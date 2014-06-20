<?php
//--------------------------------
// Author: Kashif Adhami
// Date: November, 2010
// Note: surrogate_type = 0 when creating an issue i.e in issues table,
//       will be set to 1 when creating updates i.e. in issue_history table
//--------------------------------

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

$queryx = "select issue_type_id,issue_type,issue_type_ind from ".$name.".issue_types "; //where issue_type_ind = 1 ";
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt = 0;
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt                 = $issue_typ_cnt + 1;
      $issue_typ_id[$issue_typ_cnt]  = stripslashes(trim($rowx[0]));
      $issue_typ[$issue_typ_cnt]     = stripslashes(trim($rowx[1]));
      $issue_typ_ind[$issue_typ_cnt] = stripslashes(trim($rowx[2]));      
}

$queryw = "select issue_area_id,issue_area,issue_area_ind from ".$name.".issue_areas "; // where issue_area_ind = 1
$mysql_dataw = mysql_query($queryw, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntw = mysql_num_rows($mysql_dataw);    

$issue_area_cnt = 0;
while($roww = mysql_fetch_row($mysql_dataw)) {
      $issue_area_cnt                  = $issue_area_cnt + 1;
      $issue_area_id[$issue_area_cnt]  = stripslashes(trim($roww[0]));
      $issue_area[$issue_area_cnt]     = stripslashes(trim($roww[1]));
      $issue_area_ind[$issue_area_cnt] = stripslashes(trim($roww[2]));      
      
}



   //print("$pdp");
   //$queryu = "select lanid,fullname from ".$name.".users"; 
   //$mysql_datau = mysql_query($queryu, $mysql_link) or die ("Could not query: ".mysql_error());
   //$rowcntu = mysql_num_rows($mysql_datau);    

   //    while($rowu = mysql_fetch_row($mysql_datau)) {
   //          $usr  = stripslashes($rowu[1]);
   //    }


// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1 order by pdp_period asc"; 
//$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1"; 
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

//$usr = strtoupper(trim(getenv("username")));

// setting up today's date
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
//print ("$yentry_dt");
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

// Insert a record
if ($submit == "Insert") {
	while (list($key) = each($new)) {
	        $new_issue_desc[$key] = addslashes(trim(substr($new_issue_desc[$key],0,2000)));
	        $new_created_on[$key] = $yentry_dt; //mktime(0,0,0,$ym,$yd,$yy);
	        $new_issue_area_id[$key] = addslashes($new_issue_area_id[$key] );
	        //$new_issue_type_id[$key] = addslashes($new_issue_type_id[$key] );

            $query ="INSERT into ".$name.".issues(pdp_id,issue_desc,created_by,created_on,issue_area_id)
                            VALUES('$pdp_id','$new_issue_desc[$key]','$usr','$new_created_on[$key]',
                                   '$new_issue_area_id[$key]')";
            //print("$query");                
            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

print("<html>
        <head>
         <style>
             body    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px; 
                     }
               td    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                       color: #FFFFFF; 
                     }
         textarea    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }        
          /*caption    { background:#FFC000; color:#0000FF; font-size:1em;}*/  
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }
           select    { font-family: Calibri, Helvetica, sans-serif;
                       font-size: 12px;
                     }                   
           #content
                     { top:0%;
                       width: 100%; height: 65%; background: #FFFFF0;
                       /*border: 1px solid; border-color:#BDBDBD;*/
                     }
           /*          
           #contentb { top:0%;
                       width: 100%; height: 1%; /*background: #CEE3F6;*/
                     }
           #contentc { top:0%;
                       width: 100%; height: 34%; /*background: #CEF6E3;*/
                       /*border: 1px solid; border-color:#BDBDBD;*/
                     }
           */          
           #content a:link 
                     { text-decoration: none;
                       color: #2554C7;
                     }
           #content a:visited 
                     {
                       text-decoration: none;
                       color: #2554C7;
                     }
           #content a:hover 
                     { text-decoration: underline overline;
                       color: #2554C7;
                     }
           #content a:active 
                     {
                       text-decoration: none;
                       color: #2554C7;
                     }
            a:link   {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
            a:visited 
                     {
                       font-family: Calibri, Helvetica, sans-serif;
                       text-decoration: none;
                       color: #000000;
                     }
            a:hover  {
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
         <script type=\"text/javascript\">
                 function PopupCenter(pageURL, title,w,h)
                  {
                    var left = (screen.width/2)-(w/2);
                    var top = (screen.height/2)-(h/2);
                    var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                  }
         </script>
        </head>
        <body>
");  

$captn = "Update Your Issue";
// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------


// Start of HTMl

   //print("$pdp");
   //$queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,b.pdp_period,a.pdp_launch from ".$name.".pdp a, pdp_periods b where a.pdp_desc = '$pdp' and a.pdp_period_id = b.pdp_period_id "; 
   $queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch 
                from ".$name.".pdp a 
               where a.pdp_desc = '$pdp' "; 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$queryx");
   //print("$rowcntx");
   
   //$captn = "Issue List (Click the Issue No hyper link to see updates)";

   if ($rowcntx == 1) {
       $found = 1;   

       while($rowx = mysql_fetch_row($mysql_datax)) {
             $xid            = stripslashes($rowx[0]);
             $xpdpdesc       = stripslashes(trim($rowx[1]));
             $xdesc          = stripslashes(trim($rowx[2]));
             $xpdp_period_id = stripslashes(trim($rowx[3])); 
             $xpdp_launch    = stripslashes($rowx[4]);
             //$xld            = date("d",$xpdp_launch);
             //$xlm            = date("M",$xpdp_launch);
             //$xly            = date("Y",$xpdp_launch);
             //$xpdp_launch_dt = $xld."-".$xlm."-".$xly;

             if (empty($xpdp_launch)) {
                 $xpdp_launch_dt = "00-00-0000";
             } else {
                 $xld            = date("d",$xpdp_launch);
                 $xlm            = date("M",$xpdp_launch);
                 $xly            = date("Y",$xpdp_launch);    
                 $xpdp_launch_dt = $xld."-".$xlm."-".$xly;
             }

             if ($xpdp_period_id == 0) {
             } else {
                     $query100 = "select b.pdp_period from ".$name.".pdp a, pdp_periods b where a.pdp_desc = '$pdp' and a.pdp_period_id = b.pdp_period_id";
                     //print($query100);
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     while($row100 = mysql_fetch_row($mysql_data100)) {
                           $xpdp_period = stripslashes(trim($row100[0]));
                     }
             }
       }
       
       print("
         <form method=\"post\" action=\"./enter_issue_existing.php\" id=\"thisfrm\">
           <table border='0' scroll=\"yes\" >
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP No.
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\" style=\"width: 500px; word-wrap: break-word;\">
	          <font color=\"#330099\"> 
               $xpdpdesc
              </font> 
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP Name
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" width=\"300px\">                
              <!--<textarea name=\"pdp_name\" cols=\"30\" rows=\"3\" readonly=\"readonly\">$xdesc</textarea>-->
              <font color=\"#330099\">
                $xdesc
              </font>              
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP Type
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\">                
              <font color=\"#330099\">
       ");
       if ($xpdp_period_id == 0) {
           print("VALUE NOT SET"); 
        } else {
           print($xpdp_period);
       } 
       print("</font>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP Launch
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\">                
              <font color=\"#330099\">
               $xpdp_launch_dt
              </font>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               User Id
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $usr
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               Today's Date
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ydate
              </font>               
             </td>
            </tr>
           </table>
           <br />
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
             <tr>
               <td bgcolor=\"#FF0000\" align=\"center\" rowspan=\"2\"><font color=\"#FFFFFF\">Click<br>Issue No.</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" rowspan=\"2\"><font color=\"#330099\" style=\"width: 600px\">Description (Max 500 Chars)</font></td>
               <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Created</font></td>
             </tr>
             <tr>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">By</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">On</font></td>
             </tr>
            ");
            
           // Select all issues for given pdp
           $query = "select issue_id,pdp_id,issue_desc,created_by,created_on,issue_area_id from ".$name.".issues where pdp_id = '$xid' and created_by = '$usr' ";
           $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           $rowcnt = mysql_num_rows($mysql_data);
           //print($query);
           if ($rowcnt <> 0){
           $seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt = 0;
                 $seq = $seq + 1;
	             $xid2          = stripslashes($row[0]);
                 $xpdp_id       = stripslashes($row[1]);
	             $xissue_desc   = stripslashes(trim($row[2]));
                 $xcreated_by   = stripslashes($row[3]);
                 $xcreated_on   = stripslashes($row[4]);
                 $xissue_area_id = stripslashes($row[5]);
                 //$xissue_type_id = stripslashes($row[6]);
                 $xd1           = date("d",$xcreated_on);
                 $xm1           = date("M",$xcreated_on);
                 $xy1           = date("Y",$xcreated_on);
                 $xcreate_dt     = $xd1."-".$xm1."-".$xy1;

                 $queryh = "select issue_history_id,issue_id,issue_assignee,issue_note_dt,issue_note,issue_area_id from ".$name.".issue_history where issue_id = '$xid2' order by issue_history_id desc limit 1";
                 //print $query;
                 $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcnth = mysql_num_rows($mysql_datah);                 
                 
                 if ($rowcnth == 1) {
                     while($rowh = mysql_fetch_row($mysql_datah)) {
                           $xid3              = stripslashes($rowh[0]);
                           //$xid2              = stripslashes($rowh[1]);
                           $xissue_assignee   = stripslashes(strtoupper(trim($rowh[2])));
                           $xissue_note_dt    = stripslashes($rowh[3]);
                           $xd                = date("d",$xissue_note_dt);
                           $xm                = date("m",$xissue_note_dt);
                           $xy                = date("Y",$xissue_note_dt);
                           $xdt               = $xd."-".$xm."-".$xy;
                           //$xissue_status   = stripslashes(strtoupper(trim($row[4])));
                           $xissue_note       = stripslashes(trim($rowh[4]));
                           //$xissue_type_id_a  = stripslashes($rowh[5]);
                           $xissue_area_id_a  = stripslashes($rowh[5]);  
                  }
                 $rowcnt1 = $rowncnth;
                 if ($rowcnt1 == 0) {
                 } else
                 {
                   $delcnt = $delcnt + 1; 
                 }
                }     
           print("
                 <tr>
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     <!--<a href=\"javascript:void(0);\" onclick=\"PopupCenter('enter_issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp', 'myPop1',1000,500);\">
                      $xid2
                     </a>-->
	                 <!--<a href=\"#\" onclick=\"document.getElementById('contentc').innerHTML='&lt;iframe src=&quot;enter_issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">
                     </a>-->
	                 <a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;enter_issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">
                     $xid2
                     </a>
                    </font>
                    <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                   </td>
                   <td bgcolor=\"#CCFFFF\" align=\"left\" style=\"width: 600px; word-wrap: break-word; word-break:break-all;\">
                    <font color=\"#330099\">
                     <!--<textarea name=\"xissue_desc[$xid2]\" cols=\"100%\" rows=\"4\" readonly=\"readonly\">$xissue_desc</textarea>-->
                     <p style=\"width: 600px; word-wrap: break-word; word-break:break-all;\">
                      $xissue_desc
                     </p>
                    </font>
                   </td>
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#000000\">
                     $xcreated_by
                    </font>
                   </td>
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#000000\">
                     $xcreate_dt
                    </font>
                   </td>
                ");
	       print("
                 </tr>
           ");
       }      
       print("
              </table>
              <table border='0'>
                <tr>
                 <td>
                   <br />
                   <input type=\"hidden\" name=\"pdp\" value=\"$pdp\">
                   <input type=\"hidden\" name=\"pdp_id\" value=\"$xid\">
                   <input type=\"hidden\" name=\"start\" value=\"1\">
                 </td>
                </tr>
               </table>
              <!--</form>-->
       ");
       } else {
       print("
              </table>
              <table border='0'>
                <tr>
                 <td>
                   <br />
                   <input type=\"hidden\" name=\"start\" value=\"0\">
                 </td>
                </tr>
               </table>
              <!--</form>-->
       ");
        echo "<script type=\"text/javascript\">window.alert(\"No Issues of yours found for this PDP, Click OK Please\")</script>";  
        print("<script type=\"text/javascript\">
                document.forms['thisfrm'].action=\"./enter_issue_existing.php\";
                document.forms['thisfrm'].submit();
               </script>
             ");
        //$found = 0;
       }
       print("</form>");
       
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"PDP No. was not found, Click OK Please\")</script>";
   }
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
   print("<form method=\"post\" action=\"./enter_issue_existing.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Enter PDP No.</font></td>
             <td>
              <input type=\"text\" name=\"pdp\" size=\"9\" maxlength=\"9\">
             </td>
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
             </td>
            </tr>
           </table>  
          </form>  
   "); 
}

print("  </div>
        </body>
       </html>
");

mysql_close($mysql_link);

?>
