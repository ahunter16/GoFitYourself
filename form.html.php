<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "utf-8">
		<title>gofit</title>

	</head>
	<hr>
	<body>

		<br>
		result: <?php $exercises = $newschedule->strength_schedule($pdo); foreach ($exercises as $e) {echo "<br>".$e->name." ".$e->rating ." ". $e->mgroups[0];}?>
		<br>



	</body>
</html>