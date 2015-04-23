<?php

include 'dblogin.php';
include 'classfile.php';
include 'testfile.php';

echo "gofit2";


function generate_workouts($routine)
{
	return json_encode(new work_schedule($routine, $userid));
}


function getreps($exercise, $pdo)
{
	return json_encode(Exercise::reps($exercise, $pdo));
}


function getworkout($userid)
{
	return json_encode(Workout::getworkouts($userid));
}


class work_schedule
{
	public $routine;
	public $schedule = NULL;
	public $util = NULL;
	public $userid = -1;
	
	function __construct($routine)
	{
		$exercises = array();
		$schedule = array();
		$this->routine = $routine;
		$this->util = new Utilities();
		$this->userid = $routine->userid;

		//$split is an array containing indexes 0-5, corresponding to
		//legs, back, chest, arms, shoulders, abs, and contains numbers signifying
		//how much each group is to be worked out (defined by the size of the 
		//number at the corresponding index)

	}

	//calls the strength workout function with the provided information
	function scheduler()
	{
		global $pdo;

		for($i = 0; $i < count($this->routine->options); $i++)
		{
			$this->schedule[] = $this->strength_workout($this->routine, $i, $this->userid);
		}

		return json_encode($this->schedule);

	}

	//generates a strength workout based on constraints supplied in the $routine object
	private function strength_workout($routine, $number)
	{
		global $pdo;

		$currentlength = 0;
		
		$split = new SplFixedArray(8);
		$tempsplit = new SplFixedArray(8);

		$tempsplit = [0,0,0,0,0,0,0,0];
		$split = [0,0,0,0,0,0,0,0];

		$option = $routine->options[$number];

		$workout = new Workout($routine, $option->maxlength);

		for ($i = 3; $i > 0; $i--)
		{
			try
			{
				$ex_query = 'SELECT * FROM gofit2.strength_exercises WHERE priority = '.$i.' ORDER BY rating DESC';
				$ex_stmt = $pdo->query($ex_query);
				$result = $ex_stmt->setFetchMode(PDO::FETCH_ASSOC);
			}
			catch (PDOException $e)
			{
				$output = 'Error2 fetching exercises from database: '. $e->getMessage();
				include 'output.html.php';
				exit();
			}

			while ($row = $ex_stmt->fetch())
			{
				$ex = new Exercise($row, $routine->userid);
				$tempsplit = $this->util->add_merge($tempsplit, $ex->split);

				if ($this->util->check_split($option->split, $tempsplit, $i))
				{
					$split = $tempsplit;
					$workout->exercises[] = $ex;
				}
				$tempsplit = $split;
			}

			
		}
		$tempsplit = [0,0,0,0,0,0,0,0];


		return $workout;
	}
}
include 'form.html.php';
?>