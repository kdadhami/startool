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

$queryx = "select issue_type_id,issue_type,issue_type_ind from ".$name.".issue_types order by issue_type asc"; //where issue_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt = 0;
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt                 = $issue_typ_cnt + 1;
      $issue_typ_id[$issue_typ_cnt]  = stripslashes(trim($rowx[0]));
      $issue_typ[$issue_typ_cnt]     = stripslashes(trim($rowx[1]));
      $issue_typ_ind[$issue_typ_cnt] = stripslashes(trim($rowx[2]));
}

$queryw = "select issue_area_id,issue_area from ".$name.".issue_areas"; //where issue_area_ind = 1
$mysql_dataw = mysql_query($queryw, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntw = mysql_num_rows($mysql_dataw);    

$issue_area_cnt = 0;
while($roww = mysql_fetch_row($mysql_dataw)) {
      $issue_area_cnt                = $issue_area_cnt + 1;
      $issue_area_id[$issue_area_cnt] = stripslashes(trim($roww[0]));
      $issue_area[$issue_area_cnt]    = stripslashes(trim($roww[1]));
}



   //print("$pdp");
   //$queryu = "select lanid,fullname from ".$name.".users"; 
   //$mysql_datau = mysql_query($queryu, $mysql_link) or die ("Could not query: ".mysql_error());
   //$rowcntu = mysql_num_rows($mysql_datau);    

   //    while($rowu = mysql_fetch_row($mysql_datau)) {
   //          $usr      = stripslashes($rowu[1]);
   //    }

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
	        $new_issue_type_id[$key] = addslashes($new_issue_type_id[$key] );

            $query ="INSERT into ".$name.".issues(pdp_id,issue_desc,created_by,created_on,issue_area_id,issue_type_id)
                            VALUES('$pdp_id','$new_issue_desc[$key]','$usr','$new_created_on[$key]',
                                   '$new_issue_area_id[$key]','$new_issue_type_id[$key]')";
            //print("$query");                
            $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           }
}

// Update all edited records
if ($update && $submit == "Update") {
    while (list($key) = each($update)) {
	       $xissue_id[$key]   = addslashes($xissue_id[$key]);
	       $xissue_desc[$key] = addslashes(trim(substr($xissue_desc[$key],0,2000)));

  		   $query = "UPDATE ".$name.".issues
		             SET
                         issue_desc  = '$xissue_desc[$key]'
		           WHERE issue_id = '$xissue_id[$key]'";
		   $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	}
}

