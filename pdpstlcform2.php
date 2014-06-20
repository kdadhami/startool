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

// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
                  where issue_area_ind = 1 
               order by issue_area ";
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
            $new_old_milestone_time[$key]  = addslashes($new_old_milestone_time[$key]);

             $queryh = "SELECT UPPER(trim(milestone)) 
                          FROM ".$name.".pdp_stlc 
                         WHERE  UPPER(trim(milestone)) = '$new_milestone[$key]'
                           AND  issue_area_id          = '$new_milestone_seq[$key]'
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
            $query ="INSERT into ".$name.".pdp_stlc(
			                                        milestone,
			                                        milestone_ind,
													milestone_time,
													milestone_seq,
													issue_area_id,
			                                        milestone_type,
													old_milestone_time
													)
                                             VALUES(
											        '$new_milestone[$key]',
											        1,
													'$new_milestone_time[$key]',
													'$new_milestone_seq[$key]',
													'$new_issue_area_id[$key]',
					                                '$new_milestone_type[$key]',
													'$new_old_milestone_time[$key]'
												    )";

            $mysql_data = mysql_query($query, $mysql_link) or die ("#55 Could not query: ".mysql_error());
            } else {
              echo "<script type=\"text/javascript\">window.alert(\"Work Activity '$new_milestone[$key]' for this department already exists\")</script>";
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
		   $xold_milestone_time[$key] = addslashes($xold_milestone_time[$key]);
	       
  		   $queryu = "UPDATE ".$name.".pdp_stlc
		                SET milestone      = '$xmilestone[$key]',
                            milestone_ind  = 1,
                            milestone_time = '$xmilestone_time[$key]',
							milestone_type = '$xmilestone_type[$key]',
                            milestone_seq  = '$xmilestone_seq[$key]',
                            issue_area_id  = '$xissue_area_id[$key]',
							old_milestone_time = '$xold_milestone_time[$key]'
		              WHERE milestone_id = '$key'";

		$mysql_datau = mysql_query($queryu, $mysql_link) or die ("#44.55 Could not query: ".mysql_error());
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
           <form method=\"post\" action=\"./pdpstlcform2.php\">
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
               <td align=\"center\" bgcolor=\"#99CCFF\" style=\"width: 75px\"><font color=\"#330099\">Time (Hrs)<br>99.99</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "   select milestone_id,
                    milestone,
					milestone_ind,
					milestone_time,
					milestone_seq,
					issue_area_id,
					milestone_type,
					old_milestone_time,
					issue_area_id
               from ".$name.".pdp_stlc 
           order by issue_area_id,milestone_ind desc, milestone_seq asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("#22 Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;
		
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

    $xid                 = stripslashes($row[0]);
    $xmilestone          = stripslashes($row[1]);
    $xmilestone_ind      = stripslashes($row[2]);
    $xmilestone_time     = stripslashes($row[3]);
    $xmilestone_seq      = stripslashes($row[4]);
    $xissue_area_id      = stripslashes($row[5]);
    $xmilestone_type     = stripslashes($row[6]);
	$xmilestone_hrs      = intval($xmilestone_time/60);   //derives hours 
    $xmilestone_min      = $xmilestone_time%60;           // derives minutes beyond 60 but less then 60 in the last hour
	$xold_milestone_time = stripslashes($row[7]);
	$xissue_area_id      = stripslashes($row[8]);
	//print($xissue_area_id."<br>");

    $query1 = "select milestone_id from ".$name.".milestone_surrogates where milestone_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("#33 Could not query: ".mysql_error());
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
                 <select align=\"center\" name=\"xissue_area_id[$xid]\"> 
       ");
       $w = 0;
       for ($w=1;$w<=$dcnt; ++$w) {
           if ($did[$w] == $xissue_area_id) {
                   print(" <option selected value=\"$did[$w]\">$dpt[$w]</option> ");
           } else {
                   print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
           }
       }
       print("   </select>
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
	                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                     <input type=\"text\" name=\"xold_milestone_time[$xid]\" value=\"$xold_milestone_time\" size=\"5\" maxlength=\"5\">
	                </td>	            
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
       ");
       $w = 0;
       for ($w=1;$w<=$dcnt; ++$w) {
            if ($did[$w] == $xissue_area_id) {
	            print(" <font color=\"#000000\"> 
                         $dpt[$w]
                        </font> 
                ");                
            } 
       }
       print("  </td>
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
       ");
       for ($mx=1;$mx<=3; ++$mx) {
            if ($xmilestone_type == $mil_type_val[$mx]) {
                print("
	             <font color=\"#000000\"> 
                   $mil_type[$mx]
                 </font>
				"); 				
            } else {
            }   
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
       ");
       for ($hr=0;$hr<=24; ++$hr) {
            if ($xmilestone_hrs == $hr) {
                print("
	             <font color=\"#000000\"> 
                   $xmilestone_hrs
                 </font>
				"); 				
			}   
       }                         
       print("
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
       ");
       for ($mn=0;$mn<=59; ++$mn) {
            if ($xmilestone_min == $mn) {
                print("
	             <font color=\"#000000\"> 
                   $xmilestone_min
                 </font>
				"); 				
 		    }   
       }                         
       print("
                 </select>
	            </td>	            
	      ");

	      if ($rowcnt > 0) {
	         print("
	                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	                 <font color=\"#000000\"> 
                      $xold_milestone_time
                     </font>
	                </td>	            
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
                   <select align=\"center\" name=\"new_issue_area_id[$x]\"> 
       ");
       $w = 0;
       for ($w=1;$w<=$dcnt; ++$w) {
            print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
       }
       print("     </select>
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
            print("<option value=\"$mil_type_val[$mx]\">$mil_type[$mx]</option> ");    
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
				 <select align=\"center\" name=\"new_milestone_hrs[$x]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($hr=0;$hr<=24; ++$hr) {
            print("<option value=\"$hr\">$hr</option> ");    
       }                         
       print("
                 </select>
                </td>				 
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
				 <select align=\"center\" name=\"new_milestone_min[$x]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
       ");
       for ($mn=0;$mn<=59; ++$mn) {
            print("<option value=\"$mn\">$mn</option> ");    
       }                         
       print("
                 </select>
                </td>				 
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                   <input type=\"text\" name=\"new_old_milestone_time[$xid]\" value=\"$new_old_milestone_time\" size=\"5\" maxlength=\"5\">
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
