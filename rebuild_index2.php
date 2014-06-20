<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

       /////////////////////////////////////////////////////////////////////////////////////////////////////
       /////////////////////////////////////////////////////////////////////////////////////////////////////
       $tbl[1][1] = "tgt_pdp_main";
       $tbl[1][2] = 2;
       $idx[1][1] = "index_tgt_pdp_main_1";
       $kee[1][1] = "pdp";
       $idx[1][2] = "index_tgt_pdp_main_2";
       $kee[1][2] = "etl_id".","."pdp";
                      
       $tbl[2][1] = "tgt_pdp_testing";
       $tbl[2][2] = 4;
       $idx[2][1] = "index_tgt_pdp_testing_1";
       $kee[2][1] = "pdp".","."short_desc";
       $idx[2][2] = "index_tgt_pdp_testing_2";
       $kee[2][2] = "pdp".","."department";
       $idx[2][3] = "index_tgt_pdp_testing_3";
       $kee[2][3] = "etl_id".","."pdp".","."short_desc";
       $idx[2][4] = "index_tgt_pdp_testing_4";
       $kee[2][4] = "etl_id".","."pdp".","."department";

       $tbl[3][1] = "tgt_pdp_area_execution";
       $tbl[3][2] = 2;
       $idx[3][1] = "index_tgt_pdp_area_execution_1";
       $kee[3][1] = "pdp".","."issue_area";
       $idx[3][2] = "index_tgt_pdp_area_execution_2";
       $kee[3][2] = "etl_id".","."pdp".","."issue_area";

       $tbl[4][1] = "tgt_pdp_area_work_effort";
       $tbl[4][2] = 2;
       $idx[4][1] = "index_pdp_area_work_effort_1";
       $kee[4][1] = "pdp".","."issue_area"; 
       $idx[4][2] = "index_pdp_area_work_effort_2";
       $kee[4][2] = "etl_id".","."pdp".","."issue_area"; 

       $tbl[5][1] = "tgt_pdp_issue_summary";
       $tbl[5][2] = 4;
       $idx[5][1] = "index_tgt_pdp_issue_summary_1";
       $kee[5][1] = "pdp".","."issue_type".","."issue_class";
       $idx[5][2] = "index_tgt_pdp_issue_summary_2";
       $kee[5][2] = "pdp".","."issue_type";
       $idx[5][3] = "index_tgt_pdp_issue_summary_3";
       $kee[5][3] = "etl_id".","."pdp".","."issue_type".","."issue_class";
       $idx[5][4] = "index_tgt_pdp_issue_summary_4";
       $kee[5][4] = "etl_id".","."pdp".","."issue_type";

       $tbl[6][1] = "tgt_pdp_issue_area_summary";
       $tbl[6][2] = 4;
       $idx[6][1] = "index_tgt_pdp_issue_area_summary_1";
       $kee[6][1] = "pdp".","."issue_area".","."issue_type";
       $idx[6][2] = "index_tgt_pdp_issue_area_summary_2";
       $kee[6][2] = "pdp".","."issue_area";
       $idx[6][3] = "index_tgt_pdp_issue_area_summary_3";
       $kee[6][3] = "etl_id".","."pdp".","."issue_area".","."issue_type";
       $idx[6][4] = "index_tgt_pdp_issue_area_summary_4";
       $kee[6][4] = "etl_id".","."pdp".","."issue_area";

       $tbl[7][1] = "tgt_areas";
       $tbl[7][2] = 2;
       $idx[7][1] = "index_tgt_areas_1";
       $kee[7][1] = "issue_area";
       $idx[7][2] = "index_tgt_areas_2";
       $kee[7][2] = "etl_id".","."issue_area";

       $tbl[8][1] = "tgt_report_groups";
       $tbl[8][2] = 4;
       $idx[8][1] = "index_tgt_report_groups_1";
       $kee[8][1] = "issue_type".","."issue_class";
       $idx[8][2] = "index_tgt_report_groups_1";
       $kee[8][2] = "issue_type";
       $idx[8][3] = "index_tgt_report_groups_2";
       $kee[8][3] = "etl_id".","."issue_type".","."issue_class";
       $idx[8][4] = "index_tgt_report_groups_2";
       $kee[8][4] = "etl_id".","."issue_type";

       $tbl[9][1] = "tgt_ytd_main";
       $tbl[9][2] = 4;
       $idx[9][1] = "index_tgt_ytd_main_1";
       $kee[9][1] = "pdp_type";
       $idx[9][2] = "index_tgt_ytd_main_2";
       $kee[9][2] = "etl_id".","."pdp_type";
       $idx[9][3] = "index_tgt_ytd_main_3";
       $kee[9][3] = "etl_id".","."pdp_type".","."ytd_year";
       $idx[9][4] = "index_tgt_ytd_main_4";
       $kee[9][4] = "pdp_type".","."ytd_year";

       $tbl[10][1] = "tgt_root_cause_ytd";
       $tbl[10][2] = 4;
       $idx[10][1] = "index_tgt_root_cause_ytd_1";
       $kee[10][1] = "issue_type";
       $idx[10][2] = "index_tgt_root_cause_ytd_2";
       $kee[10][2] = "etl_id".","."issue_type";
       $idx[10][3] = "index_tgt_root_cause_ytd_3";
       $kee[10][3] = "etl_id".","."issue_type".","."etl_year";
       $idx[10][4] = "index_tgt_root_cause_ytd_4";
       $kee[10][4] = "issue_type".","."etl_year";

       $tbl[11][1] = "tgt_rework_hours_ytd";
       $tbl[11][2] = 4;
       $idx[11][1] = "index_tgt_rework_hours_ytd_1";
       $kee[11][1] = "area";
       $idx[11][2] = "index_tgt_rework_hours_ytd_2";
       $kee[11][2] = "etl_id".","."area";
       $idx[11][3] = "index_tgt_rework_hours_ytd_3";
       $kee[11][3] = "etl_id".","."area".","."etl_year";
       $idx[11][4] = "index_tgt_rework_hours_ytd_4";
       $kee[11][4] = "area".","."etl_year";

       $tbl[12][1] = "tgt_back_to_build_ytd";
       $tbl[12][2] = 4;
       $idx[12][1] = "index_tgt_back_to_build_ytd_1";
       $kee[12][1] = "area";
       $idx[12][2] = "index_tgt_back_to_build_ytd_2";
       $kee[12][2] = "etl_id".","."area";
       $idx[12][3] = "index_tgt_back_to_build_ytd_3";
       $kee[12][3] = "etl_id".","."area".","."etl_year";
       $idx[12][4] = "index_tgt_back_to_build_ytd_4";
       $kee[12][4] = "area".","."etl_year";

       //print("Start of Rebuilding Indexes<br>");
       for ($x=1;$x<=12;$x=$x+1) {
            $tbl_name  = $tbl[$x][1];
            $idx_count = $tbl[$x][2];
            print("<br>".$x." - ".$tbl_name."<br>".$idx_count."<br>");
            for ($y=1;$y<=$idx_count;++$y) {
                 $idx_name = $idx[$x][$y];
                 $idx_key  = $kee[$x][$y];
                 $query = "ALTER TABLE ".$name.".$tbl_name DROP INDEX $idx_name" ;
                 $mysql_data = mysql_query($query, $mysql_link); // or die ("Drop Index #$x."-".$y Could not query: ".mysql_error());
                 print("$idx_name dropped for $tbl_name<br>");
                 $query = "ALTER TABLE ".$name.".$tbl_name ADD INDEX $idx_name ($idx_key)" ;
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Indexing #$x."-".$y Could not query: ".mysql_error());
                 print("$idx_name rebuilt for $tbl_name<br>");
            }
       }
       ////////////////////////////////////////////////////////////////////////////////////////////////////
       /////////////////////////////////////////////////////////////////////////////////////////////////////



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
