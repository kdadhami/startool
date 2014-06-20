<?php

// ----------------------------
// Author: Kashif Adhami
// Dated: October, 2010
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

$queryx = "select category_scope_id,category_scope from ".$name.".category_scope where category_scope_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$cat_scope_cnt                = 0;
//$cat_scope_cnt                = $cat_scope_cnt + 1;
//$cat_scope_id[$cat_scope_cnt] = 0;
//$cat_scope[$cat_scope_cnt]    = "";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $cat_scope_cnt                = $cat_scope_cnt + 1;
      $cat_scope_id[$cat_scope_cnt] = stripslashes(trim($rowx[0]));
      $cat_scope[$cat_scope_cnt]    = stripslashes(trim($rowx[1]));
}

if ($submit == "Submit") {
// Insert a record
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

	         $new_pdp_category[$key]        = addslashes(strtoupper(substr($new_pdp_category[$key],0,100))); 
	         //$new_pdp_category_desc[$key]   = addslashes(strtoupper(substr($new_pdp_category_desc[$key],0,500)));
 	         $new_category_scope_id[$key]   = addslashes($new_category_scope_id[$key]); 

             $queryh = "SELECT UPPER(trim(a.pdp_category)),a.category_scope_id,UPPER(trim(b.category_scope)) 
                          FROM ".$name.".pdp_categories a, ".$name.".category_scope b
                         WHERE (
                                UPPER(trim(a.pdp_category)) = '$new_pdp_category[$key]'
                                AND
                                a.category_scope_id         = '$new_category_scope_id[$key]'
                               ) 
                           AND a.category_scope_id          = b.category_scope_id
                       ";
             //print($queryh);
             $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#1 Could not query: ".mysql_error());
             $rowcnth = mysql_num_rows($mysql_datah);

             if ($rowcnth > 0) {
                 while($rowh = mysql_fetch_row($mysql_datah)) {
	                   $ucategory_scope = strtoupper(stripslashes($rowh[2]));
	             }
                 $insert_ind = 1;
             } else {
                 $insert_ind = 0;
             }

             if ($insert_ind == 0) {
                    $query ="INSERT into ".$name.".pdp_categories(pdp_category,pdp_category_ind,category_scope_id)
                             VALUES('$new_pdp_category[$key]',1,'$new_category_scope_id[$key]')"; 
                    $mysql_data = mysql_query($query, $mysql_link) or die ("#2 Could not query: ".mysql_error());
             } else {
               echo "<script type=\"text/javascript\">window.alert(\"'$new_pdp_category[$key]' PDP Category for '$ucategory_scope' already exists\")</script>";
             }
   }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]                = addslashes($xid[$key]);
	    $xpdp_category[$key]      = addslashes(strtoupper(substr($xpdp_category[$key],0,100)));
	    $xpdp_category_ind[$key]  = addslashes($xpdp_category_ind[$key]);
	    //$xpdp_category_desc[$key] = addslashes(strtoupper(substr($xpdp_category_desc[$key],0,500)));
	    $xcategory_scope_id[$key] = addslashes($xcategory_scope_id[$key]);

             $queryh = "SELECT UPPER(trim(a.pdp_category)),a.category_scope_id,UPPER(trim(b.category_scope)) 
                          FROM ".$name.".pdp_categories a, ".$name.".category_scope b
                         WHERE (
                                UPPER(trim(a.pdp_category)) = '$xpdp_category[$key]'
                                AND
                                a.category_scope_id         = '$xcategory_scope_id[$key]'
                               ) 
                           AND a.category_scope_id          = b.category_scope_id
                       ";
             //print($queryh);
             $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#1 Could not query: ".mysql_error());
             $rowcnth = mysql_num_rows($mysql_datah);

             if ($rowcnth > 0) {
                 while($rowh = mysql_fetch_row($mysql_datah)) {
	                   $ucategory_scope = strtoupper(stripslashes($rowh[2]));
	             }
                 $update_ind = 1;
             } else {
                 $update_ind = 0;
             }

             if ($update_ind == 0) {
  		          $query = "UPDATE ".$name.".pdp_categories
		                       SET pdp_category      = '$xpdp_category[$key]',
                                   pdp_category_ind  = 1,
                                   category_scope_id = '$xcategory_scope_id[$key]'
		                     WHERE pdp_category_id = '$key'";
		         //print($query);           
		         $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
             } else {
                         echo "<script type=\"text/javascript\">window.alert(\"'$xpdp_category[$key]' PDP Category for '$ucategory_scope' already exists\")</script>";
             }
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$queryi = "UPDATE ".$name.".pdp_categories
		             SET 
                         pdp_category_ind  = 1
		           WHERE pdp_category_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$queryi = "UPDATE ".$name.".pdp_categories
		             SET
                         pdp_category_ind  = 0
		           WHERE pdp_category_id = '$key'";
		$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
	}
    }

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".pdp_categories WHERE pdp_category_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}

