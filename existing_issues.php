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

// ------------------>>>>>> Root Cause
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'ROT'  
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt = 0;
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt                   = $issue_typ_cnt + 1;
      $issue_typ_id[$issue_typ_cnt]    = stripslashes(trim($rowx[0]));
      $issue_typ[$issue_typ_cnt]       = stripslashes(trim($rowx[1]));
      $issue_typ_ind[$issue_typ_cnt]   = stripslashes(trim($rowx[2]));
      $issue_typ_class[$issue_typ_cnt] = stripslashes(trim($rowx[3]));
      //print($issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
}

// ------------------>>>>>> Contributing Factor
$queryx2 = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'CNT'  
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx2 = mysql_num_rows($mysql_datax2);    

$issue_typ_cnt2 = 0;
while($rowx2 = mysql_fetch_row($mysql_datax2)) {
      $issue_typ_cnt2                    = $issue_typ_cnt2 + 1;
      $issue_typ_id2[$issue_typ_cnt2]    = stripslashes(trim($rowx2[0]));
      $issue_typ2[$issue_typ_cnt2]       = stripslashes(trim($rowx2[1]));
      $issue_typ_ind2[$issue_typ_cnt2]   = stripslashes(trim($rowx2[2]));
      $issue_typ_class2[$issue_typ_cnt2] = stripslashes(trim($rowx2[3]));
      //print($issue_typ_id2[$issue_typ_cnt2]." - ".$issue_typ2[$issue_typ_cnt2]."-".$issue_typ_class2[$issue_typ_cnt2]."<br>");
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

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period 
             from ".$name.".pdp_periods 
            where pdp_period_ind = 1 order by pdp_period asc"; 
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

// setting up today's date
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
//print ("$yentry_dt");
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

// -------------- >>> Delete
if ($submit == "Submit") {
    if (isset($update)) {
        //print("I am here");
	    while (list($key)   = each($update)) {
	           $xissue_desc[$key]   = addslashes(trim(substr($xissue_desc[$key],0,500)));
		       $query               = "update ".$name.".issues
                                          set issue_desc = '$xissue_desc[$key]'
                                        where issue_id = '$key'";
		       //print($query);
		       $mysql_data  = mysql_query($query, $mysql_link);
	    }
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
$captn = "Issues Summary";
// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------
   $queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch 
                from ".$name.".pdp a 
               where a.pdp_desc = '$pdp' "; 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$queryx");
   //print("$rowcntx");

   if ($rowcntx == 1) {
       $found = 1;   
       while($rowx = mysql_fetch_row($mysql_datax)) {
             $xid            = stripslashes($rowx[0]);
             $xpdpdesc       = stripslashes(trim($rowx[1]));
             $xdesc          = stripslashes(trim($rowx[2]));
             $xpdp_period_id = stripslashes(trim($rowx[3])); 
             $xpdp_launch    = stripslashes($rowx[4]);
             
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
                     $query100 = "select b.pdp_period 
                                    from ".$name.".pdp a, pdp_periods b 
                                   where a.pdp_desc = '$pdp' 
                                     and a.pdp_period_id = b.pdp_period_id";
                     //print($query100);
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     while($row100 = mysql_fetch_row($mysql_data100)) {
                           $xpdp_period = stripslashes(trim($row100[0]));
                     }
             }
       }
       print("  <form method=\"post\" action=\"./existing_issues.php\" id=\"thisfrm\">
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
       print("      </font>
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
                     User Department
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
      	          <font color=\"#330099\"> 
                     $uissue_area
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
                    <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" colspan=\"10\"><font color=\"#0000FF\"><strong>ISSUES RAISED FOR $uissue_area</strong></font></td>
                   </tr>
                   <tr>
                     <td bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#FFFFFF\">Issue No.</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#330099\" style=\"width: 200px;\">Title</font></td>
                     <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" colspan=\"3\"><font color=\"#330099\" style=\"width: 150px;\">Created</font></td>
                     <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" colspan=\"4\"><font color=\"#330099\" style=\"width: 350px;\">Last Update</font></td>
                     <td bgcolor=\"#ECE5B6\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#330099\">Void</font></td>
                   </tr>
                   <tr>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">By</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">On</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">From</font></td>                     
                   <!--</tr>
                   <tr>-->
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 200px;\">Notes</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">By</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">On</font></td>                     
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">From</font></td>                     
                   </tr>
      ");
      // Issues raised for
      $query = "select a.issue_id,a.pdp_id,a.issue_desc,a.created_by,a.created_on,a.issue_area_id,
                       a.void,b.issue_area 
                  from ".$name.".issues a,".$name.".issue_areas b 
                 where a.pdp_id = '$xid'
                   and a.issue_area_id = '$uissue_area_id' 
                   and a.issue_area_id_by = b.issue_area_id
              order by a.void asc, a.issue_id asc"; 
              //and created_by = '$usr' ";
              //and issue_area_id = '$uissue_area_id'
      $mysql_data = mysql_query($query, $mysql_link) or die ("#100 Could not query: ".mysql_error());
      $rowcnt = mysql_num_rows($mysql_data);
      // Issue raised by
      $query2 = "select a.issue_id,a.pdp_id,a.issue_desc,a.created_by,a.created_on,a.issue_area_id,
                       a.void,b.issue_area,a.issue_area_id_by 
                  from ".$name.".issues a,".$name.".issue_areas b 
                 where a.pdp_id = '$xid'
                   and a.issue_area_id_by = '$uissue_area_id'
                   and a.issue_area_id  <> '$uissue_area_id' 
                   and a.issue_area_id = b.issue_area_id
              order by a.void asc, a.issue_id asc"; 
              //and created_by = '$usr' ";
              //and issue_area_id = '$uissue_area_id'
      $mysql_data2 = mysql_query($query2, $mysql_link) or die ("#100 Could not query: ".mysql_error());
      $rowcnt2 = mysql_num_rows($mysql_data2);

      //print($query."<br>".$rowcnt."<br>".$query2."<br>".$rowcnt2);
      if (($rowcnt <> 0) && ($rowcnt2 <> 0)){           
          $seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt         = 0;
                 $seq            = $seq + 1;
	             $xid2           = stripslashes($row[0]);
                 $xpdp_id        = stripslashes($row[1]);
	             $xissue_desc    = stripslashes(trim($row[2]));
                 $xcreated_by    = stripslashes($row[3]);
                 $xcreated_on    = stripslashes($row[4]);
                 $xissue_area_id = stripslashes($row[5]);
                 $xissue_area_by = stripslashes($row[7]);
                 $xd1            = date("d",$xcreated_on);
                 $xm1            = date("M",$xcreated_on);
                 $xy1            = date("Y",$xcreated_on);
                 $xcreate_dt     = $xd1."-".$xm1."-".$xy1;
                 $xvoid          = stripslashes($row[6]);
                 
                 // ------------->>> Find out if Issue updates exists
                 $queryh = "select a.issue_history_id,a.issue_id,a.issue_assignee,a.issue_note_dt,a.issue_note,
                                   a.issue_area_id,b.issue_area
                              from ".$name.".issue_history a, ".$name.".issue_areas b 
                             where a.issue_id = '$xid2' 
                               and a.issue_area_id_by = '$uissue_area_id'
                               and a.issue_area_id_by = b.issue_area_id 
                          order by a.issue_history_id desc limit 1"; //limit 1
                 //print($queryh);
                 $mysql_datah = mysql_query($queryh, $mysql_link) or die ("#101 Could not query: ".mysql_error());
                 $rowcnth = mysql_num_rows($mysql_datah);                 
                 
                 if ($rowcnth == 1) {
                    while($rowh = mysql_fetch_row($mysql_datah)) {
                           $xid3              = stripslashes($rowh[0]);
                           $xissue_assignee   = stripslashes(strtoupper(trim($rowh[2])));
                           $xissue_note_dt    = stripslashes($rowh[3]);
                           $xd                = date("d",$xissue_note_dt);
                           $xm                = date("m",$xissue_note_dt);
                           $xy                = date("Y",$xissue_note_dt);
                           $xdt               = $xd."-".$xm."-".$xy;
                           $xissue_note       = stripslashes(trim($rowh[4]));
                           $xissue_area_a     = stripslashes($rowh[6]);  
                    }
                 } else {
                           $xissue_assignee   = "&nbsp";
                           $xissue_note       = "&nbsp";
                           $xissue_area_a     = "&nbsp";  
                           $xdt               = "&nbsp";
                 }
                 if ($xvoid == 1){
                     $bcolr = "#E8E8E8";
                     $fcolr = "#747170";
                 } else {
                     $bcolr = "#CCFFFF";
                     $fcolr = "#330099";
                 }     
                 print("
                        <tr>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\">
	                       <a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&&uissue_area=$uissue_area&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">
                            $xid2
                           </a>
                          </font>
                          <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                         </td>
                ");
                //if ($xissue_area_by == $uissue_area){         
                //    print(" <td align=\"left\" valign=\"middle\" style=\"width: 200px; word-wrap: break-word; word-break:break-all; background-color: $bcolr\">
                //             <font color=\"$fcolr\">
                //             <textarea name=\"xissue_desc[$xid2]\" rows=\"2\" style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">$xissue_desc</textarea>
                //            </td>
                //    ");        
                //} else {
                    print(" <td align=\"left\" valign=\"middle\" style=\"width: 200px; word-wrap: break-word; word-break:break-all; background-color: $bcolr\">
                             <font color=\"$fcolr\">
                              <p style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">
                               $xissue_desc
                              </p>
                             <!--<textarea name=\"xissue_desc[$xid2]\" rows=\"2\" style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">$xissue_desc</textarea>-->
                            </td>
                    ");        
                //}
                print("         
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xcreated_by
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xcreate_dt
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_area_by
                          </font>
                         </td>
                         <td align=\"left\" valign=\"middle\" style=\"width: 250px; word-wrap: break-word; word-break:break-all; background-color: $bcolr\">
                          <font color=\"$fcolr\">
                           <p style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
                            $xissue_note
                           </p>    
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_assignee
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xdt
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_area_a
                          </font>
                         </td>
                 ");
                 
                 if ($xvoid == 1){
                     print("
                              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                               <font color=\"$fcolr\">
                                Yes
                               </font>
                              </td>                            
                     ");
                 } else {
                     print("
                              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                               <font color=\"$fcolr\">
                               </font>
                              </td>                            
                     ");
                 }
                 print("</tr>");
           } 
           print("
                   <tr>
                    <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" colspan=\"11\">&nbsp</td>
                   </tr>
                   <tr>
                    <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" colspan=\"10\"><font color=\"#0000FF\"><strong>ISSUES RAISED BY $uissue_area FOR OTHERS</strong></font></td>
                   </tr>
                   <tr>
                     <td bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#FFFFFF\">Issue No.</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#330099\" style=\"width: 200px;\">Title</font></td>
                     <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" colspan=\"3\"><font color=\"#330099\" style=\"width: 150px;\">Created</font></td>
                     <td bgcolor=\"#CCCCCC\" align=\"center\" valign=\"middle\" colspan=\"4\"><font color=\"#330099\" style=\"width: 350px;\">Last Update</font></td>
                     <td bgcolor=\"#ECE5B6\" align=\"center\" valign=\"middle\" rowspan=\"2\"><font color=\"#330099\">Void</font></td>
                   </tr>
                   <tr>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">By</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">On</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">For</font></td>                     
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 200px;\">Notes</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">By</font></td>
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">On</font></td>                     
                     <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\" style=\"width: 50px;\">From</font></td>                     
                   </tr>
           ");
                
           while($row2 = mysql_fetch_row($mysql_data2)) {
                 $delcnt             = 0;
                 $seq                = $seq + 1;
	             $xid2               = stripslashes($row2[0]);
                 $xpdp_id            = stripslashes($row2[1]);
	             $xissue_desc        = stripslashes(trim($row2[2]));
                 $xcreated_by        = stripslashes($row2[3]);
                 $xcreated_on        = stripslashes($row2[4]);
                 $xissue_area_id     = stripslashes($row2[5]);
                 $xissue_area        = stripslashes($row2[7]);
                 $xissue_area_by_id  = stripslashes($row2[8]);
                 $xd1                = date("d",$xcreated_on);
                 $xm1                = date("M",$xcreated_on);
                 $xy1                = date("Y",$xcreated_on);
                 $xcreate_dt         = $xd1."-".$xm1."-".$xy1;
                 $xvoid              = stripslashes($row2[6]);
                 
                 // ------------->>> Find out if Issue updates exists
                 $queryh2 = "select a.issue_history_id,a.issue_id,a.issue_assignee,a.issue_note_dt,a.issue_note,
                                   a.issue_area_id,b.issue_area
                              from ".$name.".issue_history a, ".$name.".issue_areas b 
                             where a.issue_id = '$xid2' 
                               and a.issue_area_id_by = $uissue_area_id
                               and a.issue_area_id_by = b.issue_area_id 
                          order by a.issue_history_id desc limit 1"; //limit 1
                 //print($queryh2);
                 $mysql_datah2 = mysql_query($queryh2, $mysql_link) or die ("#102 Could not query: ".mysql_error());
                 $rowcnth2 = mysql_num_rows($mysql_datah2);                 
                 
                 if ($rowcnth2 == 1) {
                    while($rowh2 = mysql_fetch_row($mysql_datah2)) {
                           $xid3              = stripslashes($rowh2[0]);
                           $xissue_assignee   = stripslashes(strtoupper(trim($rowh2[2])));
                           $xissue_note_dt    = stripslashes($rowh2[3]);
                           $xd                = date("d",$xissue_note_dt);
                           $xm                = date("m",$xissue_note_dt);
                           $xy                = date("Y",$xissue_note_dt);
                           $xdt               = $xd."-".$xm."-".$xy;
                           $xissue_note       = stripslashes(trim($rowh2[4]));
                           $xissue_area_a     = stripslashes($rowh2[6]);  
                    }
                 } else {
                           $xissue_assignee   = "&nbsp";
                           $xissue_note       = "&nbsp";
                           $xissue_area_a     = "&nbsp";  
                           $xdt               = "&nbsp";
                 }
                 if ($xvoid == 1){
                     $bcolr = "#E8E8E8";
                     $fcolr = "#747170";
                 } else {
                     $bcolr = "#CCFFFF";
                     $fcolr = "#330099";
                 }     
                 print("
                        <tr>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\">
	                       <a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&&uissue_area=$uissue_area&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">
                            $xid2
                           </a>
                          </font>
                          <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                         </td>
                         <td align=\"left\" valign=\"middle\" style=\"width: 200px; word-wrap: break-word; word-break:break-all; background-color: $bcolr\">
                          <font color=\"$fcolr\">
                              <p style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">
                               $xissue_desc
                              </p>
                           <!--<textarea name=\"xissue_desc[$xid2]\" rows=\"2\" style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">$xissue_desc</textarea>-->
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xcreated_by
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xcreate_dt
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_area
                          </font>
                         </td>
                         <td align=\"left\" valign=\"middle\" style=\"width: 250px; word-wrap: break-word; word-break:break-all; background-color: $bcolr\">
                          <font color=\"$fcolr\">
                           <p style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
                            $xissue_note
                           </p>    
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_assignee
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xdt
                          </font>
                         </td>
                         <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                          <font color=\"$fcolr\"  style=\"width: 50px;\">
                           $xissue_area_a
                          </font>
                         </td>
                 ");
                 if ($xvoid == 1){
                     print("
                              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                               <font color=\"$fcolr\">
                                Yes
                               </font>
                              </td>                            
                     ");
                 } else {
                     print("
                              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">
                               <font color=\"$fcolr\">
                               </font>
                              </td>                            
                     ");
                 }
                 print("</tr>");
           } 

           print("
                    </table>
                    <!--<table border='0'>
                      <tr>
                       <td>
                         <br />
                         <input type=\"submit\" name=\"submit\" value=\"Submit\">
                         <input type=\"hidden\" name=\"pdp\" value=\"$pdp\">
                         <input type=\"hidden\" name=\"pdp_id\" value=\"$xid\">
                         <input type=\"hidden\" name=\"start\" value=\"1\">
                       </td>
                      </tr>
                     </table>-->
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
           ");
           echo "<script type=\"text/javascript\">window.alert(\"No Issues found for this PDP, Click OK Please\")</script>";  
           print("<script type=\"text/javascript\">
                    document.forms['thisfrm'].action=\"./existing_issues.php\";
                    document.forms['thisfrm'].submit();
                  </script>
           ");
      }
      print("</form>");       
   } else {
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
   print("<form method=\"post\" action=\"./existing_issues.php\">
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
