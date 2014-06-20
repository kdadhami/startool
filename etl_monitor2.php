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

if ($submit == "Submit") {
   // Delete all selected records
   if (isset($delete)) {
       while (list($key) = each($delete)) {
              // delete from cube1_main (main dimension)
		      $query       = "DELETE FROM ".$name.".tgt_pdp_main
                               WHERE etl_id = '$key' ";
		      $mysql_data  = mysql_query($query, $mysql_link);
              //delete from cube1_main (snowflakes)
		      $query1      = "DELETE FROM ".$name.".tgt_pdp_testing
                               WHERE etl_id = '$key' ";
		      $mysql_data1 = mysql_query($query1, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query2      = "DELETE FROM ".$name.".tgt_pdp_area_execution
                               WHERE etl_id = '$key' ";
		      $mysql_data2 = mysql_query($query2, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query3      = "DELETE FROM ".$name.".tgt_pdp_area_work_effort
                               WHERE etl_id = '$key' ";                               
		      $mysql_data3 = mysql_query($query3, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query7      = "DELETE FROM ".$name.".tgt_pdp_issue_area_summary
                               WHERE etl_id = '$key' ";
		      $mysql_data7 = mysql_query($query7, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query8      = "DELETE FROM ".$name.".tgt_pdp_issue_summary
                               WHERE etl_id = '$key' ";                               
		      $mysql_data8 = mysql_query($query8, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query4      = "DELETE FROM ".$name.".tgt_areas
                               WHERE etl_id = '$key' ";
		      $mysql_data4 = mysql_query($query4, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query5      = "DELETE FROM ".$name.".tgt_report_groups
                               WHERE etl_id = '$key' ";
		      $mysql_data5 = mysql_query($query5, $mysql_link);	
              // delete from cube1_c (snowflakes)
		      $query9      = "DELETE FROM ".$name.".tgt_ytd_main
                               WHERE etl_id = '$key' ";
		      $mysql_data9 = mysql_query($query9, $mysql_link);	
              // delete from cube1_c (snowflakes)
		      $query10     = "DELETE FROM ".$name.".tgt_root_cause_ytd
                               WHERE etl_id = '$key' ";
		      $mysql_data10= mysql_query($query10, $mysql_link);	
              // delete from cube1_c (snowflakes)
		      $query11     = "DELETE FROM ".$name.".tgt_back_to_build_ytd
                               WHERE etl_id = '$key' ";
		      $mysql_data11= mysql_query($query11, $mysql_link);	
              // delete from cube1_c (snowflakes)
		      $query12     = "DELETE FROM ".$name.".tgt_rework_hours_ytd
                               WHERE etl_id = '$key' ";
		      $mysql_data12= mysql_query($query12, $mysql_link);	
              // delete from cube1_d (snowflakes)
		      //$query6      = "DELETE FROM ".$name.".cube1_d
              //                 WHERE etl_id = '$key' ";
		      //$mysql_data6 = mysql_query($query6, $mysql_link);	
              // delete from etl_monitor (ETL Job Monitor)
		      $query7      = "DELETE FROM ".$name.".etl_batches
                               WHERE etl_id = '$key' ";
		      $mysql_data7 = mysql_query($query7, $mysql_link);              		      
	   }
   }
}    
$captn = "ETL Monitor";
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
           <form method=\"post\" action=\"./etl_monitor2.php\">
            <table border='0' align=\"center\" width=\"100%\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
                <font color=\"#FFFFFF\">
                 No
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
                <font color=\"#330099\">
                 ID
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Timestamp
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Year
                </font>
               </td>
                <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 PDP Count
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Status
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Ran By
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#ECE5B6\" style=\"word-wrap: break-word; word-break:break-all; width:40px;\">
                <font color=\"#330099\">
                 Delete
                </font>
               </td>
             </tr>
      ");

$query      = "select etl_id,etl_timestamp,etl_status,ran_by,etl_year,pdp_count 
                 from ".$name.".etl_batches";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt     = mysql_num_rows($mysql_data);
$delcnt     = 0;
    
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid             = stripslashes($row[0]);
    $xetl_timestamp  = stripslashes($row[1]);
    $xetl_status     = stripslashes($row[2]);    
    $xran_by         = stripslashes($row[3]);
    $xetl_year       = stripslashes($row[4]); 
    $xpdp_count      = stripslashes($row[5]);
    	
	$seq = $seq + 1;
	print("
              <tr valign=\"top\" width=\"125px\">
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                    $seq
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xid
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xetl_timestamp
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xetl_year
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xpdp_count
                 </font>
	            </td>
	            <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	              <font color=\"#000000\"> 
                   $xetl_status
                  </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xran_by
                 </font>
	            </td>                                                	            
                <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                 <input type=\"checkbox\" name=\"delete[$xid]\" value=\"Delete\">
                </td>
 	"); 
}

// Display options
print("
            </table>
            <table border='0' align=\"center\">
             <tr>
              <td>
               <br />
                <input type=\"submit\" name=\"submit\" value=\"Submit\">                                      
              </td>
             </tr>
            </table>
           </form>
          </body>
         </html>
");
mysql_close($mysql_link);
?>
