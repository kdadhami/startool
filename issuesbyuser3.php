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

// ============================================================================================
// ======================================== HTML START ========================================
// ============================================================================================
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

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
          caption    { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
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
");

if ($start == 1) {
//print("$usrx");
print("
        <body>
         <table border='1' align=\"center\" width=\"100%\" style=\"border: 1px solid #CCCCCC; border-color:#CCCCCC; background-color: #FFFFFF\">
              <tr>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 PDP
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 Type
                </font>
               </td>               
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 Issue No
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 Issue ID
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 Update ID
                </font>
               </td>               
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 150px;\">
                <font color=\"#330099\">
                 Issues and Updates
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 M/U
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 BY
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                <font color=\"#330099\">
                 ON
                </font>
               </td>
               <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 75px;\">
                <font color=\"#330099\">
                 Found By
                </font>
               </td>                                             
               <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 150px;\">
                <font color=\"#330099\">
                 &nbsp
                </font>
               </td>                                             
");

// ================================== INITIALIZATION START ====================================
// This loading of array helps to sort Root Cause and Contributing Factors 
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
                  //print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
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
      //print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
}
print("<br><br>");
for ($i=1;$i<=$icnt;++$i) {
     if ($igrp[$i] == 1){
         //print($ityp[$i]." is ".$igrp[$i]."<br>");
     } else {
         //print($ityp[$i]." is ".$igrp[$i]."<br>");
     }
}
print("<br><br>");
// ----->>>>>>>> print("PDP ID: ".$xid."<br> PDP Description: ".$xpdp_desc."<br><br>");
// ================================== INITIALIZATION END ======================================

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
     //print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: $colr;\">
     //         <font color=\"#330099\">
     //          $ityp[$i]
     //         </font>
     //        </td> 
     //");                
}
print("
        <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
         <font color=\"#330099\">
          PARITY
         </font>
        </td>
       </tr>
");

       // =====================================================================================
       // ================================== SELECT ALL PDP ===================================
       // =====================================================================================
       $query78       = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                               a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                               a.revenue_id,a.comparison_id,a.pdp_period_id,a.main_pdp_id,a.parent_pdp_id 
                          from ".$name.".pdp a
                      order by main_pdp_id,a.pdp_id ";
                      //where a.pdp_desc = '$pdp'                     
       $mysql_data78 = mysql_query($query78, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt78     = mysql_num_rows($mysql_data78);
       $pdpno        = 0;
       $isuno        = 0;

       // =====================================================================================
       // ========================== FROM ALL PDP SELECT EACH ONE BY ONE ======================
       // =====================================================================================
       while($row78 = mysql_fetch_row($mysql_data78)) {
             $pdpno            = $pdpno + 1;
	         $xid              = stripslashes($row78[0]);
	         $xpdp_desc        = stripslashes($row78[1]);
             $xupdated_date    = stripslashes($row78[2]);
             $xd               = date("d",$xupdated_date);
             $xm               = date("M",$xupdated_date);
             $xy               = date("Y",$xupdated_date);
             $xdt              = $xd."-".$xm."-".$xy;
             $xupdated_by      = stripslashes($row78[3]);
             $xpdp_name        = stripslashes($row78[4]);    
             $xpdp_owner       = stripslashes($row78[5]); 
             $xpdp_launch      = stripslashes($row78[6]);
             $xpdp_status      = stripslashes($row78[7]); 
             $xpdp_period_id   = stripslashes($row78[8]);
             $xpdp_category_id = stripslashes($row78[9]);
             $xcomplexity_id   = stripslashes($row78[10]);
             $xprojection_id   = stripslashes($row78[11]);
             $xrevenue_id      = stripslashes($row78[12]);
             $xcomparison_id   = stripslashes($row78[13]);
             $xpdp_period_id   = stripslashes($row78[14]);
             $xmain_pdp_id     = stripslashes($row78[15]);
             $xparent_pdp_id   = stripslashes($row78[16]);
             $xpdp_owner       = str_replace("'","",$xpdp_owner);

             if (empty($xparent_pdp_id) && empty($xmain_pdp_id)){
                 $xparent_pdp_id = $xid;
                 $xmain_pdp_id   = $xid;
             }

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

             // =====================================================================================
             // =========================== FIND PERIOD FOR GIVEN PDP ===============================
             // =====================================================================================
             $query71     = "select pdp_period 
                                from ".$name.".pdp_periods
                               where pdp_period_id = '$xpdp_period_id'  "; 
             $mysql_data71 = mysql_query($query71, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt71     = mysql_num_rows($mysql_data71);
             if ($rowcnt71 == 0) {
                 $xpdp_period = "NOT SET";
             } else { 
               while($row71 = mysql_fetch_row($mysql_data71)) {
                     $xpdp_period = stripslashes($row71[0]);   
               }
             }
             
             $tcnt         = array();
             for ($i=1;$i<=$icnt ; ++$i) {
                  $tcnt[$i]  = 0;
             }
       
       // ================================== LOAD ROOT CAUSE START ====================================
       // $pi                    indicates a given issue in the pdp
       // $pu                    indicates a given update in an issue
       // piid[$picnt]           indicates issue_id of an issue in a given pdp
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
       // Second dimension is known from Initialization Section i.e. ($icnt)         
       // Know the 1st dimension i.e. $picnt (No. of issues in a given PDP)
       $query80      = "select a.issue_id,a.issue_desc,a.created_by,a.created_on,b.issue_area
                          from ".$name.".issues a, issue_areas b
                         where a.pdp_id = '$xid'
                           and a.created_by = '$usrx' 
                           and a.void   = 0
                           and a.issue_area_id = b.issue_area_id
                      order by a.issue_id";
       // ----->>>>>>>> print("SQL: Get all Issues for this PDP<br>"."$query80"."<br>");               
       $mysql_data80 = mysql_query($query80, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt80     = mysql_num_rows($mysql_data80);
       $picnt        = 0;
       //if ($rowcnt80 <> 0) {
       while($row80  = mysql_fetch_row($mysql_data80)) {
             $picnt          = $picnt + 1;
             //$isuno          = $isuno + 1;           
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
             // Load Master Record
             $line           = 1;
             $query91        = "select a.issue_type_id,b.issue_type 
                                  from ".$name.".issue_surrogates a, issue_types b 
                                 where a.issue_surrogate_id = $piid[$picnt]
                                   and a.surrogate_type = 0
                                   and a.issue_type_id = b.issue_type_id
                               ";
             // ----->>>>>>>> print("SQL: Get all Root Cause logged in Master Record for issue ".$piid[$picnt]."<br>"."$query91"."<br><br>");                   
             $mysql_data91   = mysql_query($query91, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt91       = mysql_num_rows($mysql_data91);
             $pitcnt         = 0;
             while($row91  = mysql_fetch_row($mysql_data91)) {
                   $pitcnt         = $pitcnt + 1;
                   $pitid[$pitcnt] = stripslashes($row91[0]);
                   $pityp[$pitcnt] = stripslashes($row91[1]);
             }
             // Know how many updates has happened on this issue 
             $query57      = " select a.issue_history_id,a.issue_note,a.issue_assignee,a.issue_note_dt,b.issue_area 
                                 from ".$name.".issue_history a, issue_areas b  
                                where a.issue_id = $piid[$picnt]
                                  and a.issue_assignee = '$usrx'
                                  and a.issue_area_id = b.issue_area_id ";
             $mysql_data57 = mysql_query($query57, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt57     = mysql_num_rows($mysql_data57);
             // ----->>>>>>>> print("SQL: Get all Updates for issue ".$piid[$picnt]."<br>"."$query57"."<br>");
             //if ($rowcnt57 == 0){
             //} else {
             $pimax[$picnt] = $line + $rowcnt57;  // Record that will be used in Analysis, Master line if no updates else the last update line
             $piu           = $pimax[$picnt] - 1; // No. of updates
             $pim           = $pimax[$picnt];     // Same as $pimax[$picnt] 
             //}                   
             // ----->>>>>>>> print("<br>"."Master Record"."<br> Line = ".$line);
             // ----->>>>>>>> print("<br>"."No. of Root Casuses Found = ".$pitcnt);
             // ----->>>>>>>> print("<br>"."[picnt]-[line]-[i]");
             for ($i=1;$i<=$icnt ; ++$i) {
                  $pi[$picnt][$line][$i] = 0;
                  for ($pit=1;$pit<=$pitcnt ; ++$pit) {
                       if ($ityp[$i] == $pityp[$pit]){
                           $pi[$picnt][$line][$i] = 1;
                           if ($line == $pimax[$picnt]) {
                               $totl      = $pi[$picnt][$line][$i];
                               $tcnt[$i]  = $tcnt[$i] + 1;
                               $tcnt0[$i] = $tcnt0[$i] + 1; 
                           } 
                       } else {
                           //$pi[$picnt][$i][$line] = 0;    
                       }
                  } 
                  $ypi = $pi[$picnt][$line][$i];
                  // ----->>>>>>>> print("<br>".$picnt." - ".$line." - ".$i." - Value = ".$ypi." - ".$ityp[$i]);
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
             }
             // ----->>>>>>>> print("<br><br>"."Updates Found "." = ".$piu."<br><br>");
             // pu indicates no. of updates found
             // putcnt indicates no. of issue types (root cause) for each update i.e. issue_history_id  
             for ($pu=1;$pu<=$pucnt ; ++$pu) {
                  //$pu           = $pu + 1;
                  $line           = $line + 1;
                  $yid            = $puid[$picnt][$pu+1]; 
                  $query81        = "select a.issue_type_id,b.issue_type 
                                       from ".$name.".issue_surrogates a, issue_types b 
                                      where a.issue_surrogate_id = '$yid' 
                                        and a.surrogate_type = 1
                                        and a.issue_type_id = b.issue_type_id
                                    ";
                  // ----->>>>>>>> print("SQL: Get all Root Cause logged in for this Update Record ".$yid."<br>".$query81."<br><br>");                  
                  $mysql_data81   = mysql_query($query81, $mysql_link) or die ("Could not query: ".mysql_error());
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
                  for ($i=1;$i<=$icnt ; ++$i) {
                       $pi[$picnt][$line][$i] = 0;
                       for ($put=1;$put<=$putcnt ; ++$put) { 
                            if ($ityp[$i] == $putyp[$picnt][$put]){
                                $pi[$picnt][$line][$i] = 1;
                                if ($line == $pimax[$picnt]) {
                                    $totl     = $pi[$picnt][$line][$i];
                                    //if ($iccd[$i] == 'ROT') {
                                        $tcnt[$i] = $tcnt[$i] + 1;
                                    //}
                                    //if ($iccd[$i] == 'CNT'){
                                    //    $tcnt0[$i] = $tcnt0[$i] + 1;
                                    //}    
                                }
                            } else {
                            }
                       }
                       $ypi = $pi[$picnt][$line][$i];
                       // ----->>>>>>>> print("<br>".$picnt." - ".$i." - ".$line." - Value = ".$ypi." - ".$ityp[$i]);
                  }
                  // ----->>>>>>>> print("<br><br>");
             }                   
       }
       //}
       // ----->>>>>>>> print("========================================================<br>");
       // adding up totals of all issues types per issue class (picking all issue types and ignoring reporting groups)
       for ($i=1;$i<=$icnt ; ++$i) {
            if (($iccd[$i] == "ROT") && ($igrp[$i] == 0)) {
                $stotlr  = $stotlr + $tcnt[$i];
            }
            if (($iccd[$i] == "CNT") && ($igrp[$i] == 0)) {
                $stotlc = $stotlc + $tcnt[$i];
            }
            //if ($ytotl <= 9) {
            //    if ($i <= 9) {
            //        // ----->>>>>>>> print("0".$i." = "."0".$ytotl." - ".$ityp[$i]."<br>");
            //    } else {
            //        // ----->>>>>>>> print($i." = "."0".$ytotl." - ".$ityp[$i]."<br>"); 
            //    }
            //} else {
            //    if ($i <= 9) {
            //        // ----->>>>>>>> print("0".$i." = ".$ytotl." - ".$ityp[$i]."<br>");
            //    } else {
            //        // ----->>>>>>>> print($i." = ".$ytotl." - ".$ityp[$i]."<br>"); 
            //    }
            //}
       }
       // add all status types (not report group) to come up with the report group values
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
       // ----->>>>>>>> print("<br> Total: ".$stotl."<br>");
       // ----->>>>>>>> print("========================================================<br>");
       // ================================== LOAD ROOT CAUSE END ======================================



       // ================================== HEADING START ===========================================
       // ================================== HEADING END ==============================================



       // ================================== DISPLAY DETAIL RESULTS ===================================
       // display PDP-Wide Root Cause weighted average
       if ($rowcnt80 <> 0) {
        print ("<tr> 
                 <td bgcolor=\"#FFFFFF\" colspan=\"10\" align=\"center\" valign=\"middle\">
                  <font color=\"#330099\">
                   &nbsp
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFCC\" align=\"center\" valign=\"middle\">
                  <font color=\"#330099\">
                   Groups
                  </font>
                 </td>
        ");
        for ($i=1;$i<=$icnt; ++$i) {
             if ($irgrp[$i] == "GRP") {
                 print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                          <font color=\"#FF0000\">
                           $irgrp[$i]
                          </font>
                         </td> 
                 ");
             } else {
                 print(" <td align=\"center\" valign=\"middle\" style=\"width: 50px; background-color: #FFFFCC;\">
                          <font color=\"#330099\">
                           $irgrp[$i]
                          </font>
                         </td> 
                 ");
             }             
        }
        print(" <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\">
                  &nbsp
                 </font>
                </td>
               </tr>  
               <tr>
                <td bgcolor=\"#FFFFFF\" colspan=\"10\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\">
                  &nbsp
                 </font>
                </td>                
                <td bgcolor=\"#FFFFCC\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\">
                  Weighted Averages
                 </font>
                </td>
        ");
        for ($i=1;$i<=$icnt; ++$i) {
             if ($iccd[$i] == "ROT"){
                 if ($stotlr == 0) {
                     $prtotlr = 0;
                 } else {              
                     $prtotlr = round(($tcnt[$i] / $stotlr) * 100,2);
                 }
                 print("
                        <td bgcolor=\"#99FF99\" align=\"center\" valign=\"middle\">
                         <font color=\"#330099\">
                          $prtotlr%
                         </font>
                        </td> 
                 ");
             }
             if ($iccd[$i] == "CNT"){
                 if ($stotlc == 0) {
                     $prtotlc = 0;
                 } else {              
                     $prtotlc = round(($tcnt[$i] / $stotlc) * 100,2);
                 }
                 print("
                        <td bgcolor=\"#9AFEFF\" align=\"center\" valign=\"middle\">
                         <font color=\"#330099\">
                          $prtotlc%
                         </font>
                        </td> 
                 ");
             }
        }
        print("
               <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 &nbsp
                </font>
               </td>
              </tr>  
        ");       
        //display PDP-wide Root Cause totals
        print ("
                <tr> 
                 <td bgcolor=\"#FFFFFF\" colspan=\"10\" align=\"center\" valign=\"middle\">
                  <font color=\"#330099\">
                   &nbsp
                  </font>
                 </td> 
                 <td bgcolor=\"#FFFFCC\" align=\"center\" valign=\"middle\">
                  <font color=\"#330099\">
                   Total (Sum of Colored column)
                  </font>
                 </td>
        ");
        for ($i=1;$i<=$icnt; ++$i) {             // loop through totals 
             $ytotl = $tcnt[$i];
             if ($iccd[$i] == "ROT"){
                 $colr = "#99FF99";
                 print("
                        <td align=\"center\" valign=\"middle\" style=\"background-color: $colr;\">
                         <font color=\"#330099\">
                          $tcnt[$i]
                         </font>
                        </td> 
                 ");
             }
             if ($iccd[$i] == "CNT"){
                 $colr = "#9AFEFF";
                 print("
                        <td align=\"center\" valign=\"middle\" style=\"background-color: $colr;\">
                         <font color=\"#330099\">
                          $tcnt[$i]
                         </font>
                        </td> 
                 ");
             }             
        } 
        print("
               <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 &nbsp
                </font>
               </td>
              </tr>  
        ");
        $blnkline = 5 + $icnt;       
        for ($p=1;$p<=$picnt ; ++$p) {
             print("<tr>
                     <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $xpdp_desc
                      </font>
                     </td>                    
                     <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $xpdp_period
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $p
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $piid[$p]
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                       <font color=\"#330099\">
                       &nbsp
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"left\" valign=\"middle\"  valign=\"middle\" style=\"width: 150px;\">
                      <font color=\"#330099\">
                       $pidesc[$p]
                      </font>
                     </td>                                        
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       M
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $picby[$p]
                      </font>
                     </td>                    
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $pidt[$p]
                      </font>
                     </td>
                     <td bgcolor=\"#FFCC99\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       $pidpt[$p]
                      </font>
                     </td>                      
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                      <font color=\"#330099\">
                       &nbsp
                      </font>
                     </td>                       
             ");
             for ($l=1;$l<=$pimax[$p] ; ++$l) {
                  $parityind = 0;
                  $parityrot = 0;
                  $paritycnt = 0;
                  if ($l <> 1) {
                      $uuid   = $puid[$p][$l];
                      $uudesc = $pudesc[$p][$l];
                      $uby    = $pucby[$p][$l];
                      $uon    = $pudt[$p][$l];
                      $udpt   = $pudpt[$p][$l];                       
                      print("<tr>
                              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                $xpdp_desc
                               </font>
                              </td>                      
                              <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                $xpdp_prd
                               </font>
                               </td> 
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                $p
                               </font>
                              </td>
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                 $piid[$p]
                               </font>
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                $uuid
                               </font>
                              </td>
                              </td>
                               <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\"  valign=\"middle\" style=\"width: 150px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                $uudesc
                               </font>
                              </td>                                        
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                                <font color=\"#330099\">
                                U
                               </font>
                              </td>
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                 $uby
                               </font>
                              </td>                              
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                 $uon
                               </font>
                              </td>
                              <td bgcolor=\"#99FF00\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                 $udpt
                               </font>
                              </td>
                              <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 50px; border: 1px solid #CCCCCC;\">
                               <font color=\"#330099\">
                                 &nbsp
                               </font>
                              </td>                              
                      ");                           
                  }
                  for ($i=1;$i<=$icnt ; ++$i) {
                    $uval     = $pi[$p][$l][$i];
                    if ($igrp[$i] == 0){  
                      if ($uval  == 0) {
                          $uvalx = "&nbsp";
                          $colr  = "#FFFFFF";
                      } else {
                           if ($l == $pimax[$p]){
                              $parityind     = 1;
                              if ($iccd[$i]  == "ROT"){
                                  $parityrot = $parityrot + 1;
                                  $colr      = "#99FF99";
                                  //if ($igrp[$i] == 1){
                                  //    $colr      = "#FF0000";
                                  //}
                              }
                              if ($iccd[$i] == "CNT") {
                                  $paritycnt = $paritycnt + 1;
                                  $colr      = "#9AFEFF";
                                  //if ($igrp[$i] == 1){
                                  //    $colr      = "#FF0000";
                                  //}
                              }
                              $uval      = 1;                 
                              $vval[$i]  = $uval + $vval[$i]; //---->>>> supressing display on number
                              $uvalx     = $vval[$i];         
                              //$uvalx   = "x";               //---->>>> this will supersede uvalx value calculated on previous line, remark it out and the value will come up again
                              //$colr      = "#FFFF00";
                          } else {
                              $uvalx = "&nbsp";
                              $colr  = "#E8E8E8";
                          }
                      }
                    } else {
                      $colr = "#E8E8E8";
                      $uvalx = "&nbsp";
                    }  
                      print("
                             <td align=\"center\" valign=\"middle\" style=\" background-color: $colr; width: 50px; border: 1px solid #CCCCCC;\">
                              <font color=\"#330099\">
                               $uvalx
                              </font>
                             </td>                       
                      " );
                  }
                  if ($l <> $pimax[$p]) {
                      $paritychk = "&nbsp";
                  } else {
                    if ($parityind == 0) {
                        $paritychk = "NOT REQUIRED";
                    }
                    if (($parityrot == 0 && $paritycnt == 0) && $parityind == 1) {
                         $paritychk = "ROOT CAUSE AND MISSED OPPORTUNITIES MISSING";
                    }
                    if (($parityrot > 0 && $paritycnt == 0) && $parityind == 1) {
                         $paritychk = "MISSED OPPORTUNITIES MISSING";
                         if ($parityrot > 1){
                             $paritychk = $paritychk.", WITH MULTIPLE ROOT CAUSES";
                         }
                    }
                    if (($parityrot == 0 && $paritycnt > 0) && $parityind == 1) {
                         $paritychk = "ROOT CAUSE MISSING";
                    }                 
                    if (($parityrot == 1 && $paritycnt > 0) && $parityind == 1) {
                         $paritychk = "OK";
                    }
                    if (($parityrot > 1 && $paritycnt > 0) && $parityind == 1) {
                         $paritychk = "MULTIPLE ROOT CAUSES";
                    }
                  }
                  print(" <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" style=\"width: 50px;\">
                           <font color=\"#330099\">
                            $paritychk
                           </font>
                          </td>
                  ");
             }
             print("</tr>");
        }
       }
       // =============================================================================================
       unset($tcnt,$piid,$pidesc,$pitid,$pityp,$pimax,$puid,$pudesc,$putid,$putyp,$pi,$vval,$ytotl,$stotlr,$stotlc,$prtotlr,$prtotlc,$rtotl,$picby,$picon,$picdt,$pucby,$pucon,$pudt);
       //print(" <!--</tr>
       //       </table>-->
       //");       
       }
       print("</table>
       ");
}       

if ($start == 0) {       
    // ==============================
    $querys66 = "SELECT lanid FROM ".$name.".users
                  WHERE lanid not in ('BACKOFFICE','WEBMASTER')" ;
    //print($querys5);
    $mysql_data66 = mysql_query($querys66, $mysql_link) or die ("Could not query: ".mysql_error());
    $usrcnt = 0;
    while ($row66 = mysql_fetch_row($mysql_data66)) {
           $usrcnt = $usrcnt + 1;
           $usrname[$usrcnt]  = stripslashes($row66[0]);
    }
    // ==============================
    $captn = "Select User";
    print("<body>
            <form method=\"post\" action=\"./issuesbyuser3.php\">
             <table border='0' scroll=\"yes\">
              <caption>$captn</caption>
              <tr>
               <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
                <font color=\"#330099\">Select User:</font>
               </td>
               <td> 
                <select name=\"usrx\">
    ");
    $u = 0;
    //print("<option selected value=\"ALL\">ALL</option>");
    for ($u=1;$u<=$usrcnt;++$u) {
        print("<option value=\"$usrname[$u]\">$usrname[$u]</option>");
    }     
    print("
              </select>
             </td>
            </tr> 
            <tr>
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
              <!--<input type=\"hidden\" name=\"usrx\" value=\"$usrx\">-->
             </td>
            </tr>
           </table>  
          </form>  
    ");


}
       print(" </body>
              </html>
       ");           
       mysql_close($mysql_link);
?>        
