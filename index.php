<?php


include 'dblogin.php';
include 'classfile.php';


$newschedule = new work_schedule();
echo "GOFitYourself";

class work_schedule
{

	private $totaltime = 0;

	
	function __construct()
	{
		$exercises = array();
		/*$days = days_used($_POST["days"]);
		foreach($days as $day)
		{
			$totaltime += $day->freetime;
		}*/
	}

	function scheduler()
	{


		if (isset($_POST["strength"]))
		{
			$schedule = strength_schedule();
		}
	/*	elseif (isset($_POST["cardio"])
		{
			$schedule = cardio_schedule();
		}*/
	}

	function strength_schedule($pdo)
	{
		
		$reptime = 2;

		
		//---------------------------------------------------------------
		//$exercise_time = ($_POST["combo"][0] * $_POST["combo"][1])*$reptime + ($_POST["combo"][0] * $_POST["rest"]);

		//$work_time = (count($_POST["days"]) * $_POST["worktime"])
		//$num_exercises = $totaltime / $exercise_time;

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
		$testworkout->add_exercises(array(1,2,3), $pdo);
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
}
include 'form.html.php';
?>