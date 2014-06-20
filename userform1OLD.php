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

// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
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

//------------------------------------------
// Loading project types in prj_typ array
$queryp = "select user_type_id,user_type 
             from ".$name.".user_types 
           order by user_type  ";
$mysql_datap = mysql_query($queryp, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntp = mysql_num_rows($mysql_datap);

//print $rowcntp;
$xy1 = 0; 
while($row = mysql_fetch_row($mysql_datap)) {
      $xy1 = $xy1 + 1;
      $yusr_typ_id = stripslashes(trim($row[0]));
      $yusr_typ    = stripslashes(trim($row[1]));
      $usr_typ_id[$xy1]  = $yusr_typ_id;
      $usr_typ[$xy1]     = $yusr_typ;
//-----------------------------------------
}

if ($submit == "Submit") {
$insert_ind = 0;    
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {
	        $new_lanid[$key]         = addslashes(strtoupper(trim($new_lanid[$key])));
	        $new_fullname[$key]      = addslashes(strtoupper(trim($new_fullname[$key])));
	        $new_user_type_id[$key]  = addslashes($new_user_type_id[$key]);
	        $new_paswd[$key]         = addslashes($new_paswd[$key]);
	        $new_issue_area_id[$key] = addslashes($new_issue_area_id[$key]); 
            //print(strlen($new_lanid[$key]).strlen($new_fullname[$key]).strlen($new_pswd[$key]));

            $queryh = "SELECT lanid, paswd FROM users where UPPER(trim(lanid)) = '$new_lanid[$key]'";
            //print($queryh);
            $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnth = mysql_num_rows($mysql_datah);

            if ($rowcnth == 1) {
                    // duplicate primary value check 
                    $insert_ind = 1;
            } else {
                    //blank check
                    if ( strlen($new_lanid[$key])    == 0 || 
                         strlen($new_fullname[$key]) == 0 || 
                         strlen($new_paswd[$key])     == 0 
                       ) 
                    { $insert_ind = 2;
                    } else {
                      // all good to insert
                  	  $insert_ind = 0;
                    }	  
              //}
              //}
            }
            
            if ($insert_ind == 0){
                $query = "INSERT into ".$name.".users(lanid,fullname,user_type_id,paswd,issue_area_id)
                          VALUES('$new_lanid[$key]','$new_fullname[$key]','$new_user_type_id[$key]',
                                  sha1('$new_paswd[$key]'),'$new_issue_area_id[$key]')";
                //print($query);  
                $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
            } else {
                if ( $insert_ind == 1) {
                     echo "<script type=\"text/javascript\">window.alert(\"User Already Exists\")</script>";
                }
                if ( $insert_ind == 2) {
                     echo "<script type=\"text/javascript\">window.alert(\"Value cannot be empty\")</script>";
                }
            }
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
$update_ind = 0;
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]               = addslashes($xid[$key]);
	    $xlanid[$key]            = addslashes(strtoupper(trim($xlanid[$key])));
	    $xfullname[$key]         = addslashes(strtoupper(trim($xfullname[$key])));
	    $xuser_type_id[$key]     = addslashes($xuser_type_id[$key]);
	    $xpaswd[$key]            = addslashes($xpaswd[$key]);
        $xissue_area_id[$key]    = addslashes($xissue_area_id[$key]); 	    

            $queryh = "SELECT UPPER(trim(lanid)),paswd FROM users where UPPER(trim(lanid)) = '$xlanid[$key]'";
            //print($queryh);
            $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnth = mysql_num_rows($mysql_datah);

            if ($rowcnth == 1) {
                    // duplicate primary value check 
                    $update_ind = 1;
            } else {
                    //blank check
                    if ( strlen($xlanid[$key])    == 0 || 
                         strlen($xfullname[$key]) == 0 || 
                         strlen($xpaswd[$key])    == 0 
                       ) 
                    { $update_ind = 2;
                    } else {
                      // all good to insert
                  	  $update_ind = 0;
                    }	  
              //}
              //}
            }

        if ($update_ind == 0){  
            $query2 = "select paswd from ".$name.".users where lanid = '$xlanid[$key]' "; 
            $mysql_data2 = mysql_query($query2, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnt2 = mysql_num_rows($mysql_data2);
            while($row2 = mysql_fetch_row($mysql_data2)) {
                  $ypaswd  = stripslashes($row2[0]);
                  $ypaswd2 = sha1($ypaswd);
            }
	        if ($ypaswd === $xpaswd[$key]){
  		        $query = "UPDATE ".$name.".users
		                     SET user_type_id  = '$xuser_type_id[$key]',
                                 issue_area_id = '$xissue_area_id[$key]' 
		                   WHERE user_id = '$key'";
		    //print("Matched");
            } else {
  		        $query = "UPDATE ".$name.".users
		             SET user_type_id = '$xuser_type_id[$key]',
                         issue_area_id = '$xissue_area_id[$key]',
                         paswd        = sha1('$xpaswd[$key]')
		           WHERE user_id = '$key'";
		    //print("UnMatched");
            } 
		    $mysql_data = mysql_query($query, $mysql_link) or die ("#1 Could not query: ".mysql_error());
        } else {
                if ( $update_ind == 1) {
                     echo "<script type=\"text/javascript\">window.alert(\"User Already Exists\")</script>";
                }
                if ( $update_ind == 2) {
                     echo "<script type=\"text/javascript\">window.alert(\"Value cannot be empty\")</script>";
                }
        }
	}
}

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".users WHERE user_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}
// -------------------------------------
// Start of the check-01
//if (isset($yrelid) && isset($yprjtyp)) {
// -------------------------------------

$captn = "Setup Users";
// Start of HTMl
print("<html>
        <head>
          <!--<link rel=\"stylesheet\" type=\"text/css\" href=\"css/common.css\">-->
           <style>
             html {height: 100%;}
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
           div.scrollWrapper{
                   /*float:left;*/
                   margin-left: auto; 
                   margin-right: auto;
                   /*overflow:visible*/ /*!important;*/
                   /*overflow:scroll;*/
                   height:90%;  /*600px;*/
                  }
           /*div.scrollWrapper.table{
                   margin-left: auto; 
                   margin-right: auto;
                  }*/
           table.scrollable{
                   width:90%;   /*600px;*/
                   margin-right:0 /*!important;*/
                   margin-right:16px;
                   border-collapse:separate;
                  }
           table.scrollable tbody{
                   height:90%; /*600px;*/
                   /*overflow:auto;*/
                   overflow-x:hidden;
                   overflow-y:auto;
                  }
           </style>       

        </head>
        <body>
         <div id=\"content\">
          <form method=\"post\" action=\"./userform1.php\">
            <table border='0' align=\"center\" style=\"width=100%;\">
             <caption>$captn</caption>
              <tr>
                <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Id</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">lan Id</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Password</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Full Name</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">User Type</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Department</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>
              </tr>
      ");

$query = "select a.user_id,UPPER(trim(a.lanid)),a.fullname,a.user_type_id,a.paswd,a.issue_area_id 
            from ".$name.".users a, ".$name.".issue_areas b 
           where a.issue_area_id = b.issue_area_id
        order by b.issue_area,a.user_type_id,a.fullname "; 
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid            = stripslashes($row[0]);
    $xlanid         = stripslashes($row[1]);
	$xfullname      = stripslashes($row[2]);
	$xuser_type_id  = stripslashes($row[3]);
	$xpaswd         = stripslashes($row[4]);
    $xissue_area_id = stripslashes($row[5]);

    $query1      = "select UPPER(trim(created_by)) from ".$name.".issues where UPPER(trim(created_by)) = '$xlanid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1     = mysql_num_rows($mysql_data1);

    $seq = $seq + 1;
	print("   <tr rowspan=\"10\" valign=\"top\" scroll=\"yes\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                 $seq 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                  $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <input type=\"text\" name=\"xlanid[$xid]\" value=\"$xlanid\" size=\"25\" maxlength=\"45\">
                 <!--<font color=\"#330099\">
                  $xlanid
                 </font>-->                 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <input type=\"password\" name=\"xpaswd[$xid]\" value=\"$xpaswd\" size=\"20\" maxlength=\"50\">
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <input type=\"text\" name=\"xfullname[$xid]\" value=\"$xfullname\" size=\"25\" maxlength=\"45\">
                 <!--<font color=\"#330099\">
                  $xfullname
                 </font>--> 
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <select align=\"center\" name=\"xuser_type_id[$xid]\"> 
          ");
          $v = 0;
          for ($v=1;$v<=$rowcntp; ++$v) {
               if ($usr_typ_id[$v] == $xuser_type_id) {
                   print(" <option selected value=\"$usr_typ_id[$v]\">$usr_typ[$v]</option> ");
               }
               else {
                   print(" <option value=\"$usr_typ_id[$v]\">$usr_typ[$v]</option> ");
               }
          }
          print("
                 </select>
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
           ");          
	      if ($rowcnt > 0) {
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
                   print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                           </td>
                         ");
               }
     print("    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
	          </tr>
	 ");
}

// Display blank entry for a new record to be inserted
if ($submit == "Add") {
    //$n_prj_uat[1] = "YES";
    //$n_prj_uat[2] = "NO";

    //$n_prj_prod_v[1] = "YES";
    //$n_prj_prod_v[2] = "NO";

    //$n_anser[1] = "Y";
    //$n_anser[2] = "N";

    for ($x=1;$x<=$num_records; ++$x) {
		 print("
                <tr>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
		          </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
		          </td>		          
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <input type=\"text\" name=\"new_lanid[$x]\" value=\"$new_lanid[$x]\" size=\"28\" maxlength=\"45\">
                  </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                   <input type=\"password\" name=\"new_paswd[$x]\" value=\"$new_paswd[$x]\" size=\"20\" maxlength=\"50\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <input type=\"text\" name=\"new_fullname[$x]\" value=\"$new_fullname[$x]\" size=\"25\" maxlength=\"45\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <select name=\"new_user_type_id[$x]\">
          ");
          for ($e=1;$e<=$rowcntp; ++$e) {
               print(" <option selected value=\"$usr_typ_id[$e]\">$usr_typ[$e]</option> ");
	      }
          print("  </select>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                    <select align=\"center\" name=\"new_issue_area_id[$x]\"> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               print(" <option value=\"$did[$w]\">$dpt[$w]</option> ");
          }
          print("   </select>
                   </td>
                  </td>
	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  </td>
		        </tr>
		      ");
	}
}

// Display options
print("     </table>
            <table border='0' align=\"center\">
                <tr>
                 <td>
                   <br />
                   <input type=\"submit\" name=\"submit\" value=\"Submit\">
     ");

//if ($delcnt ==0) {
//    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
//} else {
//    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
//}

// Select no. of new inserts
if ($submit != "Add") {
    print("         <input type=\"submit\" name=\"submit\" value=\"Add\">
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
print("          </td>
                </tr>
            </table>
           </form>
          </div>   
         </body>
        </html>
");

// --------------------------     
// End of the check-01
//}
// --------------------------

     
?>
