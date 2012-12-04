<?php

// Koppla upp databasen
require './dbconn.php';
$db = new DBConn("sqlite",$cfg['sqlite_db']) or die("DBConn fail");

// Hämta all data
$count = $db->query("SELECT COUNT(*) from tblPaste WHERE tag=\"".htmlspecialchars($url[0])."\"")->fetchColumn();
$res = $db->query("SELECT id, time, tag, paste FROM tblPaste WHERE tag=\"".htmlspecialchars($url[0])."\"");

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
		echo '<b>'.datum($rad['time']).'</b><br />'."\n";
		echo strlen($rad['paste']).' tecken på '.$numberOfRows.' rader'."\n";
		echo '</div>';
		
		echo '<ul id="pasteLinks">'."\n";
		echo '<li><a href="./raw.php?tag='.$rad['tag'].'">Länk till rådata</a></li>'."\n";
		echo '<li><a href="#" onclick="showreader(true);">Visa läsare</a></li>'."\n";
		echo '<li><a href="./dl.php?tag='.$rad['tag'].'">Ladda hem som fil</a></li>'."\n";
		echo '<li><a href="./?edit='.$rad['tag'].'">Redigera som ny</a></li>'."\n";
		echo '</ul>'."\n";

		// 	echo '<button type="button" onclick="showreader(true);">Visa läsare</button>'."\n";
		
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
	}
}
else
{
	echo '<h2>Felaktigt urklipp</h2>'."\n";
	echo '<p>Kunde inte hitta efterfrågat urklipp i databasen.</p>'."\n";
	echo '<p><i><a href="./">Gå till startsidan och klistra in ett eget istället!</i></p>'."\n";
}

?>
