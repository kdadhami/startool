<?php

// ----------------------------
// Author: Kashif Adhami
// Dated: November, 2010
// Note:  Categories are saved in issue_types table
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
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#1 Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($yissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================

// ============================== ISSUE TYPE START ==============================
$query69               = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,
                                 a.issue_seq,a.report_group_id
                            from ".$name.".issue_types a, issue_class b
                           where a.issue_class_id = b.issue_class_id
                             and b.issue_class in ('ROT') 
                        order by b.issue_class_code desc,a.issue_seq asc"; 
$mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
$rowcnt69              = mysql_num_rows($mysql_data69); 

$icnt            = 0;
$icnt            = $icnt + 1;
$iid[$icnt]      = 0;        //Issue_id
$ityp[$icnt]     = "&nbsp";  //issue_type
$ityp_ind[$icnt] = 1;
$iccd[$icnt]     = 0;  //issue_class_code

while($row69           = mysql_fetch_row($mysql_data69)) {
      $icnt            = $icnt + 1;
      $iid[$icnt]      = stripslashes($row69[0]);        //Issue_id
      $ityp[$icnt]     = stripslashes($row69[1]);        //issue_type
      $ityp_ind[$icnt] = stripslashes($row69[2]);
      $iccd[$icnt]     = trim(stripslashes($row69[3]));  //issue_class_code
      //$irgrpid[$icnt]  = stripslashes($row69[5]);
      //$igrp[$icnt]     = 0;
      // find out report group for each issue type
      //if ($irgrpid[$icnt] == 0) {
      //    $irgrp[$icnt]   = "NO";
      //} else {
      //  $query96        = "select report_group
      //                       from ".$name.".report_groups
      //                      where report_group_id = '$irgrpid[$icnt]' "; 
      //  $mysql_data96   = mysql_query($query96, $mysql_link) or die ("#2.5 Could not query: ".mysql_error());
      //  $rowcnt96       = mysql_num_rows($mysql_data96); 
      //  while($row96        = mysql_fetch_row($mysql_data96)) {
      //        $irgrp[$icnt] = stripslashes($row96[0]);
      //        // find out if this group has other issue types from prvious $icnt, if yes create a tcnt[$icnt] else do
      //        $ifound = 0;
      //        for ($x=1;$x<=$icnt-1;++$x) {
      //             if ($irgrp[$icnt] == $irgrp[$x]){
      //                 $ifound = 1;
      //             }
      //        }
      //        if ($ifound == 0){
      //            print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
      //            $icnt            = $icnt + 1;
      //            $iid[$icnt]      = 0;                 //Issue_id        
      //            $ityp[$icnt]     = $irgrp[$icnt-1];   //New Type is the group Name
      //            $ityp_ind[$icnt] = 1;                 //Valid 
      //            $iccd[$icnt]     = $iccd[$icnt-1];    //Class Code of the Issue Type the Report Group was found first
      //            $irgrpid[$icnt]  = 0;
      //            $irgrp[$icnt]    = $irgrp[$icnt-1];
      //            $igrp[$icnt]     = 1;
      //        }
      //  }
      }     
      //print($icnt." - ".$iid[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]." - ".$ityp[$icnt]."<br>");
}
// =============================== ISSUE TYPE END ===============================


// ==============================
// Loading Data for drop downs
// ==============================
$queryA       = " select issue_class_id,issue_class,issue_class_ind,issue_class_code 
                    from ".$name.".issue_class
                order by issue_class"; 
$mysql_dataA  = mysql_query($queryA, $mysql_link) or die ("#A Could not query: ".mysql_error());
$rowcntA      = mysql_num_rows($mysql_dataA); 
$iccnt        = 0;
$iccnt        = $iccnt + 1;
$ic[$iccnt]   = "&nbsp";
$icc[$iccnt]  = "";
$icid[$iccnt] = 0;
//print($ic[$iccnt]."-".$icc[$iccnt]."-".$icid[$iccnt]."<br>");
while($rowA   = mysql_fetch_row($mysql_dataA)) {
      $iccnt         = $iccnt + 1;
      $icid[$iccnt]  = stripslashes($rowA[0]);  
      $ic[$iccnt]    = stripslashes($rowA[1]);
      $icc[$iccnt]   = stripslashes($rowA[3]);
      //print($ic[$iccnt]."-".$icc[$iccnt]."-".$icid[$iccnt]."<br>"); 
}
// -------------------------------
//$queryB       = "select report_group_id,report_group,report_group_ind 
//                    from ".$name.".report_groups
//                order by report_group"; 
//$mysql_dataB  = mysql_query($queryB, $mysql_link) or die ("#B Could not query: ".mysql_error());
//$rowcntB      = mysql_num_rows($mysql_dataB); 
//$rgcnt        = 0;
//$rgcnt        = $rgcnt + 1;
//$rgid[$rgcnt] = 0;
//$rg[$rgcnt]   = "&nbsp";
//print($rg[$rgcnt]."-".$rgid[$rgcnt]."<br>");     
//while($rowB   = mysql_fetch_row($mysql_dataB)) {
//      $rgcnt         = $rgcnt + 1;
//      $rgid[$rgcnt]  = stripslashes($rowB[0]);  
//      $rg[$rgcnt]    = stripslashes($rowB[1]);
//      print($rg[$rgcnt]."-".$rgid[$rgcnt]."<br>");        
//}
// ==============================
// Loading Data for drop downs
// ==============================

