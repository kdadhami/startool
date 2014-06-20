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

/////////////////////////
// Loading PDP Milestones
/////////////////////////
$query31      = "   select milestone_id,
                           milestone,
						   milestone_ind,
						   milestone_time,
						   milestone_seq,
                           milestone_type,
                           old_milestone_time						   
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
$workeffort_total   = 0;
while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt              = $mil_cnt + 1;
      $mil_id[$mil_cnt]     = stripslashes($row31[0]);
      $mil[$mil_cnt]        = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]    = stripslashes($row31[2]);
      $mil_time[$mil_cnt]   = (float)stripslashes($row31[3]);
	  $workeffort_total     = $workeffort_total + $mil_time[$mil_cnt];
      $mil_seq[$mil_cnt]    = (float)stripslashes($row31[4]);
      $mil_typ[$mil_cnt]    = stripslashes($row31[5]);
      $omil_time[$mil_cnt]  = (float)stripslashes($row31[6]);
      //print($mil_id[$mil_cnt]."-".$mil[$mil_cnt]."-".$mil_ind[$mil_cnt]."-".$mil_time[$mil_cnt]."-".$mil_seq[$mil_cnt]."<br>");
}
$workeffort_hrs             = intval($workeffort_total/60);      //derives hours 
$workeffort_mins            = $workeffort_total%60;              // derives minutes beyond 60 but less then 60 in the last hour
//print("Milestone Count = ".$mil_cnt);
//print("Total Work Effort Time: ".$workeffort_total ."<br>Hour: ".$workeffort_hrs."<br>Minutes: ".$workeffort_mins."<br>");
////////////////////////
/////////////////////////

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

   if (($uuser_type == 'UAT ADMINISTRATOR') || ($uuser_type == 'UAT PRIME') || ($uuser_type == 'UAT ANALYST') ){
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
	  // Trace 
	  //$trace_log = addslashes($queryy);
      //$tracesql  = "INSERT into ".$name.".pdp_trace(pdp_id,issue_area,updated_by,updated_on,comments,module)
      //             VALUES('$pdpid','$uissue_area','$usr',current_timestamp,'$trace_log','TRACKER')";
	  //print($tracesql."<br>");		   
      //$mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace0 Could not query: ".mysql_error());
     }
   }

   if (isset($update2)) {
    while (list($key2) = each($update2)) {
        $queryp = "UPDATE ".$name.".pdp
                      SET etl_check = '1'
		            WHERE pdp_id    = '$pdpid'";
        $mysql_datap = mysql_query($queryp, $mysql_link) or die ("#queryp Could not query: ".mysql_error());
        //print($queryp."<br>"); 
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

		// Trace 
	    //$trace_log = addslashes($queryy);
        //$tracesql  = "INSERT into ".$name.".pdp_trace(pdp_id,issue_area,updated_by,updated_on,comments,module)
        //              VALUES('$pdpid','$uissue_area','$usr',current_timestamp,'$trace_log','TRACKER')";
		//print($tracesql."<br>");			  
        //$mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace1 Could not query: ".mysql_error());
		
        if (empty($ycomments[$key2])){
        } else {
                     $ycomments[$key2]      = str_replace("'","",$ycomments[$key2]);
                     $ycomments[$key2]      = str_replace(chr(34),"",$ycomments[$key2]);
					 $ymil_x[$key2]         = str_replace("'","",$ymil_x[$key2]);
					 $ymil_x[$key2]         = str_replace(chr(34),"",$ymil_x[$key2]);
					 $ymil_y[$key2]         = str_replace("'","",$ymil_y[$key2]);
					 $ymil_y[$key2]         = str_replace(chr(34),"",$ymil_y[$key2]);

                     $query110 = "INSERT into ".$name.".pdp_logs(pdp_id,issue_area,updated_by,updated_on,comments,module,action,followup,phase,phase_desc)
                                  VALUES('$pdpid','$uissue_area','$usr',current_timestamp,'$ycomments[$key2]','TRACKER',0,1,'$ymil_x[$key2]','$ymil_y[$key2]')";
                     $mysql_data110 = mysql_query($query110, $mysql_link) or die ("#110 Could not query: ".mysql_error());
                     $ypdp_log_id   = mysql_insert_id();
        }

        $query9 = "select area_execution_id,pdp_id,issue_area_id
                     from ".$name.".area_execution   
                    where pdp_id        = '$pdpid'
                      and issue_area_id = '$uissue_area_id' "; 
        $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#29 Could not query: ".mysql_error());
        $rowcnt9 = mysql_num_rows($mysql_data9);    

        $e = 0;
        if ($rowcnt9 == 1){
            //$wbtb = 1;
            while($rowx9 = mysql_fetch_row($mysql_data9)) {
                  $e = $e + 1;
				  $yarea_execution_id = stripslashes($rowx9[0]);
                  //print(strlen($ycomments[$key2]));
                  //if (is_int($yback_to_build[$key2])){
                  //} else {
                  //    $yback_to_build[$key2] = 0;  
                  //}
              //for ($e=1;$e<=$itcnt ; ++$e) { 
                  $xstart_date[$key2][$e]     = mktime(0,0,0,$xms[$key2][$e],$xds[$key2][$e],$xys[$key2][$e]);
                  $xend_date[$key2][$e]       = mktime(0,0,0,$xme[$key2][$e],$xde[$key2][$e],$xye[$key2][$e]);
                  $xact_start_date[$key2][$e] = mktime(0,0,0,$xmab[$key2][$e],$xdab[$key2][$e],$xyab[$key2][$e]);
                  $xact_end_date[$key2][$e]   = mktime(0,0,0,$xma[$key2][$e],$xda[$key2][$e],$xya[$key2][$e]);
				  $st_dt                      = $xds[$key2][$e]."-".$xms[$key2][$e]."-".$xys[$key2][$e];
				  $end_dt                     = $xde[$key2][$e]."-".$xme[$key2][$e]."-".$xye[$key2][$e];
				  $ast_dt                     = $xdab[$key2][$e]."-".$xmab[$key2][$e]."-".$xyab[$key2][$e];
				  $aend_dt                    = $xda[$key2][$e]."-".$xma[$key2][$e]."-".$xya[$key2][$e];
				  //$tdaysavailable             = (($xact_end_date[$key2][$e] - $xact_start_date[$key2][$e])/86400) + 1;
				  
				  
				  
				  //print ("Days Available: ".$tdaysavailable."<br>");
                  //$xact_start_date[$key2][$e] = $xstart_date[$key2][$e];
                  //if ($xstart_date[$key2][$e] == 1167627600) {
                  //    $xstart_date[$key2][$e] = 0;
                  //} 
                  //if ($xend_date[$key2][$e] == 1167627600) {
                  //    $xend_date[$key2][$e] = 0;
                  //} 
                  // Regular Dates				  
				  $date_check[$e] = 0;
				  $err_check[$e]  = 0;
				  if ($xstart_date[$key2][$e] == 1167627600 or $xend_date[$key2][$e] == 1167627600){
					  $date_check_msg_a[$e] = "1. DEFAULT VALUE CHECK FOR PLANNED DATES:"."\\n"."One or both of Start or End Date is a default "."1-1-2007"."\\n\\n";
				      if ($xstart_date[$key2][$e] > $xend_date[$key2][$e]){
					      $xend_date[$key2][$e] = $xstart_date[$key2][$e];
						  $date_check_msg_b[$e] = "2. START-END CHECK FOR PLANNED DATES:"."\\n"."Start Date ".$st_dt." was greater then End Date ".$end_dt." ,End Date is now made same as start Date ".$st_dt."\\n\\n";
					  }
					  $date_check_msg[$e] = $date_check_msg_a[$e].$date_check_msg_b[$e];
					  $err_check[$e] = 1; 
   				      $date_check[$e] = 1;
				  } else {
				      if ($xstart_date[$key2][$e] > $xend_date[$key2][$e]){
					      $xend_date[$key2][$e] = $xstart_date[$key2][$e];
					      $date_check_msg[$e] = "2. START-END CHECK:"."\\n"."Start Date".$st_dt." was greater then End Date ".$end_dt." ,End Date is now made same as Start Date ".$st_dt."\\n\\n"; 
					      $err_check[$e]     = 2;
					  }
			          $date_check[$e]     = 2;
				  }
                  // Actual Dates
				  $act_date_check[$e] = 0;
				  $act_err_check[$e]  = 0;
				  if ($xact_start_date[$key2][$e] == 1167627600 or $xact_end_date[$key2][$e] == 1167627600){
				      $act_date_check_msg_a[$e] = "3. DEFAULT VALUE CHECK FOR ACTUAL DATES:"."\\n"."One or both of Actual Start or Actual End Date is a default date "."1-1-2007"."\\n\\n";
				      if ($xact_start_date[$key2][$e] > $xact_end_date[$key2][$e]){
					      $xact_end_date[$key2][$e] = $xact_start_date[$key2][$e];
						  $act_date_check_msg_b[$e] = "4. START-END CHECK FOR ACTUAL DATES:"."\\n"."Actual Start Date ".$ast_dt." was greater then Actual End Date ".$aend_dt." ,Actual End Date is now made same as Actual Start Date ".$ast_dt."\\n\\n";
					  }
					  $act_date_check_msg[$e] = $act_date_check_msg_a[$e].$act_date_check_msg_b[$e];
					  $act_err_check[$e]  = 1;
 				      $act_date_check[$e] = 1;
				  } else {
				      if ($xact_start_date[$key2][$e] > $xact_end_date[$key2][$e]){
					      $xact_end_date[$key2][$e] = $xact_start_date[$key2][$e];
  					      $act_date_check_msg[$e] = "4. START-END CHECK FOR ACTUAL DATES:"."\\n"."Actual Start Date".$ast_dt." was greater then Actual End Date ".$aend_dt." ,End Date is now made same as Actual Start Date ".$ast_dt."\\n\\n"; 
                          $act_err_check[$e] = 2;
					  }
					  $act_date_check[$e] = 2;
				  }
                  // Derive Week and Weekend Days for Actual Dates
                                        $ywkday_a = 0;
                                        $ywkend_a = 0;
                                        if ($xact_end_date[$key2][$e] >= $xact_start_date[$key2][$e]){
                                            $ytestingdays_a = round((($xact_end_date[$key2][$e] - $xact_start_date[$key2][$e]) / 86400)+1,0);   //+1 counts including the actual_start_date
                                            $ybasedt2       = $xact_start_date[$key2][$e];
											//print($testingdays_a."<br>");
                                            for ($ydts=1; $ydts<=$ytestingdays_a; ++$ydts) {
											     if ($ydts == 1){
												     $ydatval  = $ybasedt2;
												 } else {
                                                   $ydatval  = $ybasedt2 + (86400*($ydts-1));
												 }
                                                 $ynewdate = (string)$ydatval; 
                                                 $ydtday   = date("D",$ynewdate);
												 //print($dts." - ".$datval." - ".$dtday."<br>");
                                                 if (($ydtday == "Mon") || ($ydtday == "Tue") || ($ydtday == "Wed") || ($ydtday == "Thu") || ($ydtday == "Fri")) {
                                                      $ywkday_a = $ywkday_a + 1;     
                                                 }     
                                                 if (($ydtday == "Sat") || ($ydtday == "Sun")){
                                                      $ywkend_a = $ywkend_a + 1;     
                                                 }     
                                            }
                                            $ydays_a  = $ytestingdays_a." Days Available<br>( ".$ywkday_a." Weekdays and ".$ywkend_a." Weekend Days)";
											//print($ydays_a."<br>");
                                        }				  
				  //if ($err_check <> 0 || $act_err_check <> 0){
				  //    //$err_msg = $date_check_msg."\n".$act_date_check_msg;
				  //    echo "<script type=\"text/javascript\">window.alert('DATE WARNINGS (dd-mm-yyyy)\\n\\n'+'$date_check_msg'+'$act_date_check_msg'+'Please correct if required')</script>";
				  //}
                  //print("date_check = ".$date_check." - act_date_check = ".$act_date_check."<br>");
				  //print("err_check = ".$err_check." - act_err_check = ".$act_err_check."<br>");
				  // 1 means default value for i.e. date Jan 1, 2007
				  // 2 means a date value that is not default 
                  // date_check    act_date_check    Action 
				  // ----------------------------------------
				  // 1             1                 Nothing 
				  // 2             1                 Update Actual Dates to Start and End Dates
				  // 1             2                 Nothing 
				  // 2             2                 Nothing

                  //if (($date_check == 1 && $act_date_check == 1) || 
				  //    ($date_check == 1 && $act_date_check == 2) ||
				  //	  ($date_check == 2 && $act_date_check == 2) 
				  //   ){
                  //}				  

				  // Start and End Date are default, Actual Start and End Dates will be set as same default
				  // Start Date is greater then End Date
				  // Actual Start Date is greater then Actual End Date
				  
				  
                  if ($date_check[$e] ==2 && $act_date_check[$e] == 1){
				      $xact_start_date[$key2][$e] = $xstart_date[$key2][$e];
                      $xact_end_date[$key2][$e]   = $xend_date[$key2][$e]; 
                      //$yactual_testing_days[$key2][$e] = 1;  
                      //$yactual_weekend_days[$key2][$e] = 1;  
				  }	

                  				  
				  
                  //if ($xend_date[$key2][$e] < $xstart_date[$key2][$e]) {
                  //    $xend_date[$key2][$e] = $xstart_date[$key2][$e];
                  //} 
                  
                  //if ($xact_end_date[$key2][$e] <  $xact_start_date[$key2][$e]) {
                  //    $xact_end_date[$key2][$e] =  $xact_start_date[$key2][$e];
                  //    $yactual_testing_days[$key2][$e] = 1;  
                  //    $yactual_weekend_days[$key2][$e] = 1;  
                  //} 

                  //if ($xstart_date[$key2][$e] <> 1167627600 && $xend_date[$key2][$e] <> 1167627600){
                  //    if ($xact_end_date[$key2][$e] < $xend_date[$key2][$e]) {
                  //        $xact_end_date[$key2][$e] = $xend_date[$key2][$e];
                  //    }
                  //    if ($xact_start_date[$key2][$e] < $xstart_date[$key2][$e]) {
                  //        $xact_start_date[$key2][$e] = $xstart_date[$key2][$e];
                  //    } 
                  //} 
                  //$query96 = "select test_iteration 
                  //              from ".$name.".area_execution   
                  //             where pdp_id = '$pdpid'
                  //               and issue_area_id = '$uissue_area_id'
                  //               and test_iteration = '$e' "; 
                  //print($query96);              
                  //$mysql_data96 = mysql_query($query96, $mysql_link) or die ("#995 Could not query: ".mysql_error());
                  //$rowcnt96 = mysql_num_rows($mysql_data96);
                  //if ($rowcnt96 <> 0){
                      //$ecnt = 0;
                      //while($rowx96 = mysql_fetch_row($mysql_data96)) {
                      //      $eit   = $eit + 1;
                      //      $eit    = stripslashes($rowx96[0]);
                            //if ($eit == $key3){ 
                                $nback_to_build       = (int)$yback_to_build[$key2][$e];
                                $nstart_date          = (int)$xstart_date[$key2][$e];
                                $nend_date            = (int)$xend_date[$key2][$e];
                                $nact_end_date        = (int)$xact_end_date[$key2][$e];
                                $nact_start_date      = (int)$xact_start_date[$key2][$e];
                                $nactual_testing_days = (int)$yactual_testing_days[$key2][$e];
                                $nactual_weekend_days = (int)$yactual_weekend_days[$key2][$e];
								$err_check_3a[$e] = 0;
								$err_check_3b[$e] = 0;
								$err_check_3[$e]  = 0;
								if ($ywkday_a >= $nactual_testing_days){
								} else {
								    // if $nactual_testing_days < $ywkday_a
								    $nactual_testing_days = 0;
									$err_check_3a[$e] = 1;
									$err_check_3a_msg[$e] = "Week days utilized has been reset to 0\\n";
								}
								if ($ywkend_a >= $nactual_weekend_days){
								} else {
								    // if $nactual_weekend_days < $ywkend_a
								    $nactual_weekend_days = 0;
									$err_check_3b[$e] = 2;
									$err_check_3b_msg[$e] = "Weekend days utilized has been reset to 0\\n";
								}
								$err_check_3[$e] = $err_check_3a[$e] + $err_check_3b[$e];
								if ($err_check_3[$e] == 1){
								    $err_check_3_msg[$e] = $err_check_3a_msg[$e];
								} 
								if ($err_check_3[$e] == 2){
								    $err_check_3_msg[$e] = $err_check_3b_msg[$e];
								}
								if ($err_check_3[$e] == 3){
								    $err_check_3_msg[$e] = $err_check_3a_msg[$e].$err_check_3b_msg[$e];
								}
								//if ($err_check_3 == 0){
								//    $err_check_3_msg = "OK";
								//}
                                //print($nback_to_build);
                                $query10 = "UPDATE ".$name.".area_execution
                                               SET updated_by            = '$usr', 
                                                   last_update           = current_timestamp, 
                                                   back_to_build         = '$nback_to_build',
                                                   start_date            = '$nstart_date',  
                                                   end_date              = '$nend_date',
                                                   actual_end_date       = '$nact_end_date ',
                                                   actual_start_date     = '$nact_start_date ',
                                                   actual_testing_days   = '$nactual_testing_days', 
                                                   actual_weekend_days   = '$nactual_weekend_days' 
                                             WHERE pdp_id                = '$pdpid'
                                               AND issue_area_id         = '$uissue_area_id'
                                               AND test_iteration        = '$e' ";
                                //print($query10."<br>".$key2);            
                                $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#30 Could not query: ".mysql_error()); 

								// Trace 
	                            //$trace_log = addslashes($query10);
                                //$tracesql       = "INSERT into ".$name.".pdp_trace(pdp_id,issue_area,updated_by,updated_on,comments,module)
                                //                   VALUES('$pdpid','$uissue_area','$usr',current_timestamp,'$trace_log','TRACKER')";
                                //$mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace2 Could not query: ".mysql_error());
                                $tracesql  = "INSERT into ".$name.".area_execution_archive(pdp_id,issue_area_id,test_iteration,start_date,end_date,actual_start_date,actual_end_date,actual_testing_days,actual_weekend_days,back_to_build,updated_by,area_execution_id)
                                              VALUES('$pdpid','$uissue_area_id','$e','$nstart_date','$nend_date','$nact_start_date','$nact_end_date','$nactual_testing_days','$nactual_weekend_days','$nback_to_build','$usr','$yarea_execution_id')";
                                $mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace2 Could not query: ".mysql_error());
   						    //}
                      //}
                 //}
                      //if ($rowcnt96 == 0){
                      //    $nback_to_build       = (int)$yback_to_build[$key2][$e];
                      //    $nstart_date          = (int)$xstart_date[$key2][$e];
                      //    $nend_date            = (int)$xend_date[$key2][$e];
                      //    $nact_end_date        = (int)$xact_end_date[$key2][$e];
                      //    $nactual_testing_days = (int)$yactual_testing_days[$key2][$e];
                      //    $query105 = "INSERT into ".$name.".area_execution(pdp_id,issue_area_id,start_date,end_date,actual_end_date,
                      //                                                      actual_testing_days)
                      //                VALUES('$pdpid','$uissue_area_id','$nstart_date','$nend_date')";
                      //    //print($query10);                   
                      //    $mysql_data105 = mysql_query($query105, $mysql_link) or die ("#100 Could not query: ".mysql_error());
                      //}
              //}                   
            }
        } 

        //if ($stlc == 1){
		if (isset($update3)) {
		    //print("I am Here<br>");
			while (list($key3x) = each($update3)) {
			       $key2x                          = $yexecution_id; 
				   $ziteration_cnt                 = 0;
				   $updadj[$key2x][$key3x]         = 0;
				   //print("Milestone: ".$ymilestone_time[$key2x][$key3x]."<br>");
				   //print($yajustment[$key2x][$key3x]."<br>");
				   if ($yajustment[$key2x][$key3x] == "NULL"){
				   } else {
					 //print("Do adjustments<br>");
                     $tblsrc                 = substr($yajustment[$key2x][$key3x],0,1);
					 $occrnc                 = substr($yajustment[$key2x][$key3x],1,strlen($yajustment[$key2x][$key3x])-1);
					 $updoccrnc              = $occrnc;
					 $updadj[$key2x][$key3x] = $occrnc;
					 $updtbl[$key2x][$key3x] = $tblsrc;
                     //print("Tablesrc: ".$tblsrc."<br>Occrns: ".$occrnc."<br>");
					 //////////////////////////////////////////////////////////////////////
					 ///////////////////////// SECTION ADJUTMENT //////////////////////////
					 //////////////////////////////////////////////////////////////////////
					 if ($tblsrc == "O"){
                         $query44c = " select a.execution_id,
		                                      a.milestone_id,
							                  a.iteration_count,
							                  a.incremental_time,
							                  a.occurance
                                        from ".$name.".milestone_surrogates a   
                                       where a.execution_id  = '$key2x' 
				       		             and a.milestone_id  = '$key3x'
                                         and a.occurance     = '$occrnc'   						  
                                     ";
                         $mysql_data44c       = mysql_query($query44c, $mysql_link) or die ("#49.2c Could not query: ".mysql_error());
                         $rowcnt44c           = mysql_num_rows($mysql_data44c);
						 //print($query44c."<br>Original: ".$rowcnt44c."<br>");
                         while($row44c = mysql_fetch_row($mysql_data44c)) {
                               $yexecution_id                                = stripslashes($row44c[0]);
                               $ymilestone_id                                = stripslashes($row44c[1]);
                               //$zid                                        = stripslashes($row44c[1]);
                               $yiteration_cnt[$key2x][$key3x]               = stripslashes($row44c[2]);
							   $yiteration_cnt_adj[$key2x][$key3x]           = $yiteration_cnt[$key2x][$key3x]*(-1);
                               $yincremental_time_1[$key2x][$key3x]          = stripslashes($row44c[3]);
				               $yoccurance[$key2x][$key3x]                   = stripslashes($row44d[4]);
							   //print("Milestone 2: ".$ymilestone_time[$key2x][$key3x]."<br>");
							   //$yincremental_time_1[$key2x][$key3x]          = $yincremental_time_1[$key2x][$key3x];
							   if ($occrnc >=1){
							       $occrnc2 = $occrnc - 1;
								   //print("Previous Occrns: ".$occrnc2."<br>");
								   // Query to extract incremental time of previous entry and subtract it from current incremental time derive incremental delta between rework entry for a given milestone
                                   $query44e = " select a.execution_id,
		                                                a.milestone_id,
							                            a.iteration_count,
							                            a.incremental_time,
														a.occurance,
														a.retrofit_parity
                                                   from ".$name.".milestone_surrogates_archive a  
                                                  where a.execution_id  = '$key2x' 
				       		                        and a.milestone_id  = '$key3x'
                                                    and a.occurance     = '$occrnc2' 										 
                                               ";
                                   $mysql_data44e       = mysql_query($query44e, $mysql_link) or die ("#49.2e2 Could not query: ".mysql_error());
                                   $rowcnt44e           = mysql_num_rows($mysql_data44e);
						           //print($query44e."<br>Next A: ".$rowcnt44e."<br>");
                                   while($row44e = mysql_fetch_row($mysql_data44e)) {
                                         $yincremental_time_2[$key2x][$key3x] = stripslashes($row44e[3]);
										 $yretrofit_parity_2[$key2x][$key3x]  = stripslashes($row44e[5]);
										 if ($yretrofit_parity_2[$key2x][$key3x] == "N" or $yretrofit_parity_2[$key2x][$key3x] == "X"){
										 } else {
										     $yincremental_time_2[$key2x][$key3x]  = 0;
										 }
								   }		 
							   } else {
							             $yincremental_time_2[$key2x][$key3x]  = 0;
							   }
							   //--- Reference Line (Delta of Incremental Value)
							   $yincremental_time_adj[$key2x][$key3x]        = $yincremental_time_2[$key2x][$key3x] - $yincremental_time_1[$key2x][$key3x];    //--- Reference Line (Delta of Incremental Value)
							   //print("Time: ".$yincremental_time_1[$key2x][$key3x]." - ".$yincremental_time_2[$key2x][$key3x]." = ".$yincremental_time_adj[$key2x][$key3x]."<br>");
				         }
				     }
					 if ($tblsrc == "A"){
					     //print("Occrns: ".$occrnc."<br>");
                         $query44d = " select a.execution_id,
		                                      a.milestone_id,
							                  a.iteration_count,
							                  a.incremental_time,
							                  a.occurance
                                        from ".$name.".milestone_surrogates_archive a    
                                       where a.execution_id  = '$key2x' 
				       		             and a.milestone_id  = '$key3x'
                                         and a.occurance     = '$occrnc' 										 
                                     ";
                         $mysql_data44d       = mysql_query($query44d, $mysql_link) or die ("#49.2d Could not query: ".mysql_error());
                         $rowcnt44d           = mysql_num_rows($mysql_data44d);
						 //print($query44d."<br>Archive: ".$rowcnt44d."<br>");
                         while($row44d = mysql_fetch_row($mysql_data44d)) {
                               $yexecution_id                                = stripslashes($row44d[0]);
                               $ymilestone_id                                = stripslashes($row44d[1]);
                               //$zid                                        = stripslashes($row44d[1]);
                               $yiteration_cnt[$key2x][$key3x]               = stripslashes($row44d[2]);
							   $yiteration_cnt_adj[$key2x][$key3x]           = $yiteration_cnt[$key2x][$key3x]*(-1);
                               $yincremental_time_1[$key2x][$key3x]          = stripslashes($row44d[3]);
				               $yoccurance[$key2x][$key3x]                   = stripslashes($row44d[4]);
							   //print("Milestone 2: ".$ymilestone_time[$key2x][$key3x]."<br>");
							   if ($occrnc >=1){
							       $occrnc2 = $occrnc - 1;
								   //print("Previous Occrns: ".$occrnc2."<br>");
								   // Query to extract incremental time of previous entry and subtract it from current incremental time derive incremental delta between rework entry for a given milestone
                                   $query44e = " select a.execution_id,
		                                                a.milestone_id,
							                            a.iteration_count,
							                            a.incremental_time,
														a.occurance,
														a.retrofit_parity
                                                   from ".$name.".milestone_surrogates_archive a   
                                                  where a.execution_id  = '$key2x' 
				       		                        and a.milestone_id  = '$key3x'
                                                    and a.occurance     = '$occrnc2' 										 
                                               ";
                                   $mysql_data44e       = mysql_query($query44e, $mysql_link) or die ("#49.2e2 Could not query: ".mysql_error());
                                   $rowcnt44e           = mysql_num_rows($mysql_data44e);
						           //print($query44e."<br>Next A: ".$rowcnt44e."<br>");
                                   while($row44e = mysql_fetch_row($mysql_data44e)) {
                                         $yincremental_time_2[$key2x][$key3x] = stripslashes($row44e[3]);
										 $yretrofit_parity_2[$key2x][$key3x]  = stripslashes($row44e[5]);
										 if (($yretrofit_parity_2[$key2x][$key3x] == "N") or ($yretrofit_parity_2[$key2x][$key3x] == "X")){
										 } else {
										     $yincremental_time_2[$key2x][$key3x]  = 0;
										 }
								   }		 
							   } else {
							             $yincremental_time_2[$key2x][$key3x]  = 0;
							   }
							   //--- Reference Line (Delta of Incremental Value)
							   $yincremental_time_adj[$key2x][$key3x]        = $yincremental_time_2[$key2x][$key3x] - $yincremental_time_1[$key2x][$key3x];    //--- Reference Line (Delta of Incremental Value)
							   //print("Time: ".$yincremental_time_1[$key2x][$key3x]." - ".$yincremental_time_2[$key2x][$key3x]." = ".$yincremental_time_adj[$key2x][$key3x]."<br>");
				         }
				     }
					 //////////////////////////////////////////////////////////////////////
					 ///////////////////////// SECTION ADJUTMENT //////////////////////////
					 //////////////////////////////////////////////////////////////////////
                   }
                   if ($yajustment[$key2x][$key3x] == "NULL"){
                      //print("No Adjustment<br>");				   
					  $ybaseline_time[$key2x][$key3x]               = addslashes($prv_baseline_time[$key2x][$key3x]);                                                                 // Baseline (Applies to all Retrofit Parities) 

			          if (($ymilestone_type[$key2x][$key3x] == "F") or ($ymilstone_type[$key2x][$key3x] == "N")){
                          if (empty($yiteration_cnt[$key2x][$key3x])){                                                                                                                // If user has not selected any iteration                      
                              $yiteration_cnt[$key2x][$key3x]       = 0;                                                                     
                              $ziteration_cnt                       = addslashes($yiteration_cnt[$key2x][$key3x]);                                                                    // Iteration for F/N Retrofit Parities
				      	      $yincremental_time[$key2x][$key3x]    = 0;                                                                                                              // Incremental Time for F/N Retrofit Parities 
				              $ytotal_time[$key2x][$key3x]          = $ybaseline_time[$key2x][$key3x] + $yincremental_time[$key2x][$key3x];                                           // Total Time for F/N Retrofit Parities
                          } else {
  						      $ziteration_cnt                       = addslashes($yiteration_cnt[$key2x][$key3x]);                                                                    // Iteration for F/N Retrofit Parities 
							  $yincremental_time[$key2x][$key3x]    = $ziteration_cnt * $ymilestone_time[$key2x][$key3x];                                                             // Incremental Time for F/N Retrofit Parities 
							  $ytotal_time[$key2x][$key3x]          = $ybaseline_time[$key2x][$key3x] + $prv_total_time[$key2x][$key3x];                                              // Total Time for F/N Retrofit Parities
                          }
				      }
			          if ($ymilestone_type[$key2x][$key3x] == "V"){
				          $yincremental_time[$key2x][$key3x]        = ($ymilestone_hrs[$key2x][$key3x]*60) + $ymilestone_min[$key2x][$key3x];                                         // Incremental Time for V Retrofit Parity
				          if ($yincremental_time[$key2x][$key3x]   == 0){                                                                                                             // If user has not selected hrs:mins 
                              $ziteration_cnt                       = 0;                                                                                                              // Iteration for V Retrofit Parity (0 when no increment has been done)
				   	   	  } else {
						      $ziteration_cnt                       = 1;                                                                                                              // Iteration is 1 for V Retrofit Parity (when increment has been done) 
						  }         
					      $ytotal_time[$key2x][$key3x]              = $ybaseline_time[$key2x][$key3x] + $prv_total_time[$key2x][$key3x];                                              // Total Time for V Retrofit Parity
				      }
					  //$last_adjust_occurance                        = $prv_adjust_occurance[$key2x][$key3x];
					  $yadjust_occurance                            = 0;
				   } else {
				          //print("Yes Adjustment<br>");
				          $ziteration_cnt                           = $yiteration_cnt_adj[$key2x][$key3x];                                                                            // Adjsted Iterations
                          $yincremental_time[$key2x][$key3x]        = $yincremental_time_adj[$key2x][$key3x];	                                                                      // Adjusted Incremental Time
						  $ytotal_time[$key2x][$key3x]              = ($ybaseline_time[$key2x][$key3x] + $prv_total_time[$key2x][$key3x]) - $yincremental_time_adj[$key2x][$key3x];   // Adjusted Total Time
						  //$last_adjust_occurance                  = $updadj[$key2x][$key3x];
						  $yadjust_occurance                        = $updadj[$key2x][$key3x];
				   }
				   //$yadjust_occurance                 = $updadj[$key2x][$key3x]; 
				   $niteration_cnt                    = $ziteration_cnt;
				   $netiteration                      = $ytotal_iteration_cnt[$key2x][$key3x] + $ziteration_cnt;
				   $noccurance                        = $prv_occurance[$key2x][$key3x] + 1;                                                              
				   $last_occurance                    = $prv_occurance[$key2x][$key3x];
				   $last_iterationcnt                 = $prv_iteration_cnt[$key2x][$key3x];
				   $last_adjust_occurance             = $prv_adjust_occurance[$key2x][$key3x];       
                   // Baseline
				   if ($prv_baseline_time[$key2x][$key3x] == 0){
				       (float)$ybase_variance         = 0;
				   } else {
				       (float)$ybase_variance         = round((($prv_baseline_time[$key2x][$key3x]/$ymilestone_time[$key2x][$key3x])*100),2);
				   }
				   $netbaseline                = $prv_baseline_time[$key2x][$key3x];  
				   $netincremental             = $yincremental_time[$key2x][$key3x] + $prv_incremental_time[$key2x][$key3x];
                   $nettotal                   = $netbaseline + $netincremental;
				   // Incremental
				   if ($yincremental_time[$key2x][$key3x] == 0){
				       (float)$yincremental_variance      = 0;
				   } else {
				       (float)$incr_divisor           = $ymilestone_time[$key2x][$key3x] * $netiteration;
					   //print("Net Increment: ".$netincremental."Milestone Time: ".$ymilestone_time[$key2x][$key3x]."<br>");
				       (float)$yincremental_variance  = round((($netincremental/$ymilestone_time[$key2x][$key3x])*100),2);
				   }
                   // Last Values are values from current Milestone_surrogate entry which will be now replaced by new entry, so we will move this record into Milestone_surrogate_archive table
				   $last_baseline_time                = $prv_baseline_time[$key2x][$key3x];                                                      
				   $last_incremental_time             = $prv_incremental_time[$key2x][$key3x];                                                   
				   $last_total_time                   = $prv_baseline_time[$key2x][$key3x] + (float)$prv_incremental_time[$key2x][$key3x];       
				   $last_retrofit_parity              = $prv_retrofit_parity[$key2x][$key3x];
				   (float)$last_base_variance         = (float)$prv_base_variance[$key2x][$key3x];
				   (float)$last_incremental_variance  = (float)$prv_incremental_variance[$key2x][$key3x];
				   if ($netincremental == $prv_incremental_time[$key2x][$key3x]){
					   $updchk  = 0;
				   } else {
					   $updchk  = 1;
				   }
				   //print($updchk."<br>");
				   if($updchk == 1){
                    $queryz = "UPDATE ".$name.".milestone_surrogates
                                  SET iteration_count      = '$niteration_cnt',
				 				      occurance            = '$noccurance',
			 			 			  updated_by           = '$usr',
		 							  updated_on           = now(),
	 								  baseline_time        = '$netbaseline', 
 									  incremental_time     = '$netincremental',
									  total_time           = '$nettotal',
									  retrofit_parity      = 'N',
									  base_variance        = '$ybase_variance',
                                      incremental_variance = '$yincremental_variance',
									  adjust_occurance     = '$yadjust_occurance'
                                WHERE execution_id = '$key2x' 
							      AND milestone_id = '$key3x'";
                    //print($queryz."<br>");            
                    $mysql_dataz = mysql_query($queryz, $mysql_link) or die ("#32 Could not query: ".mysql_error());  
				    if ($noccurance <> 0){
				        $tracesql  = "INSERT into ".$name.".milestone_surrogates_archive(
					 																execution_id,
																					milestone_id,
				                                                                    updated_by,
																					last_update,
																					iteration_count,
																					baseline_time,
																					incremental_time,
																					total_time,
																					retrofit_parity,
																					occurance,
																					active_ind,
																					base_variance,
																					incremental_variance,
																					adjust_occurance
																				   )
                                                                            VALUES(
																				   '$key2x',
																				   '$key3x',
																				   '$usr',
																				   now(),
																				   '$last_iterationcnt',
																				   '$last_baseline_time',
																				   '$last_incremental_time',
																				   '$last_total_time',
																				   '$last_retrofit_parity',
																				   '$last_occurance',
																				   1,
																				   '$last_base_variance',
																				   '$last_incremental_variance',
																				   '$last_adjust_occurance'
																				  )";
				        //print($tracesql."<br>");
                        $mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace2b Could not query: ".mysql_error());
						if ($yajustment[$key2x][$key3x] <> "NULL"){
						    //$updoccrnc      = $prv_occurance[$key2x][$key3x];             //$updadj[$key2x][$key3x];
                            $queryupd = "UPDATE ".$name.".milestone_surrogates_archive
                                            SET adjust_occurance     = '$noccurance'
                                          WHERE execution_id         = '$key2x' 
							                AND milestone_id         = '$key3x'
								   		    AND occurance            = '$updoccrnc' ";
                            //print($queryupd."<br>");            
                            $mysql_dataupd = mysql_query($queryupd, $mysql_link) or die ("#32.upd Could not query: ".mysql_error());
                        }						
					   }
				   }
            }
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
                   <form method=\"post\" action=\"./executioncontrol_uat_x.php?pdp=$pdp&&start=$start\">
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
                         //print("
                         //       <tr>
                         //        <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">$deptx Testing</font></td>
                         //        <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                         //");
                         if (($uuser_type == 'UAT ADMINISTRATOR') || ($uuser_type == 'UAT PRIME') || ($uuser_type == 'UAT ANALYST')) {
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
                           ");
                           print("           
                                     </td>
                                              <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">&nbsp</font></td>
                        	                    <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
            	                                  <font color=\"#330099\"> 
                                                 &nbsp 
                                                </font> 
                                               </select> 
                                              </td>
                                             </tr>  
                           ");
                           print("</tr>");
                         } else {
                           //if ($ytest_ind[$y] == 0) {
                           //    //print(" <select align=\"left\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
                           //} else {
                           //    //print(" <select align=\"left\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
                           //}
                           //for ($e=1;$e<=2; ++$e) {
                           //     if ($ytest_ind[$y] == $ind_id[$e]) {
                           //         //print(" <option selected value=\"$ind_id[$e]\">$ind[$e]</option> ");
          	               //         print("   <font color=\"#330099\"> 
                           //                    $ind[$e] 
                           //                   </font>
                           //         ");           
                           //     } else
                           //     {
                           //         //print(" <option value=\"$ind_id[$e]\">$ind[$e]</option> ");    
          	               //         //print("   <font color=\"#330099\"> 
                           //         //           $ind[$e] 
                           //         //          </font>
                           //         //");           
                           //     }   
                           //}                         
                           print("        
                                     <input type=\"hidden\" name=\"yissue_area_id[$y]\" value=\"$yissue_area_id[$y]\">
                           ");
                         }
                         //print("           
                         //          </td>
                         //                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">&nbsp</font></td>
                    	 //                   <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
          	             //                     <font color=\"#330099\"> 
                         //                      &nbsp 
                         //                     </font> 
                         //                    </select> 
                         //                   </td>
                         //                  </tr>  
                         //");
               }
               //print("</tr>");
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
       $query42 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind,running_comments,last_update
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
               //$ydefects              = stripslashes($row42[10]);
               $yrunning_com_o        = stripslashes($row42[10]);
               $yrunning_com          = nl2br(stripslashes($row42[10]));
               //$ystart_dt_2           = stripslashes($row42[12]);
               //$yend_dt_2             = stripslashes($row42[13]);
               //$yactual_end_date      = stripslashes($row42[14]);
               //$yback_to_build        = stripslashes($row42[15]);
               //$yactual_testing_days  = stripslashes($row42[16]);
               $ylast_update          = stripslashes($row42[11]);
               //print($yactual_testing_days);

               print("  
                         <tr>
                          <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Execution ID</font></td>
                          <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
                           <font color=\"#330099\"> 
                            $yexecution_id
                           </font> 
                          </td>
                         </tr>
               "); 

               $query9 = "select area_execution_id,pdp_id,issue_area_id,back_to_build,start_date,end_date,
                                 actual_end_date,actual_testing_days,updated_by,last_update
                            from ".$name.".area_execution   
                           where pdp_id = '$xid'
                             and issue_area_id = '$uissue_area_id' "; 
               //print($query9);              
               $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#99 Could not query: ".mysql_error());
               $rowcnt9 = mysql_num_rows($mysql_data9);
               //print($rowcnt9);    

               if ($rowcnt9 == 0){
                         if (empty($yrunning_com)){
                         } else {
                             $query110 = "INSERT into ".$name.".pdp_logs(pdp_id,issue_area,updated_by,updated_on,comments,module,action,followup)
                                          VALUES('$xid','$uissue_area','$usr',current_timestamp,'$yrunning_com_o','TRACKER',0,1)";
                             $mysql_data110 = mysql_query($query110, $mysql_link) or die ("#110 Could not query: ".mysql_error());
                             $ypdp_log_id   = mysql_insert_id();
                         }
                         $query92 = "select pdp_log_id,updated_by,updated_on,comments,issue_area,phase,phase_desc
                                      from ".$name.".pdp_logs   
                                     where pdp_id = '$xid'
                                       and issue_area = '$uissue_area' 
                                       and module = 'TRACKER'
                                    "; 
                         //print($query91);               
                         $mysql_data92 = mysql_query($query92, $mysql_link) or die ("#91 Could not query: ".mysql_error());
                         $rowcnt92 = mysql_num_rows($mysql_data92);

                         if ($rowcnt92 > 0){
                             $comcnt = 0;
                             $ycomments = "";
                             while($rowx92 = mysql_fetch_row($mysql_data92)) {
                                   $comcnt                  = $comcnt + 1;
                                   $ypdp_log_id             = stripslashes($rowx92[0]);
                                   $yupdated_by             = stripslashes($rowx92[1]);
                                   $yupdated_on             = stripslashes($rowx92[2]);
                                   $ycomments               = stripslashes($rowx92[3]);
                                   $yissue_area             = stripslashes($rowx92[4]);
								   $yphase                  = stripslashes($rowx92[5]);
								   $yphase_desc             = stripslashes($rowx92[6]);
 							       if ($yphase == "OTHER"){
								       $yphase = $yphase." - ".$yphase_desc;
								   }
                                   //$urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   //$urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                                   //print($urunning_com[$comcnt]);
								   //////////////////////////////////////////////print($uissue_area." 1");
								   if ($uissue_area == 'ENTERPRISE UAT'){
								       //print("YES");
                                       $urunning_usr[$comcnt]   = "<table border='1' width='100%' style=\"border-style:solid; border-color:#00FF00 #00FF00;\">
								                                    <tr>
								     								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED BY:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_by</font></td>
								    								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED ON:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_on</font></td>
							    									</tr>																 
						    		                                <tr>
					    											 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>DEPT:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yissue_area</font></td>
				    												 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red' style=\"word-wrap: break-word;\">PHASE:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yphase</font></td>
					    											</tr>
					    											<tr>
																 <td bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" colspan='4' style=\"width='100%'; border-style:none; border-color:#00FF00 #00FF00;\">
																  <font color='black' style=\"word-wrap: break-word;\">$ycomments</font></td>
                                                                 </td> 																  
																</tr>
                                                               </table>																
                                                              ";
                                    } else {
									   //////////////////////////////////////////print("NO");
                                       $urunning_usr[$comcnt]   = "<table border='1' width='100%' style=\"border-style:solid; border-color:#00FF00 #00FF00;\">
								                                    <tr>
								     								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED BY:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_by</font></td>
								    								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED ON:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_on</font></td>
							    									</tr>																 
						    		                                <tr>
					    											 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>DEPT:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yissue_area</font></td>
				    												 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red' style=\"word-wrap: break-word;\"></font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'></font></td>
					    											</tr>
					    											<tr>
																 <td bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" colspan='4' style=\"width='100%'; border-style:none; border-color:#00FF00 #00FF00;\">
																  <font color='black' style=\"word-wrap: break-word;\">$ycomments</font></td>
                                                                 </td> 																  
																</tr>
                                                               </table>																
                                                              ";
                                    }									
                             }
                         }

                         if (empty($ystart_dt)) {
                             $ystart_dt_x = 1167627600;
                         } else {
                             $ystart_dt_x = $ystart_dt; 
                         }
                         if (empty($yend_dt)) {
                             $yend_dt_x = 1167627600;
                         } else {
                             $yend_dt_x = $yend_dt; 
                         }
                         
                         $ytest_iteration = 1;
                         for ($yit=1;$yit<=$ytest_iteration; ++$yit) {     
                              $query10 = "INSERT into ".$name.".area_execution(pdp_id,issue_area_id,start_date,end_date,test_iteration,updated_by)
                                          VALUES('$xid','$uissue_area_id','$ystart_dt_x','$yend_dt_x','$yit','$usr')";
                              //print($query10);                   
                              $mysql_data10 = mysql_query($query10, $mysql_link) or die ("#100 Could not query: ".mysql_error());
                              $epid                    = $xid;
                              $eissue_area_id          = $uissue_area_id;
                              $yback_to_build          = 0;
                              $yactual_end_date        = 0;
                              $yactual_testing_days    = 0;
                         } 
               }

               //if ($rowcnt9 == 1){
               $query91 = "select pdp_log_id,updated_by,updated_on,comments,issue_area,phase,phase_desc
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
								   $yphase                  = stripslashes($rowx91[5]);
								   $yphase_desc             = stripslashes($rowx91[6]);
 							       if ($yphase == "OTHER"){
								       $yphase = $yphase." - ".$yphase_desc;
								   }
                                   //$urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   //$urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                                   //print($urunning_com[$comcnt]);
								   //print($uissue_area." 2");
								   if ($uissue_area == 'ENTERPRISE UAT'){
								       //print("YES");
                                       $urunning_usr[$comcnt]   = "<table border='1' width='100%' style=\"border-style:solid; border-color:#00FF00 #00FF00;\">
								                                    <tr>
								     								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED BY:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_by</font></td>
								    								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED ON:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_on</font></td>
							    									</tr>																 
						    		                                <tr>
					    											 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>DEPT:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yissue_area</font></td>
				    												 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red' style=\"word-wrap: break-word;\">PHASE:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yphase</font></td>
					    											</tr>
					    											<tr>
																 <td bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" colspan='4' style=\"width='100%'; border-style:none; border-color:#00FF00 #00FF00;\">
																  <font color='black' style=\"word-wrap: break-word;\">$ycomments</font></td>
                                                                 </td> 																  
																</tr>
                                                               </table>																
                                                              ";
                                    } else {
									   //print("NO");
                                       $urunning_usr[$comcnt]   = "<table border='1' width='100%' style=\"border-style:solid; border-color:#00FF00 #00FF00;\">
								                                    <tr>
								     								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED BY:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_by</font></td>
								    								 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>UPDATED ON:</font></td>
								    								 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yupdated_on</font></td>
							    									</tr>																 
						    		                                <tr>
					    											 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red'>DEPT:</font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'>$yissue_area</font></td>
				    												 <td bgcolor=\"#EDE275\" align=\"left\" valign=\"middle\" style=\"width='15%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='red' style=\"word-wrap: break-word;\"></font></td>
					    											 <td bgcolor=\"#E8E8E8\" align=\"left\" valign=\"middle\" style=\"width='55%'; border-style:solid; border-color:#00FF00 #00FF00;\"><font color='blue'></font></td>
					    											</tr>
					    											<tr>
																 <td bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" colspan='4' style=\"width='100%'; border-style:none; border-color:#00FF00 #00FF00;\">
																  <font color='black' style=\"word-wrap: break-word;\">$ycomments</font></td>
                                                                 </td> 																  
																</tr>
                                                               </table>																
                                                              ";
                                    }									
                             }
               }     

               $query95 = "select area_execution_id,pdp_id,issue_area_id,back_to_build,start_date,end_date,actual_end_date,
                                  actual_testing_days,updated_by,last_update,test_iteration,actual_weekend_days,actual_start_date
                             from ".$name.".area_execution   
                            where pdp_id = '$xid'
                              and issue_area_id = '$uissue_area_id' "; 
               //print($query95);              
               $mysql_data95 = mysql_query($query95, $mysql_link) or die ("#99.1 Could not query: ".mysql_error());
               $rowcnt95 = mysql_num_rows($mysql_data95);
               //print($rowcnt9);    

               if ($rowcnt95 <> 0){
                   $ecnt = 1;
                   while($rowx95 = mysql_fetch_row($mysql_data95)) {
                         $ecnt                    = $ecnt + 1;
                         $exid                    = stripslashes($rowx95[0]);
                         $epid                    = stripslashes($rowx95[1]);
                         $eissue_area_id          = stripslashes($rowx95[2]);
                         $yback_to_build          = stripslashes($rowx95[3]);
                         $ystart_dt               = stripslashes($rowx95[4]);
                         $yend_dt                 = stripslashes($rowx95[5]);
                         $yactual_end_date        = stripslashes($rowx95[6]);
                         $yactual_testing_days    = stripslashes($rowx95[7]);
                         $yupdated_by             = stripslashes($rowx95[8]);
                         $ylast_update            = stripslashes($rowx95[9]);
                         $zit                     = stripslashes($rowx95[10]);
                         $yactual_weekend_days    = stripslashes($rowx95[11]);
                         $yactual_start_date      = stripslashes($rowx95[12]);
                         //if ($yend_dt < $ystart_dt){
                         //    $yend_dt = $start_dt;
                         //}
                         //if ($yactual_end_date < $yactual_start_date){
                         //    $yactual_end_date = $yactual_start_date;
                         //}
                         $ytotal_days_utilized    = $yactual_testing_days + $yactual_weekend_days;
                         $yds   = 0;
                         $yms   = 0;
                         $yys   = 0;
                         $yms2  = "";
                         $yde   = 0;
                         $yme   = 0;
                         $yye   = 0;
                         $yme2  = "";
                         $yda   = 0;
                         $yma   = 0;
                         $yya   = 0;
                         $yma2  = "";
                         $ydab  = 0;
                         $ymab  = 0;
                         $yyab  = 0;
                         $yma2b = "";
                         //if ($yactual_start_date == 0){
                         //    $yactual_start_date = $ystart_dt;
                         //} else {
                         //}

                            $query29 = "select b.issue_area,a.back_to_build
                                         from ".$name.".area_execution a, ".$name.".issue_areas b   
                                        where a.pdp_id = '$xid'
                                          and a.test_iteration = '$zit'
                                          and (a.issue_area_id = b.issue_area_id and b.short_desc <> 'MO')
                                     group by a.issue_area_id,a.back_to_build "; 
                            $mysql_data29 = mysql_query($query29, $mysql_link) or die ("#99.2 Could not query: ".mysql_error());
                            $rowcnt29 = mysql_num_rows($mysql_data29);
                            //print($query29."<br>"); 
                            $v = 1;
                            $yback_to_build_sum = "";
                            while($rowx29 = mysql_fetch_row($mysql_data29)) {
                                  $v = $v + 1;
                                  $vissue_area[$v]        = stripslashes($rowx29[0]); 
                                  $vback_to_build_sum[$v] = stripslashes($rowx29[1]);
                                  $yback_to_build_sum     = $yback_to_build_sum.$vback_to_build_sum[$v]." = ".$vissue_area[$v]."<br>";
                                  //$yback_to_build_sum2  = stripslashes($rowx29[1]);
                                  //print($yback_to_build_sum."<br>");
                            }                  

                                    //if (!empty($ystart_dt) || ($ystart_dt <> 0)){
                                        $yds  = date("d",$ystart_dt);
                                        $yms  = date("m",$ystart_dt);
                                        $yms2 = date("M",$ystart_dt);
                                        $yys  = date("Y",$ystart_dt);
                                        $ysdt = "$yds"."-"."$yms2"."-"."$yys";
                                        //$d1 = 4;
                                    //} else {
                                    //    $ysdt = "00-00-0000";
                                    //    //$ysdt = 0;
                                    //    $d2 = 0;    
                                    //}
                                    //if (!empty($yend_dt) || ($yend_dt <> 0)){
                                        $yde  = date("d",$yend_dt);
                                        $yme  = date("m",$yend_dt);
                                        $yme2 = date("M",$yend_dt);
                                        $yye  = date("Y",$yend_dt); 
                                        $yedt = "$yde"."-"."$yme2"."-"."$yye";
                                        //$d2 = 2; 
                                    //} else {
                                    //    $yedt = "00-00-0000";
                                    //    //$yedt = 0;
                                    //    $d2 = 0;
                                    //}
                                    // ----------------------------------------------------------
                                    //if (!empty($yactual_start_date) || ($yactual_start_date <> 0)){
                                        $ydab  = date("d",$yactual_start_date);
                                        $ymab  = date("m",$yactual_start_date);
                                        $yma2b = date("M",$yactual_start_date);
                                        $yyab  = date("Y",$yactual_start_date); 
                                        $yadtb = "$yda"."-"."$yma2"."-"."$yya";
                                        //$d3 = 1;
                                    //} else {
                                    //    if ($ysdt == "00-00-0000"){
                                    //        $yadtb = "00-00-0000";
                                    //        //$d3 = 0;
                                    //    } else {
                                    //        $yactual_start_date = $ystart_dt;
                                    //        $yda  = date("d",$yactual_start_date);
                                    //        $yma  = date("m",$yactual_start_date);
                                    //        $yma2 = date("M",$yactual_start_date);
                                    //        $yya  = date("Y",$yactual_start_date); 
                                    //        $yadtb = "$ydab"."-"."$yma2b"."-"."$yyab";
                                    //        //$d3 = 1;
                                    //    }
                                    //    //$yadt = "00-00-0000";
                                    //    //$yadt = 0;
                                    //    //$d3 = 0;
                                    //}
                                    //if (!empty($yactual_end_date) || ($yactual_end_date <> 0)){
                                        $yda  = date("d",$yactual_end_date);
                                        $yma  = date("m",$yactual_end_date);
                                        $yma2 = date("M",$yactual_end_date);
                                        $yya  = date("Y",$yactual_end_date); 
                                        $yadt = "$yda"."-"."$yma2"."-"."$yya";
                                    //    $d3 = 1;
                                    //} else {
                                    //    if ($yedt == "00-00-0000"){
                                    //        $yadt = "00-00-0000";
                                    //        $d3 = 0;
                                    //    } else {
                                    //        $yactual_end_date = $yend_dt;
                                    //        $yda  = date("d",$yactual_end_date);
                                    //        $yma  = date("m",$yactual_end_date);
                                    //        $yma2 = date("M",$yactual_end_date);
                                    //        $yya  = date("Y",$yactual_end_date); 
                                    //        $yadt = "$yda"."-"."$yma2"."-"."$yya";
                                    //        $d3 = 1;
                                    //    }
                                    //    //$yadt = "00-00-0000";
                                    //    //$yadt = 0;
                                    //    //$d3 = 0;
                                    //}
                     
                                        $incval = 86400;
                                        // -------------------------------------------------------------------
                                        $wkday_p = 0;
                                        $wkend_p = 0;
                                        if (($yend_dt >= $ystart_dt) && (($ystart_dt <> 0) && ($yend_dt <> 0))){
                                            $testingdays_p       = round((($yend_dt - $ystart_dt) / 86400)+1,0);    //+1 counts including the start_date
                                            $basedt1             = $ystart_dt;
											//print($testingdays_p."<br>");
                                            for ($dts=1; $dts<=$testingdays_p; ++$dts) {
											     if ($dts == 1){
												     $datval  = $basedt1;
												 } else {
                                                   $datval  = $basedt1 + (86400*($dts-1));
												 }
   											     //print($dts);
                                                 //$datval  = $basedt1 + (86400*$dts);
                                                 $newdate = (string)$datval; 
                                                 //print($newdate."<br>");
                                                 $dtday   = date("D",$newdate);
												 //print($dts." - ".$datval." - ".$dtday."<br>");
                                                 //echo $dtday;
                                                 if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                                                      $wkday_p = $wkday_p + 1;     
                                                 }     
                                                 if (($dtday == "Sat") || ($dtday == "Sun")){
                                                      $wkend_p = $wkend_p + 1;     
                                                 }     
                                            }
                                            $days_p  = $testingdays_p." Planned days<br>( ".$wkday_p." Weekdays and ".$wkend_p." Weekend Days)";
                                        } else {
                                          $testingdays_p       =  0;
                                          $days_p  = "Default dates are selected for Planned Start and End Dates, please set dates correctly";
                                        }

                                        // -------------------------------------------------------------------
                                        $wkday_a = 0;
                                        $wkend_a = 0;
                                        if ($yactual_end_date >= $yactual_start_date){
                                            $testingdays_a       = round((($yactual_end_date - $yactual_start_date) / 86400)+1,0);   //+1 counts including the actual_start_date
                                            $basedt2             = $yactual_start_date;
											//print($testingdays_a."<br>");
                                            for ($dts=1; $dts<=$testingdays_a; ++$dts) {
											     if ($dts == 1){
												     $datval  = $basedt2;
												 } else {
                                                   $datval  = $basedt2 + (86400*($dts-1));
												 }
                                                 $newdate = (string)$datval; 
                                                 $dtday   = date("D",$newdate);
												 //print($dts." - ".$datval." - ".$dtday."<br>");
                                                 if (($dtday == "Mon") || ($dtday == "Tue") || ($dtday == "Wed") || ($dtday == "Thu") || ($dtday == "Fri")) {
                                                      $wkday_a = $wkday_a + 1;     
                                                 }     
                                                 if (($dtday == "Sat") || ($dtday == "Sun")){
                                                      $wkend_a = $wkend_a + 1;     
                                                 }     
                                            }
                                            $days_a  = $testingdays_a." Days Available<br>( ".$wkday_a." Weekdays and ".$wkend_a." Weekend Days)";
                                        } else {
                                          $testingdays_a       =  0;
                                          $days_a  = "Default dates are selected for Actual Start and End Dates, please set dates correctly";
                                        }

                                        if (($yactual_testing_days == 0) && ($yactual_weekend_days == 0)){
                                            $wkdaya = 0;
                                            $wkenda = 0;
                                            $usd    = "TBD";
                                        } else {
                                            if ($yactual_testing_days == 0){
                                                $wkdaysa = 0;
                                            } else {
											    //if ($wkdaya == 0){
												//    $wkdaya = 0;
												//} else {
                                                    $wkdaya = round(($yactual_testing_days / $wkday_a),2)*100;
												//}	
                                            }
                                            if ($yactual_weekend_days == 0){
                                                $wkenda = 0;
                                            } else {
											    //if ($wkdaya == 0){
												//    $wkenda = 0; 
												//} else {
                                                    $wkenda = round(($yactual_weekend_days / $wkend_a),2)*100;
												//}
                                            }	
                                        }
                                        //$days_a  = $testingdays_a." Days Available<br>( ".$wkday_a." Weekdays and ".$wkend_a." Weekend Days)";
										//print($yactual_testing_days." - ".$wkday_a." - ".$wkdaya."% - ".$yactual_weekend_days." - ".$wkend_a." - ".$wkenda."%<br>");
                                        $usd = $yactual_testing_days." Weekdays (".$wkdaya."%) "."<br>".$yactual_weekend_days." Weekend Days (".$wkenda."%)";
                                        // --------------------------------------------------------------------------------------------------
                     
                                    print("
                                           <tr>
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Planned Start Date<br>(dd-mm-yyyy)</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\">
                                    ");
                                    if ($ystart_dt == 1167627600) {
                                        $colr = "#FFFF00";
                                    } else {
                                        $colr = "#FFFFFF";
                                    }
                                    print(" <select align=\"left\" name=\"xds[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
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
                                    print(" <select align=\"left\" name=\"xms[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
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
                                    print(" <select align=\"left\" name=\"xys[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
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
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Planned End Date<br>dd-mm-yyyy)</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                    ");
                                    if ($yend_dt == 1167627600) {
                                        $colr = "#FFFF00";
                                    } else {
                                        $colr = "#FFFFFF";
                                    }
                                    print("<select align=\"left\" name=\"xde[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
                                    for ($xdy_e=1;$xdy_e<=31; ++$xdy_e) {
                                         if ($yde == $xdy_e) {
                                             print(" <option selected value=\"$xdy_e\">$xdy_e</option> ");
                                     }
                                     else {
                                             print(" <option value=\"$xdy_e\">$xdy_e</option> ");
                                         }
                                    }
                                    print(" </select>
                                            <select align=\"left\" name=\"xme[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
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
                                            <select align=\"left\" name=\"xye[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
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
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Planned Testing Window<br>Planned (End - Start) Date</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\"> 
                                              $days_p
                                             </font> 
                                            </td>
                                           </tr>
                                           <tr>
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Start Date<br>dd-mm-yyyy)</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                    ");
                                    if ($yactual_start_date == 1167627600) {
                                        $colr = "#FFFF00";
                                    } else {
                                        $colr = "#FFFFFF";
                                    }
                                    print("<select align=\"left\" name=\"xdab[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
                                    for ($xdy_ab=1;$xdy_ab<=31; ++$xdy_ab) {
                                         if ($ydab == $xdy_ab) {
                                             print(" <option selected value=\"$xdy_ab\">$xdy_ab</option> ");
                                     }
                                     else {
                                             print(" <option value=\"$xdy_ab\">$xdy_ab</option> ");
                                         }
                                    }
                                    print(" </select>
                                            <select align=\"left\" name=\"xmab[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
                                    ");
                                    for ($xmon_ab=1;$xmon_ab<=12; ++$xmon_ab) {
                                         if ($ymab == $xmon_ab) {
                                             print(" <option selected value=\"$xmon_ab\">$xmon_ab</option> ");
                                         }
                                         else {
                                             print(" <option value=\"$xmon_ab\">$xmon_ab</option> ");
                                         }
                                    }
                                    print(" </select>
                                            <select align=\"left\" name=\"xyab[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
                                    ");
                                    for ($xyr_ab=2007;$xyr_ab<=2015; ++$xyr_ab) {
                                         if ($yyab == $xyr_ab) {
                                             print(" <option selected value=\"$xyr_ab\">$xyr_ab</option> ");
                                         }
                                         else {
                                             print(" <option value=\"$xyr_ab\">$xyr_ab</option> ");
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
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual End Date<br>dd-mm-yyyy)</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                    ");
                                    if ($yactual_end_date == 1167627600) {
                                        $colr = "#FFFF00";
                                    } else {
                                        $colr = "#FFFFFF";
                                    }
                                    print("<select align=\"left\" name=\"xda[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> ");
                                    for ($xdy_a=1;$xdy_a<=31; ++$xdy_a) {
                                         if ($yda == $xdy_a) {
                                             print(" <option selected value=\"$xdy_a\">$xdy_a</option> ");
                                     }
                                     else {
                                             print(" <option value=\"$xdy_a\">$xdy_a</option> ");
                                         }
                                    }
                                    print(" </select>
                                            <select align=\"left\" name=\"xma[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\"> 
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
                                            <select align=\"left\" name=\"xya[$yid][$zit]\" style=\"color: #000000; font-weight: normal; background-color: $colr;\">
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
                                            <!--<td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Available Days<br>Actual(End - Start)</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\"> 
                                              $days_a   
                                             </font> 
                                            </td>-->
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Available Days<br>Actual (End - Start) Date</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\"> 
                                              $days_a
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
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Actual Days Utilized</font></td>
                                        ");
                                        print("    
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <table>
                                              <td align=\"center\" valign=\"middle\">
                                                <font color=\"#330099\">
                                                 Select Weekdays<br>
                                                  <select align=\"center\" valign=\"middle\" name=\"yactual_testing_days[$yid][$zit]\">
                                        ");
                                        //$d5
                                        for ($dy=0;$dy<=$wkday_a;$dy=$dy+1) {
                                             //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                                          if ($yactual_testing_days == $dy) {
                                                  print(" <option selected value=\"$dy\">$dy</option>");
                                          } else {
                                                  print(" <option value=\"$dy\">$dy</option>");
                                          }   
                                        }
                                        print("   </font>
                                                 </select>
                                                </td> 
                                                <td align=\"center\" valign=\"middle\" style=\"width:40%;\">
                                                 <font color=\"#330099\">
                                                  Select Weekend Days<br>
                                                   <select align=\"center\" valign=\"middle\" name=\"yactual_weekend_days[$yid][$zit]\">
                                        ");
                                        //$d5
                                        for ($dy=0;$dy<=$wkend_a;$dy=$dy+1) {
                                             //print("<a>".$dy." - ".$yactual_testing_days."<br></a>");
                                          if ($yactual_weekend_days == $dy) {
                                                  print(" <option selected value=\"$dy\">$dy</option>");
                                          } else {
                                                  print(" <option value=\"$dy\">$dy</option>");
                                          }   
                                        }
                                        print("   </font>
                                                 </select>
                                                </td>
                                                <td align=\"center\" valign=\"middle\" style=\"width:30%;\">
                                                 <strong>
                                                  <font color=\"#FF0000\">
                                                   <a>Total Days Utilized<br>$ytotal_days_utilized</a>
                                                  </font>
                                                 </strong> 
                                                </td>
                                               </td>
                                              </table>  
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
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Effort Required<br>% of Days Utilized</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\">
                                               $usd
                                             </font> 
                                            </td>
                                           </tr>
                                           <tr>
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\"> 
                                              <select align=\"center\" valign=\"middle\" name=\"yback_to_build[$yid][$zit]\">
                                        ");
										$b2bldx = $yback_to_build + 5;
                                        for ($b2bld=$yback_to_build;$b2bld<=$b2bldx;$b2bld=$b2bld+1) {
                                          if ($b2bld == $yback_to_build) {
                                              print(" <option selected value=\"$b2bld\">$b2bld</option>");
                                          } else {
                                              print(" <option value=\"$b2bld\">$b2bld</option>");
                                          }   
                                        }
                                        print(" </select>
										        <a>&nbsp($uissue_area) ONLY</a> 
 											 <!-- <font color=\"#330099\"> 
                                              <input type=\"text\" name=\"yback_to_build[$yid][$zit]\" value=\"$yback_to_build\" size=\"4\" maxlength=\"4\"><a>&nbsp($uissue_area) ONLY</a>
                                             --> 
											  </font> 
                                            </td>
                                            <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Back To Build</font></td>
                                            <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                                             <font color=\"#330099\">
                                              $yback_to_build_sum  
                                             </font> 
                                            </td>
                                           </tr>
                                    ");
                   }
               } 
               
               
               print("
                      <tr>
                       <td colspan=\"4\" align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         &nbsp
                        </font> 
                       </td>
                      </tr>
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
                      <tr>
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
				</table>
			    ");
                $captn3 = "Enter Comments";
                print("				
				<table border='0' align=\"center\" width=\"90%\">
				 <caption>$captn3</caption>
				 <!--<tr>
                  <td colspan=\"4\" bgcolor=\"#99CC66\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                   <font color=\"#330099\">
                    Enter New Comments
                   </font>
                  </td>
                </tr>-->
               ");
			   
			   if ($uissue_area == 'ENTERPRISE UAT'){
			     print("	
                   <tr>
			       <td bgcolor=\"#99CC66\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Enter Phase</font></td>
			  	  <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFCC\" style=\"width:30%;\">
                   ");
                   print(" <select align=\"left\" name=\"ymil_x[$yid]\"> ");
                   for ($mil_x=1;$mil_x<=$mil_cnt; ++$mil_x) {
                        print(" <option value=\"$mil[$mil_x]\">$mil[$mil_x]</option> ");    
                   }
			       $mil_x  = $mil_cnt + 1;
			       $mil_x1 = "OTHER";
			       print(" <option selected value=\"$mil_x1\">$mil_x1</option> ");
                   print(" 
                        </select>			   
				      </td>
                     <td bgcolor=\"#99CC66\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Details for OTHER</font></td>				 
                     <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFCC\" style=\"width:30%;\">
   	                   <font color=\"#330099\"> 
                        <input type=\"text\" name=\"ymil_y[$yid]\" value=\"\" size=\"50\" maxlength=\"50\">
                       </font> 
                      </td>
				     </tr>
				   ");
				 }  
				 print("
                      <tr>
                       <td colspan=\"4\" align=\"left\" valign=\"middle\" bgcolor=\"#CCFFCC\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\">
         	            <font color=\"#330099\">
                         <textarea name=\"ycomments[$yid]\" cols=\"1\" rows=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\"></textarea> 
                        </font>
                       </td>
                       <input type=\"hidden\" name=\"yrunning_com[$yid]\" value=\"$yrunning_com\">
                      </tr>
                <tr>
                 <td colspan=\"4\" bgcolor=\"#99CC66\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Comments Log
                  </font>
                 </td>
                </tr>
                <tr>
                 <td colspan=\"4\" border=\"1\" bgcolor=\"#CCFFCC\" align=\"left\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;  scroll-x: auto;\">
                  <!--<font color=\"#000000\">-->
                  <!--<textarea cols=\"4\" rows=\"2\" readonly=\"readonly\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\">-->
                  <div id=\"track1\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px; overflow: auto; background-color: #CCFFCC;\">
                   <p>
               ");
               //$yrunning_com[$comcnt]   = $ycomments; 
               //$yrunning_usr[$comcnt]   = "UPDATED BY: ".$yupdated_by."FROM: ".$issue_area." UPDATED ON: ".$yupdated_on; 
               //$yrunning_com
               //    <!--<p style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\>-->
               //    <!--</p>--> 
               for ($com=$comcnt;$com>=1; --$com) {
                    //$wrunning_usr = nl2br($urunning_usr[$com]);
                    //$wrunning_com = nl2br($urunning_com[$com]);
					$wrunning_usr = $urunning_usr[$com];
                    //print($wrunning_usr.$wrunning_com);
 				    print($wrunning_usr."<br><br><br>");

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
       ");
	   // SELECT ALL MILESTONES FROM pdp_stlc where milestone_ind = 1, AND LOAD INTO $umil_xx array
       $query44 = "select milestone_id,
	                      milestone,
						  milestone_ind,
						  milestone_time,
						  milestone_seq,
						  issue_area_id,
						  milestone_type
                     from ".$name.".pdp_stlc  
                    where issue_area_id = '$uissue_area_id'
					  and milestone_ind = 1
                  ";
       //print($query44);               
       $mysql_data44 = mysql_query($query44, $mysql_link) or die ("#47.5 Could not query: ".mysql_error());
       $rowcnt44     = mysql_num_rows($mysql_data44);
	   $row44cnt     = 0;
       while($row44x = mysql_fetch_row($mysql_data44)) {
               $row44cnt               = $row44cnt + 1;
               $umil_id[$row44cnt]     = stripslashes($row44x[0]);
			   $umil[$row44cnt]        = stripslashes($row44x[1]);
			   $umil_time[$row44cnt]   = stripslashes($row44x[3]);
			   $umil_type[$row44cnt]   = stripslashes($row44x[6]);
			   //print($umil[$row44cnt]." - ".$umil_id[$row44cnt]." - ".$umil_time[$row44cnt]." - ".$umil_type[$row44cnt]."<br>");
       }
       if ($rowcnt44 == 0) {
           print("  
                  <input type=\"hidden\" name=\"stlc\" value=\"0\">
           ");
       } else { 
           print("  
                <input type=\"hidden\" name=\"stlc\" value=\"1\">
                <caption>$captn</caption>
                <tr>
                 <!--<td bgcolor=\"#99CC00\" align=\"center\" rowspan=\"2\"><font color=\"#FFFFFF\">ID</font></td>-->
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">No</font></td>
                 <!--<td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Order</font></td>-->
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\" width=\"100px\"><font color=\"#330099\">Work Activities</font></td>
                 <!--<td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\" ><font color=\"#330099\" width=\"100px\">Baseline<br>Effort<br>HRS : MIN</font></td>-->
                 <td bgcolor=\"#CCCC99\" align=\"center\" colspan=\"2\" ><font color=\"#330099\">Enter Rework<br>Effort</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" colspan=\"4\"><font color=\"#330099\">Total Efffort<br>HRS:MIN</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" colspan=\"1\" ><font color=\"#330099\">Previous<br>Rework Entries</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Last<br>Updated</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Update</font></td>
                </tr>
                <tr>
				 <td bgcolor=\"#FFCC66\" align=\"center\"><font color=\"#330099\" width=\"100px\">HRS:MIN</font></td>
				 <td bgcolor=\"#FFCC66\" align=\"center\"><font color=\"#330099\">Iterations</font></td>
				 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Baseline</font></td>
                 <!--<td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Baseline<br>Effort</font></td>-->
                 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Rework<br>Effort</font></td>
                 <!--<td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Incremental<br>Variance</font></td>-->
                 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Total<br>PDP<br>Effort</font></td>
				 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Iterations<br>To Date</font></td>
				 <td bgcolor=\"#FFCC66\" align=\"center\"><font color=\"#330099\">Select to<br>Delete<br><br>Iterations | Time</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">By</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">On</font></td>
                </tr>
           ");
	       // Load milestone surrogate entries	   
           $query34 = "select a.execution_id,
		                      a.milestone_id,
							  a.iteration_count,
							  b.milestone
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b 
                        where a.execution_id = $yexecution_id
                          and a.milestone_id = b.milestone_id
                          and b.issue_area_id = '$uissue_area_id'
                      ";
           $mysql_data34 = mysql_query($query34, $mysql_link) or die ("#47 Could not query: ".mysql_error());
           $rowcnt34     = mysql_num_rows($mysql_data34);
		   // If no milestone_surrogate entries found, then insert
           if ($rowcnt34 == 0) {  
               for ($d=1;$d<=$mil_cnt;++$d) {
                    if ($mil_ind[$d] == 1) {
					    // Wendy wants baseline to start at 0, therefore baseline_time and total_time is made 0 and not $mil_time[$d] i.e. milestone_time from pdp_stlc table
                        $query35 = "INSERT into ".$name.".milestone_surrogates(
						                                                       execution_id,
																			   milestone_id,
																			   iteration_count,
																			   updated_by,
																			   updated_on,
																			   baseline_time,
																			   total_time,
																			   retrofit_parity,
																			   occurance,
																			   base_variance
																			  )
                                                                       VALUES(
																	          '$yexecution_id',
																			  '$mil_id[$d]',
																			  0,
																			  '$usr',
																			  now(),
																			  '$mil_time[$d]',
																			  '$mil_time[$d]',
																			  'N',
																			  0,
																			  100.00
																			  )";
                        $mysql_data35 = mysql_query($query35, $mysql_link) or die ("#48 Could not query: ".mysql_error());
                    }    
               }
           }
		   // Find and insert missing milestone in milestone_surrogate entries
		   // OR
		   // Update active_ind = 0 for milestone_surrogate entry has been invalidated
	       $row34cnt     = 0;   // This is a counter not to be confused with $rowcnt34 which counts no of rows returned from $query34
           while($row34x = mysql_fetch_row($mysql_data34)) {
                 $row34cnt            = $row34cnt + 1;
                 $vmil_id[$row34cnt]  = stripslashes($row34x[1]);
				 $vmil[$row34cnt]     = stripslashes($row34x[3]);
           }
		   // Insert - when milestone entry missing
 		   if ($rowcnt34 <> 0) {
		       //print("HERE1<br>");
               for ($u0=1;$u0<=$row44cnt;++$u0) {
			        $fnd_u0 = 0;   
			        for ($u1=1;$u1<=$row34cnt;++$u1) {
                         if ($umil_id[$u0] == $vmil_id[$u1]) {
				             $fnd_u0 = 1;					
                         }
						 //print($umil[$u0]." - ".$vmil[$u1]." - ".$fnd_u0."<br>");
			        }
					//print($umil[$u0]." - ".$fnd_u0."<br>");
                    if ($fnd_u0 == 0){
                        $query35x = "INSERT into ".$name.".milestone_surrogates(
						                                                        execution_id,
																				milestone_id,
																				iteration_count,
																				updated_by,
																				updated_on,
																				baseline_time,
																				total_time,
																				retrofit_parity,
																				occurance,
																				base_variance
																				)
                                                                         VALUES(
																		        '$yexecution_id',
																				'$umil_id[$u0]',
																				0,
																				'$usr',
																				now(),
																				'$umil_time[$u0]',
																				'$umil_time[$u0]',
																				'N',
																				0,
																				100.00
																				)";
						//print($query35x."<br>");														
                        $mysql_data35x = mysql_query($query35x, $mysql_link) or die ("#48.X Could not query: ".mysql_error());
                    } else {
                    }			 
               }
           } 
           $query44 = "select a.execution_id,
		                      a.milestone_id,
							  a.iteration_count,
							  a.updated_by,
							  a.updated_on,
							  a.baseline_time,
							  a.total_time,
							  a.incremental_time,
							  a.occurance,
							  b.milestone_type, 
							  b.milestone_time,
                              b.milestone,
                              b.milestone_seq,
                              a.base_variance,
                              a.incremental_variance,
							  a.adjust_occurance,
							  a.retrofit_parity
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b   
                        where a.execution_id  = $yexecution_id
                          and a.milestone_id  = b.milestone_id 
                          and b.issue_area_id = '$uissue_area_id'
                     order by b.milestone_seq asc   						  
                      ";
           //print($query44."<br>");               
           $mysql_data44       = mysql_query($query44, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
           $rowcnt44           = mysql_num_rows($mysql_data44);
           $eseq               = 0;
           $total_baseline     = 0;
           $total_incrementatl = 0;
		   $eseq_a             = 0;
		   //$eseq_a_anti        = 0;
           while($row44 = mysql_fetch_row($mysql_data44)) {
		        $new_parity_cnt                = 0;		   
                $eseq                          = $eseq + 1;
                $yexecution_id                 = stripslashes($row44[0]);
                $ymilestone_id                 = stripslashes($row44[1]);
                $zid                           = stripslashes($row44[1]);
                $yiteration_cnt                = stripslashes($row44[2]);
                $yupdated_by                   = stripslashes($row44[3]);
                $yupdated_on                   = stripslashes($row44[4]);
                $ybaseline_time                = stripslashes($row44[5]);
	            $ybase_hrs                     = intval($ybaseline_time/60);      //derives hours 
                $ybase_mins                    = $ybaseline_time%60;              // derives minutes beyond 60 but less then 60 in the last hour
                $ytotal_time                   = stripslashes($row44[6]);
	            $ytotal_hrs                    = intval($ytotal_time/60);        
                $ytotal_mins                   = $ytotal_time%60;                 
                $yincremental_time             = stripslashes($row44[7]);
	            $yincr_hrs                     = intval($yincremental_time/60);    
                $yincr_mins                    = $yincremental_time%60;           
				$yoccurance                    = stripslashes($row44[8]);
				$ymilestone_type               = stripslashes($row44[9]);
				$ymilestone_time               = stripslashes($row44[10]);
				//if ($ymilestone_type == "F" or $ymilestone_type == "N"){
				//    $yincr_time_1              = $yiteration_cnt * $ymilestone_time;
				//}
				//if ($ymilestone_type == "V"){
				    $yincr_time_1              = $yincremental_time;
				//}
	            $yincr_hrs_1                   = intval($yincr_time_1/60);    
                $yincr_mins_1                  = $yincr_time_1%60;           
	            $ymilestone_hrs                 = intval($ymilestone_time/60);      
                $ymilestone_mins               = $ymilestone_time%60;             
				$ymilestone                    = stripslashes($row44[11]);
				(float)$ymilestone_seq         = stripslashes($row44[12]);
				(float)$ybase_variance         = stripslashes($row44[13]);
				(float)$yincremental_variance  = stripslashes($row44[14]);
				$yadjust_occurance             = stripslashes($row44[15]);
				//if ($adjust_occurance <> 0){
				//    $eseq_a_anti = $eseq_a_anti + 1;
				//}
				$yretrofit_parity              = stripslashes($row44[16]);
				// Suppressing "X" entries to display in the drop down selection of decrement drop down on Rework Section on Tracker Page
				if ($yretrofit_parity == "N" and $yadjust_occurance == 0){
				//if ($yretrofit_parity == "N" or $yretrofit_parity == "X"){
				    $new_parity_cnt   = $new_parity_cnt + 1; 
				}
				//print($ymilestone_id." - ".$eseq_a." - ".$yretrofit_parity." - ".$new_parity_cnt." - ".$yadjust_occurance."<br>");
				if ($yoccurance == 0){
				    $eseq_a                        = 0;
				} else {
				    //print("Occurance is: ".$yoccurance."<br>");
				    $eseq_a                        = 1;
				    $yoccurance_a[$eseq_a]         = $yoccurance;
					//print("Occurance is: ".$yoccurance_a[$eseq_a]."<br>");
				    $yiteration_cnt_a[$eseq_a]     = $yiteration_cnt;
				    $yincr_hrs_a2[$eseq_a]         = $yincr_hrs_1;
				    $yincr_mins_a2[$eseq_a]        = $yincr_mins_1;
				    //$mil_history_rows[$eseq_a]   = $yoccurance_a[$eseq_a]." | ".$yiteration_cnt_a[$eseq_a]." | ".$yincr_hrs_a2[$eseq_a].":".$yincr_mins_a2[$eseq_a]." - ".$yadjust_occurance; 
 					//$mil_row_flag[$eseq_a]       =  "O".$yoccurance_a[$eseq_a];    //Original
				    //$mil_history_rows[$eseq_a]   = $yoccurance." | ".$yiteration_cnt." | ".$yincr_hrs_1.":".$yincr_mins_1." - ".$yadjust_occurance; 
					if (strlen($yincr_hrs_1) == 1){
					    $yincr_hrs_1_x = "0".$yincr_hrs_1;
					}
					if (strlen($yincr_mins_1) == 1){
					    $yincr_mins_1_x = "0".$yincr_mins_1;
					}
				    //$mil_history_rows[$eseq_a]     = $yiteration_cnt." | ".$yincr_hrs_1_x.":".$yincr_mins_1_x; 
 					$mil_row_flag[$eseq_a]         = "O".$yoccurance;    //Original
					//print($mil_row_flag[$eseq_a]." - ".$mil_history_rows[$eseq_a]."<br>");
					//$mil_occurance[$eseq_a]     = $yoccurance;
                }
				// The following elements below can assemble $mil_history_rows where incremental time can be exact not cummulative for milestone type = V
				$row_milflg[$eseq_a]              = $ymilestone_type; 
				$row_occr[$eseq_a]                = $yoccurance_a[$eseq_a];
				$row_itcnt[$eseq_a]               = $yiteration_cnt_a[$eseq_a];
				$row_incr[$eseq_a]                = $yincremental_time;
				$row_adjust[$eseq_a]              = $yadjust_occurance;
				$row_parity[$eseq_a]              = $yretrofit_parity;
				////////////////////////////////////////////////
				/// milestone_surrogate_archive
				////////////////////////////////////////////////
                $query44_a = "select 
				              a.execution_id,
		                      a.milestone_id,
							  a.iteration_count,
							  a.updated_by,
							  a.last_update,
							  a.baseline_time,
							  a.total_time,
							  a.incremental_time,
							  a.occurance,
							  b.milestone_type, 
							  b.milestone_time,
                              b.milestone,
                              a.retrofit_parity,
                              a.active_ind,
                              a.milestone_surrogate_archive_id,
                              a.base_variance,
                              a.incremental_variance,
							  b.milestone_seq,
							  a.adjust_occurance,
							  a.retrofit_parity
                         from ".$name.".milestone_surrogates_archive a, ".$name.".pdp_stlc b  
                        where a.execution_id  = '$yexecution_id' 
                          and a.milestone_id  = '$ymilestone_id' 
						  and a.milestone_id  = b.milestone_id
				     order by a.last_update desc 		  
                      ";
                //print($query44_a."<br>");               
                $mysql_data44_a     = mysql_query($query44_a, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
                $rowcnt44_a         = mysql_num_rows($mysql_data44_a);
				//print($rowcnt44_a."<br>");
                //$eseq_a             = 1;
                while($row44_a = mysql_fetch_row($mysql_data44_a)) {
                      $eseq_a                                             = $eseq_a + 1;
                      $yexecution_id_a2[$eseq_a]                          = stripslashes($row44_a[0]);
                      $ymilestone_id_a2[$eseq_a]                          = stripslashes($row44_a[1]);
                      $zid_a2[$eseq_a]                                    = stripslashes($row44_a[1]);
                      $yiteration_cnt_a2[$eseq_a]                         = stripslashes($row44_a[2]);
                      $yupdated_by_a2[$eseq_a]                            = stripslashes($row44_a[3]);
                      $yupdated_on_a2[$eseq_a]                            = stripslashes($row44_a[4]);
                      (float)$ybaseline_time_a2[$eseq_a]                  = stripslashes($row44_a[5]);
	                  $ybase_hrs_a2[$eseq_a]                              = intval($ybaseline_time_a2[$eseq_a]/60);      //derives hours 
                      $ybase_mins_a2[$eseq_a]                             = $ybaseline_time_a2[$eseq_a]%60;              // derives minutes beyond 60 but less then 60 in the last hour
                      (float)$ytotal_time_a2[$eseq_a]                     = stripslashes($row44_a[6]);
	                  $ytotal_hrs_a2[$eseq_a]                             = intval($ytotal_time_a2[$eseq_a]/60);        
                      $ytotal_mins_a2[$eseq_a]                            = $ytotal_time_a2[$eseq_a] %60;               
                      (float)$yincremental_time_a2[$eseq_a]               = stripslashes($row44_a[7]);
	                  $yincr_hrs_a2[$eseq_a]                              = intval($yincremental_time_a2[$eseq_a]/60);    
                      $yincr_mins_a2[$eseq_a]                             = $yincremental_time_a2[$eseq_a]%60;           
				      $yoccurance_a2[$eseq_a]                             = stripslashes($row44_a[8]);
				      $ymilestone_type_a2[$eseq_a]                        = stripslashes($row44_a[9]);
				      (float)$ymilestone_time_a2[$eseq_a]                 = stripslashes($row44_a[10]);
					  //if ($ymilestone_type == "F" or $ymilestone_type == "N"){
					  //    $yincr_time_a21[$eseq_a]                        = $yiteration_cnt_a2[$eseq_a] * $ymilestone_time_a2[$eseq_a];
					  //}
					  //if ($ymilestone_type == "V"){
					      $yincr_time_a21[$eseq_a]                        = $yincremental_time_a2[$eseq_a];
					  //}
	                  $yincr_hrs_a21[$eseq_a]                             = intval($yincr_time_a21[$eseq_a]/60);    
                      $yincr_mins_a21[$eseq_a]                            = $yincr_time_a21[$eseq_a]%60;           
				      $ymilestone_a2[$eseq_a]                             = stripslashes($row44_a[11]);
				      $yactive_ind_a2[$eseq_a]                            = stripslashes($row44_a[13]);
				      $ymilestone_surrogate_archive_id_a2[$eseq_a]        = stripslashes($row44_a[14]);
				      (float)$ybase_variance_a2[$eseq_a]                  = stripslashes($row44_a[15]);
				      (float)$yincremental_variance_a2[$eseq_a]           = stripslashes($row44_a[16]);
				      (float)$ymilestone_seq_a2[$eseq_a]                  = stripslashes($row44_a[17]);
				      $yadjust_occurance_a2[$eseq_a]                      = stripslashes($row44_a[18]);
					  //if ($yadjust_occurance_a2 <> 0){
					  //    $eseq_a_anti = $eseq_a_anti + 1;
					  //}
					  $yretrofit_parity_a2[$eseq_a]                       = stripslashes($row44_a[19]);
				      if ($yretrofit_parity_a2[$eseq_a] == "N" and $yadjust_occurance_a2[$eseq_a] == 0){
				          $new_parity_cnt   = $new_parity_cnt + 1; 
				      }
                      //print($ymilestone_id_a2[$eseq_a]." - ".$eseq_a." - ".$yretrofit_parity_a2[$eseq_a]." - ".$new_parity_cnt." - ".$yadjust_occurance_a2[$eseq_a]."<br>"); 
			          //$mil_history_rows[$eseq_a]                        = $yoccurance_a2[$eseq_a]." | ".$yiteration_cnt_a2[$eseq_a]." | ".$yincr_hrs_a21[$eseq_a].":".$yincr_mins_a21[$eseq_a]." - ".$yadjust_occurance_a2[$eseq_a]; 
					  if (strlen($yincr_hrs_a21[$eseq_a]) == 1){
					      $yincr_hrs_a21_x[$eseq_a] = "0".$yincr_hrs_a21[$eseq_a];
					  }
					  if (strlen($yincr_mins_a21[$eseq_a]) == 1){
					      $yincr_mins_a21_x[$eseq_a] = "0".$yincr_mins_a21[$eseq_a];
					  }
			          //$mil_history_rows[$eseq_a]                          = $yiteration_cnt_a2[$eseq_a]." | ".$yincr_hrs_a21_x[$eseq_a].":".$yincr_mins_a21_x[$eseq_a]; 
					  $mil_row_flag[$eseq_a]                              = "A".$yoccurance_a2[$eseq_a];   // Archive
					  // The following elements below can assemble $mil_history_rows where incremental time can be exact not cummulative for milestone type = V
					  $row_milflg[$eseq_a]                                = $ymilestone_type_a2[$eseq_a]; 
					  $row_occr[$eseq_a]                                  = $yoccurance_a2[$eseq_a];
					  $row_itcnt[$eseq_a]                                 = $yiteration_cnt_a2[$eseq_a];
					  $row_incr[$eseq_a]                                  = $yincremental_time_a2[$eseq_a];
					  $row_adjust[$eseq_a]                                = $yadjust_occurance_a2[$eseq_a];
					  $row_parity[$eseq_a]                                = $yretrofit_parity_a2[$eseq_a];
					  //print($mil_row_flag[$eseq_a]." - ".$mil_history_rows[$eseq_a]."<br>");
					  //$mil_occurance[$eseq_a]                           = $yoccurance_a[$eseq_a];
                } 	
                //print($ymilestone." = ".$eseq_a."<br>");				
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
				// FIND TOTALS
				// Get from milstone_surrogates
                $query36 = " select sum(iteration_count)
                                   from ".$name.".milestone_surrogates  
                                  where milestone_id = '$zid' 
                                    and execution_id = '$yexecution_id'
                           ";
                $mysql_data36 = mysql_query($query36, $mysql_link) or die ("#50 Could not query: ".mysql_error());
                $rowcnt36 = mysql_num_rows($mysql_data36);
                while($row36 = mysql_fetch_row($mysql_data36)) {
				      $todate_iteration_cnt  = stripslashes($row36[0]);
                }
				// Get from milstone_surrogate_archive
                $query36x = " select sum(iteration_count)
                                    from ".$name.".milestone_surrogates_archive  
                                   where milestone_id = '$zid' 
                                     and execution_id = '$yexecution_id'
									 and retrofit_parity in ('N','X')
                                ";
                $mysql_data36x = mysql_query($query36x, $mysql_link) or die ("#50 Could not query: ".mysql_error());
                $rowcnt36x = mysql_num_rows($mysql_data36x);
                while($row36x = mysql_fetch_row($mysql_data36x)) {
				          $todate_iteration_cnt_2  = stripslashes($row36x[0]);
                }
				$todate_iteration_cnt_3   = $todate_iteration_cnt + $todate_iteration_cnt_2;
                $total_baseline           = $total_baseline + $ybaseline_time;
                $total_incremental        = $total_incremental + $yincremental_time;
				(float)$total_base_var    = $total_base_var + $ybase_variance;
				(float)$total_incr_var    = $total_incr_var + $yincremental_variance;
                print("           
                       <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                        <font color=\"#330099\"> 
                         $ymilestone_seq
                        </font> 
                       </td>-->
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFCC\" width=\"100px\" style=\"font-size: 10px;\">
                         <input type=\"hidden\"  name=\"yexecution_id\"                         value=\"$yid\">
                         <input type=\"hidden\"  name=\"ymilestone[$yid][$zid]\"                value=\"$ymilestone\">
                         <input type=\"hidden\"  name=\"ymilestone_id[$yid][$zid]\"             value=\"$ymilestone_id\">
						 <input type=\"hidden\"  name=\"prv_baseline_time[$yid][$zid]\"         value=\"$ybaseline_time\">
						 <input type=\"hidden\"  name=\"prv_incremental_time[$yid][$zid]\"      value=\"$yincremental_time\">
						 <input type=\"hidden\"  name=\"prv_total_time[$yid][$zid]\"            value=\"$ytotal_time\">
						 <input type=\"hidden\"  name=\"prv_occurance[$yid][$zid]\"             value=\"$yoccurance\">
						 <input type=\"hidden\"  name=\"prv_iteration_cnt[$yid][$zid]\"         value=\"$yiteration_cnt\">
						 <input type=\"hidden\"  name=\"prv_base_variance[$yid][$zid]\"         value=\"$ybase_variance\">
						 <input type=\"hidden\"  name=\"prv_incremental_variance[$yid][$zid]\"  value=\"$yincremental_variance\">
						 <input type=\"hidden\"  name=\"prv_adjust_occurance[$yid][$zid]\"      value=\"$yadjust_occurance\">
						 <input type=\"hidden\"  name=\"ymilestone_type[$yid][$zid]\"           value=\"$ymilestone_type\">
						 <input type=\"hidden\"  name=\"ymilestone_time[$yid][$zid]\"           value=\"$ymilestone_time\">
						 <input type=\"hidden\"  name=\"ytotal_iteration_cnt[$yid][$zid]\"      value=\"$todate_iteration_cnt_3\">
						 <input type=\"hidden\"  name=\"prv_retrofit_parity[$yid][$zid]\"       value=\"$yretrofit_parity\">
                        <font color=\"#330099\"> 
                         $ymilestone
                        </font> 
                       </td>
	            ");
				//print($yid." - ".$zid." - ".$ymilestone_type." - ".$ymilestone_type." - ".$ybaseline_time." - ".$yincremental_time." - ".$ytotal_time." - ".$yoccurance."<br>");
                //////////////////////////////////////
                /// Rework				
                ////////////////////////////////////// 
				//Base
				if (strlen($ybase_hrs) == 1){
				    $ybase_hrs_x = "0".$ybase_hrs;
				} else {
				    $ybase_hrs_x = $ybase_hrs;
				}
				//print($ybase_hrs_x);
				if (strlen($ybase_mins) == 1){
				    $ybase_mins_x = "0".$ybase_mins;
				} else {
				    $ybase_mins_x = $ybase_mins;
				}
				/////////////////
				if (strlen($ymilestone_hrs) == 1){
				    $ymil_hrs_x2 = "0".$ymilestone_hrs;
				} else {
				    $ymil_hrs_x2 = $ymilestone_hrs;
				}
				//print($ybase_hrs_x);
				if (strlen($ymilestone_mins) == 1){
				    $ymil_mins_x2 = "0".$ymilestone_mins;
				} else {
				    $ymil_mins_x2 = $ymilestone_mins;
				}
				//print(" : ".$ybase_mins_x."<br>");
				if ($ymilestone_type == "F"){
                    print("				
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"font-size: 10px;\">
                            <font color=\"#330099\">
							 <!--$ybase_hrs_x : $ybase_mins_x-->
                              $ymil_hrs_x2 : $ymil_mins_x2							 
                            </font> 
                           </td>
					       <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"font-size: 10px;\">
                            <font color=\"#330099\">
                             <select align=\"center\" name=\"yiteration_cnt[$yid][$zid]\">							
					");
			        for ($itc=0;$itc<=15; ++$itc) {
                         print("<option value=\"$itc\">$itc</option> ");
                    }  
                    print("					
							 </select> 
                            </font> 
                           </td>
                    ");
			    }
			    if ($ymilestone_type == "V"){
                   print(" 				   
			           <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" width=\"100px\" style=\"font-size: 10px;\">
					    <font color=\"#330099\">
				        <select align=\"center\" name=\"ymilestone_hrs[$yid][$zid]\">
				   ");		
				   //for ($hr=0;$hr<=24; ++$hr) {
			       for ($hr=0;$hr<=12; ++$hr) {
				        if ($hr == 0){
						  print("<option selected value=\"$hr\">$hr</option> "); 
						} else {
                          print("<option value=\"$hr\">$hr</option> ");
                        }						
                   }                         
                   print("
                            </select>
                           <!--</td>				 
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">-->
				            &nbsp&nbsp:&nbsp&nbsp		   
				            <select align=\"center\" name=\"ymilestone_min[$yid][$zid]\">
                   ");
                   for ($mn=0;$mn<=59; ++$mn) {
 				        if ($mn == 0){
						  print("<option selected value=\"$mn\">$mn</option> "); 
						} else {
                          print("<option value=\"$mn\">$mn</option> ");
                        }						
                   }
                   print("</font>
                        </select>
	                   </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"font-size: 10px;\">
					    <input type=\"hidden\" name=\"yiteration_cnt[$yid][$zid]\" value=\"$yiteration_cnt\">
                        <font color=\"#330099\"> 
						 +1
                        </font> 
                       </td>
                       <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\">
                         $todate_iteration_cnt_3							
                        </font> 
                       </td>-->
                  ");				  
                } else {
			        if ($ymilestone_type == "N"){
			            print("
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                            <font color=\"#330099\">
                            </font> 
                           </td>
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                            <font color=\"#330099\"> 
                            </font> 
                           </td>
                        ");				   
				    }
                }
				//Increment
				if (strlen($yincr_hrs) == 1){
				    $yincr_hrs_x = "0".$yincr_hrs;
				} else {
				    $yincr_hrs_x = $yincr_hrs;
				}
				//print($yincr_hrs_x);
				if (strlen($yincr_mins) == 1){
				    $yincr_mins_x = "0".$yincr_mins;
				} else {
				    $yincr_mins_x = $yincr_mins;
				}
				//Totals
				if (strlen($ytotal_hrs) == 1){
				    $ytotal_hrs_x = "0".$ytotal_hrs;
				} else {
				    $ytotal_hrs_x = $ytotal_hrs;
				}
				//print($ytotal_hrs_x);
				if (strlen($ytotal_mins) == 1){
				    $ytotal_mins_x = "0".$ytotal_mins;
				} else {
				    $ytotal_mins_x = $ytotal_mins;
				}
				//print(" : ".$ytotal_mins_x."<br>");
                print("
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ybase_hrs_x : $ybase_mins_x 
                        </font> 
                      </td>
                      <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ybase_variance%
                        </font> 
                      </td>-->
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $yincr_hrs_x : $yincr_mins_x 
                        </font> 
                      </td>
					  <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $yincremental_variance%
                        </font> 
                      </td>-->
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ytotal_hrs_x : $ytotal_mins_x 
                        </font> 
                      </td>
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                       <font color=\"#330099\">
                        $todate_iteration_cnt_3							
                       </font> 
                      </td>
                      <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                        </font> 
                      </td>-->
				");
				//if ($eseq_a == 0){
				if ($todate_iteration_cnt_3 == 0){
				    print("
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
					    <input type=\"hidden\" name=\"yajustment[$yid][$zid]\" value=\"NULL\">
                        <font color=\"#330099\"> 
                        </font> 
                      </td>
					");  
				} else {
				    if ($new_parity_cnt <> 0){                                                    //($yretrofit_parity == "N"){ 
                         print("				
				         	  <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"font-size: 10px;\">
                                <font color=\"#330099\">
                                 <select align=\"center\" name=\"yajustment[$yid][$zid]\">							
 				         ");
			             for ($his=0;$his<=$eseq_a; ++$his) {
						      if ($his == 0){
							      $mil_row_flag[$his] = "NULL";
							  }
							  //if ($row_milflg[$his] == "V"){
							      if ($his <> 0){
								   //print("I am here3<br>");
							          if ($his == $eseq_a){
								          $row_incr_delta[$his]       = $row_incr[$his];      
								      } else {
									    if ($row_parity[$his] == "X"){    
										    $row_incr_delta[$his]       = $row_incr[$his];
											//print("I am here<br>");
											print($row_incr[$his]."<br>");
										} else {
										  //print("I am here2<br>");
								          $his2                       = $his + 1;                          // Next row in array
								          $row_incr_delta[$his]       = $row_incr[$his]-$row_incr[$his2];  // Cummulative of this row minus commulative of next row gives you delta of incremental
										}
                                      }								  
							          $row_incr_hrs[$his]         = intval($row_incr_delta[$his]/60);
                                      $row_incr_mins[$his]        = $row_incr_delta[$his]%60;
								      //assemble $mil_history_rows[$his]
							          //$mil_history_rows[$his]  = $row_occr[$his]." | ".$row_itcnt[$his]." | ".$row_incr_hrs[$his].":".$row_incr_mins[$his]." - ".$row_adjust[$his];
					                  if (strlen($row_incr_hrs[$his]) == 1){
					                      $row_incr_hrs_x[$his] = "0".$row_incr_hrs[$his];
					                  } else {
									      $row_incr_hrs_x[$his] = $row_incr_hrs[$his];
									  }
					                  if (strlen($row_incr_mins[$his]) == 1){
					                      $row_incr_mins_x[$his] = "0".$row_incr_mins[$his];
					                  } else {
									      $row_incr_mins_x[$his] = $row_incr_mins[$his];
									  }
							          $mil_history_rows[$his]  = $row_itcnt[$his]." | ".$row_incr_hrs_x[$his].":".$row_incr_mins_x[$his]." | ".$row_occr[$his];
							      }
							  //}
						      if ($his <> $eseq_a){    // do not display the 0 occurance entry; $eseq_a begins with 0 which is the initial occurance when a record is created in milestone_surrogate table.
							      if ($row_adjust[$his] <> 0){
                                      //print("<option disabled=\"disabled\" value=\"$mil_row_flag[$his]\" style=\"color: #CCCCCC; background-color: #000000;\">$mil_history_rows[$his]</option> ");
								  } else {
								    if ((($row_parity[$his] == "N" or $row_parity[$his] == "X") and ($row_itcnt[$his] <> 0)) or ($his == 0)){                                   // and ($his <> 0)
								         print("<option value=\"$mil_row_flag[$his]\">$mil_history_rows[$his]</option> ");
									}  
								  }
							  }	 
                         }  
                         print("					
				                 </select> 
                                </font> 
                               </td>
				         ");
					} else {
				      print("
                         <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
					      <input type=\"hidden\" name=\"yajustment[$yid][$zid]\" value=\"NULL\">
                          <font color=\"#330099\"> 
                          </font> 
                         </td>
					  ");  
                    }					
                }
                print("				
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $yupdated_by
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $yupdated_on
                        </font> 
                     </td>
                     <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"update3[$zid]\" value=\"Update3\">
                     </td>
                    </tr>
                ");
           }
           if ($total_incremental == 0){
			  $incr_hrs             = 0;
			  $incr_mins            = 0;
              $percent_incremental  = 0;	
			  $percent_incremental2 = 0;
	       } else {
	          $incr_hrs           = intval($total_incremental/60);      //derives hours 
              $incr_mins          = $total_incremental%60;              // derives minutes beyond 60 but less then 60 in the last hour
			  if ($total_baseline == 0){
			      $percent_incremental  = 0; 
			  } else {
			    $net_total = $total_incremental+ $total_baseline;
                $percent_incremental  = round(((($net_total/$total_baseline)-1) * 100),2) ;
              }			  
	       }
	       if ($total_baseline == 0){
		       $percent_baseline    = 0;
			   $base_hrs            = 0;
			   $base_mins           = 0; 
	       } else {
               $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
	           $base_hrs            = intval($total_baseline/60);      //derives hours 
               $base_mins           = $total_baseline%60;              // derives minutes beyond 60 but less then 60 in the last hour
           }
		   $total_time              = $total_baseline + $total_incremental;
		   if ($total_time == 0){
		       $total_time          = 0; 
			   $total_hrs           = 0;
			   $total_mins          = 0;
			   $percent_total       = 0;
			   (float)$net_base_var = 0;
			   (float)$net_incr_var = 0;
		   } else {
	           $total_hrs           = intval($total_time/60);      //derives hours 
               $total_mins          = $total_time%60;              // derives minutes beyond 60 but less then 60 in the last hour
			   $percent_total       = round((($total_time / $total_baseline) * 100),2);
			   (float)$net_base_var = round($total_base_var/$eseq,2);
			   (float)$net_incr_var = round($total_incr_var/$eseq,2);
		   }
		   //Aggregate Sum - Base
		   if (strlen($base_hrs) == 1){
			  $base_hrs_x = "0".$base_hrs;
		   } else {
			  $base_hrs_x = $base_hrs;
		   }
		   //print($total_hrs_x);
		   if (strlen($base_mins) == 1){
			   $base_mins_x = "0".$base_mins;
		   } else {
			   $base_mins_x = $base_mins;
		   }	
		   //print(" : ".$total_mins_x."<br>");
		   //Aggregate Sum - Incremental
		   if (strlen($incr_hrs) == 1){
			  $incr_hrs_x = "0".$incr_hrs;
		   } else {
			  $incr_hrs_x = $incr_hrs;
		   }
		   //print($total_hrs_x);
		   if (strlen($incr_mins) == 1){
			   $incr_mins_x = "0".$incr_mins;
		   } else {
			   $incr_mins_x = $incr_mins;
		   }	
		   //print(" : ".$total_mins_x."<br>");
		   //Aggregate Sum - Total
		   if (strlen($total_hrs) == 1){
			  $total_hrs_x = "0".$total_hrs;
		   } else {
			  $total_hrs_x = $total_hrs;
		   }
		   //print($total_hrs_x);
		   if (strlen($total_mins) == 1){
			   $total_mins_x = "0".$total_mins;
		   } else {
			   $total_mins_x = $total_mins;
		   }	
		   //print(" : ".$total_mins_x."<br>");
           print("
                  <tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"4\">
                    <font color=\"#0000FF\"> 
                     <strong>Total</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $base_hrs_x : $base_mins_x
                    </font> 
                   </td>
				   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $incr_hrs_x : $incr_mins_x
                    </font> 
                   </td>
				   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $total_hrs_x : $total_mins_x
                    </font> 
                   </td>
				  </tr>
				  <tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"4\">
                    <font color=\"#0000FF\"> 
                     <strong>Percentage Effort</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $percent_baseline%
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $percent_incremental%
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $percent_total%
                    </font> 
                   </td>
				  </tr>
           ");
       }       //}
       // ---------------------------------------------------
       }
       //$zrunning_log = nl2br($yrunning_com);
       //$zrunning_log = str_replace("<br>", "\n\n", $yrunning_com);
       //print($zit);
       // Submit options options
       print(" <tr>
                <td>
                </td colspan=\"6\" bgcolor=\"#FFFFF0\">
               </tr>
               <tr>
                <td align=\"center\" valign=\"middle\" colspan=\"6\"  bgcolor=\"#FFFFF0\">
                 <input type=\"submit\" name=\"submit\"        value=\"Submit\"> 
                 <input type=\"hidden\" name=\"start\"         value=\"1\">
                 <input type=\"hidden\" name=\"area_cnt\"      value=\"$rowcnty2\">
                 <input type=\"hidden\" name=\"pdpid\"         value=\"$xid\">
                 <input type=\"hidden\" name=\"update1[$xid]\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update2[$yid]\" value=\"$yid\">
                 <input type=\"hidden\" name=\"$itcnt\"        value=\"$zit\">
                </td>
               </tr>
              </table>
       ");
	   //$ex = 1;
	   for ($ex=1;$ex<=1;++$ex) { 
	        if ($err_check[$ex] <> 0 || $act_err_check[$ex] <> 0){
	   	        //$err_msg = $date_check_msg."\n".$act_date_check_msg;
	   	        echo "<script type=\"text/javascript\">window.alert('WARNING FOR PLANNED AND ACTUAL DATE SETTINGS (dd-mm-yyyy)\\n\\n'+'$date_check_msg[$ex]'+'$act_date_check_msg[$ex]'+'\\nNOTES:\\n'+'\\nPLANNED DATES ARE ORIGINAL PDP START AND END DATES, SET IT ONCE AND DO NOT CHANGE'+'\\nACTUAL DATES ARE USED WHEN ORIGINAL DATES ARE CHANGED, WHEN LEFT DEFAULT THEY WILL BE SET SAME AS NON-DEFAULT PLANNED DATES'+'\\nACTUAL DAYS UTILIZED AND EFFORT IN DAYS % ARE DERIVED FROM ACTUAL DATES, NOT PLANNED DATES'+'\\n\\nPLEASE MAKE CHANGES WHERE REQUIRED')</script>";
	        }
	        if ($err_check_3[$ex] <> 0){
	            //$err_check_3_msg
	            echo "<script type=\"text/javascript\">window.alert('WARNING FOR ACTUAL DAYS UTILIZED DUE TO CHANGE IN ACTUAL DATES\\n\\n'+'$err_check_3_msg[$ex]'+'\\n\\nPLEASE MAKE CHANGES WHERE REQUIRED')</script>";
	        }
			//'$err_check_3[$ex]\\n'+
	   }
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
   print("<form method=\"post\" action=\"./executioncontrol_uat_x.php\">
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