// Delete all selected records
if ($delete && $submit == "Delete") {

	while (list($key) = each($delete)) {

		$query = "DELETE FROM ".$name.".issues WHERE issue_id = '$key' ";
		$mysql_data = mysql_query($query, $mysql_link);
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
                       border: 1px solid #CCCCCC; 
                       /*border-style:solid;
                       border-color:#CCCCCC;*/
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
                       width: 100%; height: 100%; background: #FFFFF0;
                       /*border: 1px solid; border-color:#BDBDBD;*/
                     }
           /*#contentb { top:0%;
                       width: 100%; height: 1%;*/ /*background: #CEE3F6;*/
                     /*}
           #contentc { top:0%;
                       width: 100%; height: 34%;*/ /*background: #CEF6E3;*/
                       /*border: 1px solid; border-color:#BDBDBD;
                     }*/
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

// -------------------------------------
// Start of the check-01
//if (isset($pdp) && ($start == 1)) {
if (isset($prd) && ($start == 1)) {
// -------------------------------------

$captn = "Issues by PDP Type";
    
// Start of HTMl

   //print("$prd");
   $queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,b.pdp_period,a.pdp_launch 
                from ".$name.".pdp a, pdp_periods b 
               where a.pdp_period_id = b.pdp_period_id and b.pdp_period = '$prd' ";
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$queryx");
   //print("Total Found "."$rowcntx");
   
   //$captn = "Issue List (Click the Issue No hyper link to see updates)";
   $trucnt = 0;
   
   // $rowcntx is no. of pdps found in a quarter
   $seq1 = 0;
   if ($rowcntx > 0) {
       $found = 1;

       print("
         <form method=\"post\" action=\"./list_by_prd.php\">
           <table border='0' scroll=\"yes\" >
           <caption>$captn</caption>
            <tr>
             <td bgcolor=\"#FF0000\" align=\"left\" valign=\"middle\" style=\"width:75px\">
              <font color=\"#FFFFFF\">
               PDP Type
              </font>
             </td>
             <td bgcolor=\"#FFFF00\" style=\"width:200px\">                
              <font color=\"#330099\">
               $prd
              </font>
             </td>
            </tr>
            <!--<tr>
             <td bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" style=\"width:75px\">
              <font color=\"#FFFFFF\">
               Current User
              </font>
             </td>
             <td bgcolor=\"#FFFF00\" valign=\"middle\" style=\"width:200px\">                
	          <font color=\"#330099\"> 
               $usr
              </font>               
             </td>
            </tr>-->
            <tr>
             <td bgcolor=\"#FF0000\" align=\"left\" valign=\"middle\" style=\"width:75px\">
              <font color=\"#FFFFFF\">
               Report Date
              </font>
             </td>
             <td bgcolor=\"#FFFF00\" valign=\"middle\" style=\"width:200px\">                
	          <font color=\"#330099\"> 
               $ydate
              </font>               
             </td>
            </tr>
           </table>
           <br />
          ");

       while($rowx = mysql_fetch_row($mysql_datax)) {
             $seq1         = $seq1 + 1; 
             $xid          = stripslashes($rowx[0]);
             $xpdpdesc     = stripslashes(trim($rowx[1]));
             $xdesc        = stripslashes(trim($rowx[2]));
             $xpdp_period  = stripslashes(trim($rowx[3])); 
             $xpdp_launch    = stripslashes($rowx[4]);

             if (empty($xpdp_launch)){
                 $xpdp_launch_dt = "Date Not Set";
                 //print ("True");
                 //$trucnt = $trucnt + 1;
             } else {
                     $xld            = date("d",$xpdp_launch);
                     $xlm            = date("M",$xpdp_launch);
                     $xly            = date("Y",$xpdp_launch);
                     $xpdp_launch_dt = $xld."-".$xlm."-".$xly;
             }

             $captn1 = "Summary";
             print("
                 <table border='0' scroll=\"yes\">
                 <caption>$captn1</caption> 
                 <tr>
                   <td bgcolor=\"#FF0000\" align=\"left\" style=\"width:75px\">
                    <font color=\"#FFFFFF\">
                     PDP No.
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     $seq1
                    </font>
                   </td>
                 </tr>
                 <tr>
                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:75px\">
                    <font color=\"#330099\">
                     PDP
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     $xpdpdesc
                    </font>
                   </td>
                 </tr>
                 <tr>
                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:75px\">
                    <font color=\"#330099\">
                     PDP Description
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     $xdesc
                    </font>
                   </td>
                 </tr>
                 <tr>
                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:75px\">
                    <font color=\"#330099\">
                     Launch Date
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     $xpdp_launch_dt
                    </font>
                   </td>
                 </tr>
              ");
              
           // $rowcnt is the no. of issues found in a pdp
           // Select all issues for given pdp
           $query = "select issue_id,pdp_id,issue_desc,created_by,created_on,issue_area_id,issue_type_id from ".$name.".issues where pdp_id = '$xid'";   // and created_by = '$usr'
           $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           $rowcnt = mysql_num_rows($mysql_data);
           //print($query);

           if ($rowcnt == 0) {

             print("
                 <tr>
                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:75px\">
                    <font color=\"#330099\">
                     Issues Created
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     None
                    </font>
                   </td>
                 </tr>
                 <tr></tr> 
                 <tr></tr> 
                 <tr></tr> 
                 <tr></tr> 
                </table>
                 ");
           }
           else
           {
             print("
                 <tr>
                   <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:75px\">
                    <font color=\"#330099\">
                     Issues Created
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" style=\"width:200px\">
                    <font color=\"#330099\">
                     $rowcnt
                    </font>
                   </td>
                 </tr>
                </table> 
                 ");
                                 
           $seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt = 0;
                 $seq = $seq + 1;
	             $xid2            = stripslashes($row[0]);
                 $xpdp_id         = stripslashes($row[1]);
	             $xissue_desc     = stripslashes(trim($row[2]));
                 $xcreated_by     = stripslashes($row[3]);
                 $xcreated_on     = stripslashes($row[4]);
                 $xissue_area_id  = stripslashes($row[5]);
                 $xissue_type_id  = stripslashes($row[6]);
                 $xd1             = date("d",$xcreated_on);
                 $xm1             = date("M",$xcreated_on);
                 $xy1             = date("Y",$xcreated_on);
                 $xcreate_dt      = $xd1."-".$xm1."-".$xy1;
                 $xissue_assignee = $xcreated_by;

                 $query22 = "select issue_surrogate_id,issue_type_id from ".$name.".issue_surrogates where issue_surrogate_id = '$xid2' and surrogate_type = 0"; 
                 $mysql_data22 = mysql_query($query22, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcnt22 = mysql_num_rows($mysql_data22);
                 $issue_sur_cnt0 = 0;
                 $xissue_sur_id0 = array();
                 $xissue_typ_id0 = array();
                 while($row22 = mysql_fetch_row($mysql_data22)) {
                       $issue_sur_cnt0                       = $issue_sur_cnt0 + 1;
                       $xissue_sur_id0[$issue_sur_cnt0]       = $row22[0];
                       $xissue_typ_id0[$issue_sur_cnt0]       = $row22[1];
                 }


                 //find out total updates on this issue   
                 $queryk = "select issue_history_id,issue_id,issue_assignee,issue_note_dt,issue_note,issue_type_id,issue_area_id from ".$name.".issue_history where issue_id = '$xid2' ";
                 $mysql_datak = mysql_query($queryk, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcntk = mysql_num_rows($mysql_datak); 

                 //pick the last one 
                 $queryh = "select issue_history_id,issue_id,issue_assignee,issue_note_dt,issue_note,issue_area_id from ".$name.".issue_history where issue_id = '$xid2' order by issue_history_id desc limit 1";
                 //print $query;
                 $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcnth = mysql_num_rows($mysql_datah);                 
                 
                 if ($rowcnth == 1) {
                     while($rowh = mysql_fetch_row($mysql_datah)) {
                           $xid3              = stripslashes($rowh[0]);
                           //$xid2            = stripslashes($rowh[1]);
                           $xissue_assignee   = stripslashes(strtoupper(trim($rowh[2])));
                           $xissue_note_dt    = stripslashes($rowh[3]);
                           $xd                = date("d",$xissue_note_dt);
                           $xm                = date("M",$xissue_note_dt);
                           $xy                = date("Y",$xissue_note_dt);
                           $xdt               = $xd."-".$xm."-".$xy;
                           //$xissue_status   = stripslashes(strtoupper(trim($row[4])));
                           $xissue_note       = stripslashes(trim($rowh[4]));
                           //$xissue_type_id_n  = stripslashes($rowh[5]);     //will superimpose $xissue_type_id above
                           $xissue_area_id_n  = stripslashes($rowh[5]);     //will superimpose $xissue_area_id above
                           $query21 = "select issue_surrogate_id,issue_type_id from ".$name.".issue_surrogates where issue_surrogate_id = '$xid3' and surrogate_type = 1"; 
                           $mysql_data21 = mysql_query($query21, $mysql_link) or die ("Could not query: ".mysql_error());
                           $rowcnt21 = mysql_num_rows($mysql_data21);
                           //print($query21."<br>"); 
                           //print($rowcnt21."<br>");
                           $issue_sur_cnt = 0;
                           $xissue_sur_id = array();
                           $xissue_typ_id = array();
                           while($row21 = mysql_fetch_row($mysql_data21)) {
                                 $issue_sur_cnt                       = $issue_sur_cnt + 1;
                                 //print($issue_sur_cnt."-".$row21[0]."-".$row21[1]."<br>");
                                 $xissue_sur_id[$issue_sur_cnt]       = $row21[0];
                                 $xissue_typ_id[$issue_sur_cnt]       = $row21[1];
                                 //$xissue_surrogate_id[$issue_sur_cnt] = $xissue_sur_id;
                                 //$xissue_type_id[$issue_sur_cnt]      = $xissue_typ_id;
                                 //print($issue_sur_cnt."-".$xissue_sur_id[$issue_sur_cnt]."-".$xissue_typ_id[$issue_sur_cnt]."<br>");
                           }
                 }
                  $rowcnt1 = $rowncnth;
                } else 
                {
                  $xissue_note      = ""; //$xissue_desc; 
                  //$xissue_type_id_n = ""; //$xissue_type_id;
                  $xissue_area_id_n = ""; //$xissue_area_id;
                  $xdt              = ""; //$xcreate_dt;
                  $xissue_assignee  = ""; //$xcreated_by; 
                }
           if ($seq == 1) {         
           print("
            <table border='0' scroll=\"yes\" >
            <!--<caption>$captn</caption>-->
             <tr>
               <td bgcolor=\"#99CCFF\" align=\"center\" width=\"50px\"><font color=\"#330099\">Seq</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" width=\"50px\"><font color=\"#330099\">Issue Id</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Created</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Last Updated</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" width=\"50px\"><font color=\"#330099\">Updates</font></td>
             </tr>
           ");
           }
           print("
                  <tr>
                   <td bgcolor=\"#FFC000\" align=\"center\" rowspan=\"6\" width=\"50px\">
                    <font color=\"#330099\">
                     $seq
                    </font>
                   </td> 
                   <td bgcolor=\"#E8E8E8\" align=\"center\" rowspan=\"6\">
                    <font color=\"#330099\">
                     <a href=\"javascript:void(0);\" onclick=\"PopupCenter('list_issue_updates_3.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$xpdpdesc', 'myPop1',1000,500);\">
                      $xid2
                     </a>
	                 <!--<a href=\"#\" onclick=\"document.getElementById('contentc').innerHTML='&lt;iframe src=&quot;enter_issue_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\"></a>-->
	                 <!--<a href=\"#\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;list_pdp_updates.php?v_issue_id=$xid2&&v_issue_hist_id=$xid3&&v_usr=$usr&&pdp=$pdp&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">$xid2</a>-->
                    </font>
                    <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                   </td>
                  </tr>

                  <tr> 
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     Description
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" align=\"left\" width=\"400px\">
                    <font color=\"#330099\">
                     <!--<textarea name=\"xissue_desc[$xid2]\" cols=\"30\" rows=\"2\" readonly=\"readonly\">$xissue_desc</textarea>-->
                     <p>$xissue_desc</p>
                    </font>
                   </td>
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     Description
                    </font>
                   </td>
                   <td bgcolor=\"#CCFFFF\" align=\"left\" width=\"400px\">
                    <font color=\"#330099\">
                     <!--<textarea name=\"xissue_note[$xid2]\" cols=\"30\" rows=\"2\" readonly=\"readonly\">$xissue_note</textarea>-->
                     <p>$xissue_note</p>
                    </font>
                   </td>

                   <td bgcolor=\"#E8E8E8\" align=\"center\" rowspan=\"6\">
                    <font color=\"#000000\">
                     $rowcntk
                    </font>
                   </td>                   
                  </tr>

                  <tr> 
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     By
                    </font>
                   </td>
                   <td bgcolor=\"#E8E8E8\" align=\"center\" width=\"400px\">
                    <font color=\"#330099\">
                     $xcreated_by
                    </font>
                   </td>
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     By
                    </font>
                   </td>                   
                   <td bgcolor=\"#E8E8E8\" align=\"center\" width=\"400px\">
                    <font color=\"#330099\">
                     $xissue_assignee
                    </font>
                   </td>
                  </tr>

                  <tr> 
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     On
                    </font>
                   </td>
                   <td bgcolor=\"#E8E8E8\" align=\"center\" width=\"400px\">
                    <font color=\"#330099\">
                     $xcreate_dt
                    </font>
                   </td>
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     On
                    </font>
                   </td>
                   <td bgcolor=\"#E8E8E8\" align=\"center\" width=\"400px\">
                    <font color=\"#330099\">
                     $xdt
                    </font>
                   </td>
                  </tr> 

                  <tr> 
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     Department
                    </font>
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" width=\"400px\">
                    <font color=\"#330099\">
               ");
         $w = 0;
         for ($w=1;$w<=$issue_area_cnt ; ++$w) {
              if ($issue_area_id[$w] == $xissue_area_id) {
                  print("$issue_area[$w]");
              }
         }
         print("     </font>
                    </td>
                    <td bgcolor=\"#99CCFF\" align=\"left\">
                     <font color=\"#330099\">
                      Department
                     </font>
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" width=\"400px\">
                     <font color=\"#330099\">  
               ");
         $w1 = 0;
         for ($w1=1;$w1<=$issue_area_cnt ; ++$w1) {
              if ($issue_area_id[$w1] == $xissue_area_id_n) {
                  print("$issue_area[$w1]");
              }
         }
         print("     </font>
                    </td>
                   </tr>

                   <tr> 
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                    Root Cause
                    </font>
                   </td>
                    <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" width=\"400px\">
    	                  <font color=\"#330099\"> 
                 ");
                 for ($sur=1;$sur<=$issue_sur_cnt0; ++$sur){
                      for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                           if ($issue_typ_id[$v] == $xissue_typ_id0[$sur]){
                               print("&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ[$v]."<br>");
                           }    
                      }
                 }
                 print("  </font>
                   </td>
                   <td bgcolor=\"#99CCFF\" align=\"left\">
                    <font color=\"#330099\">
                     Root Cause
                    </font>
                   </td>
                    <td align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" width=\"400px\">
                     <font color=\"#330099\">
         ");   
         if ($rowcnth == 0) {
         } else {
         for ($sur1=1;$sur1<=$issue_sur_cnt; ++$sur1){
              //$v = 0;
              for ($v1=1;$v1<=$issue_typ_cnt ; ++$v1) {
                   if ($issue_typ_id[$v1] == $xissue_typ_id[$sur1]){
                       print("&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ[$v1]."<br>");
                     }    
                }
          }
         } 
          print("    </font>
                   </td>
                  </tr> 
           ");
       }      
       }
       print("
                  <tr>
                  </tr>
                  <tr>
                  </tr>
                 </table>  
             ");
       //---------
       }
       //--------- 
 
       print("
              <!--</table>
              <table border='0'>
                <tr>
                 <td>
                   <br />-->
                   <!--<input type=\"submit\" name=\"submit\" value=\"Update\">-->             
             "); 
       print("     <!--<input type=\"hidden\" name=\"prd\" value=\"$prd\">
                   <input type=\"hidden\" name=\"start\" value=\"1\">
                 </td>
                </tr>
               </table>-->
               <input type=\"hidden\" name=\"prd\" value=\"$prd\">
               <input type=\"hidden\" name=\"start\" value=\"1\">
              </form>
       ");
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"No PDP for this Period was not found, Try Again\")</script>";  
   }
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {

   //$queryt = "select distinct(a.pdp_period) from ".$name.".pdp_periods a, pdp b where a.pdp_period_id = b.pdp_period_id";
   $queryt = "select distinct(pdp_period) from ".$name.".pdp_periods where pdp_period_ind = 1";
   $mysql_datat = mysql_query($queryt, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntt = mysql_num_rows($mysql_datat); 
   //print($rowcntt);
   //print($queryt); 
     
   $prdcnt = 0;
   while($rowt = mysql_fetch_row($mysql_datat)) {
         $prdcnt            = $prdcnt + 1;
         $pdp_prd           = stripslashes($rowt[0]);
         $xpdp_prd[$prdcnt] = $pdp_prd;
         //print($prdcnt."-".$xpdp_prd[$prdcnt]."<br>");
   }

   print("<form method=\"post\" action=\"./list_by_prd.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\">
              <font color=\"#330099\">Select Period:</font>
             </td>
             <td>
              <select name=\"prd\">
        ");
   for ($p=1;$p<=$prdcnt ; ++$p) {
        print("<option value=\"$xpdp_prd[$p]\">$xpdp_prd[$p]</option>");
   }     
   print("
              </select>
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
         <!--<div id=\"contentb\">
         </div>   
         <div id=\"contentc\">
         </div>-->     
        </body>
       </html>
");

?>
