<?php

class Exercise
{
	public $id = NULL;
	public $name = NULL;
	public $mgroups = array();
	public $egroups = array();
	public $rest = NULL;
	public $reptime = NULL;
	public $rating = NULL;
	public $sets = NULL;

	function __construct($exercise, $pdo)
	{
		$this->id = $exercise["exercise_id"];
		$this->name = $exercise["name"];
		$this->reptime = $exercise["reptime"];
		$this->rating = $exercise["rating"];
		$this->pairup($pdo);
	}

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
			}
			elseif($group == "extra")
			{
				$this->egroups[] = $row["muscle_id"];
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

class Workout
{
	public $type = NULL;
	public $count = NULL;
	public $time = NULL; //start time
	public $exercises = array();
	public $maxtime = NULL;
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


?>