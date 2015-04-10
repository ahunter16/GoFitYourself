<?php 

try
{
	
	$pdo = new PDO('mysql:host=db4free.net;dbname = gofityourself', 'gofityourself', 'CS3024Bravo15Fit');
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo -> exec('SET NAMES "utf8"');

}

catch (PDOException $e)
{
	$output = 'Unable to connect to the database server:' . 
	$e -> getMessage();
	include 'output.html.php';
	exit();
}

?>