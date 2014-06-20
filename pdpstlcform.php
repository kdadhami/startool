<?php

// ----------------------------
// Author: Kashif Adhami
// Dated: November, 2010
// ----------------------------


// Connection
require_once("./inc/connect.php");

// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
$querys5 = "SELECT user FROM ".$name.".sessions
                WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)) FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($yissue_area_id);
       }
}
//$trans = "loop";
// ==============================

// ============================== MILESTONE TYPE ================================
$mil_type[1]     = "Fixed";
$mil_type_val[1] = "F";
$mil_type[2]     = "Variable";
$mil_type_val[2] = "V";
$mil_type[3]     = "None";
$mil_type_val[3] = "N";
// ==============================================================================


// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
                  where issue_area_ind = 1 
                    and issue_area_id  = '$uissue_area_id'
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
}
//print("<br><br>");
// =============================== DEPARTMENT END ===============================

if ($submit == "Submit") {
if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_milestone[$key]       = addslashes(strtoupper($new_milestone[$key]));
	        //$new_milestone_ind[$key] = addslashes(strtoupper($new_milestone_ind[$key]));
	        $new_milestone_hrs[$key]   = addslashes($new_milestone_hrs[$key]);
			$new_milestone_min[$key]   = addslashes($new_milestone_min[$key]);
			$new_milestone_type[$key]  = addslashes($new_milestone_type[$key]);
	        $new_milestone_seq[$key]   = addslashes($new_milestone_seq[$key]);
	        $new_issue_area_id[$key]   = addslashes($new_issue_area_id[$key]);
			$new_milestone_time[$key]  = ($new_milestone_hrs[$key]*60) + $new_milestone_min[$key];
			//print($new_milestone_time[$key]);
	        
	        //if ($new_milestone_time[$key] > 99.99){
            //    $new_milestone_time[$key] = (float)0.00;
	        //}
	       
	        //if ($new_milestone_seq[$key] > 99.99){
            //    $new_milestone_seq[$key] = (float)0.00;
	        //}	        

             $queryh = "SELECT UPPER(trim(milestone)) 
                          FROM ".$name.".pdp_stlc 
                         WHERE  UPPER(trim(milestone)) = '$new_milestone[$key]'
                           AND  issue_area_id          = '$uissue_area_id'
                       ";
             //print($queryh);
             $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#1 Could not query: ".mysql_error());
             $rowcnth = mysql_num_rows($mysql_datah);

             if ($rowcnth > 0) {
                 $insert_ind = 1;
             } else {
                 $insert_ind = 0;
             }

            if ($insert_ind == 0) { 
            $query ="INSERT into ".$name.".pdp_stlc(milestone,milestone_ind,milestone_time,milestone_seq,issue_area_id,milestone_type)
                     VALUES('$new_milestone[$key]',1,'$new_milestone_time[$key]','$new_milestone_seq[$key]','$new_issue_area_id[$key]','$new_milestone_type[$key]')";

            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
            } else {
              echo "<script type=\"text/javascript\">window.alert(\"Work Activity '$new_milestone[$key]' for '$uissue_area' already exists\")</script>";
            }
           }
}

