<?php
	session_start();
	$dbUrl = getenv('DATABASE_URL');
	$dbOpts = parse_url($dbUrl);

	$dbHost = $dbOpts["host"];
	$dbPort = $dbOpts["port"];
	$dbUser = $dbOpts["user"];
	$dbPass = $dbOpts["pass"];
	$dbName = ltrim($dbOpts["path"], '/');

	$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>