<?php

	/*
		CONFIG för Paste
	*/
	
	// // Uppgifter för MySQL-databasen
	// $cfg['mysql_host'] = "";		// värd
	// $cfg['mysql_db'] = "";			// databas
	// $cfg['mysql_usr'] = "";			// användare
	// $cfg['mysql_pwd'] = "";			// lösenord
		
	// Uppgifter för SQLite-databasen
	$cfg['sqlite_db'] = "./db/paste.sqlite";
		
	// Den fulla adressen till baskatalogen för Paste
	// Anges utan det sista snedstrecket
	// Ex: $cfg_full_url = "http://www.doman.se/paste";
	$cfg['full_url'] = "http://klistra.in";
	
	// Lösenord för administration
	$cfg['adminPassword'] = "gotroot@klistra.in";
	
	// Default tidszon
	date_default_timezone_set('Europe/Stockholm');

?>