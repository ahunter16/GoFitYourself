<?php

//Object representing an exercise in the context of a user's workout
class Exercise
{
	public $id = NULL; 			//exercise id as seen in the DB
	public $name = NULL;		//name of exercise
	public $mgroups = array();	//the main muscle group(s) the exercise focuses on
	public $egroups = array();	//the muscle groups that are used, but not targeted by the exercise
	public $reptime = NULL;		//time taken to complete a rep in seconds
	public $rating = NULL;		//user rating for an exercise
	public $priority = NULL;	//category of exercise, from important to ancillary
	public $split = NULL;
	public $userid = -1;

	function __construct($exercise, $userid)
	{
		global $pdo;
		$this->id = $exercise["exercise_id"];
		$this->name = $exercise["name"];
		$this->reptime = $exercise["reptime"];
		$this->priority = $exercise["priority"];
		$this->split = new SplFixedArray(8);
		$this->pairup($pdo);
		$this->userid = $userid;

		try
		{
			$query = 'SELECT * FROM gofit2.ratings WHERE user_id = '.$userid;
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching ratings from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}
		$row = $stmt->fetch();
		if (!empty($row))
		{
			$this->rating = $row["rating"];
		}
		else 
		{
			$this->rating = $exercise["rating"];
		}

	}

	//retrieves an array of any/all exercises which correspond to the provided id(s)
	static function get_exercise($num, $userid)
	{
		global $pdo;
		$extra = "";
		if ($num != "all" && is_int($num) == TRUE)
		{
			$extra = "WHERE ID = ".$num;
		}
			$output = 'Error fetching exercises from database: '. $e->getMessage();
		try
		{
			$ex_query = 'SELECT * FROM gofit2.strength_exercises'.$num.' ORDER BY rating DESC';
			$ex_stmt = $pdo->query($ex_query);
			$result = $ex_stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			include 'output.html.php';
			exit();
		}

		while ($row = $ex_stmt->fetch())
		{
			$ex = new Exercise($row, $userid);
			$exercises[] = $ex;
		}
		return $exercises;
	}

	//assigns the correct mgroups and egroups to the exercise
	function pairup()
	{
		//echo "BLAH".$this->id;
		global $pdo;
		try 
		{
			$query = 'SELECT * FROM gofit2.muscle_exercise_pairs WHERE exercise_id = '.$this->id;
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$output = 'Error accessing pairs from database';
			include 'output.html.php';
			exit();
		}

		while ($row = $stmt->fetch())
		{
			$group =$row["grouptype"];
			if ( $group == "main")
			{
				$this->mgroups[] = $row["muscle_id"];
				if ($row["muscle_id"] > 2)
				{
					$this->split[$row["muscle_id"]] = 4*$this->priority;
				}
				else
				{
					$this->split[$row["muscle_id"]] = 2*$this->priority;
				}
			}
			elseif($group == "extra")
			{
				$this->egroups[] = $row["muscle_id"];
				$this->split[$row["muscle_id"]] = $this->priority;
			}
		}
		for($i = 0; $i<8; $i++)
		{
			if (empty($this->split[$i]))
			{
				$this->split[$i] = 0;
			}
		}
	}

	//returns the corresponding rep/set ranges suitable for the user, as shown on: 
	//http://www.aworkoutroutine.com/how-many-sets-and-reps-per-exercise/
	static function reps($type)
	{

		global $pdo;
		try 
		{
			$query = 'SELECT * FROM gofit2.intensity WHERE FIND_IN_SET("'.$type.'", class)>0';
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$output = 'Error accessing intensity from database';
			include 'output.html.php';
			exit();
		}
		$intensity = array();
		while ($row = $stmt->fetch())
		{
			$intensity[] = $row;
		}
		if (sizeof($intensity) == 0)
		{
			echo "no intensity found";
			return;
		}

		return $intensity;

	}

	//takes the corresponding values and calculates the approximate time it will take to do the exercise
	function get_time($workout)
	{
		return (($workout->reps*$this->reptime)*$workout->sets) + ($workout->rest*($workout->sets-1));
	}
}


//represents a user's workout on a given day
class Workout
{
	public $type = NULL;			//strength, size, endurance, etc
	public $time = NULL; 			//time taken
	public $exercises = array();	//array containing all exercises in the workout 
	public $intensity = NULL;		//string representing the set/rep combination
	public $intensityid = NULL;		//int representing the id of the intensity		
	public $reps = NULL;			//number of reps per set
	public $sets = NULL; 			//number of sets
	public $rest = NULL;			//rest time
	public $userid = -1;			//id of the user
	public $order = NULL;			//the order that this workout should be done in

	function __construct($routine, $time)
	{
		$this->type = $routine->type;
		$this->time = $time;
		$this->userid = $routine->userid;
		$this->rest = $routine->rest;
		$this->intensityid = $routine->intensity;

		global $pdo;

		try
		{
			$query = 'SELECT * FROM gofit2.intensity WHERE intensity_id = '.$routine->intensity;
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching exercises from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}

		while($row = $stmt->fetch())
		{
			$this->intensity = $row["name"];
			$this->reps = intval($row["sets"]);
			$this->sets = intval($row["reps"]);
		}
		
	}

