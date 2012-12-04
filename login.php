<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// Om vi har skickat formuläret för visning av alla poster i databasen
	if (isset($_POST['passwordForAdmin']))
	{
		// kräv config för rätt lösenord
		require './config.php';
		
		// aktivera sessioner
		session_start();
		
		$password = trim($_POST['passwordForAdmin']);
		
		if ($password==$cfg['adminPassword'])
			$_SESSION['adminLogin']=1;
		
		header("Location: ./?admin");
		exit();
	}
	// annars om vi vill visa en särskild post
	// elseif (isset($_POST['passwordForTag']))
	// {
	// 	// kräv konfiguration och databasfiler
	// 	require './config.php';
	// 	require './functions.php';
	// 	require './sqlconnection.php';
	// 	
	// 	// databas
	// 	$db = new SQLConnection($cfg['mysql_host'], $cfg['mysql_usr'], $cfg['mysql_pwd'], $cfg['mysql_db']) or die("SQLConnection fail");
	// 	$db->init();
	// 	$db->query("SELECT password FROM tblPaste WHERE tag=\"". mysql_real_escape_string($_POST['tag']) ."\"");
	// 
	// 	// om taggen fanns i databasen
	// 	if ($db->getNumRows() > 0) {
	// 		$rad = $db->fetch("assoc");
	// 		
	// 		// trixa till inskickat lösenord och se om det matchar det hashade i databasen
	// 		$password = secure_hash($_POST['passwordForTag'], $_POST['tag']);
	// 		
	// 		if ($password == $rad['password']) {
	// 			// aktivera sessioner och spara inloggningen
	// 			session_start();
	// 			$_SESSION['tagLogin'][$_POST['tag']]=1;
	// 		}
	// 		
	// 	}
	// 	
	// 	header("Location: ./?".$_POST['tag']."");
	// 	exit();
	// }
	else
	{
		header("Location: ./");
		exit();
	}

?>