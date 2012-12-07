<?php

	/*
		SKRIVET AV PETTER RODHELIND
	*/

	// Om vi har skickat formuläret för att lägga till ett urklipp, annars bara avbryter vi och skickar tillbaka
	if (isset($_POST['spara_urklipp']))
	{
		// Kräv config för databasen och functions för tag-generator
		require '../config.php';
		require './functions.php';
		
		// fixa variablarna
		$time = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$parent = $_POST['parent'];
		$paste = $_POST['paste'];
	
		// dubbelkolla att det skickade formuläret faktiskt innehöll något
		if (!empty($paste))
		{
			// Koppla upp databasen
			require './dbconn.php';
			$db = new DBConn("sqlite", "../".$cfg['sqlite_db']) or die("Could not create new instance of DBConn.");

			// få nuvarande högsta tagg och plusa på en
			$toptag = $db->query("SELECT tag FROM tblPaste ORDER BY tag DESC LIMIT 1");
			$toptag = $toptag->fetch();
			$tag = generate_tag($toptag[0]);

			// Förbered data
			$sql = "INSERT INTO tblPaste (time, ip, tag, parent, paste) VALUES (:time, :ip, :tag, :parent, :paste)";
			$stmt = $db->prepare($sql);
			$userdata = array(":time" => $time, ":ip" => $ip, ":tag" => $tag, ":parent" => $parent, ":paste" => $paste);

			// Infoga all data
			$stmt->execute($userdata);
		
			// Skicka till det nya urklippet
			header("Location: ../?".$tag);
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
		header("Location: ../");
		exit();
	}

?>
