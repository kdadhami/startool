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
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),UPPER(trim(b.short_desc))  
                     FROM ".$name.".users a, ".$name.".issue_areas b 
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);
              $ushort_desc     = stripslashes($row6[2]);       
              //print($yissue_area_id);
       }                               
}
//$trans = "loop";
// ==============================


// ======================================= INITIALIZATION START ====================================
// ------------------>>>>>> Root Cause
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.parent_issue_type_id 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'ROT'
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
//print($queryx);         
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt                   = 0;
$issue_typ_cnt                   = $issue_typ_cnt + 1;
$issue_typ_id[$issue_typ_cnt]    = 0;
$issue_typ[$issue_typ_cnt]       = "";
$issue_typ_ind[$issue_typ_cnt]   = 1;
$issue_typ_class[$issue_typ_cnt] = 0;
$issue_parent_id[$issue_typ_cnt] = 0;
$issue_grt[$issue_typ_cnt]       = 0; 
//print($issue_typ_cnt."-".$issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt                   = $issue_typ_cnt + 1;
      $issue_typ_id[$issue_typ_cnt]    = stripslashes(trim($rowx[0]));
      $issue_typ[$issue_typ_cnt]       = stripslashes(trim($rowx[1]));
      $issue_typ_ind[$issue_typ_cnt]   = stripslashes(trim($rowx[2]));
      $issue_typ_class[$issue_typ_cnt] = stripslashes(trim($rowx[3]));
      $issue_parent_id[$issue_typ_cnt] = stripslashes(trim($rowx[4]));
      $queryx2 = "select issue_type_id,issue_type,issue_type_ind,parent_issue_type_id 
                    from ".$name.".issue_types
                   where parent_issue_type_id = '$issue_typ_id[$issue_typ_cnt]' 
                order by issue_type asc "; //where issue_type_ind = 1";
      //print($queryx);            
      $mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#201 Could not query: ".mysql_error());
      $rowcntx2 = mysql_num_rows($mysql_datax2); 
      $issue_grt[$issue_typ_cnt]  = $rowcntx2;   
      if ($rowcntx2 > 0){
         $issue_grt[$issue_typ_cnt]  = $rowcntx2; 
         while($rowx2 = mysql_fetch_row($mysql_datax2)) {
                    $issue_typ_cnt                   = $issue_typ_cnt + 1;
                    $issue_typ_id[$issue_typ_cnt]    = stripslashes(trim($rowx2[0]));
                    $issue_typ[$issue_typ_cnt]       = stripslashes(trim($rowx2[1]));
                    $issue_typ_ind[$issue_typ_cnt]   = stripslashes(trim($rowx2[2]));
                    $issue_typ_class[$issue_typ_cnt] = "GRT";
                    $issue_parent_id[$issue_typ_cnt] = stripslashes(trim($rowx2[3]));
                    $issue_grt[$issue_typ_cnt]       = 999;
         }
      }
      
      //print($issue_typ_cnt."-".$issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
}


// ----------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------
// ------------------>>>>>> Root Cause for drop down
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.parent_issue_type_id 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id   = b.issue_class_id
              and b.issue_class_code = 'ROT'
              and a.issue_type_ind   = 1  
         order by a.issue_seq asc"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$issue_typ_cnt_r                     = 0;
