<?php


include 'dblogin.php';
include 'classfile.php';

$splitrat = array("chest", "shoulders", "arms", "back", "legs", "abs");

$newschedule = new work_schedule($splitrat);
echo "GOFitYourself";

class work_schedule
{

	private $totaltime = 0;

	
	function __construct($split)
	{
		$exercises = array();
		$schedule = array();
		$splitratio = $split;
		/*$days = days_used($_POST["days"]);
		foreach($days as $day)
		{
			$totaltime += $day->freetime;
		}*/
	}

	function scheduler()
	{
		global $pdo;
		$length = 60;
		$split = "full";//shoult either say full or link to DB split
		$weights = 1;
		$rest = 60;



		
		if (/*$_POST["type"] == "weights" ||*/ isset($weights))
		{
			for ($i = 0; $i < $weights; $i++)
			{
				$schedule[] = $this->strength_workout($pdo, $length, $split, $rest);
			}//number of w/o, length of w/o, type, goal, split(array),rest
		}
		return $schedule;
/*		elseif ($_POST["type"] == "cardio")
		{
			$schedule = cardio_schedule();
		}*/
	}

	function strength_workout($pdo, $length, $split, $rest)
	{
		
		$reptime = 3;

		$currentlength = 0;
		

		//--------------------TEST CODE------------------------

		

		try
		{
			$ex_query = 'SELECT * FROM gofit2.strength_exercises ORDER BY rating DESC';
			$pair_query = 'SELECT * FROM gofit2.muscle_exercise_pairs ORDER BY grouptype, muscle_id';
			$pair_stmt = $pdo->query($pair_query);
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
			$ex = new Exercise($row, $pdo);
			//echo $ex->name;
			$exercises[] = $ex;

		}

/*----------------test code-------------------------------*/
		$testworkout = new Workout("weights", 1);
		//$testworkout->pair_exercises($pdo);
		while ($currentlength < $length)
		{
			$testworkout->add_exercises(array(1,2,3), $pdo);//write function that takes an array of exercises and removes them as they're added
			$currentlength += $ex->get_time(60, 5, 3, 5);
		}
		
		$testworkout->remove_exercise(3);
		//echo $testworkout->exercises;
		$coveredgroups = array();
		while ($row = $pair_stmt->fetch())
		{
			$check = array_search($row["muscle_id"], $coveredgroups);
			if ($check == FALSE)
			{

			}
			//echo $row["grouptype"]." ".$row["muscle_id"]."<br>";

		}




		return $exercises;
	}

	function days_used($days)
	{

		$indexes = array_fill(0, 7, 0);
		$returndays = array();

		$workouts = 0;
		foreach ($days as $d)
		{
			$indexes[$d->dayno] = 1;
			$workouts ++;
		}

		//----------------------------------------------------------------
		//need to determine how we're calculating the days
		// add days to array in ascending order of freetime; use
		//$returndays[] = , and array_unshift($returnvalues, $daywithlessfreetime)
		return $returndays;


	}

	function getreps($exercise, $pdo)
	{
		Exercise::reps($exercise, $pdo);
	}
}
include 'form.html.php';
?>