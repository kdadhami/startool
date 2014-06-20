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
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($yissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================

if ($submit == "Submit") {
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

 	         $new_issue_class[$key]      = addslashes(strtoupper($new_issue_class[$key]));
	         $new_issue_class_code[$key] = addslashes(strtoupper($new_issue_class_code[$key]));
	         $new_parent_allowed[$key]   = addslashes(strtoupper($new_parent_allowed[$key]));

             $queryh = "SELECT UPPER(trim(issue_class)) 
                          FROM ".$name.".issue_class
                         WHERE UPPER(trim(issue_class)) = '$new_issue_class[$key]'
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
                $query ="INSERT into ".$name.".issue_class(issue_class,issue_class_ind,issue_class_code,parent_allowed)
                         VALUES('$new_issue_class[$key]',1,'$new_issue_class_code[$key]','$new_parent_allowed[$key]')";

                $mysql_data = mysql_query($query, $mysql_link) or die ("#1 Could not query: ".mysql_error());
            } else {
               echo "<script type=\"text/javascript\">window.alert(\"'$new_issue_class[$key]' Cause Type already exists\")</script>";
            }
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]               = addslashes($xid[$key]);
	    $xissue_class[$key]      = addslashes(strtoupper($xissue_class[$key]));
	    $xissue_class_ind[$key]  = addslashes($xissue_class_ind[$key]);
	    $xissue_class_code[$key] = addslashes($xissue_class_code[$key]);
        $xparent_allowed[$key]   = addslashes($xparent_allowed[$key]); 

  		$query = "UPDATE ".$name.".issue_class
		             SET issue_class      = '$xissue_class[$key]',
                         issue_class_code = '$xissue_class_code[$key]', 
                         issue_class_ind  = 1,
                         parent_allowed   = '$xparent_allowed[$key]'
		           WHERE issue_class_id   = '$key'";
		//print($query);           
		$mysql_data = mysql_query($query, $mysql_link) or die ("#2 Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".issue_class
		             SET issue_class_ind  = 1
		           WHERE issue_class_id   = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("#3 Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".issue_class
		             SET issue_class_ind  = 0
		           WHERE issue_class_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("#4 Could not query: ".mysql_error());
	}
    }

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".issue_class WHERE issue_class_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}
$captn = "Cause Types";
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
           <form method=\"post\" action=\"./issueclassform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">ID</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Cause Types</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Code</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Parent Allowed</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "select issue_class_id,issue_class,issue_class_ind,issue_class_code,parent_allowed 
            from ".$name.".issue_class 
        order by issue_class_ind desc,issue_class asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("#6 Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid               = stripslashes($row[0]);
    $xissue_class      = stripslashes($row[1]);
    $xissue_class_ind  = stripslashes($row[2]);
    $xissue_class_code = stripslashes($row[3]);
    $xparent_allowed   = stripslashes($row[4]);
	
    $query1 = "select issue_class_id 
                 from ".$name.".issue_types 
                where issue_class_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("#7 Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xissue_class_ind == 1) {

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
	            <td align=\"center\" bgcolor=\"#AFDCEC\" valign=\"middle\">
                 <input type=\"text\" name=\"xissue_class[$xid]\" value=\"$xissue_class\" size=\"25\" maxlength=\"25\">
	            </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\" valign=\"middle\">
	             <font color=\"#000000\">
                  $xissue_class_code
                 </font> 
                 <input type=\"hidden\" name=\"xissue_class_code[$xid]\" value=\"$xissue_class_code\">
	            </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\" valign=\"middle\">
                  <select align=\"center\" name=\"xparent_allowed[$xid]\">
                   <font color=\"#000000\">
       ");
       $pchk[1] = 0;
       $pval[1] = "NO";
       $pchk[2] = 1;
       $pval[2] = "YES";
       for ($p=1;$p<=2;++$p) {
            if ($xparent_allowed == $p) {
                print(" <option selected value=\"$p\">$pval[$p]</option>");
            } else {
                print(" <option value=\"$p\">$pval[$p]</option>");
            }   
       }
       print("    </font> 
                 </select>
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                      <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                    </td>
                    <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
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
             print("
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\" valign=\"middle\">
                </td>
                    ");
                }
        print("
	            <td align=\"center\"  bgcolor=\"#E8E8E8\" valign=\"middle\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
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
	            <td valign=\"middle\" bgcolor=\"#AFDCEC\" valign=\"middle\">
	             <font color=\"#000000\"> 
                   $xissue_class
                 </font>
	            </td>
	            <td valign=\"middle\" bgcolor=\"#AFDCEC\" valign=\"middle\">
	             <font color=\"#000000\">
                   $xissue_class_code
                 </font>
                 <input type=\"hidden\" name=\"xissue_class_code[$xid]\" value=\"$xissue_class_code\">
	            </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\" valign=\"middle\">
                  <!--<select align=\"center\" name=\"xparent_allowed[$xid]\">-->
                   <font color=\"#000000\">
       ");
       $pchk[1] = 0;
       $pval[1] = "NO";
       $pchk[2] = 1;
       $pval[2] = "YES";
       for ($p=1;$p<=2;++$p) {
            if ($xparent_allowed == $p) {
                print("<a>$pval[$p]</a>"); 
                //print(" <option selected value=\"$p\">$pval[$p]</option>");
            //} else {
            //    print(" <option value=\"$p\">$pval[$p]</option>");
            }   
       }
       print("    </font> 
                 <!--</select>-->
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                    </td> 
                    <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
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
                 print("<td align=\"center\"  bgcolor=\"#E8E8E8\" valign=\"middle\">
                        </td>
                  ");
                }
        print("
	            <td align=\"center\"  bgcolor=\"#E8E8E8\" valign=\"middle\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
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
		          <td align=\"center\" bgcolor=\"#99CC00\" valign=\"middle\">
		          </td>
		          <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
		          </td>		          
                  <td align=\"center\" bgcolor=\"#FF0000\" valign=\"middle\">
                     <input type=\"text\" name=\"new_issue_class[$x]\" value=\"$new_issue_class[$x]\" size=\"25\" maxlength=\"25\">
		          </td>
                  <td align=\"center\" bgcolor=\"#FF0000\" valign=\"middle\">
                     <input type=\"text\" name=\"new_issue_class_code[$x]\" value=\"$new_issue_class_code[$x]\" size=\"3\" maxlength=\"3\">
		          </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\" valign=\"middle\">
                  <select align=\"center\" name=\"new_parent_allowed[$x]\">
                   <font color=\"#000000\">
       ");
       $pchk[1] = 0;
       $pval[1] = "NO";
       $pchk[2] = 1;
       $pval[2] = "YES";
       for ($p=1;$p<=2;++$p) {
            //if ($xparent_allowed == $p) {
            //    print(" <option selected value=\"$p\">$pval[$p]</option>");
            //} else {
                print(" <option value=\"$p\">$pval[$p]</option>");
            //}   
       }
       print("    </font> 
                 </select>
	            </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                  </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                  </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                  </td>                  
                  <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
                       <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" bgcolor=\"#E8E8E8\" valign=\"middle\">
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