$issue_typ_cnt_r                     = $issue_typ_cnt_r + 1;
$issue_typ_id_r[$issue_typ_cnt_r]    = 0;
$issue_typ_r[$issue_typ_cnt_r]       = "";
$issue_typ_ind_r[$issue_typ_cnt_r]   = 1;
$issue_typ_class_r[$issue_typ_cnt_r] = 0;
$issue_parent_id_r[$issue_typ_cnt_r] = 0;
//$issue_grt_r[$issue_typ_cnt_r]     = 0; 
while($rowx = mysql_fetch_row($mysql_datax)) {
      $issue_typ_cnt_r                     = $issue_typ_cnt_r + 1;
      $issue_typ_id_r[$issue_typ_cnt_r]    = stripslashes(trim($rowx[0]));
      $issue_typ_r[$issue_typ_cnt_r]       = stripslashes(trim($rowx[1]));
      $issue_typ_ind_r[$issue_typ_cnt_r]   = stripslashes(trim($rowx[2]));
      $issue_typ_class_r[$issue_typ_cnt_r] = stripslashes(trim($rowx[3]));
      $issue_parent_id_r[$issue_typ_cnt_r] = stripslashes(trim($rowx[4]));
      //print($issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
}
// ------------------>>>>>> Granular Root Cause for drop down
if (isset($rot_id)){
  $queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.parent_issue_type_id 
               from ".$name.".issue_types a, issue_class b
              where a.issue_class_id       = b.issue_class_id
                and b.issue_class_code     = 'GRT'
                and a.parent_issue_type_id = '$rot_id'
                and a.issue_type_ind       = 1  
           order by a.issue_seq asc"; 
  $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
  $rowcntx = mysql_num_rows($mysql_datax); 
  //print("Rows ".$rowcntx."<br>"."Root ID ".$rot_id." - "."Start ".$start." - PDP ".$pdp);    

  $issue_typ_cnt_g                     = 0;
  $issue_typ_cnt_g                     = $issue_typ_cnt_g + 1;
  $issue_typ_id_g[$issue_typ_cnt_g]    = 0;
  $issue_typ_g[$issue_typ_cnt_g]       = "";
  $issue_typ_ind_g[$issue_typ_cnt_g]   = 1;
  $issue_typ_class_g[$issue_typ_cnt_g] = 0;
  $issue_parent_id_g[$issue_typ_cnt_g] = 0;
  //$issue_grt_g[$issue_typ_cnt_g]     = 0; 
  while($rowx = mysql_fetch_row($mysql_datax)) {
        $issue_typ_cnt_g                     = $issue_typ_cnt_g + 1;
        $issue_typ_id_g[$issue_typ_cnt_g]    = stripslashes(trim($rowx[0]));
        $issue_typ_g[$issue_typ_cnt_g]       = stripslashes(trim($rowx[1]));
        $issue_typ_ind_g[$issue_typ_cnt_g]   = stripslashes(trim($rowx[2]));
        $issue_typ_class_g[$issue_typ_cnt_g] = stripslashes(trim($rowx[3]));
        $issue_parent_id_g[$issue_typ_cnt_g] = stripslashes(trim($rowx[4]));
        //print($issue_typ_id[$issue_typ_cnt]." - ".$issue_typ[$issue_typ_cnt]."-".$issue_typ_class[$issue_typ_cnt]."<br>");
  }
}

// ----------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------


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

$queryw = "select issue_area_id,issue_area from ".$name.".issue_areas where issue_area_ind = 1"; 
$mysql_dataw = mysql_query($queryw, $mysql_link) or die ("Could not query: ".mysql_error());
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
// ======================================= INITIALIZATION END ====================================