if (isset($update)) {
    while (list($key) = each($update)) {
	       $xid[$key]             = addslashes($xid[$key]);
	       $xmilestone[$key]      = addslashes(strtoupper($xmilestone[$key]));
	       $xmilestone_hrs[$key]  = addslashes($xmilestone_hrs[$key]);
		   $xmilestone_min[$key]  = addslashes($xmilestone_min[$key]);
		   $xmilestone_type[$key] = addslashes($xmilestone_type[$key]);
	       $xmilestone_seq[$key]  = addslashes($xmilestone_seq[$key]);
	       $xissue_area_id[$key]  = addslashes($xissue_area_id[$key]);
		   $xmilestone_time[$key] = ($xmilestone_hrs[$key]*60) + $xmilestone_min[$key];
	       
	       //if ($xmilestone_time[$key] > 99.99){
           //    $xmilestone_time[$key] = (float)0.00;
	       //}
	       
	       //if ($xmilestone_seq[$key] > 99.99){
           //    $xmilestone_seq[$key] = (float)0.00;
	       //}	       
	       
	       //$xmilestone_ind[$key]  = addslashes($xmilestone_ind[$key]);
	       //print($key);

  		   $queryu = "UPDATE ".$name.".pdp_stlc
		                SET milestone      = '$xmilestone[$key]',
                            milestone_ind  = 1,
                            milestone_time = '$xmilestone_time[$key]',
							milestone_type = '$xmilestone_type[$key]',
                            milestone_seq  = '$xmilestone_seq[$key]',
                            issue_area_id = '$xissue_area_id[$key]'
		              WHERE milestone_id = '$key'";

		$mysql_datau = mysql_query($queryu, $mysql_link) or die ("Could not query: ".mysql_error());


		
		
		/// Retrofit Start to preserve old time for milestone_surrogates
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
		
		if ($uissue_area == 'ENTERPRISE UAT'){
            $query9 = "select area_execution_id,pdp_id,issue_area_id
                         from ".$name.".area_execution   
                        where issue_area_id = '$uissue_area_id'
                       order by pdp_id,area_execution_id ";
            $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#1.Retrofit Could not query: ".mysql_error());
            $rowcnt9 = mysql_num_rows($mysql_data9);    

            $tbl[1][1] = "area_execution";
            $tbl[1][2] = 1;
            $idx[1][1] = "index_area_execution";
            $kee[1][1] = "pdp_id".","."issue_area_id".","."test_iteration"; 
 
            $tbl[2][1] = "area_execution";
            $tbl[22][2] = 3;
            $idx[2][1] = "index_area_execution_2";
            $kee[2][1] = "pdp_id".","."execution_id".","."milestone_id"; 

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

			
			
            $e = 0;
            if ($rowcnt9 == 1){
                while($rowx9 = mysql_fetch_row($mysql_data9)) {
                  $e = $e + 1;
				  $yarea_execution_id = stripslashes($rowx9[0]);
                  $xstart_date[$key2][$e]     = mktime(0,0,0,$xms[$key2][$e],$xds[$key2][$e],$xys[$key2][$e]);
                  $xend_date[$key2][$e]       = mktime(0,0,0,$xme[$key2][$e],$xde[$key2][$e],$xye[$key2][$e]);
                  $xact_start_date[$key2][$e] = mktime(0,0,0,$xmab[$key2][$e],$xdab[$key2][$e],$xyab[$key2][$e]);
                  $xact_end_date[$key2][$e]   = mktime(0,0,0,$xma[$key2][$e],$xda[$key2][$e],$xya[$key2][$e]);
				  $st_dt                      = $xds[$key2][$e]."-".$xms[$key2][$e]."-".$xys[$key2][$e];
				  $end_dt                     = $xde[$key2][$e]."-".$xme[$key2][$e]."-".$xye[$key2][$e];
				  $ast_dt                     = $xdab[$key2][$e]."-".$xmab[$key2][$e]."-".$xyab[$key2][$e];
				  $aend_dt                    = $xda[$key2][$e]."-".$xma[$key2][$e]."-".$xya[$key2][$e];

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
				  
                  if ($date_check[$e] ==2 && $act_date_check[$e] == 1){
				      $xact_start_date[$key2][$e] = $xstart_date[$key2][$e];
                      $xact_end_date[$key2][$e]   = $xend_date[$key2][$e]; 
				  }	

                  				  
				  
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

                                $tracesql  = "INSERT into ".$name.".area_execution_archive(pdp_id,issue_area_id,test_iteration,start_date,end_date,actual_start_date,actual_end_date,actual_testing_days,actual_weekend_days,back_to_build,updated_by,area_execution_id)
                                              VALUES('$pdpid','$uissue_area_id','$e','$nstart_date','$nend_date','$nact_start_date','$nact_end_date','$nactual_testing_days','$nactual_weekend_days','$nback_to_build','$usr','$yarea_execution_id')";
                                $mysql_tracesql = mysql_query($tracesql, $mysql_link) or die ("#trace2 Could not query: ".mysql_error());
               }
            } 
        }

		/// Retrofit End to preserve old time for milestone_surrogates
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
	}
}

if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".pdp_stlc
		              SET milestone_ind  = 1
		            WHERE milestone_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".pdp_stlc
		              SET milestone_ind  = 0
		            WHERE milestone_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".pdp_stlc WHERE milestone_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}
