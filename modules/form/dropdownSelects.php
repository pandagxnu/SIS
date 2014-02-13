<?php
	/* /modules/form/dropdownSelects.php
	 * Autor: Handle Marco
	 * Version: 1.0.0
	 * Beschreibung:
	 *	ERstellt die Dropdown Einträge
	 *
	 * Changelog:
	 * 	1.0.0:  26. 08. 2013, Handle Marco - Selects für die Dropdownmenüs fertiggestellt
	 */
	
include(ROOT_LOCATION . "/modules/general/Connect.php");			//Bindet die Datenbank ein


//Section
if(array_search("Sections",$dropDown)!==false){
	$temp =  mysql_query("SELECT short FROM sections");
	$selectSections = create($temp,"seShort");
}
//Teacher
if(array_search("Teachers",$dropDown)!==false){
	$temp = mysql_query("SELECT short FROM teachers WHERE invisible = 'FALSE' ");
	$selectTeachers = create($temp,"teShort");
}
//Rooms
if(array_search("Rooms",$dropDown)!==false){
	$temp = mysql_query("SELECT name FROM rooms");
	$selectRooms = create($temp,"roName");
}
//Subjects
if(array_search("Subjects",$dropDown)!==false){
	$temp = mysql_query("SELECT short FROM subjects WHERE invisible = 'FALSE' ");
	$selectSubjects = create($temp,"suShort");
}
//Classes
if(array_search("Classes",$dropDown)!==false){
	$temp = mysql_query("SELECT name FROM classes WHERE invisible = 'FALSE' ");
	$selectClasses = create($temp,"clName");
}
//Classes nur Abteilung
if(array_search("ClassesSub",$dropDown)!==false){
	$temp = mysql_query("SELECT classes.name FROM classes INNER JOIN sections ON sections.ID = classes.sectionFK WHERE classes.invisible = 'FALSE' AND sections.short = '".$section."'");
	$selectClasses = create($temp,"clName");
}

//Days
if(array_search("Days",$dropDown)!==false){
	$selectDays = array(
		array("Mo", ""),
		array("Di", ""),
		array("Mi", ""),
		array("Do", ""),
		array("Fr", ""),
		);
		
	printf("<datalist id=\"day\">\n");
								
	foreach($selectDays as $p)													//FÃƒÆ’Ã‚Â¯Ãƒâ€šÃ‚Â¿Ãƒâ€šÃ‚Â½r jeden MenÃƒÆ’Ã‚Â¯Ãƒâ€šÃ‚Â¿Ãƒâ€šÃ‚Â½eintrag im Array f einen Eintrag erstellen
	{
		printf("<option value=\"%s\">\n", $p[0]);
	}
	
	printf("</datalist>\n\n");
}

//Erstell aus den mysql querys die Arrays mit den Inhalten
//$result ist der mysql_query
function create($result,$name){

$array=array();	//Array erstellen

while ($row = mysql_fetch_array($result)){	//Führt für jeden Datensatz die Schleife einmal aus
	array_push($array,array($row[0],""));		//Fügt dem Array ein neues Array hinzu mit dem Inhalt und einem leeren Feld(wenn selected wird das zweite benötigt)
}


printf("<datalist id=\"%s\">\n",$name);
							
foreach($array as $p)													//FÃƒÆ’Ã‚Â¯Ãƒâ€šÃ‚Â¿Ãƒâ€šÃ‚Â½r jeden MenÃƒÆ’Ã‚Â¯Ãƒâ€šÃ‚Â¿Ãƒâ€šÃ‚Â½eintrag im Array f einen Eintrag erstellen
{
	printf("<option value=\"%s\">\n", $p[0]);
}

printf("</datalist>\n\n");

}




?>