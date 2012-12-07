<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// aktivera sessioner
	session_start();

	// fippla fram alla värden i URL:n
	$url = array_keys($_GET);
	
	// om vi har valt admin
	if (in_array("admin",$url))
	{		
		unset($_SESSION['adminLogin']);
		
		header("Location: ../?admin");
		exit();
	}
	else
	{
		header("Location: ../");
		exit();
	}

?>
