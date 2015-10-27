<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>


<html><head><title>Eve Fielder Library: List by Subject</title>


<link href="../_css/2col_leftNav.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1 id="siteName"><a href="../index.php"><img src="../_images/logo75.jpg" width="75" height=""></a> Social Science Data Archive: Eve Fielder Collection</h1> 
 
<div id"container">

<?php  
	include("../_includes/SSDA_menubar.php");  
//
// SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
//
?>

<div id="content" align="left">
<H1 align="center">Subject/Index</H1><br>

<?php
		
	$currentHTTP = "http://data-archive.library.ucla.edu/da_catalog_fielder/";	
	//SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	include("../_includes/SSDA_librarydatabase.php");  //SSDA_menubar.php has the menu code for da_catalog, da_catalog_fielder(fielder collection) and 'archive reources'
	// class for database connections
	include "../_classes/class.Database.php";
	
// Define configuration
// define info pulled from SSDA_librarydatabase.php
define("DB_HOST", $db_host);
define("DB_PORT", $db_port);
define("DB_USER", $db_username);
define("DB_PASS", $db_password);
define("DB_NAME", $db_name);
	
// should be adding "class.Database.php";	
//function __autoload($class_name) {
	// echo 'class.' . $class_name . '.php<br>';
	//include 'class.' . $class_name . '.php';
//}
	 
	// check, if NOT set 
	if (!isset($_GET['subject'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
		
	if (!isset($_GET['subjectID'])) { 
		echo "<span style='margin-left: 0; text-align: center; background-color: powderblue;'><a href='fielder_titles.php'>No citations selected. Return to catalog.</a></span><br>";
		die ("No citations selected.");
		
		}
	 
	$subject =  $_GET['subject']; 
	$subjectID =  $_GET['subjectID']; 
	
	
	 
	// sql query statement
	
	 
	 $titlesBySubjectQuery = "select fielderSubjectFull.*, fielderSubjectCode.*, fielderBibRecord.* from fielderSubjectFull left join fielderSubjectCode on fielderSubjectFull.subjectID = fielderSubjectCode.subjectID left join fielderBibRecord on fielderSubjectCode.baseCode = fielderBibRecord.ID where fielderSubjectFull.subjectID = '" . $subjectID . "' ORDER BY title";
	//echo $titlesBySubjectQuery;
	
	
	// class.Database.php  is the class to make PDO connections
// initialize new db connection instance
$db = new Database();	 
	
// prepare query
$db->prepareQuery($titlesBySubjectQuery);   	
// execute query
$result = $db->executeQuery();	 
	
//$result = $db->resultset();  // execute the query
if (!$result) { 
		die ("Could not query the database: <br />"); 		
		}  // else {  echo "Successfully queried the database.<br>";   }  // for debugging

	
	echo "<H1>" . $subject  . "</H1><br>";
	echo "subject / ID : <strong>" . $subject .  "</strong><br>";


		 
	
	echo "<ul>";

		while ($row = $db->getRow())  {
		// Non-PDO code ---------------------
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			
			$title = $row[ "title" ];
			$titleArticle = $row[ "titleArticle" ];
			$recordID = $row[ "ID" ];
			
			//$studynum = $row[ "StudyNum" ];
			
			echo "<li class='alphaTitleList'><A HREF= '" . $currentHTTP . "fielder_titleRecord.php?ID=" . $recordID . "'>" . $titleArticle . " " . $title . "</a></li>";
		}
	echo "</ul>";
	
	
	
	// _destructor class closes connection
	// close the connection		
	//$PDO_connection = null;
	
	?>
    </div>
    
 </div>
 
</body></html>