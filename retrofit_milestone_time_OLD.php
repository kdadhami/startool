<?php

// --------------------------------------------------------------------------
// Author: Kashif Adhami
// Dated: September, 2011
// Revisions: October, 2011
// --------------------------------------------------------------------------
// This program helps to retrofit work effort time after the new change 
// of keeping work effort. 
// OLD Logic: Work Activity had iterations, 0 for baseline, +0 for iteration
// New Logic: Work Activity will have three types, Fixed, Variabel, None
// Fixed Work Activity: will be like old
// Variable Work Activity: will require user to enter time manullay in mins 
//                         for each iteration of variable work activity
// None Work Activity: Is not tracked in time
// --------------------------------------------------------------------------


// Connection
require_once("./inc/connect.php");
set_time_limit(0);

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
// Retrofit Date
$retro_cutoff_dt = 1314849600;
$rd              = date("d",$retro_cutoff_dt);
$rm              = date("M",$retro_cutoff_dt);
$ry              = date("Y",$retro_cutoff_dt);
$rdt             = $rd."-".$rm."-".$ry;
print("RETROFIT CUTOFF IS: ".$rdt."<br><br><br>");

//=======================
// Loading PDP Milestones
//=======================
$query31      = "   select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq,issue_area_id,milestone_type
                      from ".$name.".pdp_stlc 
                     where issue_area_id = '$uissue_area_id'
                       and milestone_ind = 1 
                  order by milestone_ind desc, milestone_seq asc";
$mysql_data31 = mysql_query($query31, $mysql_link) or die ("#24 Could not query: ".mysql_error());
$rowcnt31         = mysql_num_rows($mysql_data31);
$mil_cnt          = 0;
while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt                      = $mil_cnt + 1;
      $mil_id[$mil_cnt]             = stripslashes($row31[0]);
      $mil[$mil_cnt]                = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]            = stripslashes($row31[2]);
      $mil_time[$mil_cnt]           = intval(stripslashes($row31[3]));
      $mil_seq[$mil_cnt]            = (float)stripslashes($row31[4]);
	  $mil_issue_area_id[$mil_cnt]  = (float)stripslashes($row31[5]);
	  $mil_type[$mil_cnt]           = stripslashes($row31[6]);
      //print($mil_id[$mil_cnt]."-".$mil[$mil_cnt]."-".$mil_ind[$mil_cnt]."-".$mil_time[$mil_cnt]."-".$mil_seq[$mil_cnt]."<br>");
}


// ============================== DEPARTMENT START ==============================
       $queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                          from ".$name.".issue_areas
                         where issue_area_ind = 1 
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
             // Iteration are setup like this (hardcoded for now, unless there is a point to decomission pdp_testing table and replace ra_ind with another alternative.
             if ($dsc[$dcnt] == "CMGT"){
                 $dit[$dcnt] = 2;
             } else {
                 $dit[$dcnt] = 1;
             }
             //print($dcnt." - ".$dpt[$dcnt]." - ".$dind[$dcnt]." - ".$dti[$dcnt]." - ".$dind[$dcnt]." - ".$dit[$dcnt]."<br>");
       }
       print("<br><br>");
// =============================== DEPARTMENT END ===============================



