<?php

	/* /modules/database/selects.php
	 * Autor: Handle Marco
	 * Beschreibung:
	 *	Select Befehle f�r die Datenbank
	 *
	 */

/*
 *Gibt die Ganze Tabelle mit all ihren Spalten zurück
 *
 *$table string Tabellenname
 *$where string zum Filtern
 *$order string zum Sortieren
 *
 */
function selectAll($table, $where, $order){

	$sql = "SELECT * FROM ".$table;					//Stamm sql-Befehl
	
	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle Section zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *	
 *ID,seName,seShort,teShort
 */
function selectSection($where,$order){

	$sql="SELECT sections.ID , sections.name as seName, sections.short as seShort, teachers.short as teShort 
		FROM sections 
		INNER JOIN teachers ON sections.teacherFK=teachers.ID";		//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist
	
	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle Rooms zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *
 *ID,roName,teShort	
 */
function selectRooms($where,$order){

	$sql= "SELECT rooms.ID, rooms.name as roName, teachers.short as teShort 
		FROM rooms 
		LEFT JOIN teachers ON rooms.teacherFK=teachers.ID";	//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle Teacher zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *	
 *ID,teName,teShort,display,seShort,invisible
 */
function selectTeacher($where,$order){

	$sql= "SELECT teachers.ID, teachers.name as teName, teachers.short as teShort, teachers.display, sections.short as seShort, teachers.invisible 
		FROM teachers 
		LEFT JOIN sections ON teachers.sectionFK=sections.ID";	//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle Class zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *	
 *ID,clName,seShort,teShort,roName,invisible
 */
function selectClass($where,$order){

	$sql= "SELECT classes.ID, classes.name as clName, sections.short as seShort, teachers.short as teShort, rooms.name as roName, classes.invisible 
		FROM classes 
		LEFT JOIN sections ON sections.ID=classes.sectionFK 
		LEFT JOIN teachers ON teachers.ID=classes.teacherFK 
		LEFT JOIN rooms ON rooms.ID=classes.roomFK ";	//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle Lesson zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *	
 *ID,clName,roName,teShort,teDisplay,suShort,weekdayShort,startHour,endHour,comment,lessonsBaseFK
 */
function selectLesson($where,$order){

  	$sql= "SELECT lessons.ID, hoursStart.hour as startHour, hoursEnd.hour as endHour, rooms.name as roName, teachers.short as teShort, teachers.display as teDisplay, subjects.short as suShort, hoursStart.weekdayShort, classes.name as clName, lessons.comment, lessons.lessonBaseFK 
		FROM lessons 
		LEFT JOIN rooms ON rooms.ID = lessons.roomFK 
		INNER JOIN teachers ON teachers.ID = lessons.teachersFK 
		INNER JOIN subjects ON subjects.ID = lessons.subjectFK 
		INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK 
		INNER JOIN classes ON classes.ID = lessonsBase.classFK 
		INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK 
		INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";	//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle MissingTeacher zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *
 *ID,teShort,startDay,startHour,endDay,endHour,reason
 */
function selectMissingTeacher($where,$order){

  	$sql= "SELECT missingTeachers.ID, teachers.short as teShort, missingTeachers.startDay as startDay, hoursStart.hour as startHour, missingTeachers.endDay as endDay, hoursEnd.hour as endHour, missingTeachers.reason 
		FROM missingTeachers 
		INNER JOIN teachers ON teachers.ID = missingTeachers.teacherFK
		INNER JOIN hours as hoursStart ON hoursStart.ID = missingTeachers.startHourFK 
		INNER JOIN hours as hoursEnd ON hoursEnd.ID = missingTeachers.endHourFK";		//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe
}

/*
 *Gibt den Inhalt von der Tabelle MissingClasses zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *
 *ID,clName,startDay,startHour,endDay,endHour,reason
 */
function selectMissingClass($where,$order){

	$sql= "SELECT missingClasses.ID, classes.name as clName, missingClasses.startDay as startDay, hoursStart.hour as startHour, missingClasses.endDay as endDay, hoursEnd.hour as endHour, missingClasses.reason 
		FROM missingClasses 
		INNER JOIN classes ON classes.ID = missingClasses.classFK
		INNER JOIN hours as hoursStart ON hoursStart.ID = missingClasses.startHourFK 
		INNER JOIN hours as hoursEnd ON hoursEnd.ID = missingClasses.endHourFK";	//Stamm sql-Befehl
	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist

	return mysql_query($sql);	//R�ckgabe

}

/*
 *Gibt den Inhalt von der Tabelle Substitudes zur�ck
 *
 *$where string zum Filtern
 *$order string zum Sortieren
 *	
 *ID,newSub,move,remove,short,clName,suShort,teShort,teDisplay,time,roName,startHour,endHour,comment,oldStartHour,oldEndHour,weekdayShort,oldTeShort,oldSuShort,oldRoName,lessonBaseFK
 */
function selectSubstitude($where,$order){

 	$sql= "SELECT substitudes.ID, substitudes.newSub, substitudes.move, substitudes.remove, sections.short, classes.name as clName, subjects.short as suShort, teachers.short as teShort, teachers.display as teDisplay, substitudes.time, rooms.name as roName, hoursStart.hour as startHour, hoursEnd.hour as endHour, substitudes.comment, oldHoursStart.hour as oldStartHour, oldHoursEnd.hour as oldEndHour, hoursStart.weekdayShort, oldTeacher.short as oldTeShort , oldSubjects.short as oldSuShort,  oldRooms.name as oldRoName, lessons.lessonBaseFK
		FROM substitudes 
		LEFT JOIN lessons ON lessons.ID=substitudes.lessonFK 
		LEFT JOIN lessonsBase ON lessonsBase.ID=lessons.lessonBaseFK
		LEFT JOIN subjects ON subjects.ID = substitudes.subjectFK 
		LEFT JOIN subjects as oldSubjects ON oldSubjects.ID = lessons.subjectFK
		LEFT JOIN teachers ON teachers.ID = substitudes.teacherFK 
		LEFT JOIN teachers as oldTeacher ON oldTeacher.ID = lessons.teachersFK 
		LEFT JOIN rooms ON rooms.ID = substitudes.roomFK
		LEFT JOIN rooms as oldRooms ON oldRooms.ID = lessons.roomFK  
		LEFT JOIN classes ON classes.ID = substitudes.classFK 
		LEFT JOIN hours as hoursStart ON hoursStart.ID = substitudes.startHourFK 
		LEFT JOIN hours as hoursEnd ON hoursEnd.ID = substitudes.endHourFK 
		LEFT JOIN hours as oldHoursStart ON oldHoursStart.ID = lessonsBase.startHourFK 
		LEFT JOIN hours as oldHoursEnd ON oldHoursEnd.ID =  lessonsBase.endHourFK
		LEFT JOIN sections ON classes.sectionFK = sections.ID";	//Stamm sql-Befehl

	if (!empty($where)) $sql .= " WHERE " . $where; 	//Wenn where Variable gesetzt ist
	if (!empty($order)) $sql .= " ORDER BY " . $order;	//Wenn order Variable gesetzt ist
	//echo $sql;
	return mysql_query($sql);	//R�ckgabe

}

?>
