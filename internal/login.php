<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// Om vi har skickat formuläret för visning av alla poster i databasen
	if (isset($_POST['passwordForAdmin']))
	{
		// kräv config för rätt lösenord
		require '../config.php';
		
		// aktivera sessioner
		session_start();
		
		$password = trim($_POST['passwordForAdmin']);
		
		if ($password==$cfg['adminPassword'])
			$_SESSION['adminLogin']=1;
		
		header("Location: ../?admin");
		exit();
	}
	else
	{
		header("Location: ./");
		exit();
	}

?>
