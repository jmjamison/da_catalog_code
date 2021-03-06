<html>
<head><title>Data Archives Catalog - Index Terms</title>
<link rel="stylesheet" href="2col_leftNav.css" type="text/css">
</head>
<body>
<!-- link to top of page starts here -->
<H1 align="center">Study Numbers</H1>

<?php
	
	error_reporting(E_ALL);
	ini_set('display_errors', true);


	$sscnetHTTP = "http://www.sscnet.ucla.edu/issr/da/da_catalog_test/";
	$currentHTTP = $sscnetHTTP;
	
	$sscnetInclude = "ISSRDA_login.php";
	$mydesktopInclude = "../db_login2.php";
	$currentInclude = $sscnetInclude;
	include($currentInclude); 
	
		
$queryForMnumbers = "SELECT title.StudyNum, title.tisort, title.Title FROM title WHERE ( title.StudyNum LIKE 'M%' ) AND ( title.Studynum >= 'M1150V1' ) ORDER BY title.StudyNum";
	
	//$studynumber =  $_GET['studynumber']; 
	
	// PDO connect  
	//$PDO_string = "mysql:host=".$db_host.";dbname=da_catalog";
	$PDO_string = "mysql:host=" . $db_host . ";port=" . $db_port . ";dbname=" . $db_name ;

	
	$PDO_connection = new PDO($PDO_string, $db_username, $db_password);
	
	// PDO - create prepared statement
	 $PDO_query = $PDO_connection->prepare($queryForMnumbers);
	 
	 
	 // PDO - execute the query
	 $result = $PDO_query->execute();

	if (!$result) {
		die ("Could not query the database: <br />". mysql_error());
	}	
	
	
	
	
	// the index term list
	$studynumberList=array();
	
	

		
	$row_index = 0;
		
	while ($row = $PDO_query->fetch(PDO::FETCH_ASSOC))  {
		
		$tempStudynumber = $row['StudyNum'];
		
		// code to insure that the studynumbers sort correctly
		
		$numeric_only = preg_replace('/[a-zA-Z]/', '', $tempStudynumber);
		$numeric_only = str_pad($numeric_only, 10, "0", STR_PAD_LEFT);	
		
		$alpha_only = preg_replace("/[0-9]/", '', $tempStudynumber); 
		
		$studynumberList[$row_index]["alpha"] = $alpha_only;		
		$studynumberList[$row_index]["num"] = str_pad($numeric_only, 6, "0", STR_PAD_LEFT);	
		$studynumberList[$row_index]["studynum"] = $tempStudynumber;	
		
		$studynumberList[$row_index]["tisort"] = $row["tisort"];
		$studynumberList[$row_index]["title"] = $row["Title"];
		
		
	 	$row_index++;
	 		}
			
			
	$studynumberListCount = count($studynumberList);
	sort($studynumberList);
	
	for($row_index = 0; $row_index < $studynumberListCount; $row_index++) {
		
		$studynumber = $studynumberList[$row_index]["studynum"];
		$tisort = $studynumberList[$row_index]["tisort"];
		$title = $studynumberList[$row_index]["title"];
		
		echo $studynumber . ";" . $tisort . ";" . $title . "<br>";
		
	}
	
	
		
	
	// close the connection
	// mysql_close($connection);		
	$PDO_connection = null;
	
	
	
	?>
</div> 
<!-- end container-->
 
 </div>   <!--end navbar-->

</body></html>