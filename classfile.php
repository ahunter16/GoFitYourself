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

	function __construct($exercise)
	{
		$this->id = $exercise["exercise_id"];
		$this->name = $exercise["name"];
		$this->reptime = $exercise["reptime"];
		$this->rating = $exercise["rating"];
	}

	static function get_exercises()
	{
		try
		{
			$ex_query = 'SELECT * FROM gofit2.strength_exercises ORDER BY rating DESC';
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
			$newex = new Exercise($row);
			//echo $row['exercise_id']." ".$row['name'];
			$this->exercises[] = $newex;
		}

	}

	function remove_exercise($id)
	{
		while ($ex = current($this->exercises))
		{
			if ($ex["exercise_id"] == $id)
			{
				unset($this->exercises[key($this->exercises)]);
			}
		}
	}

	//takes all exercises stored and gives each exercise its corresponding muscle groups
/*	function pair_exercises($pdo)
	{
		$string = NULL;
		foreach ($this->exercises as $e)
		{
			$string = $string . $e["id"] . ", ";
		}
		$string = rtrim($string, ", ");
		echo $string;
		try
		{
			$pair_query = 'SELECT *, gofit2.muscle_groups.name FROM gofit2.muscle_exercise_pairs WHERE exercise_id in ('.$string.') 
			LEFT JOIN muscle_groups ON muscle_exercise_pairs.muscle_id=muscle_groups.muscle_id';
			$pair_stmt = $pdo->query($pair_query);
			$result = $pair_stmt->setFetchMode(PDO::FETCH_ASSOC);
		}
		catch (PDOException $e)
		{
			$output = 'Error fetching exercises from database: '. $e->getMessage();
			include 'output.html.php';
			exit();
		}

		while ($row = $pair_stmt->fetch())
		{
			echo $row;
			foreach($this->exercises as $e)
			{
				if ($e["id"] == $row["exercise_id"])
				{
					if($row["grouptype"] == "main")
					{
						$e->mgroups[] = $row["name"]; 
					}
					elseif($row["grouptype"] == "extra")
					{
						$e->egroups[] = $row["name"];
					}
					break;
				}
			}
		}
	}*/

	
}

class Schedule
{
	public $name = NULL;
	public $workouts = array();

	function __construct($name)
	{
		$this->name = $name;

	}
}


?>