$captn = "PDP Work";
// Start of HTMl
print("<html>
        <head>
          <!--<link rel=\"stylesheet\" type=\"text/css\" href=\"css/common.css\">-->
           <style>
             body { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px; 
                  }
               td { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                    color: #FFFFFF; 
                  }
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
           select { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }                   
           #content
                  { top:0%;
                  }
           </style> 
        </head>
        <body>
           <form method=\"post\" action=\"./pdpstlcform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\" style=\"width: 50px\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 50px\"><font color=\"#330099\">ID</font></th>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Department</font</td>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 75px\"><font color=\"#330099\">Order<br>99.99</font></td>               
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 150px\"><font color=\"#330099\">PDP Work Activities</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 75px\"><font color=\"#330099\">Incremental Duration</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 75px\"><font color=\"#330099\">Time<br>(Hrs)<br>(0-24)</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 75px\"><font color=\"#330099\">Time<br>(Min)<br>(0-59)</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "   select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq,issue_area_id,milestone_type
               from ".$name.".pdp_stlc
              where issue_area_id = '$uissue_area_id'  
           order by issue_area_id,milestone_ind desc, milestone_seq asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;
		
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

    $xid             = stripslashes($row[0]);
    $xmilestone      = stripslashes($row[1]);
    $xmilestone_ind  = stripslashes($row[2]);
    $xmilestone_time = stripslashes($row[3]);
    $xmilestone_seq  = stripslashes($row[4]);
    $xissue_area_id  = stripslashes($row[5]);
    //$xmilestone_min  = stripslashes($row[6]);
    $xmilestone_type = stripslashes($row[6]);
	$xmilestone_hrs  = intval($xmilestone_time/60);   //derives hours 
    $xmilestone_min  = $xmilestone_time%60;           // derives minutes beyond 60 but less then 60 in the last hour
	//$xymilestone_time = ($xmilestone_hrs * 60) + $xmilestone_min;   // total time in min
    //$xmilestone_ind[$key]  = addslashes($xmilestone_ind[$key]);

    $query1 = "select milestone_id from ".$name.".milestone_surrogates where milestone_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xmilestone_ind == 1) {

	   print("<tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xissue_area_id[$xid]\">--> 
       ");
       $w = 0;
       for ($w=1;$w<=$dcnt; ++$w) {
            if ($did[$w] == $xissue_area_id) {
                //print(" <option selected value=\"$did[$w]\">$dpt[$w]</option> ");
	            print(" <font color=\"#000000\"> 
                         $dpt[$w]
                        </font>
                        <input type=\"hidden\" name=\"xissue_area_id[$xid]\" value=\"$did[$w]\">
                ");                         
            }
            //else {
            //    print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
            //}
       }
	   
       print("   <!--</select>-->
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <input type=\"text\" name=\"xmilestone_seq[$xid]\" value=\"$xmilestone_seq\" size=\"5\" maxlength=\"5\">
	            </td>	            
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <input type=\"text\" name=\"xmilestone[$xid]\" value=\"$xmilestone\" size=\"50\" maxlength=\"50\">
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <select align=\"center\" name=\"xmilestone_type[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($mx=1;$mx<=3; ++$mx) {
            if ($xmilestone_type == $mil_type_val[$mx]) {
                print("<option selected value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> "); 
            } else {
                print("<option value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> ");    
            }   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <select align=\"center\" name=\"xmilestone_hrs[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($hr=0;$hr<=24; ++$hr) {
            if ($xmilestone_hrs == $hr) {
                print("<option selected value=\"$hr\">$hr</option> "); 
            } else {
                print("<option value=\"$hr\">$hr</option> ");    
            }   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <select align=\"center\" name=\"xmilestone_min[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($mn=0;$mn<=59; ++$mn) {
            if ($xmilestone_min == $mn) {
                print("<option selected value=\"$mn\">$mn</option> "); 
            } else {
                print("<option value=\"$mn\">$mn</option> ");    
            }   
       }                         
       print("
                 </select>
                </td>				 
	   ");

	    if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    </td>                
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                     print("
                             <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 } 
        } else {
             print("
                </td>
	            <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                </td>
                    ");
        }
        print("
	            <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                 <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	          </tr>
	     ");
    
    } else {
	   print("
              <tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                  $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                  $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xissue_area_id[$xid]\">--> 
       ");
       $w = 0;
       for ($w=1;$w<=$dcnt; ++$w) {
            if ($did[$w] == $xissue_area_id) {
                //print(" <option selected value=\"$did[$w]\">$dpt[$w]</option> ");
	            print(" <font color=\"#000000\"> 
                         $dpt[$w]
                        </font> 
                ");                
            } 
            // else {
            //    //print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
            //}
       }
       print("   <!--</select>-->
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\"> 
                   $xmilestone_seq
                 </font>
	            </td>
                <td align=\"left\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\"> 
                   $xmilestone
                 </font>
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <!--<select align=\"center\" name=\"xmilestone_type[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">-->
       ");
       for ($mx=1;$mx<=3; ++$mx) {
            if ($xmilestone_type == $mil_type_val[$mx]) {
                //print("<option selected value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> ");
                print("
	             <font color=\"#000000\"> 
                   $mil_type[$mx]
                 </font>
				"); 				
            } else {
                //print("<option value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> ");    
            }   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <!--<select align=\"center\" name=\"xmilestone_time[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">-->
       ");
       for ($hr=0;$hr<=24; ++$hr) {
            if ($xmilestone_hrs == $hr) {
                //print("<option selected value=\"$hr\">$hr</option> "); 
                print("
	             <font color=\"#000000\"> 
                   $xmilestone_hrs
                 </font>
				"); 				
				} else {
                //print("<option value=\"$hr\">$hr</option> ");    
            }   
       }                         
       print("
                 <!--</select>-->
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				 <!--<select align=\"center\" name=\"xmilestone_min[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">-->
       ");
       for ($mn=0;$mn<=59; ++$mn) {
            if ($xmilestone_min == $mn) {
                //print("<option selected value=\"$mn\">$mn</option> "); 
                print("
	             <font color=\"#000000\"> 
                   $xmilestone_min
                 </font>
				"); 				
 		    } else {
                //print("<option value=\"$mn\">$mn</option> ");    
            }   
       }                         
       print("
                 </select>
	            </td>	            
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                    </td> 
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                        <input type=\"checkbox\" name=\"active[$xid]\" value=\"Active\">
                    </td>
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                      print("
                             <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 }
                }
          else {
                 print("<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                        </td>
                  ");
                }
        print("
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
	          </tr>
	     ");
    
    }
}

// Display blank entry for a new record to be inserted
if ($submit == "Add") {
    for ($x=1;$x<=$num_records; ++$x) {
		 print("
                <tr>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
		          </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
		          </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                   <!--<select align=\"center\" name=\"new_issue_area_id[$x]\">--> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
	            print(" <font color=\"#000000\"> 
                         $dpt[$w]
                        </font>
                        <input type=\"hidden\" name=\"new_issue_area_id[$x]\" value=\"$did[$w]\">
                ");                         
          }
          print("   <!--</select>-->
                   </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_milestone_seq[$x]\" value=\"$new_milestone_seq[$x]\" size=\"5\" maxlength=\"5\">
		          </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_milestone[$x]\" value=\"$new_milestone[$x]\" size=\"50\" maxlength=\"50\">
		          </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
				 <select align=\"center\" name=\"new_milestone_type[$x]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($mx=1;$mx<=3; ++$mx) {
            //if ($xmilestone_type == $mil_type_val[$mx]) {
            //    print("<option selected value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> "); 
            //} else {
                print("<option value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> ");    
            //}   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
				 <select align=\"center\" name=\"new_milestone_hrs[$x]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($hr=0;$hr<=24; ++$hr) {
            //if ($xmilestone_time == $hr) {
                //print("<option selected value=\"$hr\">$hr</option> "); 
            //} else {
                print("<option value=\"$hr\">$hr</option> ");    
            //}   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
				 <select align=\"center\" name=\"new_milestone_min[$x]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($mn=0;$mn<=59; ++$mn) {
            //if ($xmilestone_min == $mn) {
                //print("<option selected value=\"$mn\">$mn</option> "); 
            //} else {
                print("<option value=\"$mn\">$mn</option> ");    
            //}   
       }                         
       print("
                 </select>
                </td>				 
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>                  
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                       <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
		        </tr>
		      ");
	}
}

// Display options
print("
            </table>

            <table border='0' align=\"center\">
                <tr>
                 <td>
                   <br />
     ");
print("            <input type=\"submit\" name=\"submit\" value=\"Submit\">
     ");

// Select no. of new inserts
if ($submit != "Add") {
    print("
                   <input type=\"submit\" name=\"submit\" value=\"Add\">
                    <select name =\"num_records\">
                      <option value=\"1\">1</optons>
                      <option value=\"2\">2</optons>
                      <option value=\"3\">3</optons>
                      <option value=\"4\">4</optons>
                      <option value=\"5\">5</optons>
                    </select>
          ");
}

// End of HTML
print("
                 </td>
                </tr>
            </table>
           </form>
          </body>
         </html>
     ");
?>
