<?php

// Connection
require_once("./inc/connect.php");

//echo "testing - ".$yrelid." - ".$yprjtyp;

//------------------------------------------
// Loading project types in prj_typ array
$queryp = "select project_type from ".$name.".project_types ";
$mysql_datap = mysql_query($queryp, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntp = mysql_num_rows($mysql_datap);

//print $rowcntp;
$xy1 = 0; 
while($row = mysql_fetch_row($mysql_datap)) {
      $xy1 = $xy1 + 1;
      $yprj_typ = stripslashes(trim($row[0]));
      //print $yprj_typ;
      $prj_typ[$xy1]  = $yprj_typ;
//-----------------------------------------
}
    
$prj_uat[1]    = "YES";
$prj_uat[2]    = "NO";

$prj_prod_v[1] = "YES";
$prj_prod_v[2] = "NO";

$anser[1]      = "Y";
$anser[2]      = "N";


if (isset($yrelid) && isset($yprjtyp)) {

    $queryx = "select release_id, release_name from ".$name.".release where release_id = '$yrelid' ";
    $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcntx = mysql_num_rows($mysql_datax);
    
    $t = 0;
    while($row = mysql_fetch_row($mysql_datax)) {
          $t = $t + 1; 
          $trid = stripslashes($row[0]);
          $trelease_name = stripslashes($row[1]);
          $trelname[$t] = $trelease_name;
          $trelid[$t] = $trid;
         }    

    if ($yrelid == 0){
        $filtr = " Release ALL - Type ".$yprjtyp;
    } else {
        $filtr = " Release ".$trelname[$t]." - Type ".$yprjtyp;
    }
   } 
else {
   require_once("./select_releaseandtype.php");
   }

// Release drop down creations --- start
// -------------------------------------
$query = "select release_id, release_name from ".$name.".release";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());

$r = 0;
while($row = mysql_fetch_row($mysql_data)) {
      $r = $r + 1; 
      $rid = stripslashes($row[0]);
      $rrelease_name = stripslashes($row[1]);
      $relname[$r] = $rrelease_name;
      $relid[$r] = $rid;
}

