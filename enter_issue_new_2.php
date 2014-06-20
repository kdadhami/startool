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
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#1 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)) FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#2 Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);       
              //print($yissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================


// ======================================= INITIALIZATION START ====================================
// ------------------>>>>>> Root Cause
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'ROT'  
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#3 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt                   = 0;
$issue_typ_cnt                   = $issue_typ_cnt + 1;
$issue_typ_id[$issue_typ_cnt]    = 0;
$issue_typ[$issue_typ_cnt]       = "";
$issue_typ_ind[$issue_typ_cnt]   = 1;
$issue_typ_class[$issue_typ_cnt] = 0;
//print($issue_typ_cnt."-".$issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt                   = $issue_typ_cnt + 1;
      $issue_typ_id[$issue_typ_cnt]    = stripslashes(trim($rowx[0]));
      $issue_typ[$issue_typ_cnt]       = stripslashes(trim($rowx[1]));
      $issue_typ_ind[$issue_typ_cnt]   = stripslashes(trim($rowx[2]));
      $issue_typ_class[$issue_typ_cnt] = stripslashes(trim($rowx[3]));
      //print($issue_typ_cnt."-".$issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
}

// ------------------>>>>>> Contributing Factor
$queryx2 = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'CNT'  
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#4 Could not query: ".mysql_error());
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

$queryw = "select issue_area_id,issue_area from ".$name.".issue_areas where issue_area_ind = 1"; 
$mysql_dataw = mysql_query($queryw, $mysql_link) or die ("#5 Could not query: ".mysql_error());
$rowcntw = mysql_num_rows($mysql_dataw);    

$issue_area_cnt = 0;
while($roww = mysql_fetch_row($mysql_dataw)) {
      $issue_area_cnt                = $issue_area_cnt + 1;
      $issue_area_id[$issue_area_cnt] = stripslashes(trim($roww[0]));
      $issue_area[$issue_area_cnt]    = stripslashes(trim($roww[1]));
}

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period 
             from ".$name.".pdp_periods 
            where pdp_period_ind = 1 order by pdp_period asc"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#6 Could not query: ".mysql_error());
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
// ======================================= INITIALIZATION END ====================================

// ================================ INSERT, UPDATE, DELETE START =================================
// Insert a record
if ($submit == "Save") {
	while (list($key) = each($new)) {
	   if (strlen($new_issue_desc[$key]) >= 1){
	      //if (isset($new_issue_type_id[$key])){
	      if ($new_issue_type_id[$key] <> 0){
	          $new_issue_desc[$key]     = addslashes(trim(substr($new_issue_desc[$key],0,500)));
	          $new_created_on[$key]     = $yentry_dt; //mktime(0,0,0,$ym,$yd,$yy);
	          $new_issue_area_id[$key]  = addslashes($new_issue_area_id[$key] );
              $query                    = "INSERT into ".$name.".issues(pdp_id,issue_desc,created_by,created_on,
                                                                        issue_area_id,issue_area_id_by)
                                           VALUES('$pdp_id','$new_issue_desc[$key]','$usr','$new_created_on[$key]',
                                                  '$new_issue_area_id[$key]','$uissue_area_id')";
              //print("$query");                
              $mysql_data               = mysql_query($query, $mysql_link) or die ("#7 Could not query: ".mysql_error());
              $xissue_surrogate_id      = mysql_insert_id();
              //while (list($key2)        = each($new_issue_type_id[$key])) {
                     $yissue_type_id    = addslashes($new_issue_type_id[$key]);              
                     $query11           = "INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,
                                                                                  surrogate_type)
                                           VALUES('$xissue_surrogate_id','$yissue_type_id','0')";
                     //print("$query11");                
                     $mysql_data11      = mysql_query($query11, $mysql_link) or die ("#8 Could not query: ".mysql_error());
              //}
              if (isset($new_issue_type_id2[$key])){
                 while (list($key2)       = each($new_issue_type_id2[$key])) {
                        $yissue_type_id2  = addslashes($new_issue_type_id2[$key][$key2]);              
                        $query12          = "INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,
                                                                                    surrogate_type)
                                             VALUES('$xissue_surrogate_id','$yissue_type_id2','0')";
                        $mysql_data12     = mysql_query($query12, $mysql_link) or die ("#9 Could not query: ".mysql_error());
                 }
              } 
         } else {
             echo "<script type=\"text/javascript\">window.alert(\"No Root Cause selected, Click OK Please\")</script>";
             $start  = 1;
             $zdesc  = $new_issue_desc[$key];
             $submit = "notinsert"; 
         }
       } else {
         echo "<script type=\"text/javascript\">window.alert(\"Description missing or too short, Click OK Please\")</script>";
         $start = 1;
         $zdesc = $new_issue_desc[$key];
         $submit = "notinsert";
       }  
    }
           
}
// ================================ INSERT, UPDATE, DELETE END =================================

