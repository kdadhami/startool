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
$trans = "loop";
// ==============================

// ===============================================================================================================
   $query69               = "select cube_id,cube_name
                               from ".$name.".cubes
                              where cube_ind = 1 
                           order by cube_name "; 
   $mysql_data69          = mysql_query($query69, $mysql_link) or die ("#2 Could not query: ".mysql_error());
   $rowcnt69              = mysql_num_rows($mysql_data69); 
   $ccnt                  = 0;
   while($row69           = mysql_fetch_row($mysql_data69)) {
         $ccnt            = $ccnt + 1;
         $cid[$ccnt]      = stripslashes($row69[0]);        //cube_id
         $cname[$icnt]    = trim(stripslashes($row69[1]));  //cube_name
         //print($icnt." - ".$ityp[$icnt]." - ".$iccd[$icnt]." - ".$irgrp[$icnt]." - ".$igrp[$icnt]."<br>");
   }
// ===============================================================================================================


// ===============================================================================================================
for ($sz=25;$sz<=200;$sz+=25) {
     $xsz[$sz] = $sz;    
}
// ===============================================================================================================


// Insert a record
if ($submit == "Submit") {
//if ($submit == "Insert") {
if (isset($new)) {
	while (list($key) = each($new)) {

	        $new_cube_name[$key]   = addslashes(strtoupper($new_cube_name[$key]));

            $query ="INSERT into ".$name.".cube_headers(cube_id,cube_header_name,header_size,cube_header_ind)
                     VALUES('$new_cube_name[$key]',1)";

            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

// Update all edited records
//if ($update && $submit == "Update") {
if (isset($update)) {
    while (list($key) = each($update)) {
	    $xid[$key]        = addslashes($xid[$key]);
	    $xcube_name[$key] = addslashes(strtoupper($xcube_name[$key]));
	    $xcube_ind[$key]  = addslashes($xcube_ind[$key]);

  		$query = "UPDATE ".$name.".cubes
		             SET cube_name  = '$xcube_name[$key]',
                         cube_ind   = 1
		           WHERE cube_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Inactivate all selected records
//if ($inactive && $submit == "Inactive") {
if (isset($inactive)) {
    while (list($key) = each($inactive)) {

  		$query = "UPDATE ".$name.".cubes
		             SET cube_ind = 0
		           WHERE cube_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Activate all selected records
//if ($active && $submit == "Active") {
if (isset($active)) {
    while (list($key) = each($active)) {

  		$query = "UPDATE ".$name.".cubes
		             SET cube_ind = 1
		           WHERE cube_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Delete all selected records
//if ($delete && $submit == "Delete") {
if (isset($delete)) {
	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".cubes WHERE cube_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
}    
$captn = "Setup Cube Headers";
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
           <form method=\"post\" action=\"./cubeform.php\">
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">ID</font></th>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Header</font></td>
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Cube</font></td> 
               <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Size</font></td> 
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Inactive</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Active</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>               
             </tr>
      ");

$query = "select cube_header_id,cube_id,cube_header_name,header_size,cube_header_ind from ".$name.".cube_headers";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
$delcnt = 0;
    
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid                = stripslashes($row[0]);
	$xcube_id           = stripslashes($row[1]);
	$xcube_header_name  = stripslashes($row[2]);
	$xheader_size       = stripslashes($row[3]);
    $xcube_header_ind   = stripslashes($row[4]);    

    //$query1 = "select cube_id from ".$name.".cube_headers where cube_id = '$xid' ";
    //$mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    //$rowcnt1 = mysql_num_rows($mysql_data1);
    $rowcnt = 0;
	
	$seq = $seq + 1;
    if ( $xcube_ind == 1 ) {
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
                 <input type=\"text\" name=\"xcube_header_name[$xid]\" value=\"$xcube_header_name\" size=\"100\" maxlength=\"100\">
	            </td>
	            
	            <td align=\"center\" bgcolor=\"#AFDCEC\">
                 <input type=\"text\" name=\"xcube_name[$xid]\" value=\"$xcube_name\" size=\"50\" maxlength=\"50\">
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

          } else {
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
                    $xcube_name
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
                     <input type=\"text\" name=\"new_cube_name[$x]\" value=\"$new_cube_name[$x]\" size=\"50\" maxlength=\"50\">
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
//if ($submit == "Add") {
//    print("
//                   <!--<input type=\"submit\" name=\"submit\" value=\"Insert\">-->
//          ");
//}

// End of HTML
print("       </td>
             </tr>
            </table>
           </form>
          </body>
         </html>
");
?>