// Insert a record
if ($submit == "Insert") {
	while (list($key) = each($new)) {
	        $new_xrelease_id[$key]       = addslashes($new_xrelease_id[$key]);
	        $new_xproject_desc[$key]     = strtoupper($new_xproject_desc[$key]);
	        $new_xproject_type[$key]     = addslashes(trim($new_xproject_type[$key]));
	        //$new_xproject_status[$key] = strtoupper(trim($new_xproject_status[$key]));
	        $new_xuat_flag[$key]         = "N";
	        $new_xprod_validation[$key]  = "N";
	        //$new_xprod_validation[$key]  = addslashes($new_xprod_validation[$key]);
	        //$new_xuat_flag[$key]         = trim($new_xuat_flag[$key]);

            $query ="INSERT into ".$name.".projects(release_id,project_desc,project_type,uat_flag,prod_validation)
                            VALUES('$new_xrelease_id[$key]','$new_xproject_desc[$key]','$new_xproject_type[$key]',
                                   '$new_xuat_flag[$key]','$new_xprod_validation[$key]')";
            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

// Update all edited records
if ($update && $submit == "Update") {
    while (list($key) = each($update)) {
	    $xid[$key]                = addslashes($xid[$key]);
	    $xrelease_id[$key]        = addslashes($xrelease_id[$key]);
	    $xproject_desc[$key]      = strtoupper($xproject_desc[$key]);
	    $xproject_type[$key]      = addslashes(trim($xproject_type[$key]));
	    //$xproject_status[$key]    = addslashes(trim($xproject_status[$key]));
	    $xuat_flag[$key]          = addslashes($xuat_flag[$key]);
	    $xprod_validation[$key]   = addslashes($xprod_validation[$key]);

  		$query = "UPDATE ".$name.".projects
		             SET
                         release_id      = '$xrelease_id[$key]',
                         project_desc    = '$xproject_desc[$key]',
                         project_type    = '$xproject_type[$key]',
                         uat_flag        = '$xuat_flag[$key]',
                         prod_validation = '$xprod_validation[$key]'
		           WHERE project_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Delete all selected records
if ($delete && $submit == "Delete") {

	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".projects WHERE project_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }


// -------------------------------------
// Start of the check-01
if (isset($yrelid) && isset($yprjtyp)) {
// -------------------------------------

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
         <div id=\"content\" >
          <form method=\"post\" action=\"./setup_projects.php\">
           <table border='0' align=\"center\" scroll=\"yes\">
             <tr><td colspan=\"12\" align=\"center\" bgcolor=\"#00CCFF\">Setup Projects for $filtr</td>
             </tr>
            <tr>
               <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">id</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Release</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Project</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Type</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">UAT</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">PVT</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>
            </tr>
      ");

// Select all for given release and project_type
$query = "select project_id,release_id,project_desc,project_type,uat_flag,prod_validation from ".$name.".projects "; 

if ($yprjtyp == "ALL" && $yrelid <> 0){
    $query = $query." where release_id = '$yrelid' ";
   }

if ($yprjtyp <> "ALL" && $yrelid <> 0) {
    $query = $query." where release_id = '$yrelid' and project_type = '$yprjtyp' ";
}

if ($yprjtyp <> "ALL" && $yrelid == 0) {
    $query = $query." where project_type = '$yprjtyp' ";
}

//echo $query;

$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid               = stripslashes($row[0]);
    $xrelease_id       = stripslashes($row[1]);
	$xproject_desc     = stripslashes($row[2]);
	$xproject_type     = stripslashes(trim($row[3]));
	//$xproject_status   = stripslashes(trim($row[4]));
	$xuat_flag         = stripslashes(strtoupper(trim($row[4])));
	$xprod_validation  = stripslashes(strtoupper(trim($row[5])));

    $query1 = "select project_id from ".$name.".project_details where project_id = $xid";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);
    //echo $rowcnt1."<br>";

    $query2 = "select project_id from ".$name.".project_summary where project_id = $xid";
    $mysql_data2 = mysql_query($query2, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt2 = mysql_num_rows($mysql_data2);
    //echo $rowcnt2."<br>";


    $seq = $seq + 1;
	print("   <tr valign=\"top\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq    <!--$xid-->
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <select align=\"center\" name=\"xrelease_id[$xid]\"> 
          ");
          $u = 0;
          for ($u=1;$u<=$r; ++$u) {
               if ($relid[$u] == $xrelease_id) {
                   print(" <option selected value=\"$relid[$u]\">$relname[$u]</option> ");
               }
               else {
                   print(" <option value=\"$relid[$u]\">$relname[$u]</option> ");
               }
               }
    print("   </select> 
	            </td>        
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                    <input type=\"text\" name=\"xproject_desc[$xid]\" value=\"$xproject_desc\" size=\"30\" maxlength=\"50\">
	            </td>
                <td align=\"center\" valign=\"middle\"bgcolor=\"#AFDCEC\">
                 <select align=\"center\" name=\"xproject_type[$xid]\"> 
          ");
          $v = 0;
          for ($v=1;$v<=$rowcntp; ++$v) {
               if ($prj_typ[$v] == $xproject_type) {
                   print(" <option selected value=\"$prj_typ[$v]\">$prj_typ[$v]</option> ");
               }
               else {
                   print(" <option value=\"$prj_typ[$v]\">$prj_typ[$v]</option> ");
               }
               }
     print("    </select>
              </td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xuat_flag[$xid]\">--> 
          ");
          $a = 0;
          for ($a=1;$a<=2; ++$a) {
               if ($anser[$a] == $xuat_flag) {
                    print(" <font color=\"#000000\"> 
                             $prj_uat[$a]
                            </font> 
                            <input type=\"hidden\" name=\"xuat_flag[$xid]\" value=\"$xuat_flag\">
                         ");
          // <option selected value=\"$anser[$a]\">$prj_uat[$a]</option> ");
               }
               else {
          //         print(" <option value=\"$anser[$a]\">$prj_uat[$a]</option> ");
               }
               }
     print("   <!--</select>-->
             </td>
             <td align=\"center\" valign=\"middle\"bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xprod_validation[$xid]\">--> 
          ");
          $b = 0;
          for ($b=1;$b<=2; ++$b) {
               if ($anser[$b] == $xprod_validation) {
                    print(" <font color=\"#000000\"> 
                             $prj_prod_v[$b]
                            </font> 
                            <input type=\"hidden\" name=\"xprod_validation[$xid]\" value=\"$xprod_validation\">
                          ");
                   //print(" <option selected value=\"$anser[$b]\">$prj_prod_v[$b]</option> ");
               }
               else {
                   //print(" <option value=\"$anser[$b]\">$prj_prod_v[$b]</option> ");
               }
               }
     print("   <!--</select>-->
              </td>
           ");
	      if ($rowcnt > 0) {
              if (($rowcnt1 == 0) && ($rowcnt2 == 0)) {
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
     print("
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	          </tr>
	     ");
}

// Display blank entry for a new record to be inserted
if ($submit == "Add") {
    $n_prj_uat[1] = "YES";
    $n_prj_uat[2] = "NO";

    $n_prj_prod_v[1] = "YES";
    $n_prj_prod_v[2] = "NO";

    $n_anser[1] = "Y";
    $n_anser[2] = "N";

    for ($x=1;$x<=$num_records; ++$x) {
		 print("
                <tr>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
		          </td>
		          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
		          </td>		          
		          <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
                   <select align=\"center\" name=\"new_xrelease_id[$x]\"> 
              ");
                     $c = 0;
                     for ($c=1;$c<=$r; ++$c) {
                           if ($relid[$c] == $yrelid) {
                               print(" <option selected value=\"$relid[$c]\">$relname[$c]</option> ");
                           }
                           else {
                               print(" <option value=\"$relid[$c]\">$relname[$c]</option> ");
                           }
                     }
     print("        </select> 
	               </td>		          
                   <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
                      <input type=\"text\" name=\"new_xproject_desc[$x]\" value=\"$new_xproject_desc[$x]\" size=\"30\" maxlength=\"50\">
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
                      <select name=\"new_xproject_type[$x]\">
          ");
                      for ($e=1;$e<=$rowcntp; ++$e) {
                           if ($prj_typ[$e] == $yprjtyp) {
                               print(" <option selected value=\"$prj_typ[$e]\">$prj_typ[$e]</option> ");
                           }
                           else {
                               print(" <option value=\"$prj_typ[$e]\">$prj_typ[$e]</option> ");
                           }
	                  }
     print("          </select>
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
                      <!--<select name=\"new_xuat_flag[$x]\">
          ");
                      //for ($g=1;$g<=2; ++$g) {
                      //       print(" <option value=\"$n_anser[$g]\">$n_prj_uat[$g]</option> ");
	                  //}
     print("          </select>-->
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"##AFDCEC\">
                      <!--<select name=\"new_xprod_validation[$x]\">
          ");
                      //for ($h=1;$h<=2; ++$h) {
                      //       print(" <option value=\"$n_anser[$h]\">$n_prj_prod_v[$h]</option> ");
	                  //}
     print("          </select>-->
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
                   <input type=\"submit\" name=\"submit\" value=\"Update\">
     ");

if ($delcnt ==0) {
    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> "); 
} else {
    print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
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
                   <input type=\"submit\" name=\"submit\" value=\"Insert\">
          ");
}

// End of HTML
print("
                   <input type=\"submit\" name=\"submit\" value=\"Refresh\">
                   <input type=\"hidden\" name=\"yrelid\" value=\"$yrelid\">
                   <input type=\"hidden\" name=\"yprjtyp\" value=\"$yprjtyp\">
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
}
// --------------------------

     
?>
