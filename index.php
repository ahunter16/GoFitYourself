<?php


include 'dblogin.php';
include 'classfile.php';
include 'testfile.php';



echo "gofityourself";

class work_schedule
{

	private $totaltime = 0;
	public $routine;
	public $schedule = NULL;
	public $util = NULL;

	
	function __construct($routine)
	{
		$exercises = array();
		$schedule = array();
		$this->routine = $routine;
		$this->util = new Utilities();
		//$split is an array containing indexes 0-5, corresponding to
		//legs, back, chest, arms, shoulders, abs, and contains numbers signifying
		//how much each group is to be worked out (defined by the )

	}
	//calls the strength workout function with the provided information
	function scheduler()
	{
		global $pdo;

		
		if ($this->routine->type == "weights")
		{
			foreach($this->routine->options as $w)
			{
				$this->schedule[] = $this->strength_workout($pdo, $w, $this->routine->rest);
			}
		}

		return $this->schedule;
		//return json_encode($schedule)

	}


	function strength_workout($pdo, $option, $rest)
	{
		
		$reptime = 3;

		$currentlength = 0;
		
		$split = new SplFixedArray(8);

		$tempsplit = new SplFixedArray(8);
		$tempsplit = [0,0,0,0,0,0,0,0];
		$split = [0,0,0,0,0,0,0,0];

		//--------------------TEST CODE------------------------

		$workout = new Workout("weights", 60, "5x5");

		for ($i = 3; $i > 0; $i--)
		{
			try
			{
				$ex_query = 'SELECT * FROM gofityourself.strength_exercises WHERE priority = '.$i.' ORDER BY rating DESC';
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
				$ex = new Exercise($row, $pdo);
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