<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

//require("./inc/fpdf.php"); 

// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
$querys5 = "SELECT user FROM ".$name.".sessions
             WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
}
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
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
$xreport_pth = "./reports/";
$xreport_nam = "FULL EXTRACT-".$ydate3.".htm";
//print ($reportname); 
//Start of HTML
//================================================================================================================

// ---------------------------------------------------------------------------------------------------------------- //
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
             //   .wrapper1
             //   .wrapper2{width: 100%; overflow-x: scroll; overflow-y:scroll; }
             //   .wrapper1{height: 5%; }
             //   .wrapper2{height: 100%; }
             //   .div1 {width:100%; height: 5%; }
             //   .div2 {width:100%; height: 65%; background-color: #FFFFFF;overflow-x: scroll; overflow-y:scroll;}
             //<script type=\"text/javascript\">
             //$(function(){
             //    $(\".wrapper1\").scroll(function(){
             //        $(\".wrapper2\")
             //            .scrollLeft($(\".wrapper1\").scrollLeft());
             //    });
             //    $(\".wrapper2\").scroll(function(){
             //        $(\".wrapper1\")
             //            .scrollLeft($(\".wrapper2\").scrollLeft());
             //    });
             //});
             //</script>
// ---------------------------------------------------------------------------------------------------------------- //

