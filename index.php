<?php
	/*
		SKRIVET AV PETTER RODHELIND
	*/
	
	// version :)
	DEFINE("VERSION","3.0");

	// Kräv config, lite blandade funktioner samt databasen
	require './config.php';
	require './internal/functions.php';
	require './internal/dbconn.php';

	// aktivera sessioner
	session_start();

	// Hämta nycklarna i $_GET
	$url = array_keys($_GET);

?><!DOCTYPE html>
<html>
<head>
	<!--
	
		Paste v<?=VERSION?>
		
		Senast uppdaterad 2012-12-02
		
		Skriven av Petter Rodhelind	
	
	//-->
	<title>Klistra.in</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		// mest showoff för att visa hur sidan ser ut utan CSS ;)
		if (!in_array("nocss", $url))
			echo '<link rel="stylesheet" href="./styles/default.css" type="text/css" />'."\n";
	?>
	<script type="text/javascript" src="./internal/script.js"></script>
</head>
<body>

<?php if (!in_array("nocss", $url)) { ?><div id="reader"><div id="readerContent"></div></div><div id="popup"></div><?php } ?>

<div id="world">

<div id="header">
	<a href="./"><h1><span>Klistra.in</span></h1></a>
</div>

<hr />

<div id="content">

<?php

	// Om vi vill logga in och ut
	if (in_array("admin",$url))
	{
		// include './internal/inc_admin.php';

		// visa in- eller utloggning
		if (!isset($_SESSION['adminLogin']))
		{
			echo '<form method="post" action="./internal/login.php">'."\n";
			echo '<fieldset><legend>Logga in för administration</legend>'."\n";
			echo '<label for="password">Lösenord:</label><input type="password" name="passwordForAdmin" id="password" />'."\n";
			echo '</fieldset>'."\n";
			echo '</form>'."\n";
		}
		else
		{
			echo '<p><a href="./internal/logout.php?admin"><b>Logga ut</b></a></p>'."\n";
		}
	}
	
	// Om vi vill lägga till en (blank url)
	else if (empty($url) || $url[0]=="" || $url[0]=="nocss" || $url[0]=="edit")
	{
		// koppla upp databasen
		$db = new DBConn("sqlite",$cfg['sqlite_db']) or die("DBConn fail");
		
		// formulär för nytt inlägg
		echo'<form method="post" action="add.php">'."\n";
			echo '<fieldset id="newPaste"><legend>Skapa nytt</legend>'."\n";
			echo '<textarea cols="100" rows="25" name="paste" id="paste">'; 
			if (isset($_GET['edit'])) {
				$tag = htmlspecialchars($_GET['edit']);
				$count = $db->query("SELECT COUNT(*) from tblPaste WHERE tag=\"".$tag."\"")->fetchColumn();
				$res = $db->query("SELECT tag, paste FROM tblPaste WHERE tag=\"".$tag."\"")->fetch();
				echo htmlspecialchars($res['paste']);
			}
			echo '</textarea><br /><br />'."\n";
			echo '<input type="submit" name="spara_urklipp" value="Spara" onclick="return checkForEmpty(\'paste\');" />'."\n";
			echo '</fieldset>'."\n";
		echo'</form>'."\n";
		
		echo '<br />'."\n";
		
		// lista tidigare
		echo '<fieldset id="oldPastes"><legend>Lagrade</legend>'."\n";
		
			echo '<table cellpadding="2" cellspacing="1" class="lista">'."\n";
			echo '<tr>';
			if (isset($_SESSION['adminLogin']))	{
				echo '<th width="30">&nbsp;</th>';
			}
			echo '<th width="200">Datum</th>'.
				 '<th>Utdrag</th>';
			if (isset($_SESSION['adminLogin']))	{
				echo '<th width="250">IP-adress</th>'.
					 '<th></th>';
			}
			echo '</tr>'."\n";

			// för alternerande färg på raderna
			$i=0;

			// Hämta all data
			foreach ($db->query("SELECT id, ip, time, tag, paste FROM tblPaste ORDER BY time DESC") as $rad) {
				
				$utdrag = "";
				
				if (strlen($rad['paste']) > 200) {
					$utdrag = substr(htmlspecialchars($rad['paste']), 0, 195) . ' >>>';
				} else {
					$utdrag = htmlspecialchars($rad['paste']);
				}

				$stil = ($i%2==0) ? "lista_falt1" : "lista_falt2";
				echo '<tr>';
				if (isset($_SESSION['adminLogin']))	{
					echo '<td class="'.$stil.'" align="right"><a href="./?'.$rad['tag'].'"><b>'.$rad['tag'].'</b></a></td>';
				}
				echo '<td class="'.$stil.'" align="left"><a href="./?'.$rad['tag'].'">'.datum($rad['time']).'</a></td>'.
					 '<td class="'.$stil.'" id="utdrag-'.$rad['id'].'"><a href="./?'.$rad['tag'].'">'.$utdrag.'</a></td>';
				
				// Om inloggad som admin
				if (isset($_SESSION['adminLogin']))	{
					echo '<td class="'.$stil.'" align="center">'.$rad['ip'].'<br />('.gethostbyaddr($rad['ip']).')</td>'.
						 '<td class="'.$stil.'"><a href="./internal/delete.php?id='.$rad['id'].'" onmouseover="document.getElementById(\'utdrag-'.$rad['id'].'\').style.textDecoration = \'line-through\';" onmouseout="document.getElementById(\'utdrag-'.$rad['id'].'\').style.textDecoration = \'none\';" onclick="return confirm(\'Raderar: '.$rad['tag'].'\n\nÄr du säker?\');"><img src="./images/icon_delete.gif" alt="Radera" /></a>'."\n";
				}
						
				echo '</td>'.'</tr>'."\n";
				
				// snurra vidare i alternering av färger
				$i++;
			}
			// else
			// {
			// 	echo '<tr><td class="lista_falt1">Inga urklipp är lagrade i databasen.</td></tr>'."\n";
			// }

			echo '</table>'."\n";
		echo '</fieldset>'."\n";
	}
	
	// Kvar finns nu bara ?mumbojumbo och då utgår vi från att det är en post i databasen
	else
	{
		include './internal/inc_showtag.php';
	}

?>

</div>

<hr />

<div id="footer">
	<address id="copyright">
		Klistra.in är skapat av Petter Rodhelind och tillhandahålls fritt och utan garantier, 2010 - 2012
	</address>
</div>

</div>

</body>
</html>