print("<html>
        <head>
         <style>
             body { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px; 
                  }
               td { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                    color: #FFFFFF; 
                  }
         textarea {font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }        
          /*caption {background:#FFC000; color:#0000FF; font-size:1em;}*/
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
           select { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }                   
           #content
                  { top:0%;
                    width: 100%; height: 65%; background: #FFFFF0;
                    /*border: 1px solid; border-color:#BDBDBD;*/
                  }
           /*
           #contentb
                  { top:0%;
                    width: 100%; height: 1%; /*background: #CEE3F6;*/
                  }
           #contentc
                  { top:0%;
                    width: 100%; height: 34%; /*background: #CEF6E3;*/
                    /*border: 1px solid; border-color:#BDBDBD;*/
                  }
           */       
           #content a:link {
                  text-decoration: none;
                      color: #2554C7;
                      }
           #content a:visited {
                      text-decoration: none;
                      color: #2554C7;
                      }
           #content a:hover {
                      text-decoration: underline overline;
                      color: #2554C7;
                      }
           #content a:active {
                      text-decoration: none;
                      color: #2554C7;
                      }
            a:link {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:visited {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:hover {
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

$captn = "Raise New Issue";
// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------
   // ---------->>>> looking up PDP
   $queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch 
                from ".$name.".pdp a 
               where a.pdp_desc = '$pdp' "; 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#10 Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);
   //print($queryx);
       
   if ($rowcntx == 1) {
       //print($rowcntx);
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
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#11 Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     while($row100 = mysql_fetch_row($mysql_data100)) {
                           $xpdp_period = stripslashes(trim($row100[0]));
                     }
             }
                                        
       }
       // ---------->>>> display PDP Info
       print("
         <form method=\"post\" action=\"./enter_issue_new_2.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP No.
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\" style=\"width: 500px;\">
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
             <td bgcolor=\"#CCFFFF\" style=\"width: 500px; word-wrap: break-word;\">                
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
           <table border='0' width=\"100%\">
           <caption>$captn</caption>
            <tr>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Issue No.</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\" style=\"width: 200px\">Title (Max 500 Chars)</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">For</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Root Cause</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Missed Opportunity(s)</font></td>
               <td bgcolor=\"#CCCCCC\" align=\"center\"><font color=\"#330099\">Created</font></td>
            </tr>
            <!--<tr>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">By</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">On</font></td>
            </tr>-->
       ");

       for ($x=1;$x<=$num_records; ++$x) {
	        print("
                <tr>
		         <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
		          <input type=\"hidden\" name=\"new[$x]\" value=\"$x\">
		         </td>
	             <td bgcolor=\"#FFFF00\" align=\"left\" style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
            ");
            if (isset($zdesc)) {
                print("<textarea name=\"new_issue_desc[$x]\" rows=\"10\" cols=\"40\">$zdesc</textarea>");   
            } else {
                print("<textarea name=\"new_issue_desc[$x]\" rows=\"10\" cols=\"40\"></textarea>");   
            }
            print("    <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFF00\">
                        <select align=\"center\" name=\"new_issue_area_id[$x]\">  
            ");
            $w = 0;
            for ($w=1;$w<=$issue_area_cnt ; ++$w) {
                 //if ($issue_area_id[$w] == $uissue_area_id) {
                     print(" <option value=\"$issue_area_id[$w]\">$issue_area[$w]</option> ");
                     //print("
            	     //       <font color=\"#330099\"> 
                     //        $issue_area[$w]
                     //       </font> 
                     //       <input type=\"hidden\" name=\"new_issue_area_id[$x]\" value=\"$issue_area_id[$w]\">
                     //");
                 //}
            }
            print("     </select>
                         </td>
                          <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFF00\">
                            <select align=\"center\" name=\"new_issue_type_id[$x]\">
                            <!--<font color=\"#000000\">-->
            ");
            for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                 if ($issue_typ_ind[$v] == 1){
                     if ($issue_typ_id[$v] == 0){
                             print("
                                    <option selected value=\"$issue_typ_id[$v]\">$issue_typ[$v]</option> 
                                    <!--<input type=\"checkbox\" name=\"new_issue_type_id[$x][$v]\" value=\"$issue_typ_id[$v]\" >
                                    $issue_typ[$v]<br>-->    
                             ");                     
                     } else {
                             print("
                                    <option value=\"$issue_typ_id[$v]\">$issue_typ[$v]</option> 
                             ");
                     }
                 }
            }
            print("     <!--</font>-->
                       </td>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFF00\">
                        <font color=\"#000000\"> 
            ");
            for ($u=1;$u<=$issue_typ_cnt2 ; ++$u) {
                 if ($issue_typ_ind2[$u] == 1){
                     print("
                            <input type=\"checkbox\" name=\"new_issue_type_id2[$x][$u]\" value=\"$issue_typ_id2[$u]\" >
                            $issue_typ2[$u]<br>    
                     ");
                 }
            }                                   
            print("     </font>
                       </td>
            ");                           
            print("
	             </td>
	             <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                  <font color=\"#000000\">
                   BY<br><font color=\"#330099\">$usr</font><br><br>ON<br><font color=\"#330099\">$ydate</font><br><br>FROM<br><font color=\"#330099\">$uissue_area</font>
                  </font> 
	             </td>
	            </tr> 
            ");
	    }
	    // ---------->>>> displaying last issues entered for this PDP
        /////////////////////////////////////////////////////////////////////////////////////////////////   
        if ($submit == "Save" ){ 
           $query = "select a.issue_id,a.pdp_id,a.issue_desc,a.created_by,a.created_on,a.issue_area_id,
                            a.issue_type_id,b.issue_area  
                       from ".$name.".issues a,".$name.".issue_areas b 
                      where a.pdp_id = '$xid' 
                        and a.created_by = '$usr'
                        and a.issue_area_id_by = b.issue_area_id  
                   order by a.issue_id desc limit 1 "; 
           $mysql_data = mysql_query($query, $mysql_link) or die ("#12 Could not query: ".mysql_error());
           $rowcnt = mysql_num_rows($mysql_data);
           //print($rowcnt);
           $seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt = 0;
                 $seq = $seq + 1;
	             $xid2              = stripslashes($row[0]);
                 $xpdp_id           = stripslashes($row[1]);
	             $xissue_desc       = stripslashes(trim($row[2]));
                 $xcreated_by       = stripslashes($row[3]);
                 $xcreated_on       = stripslashes($row[4]);
                 $xissue_area_id    = stripslashes($row[5]);
                 $xissue_area_by    = stripslashes($row[7]);
                 $xd1               = date("d",$xcreated_on);
                 $xm1               = date("M",$xcreated_on);
                 $xy1               = date("Y",$xcreated_on);
                 $xcreate_dt        = $xd1."-".$xm1."-".$xy1;
                 // ---------->>>> Loading surrogate information for this issues
                 $query21 = "select issue_surrogate_id,issue_type_id 
                               from ".$name.".issue_surrogates 
                              where issue_surrogate_id = '$xid2' 
                                and surrogate_type = 0"; 
                 $mysql_data21 = mysql_query($query21, $mysql_link) or die ("#13 Could not query: ".mysql_error());
                 $rowcnt21 = mysql_num_rows($mysql_data21);
                 //print($query21."<br>"); 
                 //print($rowcnt21."<br>");
                 $issue_sur_cnt = 0;
                 $xissue_sur_id = array();
                 $xissue_typ_id = array();
                 while($row21 = mysql_fetch_row($mysql_data21)) {
                       $issue_sur_cnt                       = $issue_sur_cnt + 1;
                       $xissue_sur_id[$issue_sur_cnt]       = $row21[0];
                       $xissue_typ_id[$issue_sur_cnt]       = $row21[1];
                 }
                 print(" 
                 <tr>
                  <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"7\">
                   <font color=\"#0000FF\">
                    Last Issue Entered
                   </font>
                  </td>
                 </tr>
                 <tr>
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     $xid2
                    </font>
                    <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                   </td>
                   <td bgcolor=\"#CCFFFF\" align=\"left\" style=\"width: 200px; word-wrap: break-word; word-break:break-all;\">
                    <font color=\"#330099\">
                     <p style=\"width: 250px; word-wrap: break-word; word-break:break-all;\">
                      $xissue_desc
                     </p>
                    </font>
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                     <font color=\"#330099\"> 
                 ");
                 $w = 0;
                 for ($w=1;$w<=$issue_area_cnt ; ++$w) {
                      if ($issue_area_id[$w] == $xissue_area_id) {
                          print($issue_area[$w]);
                      }
                 }
                 print("  </font> 
                         </td>  
                         <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                          <font color=\"#330099\">
                 ");   
                 for ($sur=1;$sur<=$issue_sur_cnt; ++$sur){
                      for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                           if ($issue_typ_id[$v] == $xissue_typ_id[$sur]){
                               print("&nbsp&nbsp "."<a>&nbsp&nbsp</a>".$issue_typ[$v]."<br>");
                           }    
                      }
                 }
                 print("  </font>
                         </td>
                         <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                          <font color=\"#330099\">
                 ");        
                 for ($sur=1;$sur<=$issue_sur_cnt; ++$sur){
                      for ($u=1;$u<=$issue_typ_cnt2 ; ++$u) {
                           if ($issue_typ_id2[$u] == $xissue_typ_id[$sur]){
                               print("&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ2[$u]."<br>");
                           }    
                      }
                 }
                 print("  </font>
                         </td>
                 ");
                 print("
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     BY<br><font color=\"#330099\">$xcreated_by</font><br><br>ON<br><font color=\"#330099\">$xcreate_dt</font><br><br>FROM<br><font color=\"#330099\">$xissue_area_by</font>
                    </font>
                   </td>
                 ");  
           }
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////   
        print("
              </table>
              <table border='0'>
                <tr>
                 <td>
        "); 
        print("     
                   <input type=\"submit\" name=\"submit\" value=\"Save\">
                   <input type=\"hidden\" name=\"num_records\" value=\"$num_records\">                      
                   <input type=\"hidden\" name=\"pdp\" value=\"$pdp\">
                   <input type=\"hidden\" name=\"pdp_id\" value=\"$xid\">
                   <input type=\"hidden\" name=\"start\" value=\"1\">
                 </td>
                </tr>
               </table>
              </form>
        ");
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
   print("<form method=\"post\" action=\"./enter_issue_new_2.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\">
              <font color=\"#330099\">
               Enter PDP No.
              </font>
             </td>
             <td>
              <input type=\"text\" name=\"pdp\" size=\"9\" maxlength=\"9\">
             </td>
             <td>
              <input type=\"submit\" name=\"submit1\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
              <input type=\"hidden\" name=\"submit\" value=\"Add\">
              <input type=\"hidden\" name=\"num_records\" value=\"1\">
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
