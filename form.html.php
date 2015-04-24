<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>gofit</title>

	</head>
	<hr>
	<body>

		<br>
		<?php 
		$schedule = genroutine("weights", "strength", 60);
		$myschedule = json_decode(generate_workouts(json_encode($schedule))); 
		$counter = 1;
		foreach ($myschedule as $w) 
			{
				echo "<b>Workout: ".$counter."</b>";
				foreach($w->exercises as $e)
				{
					echo "<br>".$e->name." ".$e->rating ." ". $e->mgroups[0];
				}
				$counter++;
				echo "<br><br>";
				//break;
			} 
		insertworkout(json_encode($myschedule[0]), 0);
			
		/*$newschedule->getreps("endurance", $pdo);*/?>
		<br>



	</body>
</html>