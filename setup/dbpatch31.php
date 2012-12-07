
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php

require '../config.php';

if (!isset($_GET['patch']))
{

	echo '<h3>Uppgradera</h3>'."\n";
	
	echo 'Det här skriptet kommer att uppgradera databasen <b>'.$cfg['sqlite_db'].'</b>.<br/>'."\n";
	echo 'Om databasen inte stämmer måste du ändra denna i <i>config.php</i>.<br/><br/>'."\n";
	
	echo '<a href="./dbpatch31.php?patch=1">Den stämmer, uppgradera!</a>'."\n";
	
}
else
{

	// databas
	require '../internal/dbconn.php';
	$db = new DBConn("sqlite", "../".$cfg['sqlite_db']) or die("DBConn fail");
	
	// Installera tabellen
	$q = "ALTER TABLE tblPaste (
			parentHEJ TEXT
		)";
	$stmt = $db->prepare($q);
	$stmt->execute();

	echo 'Paste har nu korrekt installerats i databasen <b>'.$cfg['sqlite_db'].'</b>.<br/><br/>'."\n";

	echo '<a href="../">Till index</a>';

}

?>
</body>
</html>
