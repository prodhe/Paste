<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// aktivera sessioner
	session_start();

	// Om vi har skickat formuläret för att radera och dessutom är inloggad admin
	if (isset($_GET['id']) && isset($_SESSION['adminLogin']))
	{
		// Kräv config för databasen
		require '../config.php';
		require './functions.php';
		
		// fixa variablarna
		$id = (int) $_GET['id'];
	
		// kolla att vi skickat med något ID
		if (!empty($id))
		{
			// Koppla upp databasen
			require './dbconn.php';
			$db = new DBConn("sqlite", "../".$cfg['sqlite_db']) or die("Could not create new instance of DBConn.");

			// Infoga all data
			$sql = "DELETE FROM tblPaste WHERE id=".$id."";
			$db->exec($sql);
		
			// Skicka tillbaka till start
			header("Location: ../");
			exit();
		
		}
		else
		{
			header("Location: ../");
			exit();
		}
	}
	else
	{
		echo "no admin";
		exit();
	}

?>
