<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

// ================================================================================================================
// ================================================================================================================
// =========================================== INITIALIZATION START ===============================================
// ================================================================================================================
// ================================================================================================================
// ============================== SESSION START ==============================
session_start();
$xsession = session_id();
$querys5 = "SELECT user FROM ".$name.".sessions
                WHERE sessionid = trim('$xsession')" ;
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#1 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
}
// =============================== SESSION END ===============================
// ============================== STATUS TYPE START ==============================
$query69               = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,
                                 a.issue_seq,a.report_group_id
                            from ".$name.".issue_types a, issue_class b
                           where a.issue_class_id = b.issue_class_id
                        order by b.issue_class_code desc,a.issue_seq asc"; 
$mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
$rowcnt69              = mysql_num_rows($mysql_data69); 
$icnt                  = 0;
while($row69           = mysql_fetch_row($mysql_data69)) {
      $icnt            = $icnt + 1;
      $iid[$icnt]      = stripslashes($row69[0]);        //Issue_id
      $ityp[$icnt]     = stripslashes($row69[1]);        //issue_type
      $ityp_ind[$icnt] = stripslashes($row69[2]);
      $iccd[$icnt]     = trim(stripslashes($row69[3]));  //issue_class_code
      //$iseq[$icnt]     = stripslashes($row69[4]);
      $irgrpid[$icnt]  = stripslashes($row69[5]);
      $igrp[$icnt]     = 0;
      // find out report group for each issue type
      if ($irgrpid[$icnt] == 0) {
          $irgrp[$icnt]   = "NO";
      } else {
        $query96        = "select report_group
                             from ".$name.".report_groups
                            where report_group_id = '$irgrpid[$icnt]' "; 
        $mysql_data96   = mysql_query($query96, $mysql_link) or die ("#2.5 Could not query: ".mysql_error());
        $rowcnt96       = mysql_num_rows($mysql_data96); 
        while($row96        = mysql_fetch_row($mysql_data96)) {
              $irgrp[$icnt] = stripslashes($row96[0]);
              // find out if this group has other issue types from prvious $icnt, if yes create a tcnt[$icnt] else do
              $ifound = 0;
              for ($x=1;$x<=$icnt-1;++$x) {
                   if ($irgrp[$icnt] == $irgrp[$x]){
                       $ifound = 1;
                   }
              }
              if ($ifound == 0){
                  print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
                  $icnt            = $icnt + 1;
                  $iid[$icnt]      = 0;                 //Issue_id        
                  $ityp[$icnt]     = $irgrp[$icnt-1];   //New Type is the group Name
                  $ityp_ind[$icnt] = 1;                 //Valid 
                  $iccd[$icnt]     = $iccd[$icnt-1];    //Class Code of the Issue Type the Report Group was found first
                  $irgrpid[$icnt]  = 0;
                  $irgrp[$icnt]    = $irgrp[$icnt-1];
                  $igrp[$icnt]     = 1;
              }
        }
      }     
      print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
}
// =============================== ISSUE TYPE END ===============================
// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
               order by issue_area_id ";
                                 //where test_ind = 1 
                // where issue_area_ind = 1 and test_ind = 1    
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
      print($dcnt." - ".$dpt[$dcnt]." - ".$dind[$dcnt]." - ".$dti[$dcnt]." - ".$dind[$dcnt]."<br>");
}
print("<br><br>");
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
$cat[$ccnt]   = "NOT ASSIGNED";
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
      print($mid[$mcnt]." = ".$mil[$mcnt]." - ".$mit[$mcnt]."<br>");
}      
// ================================ MILESTONES END ================================
// ================================================================================================================
// ================================================================================================================
// ============================================= INITIALIZATION END ===============================================
// ================================================================================================================
// ================================================================================================================
// setting up today's date
//$yw        = date("D");
//$yd        = date("d");
//$ym        = date("m");
//$yy        = date("Y");
//$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
//$ym        = date("M");
//$ydate     = $yw." ".$yd."-".$ym."-".$yy;
print("<html>
        <head>
         <style>
             body    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px; 
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
             caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
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
                       color: #000000;
                     }
            a:visited 
                     {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
            a:hover  {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: underline overline;
                       color: #FF0000;
                     }
            a:active {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
         </style>       
         <script type=\"text/javascript\">
                 function PopupCenter(pageURL, title,w,h)
                  {
                    var left = (screen.width/2)-(w/2);
                    var top = (screen.height/2)-(h/2);
                    var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                  }
         </script>
        </head>
        <body>
");  

   // =========================================================================================
   // ====================================== ETL START ========================================
   // =========================================================================================
   // writing etl_monitor
   //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
   $xjob_log      = "Job Started at: ".date("l F d, Y, h:i:s A").chr(10)."Query:".chr(10).$queryx.chr(10);
   $xjob_log_y    = "Job Started at: ".date("l F d, Y, h:i:s A")."<br> Query:<br>".$queryx."<br>";     
   $query101      = "INSERT into ".$name.".etl_monitor(etl_status,target_cube,header_rows,detail_rows,
                                                       footer_rows,ran_by,job_log)
                     VALUES('ETL Started','cube_1_main',0,0,0,'$usr','$xjob_log')";
   $mysql_data101 = mysql_query($query101, $mysql_link) or die ("#6 Could not query: ".mysql_error());
   $xetl_id       = mysql_insert_id();
   //$etlfile       = "/".$xetl_id."-".date("dmY");
   //$etlfolder     = "/etl";
   //$etlpath       = $etlfolder.$etlfile;   
   //chmod($etlfolder,0777);
   //chmod($etlpath,0666);
   //print("<br> ETL File: ".$etlpath."<br><br>");
   print($xjob_log_y);
   $xjob_log      = $xjob_log.chr(10)."ETL ID: ".$xetl_id.chr(10);
   $xjob_log_x    = $xjob_log.chr(10)."ETL ID: ".$xetl_id.chr(10);
   $xjob_log_y    = "ETL ID: ".$xetl_id."<br>"; 
   // updating status
   $query111      = "UPDATE ".$name.".etl_monitor
                        SET job_log    = '$xjob_log',
                            etl_status = 'ETL In-progress'
                      WHERE etl_id     = '$xetl_id' ";
   $mysql_data111 = mysql_query($query111, $mysql_link) or die ("#7 Could not query: ".mysql_error());
   print($xjob_log_y);
   //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

   $queryx      = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                          a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                          a.revenue_id,a.comparison_id,a.pdp_period_id,a.main_pdp_id,a.parent_pdp_id 
                     from ".$name.".pdp a 
                 order by a.main_pdp_id,a.pdp_id ";
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#8 Could not query: ".mysql_error());
   $rowcntx     = mysql_num_rows($mysql_datax);
   //$trucnt      = 0;
   $seq1        = 0;
   $seq         = 0;
   // =========================================================================================
   // ====================================== EXTRACT PDP ======================================
   // =========================================================================================
   if ($rowcntx > 0) {
       //$found  = 1;
       $tbrun    = 0;
       $tinvc    = 0;
       $tppw     = 0;
       $tdfct    = 0;
       $tprwk    = (float)0;
       $tisue    = 0;
       //$t_total  = array();
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       $xjob_log   = $xjob_log.chr(10)."Extracting PDPs ...".chr(10);
       $xjob_log_y = "Extracting PDPs ...<br>"; 
       print($xjob_log_y);
       print("<br><br><br><br><br>");
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
             $xpdp_category_id = stripslashes($rowx[9]);
             $xcomplexity_id   = stripslashes($rowx[10]);
             $xprojection_id   = stripslashes($rowx[11]);
             $xrevenue_id      = stripslashes($rowx[12]);
             $xpast_id         = stripslashes($rowx[13]);
             $xpdp_period_id   = stripslashes($rowx[14]);
             $xmain_pdp_id     = stripslashes($rowx[15]);
             $xparent_pdp_id   = stripslashes($rowx[16]);
             $xpdp_name        = str_replace("'","",$xpdp_name);
             $xpdp_owner       = str_replace("'","",$xpdp_owner);
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             print("<br><br>====================================================================================<br><br>");
             $xjob_log   = $xjob_log.chr(10)."Extracting PDP $xpdp_desc".chr(10);
             $xjob_log_y = "Extracting PDP $xpdp_desc<br>"; 
             print($xjob_log_y);
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             // =========================================================================================
             // =================================== EXTRACT PDP PERIOD ==================================
             // =========================================================================================
             if (empty($xparent_pdp_id) && empty($xmain_pdp_id)){
                 $xparent_pdp_id = $xpdp_period_id;     //$xid;
                 $xmain_pdp_id   = $xpdp_period_id;     //$xid;
             }
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
                  if ($xpdp_category_id == $cid[$c]){
                      $xscoping         = $scp[$c];
                      $xcategory        = $cat[$c];
                      $xfound           = 1;
                  }
             }
             if ($xfound == 0) {
                 $xcategory             = "NOT SET";  
             }
             $xfound = 0;
             for ($s=1;$s<=$scnt ; ++$s) {
                  if ($xpdp_complexity_id == $sid[$s]){
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
                  if ($xpdp_projection_id == $sid[$s]){
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
                  if ($xpdp_revenue_id == $sid[$s]){
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
                  if ($xpdp_past_id == $sid[$s]){
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
             $query42      = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,
                                     bill_run_count,ppw_update,comments,launch_ind,defects,
                                     running_comments 
                                from ".$name.".pdp_execution 
                               where pdp_id = '$xid' "; 
             $mysql_data42 = mysql_query($query42, $mysql_link) or die ("#15 Could not query: ".mysql_error());
             $rowcnt42     = mysql_num_rows($mysql_data42);
             if ($rowcnt42 == 0) {
                 $xstart_date         = "0000-00-00 00:00:00";
                 $xend_date           = "0000-00-00 00:00:00";
                 $yinvoice_cnt        = 0;
                 $ybillrun_cnt        = 0;
                 $yppw_update         = 0;
                 $ydefects            = 0;
                 $ylaunch             = "TBD";
                 $total_baseline      = 0;
                 $total_incremental   = 0;           
                 $percent_incremental = 0;
             } else {
               while($row42           = mysql_fetch_row($mysql_data42)) {
                     $yexecution_id   = stripslashes($row42[0]);
                     $yid             = stripslashes($row42[0]);
                     $ypdp_id         = stripslashes($row42[1]);
                     $ystart_dt       = stripslashes($row42[2]);
                     $yend_dt         = stripslashes($row42[3]);
                     $yupdated_by     = stripslashes($row42[4]);
                     $yinvoice_cnt    = stripslashes($row42[5]);
                     $ybillrun_cnt    = stripslashes($row42[6]);
                     $yppw_update     = stripslashes($row42[7]);
                     $ycomments       = stripslashes($row42[8]);
                     $ylaunch_ind     = stripslashes($row42[9]);
                     $yrunning_com    = nl2br(stripslashes($row42[11]));
                     //$tbrun           = $tbrun + $ybillrun_cnt;
                     //$tinvc           = $tinvc + $yinvoice_cnt;
                     //$tppw            = $tppw  + $yppw_update;
                     //$tdfct           = $tdfct + $ydefects;
                     // launch in jeopardy
                     if ($ylaunch_ind == 0){
                         $ylaunch     = "NO";
                     } else {
                         $ylaunch     = "YES";
                     }
                     // Testing Start Date
                     if (!empty($ystart_dt)){
	                     $yds         = date("d",$ystart_dt);
                         $yms         = date("m",$ystart_dt);
                         $yms2        = date("M",$ystart_dt);
                         $yys         = date("Y",$ystart_dt);
                         $ysdt        = "$yds"."-"."$yms2"."-"."$yys";
                         $xstart_date = date("Y-m-d)",$ystart_dt)." 00:00:00";
                     } else {
                         $ysdt = "-";
                         $xstart_date = "0000-00-00 00:00:00";    
                     }
                     // Testing End Date
                     if (!empty($yend_dt)){
	                     $yde         = date("d",$yend_dt);
                         $yme         = date("m",$yend_dt);
                         $yme2        = date("M",$yend_dt);
                         $yye         = date("Y",$yend_dt); 
                         $yedt        = "$yde"."-"."$yme2"."-"."$yye";
                         $xend_date   = date("Y-m-d)",$yend_dt)." 00:00:00";
                     } else {
                         $yedt        = "-";
                         $xend_date   = "0000-00-00 00:00:00";
                     }
                     // ========================= Select Execution Milstones & Iterations ===================== 
                     $query44            = "select execution_id,milestone_id,iteration_count
                                              from ".$name.".milestone_surrogates 
                                             where execution_id = $yexecution_id
                                          order by execution_id,milestone_id ";
                     //print($query44);                        
                     $mysql_data44       = mysql_query($query44, $mysql_link) or die ("#16 Could not query: ".mysql_error());
                     $rowcnt44           = mysql_num_rows($mysql_data44);
                     //$eseq             = 0;
                     $total_baseline     = 0;
                     $total_incremental  = 0;
                     while($row44 = mysql_fetch_row($mysql_data44)) {
                           //$eseq              = $eseq + 1;
                           //$yexecution_id     = stripslashes($row44[0]);
                           $ymilestone_id     = stripslashes($row44[1]);
                           //$zid             = stripslashes($row44[1]);
                           $yiteration_cnt    = stripslashes($row44[2]);
                           // ========================= Select Execution Milstones & Iterations ===================== 
                           for ($m=1;$m<=$mcnt; ++$m) {
                                if ($ymilestone_id == $mid[$m]) {                                 
                                    //$ymilestone        = $mil[$m];
                                    $ymilestone_time   = $mit[$m];
                                    $ybaseline_time    = $ymilestone_time;
                                    $yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                                    $total_baseline    = $total_baseline + $ybaseline_time;
                                    $total_incremental = $total_incremental + $yincremental_time;
                                }
                           }      
                     }
                     print("<br>Total Baseline: ".$total_baseline."<br>Total Incremental: ".$total_incremental."<br>");
                     $total_time          = round($total_baseline + $total_incremental,2);
                     $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
                     $percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ;
                     //$tbasewk             = (float)$tbasewk + (float)$total_baseline;
                     //$trewk               = (float)$trewk + (float)$total_incremental;
                     //$tprwk               = (float)$tprwk + (float)$percent_incremental; 
               }
             }
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             $xjob_log   = $xjob_log.chr(10)."PDP, Scoping, Tracker details extracted for $xpdp_desc".chr(10);
             $xjob_log_y = "PDP, Scoping, Tracker details extracted for $xpdp_desc<br>"; 
             print($xjob_log_y);
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
                  for ($d=1;$d<=$dcnt;++$d) {
                       $dpti[$i][$d] = 0;
                  }
             }
             $query80      = "select a.issue_id,a.issue_desc,a.created_by,a.created_on,b.issue_area
                                from ".$name.".issues a, issue_areas b
                               where a.pdp_id = '$xid' 
                                 and a.void   = 0
                                 and a.issue_area_id = b.issue_area_id
                            order by a.issue_id";
             // ----->>>>>>>> print("SQL: Get all Issues for this PDP<br>"."$query80"."<br>");               
             print("SQL: Get all Issues for this PDP<br>"."$query80"."<br>");
             $mysql_data80 = mysql_query($query80, $mysql_link) or die ("#17 Could not query: ".mysql_error());
             $rowcnt80     = mysql_num_rows($mysql_data80);
             $xjob_log   = $xjob_log.chr(10)."$picnt Valid issues identified for $xpdp_desc".chr(10);
             $xjob_log_y = "$rowcnt80 Valid issues identified for $xpdp_desc<br><br>"; 
             print($xjob_log_y);
             for ($i=1;$i<=$icnt ; ++$i) {
                  $tcnt[$i] = 0;
             }
             if ($rowcnt80 == 0) {
                  $picnt  = 0;
                  $bypass = 1;
                  //$xjob_log   = $xjob_log.chr(10)."$picnt Valid issues identified, and analysed for $xpdp_desc".chr(10);
                  //$xjob_log_y = "$picnt Valid issues identified, and analysed for $xpdp_desc<br><br>"; 
                  //print($xjob_log_y);
             } else {
               $picnt        = 0;
               while($row80  = mysql_fetch_row($mysql_data80)) {
                     $picnt          = $picnt + 1;
                     $piid[$picnt]   = stripslashes($row80[0]);  // PDP Issue_id found for this given PDP (A)
                     $pidesc[$picnt] = stripslashes($row80[1]);  // Issue Description
                     $picby[$picnt]  = stripslashes($row80[2]);
                     $picon[$picnt]  = stripslashes($row80[3]);
                     $pidpt[$picnt]  = stripslashes($row80[4]);
                     $xd             = date("d",$picon[$picnt]);
                     $xm             = date("M",$picon[$picnt]);
                     $xy             = date("Y",$picon[$picnt]);
                     $pidt[$picnt]   = $xd."-".$xm."-".$xy;             
                     $piidx          = $piid[$picnt];            // Move (A) to a non-array variable
                     // ----->>>>>>>> print("<br>"."-----------------------------------------------------------------------------------");
                     // ----->>>>>>>> print("<br> Issue No: ".$picnt."<br> Issue ID: ".$piid[$picnt]."<br> Issue Description: ".$pidesc[$picnt]."<br><br>");
                     print("<br>"."-----------------------------------------------------------------------------------");
                     print("<br> Issue No: ".$picnt."<br> Issue ID: ".$piid[$picnt]."<br> Issue Description: ".$pidesc[$picnt]."<br>Issue Found By:".$pidpt[$picnt]."<br><br>"); 
                     // Load Master Record
                     $line           = 1;
                     $query91        = "select a.issue_type_id,b.issue_type 
                                          from ".$name.".issue_surrogates a, issue_types b 
                                         where a.issue_surrogate_id = $piid[$picnt]
                                           and a.surrogate_type = 0
                                           and a.issue_type_id = b.issue_type_id
                                 ";
                     // ----->>>>>>>> print("SQL: Get all Root Cause logged in Master Record for issue ".$piid[$picnt]."<br>"."$query91"."<br><br>");                   
                     print("SQL: Get all Root Cause logged in Master Record for issue ".$piid[$picnt]."<br>"."$query91"."<br><br>");
                     $mysql_data91   = mysql_query($query91, $mysql_link) or die ("#18 Could not query: ".mysql_error());
                     $rowcnt91       = mysql_num_rows($mysql_data91);
                     $pitcnt         = 0;
                     while($row91  = mysql_fetch_row($mysql_data91)) {
                           $pitcnt         = $pitcnt + 1;
                           $pitid[$pitcnt] = stripslashes($row91[0]);
                           $pityp[$pitcnt] = stripslashes($row91[1]);
                     }
                     $query57      = " select a.issue_history_id,a.issue_note,a.issue_assignee,a.issue_note_dt,b.issue_area 
                                         from ".$name.".issue_history a, issue_areas b  
                                        where a.issue_id = $piid[$picnt]
                                          and a.issue_area_id = b.issue_area_id ";
                     $mysql_data57 = mysql_query($query57, $mysql_link) or die ("#19 Could not query: ".mysql_error());
                     $rowcnt57     = mysql_num_rows($mysql_data57);
                     // ----->>>>>>>> print("SQL: Get all Updates for issue ".$piid[$picnt]."<br>"."$query57"."<br>");
                     print("SQL: Get all Updates for issue ".$piid[$picnt]."<br>"."$query57"."<br>");
                     $pimax[$picnt] = $line + $rowcnt57;  // Record that will be used in Analysis, Master line if no updates else the last update line
                     $piu           = $pimax[$picnt] - 1; // No. of updates
                     $pim           = $pimax[$picnt];     // Same as $pimax[$picnt] 
                     // ----->>>>>>>> print("<br>"."Master Record"."<br> Line = ".$line);
                     // ----->>>>>>>> print("<br>"."No. of Root Casuses Found = ".$pitcnt);
                     // ----->>>>>>>> print("<br>"."[picnt]-[line]-[i]");
                     print("<br>"."Master Record"."<br> Line = ".$line);
                     print("<br>"."No. of Root Casuses Found = ".$pitcnt);
                     print("<br>"."[picnt]-[line]-[i]");
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
                                                $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                     if ($irgrp[$i] <> "NO"){
                                                         for ($i3=1;$i3<=$icnt;++$i3) {
                                                              if ($irgrp[$i3] == $ityp[$i3]){
                                                                  $dpti[$i3][$d] = $dpti[$i3][$d] + 1;
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
                          // ----->>>>>>>> print("<br>".$picnt." - ".$line." - ".$i." - Value = ".$ypi." - ".$ityp[$i]);
                          print("<br>".$picnt." - ".$line." - ".$i." - Value = ".$ypi." - ".$ityp[$i]);
                     }             
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
                           print("<br> Update No: ".$wpu."<br>Issue Found By:".$wdpt."<br><br>"); 
                     }
                     // ----->>>>>>>> print("<br><br>"."Updates Found "." = ".$piu."<br><br>");
                     print("<br><br>"."Total Updates Found "." = ".$piu."<br><br>");
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
                          // ----->>>>>>>> print("SQL: Get all Root Cause logged in for this Update Record ".$yid."<br>".$query81."<br><br>"); 
                          print("SQL: Get all Root Cause logged in for this Update Record ".$yid."<br>".$query81."<br><br>");                  
                          $mysql_data81   = mysql_query($query81, $mysql_link) or die ("#20 Could not query: ".mysql_error());
                          $rowcnt81       = mysql_num_rows($mysql_data81);
                          $putcnt         = 0;
                          while($row81  = mysql_fetch_row($mysql_data81)) {
                                $putcnt         = $putcnt + 1;
                                $putid[$picnt][$putcnt] = stripslashes($row81[0]);
                                $putyp[$picnt][$putcnt] = stripslashes($row81[1]);
                          }
                          $w = $pu + 1;
                          // ----->>>>>>>> print("Update No: ".$pu."<br> Line = ".$w);    //$line
                          // ----->>>>>>>> print("<br> Issue History ID: ".$puid[$picnt][$pu+1]);
                          // ----->>>>>>>> print("<br>"."No. of Root Casuses Found = ".$putcnt);
                          // ----->>>>>>>> print("<br>"."[picnt]-[line]-[i]");
                          print("Update No: ".$pu."<br> Line = ".$w);
                          print("<br> Issue History ID: ".$puid[$picnt][$pu+1]);
                          print("<br>"."No. of Root Casuses Found = ".$putcnt);
                          print("<br>"."[picnt]-[line]-[i]");
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
                                                     $dpti[$i][$d] = $dpti[$i][$d] + 1;
                                                     if ($irgrp[$i] <> "NO"){
                                                         for ($i3=1;$i3<=$icnt;++$i3) {
                                                              if ($irgrp[$i3] == $ityp[$i3]){
                                                                  $dpti[$i3][$d] = $dpti[$i3][$d] + 1;
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
                               // ----->>>>>>>> print("<br>".$picnt." - ".$i." - ".$line." - Value = ".$ypi." - ".$ityp[$i]);
                               print("<br>".$picnt." - ".$i." - ".$line." - Value = ".$ypi." - ".$iccd[$i]." - ".$ityp[$i]);
                          }
                          // ----->>>>>>>> print("<br><br>");
                          print("<br><br>");
                     }                   
               }
               for ($i=1;$i<=$icnt ; ++$i) {
                    print("<br>".$ityp[$i]." = ".$tcnt[$i]); 
               }
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
                           if ((trim($ityp[$i]) == trim($irgrp[$i2])) && ($igrp[$i2] == 0)){
                                $tcnt[$i]  = $tcnt[$i] + $tcnt[$i2];  
                           }
                           //} 
                      }
                  }
             }             
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
             if ($bypass == 0){
                 //$xjob_log   = $xjob_log.chr(10)."$picnt Valid issues identified, and analysed for $xpdp_desc".chr(10);
                 //$xjob_log_y = "$picnt Valid issues identified, and analysed for $xpdp_desc<br><br>"; 
                 //print($xjob_log_y);
                 $query103 = "INSERT into ".$name.".cube1_main(etl_id,
                                                               row_type,
                                                               pdp,
                                                               pdp_desc,
                                                               pdp_owner,
                                                               pdp_type,
                                                               pdp_status,
                                                               pdp_launch,
                                                               parent_pdp,
                                                               main_pdp,
                                                               issues_created,
                                                               pdp_category,
                                                               scoping,
                                                               complexity_factor,
                                                               revenue_factor,
                                                               customer_factor,
                                                               past_factor,
                                                               testing_start_date,
                                                               testing_end_date,
                                                               bills_run,
                                                               invoices_generated,
                                                               ppw_changes,
                                                               launch_in_jeopardy,
                                                               baseline_hours,
                                                               rework_hours,
                                                               percentage_rework
                                                              )
                              VALUES('$xetl_id',
                                     '1',
                                     '$xpdp_desc',
                                     '$xpdp_name',
                                     '$xpdp_owner',
                                     '$xpdp_period',
                                     '$xpdp_status',
                                     '$xdate',
                                     '$xparent_pdp_desc',
                                     '$xmain_pdp_desc',
                                     '$picnt',
                                     '$xcategory',
                                     '$xscoping',
                                     '$xcomplexity',
                                     '$xrevenue',
                                     '$xprojection',
                                     '$xpast',
                                     '$xstart_date',
                                     '$xend_date',
                                     '$ybillrun_cnt',
                                     '$yinvoice_cnt',
                                     '$yppw_update',
                                     '$ylaunch',
                                     '$total_baseline',
                                     '$total_incremental',
                                     '$percent_incremental'
                                    )";
                 //print($query103);
                 $mysql_data103 = mysql_query($query103, $mysql_link) or die ("#21 Could not query: ".mysql_error());
                 for ($b=1;$b<=$y ; ++$b) {
                      $query102 = "INSERT into ".$name.".cube1_a(etl_id,pdp,short_desc,tested,department)
                                   VALUES('$xetl_id','$xpdp_desc','$ydsc[$b]','$ytind[$b]','$ydpt[$b]')";
                      print($query104."<br>");             
                      $mysql_data102 = mysql_query($query102, $mysql_link) or die ("#22 Could not query: ".mysql_error());
                 }
                 for ($i=1;$i<=$icnt; ++$i) {
                      $query104 = "INSERT into ".$name.".cube1_b(etl_id,pdp,issue_type,occurance,issue_class,report_group,group_used)
                                   VALUES('$xetl_id','$xpdp_desc','$ityp[$i]','$tcnt[$i]','$iccd[$i]','$irgrp[$i]','$igrp[$i]')";
                      print($query104."<br>");             
                      $mysql_data104 = mysql_query($query104, $mysql_link) or die ("#23 Could not query: ".mysql_error());
                 }
                 for ($i=1;$i<=$icnt;++$i) {
                  for ($d=1;$d<=$dcnt;++$d) {
                      $xdpti = $dpti[$i][$d]; 
                      $query105 = "INSERT into ".$name.".cube1_c(etl_id,pdp,issue_area,found_issues,issue_type)
                                   VALUES('$xetl_id','$xpdp_desc','$dpt[$d]','$xdpti','$ityp[$i]')";
                      print($query105."<br>");             
                      $mysql_data105 = mysql_query($query105, $mysql_link) or die ("#23.5 Could not query: ".mysql_error());
                  }
                 } 
                 $query112      = "UPDATE ".$name.".etl_monitor
                                      SET etl_status = 'ETL for PDP $xpdp_desc Completed'
                                    WHERE etl_id     = '$xetl_id' ";
                 $mysql_data112 = mysql_query($query111, $mysql_link) or die ("#24 Could not query: ".mysql_error());
                 unset($tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval,$ytotl,$stotlr,$stotlc,$prtotlr,$prtotlc,$rtotl,$picby,$picon,$picdt,$pucby,$pucon,$pudt,$pucon,$pudt,$pucon,$pudt);
             }
             //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       }
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
       $xjob_log      = $xjob_log.chr(10)."Job Ending at: ".date("l F d, Y, h:i:s A").chr(10);
       $xjob_log_x    = $xjob_log_x.chr(10)."Job Ending at: ".date("l F d, Y, h:i:s A").chr(10);
       $xjob_log_y    = "Job Ending at: ".date("l F d, Y, h:i:s A")."<br>";     
       print($xjob_log_y);
       //print("=================================");
       //print($xjob_log);
       $query113 = "UPDATE ".$name.".etl_monitor
                       SET job_log    = '$xjob_log_x', 
                           etl_status = 'ETL Completed'
                     WHERE etl_id = '$xetl_id' ";
       $mysql_data113 = mysql_query($query113, $mysql_link) or die ("#25 Could not query: ".mysql_error());
       //$fh = fopen($etlpath,'w') or die("can't open file");
       //fwrite($fh, $xjob_log);
       //fclose($fh);
       //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 
   } else {
     $found = 0;
     echo "<script type=\"text/javascript\">window.alert(\"No PDP found under this criteria, Please Try Again\")</script>";  
   }
print("  </div>
        </body>
       </html>
");
mysql_close($mysql_link);
?>
