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
					echo '<!DOCTYPE html>'."\n".
						 '<html><head><title></title></head><body><pre style="word-wrap: break-word; white-space: pre-wrap;">'."\n";
					echo htmlspecialchars($rad['paste']);
					echo '</pre>'."\n";
					echo '</body></html>';
				}
			}
		}
	}
	else {
		header("Location: ./");
		exit();
	}
?>
