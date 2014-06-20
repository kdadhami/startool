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
    //}
    //if (isset($area_cnt)) {
        $xstart_date[$key2]    = mktime(0,0,0,$xms[$key2],$xds[$key2],$xys[$key2]);
        $xend_date[$key2]      = mktime(0,0,0,$xme[$key2],$xde[$key2],$xye[$key2]);
        $xact_end_date[$key2]  = mktime(0,0,0,$xma[$key2],$xda[$key2],$xya[$key2]);
        $ycomments[$key2]      = str_replace("'","",$ycomments[$key2]);
        $ycomments[$key2]      = str_replace(chr(34),"",$ycomments[$key2]);
        //$ycomments[$key2]    =  substr($ycomments[$key2],0,200);
        // Check if date is January 1, 2007
        if ($xstart_date[$key2] == 1167627600) {
            $xstart_date[$key2] = 0;
        } 
        if ($xend_date[$key2] == 1167627600) {
            $xend_date[$key2] = 0;
        }            
        if ($xact_end_date[$key2] == 1167627600) {
            $xact_end_date[$key2] = 0;
        }            
        if ($xstart_date_2[$key2] == 1167627600) {
            $xstart_date_2[$key2] = 0;
        } 
        if ($xend_date_2[$key2] == 1167627600) {
            $xend_date_2[$key2] = 0;
        } 
        if (strlen($ycomments[$key2]) == 0) {
        } else {
          //$ycomments[$key2]    = substr($ycomments[$key2],0,200);
          $log_entry   = $usr." from ".$uissue_area." updated on ".$today_dt."<br>".$ycomments[$key2]."<br>";
          $running_com = $log_entry.$yrunning_com[$key2];
          $yrunning_com[$key2] =  $running_com;    ///substr($running_com,0,4999);
        }
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

        $queryy = "UPDATE ".$name.".pdp_execution
                      SET updated_by          = '$usr',
		            WHERE execution_id        = '$key2' ";
        //$queryy = "UPDATE ".$name.".pdp_execution
        //              SET start_date          = '$xstart_date[$key2]', 
        //                  end_date            = '$xend_date[$key2]', 
        //                  start_date_2        = 0, 
        //                  end_date_2          = 0, 
        //                  actual_end_date     = '$xact_end_date[$key2]', 
        //                  updated_by          = '$usr',
        //                  invoice_count       = '$yinvoice_cnt[$key2]',
        //                  bill_run_count      = '$ybillrun_cnt[$key2]',
        //                  ppw_update          = '$yppw_update[$key2]',
        //                  back_to_build       = '$yback_to_build[$key2]',
        //                  actual_testing_days = '$yactual_testing_days[$key2]',
        //                  comments            = '$ycomments[$key2]',
        //                  launch_ind          = '$ylaunch_ind[$key2]',
        //                  running_comments    = '$yrunning_com[$key2]'
		//            WHERE execution_id        = '$key2' ";
        $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#28 Could not query: ".mysql_error());
        //print($queryy."<br>"); 
        $query9 = "select area_execution_id,pdp_id,issue_area_id
                     from ".$name.".area_execution   
                    where pdp_id        = '$pdpid'
                      and issue_area_id = '$uissue_area_id' "; 
        $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#29 Could not query: ".mysql_error());
        $rowcnt9 = mysql_num_rows($mysql_data9);    

        if ($rowcnt9 == 1){
            //$wbtb = 1;
            while($rowx9 = mysql_fetch_row($mysql_data9)) {
                  //$wbtb                     = $wbtb + 1;
                  //$wback_to_build_id = stripslashes($rowx9[0]);
                  //$wpdp_id           = stripslashes($rowx9[1]);
                  //$wissue_area_id    = stripslashes($rowx9[2]);
                  //$wback_to_build    = stripslashes($rowx9[3]);

                  //$updbtb  = 0;
                  //if ($ybtbchk = 0){
                  //    $updbtb = $wback_to_build + 0;
                  //} 

                  //if ($ybtbchk = 1){
                  //    $updbtb = $wback_to_build + 1;
                  //} 

                  //if ($ybtbchk = -1){
                  //    $updbtb = $wback_to_build -1;
                  //} 
                  
                  $query10 = "UPDATE ".$name.".area_execution
                                 SET back_to_build         = '$yback_to_build[$key2]',
                                     back_to_build2        = 0,
                                     comments              = '$ycomments[$key2]',
                                     running_comments      = '$yrunning_com[$key2]',
                                     start_date            = '$xstart_date[$key2]',  
                                     start_date2           = 0,
                                     end_date              = '$xend_date[$key2]',
                                     end_date2             = 0,
                                     actual_end_date       = '$xact_end_date[$key2]',
                                     actual_end_date2      = 0,
                                     actual_testing_days   = '$yactual_testing_days[$key2]',
                                     actual_testing_days2  = 0
                               WHERE pdp_id                = '$pdpid'
                                 AND issue_area_id         = '$uissue_area_id' ";
                  //print($query10);            
                  $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#30 Could not query: ".mysql_error());                
            }
        } 
        
        //if ($rowcnt9 == 0){

        //    $insbtb  = 0;
        //    if ($ybtbchk = 0){
        //        $insbtb = 0;
        //    } 

        //    if ($ybtbchk = 1){
        //        $insbtb = 1;
        //    } 

        //    //if ($ybtbchk = -1){
        //    //    $insbtb = 0;
        //    //} 

        //    $wbtb = 1;
        //    $query10 = "INSERT into ".$name.".area_execution(pdp_id,issue_area_id,back_to_build)
        //                VALUES('$pdpid','$uissue_area_id','$insbtb')";
        //    //print($query10);            
        //    $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#31 Could not query: ".mysql_error());                
        //} 
                    

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
             print("<form method=\"post\" action=\"./executioncontrol_uat.php?pdp=$pdp&&start=$start\">
                     <table border='0' align=\"center\" width=\"80%\">
                      <caption>$captn</caption>
                      <tr>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:150px;\"><font color=\"#FFFFFF\"><font color=\"#330099\">ID</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:300px;\">
         	            <font color=\"#000000\"> 
                          <a>$xid</a>
                        </font>   
         	           </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">PDP No.</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
                        <font color=\"#330099\"> 
                         $xpdp_desc
                        </font>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">PDP Name</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px; word-wrap: break-word;\">
         	           <font color=\"#330099\"> 
                         $xpdp_name
                        </font> 	            
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Owner</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:300px;\">
         	            <font color=\"#330099\"> 
                         $xpdp_owner
                        </font> 	            
         	           </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Launch</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $xpdp_launch_dt
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Status</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $xpdp_status
                        </font> 
                       </td> 
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Type</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
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
                                 <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">$deptx Testing</font></td>
                                 <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
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
                         ");
               }
               print("</tr>");

       // Insert a record in pdp_execution if it does not exist
       // ---------------------------------------------------
       $query32 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind, defects,actual_end_date,back_to_build
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
       $query42 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind,defects,running_comments,start_date_2,end_date_2,
                          actual_end_date,back_to_build,actual_testing_days
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
               $ycomments             = stripslashes($row42[8]);
               $ylaunch_ind           = stripslashes($row42[9]);
               $ydefects              = stripslashes($row42[10]);
               $yrunning_com_o        = stripslashes($row42[11]);
               $yrunning_com          = nl2br(stripslashes($row42[11]));
               $ystart_dt_2           = stripslashes($row42[12]);
               $yend_dt_2             = stripslashes($row42[13]);
               $yactual_end_date      = stripslashes($row42[14]);
               $yback_to_build        = stripslashes($row42[15]);
               $yactual_testing_days  = stripslashes($row42[16]);
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
                
               $query9 = "select area_execution_id,pdp_id,issue_area_id,back_to_build,back_to_build2,comments,running_comments,
                                 start_date,start_date2,end_date,end_date2,actual_end_date,actual_end_date2,
                                 actual_testing_days,actual_testing_days2
                            from ".$name.".area_execution   
                           where pdp_id = '$xid'
                             and issue_area_id = '$uissue_area_id' "; 
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
                         $ycomments               = stripslashes($rowx9[5]);
                         $yrunning_com            = nl2br(stripslashes($rowx9[6]));
                         $ystart_dt               = stripslashes($rowx9[7]);
                         $ystart_dt_2             = stripslashes($rowx9[8]);
                         $yend_dt                 = stripslashes($rowx9[9]);
                         $yend_dt_2               = stripslashes($rowx9[10]);
                         $yactual_end_date        = stripslashes($rowx9[11]);
                         $yactual_end_date2       = stripslashes($rowx9[12]);
                         $yactual_testing_days    = stripslashes($rowx9[13]);
                         $yactual_testing_days2   = stripslashes($rowx9[14]); 
                   }
               } 
               
               if ($rowcnt9 == 0){
               
                         if (empty($ystart_dt)) {
                             $ystart_dt_x = 0;
                         } else {
                             $ystart_dt_x = $ystart_dt; 
                         }
                         
                         if (empty($ystart_dt_2)) {
                             $ystart_dt_2x = 0;
                         } else {
                             $ystart_dt_2x = $ystart_dt_2; 
                         }
      
                         if (empty($yend_dt)) {
                             $yend_dt_x = 0;
                         } else {
                             $yend_dt_x = $yend_dt; 
                         }
                         
                         if (empty($yend_dt_2)) {
                             $yend_dt_2x = 0;
                         } else {
                             $yend_dt_2x = $yend_dt_2; 
                         }
                         
                         if (empty($yactual_end_date)) {
                             $yactual_end_datex = 0;
                         } else {
                             $yactual_end_datex = $yactual_end_date; 
                         }
      
                         $query10 = "INSERT into ".$name.".area_execution(pdp_id,issue_area_id,back_to_build,back_to_build2,comments,running_comments,
                                                                          start_date,start_date2,end_date,end_date2,actual_end_date,actual_end_date2,
                                                                          actual_testing_days,actual_testing_days2
                                                                          )
                                     VALUES('$xid','$uissue_area_id','$yback_to_build',0,'$ycomments','$yrunning_com_o','$ystart_dt_x','$ystart_dt_2x',
                                            '$yend_dt_x','$yend_dt_2x','$yactual_end_datex',0,'$yactual_testing_days',0
                                            )";
                         //print($query10);                   
                         $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#100 Could not query: ".mysql_error());
               }
               
               //$wkday = 0;
               //$wkend = 0;
               //$wkdayb = 0;
               //$wkendb = 0;
               //$incval = 86400;
               //$basedt = $ystart_dt;
               //$basedtb = $ystart_dt_2;
               //for ($dts=1; $dts<=$daysindelay; ++$dts) {
               //     //print($dts);
               //     $datval  = $basedt + (86400*$dts);
               //     $newdate = (string)$datval; 
               //     //print($newdate."<br>");
               //     $dtday = date("D",$newdate);
               //     //echo $dtday;
               //     if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
               //          $wkday = $wkday + 1;     
               //     }     
               //     if (($dtday == "Sat") || ($dtday == "Sun")){
               //          $wkend = $wkend + 1;     
               //     }     
               //}
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
               if (!empty($ystart_dt_2)){
	               $yds4  = date("d",$ystart_dt_2);
                   $yms4  = date("m",$ystart_dt_2);
                   $yms24 = date("M",$ystart_dt_2);
                   $yys4  = date("Y",$ystart_dt_2);
                   $ysdt4 = "$yds4"."-"."$yms24"."-"."$yys4";
               } else {
                   $ysdt4 = "00-00-0000";
                   $d1a   = 4;    
               }
               if (!empty($yend_dt_2)){
	               $yde4  = date("d",$yend_dt_2);
                   $yme4  = date("m",$yend_dt_2);
                   $yme24 = date("M",$yend_dt_2);
                   $yye4  = date("Y",$yend_dt_2); 
                   $yedt4 = "$yde4"."-"."$yme24"."-"."$yye4";
               } else {
                   $yedt4 = "00-00-0000";
                   $d2a = 0;
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
               if (!empty($yactual_end_date2) || ($yactual_end_date2 <> 0)){
	               $ydab  = date("d",$yactual_end_date2);
                   $ymab  = date("m",$yactual_end_date2);
                   $yma2b = date("M",$yactual_end_date2);
                   $yyab  = date("Y",$yactual_end_date2); 
                   $yadtb = "$ydab"."-"."$yma2b"."-"."$yyab";
                   $d3a = 1;
               } else {
                   if ($yedt == "00-00-0000"){
                       $yadt = "00-00-0000";
                       $d3a = 0;
                   } else {
                       $yactual_end_date2 = $yend_dt_2;
                       $ydab  = date("d",$yactual_end_date2);
                       $ymab  = date("m",$yactual_end_date2);
                       $yma2b = date("M",$yactual_end_date2);
                       $yyab  = date("Y",$yactual_end_date2); 
                       $yadtb = "$yda"."-"."$yma2"."-"."$yya";
                       $d3a = 1;
                   }
                   //$yadt = "00-00-0000";
                   //$yadt = 0;
                   //$d3 = 0;
               }

               $d4 = $d1 + $d2 + $d3;
               $d4a = $d1a + $d2a + $d3a;
                              
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
               } 
               // --------------------------------------------
               if ($d4a == 6){
                   $testingdays2          =  ($yend_dt - $ystart_dt) / 86400;
                   $daysindelay2          =  0;
                   $incval = 86400;
                   $wkday1a = 0;
                   $wkend1a = 0;
                   $basedt1a = $ystart_dt_2;
                   for ($dts=1; $dts<=$testingdays2; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1a + (86400*$dts);
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
               
               if ($d4a == 7){
                   $testingdays2          =  ($yend_dt_2 - $ystart_dt_2) / 86400;
                   $daysindelay2          =  ((($yactual_end_date2 - $ystart_dt_2) / 86400) - $testingdays);
                   $incval = 86400;
                   $wkday1a = 0;
                   $wkend1a = 0;
                   $basedt1a = $ystart_dt_2;
                   for ($dts=1; $dts<=$testingdays2; ++$dts) {
                        //print($dts);
                        $datval  = $basedt1a + (86400*$dts);
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
               
               if ($d4a < 6){
                   $testingdays   = 0;
                   $daysindelay   = 0;
               } 


               print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Execution ID</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $yexecution_id
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\"></font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
         	             First Testing Cycle
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Start Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
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
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
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
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
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
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Available Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $testingdays &nbsp&nbsp $wkday1 Weekdays &nbsp&nbsp $wkend1 Weekend Days
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Days due to Rework Effort</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $daysindelay &nbsp&nbsp $wkday2 Weekdays &nbsp&nbsp $wkend2 Weekend Days
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Back To Build<br>($uissue_area)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yback_to_build[$yid]\" value=\"$yback_to_build\" size=\"4\" maxlength=\"4\">
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Back To Build<br>(ALL)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         $yback_to_build_sum  
                        </font> 
                       </td>
                      </tr>
               ");
               $d5 = $testingdays + $daysindelay; 
               //print($d5);                        
               
               if ($d5 > 0) {
                   //Actual Testing Days drop down
                   //for ($ady=1;$ady<=$d5;++$ady) {
                   //     $xady[$ady] = $ady;
                   //}
                   print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
                        <select align=\"left\" name=\"yactual_testing_days[$yid]\">
                   ");
                   for ($dy=1;$dy<=$d5;++$dy) {
                        //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                     if ($yactual_testing_days == $dy) {
                             print(" <option selected value=\"$dy\">$dy</option> 
                             ");
                     } else {
                             print(" <option value=\"$dy\">$dy</option>");
                     }   
                   }
                   print("  </select>
                           </td>
                          </tr>
                   ");
               } else {
                 print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         <input type=\"hidden\" name=\"yactual_testing_days[$yid]\" value=\"0\"> 
                        </font> 
                       </td>
                      </tr>
                  ");     
               }     
               print("       
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\"></font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
         	             Second Testing Cycle
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Start Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
                        <font color=\"#330099\">
               ");
               if ($ysdt4 == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               //if ($ysdt == "00-00-0000") {
                   print(" <select align=\"left\" name=\"xds4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xdy_s[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xdy_s4=1;$xdy_s4<=31; ++$xdy_s4) {
                    if ($yds4 == $xdy_s4) {
                        print(" <option selected value=\"$xdy_s4\">$xdy_s4</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_s4\">$xdy_s4</option> ");
                    }
               }
               print(" </select>
               ");
               //if ($ysdt == "00-00-0000") {
                   print(" <select align=\"left\" name=\"xms4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xmon_s[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xmon_s4=1;$xmon_s4<=12; ++$xmon_s4) {
                    if ($yms4 == $xmon_s4) {
                        print(" <option selected value=\"$xmon_s4\">$xmon_s4</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_s4\">$xmon_s4</option> ");
                    }
               }
               print(" </select>
               ");
               //if ($ysdt == "00-00-0000") {
                   print(" <select align=\"left\" name=\"xys4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xyr_s[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xyr_s4=2007;$xyr_s4<=2015; ++$xyr_s4) {
                    if ($yys4 == $xyr_s4) {
                        print(" <option selected value=\"$xyr_s4\">$xyr_s4</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_s4\">$xyr_s4</option> ");
                    }
               }
               print("  </select>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\"><font color=\"#330099\">End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
               ");
               if ($ysdt4 == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               //if ($yedt == "00-00-0000") {
                   print("<br>
                          <select align=\"left\" name=\"xde4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xdy_e[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xdy_e4=1;$xdy_e4<=31; ++$xdy_e4) {
                    if ($yde4 == $xdy_e4) {
                        print(" <option selected value=\"$xdy_e4\">$xdy_e4</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_e4\">$xdy_e4</option> ");
                    }
               }
               print(" </select>
               ");
               //if ($yedt == "00-00-0000") {
                   print(" <select align=\"left\" name=\"xme4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xmon_e[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xmon_e4=1;$xmon_e4<=12; ++$xmon_e4) {
                    if ($yme4 == $xmon_e4) {
                        print(" <option selected value=\"$xmon_e4\">$xmon_e4</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_e4\">$xmon_e4</option> ");
                    }
               }
               print(" </select>
               ");
               //if ($yedt == "00-00-0000") {
                   print(" <select align=\"left\" name=\"xye4[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"xyr_e[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}
               for ($xyr_e4=2007;$xyr_e4<=2015; ++$xyr_e4) {
                    if ($yye4 == $xyr_e4) {
                        print(" <option selected value=\"$xyr_e4\">$xyr_e4</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_e4\">$xyr_e4</option> ");
                    }
               }
               print("   </font>
                        </select>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual End Date (dd-mm-yyyy)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
               ");
               if ($yadt2 == "00-00-0000") {
                   $colr = "#FFFF00";
               } else {
                   $colr = "#FFFFFF";
               }
               print("<select align=\"left\" name=\"xda2[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
               for ($xdy_a2=1;$xdy_a2<=31; ++$xdy_a2) {
                    if ($yda == $xdy_a2) {
                        print(" <option selected value=\"$xdy_a2\">$xdy_a2</option> ");
	                }
	                else {
                        print(" <option value=\"$xdy_a2\">$xdy_a2</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xma2[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
               ");
               for ($xmon_a2=1;$xmon_a2<=12; ++$xmon_a2) {
                    if ($yma2 == $xmon_a2) {
                        print(" <option selected value=\"$xmon_a2\">$xmon_a2</option> ");
                    }
                    else {
                        print(" <option value=\"$xmon_a2\">$xmon_a2</option> ");
                    }
               }
               print(" </select>
                       <select align=\"left\" name=\"xya2[$yid]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
               ");
               for ($xyr_a2=2007;$xyr_a2<=2015; ++$xyr_a2) {
                    if ($yya2 == $xyr_a2) {
                        print(" <option selected value=\"$xyr_a2\">$xyr_a2</option> ");
                    }
                    else {
                        print(" <option value=\"$xyr_a2\">$xyr_a2</option> ");
                    }
               }
               print("    
                         </font>
                        </select>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Back To Build<br>($uissue_area)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yback_to_build2[$yid]\" value=\"$yback_to_build2\" size=\"4\" maxlength=\"4\">
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Back To Build in<br>(ALL)</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         $yback_to_build_sum  
                        </font> 
                       </td>
                      </tr>
               ");
               
               $d5b = $testingdaysb + $daysindelayb; 
               //print($d5);                        
               
               if ($d5 > 0) {
                   //Actual Testing Days drop down
                   //for ($ady=1;$ady<=$d5;++$ady) {
                   //     $xady[$ady] = $ady;
                   //}
                   print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
                        <select align=\"left\" name=\"yactual_testing_days2[$yid]\">
                   ");
                   for ($dy=1;$dy<=$d5b;++$dy) {
                        //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                     if ($yactual_testing_days2 == $dy) {
                             print(" <option selected value=\"$dy\">$dy</option> 
                             ");
                     } else {
                             print(" <option value=\"$dy\">$dy</option>");
                     }   
                   }
                   print("  </select>
                           </td>
                          </tr>
                   ");
               } else {
                 print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Actual Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         <input type=\"hidden\" name=\"yactual_testing_days[$yid]\" value=\"0\"> 
                        </font> 
                       </td>
                      </tr>
                  ");     
               }     
               print("
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Available Testing Days</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $testingdays &nbsp&nbsp $wkday1a Weekdays &nbsp&nbsp $wkend1a Weekend Days
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Days due to Rework Effort</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $daysindelay &nbsp&nbsp $wkday2a Weekdays &nbsp&nbsp $wkend2a Weekend Days
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Invoices Generated</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
         	             $yinvoice_cnt
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Bill Runs</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
         	             $ybillrun_cnt
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">PPW Updates</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         $yppw_update 
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Launch in Jeopoardy</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
               ");
               //if ($ylaunch_ind == 0) {
               //    print(" <select align=\"left\" name=\"ylaunch_ind[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
               //} else {
               //    print(" <select align=\"left\" name=\"ylaunch_ind[$yid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
               //}               
               for ($e=1;$e<=2; ++$e) {
                     if ($ylaunch_ind == $ind_id[$e]) {
                         //print(" <option selected value=\"$ind_id[$e]\">$ind[$e]</option> "); 
         	            print("<font color=\"#330099\"> 
         	                    $ind[$e]
                               </font>
                        ");                         
                     } else
                     {
                         //print(" <option value=\"$ind_id[$e]\">$ind[$e]</option> ");    
                     }   
               }                         
               print("         
                        <!--</select>--> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Comments</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\">
                         <textarea name=\"ycomments[$yid]\" cols=\"100%\" rows=\"2\"></textarea> 
                        </font>
                       </td>
                         <input type=\"hidden\" name=\"yrunning_com[$yid]\" value=\"$yrunning_com\">
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Last Updated By</font></td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:300px;\">
         	            <font color=\"#330099\"> 
                         $yupdated_by
                        </font> 
                       </td>
                      </tr>
                      <tr>
               ");
       }
       //}
       // Insert a record in milestone_surrogates
       // ---------------------------------------
       print(" </table>
               <table border='0' align=\"center\" width=\"80%\">
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
                  </tr>
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
       $zrunning_log = str_replace("<br>", "\n\n", $yrunning_com);

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
              <table border='0' align=\"center\" width=\"80%\">
                <tr>
                 <td bgcolor=\"#99CCFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\">
                  <font color=\"#330099\">
                   Comments Log
                  </font>
                 </td>
                </tr>
                <tr>
                 <td bgcolor=\"#CCFFFF\" align=\"left\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;  scroll-x: auto;\">
                  <font color=\"#000000\">
                   <textarea cols=\"1\" rows=\"1\" readonly=\"readonly\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\" >
                    $zrunning_log
                   </textarea>
                  </font>
                 </td>                  
                </tr>
              </table>
             </form>
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
