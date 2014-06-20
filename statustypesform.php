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
}
//$trans = "loop";
// ==============================

if ($submit == "Submit") {
// Insert a record
if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_status_type[$key]         = addslashes(strtoupper($new_status_type[$key]));
	        $new_status_color_code[$key]   = addslashes(strtoupper($new_status_color_code[$key]));

            $query ="INSERT into ".$name.".status_types(status_type,status_type_ind,status_color_code)
                            VALUES('$new_status_type[$key]',1,'$new_status_color_code[$key]')";

            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

// Update all edited records
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]                = addslashes($xid[$key]);
	    $xstatus_type[$key]       = addslashes(strtoupper($xstatus_type[$key]));
	    $xstatus_type_ind[$key]   = addslashes($xstatus_type_ind[$key]);
	    $xstatus_color_code[$key] = addslashes($xstatus_color_code[$key]);

  		$query = "UPDATE ".$name.".status_types
		             SET
                         status_type       = '$xstatus_type[$key]',
                         status_type_ind   = 1,
                         status_color_code = '$xstatus_color_code[$key]'
		           WHERE status_type_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Activate all selected records
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".status_types
		             SET
                         status_type_ind  = 1
		           WHERE status_type_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".status_types
		             SET
                         status_type_ind  = 0
		           WHERE status_type_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Delete all selected records
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".status_types WHERE status_type_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}

$captn = "Setup Status Types";
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
           <form method=\"post\" action=\"./statustypesform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <!--<tr><td colspan=\"9\" align=\"center\" bgcolor=\"#00CCFF\">Setup Status Types</td>
             </tr>-->
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">id</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Status Type</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Color Code</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font</td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>               
             </tr>
      ");

$query = "select status_type_id,status_type,status_type_ind,status_color_code from ".$name.".status_types order by status_type_ind desc,status_type asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid                = stripslashes($row[0]);
    $xstatus_type       = stripslashes($row[1]);
    $xstatus_type_ind   = stripslashes($row[2]);
    $xstatus_color_code = stripslashes($row[3]);
	
    $query1 = "select status_type_id from ".$name.".complexity where status_type_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

    $query2 = "select status_type_id from ".$name.".revenue where status_type_id = '$xid' ";
    $mysql_data2 = mysql_query($query2, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt2 = mysql_num_rows($mysql_data2);
    
    $query3 = "select status_type_id from ".$name.".projection where status_type_id = '$xid' ";
    $mysql_data3 = mysql_query($query3, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt3 = mysql_num_rows($mysql_data3);       

    $query4 = "select status_type_id from ".$name.".comparison where status_type_id = '$xid' ";
    $mysql_data4 = mysql_query($query4, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt4 = mysql_num_rows($mysql_data4);    

	$seq = $seq + 1;
    if ($xstatus_type_ind == 1) {

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
                    <input type=\"text\" name=\"xstatus_type[$xid]\" value=\"$xstatus_type\" size=\"30\" maxlength=\"30\">
	            </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\">
                    <input type=\"text\" name=\"xstatus_color_code[$xid]\" value=\"$xstatus_color_code\" size=\"10\" maxlength=\"10\">
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
	            <td valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xstatus_type
                 </font>  
	            </td>
	            <td valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
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
                 if (($rowcnt1 == 0) or ($rowcnt2 == 0) or ($rowcnt3 == 0) or ($rowcnt4 == 0))  {
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
                     <input type=\"text\" name=\"new_status_type[$x]\" size=\"30\" maxlength=\"30\">
		          </td>
                  <td align=\"center\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_status_color_code[$x]\" size=\"10\" maxlength=\"10\">
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

//if ($delcnt ==0) {
//    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
//} else {
//    print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
//}

print("   <input type=\"submit\" name=\"submit\" value=\"Submit\">

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
//                   <!--<input type=\"submit\" name=\"submit\" value=\"Insert\">-->
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
