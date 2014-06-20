<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: milestone_maintenance.php
// Date: September, 2011
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
       }         
}
//$trans = "loop";
// ==============================

// setting up today's date
$newd     = date("d"); //day
$newm     = date("m"); //month
$newm2    = date("M"); //month
$newy     = date("Y"); //year
$newt     = time();
$new_dt   = mktime(0,0,0,$newm,$newd,$newy);
$today_dt = $newd."-".$newm2."-".$newy." : ";

//load status types
$queryx      = "select status_type_id,status_type,status_color_code from ".$name.".status_types where status_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#23 Could not query: ".mysql_error());
$rowcntx     = mysql_num_rows($mysql_datax);    
$st_typ_cnt              = 1;
$st_typ_id[$st_typ_cnt]  = 0;
$st_typ[$st_typ_cnt]     = "";
$st_typ_clr[$st_typ_cnt] = "";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $st_typ_cnt              = $st_typ_cnt + 1;
      $st_typ_id[$st_typ_cnt]  = stripslashes(trim($rowx[0]));
      $st_typ[$st_typ_cnt]     = stripslashes(trim($rowx[1]));      
      $st_typ_clr[$st_typ_cnt] = stripslashes(trim($rowx[2]));
}

// Loading PDP Milestones
$query31      = "   select milestone_id,
                           milestone,
						   milestone_ind,
						   milestone_time,
						   milestone_seq 
                      from ".$name.".pdp_stlc 
                     where issue_area_id = '$uissue_area_id'
                       and milestone_ind = 1 
                  order by milestone_ind desc, milestone_seq asc";
$mysql_data31 = mysql_query($query31, $mysql_link) or die ("#24 Could not query: ".mysql_error());
$rowcnt31         = mysql_num_rows($mysql_data31);
$mil_cnt          = 0;

while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt            = $mil_cnt + 1;
      $mil_id[$mil_cnt]   = stripslashes($row31[0]);
      $mil[$mil_cnt]      = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]  = stripslashes($row31[2]);
      $mil_time[$mil_cnt] = (float)stripslashes($row31[3]);
      $mil_seq[$mil_cnt]  = (float)stripslashes($row31[4]);
}

// ============================== MILESTONE TYPE ================================
$mil_type[1]     = "Fixed";
$mil_type_val[1] = "F";
$mil_type[2]     = "Variable";
$mil_type_val[2] = "V";
$mil_type[3]     = "None";
$mil_type_val[3] = "N";
// ==============================================================================


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
while($rowx2 = mysql_fetch_row($mysql_datax2)) {
      $dept_cnt             = $dept_cnt + 1;
      $dept_id[$dept_cnt]   = stripslashes(trim($rowx2[0]));
      $dept[$dept_cnt]      = stripslashes(trim($rowx2[1]));
      $dept_code[$dept_cnt] = stripslashes(trim($rowx2[2])); 
}

