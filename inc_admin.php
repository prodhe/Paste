<?php

	// aktivera sessioner
	session_start();

	// visa in- eller utloggning
	if (!isset($_SESSION['adminLogin']))
	{
		echo '<form method="post" action="login.php">'."\n";
		echo '<fieldset><legend>Logga in för administration</legend>'."\n";
		echo '<label for="password">Lösenord:</label><input type="password" name="passwordForAdmin" id="password" />'."\n";
		echo '</fieldset>'."\n";
		echo '</form>'."\n";
	}
	else
	{
		echo '<p><a href="./logout.php?admin"><b>Logga ut</b></a></p>'."\n";
	}

?>