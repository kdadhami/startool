<?php

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

// Yes and No Values
$ind[0] = "";
$ind[1] = "Yes";
$ind[2] = "No";
$ind_id[0] = 0;
$ind_id[1] = 1;
$ind_id[2] = 0;


if ($submit == "Submit") {
// Insert a record
   //if ($submit == "Insert") {
   if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_issue_area[$key] = addslashes(strtoupper($new_issue_area[$key]));
	        $new_test_ind[$key]   = addslashes(strtoupper($new_test_ind[$key]));
	        $new_short_desc[$key] = addslashes(strtoupper($new_short_desc[$key]));

             $queryh = "SELECT UPPER(trim(issue_area)) 
                          FROM ".$name.".issue_areas
                         WHERE UPPER(trim(issue_area)) = '$new_issue_area[$key]'
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
                 $query ="INSERT into ".$name.".issue_areas(issue_area,issue_area_ind,test_ind,short_desc)
                          VALUES('$new_issue_area[$key]',1,'$new_test_ind[$key]','$new_short_desc[$key]')";
                 //print($query); 
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
             } else {
                 echo "<script type=\"text/javascript\">window.alert(\"Department '$new_issue_area[$key]' already exists\")</script>";
             }
           }
   }

   // Update all edited records
   //if ($update && $submit == "Update") {
   if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]             = addslashes($xid[$key]);
	    $xissue_area[$key]     = addslashes(strtoupper($xissue_area[$key]));
	    $xissue_area_ind[$key] = addslashes($xissue_area_ind[$key]);
	    $xtest_ind[$key]       = addslashes($xtest_ind[$key]);

  		$query = "UPDATE ".$name.".issue_areas
		             SET
                         issue_area     = '$xissue_area[$key]',
                         issue_area_ind = 1,
                         test_ind       = '$xtest_ind[$key]'
		           WHERE issue_area_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
   }

   // Activate all selected records
   //if ($active && $submit == "Active") {
   if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".issue_areas
		             SET
                         issue_area_ind  = 1
		           WHERE issue_area_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
   }

   // Inactivate all selected records
   //if ($inactive && $submit == "Inactive") {
   if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".issue_areas
		             SET
                         issue_area_ind  = 0
		           WHERE issue_area_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
   }

   // Delete all selected records
   //if ($delete && $submit == "Delete") {
   if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".issue_areas WHERE issue_area_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	}
   }
}
$captn = "Departments";
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
          <!--<h1 align=\"center\">XYZ<h1>-->
           <form method=\"post\" action=\"./issueareasform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <!--<tr><td colspan=\"10\" align=\"center\" bgcolor=\"#00CCFF\">Setup Departments</td>
             </tr>-->
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Id</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Departments</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Test</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Code</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "select issue_area_id,issue_area,issue_area_ind,test_ind,short_desc from ".$name.".issue_areas order by issue_area_ind desc,issue_area asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid             = stripslashes($row[0]);
    $xissue_area     = stripslashes($row[1]);
    $xissue_area_ind = stripslashes($row[2]);
    $xtest_ind       = stripslashes($row[3]);
    $xshort_desc     = stripslashes($row[4]);
	
    $query1 = "select issue_area_id from ".$name.".issue_history where issue_area_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xissue_area_ind == 1) {

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
	            <td align=\"center\" bgcolor=\"#AFDCEC\">
                    <input type=\"text\" name=\"xissue_area[$xid]\" value=\"$xissue_area\" size=\"50\" maxlength=\"50\">
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <select align=\"center\" name=\"xtest_ind[$xid]\">  
               ");
         $w = 0;
         for ($w=1;$w<=2; ++$w) {
              if ($ind_id[$w] == $xtest_ind) {
                  print(" <option selected value=\"$ind_id[$w]\">$ind[$w]</option> ");
              }
              else {
                  print(" <option value=\"$ind_id[$w]\">$ind[$w]</option> ");
              }
         }
         print(" </select>
                </td>
	            <td align=\"center\" bgcolor=\"#E8E8E8\">
                 <font color=\"#000000\"> 
                  $xshort_desc
                 </font>
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                    </td>
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                    </td>                
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                     print("
                             <td align=\"center\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\"  bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 } 
                }
          else {
             print("
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                    ");
                }
        print("
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\">
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
	            <td valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <!--<input type=\"text\" name=\"xissue_area[$x]\" value=\"$xissue_area\" size=\"50\" maxlength=\"50\">-->
	             <font color=\"#000000\"> 
                    $xissue_area
                 </font> 
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <font color=\"#000000\">  
               ");
         $w = 0;
         for ($w=1;$w<=2; ++$w) {
              if ($ind_id[$w] == $xtest_ind) {
                  print($ind[$w]);
              }
         }
         print("  
                 </font>
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                   $xshort_desc
                 </font> 
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                    </td> 
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                        <input type=\"checkbox\" name=\"active[$xid]\" value=\"Active\">
                    </td>
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                      print("
                             <td align=\"center\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                             </td>
                            ");
                 } else {
                           print(" <td align=\"center\"  bgcolor=\"#E8E8E8\">
                                   </td>
                                ");              
                 }
                }
          else {
                 print("<td align=\"center\"  bgcolor=\"#E8E8E8\">
                        </td>
                  ");
                }
        print("
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\">
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
		          <td align=\"center\" bgcolor=\"#99CC00\">
		          </td>
		          <td align=\"center\" bgcolor=\"#E8E8E8\">
		          </td>		          
                  <td align=\"center\" bgcolor=\"#FF0000\">
                   <input type=\"text\" name=\"new_issue_area[$x]\" value=\"$new_issue_area[$x]\" size=\"50\" maxlength=\"50\">
		          </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                   <select align=\"center\" name=\"new_test_ind[$x]\">  
               ");
         //$w = 0;
         for ($w=0;$w<=2; ++$w) {
              //if ($ind_id[$w] == $xtest_ind) {
                  //print(" <option selected value=\"$ind_id[$w]\">$ind[$w]</option> ");
              //}
              //else {
                  print(" <option value=\"$ind_id[$w]\">$ind[$w]</option> ");
              //}
         }
         print("   </select>
                  </td>
                  <td align=\"center\" bgcolor=\"#FF0000\">
                   <input type=\"text\" name=\"new_short_desc[$x]\" value=\"$new_short_desc[$x]\" size=\"4\" maxlength=\"4\">
		          </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\">
                  </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\">
                  </td>                  
                  <td align=\"center\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" bgcolor=\"#E8E8E8\">
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

// Select no. of new inserts
//if ($submit != "Add") {
//    print("
//                   <input type=\"submit\" name=\"submit\" value=\"Add\">
//                    <select name =\"num_records\">
//                      <option value=\"1\">1</optons>
//                      <option value=\"2\">2</optons>
//                      <option value=\"3\">3</optons>
//                      <option value=\"4\">4</optons>
//                      <option value=\"5\">5</optons>
//                    </select>
//          ");
//}

// Display blank entries for a new records
//if ($submit == "Add") {
//    print("
//                   <!--<input type=\"submit\" name=\"submit\" value=\"Insert\">-->
//          ");
//}

// End of HTML
print("            <input type=\"submit\" name=\"submit\" value=\"Submit\">
     ");

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
print("             <!--<input type=\"submit\" name=\"submit\" value=\"Refresh\">-->
                 </td>
                </tr>
            </table>
           </form>
          </body>
         </html>
     ");
?>
