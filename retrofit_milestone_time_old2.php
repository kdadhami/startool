<?php

// --------------------------------------------------------------------------
// Author: Kashif Adhami
// Dated: September, 2011
// Revisions: October, 2011
// --------------------------------------------------------------------------
// #1
// USE THIS SCRIPT ONE TIME TO POPULATE FIELDS THAT WILL BE USED AFTER
// CHANGES HAVE BEEN IMPLEMENTED FOR MANAGING TIMEKEEPING (BASELINE AND 
// REWORK) CALCULATIONS
// #2
// CHANGE RETROFIT_PARITY = "R" IN MILESTONE TABLE
// #3
// THIS SCRIPT WILL ONLY BE SUCCESSFUL IF RETROFIT_PARITY IS SET TO "R" FOR
// ALL ROWS IN MILESTONE_SURROGATE TABLE THAT EXISTS FROM BEFORE THE CHANGES
// AND SHOULD ONLY BE USED ONCE
// --------------------------------------------------------------------------
// This program helps to retrofit work effort time after the new change 
// of keeping work effort. 
// OLD Logic: Work Activity had iterations, 0 for baseline, +0 for iteration
// New Logic: Work Activity will have three types, Fixed, Variable, None
// Fixed Work Activity: will be like old
// Variable Work Activity: will require user to enter time manullay in mins 
//                         for each iteration of variable work activity
// None Work Activity: Is not tracked in time
// --------------------------------------------------------------------------
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
////////////////
// Retrofit Date
////////////////
$retro_cutoff_dt = 1314849600;
$rd              = date("d",$retro_cutoff_dt);
$rm              = date("M",$retro_cutoff_dt);
$ry              = date("Y",$retro_cutoff_dt);
$rdt             = $rd."-".$rm."-".$ry;
//print("RETROFIT CUTOFF IS: ".$rdt."<br><br><br>");
///////////////////////////////////////////////////


//=======================
// Loading PDP Milestones
//=======================
$query31      = "   select milestone_id,
                           milestone,
						   milestone_ind,
						   milestone_time,
						   milestone_seq,
						   issue_area_id,
						   milestone_type,
						   old_milestone_time
                      from ".$name.".pdp_stlc  
                  order by milestone_ind desc, 
				           milestone_seq asc
			    ";
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
	  $omil_time[$mil_cnt]          = stripslashes($row31[7]);
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


