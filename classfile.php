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
	public $sets = NULL;		//number of sets the user is to do
	public $priority = NULL;	//category of exercise, from important to ancillary
	public $split = NULL;

	function __construct($exercise, $pdo)
	{
		$this->id = $exercise["exercise_id"];
		$this->name = $exercise["name"];
		$this->reptime = $exercise["reptime"];
		$this->rating = $exercise["rating"];
		$this->priority = $exercise["priority"];
		$this->split = new SplFixedArray(8);
		$this->pairup($pdo);
	}

	//retrieves an array of any/all exercises which correspond to the provided id(s)
	static function get_exercise($num)
	{
		global $pdo;
		$extra = "";
		if ($num != "all" && is_int($num) == TRUE)
		{
			$extra = "WHERE ID = ".$num;
		}
		try
		{
			$ex_query = 'SELECT * FROM gofit2.strength_exercises'.$num.' ORDER BY rating DESC';
			$ex_stmt = $pdo->query($ex_query);
			$result = $ex_stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching exercises from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}

		while ($row = $ex_stmt->fetch())
		{
			$ex = new Exercise($row);
			$exercises[] = $ex;
		}
		return $exercises;
	}

	//assigns the correct mgroups and egroups to the exercise
	function pairup($pdo)
	{
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
				$this->split[$row["muscle_id"]] = 2*$this->priority;
			}
			elseif($group == "extra")
			{
				$this->egroups[] = $row["muscle_id"];
				$this->split[$row["muscle_id"]] = $this->priority;
			}
		}
		for($i = 0; $i<8; $i++)
		{
			if (!isset($this->split[$i]))
			{
				$this->split[$i] = 0;
			}
		}
	}

	//returns the corresponding rep/set ranges suitable for the user, as shown on: 
	//http://www.aworkoutroutine.com/how-many-sets-and-reps-per-exercise/
	static function reps($type, $pdo)
	{
		//could use "global $pdo;" instead of using it as argument every time, but this might be a security issue.
		try 
		{
			$query = 'SELECT * FROM gofit2.intensity WHERE FIND_IN_SET("'.$type.'", class)>0';
			$stmt = $pdo->query($query);
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$output = 'Error accessing intensities from database';
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
			echo "no intensities found";
			return;
		}

		
		return $intensity;

	}
	//takes the corresponding values and calculates the approximate time it will take to do the exercise
	function get_time($rest, $reps, $reptime, $sets)
	{
		return (($reps*$reptime)*$sets) + ($rest*($sets-1));
	}


}

//not likely to be used
class Day
{
	public $name = NULL;
	public $freetime =NULL;	
	public $dayno = NULL;
	function __construct($name)
	{
		switch($name)
		{
			case "Mon":
				$this->dayno = 0;			
			case "Tue":
				$this->dayno = 1;
			case "Wed":
				$this->dayno = 2;
			case "Thu":
				$this->dayno = 3;
			case "Fri":
				$this->dayno = 4;
			case "Sat":
				$this->dayno = 5;
			case "Sun":
				$this->dayno = 6;

		}
	}


}

//represents a user's workout on a given day
class Workout
{
	public $type = NULL;			//strength, size, endurance, etc
	public $count = NULL;			//number of exercises (may delete)
	public $time = NULL; 			//start time or time taken
	public $exercises = array();	//array containing all exercises in the workout
	public $maxtime = NULL;			//max amount of time allowed for the workout 
	public $dayname = NULL;

	function __construct($type, $maxtime)
	{
		$this->type = $type;
		$this->maxtime = $maxtime;
	}

	function add_exercises($ids, $pdo)
	{
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
			$newex = new Exercise($row, $pdo);
			//echo $row['exercise_id']." ".$row['name'];
			$this->exercises[] = $newex;
		}

	}

	function remove_exercise($id)
	{
		//echo $this->exercises[1]->id;
		foreach($this->exercises as $ex)
		{
			if ($ex->id == $id)
			{
				echo "id: ".$id;
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
	
}

class Schedule
{
	public $name = NULL;
	public $workouts = array();

	function __construct($name)
	{
		$this->name = $name;

	}

	function days()
	{
		$days = array();
		foreach($this->workouts as $w)
		{
			$days[] = $w->dayname;
		}
	}
}

class Routine
{
	public $type; 		//type of workout: cardio or weights
	public $subtype; 	//subtype: eg strength, endurance, etc
	public $rest;		//rest time between exercises in seconds
	public $options =array();
}

class Option
{
	public $split = array();	//attention to be paid to given muscle group
	public $length;				//length of given workout
	public $maxlength;
}

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
/*		echo "max:[";
		foreach ($max as $a)
		{
			echo $a . ", ";
		}
		echo "] ";
		echo "current:[";
		foreach ($current as $a)
		{
			echo $a . ", ";
		}
		echo "] ";
		echo "points:" .$points." ";*/


		for ($i = 0; $i < count($current); $i++)
		{
			if ($max[$i] - $current[$i] <= $points)
			{	
				//echo $i;
				if ($current[$i] > $max[$i])
				{
					//echo " FALSE" . $max[$i]. " ".$current[$i]."<br>";
					return FALSE;
				}
			}

		}
		//echo " TRUE <br>";
		return TRUE;
	}


}

?>