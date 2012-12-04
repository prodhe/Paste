<?php

	require './config.php';
	require './functions.php';
	
	// Koppla upp databasen
	require './dbconn.php';
	$db = new DBConn("sqlite", $cfg['sqlite_db']) or die("Could not create new instance of DBConn.");

	$toptag = $db->query("SELECT tag FROM tblPaste ORDER BY tag DESC LIMIT 1");
	$toptag = $toptag->fetch();
	$tag = generate_tag($toptag[0]);
	
	echo $tag;
	
	// echo generate_tag("000000a");

?>