print("<html>
        <head>
         <style>
             body    { font-family: Courier, monospace;
                       font-size: 12px; 
                     }
             font    { font-family: Courier, monospace;
                       font-size: 12px;
                     }        
         </style>       
        </head>
        <body>
");


//============================================================================
//============================================================================
//============================================================================

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
        print("<br>
		       <br>
			   <br>
			    START OF RETROFIT RUN
			   <br>
			   <br>
		");
		
       $query9 = "select execution_id,
		                 milestone_id,
			            iteration_count
                   from ".$name.".milestone_surrogates
				  where retrofit_parity = 'R' ";
       $mysql_data9 = mysql_query($query9, $mysql_link) or die ("#1.Retrofit Could not query: ".mysql_error());
       $rowcnt9 = mysql_num_rows($mysql_data9);

	   print("<br>".$query9."<br>");
       print("Rows Found.............: ".$rowcnt9);			

       //break;
       $e = 0;
       if ($rowcnt9 <> 0){
                while($rowx9 = mysql_fetch_row($mysql_data9)) {
                      $e                          = $e + 1;
					  $yexecution_id              = stripslashes($rowx9[0]);
					  //$exec_id[$e]                = $yexecution_id;
					  $ymilestone_id              = stripslashes($rowx9[1]);
					  $yiteration_count           = stripslashes($rowx9[2]);
                      print("<br><br>ENTRY NO: ".$e."<br>==============<br>");
					  print("Execution ID............: ".$yexecution_id."<br>");
					  print("Iteration...............: ".$yiteration_count."<br>");
                      //print("No......................: ".$e."<br>");
                      //if ($e == 1){
					  //   $chk = 0;
					  //} else {
					  //    $chk = 1;
					  //}
					  //if ($chk == 1){
					  //    $zexecution_id = $exec_id[$e-1];
					  //}
					  /////////////////////////					  
					  // FIND EXECUTION DETAILS
					  /////////////////////////
                      //$query9x = "select area_execution_id,
					  //                   pdp_id
                      //              from ".$name.".area_execution a 
                      //             where area_execution_id = '$yexecution_id' ";
                      //$query9x = "select area_execution_id,
					  //                   pdp_id
                      //              from ".$name.".area_execution a 
                      //             where area_execution_id = '$yexecution_id' ";
				      //$mysql_data9x = mysql_query($query9x, $mysql_link) or die ("#1x.Retrofit Could not query: ".mysql_error());
                      //$rowcnt9x = mysql_num_rows($mysql_data9x);					  
                      //if ($rowcnt9x <> 0){
					  //     while($rowx9x = mysql_fetch_row($mysql_data9x)) {
				      //           $yarea_execution_id       = stripslashes($rowx9x[0]);
				      //           $ypdp_id                  = stripslashes($rowx9x[1]);
					  //  	    if (($chk == 0) or ($yexecution_id <> $zexecution_id)){
                      //               print("Execution Found.........: YES<br>");
					  //	         }
					  //	  }		 
					  //} else {
					  //  print("Execution Found.........: NO<br>");
					  //}
					  ///////////////////					  
					  // FIND PDP DETAILS
					  ///////////////////
                      //$query9y = "select pdp_desc,
					  //                   pdp_launch
                      //              from ".$name.".pdp c 
                      //             where pdp_id = '$ypdp_id' ";
                      //$mysql_data9y = mysql_query($query9y, $mysql_link) or die ("#1y.Retrofit Could not query: ".mysql_error());
                      //$rowcnt9y = mysql_num_rows($mysql_data9y);
                      //if ($rowcnt9y <> 0){					  
					  //     while($rowx9y = mysql_fetch_row($mysql_data9y)) {
				      //           $ypdp_desc   = stripslashes($rowx9y[0]);
				      //           $ypdp_launch = stripslashes($rowx9y[1]);
					  //			 $ypdpfound   = $ypdp_desc;
                      //           // Derive Launch Date
             		  //           if (empty($ypdp_launch)){
                      //           	$ypdp_launch_dt = "NULL";
                      //           	$ydate = "0000-00-00 00:00:00";
             		  //           } else {  
                      //           	$yld            = date("d",$ypdp_launch);
                      //           	$ylm            = date("M",$ypdp_launch);
                      //            	$yly            = date("Y",$ypdp_launch);
                      //            	$ypdp_launch_dt = $yld."-".$ylm."-".$yly;
             		  //           } 
					  //           // Derive if Retrofit is before or after Retrofit Date(0 for before, and 1 for after)
			 		  //           //if ($ypdp_launch >= $retro_cutoff_dt) {
			     	  //			 //     $doretrofit = 1;
                      //           //     $retrofix   = "YES";									  
			 		  //           //} else {
			     	  //			      //$doretrofit = 0;
				      //		 //$retrofix   = "NO";
			 		  //           //}
					  //     }
					  //} else {
					  //          $ypdpfound      = "*** NOT FOUND ***";
                      //         	$ypdp_launch_dt = "NULL";
                      //          $ydate          = "0000-00-00 00:00:00";
					  //			//$doretrofit     = 0;
				      //				//$retrofix       = "NO";
					  //}
				      //if (($chk == 0) or ($yexecution_id <> $zexecution_id)){
                      //     print("PDP ....................: ".$ypdpfound."<br>");
                      //     print("PDP Launch..............: ".$ypdp_launch_dt."<br>");
                      //     print("Retrofix................: ".$retrofix."<br>");
                      //}
					  /////////////////////////
                      // FIND MILESTONE DETAILS
                      /////////////////////////
                      $mil_found = 0;
                      $milfnd    = "NO"; 					  
					  for ($m=1;$m<=$mil_cnt;++$m) { 
						   if ($mil_id[$m] == $ymilestone_id) {
						       $mil_found = 1;
							   $milfnd = "YES";
						       //$ymil_time = $mil_time[$m];   // Use this for after Retrofit, i.e. when setting to hrs, min change
							   $ymil_time  = $omil_time[$m];    // Use this for before Retrofit
							   $ymil_id    = $mil_id[$m];
							   $ymil_type  = $mil_type[$m];
							   $yomil_time = $omil_time[$m];
                               print("Milestone...............: ".$mil[$m]."<br>".
							         "Type....................: ".$mil_type[$m]."<br>"
							   );
					           //"Baseline................: ".$mil_time[$m]."<br>".
					       }		   
                      }	
                      /////////////////					  
					  // RETROFIX = YES
                      ///////////////// 					  
					  //if ($doretrofit == 1) {
 					  //	  if ($mil_found == 0){
                      //        $yiteration_count  = 0;
                      //        $ymil_base_time    = 0;
                      //        $ymil_incr_time    = 0;
                      //        $ymil_totl_time    = 0;
					  //		  $ymil_parity       = "X";
					  //	  } else {
                      //        if ($yiteration_count == 0){
                      //            $ymil_base_time    = $ymil_time;
                      //            $ymil_incr_time    = 0;
                      //            $ymil_totl_time     = $ymil_base_time; 
                      //        }
                      //        if ($yiteration_count <> 0){
                      //            $ymil_base_time    = $ymil_time;
                      //            $ymil_incr_time    = $ymil_time * $yiteration_count;
                      //            $ymil_totl_time    = $ymil_incr_time; 
                      //        }
                      //        //$ymil_base_time    = $ymil_time;
                      //        //$ymil_incr_time    = $ymil_time * $yiteration_count;
                      //        //$ymil_totl_time     = $ymil_base_time + $ymil_incr_time; 
					  //		  $ymil_parity        = "Y";
                      //    }										 
                      //    $query11 = "UPDATE ".$name.".milestone_surrogates
                      //                   SET updated_by            = '$usr', 
                      //                       updated_on            = current_timestamp, 
                      //                       baseline_time         = '$ymil_base_time',
                      //                       old_baseline_time     = 0,											 
                      //                       incremental_time      = '$ymil_incr_time',
                      //                       total_time            = '$ymil_totl_time',
                      //                       retrofit_parity       = '$ymil_parity',
                      //                       retrofit_time         = now(),
                      //                       milestone_found       = '$mil_found'											 
                      //                 WHERE execution_id          = '$yexecution_id' 
                      //                   AND milestone_id          = '$ymil_id'";
					  //}
                      /////////////////					  
					  // RETROFIX = NO
                      ///////////////// 					  
					  //if ($doretrofit == 0) {
 					  if ($mil_found == 0){
                              $yiteration_count         = 0;
                              (float)$ymil_base_time    = 0;
                              (float)$ymil_incr_time    = 0;
                              (float)$ymil_totl_time    = 0;
							  $ymil_parity              = "R";
					  } else {
                              if ($ymil_type == "N"){
                                  $yiteration_count         = 0;
                                  (float)$ymil_base_time    = 0;
                                  (float)$ymil_incr_time    = 0;
                                  (float)$ymil_totl_time    = 0;
                              } else {							  
                                  if ($yiteration_count == 0){
                                      (float)$ymil_base_time    = $ymil_time;
                                      (float)$ymil_incr_time    = 0;
                                      (float)$ymil_totl_time    = $ymil_base_time; 
                                  }
                                  if ($yiteration_count <> 0){
                                      (float)$ymil_base_time    = $ymil_time;
                                      (float)$ymil_incr_time    = $ymil_time * $yiteration_count;
                                      (float)$ymil_totl_time    = (float)$ymil_base_time + (float)$ymil_incr_time; 
                                  }
							  }
                              //$ymil_totl_time     = $ymil_base_time + $ymil_incr_time; 
							  $ymil_parity        = "R";
                      }
                      ////////////////////////////////////////////////////////////////////////
                      ////////////////////////////////////////////////////////////////////////					  
					  // Updaing milestone_surrogate_archive
					  //
					  // Select entries from milestone_surrogate_archive table
                      ////////////////////////////////////////////////////////////////////////
                      ////////////////////////////////////////////////////////////////////////					  
            		  $query99 = "select execution_id,
					                     milestone_id,
					  		             iteration_count
           		                 from ".$name.".milestone_surrogates_archive
					  			 where execution_id = '$yexecution_id' 
                                   and milestone_id = '$ymil_id'
							  order by execution_id,milestone_id,last_update asc ";
            		  $mysql_data99 = mysql_query($query99, $mysql_link) or die ("#1.99 Could not query: ".mysql_error());
            		  $rowcnt99 = mysql_num_rows($mysql_data99);
					  //print($query99."<br>");    
            		  //print("<br>Archive rows Found......: ".$rowcnt99."<br>");			
            		  $a9 = 0;
            		  if ($rowcnt99 <> 0){
               		      while($rowx99 = mysql_fetch_row($mysql_data99)) {
                      		  $a9                         = $a9 + 1;
					  		  $a_execution_id             = stripslashes($rowx99[0]);
					  		  $a_milestone_id             = stripslashes($rowx99[1]);
					  		  $a_iteration_count          = stripslashes($rowx99[2]);
                              if ($a_iteration_count == 0){
                                      (float)$a_mil_base_time    = $ymil_time;
                                      (float)$a_mil_incr_time    = 0;
                                      (float)$a_mil_totl_time    = $a_mil_base_time; 
                              }
                              if ($a_iteration_count <> 0){
                                      (float)$a_mil_base_time    = $ymil_time;
                                      (float)$a_mil_incr_time    = $ymil_time * $a_iteration_count;
                                      (float)$a_mil_totl_time    = (float)$a_mil_base_time + (float)$a_mil_incr_time; 
                              }
					  		  $a_mil_parity        = "R";
                      		  $query12 = "UPDATE ".$name.".milestone_surrogates_archive
                       		                 SET baseline_time         = '$a_mil_base_time',
                        		                 incremental_time      = '$a_mil_incr_time',
                        		                 total_time            = '$a_mil_totl_time',
                         		                 retrofit_parity       = '$a_mil_parity',
								  		         occurance             = '$a9'
                         		            WHERE execution_id         = '$yexecution_id' 
                         		              AND milestone_id         = '$ymil_id'";
					 		   //}
					  		  $mysql_data12 = mysql_query($query12, $mysql_link) or die ("#Update.12 Could not query: ".mysql_error());
							  if ($a9 == 1){
                      		      print("Archives Found..........: YES"."<br>");
							  }
						      print("Occurance Updated.......: ".$a9."<br>");
                		 }
            		  } else {
					    print("Archives Found..........: NO"."<br>");
					  } 
                      $a9 = $a9 + 1;					  
                      ////////////////////////////////////////////////////////////////////////
                      ////////////////////////////////////////////////////////////////////////					  
                      $query11 = "UPDATE ".$name.".milestone_surrogates
                                     SET updated_by            = '$usr', 
                                         updated_on            = now(), 
                                         baseline_time         = '$ymil_base_time',
                                         incremental_time      = '$ymil_incr_time',
                                         total_time            = '$ymil_totl_time',
                                         retrofit_parity       = '$ymil_parity',
								         occurance             = '$a9' 
                                   WHERE execution_id          = '$yexecution_id' 
                                     AND milestone_id          = '$ymil_id'";
					  //}
					  $mysql_data11 = mysql_query($query11, $mysql_link) or die ("#Update.Retrofit Could not query: ".mysql_error());
                      print("Milestone Found.........: ".$mil_found."<br>".
					        "Baseline................: ".$ymil_time."<br>".
						    "Incrementatl............: ".$ymil_incr_time."<br>".
						    "Total...................: ".$ymil_totl_time."<br>".
							"Occurance...............: ".$e9."<br>".
						    "Retrofit Parity.........: ".$ymil_parity."<br>"
					  );
					  //if ($a9 > 1){
					  //    print("Archive Updted..........: YES"."<br>");
					  //}
                      //$query35 = "INSERT into ".$name.".milestone_surrogates_archive( execution_id,
					  //                                                                milestone_id,
					  // 														        iteration_count,
					  //														        updated_by,
					  // 														        last_update,
					  // 													            baseline_time,
				      //															    incremental_time,
			          //																total_time,
				      //															    retrofit_parity,
				      //															    occurance
			          //														      )
                      //                                                        VALUES( '$yexecution_id',
			          //														        '$ymil_id',
			          //																'$yiteration_count',
			          //																'$usr',
			          //																now(),
			          //																'$ymil_base_time',
			          //																'$ymil_incr_time',
			          //																'$ymil_totl_time',
			          //																'R',
			          //																1
			          //															  ) ";
                      //$mysql_data35 = mysql_query($query35, $mysql_link) or die ("#48 Could not query: ".mysql_error());
              }
       } 
	   print(" <br>
	           <br>
			   <br>
			   END OF RETROFIT RUN
			   <br>
			  </body>
	  ");
//============================================================================
//============================================================================
//===========================================================================		
		
?>