// ================================ INSERT, UPDATE, DELETE START =================================
// Insert a record
if ($submit == "Save") {
    //print("ROT_ID ".$rot_id."<br>");
	while (list($key) = each($new)) {
	   if (strlen($new_issue_desc[$key]) >= 1){
	      if (
              ($new_issue_type_id[$key] <> 0)                         // checks 
              or
              (
               ($new_issue_type_id[$key] == 0) && ($rot_id <> 0)      // checks if root cause was selected (mandatory) but no granular root cause was selected (optional)
              )
             ){
              if (($new_issue_type_id[$key] == 0) && ($rot_id <> 0)){
                   $new_issue_type_id[$key] = $rot_id;
                   //print("I am here"."<br>");
                   //print($new_issue_type_id[$key]."<br>");
              }
	          //print($new_issue_type_id[$key]."<br>");
	          //$new_issue_desc[$key]   = addslashes(trim(substr($new_issue_desc[$key],0,500)));
	          $new_issue_desc[$key]     = addslashes($new_issue_desc[$key]);
	          $new_created_on[$key]     = $yentry_dt; //mktime(0,0,0,$ym,$yd,$yy);
	          $new_issue_area_id[$key]  = addslashes($new_issue_area_id[$key]);
	          $new_test_iteration[$key] = addslashes($new_test_iteration[$key]);
              $query                    = "INSERT into ".$name.".issues(pdp_id,issue_desc,created_by,created_on,
                                                                        issue_area_id,issue_area_id_by,test_iteration)
                                           VALUES('$pdp_id','$new_issue_desc[$key]','$usr','$new_created_on[$key]',
                                                  '$new_issue_area_id[$key]','$uissue_area_id','$new_test_iteration[$key]')";
              //print("$query");                
              $mysql_data               = mysql_query($query, $mysql_link) or die ("#1 Could not query: ".mysql_error());
              $xissue_surrogate_id      = mysql_insert_id();
              $yissue_type_id           = addslashes($new_issue_type_id[$key]);  
              //print("<br>".$yissue_type_id."<br>");            
              $query11                  = "INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,surrogate_type)
                                           VALUES('$xissue_surrogate_id','$yissue_type_id','0')";
              //print("$query11");                
              $mysql_data11      = mysql_query($query11, $mysql_link) or die ("#2 Could not query: ".mysql_error());
              if (isset($new_issue_type_id2[$key])){
                 while (list($key2)       = each($new_issue_type_id2[$key])) {
                        //print($new_issue_type_id2[$key][$key2]."<br>");
                        $yissue_type_id2  = addslashes($new_issue_type_id2[$key][$key2]);
                        //print($yissue_type_id2."<br>");              
                        $query12          = "INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,surrogate_type)
                                             VALUES('$xissue_surrogate_id','$yissue_type_id2','0')";
                        //print($query12);  
                        $mysql_data12     = mysql_query($query12, $mysql_link) or die ("#3 Could not query: ".mysql_error());
                 }
              } 
              $queryx                   = "UPDATE ".$name.".pdp
		                                      SET etl_check  = 1
		                                    WHERE pdp_id = '$pdp_id'";
              //print("$query");                
              $mysql_datax               = mysql_query($queryx, $mysql_link) or die ("#1 Could not query: ".mysql_error());
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
    unset($rot_id);       
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
         <script type=\"text/javascript\">
          function reload(form){
            var val=form.rot_id.options[form.rot_id.options.selectedIndex].value;
            var pdpval=form.zpdp.value; 
            var numrval=form.znumr.value; 
            self.location='enter_issue_new.php?rot_id=' + val + '&start=1&pdp=' + pdpval + '&num_records=' + numrval ;
          }
         </script>
");  

$captn = "Raise New Issue";
// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------

    $itdesc[1] = "TESTING CYCLE PRE-PROD";
    $itdesc[2] = "TESTING CYCLE PRODUCTION";
    if ($ushort_desc == "MO" or  $ushort_desc == "UAT") {
            $itcnt  = 1;
    } else {
            $itcnt  = 2;
    } 

   //print($pdp." - ".$start." - ".$num_records);
   // ---------->>>> looking up PDP
   $queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch 
                from ".$name.".pdp a 
               where a.pdp_desc = '$pdp' "; 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);
   //print($queryx);
       
   if ($rowcntx == 1)   {
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
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     while($row100 = mysql_fetch_row($mysql_data100)) {
                           $xpdp_period = stripslashes(trim($row100[0]));
                     }
             }
                                        
       }
       // ---------->>>> display PDP Info
       print("
         <form method=\"post\" action=\"./enter_issue_new.php\">
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
           <table border='0' width=\"100%\" >
           <caption>$captn</caption>
            <tr>
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">Issue No.</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">Select Root Cause</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width=40% height:25px;\"><font color=\"#330099\">Enter Issue Description</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">Created</font></td>
            </tr>
       ");

       for ($x=1;$x<=$num_records; ++$x) {
	        print("
                <tr>
		         <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" rowspan=\"2\" style=\"height:250px;\">
		          <input type=\"hidden\" name=\"new[$x]\" value=\"$x\">
		         </td>
                 <td>  
                    <table border=\"0\" border-color=\"#FFFF00\" width=\"100%\" cellpadding=\"0\">
                     <tr bgcolor=\"#FFFF00\"> 
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFF00\" style=\"height:50px;\">
                       <select align=\"center\" name=\"rot_id\" onchange=\"reload(this.form)\">
            ");
            //for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
            //     if ($issue_typ_ind[$v] == 1){
            //         if ($issue_typ_id[$v] == 0){
            //             $bcolr  = "#CCCCCC";
            //             $fcolr  = "#000000"; 
            //             print("
            //                     <option selected value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //             ");
            //         } else {
            //             if ($issue_grt[$v] == 0){
            //                 $bcolr  = "blue";
            //                 $fcolr  = "#FFFFFF"; 
            //                 //print("
            //                 //    <option value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //                 //");
            //             } else {
            //                 if (($issue_grt[$v] > 0) && ($issue_grt[$v] <> 999)){
            //                      $bcolr  = "blue";
            //                      $fcolr  = "#FFFFFF"; 
            //                      // disable if root cause with granular root caused need not be selected i.e. disabled=\"disabled\" 
            //                      //print("
            //                      //       <option value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //                      //");
            //                 } else {
            //                      $bcolr  = "#FFFFFF";
            //                      $fcolr  = "blue"; 
            //                      //print("
            //                      //       <option value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //                      //");
            //                 }
            //                 //print("
            //                 //       <option value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //                //");
            //                 
            //             }                        
            //             print("
            //                     <option value=\"$issue_typ_id[$v]\" style=\"color: $fcolr; font-weight: normal; background-color: $bcolr;\">$issue_typ[$v]</option> 
            //             ");
            //         }
            //     }
            //}
            for ($v=1;$v<=$issue_typ_cnt_r ; ++$v) {
                 if (isset($rot_id)){
                   if ($issue_typ_id_r[$v] == $rot_id){
                      print("
                        <option selected value=\"$issue_typ_id_r[$v]\" style=\"color: blue; font-weight: normal; background-color:#FFFFFF;\">$issue_typ_r[$v]</option> 
                      ");
                   } else {
                     print("
                        <option value=\"$issue_typ_id_r[$v]\" style=\"color: blue; font-weight: normal; background-color: #FFFFFF;\">$issue_typ_r[$v]</option> 
                     ");
                   }
                 } else {
                   print("
                        <option value=\"$issue_typ_id_r[$v]\" style=\"color: blue; font-weight: normal; background-color: #FFFFFF;\">$issue_typ_r[$v]</option> 
                   ");
                 }
            }
            print("          </select>
                             <input type=\"hidden\" name=\"zpdp\" value=\"$xpdpdesc\">
                             <input type=\"hidden\" name=\"zpdpid\" value=\"$xid\">
                             <input type=\"hidden\" name=\"znumr\" value=\"1\">
                            </td>
                           </tr>    
            ");
            //=============================================================================================
            if (isset($rot_id)){
             if ($issue_typ_cnt_g == 1){
                 //--------------- when root cause does not have any granular root cause
                 print("
                     <tr bgcolor=\"#FFFF00\">
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"height:25px;\"> 
                       <font color=\"#330099\">Granular Root Cause</font>
                      </td>
                     </tr>
                 ");  
                 print(" <tr bgcolor=\"#FFFF00\">
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" style=\"height:50px;\"> 
                       <font color=\"#330099\">Not Applicable</font>
                      </td>
                     </tr>
                     <input type=\"hidden\" name=\"new_issue_type_id[$x]\" value=\"$rot_id\">
                 ");  
             } else {
                //--------------- when root cause has granular root cause
                print(" 
                     <tr bgcolor=\"#FFFF00\">
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"height:25px;\"> 
                       <font color=\"#330099\">Select Granular Root Cause</font>
                      </td>
                     </tr>
                ");  
                print("
                       <tr bgcolor=\"#FFFF00\"> 
                        <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFF00\" style=\"height:50px;\">
                         <select align=\"center\" name=\"new_issue_type_id[$x]\">
                ");
                for ($v=1;$v<=$issue_typ_cnt_g ; ++$v) {
                 print("
                        <option value=\"$issue_typ_id_g[$v]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">$issue_typ_g[$v]</option> 
                 ");
                }
                print("      </select>
                            </td>
                           </tr>    
                ");
             }  
            } else {
              //--------------- when no root cause has been selected
              print(" <tr bgcolor=\"#FFFF00\">
                       <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"height:25px;\"> 
                        <font color=\"#330099\">Granular Root Cause</font>
                       </td>
                      </tr>
              ");  
              print(" <tr bgcolor=\"#FFFF00\">
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" style=\"height:50px;\"> 
                       <font color=\"#330099\">&nbsp</font>
                      </td>
                     </tr>
                     <input type=\"hidden\" name=\"new_issue_type_id[$x]\" value=\"0\">
              ");  
            }
            //=============================================================================================
            print("  <tr bgcolor=\"#FFFF00\">
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"height:25px;\"> 
                       <input type=\"hidden\" name=\"new_issue_area_id[$x]\" value=\"$uissue_area_id\">
                       <font color=\"#330099\">Select Missed Opportunity(s)</font>
                      </td>
                     </tr>
            ");  
            print("  <tr bgcolor=\"#FFFF00\">
                      <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFF00\" style=\"height:50px;\">
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
            print("  </font>
                    </td>
                  </tr>
                  <tr bgcolor=\"#FFFF00\">
                    <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"height:25px;\"> 
                     <font color=\"#330099\">Select Test Iteration</font>
                    </td>
                  </tr>
            ");  
            print("  <tr bgcolor=\"#FFFF00\">
                      <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFF00\" style=\"height:50px;\">
                       <select align=\"center\" name=\"new_test_iteration[$x]\">
            ");
            for ($ti=1;$ti<=$itcnt ; ++$ti) {
                 print("
                        <option value=\"$ti\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">$itdesc[$ti]</option> 
                 ");
            }                                   
            print("  </select>
                    </td>
                  </tr>
                 </table>
                </td>  
            ");
            if (isset($rot_id) or ($rot_id <> 0)){
                 print("
	                  <td bgcolor=\"#FFFF00\" align=\"left\" style=\"width:600px; word-wrap: break-word; word-break:break-all;\">
	                   <div style=\"width: 600px; word-wrap: break-word; word-break:break-all;\">
                 ");
                 if (isset($zdesc)) {
                     print("<textarea name=\"new_issue_desc[$x]\" rows=\"10\" style=\"width: 575px;\">$zdesc</textarea>");   
                 } else {
                     print("<textarea name=\"new_issue_desc[$x]\" rows=\"10\" style=\"width: 575px;\"></textarea>");   
                 }
                 //print("</td>");
                 //print("    <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFF00\">
                 //            <select align=\"center\" name=\"new_issue_area_id[$x]\">  
                 //");
                //$w = 0;
                 //for ($w=1;$w<=$issue_area_cnt ; ++$w) {
                 //     if ($issue_area_id[$w] == $uissue_area_id) {
                 //         print(" <option selected value=\"$issue_area_id[$w]\">$issue_area[$w]</option> ");
                 //         //print("
                 // 	     //       <font color=\"#330099\"> 
                 //         //        $issue_area[$w]
                 //         //       </font> 
                 //         //       <input type=\"hidden\" name=\"new_issue_area_id[$x]\" value=\"$issue_area_id[$w]\">
                 //         //");
                 //     } else {
                 //       print(" <option value=\"$issue_area_id[$w]\">$issue_area[$w]</option> ");
                 //     }
                 //}
                 //print("     </select>
                 //             </td>
                 //");
                 print("
                         </div>
                        </td>
                 ");
            } else {
	             print("
                      <td bgcolor=\"#FFFF00\" align=\"left\" style=\"width:600px; word-wrap: break-word; word-break:break-all;\">
                      </td> 
                 ");
            }
            print("        
 	               <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\" rowspan=\"2\">
                    <font color=\"#000000\">
                     <strong>BY</strong><br><font color=\"blue\">$usr</font><br><br><strong>ON</strong><br><font color=\"blue\">$ydate</font><br><br><strong>DEPARTMENT</strong><br><font color=\"blue\">$uissue_area</font>
                    </font> 
	               </td>
	              </tr> 
            ");
            //print("     <!--</font>-->
            //           </td>
            //          </tr> 
            //");           
	    }
	    // ---------->>>> displaying last issues entered for this PDP
        /////////////////////////////////////////////////////////////////////////////////////////////////   
        if ($submit == "Save" ){ 
           $query = "select a.issue_id,a.pdp_id,a.issue_desc,a.created_by,a.created_on,a.issue_area_id,
                            a.issue_type_id,b.issue_area,a.test_iteration   
                       from ".$name.".issues a,".$name.".issue_areas b 
                      where a.pdp_id = '$xid' 
                        and a.created_by = '$usr' 
                        and a.issue_area_id = b.issue_area_id
                   order by a.issue_id desc limit 1"; 
           $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           $rowcnt = mysql_num_rows($mysql_data);
           //print($rowcnt);
           $seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt = 0;
                 $seq = $seq + 1;
	             $xid2              = stripslashes($row[0]);
                 $xpdp_id           = stripslashes($row[1]);
	             //$xissue_desc       = stripslashes(trim($row[2]));
	             $xissue_desc       = nl2br(stripslashes($row[2]));
                 $xcreated_by       = stripslashes($row[3]);
                 $xcreated_on       = stripslashes($row[4]);
                 $xissue_area_id    = stripslashes($row[5]);
                 //$xissue_area_by  = stripslashes($row[7]);
                 $xissue_area       = stripslashes($row[7]);
                 $xtest_iteration   = stripslashes($row[8]);
                 $xd1               = date("d",$xcreated_on);
                 $xm1               = date("M",$xcreated_on);
                 $xy1               = date("Y",$xcreated_on);
                 $xcreate_dt        = $xd1."-".$xm1."-".$xy1;
                 // ---------->>>> Loading surrogate information for this issues
                 $query21 = "select issue_surrogate_id,issue_type_id 
                               from ".$name.".issue_surrogates 
                              where issue_surrogate_id = '$xid2' 
                                and surrogate_type = 0"; 
                 $mysql_data21 = mysql_query($query21, $mysql_link) or die ("Could not query: ".mysql_error());
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
                   <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\">
                    <strong>
                     <font color=\"blue\">
                      Last Issue Entered
                     </font>
                    </strong> 
                   </td>
                  </tr>
                  <tr>
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     $xid2
                    </font>
                    <input type=\"hidden\" name=\"xissue_id[$xid2]\" value=\"$xid2\">
                   </td>
                   <td>                   
                    <table border=\"0\" border-color=\"#CCCCCC\" width=\"100%\" cellpadding=\"0\">
                     <tr>
                 ");
                 //print("
                 //  <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
                 //    <font color=\"#330099\"> 
                 //");
                 //$w = 0;
                 //for ($w=1;$w<=$issue_area_cnt ; ++$w) {
                 //     if ($issue_area_id[$w] == $xissue_area_id) {
                 //         print($issue_area[$w]);
                 //     }
                 //}
                 //print("  </font> 
                 //        </td>  
                 //");
                 print(" <td align=\"left\" valign=\"middle\" bgcolor=\"#CCCCCC\" style=\"width:100%; height:75px;\">
                 ");
                 //$grtchk = 0;   
                 for ($sur=1;$sur<=$issue_sur_cnt; ++$sur){
                      for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                           if ($issue_typ_id[$v] == $xissue_typ_id[$sur]){
                               if ($issue_parent_id[$v] <> 0){
                                   for ($v2=1;$v2<=$issue_typ_cnt ; ++$v2) {
                                        if ($issue_typ_id[$v2] == $issue_parent_id[$v]){
                                            $parent_type = $issue_typ[$v2];
                                        } 
                                   }
                                   //$grtchk = $grtchk + 1;
                                   print("<strong><font color=\"#000000\">"."ROOT CAUSE<br></font></strong>".
                                         "<font color=\"blue\">".$parent_type."</font><br><br>".
                                         "<strong><font color=\"#000000\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."</font>"
                                        );
                               } else {
                                   print("<strong><font color=\"#000000\">ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."<br><br>"
                                   );
                                   if ($issue_grt[$v] <> 0){
                                       print("<strong><font color=\"#000000\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT SELECTED</font>"
                                       );
                                   
                                   } else {
                                       print("<strong><font color=\"#000000\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT APPLICABLE</font>"
                                       );
                                   }      
                               }
                           }    
                      }
                 }
                 print("  </td>
                         </tr>
                         <tr bgcolor=\"#CCCCCC\">
                          <td align=\"left\" valign=\"middle\" bgcolor=\"#CCCCCC\" style=\"width:100%; height:100px;\">
                           <font color=\"#000000\">
                            <strong>MISSED OPPORTUNITIES</strong>
                           </font> 
                           <br>
                 ");
                 $mochk = 0;        
                 for ($sur=1;$sur<=$issue_sur_cnt; ++$sur){
                      for ($u=1;$u<=$issue_typ_cnt2 ; ++$u) {
                           if ($issue_typ_id2[$u] == $xissue_typ_id[$sur]){
                               $mochk = $mochk + 1;
                               print("<font color=\"blue\">&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ2[$u]."</font><br><br>");
                           }    
                      }
                 }
                 if ($mochk == 0){
                     print("<font color=\"blue\">NONE</a>".$issue_typ2[$u]."</font><br><br>");
                 }
                 print("   <font color=\"#000000\">
                            <strong>TEST ITERATION</strong>
                           </font> 
                           <br>
                 ");
                 for ($ti=1;$ti<=$itcnt ; ++$ti) {
                      if ($ti == $xtest_iteration) {
                          print("<font color=\"blue\">$itdesc[$ti]</font><br>");
                      }
                 }                                   
                 print("
                          </td>
                         </tr>
                        </table> 
                       </td> 
                 ");
                 print("
                   <td bgcolor=\"#CCCCCC\" align=\"left\" valign=\"top\" style=\"width:600px; height:150px; word-wrap: break-word; word-break:break-all; scroll-x: auto;\">
                    <font color=\"#000000\">
   	                 <div style=\"word-wrap: break-word; word-break:break-all; width:600px; height:150px; overflow-y: auto; background-color: #CCCCCC;\">
                      <p style=\"width:575px; word-wrap: break-word; word-break:break-all;\">
                       $xissue_desc
                      </p>
                     </div> 
                    </font>
                   </td>
                   <td bgcolor=\"#CCCCCC\" align=\"center\">
                    <font color=\"#000000\">
                     <strong>BY</strong><br><font color=\"blue\">$xcreated_by</font><br><br><strong>ON</strong><br><font color=\"blue\">$xcreate_dt</font><br><br><strong>DEPARTMENT</strong><br><font color=\"blue\">$xissue_area</font>
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
   print("<form method=\"post\" action=\"./enter_issue_new.php\">
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
