<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

$tbl[1][1] = "issue_surrogates";
$tbl[1][2] = 1;
$idx[1][1] = "index_issue_surrogates";
$kee[1][1] = "issue_surrogate_id".","."issue_type_id".","."surrogate_type"; 
                      
$tbl[2][1] = "issue_types";
$tbl[2][2] = 1;
$idx[2][1] = "index_issue_types";
$kee[2][1] = "issue_type_id".","."issue_class_id"; 

$tbl[3][1] = "issue_class";
$tbl[3][2] = 1;
$idx[3][1] = "index_issue_class";
$kee[3][1] = "issue_class_id"; 


$tbl[4][1] = "issues";
$tbl[4][2] = 2;
$idx[4][1] = "index_issues_1";
$kee[4][1] = "pdp_id".","."void".","."test_iteration"; 
$idx[4][2] = "index_issues_2";
$kee[4][2] = "pdp_id".","."void"; 


$tbl[5][1] = "issue_history";
$tbl[5][2] = 2;
$idx[5][1] = "index_issue_history_1";
$kee[5][1] = "issue_history_id";
$idx[5][2] = "index_issue_history_2";
$kee[5][2] = "issue_history_id".","."issue_id";
$idx[5][3] = "index_issue_history_3";
$kee[5][3] = "issue_id";

$tbl[6][1] = "milestone_surrogates";
$tbl[6][2] = 1;
$idx[6][1] = "index_milestone_surrogates";
$kee[6][1] = "execution_id".","."milestone_id".","."iteration_count"; 

$tbl[7][1] = "pdp_execution";
$tbl[7][2] = 1;
$idx[7][1] = "index_pdp_execution";
$kee[7][1] = "pdp_id"; 

$tbl[8][1] = "pdp_stlc";
$tbl[8][2] = 1;
$idx[8][1] = "index_pdp_stlc";
$kee[8][1] = "issue_area_id".","."milestone_id"; 

$tbl[9][1] = "issue_areas";
$tbl[9][2] = 1;
$idx[9][1] = "index_issue_areas";
$kee[9][1] = "issue_area_id"; 

$tbl[10][1] = "area_execution";
$tbl[10][2] = 1;
$idx[10][1] = "index_area_execution";
$kee[10][1] = "pdp_id".","."issue_area_id".","."test_iteration"; 

$tbl[11][1] = "pdp_testing";
$tbl[11][2] = 1;
$idx[11][1] = "index_pdp_testing";
$kee[11][1] = "pdp_id"; 

$tbl[12][1] = "pdp";
$tbl[12][2] = 2;
$idx[12][1] = "index_pdp_1";
$kee[12][1] = "pdp_id"; 
$idx[12][2] = "index_pdp_2";
$kee[12][2] = "pdp_desc"; 

print("Start of Rebuilding Indexes<br>");

for ($x=1;$x<=12;++$x) {
     $tbl_name  = $tbl[$x][1];
     $idx_count = $tbl[$x][2];
     print($tbl_name."<br>".$idx_count."<br>"."<br>");
     for ($y=1;$y<=$idx_count;++$y) {
          $idx_name = $idx[$x][$y];
          $idx_key  = $kee[$x][$y];
          //if ($y == 1){
              $query = "ALTER TABLE ".$name.".$tbl_name DROP INDEX $idx_name" ;
              $mysql_data = mysql_query($query, $mysql_link); // or die ("Drop Index #$x."-".$y Could not query: ".mysql_error());
              print("$idx_name dropped for $tbl_name<br>");
          //}
          $query = "ALTER TABLE ".$name.".$tbl_name ADD INDEX $idx_name ($idx_key)" ;
          $mysql_data = mysql_query($query, $mysql_link) or die ("Indexing #$x."-".$y Could not query: ".mysql_error());
          print("$idx_name rebuilt for $tbl_name<br>");
     }
}
print("End of Rebuilding Indexes<br>");


//$querysa1 = "ALTER TABLE ".$name.".issue_surrogates ENGINE='InnoDB'" ;
//$mysql_dataa1 = mysql_query($querysa1, $mysql_link) or die ("#a1 Could not query: ".mysql_error());
//print("Reindex of issue_surrogates done<br>");

//$querysa2 = "ALTER TABLE ".$name.".issue_types ENGINE='InnoDB'" ;
//$mysql_dataa2 = mysql_query($querysa2, $mysql_link) or die ("#a2 Could not query: ".mysql_error());
//print("Reindex of issue_types done<br>");

//$querysa3 = "ALTER TABLE ".$name.".issue_class ENGINE='InnoDB'" ;
//$mysql_dataa3 = mysql_query($querysa3, $mysql_link) or die ("#a3 Could not query: ".mysql_error());
//print("Reindex of issue_class done<br>");

//$querysa4 = "ALTER TABLE ".$name.".issues ENGINE='InnoDB'" ;
//$mysql_dataa4 = mysql_query($querysa4, $mysql_link) or die ("#a4 Could not query: ".mysql_error());
//print("Reindex of issues done<br>");

//$querysa5 = "ALTER TABLE ".$name.".issue_history ENGINE='InnoDB'" ;
//$mysql_dataa5 = mysql_query($querysa5, $mysql_link) or die ("#a5 Could not query: ".mysql_error());
//print("Reindex of issue_history done<br>");

//$querysa6 = "ALTER TABLE ".$name.".milestone_surrogates ENGINE='InnoDB'" ;
//$mysql_dataa3 = mysql_query($querysa6, $mysql_link) or die ("#a6 Could not query: ".mysql_error());
//print("Reindex of milestone_surrogates done<br>");

//$querysa7 = "ALTER TABLE ".$name.".pdp ENGINE='InnoDB'" ;
//$mysql_dataa7 = mysql_query($querysa7, $mysql_link) or die ("#a7 Could not query: ".mysql_error());
//print("Reindex of pdp done<br>");

//$querysa8 = "ALTER TABLE ".$name.".pdp_execution ENGINE='InnoDB'" ;
//$mysql_dataa8 = mysql_query($querysa8, $mysql_link) or die ("#a8 Could not query: ".mysql_error());
//print("Reindex of pdp_execution done<br>");

//$querysa9 = "ALTER TABLE ".$name.".pdp_stlc ENGINE='InnoDB'" ;
//$mysql_dataa9 = mysql_query($querysa9, $mysql_link) or die ("#a9 Could not query: ".mysql_error());
//print("Reindex of pdp_stlc done<br>");

//print("End of Rebuilding Indexes<br>");
//print("<br>");


?>
