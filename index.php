<?php

include 'dblogin.php';
include 'classfile.php';
include 'testfile.php';

echo "gofit2";

//generates workouts based on information provided by a routine
function generate_workouts($routine)
{
	$myschedule = new work_schedule(json_decode($routine));
	return json_encode($myschedule->scheduler());
}

//gets the set/rep ranges suitable for this type of exercise. you may need to remove the decode statement
function getreps($type)
{
	global $pdo;
	return json_encode(Exercise::reps(json_decode($type), $pdo));
}

//returns all workouts associated with a user. you may need to remove the decode statement
function getworkouts($userid)
{
	return json_encode(Workout::getworkouts(json_decode($userid)));
}

//inserts a given workout into the database. This includes storing
//information about the workout itself, as well as making record of all exercises associated with it
//you must pass a json encoded workout object as well as a number represending the order this workout should come
//in the users' weekly schedule.
function insertworkout($workout, $order)
{
	$savedworkout = json_decode($workout);
	Workout::save($savedworkout, $order);
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

		//$split is an array containing indexes 0-7, corresponding to
		//legs, back, chest, biceps, triceps, shoulders, forearms, and abs, and contains numbers signifying
		//how much each group is to be worked out (defined by the size of the 
		//number at the corresponding index)

	}

	//calls the strength workout function with the provided information
	function scheduler()
	{
		global $pdo;

		for($i = 0; $i < count($this->routine->options); $i++)
		{
			$this->schedule[] = $this->strength_workout($this->routine, $i);
		}

		return $this->schedule;

	}

	//generates a strength workout based on constraints supplied in the $routine object
	private function strength_workout($routine, $number)
	{
		global $pdo;

		$currentlength = 0;
		
		$split = new SplFixedArray(8);
		$tempsplit = new SplFixedArray(8);

		$tempsplit 	=	[0,0,0,0,0,0,0,0];
		$split 		= 	[0,0,0,0,0,0,0,0];
		$filter 	=	[4,4,4,1,2,2,2,3];

		$option = $routine->options[$number];

		$workout = new Workout($routine, 0);

		for ($i = 3; $i > 0; $i--)
		{
			try
			{
				$ex_query = 'SELECT * FROM gofit2.strength_exercises WHERE priority = '.$i.' AND equipment < '.(intval($routine->equipment)+2).' ORDER BY rating DESC';
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
				$extime = $ex->get_time($workout);

				if ($this->util->check_split($option->split, $tempsplit, $i) && ($extime + $workout->time) < $option->maxtime)
				{

					$approved = 1;
					foreach($ex->mgroups as $mg)
					{
						if ($filter[$mg] < $i)
						{
							$approved = 0;
						}
					}

					if($approved == 1)
					{
						foreach($ex->mgroups as $mg)
						{	
							$filter[$mg] = $filter[$mg]-1;
						}
						$split = $tempsplit;
						$workout->exercises[] = $ex;
						$workout->time += $extime;
					}

				}
				$tempsplit = $split;
			}

			
		}
		$tempsplit = [0,0,0,0,0,0,0,0];
		$workout->order = $option->order;
		return $workout;
	}
}
include 'form.html.php';
?>