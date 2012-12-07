<?php

// Koppla upp databasen
$db = new DBConn("sqlite",$cfg['sqlite_db']) or die("DBConn fail");

// Hämta all data
$count = $db->query("SELECT COUNT(*) from tblPaste WHERE tag=\"".htmlspecialchars($url[0])."\"")->fetchColumn();
$res = $db->query("SELECT id, time, tag, parent, paste FROM tblPaste WHERE tag=\"".htmlspecialchars($url[0])."\"");

// Visa posten, om kommandot fungerade och den faktiskt hittade något
if ($res !== FALSE && $count > 0)
{
	foreach ($res as $rad)
	{
		// räkna antalet rader
		$numberOfRows = count(explode("\n",$rad['paste']));
		
		// snabblänk
		echo '<fieldset id="fullurl"><legend><a href="./?'.$rad['tag'].'">'.$cfg['full_url'].'/?<b>'.$rad['tag'].'</b></a></legend>'."\n";
		echo '<div id="pasteInfo">'."\n";
		echo '<b>'.datum($rad['time']).'</b>, '."\n";
		echo strlen($rad['paste']).' tecken på '.$numberOfRows.' rader';
		if (!empty($rad['parent'])) {
			echo ', förälder: <a href="./?'.$rad['parent'].'"><b>'.$rad['parent'].'</b></a>'."\n";
		}
		echo '</div>';
		
		echo '<ul id="pasteLinks">'."\n";
		echo '<li><a href="./raw.php?tag='.$rad['tag'].'">Länk till rådata</a></li>'."\n";
		echo '<li><a href="#" onclick="showreader(true);">Visa läsare</a></li>'."\n";
		echo '<li><a href="./dl.php?tag='.$rad['tag'].'">Ladda hem som fil</a></li>'."\n";
		echo '<li><a href="./?edit='.$rad['tag'].'">Redigera som ny</a></li>'."\n";
		echo '</ul>'."\n";

		echo '<hr />'."\n";		
		echo '<br />'."\n";

		// skriv ut en tabell med en kolumn radnummer och en kolumn inklistrad text
		echo '<table cellpadding="2" cellspacing="0">'."\n";
		echo '<tr>'."\n";
		echo '<td class="codeLineNumber"><pre>';
			for ($i=0; $i <= $numberOfRows-1; $i++)
			{
				echo '&nbsp;'.($i+1).'&nbsp;'."\n";
			}
		echo '</pre></td>'."\n";
		echo '<td class="code">'."\n";			
			echo '<pre id="pastedText">';
			echo parse_text($rad['paste']);
			echo '</pre>'."\n";
		echo '</td>'."\n";
		echo '</tr>';
		echo '</table>'."\n";
		
		echo '<br />'."\n";
		
		echo '</fieldset>'."\n";


		// Hämta alla som skapats utifrån ovanstående
		$count2 = $db->query("SELECT COUNT(*) from tblPaste WHERE parent=\"".$rad['tag']."\"")->fetchColumn();
		$res2 = $db->query("SELECT id, time, tag, paste FROM tblPaste WHERE parent=\"".$rad['tag']."\" ORDER BY time DESC");

		// Visa posten, om kommandot fungerade och den faktiskt hittade något
		if ($res2 !== FALSE && $count2 > 0)
		{
			// lista tidigare
			echo '<br />'."\n";
			echo '<fieldset id="childrenPastes"><legend>Avkommor</legend>'."\n";
			
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

			foreach ($res2 as $rad2) {
				
				$utdrag = "";
				
				if (strlen($rad2['paste']) > 200) {
					$utdrag = substr(htmlspecialchars($rad2['paste']), 0, 195) . ' >>>';
				} else {
					$utdrag = htmlspecialchars($rad2['paste']);
				}

				$stil = ($i%2==0) ? "lista_falt1" : "lista_falt2";
				echo '<tr>';
				if (isset($_SESSION['adminLogin']))	{
					echo '<td class="'.$stil.'" align="right"><a href="./?'.$rad2['tag'].'"><b>'.$rad2['tag'].'</b></a></td>';
				}
				echo '<td class="'.$stil.'" align="left"><a href="./?'.$rad2['tag'].'">'.datum($rad2['time']).'</a></td>'.
					 '<td class="'.$stil.'" id="utdrag-'.$rad2['id'].'"><a href="./?'.$rad2['tag'].'">'.$utdrag.'</a></td>';
				
				// Om inloggad som admin
				if (isset($_SESSION['adminLogin']))	{
					echo '<td class="'.$stil.'" align="center">'.$rad2['ip'].'<br />('.gethostbyaddr($rad2['ip']).')</td>'.
						 '<td class="'.$stil.'"><a href="./internal/delete.php?id='.$rad2['id'].'" onmouseover="document.getElementById(\'utdrag-'.$rad2['id'].'\').style.textDecoration = \'line-through\';" onmouseout="document.getElementById(\'utdrag-'.$rad2['id'].'\').style.textDecoration = \'none\';" onclick="return confirm(\'Raderar: '.$rad2['tag'].'\n\nÄr du säker?\');"><img src="./images/icon_delete.gif" alt="Radera" /></a>'."\n";
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
	}
}
else
{
	echo '<h2>Felaktigt urklipp</h2>'."\n";
	echo '<p>Kunde inte hitta efterfrågat urklipp i databasen.</p>'."\n";
	echo '<p><i><a href="./">Gå till startsidan och klistra in ett eget istället!</i></p>'."\n";
}

?>