//============================================================================
//============================================================================
//============================================================================

		/// Retrofit Start to preserve old time for milestone_surrogates
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////

		// Reindexing area_execution table
        $tbl[1][1] = "milestone_surrogates";
        $tbl[1][2] = 1;
        $idx[1][1] = "index_milestone_surrogates_1";
        $kee[1][1] = "execution_id".","."milestone_id"; 

        print("Start of Rebuilding Indexes<br>");

        for ($x=1;$x<=1;++$x) {
                 $tbl_name  = $tbl[$x][1];
                 $idx_count = $tbl[$x][2];
                 print($tbl_name."<br>".$idx_count."<br>"."<br>");
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
        print("End of Rebuilding Indexes<br>");
        print("<br>");
		// Reindex done
        print("<br><br><br>START OF RETROFIT RUN<br><br>");
		
		//if ($uissue_area == 'ENTERPRISE UAT'){
            $query9 = "select a.area_execution_id,a.pdp_id,a.issue_area_id,b.issue_area,c.pdp_desc,c.pdp_launch
                         from ".$name.".area_execution a, issue_areas b, pdp c 
                        where a.issue_area_id = b.issue_area_id
						  and a.pdp_id        = c.pdp_id
                       order by a.pdp_id,a.area_execution_id ";
            $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#1.Retrofit Could not query: ".mysql_error());
            $rowcnt9 = mysql_num_rows($mysql_data9);
			print("<br>".$query9."<br>");
            print("<br>Total Rows Found: ".$rowcnt9."<br>");			

            //break;
			
            $e = 0;
            if ($rowcnt9 <> 0){
                while($rowx9 = mysql_fetch_row($mysql_data9)) {
                      $e                          = $e + 1;
				      $yarea_execution_id         = stripslashes($rowx9[0]);
				      $ypdp_id                    = stripslashes($rowx9[1]);
		   		      $yissue_area_id             = stripslashes($rowx9[2]);
					  $yissue_area                = stripslashes($rowx9[3]);
					  $ypdp_desc                  = stripslashes($rowx9[4]);
					  $ypdp_launch                = stripslashes($rowx9[5]);

             		  if (empty($ypdp_launch)){
                              	$ypdp_launch_dt = "NULL";
                              	$ydate = "0000-00-00 00:00:00";
             		  } else {  
                              	$yld            = date("d",$ypdp_launch);
                              	$ylm            = date("M",$ypdp_launch);
                              	$yly            = date("Y",$ypdp_launch);
                              	$ypdp_launch_dt = $yld."-".$ylm."-".$yly;
                              	//$xdate          = date("Y-m-d",$xpdp_launch)." 00:00:00";
             		  }
					  
					  print("============================<br>"."No: ".$e."<br>Execution Id: ".$yarea_execution_id."<br> PDP Id: ".$ypdp_id."<br> Deprartment Id: ".$yissue_area_id."<br>Department: ".$yissue_area."<br>PDP: ".$ypdp_desc."<br>"."PDP Launch: ".$ypdp_launch."<br> PDP Launch Date: ".$ypdp_launch_dt."<br><br>" );
			 		  if ($ypdp_launch >= $retro_cutoff_dt) {
			     				$doretrofit = 1; 
								print("<br><br>PDP Launch Date is in Retrofit Date Range<br><br>");
			 		  } else {
			     				$doretrofit = 0;
								print("<br><br>PDP Launch Date is not in Retrofit Date Range<br><br>");
			 		  }
					  // If the Launch date is after Retrofit cuttoff date		
					  if ($doretrofit == 1) {
							    $f = 0;
							    for ($m=1;$m<=$mil_cnt;++$m) { 
							         if ($mil_issue_area_id[$m] == $yissue_area_id) {
                                         $f = $f + 1;
									     $ymil_time = $mil_time[$m];
										 $ymil_id   = $mil_id[$m];
  			            	             $query12 = "select execution_id,milestone_id,iteration_count
                                         	            from ".$name.".milestone_surrogates   
                                            	       where execution_id = '$yarea_execution_id'
													     and milestone_id = '$ymil_id'";
            	                         $mysql_data12 = mysql_query($query12, $mysql_link) or die ("#2.Retrofit Could not query: ".mysql_error());
            	                         $rowcnt12 = mysql_num_rows($mysql_data12);    
										 if ($rowcnt12 == 0){
                                               $yiteration_count  = 0;
                                               $ymil_base_time    = 0;
                                               $ymil_incr_time    = 0;
                                               $ymil_totl_time    = 0;
                                               $mil_found         = "No";  											   
										 } else { 
                                           while($rowx12 = mysql_fetch_row($mysql_data12)) {
                                               $yiteration_count  = stripslashes($rowx12[2]);
                                               $ymil_base_time    = $ymil_time;
                                               $ymil_incr_time    = $ymil_time * $yiteration_count;
                                               $ymil_totl_time    = $ymil_base_time + $ymil_incr_time; 
											   $mil_found         = "Yes";
                                           }	
                                         }										 
                                         print("Milestone Found: ".$mil_found."||Milestone: ".$mil[$m]."||Type: ".$mil_type[$m]."||Baseline: ".$mil_time[$m]."||Incremental Time: ".$ymil_incr_time."||Total Time: ".$ymil_totl_time."<br>");
										 if ($mil_type[$m] == "F"){
                                             $query11 = "UPDATE ".$name.".milestone_surrogates
                                                            SET updated_by            = '$usr', 
                                                                updated_on            = current_timestamp, 
                                                                baseline_time         = '$ymil_time',  
                                                                incremental_time      = '$ymil_incr_time',
                                                                total_time            = '$ymil_totl_time',
                                                                retrofit_parity       = 'Y',
                                                                retrofit_time         = now()																
                                                         WHERE execution_id           = '$yarea_execution_id' 
                                                           AND milestone_id           = '$ymil_id'";
										 }
										 
										 if ($mil_type[$m] == "V"){
                                             $query11 = "UPDATE ".$name.".milestone_surrogates 
                                                            SET updated_by            = '$usr', 
                                                                updated_on            = current_timestamp, 
                                                                baseline_time         = '$ymil_time',  
                                                                incremental_time      = '$ymil_incr_time',
                                                                total_time            = '$ymil_totl_time', 
                                                                retrofit_parity       = 'Y',
                                                                retrofit_time         = now()																
  														 WHERE execution_id           = '$yarea_execution_id' 
                                                           AND milestone_id           = '$ymil_id'";
										 }

 										 if ($mil_type[$m] == "N"){
                                             $query11 = "UPDATE ".$name.".milestone_surrogates 
                                                            SET updated_by            = '$usr', 
                                                                updated_on            = current_timestamp,
                                                                retrofit_parity       = 'Y',
                                                                retrofit_time         = now()																
                                                         WHERE execution_id           = '$yarea_execution_id' 
                                                           AND milestone_id           = '$ymil_id'";
										 }
										 
             				             $mysql_data11 = mysql_query($query11, $mysql_link) or die ("#3.Retrofit Could not query: ".mysql_error());
             				             //$rowcnt11 = mysql_num_rows($mysql_data11);
                                     }									 
						        } 
								if ($f == 0) {
								    print("<br><br>Milestone Surrogate entries not found<br><br>");
			 			 	    } else {
			     				    print("<br><br>Milestone Surrogate entries found<br><br>");
			 				    }  

					            print("============================<br><br>");
                      }
                      // If the Launch date is before Retrofit cuttoff date 					  
					  if ($doretrofit == 0) {
							    $f2 = 0;
							    for ($m=1;$m<=$mil_cnt;++$m) { 
							         if ($mil_issue_area_id[$m] == $yissue_area_id) {
                                         $f2 = $f2 + 1;
									     $ymil_time = $mil_time[$m];
										 $ymil_id   = $mil_id[$m];
  			            	             $query12   = "select execution_id,milestone_id,iteration_count
                                         	             from ".$name.".milestone_surrogates   
                                            	        where execution_id = '$yarea_execution_id'
													      and milestone_id = '$ymil_id'";
            	                         $mysql_data12 = mysql_query($query12, $mysql_link) or die ("#2.Retrofit2 Could not query: ".mysql_error());
            	                         $rowcnt12 = mysql_num_rows($mysql_data12);    
										 if ($rowcnt12 == 0){
                                               $yiteration_count  = 0;
                                               $ymil_base_time    = 0;
                                               $ymil_incr_time    = 0;
                                               $ymil_totl_time    = 0;
                                               $mil_found         = "No";  											   
										 } else { 
                                           while($rowx12 = mysql_fetch_row($mysql_data12)) {
                                               $yiteration_count  = stripslashes($rowx12[2]);
                                               $ymil_base_time    = $ymil_time;
                                               $ymil_incr_time    = $ymil_time * $yiteration_count;
                                               $ymil_totl_time    = $ymil_base_time + $ymil_incr_time; 
											   $mil_found         = "Yes";
                                           }	
                                         }										 
                                         print("Milestone Found: ".$mil_found."||Milestone: ".$mil[$m]."||Type: ".$mil_type[$m]."||Baseline: ".$mil_time[$m]."||Incremental Time: ".$ymil_incr_time."||Total Time: ".$ymil_totl_time."<br>");
										 //if ($mil_type[$m] == "F"){
                                             $query11 = "UPDATE ".$name.".milestone_surrogates
                                                            SET updated_by            = '$usr', 
                                                                updated_on            = current_timestamp, 
                                                                old_baseline_time     = '$ymil_time',  
                                                                incremental_time      = '$ymil_incr_time',
                                                                total_time            = '$ymil_totl_time',
                                                                retrofit_parity       = 'N',
                                                                retrofit_time         = now()																
                                                         WHERE execution_id           = '$yarea_execution_id' 
                                                           AND milestone_id           = '$ymil_id'";
										 //}
             				             $mysql_data11 = mysql_query($query11, $mysql_link) or die ("#3.Retrofit2 Could not query: ".mysql_error());
             				             //$rowcnt11 = mysql_num_rows($mysql_data11);
                                     }									 
						        } 
								if ($f2 == 0) {
								    print("<br><br>Milestone Surrogate entries not found<br><br>");
			 			 	    } else {
			     				    print("<br><br>Milestone Surrogate entries found<br><br>");
			 				    }  

					            print("============================<br><br>");
                      }							
              }
			  print("<br><br><br>END OF RETROFIT RUN");
            } 
		/// Retrofit End to preserve old time for milestone_surrogates
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////

//============================================================================
//============================================================================
//===========================================================================		
		
?>