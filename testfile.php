<?php
function genroutine($type, $subtype, $rest)
{
	$routine = new Routine();
	$routine->type = $type;
	$routine->subtype = $subtype;
	$routine->rest = $rest;


	for ($i = 0; $i < 4; $i++)
	{
		$option = new Option();
		$option->length = 60;
		$routine->options[] = $option;

	}
	$routine->options[0]->split = [6,6,6,6,6,6,6,6];
	$routine->options[1]->split = [6,0,0,0,0,0,0,6];
	$routine->options[2]->split = [0,0,6,0,6,6,0,6];
	$routine->options[3]->split = [0,6,0,6,0,0,6,6];
	return $routine;
}


?>