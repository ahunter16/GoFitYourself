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
		$option->length = 40;
		$routine->options[] = $option;

	}
	$routine->options[0]->split = [8,8,8,8,8,8,8,8];
	$routine->options[1]->split = [8,0,0,0,0,0,0,8];
	$routine->options[2]->split = [0,0,8,0,8,8,0,8];
	$routine->options[3]->split = [0,8,0,8,0,0,8,8];
	return $routine;
}


?>