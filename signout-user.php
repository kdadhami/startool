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
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),b.short_desc,u.user_type 
                     FROM ".$name.".users a, ".$name.".issue_areas b, ".$name.".user_types u 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                      AND a.user_type_id = u.user_type_id
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]); 
              $ushort_desc     = stripslashes($row6[2]);
              $uuser_type      = stripslashes($row6[3]);
              //print($yissue_area_id);
       } 
}
// ==============================
print("<html>
        <head>
         <style>
          html { height: 100%;}
          body { font-family: Calibri, Helvetica, sans-serif; font-size: 12px; background-color: #FF0000; }
          div  { position: absolute; top: 0px; }
        </style>       
        </head>
        <body>
         <div>
          <table border=\"0\" width=\"100%\">
           <tr>
            <td align=\"center\" valign=\"middle\" bgcolor=\"#FF0000\">
 	         <font color=\"#FFFFFF\">
              <a>$usr signed-out</a>
             </font>
            </td>
           </tr>
          </table>     
         </div> 
        </body>
       </html>
");
?>
