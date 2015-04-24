<?php
function genroutine($type, $subtype, $rest)
{
	$routine = new Routine();
	$routine->type = $type;
	$routine->subtype = $subtype;
	$routine->rest = $rest;


	for ($i = 0; $i < 4; $i++)
	{
		$option = new Options();
		$option->maxtime = 3600;
		$routine->intensity = 6;
		$routine->type = "strength";
		$routine->options[] = $option;
		$routine->userid = 1;
		$routine->equipment = 2;

	}
	$routine->options[0]->split = [7,7,7,7,7,7,7,7];
	$routine->options[1]->split = [20,0,0,0,0,0,0,20];
	$routine->options[2]->split = [0,0,20,0,20,20,0,20];
	$routine->options[3]->split = [0,20,0,20,0,0,20,20];
	return $routine;
}


?>