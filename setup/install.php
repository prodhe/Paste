<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php

require './config.php';

if (!isset($_GET['install']))
{

	echo '<h3>Installera</h3>'."\n";
	
	echo 'Det här skriptet kommer att installera tabellen <b>tblPaste</b> i databasen <b>'.$cfg['sqlite_db'].'</b>.<br/>'."\n";
	echo 'Om databasen inte stämmer måste du ändra denna i <i>config.php</i>.<br/><br/>'."\n";
	
	echo '<a href="./install.php?install=1">Den stämmer, installera!</a>'."\n";
	
}
else
{

	// databas
	require './dbconn.php';
	$db = new DBConn("sqlite", $cfg['sqlite_db']) or die("DBConn fail");
	
	// Installera tabellen
	$q = "CREATE TABLE IF NOT EXISTS tblPaste (
			id INTEGER PRIMARY KEY,
			time INTEGER,
			ip TEXT,
			tag TEXT,
			paste TEXT
		)";
	$stmt = $db->prepare($q);
	$stmt->execute();

	// Lägg till en förstapost
	$sql = "INSERT INTO tblPaste (time, ip, tag, paste) VALUES (:time, :ip, :tag, :paste)";
	$stmt = $db->prepare($sql);
	$userdata = array(":time" => time(), ":ip" => $_SERVER['REMOTE_ADDR'], ":tag" => "0000", ":paste" => "Hello world!");
	$stmt->execute($userdata);

	echo 'Paste har nu korrekt installerats i databasen <b>'.$cfg['sqlite_db'].'</b>.<br/><br/>'."\n";

	echo '<a href="./">Till index</a>';

}

?>
</body>
</html>