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
		      $query       = "DELETE FROM ".$name.".cube1_main
                               WHERE etl_id = '$key' ";
		      $mysql_data  = mysql_query($query, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query1      = "DELETE FROM ".$name.".cube1_a
                               WHERE etl_id = '$key' ";
		      $mysql_data1 = mysql_query($query1, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query2      = "DELETE FROM ".$name.".cube1_b
                               WHERE etl_id = '$key' ";
		      $mysql_data2 = mysql_query($query2, $mysql_link);
              // delete from cube1_main (snowflakes)
		      $query3      = "DELETE FROM ".$name.".cube1_b_lov
                               WHERE etl_id = '$key' ";                               
		      $mysql_data3 = mysql_query($query3, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query4      = "DELETE FROM ".$name.".cube1_c
                               WHERE etl_id = '$key' ";
		      $mysql_data4 = mysql_query($query4, $mysql_link);
              // delete from cube1_c (snowflakes)
		      $query5      = "DELETE FROM ".$name.".cube1_c_lov
                               WHERE etl_id = '$key' ";
		      $mysql_data5 = mysql_query($query5, $mysql_link);		      
              // delete from cube1_d (snowflakes)
		      $query6      = "DELETE FROM ".$name.".cube1_d
                               WHERE etl_id = '$key' ";
		      $mysql_data6 = mysql_query($query6, $mysql_link);	
              // delete from etl_monitor (ETL Job Monitor)
		      $query7      = "DELETE FROM ".$name.".etl_monitor
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
           <form method=\"post\" action=\"./etl_monitor.php\">
            <table border='0' align=\"center\" width=\"100%\" scroll=\"yes\">
             <caption>$captn</caption>
             <tr> 
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
                <font color=\"#FFFFFF\">
                 No
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
                <font color=\"#330099\">
                 ID
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Timestamp
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Status
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Target Cube
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\" colspan=\"3\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Rows
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                <font color=\"#330099\">
                 Ran By
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#99CCFF\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\">
                <font color=\"#330099\">
                 Job Log
                </font>
               </td>
               <td align=\"center\" valign=\"middle\" bgcolor=\"#ECE5B6\" rowspan=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:40px;\">
                <font color=\"#330099\">
                 Delete
                </font>
               </td>
             </tr>
             <tr>
              <td align=\"center\" bgcolor=\"#99CCFF\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
               <font color=\"#330099\">
                Header
               </font>
              </td>
              <td align=\"center\" bgcolor=\"#99CCFF\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
               <font color=\"#330099\">
                Detail
               </font>
              </td>
              <td align=\"center\" bgcolor=\"#99CCFF\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:25px;\">
               <font color=\"#330099\">
                Footer
               </font>
              </td>             
             </tr>
      ");

$query      = "select etl_id,etl_timestamp,etl_status,target_cube,header_rows,detail_rows,footer_rows,ran_by,job_log
                 from ".$name.".etl_monitor";
$mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt     = mysql_num_rows($mysql_data);
$delcnt     = 0;
    
$seq = 0;
while($row = mysql_fetch_row($mysql_data)) {

	$xid             = stripslashes($row[0]);
    $xetl_timestamp  = stripslashes($row[1]);
    $xetl_status     = stripslashes($row[2]);    
    $xtarget_cube    = stripslashes($row[3]);
    $xheader_rows    = stripslashes($row[4]);
    $xdetail_rows    = stripslashes($row[5]);
    $xfooter_rows    = stripslashes($row[6]);
    $xran_by         = stripslashes($row[7]); 
    $xjob_log        = stripslashes($row[8]);
    $xjob_log_x      = str_replace("<br>","\n\n",$xjob_log);
    $xjob_log_x      = ltrim($xjob_log_x);                        
	
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
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xetl_timestamp
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xetl_status
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xtarget_cube
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xheader_rows
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xdetail_rows
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xfooter_rows
                 </font>
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                    $xran_by
                 </font>
	            </td>                                                	            
	            <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;  scroll-x: auto;\">
                 <font color=\"#000000\">
                  <textarea cols=\"1\" rows=\"1\" readonly=\"readonly\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;\" >
                   $xjob_log
                  </textarea>
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
