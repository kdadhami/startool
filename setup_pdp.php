<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: setup_pdp.php
// Date: Oct, 2010
// Notes: This program provides listing and maintaninence of PDP
// that has been loaded from "Load PDP option" under "Admin"
// menu option. The manual functionality of "insert" and "update"
// are suppressed for now, and only "Delete" is allowed.
//
// --------------------------------------------------------------

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

// setting up today's date
$newd  = date("d"); //day
$newm  = date("m"); //month
$newy  = date("Y"); //year
$newt  = time();
$new_dt = mktime(0,0,0,$newm,$newd,$newy);

// getting id of user
//$usr = strtoupper(trim(getenv("username")));
//print $usr;

$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$pdp_prd_cnt = 1;
$pdp_prd_id[$pdp_prd_cnt] = 0;
$pdp_prd[$pdp_prd_cnt] = "";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $pdp_prd_cnt              = $pdp_prd_cnt + 1;
      $pdp_prd_id[$pdp_prd_cnt] = stripslashes(trim($rowx[0]));
      $pdp_prd[$pdp_prd_cnt]    = stripslashes(trim($rowx[1]));
}


if ($submit == "Submit") {
// Insert a record
//if (isset($new)) {
////if ($submit == "Insert") {
//	while (list($keyi) = each($new)) {
//	        $new_pdp_desc[$keyi]   = strtoupper($new_pdp_desc[$keyi]);
//            $new_updated_dt[$keyi] = mktime(0,0,0,$newm,$newd,$newy);
//            $new_updated_by[$keyi] = strtoupper(trim($usr));
//            
//            $query ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by)
//                            VALUES('$new_pdp_desc[$keyi]','$new_updated_dt[$keyi]','$new_updated_by[$keyi]')";
//            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
//           }
//}

// Update all edited records
if (isset($update)) {
//if ($update && $submit == "Update") { 
    while (list($key) = each($update)) {
	       //$xid[$key]          = addslashes($xid[$key]);
	       //$xpdp_desc[$key]    = strtoupper($xpdp_desc[$key]);
           $xupdated_dt[$key]    = mktime(0,0,0,$newm,$newd,$newy);
           $xupdated_by[$key]    = strtoupper(trim($usr));
           $xpdp_period_id[$key] = addslashes($xpdp_period_id[$key]);

  	       $query = "UPDATE ".$name.".pdp
		                SET updated_date  = '$xupdated_dt[$key]',
		                    updated_by    = '$xupdated_by[$key]',
		                    pdp_period_id = '$xpdp_period_id[$key]'
		              WHERE pdp_id       = '$key' ";
		//print($query);
        //print($key);
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
    }
}

// Delete all selected records
if (isset($delete)) {
//if ($delete && $submit == "Delete") {
	while (list($keyd) = each($delete)) {
		$query = "DELETE FROM ".$name.".pdp WHERE pdp_id = '$keyd' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
}
}

// -------------------------------------
// Start of the check-01
//if (isset($yrelid) && isset($yprjtyp)) {
// -------------------------------------
$captn = " List PDP";
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
          textbox {font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
       
            input { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
           select { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }                   
           #content
                  { top:0%;
                    width: 100%; height: 100%; background: #FFFFF0;
                    /*border: 1px solid; border-color:#BDBDBD;*/
                  }
           /*#contentb
                  { top:0%;
                    width: 100%; height: 1%; background: #CEE3F6;
                  }
           #contentc
                  { top:0%;
                    width: 100%; height: 49%; background: #CEF6E3;
                    border: 1px solid; border-color:#BDBDBD;
                  }*/
           div.scrollWrapper{
                   /*float:left;*/
                   margin-left: auto; 
                   margin-right: auto;
                   overflow:visible /*!important;*/
                   overflow:scroll;
                   height:600px;
                  }
           /*div.scrollWrapper.table{
                   margin-left: auto; 
                   margin-right: auto;
                  }*/
           table.scrollable{
                   width:50px;
                   margin-right:0 /*!important;*/
                   margin-right:16px;
                   border-collapse:separate;
                  }
           table.scrollable tbody{
                   height:600px;
                   /*overflow:auto;*/
                   overflow-x:hidden;
                   overflow-y:auto;
                  }
            a:link {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:visited {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:hover {
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

        </head>
        <body>
         <!--<div id=\"content\" class=\"scrollWrapper\">-->
         <div id=\"content\">
          <form method=\"post\" action=\"./setup_pdp.php\">
           <table border='0' align=\"center\" scroll=\"yes\">
           <!--<table border='0' align=\"center\" scroll=\"yes\" class=\"scrollable\">-->
           <caption>$captn</caption>
            <thead>
             <!--<tr>
              <td colspan=\"12\" align=\"center\" bgcolor=\"#00CCFF\">
               <font color=\"#0000FF\">
                Setup PDP Numbers
               </font>
              </td>
             </tr>-->
             <tr>
              <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Id</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">PDP No.</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Program Name</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Owner</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Launch</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Status</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Type</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Last Updated On</font></td>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Last Updated By</font></td>
              <!--<td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>-->
              <!--<td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>-->
              <!--<td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>-->
              <!--<td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font></td>-->
             </tr>
            </thead>
            <tbody> 
      ");

// Select all pdp
$query = "select pdp_id,pdp_desc,updated_date,updated_by,pdp_name,pdp_owner,pdp_launch,pdp_status,pdp_period_id from ".$name.".pdp order by pdp_desc"; 

$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid            = stripslashes($row[0]);
	$xpdp_desc      = stripslashes($row[1]);
    $xupdated_date  = stripslashes($row[2]);
    $xd             = date("d",$xupdated_date);
    $xm             = date("M",$xupdated_date);
    $xy             = date("Y",$xupdated_date);
    //$xh           = date("H",$xupdated_date);
    //$xi           = date("i",$xupdated_date);
    //$xs           = date("s",$xupdated_date);
    $xdt            = $xd."-".$xm."-".$xy;
    $xupdated_by    = stripslashes($row[3]);
    $xpdp_name      = stripslashes($row[4]);    
    $xpdp_owner     = stripslashes($row[5]); 
    $xpdp_launch    = stripslashes($row[6]);
    $xpdp_status    = stripslashes($row[7]); 
    $xpdp_period_id = stripslashes($row[8]);

    //print ($xid);

    if (empty($xpdp_launch)) {
        $xpdp_launch_dt = "00-00-0000";
    } else {
        $xpdp_launch_d  = date("d",$xpdp_launch);
        $xpdp_launch_m  = date("M",$xpdp_launch);
        $xpdp_launch_y  = date("y",$xpdp_launch);    
        $xpdp_launch_dt = $xpdp_launch_d."-".$xpdp_launch_m."-".$xpdp_launch_y;
    }

    //$xpdp_status    = stripslashes($row[7]); 

    $seq = $seq + 1;
	print("   <tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
	                <a href=\"#\" onclick=\"document.getElementById('contentc').innerHTML='&lt;iframe src=&quot;manageissues.php?pid=$xid&&pdpdesc=$xpdp_desc&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">$xid</a>
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<input type=\"text\" name=\"xpdp_desc[$xid]\" value=\"$xpdp_desc\" size=\"9\" maxlength=\"9\">-->
	             <font color=\"#330099\"> 
                   $xpdp_desc
                 </font>
	            </td>
	            <td align=\"left\" valign=\"middle\" bgcolor=\"#AFDCEC\" style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
	             <font color=\"#330099\"> 
                   <!--<textarea cols=\"30\" rows=\"2\" readonly=\"readonly\">$xpdp_name</textarea>-->
                   <p style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
                    $xpdp_name
                   </p>
                 </font> 	            
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\"> <!--width=\50\ can be added to style-->
	             <font color=\"#330099\"> 
                   $xpdp_owner
                 </font> 	            
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#330099\"> 
                   $xpdp_launch_dt
                 </font> 
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
	             <font color=\"#330099\"> 
                   $xpdp_status
                 </font> 
                </td>                	            
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <font color=\"#330099\">
                 <!--<select align=\"center\" name=\"xpdp_period_id[$xid]\">-->  
               ");
         if ($xpdp_period_id == 0){
         } else {  
           $w = 0;
           for ($w=1;$w<=$pdp_prd_cnt ; ++$w) {
                if ($pdp_prd_id[$w] == $xpdp_period_id) {
                    //print(" <option selected value=\"$pdp_prd_id[$w]\">$pdp_prd[$w]</option> ");
                    print($pdp_prd[$w]);
                }
                //else {
                    //print(" <option value=\"$pdp_prd_id[$w]\">$pdp_prd[$w]</option> ");
                //}
           }
         }
         print(" <!--</select>-->
                 </font>
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <font color=\"#330099\">$xdt</font>
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <font color=\"#330099\">$xupdated_by</font>
	            </td>                	            
          ");

    // Find issues
    $queryi = "select issue_id from ".$name.".issues where pdp_id = '$xid'"; 
    $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnti = mysql_num_rows($mysql_datai);
    
	//if ($rowcnti > 0) {
    //    $delcnt = $delcnt + 1;
    //    print("
    //           <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
    //           </td>
    //         ");
    //} else {
    //   print(" <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
    //            <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
    //           </td>
    //        ");
    //}
    print("
	        <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\"></td>-->
            <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
             <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
            </td>-->
            <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\"></td>-->            
	       </tr>
	     ");
}

// ------------------------------------
// Display blank entry for a new record to be inserted
//if ($submit == "Add") {
//    for ($x=1;$x<=$num_records; ++$x) {
//		 print("
//                <tr>
//		          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
//		          </td>
//		          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//		          </td>
//                <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                   <input type=\"text\" name=\"new_pdp_desc[$x]\" value=\"$new_pdp_desc[$x]\" size=\"9\" maxlength=\"9\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>                                                      
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//                  </td>
//	              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//                  </td>
//                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//                   <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
//                  </td>
//                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//                  </td>
//                  <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
//                  </td>
//		        </tr>
//		      ");
//	}
//}
// ------------------------------------

// Display options
print("      </tbody>
            </table>
            <table border='0' align=\"center\">
             <tr>
              <td>
               <br />
                <!--<input type=\"submit\" name=\"submit\" value=\"Update\">-->
     ");

//if ($rowcnt > 1) {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");      
//} else {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
//}

// ----------------------------
// Select no. of new inserts
//if ($submit != "Add") {
//    print("
//                   <!--<input type=\"submit\" name=\"submit\" value=\"Add\">
//                    <select name =\"num_records\">
//                      <option value=\"1\">1</optons>
//                      <option value=\"2\">2</optons>
//                      <option value=\"3\">3</optons>
//                      <option value=\"4\">4</optons>
//                      <option value=\"5\">5</optons>
//                    </select>-->
//          ");
//}
// ----------------------------

// Display blank entries for a new records
//if ($submit == "Add") {
//    print("
//                   <!--<input type=\"submit\" name=\"submit\" value=\"Insert\">-->
//          ");
//}

// End of HTML
print("            <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                   <!--<input type=\"submit\" name=\"submit\" value=\"Refresh\">-->
                 </td>
                </tr>
            </table>
           </form>
          </div>
          <!--<div id=\"contentb\">
          </div>   
          <div id=\"contentc\">
          </div>-->   
         </body>
        </html>
     ");

// --------------------------     
// End of the check-01
//}
// --------------------------

     
?>