if ($submit == "Submit") {
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

	         $new_granular_issue[$key] = addslashes(strtoupper($new_granular_issue[$key]));
	         $new_issue_type_id[$key] = addslashes($new_issue_typeid[$key]);

             $queryh = "SELECT UPPER(trim(new_granular_issue)) 
                          FROM ".$name.".granular_issues
                         WHERE UPPER(trim(granular_issues)) = '$new_granular_issue[$key]'
                           AND issue_type_id = '$new_issue_type_id[$key]' 
                       ";

             for ($c=1;$c<=$icnt; ++$c) {
                  if ($ityp[$c] == $new_issue_type_id[$key]) { 
                      $yissue_type = $ityp[$c]
                  }
             }                 
                       
             //print($queryh);
             $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#1 Could not query: ".mysql_error());
             $rowcnth = mysql_num_rows($mysql_datah);

             if ($rowcnth > 0) {
                 $insert_ind = 1;
             } else {
                 $insert_ind = 0;
             }

             if ($insert_ind == 0) {
                 $query ="INSERT into ".$name.".granular_issues(granular_issue,issue_type_id,granular_issue_ind)
                          VALUES('$new_granular_issue[$key]','$new_issue_type_id[$key]',1)";

                 $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
             } else {
               echo "<script type=\"text/javascript\">window.alert(\"Granular Cause ('$new_granular_issue[$key]') already exists for ('$yissue_type')\")</script>";
             }    
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]                 = addslashes($xid[$key]);
	    $xgranular_issue[$key]     = addslashes(strtoupper($xgranular_issue[$key]));
	    $xissue_type_id[$key]      = addslashes($xissue_type_id[$key]);
	    $xgranular_issue_ind[$key] = addslashes($xgranular_issue_ind[$key]);

  		$query = "UPDATE ".$name.".granular_issues
		             SET granular_issue      = '$xgranular_issue[$key]',
                         granular_issue_ind  = 1,
                         issue_type_id       = '$xissue_type_id[$key]'
		           WHERE granular_issue_id   = '$key'";
		//print($query);           
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".granular_issues
		             SET granular_issue_ind  = 1
		           WHERE granular_issue_id   = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".granular_issues
		             SET granular_issue_ind  = 0
		           WHERE granular_issue_id   = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".granular_issues WHERE granular_issue_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}
$captn = "Granular Root Causes";
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
           <form method=\"post\" action=\"./reportgroupform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">ID</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Root Cause</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Granular Root Cause</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "select granular_issue_id,granular_issue,granular_issue_ind,issue_type_id 
            from ".$name.".report_groups 
        order by report_group_ind desc,report_group asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid                  = stripslashes($row[0]);
    $xgranular_issue      = stripslashes($row[1]);
    $xgranular_issue_ind  = stripslashes($row[2]);
    $xissue_type_id       = stripslashes($row[3]);
	
	$seq = $seq + 1;
    if ($xgranular_issue_ind == 1) {

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
                 <select name=\"xissue_type_id[$xid]\">
	      ");
          for ($c=1;$c<=$icnt; ++$c) {
               if ($ityp[$c] == $xissue_type_id) {
                   print(" <option selected value=\"$iid[$c]\">$ityp[$c]</option> "); 
               } else {
                   print(" <option value=\"$iid[$c]\">$ityp[$c]</option> ");
               }
          }
          print(" </select>
                 </td>
 	             <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <input type=\"text\" name=\"xgranular_issue[$xid]\" value=\"$xgranular_issue\" size=\"200\" maxlength=\"200\">
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
                }
          else {
             print("
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                    ");
                }
        print("
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
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
	            <td valign=\"middle\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\"> 
                   $xreport_group
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#000000\">
	      ");
          for ($c=1;$c<=$iccnt; ++$c) {
               if ($icid[$c] == $xissue_class_id) {
                   print("$ic[$c]");
               }
          }
          print(" </font>
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
                             <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\"  bgcolor=\"#E8E8E8\" valign=\"middle\">
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
		          <td align=\"center\" valign=\"middle\"bgcolor=\"#E8E8E8\">
		          </td>		          
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_report_group[$x]\" value=\"$new_report_group[$x]\" size=\"50\" maxlength=\"50\">
		          </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\"> 
                   <select name=\"new_issue_class_id[$x]\">
	     ");
         for ($c=1;$c<=$iccnt; ++$c) {
              print(" <option value=\"$icid[$c]\">$ic[$c]</option> ");

         }
         print(" </select>
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
                   <!--<input type=\"submit\" name=\"submit\" value=\"Update\">
                   <input type=\"submit\" name=\"submit\" value=\"Inactive\">
                   <input type=\"submit\" name=\"submit\" value=\"Active\">-->
     ");

if ($delcnt ==0) {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
} else {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
}

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

// Display blank entries for a new records
//if ($submit == "Add") {
//    print("
//                   <input type=\"submit\" name=\"submit\" value=\"Insert\">
//          ");
//}

// End of HTML
print("
                   <!--<input type=\"submit\" name=\"submit\" value=\"Refresh\">-->
                 </td>
                </tr>
            </table>
           </form>
          </body>
         </html>
     ");
?>