	function add_exercises($ids)
	{
		global $pdo;
		$idstring = "";
		foreach($ids as $id)
		{
			$idstring = $idstring.$id.", ";
		}

		$idstring = rtrim($idstring, ", ");

		try
		{
			$query = 'SELECT * FROM gofit2.strength_exercises WHERE exercise_id in ('.$idstring.')';
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching exercises from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}

		while($row = $stmt->fetch())
		{
			$newex = new Exercise($row, $this->userid);
			$this->exercises[] = $newex;
		}

	}


	//retrieves a users' workouts
	static function getworkouts($userid)
	{
		$workoutarray = array();
		$conter = 0;
		try
		{
			$query = 'SELECT * FROM gofit2.workouts WHERE user_id ='.$userid.' ORDER BY order DESC;';
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching exercises from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}

		while($row = $stmt->fetch())
		{
			try
			{
				$query2 = 'SELECT * FROM gofit2.workout_pairs WHERE workout_id = '.$row["workout_id"]. 'ORDER BY order DESC';
				$stmt2 = $pdo->query($query2);
				$result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				$output = 'Error fetching exercises from database: '. $e->getMessage();
				include 'output.html.php';
				exit();
			}
			$newroutine = new Routine();
			$newroutine->type = $row["type"];
			$newroutine->userid = $userid;
			$newroutine->rest = $row["rest"];
			$newroutine->intensity = $row["intensity"];
			$workoutobj = new Workout($$newroutine, $row["time"]);

			while($row2 = $stmt2->fetch())
			{
				$workoutobj->exercises[] = Exercise::get_exercise($row2["exercise_id"], $userid);
			}
			$workoutarray[] = $workoutobj;
			$counter++;
		}

		return $workoutarray;
	}

	function remove_exercise($id)
	{

		foreach($this->exercises as $ex)
		{
			if ($ex->id == $id)
			{
				unset($this->exercises[key($this->exercises)]);
				return;

			}
		}
		echo "does not exist";
	}

	//works out how many exercises of each group will be generated
	static function split_ratio($extime, $length, $groups)
	{
		return floor((60*$length/$extime)/$groups);
	}

	static function save($workoutobj, $order)
	{
		global $pdo;
		try
			{//INSERT INTO `workouts`(`order`, `time`, `intensity`, `user_id`, `type`, `rest`) VALUES (0, 2170, 6, 1, 'strength', 60)
				$query2 = 'INSERT INTO  gofit2.workouts(`order`, `time`, `intensity`, `user_id`, `type`, `rest`) VALUES ('.$order.', '. $workoutobj->time.', '. $workoutobj->intensityid.', '. $workoutobj->userid.', "'. $workoutobj->type.'", '. $workoutobj->rest.');';
				$pdo->exec($query2);
				$last_id = $pdo->lastInsertId();
	
			}
			catch (PDOException $e)
			{
				$output = 'Error inserting: '. $e->getMessage();
				include 'output.html.php';
				exit();
			}
		$counter = 0;
		$prepquery = $pdo->prepare('INSERT INTO  gofit2.workout_pairs(`workout_id`, `exercise_id`, `order`) VALUES (:workout_id, :exercise_id, :order);');
		foreach($workoutobj->exercises as $ex)
		{	
			$prepquery->bindParam(':workout_id', $last_id);
			$prepquery->bindParam(':exercise_id', $ex->id);
			$prepquery->bindParam(':order', $counter);
			$prepquery->execute();
			$counter++;
		}
	}
	
}

//object passed from the java program. Contains an "Options" object for each workout.
class Routine
{
	public $type; 				//STRING - subtype: eg strength, endurance, etc
	public $rest;				//INT - rest time between exercises in seconds
	public $options = array();	//ARRAY OF OPTIONS OBJECTS, LENGTH DEPENDS ON NUMBER OF WORKOUTS - array to contain Options objects
	public $intensity;			//INT - the id of the intensity to be used(see database table "intensity")
	public $userid;				//INT - the id of the user in the database
	public $equipment; 			//INT - should reflect how much equipment the user is able to use 
								//1 = none or free weights, 2 = basic equipment like a bench
								//3 = specialist equipment like cable machines or smith machines that you only 
								//really find in gyms
}

//information about a given workout; the split 
class Options
{
	public $split;		//ARRAY OF INTs, FIXED LENGTH OF 8 - attention to be paid to given muscle group
	public $time;		//INT - length of given workout in seconds
	public $maxtime;	//INT - the length of time that this workout should not exceed in seconds
	public $order;
	function __construct()
	{
		$this->split = new SplFixedArray(8);
	}						

}

//extra functions used in the business logic. Mostly for checking 
//exercises to be added to a workout
class Utilities
{
	//adds up the values of 2 arrays
	public static function add_merge($split1, $split2)
	{
		if (count($split1) > count($split2))
		{
			$a = $split1;
			$split1 = $split2;
			$split2 = $a;
		}

		$array = array();
		for ($i = 0; $i < count($split1); $i++)
		{
			$array[] = $split1[$i]+$split2[$i];
		}

		return $array;
	}

	//checks an array against another to make sure no value exceeds
	//any corresponding value in the latter array
	function check_split($max, $current, $points)
	{
		if (count($max) < 8)
		{
			return FALSE;
		}

		for ($i = 0; $i < count($current); $i++)
		{
			if ($max[$i] - $current[$i] <= $points)
			{	
				if ($current[$i] > $max[$i])
				{
					return FALSE;
				}
			}
		}

		return TRUE;
	}


}

?>