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
		$option->maxlength = 60;
		$routine->intensity = 6;
		$routine->type = "strength";
		$routine->options[] = $option;
		$routine->userid = 0;

	}
	$routine->options[0]->split = [6,6,6,6,6,6,6,6];
	$routine->options[1]->split = [6,0,0,0,0,0,0,6];
	$routine->options[2]->split = [0,0,6,0,6,6,0,6];
	$routine->options[3]->split = [0,6,0,6,0,0,6,6];
	return new work_schedule($routine);
}


?>