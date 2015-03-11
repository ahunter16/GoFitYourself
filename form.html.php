<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>gofit</title>

	</head>
	<hr>
	<body>

		<br>
		result: <?php 
		$exercises = $newschedule->scheduler(); 
		foreach ($exercises[0] as $e) 
			{
				echo "<br>".$e->name." ".$e->rating ." ". $e->mgroups[0];
			} 
			echo "<br>";
		$newschedule->getreps("endurance", $pdo);?>
		<br>



	</body>
</html>