<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: executioncontrol.php
// Date: Novemeber, 2010
// Notes: Hardcoding used in the following query in ('RA')
// $queryy2 = "select pdp_id,issue_area_id,test_ind,short_desc from ".$name.".pdp_testing where pdp_id = '$xid' and short_desc in ('UAT')";
// --------------------------------------------------------------

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
$querys5 = "SELECT user 
              FROM ".$name.".sessions
             WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#21 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area))
                     FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#22 Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);        
              //print($yissue_area_id);
       }         
}
$trans = "loop";
// ==============================

//Back_to_build
//for ($btb=1;$btb<=20;++$btb) {
//     $ybtb[$btb] = $btb;
//}


// setting up today's date
$newd  = date("d"); //day
$newm  = date("m"); //month
$newm2  = date("M"); //month
$newy  = date("Y"); //year
$newt  = time();
$new_dt = mktime(0,0,0,$newm,$newd,$newy);
$today_dt = $newd."-".$newm2."-".$newy." : ";

// getting id of user
//$usr = strtoupper(trim(getenv("username")));
//print $usr;

//load status types
$queryx = "select status_type_id,status_type,status_color_code from ".$name.".status_types where status_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#23 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    
$st_typ_cnt              = 1;
$st_typ_id[$st_typ_cnt]  = 0;
$st_typ[$st_typ_cnt]     = "";
$st_typ_clr[$st_typ_cnt] = "";
//print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
while($rowx = mysql_fetch_row($mysql_datax)) {
      $st_typ_cnt              = $st_typ_cnt + 1;
      $st_typ_id[$st_typ_cnt]  = stripslashes(trim($rowx[0]));
      $st_typ[$st_typ_cnt]     = stripslashes(trim($rowx[1]));      
      $st_typ_clr[$st_typ_cnt] = stripslashes(trim($rowx[2]));
      //print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
}
//print($st_typ_cnt);

// Loading PDP Milestones
$query31      = "   select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq 
                      from ".$name.".pdp_stlc 
                     where issue_area_id = '$uissue_area_id'
                       and milestone_ind = 1 
                  order by milestone_ind desc, milestone_seq asc";
$mysql_data31 = mysql_query($query31, $mysql_link) or die ("#24 Could not query: ".mysql_error());
$rowcnt31         = mysql_num_rows($mysql_data31);
$mil_cnt          = 0;
//$mil_cnt          = $mil_cnt + 1;
//$mil_id[$mil_cnt] = 0;
//print($mil_id[$mil_cnt]."<br>");
while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt            = $mil_cnt + 1;
      $mil_id[$mil_cnt]   = stripslashes($row31[0]);
      $mil[$mil_cnt]      = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]  = stripslashes($row31[2]);
      $mil_time[$mil_cnt] = (float)stripslashes($row31[3]);
      $mil_seq[$mil_cnt]  = (float)stripslashes($row31[4]);
      //print($mil_id[$mil_cnt]."-".$mil[$mil_cnt]."-".$mil_ind[$mil_cnt]."-".$mil_time[$mil_cnt]."-".$mil_seq[$mil_cnt]."<br>");
}
//print("Milestone Count = ".$mil_cnt);

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#25 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$pdp_prd_cnt = 1;
$pdp_prd_id[$pdp_prd_cnt] = 0;
$pdp_prd[$pdp_prd_cnt] = "";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $pdp_prd_cnt              = $pdp_prd_cnt + 1;
      $pdp_prd_id[$pdp_prd_cnt] = stripslashes(trim($rowx[0]));
      $pdp_prd[$pdp_prd_cnt]    = stripslashes(trim($rowx[1]));
}

//loading departments
$queryx2 = "select issue_area_id,issue_area,short_desc from ".$name.".issue_areas where issue_area_ind = 1 and test_ind = 1 "; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#26 Could not query: ".mysql_error());
$rowcntx2 = mysql_num_rows($mysql_datax2);    

$dept_cnt = 0;
//$dept_id[$dept_cnt] = 0;
//$dept[$dept_cnt] = "";
while($rowx2 = mysql_fetch_row($mysql_datax2)) {
      $dept_cnt             = $dept_cnt + 1;
      $dept_id[$dept_cnt]   = stripslashes(trim($rowx2[0]));
      $dept[$dept_cnt]      = stripslashes(trim($rowx2[1]));
      $dept_code[$dept_cnt] = stripslashes(trim($rowx2[2])); 
}

// Yes and No Values
$ind[0]    = "";
$ind[1]    = "Yes";
$ind[2]    = "No";
$ind_id[0] = 0;
$ind_id[1] = 1;
$ind_id[2] = 0;

