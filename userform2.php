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
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#88 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)) FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#sesssion Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($uissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================

// ============================== DEPARTMENT START ==============================
$queryx2      = "select issue_area_id,issue_area,short_desc,issue_area_ind,test_ind 
                   from ".$name.".issue_areas
                  where issue_area_ind = 1 
               order by issue_area_id ";
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#107 Could not query: ".mysql_error());
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
            where UPPER(trim(user_type)) = 'SIGNOUT' 
          ";
$mysql_datap = mysql_query($queryp, $mysql_link) or die ("#106 Could not query: ".mysql_error());
$rowcntp = mysql_num_rows($mysql_datap);

//print $rowcntp;
$xy1 = 0; 
while($row = mysql_fetch_row($mysql_datap)) {
      $xy1 = $xy1 + 1;
      $yusr_typ_id = stripslashes(trim($row[0]));
      $yusr_typ    = stripslashes(trim($row[1]));
      $usr_typ_id[$xy1]  = $yusr_typ_id;
      $usr_typ[$xy1]     = $yusr_typ;
}

if ($submit == "Submit") {    
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {
	        $new_lanid[$key]         = addslashes(strtoupper(trim($new_lanid[$key])));
	        $new_fullname[$key]      = addslashes(strtoupper(trim($new_fullname[$key])));
	        $new_user_type_id[$key]  = $usr_typ_id[$xy1];
	        $new_pswd[$key]          = "pdp";
	        $new_issue_area_id[$key] = addslashes($new_issue_area_id[$key]); 

            $queryh = "SELECT lanid,paswd FROM users where UPPER(lanid) = '$new_lanid[$key]'";
            //print($queryh);
            $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#105 Could not query: ".mysql_error());

            while($rowh = mysql_fetch_row($mysql_datah)) {
	              $yuserid = strtoupper(stripslashes($rowh[0]));
	              $ypaswd  = stripslashes($rowh[1]);
                  if ($yuserid == $new_lanid[$key]) {
                      $insert_ind = 1;
                  }else{
                  	  $insert_ind = 0;
                  }
            }

            if ($insert_ind == 0){
                $query = "INSERT into ".$name.".users(lanid,fullname,issue_area_id,paswd,user_type_id)
                          VALUES('$new_lanid[$key]','$new_fullname[$key]','$new_issue_area_id[$key]',sha1('$new_pswd[$key]'),
                                  $new_user_type_id[$key])";
                //print($query);  
                $mysql_data = mysql_query($query, $mysql_link) or die ("#104 Could not query: ".mysql_error());
            } else {
                echo "<script type=\"text/javascript\">window.alert(\"User Already Exists\")</script>";
            }
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]               = addslashes($xid[$key]);
	    $xlanid[$key]            = addslashes(strtoupper(trim($xlanid[$key])));
	    $xfullname[$key]         = addslashes(strtoupper(trim($xfullname[$key])));
	    //$xuser_type_id[$key]     = addslashes($xuser_type_id[$key]);
	    //$xpaswd[$key]            = addslashes($xpaswd[$key]);
        $xissue_area_id[$key]    = addslashes($xissue_area_id[$key]); 	    

        $query2 = "select paswd from ".$name.".users where lanid = '$xlanid[$key]' "; 
        $mysql_data2 = mysql_query($query2, $mysql_link) or die ("#102 Could not query: ".mysql_error());
        $rowcnt2 = mysql_num_rows($mysql_data2);
        while($row2 = mysql_fetch_row($mysql_data2)) {
              $ypaswd  = stripslashes($row2[0]);
              $ypaswd2 = sha1($ypaswd);
              
        }
	    if ($ypaswd === $xpaswd[$key]){
  		    $query = "UPDATE ".$name.".users
		             SET
                         lanid         = '$xlanid[$key]',
                         fullname      = '$xfullname[$key]',
                         issue_area_id = '$xissue_area_id[$key]' 
		           WHERE user_id = '$key'";
		//print("Matched");
        } else {
  		        $query = "UPDATE ".$name.".users
		             SET
                         lanid        = '$xlanid[$key]',
                         fullname     = '$xfullname[$key]',
                         issue_area_id = '$xissue_area_id[$key]'
		           WHERE user_id = '$key'";
		//print("UnMatched");
        } 
        //print($query);
  		//$query = "UPDATE ".$name.".users
		//             SET
        //                 lanid        = '$xlanid[$key]',
        //                 fullname     = '$xfullname[$key]',
        //                 user_type_id = '$xuser_type_id[$key]',
        //                 paswd        = sha1('$xpaswd[$key]')
		//           WHERE user_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("#101 Could not query: ".mysql_error());
	}
}

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$query = "UPDATE ".$name.".users
		             SET
                         user_ind = 0
		           WHERE user_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("#inactive Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$query = "UPDATE ".$name.".users
		             SET
                         user_ind = 1
		           WHERE user_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("#active Could not query: ".mysql_error());
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
          <form method=\"post\" action=\"./userform2.php\">
            <table border='0' align=\"center\" style=\"width=100%;\">
             <caption>$captn</caption>
             <thead>  
              <tr>
                <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Id</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">lan Id</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Full Name</font</td>
                <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Department</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>
              </tr>
             </thead>
             <tbody>
      ");

$query = "select user_id,lanid,fullname,user_type_id,paswd,issue_area_id,user_ind 
            from ".$name.".users
           where issue_area_id = '$uissue_area_id' 
            order by issue_area_id,fullname"; 
$mysql_data = mysql_query($query, $mysql_link) or die ("#100 Could not query: ".mysql_error());
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
	$xuser_ind      = stripslashes($row[6]);

    $seq = $seq + 1;
	if ( $xuser_ind == 1 ) {
	     print("   
		       <tr rowspan=\"10\" valign=\"top\" scroll=\"yes\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <input type=\"text\" name=\"xlanid[$xid]\" value=\"$xlanid\" size=\"28\" maxlength=\"45\">
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <input type=\"text\" name=\"xfullname[$xid]\" value=\"$xfullname\" size=\"25\" maxlength=\"45\">
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               if ($did[$w] == $uissue_area_id) {
	               print(" <font color=\"#000000\"> 
                            $dpt[$w]
                           </font>
                           <input type=\"hidden\" name=\"xissue_area_id[$xid]\" value=\"$did[$w]\">     
                   ");          
               }
          }
          print(" </td>
          ");          
	      if ($rowcnt > 0) {
	          print("
                     <td align=\"center\" bgcolor=\"#E8E8E8\">
                         <input type=\"checkbox\" name=\"inactive[$xid]\" value=\"Inactive\">
                     </td>
                     <td align=\"center\" bgcolor=\"#E8E8E8\">
                     </td>                
              ");
           } else {
                   print(" <td align=\"center\"  bgcolor=\"#E8E8E8\">
                           </td>
						   <td align=\"center\"  bgcolor=\"#E8E8E8\">
                           </td>
                   ");
          }
          print(" 
   	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	            <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
                </td>
	          </tr>
	      ");
	 } else {
	     print("   
		       <tr rowspan=\"10\" valign=\"top\" scroll=\"yes\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#808080\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#808080\"> 
				  $xlanid
                 </font>   
	            </td>
	            <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#808080\"> 
                    $xfullname
                 </font>   
	            </td>
                <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\">
				 <font color=\"#808080\"> 
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               if ($did[$w] == $uissue_area_id) {
	               print(" <a> $dpt[$w] </a> ");          
               }
          }
          print(" </font>
		         </td>
          ");          
	      if ($rowcnt > 0) {
	          print("
                     <td align=\"center\" bgcolor=\"#E8E8E8\">
                     </td>                
                     <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                      <input type=\"checkbox\" name=\"active[$xid]\" value=\"Active\">
                     </td>
              ");
          } else {
                   print(" <td align=\"center\"  bgcolor=\"#E8E8E8\">
                           </td>
						   <td align=\"center\"  bgcolor=\"#E8E8E8\">
                           </td>
                   ");
          }
          print(" 
   	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
	            <td align=\"center\" valign=\"middle\"  bgcolor=\"#E8E8E8\">
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
                   <input type=\"text\" name=\"new_lanid[$x]\" value=\"$new_lanid[$x]\" size=\"28\" maxlength=\"45\">
                  </td>
                  <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                   <input type=\"text\" name=\"new_fullname[$x]\" value=\"$new_fullname[$x]\" size=\"25\" maxlength=\"45\">
                  </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
          ");
          $w = 0;
          for ($w=1;$w<=$dcnt; ++$w) {
               if ($did[$w] == $uissue_area_id) {
	               print(" <font color=\"#000000\"> 
                            $dpt[$w]
                           </font>
                           <input type=\"hidden\" name=\"new_issue_area_id[$x]\" value=\"$did[$w]\"> 
                   ");
               }              
          }
          print("   
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
print("      </tbody>
            </table>

            <table border='0' align=\"center\">
                <tr>
                 <td>
                   <br />
                   <!--<input type=\"submit\" name=\"submit\" value=\"Update\">-->
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
          </div>   
         </body>
        </html>
     ");

// --------------------------     
// End of the check-01
//}
// --------------------------

     
?>