$captn = "PDP Scope Categories";
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
           <form method=\"post\" action=\"./pdpcategoriesform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Id</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Categories (Max 200 Chars)</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Scope Type</font></td>
               <!--<td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Description(Max 500 Chars)</font></td>-->
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font></td>                              
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font></td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>               
             </tr>
      ");

$query = "select pdp_category_id,pdp_category,pdp_category_ind,pdp_category_desc,category_scope_id 
            from ".$name.".pdp_categories 
        order by category_scope_id asc,pdp_category_ind desc,pdp_category asc";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;

$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid                = stripslashes($row[0]);
    $xpdp_category      = stripslashes($row[1]);
    $xpdp_category_ind  = stripslashes($row[2]);
    $xpdp_category_desc = stripslashes($row[3]);
    $xcategory_scope_id = stripslashes($row[4]);
    //print($xcategory_scope_id);
	
    $query1 = "select pdp_id from ".$name.".pdp where pdp_category_id = '$xid' ";
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1 = mysql_num_rows($mysql_data1);

	$seq = $seq + 1;
    if ($xpdp_category_ind == 1) {

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
                    <textarea name=\"xpdp_category[$xid]\" cols=\"30\" rows=\"2\" >$xpdp_category</textarea>
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
       ");
       if ($xcategory_scope_id == 0) {
           print(" <select align=\"center\" name=\"xcategory_scope_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
       } else {
           print(" <select align=\"center\" name=\"xcategory_scope_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
       }       
                 //<select align=\"center\" name=\"xcategory_scope_id[$xid]\">  
               //");
         $w = 0;
         for ($w=1;$w<=$cat_scope_cnt ; ++$w) {
              if ($cat_scope_id[$w] == $xcategory_scope_id) {
                  print(" <option selected value=\"$cat_scope_id[$w]\">$cat_scope[$w]</option> ");
              }
              else {
                  print(" <option value=\"$cat_scope_id[$w]\">$cat_scope[$w]</option> ");
              }
         }
         print(" </select>
                </td>
	            <!--<td align=\"center\" bgcolor=\"#AFDCEC\">
                    <textarea name=\"xpdp_category_desc[$xid]\" cols=\"45\" rows=\"2\" >$xpdp_category_desc</textarea>
	            </td>-->
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
                  <textarea name=\"xpdp_category[$xid]\" cols=\"30\" rows=\"2\" readonly=\"readonly\">$xpdp_category</textarea>
	            </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#AFDCEC\">
                 <!--<select align=\"center\" name=\"xcategory_scope_id[$xid]\">-->
                 <font color=\"#000000\">  
               ");
         $v = 0;
         for ($v=1;$v<=$cat_scope_cnt ; ++$v) {
              if ($cat_scope_id[$v] == $xcategory_scope_id) {
                  //print(" <option selected value=\"$cat_scope_id[$v]\">$xcat_scope[$v]</option> ");
                  print($cat_scope[$v]);
              }
              //else {
                  //print(" <option value=\"$cat_scope_id[$v]\">$cat_scope[$v]</option> ");
              //}
         }
         print(" </font>
                 <input type=\"hidden\" name=\"xcategory_scope[$xid]\" value=\"$xcategory_scope_id\">
                 <!--</select>-->
                </td>
	            <!--<td valign=\"middle\" bgcolor=\"#AFDCEC\">
                  <textarea name=\"xpdp_category_desc[$xid]\" cols=\"45\" rows=\"2\" readonly=\"readonly\">$xpdp_category_desc</textarea>
	            </td>-->
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
                     <textarea name=\"new_pdp_category[$x]\" cols=\"30\" rows=\"2\" ></textarea>
		          </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
                 <select align=\"center\" name=\"new_category_scope_id[$x]\">  
               ");
         $w = 0;
         for ($w=1;$w<=$cat_scope_cnt ; ++$w) {
              //if ($cat_scope_id[$w] == $xcategory_scope_id) {
                  //print(" <option selected value=\"$cat_scope_id[$w]\">$xcat_scope[$w]</option> ");
              //}
              //else {
                  print(" <option value=\"$cat_scope_id[$w]\">$cat_scope[$w]</option> ");
              //}
         }
         print("   </select>
                  </td>
                  <!--<td align=\"center\" bgcolor=\"#FF0000\">
                     <textarea name=\"new_pdp_category_desc[$x]\" cols=\"45\" rows=\"2\" ></textarea>
		          </td>-->
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
//    //print(" <input type=\"submit\" name=\"submit\" value=\"Delete\"> ");  
//}

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
