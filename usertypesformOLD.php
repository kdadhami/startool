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
$trans = "loop";
// ==============================

// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
                  where issue_area_ind = 1
                     or UPPER(trim(issue_area)) = 'ADMIN'  
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

// Insert a record
if ($submit == "Submit") {
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_user_type[$key]     = addslashes(strtoupper($new_user_type[$key]));
	        $new_menu[$key]          = addslashes(trim($new_menu[$key]));
            $new_issue_area_id[$key] = addslashes($new_issue_area_id[$key]);
            
            $queryh = "SELECT UPPER(user_type) FROM user_types where UPPER(trim(user_type)) = '$new_user_type[$key]'";
            //print($queryh);
            $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnth = mysql_num_rows($mysql_datah);
            
            //while($rowh = mysql_fetch_row($mysql_datah)) {
	              //$yuser_type = strtoupper(stripslashes($rowh[0]));
                  //if ($yuser_type == $new_lanid[$key]) {
                  if ($rowcnth > 0) {
                      $insert_ind = 1;
                  } else {
                  	  $insert_ind = 0;
                  }
            //}
             if ($insert_ind == 0){
                 $query ="INSERT into ".$name.".user_types(user_type,user_type_ind,menu,issue_area_id)
                          VALUES('$new_user_type[$key]',1,'$new_menu[$key]','$new_issue_area_id[$key]')";
                 //print($query);         
                 $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
             } else {
                 echo "<script type=\"text/javascript\">window.alert(\"User Type Already Exists\")</script>";
             }
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]             = addslashes($xid[$key]);
	    $xuser_type[$key]      = addslashes(strtoupper($xuser_type[$key]));
	    $xuser_type_ind[$key]  = addslashes($xuser_type_ind[$key]);
	    $xmenu[$key]           = addslashes($xmenu[$key]);
        $xissue_area_id[$key]  = addslashes($xissue_area_id[$key]);	    

  		$query = "UPDATE ".$name.".user_types
		             SET
                         user_type     = '$xuser_type[$key]',
                         user_type_ind = 1,
                         menu          = '$xmenu[$key] ',
                         issue_area_id = '$xissue_area_id[$key]' 
		           WHERE user_type_id = '$key'";
		//print($query);             
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$query = "UPDATE ".$name.".user_types
		             SET
                         user_type_ind = 0
		           WHERE user_type_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$query = "UPDATE ".$name.".user_types
		             SET
                         user_type_ind = 1
		           WHERE user_type_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".user_types WHERE user_type_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}    
$captn = "Setup User Types";
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
           <form method=\"post\" action=\"./usertypesform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">id</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">User Type</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Department</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Menu File</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>               
             </tr>
      ");

$query = "select a.user_type_id,a.user_type,a.user_type_ind,a.menu,a.issue_area_id,b.issue_area 
            from ".$name.".user_types a, ".$name.".issue_areas b 
           where a.issue_area_id = b.issue_area_id
          order by b.issue_area,a.user_type ";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;
    
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid             = stripslashes($row[0]);
    $xuser_type      = stripslashes($row[1]);
    $xuser_type_ind  = stripslashes($row[2]);    
    $xmenu           = stripslashes($row[3]);
    $xissue_area_id  = stripslashes($row[4]);    

    $query1 = "select user_type_id from ".$name.".users where user_type_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);
	
	$seq = $seq + 1;
    if ( $xuser_type_ind == 1 ) {

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
                    <input type=\"text\" name=\"xuser_type[$xid]\" value=\"$xuser_type\" size=\"20\" maxlength=\"20\">
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <select align=\"center\" name=\"xissue_area_id[$xid]\"> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               if ($did[$w] == $xissue_area_id) {
                   print(" <option selected value=\"$did[$w]\">$dpt[$w]</option> ");
               }
               else {
                   print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
               }
          }
          print("   </select>
                   </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                    <input type=\"text\" name=\"xmenu[$xid]\" value=\"$xmenu\" size=\"45\" maxlength=\"45\">
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
	            <td valign=\"middle\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xuser_type
                 </font>  
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xissue_area_id[$xid]\">--> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               if ($did[$w] == $xissue_area_id) {
                   //print(" <option selected value=\"$did[$w]\">$dpt[$w]</option> ");
	               print("<font color=\"#000000\"> 
                           $dpt[$w]
                          </font>
                   ");         
               }
          }
          print("   </select>
                   </td>
	            <td valign=\"middle\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xmenu
                 </font>  
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
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_user_type[$x]\" value=\"$new_user_type[$x]\" size=\"20\" maxlength=\"20\">
		          </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                   <select align=\"center\" name=\"new_issue_area_id[$x]\"> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
          }
          print("   </select>
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_menu[$x]\" value=\"$new_menu[$x]\" size=\"45\" maxlength=\"45\">
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
                   <input type=\"submit\" name=\"submit\" value=\"Submit\">                                      
     ");

if ($delcnt ==0) {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
} else {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
}

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
if ($submit == "Add") {
    print("
                   <!--<input type=\"submit\" name=\"submit\" value=\"Insert\">-->
          ");
}

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
