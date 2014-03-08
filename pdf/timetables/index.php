<?php
include_once("../../config.php");	 
require_once(ROOT_LOCATION . "/modules/external/fpdf/fpdf.php");
include_once(ROOT_LOCATION . "/modules/general/Connect.php");			
include_once(ROOT_LOCATION . "/modules/general/SessionManager.php");
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");	

ifNotLoggedInGotoLogin();	

$permission = getPermission();
if($permission != "root" and $permission != "admin") noPermission();
if(isset($_GET['section'])) $section =$_GET['section'];
else $section = 'N';
if(isset($_GET['class'])) $class =$_GET['class'];
else exit();

$sql ="SELECT 
		`su`.`short` AS `suShort`,
		`sH`.`hour` AS `startHour`,
		`eH`.`hour` AS `endHour`,
		`sH`.`weekdayShort` AS `weekday` 
	  	FROM lessons AS `l`
		INNER JOIN subjects AS `su` ON `l`.`subjectFK` = `su`.`ID`
		INNER JOIN lessonsBase AS `lb` ON `l`.`lessonBaseFK` = `lb`.`ID`
		INNER JOIN classes AS `c` ON `lb`.`classFK` = `c`.`ID`
		INNER JOIN hours AS `sH` ON `lb`.`startHourFK` = `sH`.`ID`
		INNER JOIN hours AS `eH` ON `lb`.`endHourFK` = `eH`.`ID`
		WHERE `c`.`name` = '".$class."'
";
$sql_result  = mysql_query($sql);
echo mysql_error();
while($result = mysql_fetch_array($sql_result)) {    
	$results[]=$result;
}
$hours = array();
for($j=0;$j<count($results);$j++){
 	$startHour =$results[$j]['startHour'];

	while($startHour <= $results[$j]['endHour'])
	{	
 		if(isset($hours[$startHour][$results[$j]['weekday']]) && $hours[$startHour][$results[$j]['weekday']] != $results[$j]['suShort'])
		{
 			if(!strpos($hours[$startHour][$results[$j]['weekday']],$results[$j]['suShort']))
			$hours[$startHour][$results[$j]['weekday']] .= " | ".$results[$j]['suShort'];
		}
		else $hours[$startHour][$results[$j]['weekday']] = $results[$j]['suShort'];
	$startHour++;
	}
}

$day = array(1=>'Mo',2=>'Di',3=>'Mi',4=>'Do',5=>'Fr');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('gothic');
$pdf->AddFont('gothic','B');
$pdf->SetFont('gothic','B',20);
$pdf->Cell('130','25','HTL Anichstraße');
$pdf->CELL('10','25','Klasse: '.$class,'','1');
$pdf->SetFont('gothic','B',16);
$pdf->Cell('25','10','Stunde','1');
$pdf->Cell('25','10','Mo','1');
$pdf->Cell('25','10','Di','1');
$pdf->Cell('25','10','Mi','1');
$pdf->Cell('25','10','Do','1');
$pdf->Cell('25','10','Fr','1','1');
$pdf->SetFont('gothic','',12);
for($i=1;$i<17;$i++){
	$pdf->Cell('25','10',$i,'1');
	for($j=1;$j<6;$j++){
		if(isset($hours[$i][$day[$j]])){
 			$pdf->Cell('25','10',$hours[$i][$day[$j]],'1');
			
		}
		else $pdf->Cell('25','10','','1');
	}
	$pdf->Cell('1','10','','','1');
}
$pdf->Output();
?>