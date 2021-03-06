<?php

	/* /statistics/index.php
	 * Autor: Handle Marco
	 * Beschreibung:
	 *	Erstellt das Formular für die Hilfe
	 *
	 */
	 
require("../../../config.php");
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/statistics.php");
require_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("Statistik", __FILE__);


if (!($_SESSION['rights']['root'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

$startTime = date("d-m-Y",mktime(0,0,0,2,18,2014));
$endTime = date("d-m-Y");
//print_R($_POST);
if(!empty($_POST['ok']) && $_POST['ok']!=""){
	HashCheck($hashGenerator);
	
	$temp1 = explode("-",$_POST['startTime']);
	$temp2 = explode("-",$_POST['endTime']);
	if(checkdate($temp1[1],$temp1[0],$temp1[2]) && checkdate($temp2[1],$temp2[0],$temp2[2])){
		$temp = get(strtotime($_POST['startTime']),strtotime($_POST['endTime']));
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];
		$fail = "";
	}
	else{
		$temp = get(strtotime($startTime),strtotime($endTime));
		$fail = "Bitte korrektes Datum eingeben!!";
	}
	
}
else
	$temp = get(strtotime($startTime),strtotime($endTime));



$browserPC = $temp[0];
$osPC=$temp[1];
$classes = $temp[2];
$sections = $temp[3];
$sitesSub = $temp[4];
$hourFrequenzy = $temp[5];
$mobileWeb = $temp[6];
$sitesClients = $temp[7];
$sitesMobile = $temp[8];
$osM=$temp[10];
$browserM = $temp[9];
$dayFrequenzy = $temp[11];

//Für die Tagesaufrufe wird das erste Datum (min) des ersten Eintrages um einen Tag verringert um eine bessere Darstellung zu erreichen
//Selbes gilt für den letzten Einrag der Aufrufe. Nur wird hier ein Tag erhöht.
$x = strptime(strftime("%d %b %Y",$temp[12][0]), "%d %b %Y");
$y = mktime($x["tm_hour"], $x["tm_min"], $x["tm_sec"], 
		$x["tm_mon"]+1, $x["tm_mday"]-1, 1900+$x["tm_year"] );
$d_min = strftime("%d %b %Y", $y);

$x = strptime(strftime("%d %b %Y",$temp[12][1]), "%d %b %Y");
$y = mktime($x["tm_hour"], $x["tm_min"], $x["tm_sec"], 
		$x["tm_mon"]+1, $x["tm_mday"]+1, 1900+$x["tm_year"] );
$d_max = strftime("%d %b %Y", $y);
//Seitenheader
pageHeader("Statistiken","main");
$hashGenerator->generate();
HashFail();
?>
<form method="post">
<?php $hashGenerator->printForm(); ?>
<table>
<?php 
if ($fail != "")
	echo "<tr><td>$fail</td></tr>";
?>
<tr><td>Startdatum: (DD-MM-YYYY)</td></tr>
<tr><td><input type="date" name="startTime" value="<?php echo $startTime; ?>"></td></tr>

<tr><td>Enddatum: (DD-MM-YYYY)</td></tr>
<tr><td><input type="date" name="endTime" value="<?php echo $endTime; ?>"></td></tr>
<tr><td><button type="submit" name="ok" value="ok">OK</button></td></tr>
</table>
</form>


Das Entwicklungsteam wird nicht mitgez&auml;hlt!!!<br />
<a href="">Reload</a><br /><br />
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="<?php echo RELATIVE_ROOT;?>/modules/external/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var s1 = [ <?php echo $browserPC; ?>];
         
    var plot1 = $.jqplot('chart1', [s1], {
	title:'Browser PC',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s2 = [ <?php echo $osPC; ?>];
         
    var plot2 = $.jqplot('chart2', [s2], {
	title:'Plattform PC',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s10 = [ <?php echo $browserM; ?>];
         
    var plot10 = $.jqplot('chart10', [s10], {
	title:'Browser Mobile',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s11 = [ <?php echo $osM; ?>];
         
    var plot11 = $.jqplot('chart11', [s11], {
	title:'Plattform Mobile',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});

$(document).ready(function(){
    var s3 = [ <?php echo $classes; ?>];
         
    var plot3 = $.jqplot('chart3', [s3], {
	title:'Sch&uuml;ler/Lehrer',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s4 = [ <?php echo $sections; ?>];
         
    var plot4 = $.jqplot('chart4', [s4], {
	title:'Abteilungen',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s5 = [ <?php echo $sitesSub; ?>];
         
    var plot5 = $.jqplot('chart5', [s5], {
	title:'Seiten Supplierungen',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s6 = [ <?php echo $mobileWeb; ?>];
         
    var plot6 = $.jqplot('chart6', [s6], {
	title:'App/Web',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s8 = [ <?php echo $sitesClients; ?>];
         
    var plot8 = $.jqplot('chart8', [s8], {
	title:'Seitenaufrufe Web',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
    var s9 = [ <?php echo $sitesMobile; ?>];
         
    var plot9 = $.jqplot('chart9', [s9], {
	title:'Seitenaufrufe Apps',
        seriesDefaults: {
        // Make this a pie chart.
        renderer: $.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      },
	grid: {
    	drawGridLines: true,        // wether to draw lines across the grid or not.
        gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
        background: 'transparent',      // CSS color spec for background color of grid.
        borderColor: '#999999',     // CSS color spec for border around grid.
        borderWidth: 2.0,           // pixel width of border around grid.
        shadow: true,               // draw a shadow for grid.
        shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
        shadowOffset: 1.5,          // offset from the line of the shadow.
        shadowWidth: 3,             // width of the stroke for the shadow.
        shadowDepth: 3
}, 
      legend: { show:true, location: 'e' }
    });
});
$(document).ready(function(){
	var s7 = [ <?php echo $hourFrequenzy; ?>];
	var plot7 = $.jqplot('chart7', [s7], {
		title:'Aufrufe/Stunde',
            seriesDefaults: {
            	renderer:$.jqplot.BarRenderer,
	 			pointLabels:{ 
					show: true 
				},
	        	showMarker:true,
	        	rendererOptions: {
	       		}
        	},
            axes: {
               	xaxis: {
               		renderer: $.jqplot.CategoryAxisRenderer
               	}
            },
            grid: {
			   	drawGridLines: true,        // wether to draw lines across the grid or not.
			    gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
			    background: 'transparent',      // CSS color spec for background color of grid.
			    borderColor: '#999999',     // CSS color spec for border around grid.
			    borderWidth: 2.0,           // pixel width of border around grid.
			    shadow: true,               // draw a shadow for grid.
			    shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
			    shadowOffset: 1.5,          // offset from the line of the shadow.
			    shadowWidth: 3,             // width of the stroke for the shadow.
			    shadowDepth: 3
			}, 
	});
});
$(document).ready(function(){
	var s12 = [ <?php echo $dayFrequenzy; ?>];
	var plot12 = $.jqplot('chart12', [s12], {
		title:'Aufrufe/Tag',
        cursor:{
        	show: true, 
			zoom: true
		},
        seriesDefaults: {
 			pointLabels:{ 
				show: true 
			},
        	showMarker:true,
        	rendererOptions: {
       		}
        },
        axes: {
           	xaxis: {
           		renderer: $.jqplot.DateAxisRenderer,
			abelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                	tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                	tickOptions: {
                    		angle: -40,
				textColor: 'white',
				formatString: '%a %d %b %Y',
                	},
			min: '<?php echo $d_min; ?>',
			max: '<?php echo $d_max; ?>',
        	},
		yaxis:{
			min:0,
		}
        },
        grid: {
		   	drawGridLines: true,        // wether to draw lines across the grid or not.
		    gridLineColor: '#cccccc',   // CSS color spec of the grid lines.
		    background: 'transparent',      // CSS color spec for background color of grid.
		    borderColor: '#999999',     // CSS color spec for border around grid.
		    borderWidth: 2.0,           // pixel width of border around grid.
		    shadow: true,               // draw a shadow for grid.
		    shadowAngle: 45,            // angle of the shadow.  Clockwise from x axis.
		    shadowOffset: 1.5,          // offset from the line of the shadow.
		    shadowWidth: 3,             // width of the stroke for the shadow.
		    shadowDepth: 3
		}, 

	});
});

</script>
<?php
printf("<div  id=\"chart1\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart2\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart10\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart11\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart3\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart4\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart5\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart6\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart8\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart9\" style=\"height:400px;width:600px;float:left;\"></div>");
printf("<div  id=\"chart7\" style=\"height:400px;width:1200px;float:left;\"></div>");
printf("<div  id=\"chart12\" style=\"height:400px;width:1200px;float:left;\"></div>");
//Seitenfooter



pageFooter();


?>
