<?php

// ----------------------------
// Author: Kashif Adhami
// Dated: October, 2010
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
	        $new_pdp_period[$key]   = addslashes(strtoupper($new_pdp_period[$key]));

             $queryh = "SELECT UPPER(trim(pdp_period)) 
                          FROM ".$name.".pdp_periods
                         WHERE UPPER(trim(pdp_period)) = '$new_pdp_period[$key]'
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
                $query ="INSERT into ".$name.".pdp_periods(pdp_period,pdp_period_ind)
                         VALUES('$new_pdp_period[$key]',1)";
                $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
            } else {
                echo "<script type=\"text/javascript\">window.alert(\"PDP Type '$new_pdp_period[$key]' already exists\")</script>";
            }
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]              = addslashes($xid[$key]);
	    $xpdp_period[$key]      = addslashes(strtoupper($xpdp_period[$key]));
	    $xpdp_period_ind[$key]  = addslashes($xpdp_period_ind[$key]);

  		$query = "UPDATE ".$name.".pdp_periods
		             SET
                         pdp_period      = '$xpdp_period[$key]',
                         pdp_period_ind  = 1
		           WHERE pdp_period_id = '$key'";
		//print($query);           
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".pdp_periods
		             SET 
                         pdp_period_ind  = 1
		           WHERE pdp_period_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".pdp_periods
		             SET
                         pdp_period_ind  = 0
		           WHERE pdp_period_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".pdp_periods WHERE pdp_period_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}

$captn = "PDP Types";
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
           <form method=\"post\" action=\"./pdptypesform2.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Id</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Types</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
");

$query = "select pdp_period_id,pdp_period,pdp_period_ind from ".$name.".pdp_periods order by pdp_period_ind desc,pdp_period asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid              = stripslashes($row[0]);
    $xpdp_period      = stripslashes($row[1]);
    $xpdp_period_ind  = stripslashes($row[2]);
	
    $query1 = "select pdp_period_id from ".$name.".pdp where pdp_period_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xpdp_period_ind == 1) {

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
                    <input type=\"text\" name=\"xpdp_period[$xid]\" value=\"$xpdp_period\" size=\"15\">
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                      <!--<input type=\"radio\" name=\"chkbx[$xid]\" value=\"Inactive\">
                      <input type=\"hidden\" name=\"inactive[$xid]\">-->
                    </td>
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                    </td>                
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                     print("
                             <td align=\"center\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                               <!--<input type=\"radio\" name=\"chkbx[$xid]\" value=\"Delete\">
                               <input type=\"hidden\" name=\"delete[$xid]\">-->
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
                   <!--<input type=\"radio\" name=\"chkbx[$xid]\" value=\"Update\">
                   <input type=\"hidden\" name=\"update[$xid]\">-->
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
	              <font color=\"#000000\"> 
                   $xpdp_period
	              </font> 
                  <input type=\"hidden\" name=\"xpdp_period[$xid]\" value=\"$xpdp_period\" size=\"15\">
	            </td>
	      ");

	      if ($rowcnt > 0) {
	         print("
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                    </td> 
                    <td align=\"center\" bgcolor=\"#E8E8E8\">
                        <input type=\"checkbox\" name=\"active[$xid]\" value=\"Active\">
                        <!--<input type=\"radio\" name=\"chkbx[$xid]\" value=\"Active\">
                        <input type=\"hidden\" name=\"active[$xid]\">-->
                    </td>
                  ");
                 if ($rowcnt1 == 0) {
                     $delcnt = $delcnt + 1;
                      print("
                             <td align=\"center\" bgcolor=\"#E8E8E8\">
                               <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                               <!--<input type=\"radio\" name=\"chkbx[$xid]\" value=\"Delete\">
                               <input type=\"hidden\" name=\"delete[$xid]\">-->
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
  	                 <input type=\"text\" name=\"new_pdp_period[$x]\" value=\"$new_pdp_period\" size=\"15\">
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
