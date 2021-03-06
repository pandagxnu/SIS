<?php
	/* /monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.0
	 * Beschreibung:
	 *	Start-Seite für Monitore
	 * 	GET-Parameter Name identifiziert den Monitor
	 *	übernimmt Registrierung der Monitore
	 *
	 * Changelog:
	 *	1.0.0:	24. 09. 2013, Buchberger Florian - + Registrierung (prüft IP)
	 * 	0.1.0:  22. 08. 2013, Buchberger Florian - erste Version
	 */

	require("../config.php");		
	require(ROOT_LOCATION . "/modules/general/Connect.php");
	require(ROOT_LOCATION . "/modules/general/Site.php");
	
	if (!isset($_GET['name']) || empty($_GET['name'])) {
		echo ("no name given");
		exit();
	}

	if (isset($_GET['register'])) {
		$sql = "SELECT `ID` FROM `monitors` WHERE `ip` = '" . $_SERVER['REMOTE_ADDR'] . "'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			// irgendwie wieder endkommentieren
			//die("already bind to monitor");
		}
		$name = mysql_real_escape_string($_GET['name']);
		$sql = "INSERT IGNORE INTO `monitors` SET `name`='" . $name . "', `modeFK`=5, `file`='def.mp4', `roomFK`=1, `ip`='" . $_SERVER['REMOTE_ADDR'] . "', `displayModeFK`=1, `displayStartDaytime`=0, `displayEndDaytime`=0, `sectionFK`=1, `time`=" . time() . "";
		$result = mysql_query($sql);
		header("LOCATION: ?name=" . $_GET['name']);
		exit();
	}

	if (!isset($_GET['test']))
		pageHeader(htmlspecialchars($_GET['name']), "monitors");
	else
		pageHeader(htmlspecialchars($_GET['name']), "monitorsTest");
	pageFooter();
?>
