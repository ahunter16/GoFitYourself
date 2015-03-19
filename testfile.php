<?php
function genroutine($type, $subtype, $rest)
{
	$routine = new Routine();
	$routine->type = $type;
	$routine->subtype = $subtype;
	$routine->rest = $rest;


	for ($i = 0; $i < 3; $i++)
	{
		$option = new Option();
		$option->split = [1,8,8,8,8,8,8,8];
		$option->length = 40;
		$routine->options[] = $option;

	}
	return $routine;
}


?>