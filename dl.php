<?php
	if (isset($_GET['tag']))
	{
		// Kräv config för databasen
		require './config.php';
		
		// fixa variablarna
		$tag = htmlspecialchars($_GET['tag']);
	
		// dubbelkolla att det skickade formuläret faktiskt innehöll något
		if (!empty($tag))
		{
			// Koppla upp databasen
			require './internal/dbconn.php';
			$db = new DBConn("sqlite", $cfg['sqlite_db']) or die("Could not create new instance of DBConn.");

			// Förbered data
			$sql = "SELECT tag,paste FROM tblPaste WHERE tag=:tag";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(":tag", $tag);
			$stmt->execute();
				
			// loopa resultat
			if ($stmt !== FALSE) {
				foreach ($stmt as $rad) {
					// Forcera filtyp och nedladdning
					header('Content-type: text/plain');
					header('Content-Disposition: attachment; filename="klistrain-'.$tag.'"');
					header('Content-length: '.strlen($rad['paste']));
					printf("%s", $rad['paste']);
				}
			}
		}
	}
	else {
		header("Location: ./");
		exit();
	}
?>
