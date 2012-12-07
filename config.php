<?php

	/*
		CONFIG för Paste
	*/
	
		
	// Uppgifter för SQLite-databasen (absolute path)
	$cfg['sqlite_db'] = "./db/paste.sqlite";
		
	// Den fulla adressen till baskatalogen för Paste
	// Anges utan det sista snedstrecket
	// Ex: $cfg_full_url = "http://www.doman.se/paste";
	$cfg['full_url'] = "http://klistra.in";
	
	// Lösenord för administration
	$cfg['adminPassword'] = "gotroot@paste";
	
	// Default timezone
	date_default_timezone_set('Europe/Stockholm');

?>
