<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

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


// setting up today's date
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

//Start of HTML
//================================================================================================================
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

if ($start == 1) {
   // ============================== ISSUE TYPE START ==============================
   $query69               = "select distinct issue_type,issue_class,report_group,group_used
                               from ".$name.".cube1_b
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
         //print($icnt." - ".$ityp[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]."<br>");
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
        $wherex  = " where a.etl_id = '$yetl_id' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.etl_id = b.etl_id
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;               
   } 
   
   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.pdp_type = '$prd' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }      

   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.pdp_category = '$pdpcat' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.etl_id = b.etl_id
                       and a.pdp_category = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and a.pdp_category = '$pdpcat'";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and a.etl_id = b.etl_id
                       and a.pdp    = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd'
                       and a.etl_id = b.etl_id
                       and a.pdp_category = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   
   // ============================= SUM OF TRACKER START ===========================
   $select71              = "select sum(a.issues_created),sum(a.bills_run),sum(a.invoices_generated),
                                    sum(a.ppw_changes),sum(a.baseline_hours),sum(a.rework_hours) ";
   $query71               = $select71.$fromx.$wherex; 
   $mysql_data71          = mysql_query($query71, $mysql_link) or die ("#2.6 Could not query: ".mysql_error());
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
        $selecty      = "( select a.pdp ";
        $query73      = $selecty.$fromx.$wherex.")";
        $query72      = "select sum(occurance)
                           from ".$name.".cube1_b
                          where etl_id     = '$yetl_id'
                            and issue_type = '$ityp[$i]'
                            and pdp in ";
        $query74      = $query72.$query73;
        //print($query74);                    
        $mysql_data74 = mysql_query($query74, $mysql_link) or die ("#2.1 Could not query: ".mysql_error());
        $rowcnt74     = mysql_num_rows($mysql_data74);
        while($row74  = mysql_fetch_row($mysql_data74)) {
              $itypsum[$i] =  stripslashes($row74[0]);
              if (($igrp[$i] == 0) && ($iccd[$i] == "ROT")){
                  $rottotal = $rottotal + $itypsum[$i]; 
              }         
              if (($igrp[$i] == 0) && ($iccd[$i] == "CNT")){
                  $cnttotal = $cnttotal + $itypsum[$i]; 
              }
        }                 
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
   // =========================== SUM OF ISSUE PER AREA START ==========================
   //for ($i=1;$i<=$icnt;++$i) {
   //     $selecty      = "( select a.pdp ";
   //     $query73      = $selecty.$fromx.$wherex.")";
   //     $query77      = "select issue_area,sum(found_issues)
   //                        from ".$name.".cube1_c
   //                       where etl_id     = '$yetl_id'
   //                         and issue_type = '$ityp[$i]'
   //                         and pdp in ";
   //     $query77      = $query77.$query73;
   //     //print($query74);                    
   //     //$mysql_data77 = mysql_query($query77, $mysql_link) or die ("#2.1 Could not query: ".mysql_error());
   //     //$rowcnt77     = mysql_num_rows($mysql_data77);
   //     //while($row74  = mysql_fetch_row($mysql_data74)) {
   //    //      $itypsum[$i] =  stripslashes($row74[0]);
   //     //      if (($igrp[$i] == 0) && ($iccd[$i] == "ROT")){
   //     //          $rottotal = $rottotal + $itypsum[$i]; 
   //     //      }         
   //     //      if (($igrp[$i] == 0) && ($iccd[$i] == "CNT")){
   //     //          $cnttotal = $cnttotal + $itypsum[$i]; 
   //     //      }
   //    //}                 
   //}  
   // ============================= SUM OF ISSUE PER AREA END ==========================
   // ===================== SETTING UP HEADERS ====================
   // Sections
   $sctn[1]  = "PDP Information";
   $cols[1]  = 12;
   $sctn[2]  = "Scoping";
   $cols[2]  = 6;
   $sctn[3]  = "Testing Execution";
   $cols[3]  = 9;
   $sctn[4]  = "Root Causes";
   $cols[4]  = $rcnt;
   $sctn[5]  = "Contributing Factors";
   $cols[5]  = $ccnt;
   $scnt     = 5;
   // Headings
   // PDP Information (1-10) + 2 for PDP Testing = 12
   $head[1]  = "No";
   $huse[1]  = 1;
   $hsum[1]  = 0;
   $head[2]  = "PDP No.";
   $huse[2]  = 1;
   $hsum[2]  = 0;
   $head[3]  = "Description";
   $huse[3]  = 1;
   $hsum[3]  = 0;
   $head[4]  = "Owner";
   $huse[4]  = 1;
   $hsum[4]  = 0;
   $head[5]  = "Type";
   $huse[5]  = 1;
   $hsum[5]  = 0;
   $head[6]  = "Status";
   $huse[6]  = 1;
   $hsum[6]  = 0;
   $head[7]  = "Launch (YYYY-MM-DD)";
   $huse[7]  = 1;
   $hsum[7]  = 0;
   $head[8]  = "Parent PDP";
   $huse[8]  = 1;
   $hsum[8]  = 0;
   $head[9]  = "Main PDP";
   $huse[9]  = 1;
   $hsum[9]  = 0;
   // PDP Testing
   $head[10] = "Issue Created";
   $huse[10] = 1;
   $hsum[10] = 1;
   $hval[10] = $sumissues[$sumcnt];
   // Scoping (11-16)
   $head[11] = "PDP Category";
   $huse[11] = 1;
   $hsum[11] = 0;
   $head[12] = "Scoping";
   $huse[12] = 1;
   $hsum[12] = 0;
   $head[13] = "Complexity";
   $huse[13] = 1;
   $hsum[13] = 0;
   $head[14] = "Revenue Impact";
   $huse[14] = 1;
   $hsum[14] = 0;
   $head[15] = "Customer Impact";
   $huse[15] = 1;
   $hsum[15] = 0;
   $head[16] = "Past Impact";
   $huse[16] = 1;
   $hsum[16] = 0;
   //Testing Execution (17-25)
   $head[17] = "Execution Start Date (YYYY-MM-DD)";
   $huse[17] = 1;
   $hsum[17] = 0;
   $head[18] = "Execution End Date (YYYY-MM-DD)";
   $huse[18] = 1;
   $hsum[18] = 0;
   $head[19] = "Bill Runs";
   $huse[19] = 1;
   $hsum[19] = 1;
   $hval[19] = $sumbillruns[$sumcnt];
   $head[20] = "Invoice Generated";
   $huse[20] = 1;
   $hsum[20] = 1;
   $hval[20] = $suminvoices[$sumcnt];
   $head[21] = "PPW Changes";
   $huse[21] = 1;
   $hsum[21] = 1;
   $hval[21] = $sumppwchang[$sumcnt];
   $head[22] = "Launch in Jeopardy";
   $huse[22] = 1;
   $hsum[22] = 0;
   $head[23] = "Baseline Work (Hours)";
   $huse[23] = 1;
   $hsum[23] = 1;
   $hval[23] = $sumbasehrs[$sumcnt];
   $head[24] = "Rework (Hours)";
   $huse[24] = 1;
   $hsum[24] = 1;
   $hval[24] = $sumrwrkhrs[$sumcnt];
   $head[25] = "Percentage Rework ";
   $huse[25] = 1;
   $hsum[25] = 0;
   $hprc[25] = 1;
   if ($sumbasehrs[$sumcnt] == 0){
       $hval[25] = 0; 
   } else {
       $hval[25] = round(($sumrwrkhrs[$sumcnt]/$sumbasehrs[$sumcnt])*100,1);
   }
   // =============================================================

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
                  $mysql_data82     = mysql_query($query82, $mysql_link) or die ("#2.7 Could not query: ".mysql_error());
                  $rowcnt82         = mysql_num_rows($mysql_data82); 
                  while($row82      = mysql_fetch_row($mysql_data82)) {
                        $zdtl[$i]   = stripslashes($row82[0]);        //department
                        if ($zdtl[$i] == 0){
                            $zdtl[$i] = "&nbsp";
                        }
                  }
             }
             //             
	         $xdtl[10]   = stripslashes($rowttl[10]);              //$xissues_created
	         $xdtl[11]   = stripslashes($rowttl[11]);              //$xpdp_category
	         $xdtl[12]   = stripslashes($rowttl[12]);              //$xscoping
	         $xdtl[13]   = stripslashes($rowttl[13]);              //$xcomplexity_factor
	         $xdtl[14]   = stripslashes($rowttl[14]);              //$xrevenue_factor
	         $xdtl[15]   = stripslashes($rowttl[15]);              //$xcustomer_factor
	         $xdtl[16]   = stripslashes($rowttl[16]);              //$xpast_factor
	         $xdtl[17]   = substr(stripslashes($rowttl[17]),0,-9); //$xtesting_start_date
	         $xdtl[18]   = substr(stripslashes($rowttl[18]),0,-9); //$xtesting_end_date
	         $xdtl[19]   = stripslashes($rowttl[19]);              //$xbills_run
	         $xdtl[20]   = stripslashes($rowttl[20]);              //$xinvoices_generated
	         $xdtl[21]   = stripslashes($rowttl[21]);              //$xppw_changes
	         $xdtl[22]   = stripslashes($rowttl[22]);              //$xlaunch_in_jeopardy
	         $xdtl[23]   = (float)stripslashes($rowttl[23]);       //$xbaseline_hours
	         $xdtl[24]   = (float)stripslashes($rowttl[24]);       //$xrework_hours
	         $xdtl[25]   = (float)stripslashes($rowttl[25]);       //$xpercentage_rework
             if ($seq == 1) {
                 //    
                 $captn = "PDP Summary Report";
                 print("<table border='1' scroll=\"yes\" style=\"width: 300%; border-style:solid; border-color:#CCCCCC;\" >
                         <caption >$captn</caption>
                 ");
                              
                 print("<tr>");
                 for ($s=1;$s<=$scnt;++$s) {
                      print("<td bgcolor=\"#CCCCCC\" colspan=\"$cols[$s]\" align=\"center\" valign=\"middle\">
                             <font color=\"#330099\">
                              $sctn[$s]
                             </font>
                            </td>            
                      ");            
                 }
                 print("</tr>");
                 // ==================================================
                 // Headers for cube1_main (1-9)
                 // ================================================== 
                 print("<tr>");
                 for ($h=1;$h<=9;++$h) {
                       if ($huse[$h] == 1) { 
                           print("<td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $head[$h]
                                   </font>
                                  </td>        
                           ");
                       }   
                 }
                 // ==================================================
                 // Select Headers for cube1_a
                 // ================================================== 
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                              <font color=\"#330099\">
                               $dpt[$d]
                              </font>
                             </td>
                      ");                      
                 } 
                 // ==================================================
                 // Headers for cube1_main (10-25)
                 // ================================================== 
                 for ($h=10;$h<=25;++$h) {
                       if ($huse[$h] == 1) { 
                           print("<td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
                                   <font color=\"#330099\">
                                    $head[$h]
                                   </font>
                                  </td>        
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
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: $colr;\">
                                   <font color=\"#FF0000\">
                                    $ityp[$i]
                                   </font>
                                  </td> 
                          ");
                      } else {
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: $colr;\">
                                   <font color=\"#330099\">
                                    $ityp[$i]
                                   </font>
                                  </td> 
                          ");
                      }     
                 }
                 print("</tr>
                        <tr> 
                 ");
                 // ==================================================
                 // Sum Start
                 // ================================================== 
                 for ($h=1;$h<=9;++$h) {
                      if ($hsum[$h] == 1){
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                                   <font color=\"#FF0000\">
                                    $hval[$h]
                                   </font>
                                  </td> 
                          ");            
                      } else {
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #CCCCCC;\">
                                   <font color=\"#FF0000\">
                                   </font>
                                  </td> 
                          ");            
                      }
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                              <font color=\"#330099\">
                              </font>
                                   </td>
                      ");                      
                 }       
                 for ($h=10;$h<=25;++$h) {
                      if ($hsum[$h] == 1){
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                                   <font color=\"#FF0000\">
                                    $hval[$h]
                                   </font>
                                  </td> 
                          ");            
                      } else {
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #CCCCCC;\">
                                   <font color=\"#FF0000\">
                                   </font>
                                  </td> 
                          ");            
                      }
                 }
                 for ($i=1;$i<=$icnt ; ++$i) {
                      print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                               <font color=\"#FF0000\">
                                $itypsum[$i]
                               </font>
                              </td> 
                          ");
                 } 
                 print("</tr>
                        <tr> 
                 ");
                 // ==================================================
                 // Sum End
                 // ================================================== 
                 // ==================================================
                 // Percentage Start
                 // ================================================== 
                 for ($h=1;$h<=9;++$h) {
                      if ($hprc[$h] == 1){
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                                   <font color=\"#FF0000\">
                                    $hval[$h]%
                                   </font>
                                  </td> 
                          ");            
                      } else {
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #CCCCCC;\">
                                   <font color=\"#FF0000\">
                                   </font>
                                  </td> 
                          ");            
                      }
                 }
                 for ($d=1;$d<=$dcnt;++$d) {
                      print("
                             <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                              <font color=\"#330099\">
                              </font>
                             </td>
                      ");                      
                 }       
                 for ($h=10;$h<=25;++$h) {
                      if ($hprc[$h] == 1){
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                                   <font color=\"#FF0000\">
                                    $hval[$h]%
                                   </font>
                                  </td> 
                          ");            
                      } else {
                          print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #CCCCCC;\">
                                   <font color=\"#FF0000\">
                                   </font>
                                  </td> 
                          ");            
                      }
                 }
                 for ($i=1;$i<=$icnt ; ++$i) {
                      print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                               <font color=\"#FF0000\">
                                $itypprc[$i]%
                               </font>
                              </td> 
                          ");
                 } 
                 print("</tr>
                        <tr> 
                 ");
                 // ==================================================
                 // Percentage End
                 // ================================================== 
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
                         <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
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
             // cube1_b
             for ($i=1;$i<=$icnt ; ++$i) {
                  if ($igrp[$i] == 1){
                      $colr = "#FF0000";
                  } else {
                      $colr = "#330099";
                  }
                  print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFFF;\">
                           <font color=\"$colr\">
                            $zdtl[$i]
                           </font>
                          </td> 
                      ");
             } 
             print("</tr>
                    <tr> 
             ");       
             // ==================================================
             // Details End
             // ==================================================              
         } 
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"No PDP found under this criteria, Please Try Again\")</script>";  
   }
   print(" </tr>
          </table>");
} else {
  $found = 0;
}
// ================================================================================================================
// ================================================================================================================
if ($found == 0) {
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
    $ind[1]    = "YES";
    $ind[2]    = "NO";
    //$ind_id[0] = 0;
    $ind_id[1] = 1;
    $ind_id[2] = 0;

    // PDP Type
    $queryt = "select distinct(pdp_type) from ".$name.".cube1_main";
    $mysql_datat = mysql_query($queryt, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcntt = mysql_num_rows($mysql_datat); 
    $prdcnt = 0;
    while($rowt = mysql_fetch_row($mysql_datat)) {
          $prdcnt            = $prdcnt + 1;
          $pdp_prd           = stripslashes($rowt[0]);
          $xpdp_prd[$prdcnt] = $pdp_prd;
    }
    $captn = "Report 3";
    print("<form method=\"post\" action=\"./report3.php\">
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
              <font color=\"#330099\">Select Period:</font>
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
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
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
    $queryt1       = "select distinct(pdp_category) 
                        from ".$name.".cube1_main
                       where pdp_category <> '' ";
    $mysql_datat1  = mysql_query($queryt1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1       = mysql_num_rows($mysql_datat1); 
    $catcnt        = 0;
    while($rowt1 = mysql_fetch_row($mysql_datat1)) {
          $catcnt            = $catcnt + 1;
          $pdpcat            = stripslashes($rowt1[0]);
          $xpdpcat[$catcnt] = $pdpcat;
    }
    print(" <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
              <font color=\"#330099\">Select Category:</font>
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
    "); 
}
print("  </div>
        </body>
       </html>
");
// ================================================================================================================
// ================================================================================================================
mysql_close($mysql_link);
?>
