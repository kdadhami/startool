<?php
// Connection
require_once("./inc/connect.php");
set_time_limit(0);


// ============================== SESSION START ==============================
session_start();
$xsession = session_id();
$querys5 = "SELECT user 
              FROM ".$name.".sessions
             WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#21 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),b.short_desc,u.user_type
                     FROM ".$name.".users a, ".$name.".issue_areas b, ".$name.".user_types u   
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                      AND a.user_type_id = u.user_type_id
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#22 Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);
              $ushort_desc     = stripslashes($row6[2]);
              $uuser_type      = stripslashes($row6[3]);
       }         
}
// =============================== SESSION END ===============================



// INCREMENTAL ETL
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// setting up today's date
$yw         = date("D");
$yd         = date("d");
$ym         = date("m");
$yy         = date("Y");
$yt         = date("H:i:s T");
$yt2        = date("HisT");
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
$etl_year   = $yy;

// setting up start and end date
$start_d    = 1;
$start_m    = 1;
$start_y    = $etl_year;
$start_dmy  = mktime(0,0,0,$start_m,$start_d,$start_y);
$end_d      = 31;
$end_m      = 12;
$end_y      =  $etl_year;
$end_dmy    = mktime(0,0,0,$end_m,$end_d,$end_y);
//print($start_y." - ".$end_y."<br>");

   $queryx      = "select a.pdp_id,
                          a.pdp_desc,
                          a.updated_date,
                          a.updated_by,
                          a.pdp_name,
                          a.pdp_owner,
                          a.pdp_launch,
                          a.pdp_status,
                          a.pdp_period_id,
                          a.pdp_category_id,
                          a.complexity_id,
                          a.projection_id,
                          a.revenue_id,
                          a.comparison_id,
                          a.pdp_period_id,
                          a.main_pdp_id,
                          a.parent_pdp_id,
                          a.lob						  
                     from ".$name.".pdp a  
                    where trim(a.pdp_status) <> 'Cancelled'
                      and pdp_launch between '$start_dmy' and '$end_dmy' 
                      and etl_check = 1  
                 order by a.main_pdp_id,a.pdp_id ";
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#8 Could not query: ".mysql_error());
   $rowcntx     = mysql_num_rows($mysql_datax);
   //print($queryx."<br>".$rowcntx."<br>");
   $seq1        = 0;
   $seq         = 0;
   // =========================================================================================
   // ====================================== EXTRACT PDP ======================================
   // =========================================================================================
   if ($rowcntx > 0) {
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
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

       //print("Start of Rebuilding Indexes<br>");

       for ($x=1;$x<=12;++$x) {
            $tbl_name  = $tbl[$x][1];
            $idx_count = $tbl[$x][2];
            //print($tbl_name."<br>".$idx_count."<br>"."<br>");
            for ($y=1;$y<=$idx_count;++$y) {
                 $idx_name = $idx[$x][$y];
                 $idx_key  = $kee[$x][$y];
                 $query = "ALTER TABLE ".$name.".$tbl_name DROP INDEX $idx_name" ;
                 $mysql_data = mysql_query($query, $mysql_link); // or die ("Drop Index #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name dropped for $tbl_name<br>");
                 $query = "ALTER TABLE ".$name.".$tbl_name ADD INDEX $idx_name ($idx_key)" ;
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Indexing #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name rebuilt for $tbl_name<br>");
            }
       }

       // ============================== PDP TYPES ==============================
       $queryptyp = "select pdp_period_id,pdp_period 
                       from ".$name.".pdp_periods 
                      where pdp_period_ind = 1 
                   order by pdp_period asc "; 
       $mysql_dataptyp = mysql_query($queryptyp, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcntptyp     = mysql_num_rows($mysql_dataptyp);    
       
       $pdp_prd_cnt = 1;
       $pdp_prd_id[$pdp_prd_cnt] = 0;
       $pdp_prd[$pdp_prd_cnt]    = "NOT SET";
       while($rowptyp = mysql_fetch_row($mysql_dataptyp)) {
             $pdp_prd_cnt              = $pdp_prd_cnt + 1;
             $pdp_prd_id[$pdp_prd_cnt] = stripslashes(trim($rowptyp[0]));
             $pdp_prd[$pdp_prd_cnt]    = stripslashes(trim($rowptyp[1]));
             print($pdp_prd[$pdp_prd_cnt]."<br>");
       }

       // ============================== ISSUE TYPE START ==============================
       $query69               = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,
                                        a.issue_seq,a.report_group_id,a.parent_issue_type_id
                                   from ".$name.".issue_types a, ".$name.".issue_class b
                                         where a.issue_class_id = b.issue_class_id
                                           and b.issue_class_code <> 'GRT'
                               order by b.issue_class_code desc,a.issue_seq asc";
       //print($query69."<br>");                         
       $mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
       $rowcnt69              = mysql_num_rows($mysql_data69); 
       $icnt                  = 0;
       while($row69           = mysql_fetch_row($mysql_data69)) {
             $icnt            = $icnt + 1;
             $iid[$icnt]      = stripslashes($row69[0]);        //Issue_id
             $ityp[$icnt]     = stripslashes($row69[1]);        //issue_type
             $ityp_ind[$icnt] = stripslashes($row69[2]);
             $iccd[$icnt]     = trim(stripslashes($row69[3]));  //issue_class_code
             //$iseq[$icnt]   = stripslashes($row69[4]);
             $irgrpid[$icnt]  = stripslashes($row69[5]);        //report_group_id
             $ipid[$icnt]     = stripslashes($row69[6]);      
             $igrp[$icnt]     = 0;                              //
             if ($irgrpid[$icnt] == 0) {
                 $irgrp[$icnt]   = "NO";                        //report_group is not assigned
             }
             // find out report group for each issue type
           if ($iccd[$icnt] == "CNT"){
               $query96        = "select report_group
                                    from ".$name.".report_groups
                                          where report_group_id = '$irgrpid[$icnt]' "; 
               $mysql_data96   = mysql_query($query96, $mysql_link) or die ("#2.5 Could not query: ".mysql_error());
               $rowcnt96       = mysql_num_rows($mysql_data96); 
               while($row96        = mysql_fetch_row($mysql_data96)) {
                     $irgrp[$icnt] = stripslashes($row96[0]);    //report_group
                     // find out if this group has other issue types from prvious $icnt, if yes create a tcnt[$icnt] else do
                     $ifound = 0;
                     for ($x=1;$x<=$icnt-1;++$x) {
                          if ($irgrp[$icnt] == $irgrp[$x]){
                              $ifound = 1;
                          }
                     }
                     if ($ifound == 0){
                         $xiid      =  $iid[$icnt];
                         $xityp     =  $ityp[$icnt];
                         $xityp_ind =  $ityp_ind[$icnt];
                         $xiccd     =  $iccd[$icnt];
                         $xirgrpid  =  $irgrpid[$icnt];  
                         $xirgrp    =  $irgrp[$icnt]; 
                         $xipid     =  $ipid[$icnt];
                         $xigrp     =  $igrp[$icnt];
                         $xind      =  $ind[$icnt];
                         $xicnt     =  $icnt;

                         $iid[$icnt]      = 0;       //Issue_id        
                         $ityp[$icnt]     = $xirgrp; //New Type is the group Name
                         $ityp_ind[$icnt] = 1;       //Valid 
                         $iccd[$icnt]     = $xiccd;  //Class Code of the Issue Type the Report Group was found first
                         $irgrpid[$icnt]  = 0;
                         $irgrp[$icnt]    = $xirgrp;
                         $ipid[$icnt]     = 0;
                         $igrp[$icnt]     = 1;
                  
                         $icnt            = $icnt + 1;
                         $iid[$icnt]      = $xiid;
                         $ityp[$icnt]     = $xityp;
                         $ityp_ind[$icnt] = $xityp_ind;
                         $iccd[$icnt]     = $xiccd;
                         $irgrpid[$icnt]  = $xirgrpid;  
                         $irgrp[$icnt]    = $xirgrp; 
                         $ipid[$icnt]     = $xipid;
                         $igrp[$icnt]     = $xigrp;
                     }
               }
            }  
             if ($iccd[$icnt] == "ROT"){
                 $query77  = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,
                                     a.issue_seq,a.report_group_id,a.parent_issue_type_id 
                                from ".$name.".issue_types a, ".$name.".issue_class b 
                               where a.parent_issue_type_id = '$iid[$icnt]' 
                                 and a.issue_class_id = b.issue_class_id                           
                            order by b.issue_class_code desc,a.issue_seq asc";
                 $mysql_data77 = mysql_query($query77, $mysql_link) or die ("#2.6 Could not query: ".mysql_error());
                 $rowcnt77     = mysql_num_rows($mysql_data77); 
                 //print($query77."<br>".$rowcnt77."<br>");
                 if ($rowcnt77 <> 0){
                     $irgrp[$icnt] = $ityp[$icnt];
                     $igrp[$icnt]  = 1;
                 }
                 while($row77           = mysql_fetch_row($mysql_data77)) {
                       $icnt            = $icnt + 1;
                       $iid[$icnt]      = stripslashes($row77[0]);        //Issue_id
                       $ityp[$icnt]     = stripslashes($row77[1]);        //issue_type
                       $ityp_ind[$icnt] = stripslashes($row77[2]);
                       $iccd[$icnt]     = trim(stripslashes($row77[3]));  //issue_class_code
                       //$iseq[$icnt]   = stripslashes($row69[4]);
                       $irgrpid[$icnt]  = stripslashes($row77[5]);        //report_group_id
                       $ipid[$icnt]     = stripslashes($row77[6]);
                       $irgrp[$icnt]    = $irgrp[$icnt-1];
                       $igrp[$icnt]     = 0;                              //
                 }
             }    
       }
       // =============================== ISSUE TYPE END ===============================
       
       // ============================== DEPARTMENT START ==============================
       $queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                          from ".$name.".issue_areas
                         where issue_area_ind = 1 
                      order by issue_area_id ";
       $mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#3 Could not query: ".mysql_error());
       $rowcntx2     = mysql_num_rows($mysql_datax2);    
       $dcnt         = 0;
       while($rowx2  = mysql_fetch_row($mysql_datax2)) {
             $dcnt        = $dcnt + 1;
             $did[$dcnt]  = stripslashes(trim($rowx2[0]));
             $dpt[$dcnt]  = stripslashes(trim($rowx2[1]));
             $dsc[$dcnt]  = stripslashes(trim($rowx2[2]));
             $dind[$dcnt] = stripslashes(trim($rowx2[3]));
             $dti[$dcnt]  = stripslashes(trim($rowx2[4]));
             if ($dind[$dcnt] == 1){
                 $dind[$dcnt] = "YES";
             } else {
                 $dind[$dcnt] = "NO";
             }
             // Iteration are setup like this (hardcoded for now, unless there is a point to decomission pdp_testing table and replace ra_ind with another alternative.
             if ($dsc[$dcnt] == "CMGT" ||  $dsc[$dcnt] == "RA"){
                 $dit[$dcnt] = 2;
             } else {
                 $dit[$dcnt] = 1;
             }
       }
       // =============================== DEPARTMENT END ===============================

       // ============================== PDP CATEGORY START ==============================
       $queryx4      = "select a.pdp_category_id,a.pdp_category,b.category_scope 
                          from ".$name.".pdp_categories a, category_scope b 
                         where a.category_scope_id = b.category_scope_id 
                      order by b.category_scope_id,a.pdp_category_id "; 
       $mysql_datax4 = mysql_query($queryx4, $mysql_link) or die ("#4 Could not query: ".mysql_error());
       $rowcntx4     = mysql_num_rows($mysql_datax4);    
       $ccnt         = 0;
       $ccnt         = $ccnt + 1;
       $cid[$ccnt]   = 0;
       $cat[$ccnt]   = "NOT SET";
       $scp[$ccnt]   = "NOT SET";
       while($rowx4  = mysql_fetch_row($mysql_datax4)) {
             $ccnt   = $ccnt + 1;
             $cid[$ccnt] = stripslashes(trim($rowx4[0]));
             $cat[$ccnt] = stripslashes(trim($rowx4[1]));
             $scp[$ccnt] = stripslashes(trim($rowx4[2]));
       }
       // =============================== PDP CATEGORY END ===============================
       
       // =============================== MILESTONES START ===============================
       $query36           = "select milestone_id,milestone,milestone_time 
                               from ".$name.".pdp_stlc 
                           order by milestone_id "; 
                              //where milestone_id = $zid";
       $mysql_data36      = mysql_query($query36, $mysql_link) or die ("#5 Could not query: ".mysql_error());
       $rowcnt36          = mysql_num_rows($mysql_data36);
       $mcnt              = 0;
       while($row36       = mysql_fetch_row($mysql_data36)) {
             $mcnt        = $mcnt + 1;
             $mid[$mcnt]  = stripslashes($row36[0]);
             $mil[$mcnt]  = stripslashes($row36[1]);
             $mit[$mcnt]  = stripslashes($row36[2]);
             //print($mid[$mcnt]." = ".$mil[$mcnt]." - ".$mit[$mcnt]."<br>");
       }
       // ================================ MILESTONES END ================================

       // ============================== STATUS TYPES START ==============================
       //load status types
       $queryx1      = "select status_type_id,status_type,status_color_code 
                         from ".$name.".status_types 
                        where status_type_ind = 1"; 
       $mysql_datax1 = mysql_query($queryx1, $mysql_link) or die ("5.5 Could not query: ".mysql_error());
       $rowcntx1     = mysql_num_rows($mysql_datax1);    
       $scnt        = 0;
       while($rowx1 = mysql_fetch_row($mysql_datax1)) {
             $scnt        = $scnt + 1;
             $sid[$scnt]  = stripslashes(trim($rowx1[0]));
             $styp[$scnt] = stripslashes(trim($rowx1[1]));      
             $sclr[$scnt] = stripslashes(trim($rowx1[2]));
             //print($sid[$scnt]."-".$styp[$scnt]."-".$sclr[$scnt]."<br>");
       }
       // =============================== STATUS TYPES END ===============================
       
       $ynote      = $ydate2."  -  Incremental Batch Started";

          //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
          $query101      = "INSERT into ".$name.".etl_batches(etl_status,ran_by,etl_year,pdp_count)
                            VALUES('$ynote','$usr','$etl_year','$rowcntx')";
          $mysql_data101 = mysql_query($query101, $mysql_link) or die ("#99.0 Could not query: ".mysql_error());
          $xetl_id       = mysql_insert_id();
          //print("ETL ID: ".$xetl_id."<br>"); 
          //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================
       //============================================================================================================


       //$found  = 1;
       $tbrun    = 0;
       $tinvc    = 0;
       $tppw     = 0;
       $tdfct    = 0;
       $tprwk    = (float)0;
       $tisue    = 0;
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       while($rowx = mysql_fetch_row($mysql_datax)) {
             $seq              = $seq + 1;
             $bypass           = 0;
	         $xid              = stripslashes($rowx[0]);
	         $xpdp_desc        = stripslashes($rowx[1]);
             $xupdated_date    = stripslashes($rowx[2]);
             $xd               = date("d",$xupdated_date);
             $xm               = date("M",$xupdated_date);
             $xy               = date("Y",$xupdated_date);
             $xdt              = $xd."-".$xm."-".$xy;
             $xupdated_by      = stripslashes($rowx[3]);
             $xpdp_name        = stripslashes($rowx[4]);    
             $xpdp_owner       = stripslashes($rowx[5]); 
             $xpdp_launch      = stripslashes($rowx[6]);
             $xpdp_status      = stripslashes($rowx[7]); 
             $xpdp_period_id   = stripslashes($rowx[8]);
             $xcategory_id     = stripslashes($rowx[9]);
             $xcomplexity_id   = stripslashes($rowx[10]);
             $xprojection_id   = stripslashes($rowx[11]);
             $xrevenue_id      = stripslashes($rowx[12]);
             $xpast_id         = stripslashes($rowx[13]);
             //$xpdp_period_id   = stripslashes($rowx[14]);
             $xmain_pdp_id     = stripslashes($rowx[15]);
             $xparent_pdp_id   = stripslashes($rowx[16]);
			 $ylob             = stripslashes($rowx[17]);
			 if ($ylob == 1){
			     $xlob = "CABLE AND WIRELESS";
			 }
			 if ($ylob == 2){
			     $xlob = "CABLE";
			 }
			 if ($ylob == 3){
			     $xlob = "WIRELESS";
			 }
			 if ($ylob == 0){
			     $xlob = "UNKNOWN";
			 }
             $xpdp_name        = str_replace("'","",$xpdp_name);
             $xpdp_owner       = str_replace("'","",$xpdp_owner);
             $queryi2 = "select count(a.issue_id) 
                           from ".$name.".issues a      
                          where a.pdp_id = '$xid'
                            and a.void = 0 
                       order by a.issue_id asc "; 
             $mysql_datai2 = mysql_query($queryi2, $mysql_link) or die ("#100 Could not query: ".mysql_error());

             ///////////////////////////////////////////
             ///////////////////////////////////////////
             // DELETE PREVIOUS ENTRY FOR THIS PDP
             //////////////////////////////////////////
             ////////////////////////////////////////// 
             $query98      = "select etl_id 
                                from ".$name.".tgt_pdp_main 
                               where pdp = '$xpdp_desc'"; 
             $mysql_data98 = mysql_query($query98, $mysql_link) or die ("#98.99 Could not query: ".mysql_error());
             $rowcnt98     = mysql_num_rows($mysql_data98);
             while($row98 = mysql_fetch_row($mysql_data98)) {
                   $detl_id   = stripslashes(trim($row98[0]));
             }          
             $query99      = "select etl_id,etl_year 
                                from ".$name.".etl_batches 
                               where etl_id = '$detl_id'";
			 // where etl_year = '$etl_year'				   
             $mysql_data99 = mysql_query($query99, $mysql_link) or die ("#99.99 Could not query: ".mysql_error());
             $rowcnt99     = mysql_num_rows($mysql_data99); 
             while($row99 = mysql_fetch_row($mysql_data99)) {
                   $detl_year = stripslashes(trim($row99[1]));
             }          
             $query199     = "UPDATE ".$name.".etl_batches 
                                 SET pdp_count = pdp_count - 1
						       WHERE etl_id = '$detl_id' ";
			 // where etl_year = '$etl_year'				   
             $mysql_data199 = mysql_query($query199, $mysql_link) or die ("#199.99 Could not query: ".mysql_error());
             //////////////////////////////////////////////////////////////
    	     $query       = "DELETE FROM ".$name.".tgt_pdp_main
                              WHERE pdp = '$xpdp_desc' ";
		     $mysql_data  = mysql_query($query, $mysql_link);
             //delete from cube1_main (snowflakes)
		     $query1      = "DELETE FROM ".$name.".tgt_pdp_testing
                              WHERE pdp = '$xpdp_desc' ";
		     $mysql_data1 = mysql_query($query1, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query2      = "DELETE FROM ".$name.".tgt_pdp_area_execution
                              WHERE pdp = '$xpdp_desc' ";
		     $mysql_data2 = mysql_query($query2, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query3      = "DELETE FROM ".$name.".tgt_pdp_area_work_effort
                              WHERE pdp = '$xpdp_desc' ";                               
		     $mysql_data3 = mysql_query($query3, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query7      = "DELETE FROM ".$name.".tgt_pdp_issue_area_summary
                              WHERE pdp = '$xpdp_desc' ";
		     $mysql_data7 = mysql_query($query7, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query8      = "DELETE FROM ".$name.".tgt_pdp_issue_summary
                              WHERE pdp = '$xpdp_desc' ";                               
		     $mysql_data8 = mysql_query($query8, $mysql_link);
             // delete from cube1_main (snowflakes)
	         $query11      = "DELETE FROM ".$name.".tgt_ytd_main
                              WHERE ytd_year = '$detl_year' ";                               
		     $mysql_data11 = mysql_query($query11, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query12      = "DELETE FROM ".$name.".tgt_root_cause_ytd
                              WHERE etl_year = '$detl_year' ";                               
		     $mysql_data12 = mysql_query($query12, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query13      = "DELETE FROM ".$name.".tgt_back_to_build_ytd
                              WHERE etl_year = '$detl_year' ";                               
		     $mysql_data13 = mysql_query($query13, $mysql_link);
             // delete from cube1_main (snowflakes)
		     $query14      = "DELETE FROM ".$name.".tgt_rework_hours_ytd
                              WHERE etl_year = '$detl_year' ";                               
		     $mysql_data14 = mysql_query($query14, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query4      = "DELETE FROM ".$name.".tgt_areas";              // delete completely, need to have only one set of value and not per etl run
		      $mysql_data4 = mysql_query($query4, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query5      = "DELETE FROM ".$name.".tgt_report_groups";      // delete completely, need to have only one set of value and not per etl run
		      $mysql_data5 = mysql_query($query5, $mysql_link);		      
             ///////////////////////////////////////////
             ///////////////////////////////////////////
             //////////////////////////////////////////
             ////////////////////////////////////////// 

             while($rowi2 = mysql_fetch_row($mysql_datai2)) {
                    $xissues_created  = stripslashes($rowi2[0]);
             }
            // =========================================================================================
            // ================================== EXTRACT LAUNCH DATE ==================================
            // =========================================================================================
            if (empty($xpdp_launch)){
                             $xpdp_launch_dt = "-";
                             $xdate = "0000-00-00 00:00:00";
            } else {  
                             $xld            = date("d",$xpdp_launch);
                             $xlm            = date("M",$xpdp_launch);
                             $xly            = date("Y",$xpdp_launch);
                             $xpdp_launch_dt = $xld."-".$xlm."-".$xly;
                             $xdate          = date("Y-m-d",$xpdp_launch)." 00:00:00";
            }
            // =========================================================================================
            // =================================== EXTRACT PDP PERIOD ==================================
            // =========================================================================================
            //if (empty($xparent_pdp_id) && empty($xmain_pdp_id)){
            //          $xparent_pdp_id = $xpdp_period_id;     //$xid;
            //          $xmain_pdp_id   = $xpdp_period_id;     //$xid;
            //}
            // -----------------------------------------------------------------------------------------
            if ($xpdp_period_id == 0) {
                      $xpdp_period = "NOT SET";
            } else {
                    $query100      = "select a.pdp_period 
                                        from ".$name.".pdp_periods a 
                                       where a.pdp_period_id = '$xpdp_period_id' ";
                    //print($query100);
                    $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#9 Could not query: ".mysql_error());
                    $rowcnt100     = mysql_num_rows($mysql_data100);
                    while($row100  = mysql_fetch_row($mysql_data100)) {
                          $xpdp_period = stripslashes(trim($row100[0]));
                    }
            }
            // =========================================================================================
            // ================================ EXTRACT PARENT AND MAIN ================================
            // =========================================================================================
            if (($xparent_pdp_id == 0) && ($xmain_pdp_id == 0)){
                $xparent_pdp_desc = $xpdp_desc; 
                $xmain_pdp_desc   = $xpdp_desc;
            } else {
                // main_pdp_id
                $queryx2      = "select pdp_desc from ".$name.".pdp where pdp_id = '$xmain_pdp_id'"; 
                $mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#10 Could not query: ".mysql_error());
                $rowcntx2     = mysql_num_rows($mysql_datax2);  
                if ($rowcntx2 > 0) {
                      while($rowx2 = mysql_fetch_row($mysql_datax2)) {
	                        $xmain_pdp_desc = stripslashes($rowx2[0]);
                      }
                } else {
                      $xmain_pdp_desc = "NOT SET";
                } 
                // -----------------------------------------------------------------------------------------
                // parent_pdp_id         
                $queryx3      = "select pdp_desc from ".$name.".pdp where pdp_id = '$xparent_pdp_id'"; 
                $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("#11 Could not query: ".mysql_error());
                $rowcntx3     = mysql_num_rows($mysql_datax3);  
                if ($rowcntx3 > 0) {
                      while($rowx3 = mysql_fetch_row($mysql_datax3)) {
	                        $xparent_pdp_desc = stripslashes($rowx3[0]);
                      }
                } else {
                      $xparent_pdp_desc = "NOT SET";
                }              
            }
            // =========================================================================================
            // ================================= EXTRACT TESTING AREAS =================================
            // =========================================================================================
            $queryy      = "select pdp_id,issue_area_id,test_ind 
                              from ".$name.".pdp_testing
                             where pdp_id = '$xid'"; 
            $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#12 Could not query: ".mysql_error());
            $rowcnty     = mysql_num_rows($mysql_datay);  
            // ====================== Insert in case if not existing in table pdp_testing ==============
            if ($rowcnty == 0) {
               for ($d=1;$d<=$dcnt ; ++$d) {
                    if ($dti[$d] == 1){    
                        $queryi = "INSERT into ".$name.".pdp_testing(pdp_id,issue_area_id,test_ind,short_desc)
                                   VALUES('$xid','$did[$d]',0,'$dsc[$d]')";
                        $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#13 Could not query: ".mysql_error());
                    }    
               }
            }
            // ========================= Select test indicators for each Test Area ===================== 
            $queryy2      = "select pdp_id,issue_area_id,test_ind 
                               from ".$name.".pdp_testing 
                              where pdp_id = '$xid'"; 
            $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("#14 Could not query: ".mysql_error());
            $rowcnty2     = mysql_num_rows($mysql_datay2);  
            $y            = 0; 
            while($rowy2 = mysql_fetch_row($mysql_datay2)) {
                  $y                  = $y + 1;
                  $yissue_area_id[$y] = stripslashes($rowy2[1]);
                  $yti[$y]            = stripslashes($rowy2[2]);
                  for ($d=1;$d<=$dcnt ; ++$d) {
                   if ($dti[$d] == 1){
                       if ($yissue_area_id[$y] == $did[$d]) {
                           $ydsc[$y] = $dsc[$d];
                           $ydpt[$y] = $dpt[$d];  
                       }
                       if ($yti[$y] == 1){
                           $ytind[$y] = "YES"; 
                       } else {
                           $ytind[$y] = "NO";
                       }
                   }
                  }
            }
            // =========================================================================================
            // ==================================== EXTRACT SCOPING ====================================
            // =========================================================================================
            $xfound = 0;
            for ($c=1;$c<=$ccnt ; ++$c) {
                 if ($xcategory_id == $cid[$c]){
                     $xscoping         = $scp[$c];
                     $xcategory        = $cat[$c];
                     $xfound           = 1;
                 }
            }
            if ($xfound == 0) {
                $xcategory             = "NOT SET";  
            }
            $xfound = 0;
            for ($s=1;$s<=$scnt;++$s) {
                 if ($xcomplexity_id == $sid[$s]){
                     $xcomplexity        = $styp[$s];
                     $xcomplexity_clr    = $sclr[$s];
                     $xfound             = 1;
                 }
            }
            if ($xfound == 0) {
                $xcomplexity             = "NOT SET";  
            }
            $xfound = 0;            
            for ($s=1;$s<=$scnt ; ++$s) {
                 if ($xprojection_id == $sid[$s]){
                     $xprojection        = $styp[$s];
                     $xprojection_clr    = $sclr[$s];
                     $xfound             = 1;
                 }
            } 
            if ($xfound == 0) {
                $xprojection             = "NOT SET";  
            }
            $xfound = 0;             
            for ($s=1;$s<=$scnt ; ++$s) {
                 if ($xrevenue_id == $sid[$s]){
                     $xrevenue        = $styp[$s];
                     $xrevenue_clr    = $sclr[$s];
                     $xfound          = 1;
                 }
            } 
            if ($xfound == 0) {
                $xrevenue             = "NOT SET";  
            }
            $xfound = 0;  
            for ($s=1;$s<=$scnt ; ++$s) {
                 if ($xpast_id == $sid[$s]){
                     $xpast        = $styp[$s];
                     $xpast_clr    = $sclr[$s];
                     $xfound       = 1;
                 }
            }                           
            if ($xfound == 0) {
                $xpast             = "NOT SET";  
            }
            $xfound = 0;  
            // =========================================================================================
            // ==================================== EXTRACT TRACKER ====================================
            // =========================================================================================
            // ========================= Select Execution Record ===================== 
            $query42      = "select execution_id,
                                    pdp_id,
                                    updated_by,
                                    invoice_count,
                                    bill_run_count,
                                    ppw_update,
                                    launch_ind
                               from ".$name.".pdp_execution 
                              where pdp_id = '$xid' "; 
            $mysql_data42 = mysql_query($query42, $mysql_link) or die ("#15 Could not query: ".mysql_error());
            $rowcnt42     = mysql_num_rows($mysql_data42);
            if ($rowcnt42 == 0) {
                 $query33 = "INSERT into ".$name.".pdp_execution(pdp_id,launch_ind)
                             VALUES('$xid',0)";
                 $mysql_data33 = mysql_query($query33, $mysql_link) or die ("#query33 Could not query: ".mysql_error());
                 //$yexecution_id     = mysql_insert_id();
                 $yinvoice_cnt        = 0;
                 $ybillrun_cnt        = 0;
                 $yppw_update         = 0;
                 $ydefects            = 0;
                 $ylaunch             = "TBD";
                 $yarea_exec_cnt      = 0;
            } else {
               while($row42           = mysql_fetch_row($mysql_data42)) {
                     $yexecution_id   = stripslashes($row42[0]);
                     $yid             = stripslashes($row42[0]);
                     $ypdp_id         = stripslashes($row42[1]);
                     $yupdated_by     = stripslashes($row42[3]);
                     $yinvoice_cnt    = stripslashes($row42[4]);
                     $ybillrun_cnt    = stripslashes($row42[5]);
                     $yppw_update     = stripslashes($row42[6]);
                     $ylaunch_ind     = stripslashes($row42[7]);
                     // ========================= Launch-in-Jeopardy ===================== 
                     if ($ylaunch_ind == 0){
                         $ylaunch     = "NO";
                     } else {
                         $ylaunch     = "YES";
                     }
                     $itdesc[1] = "TESTING CYCLE PRE-PROD";
                     $itdesc[2] = "TESTING CYCLE PRODUCTION";

                     for ($d=1;$d<=$dcnt; ++$d) {
                      $itcnt = 0;
                      if ($dsc[$d] == "MO" or  $dsc[$d] == "UAT") {
                              $itcnt                  = 1;
                      } else {
                              $itcnt                  = 2;
                      } 

                      for ($t=1;$t<=$itcnt ; ++$t) { 
                       $tissue_created[$d][$t] = 0;                      
                       $query142        = "select a.area_execution_id,
                                                  a.pdp_id,
                                                  a.issue_area_id,
                                                  a.start_date,
                                                  a.end_date,
                                                  a.actual_start_date,
                                                  a.actual_end_date,
                                                  a.actual_testing_days,
                                                  a.actual_weekend_days,
                                                  a.test_iteration,
                                                  a.back_to_build,
                                                  a.updated_by,
                                                  a.last_update,
                                                  a.issue_area_id
                                             from ".$name.".area_execution a 
                                            where a.pdp_id = '$xid' 
                                              and a.issue_area_id = '$did[$d]' 
                                              and a.test_iteration = '$t' 
                                           "; 
                       $mysql_data142   = mysql_query($query142, $mysql_link) or die ("#15.5 Could not query: ".mysql_error());
                       $rowcnt142       = mysql_num_rows($mysql_data142);
                       //$yarea_exec_cnt  =  $rowcnt142;

                       if ($rowcnt142 == 0){
                                // $yae_cnt                  = $yarea_exec_cnt; 
                                // in case for a given pdp there is no record in area_execution, no records are created in cube tgt_pdp_area_execution                         
                                // $tarea_execution_id[$dcnt]= stripslashes($row142[0]);
                                $tpdp_id[$d][$t]             = stripslashes($row142[1]);
                                $tissue_area[$d][$t]         = $dpt[$d];         //stripslashes($row142[2]);
                                $tstart_dt[$d][$t]           = 1167627600;
                                $tend_dt[$d][$t]             = 1167627600;
                                $tact_start_dt[$d][$t]       = 1167627600;
                                $tact_end_dt[$d][$t]         = 1167627600;
                                $tact_wkd[$d][$t]            = 0;
                                $tact_wked[$d][$t]           = 0;
                                $ttest_iteration[$d][$t]     = $t;
                                $tback_to_build[$d][$t]      = 0;
                                //$tupdated_by[$d][$t]         = "";
                                //$tlast_update[$d][$t]        = "";
                                $tissue_area_id[$d][$t]      = 0;
                                $tp_wkd[$d][$t]              = 0;
                                $tp_wked[$d][$t]             = 0;
                                $ta_wkd[$d][$t]              = 0;
                                $ta_wked[$d][$t]             = 0;
                                $query143                    = "select issue_id,issue_area_id,test_iteration
                                                                     from ".$name.".issues  
                                                                    where pdp_id = '$xid' 
                                                                      and void = 0
                                                                      and test_iteration = '$t' 
                                                               "; 
                                //print($query143);                                  
                                // and issue_area_id = '$did[$d]'
                                // and test_iteration = '$t' 
                                $mysql_data143        = mysql_query($query143, $mysql_link) or die ("#15.6 Could not query: ".mysql_error());
                                $rowcnt143            = mysql_num_rows($mysql_data143);
                                //$tissue_created[$d][$t]     =  $rowcnt143;
                                if ($rowcnt143 == 0){
                                    $tissue_created[$d][$t] = 0;
                                } else {
                                  while($row143 = mysql_fetch_row($mysql_data143)) {
                                        $hissue_id       = stripslashes($row143[0]);
                                        $hissue_area_id  = stripslashes($row143[1]);
                                        $htest_iteration = stripslashes($row143[2]);
                                        $query144       = "   select issue_id,issue_area_id
                                                               from ".$name.".issue_history  
                                                              where issue_id = '$hissue_id'
                                                           order by issue_history_id desc limit 1"; 
                                        $mysql_data144  = mysql_query($query144, $mysql_link) or die ("#15.65 Could not query: ".mysql_error());
                                        $rowcnt144      = mysql_num_rows($mysql_data144);
                                        //print($query144."<br>");
                                        if ($rowcnt144 == 0){
                                            if ($hissue_area_id == $did[$d]){
                                                 $tissue_created[$d][$t] = $tissue_created[$d][$t] + 1;
                                                 $tval = $tissue_created[$d][$t];
                                                 //print("A".$tval."<br>");
                                            }
                                        } else {
                                               while($row144 = mysql_fetch_row($mysql_data144)) {
                                                     $gissue_area_id = stripslashes($row144[1]);
                                                     if ($gissue_area_id ==  $did[$d]){
                                                         $tissue_created[$d][$t] = $tissue_created[$d][$t] + 1;
                                                         $tval = $tissue_created[$d][$t];
                                                         //print("A".$tval."<br>");
                                                     }    
                                               } 
                                        }
                                  }
                                }
                                $xstart_date[$d][$t]        = "0000-00-00 00:00:00"; 
                                $xend_date[$d][$t]          = "0000-00-00 00:00:00";
                                $xact_start_date[$d][$t]    = "0000-00-00 00:00:00";
                                $xact_end_date[$d][$t]      = "0000-00-00 00:00:00";
                       } else {
                         //$yae_cnt = 0;
                         while($row142 = mysql_fetch_row($mysql_data142)) {
                               //$yae_cnt                       = $yae_cnt + 1;
                               //$tarea_execution_id[$dcnt]  = stripslashes($row142[0]);
                               $tpdp_id[$d][$t]             = stripslashes($row142[1]);
                               $tissue_area[$d][$t]         = $dpt[$d];         //stripslashes($row142[2]);
                               $tstart_dt[$d][$t]           = stripslashes($row142[3]);
                               $tend_dt[$d][$t]             = stripslashes($row142[4]);
                               $tact_start_dt[$d][$t]       = stripslashes($row142[5]);
                               $tact_end_dt[$d][$t]         = stripslashes($row142[6]);
                               $tact_wkd[$d][$t]            = stripslashes($row142[7]);
                               $tact_wked[$d][$t]           = stripslashes($row142[8]);
                               $ttest_iteration[$d][$t]     = stripslashes($row142[9]);
                               $tback_to_build[$d][$t]      = stripslashes($row142[10]);
                               //$tupdated_by[$d][$t]         = stripslashes($row142[12]);
                               //$tlast_update[$d][$t]        = stripslashes($row142[13]);
                               $tissue_area_id[$d][$t]      = stripslashes($row142[14]);
                               $tp_wkd[$d][$t]              = 0;
                               $tp_wked[$d][$t]             = 0;
                               $ta_wkd[$d][$t]              = 0;
                               $ta_wked[$d][$t]             = 0;
                               $query143                       = "select issue_id,issue_area_id,test_iteration
                                                                    from ".$name.".issues  
                                                                   where pdp_id = '$xid'
                                                                     and void = 0 
                                                                      and test_iteration = '$t' 
                                                                 "; 
                               //and issue_area_id = '$did[$d]'
                               //and test_iteration = '$t' 
                               //print($query143."<br>");                                  
                               $mysql_data143             = mysql_query($query143, $mysql_link) or die ("#15.6 Could not query: ".mysql_error());
                               $rowcnt143                 = mysql_num_rows($mysql_data143);
                               //$tissue_created[$d][$t]    =  $rowcnt143;
                               if ($rowcnt143 == 0){
                                   $tissue_created[$d][$t] = 0;
                               } else {
                                 while($row143 = mysql_fetch_row($mysql_data143)) {
                                       $hissue_id       = stripslashes($row143[0]);
                                       $hissue_area_id  = stripslashes($row143[1]);
                                       $htest_iteration = stripslashes($row143[2]);
                                       $query144       = "   select issue_id,issue_area_id
                                                              from ".$name.".issue_history  
                                                             where issue_id = '$hissue_id'
                                                          order by issue_history_id desc limit 1"; 
                                       $mysql_data144             = mysql_query($query144, $mysql_link) or die ("#15.65 Could not query: ".mysql_error());
                                       $rowcnt144                 = mysql_num_rows($mysql_data144);
                                       //print($query144."<br>");
                                       if ($rowcnt144 == 0){
                                           if ($hissue_area_id == $did[$d]){
                                                $tissue_created[$d][$t] = $tissue_created[$d][$t] + 1;
                                                $tval = $tissue_created[$d][$t];
                                                //print("B".$tval."<br>");
                                           }
                                       } else {
                                              while($row144 = mysql_fetch_row($mysql_data144)) {
                                                    $gissue_area_id = stripslashes($row144[1]);
                                                    if ($gissue_area_id ==  $did[$d]){
                                                        $tissue_created[$d][$t] = $tissue_created[$d][$t] + 1;
                                                        $tval = $tissue_created[$d][$t];
                                                        //print("B".$tval."<br>");
                                                    }    
                                              } 
                                       }
                                 }
                               }
                               // Testing Start Date
                               if (!empty($tstart_dt[$d][$t])){
                                   if ($tstart_dt[$d][$t] == 0){
                                       $tstart_dt[$d][$t] = 1167627600;
                                   }
	                               $yds         = date("d",$tstart_dt[$d][$t]);
                                   $yms         = date("m",$tstart_dt[$d][$t]);
                                   $yms2        = date("M",$tstart_dt[$d][$t]);
                                   $yys         = date("Y",$tstart_dt[$d][$t]);
                                   $ysdt        = "$yds"."-"."$yms2"."-"."$yys";
                                   $xstart_date[$d][$t] = date("Y-m-d",$tstart_dt[$d][$t])." 00:00:00";
                               } else {
                                   $ysdt                  = "-";
                                   $xstart_date[$d][$t] = "0000-00-00 00:00:00";    
                               }
                               // Testing End Date
                               if (!empty($tend_dt[$dcnt][$t])){
                                   if ($tend_dt[$d][$t] == 0){
                                       $tend_dt[$d][$t] = 1167627600;
                                   }
	                               $yde         = date("d",$tend_dt[$d][$t]);
                                   $yme         = date("m",$tend_dt[$d][$t]);
                                   $yme2        = date("M",$tend_dt[$d][$t]);
                                   $yye         = date("Y",$tend_dt[$d][$t]); 
                                   $yedt        = "$yde"."-"."$yme2"."-"."$yye";
                                   $xend_date[$d][$t]   = date("Y-m-d",$tend_dt[$d][$t])." 00:00:00";
                               } else {
                                   $yedt                   = "-";
                                   $xend_date[$d][$t]   = "0000-00-00 00:00:00";
                               }
 
                               // Actual Start Date
                               if (!empty($tact_start_dt[$dcnt][$t])){ 
                                   if ($tact_start_dt[$d][$t] == 0){
                                       $tact_start_dt[$d][$t] = 1167627600;
                                   }
	                               $ydsa            = date("d",$tact_start_dt[$d][$t]);
                                   $ymsa            = date("m",$tact_start_dt[$d][$t]);
                                   $yms2a           = date("M",$tact_start_dt[$d][$t]);
                                   $yysa            = date("Y",$tact_start_dt[$d][$t]);
                                   $ysdta           = "$ydsa"."-"."$yms2a"."-"."$yysa";
                                   $xact_start_date[$d][$t] = date("Y-m-d",$tact_start_dt[$d][$t])." 00:00:00";
                               } else {
                                   $ysdta                     = "-";
                                   $xact_start_date[$d][$t] = "0000-00-00 00:00:00";    
                               }
                               // Actual End Date
                               if (!empty($tact_end_dt[$dcnt][$t])){
                                   if ($tact_end_dt[$d][$t] == 0){
                                       $tact_end_dt[$d][$t] = 1167627600;
                                   }
	                               $ydea            = date("d",$tact_end_dt[$d][$t]);
                                   $ymea            = date("m",$tact_end_dt[$d][$t]);
                                   $yme2a           = date("M",$tact_end_dt[$d][$t]);
                                   $yyea            = date("Y",$tact_end_dt[$d][$t]); 
                                   $yedta           = "$ydea"."-"."$yme2a"."-"."$yyea";
                                   $xact_end_date[$d][$t]  = date("Y-m-d",$tact_end_dt[$d][$t])." 00:00:00";
                               } else {
                                   $yedta                     = "-";
                                   $xact_end_date[$d][$t]  = "0000-00-00 00:00:00";
                               }
                                         $incval = 86400;
                                         // -------------------------------------------------------------------
                                         $wkday_p = 0;
                                         $wkend_p = 0;
                                         if (($tend_dt[$d][$t] > $tstart_dt[$d][$t]) && (($tstart_dt[$d][$t] <> 0) && ($tend_dt[$d][$t] <> 0))){
                                             $testingdays_p       =  round((($tend_dt[$d][$t] - $tstart_dt[$d][$t]) / 86400)+1,0);
                                             $basedt1             = $tstart_dt[$d][$t];
                                             for ($dts=1; $dts<=$testingdays_p; ++$dts) {
                                                   //print($dts);
                                                  $datval  = $basedt1 + (86400*$dts);
                                                  $newdate = (string)$datval; 
                                                  //print($newdate."<br>");
                                                  $dtday   = date("D",$newdate);
                                                  //echo $dtday;
                                                  if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                                                       $wkday_p = $wkday_p + 1;     
                                                  }     
                                                  if (($dtday == "Sat") || ($dtday == "Sun")){
                                                       $wkend_p = $wkend_p + 1;     
                                                  }     
                                             }
                                             //$days_p  = $testingdays_p." Planned days<br>( ".$wkday_p." Weekdays and ".$wkend_p." Weekend Days)";
                                             $tp_wkd[$d][$t]   = $wkday_p;
                                             $tp_wked[$d][$t]  = $wkend_p;
                                          } else {
                                           $testingdays_p       =  0;
                                           //$days_p              = "Set Planned Start and End Dates correctly";
                                         }
                                         // -------------------------------------------------------------------
                                         $wkday_a = 0;
                                         $wkend_a = 0;
                                         if ($tact_end_dt[$d][$t] > $tact_start_dt[$d][$t]){
                                             $testingdays_a       =  round((($tact_end_dt[$d][$t] - $tact_start_dt[$d][$t]) / 86400)+1,0);
                                             $basedt2             = $tact_start_dt[$d][$t];
                                              for ($dts=1; $dts<=$testingdays_a; ++$dts) {
                                                  $datval  = $basedt2 + (86400*$dts);
                                                  $newdate = (string)$datval; 
                                                  $dtday   = date("D",$newdate);
                                                  if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                                                       $wkday_a = $wkday_a + 1;     
                                                  }     
                                                  if (($dtday == "Sat") || ($dtday == "Sun")){
                                                       $wkend_a = $wkend_a + 1;     
                                                   }     
                                             }
                                         } else {
                                           $testingdays_a       =  0;
                                           //$days_a  = "Set Planned Start and End Dates correctly";
                                         }   

                                         if (($tact_wkd[$d][$t] == 0) && ($tact_wked[$d][$t] == 0)){
                                             $wkdaya = 0;
                                             $wkenda = 0;
                                             $usd    = "TBD";
                                         } else {
                                             if ($tact_wkd[$d][$t] == 0){
                                                 $wkdaysa = 0;
                                             } else {
                                                 $wkdaya = round(($tact_wkd[$d][$t] / $wkday_a),2)*100;
                                             }
                                             if ($tact_wked[$d][$t] == 0){
                                                 $wkenda = 0;
                                             } else { 
                                                 $wkenda = round(($tact_wked[$d][$t] / $wkend_a),2)*100;
                                             }
                                         }
                                         $ta_wkd[$d][$t]  = $wkday_a;
                                         $ta_wked[$d][$t] = $wkend_a;
                                             // --------------------------------------------------------------------------------------------------
                         }
                        }
                        // Heavyweight (when all records show up on the log)       
                               $xcd_issue_area     = $tissue_area[$d][$t];
                               $xcd_issue_created  = $tissue_created[$d][$t];
                               $xcd_start_dt       = $xstart_date[$d][$t];
                               $xcd_end_dt         = $xend_date[$d][$t];
                               $xcd_act_start_dt   = $xact_start_date[$d][$t];
                               $xcd_act_end_dt     = $xact_end_date[$d][$t];
                               $xcd_act_wkd        = $tact_wkd[$d][$t];
                               $xcd_act_wked       = $tact_wked[$d][$t];
                               $xcd_back_to_build  = $tback_to_build[$d][$t];
                               $xcd_test_iteration = $ttest_iteration[$d][$t];
                               //$xcd_updated_by     = $tupdated_by[$d][$t];
                               //$xcd_last_update    = $tlast_update[$d][$t];
                               $xcd_a_wkd          = $ta_wkd[$d][$t];
                               $xcd_a_wked         = $ta_wked[$d][$t];
                               $xcd_p_wkd          = $tp_wkd[$d][$t];
                               $xcd_p_wked         = $tp_wked[$d][$t];
                      }
                     } 
                     for ($d=1;$d<=$dcnt;++$d) {
                          // ========================= Select Execution Milstones & Iterations ===================== 
                          $query44 = " select a.execution_id,
                                              a.milestone_id,
                                              a.iteration_count
                                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b   
                                        where a.execution_id = $yexecution_id
                                          and a.milestone_id = b.milestone_id 
                                          and b.issue_area_id = '$did[$d]'
                                     ";
                          //print($query44);                        
                          $mysql_data44        = mysql_query($query44, $mysql_link) or die ("#16 Could not query: ".mysql_error());
                          $rowcnt44            = mysql_num_rows($mysql_data44);
                          $rwrk[$d]         = $rowcnt44;
                          //$eseq              = 0;
                          $total_baseline[$d]      = 0;
                          $total_incremental[$d]   = 0;
                          $percent_incremental[$d] = 0;
                          if ($rwrk[$d] <> 0){
                              while($row44 = mysql_fetch_row($mysql_data44)) {
                                    $ymilestone_id     = stripslashes($row44[1]);
                                    $yiteration_cnt    = stripslashes($row44[2]);
                                    // ========================= Select Execution Milstones & Iterations ===================== 
                                    for ($m=1;$m<=$mcnt; ++$m) {
                                         if ($ymilestone_id == $mid[$m]) {                                 
                                             //$ymilestone        = $mil[$m];
                                             $ymilestone_time   = $mit[$m];
                                             $ybaseline_time    = $ymilestone_time;
                                             $yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                                             $total_baseline[$d]    = $total_baseline[$d] + $ybaseline_time;
                                             $total_incremental[$d] = $total_incremental[$d] + $yincremental_time;
                                         }
                                    }      
                              }
                              $total_time[$d]          = round($total_baseline[$d] + $total_incremental[$d],2);
                              $percent_baseline[$d]    = round((($total_baseline[$d] / $total_baseline[$d]) * 100),2);
                              $percent_incremental[$d] = round((($total_incremental[$d] / $total_baseline[$d]) * 100),2);
                          } else {
                                   $total_baseline[$d]      = 0;
                                   $total_incremental[$d]   = 0;
                                   $percent_baseline[$d]    = 0;
                                   $percent_incremental[$d] = 0; 
                          }
                     }  
               }
            }
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             // =========================================================================================
             // ==================================== EXTRACT ISSUES =====================================
             // =========================================================================================
             // $pi                    indicates a given issue in the pdp
             // $pu                    indicates a given update in an issue
             // $picnt                 indicates the chronological sequence number of the issue in the given pdp
             // $pucnt                 indicates the chronological sequence number of a issue update in a given issue
             // $pitcnt                no of rows for a given issue_id in issue_surrogate table
             // $putcnt                no of rows for a given issue_history_id (for a given issue_id) in issue_surrogate table
             // piid[$picnt]           indicates issue_id of a issue in a given pdp
             // pidesc[$pcnt]          indicates description of the issue
             // pimax[$picnt]          indicates total of master and update rows for a given issue
             // puid[$picnt][$pucnt]   indicates issue_history_id of a given update for a given issue in a pdp
             // pudesc[$picnt][$pucnt] indicates description of a given update for a given issue in a pdp 
             // Declare Arrays
             // [picnt][i][lines]      stores root cause per issue and update (i.e. A 3 dimensional array)
             // [picnt]                Issue no. in a given PDP
             // [i]                    Seq in an absolute value icnt indicates total issues types (i.e. root causes)
             // [lines]                indicates sum of .....
             //                        master rows from issues table         (always 1, issue_surrogate.surrogate_type = 0) 
             //                        + 
             //                        updates rows from issue_history table (can be 1 or many, issue_surrogate.surrogate_type = 1) 
             $pi = array();
             for ($i=1;$i<=$icnt;++$i) {
                  $tcnt[$i] = 0;
                  for ($d=1;$d<=$dcnt;++$d) {
                       $dpti[$i][$d] = 0;
                  }
             }
             for ($d=1;$d<=$dcnt;++$d) {
                  $dptix[$d] = 0;
             }             
             // Find out How many Issues in this PDP
             $query80      = "select a.issue_id,a.issue_desc,a.created_by,a.created_on,b.issue_area
                                from ".$name.".issues a, issue_areas b
                               where a.pdp_id = '$xid' 
                                 and a.void   = 0
                                 and a.issue_area_id = b.issue_area_id
                            order by a.issue_id";
             $mysql_data80 = mysql_query($query80, $mysql_link) or die ("#17 Could not query: ".mysql_error());
             $rowcnt80     = mysql_num_rows($mysql_data80);
             $xjob_log   = $xjob_log.chr(10)."$picnt Valid issues identified for $xpdp_desc".chr(10);
             $xjob_log_y = "$rowcnt80 Valid issues identified for $xpdp_desc<br><br>"; 
             if ($rowcnt80 == 0) {
                  $picnt  = 0;
                  $bypass = 0;       //bypass = 1 if PDP wants to be displayed even with 0 issues
             } else {
               $picnt        = 0;
               $countdone_pi = 0;
               $countdone_pu = 0;
               while($row80  = mysql_fetch_row($mysql_data80)) {
                     $picnt          = $picnt + 1;
                     $piid[$picnt]   = stripslashes($row80[0]);  // PDP Issue_id found for this given PDP (A)
                     $pidesc[$picnt] = stripslashes($row80[1]);  // Issue Description
                     $picby[$picnt]  = stripslashes($row80[2]);
                     $picon[$picnt]  = stripslashes($row80[3]);
                     $pidpt[$picnt]  = stripslashes($row80[4]);
                     //$pidptx[$picnt] = 0;
                     $xd             = date("d",$picon[$picnt]);
                     $xm             = date("M",$picon[$picnt]);
                     $xy             = date("Y",$picon[$picnt]);
                     $pidt[$picnt]   = $xd."-".$xm."-".$xy;             
                     $piidx          = $piid[$picnt];            // Move (A) to a non-array variable
                     // Load Master Record
                     $line           = 1;
                     $query91        = "select a.issue_type_id,b.issue_type 
                                          from ".$name.".issue_surrogates a, issue_types b 
                                         where a.issue_surrogate_id = $piid[$picnt]
                                           and a.surrogate_type = 0
                                           and a.issue_type_id = b.issue_type_id
                                 ";
                     $mysql_data91   = mysql_query($query91, $mysql_link) or die ("#18 Could not query: ".mysql_error());
                     $rowcnt91       = mysql_num_rows($mysql_data91);
                     $pitcnt         = 0;
                     while($row91  = mysql_fetch_row($mysql_data91)) {
                           $pitcnt         = $pitcnt + 1;
                           $pitid[$pitcnt] = stripslashes($row91[0]);
                           $pityp[$pitcnt] = stripslashes($row91[1]);
                     }
                     // Query to Find out How Many Updates To this Issue
                     $query57      = " select a.issue_history_id,a.issue_note,a.issue_assignee,a.issue_note_dt,b.issue_area 
                                         from ".$name.".issue_history a, issue_areas b  
                                        where a.issue_id = $piid[$picnt]
                                          and a.issue_area_id = b.issue_area_id ";
                     $mysql_data57 = mysql_query($query57, $mysql_link) or die ("#19 Could not query: ".mysql_error());
                     $rowcnt57     = mysql_num_rows($mysql_data57);
                     $pimax[$picnt] = $line + $rowcnt57;  // Record that will be used in Analysis, Master line if no updates else the last update line
                     $piu           = $pimax[$picnt] - 1; // No. of updates
                     $pim           = $pimax[$picnt];     // Same as $pimax[$picnt] 
                     // Hash on Master Level
                     $countdone_pi = 0;
                     for ($i=1;$i<=$icnt ; ++$i) {
                          $pi[$picnt][$line][$i] = 0;
                          for ($pit=1;$pit<=$pitcnt ; ++$pit) {
                               if ($ityp[$i] == $pityp[$pit]){
                                   $pi[$picnt][$line][$i] = 1;
                                   if ($line == $pimax[$picnt]) {
                                       $totl      = $pi[$picnt][$line][$i];
                                       $tcnt[$i]  = $tcnt[$i] + 1;
                                       $tcnt0[$i] = $tcnt0[$i] + 1;
                                            for ($d=1;$d<=$dcnt;++$d) {
                                                 if ($dpt[$d] == $pidpt[$picnt]){
                                                     if ($irgrp[$i] == "NO"){
                                                         $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                     }
                                                     if ($irgrp[$i] <> "NO"){
                                                         $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                         if ($irgrp[$i] <> $ityp[$i]){
                                                             for ($i3=$i;$i3>=1;$i3=$i3-1) {
                                                                  if ($ityp[$i3] == $irgrp[$i]){
                                                                      $dpti[$i3][$d] = $dpti[$i3][$d] + 1;
                                                                  }
                                                             }
                                                         }
                                                     }
                                                 }
                                            } 
                                   } 
                               } else {
                               }
                          } 
                          $ypi = $pi[$picnt][$line][$i];
                     }
                     // Drill down into each update for this Issue using Query #19             
                     $pucnt = 0;   //counter for no. of updates for the given issue
                     while($row57  = mysql_fetch_row($mysql_data57)) {
                           $pucnt                      = $pucnt + 1;
                           $puid[$picnt][$pucnt+1]     = stripslashes($row57[0]);
                           $pudesc[$picnt][$pucnt+1]   = stripslashes($row57[1]);
                           $pucby[$picnt][$pucnt+1]    = stripslashes($row57[2]);    // changed from 80
                           $pucon[$picnt][$pucnt+1]    = stripslashes($row57[3]);    // changed from 80
                           $pudpt[$picnt][$pucnt+1]    = stripslashes($row57[4]);    // changed from 80
                           $yd                         = date("d",$pucon[$picnt][$pucnt+1]);
                           $ym                         = date("M",$pucon[$picnt][$pucnt+1]);
                           $yy                         = date("Y",$pucon[$picnt][$pucnt+1]);
                           $pudt[$picnt][$pucnt+1]     = $yd."-".$ym."-".$yy;
                           $wpu                        = $puid[$picnt][$pucnt+1];
                           $wdpt                       = $pudpt[$picnt][$pucnt+1];
                     }
                     // Loading Updates (if exists)
                     for ($pu=1;$pu<=$pucnt ; ++$pu) {
                          $line           = $line + 1;
                          $yid            = $puid[$picnt][$pu+1]; 
                          $query81        = "select a.issue_type_id,b.issue_type 
                                               from ".$name.".issue_surrogates a, issue_types b 
                                              where a.issue_surrogate_id = '$yid' 
                                                and a.surrogate_type = 1
                                                and a.issue_type_id = b.issue_type_id
                                            ";
                          $mysql_data81   = mysql_query($query81, $mysql_link) or die ("#20 Could not query: ".mysql_error());
                          $rowcnt81       = mysql_num_rows($mysql_data81);
                          $putcnt         = 0;
                          while($row81  = mysql_fetch_row($mysql_data81)) {
                                $putcnt         = $putcnt + 1;
                                $putid[$picnt][$putcnt] = stripslashes($row81[0]);
                                $putyp[$picnt][$putcnt] = stripslashes($row81[1]);
                          }
                          $w = $pu + 1;
                          $countdone_pu = 0;
                          for ($i=1;$i<=$icnt ; ++$i) {
                               $pi[$picnt][$line][$i] = 0;
                               for ($put=1;$put<=$putcnt ; ++$put) { 
                                    if ($ityp[$i] == $putyp[$picnt][$put]){
                                        $pi[$picnt][$line][$i] = 1;
                                        if ($line == $pimax[$picnt]) {
                                            $totl     = $pi[$picnt][$line][$i];
                                            $tcnt[$i] = $tcnt[$i] + 1;
                                            for ($d=1;$d<=$dcnt;++$d) {
                                                 if ($dpt[$d] == $pudpt[$picnt][$line]){
                                                     if ($irgrp[$i] == "NO"){
                                                         $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                     }
                                                     if ($irgrp[$i] <> "NO"){
                                                         $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                         if ($irgrp[$i] <> $ityp[$i]){
                                                             for ($i3=$i;$i3>=1;$i3=$i3-1) {
                                                                  if ($ityp[$i3] == $irgrp[$i]){
                                                                      $dpti[$i3][$d] = $dpti[$i3][$d] + 1;
                                                                  }
                                                             }
                                                         }
                                                     }
                                                 }
                                            } 
                                            //}
                                        }
                                    } else {
                                    }
                               }
                               $ypi = $pi[$picnt][$line][$i];
                          }
                     }                   
               }
               for ($i=1;$i<=$icnt ; ++$i) {
                  if ($iccd[$i] == "ROT") {
                       for ($i2=1;$i2<=$icnt ; ++$i2) {
                            if ($ipid[$i2] == $iid[$i]){
                                $tcnt[$i] = $tcnt[$i] + $tcnt[$i2];
                            }
                       }   
                  }
              }
              //for ($i=1;$i<=$icnt ; ++$i) {
              //}
              for ($i=1;$i<=$icnt ; ++$i) {
                    if (($iccd[$i] == "ROT") && ($igrp[$i] == 0)) {
                        $stotlr  = $stotlr + $tcnt[$i];
                    }
                    if (($iccd[$i] == "CNT") && ($igrp[$i] == 0)) {
                        $stotlc = $stotlc + $tcnt[$i];
                    }
               }
              }
              for ($i=1;$i<=$icnt ; ++$i) {
                  if ($igrp[$i] == 1){
                      for ($i2=1;$i2<=$icnt; ++$i2) {
                           //if ($iccd[$i] == $iccd[$i2]) {
                           if ((trim($ityp[$i]) == trim($irgrp[$i2])) && ($igrp[$i2] == 0) && $iccd[$i] == "CNT"){
                                $tcnt[$i]  = $tcnt[$i] + $tcnt[$i2];  
                           }
                           //} 
                      }
                  }
              }             

             if ($bypass == 0){
                 $query103 = "INSERT into ".$name.".tgt_pdp_main(
                                                               etl_id,
                                                               pdp,
                                                               pdp_desc,
                                                               pdp_owner,
                                                               pdp_type,
                                                               pdp_status,
                                                               pdp_launch,
                                                               parent_pdp,
                                                               main_pdp,
                                                               pdp_category,
                                                               scoping,
                                                               complexity_factor,
                                                               revenue_factor,
                                                               customer_factor,
                                                               past_factor,
                                                               bills_run,
                                                               invoices_generated,
                                                               ppw_changes,
                                                               launch_in_jeopardy,
                                                               issues_created,
															   lob
                                                              )
                              VALUES('$xetl_id',
                                     '$xpdp_desc',
                                     '$xpdp_name',
                                     '$xpdp_owner',
                                     '$xpdp_period',
                                     '$xpdp_status',
                                     '$xdate',
                                     '$xparent_pdp_desc',
                                     '$xmain_pdp_desc',
                                     '$xcategory',
                                     '$xscoping',
                                     '$xcomplexity',
                                     '$xrevenue',
                                     '$xprojection',
                                     '$xpast',
                                     '$ybillrun_cnt',
                                     '$yinvoice_cnt',
                                     '$yppw_update',
                                     '$ylaunch',
                                     '$xissues_created',
									 '$xlob'
                  )";
                 //print($query103);
                 $mysql_data103 = mysql_query($query103, $mysql_link) or die ("#21 Could not query: ".mysql_error($mysql_link));
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #1 tgt_pdp_main rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = '$ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.99 Could not query: ".mysql_error());
                 }
                 for ($b=1;$b<=$y ; ++$b) {
                      $query102 = "INSERT into ".$name.".tgt_pdp_testing(etl_id,pdp,short_desc,tested,department)
                                   VALUES('$xetl_id','$xpdp_desc','$ydsc[$b]','$ytind[$b]','$ydpt[$b]')";
                      //print($query104."<br>");             
                      $mysql_data102 = mysql_query($query102, $mysql_link) or die ("#22 Could not query: ".mysql_error($mysql_link));
                      //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
                 }
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #2 tgt_pdp_tested rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = '$ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.1 Could not query: ".mysql_error());
                  //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link));
                 }
                 for ($i=1;$i<=$icnt; ++$i) {
                      if ($tcnt[$i] == 0) {
                      } else { 
                           $query104 = "INSERT into ".$name.".tgt_pdp_issue_summary(etl_id,pdp,issue_type,occurance,issue_class,report_group,group_used)
                                        VALUES('$xetl_id','$xpdp_desc','$ityp[$i]','$tcnt[$i]','$iccd[$i]','$irgrp[$i]','$igrp[$i]')";
                           //print($query104."<br>");             
                           $mysql_data104 = mysql_query($query104, $mysql_link) or die ("#23 Could not query: ".mysql_error());
                      }
                 }
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #3 tgt_pdp_issue_summary rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = '$ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.1 Could not query: ".mysql_error());
                  //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link));
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                  for ($i=1;$i<=$icnt;++$i) {
                      $xdpti = $dpti[$i][$d]; 
                      if ($xdpti == 0) {
                      } else {                  
                              $query105 = "INSERT into ".$name.".tgt_pdp_issue_area_summary(etl_id,pdp,issue_area,found_issues,issue_type)
                                           VALUES('$xetl_id','$xpdp_desc','$dpt[$d]','$xdpti','$ityp[$i]')";
                              //print($query105."<br>");             
                              $mysql_data105 = mysql_query($query105, $mysql_link) or die ("#23.5 Could not query: ".mysql_error());
                      }
                  }
                 }
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #4 tgt_pdp_issue_area_summary rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = '$ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.1 Could not query: ".mysql_error());
                  //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link));
                 }
                 for ($d=1;$d<=$dcnt; ++$d) {
                      $itcnt = 0;
                      if ($dsc[$d] == "MO" or  $dsc[$d] == "UAT") {
                              $itcnt                  = 1;
                      } else {
                              $itcnt                  = 2;
                      } 

                      for ($t=1;$t<=$itcnt ; ++$t) {                       
                           $xcd_issue_area     = $tissue_area[$d][$t];
                           $xcd_issue_created  = $tissue_created[$d][$t];
                           //print("xcd_issue_created: ".$xcd_issue_created."<br>");
                           $xcd_start_dt       = $xstart_date[$d][$t];
                           $xcd_end_dt         = $xend_date[$d][$t];
                           $xcd_act_start_dt   = $xact_start_date[$d][$t];
                           $xcd_act_end_dt     = $xact_end_date[$d][$t];
                           $xcd_act_wkd        = $tact_wkd[$d][$t];
                           $xcd_act_wked       = $tact_wked[$d][$t];
                           $xcd_back_to_build  = $tback_to_build[$d][$t];
                           $xcd_test_iteration = $ttest_iteration[$d][$t];
                           //$xcd_updated_by     = $tupdated_by[$d][$t];
                           //$xcd_last_update    = $tlast_update[$d][$t];
                           $xcd_a_wkd          = $ta_wkd[$d][$t];
                           $xcd_a_wked         = $ta_wked[$d][$t];
                           $xcd_p_wkd          = $tp_wkd[$d][$t];
                           $xcd_p_wked         = $tp_wked[$d][$t];
                           $query125 = "INSERT into ".$name.".tgt_pdp_area_execution(
                                                                                     etl_id,
                                                                                     pdp,
                                                                                     issue_area,
                                                                                     issue_count,
                                                                                     testing_start_date,
                                                                                     testing_end_date,
                                                                                     actual_start_date,
                                                                                     actual_end_date,
                                                                                     utilized_wkd,
                                                                                     utilized_wked,
                                                                                     back_to_build,
                                                                                     test_iteration,
                                                                                     planned_wkd,
                                                                                     planned_wked,
                                                                                     actual_available_wkd,
                                                                                     actual_available_wked
                                                                                    )
                                        VALUES(
                                               '$xetl_id',
                                               '$xpdp_desc',
                                               '$xcd_issue_area',
                                               '$xcd_issue_created',
                                               '$xcd_start_dt',
                                               '$xcd_end_dt',
                                               '$xcd_act_start_dt',
                                               '$xcd_act_end_dt',
                                               '$xcd_act_wkd',  
                                               '$xcd_act_wked', 
                                               '$xcd_back_to_build',
                                               '$xcd_test_iteration',
                                               '$xcd_p_wkd', 
                                               '$xcd_p_wked',
                                               '$xcd_a_wkd', 
                                               '$xcd_a_wked'
                          )";
                          //print($query125."<br>");             
                          $mysql_data125 = mysql_query($query125, $mysql_link) or die ("#23.6 Could not query: ".mysql_error($mysql_link));
                          //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
                      }
                           $query126 = "INSERT into ".$name.".tgt_pdp_area_work_effort(
                                                                                     etl_id,
                                                                                     pdp,
                                                                                     issue_area,
                                                                                     baseline_hours ,
                                                                                     rework_hours,
                                                                                     percentage_rework,
                                                                                     percentage_baseline
                                                                                    )
                                        VALUES(
                                               '$xetl_id',
                                               '$xpdp_desc',
                                               '$dpt[$d]',
                                               '$total_baseline[$d]',
                                               '$total_incremental[$d]',
                                               '$percent_incremental[$d]',
                                               '$percent_baseline[$d]'
                                              )";
                          //print($query126."<br>");             
                          $mysql_data125 = mysql_query($query126, $mysql_link) or die ("#23.7 Could not query: ".mysql_error($mysql_link));
                          //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
                 }
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #5 tgt_pdp_area_execution rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = '$ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.2 Could not query: ".mysql_error());
                 }
                 if ($seq == $rowcntx){
                  $yw         = date("D");
                  $yd         = date("d");
                  $ym         = date("m");
                  $yy         = date("Y");
                  $yt         = date("H:i:s T");
                  $yt2        = date("HisT");
                  $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
                  $ym         = date("M");
                  $ydate      = $yw." ".$yd."-".$ym."-".$yy;
                  $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
                  $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
                  $ynote      = $ynote."<br>".$ydate2."  -  #6 tgt_pdp_area_work_effort rows inserted";
                  $query113 = "UPDATE ".$name.".etl_batches
                                  SET ran_by     = '$usr', 
                                      etl_status = ' $ynote'
                                WHERE etl_id = '$xetl_id' ";
                  $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.3-4 Could not query: ".mysql_error($mysql_link));
                  //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link));
                 }
		         $mysql_data7 = mysql_query($query7, $mysql_link);              		      
                 $query112      = "UPDATE ".$name.".pdp
                                      SET etl_check = 0 
                                    WHERE pdp_desc = '$xpdp_desc' ";
                 //print("<br>".$query112);  
                 $mysql_data112 = mysql_query($query112, $mysql_link) or die ("#24 Could not query: ".mysql_error());

                 unset($tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval,$ytotl,$stotlr,$stotlc,$prtotlr,$prtotlc,$rtotl,$picby,$picon,$picdt,$pucby,$pucon,$pudt,$pucon,$pudt,$pucon,$pudt);
             }
       }
       for ($i=1;$i<=$icnt; ++$i) {
            $query304 = "INSERT into ".$name.".tgt_report_groups(etl_id,issue_type,issue_class,report_group,group_used,parent_issue_type)
                         VALUES('$xetl_id','$ityp[$i]','$iccd[$i]','$irgrp[$i]','$igrp[$i]','$pityp[$i]')";
            //print($query304."<br>");             
            $mysql_data304 = mysql_query($query304, $mysql_link) or die ("#23.1 Could not query: ".mysql_error($mysql_link));
            //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
       }
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #7 tgt_report_groups rows inserted";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.5 Could not query: ".mysql_error());
       }
       for ($d=1;$d<=$dcnt;++$d) {
            $query305 = "INSERT into ".$name.".tgt_areas(etl_id,issue_area,short_code,iterations)
                         VALUES('$xetl_id','$dpt[$d]','$dsc[$d]','$dit[$d]')";
            //print($query305."<br>");             
            $mysql_data305 = mysql_query($query305, $mysql_link) or die ("#23.6 Could not query: ".mysql_error($mysql_link));
            //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
       }
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #8 tgt_areas rows inserted";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.6 Could not query: ".mysql_error());
       }

       /////////////////////////////////////////////////////////////////////////////////////////////////////
       /////////////////////////////////////////////////////////////////////////////////////////////////////
       $tbl[1][1] = "tgt_pdp_main";
       $tbl[1][2] = 3;
       $idx[1][1] = "index_tgt_pdp_main_1";
       $kee[1][1] = "pdp";
       $idx[1][2] = "index_tgt_pdp_main_2";
       $kee[1][2] = "etl_id".","."pdp";
       $idx[1][3] = "index_tgt_pdp_main_3";
       $kee[1][3] = "etl_id".","."pdp".","."lob";
                      
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

       //$tbl[9][1] = "tgt_ytd_main";
       //$tbl[9][2] = 4;
       //$idx[9][1] = "index_tgt_ytd_main_1";
       //$kee[9][1] = "pdp_type";
       //$idx[9][2] = "index_tgt_ytd_main_2";
       //$kee[9][2] = "etl_id".","."pdp_type";
       //$idx[9][3] = "index_tgt_ytd_main_3";
       //$kee[9][3] = "etl_id".","."pdp_type".","."ytd_year";
       //$idx[9][4] = "index_tgt_ytd_main_4";
       //$kee[9][4] = "pdp_type".","."ytd_year";

       //$tbl[10][1] = "tgt_root_cause_ytd";
       //$tbl[10][2] = 4;
       //$idx[10][1] = "index_tgt_root_cause_ytd_1";
       //$kee[10][1] = "issue_type";
       //$idx[10][2] = "index_tgt_root_cause_ytd_2";
       //$kee[10][2] = "etl_id".","."issue_type";
       //$idx[10][3] = "index_tgt_root_cause_ytd_3";
       //$kee[10][3] = "etl_id".","."issue_type".","."etl_year";
       //$idx[10][4] = "index_tgt_root_cause_ytd_4";
       //$kee[10][4] = "issue_type".","."etl_year";

       //$tbl[11][1] = "tgt_rework_hours_ytd";
       //$tbl[11][2] = 4;
       //$idx[11][1] = "index_tgt_rework_hours_ytd_1";
       //$kee[11][1] = "area";
       //$idx[11][2] = "index_tgt_rework_hours_ytd_2";
       //$kee[11][2] = "etl_id".","."area";
       //$idx[11][3] = "index_tgt_rework_hours_ytd_3";
       //$kee[11][3] = "etl_id".","."area".","."etl_year";
       //$idx[11][4] = "index_tgt_rework_hours_ytd_4";
       //$kee[11][4] = "area".","."etl_year";

       //$tbl[12][1] = "tgt_back_to_build_ytd";
       //$tbl[12][2] = 4;
       //$idx[12][1] = "index_tgt_back_to_build_ytd_1";
       //$kee[12][1] = "area";
       //$idx[12][2] = "index_tgt_back_to_build_ytd_2";
       //$kee[12][2] = "etl_id".","."area";
       //$idx[12][3] = "index_tgt_back_to_build_ytd_3";
       //$kee[12][3] = "etl_id".","."area".","."etl_year";
       //$idx[12][4] = "index_tgt_back_to_build_ytd_4";
       //$kee[12][4] = "area".","."etl_year";

       //print("Start of Rebuilding Indexes<br>");
       for ($x=1;$x<=8;++$x) {
            $tbl_name  = $tbl[$x][1];
            $idx_count = $tbl[$x][2];
            //print("<br>".$x." - ".$tbl_name."<br>".$idx_count."<br>");
            for ($y=1;$y<=$idx_count;++$y) {
                 $idx_name = $idx[$x][$y];
                 $idx_key  = $kee[$x][$y];
                 $query = "ALTER TABLE ".$name.".$tbl_name DROP INDEX $idx_name" ;
                 $mysql_data = mysql_query($query, $mysql_link); // or die ("Drop Index #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name dropped for $tbl_name<br>");
                 $query = "ALTER TABLE ".$name.".$tbl_name ADD INDEX $idx_name ($idx_key)" ;
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Indexing #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name rebuilt for $tbl_name<br>");
            }
       }
       ////////////////////////////////////////////////////////////////////////////////////////////////////
       /////////////////////////////////////////////////////////////////////////////////////////////////////


       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //print("<br><br>End of ETL");
       //$xreport_contents = ob_get_clean();
       //$xreport_path = $xreport_pth.$xreport_nam;
       //$f = fopen($xreport_path, "w");
       //fwrite($f, $xreport_contents);
       //fclose($f);
       //ob_end_clean();
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //-- SELECT a.etl_id,a.pdp,a.pdp_type,b.short_desc,b.tested,a.scoping,issues_created
       //SELECT a.etl_id,a.pdp_type,count(*),sum(a.issues_created)
       //  FROM tgt_pdp_main a, tgt_pdp_testing b
       // where a.etl_id in (select etl_id from etl_batches where etl_year = 2010)
       //   and a.pdp = b.pdp and b.short_desc = 'UAT'
       //   and (   (b.tested = 'YES')
       //        or (b.tested = 'NO' and a.scoping = 'IN SCOPE')
       //       )
       //   -- and pdp_type = 'ADDENDUM'
       //group by a.etl_id,a.pdp_type       for ($ptyp=1;$ptyp<=$pdp_prd_cnt;++$ptyp) {
       for ($ptyp=1;$ptyp<=$pdp_prd_cnt;++$ptyp) {
            // IN 
            $query399 = "SELECT a.etl_id,a.pdp_type,count(*),sum(a.issues_created)
                           FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b
                          WHERE a.etl_id in (select etl_id from etl_batches where etl_year = '$etl_year' )
                            AND a.pdp         = b.pdp 
                            AND b.short_desc  = 'UAT'
                            AND (   (b.tested = 'YES')
                                 OR (b.tested = 'NO' AND a.scoping = 'IN SCOPE')
                                 )
                            AND pdp_type = '$pdp_prd[$ptyp]' 
                       GROUP BY a.pdp_type
                       ";
            //print($query399."<br>");           
            $mysql_data399 = mysql_query($query399, $mysql_link) or die ("#399 Could not query: ".mysql_error($mysql_link));
            $rowcnt399     = mysql_num_rows($mysql_data399);
            if ($rowcnt399 == 0){
                    $ytd_ptyp_cnt_in = 0;
                    $ytd_issus_in    = 0;
            } else { 
              while($row399 = mysql_fetch_row($mysql_data399)) {
                    //$ytd_etl_id      = stripslashes($row399[0]);   
                    $ytd_ptyp_cnt_in = stripslashes($row399[2]);
                    $ytd_issus_in    = stripslashes($row399[3]);
              }  
            }                       
            // OUT
            $query400 = "SELECT a.etl_id,a.pdp_type,count(*),sum(a.issues_created)
                           FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b
                          WHERE a.etl_id in (select etl_id from etl_batches where etl_year = '$etl_year' )
                            AND a.pdp        = b.pdp 
                            AND b.short_desc = 'UAT'
                            AND (b.tested    = 'NO' AND a.scoping in ('OUT OF SCOPE','NOT SET')) 
                            AND pdp_type     = '$pdp_prd[$ptyp]'
                       GROUP BY a.pdp_type
                       ";
            //print($query400."<br>");           
            $mysql_data400 = mysql_query($query400, $mysql_link) or die ("#400 Could not query: ".mysql_error($mysql_link));
            $rowcnt400     = mysql_num_rows($mysql_data400);
            if ($rowcnt400 == 0){
                    $ytd_ptyp_cnt_out = 0;
                    $ytd_issus_out    = 0;
            } else { 
              while($row400 = mysql_fetch_row($mysql_data400)) {
                    //$ytd_etl_id      = stripslashes($row399[0]);   
                    $ytd_ptyp_cnt_out = stripslashes($row400[2]);
                    $ytd_issus_out    = stripslashes($row400[3]);
              }  
            }                       
            $query401 = "INSERT into ".$name.".tgt_ytd_main(etl_id,pdp_type,ytd_count_in,ytd_count_out,ytd_count_issues_in,ytd_count_issues_out,ytd_year)
                         VALUES('$xetl_id','$pdp_prd[$ptyp]',$ytd_ptyp_cnt_in,$ytd_ptyp_cnt_out,$ytd_issus_in,$ytd_issus_out,$etl_year)";
            //print($query401."<br>");             
            $mysql_data401 = mysql_query($query401, $mysql_link) or die ("#401 Could not query: ".mysql_error($mysql_link));
            //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #9 tgt_ytd_main created for $etl_year";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id     = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.51 Could not query: ".mysql_error());
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       for ($i=1;$i<=$icnt;++$i) {
            if ($iccd[$i] == "ROT"){
                $query398 = "SELECT issue_type,sum(occurance)
                               FROM ".$name.".tgt_pdp_issue_summary 
                              WHERE issue_class = 'ROT'
                                AND etl_id in (select etl_id from etl_batches where etl_year = '$etl_year' )
                                AND issue_type = '$ityp[$i]'
                           GROUP BY issue_type 
                           ";
                //print($query398."<br>");           
                $mysql_data398 = mysql_query($query398, $mysql_link) or die ("#398 Could not query: ".mysql_error($mysql_link));
                $rowcnt398     = mysql_num_rows($mysql_data398);
                if ($rowcnt398 == 0){
                        $ytd_issue_type = $ityp[$i];
                        $ytd_occurance  = 0;
                } else { 
                  while($row398 = mysql_fetch_row($mysql_data398)) {
                        $ytd_issue_type = stripslashes($row398[0]);
                        $ytd_occurance  = stripslashes($row398[1]);
                  }  
                }                       
                $query402 = "INSERT into ".$name.".tgt_root_cause_ytd(etl_id,issue_type,ytd_count,etl_year)
                             VALUES('$xetl_id','$ityp[$i]',$ytd_occurance,$etl_year)";
                //print($query402."<br>");             
                $mysql_data402 = mysql_query($query402, $mysql_link) or die ("#402 Could not query: ".mysql_error($mysql_link));
                //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
            }
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #10 tgt_root_cause_ytd created for $etl_year";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id     = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.52 Could not query: ".mysql_error());
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       for ($d=1;$d<=$dcnt;++$d) {
                $query397 = "SELECT issue_area,sum(back_to_build)
                               FROM ".$name.".tgt_pdp_area_execution  
                              WHERE etl_id in (select etl_id from etl_batches where etl_year = '$etl_year' )
                                AND issue_area = '$dpt[$d]'
                           GROUP BY issue_area 
                           ";
                //print($query397."<br>");           
                $mysql_data397 = mysql_query($query397, $mysql_link) or die ("#397 Could not query: ".mysql_error($mysql_link));
                $rowcnt397     = mysql_num_rows($mysql_data397);
                if ($rowcnt397 == 0){
                        $ytd_issue_area = $dpt[$d];
                        $ytd_back2build = 0;
                } else { 
                  while($row397 = mysql_fetch_row($mysql_data397)) {
                        $ytd_issue_area = stripslashes($row397[0]);
                        $ytd_back2build = stripslashes($row397[1]);
                  }  
                }                       
            $query403 = "INSERT into ".$name.".tgt_back_to_build_ytd(etl_id,area,ytd_count,etl_year)
                         VALUES('$xetl_id','$dpt[$d]',$ytd_back2build,$etl_year)";
            //print($query403."<br>");             
            $mysql_data403 = mysql_query($query403, $mysql_link) or die ("#403 Could not query: ".mysql_error($mysql_link));
            //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #11 tgt_back_to_build_ytd created for $etl_year";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id     = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.53 Could not query: ".mysql_error());
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       for ($d=1;$d<=$dcnt;++$d) {
                $query396 = "SELECT issue_area,sum(baseline_hours),sum(rework_hours)
                               FROM ".$name.".tgt_pdp_area_work_effort  
                              WHERE etl_id in (select etl_id from etl_batches where etl_year = '$etl_year' )
                                AND issue_area = '$dpt[$d]'
                           GROUP BY issue_area 
                           ";
                //print($query396."<br>");           
                $mysql_data396 = mysql_query($query396, $mysql_link) or die ("#396 Could not query: ".mysql_error($mysql_link));
                $rowcnt396     = mysql_num_rows($mysql_data396);
                if ($rowcnt396 == 0){
                        $ytd_issue_area   = $dpt[$d];
                        $ytd_baseline_hrs = 0;
                        $ytd_rework_hrs   = 0;
                } else { 
                  while($row396 = mysql_fetch_row($mysql_data396)) {
                        $ytd_issue_area   = stripslashes($row396[0]);
                        $ytd_baseline_hrs = stripslashes($row396[1]);
                        $ytd_rework_hrs   = stripslashes($row396[2]);
                  }  
                }                       
            $query404 = "INSERT into ".$name.".tgt_rework_hours_ytd(etl_id,area,ytd_count_base,ytd_count_rework,etl_year)
                         VALUES('$xetl_id','$dpt[$d]',$ytd_baseline_hrs,$ytd_rework_hrs,$etl_year)";
            //print($query404."<br>");             
            $mysql_data404 = mysql_query($query404, $mysql_link) or die ("#404 Could not query: ".mysql_error($mysql_link));
            //print(mysql_errno($mysql_link)." : ".mysql_error($mysql_link)."<br>");
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  #12 tgt_rework_hours_ytd created for $etl_year";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id     = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.54 Could not query: ".mysql_error());
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       

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
       for ($x=9;$x<=12;$x=$x+1) {
            $tbl_name  = $tbl[$x][1];
            $idx_count = $tbl[$x][2];
            //print("<br>".$x." - ".$tbl_name."<br>".$idx_count."<br>");
            for ($y=1;$y<=$idx_count;++$y) {
                 $idx_name = $idx[$x][$y];
                 $idx_key  = $kee[$x][$y];
                 $query = "ALTER TABLE ".$name.".$tbl_name DROP INDEX $idx_name" ;
                 $mysql_data = mysql_query($query, $mysql_link); // or die ("Drop Index #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name dropped for $tbl_name<br>");
                 $query = "ALTER TABLE ".$name.".$tbl_name ADD INDEX $idx_name ($idx_key)" ;
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Indexing #$x."-".$y Could not query: ".mysql_error());
                 //print("$idx_name rebuilt for $tbl_name<br>");
            }
       }
       ////////////////////////////////////////////////////////////////////////////////////////////////////
       /////////////////////////////////////////////////////////////////////////////////////////////////////



       if ($seq == $rowcntx){
        $yw         = date("D");
        $yd         = date("d");
        $ym         = date("m");
        $yy         = date("Y");
        $yt         = date("H:i:s T");
        $yt2        = date("HisT");
        $yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
        $ym         = date("M");
        $ydate      = $yw." ".$yd."-".$ym."-".$yy;
        $ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
        $ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
        $ynote      = $ynote."<br>".$ydate2."  -  ETL Process Completed";
        $query113 = "UPDATE ".$name.".etl_batches
                        SET ran_by     = '$usr', 
                            etl_status = '$ynote'
                      WHERE etl_id = '$xetl_id' ";
        $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#99.99 Could not query: ".mysql_error());
       }
       $found = 1;
   }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////



// START OF REPORT
// CONTROL VARIABLES
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
// ==============================
// Getting user for this sessrion
//session_start();
//$xsession = session_id();
//$querys5 = "SELECT user FROM ".$name.".sessions
//             WHERE sessionid = trim('$xsession')" ;
////print($querys5);
//$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#21 Could not query: ".mysql_error());
//while ($row5 = mysql_fetch_row($mysql_data5)) {
//       $usr  = stripslashes($row5[0]);
//       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),b.short_desc,u.user_type
//                     FROM ".$name.".users a, ".$name.".issue_areas b, ".$name.".user_types u   
//                    WHERE trim(a.lanid) = '$usr' 
//                      AND a.issue_area_id = b.issue_area_id 
//                      AND a.user_type_id = u.user_type_id
//                    group by b.issue_area_id";
//       //print($querys6);             
//       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#22 Could not query: ".mysql_error());                    
//       while ($row6 = mysql_fetch_row($mysql_data6)) {
//              $uissue_area_id  = stripslashes($row6[0]); 
//              $uissue_area     = stripslashes($row6[1]);
//              $ushort_desc     = stripslashes($row6[2]);
//              $uuser_type      = stripslashes($row6[3]);
//              //print($yissue_area_id);
//      }         
//}
// ==============================

$h_dpt[1] = 'REVENUE ASSURANCE';
$h_dpt[2] = 'ENTERPRISE UAT';

// setting up today's date
$yw         = date("D");
$yd         = date("d");
$ym         = date("m");
$yy         = date("Y");
$yt         = date("H:i:s T");
$yt2        = date("HisT");
$yt3        = date("H-i-s-T");  
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt3;
$xreport_pth = "./reports/";
$xreport_nam = "PDP_UAT_REPORT-".$ydate3.".htm";
//print ($reportname); 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////









// HTML START
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
$hstart = "<html>
            <head>
             <style>
                 body    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px; 
                         }
                   th    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                           color: #FFFFFF;
                           border: 1px solid #CCCCCC; 
                           /*border-style:solid;
                           border-color:#CCCCCC;*/
                         }
                   td    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                           color: #FFFFFF;
                           border: 1px solid #CCCCCC; 
                           /*border-style:solid;
                           border-color:#CCCCCC;*/
                         }
             textarea    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                         }        
              /*caption    { background:#FFC000; color:#0000FF; font-size:1em;}*/
                 caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 24px; font-weight: bold;}       
                input    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                         }
               select    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                         }                   
               #content
                         { top:0%;
                           width: 100%; height: 100%; background: #FFFFF0;
                           /*border: 1px solid; border-color:#BDBDBD;*/
                         }
               /*#contentb { top:0%;
                           width: 100%; height: 1%;*/ /*background: #CEE3F6;*/
                         /*}
               #contentc { top:0%;
                           width: 100%; height: 34%;*/ /*background: #CEF6E3;*/
                           /*border: 1px solid; border-color:#BDBDBD;
                         }*/
               #content a:link 
                         { text-decoration: none;
                           color: #2554C7;
                         }
               #content a:visited 
                         {
                           text-decoration: none;
                           color: #2554C7;
                         }
               #content a:hover 
                         { text-decoration: underline overline;
                           color: #2554C7;
                         }
               #content a:active 
                         {
                           text-decoration: none;
                           color: #2554C7;
                         }
               a:link   {
                           font-family: Calibri, Helvetica, sans-serif;
                               text-decoration: none;
                           color: #330099;
                         }
                a:visited 
                         {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: none;
                           color: #FF0000;
                         }
                a:hover  {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: underline overline;
                           color: #330099;
                         }
                a:active {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: none;
                           color: #330099;
                         }
                .cont{ overflow:auto }
                .cont2{ overflow:auto }
                .wrapper2{width: 100%; height: 75%; background-color: #FFFFFF; overflow-x: scroll; overflow-y:scroll; }
                /*.div2 {width:100%; height: 75%; background-color: #FFFFFF; overflow-x: scroll; overflow-y:scroll;}*/
             </style>       
             <script type=\"text/javascript\">
                     function PopupCenter(pageURL, title,w,h)
                      {
                        w = window.screen.availWidth;
                        h = window.screen.availHeight;
                        var left = (screen.width/2)-(w/2);
                        var top = (screen.height/2)-(h/2);
                        var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                      }
             </script>
       
             <script type=\"text/javascript\">
                    function popup(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname5', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>

             <script type=\"text/javascript\">
              var rowVisible = true;
              function toggleDisplay(tbl) {
               var tblRows = tbl.rows;
               for (i = 0; i < tblRows.length; i++) {
                if (tblRows[i].className != \"headerRow\") {
                    tblRows[i].style.display = (rowVisible) ? \"none\" : \"\";
                }
               }
               rowVisible = !rowVisible;
              }
             </script>
            </head>
            <body>
    "; 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////








// REPORT LOGIC START
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
if ($start == 1) {
   // ------------------------------------------------------------------------------------------------------------ //
   ob_start();
   print($hstart);
   // ------------------------------------------------------------------------------------------------------------ //


   $querysa1 = "ALTER TABLE ".$name.".issue_surrogates ENGINE='InnoDB'" ;
   $mysql_dataa1 = mysql_query($querysa1, $mysql_link) or die ("#a1 Could not query: ".mysql_error());




   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // ============================== ISSUE AREA START ==============================
   //print("AREAS<br>");
   $query96                = "select distinct issue_area
                                from ".$name.".tgt_areas
                               where etl_id = '$yetl_id'
                            order by issue_area asc"; 
   $mysql_data96           = mysql_query($query96, $mysql_link) or die ("#2.1 Could not query: ".mysql_error());
   $rowcnt96               = mysql_num_rows($mysql_data96);
   //print($query96."<br>"); 
   $dcnt2                  = 0;
   while($row96            = mysql_fetch_row($mysql_data96)) {
         $dcnt2            = $dcnt2 + 1;
         $darea[$dcnt2]    = stripslashes($row96[0]);  //issue_area
         $disuecnt[$dcnt2] = 0;
         //print($dcnt2." - ".$darea[$dcnt2]."<br>");
   }
   // =============================== ISSUE AREA END ===============================



   // ============================= PDP TESTING START ==============================
   $query70               = "select distinct issue_area,short_code
                               from ".$name.".tgt_areas
                              where etl_id = '$yetl_id'  
                           order by issue_area asc"; 
                           //where etl_id = '$yetl_id'
   //print($query70."<br>");                        
   $mysql_data70          = mysql_query($query70, $mysql_link) or die ("#2.5 Could not query: ".mysql_error());
   $rowcnt70              = mysql_num_rows($mysql_data70); 
   $dcnt                  = 0;
   while($row70           = mysql_fetch_row($mysql_data70)) {
         $dcnt            = $dcnt + 1;
         $dpt[$dcnt]      = stripslashes($row70[0]);        //department
         $dsc[$dcnt]      = trim(stripslashes($row70[1]));  //department short description
         //print($dcnt." - ".$dpt[$dcnt]." - ".$dsc[$dcnt]."<br>");
   }
   //print("Total Departments: ".$dcnt."<br>");
   // ============================== PDP TESTING END ===============================


   // ===================== APPLYING THE FILTERS ====================
   // 0 means filtered
   // 1 means not filtered
   //print($prd."<br>".$pdpcat."<br>");
   $fltr1 = 0;     // pdp_type
   $fltr2 = 0;     // RA_IND
   $fltr3 = 0;     // pdp_category
   $fltr4 = 0;     // Date
   if ($prd == "ALL") {
       $fltr1 = 1; 
   }
   if ($ra_ind == "BOTH") {
       $fltr2 = 1; 
   }
   if ($pdpcat == "ALL") {
       $fltr3 = 1; 
   } 
   //print($prd."<br>".$fltr1."<br>");  
   //print($pdpcat."<br>".$fltr3."<br>");
   // setting up today's date
   $newd  = date("d");   //day
   $newm  = date("m");   //month
   $newy  = date("Y");   //year
   // 30 days from today
   $new_dt = mktime(0,0,0,$newm,$newd,$newy) + (60*60*24*30);
   $newd  = date("d",$new_dt);   //day
   $newm  = date("m",$new_dt);   //month
   $newy  = date("Y",$new_dt);   //year
   $today_dt = $newy."-".$newm."-".$newd;
   //print("Today's date :".$today_dt."<br>"); 
   $fromdt = mktime(0,0,0,$xms,$xds,$xys);
   $todate = mktime(0,0,0,$xme,$xde,$xye);
   if (($fromdt == $todate) && ($fromdt == 1283313600)){
        $xldate  = "2010-09-01";
        $xldate2 = $today_dt;
   }
   if ($fromdt <> $todate){
    if ($fromdt == 1283313600){
        $xldate = "2010-09-01";
    } else {
       if (strlen($xds) == 1){
           $xds = "0".$xds;
       } 
       if (strlen($xms) == 1){
           $xms = "0".$xms;
       }
       $xldate = $xys."-".$xms."-".$xds;
    }
    if ($todate > $fromdt){    
       if (strlen($xde) == 1){
           $xde = "0".$xde;
       } 
       if (strlen($xme) == 1){
           $xme = "0".$xme;
       }
       $xldate2 = $xye."-".$xme."-".$xde;
    } else {
       $xldate2 = $xldate;
    }   
   } 
   if (($fromdt == $todate) && ($fromdt <> 1283313600)){
       if (strlen($xds) == 1){
           $xds = "0".$xds;
       } 
       if (strlen($xms) == 1){
           $xms = "0".$xms;
       }
       $xldate = $xys."-".$xms."-".$xds;
       if (strlen($xde) == 1){
           $xde = "0".$xde;
       } 
       if (strlen($xme) == 1){
           $xme = "0".$xme;
       }
       $xldate2 = $xye."-".$xme."-".$xde;
   }

   //print($xds."<br>");
   //print($xms."<br>");
   
   //print($xys."<br>"); 
   //print("From Date: ".$xldate."<br>"."To Date: ".$xldate2."<br>");
   // ===============================================================













   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =========================== LOAD PDP ARRAY ==========================
   //                            0 'tgt_pdp_main'       as 'DUMMY',
   //                            1 @rownum:=@rownum+1   as 'NO',
   //                            2 a.pdp                as 'PDP',
   //                            3 a.pdp_desc           as 'DESCRIPTION',
   //                            4 a.pdp_owner          as 'OWNER',
   //                            5 a.pdp_type           as 'TYPE',
   //                            6 a.pdp_status         as 'STATUS',
   //                            7 a.pdp_launch         as 'LAUNCH',
   //                            8 a.parent_pdp         as 'PARENT',
   //                            9 a.main_pdp           as 'MAIN',
   //                           10 a.scoping            as 'SCOPE',
   //                           11 a.pdp_category       as 'CATEGORY',
   //                           12 a.complexity_factor  as 'COMPLEIXTY',
   //                           13 a.revenue_factor     as 'REVENUE IMPACT',
   //                           14 a.customer_factor    as 'CUSTOMER IMPACT',
   //                           15 a.past_factor        as 'PAST PERFORMANCE',
   //                           16 a.bills_run          as 'BILL RUNS',
   //                           17 a.invoices_generated as 'INVOICE GENERATED',
   //                           18 a.ppw_changes        as 'PPW CHANGES',
   //                           19 a.launch_in_jeopardy as 'LAUNCH IN JEOPARDY',
   //                           20 a.issues_created     as 'ISSUES CREATED',
   //                           21 b.tested             as 'UAT TESTED',
   //                           22 c.tested             as 'RA TESTED',
   //                           23 1                    as 'FILTER' 
   //$cnd1 = "HIGH";
   //$cnd2 = "MEDIUM";
   //$cnd3 = "LOW";
   $queryv1       = "  set @rownum  = 0";
   $mysql_datav1  = mysql_query($queryv1, $mysql_link) or die ("#queryv1 Could not query: ".mysql_error());       
   $querypdp      = "  select 'tgt_pdp_main'                    as 'DUMMY',
                              @rownum:=@rownum+1                as 'NO',
                              a.pdp                             as 'PDP',
                              a.pdp_desc                        as 'DESCRIPTION',
                              a.pdp_owner                       as 'OWNER',
                              a.pdp_type                        as 'TYPE',
                              a.pdp_status                      as 'STATUS',
                              a.pdp_launch                      as 'LAUNCH',
                              a.parent_pdp                      as 'PARENT',
                              a.main_pdp                        as 'MAIN',
                              a.scoping                         as 'SCOPE',
                              upper(rtrim(a.pdp_category))      as 'CATEGORY',
                              upper(rtrim(a.complexity_factor)) as 'COMPLEIXTY',
                              upper(rtrim(a.revenue_factor))    as 'REVENUE IMPACT',
                              upper(rtrim(a.customer_factor))   as 'CUSTOMER IMPACT',
                              upper(rtrim(a.past_factor))       as 'PAST PERFORMANCE',
                              a.bills_run                       as 'BILL RUNS',
                              a.invoices_generated              as 'INVOICE GENERATED',
                              a.ppw_changes                     as 'PPW CHANGES',
                              a.launch_in_jeopardy              as 'LAUNCH IN JEOPARDY',
                              a.issues_created                  as 'TOTAL ISSUES CREATED',
                              b.tested                          as 'UAT TESTED',
                              c.tested                          as 'RA REQUESTED TESTING',
                              1                                 as 'FILTER'  
                         from ".$name.".tgt_pdp_main a ,".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c, ".$name.".tgt_pdp_area_execution d  
                        where trim(a.pdp_status) <> 'Cancelled'
						  and a.pdp  = d.pdp
						  and d.issue_area = 'ENTERPRISE UAT'
						  and (d.actual_start_date >= '$xldate' and d.actual_end_date <= '$xldate2')
						  and a.pdp  = b.pdp
                          and (a.pdp = b.pdp and b.short_desc = 'UAT') 
                          and (a.pdp = c.pdp and c.short_desc = 'RA')
                   ";
   //                
   //a.etl_id = '$yetl_id'
   //                       and (a.pdp_launch >= '2010-09-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
   //                       and ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01')) 
   //                       and (a.pdp = b.pdp and b.short_desc = 'UAT' and b.etl_id = '$yetl_id') 
   //                       and (a.pdp = c.pdp and c.short_desc = 'RA'  and c.etl_id = '$yetl_id') 
   //print($querypdp."<br>");                
   $mysql_datap  = mysql_query($querypdp, $mysql_link) or die ("#querypdp Could not query: ".mysql_error());
   $pdp_rows     = mysql_num_rows($mysql_datap);
   $pcol         = mysql_num_fields($mysql_datap)-1;    // subtracting field/column at [0] i.e the DUMMY field/column                      
   $total_pdp    = 0;
   $pc3a        = 0;  // columns not displayed
   while($rowp  = mysql_fetch_row($mysql_datap)) {
         $total_pdp = $total_pdp + 1;
         if ($total_pdp == 1){
             for ($pc=1;$pc<=$pcol;++$pc) {
                  $pdp_head[$pc] = mysql_field_name($mysql_datap,$pc);
                  if ($pc == 0 || $pc == 4 || $pc == 6 || ($pc >= 8 && $pc <= 18) || $pc == 23){
                      $pdp_head_use[$pc] = 0;
                      $pc3a = $pc3a + 1;
                  } else {
                      $pdp_head_use[$pc] = 1;
                  }
                  $pcx = $pcx + 1;
             }
         }
         for ($pc=1;$pc<=$pcol;++$pc) {
              if ($pc == 7) {
                  $pdp[$total_pdp][$pc] = substr(trim(stripslashes($rowp[$pc])),0,10);
              } else {
                $pdp[$total_pdp][$pc] = trim(stripslashes($rowp[$pc]));
              }
        }
   }
   //print("Last Column ".$pcol." - ".$pc3a."<br>");


   // =========================== FILTER PDP ARRAY ==========================   
   
   // filtr1 (PDP_TYPE)
   $fltcnt1 = 0;
   if ($fltr1 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 5 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 5 means PDP_TYPE
                     if ($pdp[$tp][$pc] <> $prd){
                         $fltcnt1 = $fltcnt1 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  
   
   // filtr3 (PDP_CATEGORY)
   $fltcnt3 = 0;
   if ($fltr3 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 10 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 10+11 means concat(SCOPING." - ".PDP_CATEGORY)
                     $valx = $pdp[$tp][$pc]." - ".$pdp[$tp][$pc+1];
                     //if ($pdp[$tp][$pc] <> $pdpcat){
                     if ($valx <> $pdpcat){
                         $fltcnt3 = $fltcnt3 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  

   // filtr2 (RA_TESTING)
   $fltcnt2 = 0;
   if ($fltr2 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 22 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 22 means RA_IND
                     $valx = $pdp[$tp][$pc];
                     //if ($pdp[$tp][$pc] <> $pdpcat){
                     if ($valx <> $ra_ind){
                         $fltcnt2 = $fltcnt2 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  

   // CREATE XPDP from PDP TO INCLUDE ONLY PDP THAT ARE VALID AS PER ABOVE FILTERS
   $rowcount = 0;
   for ($tp=1;$tp<=$total_pdp;++$tp) {
    if ($pdp[$tp][$pcol] == 1){
        $rowcount = $rowcount + 1;
        print("<tr>");
        for ($pc=1;$pc<=$pcol;++$pc) {
             if ($pdp_head_use[$pc] == 1) { 
                 if ($pc == 1){
                     $xpdp[$rowcount][$pc] = $rowcount;
                 } else {
                     $xpdp[$rowcount][$pc] = $pdp[$tp][$pc];
                     if ($pc == 20){
                         $pdpisu[$rowcount] = stripslashes($rowp[$pc]); 
                     }
                 }
             }   
        }
        //$uno  = $xpdp[$rowcount][1];
        //$updp = $xpdp[$rowcount][2]; 
        //print($uno." - ".$updp."<br>");
    }    
   }
   //ANALYSIS
   ////////////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////////////
   $analsis[1]  = "&nbsp";
   $sum1[1]     = 0; //NO. OF PDP
   $analsis[2]  = "&nbsp";
   $analsis[3]  = "&nbsp";
   $analsis[4]  = "&nbsp";
   $analsis[5]  = "&nbsp";
   $analsis[6]  = "&nbsp";
   $analsis[7]  = "&nbsp";
   $analsis[8]  = "&nbsp";
   $analsis[9]  = "&nbsp";
   $analsis[10] = "&nbsp";
   $sum1[10][1] = 0; //IN SCOPE 
   $sum1[10][2] = 0; //OUT OF SCOPE
   $sum1[10][3] = 0; //NOT SET
   $analsis[11] = "&nbsp";
   $sum1[12][1] = 0; //HIGH
   $sum1[12][2] = 0; //MEDIUM
   $sum1[12][3] = 0; //LOW
   $sum1[12][4] = 0; //NOT SET
   $analsis[12] = "&nbsp";
   $sum1[13][1] = 0; //HIGH
   $sum1[13][2] = 0; //MEDIUM
   $sum1[13][3] = 0; //LOW
   $sum1[13][4] = 0; //NOT SET
   $analsis[13] = "&nbsp";
   $sum1[14][1] = 0; //HIGH
   $sum1[14][2] = 0; //MEDIUM
   $sum1[14][3] = 0; //LOW
   $sum1[14][4] = 0; //NOT SET
   $analsis[14] = "&nbsp";
   $sum1[15][1] = 0; //HIGH
   $sum1[15][2] = 0; //MEDIUM
   $sum1[15][3] = 0; //LOW
   $sum1[15][4] = 0; //NOT SET
   $analsis[15] = "&nbsp";
   $analsis[16] = "&nbsp";
   $sum1[16]    = 0; //BILLS RUN 
   $analsis[17] = "&nbsp";
   $sum1[17]    = 0; //INVOICE GENERATED 
   $analsis[18] = "&nbsp";
   $sum1[18]    = 0; //PPW CHANGES 
   $analsis[19] = "&nbsp";
   $sum1[19][1] = 0; // LAUNCH IN JEOPARDY WHEN YES
   $sum1[19][2] = 0; // LAUNCH IN JEOPARDY WHEN NO
   $analsis[20] = "&nbsp";
   $sum1[20]    = 0; //ISSUES CREATED
   $sum1x[20][1]= 0;
   $sum1x[20][2]= 0;
   $sum1x[20][3]= 0;
   $sum1x[20][4]= 0;
   $analsis[21] = "&nbsp";
   $sum1[21][1] = 0;
   $sum1[21][2] = 0;
   $sum1[21][3] = 0;
   $sum1[21][4] = 0;
   $sum1x[21][1] =0;
   $sum1x[21][2] =0;
   $sum1x[21][3] =0;
   $sum1x[21][4] =0;
   $analsis[22] = "&nbsp";
   $analsis[23] = "&nbsp";
   $isum = 0;
   $osum = 0;
   $nsum = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
         for ($pc=1;$pc<=$pcol;++$pc) {
                //NO.
                if ($pc == 1){
                    $sum1[1]    = $sum1[1] + 1;
                    $ypdp       = $sum1[1]; 
                    //Analysis
                    $analsis[1] = "<u>TOTAL PDPs FOUND</u><br><br>".$sum1[1];
                }
                //SCOPE
                if ($pc == 10){
                    switch ($xpdp[$tp][$pc]) {
                            case "IN SCOPE":
                            $sum1[$pc][1] = $sum1[10][1] + 1;
                            break;
                            case "OUT OF SCOPE":
                            $sum1[$pc][2] = $sum1[10][2] + 1;
                            break;
                            case "NOT SET":
                            $sum1[$pc][3] = $sum1[10][3] + 1;
                            break;
                    }
                    $sumx = $sum1[$pc][1] + $sum1[$pc][2] + $sum1[$pc][3];
                    // Calculate percentages
                    if ($sumx == 0){
                        $sumy[$pc][1] = 0;
                        $sumy[$pc][2] = 0;
                        $sumy[$pc][3] = 0;
                    } else { 
                      (float)$sumy[$pc][1] = round(($sum1[$pc][1]/$sumx)*100,2);
                      (float)$sumy[$pc][2] = round(($sum1[$pc][2]/$sumx)*100,2);
                      (float)$sumy[$pc][3] = round(($sum1[$pc][3]/$sumx)*100,2);
                    }
                    //Analysis
                    $analsisi[10] = "<u>IN SCOPE</u><br><br>".$sum1[10][1]." PDPs<br>(".$sumy[10][1]."%)";
                    $analsiso[10] = "<u>OUT OF SCOPE</u><br><br>".$sum1[10][2]." PDPs<br>(".$sumy[10][2]."%)";
                    $analsisn[10] = "<u>NOT SET</u><br><br>".$sum1[10][3]." PDPs<br>(".$sumy[10][3]."%)";
                }
                // 12 COMPLEXITY
                // 13 REVENUE IMPACT
                // 14 CUSTOMER IMPACT
                // 15 PAST PERFORMANCE
                if ($pc >= 12 && $pc <= 15){
                    switch ($xpdp[$tp][$pc]) {
                            case "HIGH":
                            $sum1[$pc][1] = $sum1[$pc][1] + 1;
                            break;
                            case "MEDIUM":
                            $sum1[$pc][2] = $sum1[$pc][2] + 1;
                            break;
                            case "LOW":
                            $sum1[$pc][3] = $sum1[$pc][3] + 1;
                            break;
                            case "NOT SET":
                            $sum1[$pc][4] = $sum1[$pc][4] + 1;
                            break;
                    }
                    $sumx = $sum1[$pc][1] + $sum1[$pc][2] + $sum1[$pc][3] + $sum1[$pc][4];
                    // Calculate percentages
                    if ($sumx == 0){
                        $sumy[$pc][1] = 0;
                        $sumy[$pc][2] = 0;
                        $sumy[$pc][3] = 0;
                        $sumy[$pc][4] = 0;
                    } else { 
                      (float)$sumy[$pc][1] = round(($sum1[$pc][1]/$sumx)*100,2);
                      (float)$sumy[$pc][2] = round(($sum1[$pc][2]/$sumx)*100,2);
                      (float)$sumy[$pc][3] = round(($sum1[$pc][3]/$sumx)*100,2);
                      (float)$sumy[$pc][4] = round(($sum1[$pc][4]/$sumx)*100,2);
                    }
                    //Analysis 
                    $analsis[12] = "<u>HIGH</u><br>".$sum1[12][1]."<br>(".$sumy[12][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[12][2]."<br>(".$sumy[12][2]."%)"."<br><br><u>LOW</u><br>".$sum1[12][3]."<br>(".$sumy[12][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[12][4]."<br>(".$sumy[12][4]."%)";
                    $analsis[13] = "<u>HIGH</u><br>".$sum1[13][1]."<br>(".$sumy[13][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[13][2]."<br>(".$sumy[13][2]."%)"."<br><br><u>LOW</u><br>".$sum1[13][3]."<br>(".$sumy[13][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[13][4]."<br>(".$sumy[13][4]."%)";
                    $analsis[14] = "<u>HIGH</u><br>".$sum1[14][1]."<br>(".$sumy[14][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[14][2]."<br>(".$sumy[14][2]."%)"."<br><br><u>LOW</u><br>".$sum1[14][3]."<br>(".$sumy[14][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[14][4]."<br>(".$sumy[14][4]."%)";
                    $analsis[15] = "<u>HIGH</u><br>".$sum1[15][1]."<br>(".$sumy[15][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[15][2]."<br>(".$sumy[15][2]."%)"."<br><br><u>LOW</u><br>".$sum1[15][3]."<br>(".$sumy[15][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[15][4]."<br>(".$sumy[15][4]."%)";
                }
                // 16 BILL RUNS
                // 17 INVOICE GENERATED
                // 18 PPW CHANGES
                // 20 ISSUES CREATED
                if (($pc >= 16 && $pc <=18) || $pc == 20){
                    if ($xpdp[$tp][$pc] > 0){
                        $sum1[$pc] = $sum1[$pc] + $xpdp[$tp][$pc];
                        if ($pc == 20){
                            $yisu = $sum1[$pc];
                                 if ($xpdp[$tp][10] == "IN SCOPE"){
                                     $isum  =  $isum + $xpdp[$tp][$pc];
                                 }
                                 if ($xpdp[$tp][10] == "OUT OF SCOPE"){
                                     $osum =  $osum + $xpdp[$tp][$pc];
                                 }
                                 if ($xpdp[$tp][10] == "NOT SET"){
                                     $nsum =  $nsum + $xpdp[$tp][$pc];
                                 }
                        }
                    }    
                    $analsis[$pc] = $sum1[$pc];
                }
                // LAUNCH IN JEOPARDY
                if ($pc == 19){
                    if ($xpdp[$tp][$pc] == "YES"){
                        $sum1[$pc][1] = $sum1[$pc][1] + 1;
                    } 
                    if ($xpdp[$tp][$pc] == "NO"){
                        $sum1[$pc][2] = $sum1[$pc][2] + 1;
                    } 
					$sum19 = $sum1[$pc][1] + $sum1[$pc][2];
    				if ($sum19 == 0){
					    $prc1[$pc] = 0;
						$prc2[$pc] = 0;
		     		} else {
					    if ($sum1[$pc][1] == 0){
						    $prc1[$pc] = 0;
						} else {
						    $prc1[$pc] = round(($sum1[$pc][1]/$sum19)*100,2); 
						}
					    if ($sum1[$pc][2] == 0){
						    $prc2[$pc] = 0;
						} else {
						    $prc2[$pc] = round(($sum1[$pc][2]/$sum19)*100,2); 
						}
					}
                    $analsis[$pc] = "YES = ".$sum1[$pc][1]."<br>(".$prc1[$pc].")%<br><br>"."NO = ".$sum1[$pc][2]."<br>(".$prc2[$pc].")%";
                }
                // UAT and RA TESTED
                if ($pc == 21){
                    switch ($xpdp[$tp][21]) {
                       case ($xpdp[$tp][21] == "YES" && $xpdp[$tp][22] == "YES"):
                             $sum1[21][1] = $sum1[21][1] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][1] = $sum1x[$pc][1] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][1] = 0;
                                 $sumy[$pc][1] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "YES" && $xpdp[$tp][22] == "NO"): 
                             $sum1[21][2] = $sum1[21][2] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][2] = $sum1x[21][2] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][2] = 0;
                                 $sumy[$pc][2] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "NO" && $xpdp[$tp][22] == "YES"): 
                             $sum1[21][3] = $sum1[21][3] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][3] = $sum1x[21][3] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][3] = 0;
                                 $sumy[$pc][3] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "NO" && $xpdp[$tp][22] == "NO"): 
                             $sum1[21][4] = $sum1[21][4] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][4] = $sum1x[21][4] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][4] = 0;
                                 $sumy[$pc][4] = 0;
                             }
                             break;
                    }
                    if ($tp == $rowcount){
                        for ($x=1;$x<=4;++$x) {
                             if ($sum1[21][$x] == 0){
                                 $sumz[21][$x] = 0;
                             } else {
                                 (float)$sumz[21][$x] = round(($sum1[21][$x]/$ypdp)*100,2);
                             }
                             if ($sum1x[21][$x] == 0){
                                 $sumy[21][$x] = 0;
                             } else {
                                 (float)$sumy[21][$x] = round(($sum1x[21][$x]/$yisu)*100,2);
                             }
                        }    
                    }
                    //Analysis
                    $analsis[21] = "<u>UAT=YES,RA=YES<br></u><br>PDP<br>".$sum1[21][1]." out of ".$ypdp."<br>(".$sumz[21][1].")%<br><br>ISSUES<br>".$sum1x[21][1]." out of ".$yisu."<br>(".$sumy[21][1].")%<br><br>".
                                   "<u><br>UAT=YES,RA=NO<br></u><br>PDP<br>".$sum1[21][2]." out of ".$ypdp."<br>(".$sumz[21][2].")%<br><br>ISSUES<br>".$sum1x[21][2]." out of ".$yisu."<br>(".$sumy[21][2].")%<br><br>".
                                   "<u><br>UAT=NO,RA=YES<br></u><br>PDP<br>".$sum1[21][3]." out of ".$ypdp."<br>(".$sumz[21][3].")%<br><br>ISSUES<br>".$sum1x[21][3]." out of ".$yisu."<br>(".$sumy[21][3].")%<br><br>".
                                   "<u><br>UAT=NO,RA=NO<br></u><br>PDP<br>".$sum1[21][4]." out of ".$ypdp."<br>(".$sumz[21][4].")%<br><br>ISSUES<br>".$sum1x[21][4]." out of ".$yisu."<br>(".$sumy[21][4].")%";
                }
         }
   } 
   //print("Filter 1 Found :".$fltcnt1."To filter out<br>");
   //print("Filter 3 Found :".$fltcnt3."To filter out<br>");
   //print($rowcount."<br>");


   // =========================== LOAD AREA EXECUTION ==========================
   //$query2        = "  select sum(iterations) from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   //$mysql_data2   = mysql_query($query2, $mysql_link) or die ("#query2 Could not query: ".mysql_error());       
   //while($row2    = mysql_fetch_row($mysql_data2)) {
   //      $itcnt   = stripslashes($row2[0]);          
   //}
   $pc3b            = 0;  // columns not displayed
   for ($tp=1;$tp<=$rowcount;++$tp) {
        //                            0 'tgt_pdp_area_execution'                                   as 'DUMMY',
        //                            1 @rownum2:=@rownum2+1                                       as 'NO',
        //                            2 a.pdp                                                      as 'PDP',
        //                            3 a.issue_area                                               as 'DEPARTMENT',
        //                            4 if(a.test_iteration=1,'PRE-PRODUCTION','POST-PRODUCTION')  as 'ITERATION',
        //                            5 a.issue_count                                              as 'ISSUE COUNT',
        //                            6 a.back_to_build                                            as 'BACK TO BUILD',
        //                            7 a.testing_start_date                                       as 'TESTING START DATE',
        //                            8 a.testing_end_date                                         as 'TESTING END DATE',
        //                            9 a.planned_wkd                                              as 'PLANNED WEEKDAYS',
        //                           10 a.planned_wked                                             as 'PLANNED WEEKEND DAYS',
        //                           11 a.actual_start_date                                        as 'ACTUAL START DATE',
        //                           12 a.actual_end_date                                          as 'ACTUAL END DATE',
        //                           13 a.actual_available_wkd                                     as 'ACTUAL AVAILABLE WEEKDAYS',
        //                           14 a.actual_available_wked                                    as 'ACTUAL AVAILABLE WEEKENDAYS',
        //                           15 a.utilized_wkd                                             as 'UTILIZED WEEK DAYS',
        //                           16 a.utilized_wked                                            as 'UTILIZED WEEKEDND DAYS'
        $paecol        = 0;
        $updp          = $xpdp[$tp][2];
        $queryv        = "  set @rownum2  = 0";
        $mysql_datav   = mysql_query($queryv, $mysql_link) or die ("#queryv Could not query: ".mysql_error());       
        $querypae      = "  select 'tgt_pdp_area_execution'                                   as 'DUMMY',
                                   @rownum2:=@rownum2+1                                       as 'NO',
                                   a.pdp                                                      as 'PDP',
                                   a.issue_area                                               as 'DEPARTMENT',
                                   if(a.test_iteration=1,'PRE-PRODUCTION','POST-PRODUCTION')  as 'ITERATION',
                                   a.issue_count                                              as 'ISSUE COUNT',
                                   a.back_to_build                                            as 'BACK TO BUILD',
                                   a.testing_start_date                                       as 'TESTING START DATE',
                                   a.testing_end_date                                         as 'TESTING END DATE',
                                   a.planned_wkd                                              as 'PLANNED WEEKDAYS',
                                   a.planned_wked                                             as 'PLANNED WEEKEND DAYS',
                                   a.actual_start_date                                        as 'ACTUAL START DATE<br>YYYY-MM-DD',
                                   a.actual_end_date                                          as 'ACTUAL END DATE<br>YYYY-MM-DD',
                                   a.actual_available_wkd                                     as 'ACTUAL AVAILABLE WEEKDAYS',
                                   a.actual_available_wked                                    as 'ACTUAL AVAILABLE WEEKENDAYS',
                                   a.utilized_wkd                                             as 'UTILIZED WEEK DAYS',
                                   a.utilized_wked                                            as 'UTILIZED WEEKEDND DAYS'
                              from ".$name.".tgt_pdp_area_execution a 
                             where a.pdp            = '$updp' 
                               and a.test_iteration = 1 
                               and a.issue_area     = 'ENTERPRISE UAT'
                          order by a.pdp,a.issue_area,a.test_iteration
                        ";
        //a.etl_id = '$yetl_id'               
        //print($querypdp2."<br>");                
        $mysql_datapae = mysql_query($querypae, $mysql_link) or die ("#querypae Could not query: ".mysql_error());
        $paerows       = mysql_num_rows($mysql_datapae);
        $paecol        = mysql_num_fields($mysql_datapae)-1;                // subtracting field/column at [0] i.e the DUMMY field/column                      
        $paestart      = 1;                                                 //($paecol - $paecol2)+1;
        $paeend        = $paecol;
        $totl          = 0;
        //print("Rows :".$paerows."  Columns :".$paecol."<br>");
        while($rowpae  = mysql_fetch_row($mysql_datapae)) {
              $totl = $totl + 1;
              if ($totl == 1){
              } else {
                  $paestart = $paestart + $paecol;
                  $paeend   = $paeend + $paecol;
                  //print("Start: ".$paestart." - End: ".$paeend."<br>");
              }
              //print("Start :".$paestart."  End :".$paeend."<br>");              
              $pc2 = 0;
              for ($pc=$paestart;$pc<=$paeend;++$pc) {
                   $pc2    = $pc2 + 1;
                   if ($tp == 1){
                       $analsis2[$pc]  = 0;
                       $sum2[$pc]      = 0;
                   } 
                   //LOADING HEADING NAMES      
                   if ($tp == 1){
                       $pae_head[$pc] = mysql_field_name($mysql_datapae,$pc2);
                       if ($pc == $paestart || $pc2 == 2  || $pc2 == 3 || $pc2 == 4 || $pc2 == 7 || $pc2 == 8 || $pc2 == 9  || $pc2 == 10  || $pc2 == 13 || $pc2 == 14 || $pc2 == 15 || $pc2 == 16  ){
                           // SUPRESSING THE FIRST COLUMN TO DISPLAY
                           $pae_head_use[$pc] = 0;
                           $pc3b = $pc3b + 1;
                       } else {
                           $pae_head_use[$pc] = 1;
                       }
                   }
                   //$pae[$tp][$pc] = stripslashes($rowpae[$pc2]);
                   if ($pc2 == 7 || $pc2 == 8 || $pc2 == 11 || $pc2 == 12){
                       $pae[$tp][$pc] = substr(stripslashes($rowpae[$pc2]),0,10);
                       if (trim($pae[$tp][$pc]) == "0000-00-00" ){
                           $pae[$tp][$pc] = "&nbsp";
                       }
                   } else {
                       $pae[$tp][$pc] = stripslashes($rowpae[$pc2]);
                       //////////////////////////////////////////////
                       //ANALYSIS FOR ISSUE COUNT AND BACK TO BUILD//
                       //////////////////////////////////////////////
                       // ISSUE COUNT
                       if ($pc2 == 5){
                           //if ($pae[$tp][$pc] > 0){
                               $xy = $pc-2;    // Department
                               $xz = $pc-1;    // Iteration
                               $sum2head[$pc] = $pae[$tp][$xy]; //."<br><br>".$pae[$tp][$xz]; ---> Took Iteration out of analysis display
                               $sum2[$pc]     = $sum2[$pc] + $pae[$tp][$pc];
                               if ($sum2[$pc] == 0){
                                   $sum2y[$pc] = 0;
                               } else {
                                 (float)$sum2y[$pc] = round(($sum2[$pc]/$yisu)*100,2); 
                               }  
                               // ANALYSIS 
                               $analsis2[$pc] = "<u>".$sum2head[$pc]."</u>"."<br><br>".$sum2[$pc]." out of ".$yisu."<br>(".$sum2y[$pc].")%";
                               //$xy = $pc - 2;
                               //$analsis2[$xy] =  $analsis2[$pc]."<br><br>".$analsis2[$xy];
                           //}
                           //////////////////////////////////////////////
                           // ISSUE COUNT SUM FOR PRE AND POST PRODUCTION
                           //////////////////////////////////////////////
                           //$u = $pc-1;
                           //$v = $pc;
                           //$valx1 = $pae[$tp][$u];
                           //$valx2 = $pae[$tp][$v];
                           //print("PC: ".$u." - ".$valx1." || PC2: ".$v." - ".$valx2."<br>");
                           // TOTAL PRE-PRODUCTION and PC 112
                           if (trim($pae[$tp][$pc-1]) == "PRE-PRODUCTION"){
                               $x                = 1; // FILLER "TOTAL ISSUES PRE-PRODUCION";
                               $xfilr[$tp][$x]   = $xfilr[$tp][$x] + $pae[$tp][$pc];
                           } 
                           // TOTAL POST-PRODUCTION and PC 113
                           if (trim($pae[$tp][$pc-1]) == "POST-PRODUCTION"){
                               $x                = 2; // FILLER "TOTAL ISSUES POST-PRODUCION";
                               $xfilr[$tp][$x]   = $xfilr[$tp][$x] + $pae[$tp][$pc];
                           } 
                       }
                       // BACK TO BUILD
                       if ($pc2 == 6 || ($pc2 >= 9 && $pc2 <= 16)){
                           if ($pae[$tp][$pc] > 0){
                               $sum2[$pc] = $sum2[$pc] + $pae[$tp][$pc];
                               if ($pc2 == 6){
                                   $x               = 3;      // FILLER "TOTAL BACK TO BUILD";
                                   $xfilr[$tp][$x]  = $xfilr[$tp][$x] + $pae[$tp][$pc];
                               }
                               // ANALYSIS
                               $analsis2[$pc]        = $sum2[$pc]; 
                           }    
                       }
                   }
              }
         }
   }
   //for ($x=1;$x<=3;++$x) {
   //     $paeend = $paeend + 1;
   //     $pae_head_use[$paeend]  = 1;
   //     switch ($x){
   //          case 1:
   //             $pae_head[$paeend] = "TOTAL ISSUES PRE-PRODUCION";
   //             break;
   //          case 2:
   //             $pae_head[$paeend] = "TOTAL ISSUES POST-PRODUCTION";
   //             break;
   //          case 3:
   //             $pae_head[$paeend] = "TOTAL BACK TO BUILD";
   //             break;
   //     } 
   //     //FILLER "TOTAL BACK TO BUILD";
   //     for ($tp=1;$tp<=$rowcount;++$tp) {
   //          $pae[$tp][$paeend] = $xfilr[$tp][$x];
   //          $yfilr[$x]         = $yfilr[$x] + $pae[$tp][$paeend];
   //     }
   //     $analsis2[$paeend]      = $yfilr[$x];
   //}
   //print("Last Column ".$paeend."<br>");
   
   // =========================== LOAD WORK EFFORT ==========================
   //$query2a       = "  select count(*) from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   //$mysql_data2a  = mysql_query($query2a, $mysql_link) or die ("#query2a Could not query: ".mysql_error());       
   //while($row2a   = mysql_fetch_row($mysql_data2a)) {
   //      $areacnt   = stripslashes($row2a[0]);          
   //}
   $pc3c          = 0;  // columns not displayed
   for ($tp=1;$tp<=$rowcount;++$tp) {
        //                          0 'tgt_pdp_area_work_effort'                                 as 'DUMMY',
        //                          1 @rownum3:=@rownum3+1                                       as 'NO',
        //                          2 a.pdp                                                      as 'PDP',
        //                          3 a.issue_area                                               as 'AREA',
        //                          4 a.baseline_hours                                           as 'BASELINE HOURS',
        //                          5 a.rework_hours                                             as 'REWORK HOURS',
        //                          6 a.percentage_rework                                        as 'BASELINE HOURS UTILIZED',
        //                          7 a.percentage_baseline                                      as 'REWORK HOURS REQUIRED'
        $pwecol = 0;
        $updp          = $xpdp[$tp][2];
        $queryv2       = "  set @rownum3  = 0";
        $mysql_datav2  = mysql_query($queryv2, $mysql_link) or die ("#queryv2 Could not query: ".mysql_error());       
        $querypwe      = "  select 'tgt_pdp_area_work_effort'                                 as 'DUMMY',
                                   @rownum3:=@rownum3+1                                       as 'NO',
                                   a.pdp                                                      as 'PDP',
                                   a.issue_area                                               as 'DEPARTMENT',
                                   a.baseline_hours                                           as 'BASELINE HOURS',
                                   a.rework_hours                                             as 'REWORK HOURS',
                                   a.percentage_baseline                                      as 'BASELINE HOURS UTILIZED',
                                   a.percentage_rework                                        as 'REWORK HOURS REQUIRED'
                              from ".$name.".tgt_pdp_area_work_effort a 
                             where a.pdp        = '$updp'
                               and a.issue_area = 'ENTERPRISE UAT' 
                          order by a.pdp,a.issue_area
                        ";
        //  a.etl_id = '$yetl_id'               
        //print($querypdp2."<br>");                
        $mysql_datapwe = mysql_query($querypwe, $mysql_link) or die ("#querypwe Could not query: ".mysql_error());
        $pwerows       = mysql_num_rows($mysql_datapwe);
        $pwecol        = mysql_num_fields($mysql_datapwe)-1;                // subtracting field/column at [0] i.e the DUMMY field/column                      
        $pwestart      = 1;                                                 //($pwecol - $pwecol2)+1;
        $pweend        = $pwecol;
        $totl          = 0;
        //print("Rows :".$paerows."  Columns :".$paecol."<br>");
        while($rowpwe  = mysql_fetch_row($mysql_datapwe)) {
              $totl = $totl + 1;
              if ($totl == 1){
              } else {
                  $pwestart = $pwestart + $pwecol;
                  $pweend   = $pweend + $pwecol;
              }
              //print("Start :".$pwestart."  End :".$pweend."<br>");              
              $pc2 = 0;
              for ($pc=$pwestart;$pc<=$pweend;++$pc) {
                   //$ytp[$pc] = 0;
                   $pc2    = $pc2 + 1;
                   if ($tp == 1){
                       $analsis3[$pc]  = 0;
                       $sum3[$pc]      = 0;
                       $ytp[$pc]       = 0;
                       $sum3y[$pc]     = 0;
                       $pwe_head[$pc] = mysql_field_name($mysql_datapwe,$pc2);
                       if ($pc == $pwestart || $pc2 == 2  || $pc2 == 3  || $pc2 == 4  || $pc2 == 5 || $pc2 == 6){
                           $pwe_head_use[$pc] = 0;
                           //if ($pc <> 0){
                               $pc3c = $pc3c + 1;
                           //}           // Counter should be used only when $pc <> 0
                       } else {
                           $pwe_head_use[$pc] = 1;
                       }
                   }

                   $pwe[$tp][$pc] = stripslashes($rowpwe[$pc2]);
                   if ($pc2 == 6 || $pc2 == 7){
                           if ($pc2 == 6){
                               $xy = $pc - 3;
                           } else {
                               $xy = $pc - 4;
                           }
                           $sum3head[$pc] = $pwe[$tp][$xy];
                           if ($pwe[$tp][$pc] > 0){
                               $ytp[$pc]      = $ytp[$pc]  + 1;
                               $sum3[$pc]     = $sum3[$pc] + $pwe[$tp][$pc];
                               $sum3y[$pc]    = round(($sum3[$pc]/$ytp[$pc]),2); 
                               // ANALYSIS 
                               //$analsis3[$pc] = $sum3[$pc]."<br>".$sum3y[$pc]."<br>".$ytp[$pc];    //." for ".$ypdp." PDP<br>(".$sum3y[$pc].")%"; 
                               //$analsis3[$pc] =  $sum3head[$pc]."<br><br>".$sum3y[$pc];
                           }
                           //$sum3y[$pc]    = round(($sum3[$pc]/$ytp[$pc]),2);
                           $analsis3[$pc] =  "<u>".$sum3head[$pc]."</u>"."<br><br>".$sum3y[$pc];
                       //}
                   } else {
                       //$pwe[$tp][$pc] = stripslashes($rowpwe[$pc2]);
                       if ($pc2 == 4 || $pc2 == 5){
                           if ($pwe[$tp][$pc] > 0){
                               $sum3[$pc]     = $sum3[$pc] + $pwe[$tp][$pc];
                               // ANALYSIS 
                               $analsis3[$pc] = $sum3[$pc];    //." for ".$ypdp." PDP<br>(".$sum3y[$pc].")%"; 
                           }
                       }
                   }

              }
        }
   }
   //print("Last Column ".$paeend."<br>");

   // =========================== LOAD ISSUE ANALYTICS ==========================
   $query1a       = " select issue_area from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   $mysql_data1a  = mysql_query($query1a, $mysql_link) or die ("#query1a Could not query: ".mysql_error());
   $arearows      = mysql_num_rows($mysql_data1a);
   $areacnt       = 0;          
   while($row1a   = mysql_fetch_row($mysql_data1a)) {
         $areacnt = $areacnt + 1; 
         $ara[$areacnt]   = stripslashes($row1a[0]);          
   }
   $query2a       = "  select issue_type,issue_class,report_group
                         from ".$name.".tgt_report_groups
                    ";
   //where etl_id = '$yetl_id'                      
   $mysql_data2a  = mysql_query($query2a, $mysql_link) or die ("#query2a Could not query: ".mysql_error());       
   $isucnt = 0;
   while($row2a   = mysql_fetch_row($mysql_data2a)) {
         $isucnt       = $isucnt + 1;
         $isu[$isucnt] = stripslashes($row2a[0]);
         $isc[$isucnt] = stripslashes($row2a[1]);
         $isr[$isucnt] = stripslashes($row2a[2]); 
         //print($isucnt." - ".$isc[$isucnt]." - ".$isu[$isucnt]."<br>");
   }
   /////////////////////////////////////////////////////////////////
   $pc4  = $isucnt + 1;     // Headers are Area + All Issue Types 
   $pc4h = $pc4 * $areacnt;
   $pc4a = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
        $pc = 0;
    for ($ar=1;$ar<=$areacnt;++$ar) {
     if ($ara[$ar] == "ENTERPRISE UAT"){
         $pc             = $pc + 1;
         $pc3            = $pc;
         $pia_head[$pc]  = "DEPARTMENT"; //$ara[$ar];     // AREA is the first HEADER
         $pia[$tp][$pc]  = $ara[$ar];
         $pia_head_use[$pc] = 0;
         $valx           = $pia[$tp][$pc];
         $pc2            = 0;
         $pc2            = $pc2 + 1;
         $sum4grsrot     = 0;
         $sum4grscnt     = 0;
      for ($is=1;$is<=$isucnt;++$is) {
          $pc            = $pc + 1;                // Counter for all Other HEADERS
          $pc2           = $pc2 + 1;
          $chk[$pc]      = $pc2;                   // $pc2 works just like $bpc (used in issue summary per area)         
          $pia_head[$pc] = $isu[$is];              // Setting up HEADER
          //$xhead = $pia_head[$pc];
          $pia_head1[$pc]= "<br><br>".$isc[$is]."<br><br>".$isr[$is];
          $piac[$pc]     = $isc[$is];              // ISSUE CLASS
          $piar[$pc]     = $isr[$is];              // ISSUE GROUP 
          if ($tp == 1){
            // SUPPRESSION OF COLUMNS
            if ($piac[$pc] == "GRT"){
                $pia_head_use[$pc] = 0;
                $pc4a = $pc4a + 1;
            } 
            if ($piac[$pc] == "CNT" && $piar[$pc] <> "NO"){
                if (trim($pia_head[$pc]) == trim($piar[$pc])){
                    $pia_head_use[$pc] = 1;
                } else {
                  $pia_head_use[$pc] = 0;
                 $pc4a = $pc4a + 1;
                 }
            }
            if (($piac[$pc] == "CNT" && $piar[$pc] == "NO") || $piac[$pc] == "ROT"){
                 $pia_head_use[$pc] = 1;
            }
          }
          $updp = $xpdp[$tp][2];
          //if ($pdpisu[$tp] == 0){
          //    $pia[$tp][$pc] = 0;
          //} else { 
            $querypia      = "  select a.found_issues 
                                  from ".$name.".tgt_pdp_issue_area_summary a 
                                 where a.pdp        = '$updp'
                                   and a.issue_area = '$ara[$ar]'
                                   and a.issue_type = '$isu[$is]'  
                            ";
            //a.etl_id     = '$yetl_id'                
            //print($querypia."<br>");                
            $mysql_datapia = mysql_query($querypia, $mysql_link) or die ("#querypia Could not query: ".mysql_error());
            $piarows       = mysql_num_rows($mysql_datapia);
            //print($pc." - ".$pia_head[$pc]." - Class: ".$piac[$pc]." - Report Group: ".$piar[$pc]."<br>");
            //print($pc."ROWS RETURNED - ".$piarows."<br>");
            if ($piarows == 0){
                $pia[$tp][$pc] = 0;
                //$valx = $pia[$tp][$pc];
                //print($pc." - ".$valx."<br>");
            } else {
                while($rowpia = mysql_fetch_row($mysql_datapia)) {
                      $pia[$tp][$pc] = stripslashes($rowpia[0]); 
                }        
            }
            //////////
            //ANALYSIS
            //////////
            if ($piac[$pc] == "ROT" || $piac[$pc] == "GRT"){
                //$totalrot        = $totalrot + $pia[$tp][$pc];       // Total of all ROT Issues Types for all PDPs
                $sum4[$pc]       = $sum4[$pc] + $pia[$tp][$pc];        // Total of specific Issue Type for all PDPs
                ///// CALCULATE (A) TOTALROT (TOTAL OF ROOT CAUSE FOR ALL PDP, SUM4ROT (SUM OF ROOT CAUSE FOR A GIVEN DEPARTMENT
                if ($piac[$pc] == "ROT"){
                    $totalrot        = $totalrot + $pia[$tp][$pc];       // Total of all ROT Issues Types for all PDPs
                    $sum4rot[$ar]    = $sum4rot[$ar] + $pia[$tp][$pc];   // Total of all Issues Types in a specific area i.e. MO, RA, UAT, CMGT
                }
                ///// CALCULATE (A) TOTALROT (TOTAL OF ROOT CAUSE FOR ALL PDP, SUM4ROT (SUM OF ROOT CAUSE FOR A GIVEN DEPARTMENT
                if (($sum4[$pc] == 0 && $sum4rot[$ar] == 0) && $piac[$pc] == "ROT"){
                    $sum4a[$pc]  = 0;
                    $sum4b[$pc] = 0;
                } else {
                    if ($piac[$pc] == "ROT"){
                        $sum4a[$pc]  = round(($sum4[$pc]/$sum4rot[$ar])*100,2);
                        $sum4b[$pc]  = round(($sum4[$pc]/$totalrot)*100,2);
                    }
                }
                if ($piac[$pc] == "ROT"){
                    //$xhead = $pia_head[$pc];
                    //print($xhead." - ".$piar[$pc]."<br>");
                    if (trim($pia_head[$pc]) == trim($piar[$pc])){
                        //print($piar[$pc]."<br>");
                        $xpc          = $pc; 
                        $xcause       = trim($pia_head[$pc]);
                        $piaxp[$xpc]  = 1;
                        $xp           = 0;
                        $analsis4x[$xpc] = "<br><u>GRANULAR ROOT CAUSE COUNT</u><br><br>";
                    }
                    $analsis4[$pc]   = $sum4[$pc]."<br><br>".$sum4a[$pc]."%<br>"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4rot[$ar]."<br><br>Total: ".$totalrot;
                } else {
                    $analsis4[$pc]   = "(R)<br>".$sum4[$pc];
                    if (trim($piar[$pc]) == $xcause){
                        //print("YES"."<br>");
                        if ($sum4[$pc] == 0){
                          $grtchk[$xpc] = 0;
                        } else {
                          $xp = $xp + 1;
                          $grtchk[$xpc] = $xp;
                          $analsis4x[$xpc] = $analsis4x[$xpc]."<br><br>".$pia_head[$pc]." = ".$sum4[$pc];
                        }
                    }
                }
            }
            if ($piac[$pc] == "CNT" && (trim($pia_head[$pc]) <> trim($piar[$pc]))){
                $totalcnt        = $totalcnt + $pia[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                $sum4[$pc]       = $sum4[$pc] + $pia[$tp][$pc];      // Total of specific Issue Type for all PDPs
                $sum4cnt[$ar]    = $sum4cnt[$ar] + $pia[$tp][$pc];   // Total of all Issues Types in a specific area i.e. MO, RA, UAT, CMGT
                if ($sum4[$pc] == 0 && $sum4cnt[$ar] == 0){
                    $sum4c[$pc]  = 0;
                    $sum4d[$pc]  = 0;
                } else {
                    $sum4c[$pc]  = round(($sum4[$pc]/$sum4cnt[$ar])*100,2);
                    $sum4d[$pc]  = round(($sum4[$pc]/$totalcnt)*100,2);
                }
                $analsis4[$pc]   = $sum4[$pc]."<br><br>".$sum4c[$pc]."%<br>"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4cnt[$ar]."<br><br>Total: ".$totalcnt
            }
            if ($pc2 == $pc4){
                if ($sum4rot[$ar] == 0){
                    $analsis4a  = 0;
                } else {
                  $analsis4a  = round((($sum4rot[$ar]/$totalrot)*100),2);
                }
                if ($sum4cnt[$ar] == 0){
                    $analsis4c  = 0;
                } else {
                  $analsis4c  = round((($sum4cnt[$ar]/$totalcnt)*100),2);
                }
                $analsis4[$pc3] = "<u>".$ara[$ar]."</u><br><br>(R)<br><u>ROOT CAUSE COUNT</u><br>(A of B) <br>".$sum4rot[$ar]." of ".$totalrot."<br>(".$analsis4a.")%".
                                                  "<br><br>(M)<br><u>MISSED OPPORTUNITIES</u><br>(C of D)<br>".$sum4cnt[$ar]." of ".$totalcnt."<br>(".$analsis4c.")%";
            }               
      }
     }
    }
   }
   //print($pc4h." - ".$pc4a."<br>");
   ///////////////////////////////////////////////////////////////
   $pc5  = $isucnt;     // Headers are Area + All Issue Types 
   $pc5h = $pc5;
   $pc5a = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
        $pc = 0;
     for ($is=1;$is<=$isucnt;++$is) {
          $pc            = $pc + 1;                // Counter for all Other HEADERS
          $pii_head[$pc] = $isu[$is];              // Setting up HEADER
          $pii_head1[$pc]= "<br><br>".$isc[$is]."<br><br>".$isr[$is];
          $piic[$pc]     = $isc[$is];
          $piir[$pc]     = $isr[$is];
          if ($tp == 1){
            // SUPPRESSION OF COLUMNS
            if ($piic[$pc] == "GRT"){
                $pii_head_use[$pc] = 0;
                $pc5a = $pc5a + 1;
            } 
            if ($piic[$pc] == "CNT"){
                $pii_head_use[$pc] = 0;
                $pc5a = $pc5a + 1;
            }
            if ($piic[$pc] == "ROT"){
                 $pii_head_use[$pc] = 1;
            }
          }
          $updp          = $xpdp[$tp][2];
          $querypii      = "  select a.occurance 
                                from ".$name.".tgt_pdp_issue_summary a 
                               where a.pdp        = '$updp'
                                 and a.issue_type = '$isu[$is]'  
                           ";
          // a.etl_id     = '$yetl_id'                 
          //print($querypia."<br>");                
          $mysql_datapii = mysql_query($querypii, $mysql_link) or die ("#querypii Could not query: ".mysql_error());
          $piirows       = mysql_num_rows($mysql_datapii);
          if ($piirows == 0){
              $pii[$tp][$pc] = 0;
              $sum5[$pc]     = $sum5[$pc] + $pii[$tp][$pc];
              $analsis5[$pc] = $sum5[$pc];
          } else {
              while($rowpii = mysql_fetch_row($mysql_datapii)) {
                    $pii[$tp][$pc] = stripslashes($rowpii[0]); 
                    //////////
                    //ANALYSIS
                    //////////
                    //$sum5[$pc]     = $sum5[$pc] + $pii[$tp][$pc];
                    //$analsis5[$pc] =  $sum5[$pc];
              }        
          }
            //////////
            //ANALYSIS
            //////////
            if ($piic[$pc] == "ROT" || $piic[$pc] == "GRT"){
                $sum5[$pc] = $sum5[$pc] + $pii[$tp][$pc];                  // Total of specific Issue Type for all PDPs
                if ($piic[$pc] == "ROT"){
                    $totalrot2 = $totalrot2 + $pii[$tp][$pc];
                    if (trim($pii_head[$pc]) == trim($piir[$pc])){
                        $xpc          = $pc; 
                        $xcause       = trim($pii_head[$pc]);
                        $piixp[$xpc]  = 1;
                        $xp           = 0;
                        $analsis5x[$xpc] = "<br><u>GRANULAR ROOT CAUSE COUNT</u><br>";
                    }
                    $analsis5[$pc]   =  $sum5[$pc];                  //"(R)<br>".$sum5[$pc]."<br><br>(A)<br>".$sum5a[$pc]."%";   //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4rot[$ar]."<br><br>Total: ".$totalrot;
                } else {
                    $analsis5[$pc]   = $sum5[$pc];
                    if (trim($piir[$pc]) == $xcause){
                        //print("YES"."<br>");
                        if ($sum5[$pc] == 0){
                            $grtchk2[$xpc] = 0;
                        } else {
                          $xp = $xp + 1;
                          $grtchk2[$xpc] = $xp;
                          $analsis5x[$xpc] = $analsis5x[$xpc]."<br><br>".$pii_head[$pc]." = ".$sum5[$pc];
                        }
                    }
                }
            }
            if ($piic[$pc] == "CNT"){
                $sum5[$pc]      = $sum5[$pc] + $pii[$tp][$pc];        // Total of specific Issue Type for all PDPs
                if ($pii_head[$pc] == $piir[$pc]){
                    //$totalcnt2      = $totalcnt2 + $pii[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                } else {
                    $totalcnt2  = $totalcnt2 + $pii[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                }
                $analsis5[$pc]   =  $sum5[$pc];                 //"(M)<br>".$sum5[$pc]."<br><br>(C)<br>".$sum5c[$pc]."%<br>(D)<br>".$sum5d[$pc]."%"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4cnt[$ar]."<br><br>Total: ".$totalcnt
            }
     }
   }
   //print("Last Column ".$paeend."<br>");

   











   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   //print($total_pdp." Total PDPs<br>");
   // ============================ PDP AND CRITERIA ===========================
   $captnx = "Criteria";
   print("
                        <div id=\"One\" class=\"cont\"> 
                         <table>
                          <caption>$captnx</caption>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Type</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$prd</font>
                           </th>
                          </tr>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">RA Testing</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$ra_ind</font>
                           </th>
                          </tr>             
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Category</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$pdpcat</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Launch Date (YYYY-MM-DD)</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">Between $xldate and $xldate2</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">Run Date</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$ydate2</font>
                           </th>
                          </tr> 
                          <!--<tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">ETL JOB</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$yetl_id</font>
                           </th>
                          </tr>--> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">REPORT</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">PDP UAT REPORT</font>
                           </th>
                          </tr>                                         
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">USER</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$usr</font>
                           </th>
                          </tr>
   ");
   if ($total_pdp == 0){
       print("                        
                          <tr>
                           <th colspan=\"2\" bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:500px;\">
                            <font color=\"#FFFFFF\">
                             NO RECORDS FOUND FOR THIS CRITERIA
                            </font>
                           </th>
                          </tr>
       "); 
   }
   print("                       
                         </table>
                        </div> 
   ");










   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =============
   // Headers Start 
   // ============= 
   //print("pcol: ".$pcol." pc3a = ".$pc3a." - paeend: ".$paeend." pc3b = ".$pc3b." - pweend: ".$pweend." pc3c = ".$pc3c."<br>");
   $cola = $pcol - $pc3a;
   $colb = $paeend - $pc3b;
   $colc = $pweend - $pc3c;
   $cold = $pc4h - $pc4a;
   $cole = $pc5h - $pc5a;
   //print("cola: ".$cola." - "."colb: ".$colb." - "."colc: ".$colc."<br>");
   print("<input type=\"button\" value=\"Toggle Detail Row Display\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");
   //$pcolx = $pcol - $pcol_supress;
   $captn = "PDP UAT REPORT";
   print(
          "<div id=\"Two\" class=\"cont2\">
            <div class=\"wrapper2\">
             <table id=\"theTable\" scroll=\"yes\" style=\"border-style:solid 1px; border-color:#CCCCCC; width=100%;\" >
              <caption >$captn</caption>
               <tr class=\"headerRow\">
                <th bgcolor=\"#CCCCCC\" colspan=\"$cola\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  PDP GENERAL INFORMATION
                 </font>
                </th>            
                <th bgcolor=\"#AFC7C7\" colspan=\"$colb\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  ISSUES AND BACK TO BUILD SUMMARY
                 </font>
                </th>            
                <th bgcolor=\"#CCCCCC\" colspan=\"$colc\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  REWORK EFFORT PER AREA
                 </font>
                </th>            
                <th bgcolor=\"#AFC7C7\" colspan=\"$cold\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  ISSUES CAUSE SUMMARY BY AREA
                 </font>
                </th>            
                <!--<th bgcolor=\"#CCFFCC\" colspan=\"$cole\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  ISSUES ROOT CAUSE SUMMARY
                 </font>
                </th>-->            
               </tr>
   ");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   // Open this for debugging
   //print("<tr class=\"headerRow\">");
   //for ($pc=1;$pc<=$pcol;++$pc) {
   //     if ($pdp_head_use[$pc] == 1) { 
   //         if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
   //             $wdth = "150px";
   //         } else {
   //             $wdth = "75px"; 
   //         }
   //         print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"#330099\">
   //                  $pc
   //                 </font>
   //                </th>        
   //         ");
   //    }   
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   //$bpc = 0;
   //for ($pc=1;$pc<=$paeend;++$pc) {
   //     $bpc = $bpc + 1;
   //     //if ($bpc == 3){ 
   //     //    $bcolr = "#E8E8E8";
   //     //    $fcolr = "#FF0000";
   //    //} else {
   //         $bcolr = "#AFC7C7";
   //         $fcolr = "#330099"; 
   //     //}
   //     if ($pae_head_use[$pc] == 1) {
   //         $wdth = "75px";
   //         print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"$fcolr\">
   //                  $pc
   //                 </font>
   //               </th>        
   //         ");
   //    } 
   //    if ($bpc == $paecol){
   //        $bpc = 0;
   //    }
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort
   // Open this for debugging
   //$bpc = 0;
   //for ($pc=1;$pc<=$pweend;++$pc) {
   //     $bpc = $bpc + 1;
   //     if ($bpc == 3){ 
   //         $bcolr = "#E8E8E8";
   //         $fcolr = "#FF0000";
   //     } else {
   //         $bcolr = "#CCCCCC";
   //         $fcolr = "#330099"; 
   //     }
   //     if ($pwe_head_use[$pc] == 1) {
   //         $wdth = "75px";
   //         print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"$fcolr\">
   //                  $pc
   //                 </font>
   //                </th>        
   //         ");
   //    }
   //    if ($bpc == $pwecol){
   //        $bpc = 0;
   //    }
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary
   // Open this for debugging
   //$bpc = 0;
   //for ($pc=1;$pc<=$pc4h;++$pc) {
   //     $bpc = $bpc + 1;
   //     $wdth = "75px";
   //     if ($bpc == 1){ 
   //         $bcolr = "#E8E8E8";
   //         $fcolr = "#FF0000";
   //     } else {
   //         $bcolr = "#AFC7C7";
   //         $fcolr = "#330099"; 
   //     }
   //     if ($pia_head_use[$pc] == 1){
   //         print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"$fcolr\">
   //                  $pc&nbsp$pia_head1[$pc]
   //                 </font>
   //                </th>        
   //         ");
   //     }
   //     if ($bpc == $pc4){
   //         $bpc = 0;
   //     }
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_issue_summary
   // Open this for debugging
   //for ($pc=1;$pc<=$pc5h;++$pc) {
   //     $wdth = "75px";
   //     if ($pii_head_use[$pc] == 1){       
   //         print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"#330099\">
   //                  $pc&nbsp$pii_head1[$pc]
   //                 </font>
   //                </th>        
   //         ");
   //     }
   //}
   //print("</tr>");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   print("<tr class=\"headerRow\">");
   for ($pc=1;$pc<=$pcol;++$pc) {
        if ($pdp_head_use[$pc] == 1) {
            if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
                $wdth = "150px";
            } else {
                $wdth = "75px"; 
            }
            print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"#330099\">
                     $pdp_head[$pc]
                    </font>
                   </th>        
            ");
       }   
   } 
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution                        
   $bpc = 0;
   for ($pc=1;$pc<=$paeend;++$pc) {
        $bpc = $bpc + 1;
        //if ($bpc == 3){ 
        //    $bcolr = "#E8E8E8";
        //    $fcolr = "#FF0000";
        //} else {
            $bcolr = "#AFC7C7";
            $fcolr = "#330099"; 
        //}
        if ($pae_head_use[$pc] == 1) {
            $wdth = "75px";
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pae_head[$pc]
                    </font>
                   </th>        
            ");
       }   
       if ($bpc == $paecol){
           $bpc = 0;
       }
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort                        
   $bpc = 0;
   for ($pc=1;$pc<=$pweend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#CCCCCC";
            $fcolr = "#330099"; 
        }
        if ($pwe_head_use[$pc] == 1) {
            $wdth = "75px";
            //if ($pc == 3 || $pc == 11){ 
            //    $wdth = "150px";
            //} else {
            //    $wdth = "75px"; 
            //}
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pwe_head[$pc]
                    </font>
                   </th>        
            ");
       }   
       if ($bpc == $pwecol){
           $bpc = 0;
       }
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary 
   $bpc = 0;                       
   for ($pc=1;$pc<=$pc4h;++$pc) {
        $bpc = $bpc + 1;
            $wdth = "75px";
                   if($piac[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "CNT"){
                      if($piar[$pc] == "NO" || $piar[$pc] == $pia_head[$pc]){
                         $bcolr = "#9AFEFF";
                        $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
                 if ($bpc == 1){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                }
        if ($pia_head_use[$pc] == 1){
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pia_head[$pc]
                    </font>
                   </th>        
            ");
        } 
        if ($bpc == $pc4){
                $bpc = 0;
        }
       //}   
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_issue_summary 
   //$bpc = 0;                       
   //for ($pc=1;$pc<=$pc5h;++$pc) {
   //         $wdth = "75px";
   //         if($piic[$pc] == "ROT"){
   //                   $bcolr = "#CCFFCC";
   //                   $fcolr = "#330099";
   //         }
   //         if($piic[$pc] == "GRT"){
   //                   $bcolr = "#FFFF00";
   //                   $fcolr = "#330099";
   //         }
   //         if($piic[$pc] == "CNT"){
   //                   if($piir[$pc] == "NO" || $piir[$pc] == $pii_head[$pc]){
   //                      $bcolr = "#9AFEFF";
   //                      $fcolr = "#330099";
   //                   } else {
   //                      $bcolr = "#FFFF00";
   //                      $fcolr = "#330099";
   //                   }
   //        }
   //         if ($pii_head_use[$pc] == 1){       
   //             print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                     <font color=\"$fcolr\">
   //                      $pii_head[$pc]
   //                     </font>
   //                    </th>        
   //             ");
   //         }
   //}                         
   print("</tr>");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   // ===========
   // Headers End 
   // =========== 


   // =============
   // Summary Start 
   // ============= 
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   // Open this for debugging
   print("<tr class=\"headerRow\">");
   for ($pc=1;$pc<=$pcol;++$pc) {
        if ($pdp_head_use[$pc] == 1) { 
            if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
                $wdth = "150px";
            } else {
                $wdth = "75px"; 
            }
            if ($pc == 21 || $pc == 22){
                if ($pc == 21){
                    print("<th bgcolor=\"#FFFFCC\" align=\"center\" colspan=\"2\" valign=\"top\" style=\"width: $wdth;\">
                            <font color=\"#FF0000\">
                             $analsis[$pc]
                            </font>
                           </th>        
                    ");
                }
            } else {
              if ($pc == 10){
                  $analsis[$pc] = $analsisi[$pc]."<br><br>".$isum." Issues<br><br>".$analsiso[$pc]."<br><br>".$osum." Issues<br><br>".$analsisn[$pc]."<br><br>".$nsum." Issues<br><br>";
              }
              print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"#FF0000\">
                     $analsis[$pc]
                    </font>
                   </th>        
              ");
            }
       }   
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$paeend;++$pc) {
        $bpc = $bpc + 1;
        //if ($bpc == 3 || $pc >= $paeend-2){
        //    $bcolr = "#E8E8E8";
        //    $fcolr = "#FF0000";
        //} else {
            $bcolr = "#FFFFCC";
            $fcolr = "#FF0000";
        //}
        if ($pae_head_use[$pc] == 1) {
            $wdth = "75px";
            if ($bpc == 5 || $bpc == 6 || $bpc >= 9 && $bpc <= 16 || $pc >= $paeend-2){
			    if ($bpc == 11 || $bpc == 12){
				    $analsis2[$pc] = "&nbsp";
				}
                print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"$fcolr\">
                         $analsis2[$pc]
                        </font>
                       </th>        
                ");
            } else {
                print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     &nbsp
                    </font>
                   </th>        
                ");
              //}  
            }
        }
        if ($bpc == $paecol){
            $bpc = 0;
        }
   }
   //$colsp = $colc + $pc4h + $pc5h;
   //print("<th bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" colspan=\"$colsp\">
   //                 <font color=\"#330099\">
   //                  &nbsp
   //                 </font>
   //                </th>        
   //");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   //for ($pc=1;$pc<=$paeend;++$pc) {
   //     if ($pae_head_use[$pc] == 1) {
   //         $wdth = "75px";
   //         print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
   //                 <font color=\"#330099\">
   //                  $pc
   //                 </font>
   //                </th>        
   //         ");
   //    }   
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort
   // Open this for debugging
   $bpc = 0;
   //print("PWECOL: ".$pwecol."<br>");
   for ($pc=1;$pc<=$pweend;++$pc) {
        $bpc = $bpc + 1;
        //if ($bpc == 3){
        //    $bcolr = "#E8E8E8";
        //    $fcolr = "#FF0000";
        //} else {
            $bcolr = "#FFFFCC";
            $fcolr = "#FF0000";
        //}
        //print("PC: ".$pc." - BPC: ".$bpc."HEADING: ".$pwe_head_use[$pc]."<br>");
        if ($pwe_head_use[$pc] == 1) {
            $wdth = "75px";
            if ($bpc >= 4 && $bpc <= 7){ 
                if ($bpc == 6 || $bpc == 7){
                  $bpcx = $pc - 2;
                  print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                          <font color=\"$fcolr\">
                           $analsis3[$pc]%<br><br>$analsis3[$bpcx]<br>Hours
                          </font>
                         </th>        
                  ");
                } else {
                  print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                          <font color=\"$fcolr\">
                           $analsis3[$pc]
                          </font>
                         </th>        
                  ");
                }
           } else {
                print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"$fcolr\">
                         &nbsp
                        </font>
                       </th>        
                ");
           }
       }   
       if ($bpc == $pwecol){
           $bpc = 0;
       }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$pc4h;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 1){
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#FFFFCC";
            $fcolr = "#330099";
        }
        $wdth = "75px";
        if ($pia_head_use[$pc] == 1){
          if (trim($piaxp[$pc]) == 1){
              //if ($grtchk[$pc] == 0){
              //    $analsis4x[$pc] = $analsis4x[$pc]."<br>NOT USED";
              //}
              print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                      <font color=\"$fcolr\">
                       $analsis4[$pc]<br> $analsis4x[$pc]
                      </font>
                      </th>        
              ");
          } else { 
             print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                      <font color=\"$fcolr\">
                       $analsis4[$pc]
                       </font>
                     </th>        
              ");
          } 
        }    
        if ($bpc == $pc4){
            $bpc = 0;
        }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_issue_summary
   // Open this for debugging
   //for ($pc=1;$pc<=$pc5h;++$pc) {
   //     $wdth = "75px";
   //     $wdth = "75px";
   //     if (trim($piixp[$pc]) == 1){
   //         //if ($grtchk2[$pc] == 0){
   //         //    $analsis5x[$pc] = $analsis5x[$pc]."<br><br>NOT USED";
   //         //}
   //         if ($pii_head_use[$pc] == 1){       
   //             if ($piic[$pc] == "ROT"){
   //                 //$analsis5[$pc]<br><br>$totalrot2<br><br>$analsis5x[$pc]   (was there below initially)
   //                 if ($sum5[$pc] == 0){
   //                     $prcsum5 = 0;
   //                 } else {
   //                   $prcsum5 = round(($sum5[$pc]/$totalrot2)*100,2);
   //                 }
   //                 print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                         <font color=\"#FF0000\">
   //                          $analsis5[$pc]  out of $totalrot2 ($prcsum5)%<br>$analsis5x[$pc]
   //                         </font>
   //                        </th>        
   //                 ");
   //             }
   //         }
   //     } else {
   //         if ($pii_head_use[$pc] == 1){       
   //             if ($piic[$pc] == "ROT"){
   //                 //$analsis5[$pc]<br><br>$totalrot2       (was there below initially)
   //                 if ($sum5[$pc] == 0){
   //                     $prcsum5 = 0;
   //                 } else {
   //                   $prcsum5 = round(($sum5[$pc]/$totalrot2)*100,2);
   //                }
   //                 print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                         <font color=\"#FF0000\">
   //                          $analsis5[$pc] out of $totalrot2 ($prcsum5)%
   //                         </font>
   //                        </th>        
   //                 ");
   //             }
   //             if ($piic[$pc] == "GRT"){
   //                 print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                         <font color=\"#FF0000\">
   //                          $analsis5[$pc]
   //                         </font>
   //                        </th>        
   //                 ");
   //             }
   //             if ($piic[$pc] == "CNT"){
   //                 print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                         <font color=\"#FF0000\">
   //                          $analsis5[$pc]<br><br>$totalcnt2
   //                         </font>
   //                        </th>        
   //                 ");
   //             }
   //         }
   //     }    
   //     //print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
   //     //        <font color=\"#330099\">
   //     //         $analsis5[$pc]
   //     //        </font>
   //     //       </th>        
   //     //");
   //}
   print("</tr>");
   // ===========
   // Summary End 
   // =========== 















   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =============
   // Details Start 
   //$rowcount = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
    //if ($xpdp[$tp][$pcol] == 1){
        //$rowcount = $rowcount + 1;
        print("<tr>");
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_main
        for ($pc=1;$pc<=$pcol;++$pc) {
             if ($pdp_head_use[$pc] == 1) { 
                 if ($pc == 3 || $pc == 11){ 
                     $wdth = "150px";
                 } else {
                     $wdth = "75px"; 
                 }
                 //if ($pc == 1){
                     //$val = $rowcount;
                 //} else {
                 $val = $xpdp[$tp][$pc];
                 //}
                 if ($pc == 2){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     if ($pc == 20){
                        if ($val == 0){
                            $bcolr = "#FFFFFF";
                            $fcolr = "#330099";
                        } else {
                            $bcolr = "#CCFFCC";
                            $fcolr = "#330099";
                        }   
                     } else {
                       $bcolr = "#FFFFFF";
                       $fcolr = "#330099";
                     }
                 }
                 if ($pc == 2){
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            <!--<a href=\"javascript:void(0);\" onclick=\"PopupCenter('../pdp_issue_summary.php?pdpdesc=$val', 'myPop1',1200,800);\">$val</a>-->
                            <a href=\"javascript:void(0);\" onclick=\"popup('../pdp_issue_summary.php?pdpdesc=$val')\">$val</a>
                           </font>
                          </td>        
                   ");
                 } else {
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            $val
                           </font>
                          </td>        
                   ");
                 }
             }   
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_execution
        $bpc = 0;
        for ($pc=1;$pc<=$paeend;++$pc) {
             $bpc = $bpc + 1;
             if ($pae_head_use[$pc] == 1) {
                 $wdth = "75px"; 
                 $val = $pae[$tp][$pc]; 
                 if (($bpc == 3 || $bpc == 4 || $bpc == 5 || $bpc == 6) || $pc >= ($paeend - 2)){ 
                   if ($val == 0){
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099";
                   } else {
                     $bcolr = "#CCFFCC";
                     $fcolr = "#330099";
                   }   
                 }
                 if ($bpc == 11 || $bpc == 12){ 
                   if ($val <> "&nbsp"){
				       if ($val == "2007-01-01"){
					       $bcolr = "#FFFF00";
					   } else {
                         $bcolr = "#CCFFCC";
					  }
                      $fcolr = "#330099";
                   } else {
                      $bcolr = "#FFFFFF";
                      $fcolr = "#330099";
                   }   
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             }
             if ($bpc == $paecol){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_work_effort
        $bpc = 0;
        for ($pc=1;$pc<=$pweend;++$pc) {
             $bpc = $bpc + 1;
             if ($pwe_head_use[$pc] == 1) {
                 $wdth = "75px"; 
                 if ($bpc == 6 || $bpc == 7){
                     $val = $pwe[$tp][$pc]."%";
                 } else {
                     $val = $pwe[$tp][$pc];
                 }
                 
                 if ($bpc == 3 || $bpc == 4 || $bpc == 5 || $bpc == 6 || $bpc == 7){ 
                     //$bcolr = "#E8E8E8";
                     //$fcolr = "#FF0000";
                 //} else {
                   if ($val == "0.00%"){
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099";
                   } else {
                     $bcolr = "#CCFFCC";
                     $fcolr = "#330099";
                   }   
                     //$bcolr = "#FFFFFF";
                     //$fcolr = "#330099"; 
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             }
             if ($bpc == $pwecol){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_issue_summary
        //$bpc = 0;
        for ($pc=1;$pc<=$pc4h;++$pc) {
             $bpc = $bpc + 1;
                 $wdth = "75px"; 
                 $val = $pia[$tp][$pc];
                 if ($bpc == 1){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099"; 
                 }
                 if ($val == 0){
                } else {
                   if($piac[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                     $fcolr = "#330099";
                   }
                   if($piac[$pc] == "CNT"){
                      if($piar[$pc] == "NO" || $piar[$pc] == $pia_head[$pc]){
                         $bcolr = "#9AFEFF";
                         $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
                      
                 }
                 if ($pia_head_use[$pc] == 1){
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            $val
                           </font>
                          </td>        
                   ");
                 }
             if ($bpc == $pc4){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_issue_summary
        //$bpc = 0;
        //for ($pc=1;$pc<=$pc5h;++$pc) {
        //     $bpc = $bpc + 1;
        //         $wdth = "75px"; 
        //         $val = $pii[$tp][$pc];
        //         if ($val == 0){
        //             $bcolr = "#FFFFFF";
        //             $fcolr = "#330099";
        //         } else {
        //           if($piic[$pc] == "ROT"){
        //              $bcolr = "#CCFFCC";
        //             $fcolr = "#330099";
        //           }
        //           if($piic[$pc] == "GRT"){
        //              $bcolr = "#FFFF00";
        //              $fcolr = "#330099";
        //           }
        //           if($piic[$pc] == "CNT"){
        //              if($piir[$pc] == "NO" || $piir[$pc] == $pii_head[$pc]){
        //                 $bcolr = "#9AFEFF";
        //                 $fcolr = "#330099";
        //              } else {
        //                 $bcolr = "#FFFF00";
        //                 $fcolr = "#330099";
        //              }
        //           }
        //              
        //         }
        //         if ($pii_head_use[$pc] == 1){    
        //             print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
        //                     <font color=\"$fcolr\">
        //                      $val
        //                     </font>
        //                    </td>        
        //             ");
        //         }
        //     if ($bpc == $pc4){
        //         $bpc = 0;
        //     }
        //}
        print("</tr>");
    //}    
   }
   print("     </table>
              </div>
             </div>
            </body>
           </html>                     
   ");
   // =============
   // Details End 
   // ============= 
   $xfilters = "Type = ".$prd."<br>REVENUE ASSURANCE TESTING = ".$ra_ind."<br>PDP CATEGORY = ".$pdpcat."<br>LAUNCH DATE BETWEEN ".$xldate." AND ".$xldate2;
   $xreport_name = "PDP_UAT_REPORT"; 
   //var_dump($xreport_contents); 
   $query99      = " INSERT into ".$name.".saved_reports(report_name,filters,etl_id,ran_by) 
                     VALUES('$xreport_name','$xfilters','$yetl_id','$usr')"; 
   $mysql_data99 = mysql_query($query99, $mysql_link) or die ("#insert saved_reports - Could not query: ".mysql_error());
   $savedrepid   = mysql_insert_id();
   $xreport_path = $xreport_pth.$savedrepid."-".$xreport_nam;
   $query100      = " UPDATE ".$name.".saved_reports
                         SET report_path = '$xreport_path' 
                       WHERE saved_report_id = '$savedrepid' "; 
   $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#update saved_reports - Could not query: ".mysql_error());
   $loc  =  $_SERVER['REQUEST_URI'];
   //print($loc."<br>");
   $locx = substr($loc,0,-15);
   //print($locx."<br>");   
   $pagelink = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$locx."/reports/". $savedrepid."-".$xreport_nam;             //getenv('REQUEST_URI');
   print("               <table>
                          <tr>
                           <th bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">LOCATION</font>
                           </th>
                           <th bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:600px;\">
                            <font color=\"#000000\">$pagelink</font>
                           </th>
                          </tr>
   						 </table> 
   ");
   $xreport_contents = ob_get_clean();
   //$replen = strlen($xreport_contents);
   //print($xreport_contents);
   $f = fopen($xreport_path, "w+") or die ("could not open file.");
   fwrite($f, $xreport_contents) or die ("could not write to file");
   fclose($f);
   $found = 0;
   $start = 0;
} else {
  // ------------ //
  $found = 0;
  ob_end_clean();
  // ------------ //
}
// ================================================================================================================
// ================================================================================================================
if ($found == 0) {
    if ($start <> 1){
        print($hstart);
    }
    $query1      = " select max(etl_id)
                       from ".$name.".etl_batches ";  
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1     = mysql_num_rows($mysql_data1);
    //print("$query1"."<br>".$rowcnt1."<br>");
    while($row1 = mysql_fetch_row($mysql_data1)) {
	         $yetl_id = stripslashes($row1[0]);
    }

    //$ind[0]    = "ALL";
    $ind[1]      = "YES";
    $ind[2]      = "NO";
    //$ind_id[0] = 0;
    $ind_id[1]   = 1;
    $ind_id[2]   = 0;

    // PDP Type
    //$queryt = "select distinct(pdp_type) from ".$name.".cube1_main";
    $queryt = "select distinct(pdp_period) from ".$name.".pdp_periods";
    $mysql_datat = mysql_query($queryt, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcntt = mysql_num_rows($mysql_datat); 
    $prdcnt = 0;
    while($rowt = mysql_fetch_row($mysql_datat)) {
          $prdcnt            = $prdcnt + 1;
          $pdp_prd           = stripslashes($rowt[0]);
          $xpdp_prd[$prdcnt] = $pdp_prd;
    }
    $captn = "Select Criteria";
    print("<form method=\"post\" action=\"./report_uat.php\">
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">Select PDP Type:</font>
             </td>
             <td> 
              <select name=\"prd\">
    ");
    $p = 0;
    print("<option selected value=\"ALL\">ALL</option>");
    for ($p=1;$p<=$prdcnt ; ++$p) {
        print("<option value=\"$xpdp_prd[$p]\">$xpdp_prd[$p]</option>");
    }     
    print("
              </select>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">
               RA Testing:
              </font>
             </td>
             <td align=\"left\" valign=\"middle\">
              <select align=\"left\" name=\"ra_ind\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
    ");
    $e = 0;
    print(" <option selected value=\"BOTH\">BOTH</option> ");
    for ($e=1;$e<=2; ++$e) {
         print(" <option value=\"$ind[$e]\">$ind[$e]</option> "); 
    }                         
    print("   </select>
             <input type=\"hidden\" name=\"yshort_desc\" value=\"RA\"> 
             </td>
    ");         
    //$queryt1       = "select distinct(pdp_category) 
    //                    from ".$name.".cube1_main
    //                   where pdp_category <> '' ";
    $queryt1       = "select concat(c.category_scope,' - ',p.pdp_category) as pdpcat 
                        from ".$name.".pdp_categories p, category_scope c
                       where p.category_scope_id = c.category_scope_id 
                    group by c.category_scope,p.pdp_category ";
    $mysql_datat1  = mysql_query($queryt1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1       = mysql_num_rows($mysql_datat1); 
    $catcnt        = 0;
    while($rowt1 = mysql_fetch_row($mysql_datat1)) {
          $catcnt            = $catcnt + 1;
          $pdpcat            = stripslashes($rowt1[0]);
          $xpdpcat[$catcnt] = $pdpcat;
    }
    print(" <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">Select PDP Category:</font>
             </td>
             <td> 
              <select name=\"pdpcat\">
    ");
    $yyr  = date("Y");
	//print($yyr."<br>");
    $c    = 0;
    print("<option selected value=\"ALL\">ALL</option>");
    for ($c=1;$c<=$catcnt ; ++$c) {
        print("<option value=\"$xpdpcat[$c]\">$xpdpcat[$c]</option>");
    }     
    print("
              </select>
             </td>
            </tr> 
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\"><font color=\"#330099\">Actual Start Date (dd-mm-yyyy)</font></td>
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:150px;\">
              <font color=\"#330099\">
    ");
    $yms = 9;
    print(" <select align=\"left\" name=\"xds\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
         if ($yds == $xdy_s) {
             print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
         } else {
             print(" <option value=\"$xdy_s\">$xdy_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xms\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
         if ($yms == $xmon_s) {
             print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
         } else {
             print(" <option value=\"$xmon_s\">$xmon_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xys\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xyr_s=2010;$xyr_s<=2015; ++$xyr_s) {
         if ($xyr_s == $yyr) {
             print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
         } else {
             print(" <option value=\"$xyr_s\">$xyr_s</option> ");
         }
    }
    print("    
               </font>
              </select>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\"><font color=\"#330099\">Actual End Date (dd-mm-yyyy)</font></td>
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:150px;\">
              <font color=\"#330099\">
    ");
    print(" <select align=\"left\" name=\"xde\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
         if ($yds == $xdy_s) {
             print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
         } else {
             print(" <option value=\"$xdy_s\">$xdy_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xme\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
         if ($yms == $xmon_s) {
             print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
         } else {
             print(" <option value=\"$xmon_s\">$xmon_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xye\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xyr_s=2010;$xyr_s<=2015; ++$xyr_s) {
         if ($xyr_s == $yyr) {
             print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
         } else {
             print(" <option value=\"$xyr_s\">$xyr_s</option> ");
         }
    }
    print("    
               </font>
              </select>
             </td>
            </tr>
            <tr>
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
              <input type=\"hidden\" name=\"yetl_id\" value=\"$yetl_id\">
             </td>
            </tr>
           </table>
          </form>  
           <br><br>
   ");
  
   $captn = "Saved Reports";

   if ($submit == "Submit") {
	while (list($key) = each($delete)) {
		   $query = "DELETE FROM ".$name.".saved_reports WHERE saved_report_id = '$key' ";
		   $mysql_data = mysql_query($query, $mysql_link);
		   unlink($delfile[$key]);
	}
   }

   print("<form method=\"post\" action=\"./report_uat.php\"> 
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
              <tr>
               <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">ID</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Pathname</font</td>-->
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width: 400px;\"><font color=\"#330099\">Ran Date</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Ran By</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Extract</font</td>-->
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
              </tr>
   ");

   $query = "  select saved_report_id,report_name,filters,report_path,etl_id,report_timestamp,ran_by from ".$name.".saved_reports
                where rtrim(report_name) = 'PDP_UAT_REPORT'
                  and ran_by = '$usr'
             order by filters,report_timestamp desc"; 
             //and etl_id = '$yetl_id'  
   $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcnt = mysql_num_rows($mysql_data); 

   $seq = 0;
   while($row = mysql_fetch_row($mysql_data)) {
    $seq                     = $seq + 1;
	$wid[$seq]               = stripslashes($row[0]);
    $wreport_name[$seq]      = stripslashes($row[1]);
	$wfilters[$seq]          = stripslashes($row[2]);
	$wreport_path[$seq]      = stripslashes($row[3]);
	$wreport_path2[$seq]     = str_replace("./reports/","",$wreport_path[$seq]);
	$wetl_id[$seq]           = stripslashes($row[4]);
	$wreport_timestamp[$seq] = stripslashes($row[5]);
	$wran_by[$seq]           = stripslashes($row[6]);
    $save_id                 = $wid[$seq];
    $del_file                = $wreport_path[$seq];
    
    $query0      = "select etl_timestamp
                      from ".$name.".etl_monitor
                     where etl_id = '$wetl_id[$seq]' ";  
    $mysql_data0 = mysql_query($query0, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt0     = mysql_num_rows($mysql_data0);
    while($row0 = mysql_fetch_row($mysql_data0)) {
          $yetl_timestamp = stripslashes($row0[0]);
    }
    
    $seq1 = $seq - 1;
    if (($seq <> 0) && ($wfilters[$seq] <> $wfilters[$seq1])){
	print("   <tr>
	            <td colspan=\"6\" align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                  $wfilters[$seq]
                 </font>   
	            </td>
	          </tr>  
    ");    
    }
	print("   <tr>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                 $seq 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#330099\"> 
                  $wid[$seq]
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width: 400px;\">
	             <font color=\"#330099\">
                  <a href=\"javascript:void(0);\" onclick=\"PopupCenter('$wreport_path[$seq]', 'myPop1',1200,800);\">$wreport_path2[$seq]</a>
                 </font>  	             
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                  $wran_by[$seq]
                 </font>  	             
	            </td>
	            <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                  $yetl_timestamp
                 </font>  	             
	            </td>-->
                <td align=\"center\" bgcolor=\"#E8E8E8\">
                 <input type=\"checkbox\" name=\"delete[$save_id]\" value=\"Delete\">
                 <input type=\"hidden\" name=\"delfile[$save_id]\" value=\"$del_file\">
                </td>
	          </tr>
	     ");
   }
      
   print(" </table>           
            <input type=\"submit\" name=\"submit\" value=\"Submit\">
            <input type=\"hidden\" name=\"start\" value=\"0\">
          </form>  
    "); 
}
//var_dump();
print("  </body>
       </html>
");
mysql_close($mysql_link);
?>
