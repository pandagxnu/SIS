<?php

	/* /backend/teachers.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Lehrer
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$selectSections = array(
	array("E", 	""),
	array("N", 	""),
	array("W", 	""),
	array("M", 	""),
	);

$fields = array(
	array( "ID", 		"",			 			"hidden", 	"",		"",		"",					""),
	array( "teName", 	"Name: ", 				"text", 	"15",	"",		"",					""),
	array( "teShort", 	"K&uuml;rzel: ", 		"text", 	"5",	"",		"",					""),
	array( "display", 	"Kurzname: ", 			"text",		"15",	"",		"",					""),
	array( "seShort",	"Stammabteilung: ", 	"dropdown",	"5",	"",		$selectSections,	""),	
	);


pageHeader("Formular","main");

$result = selectTeacher("","");
$i=0;
while ($row = mysql_fetch_array($result)){
//	print_r($row);
	form_new("get","",$fields,$row);
	$i=$i+1;
	
}
//print_r($i);
form_new("get","",$fields,false);

pageFooter();
?>