if ($start == 1) {
   // ------------------------------------------------------------------------------------------------------------ //
   ob_start();
   print($hstart);
   // ------------------------------------------------------------------------------------------------------------ //

   // ============================== ISSUE TYPE START ==============================
   $query69               = "select distinct issue_type,issue_class,report_group,group_used
                               from ".$name.".cube1_b_lov
                              where etl_id = '$yetl_id'
                           order by issue_class desc,report_group,group_used asc"; 
   $mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
   $rowcnt69              = mysql_num_rows($mysql_data69); 
   $icnt                  = 0;
   $rcnt                  = 0;
   $ccnt                  = 0;
   while($row69           = mysql_fetch_row($mysql_data69)) {
         $icnt            = $icnt + 1;
         $ityp[$icnt]     = stripslashes($row69[0]);        //issue_type
         $iccd[$icnt]     = trim(stripslashes($row69[1]));  //issue_class_code
         $irgrp[$icnt]    = trim(stripslashes($row69[2]));  //report_group
         $igrp[$icnt]     = stripslashes($row69[3]);        //group_used
         $itypsum[$icnt]  = 0;
         //print($icnt." - ".$ityp[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$itypsum[$icnt]."<br>");
         if ($iccd[$icnt] == "ROT"){
             $rcnt        = $rcnt + 1;
         }
         if ($iccd[$icnt] == "CNT"){
             $ccnt        = $ccnt + 1; 
         }
   }
   //print("Total Root Causes: ".$rcnt."<br>");
   //print("Total Contributing Factor: ".$ccnt."<br>");
   // =============================== ISSUE TYPE END ===============================
   // ============================== ISSUE AREA START ==============================
   //print("AREAS<br>");
   $query96                = "select distinct issue_area
                                from ".$name.".cube1_c_lov
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
   $query70               = "select distinct department,short_desc
                               from ".$name.".cube1_a
                              where etl_id = '$yetl_id'
                           order by department asc"; 
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

   //    
   //$captn = "PDP Summary Report";
   //print("     <table border='1' scroll=\"yes\" style=\"width: 300%; border-style:solid; border-color:#CCCCCC;\" >
   //                 <caption >$captn</caption>
   //");
 
   // ===================== APPLYING THE QUERY ====================
   $cnd1 = 0;
   $cnd2 = 0;
   if ($prd == "ALL") {
       $cnd1 = 1; 
   } else {
       $cnd1 = 2;
   }
   if ($ra_ind == "BOTH") {
       $cnd2 = 1; 
   } else {
       $cnd2 = 2;
   }
   if ($pdpcat == "ALL") {
       $cnd3 = 1; 
   } else {
       $cnd3 = 2;
   }      

   // ==================================================
   // Select from cube1_main
   // ==================================================
   $selectx     = "select a.etl_id,a.row_type,a.pdp,a.pdp_desc,a.pdp_owner,a.pdp_type,a.pdp_status,a.pdp_launch,
                          a.parent_pdp,a.main_pdp,a.issues_created,a.pdp_category,a.scoping,a.complexity_factor,
                          a.revenue_factor,a.customer_factor,a.past_factor,a.testing_start_date,a.testing_end_date,
                          a.bills_run,a.invoices_generated,a.ppw_changes,a.launch_in_jeopardy,a.baseline_hours,
                          a.rework_hours,a.percentage_rework ";
   $orderbyx    = " order by a.pdp ";
   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 1)) {
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.etl_id = b.etl_id
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";

        $queryx  = $selectx.$fromx.$wherex.$orderbyx;               
   } 
   
   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.pdp_type = '$prd' 
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }      

   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and concat(a.scoping,' - ',a.pdp_category) = '$pdpcat' 
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.etl_id = b.etl_id
                       and concat(a.scoping,' - ',a.pdp_category) = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and concat(a.scoping,' - ',a.pdp_category) = '$pdpcat'
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and a.etl_id = b.etl_id
                       and a.pdp    = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd'
                       and a.etl_id = b.etl_id
                       and concat(a.scoping,' - ',a.pdp_category) = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')
                       and trim(a.pdp_status) <> 'Cancelled'
                       and (a.pdp_launch >= '2010-08-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                   ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   // =========================== PDP COUNT START ==========================
   //for ($i=1;$i<=$icnt;++$i) {
         $selecty1     = "select a.pdp ";
         $query84      = $selecty1.$fromx.$wherex;
         //print($query84);
         $mysql_data84 = mysql_query($query84, $mysql_link) or die ("#2.11 Could not query: ".mysql_error());
         $rowcnt84     = mysql_num_rows($mysql_data84);
   //}  
   // ============================ PDP COUNT END ===========================
   // ============================= SUM OF TRACKER START ===========================
   $select71              = "select sum(a.issues_created),sum(a.bills_run),sum(a.invoices_generated),
                                    sum(a.ppw_changes),sum(a.baseline_hours),sum(a.rework_hours) ";
   $query71               = $select71.$fromx.$wherex; 
   $mysql_data71          = mysql_query($query71, $mysql_link) or die ("#2.6 Could not query: ".mysql_error());
   //print($query71);
   $rowcnt71              = mysql_num_rows($mysql_data71); 
   $sumcnt                = 0;
   while($row71           = mysql_fetch_row($mysql_data71)) {
         $sumcnt          = $sumcnt + 1;
         $sumissues[$sumcnt]   = stripslashes($row71[0]);        //Issues Created
         $sumbillruns[$sumcnt] = trim(stripslashes($row71[1]));  //Bill Runs
         $suminvoices[$sumcnt] = trim(stripslashes($row71[2]));  //Invoices Generated
         $sumppwchang[$sumcnt] = trim(stripslashes($row71[3]));  //PPW Changes
         $sumbasehrs[$sumcnt]  = trim(stripslashes($row71[4]));  //Baseline Hours
         $sumrwrkhrs[$sumcnt]  = trim(stripslashes($row71[5]));  //Rework Hours
   }
   //print("Total Sum Rows: ".$sumcnt."<br>");
   // ============================== SUM OF TRACKER END ============================
   // =========================== SUM OF ISSUE TYPE START ==========================
   for ($i=1;$i<=$icnt;++$i) {
        $query72      = "select sum(occurance)
                           from ".$name.".cube1_b
                          where etl_id     = '$yetl_id'
                            and issue_type = '$ityp[$i]'
                            and pdp in ";
        $selecty      = "( select a.pdp ";
        $query73      = $selecty.$fromx.$wherex.")";
        $query74      = $query72.$query73;
        $mysql_data74 = mysql_query($query74, $mysql_link) or die ("#2.1 Could not query: ".mysql_error());
        $rowcnt74     = mysql_num_rows($mysql_data74);
        //print($query74."<br>");
        //if (is_null($rowcnt74)){
        //    $itypsum[$i] =  0;
        //    //print("I was here<br>");
        //} else {     
          while($row74  = mysql_fetch_row($mysql_data74)) {
                $itypsum[$i] =  stripslashes($row74[0]);
                if (empty($rowcnt74)){
                    $itypsum[$i] =  0;
                } else {
                   if (($igrp[$i] == 0) && ($iccd[$i] == "ROT")){
                        $rottotal = $rottotal + $itypsum[$i]; 
                   }         
                   if (($igrp[$i] == 0) && ($iccd[$i] == "CNT")){
                        $cnttotal = $cnttotal + $itypsum[$i]; 
                   }
                }
          }                  
        //}
   }  
   // ============================= SUM OF ISSUE TYPE END ==========================
   // ========================= PERCENTAGE ISSUE TYPE START ========================
   for ($i=1;$i<=$icnt;++$i) {
        if ($iccd[$i] == "ROT"){
            if ($rottotal == 0){
                $itypprc[$i] = 0;
            } else {
                $itypprc[$i] = round(($itypsum[$i]/$rottotal)*100,1);
            }
        }         
        if ($iccd[$i] == "CNT"){
             if ($cnttotal == 0){
                $itypprc[$i] = 0;
            } else {       
                $itypprc[$i] = round(($itypsum[$i]/$cnttotal)*100,1);
            }
        }
   }  
   // ========================== PERCENTAGE ISSUE TYPE END =========================
   // =========================== SUM OF ISSUE CAUSES PER AREA START ==========================
   $zfound_sum_rot = 0;
   $zfound_sum_cnt = 0;
   for ($i=1;$i<=$icnt;++$i) {
      for ($d2=1;$d2<=$dcnt2;++$d2) {
           if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){
                $query77   = "select x.issue_area,x.issue_type,sum(x.found_issues),b.issue_class,c.tested
                              from ".$name.".cube1_c x, cube1_b b, cube1_a c ";
                $query77b  = " and x.issue_type = b.issue_type
                               and x.pdp = b.pdp
                               and b.group_used <> 1
                               and x.pdp = c.pdp
                               and x.issue_area = c.department "; 
                $grpby77   = " group by x.issue_area,x.issue_type,c.tested ";  
           } else {
                $query77   = "select x.issue_area,x.issue_type,sum(x.found_issues),b.issue_class
                              from ".$name.".cube1_c x, cube1_b b ";
                $query77b  = " and x.issue_type = b.issue_type
                               and x.pdp = b.pdp
                               and b.group_used <> 1 "; 
                $grpby77   = " group by x.issue_area,x.issue_type ";                                 
           }                   
           $query77a     = " where x.etl_id     = '$yetl_id'
                               and x.issue_area = '$darea[$d2]'
                               and x.issue_type = '$ityp[$i]'
                               and x.pdp in ";
           $selecty      = " ( select a.pdp ";
           $query73      = $selecty.$fromx.$wherex.")";
           //$query77b     = "   and x.issue_type = b.issue_type
           //                    and x.pdp = b.pdp
           //                    and b.group_used <> 1 ";                    
           //$grpby77      = " group by x.issue_area,x.issue_type ";                    
           $query77      = $query77.$query77a.$query73.$query77b.$grpby77;
           //print($query77);                    
           $mysql_data77 = mysql_query($query77, $mysql_link) or die ("#2.15 Could not query: ".mysql_error());
           $rowcnt77     = mysql_num_rows($mysql_data77);
           if ($rowcnt77 > 0){
            if ($rowcnt77 == 1){
               while($row77  = mysql_fetch_row($mysql_data77)) {
                          $zfound[$i][$d2]  = stripslashes($row77[2]);
                          $zissueclass      = stripslashes($row77[3]);
                          $zfound_sum       = $zfound_sum + $zfound[$i][$d2];
                          if ($zissueclass  == "ROT") {
                              $zfound_sum_rot   = $zfound_sum_rot + $zfound[$i][$d2];
                          }
                          if ($zissueclass  == "CNT") {
                              $zfound_sum_cnt   = $zfound_sum_cnt + $zfound[$i][$d2];
                          }                          
               }
            }
            if ($rowcnt77 == 2){
               //$xfound = 0;
               while($row77  = mysql_fetch_row($mysql_data77)) {
                          //$xfound           = stripslashes($row77[2]);
                          //$zfound[$i][$d2]  = $zfound[$i][$d2] + $xfound;
                          $zfound[$i][$d2]  = stripslashes($row77[2]);
                          $zissueclass      = stripslashes($row77[3]);
                          $ztested          = stripslashes($row77[4]);
                          $zfound_sum       = $zfound_sum + $zfound[$i][$d2];
                          if (trim($ztested) == "YES"){
                              $zfound_sum_y  = $zfound_sum_y + $zfound[$i][$d2];
                          }
                          if (trim($ztested) == "NO"){
                              $zfound_sum_n  = $zfound_sum_n + $zfound[$i][$d2];
                          } 
                          if ($zissueclass  == "ROT") {
                              $zfound_sum_rot   = $zfound_sum_rot + $zfound[$i][$d2];
                              if (trim($ztested) == "YES"){
                                  $zfound_sum_rot_y  = $zfound_sum_rot_y + $zfound[$i][$d2];
                              }
                              if (trim($ztested) == "NO"){
                                  $zfound_sum_rot_n  = $zfound_sum_rot_n + $zfound[$i][$d2];
                              }                              
                          }
                          if ($zissueclass  == "CNT") {
                              $zfound_sum_cnt   = $zfound_sum_cnt + $zfound[$i][$d2];
                              if (trim($ztested) == "YES"){
                                  $zfound_sum_cnt_y  = $zfound_sum_cnt_y + $zfound[$i][$d2];
                              }
                              if (trim($ztested) == "NO"){
                                  $zfound_sum_cnt_n  = $zfound_sum_cnt_n + $zfound[$i][$d2];
                              }                               
                          }                          
               }
            }
           } else {
                   $zfound[$i][$d2] =  0; 
           }
           if ($zissueclass == "ROT"){
               $disuecnt_rot[$d2] = $disuecnt_rot[$d2] + $zfound[$i][$d2];
           }
           if ($zissueclass == "CNT"){
               $disuecnt_cnt[$d2] = $disuecnt_cnt[$d2] + $zfound[$i][$d2];
           }           
           //$disuecnt_rot[$d2] = $disuecnt_rot[$d2] + $zfound[$i][$d2];
           //print($i."------".$ityp[$i]." ------- ".$d2."------".$darea[$d2]." ------- ".$zfound[$i][$d2]."<br>"); 
      }                    
   }  
   // ============================= SUM OF ISSUE CAUSES PER AREA END ==========================
   // =========================== SUM OF ISSUEs PER AREA START ==========================
   //for ($i=1;$i<=$icnt;++$i) {
   //$wfound_sum = 0;
   for ($d2=1;$d2<=$dcnt2;++$d2) {
           //print($darea[$d2]);
           $query97      = "select issue_area,sum(issue_count)
                              from ".$name.".cube1_d
                             where etl_id     = '$yetl_id'
                               and issue_area = '$darea[$d2]'
                               and pdp in ";
           $grpby97      = " group by issue_area ";                    
           $selecty      = "( select a.pdp ";
           $query93      = $selecty.$fromx.$wherex.")";
           $query97      = $query97.$query93.$grpby97;
           //print($query97);                    
           $mysql_data97 = mysql_query($query97, $mysql_link) or die ("#2.16 Could not query: ".mysql_error());
           $rowcnt97     = mysql_num_rows($mysql_data97);
           if ($rowcnt97 == 1){
               while($row97  = mysql_fetch_row($mysql_data97)) {
                          $wfound[$d2] =  stripslashes($row97[1]);
                          if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){
                              // NO
                              $query107 =  "select issue_area,sum(issue_count)
                                              from ".$name.".cube1_d
                                             where etl_id     = '$yetl_id'
                                               and issue_area = '$darea[$d2]'
                                               and pdp in ";
                              $fromx1   = "from ".$name.".cube1_main a, ".$name.".cube1_a b ";
                              $wherex1  = "where a.etl_id = '$yetl_id'
                                             and trim(a.pdp_status) <> 'Cancelled'
                                             and (a.pdp_launch >= '2010-08-01'
                                                  or
                                                    (a.pdp_launch = '0000-00-00' and a.issues_created <> 0)
                                                  )
                                             and a.pdp = b.pdp
                                             and b.department = '$darea[$d2]'
                                             and b.tested     = 'NO'                              
                                          ";
                              $query103       = $selecty.$fromx1.$wherex1.")";
                              $query107       = $query107.$query103.$grpby97;
                              //print($query107);
                              $mysql_data107  = mysql_query($query107, $mysql_link) or die ("#2.161 Could not query: ".mysql_error());
                              $rowcnt107      = mysql_num_rows($mysql_data107);
                              if ($rowcnt107 == 1){
                                 while($row107  = mysql_fetch_row($mysql_data107)) {
                                        $wfound_no[$d2] =  stripslashes($row107[1]);
                                  }
                              }
                             //$wfound_yes[$d2] = 0;                                             
                              // YES
                              $query108 =  "select issue_area,sum(issue_count)
                                              from ".$name.".cube1_d
                                             where etl_id     = '$yetl_id'
                                               and issue_area = '$darea[$d2]'
                                               and pdp in ";
                              //$fromx1   = "pdp.cube1_main a, cube1_a b ";
                              $wherex1  = "where a.etl_id = '$yetl_id'
                                             and trim(a.pdp_status) <> 'Cancelled'
                                             and (a.pdp_launch >= '2010-08-01'
                                                  or
                                                    (a.pdp_launch = '0000-00-00' and a.issues_created <> 0)
                                                  )
                                             and a.pdp = b.pdp
                                             and b.department = '$darea[$d2]'
                                             and b.tested     = 'YES'                              
                                          ";
                              $query103 = $selecty.$fromx1.$wherex1.")";
                              $query108 = $query108.$query103.$grpby97;
                              //print($query108);
                             $mysql_data108  = mysql_query($query108, $mysql_link) or die ("#2.162 Could not query: ".mysql_error());
                              $rowcnt108      = mysql_num_rows($mysql_data108);
                              if ($rowcnt108 == 1){
                                  while($row108  = mysql_fetch_row($mysql_data108)) {
                                        $wfound_yes[$d2] =  stripslashes($row108[1]);
                                  }
                              }                                             
                          }
               }
           } else {
                   $wfound[$d2] =  0; 
           }
           //$disuecnt[$d2] = $disuecnt[$d2] + $zfound[$i][$d2];
           //print($i."------".$ityp[$i]." ------- ".$d2."------".$darea[$d2]." ------- ".$zfound[$i][$d2]."<br>"); 
   }                    
   //}  
   // ============================= SUM OF ISSUE PER AREA END ==========================
   // =========================== SUM OF SCOPING START ==========================
   //for ($i=1;$i<=$icnt;++$i) {
      //for ($d2=1;$d2<=$dcnt2;++$d2) {   
          $selecty      = "( select a.pdp ";
          $query83      = $selecty.$fromx.$wherex.")";
          $query87      = "select scoping
                             from ".$name.".cube1_main 
                            where etl_id = '$yetl_id'
                              and pdp in ";
          //$grpby87      = " group by c.category_scope,p.pdp_category ";                    
          $query87      = $query87.$query83; //.$grpby87;
          //print($query87);                    
          $mysql_data87 = mysql_query($query87, $mysql_link) or die ("#2.2 Could not query: ".mysql_error());
          $rowcnt87     = mysql_num_rows($mysql_data87);
          $inscpcnt     = 0;
          $outscpcnt    = 0;
          $notsetcnt    = 0;
          if ($rowcnt87 <> 0){
              while($row87  = mysql_fetch_row($mysql_data87)) {
                    $scp =  stripslashes(trim($row87[0]));
                    if ($scp == "IN SCOPE"){
                        $inscpcnt = $inscpcnt + 1;                        
                    }
                    if ($scp == "OUT OF SCOPE"){
                        $outscpcnt = $outscpcnt + 1;                        
                    }
                    if ($scp == "NOT SET"){
                        $notsetcnt = $notsetcnt + 1;                        
                    }                    
              }
          }
          //print("In Scope: ".$inscpcnt."<br> Out Of Scope: ".$outscpcnt."<br>Not Set: ".$notsetcnt."<br>");
          $totscpcnt = $inscpcnt + $outscpcnt + $notsetcnt;
          if ($totscpcnt == 0) {
          } else {
          $inscpprc  = round(($inscpcnt / $totscpcnt)*100,1);
          $outscpprc = round(($outscpcnt / $totscpcnt)*100,1);
          $notsetprc = round(($notsetcnt / $totscpcnt)*100,1);
          }
      //}                    
   //}  
   // ============================= SUM OF SCOPING END ==========================
   // =========================== SUM OF FACTOR START ==========================
   //for ($i=1;$i<=$icnt;++$i) {
      //for ($d2=1;$d2<=$dcnt2;++$d2) {   
          $query87      = "select complexity_factor,revenue_factor,customer_factor,past_factor
                             from ".$name.".cube1_main 
                            where etl_id     = '$yetl_id'
                              and pdp in ";
          $selecty      = "( select a.pdp ";
          $query83      = $selecty.$fromx.$wherex.")";
          //$grpby87      = " group by c.category_scope,p.pdp_category ";                    
          $query87      = $query87.$query83; //.$grpby87;
          //print($query87);                    
          $mysql_data87 = mysql_query($query87, $mysql_link) or die ("#2.3 Could not query: ".mysql_error());
          $rowcnt87     = mysql_num_rows($mysql_data87);
          $comphcnt     = 0;
          $compmcnt     = 0;
          $complcnt     = 0;
          $revnhcnt     = 0;
          $revnmcnt     = 0;
          $revnlcnt     = 0;
          $revnncnt     = 0; 
          $custhcnt     = 0;
          $custmcnt     = 0;
          $custlcnt     = 0;
          $custncnt     = 0; 
          $pasthcnt     = 0;
          $pastmcnt     = 0;
          $pastlcnt     = 0;
          $pastncnt     = 0;          
          if ($rowcnt87 <> 0){
              while($row87  = mysql_fetch_row($mysql_data87)) {
                    $comp =  stripslashes(trim($row87[0]));
                    $revn =  stripslashes(trim($row87[1]));
                    $cust =  stripslashes(trim($row87[2]));
                    $past =  stripslashes(trim($row87[3]));
                    if ($comp == "HIGH"){
                        $comphcnt = $comphcnt + 1;                        
                    }
                    if ($comp == "MEDIUM"){
                        $compmcnt = $compmcnt + 1;                        
                    }
                    if ($comp == "LOW"){
                        $complcnt = $complcnt + 1;                        
                    } 
                    if ($comp == "NOT SET"){
                        $compncnt = $compncnt + 1;                        
                    }                                       
                    if ($revn == "HIGH"){
                        $revnhcnt = $revnhcnt + 1;                        
                    }
                    if ($revn == "MEDIUM"){
                        $revnmcnt = $revnmcnt + 1;                        
                    }
                    if ($revn == "LOW"){
                        $revnlcnt = $revnlcnt + 1;                        
                    } 
                    if ($revn == "NOT SET"){
                        $revnncnt = $revnncnt + 1;                        
                    }
                    if ($cust == "HIGH"){
                        $custhcnt = $custhcnt + 1;                        
                    }
                    if ($cust == "MEDIUM"){
                        $custmcnt = $custmcnt + 1;                        
                    }
                    if ($cust == "LOW"){
                        $custlcnt = $custlcnt + 1;                        
                    } 
                    if ($cust == "NOT SET"){
                        $custncnt = $custncnt + 1;                        
                    }                    
                    if ($past == "HIGH"){
                        $pasthcnt = $pasthcnt + 1;                        
                    }
                    if ($past == "MEDIUM"){
                        $pastmcnt = $pastmcnt + 1;                        
                    }
                    if ($past == "LOW"){
                        $pastlcnt = $pastlcnt + 1;                        
                    } 
                    if ($past == "NOT SET"){
                        $pastncnt = $pastncnt + 1;                        
                    } 
              }
          }
          //print("In Scope: ".$inscpcnt."<br> Out Of Scope: ".$outscpcnt."<br>Not Set: ".$notsetcnt."<br>");
          $comptcnt = $comphcnt + $compmcnt + $complcnt + $compncnt;
          if ($comptcnt == 0) {
          $comphprc  = 0;
          $compmprc  = 0;
          $complprc  = 0;
          $compnprc  = 0;
          } else {
          $comphprc  = round(($comphcnt / $comptcnt)*100,1);
          $compmprc  = round(($compmcnt / $comptcnt)*100,1);
          $complprc  = round(($complcnt / $comptcnt)*100,1);
          $compnprc  = round(($compncnt / $comptcnt)*100,1);
          }
          $revntcnt = $revnhcnt + $revnmcnt + $revnlcnt + $revnncnt;
          if ($revntcnt == 0) {
          $revnhprc  = 0;
          $revnmprc  = 0;
          $revnlprc  = 0;
          $revnnprc  = 0;
          } else {
          $revnhprc  = round(($revnhcnt / $revntcnt)*100,1);
          $revnmprc  = round(($revnmcnt / $revntcnt)*100,1);
          $revnlprc  = round(($revnlcnt / $revntcnt)*100,1);
          $revnnprc  = round(($revnncnt / $revntcnt)*100,1);
          }
          $custtcnt = $custhcnt + $custmcnt + $custlcnt + $custncnt;
          if ($custtcnt == 0) {
          $custhprc  = 0;
          $custhprc  = 0;
          $custhprc  = 0;
          $custhprc  = 0;
          } else {
          $custhprc  = round(($custhcnt / $custtcnt)*100,1);
          $custmprc  = round(($custmcnt / $custtcnt)*100,1);
          $custlprc  = round(($custlcnt / $custtcnt)*100,1);
          $custnprc  = round(($custncnt / $custtcnt)*100,1);          
          }
          $pasttcnt = $pasthcnt + $pastmcnt + $pastlcnt + $pastncnt;
          if ($pasttcnt == 0) {
          $pasthprc  = 0;
          $pasthprc  = 0;
          $pasthprc  = 0;
          $pasthprc  = 0;
          } else {
          $pasthprc  = round(($pasthcnt / $pasttcnt)*100,1);
          $pastmprc  = round(($pastmcnt / $pasttcnt)*100,1);
          $pastlprc  = round(($pastlcnt / $pasttcnt)*100,1);
          $pastnprc  = round(($pastncnt / $pasttcnt)*100,1);
          }
      //}                    
   //}  
   // ============================= SUM OF FACTOR END ==========================
   // ===================== SETTING UP HEADERS ====================
   // Sections
   $sctn[1]   = "PDP Information";
   $cols[1]   = 9;
   $sctn[2]   = "Scoping";
   $cols[2]   = 10;
   $sctn[3]   = "Work Effort";
   $cols[3]   = 11;
   $sctn[4]   = "Root Causes";
   $cols[4]   = $rcnt;
   $sctn[5]   = "Missed Opportunities";
   $cols[5]   = $ccnt;
   $scnt      = 5;
   // Headings
   // PDP Information (1-10) + 2 for PDP Testing = 12
   $head[1]   = "No";
   $huse[1]   = 1;
   $hsum[1]   = 0;
   $head[2]   = "PDP No.";
   $huse[2]   = 1;
   $hsum[2]   = 1;
   $hval[2]   = $rowcnt84;
   $head[3]   = "Description";
   $huse[3]   = 1;
   $hsum[3]   = 0;
   $head[4]   = "Owner";
   $huse[4]   = 1;
   $hsum[4]   = 0;
   $head[5]   = "Type";
   $huse[5]   = 1;
   $hsum[5]   = 0;
   $head[6]   = "Status";
   $huse[6]   = 1;
   $hsum[6]   = 0;
   $head[7]   = "Launch (YYYY-MM-DD)";
   $huse[7]   = 1;
   $hsum[7]   = 0;
   $head[8]   = "Parent PDP";
   $huse[8]   = 1;
   $hsum[8]   = 0;
   $head[9]   = "Main PDP";
   $huse[9]   = 1;
   $hsum[9]   = 0;
   // PDP Testing
   //$head[10] = "Issue Created";
   //$huse[10] = 1;
   //$hsum[10] = 1;
   //$hval[10] = $sumissues[$sumcnt];
   // Scoping (11-16)
   $head[10]  = "PDP Category";
   $huse[10]  = 1;
   $hsum[10]  = 0;
   $head[11]  = "Scoping";
   $huse[11]  = 1;
   $hsum[11]  = 0;
   $hprc3[11] = 1;   
   $head[12]  = "Complexity";
   $huse[12]  = 1;
   $hsum[12]  = 0;
   $hprc3[12] = 1;   
   $head[13]  = "Revenue Impact";
   $huse[13]  = 1;
   $hsum[13]  = 0;
   $hprc3[13] = 1;   
   $head[14]  = "Customer Impact";
   $huse[14]  = 1;
   $hsum[14]  = 0;
   $hprc3[14] = 1;   
   $head[15]  = "Past Impact";
   $huse[15]  = 1;
   $hsum[15]  = 0;
   $hprc3[15] = 1;   
   //Testing Execution (17-25)
   $head[16]  = "Execution Start Date (YYYY-MM-DD)";
   $huse[16]  = 1;
   $hsum[16]  = 0;
   $head[17]  = "Execution End Date (YYYY-MM-DD)";
   $huse[17]  = 1;
   $hsum[17]  = 0;
   $head[18]  = "Bill Runs";
   $huse[18]  = 1;
   $hsum[18]  = 1;
   $hval[18]  = $sumbillruns[$sumcnt];
   $head[19]  = "Invoice Generated";
   $huse[19]  = 1;
   $hsum[19]  = 1;
   $hval[19]  = $suminvoices[$sumcnt];
   $head[20]  = "PPW Changes";
   $huse[20]  = 1;
   $hsum[20]  = 1;
   $hval[20]  = $sumppwchang[$sumcnt];
   $head[21]  = "Launch in Jeopardy";
   $huse[21]  = 1;
   $hsum[21]  = 0;
   $head[22]  = "Baseline Work (Hours)";
   $huse[22]  = 1;
   $hsum[22]  = 1;
   $hval[22]  = $sumbasehrs[$sumcnt];
   $head[23]  = "Rework (Hours)";
   $huse[23]  = 1;
   $hsum[23]  = 1;
   $hval[23]  = $sumrwrkhrs[$sumcnt];
   $head[24]  = "Percentage Rework ";
   $huse[24]  = 1;
   $hsum[24]  = 1;
   $hprc[24]  = 0;
   $prcf[24]  = 1;
   if ($sumbasehrs[$sumcnt] == 0){
       $hval[24] = 0; 
   } else {
       $hval[24] = round(($sumrwrkhrs[$sumcnt]/$sumbasehrs[$sumcnt])*100,1);
   }
   $head[25]  = "Issues Created";
   $huse[25]  = 1;
   $hsum[25]  = 1;
   $hprc[25]  = 1;
   $hprc2[25] = 1;
   //$hval[25]  = $sumissues[$sumcnt];
   $prcf[25]  = 0;
   $head[26]  = "&nbsp";
   $huse[26]  = 1;
   $hsum[26]  = 1;
   $hprc[26]  = 0;   
   $hprc2[26] = 1;
   //$hval[26] = $sumxxxxxx[$sumcnt];  
   $head[27]  = "&nbsp";
   $huse[27]  = 1;
   $hsum[27]  = 1;
   $hprc[27]  = 1;
   $hprc2[27] = 1;
   $prcf[27]  = 1;
   //$hval[26] = $sumxxxxxx[$sumcnt];  
   $head[28]  = "&nbsp";
   $huse[28]  = 1;
   $hsum[28]  = 1;
   $hprc[28]  = 1;
   $hprc2[28] = 1;
   $prcf[28]  = 1;   
   // =============================================================
   //print($queryx);
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx     = mysql_num_rows($mysql_datax);
   $seq  = 0;
   if ($rowcntx > 0) {
       $found  = 1;
       while($rowttl = mysql_fetch_row($mysql_datax)) {
             $seq        = $seq + 1;
             //$seq1     = 2;
	         $xdtl[0]    = stripslashes($rowttl[0]);               //$xetl_id
	         $xdtl[1]    = $seq;
	         $xrow_type  = stripslashes($rowttl[1]);               //$xrow_type
	         $xdtl[2]    = stripslashes($rowttl[2]);               //$xpdp
	         $xdtl[3]    = stripslashes($rowttl[3]);               //$xpdp_desc  
	         $xdtl[4]    = stripslashes($rowttl[4]);               //$xpdp_owner
	         $xdtl[5]    = stripslashes($rowttl[5]);               //$xpdp_type
	         $xdtl[6]    = stripslashes($rowttl[6]);               //$xpdp_status
	         $xdtl[7]    = substr(stripslashes($rowttl[7]),0,-9);  //$xpdp_launch
	         $xdtl[8]    = stripslashes($rowttl[8]);               //$xparent_pdp 
	         $xdtl[9]    = stripslashes($rowttl[9]);               //$xmain_pdp
             // cube1_a
             for ($d=1;$d<=$dcnt;++$d) {
                  $query81        = "select short_desc,tested
                                       from ".$name.".cube1_a
                                      where etl_id     = '$yetl_id'
                                        and pdp        = '$xdtl[2]'
                                        and short_desc = '$dsc[$d]' 
                                   order by department asc"; 
                  //print($query81."<br>");                        
                  $mysql_data81     = mysql_query($query81, $mysql_link) or die ("#2.7 Could not query: ".mysql_error());
                  $rowcnt81         = mysql_num_rows($mysql_data81); 
                  while($row81      = mysql_fetch_row($mysql_data81)) {
                        $ydtl[$d]   = stripslashes($row81[1]);        //department
                  }
             }
             // cube1_b
             for ($i=1;$i<=$icnt;++$i) {
                  $query82        = " select occurance
                                        from ".$name.".cube1_b
                                       where etl_id     = '$yetl_id'
                                         and issue_type = '$ityp[$i]'
                                         and pdp        = '$xdtl[2]' "; 
                  //print($query82."<br>");                        
                  $mysql_data82     = mysql_query($query82, $mysql_link) or die ("#2.75 Could not query: ".mysql_error());
                  $rowcnt82         = mysql_num_rows($mysql_data82); 
                  while($row82      = mysql_fetch_row($mysql_data82)) {
                        $zdtl[$i]   = stripslashes($row82[0]);        //department
                        if ($zdtl[$i] == 0){
                            $zdtl[$i] = "&nbsp";
                        }
                  }
             }
             //             
	         $xdtl[10]   = stripslashes($rowttl[11]);              //$xpdp_category
	         $xdtl[11]   = stripslashes($rowttl[12]);              //$xscoping
	         $xdtl[12]   = stripslashes($rowttl[13]);              //$xcomplexity_factor
	         $xdtl[13]   = stripslashes($rowttl[14]);              //$xrevenue_factor
	         $xdtl[14]   = stripslashes($rowttl[15]);              //$xcustomer_factor
	         $xdtl[15]   = stripslashes($rowttl[16]);              //$xpast_factor
	         $xdtl[16]   = substr(stripslashes($rowttl[17]),0,-9); //$xtesting_start_date
	         $xdtl[17]   = substr(stripslashes($rowttl[18]),0,-9); //$xtesting_end_date
	         $xdtl[18]   = stripslashes($rowttl[19]);              //$xbills_run
	         $xdtl[19]   = stripslashes($rowttl[20]);              //$xinvoices_generated
	         $xdtl[20]   = stripslashes($rowttl[21]);              //$xppw_changes
	         $xdtl[21]   = stripslashes($rowttl[22]);              //$xlaunch_in_jeopardy
	         $xdtl[22]   = (float)stripslashes($rowttl[23]);       //$xbaseline_hours
	         $xdtl[23]   = (float)stripslashes($rowttl[24]);       //$xrework_hours
	         $xdtl[24]   = (float)stripslashes($rowttl[25]);       //$xpercentage_rework
	         $xdtl[25]   = stripslashes($rowttl[10]);              //$xissues_created
	         $xdtl[26]   = "&nbsp";                                //filler 
             if ($seq == 1) {
             
                 $captnx = "Criteria";
                 print("
                        <div id=\"One\" class=\"cont\"> 
                         <table>
                          <caption>$captnx</caption>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             PDP Type
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $prd
                            </font>
                           </th>
                          </tr>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             RA Testing
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $ra_ind
                            </font>
                           </th>
                          </tr>             
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             PDP Category
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $pdpcat
                            </font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             Date/Time
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $ydate2
                            </font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             ETL JOB
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $yetl_id
                            </font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             REPORT
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             FULL EXTRACT
                            </font>
                           </th>
                          </tr>                                         
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             USER
                            </font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $usr
                            </font>
                           </th>
                          </tr>
                         </table>
                        </div> 
                 ");

                 print("<input type=\"button\" value=\"Toggle Detail Row Display\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");

                 $captn = "FULL EXTRACT";
                 print("<div id=\"Two\" class=\"cont2\">
                          <div class=\"wrapper2\">
                           <!--<div class=\"div2\">-->                          
                            <table id=\"theTable\" scroll=\"yes\" style=\"border-style:solid 1px; border-color:#CCCCCC; width=300%;\" >
                             <caption >$captn</caption>
                              <tr class=\"headerRow\">
                 ");
                 for ($s=1;$s<=$scnt;++$s) {
                      print("<th bgcolor=\"#CCCCCC\" colspan=\"$cols[$s]\" align=\"center\" valign=\"middle\">
                             <font color=\"#330099\">
                              $sctn[$s]
                             </font>
                            </th>            
                      ");            
                 }
                 print("</tr>");
                 // ==================================================
                 // Headers for cube1_main (1-9)
                 // ================================================== 
                 print("<tr class=\"headerRow\">");
                 for ($h=1;$h<=9;++$h) {
                       if ($huse[$h] == 1) { 
                           print("<th bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $head[$h]
                                   </font>
                                  </th>        
                           ");
                       }   
                 }
                 // ==================================================
                 // Select Headers for cube1_a
                 // ================================================== 
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <th bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:125px;\">
                              <font color=\"#330099\">
                               $dpt[$d]
                              </font>
                             </th>
                      ");                      
                 } 
                 // ==================================================
                 // Headers for cube1_main (10-25)
                 // ================================================== 
                 for ($h=10;$h<=25;++$h) {
                       if ($huse[$h] == 1) { 
                           print("<th bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $head[$h]
                                   </font>
                                  </th>        
                           ");
                       }   
                 }
                 // ==================================================
                 // Headers for cube1_c (26)
                 // ================================================== 
                 for ($h=26;$h<=28;++$h) {
                       if ($huse[$h] == 1) { 
                           print("<th bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $head[$h]
                                   </font>
                                  </th>        
                           ");
                       }   
                 }
                 // ==================================================
                 // Select Headers for cube1_b
                 // ==================================================       
                 for ($i=1;$i<=$icnt ; ++$i) {
                      if ($iccd[$i] == "ROT") {
                          $colr = "#99FF99";
                      } else {
                          $colr = "#9AFEFF";
                      }
                      if ($igrp[$i] == 1) {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                   <font color=\"#FF0000\">
                                    $ityp[$i]
                                   </font>
                                  </th> 
                          ");
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                   <font color=\"#330099\">
                                    $ityp[$i]
                                   </font>
                                  </th> 
                          ");
                      }     
                 }
                 print("</tr>
                        <tr class=\"headerRow\"> 
                 ");
                 // ==================================================
                 // Group Headings Start
                 // ================================================== 
                 for ($h=1;$h<=9;++$h) {
                      //if ($hsum[$h] == 1){
                      //    print(" <td align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                      //             <font color=\"#FF0000\">
                      //              $hval[$h]
                      //             </font>
                      //            </td> 
                      //    ");            
                      //} else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      //}
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <th align=\"center\" valign=\"middle\" style=\"background-color: #CCFFFF; word-wrap: break-word; word-break:break-all; width:125px;\">
                              <font color=\"#000000\">
                              </font>
                             </th>
                      ");                      
                 }       
                 for ($h=10;$h<=28;++$h) {
                      //if ($hsum[$h] == 1){
                      //    print(" <td align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                      //             <font color=\"#FF0000\">
                      //              $hval[$h]
                      //             </font>
                      //            </td> 
                      //    ");            
                      //} else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      //}
                 }                                                   
                 for ($i=1;$i<=$icnt ; ++$i) {
                      if (($igrp[$i] == 0) && ($irgrp[$i] <> "NO")) {
                      print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #9AFEFF;\">
                               <font color=\"#330099\">
                                $irgrp[$i]
                               </font>
                              </th> 
                          ");
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");                       
                      }    
                 } 
                 print("</tr>
                        <tr class=\"headerRow\"> 
                 ");
                 // ==================================================
                 // Group Headings End
                 // ==================================================                  
                 // ==================================================
                 // Sum Start
                 // ================================================== 
                 for ($h=1;$h<=9;++$h) {
                      if ($hsum[$h] == 1){
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                                   <font color=\"#330099\">
                                    $hval[$h]
                                   </font>
                                  </th> 
                          ");            
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      }
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <th align=\"center\" valign=\"middle\" style=\"background-color: #CCFFFF; word-wrap: break-word; word-break:break-all; width:125px;\">
                              <font color=\"#000000\">
                              </font>
                             </th>
                      ");                      
                 }       
                 for ($h=10;$h<=28;++$h) {
                      if (($h >= 25) && ($h <= 28)){
                          $colr  = "#99CCFF";
                          //$colrf = "#FF0000";   
                      } else {
                          $colr = "#FFFFCC"; 
                          //$colrf = "#330099"; 
                      }
                      if ($h == 25) {
                          $hval[$h] = "Issue Created";
                      }                 
                      if ($h == 26) {
                          $hval[$h] = "Found By";
                      }
                      if ($h == 27) {
                          $hval[$h] = "Total Root Cause";
                      }
                      if ($h == 28) {
                          $hval[$h] = "Total Missed<br>Opportunities";
                      }
                      if ($hsum[$h] == 1){
                          if (($prcf[$h] == 1) && ($h == 24)){
                              $hval[$h] = $hval[$h]."%";
                          }
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                   <font color=\"#330099\">
                                    $hval[$h]
                                   </font>
                                  </th> 
                          ");            
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      }
                 }
                 for ($i=1;$i<=$icnt ; ++$i) {
                      print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                               <font color=\"#330099\">
                                 $itypsum[$i]
                               </font>
                              </th> 
                          ");
                 } 
                 print("</tr>
                        <tr class=\"headerRow\"> 
                 ");
                 // ==================================================
                 // Sum End
                 // ================================================== 
                 // ==================================================
                 // Percentage Start 1
                 // ================================================== 
                 for ($h=1;$h<=9;++$h) {
                      if ($hprc[$h] == 1){
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #99CCFF;\">
                                   <font color=\"#330099\">
                                    $hval[$h]%
                                   </font>
                                  </th> 
                          ");            
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      }
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <th align=\"center\" valign=\"middle\" style=\"background-color: #CCFFFF; word-wrap: break-word; word-break:break-all; width:125px;\">
                              <font color=\"#000000\">
                              </font>
                             </th>
                      ");                      
                 }       
                 for ($h=10;$h<=28;++$h) {
                      if (($h == 25) or ($h == 27) or ($h == 28)){
                          $colr  = "#FFFFCC";
                          //$colrf = "#FF0000";   
                      } else {
                          $colr = "#99CCFF"; 
                          //$colrf = "#330099"; 
                      }                 
                      if ($h == 25) {
                          $hval[$h] = "(T)Total<br>=".$sumissues[$sumcnt];
                      }
                      if ($h == 27) {
                          $hval[$h] = "(S)Sum<br>=".$zfound_sum_rot;
                      }                      
                      if ($h == 28) {
                          $hval[$h] = "(S)Sum<br>=".$zfound_sum_cnt;
                      }                      
                      if ($hprc[$h] == 1){
                          if (($h == 25) or ($h == 27) or ($h == 28)){
                              $hval[$h] = $hval[$h];
                          } //else {
                            //  $hval[$h] = $hval[$h]."%"; 
                          //}
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                   <font color=\"#330099\">
                                    $hval[$h]
                                   </font>
                                  </th> 
                          ");            
                      } else {
                          print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                   <font color=\"#000000\">
                                   </font>
                                  </th> 
                          ");            
                      }
                 }
                 for ($i=1;$i<=$icnt ; ++$i) {
                      print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                               <font color=\"#330099\">
                                ($itypprc[$i]%)
                               </font>
                              </th> 
                          ");
                 } 
                 print("</tr>");
                 // ==================================================
                 // Percentage End 1
                 // ================================================== 
                 // ==================================================
                 // Percentage Start 2
                 // ==================================================
                 for ($d2=1;$d2<=$dcnt2;++$d2) { 
                   print("<tr class=\"headerRow\">");
                   for ($h=1;$h<=9;++$h) {
                        if ($hprc2[$h] == 1){
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                                     <font color=\"#330099\">
                                      $hval[$h]%
                                     </font>
                                    </th> 
                            ");            
                        } else {
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                     <font color=\"#000000\">
                                     </font>
                                    </th> 
                            ");            
                        }
                   }
                   for ($d=1;$d<=$dcnt;++$d) {
                        print("
                               <th align=\"center\" valign=\"middle\" style=\"background-color: #CCFFFF; word-wrap: break-word; word-break:break-all; width:125px;\">
                               <font color=\"#000000\">
                                </font>
                               </th>
                        ");                      
                   }       
                   for ($h=10;$h<=24;++$h) {
                        if ($hprc2[$h] == 1){
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                     <font color=\"#000000\">
                                     </font>
                                    </th> 
                            ");            
                        } else {
                            //print(" <td align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                            //         <font color=\"#000000\">
                            //         </font>
                            //        </td> 
                            //");            
                        }
                        if ($hprc3[$h] == 1){
                          if ($h == 11) {
                              if ($d2 == 1) {
                                  $hval[$h] = "IN SCOPE "."<br>= ".$inscpcnt."<br>(".$inscpprc."%)"; 
                              }
                              if ($d2 == 2) {
                                  $hval[$h] = "OUT OF SCOPE "."<br>= ".$outscpcnt."<br>(".$outscpprc."%)"; 
                              }
                              if ($d2 == 3) {
                                  $hval[$h] = "NOT SET "."<br>= ".$notsetcnt."<br>(".$notsetprc."%)"; 
                              }
                              if ($d2 == 4) {
                                  $hval[$h] = "TOTAL "."<br>= ".$totscpcnt; 
                              }
                              if ($d2 > 4) {
                                  $hval[$h] = "&nbsp"; 
                              }                             
                          }
                          if ($h == 12) {
                              if ($d2 == 1) {
                                  $hval[$h] = "HIGH "."<br>= ".$comphcnt."<br>(".$comphprc."%)"; 
                              }
                              if ($d2 == 2) {
                                  $hval[$h] = "MEDIUM "."<br>= ".$compmcnt."<br>(".$compmprc."%)"; 
                              }
                              if ($d2 == 3) {
                                  $hval[$h] = "LOW "."<br>= ".$complcnt."<br>(".$complprc."%)"; 
                              }
                              if ($d2 == 4) {
                                  $hval[$h] = "NOT SET "."<br>= ".$compncnt."<br>(".$compnprc."%)"; 
                              }                              
                              if ($d2 == 5) {
                                  $hval[$h] = "TOTAL "."<br>= ".$comptcnt; 
                              }                               
                              if ($d2 > 5) {
                                  $hval[$h] = "&nbsp"; 
                              }                               
                          }                          
                          if ($h == 13) {
                              if ($d2 == 1) {
                                  $hval[$h] = "HIGH "."<br>= ".$revnhcnt."<br>".$revnhprc."%)"; 
                              }
                              if ($d2 == 2) {
                                  $hval[$h] = "MEDIUM "."<br>= ".$revnmcnt."<br>".$revnmprc."%)"; 
                              }
                              if ($d2 == 3) {
                                  $hval[$h] = "LOW "."<br>= ".$revnlcnt."<br>".$revnlprc."%)"; 
                              }
                              if ($d2 == 4) {
                                  $hval[$h] = "NOT SET "."<br>= ".$revnncnt."<br>".$revnnprc."%)"; 
                              }                              
                              if ($d2 == 5) {
                                  $hval[$h] = "TOTAL "."<br>= ".$revntcnt; 
                              }                               
                              if ($d2 > 5) {
                                  $hval[$h] = "&nbsp"; 
                              }                              
                          }
                          if ($h == 14) {
                              if ($d2 == 1) {
                                  $hval[$h] = "HIGH "."<br>= ".$custhcnt."<br>(".$custhprc."%"; 
                              }
                              if ($d2 == 2) {
                                  $hval[$h] = "MEDIUM "."<br>= ".$custmcnt."<br>(".$custmprc."%"; 
                              }
                              if ($d2 == 3) {
                                  $hval[$h] = "LOW "."<br>= ".$custlcnt."<br>(".$custlprc."%"; 
                              }
                              if ($d2 == 4) {
                                  $hval[$h] = "NOT SET "."<br>= ".$custncnt."<br>(".$custnprc."%)"; 
                              }                              
                              if ($d2 == 5) {
                                  $hval[$h] = "TOTAL "."<br>= ".$custtcnt; 
                              }
                              if ($d2 > 5) {
                                  $hval[$h] = "&nbsp"; 
                              }                                 
                          }
                          if ($h == 15) {
                              if ($d2 == 1) {
                                  $hval[$h] = "HIGH "."<br>= ".$pasthcnt."<br>(".$pasthprc."%)"; 
                              }
                              if ($d2 == 2) {
                                  $hval[$h] = "MEDIUM "."<br>= ".$pastmcnt."<br>(".$pastmprc."%)"; 
                              }
                              if ($d2 == 3) {
                                  $hval[$h] = "LOW "."<br>= ".$pastlcnt."<br>(".$pastlprc."%)"; 
                              }
                              if ($d2 == 4) {
                                  $hval[$h] = "NOT SET "."<br>= ".$pastncnt."<br>(".$pastnprc."%)"; 
                              }                              
                              if ($d2 == 5) {
                                  $hval[$h] = "TOTAL "."<br>= ".$pasttcnt; 
                              }
                              if ($d2 > 5) {
                                  $hval[$h] = "&nbsp"; 
                              }                               
                          }                                                    
                          if ($hval[$h] == "&nbsp"){
                              print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                       <font color=\"#000000\">
                                       </font>
                                      </th> 
                              "); 
                          } else {
                              print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFCC;\">
                                       <font color=\"#330099\">
                                        $hval[$h]
                                       </font>
                                      </th> 
                              ");                          
                          }             
                        } else {
                            //print(" <td align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                            //         <font color=\"#000000\">
                            //         </font>
                            //        </td> 
                            //");            
                        }
                        if (($hprc2[$h] <> 1) && ($hprc3[$h] <> 1)){
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                     <font color=\"#000000\">
                                     </font>
                                    </th> 
                            ");            
                        }
                   }
                   for ($h=25;$h<=28;++$h) {
                        if (($h == 25) or ($h == 27) or ($h == 28)){
                            $colr  = "#FFFFCC";
                            $colrf = "#330099";   
                        } else {
                            $colr = "#99CCFF"; 
                            $colrf = "#330099"; 
                        }
                        if ($hprc2[$h] == 1){
                            if ($h == 25){
                                $wfoundp    = round(($wfound[$d2]/$sumissues[$sumcnt])*100,1);
                                if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){
                                    $wfoundpno  = round(($wfound_no[$d2]/$wfound[$d2])*100,1);
                                    $wfoundpyes = round(($wfound_yes[$d2]/$wfound[$d2])*100,1);
                                    $hval[$h] = "(C)Count<br>=".$wfound[$d2]."<br><br>T = ".$wfoundp."%<br><br>YES = ".$wfound_yes[$d2]."<br>C = ".$wfoundpyes."%<br><br>NO = ".$wfound_no[$d2]."<br>C = ".$wfoundpno."%";
                                } else {
                                    $hval[$h] = $wfound[$d2]."<br>T = ".$wfoundp."%"; 
                                }
                            }                            
                            if ($h == 26){
                                $hval[$h] = $darea[$d2];
                            }                            
                            if ($h == 27){
                                $zfoundp[$d2] = round(($disuecnt_rot[$d2]/$zfound_sum_rot)*100,1);
                                $hval[$h] = $disuecnt_rot[$d2]."<br>"."S = ".$zfoundp[$d2]."%";
                                if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){  
                                     $hval[$h] = $hval[$h]."<br><br>".$zfound_sum_rot_y."<br>".$zfound_sum_rot_n;
                                } 
                            }
                            if ($h == 28){
                                $zfoundp[$d2] = round(($disuecnt_cnt[$d2]/$zfound_sum_cnt)*100,1);  
                                $hval[$h] = $disuecnt_cnt[$d2]."<br>"."S = ".$zfoundp[$d2]."%";
                                if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){  
                                     $hval[$h] = $hval[$h]."<br><br>".$zfound_sum_cnt_y."<br>".$zfound_sum_cnt_n;
                                } 
                            }
                            //if ($prcf[$h] == 1){
                            //    $hval[$h] = $hval[$h]."%";
                            //} 
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                     <font color=\"$colrf\">
                                      $hval[$h]
                                     </font>
                                    </th> 
                            ");            
                        } else {
                            print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #CCFFFF;\">
                                     <font color=\"#000000\">
                                     </font>
                                    </th> 
                            ");            
                        }
                   }
                   $colr  = "#FFFFCC";
                   $colrf = "#FF0000";   
                   for ($i=1;$i<=$icnt ; ++$i) {
                        $yfound  = $zfound[$i][$d2];
                        if ($itypsum[$i] == 0){
                            $yfndprc = 0;
                        } else {
                            $yfndprc = round(($zfound[$i][$d2]/$itypsum[$i])*100,1);
                        }
                        $val = $yfound."<br>(".$yfndprc."%)";
                        if (($darea[$d2] == $h_dpt[1]) or ($darea[$d2] == $h_dpt[2])){  
                             $val = $val."<br><br>".$zfound_sum_y."<br>".$zfound_sum_n;
                        }
                        //$yfound<br>($yfndprc%)<br><br>$zfound_sum_y<br>$zfound_sum_n
                        print(" <th align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: $colr;\">
                                 <font color=\"$colrf\">
                                 $val
                                 </font>
                                </th> 
                            ");
                   } 
                   print("</tr>
                   ");
                 }  
                 // ==================================================
                 // Percentage End 2
                 // ================================================== 
               //$divline = 26+$dcnt+$icnt;
               //print("<div id=\"wrapper\">
               //        <tr>
               //         <td bgcolor=\"#FFFFFF\" colspan=\"$divline\" align=\"left\" valign=\"middle\">
               //          <font color=\"#330099\">
               //           <a onclick=\"switchMenu('myvar');\">Toggle Switch</a>
               //          </font>
               //         </td>
               //        </tr>         
               //");  
             }
                         
             // ==================================================
             // Details Start
             // ==================================================              
             // cube1_main (1-9)
             print("<tr>");
             for ($h=1;$h<=9;++$h) {
                   if ($huse[$h] == 1) {
                       if ($h == 2){
                           print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    <!--<a>$xdtl[$h]</a>-->
                                    <a href=\"javascript:void(0);\" onclick=\"PopupCenter('causeanalysis.php?pdp=$xdtl[$h]', 'myPop1',1000,800);\">$xdtl[$h]</a>
                                   </font>
                                  </td>        
                           ");                           
                       } else { 
                           print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $xdtl[$h]
                                   </font>
                                  </td>        
                           ");
                       }
                   }   
             }
             // cube1_a
             for ($d=1;$d<=$dcnt;++$d) {
                  print("
                         <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:125px;\">
                          <font color=\"#330099\">
                           $ydtl[$d]
                          </font>
                         </td>
                  ");                      
             } 
             // cube1_main (10-25)
             for ($h=10;$h<=25;++$h) {
                   if ($huse[$h] == 1) { 
                       print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                               <font color=\"#330099\">
                                $xdtl[$h]
                               </font>
                              </td>        
                       ");
                   }   
             }
             for ($h=26;$h<=27;++$h) {
                   if ($huse[$h] == 1) { 
                       print("<td bgcolor=\"#CCFFFF\" align=\"center\" valign=\"middle\">
                               <font color=\"#000000\">
                               </font>
                              </td>        
                       ");
                   }   
             }             
             // cube1_b
             for ($i=1;$i<=$icnt ; ++$i) {
                  if ($igrp[$i] == 1){
                      $colr = "#FF0000";
                  } else {
                      $colr = "#330099";
                  }
                  print(" <td align=\"center\" valign=\"middle\" style=\"width: 125px; background-color: #FFFFFF;\">
                           <font color=\"$colr\">
                            $zdtl[$i]
                           </font>
                          </td> 
                      ");
             } 
             print("  </tr>
             ");
             // ==================================================
             // Details End
             // ==================================================              
         }
         print("     </table>
                   </div>
                  </div>
                 </body>
                </html>                     
         ");
         //print("<input type=\"button\" value=\"Toggle Detail Row Display\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");
   } else
   {
       //$found = 0;
                 $captnx = "Criteria";
                 print( "<table>
                          <caption>$captnx</caption>
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             PDP Type
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $prd
                            </font>
                           </td>
                          </tr>
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             RA Testing
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $ra_ind
                            </font>
                           </td>
                          </tr>             
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             PDP Category
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $pdpcat
                            </font>
                           </td>
                          </tr> 
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             Date/Time
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $ydate2
                            </font>
                           </td>
                          </tr> 
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             ETL JOB
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $yetl_id
                            </font>
                           </td>
                          </tr> 
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             REPORT
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             FULL EXTRACT
                            </font>
                           </td>
                          </tr>                                         
                          <tr>
                           <td bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">
                             USER
                            </font>
                           </td>
                           <td bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">
                             $usr
                            </font>
                           </td>
                          </tr>
                          <tr>
                           <td colspan=\"2\" bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:500px;\">
                            <font color=\"#FFFFFF\">
                             NO RECORDS FOUND FOR THIS CRITERIA
                            </font>
                           </td>
                          </tr>
                         </table>
                        </body>
                       </html>                          
                 ");
       //echo "<script type=\"text/javascript\">window.alert(\"No PDP found under this criteria, Please Try Again\")</script>";  
   }
   //print(" </tr>
   //       </table>");
   // -------------------------------------------------------------------------------------------------//       
    $xfilters = "Type = ".$prd."<br>REVENUE ASSURANCE TESTING = ".$ra_ind."<br>PDP CATEGORY = ".$pdpcat;
    $xreport_name = "FULL EXTRACT"; 
    //var_dump($xreport_contents); 
    $query99      = " INSERT into ".$name.".saved_reports(report_name,filters,etl_id,ran_by) 
                      VALUES('$xreport_name','$xfilters','$yetl_id','$usr')"; 
    $mysql_data99 = mysql_query($query99, $mysql_link) or die ("#9.9 Could not query: ".mysql_error());
    $savedrepid   = mysql_insert_id();
    $xreport_path = $xreport_pth.$savedrepid."-".$xreport_nam;
    $query100      = " UPDATE ".$name.".saved_reports
                          SET report_path = '$xreport_path' 
                        WHERE saved_report_id = '$savedrepid' "; 
    $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#9.95 Could not query: ".mysql_error());
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
    $query1      = "select max(etl_id)
                      from ".$name.".etl_monitor
                     where target_cube = 'cube_1_main'";  
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
    print("<form method=\"post\" action=\"./report4z.php\">
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
    $c = 0;
    print("<option selected value=\"ALL\">ALL</option>");
    for ($c=1;$c<=$catcnt ; ++$c) {
        print("<option value=\"$xpdpcat[$c]\">$xpdpcat[$c]</option>");
    }     
    print("
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

   print("<form method=\"post\" action=\"./report4z.php\"> 
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
              <tr>
               <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">ID</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Pathname</font</td>-->
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width: 400px;\"><font color=\"#330099\">Ran Date</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Ran By</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Extract</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
              </tr>
   ");

   $query = "  select saved_report_id,report_name,filters,report_path,etl_id,report_timestamp,ran_by from ".$name.".saved_reports
                where rtrim(report_name) = 'FULL EXTRACT'
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
                     where target_cube = 'cube_1_main'
                       and etl_id = '$wetl_id[$seq]' ";  
    $mysql_data0 = mysql_query($query0, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt0     = mysql_num_rows($mysql_data0);
    while($row0 = mysql_fetch_row($mysql_data0)) {
	         $yetl_timestamp = stripslashes($row0[0]);
	         //$w1  = substr($yetl_timestamp,0,4);
	         //$w2  = substr($yetl_timestamp,5,2);
	         //$w3  = substr($yetl_timestamp,8,2);
	         //$w4  = substr($yetl_timestamp,11,8);
	         //$w5  = $w1.$w2.$w3.$w4;
             //$ww  = date("D",$yetl_timestamp);
             //$wm  = date("m",$yetl_timestamp);
             //$wy  = date("Y",$yetl_timestamp);
             //$wt  = date("H:i:s T",$yetl_timestamp);
             //$wetl_timestamp = $ww."-".$wm."-".$wy." ".$wt; 
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
	            <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#000000\"> 
                    <a href=\"javascript:void(0);\" onclick=\"PopupCenter('$wreport_path[$seq]', 'myPop1',1200,800);\">$wreport_path[$seq]</a>
                 </font>  	             
	            </td>-->
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
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                   $yetl_timestamp
                 </font>  	             
	            </td>
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
    unset($xfilters,$xreport_name,$query99,$savedrepid,$xreport_path,$query100,$mysql_data100,$f,$xreport_contents,$querys5,$mysql_data5,$row5,$usr,$yw,$yd,$ym,$yy,$yt,$yt2,$yentry_dt,$ym,$ydate,$ydate2,$ydate3,$xreport_pth,$xreport_nam,$query69,$mysql_data69,$rowcnt69,$icnt,$rcnt,$ccnt,$ityp,$iccd,$irgrp,$igrp);
    unset($itypsum,$query96,$mysql_data96,$rowcnt96,$dcnt2,$row96,$darea,$disuecnt,$query70,$mysql_data70,$rowcnt70,$dcnt,$dpt,$dsc,$cnd1,$cnd2,$prd,$ra_ind,$pdpcat,$cnd3,$selectx,$orderbyx,$fromx);
    unset($wherex,$queryx,$selecty1,$query84,$mysql_data84,$rowcnt84,$select71,$query71,$mysql_data71,$rowcnt71,$sumcnt,$row71,$sumissues,$sumbillruns,$suminvoices,$sumppwchang,$sumbasehrs);
    unset($sumrwrkhrs,$query72,$selecty,$query73,$query74,$mysql_data74,$rowcnt74,$itypsum,$row74,$rottotal,$cnttotal,$itypprc,$query73,$query77,$grpby77,$mysql_data77,$rowcnt77,$zfound,$zissueclass,$zfound_sum_rot,$$zfound_sum_cnt,$disuecnt_rot,$disuecnt_cnt,$zfound_sum,$ztested,$zfound_sum_y,$zfound_sum_n,$zfound_sum_rot_y,$zfound_sum_rot_n,$zfound_sum_cnt_y,$zfound_sum_cnt_n);
    unset($query97,$grpby97,$query93,$query97,$mysql_data97,$rowcnt97,$row97,$wfound,$query83,$query87,$query87,$mysql_data87,$rowcnt87,$inscpcnt,$outscpcnt,$notsetcnt,$val,$valx);
    unset($rowcnt87,$row87,$scp,$inscpcnt,$outscpcnt,$notsetcnt,$totscpcnt,$notsetprc,$comphcnt,$compmcnt,$complcnt,$revnhcnt,$revnmcnt,$revnlcnt,$revnncnt,$custhcnt,$custmcnt,$custlcnt,$custncnt,$pasthcnt);
    unset($pastmcnt,$pastlcnt,$pastncnt,$comptcnt,$revntcnt,$custtcnt,$pasttcnt,$sctn,$cols,$scnt,$head,$huse,$hsum,$hval,$hprc,$prcf,$hprc3,$sumbasehrs,$hprc2,$mysql_datax,$rowcntx);
    unset($seq,$rowttl,$xdtl,$query81,$mysql_data81,$rowcnt81,$row81,$ydtl,$query82,$mysql_data82,$rowcnt82,$zdtl,$row82,$captnx,$s,$h,$d,$i,$colr,$wfoundp,$query107,$fromx1,$wherex1,$query103,$mysql_data107,$rowcnt107,$wfound_no,$wfound_yes,$h_dpt,$query108,$mysql_data108,$rowcnt108,$row108);
// ================================================================================================================
// ================================================================================================================
mysql_close($mysql_link);
?>
