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

// Insert a record
if ($submit == "Insert") {
	while (list($key) = each($new)) {

	        $new_global_var[$key]   = addslashes(strtoupper(trim($new_global_var[$key])));
	        $new_global_val[$key]   = addslashes(trim($new_global_val[$key]));

            $query ="INSERT into ".$name.".global(global_var,global_val)
                            VALUES('$new_global_var[$key]','$new_global_val[$key]')";

            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

// Update all edited records
if ($update && $submit == "Update") {
    while (list($key) = each($update)) {
	    $xid[$key]             = addslashes($xid[$key]);
	    $xglobal_var[$key]     = addslashes(strtoupper(trim($xglobal_var[$key])));
	    $xglobal_val[$key]     = addslashes(trim($xglobal_val[$key]));

  		$query = "UPDATE ".$name.".global
		             SET
                         global_var  = '$xglobal_var[$key]',
                         global_val  = '$xglobal_val[$key]'
		           WHERE global_id = '$key'";
		$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Delete all selected records
if ($delete && $submit == "Delete") {

	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".global WHERE global_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
	    }
    }
$captn = "Setup Global Variables";
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
           div.scrollWrapper{
                   /*float:left;*/
                   margin-left: auto; 
                   margin-right: auto;
                   overflow:visible !important;
                   overflow:scroll;
                   height:600px;
                  }
           /*div.scrollWrapper.table{
                   margin-left: auto; 
                   margin-right: auto;
                  }*/
           table.scrollable{
                   width:600px;
                   margin-right:0 *!important;*
                   margin-right:16px;
                   border-collapse:separate;
                  }
           table.scrollable tbody{
                   height:600px;
                   /*overflow:auto;*/
                   overflow-x:hidden;
                   overflow-y:auto;
                  }
           </style> 
        </head>
        <body>
          <div id=\"content\">
           <form method=\"post\" action=\"./globalform.php\" >
            <table border='0' align=\"center\" scroll=\"yes\">
             <caption>$captn</caption> 
             <thead>
              <!--<tr><td colspan=\"11\" align=\"center\" bgcolor=\"#FFFFF0\"><font color=\"blue\">Setup User Types</font></td>
              </tr>-->
              <tr> 
                <td align=\"center\" bgcolor=\"#99CC00\"><font color=\"#FFFFFF\">No</font></th>
                <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Id</font></th>
                <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Variable</font></td>
                <td align=\"center\" bgcolor=\"#99CCFF\"><font color=\"#330099\">Value</font></td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Insert</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font</td>
                <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</font</td>
              </tr>
             </thead>
             <tbody> 
      ");

$query = "select global_id,global_var,global_val from ".$name.".global";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt = mysql_num_rows($mysql_data);
//$delcnt = 0;
    
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid          = stripslashes($row[0]);
    $xglobal_var  = stripslashes($row[1]);
    $xglobal_val  = stripslashes($row[2]);    

	$seq = $seq + 1;
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
                    <input type=\"text\" name=\"xglobal_var[$xid]\" value=\"$xglobal_var\" size=\"30\" maxlength=\"30\">
	            </td>
	            <td align=\"center\" bgcolor=\"#AFDCEC\">
                    <input type=\"text\" name=\"xglobal_val[$xid]\" value=\"$xglobal_val\" size=\"50\" maxlength=\"50\">
	            </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\">
                    <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>
                <td align=\"center\" bgcolor=\"#E8E8E8\">
                   <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
                </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
                </td>                
	          </tr>
	"); 
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
                     <input type=\"text\" name=\"new_global_var[$x]\" value=\"$new_global_var[$x]\" size=\"30\" maxlength=\"30\">
		          </td>
                  <td align=\"center\" bgcolor=\"#FF0000\">
                     <input type=\"text\" name=\"new_global_val[$x]\" value=\"$new_gobal_val[$x]\" size=\"50\" maxlength=\"50\">
		          </td>
	              <td align=\"center\" bgcolor=\"#E8E8E8\">
                  </td>                  
                  <td align=\"center\" bgcolor=\"#E8E8E8\">
                       <input type=\"checkbox\" name=\"new[$x]\" checked=\"checked\">
                  </td>
                  <td align=\"center\" bgcolor=\"#E8E8E8\">
                  </td>
	            <td align=\"center\"  bgcolor=\"#E8E8E8\">
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
                   <input type=\"submit\" name=\"submit\" value=\"Update\">
     ");

if ($rowcnt > 0) {
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
                 </td>
                </tr>
            </table>
           </form>
          </div> 
         </body>
        </html>
     ");
?>