$ind[0]    = "";
$ind[1]    = "Yes";
$ind[2]    = "No";
$ind_id[0] = 0;
$ind_id[1] = 1;
$ind_id[2] = 0;


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

       $captn = "Rework Effort History";
       print(" <table id=\"theTable\" border='0' align=\"center\" width=\"90%\"> ");
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
			   $umil_time[$row444cnt]  = stripslashes($row444x[3]);
			   $umil_type[$row444cnt]  = stripslashes($row444x[6]);
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
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">PDP Rework Effort</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Rework<br>Effort</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Enter<br>Time</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\"><font color=\"#330099\">Time<br>(Hours)</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Last<br>Updated</font></td>
                </tr>
                <tr>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Time<br>(Hrs)<br>(0-24)</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Time<br>(Hrs)<br>(0-59)</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Baseline</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Rework</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Total</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">By</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">On</font></td>
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
                        $query35 = "INSERT into ".$name.".milestone_surrogates(
						                                                       execution_id,
																			   milestone_id,
																			   iteration_count,
																			   updated_by,
																			   updated_on,
																			   baseline_time,
																			   total_time,
																			   retrofit_parity,
																			   occurance
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
																			  1
																			  )";
                        $mysql_data35 = mysql_query($query35, $mysql_link) or die ("#48 Could not query: ".mysql_error());
                        $query35y = "INSERT into ".$name.".milestone_surrogates_archive(
						                                                       execution_id,
																			   milestone_id,
																			   iteration_count,
																			   updated_by,
																			   last_update,
																			   baseline_time,
																			   total_time,
																			   retrofit_parity,
																			   occurance
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
																			  1
																			  )";
                        $mysql_data35y = mysql_query($query35y, $mysql_link) or die ("#48.y Could not query: ".mysql_error());
                    }    
               }
           }
		   // Find and insert missing milestone in milestone_surrogate entries
		   // OR
		   // Update active_ind = 0 for milestone_surrogate entry has been invalidated
	       $row34cnt     = 0;
           while($row34x = mysql_fetch_row($mysql_data34)) {
                 $row34cnt            = $row34cnt + 1;
                 $vmil_id[$row34cnt]  = stripslashes($row34x[1]);
				 $vmil[$row34cnt]     = stripslashes($row34x[3]);
           }
		   // Insert - when milestone entry missing
 		   if ($rowcnt34 <> 0) {
               for ($u0=1;$u0<=$row44cnt;++$u0) {
			        $fnd_u0 = 0;   
			        for ($u1=1;$u1<=$row34cnt;++$u1) {
                         if ($umil_id[$u0] == $vmil_id[$u1]) {
				             $fnd_u0 = 1;					
                         }
			        }
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
																				occurance
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
																				1
																				)";
                        $mysql_data35x = mysql_query($query35x, $mysql_link) or die ("#48.X Could not query: ".mysql_error());
                        $query35z = "INSERT into ".$name.".milestone_surrogates_archive(
						                                                        execution_id,
																				milestone_id,
																				iteration_count,
																				updated_by,
																				last_update,
																				baseline_time,
																				total_time,
																				retrofit_parity,
																				occurance
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
																				1
																			  )";
                        $mysql_data35z = mysql_query($query35z, $mysql_link) or die ("#48.z Could not query: ".mysql_error());
                    } else {
                    }			 
               }
               // update - when milestone not valid  		   
               for ($u1=1;$u1<=$row34cnt;++$u1) {
			        $fnd_u1 = 0;   
			        for ($u0=1;$u0<=$row44cnt;++$u0) {
                         if ($vmil_id[$u1] == $umil_id[$u0]) {
			                 $fnd_u1 = 1;
                         }
			        }
                    if ($fnd_u1 == 0){
                        //$query35x = "DELETE from ".$name.".milestone_surrogates
			     	    //                WHERE execution_id = '$yexecution_id' 
			   		    //		          AND milestone_id = '$vmil_id[$u1]' ";
                        //$query35x = "UPDATE ".$name.".milestone_surrogates
						//                SET active_ind = 0 
			     	    //              WHERE execution_id = '$yexecution_id' 
			   			//	            AND milestone_id = '$vmil_id[$u1]' ";
					    //$mysql_data35x = mysql_query($query35x, $mysql_link) or die ("#48.X Could not query: ".mysql_error());
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
                              b.milestone							  
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b   
                        where a.execution_id  = $yexecution_id
                          and a.milestone_id  = b.milestone_id 
                          and b.issue_area_id = '$uissue_area_id' 
                      ";
           //print($query34);               
           $mysql_data44       = mysql_query($query44, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
           $rowcnt44           = mysql_num_rows($mysql_data44);
           $eseq               = 0;
           $total_baseline     = 0;
           $total_incrementatl = 0;
           while($row44 = mysql_fetch_row($mysql_data44)) {
                $eseq                     = $eseq + 1;
                $yexecution_id            = stripslashes($row44[0]);
                $ymilestone_id            = stripslashes($row44[1]);
                $zid                      = stripslashes($row44[1]);
                $yiteration_cnt           = stripslashes($row44[2]);
                $yupdated_on              = stripslashes($row44[3]);
                $yupdated_by              = stripslashes($row44[4]);
                (float)$ybaseline_time    = stripslashes($row44[5]);
                (float)$ytotal_time       = stripslashes($row44[6]);
                (float)$yincremental_time = stripslashes($row44[7]);
				$yoccurance               = stripslashes($row44[8]);
				$ymilestone_type          = stripslashes($row44[9]);
				(float)$ymilestone_time   = stripslashes($row44[10]);
				(float)$ymilestone        = stripslashes($row44[11]);
				
                print("  <tr>
                          <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                           <font color=\"#330099\">
                            $yexecution_id 
                           </font> 
                          </td>-->
                          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                           <font color=\"#330099\"> 
                            $eseq
                           </font> 
                          </td>
                ");
				// FIND TOTALS
                //$query36 = " select sum(incrementatl_time)
                //               from ".$name.".milestone_surrogates  
                //              where milestone_id = '$zid' 
                //                and execution_id = $yexecution_id
                //           ";
		        //// issue_area_id = '$uissue_area_id' and milestone_ind = 1		   
                //$mysql_data36 = mysql_query($query36, $mysql_link) or die ("#50 Could not query: ".mysql_error());
                //$rowcnt36 = mysql_num_rows($mysql_data36);
				//$total_incremental_time = 0;
                //while($row36 = mysql_fetch_row($mysql_data36)) {
				//      (float)$total_incremental  = stripslashes($row36[0]);
                //}
                //$yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                //$total_baseline    = $total_baseline + $ybaseline_time;
                //$total_incremental = $total_incremental + $yincremental_time;
                //$yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                $total_baseline    = $total_baseline + $ybaseline_time;
                $total_incremental = $total_incremental + $yincremental_time;
                print("           
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ymilestone
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         <input type=\"text\" name=\"yiteration_cnt[$yid][$zid]\" value=\"$yiteration_cnt\" size=\"3\">
                         <input type=\"hidden\" name=\"ymilestone[$yid][$zid]\" value=\"$ymilestone\">
						 <input type=\"hidden\" name=\"prv_baseline_time[$yid][$zid]\" value=\"$ybaseline_time\">
						 <input type=\"hidden\" name=\"prv_incremental_time[$yid][$zid]\" value=\"$yincremental_time\">
						 <input type=\"hidden\" name=\"prv_total_time[$yid][$zid]\" value=\"$ytotal_time\">
						 <input type=\"hidden\" name=\"prv_occurance[$yid][$zid]\" value=\"$yoccurance\">
						 <input type=\"hidden\" name=\"ymilestone_type[$yid][$zid]\" value=\"$ymilestone_type\">
                        </font> 
                       </td>
               ");
			   if ($ymilestone_type == "V"){
                   print(" 
			           <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				        <select align=\"center\" name=\"ymilestone_hrs[$yid][$zid]\">
				   ");		
			       for ($hr=0;$hr<=24; ++$hr) {
				        if ($hr == 0){
						  print("<option selected value=\"$hr\">$hr</option> "); 
						} else {
                          print("<option value=\"$hr\">$hr</option> ");
                        }						
                   }                         
                   print("
                            </select>
                           </td>				 
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
				            <select align=\"center\" name=\"ymilestone_min[$yid][$zid]\">
                   ");
                   for ($mn=0;$mn<=59; ++$mn) {
 				        if ($mn == 0){
						  print("<option selected value=\"$mn\">$mn</option> "); 
						} else {
                          print("<option value=\"$mn\">$mn</option> ");
                        }						
                   }
                  print("
                        </select>
	                   </td>	            
                  ");				  
               } else {
			        print("
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                            <font color=\"#330099\">
                             <input type=\"hidden\" name=\"ymilestone_time[$yid][$zid]\" value=\"$ymilestone_time\">							
                            </font> 
                           </td>
                           <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                            <font color=\"#330099\"> 
                            </font> 
                           </td>
                    ");
               }			   
               print("
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ybaseline_time
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $yincremental_time
                        </font> 
                      </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                        <font color=\"#330099\"> 
                         $ytotal_time
                        </font> 
                      </td>
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
                    </tr>
                ");
           }
           if ($total_incremental == 0){
		      $total_time          = 0; 
	       } else {
              $total_time          = round($total_baseline + $total_incremental,2);
	       }
	       if ($total_baseline == 0){
		      $percent_baseline    = 0;
              $percent_incremental = 0;			  
	       } else {
              $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
              $percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ; 
           }
           print("
                  <tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Work Effort (Hours)</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $total_baseline
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $total_incremental
                    </font> 
                   </td>
                  </tr>
                                              
                  </tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Percentage</strong>
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
                  </tr>

                  </tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Total Effort (Hours)</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\" colspan=\"2\">
                    <font color=\"#FF0000\"> 
                     $total_time
                    </font> 
                   </td>
                  </tr>                   
           ");
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
                 <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                 <input type=\"hidden\" name=\"start\" value=\"1\">
                 <input type=\"hidden\" name=\"area_cnt\" value=\"$rowcnty2\">
                 <input type=\"hidden\" name=\"pdpid\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update1[$xid]\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update2[$yid]\" value=\"$yid\">
                 <input type=\"hidden\" name=\"$itcnt\" value=\"$zit\">
                </td>
               </tr>
              </table>
       ");
   } else {
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
   print("<form method=\"post\" action=\"./milestone_maintenance.php\">
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
