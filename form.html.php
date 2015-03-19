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
		$schedule = new work_schedule(genroutine("weights", "strength", 60));
		$schedule->scheduler(); 
		$counter = 1;
		foreach ($schedule->schedule as $w) 
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
			
		/*$newschedule->getreps("endurance", $pdo);*/?>
		<br>



	</body>
</html>