if ($submit == "Submit") {
   if (isset($update1)) {
    while (list($key) = each($update1)) {
    }
    if (isset($area_cnt)) {
        for ($h=1;$h<=$area_cnt ; ++$h) {
             $queryy = "UPDATE ".$name.".pdp_testing
		                   SET test_ind      = '$ytest_ind[$h]'
		                 WHERE pdp_id        = '$pdpid' 
                           AND issue_area_id = '$yissue_area_id[$h]' "; 
           //print($queryy);
		   $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#27 Could not query: ".mysql_error());
        }    
    }
   }

   if (isset($update2)) {
    while (list($key2) = each($update2)) {
           //print($yactual_testing_daysx[$key2]."<br>");
    //}
    //if (isset($area_cnt)) {
        $xstart_date[$key2]    = mktime(0,0,0,$xms[$key2],$xds[$key2],$xys[$key2]);
        $xend_date[$key2]      = mktime(0,0,0,$xme[$key2],$xde[$key2],$xye[$key2]);
        $xact_end_date[$key2]  = mktime(0,0,0,$xma[$key2],$xda[$key2],$xya[$key2]);
        if ($xstart_date[$key2] == 1167627600) {
            $xstart_date[$key2] = 0;
        } 
        if ($xend_date[$key2] == 1167627600) {
            $xend_date[$key2] = 0;
        }            
        if ($xact_end_date[$key2] == 1167627600) {
            $xact_end_date[$key2] = 0;
        } 
        if ($xact_end_date[$key2] < $xend_date[$key2]) {
            $xact_end_date[$key2] = $xend_date[$key2];
        } 
        // 
        $xstart_date2[$key2]   = mktime(0,0,0,$xmsb[$key2],$xdsb[$key2],$xysb[$key2]);
        $xend_date2[$key2]     = mktime(0,0,0,$xmeb[$key2],$xdeb[$key2],$xyeb[$key2]);
        $xact_end_date2[$key2] = mktime(0,0,0,$xmab[$key2],$xdab[$key2],$xyab[$key2]);
        print($xstart_date2[$key2]."-".$xend_date2[$key2]."-".$xact_end_date2[$key2]."<br>");
        //$ycomments[$key2]      = str_replace("'","",$ycomments[$key2]);
        //$ycomments[$key2]      = str_replace(chr(34),"",$ycomments[$key2]);
        //$ycomments[$key2]    =  substr($ycomments[$key2],0,200);
        // Check if date is January 1, 2007
        if ($xstart_date_2[$key2] == 1167627600) {
            $xstart_date_2[$key2] = 0;
        } 
        if ($xend_date_2[$key2] == 1167627600) {
            $xend_date_2[$key2] = 0;
        } 
        if ($xact_end_date2[$key2] == 1167627600) {
            $xact_end_date2[$key2] = 0;
        }            
        if ($xact_end_date2[$key2] < $xend_date_2[$key2]) {
            $xact_end_date2[$key2] = $xend_date_2[$key2];
        } 
        print($xstart_date2[$key2]."-".$xend_date2[$key2]."-".$xact_end_date2[$key2]."<br>");
        //if (strlen($ycomments[$key2]) == 0) {
        //} else {
        //  //$ycomments[$key2]    = substr($ycomments[$key2],0,200);
        //  $log_entry   = $usr." from ".$uissue_area." updated on ".$today_dt."<br>".$ycomments[$key2]."<br>";
        //  $running_com = $log_entry.$yrunning_com[$key2];
        //  $yrunning_com[$key2] =  $running_com;    ///substr($running_com,0,4999);
        //}
        if ($launch_ind[$key2] == 0){
            $lij = "No";
        } else {
            $lij = "Yes";
        }
        if (empty($yinvoice_cnt[$key2])){
                  $yinvoice_cnt[$key2] = 0;
        }
        if (empty($ybillrun_cnt[$key2])){
                  $ybillrun_cnt[$key2] = 0;
        }
        if (empty($yppw_update[$key2])){
                 $yppw_update[$key2] = 0;
        }         
        $ninvoice_cnt = (int)$yinvoice_cnt[$key2];
        $nbillrun_cnt = (int)$ybillrun_cnt[$key2];
        $nppw_update  = (int)$yppw_update[$key2];
        $queryy = "UPDATE ".$name.".pdp_execution
                      SET updated_by          = '$usr',
                          last_update         = current_timestamp,
                          invoice_count       = '$ninvoice_cnt',
                          bill_run_count      = '$nbillrun_cnt',
                          ppw_update          = '$nppw_update',
                          launch_ind          = '$ylaunch_ind[$key2]'
		            WHERE execution_id        = '$key2' ";
        $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#28 Could not query: ".mysql_error());
        //print($queryy."<br>"); 
        $query9 = "select area_execution_id,pdp_id,issue_area_id
                     from ".$name.".area_execution   
                    where pdp_id        = '$pdpid'
                      and issue_area_id = '$uissue_area_id' "; 
        $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#29 Could not query: ".mysql_error());
        $rowcnt9 = mysql_num_rows($mysql_data9);    
        print($query9."<br>");
        print($xstart_date2[$key2]."-".$xend_date2[$key2]."-".$xact_end_date2[$key2]."<br>");
        if ($rowcnt9 == 1){
            //$wbtb = 1;
            while($rowx9 = mysql_fetch_row($mysql_data9)) {
                  //print(strlen($ycomments[$key2]));
                  if (empty($ycomments[$key2])){
                  } else {
                     $ycomments[$key2]      = str_replace("'","",$ycomments[$key2]);
                     $ycomments[$key2]      = str_replace(chr(34),"",$ycomments[$key2]);
                     $query110 = "INSERT into ".$name.".pdp_logs(pdp_id,issue_area,updated_by,updated_on,comments,module,action,followup)
                                  VALUES('$pdpid','$uissue_area','$usr',current_timestamp,'$ycomments[$key2]','TRACKER',0,1)";
                     $mysql_data110 = mysql_query($query110, $mysql_link) or die ("#110 Could not query: ".mysql_error());
                     $ypdp_log_id   = mysql_insert_id();
                  }
                  $nback_to_build = (int)$yback_to_build[$key2];
                  $nback_to_build2 = (int)$yback_to_build2[$key2];
                  //print($nback_to_build);
                  print($xstart_date2[$key2]."-".$xend_date2[$key2]."-".$xact_end_date2[$key2]."<br>");
                  $query10 = "UPDATE ".$name.".area_execution
                                 SET updated_by            = '$usr', 
                                     last_update           = current_timestamp, 
                                     back_to_build         = '$nback_to_build',
                                     back_to_build2        = '$nback_to_build2',
                                     start_date            = '$xstart_date[$key2]',  
                                     start_date2           = '$xstart_date2[$key2]',
                                     end_date              = '$xend_date[$key2]',
                                     end_date2             = '$xend_date2[$key2]',
                                     actual_end_date       = '$xact_end_date[$key2]',
                                     actual_end_date2      = '$xact_end_date2[$key2]',
                                     actual_testing_days   = '$yactual_testing_days[$key2]',  
                                     actual_testing_days2  = '$yactual_testing_days2[$key2]'
                               WHERE pdp_id                = '$pdpid'
                                 AND issue_area_id         = '$uissue_area_id' ";
                  print($query10."<br>".$key2);            
                  $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#30 Could not query: ".mysql_error());                
            }
        } 

        while (list($key3) = each($yiteration_cnt[$key2])) {
                  if (empty($yiteration_cnt[$key2][$key3])){
                            $yiteration_cnt[$key2][$key3] = 0;
                            $ziteration_cnt               = addslashes($yiteration_cnt[$key2][$key3]);
                  } else {
                            $ziteration_cnt               = addslashes($yiteration_cnt[$key2][$key3]);
                  }
                  $queryz = "UPDATE ".$name.".milestone_surrogates
                                SET iteration_count = '$ziteration_cnt'
                              WHERE execution_id = '$key2' and milestone_id = '$key3'";
                  //print($queryz);            
                  $mysql_dataz = mysql_query($queryz, $mysql_link) or die ("#32 Could not query: ".mysql_error());                
        }
    }
   }   
}

print("<html>
        <head>
         <style>
             body    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px; 
                     }
               td    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                       color: #FFFFFF; 
                     }
         textarea    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }        
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
          /*caption    { background:#FFC000; color:#0000FF; font-size:1em;}*/  
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
         <div id=\"content\">
");

// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------

   $captn="PDP Tracker";
   // -------------------------------------------------------------------------------------
   //Update pdp
   // -------------------------------------------------------------------------------------
   $queryx = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                     a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                     a.revenue_id,a.comparison_id 
               from ".$name.".pdp a
              where a.pdp_desc = '$pdp'"; 
   //print("$queryx"); 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#33 Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$rowcntx");

   if ($rowcntx == 1) {
       $found = 1;   
     
       $seq = 0;
       while($rowx = mysql_fetch_row($mysql_datax)) {
             $seq = $seq + 1;
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
             $xcomparison_id   = stripslashes($rowx[13]);
             //$xpdp_period      = stripslashes($rowx[14]);                          

             if (empty($xpdp_launch)) {
                 $xpdp_launch_dt = "00-00-0000";
             } else {
                 $xpdp_launch_d  = date("d",$xpdp_launch);
                 $xpdp_launch_m  = date("M",$xpdp_launch);
                 $xpdp_launch_y  = date("y",$xpdp_launch);    
                 $xpdp_launch_dt = $xpdp_launch_d."-".$xpdp_launch_m."-".$xpdp_launch_y;
             }

             // Insert a record in pdp_testing if it does not exist
             // ---------------------------------------------------
             $queryy = "select pdp_id,issue_area_id,test_ind,short_desc from ".$name.".pdp_testing where pdp_id = '$xid'"; 
             $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#34 Could not query: ".mysql_error());
             $rowcnty = mysql_num_rows($mysql_datay);  

             if ($rowcnty == 0) {
                $d = 0;
                for ($d=1;$d<=$dept_cnt ; ++$d) {
                     //test_ind = 0 means NO
                     if ($dept_code == "UAT"){
                         $queryi = "INSERT into ".$name.".pdp_testing(pdp_id,issue_area_id,test_ind,short_desc)
                                    VALUES('$xid','$dept_id[$d]',0,'$dept_code[$d]')";
                         $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#35 Could not query: ".mysql_error());
                     }
                }
             } 
             // ---------------------------------------------------
             
             
             
             // start of HTML
             print("
                   <form method=\"post\" action=\"./executioncontrol_cm.php?pdp=$pdp&&start=$start\">
                     <table border='0' align=\"center\" width=\"90%\">
                      <caption>$captn</caption>
                      <tr>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:15%;\"><font color=\"#FFFFFF\"><font color=\"#330099\">ID</font></td>
         	           <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#000000\"> 
                          <a>$xid</a>
                        </font>   
         	           </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">User</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\" style=\"width:30%;\"> 
                         $usr
                        </font>
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Department</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         $uissue_area
                        </font>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP No.</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         $xpdp_desc
                        </font>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP Name</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%; word-wrap: break-word;\">
         	           <font color=\"#330099\"> 
                         $xpdp_name
                        </font> 	            
                       </td>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Owner</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"word-wrap: break-word; width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_owner
                        </font> 	            
         	           </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Launch</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_launch_dt
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Status</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_status
                        </font> 
                       </td> 
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP Type</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
               ");
               $query51 = "select a.pdp_id,a.pdp_period_id,b.pdp_period from ".$name.".pdp a, pdp_periods b where a.pdp_id = '$xid' and a.pdp_period_id = b.pdp_period_id"; 
               $mysql_data51 = mysql_query($query51, $mysql_link) or die ("#36 Could not query: ".mysql_error());
               $rowcnt51 = mysql_num_rows($mysql_data51);
               if ($rowcnt51 == 1) {  
                   while($row51 = mysql_fetch_row($mysql_data51)) {
         	             $xpdp_period = stripslashes($row51[2]);
                   }
               } else {
                 $xpdp_period = "VALUE NOT SET"; 
               }
               print("   $xpdp_period
                        </font> 
                       </td> 
                      </tr>
               ");
               // pdp_tesing start ---------------------------------------------------   
               // Display records for update
               $queryy2 = "select pdp_id,issue_area_id,test_ind,short_desc 
                             from ".$name.".pdp_testing 
                            where pdp_id = '$xid' 
                              and short_desc in ('RA')"; 
               $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("#37 Could not query: ".mysql_error());
               $rowcnty2 = mysql_num_rows($mysql_datay2);  
               $y = 0;

               if ($rowcnty2 == 0) {
                   $d = 0;
                   for ($d=1;$d<=$dept_cnt ; ++$d) {
                        //test_ind = 0 means NO
                        $queryi = "INSERT into ".$name.".pdp_testing(pdp_id,issue_area_id,test_ind,short_desc)
                                   VALUES('$xid','$dept_id[$d]',0,'$dept_code[$d]')";
                        $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#38 Could not query: ".mysql_error());
                   }
               } 

               $queryy3 = "select pdp_id,issue_area_id,test_ind,short_desc from ".$name.".pdp_testing where pdp_id = '$xid' and short_desc in ('RA')"; 
               $mysql_datay3 = mysql_query($queryy3, $mysql_link) or die ("#39 Could not query: ".mysql_error());
               $rowcnty3 = mysql_num_rows($mysql_datay3);  
               //$y = 0;
                
               //if ($rowcnty2 > 0) { ****
               while($rowy3 = mysql_fetch_row($mysql_datay3)) {
                         $y                  = $y + 1;
         	             $yissue_area_id[$y] = stripslashes($rowy3[1]);
                         $ytest_ind[$y]      = stripslashes($rowy3[2]);
                         $yshort_desc[$y]    = stripslashes($rowy3[3]);
                         //print($ytest_ind[$y]);
                         //loading departments
                         $queryx3 = "select issue_area from ".$name.".issue_areas where issue_area_id = '$yissue_area_id[$y]' "; 
                         $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("#40 Could not query: ".mysql_error());
                         $rowcntx3 = mysql_num_rows($mysql_datax3);    
                         while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                               $deptx = stripslashes(trim($rowx3[0]));
                         }
                         print("
                                <tr>
                                 <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">$deptx Testing</font></td>
                                 <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                         ");
                         if ($ytest_ind[$y] == 0) {
                             print(" <select align=\"left\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
                         } else {
                             print(" <select align=\"left\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
                         }
                         for ($e=1;$e<=2; ++$e) {
                              if ($ytest_ind[$y] == $ind_id[$e]) {
                                  print(" <option selected value=\"$ind_id[$e]\">$ind[$e]</option> "); 
                              } else
                              {
                                  print(" <option value=\"$ind_id[$e]\">$ind[$e]</option> ");    
                              }   
                         }                         
                         print("        
                                   </select>
                                   <input type=\"hidden\" name=\"yissue_area_id[$y]\" value=\"$yissue_area_id[$y]\"> 
                                   </td>
                                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">&nbsp</font></td>
         	                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	                        <font color=\"#330099\"> 
                                     &nbsp
                                    </font> 
                                   </td> 
                         ");
               }
               print("</tr>");
       // Insert a record in pdp_execution if it does not exist
       // ---------------------------------------------------
       $query32 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind
                     from ".$name.".pdp_execution where pdp_id = '$xid'"; 
       $mysql_data32 = mysql_query($query32, $mysql_link) or die ("#41 Could not query: ".mysql_error());
       $rowcnt32 = mysql_num_rows($mysql_data32);
       //print($query32."-".$rowcnt32);

       if ($rowcnt32 == 0) {
           $query33 = "INSERT into ".$name.".pdp_execution(pdp_id,launch_ind)
                       VALUES('$xid',0)";
           $mysql_data33 = mysql_query($query33, $mysql_link) or die ("#42 Could not query: ".mysql_error());
           $yexecution_id = mysql_insert_id();
       }
       $query42 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,ppw_update,launch_ind,last_update
                     from ".$name.".pdp_execution where pdp_id = '$xid'"; 
       $mysql_data42 = mysql_query($query42, $mysql_link) or die ("#43 Could not query: ".mysql_error());
       $rowcnt42 = mysql_num_rows($mysql_data42);


       while($row42 = mysql_fetch_row($mysql_data42)) {
               $yexecution_id         = stripslashes($row42[0]);
               $yid                   = stripslashes($row42[0]);
               $ypdp_id               = stripslashes($row42[1]);
               $ystart_dt             = stripslashes($row42[2]);
               $yend_dt               = stripslashes($row42[3]);
               $yupdated_by           = stripslashes($row42[4]);
               $yinvoice_cnt          = stripslashes($row42[5]);
               $ybillrun_cnt          = stripslashes($row42[6]);
               $yppw_update           = stripslashes($row42[7]);
               //$ycomments             = stripslashes($row42[8]);
               $ylaunch_ind           = stripslashes($row42[8]);
               //$ydefects              = stripslashes($row42[10]);
               //$yrunning_com_o        = stripslashes($row42[10]);
               //$yrunning_com          = nl2br(stripslashes($row42[10]));
               //$ystart_dt_2           = stripslashes($row42[12]);
               //$yend_dt_2             = stripslashes($row42[13]);
               //$yactual_end_date      = stripslashes($row42[14]);
               //$yback_to_build        = stripslashes($row42[15]);
               //$yactual_testing_days  = stripslashes($row42[16]);
               $ylast_update          = stripslashes($row42[9]);
               //print($yactual_testing_days);

               $query29 = "select sum(back_to_build),sum(back_to_build2)
                            from ".$name.".area_execution   
                           where pdp_id = '$xid' "; 
               $mysql_data29 = mysql_query($query29, $mysql_link) or die ("#99 Could not query: ".mysql_error());
               $rowcnt29 = mysql_num_rows($mysql_data29);
               //print($rowcnt29); 
               
               while($rowx29 = mysql_fetch_row($mysql_data29)) {
                     $yback_to_build_sum   = stripslashes($rowx29[0]);
                     $yback_to_build_sum2  = stripslashes($rowx29[1]);
               }                  
                
               $query9 = "select area_execution_id,pdp_id,issue_area_id,back_to_build,back_to_build2,start_date,start_date2,end_date,end_date2,
                                 actual_end_date,actual_end_date2,actual_testing_days,actual_testing_days2,updated_by,last_update
                            from ".$name.".area_execution   
                           where pdp_id = '$xid'
                             and issue_area_id = '$uissue_area_id' "; 
               //print($query9);              
               $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#99 Could not query: ".mysql_error());
               $rowcnt9 = mysql_num_rows($mysql_data9);
               //print($rowcnt9);    

               if ($rowcnt9 == 1){
                   $ecnt = 1;
                   while($rowx9 = mysql_fetch_row($mysql_data9)) {
                         $ecnt                    = $ecnt + 1;
                         $exid                    = stripslashes($rowx9[0]);
                         $epid                    = stripslashes($rowx9[1]);
                         $eissue_area_id          = stripslashes($rowx9[2]);
                         $yback_to_build          = stripslashes($rowx9[3]);
                         $yback_to_build2         = stripslashes($rowx9[4]);
                         //$ycomments             = stripslashes($rowx9[5]);
                         //$yrunning_com          = nl2br(stripslashes($rowx9[6]));
                         $ystart_dt               = stripslashes($rowx9[5]);
                         $ystart_dt_2             = stripslashes($rowx9[6]);
                         $yend_dt                 = stripslashes($rowx9[7]);
                         $yend_dt_2               = stripslashes($rowx9[8]);
                         $yactual_end_date        = stripslashes($rowx9[9]);
                         $yactual_end_date2       = stripslashes($rowx9[10]);
                         $yactual_testing_days    = stripslashes($rowx9[11]);
                         $yactual_testing_days2   = stripslashes($rowx9[12]); 
                         $yupdated_by             = stripslashes($rowx9[13]);
                         $ylast_update            = stripslashes($rowx9[14]);
                         //$zrunning_log            = str_replace("<br>", "\n\n", $yrunning_com);

                         $query91 = "select pdp_log_id,updated_by,updated_on,comments,issue_area
                                      from ".$name.".pdp_logs   
                                     where pdp_id = '$xid'
                                       and issue_area = '$uissue_area' 
                                       and module = 'TRACKER'
                                    "; 
                         //print($query91);               
                         $mysql_data91 = mysql_query($query91, $mysql_link) or die ("#91 Could not query: ".mysql_error());
                         $rowcnt91 = mysql_num_rows($mysql_data91);

                         if ($rowcnt91 > 0){
                             $comcnt = 0;
                             $ycomments = "";
                             while($rowx91 = mysql_fetch_row($mysql_data91)) {
                                   $comcnt                  = $comcnt + 1;
                                   $ypdp_log_id             = stripslashes($rowx91[0]);
                                   $yupdated_by             = stripslashes($rowx91[1]);
                                   $yupdated_on             = stripslashes($rowx91[2]);
                                   $ycomments               = stripslashes($rowx91[3]);
                                   $yissue_area             = stripslashes($rowx91[4]);
                                   $urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   $urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                                   //print($urunning_com[$comcnt]);
                             }
                         }     
                   }
               } 
               
               if ($rowcnt9 == 0){
                         if (empty($ystart_dt)) {
                             $ystart_dt_x = 0;
                         } else {
                             $ystart_dt_x = $ystart_dt; 
                         }
                         
                         //if (empty($ystart_dt_2)) {
                         //    $ystart_dt_2x = 0;
                         //} else {
                         //    $ystart_dt_2x = $ystart_dt_2; 
                         //}
      
                         if (empty($yend_dt)) {
                             $yend_dt_x = 0;
                         } else {
                             $yend_dt_x = $yend_dt; 
                         }
                         
                         //if (empty($yend_dt_2)) {
                         //    $yend_dt_2x = 0;
                         //} else {
                         //    $yend_dt_2x = $yend_dt_2; 
                         //}
                         
                         //if (empty($yactual_end_date)) {
                         //    $yactual_end_datex = 0;
                         //} else {
                         //    $yactual_end_datex = $yactual_end_date; 
                         //}
                         //if (empty($yactual_end_date2)) {
                         //    $yactual_end_datex2 = 0;
                         //} else {
                         //    $yactual_end_datex2 = $yactual_end_date2; 
                         //}

                         //$query110 = "INSERT into ".$name.".pdp_logs(pdp_id,issue_area,updated_by,updated_on,comments,module,action,followup)
                         //            VALUES('$xid','$uissue_area','$usr',current_timestamp,'Tracking Started','TRACKER',0,1)";
                         //$mysql_data110 = mysql_query($query110, $mysql_link) or die ("#110 Could not query: ".mysql_error());
                         //$ypdp_log_id   = mysql_insert_id();

                         //$query92 = "select pdp_log_id,updated_by,updated_on,comments,issue_area
                         //             from ".$name.".pdp_logs   
                         //            where pdp_id = '$xid'
                         //              and issue_area = '$uissue_area' 
                         //              and module = 'TRACKER'
                         //           "; 
                         //print($query91);               
                         //$mysql_data92 = mysql_query($query92, $mysql_link) or die ("#91 Could not query: ".mysql_error());
                         //$rowcnt92 = mysql_num_rows($mysql_data92);

                         //if ($rowcnt92 > 0){
                         //    $comcnt = 0;
                         //    $ycomments = "";
                         //    while($rowx92 = mysql_fetch_row($mysql_data92)) {
                                   //$comcnt                  = $comcnt + 1;
                                   //$ypdp_log_id             = stripslashes($rowx92[0]);
                                   //$yupdated_by             = stripslashes($rowx92[1]);
                                   //$yupdated_on             = stripslashes($rowx92[2]);
                                   $ycomments                 = "";
                                   //$yissue_area             = stripslashes($rowx92[4]);
                                   //$urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   //$urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                                   //print($urunning_com[$comcnt]);
                         //    }
                         //}     
                         
                         $query10 = "INSERT into ".$name.".area_execution(pdp_id,issue_area_id,start_date,end_date)
                                     VALUES('$xid','$uissue_area_id','$ystart_dt_x','$yend_dt_x')";
                         //print($query10);                   
                         $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#100 Could not query: ".mysql_error());
                         $epid                    = $xid;
                         $eissue_area_id          = $uissue_area_id;
                         $yback_to_build          = 0;
                         $yback_to_build2         = 0;
                         $ystart_dt_2             = 0;
                         $yend_dt_2               = 0;
                         $yactual_end_date        = 0;
                         $yactual_end_date2       = 0;
                         $yactual_testing_days    = 0;
                         $yactual_testing_days2   = 0; 
               }
               
               // ---------- 1
               if (!empty($ystart_dt) || ($ystart_dt <> 0)){
	               $yds  = date("d",$ystart_dt);
                   $yms  = date("m",$ystart_dt);
                   $yms2 = date("M",$ystart_dt);
                   $yys  = date("Y",$ystart_dt);
                   $ysdt = "$yds"."-"."$yms2"."-"."$yys";
                   $d1 = 4;
               } else {
                   $ysdt = "00-00-0000";
                   //$ysdt = 0;
                   $d2 = 0;    
               }
               if (!empty($yend_dt) || ($yend_dt <> 0)){
	               $yde  = date("d",$yend_dt);
                   $yme  = date("m",$yend_dt);
                   $yme2 = date("M",$yend_dt);
                   $yye  = date("Y",$yend_dt); 
                   $yedt = "$yde"."-"."$yme2"."-"."$yye";
                   $d2 = 2; 
               } else {
                   $yedt = "00-00-0000";
                   //$yedt = 0;
                   $d2 = 0;
               }
               if (!empty($yactual_end_date) || ($yactual_end_date <> 0)){
	               $yda  = date("d",$yactual_end_date);
                   $yma  = date("m",$yactual_end_date);
                   $yma2 = date("M",$yactual_end_date);
                   $yya  = date("Y",$yactual_end_date); 
                   $yadt = "$yda"."-"."$yma2"."-"."$yya";
                   $d3 = 1;
               } else {
                   if ($yedt == "00-00-0000"){
                       $yadt = "00-00-0000";
                       $d3 = 0;
                   } else {
                       $yactual_end_date = $yend_dt;
                       $yda  = date("d",$yactual_end_date);
                       $yma  = date("m",$yactual_end_date);
                       $yma2 = date("M",$yactual_end_date);
                       $yya  = date("Y",$yactual_end_date); 
                       $yadt = "$yda"."-"."$yma2"."-"."$yya";
                       $d3 = 1;
                   }
                   //$yadt = "00-00-0000";
                   //$yadt = 0;
                   //$d3 = 0;
               }

               $d4  = $d1 + $d2 + $d3;
               
               if ($d4 == 6){
                   $testingdays          =  ($yend_dt - $ystart_dt) / 86400;
                   $daysindelay          =  0;
                   $incval = 86400;
                   $wkday1 = 0;
                   $wkend1 = 0;
                   $basedt1 = $ystart_dt;
                   for ($dts=1; $dts<=$testingdays; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1 + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday1 = $wkday1 + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend1 = $wkend1 + 1;     
                        }     
                   }
               
               }
               
               if ($d4 == 7){
                   $testingdays          =  ($yend_dt - $ystart_dt) / 86400;
                   $daysindelay          =  ((($yactual_end_date - $ystart_dt) / 86400) - $testingdays);
                   $incval = 86400;
                   $wkday1 = 0;
                   $wkend1 = 0;
                   $basedt1 = $ystart_dt;
                   for ($dts=1; $dts<=$testingdays; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1 + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday1 = $wkday1 + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend1 = $wkend1 + 1;     
                        }     
                   }
                   $wkday2 = 0;
                   $wkend2 = 0;
                   $basedt2 = $yend_dt;
                   for ($dts=1; $dts<=$daysindelay; ++$dts) {
                        //print($dts);
                        $datval  = $basedt2 + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday2 = $wkday2 + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend2 = $wkend2 + 1;     
                        }     
                   }
               }
               
               if ($d4 < 6){
                   $testingdays   = 0;
                   $daysindelay   = 0;
                   $totdays       = 0;
                   $wkday1        = 0;
                   $wkday2        = 0;
                   $wkday3        = 0;
                   $wkend1        = 0;
                   $wkend2        = 0;
                   $wkend3        = 0;
                   $pland         = "TBD";
                   $delayd        = "TBD";
                   $totd          = "TBD";

               } else {
                       $totdays = $testingdays + $daysindelay;
                       $wkday3  = $wkday1 + $wkday2;
                       $wkend3  = $wkend1 + $wkend2;
                       $pland  = "Potentially  ".$testingdays." days  (".$wkday1." Weekdays  ".$wkend1." Weekend Days)";
                       $delayd = "Potentially  ".$daysindelay." days  (".$wkday2." Weekdays  ".$wkend2." Weekend Days)";
                       $totd   = "Potentially  ".$totdays." days  (".$wkday3." Weekdays  ".$wkend3." Weekend Days)";
               } 

               if (($yactual_testing_days <> 0) && ($totdays <> 0) ) {
                   //$wkdayu = round(($yactual_testing_days / $wkday3),2)*100;
                   if ($yactual_testing_days <= $wkday3){
                       $wkdayu = round(($yactual_testing_days / $wkday3),2)*100;
                       $wkendu = 0;
                   } else {
                       $wkdayu = round(($wkday3 / $wkday3),2)*100;
                       $wkendu = round((($yactual_testing_days - $wkday3) / $wkend3),2)*100;
                   }
                   $utilp = "Weekdays ".$wkdayu."%,  Weekends ".$wkendu."%"; 
               } else {
                    $wkdayu = 0;
                    $wkendu = 0;
                    $utilp = "TBD";
               }

               $d5 = $testingdaysb + $daysindelayb;

               print($ystart_dt_2."<br>");
               print($yend_dt_2."<br>");
               print($yactual_end_date2."<br>");
               // ---------- 2
               if (!empty($ystart_dt_2)){
	               $ydsb  = date("d",$ystart_dt_2);
                   $ymsb  = date("m",$ystart_dt_2);
                   $ymsb2 = date("M",$ystart_dt_2);
                   $yysb  = date("Y",$ystart_dt_2);
                   $ysdtb = "$ydsb"."-"."$ymsb2"."-"."$yysb";
                   $d1b = 4; 
               } else {
                   $ysdtb = "00-00-0000";
                   $d1b = 0;    
               }
               if (!empty($yend_dt_2)){
	               $ydeb  = date("d",$yend_dt_2);
                   $ymeb  = date("m",$yend_dt_2);
                   $ymeb2 = date("M",$yend_dt_2);
                   $yyeb  = date("Y",$yend_dt_2); 
                   $yedtb = "$ydeb"."-"."$ymeb2"."-"."$yyeb";
                   $d2b = 2;
               } else {
                   $yedtb = "00-00-0000";
                   $d2b = 0;
               }
               if (!empty($yactual_end_date2) || ($yactual_end_date2 <> 0)){
	               $ydab  = date("d",$yactual_end_date2);
                   $ymab  = date("m",$yactual_end_date2);
                   $ymab2 = date("M",$yactual_end_date2);
                   $yyab  = date("Y",$yactual_end_date2); 
                   $yadtb = "$ydab"."-"."$ymab2"."-"."$yyab";
                   $d3b = 1;
               } else {
                   if ($yedtb == "00-00-0000"){
                       $yadtb = "00-00-0000";
                       $d3b = 0;
                   } else {
                       $yactual_end_date2 = $yend_dt_2;
                       $ydab  = date("d",$yactual_end_date2);
                       $ymab  = date("m",$yactual_end_date2);
                       $ymab2 = date("M",$yactual_end_date2);
                       $yyab  = date("Y",$yactual_end_date2); 
                       $yadtb = "$ydab"."-"."$ymab2"."-"."$yyab";
                       $d3b = 1;
                   }
                   //$yadt = "00-00-0000";
                   //$yadt = 0;
                   //$d3 = 0;
               }

               $d4b = $d1b + $d2b + $d3b;
               print($d4b);

               if ($d4b == 6){
                   $testingdaysb          =  ($yend_dt_2 - $ystart_dt_2) / 86400;
                   $daysindelayb          =  0;
                   $incval                = 86400;
                   $wkday1b               = 0;
                   $wkend1b               = 0;
                   $basedt1b              = $ystart_dt_2;
                   for ($dts=1; $dts<=$testingdaysb; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1b + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday1b = $wkday1b + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend1b = $wkend1b + 1;     
                        }     
                   }
               
               }
               
               if ($d4b == 7){
                   $testingdaysb          =  ($yend_dt_2 - $ystart_dt_2) / 86400;
                   $daysindelayb          =  ((($yactual_end_date2 - $ystart_dt_2) / 86400) - $testingdaysb);
                   $incval                = 86400;
                   $wkday1b               = 0;
                   $wkend1b               = 0;
                   $basedt1b              = $ystart_dt_2;
                   for ($dts=1; $dts<=$testingdaysb; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1b + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday1b = $wkday1b + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend1b = $wkend1b + 1;     
                        }     
                   }
                   $wkday2b  = 0;
                   $wkend2b  = 0;
                   $basedt2b = $yend_dt_2;
                   for ($dts=1; $dts<=$daysindelayb; ++$dts) {
                        //print($dts);
                        $datval  = $basedt2b + (86400*$dts);
                        $newdate = (string)$datval; 
                        //print($newdate."<br>");
                        $dtday = date("D",$newdate);
                        //echo $dtday;
                        if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                             $wkday2b = $wkday2b + 1;     
                        }     
                        if (($dtday == "Sat") || ($dtday == "Sun")){
                             $wkend2b = $wkend2b + 1;     
                        }     
                   }
               }
               
               if ($d4b < 6){
                   $testingdaysb   = 0;
                   $daysindelayb   = 0;
                   $totdaysb       = 0;
                   $wkday1b        = 0;
                   $wkday2b        = 0;
                   $wkday3b        = 0;
                   $wkend1b        = 0;
                   $wkend2b        = 0;
                   $wkend3b        = 0;
                   $plandb         = "TBD";
                   $delaydb        = "TBD";
                   $totdb          = "TBD";

               } else {
                       $totdaysb = $testingdaysb + $daysindelayb;
                       $wkday3b  = $wkday1b + $wkday2b;
                       $wkend3b  = $wkend1b + $wkend2b;
                       $plandb  = "Potentially  ".$testingdaysb." days  (".$wkday1b." Weekdays  ".$wkend1b." Weekend Days)";
                       $delaydb = "Potentially  ".$daysindelayb." days  (".$wkday2b." Weekdays  ".$wkend2b." Weekend Days)";
                       $totdb   = "Potentially  ".$totdaysb." days  (".$wkday3b." Weekdays  ".$wkend3b." Weekend Days)";
               } 

               if (($yactual_testing_days2 <> 0) && ($totdaysb <> 0) ) {
                   //$wkdayu = round(($yactual_testing_days / $wkday3),2)*100;
                   if ($yactual_testing_days2 <= $wkday3b){
                       $wkdayub = round(($yactual_testing_days2 / $wkday3b),2)*100;
                       $wkendub = 0;
                   } else {
                       $wkdayub = round(($wkday3b / $wkday3b),2)*100;
                       $wkendub = round((($yactual_testing_days2 - $wkday3b) / $wkend3b),2)*100;
                   }
                   $utilpb = "Weekdays ".$wkdayub."%,  Weekends ".$wkendub."%"; 
               } else {
                    $wkdayub = 0;
                    $wkendub = 0;
                    $utilpb = "TBD";
               }

               $d5b = $testingdaysb + $daysindelayb;
               //print($d5);

               print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Execution ID</font></td>
                       <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $yexecution_id
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td colspan=\"4\" align=\"center\" valign=\"middle\" bgcolor=\"#00FF00\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         First Cycle Testing 
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Start Date (dd-mm-yyyy)</font></td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\">
               ");
               if ($ysdt == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print(" <select align=\"left\" name=\"xds[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
                    if ($yds == $xdy_s) {
                        print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_s\">$xdy_s</option> ");
                    }
               }
               print(" </select>
               ");
               print(" <select align=\"left\" name=\"xms[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
                    if ($yms == $xmon_s) {
                        print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_s\">$xmon_s</option> ");
                    }
               }
               print(" </select>
               ");
               print(" <select align=\"left\" name=\"xys[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xyr_s=2007;$xyr_s<=2015; ++$xyr_s) {
                    if ($yys == $xyr_s) {
                        print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_s\">$xyr_s</option> ");
                    }
               }
               print("    
                         </font>
                        </select>
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">&nbsp</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         &nbsp
                        </font>
                       </td>  
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
               ");
               if ($yedt == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print("<select align=\"left\" name=\"xde[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_e=1;$xdy_e<=31; ++$xdy_e) {
                    if ($yde == $xdy_e) {
                        print(" <option selected value=\"$xdy_e\">$xdy_e</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_e\">$xdy_e</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xme[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
               ");
               for ($xmon_e=1;$xmon_e<=12; ++$xmon_e) {
                    if ($yme == $xmon_e) {
                        print(" <option selected value=\"$xmon_e\">$xmon_e</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_e\">$xmon_e</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xye[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
               ");
               for ($xyr_e=2007;$xyr_e<=2015; ++$xyr_e) {
                    if ($yye == $xyr_e) {
                        print(" <option selected value=\"$xyr_e\">$xyr_e</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_e\">$xyr_e</option> ");
                    }
               }
               print("    
                        </font>
                       </select>
                      </td> 
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Planned Testing Window<br>(End - Start)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $pland
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Revised End Date (Creep)<br>(dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
               ");
               if ($yadt == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print("<select align=\"left\" name=\"xda[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_a=1;$xdy_a<=31; ++$xdy_a) {
                    if ($yda == $xdy_a) {
                        print(" <option selected value=\"$xdy_a\">$xdy_a</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_a\">$xdy_a</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xma[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
               ");
               for ($xmon_a=1;$xmon_a<=12; ++$xmon_a) {
                    if ($yma == $xmon_a) {
                        print(" <option selected value=\"$xmon_a\">$xmon_a</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_a\">$xmon_a</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xya[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
               ");
               for ($xyr_a=2007;$xyr_a<=2015; ++$xyr_a) {
                    if ($yya == $xyr_a) {
                        print(" <option selected value=\"$xyr_a\">$xyr_a</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_a\">$xyr_a</option> ");
                    }
               }
               print("    
                         </font>
                        </select>
                       </td>
                       <!--<td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Testing Window Creep<br>(End - Revised End)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $delayd   
                        </font> 
                       </td>-->
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Total Available Days<br>(Revised End - Start)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $totd
                        </font> 
                       </td>
                      </tr>
                ");
               //$d5 = $testingdays + $daysindelay; 
               //print($d5);                        
               
               //if ($d5 > 0) {
                   //Actual Testing Days drop down
                   //for ($ady=1;$ady<=$d5;++$ady) {
                   //     $xady[$ady] = $ady;
                   //}
                   print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Testing Days Utilized</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <select align=\"left\" name=\"yactual_testing_days[$yid]\">
                        <!--<input type=\"text\" name=\"yactual_testing_days[$yid]\" size=\"4\" maxlength=\"4\">-->  
                   ");
                   for ($dy=0;$dy<=$d5;$dy=$dy+1) {
                        //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                     if ($yactual_testing_days == $dy) {
                             print(" <option selected value=\"$dy\">$dy</option>");
                     } else {
                             print(" <option value=\"$dy\">$dy</option>");
                     }   
                   }
                   print("  </select>
                           </td>
                   ");
               //} else {
               //  print("
               //       <tr>
               //        <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Testing Days Utilized</font></td>
               //        <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	   //         <font color=\"#330099\">
         	   //          TBD
               //          <input type=\"hidden\" name=\"yactual_testing_days[$yid]\" value=\"$dy\"> 
               //         </font>
               //        </td>
               //   ");     
               //}     
               //if ($yactual_testing_days <> 0 && $totdays ) {
               //    $wkdayu = ($totdays / $wkday3);
               //} else {
               //}
               print("
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Testing Window Utilization</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\">
         	             $utilp
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yback_to_build[$yid]\" value=\"$yback_to_build\" size=\"4\" maxlength=\"4\"><a>&nbsp($uissue_area) ONLY</a>
                        </font> 
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build<br></font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\">
                         $yback_to_build_sum&nbsp&nbsp(ALL DEPARTMENTS)  
                        </font> 
                       </td>
                      </tr>
               ");
               print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Invoices Generated</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yinvoice_cnt[$yid]\" value=\"$yinvoice_cnt\" size=\"3\" maxlength=\"3\">
                        </font> 
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%x;\"><font color=\"#330099\">Bill Runs</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"ybillrun_cnt[$yid]\" value=\"$ybillrun_cnt\" size=\"3\" maxlength=\"3\">
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PPW Updates</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yppw_update[$yid]\" value=\"$yppw_update\" size=\"3\" maxlength=\"3\">
                        </font> 
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Launch in Jeopoardy</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
               ");
               if ($ylaunch_ind == 0) {
                   print(" <select align=\"left\" name=\"ylaunch_ind[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
               } else {
                   print(" <select align=\"left\" name=\"ylaunch_ind[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               }               
               for ($e=1;$e<=2; ++$e) {
                     if ($ylaunch_ind == $ind_id[$e]) {
                         print(" <option selected value=\"$ind_id[$e]\">$ind[$e]</option> "); 
                     } else
                     {
                         print(" <option value=\"$ind_id[$e]\">$ind[$e]</option> ");    
                     }   
               }                         
               print("         
                        </select> 
                       </td>
                      </tr>
                      <!--<tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Last Updated By</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $yupdated_by
                        </font> 
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Last Updated On</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $ylast_update
                        </font> 
                       </td>
                      </tr>
                      <tr>-->
               ");
               // ====================================== Second Cycle 
               print("       
                      <tr>
                       <td colspan=\"4\" align=\"center\" valign=\"middle\" bgcolor=\"#00FF00\">
         	            <font color=\"#330099\"> 
                         Second Cycle Testing 
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Start Date (dd-mm-yyyy)</font></td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\">
               ");
               if ($ysdtb == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print(" <select align=\"left\" name=\"xdsb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
                    if ($ydsb == $xdy_s) {
                        print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_s\">$xdy_s</option> ");
                    }
               }
               print(" </select>
               ");
               print(" <select align=\"left\" name=\"xmsb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
                    if ($ymsb == $xmon_s) {
                        print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_s\">$xmon_s</option> ");
                    }
               }
               print(" </select>
               ");
               print(" <select align=\"left\" name=\"xysb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xyr_s=2007;$xyr_s<=2015; ++$xyr_s) {
                    if ($yysb == $xyr_s) {
                        print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_s\">$xyr_s</option> ");
                    }
               }
               print("    
                         </font>
                        </select>
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">&nbsp</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         &nbsp
                        </font>
                       </td>  
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
               ");
               if ($yedtb == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print("<select align=\"left\" name=\"xdeb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_e=1;$xdy_e<=31; ++$xdy_e) {
                    if ($ydeb == $xdy_e) {
                        print(" <option selected value=\"$xdy_e\">$xdy_e</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_e\">$xdy_e</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xmeb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
               ");
               for ($xmon_e=1;$xmon_e<=12; ++$xmon_e) {
                    if ($ymeb == $xmon_e) {
                        print(" <option selected value=\"$xmon_e\">$xmon_e</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_e\">$xmon_e</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xyeb[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
               ");
               for ($xyr_e=2007;$xyr_e<=2015; ++$xyr_e) {
                    if ($yyeb == $xyr_e) {
                        print(" <option selected value=\"$xyr_e\">$xyr_e</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_e\">$xyr_e</option> ");
                    }
               }
               print("    
                        </font>
                       </select>
                      </td> 
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Planned Testing Window<br>(End - Start)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $pland
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Revised End Date (Creep)<br>(dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
               ");
               if ($yadt == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print("<select align=\"left\" name=\"xdab[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_a=1;$xdy_a<=31; ++$xdy_a) {
                    if ($ydab == $xdy_a) {
                        print(" <option selected value=\"$xdy_a\">$xdy_a</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_a\">$xdy_a</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xmab[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
               ");
               for ($xmon_a=1;$xmon_a<=12; ++$xmon_a) {
                    if ($ymab == $xmon_a) {
                        print(" <option selected value=\"$xmon_a\">$xmon_a</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_a\">$xmon_a</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xyab[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
               ");
               for ($xyr_a=2007;$xyr_a<=2015; ++$xyr_a) {
                    if ($yyab == $xyr_a) {
                        print(" <option selected value=\"$xyr_a\">$xyr_a</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_a\">$xyr_a</option> ");
                    }
               }
               print("    
                         </font>
                        </select>
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Total Available Days<br>(Revised End - Start)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $totdb
                        </font> 
                       </td>
                      </tr>
                ");
               //$d5 = $testingdays + $daysindelay; 
               //print($d5);                        
               
               //if ($d5 > 0) {
                   //Actual Testing Days drop down
                   //for ($ady=1;$ady<=$d5;++$ady) {
                   //     $xady[$ady] = $ady;
                   //}
                   print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Testing Days Utilized</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <select align=\"left\" name=\"yactual_testing_days2[$yid]\">
                   ");
                   for ($dy=0;$dy<=$d5b;$dy=$dy+1) {
                        //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                     if ($yactual_testing_days2 == $dy) {
                             print(" <option selected value=\"$dy\">$dy</option>");
                     } else {
                             print(" <option value=\"$dy\">$dy</option>");
                     }   
                   }
                   print("  </select>
                           </td>
                   ");
               //} else {
               //  print("
               //       <tr>
               //        <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Testing Days Utilized</font></td>
               //        <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	   //         <font color=\"#330099\">
         	   //          TBD
               //          <input type=\"hidden\" name=\"yactual_testing_days[$yid]\" value=\"$dy\"> 
               //         </font>
               //        </td>
               //   ");     
               //}     
               //if ($yactual_testing_days <> 0 && $totdays ) {
               //    $wkdayu = ($totdays / $wkday3);
               //} else {
               //}
               print("
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Testing Window Utilization</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\">
         	             $utilpb
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yback_to_build2[$yid]\" value=\"$yback_to_build2\" size=\"4\" maxlength=\"4\"><a>&nbsp($uissue_area) ONLY</a>
                        </font> 
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build<br></font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\">
                         $yback_to_build_sum2&nbsp&nbsp(ALL DEPARTMENTS)  
                        </font> 
                       </td>
                      </tr>

                <tr>
                 <td colspan=\"4\" bgcolor=\"#99CCFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Enter New Comments
                  </font>
                 </td>
                </tr>
                      <tr>
                       <td colspan=\"4\" align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\">
         	            <font color=\"#330099\">
                         <textarea name=\"ycomments[$yid]\" cols=\"1\" rows=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\"></textarea> 
                        </font>
                       </td>
                       <!--<input type=\"hidden\" name=\"yrunning_com[$yid]\" value=\"$yrunning_com\">-->
                      </tr>
                <tr>
                 <td colspan=\"4\" bgcolor=\"#99CCFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Comments Log
                  </font>
                 </td>
                </tr>
                <tr>
                  <td colspan=\"4\" border=\"1\" bgcolor=\"#FFFFFF\" align=\"left\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;  scroll-x: auto;\">
                  <!--<font color=\"#000000\">-->
                  <!--<textarea cols=\"4\" rows=\"2\" readonly=\"readonly\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\">-->
                  <div style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px; overflow: auto; background-color: #CCCCCC;\">
                   <p>
               ");
               //$yrunning_com[$comcnt]   = $ycomments; 
               //$yrunning_usr[$comcnt]   = "UPDATED BY: ".$yupdated_by."FROM: ".$issue_area." UPDATED ON: ".$yupdated_on; 
               //$yrunning_com
               //    <!--<p style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\>-->
               //    <!--</p>--> 
               for ($com=$comcnt;$com>=1; --$com) {
                    $wrunning_usr = nl2br($urunning_usr[$com]);
                    $wrunning_com = nl2br($urunning_com[$com]);
                    print($wrunning_usr.$wrunning_com);
               }
               print("<br>");
               print("
                    </p> 
                   </div>
                   <!--</textarea>-->
                  <!--</font>-->
                 </td>                  
                </tr>
               ");
       }
               //print("
               //     </table> 
               //     <div id=\"One\" class=\"cont\">
               //      <table border='0' align=\"center\" width=\"90%\">
               //       <caption>$captn</caption>
               //");
       //}
       // Insert a record in milestone_surrogates
       // ---------------------------------------
       $captn = "Rework Effort";
       print(" 
               </table>
               <table id=\"theTable\" border='0' align=\"center\" width=\"90%\">
                <caption>$captn</caption>
                <tr>
                 <!--<td bgcolor=\"#99CC00\" align=\"center\" rowspan=\"2\"><font color=\"#FFFFFF\">ID</font></td>-->
                 <td bgcolor=\"#99CCFF\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">No</font></td>
                 <td bgcolor=\"#99CCFF\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">PDP Rework Effort</font></td>
                 <td bgcolor=\"#99CCFF\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Rework<br>Effort</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Time<br>(Hours)</font></td>
                </tr>
                <tr>
                 <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Baseline</font></td>
                 <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Rework</font></td>
                </tr>
       ");
       $query34 = "select a.execution_id,a.milestone_id,a.iteration_count
                     from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b 
                    where execution_id = $yexecution_id
                      and a.milestone_id = b.milestone_id
                      and b.issue_area_id = '$uissue_area_id'
                  ";
       //print($query34);               
       $mysql_data34 = mysql_query($query34, $mysql_link) or die ("#47 Could not query: ".mysql_error());
       $rowcnt34 = mysql_num_rows($mysql_data34);
       if ($rowcnt34 == 0) {  
           for ($d=1;$d<=$mil_cnt;++$d) {
                if ($mil_ind[$d] == 1) {
                    $query35 = "INSERT into ".$name.".milestone_surrogates(execution_id,milestone_id,iteration_count)
                                VALUES('$yexecution_id','$mil_id[$d]',0)";
                    //print($query35);            
                    $mysql_data35 = mysql_query($query35, $mysql_link) or die ("#48 Could not query: ".mysql_error());
                }    
           }
       } 
       //else {
       $query44 = "select a.execution_id,a.milestone_id,a.iteration_count
                     from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b   
                    where a.execution_id = $yexecution_id
                      and a.milestone_id = b.milestone_id 
                      and b.issue_area_id = '$uissue_area_id'
                  ";
       //print($query34);               
       $mysql_data44 = mysql_query($query44, $mysql_link) or die ("#49 Could not query: ".mysql_error());
       $rowcnt44 = mysql_num_rows($mysql_data44);
       
       $eseq = 0;
       $total_baseline = 0;
       $total_incrementatl = 0;
       while($row44 = mysql_fetch_row($mysql_data44)) {
                $eseq              = $eseq + 1;
                $yexecution_id     = stripslashes($row44[0]);
                $ymilestone_id     = stripslashes($row44[1]);
                $zid               = stripslashes($row44[1]);
                $yiteration_cnt    = stripslashes($row44[2]);
       print("  <tr>
                    <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                     <font color=\"#330099\">
                      $yexecution_id 
                     </font> 
                    </td>-->
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                     <font color=\"#330099\"> 
                      $eseq
                     </font> 
                    </td>
       ");
       $query36 = "select milestone_id,milestone,milestone_time 
                     from ".$name.".pdp_stlc 
                    where milestone_id = '$zid' 
                      and issue_area_id = '$uissue_area_id' 
                      and milestone_ind = 1 
                  ";
       $mysql_data36 = mysql_query($query36, $mysql_link) or die ("#50 Could not query: ".mysql_error());
       $rowcnt36 = mysql_num_rows($mysql_data36);
       while($row36 = mysql_fetch_row($mysql_data36)) {
                $ymilestone        = stripslashes($row36[1]);
                $ymilestone_time   = stripslashes($row36[2]);
                $ybaseline_time    = $ymilestone_time;
                $yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                $total_baseline    = $total_baseline + $ybaseline_time;
                $total_incremental = $total_incremental + $yincremental_time;
       }      
       print("           
                    <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                     <font color=\"#330099\"> 
                      $ymilestone
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                     <font color=\"#330099\"> 
                      <input type=\"text\" name=\"yiteration_cnt[$yid][$zid]\" value=\"$yiteration_cnt\" size=\"3\">
                      <input type=\"hidden\" name=\"ymilestone[$yid][$zid]\" value=\"$ymilestone\">
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                     <font color=\"#330099\"> 
                      $ybaseline_time
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                     <font color=\"#330099\"> 
                      $yincremental_time
                     </font> 
                    </td>
                   </tr>
       ");
       }
       $total_time          = round($total_baseline + $total_incremental,2);
       $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
       $percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ; 
       print("
                  <tr>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\" colspan=\"3\">
                    <font color=\"#FF0000\"> 
                     Work Effort (Hours)
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                    <font color=\"#FF0000\"> 
                     $total_baseline
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                    <font color=\"#FF0000\"> 
                     $total_incremental
                    </font> 
                   </td>
                  </tr>
                                              
                  </tr>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" colspan=\"3\">
                    <font color=\"#FF0000\"> 
                     Percentage
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    <font color=\"#FF0000\"> 
                     $percent_baseline%
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    <font color=\"#FF0000\"> 
                     $percent_incremental%
                    </font> 
                   </td>
                  </tr>

                  </tr>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\" colspan=\"3\">
                    <font color=\"#FF0000\"> 
                     Total Effort (Hours)
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\" colspan=\"2\">
                    <font color=\"#FF0000\"> 
                     $total_time
                    </font> 
                   </td>
                  </tr>                   
       ");
       //}
       // ---------------------------------------------------
       }
       //$zrunning_log = nl2br($yrunning_com);
       //$zrunning_log = str_replace("<br>", "\n\n", $yrunning_com);

       // Submit options options
       print(" <tr>
                <td>
                </td colspan=\"6\" bgcolor=\"#FFFFF0\">
               </tr>
               <tr>
                <td align=\"center\" valign=\"middle\" colspan=\"6\"  bgcolor=\"#FFFFF0\">
                <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                 <input type=\"hidden\" name=\"start\" value=\"1\">
                 <input type=\"hidden\" name=\"area_cnt\" value=\"$rowcnty2\">
                 <input type=\"hidden\" name=\"pdpid\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update1[$xid]\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update2[$yid]\" value=\"$yid\">
                </td>
               </tr>
              </table>
       "); 
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"PDP No. was not found, Try Again\")</script>";  
   }
   // -------------------------------------------------------------------------------------
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
   print("<form method=\"post\" action=\"./executioncontrol_cm.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Enter PDP No.</font></td>
             <td>
              <input type=\"text\" name=\"pdp\" size=\"9\" maxlength=\"9\">
             </td>
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
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
mysql_close($mysql_link);     
?>
