<?php

//--------------------------------
// Author: Kashif Adhami
// Date:   November, 2010
// Note:   surrogate_type = 0 when creating an issue i.e in issues table,
//         will be set to 1 when creating updates i.e. in issue_history table
//--------------------------------

// Connection
require_once("./inc/connect.php");

//$usr = strtoupper(trim(getenv("username")));
$usr = $v_usr;
$num_records = 1;

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
//print($usr." - ".$uissue_area_id." - ".$uissue_area."<br>");


//print($usr);
//print($pdp);

// ------------------>>>>>> Root Cause
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.parent_issue_type_id 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'ROT'
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
//print($queryx);         
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#200 Could not query: ".mysql_error());
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

// ------------------>>>>>> Contributing Factor
$queryx2 = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id = b.issue_class_id
              and b.issue_class_code = 'CNT'  
         order by a.issue_class_id asc,a.issue_type_ind desc,a.issue_seq asc"; //where issue_type_ind = 1"; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#203 Could not query: ".mysql_error());
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


// ----------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------
// ------------------>>>>>> Root Cause for drop down
$queryx = "select a.issue_type_id,a.issue_type,a.issue_type_ind,b.issue_class_code,a.parent_issue_type_id 
             from ".$name.".issue_types a, issue_class b
            where a.issue_class_id   = b.issue_class_id
              and b.issue_class_code = 'ROT'
              and a.issue_type_ind   = 1  
         order by a.issue_seq asc"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#204 Could not query: ".mysql_error());
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
  $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#205 Could not query: ".mysql_error());
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




$queryw = "select issue_area_id,issue_area,issue_area_ind from ".$name.".issue_areas"; // where issue_area_ind = 1
$mysql_dataw = mysql_query($queryw, $mysql_link) or die ("#206 Could not query: ".mysql_error());
$rowcntw = mysql_num_rows($mysql_dataw);    

$issue_area_cnt = 0;
while($roww = mysql_fetch_row($mysql_dataw)) {
      $issue_area_cnt                = $issue_area_cnt + 1;
      $issue_area_id[$issue_area_cnt] = stripslashes(trim($roww[0]));
      $issue_area[$issue_area_cnt]    = stripslashes(trim($roww[1]));
      $issue_area_ind[$issue_area_cnt] = stripslashes(trim($roww[2]));       
}

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period 
             from ".$name.".pdp_periods 
            where pdp_period_ind = 1 
         order by pdp_period asc"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#207 Could not query: ".mysql_error());
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
$yd  = date("d");
$ym  = date("m");
$yy  = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

    $queryx = "select issue_id,pdp_id,issue_desc from ".$name.".issues where issue_id = $v_issue_id"; 
    //print($queryx);
    $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#208 Could not query: ".mysql_error());
    $rowcntx = mysql_num_rows($mysql_datax);    
    //print($rowcntx); 

    while($rowx = mysql_fetch_row($mysql_datax)) {
          $xpdp_id = stripslashes(trim($rowx[1]));
          $xissue_desc = stripslashes(trim($rowx[2]));
    }

          $queryp = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch 
                       from ".$name.".pdp a 
                      where a.pdp_desc = '$pdp' "; 
          $mysql_datap = mysql_query($queryp, $mysql_link) or die ("#209 Could not query: ".mysql_error());
          $rowcntp = mysql_num_rows($mysql_datap);           
          //print($queryp);
          //print($rowcntp); 

          while($rowp = mysql_fetch_row($mysql_datap)) {
                $xid          = stripslashes($rowp[0]);
                $xpdpdesc     = stripslashes(trim($rowp[1]));
                $xdesc        = stripslashes(trim($rowp[2]));
                $xpdp_period  = stripslashes(trim($rowp[3]));
                $xpdp_launch    = stripslashes($rowp[4]);
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
                     $query100 = "select b.pdp_period 
                                    from ".$name.".pdp a, pdp_periods b 
                                   where a.pdp_desc = '$pdp' 
                                     and a.pdp_period_id = b.pdp_period_id";
                     //print($query100);
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#210 Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     while($row100 = mysql_fetch_row($mysql_data100)) {
                           $xpdp_period = stripslashes(trim($row100[0]));
                     }
             }

          }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insert a record
if (($submit == "Save") or ($submit == "Add")) {
	while (list($key) = each($new)) {
	   if (strlen($new_issue_note[$key]) >= 1){
          //if ($new_issue_type_id[$key] <> 0){
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
	        $new_issue_id[$key]          = addslashes($new_issue_id[$key]);
	        $new_issue_assignee[$key]    = strtoupper(trim($usr));
	        $new_issue_note_dt[$key]     = mktime(0,0,0,$new_xm[$key],$new_xd[$key],$new_xy[$key]);
	        $new_issue_status_id[$key]   = addslashes($new_issue_status_id[$key]);
	        $new_issue_note[$key]        = addslashes($new_issue_note[$key]);
	        $new_issue_area_id[$key]     = addslashes($new_issue_area_id[$key]);	        

            $query ="INSERT into ".$name.".issue_history(issue_id,issue_assignee,issue_note_dt,issue_note,
                                                         issue_area_id,issue_area_id_by)
                     VALUES('$new_issue_id[$key]','$new_issue_assignee[$key]','$new_issue_note_dt[$key]',
                            '$new_issue_note[$key]','$new_issue_area_id[$key]','$uissue_area_id')";
            //print($query);                       
            $mysql_data = mysql_query($query, $mysql_link) or die ("#1 Could not query: ".mysql_error());
            $xissue_surrogate_id = mysql_insert_id();
                   $yissue_type_id  = addslashes($new_issue_type_id[$key]);              
                   $query11 ="INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,surrogate_type)
                              VALUES('$xissue_surrogate_id','$yissue_type_id','1')";
                   //print("$query11");                
                   $mysql_data11 = mysql_query($query11, $mysql_link) or die ("#2 Could not query: ".mysql_error());
            if (isset($new_issue_type_id2[$key])){	
                while (list($key2) = each($new_issue_type_id2[$key])) {
                       $yissue_type_id  = addslashes($new_issue_type_id2[$key][$key2]);              
                       $query12 ="INSERT into ".$name.".issue_surrogates(issue_surrogate_id,issue_type_id,
                                                                         surrogate_type)
                                  VALUES('$xissue_surrogate_id','$yissue_type_id','1')";
                       //print("$query11");                
                       $mysql_data12 = mysql_query($query12, $mysql_link) or die ("#3 Could not query: ".mysql_error());
                }
            }
         } else {
             echo "<script type=\"text/javascript\">window.alert(\"No Root Cause selected, Click OK Please\")</script>";
             $start  = 1;
             $zdesc  = $new_issue_note[$key];
             $submit = "notinsert"; 
         }
       } else {
         echo "<script type=\"text/javascript\">window.alert(\"Description missing or too short, Click OK Please\")</script>";
         $start = 1;
         $zdesc = $new_issue_note[$key];
         $submit = "notinsert";
       }
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



     // Select values from last issue_history
     $query101 = "select issue_history_id,issue_id,issue_note,issue_area_id 
                    from ".$name.".issue_history 
                   where issue_id = $v_issue_id 
                order by issue_history_id desc limit 1";
     $mysql_data101 = mysql_query($query101, $mysql_link) or die ("#301 Could not query: ".mysql_error());
     $rowcnt101 = mysql_num_rows($mysql_data101);

     if ($rowcnt101 <> 0){
         while($row101 = mysql_fetch_row($mysql_data101)) {
               $zid            = stripslashes($row101[0]);
               $zid2           = stripslashes($row101[1]);
               $zissue_note    = stripslashes(trim($row101[2]));            // -----> last record
               $zissue_area_id = stripslashes(trim($row101[3]));            // -----> last record
               $query102 = "select issue_surrogate_id,issue_type_id 
                              from ".$name.".issue_surrogates 
                             where issue_surrogate_id = '$zid' 
                               and surrogate_type = 1"; 
               $mysql_data102  = mysql_query($query102, $mysql_link) or die ("#302 Could not query: ".mysql_error());
               $rowcnt102      = mysql_num_rows($mysql_data102);
               $zissue_sur_cnt = 0;
               $zissue_sur_id  = array();
               $zissue_typ_id  = array();
               while($row102 = mysql_fetch_row($mysql_data102)) {
                     $zissue_sur_cnt                       = $zissue_sur_cnt + 1;
                     $zissue_sur_id[$zissue_sur_cnt]       = $row102[0];
                     $zissue_typ_id[$zissue_sur_cnt]       = $row102[1];
                     //print($zissue_typ_id[$zissue_sur_cnt]."<br>");
               }
               //print($zissue_sur_cnt);
         }
     } else {
             // Select values from issue
             $query103 = "select issue_id,issue_desc,issue_area_id 
                            from ".$name.".issues 
                           where issue_id = $v_issue_id ";
             $mysql_data103 = mysql_query($query103, $mysql_link) or die ("#303 Could not query: ".mysql_error());
             $rowcnt103 = mysql_num_rows($mysql_data103);

             $seq = $rowcnt + 1;
             while($row103 = mysql_fetch_row($mysql_data103)) {
                   $zid            = stripslashes($row103[0]);
                   //$zid2           = stripslashes($row103[1]);
                   $zissue_note    = stripslashes(trim($row103[1]));   // -----> last record
                   $zissue_area_id = stripslashes(trim($row103[2]));   // -----> last record
                   $query104 = "select issue_surrogate_id,issue_type_id 
                                  from ".$name.".issue_surrogates 
                                 where issue_surrogate_id = '$zid' 
                                   and surrogate_type = 0"; 
                   $mysql_data104  = mysql_query($query104, $mysql_link) or die ("#304 Could not query: ".mysql_error());
                   $rowcnt104      = mysql_num_rows($mysql_data104);
                   $zissue_sur_cnt = 0;
                   $zissue_sur_id  = array();
                   $zissue_typ_id  = array();
                   while($row104 = mysql_fetch_row($mysql_data104)) {
                         $zissue_sur_cnt                       = $zissue_sur_cnt + 1;
                         $zissue_sur_id[$zissue_sur_cnt]       = $row104[0];
                         $zissue_typ_id[$zissue_sur_cnt]       = $row104[1];
                         //print($zissue_typ_id[$zissue_sur_cnt]."<br>");
                   }
                   //print($zissue_sur_cnt);
             }      
     }

$captn = "Issue Details";
//print("$captn");

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
                    width: 100%; height: 100%; background: #FFFFF0;
                    /*border: 1px solid; border-color:#BDBDBD;*/
                  }
           /*#contentb
                  { top:0%;
                    width: 100%; height: 50%; background: red; overflow-y: scroll; overflow-x: hidden;
                  }
           #contentc
                  { top:0%;
                    width: 100%; height: 5%; background: green;
                    /*border: 1px solid; border-color:#BDBDBD;*/
                  }*/
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

         <script type=\"text/javascript\">
          function reload(form){
            var val=form.rot_id.options[form.rot_id.options.selectedIndex].value;
            var pdpval=form.zpdp.value; 
            var numrval=form.znumr.value;
            var w_issue_id=form.z_issue_id.value;
            var w_issue_hist_id=form.z_issue_hist_id.value;
            self.location='enter_issue_updates_3y.php?rot_id=' + val + '&start=1&pdp=' + pdpval + '&num_records=' + numrval + '&v_issue_id=' + w_issue_id + '&v_issue_hist_id' + w_issue_hist_id ;
          }
         </script>

        </head>
        <body>
         <div id=\"content\" >
          <!--<form id=\"thisfrm\" method=\"post\" action=\"./display_issue_details2.php?v_issue_id=$v_issue_id\">-->
           <table border='0'>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               PDP No.
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">
	          <font color=\"#330099\" style=\"width: 500px;\"> 
               $pdp
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
               $pdptype
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
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               Issue No.
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">
	          <font color=\"#330099\"> 
               $v_issue_id
              </font> 
             </td>
            </tr>
           </table>
           <br />
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">No.</font></td>
             <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">Select Root Cause</font></td>
             <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width=40% height:25px;\"><font color=\"#330099\">Notes</font></td>
             <td bgcolor=\"#99CCFF\" align=\"center\" style=\"height:25px;\"><font color=\"#330099\">Origination</font></td>
            </tr>
            <tr>
     ");

     // Select all history for given issue
     $query = "select a.issue_history_id,a.issue_id,a.issue_assignee,a.issue_note_dt,a.issue_note,a.issue_area_id,b.issue_area 
                 from ".$name.".issue_history a, ".$name.".issue_areas b 
                where a.issue_id = $v_issue_id 
                  and a.issue_area_id = b.issue_area_id 
             order by a.issue_history_id desc";
                //and a.issue_area_id_by = b.issue_area_id            //keeping this issue_area_id in query because initially UAT raised issues on behalf of other teams.
                //and issue_assignee = '$v_usr'
     //print $query;
     $mysql_data = mysql_query($query, $mysql_link) or die ("#401 Could not query: ".mysql_error());
     $rowcnt = mysql_num_rows($mysql_data);
     
     // Display blank entry for a new record to be inserted
	 $new_xd  = date("d");
     $new_xm  = date("M");
     $new_xy  = date("Y");
     $new_dt  = $new_xd."-".$new_xm."-".$new_xy;
     $new_xm  = date("m");

     if ($rowcnt == 0) {
     } else {
         print("
                <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" colspan=\"4\"><font color=\"blue\"><strong>$rowcnt EXISTING UPDATES</strong></font></td>
         ");      
     }
     
     $seq               = $rowcnt + 1;
     while($row = mysql_fetch_row($mysql_data)) {
      $delcnt            = $delcnt + 1;
      $seq               = $seq - 1;
      $xid               = stripslashes($row[0]);
      $xid2              = stripslashes($row[1]);
      $xissue_assignee   = stripslashes(strtoupper(trim($row[2])));
      $xissue_note_dt    = stripslashes($row[3]);
      $xd                = date("d",$xissue_note_dt);
      $xm                = date("M",$xissue_note_dt);
      $xy                = date("Y",$xissue_note_dt);
      $xdt               = $xd."-".$xm."-".$xy;
      $xissue_note       = stripslashes(trim($row[4]));
      $xissue_area_id    = stripslashes($row[5]);
      $xissue_area_by    = stripslashes($row[6]);  
      
      $query21 = "select issue_surrogate_id,issue_type_id 
                    from ".$name.".issue_surrogates 
                   where issue_surrogate_id = '$xid' 
                     and surrogate_type = 1"; 
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
	    print("   <tr valign=\"top\">
    	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
    	             <font color=\"blue\"> 
                        $seq
                     </font> 
                     <input type=\"hidden\" name=\"xissue_id\" value=\"$xid2\">
    	            </td>
    	");
        print("            
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
        ");
        if ($seq == $rowcnt){
            $bcolr = "#CCFFCC";
        } else {
            $bcolr = "#E8E8E8";
        }
        print("            
                     <table border=\"0\" border-color=\"$bcolr\" bgcolor=\"$bcolr\" width=\"100%\" cellpadding=\"0\">
                      <tr>
        ");              
        print(" <td align=\"left\" valign=\"middle\" bgcolor=\"$bcolr\" style=\"width:100%; height:75px;\">");
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
                                   print("<strong><font color=\"#330099\">"."ROOT CAUSE<br></font></strong>".
                                         "<font color=\"blue\">".$parent_type."</font><br><br>".
                                         "<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."</font>"
                                        );
                               } else {
                                   print("<strong><font color=\"#330099\">ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."<br><br>"
                                   );
                                   if ($issue_grt[$v] <> 0){
                                       print("<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT SELECTED</font>"
                                       );
                                   
                                   } else {
                                       print("<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT APPLICABLE</font>"
                                       );
                                   }      
                               }
                           }    
                      }
        }
        print("  </td>
                </tr>
                <tr>
                 <td align=\"left\" valign=\"top\" bgcolor=\"$bcolr\" style=\"width:100%; height:100px;\">
                  <font color=\"#330099\">
                   <strong>MISSED OPPORTUNITIES</strong>
                  </font> 
                  <br>
        ");
        $mochk = 0;        
        for ($sur=1;$sur<=$issue_sur_cnt; ++$sur){
                      for ($u=1;$u<=$issue_typ_cnt2 ; ++$u) {
                           if ($issue_typ_id2[$u] == $xissue_typ_id[$sur]){
                               $mochk = $mochk + 1;
                               print("<font color=\"blue\">&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ2[$u]."</font><br>");
                           }    
                      }
                 }
                 if ($mochk == 0){
                     print("<font color=\"blue\">NONE</a>".$issue_typ2[$u]."</font><br>");
                 }
                 print("  </td>
                         </tr>
                        </table> 
                        </td> 
        ");
        print("            
    	            <td bgcolor=\"$bcolr\" align=\"left\" style=\"width:600px; height:150px; word-wrap: break-word; word-break:break-all; scroll-x: auto;\">
    	              <font color=\"#000000\">
    	               <div style=\"word-wrap: break-word; word-break:break-all; width:600px; height:150px; overflow-y: auto; background-color: $bcolr;\">
                        <p style=\"width:575px; word-wrap: break-word; word-break:break-all;\">
                         $xissue_note
                        </p>
                       </div> 
                      </font>
    	            </td>
    	");
        print("
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     <strong>BY</strong><br><font color=\"blue\">$xissue_assignee</font><br><br><strong>ON</strong><br><font color=\"blue\">$xdt</font><br><br><strong>DEPARTMENT</strong><br><font color=\"blue\">$xissue_area_by</font>
                    </font>
                   </td>
        ");  
      }           
      $updcnt = $rowcnt;
           // displaying master record
           $query = "select a.issue_id,a.pdp_id,a.issue_desc,a.created_by,a.created_on,a.issue_area_id,b.issue_area 
                       from ".$name.".issues a, ".$name.".issue_areas b
                      where a.issue_id = '$v_issue_id' 
                        and a.issue_area_id = b.issue_area_id  
                    ";
                     //and a.issue_area_id_by = b.issue_area_id    //keeping this issue_area_id in query because initially UAT raised issues on behalf of other teams.
                     //and created_by = '$usr'
           //print($query);             
           $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
           $rowcnt = mysql_num_rows($mysql_data);
           //print($query);
           
           //$seq = 0;
           while($row = mysql_fetch_row($mysql_data)) {
	             $xid2             = stripslashes($row[0]);
                 $xpdp_id          = stripslashes($row[1]);
	             $xissue_desc      = stripslashes(trim($row[2]));
                 $xcreated_by      = stripslashes($row[3]);
                 $xcreated_on      = stripslashes($row[4]);
                 $xissue_area_id_x = stripslashes($row[5]);
                 $xissue_area_by   = stripslashes($row[6]);
                 $xd1              = date("d",$xcreated_on);
                 $xm1              = date("M",$xcreated_on);
                 $xy1              = date("Y",$xcreated_on);
                 $xcreate_dt       = $xd1."-".$xm1."-".$xy1;

                 $query22 = "select issue_surrogate_id,issue_type_id 
                               from ".$name.".issue_surrogates 
                              where issue_surrogate_id = '$xid2' 
                                and surrogate_type = 0"; 
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
                 print("   <tr valign=\"top\">
                            <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" colspan=\"4\"><font color=\"blue\"><strong>MASTER RECORD</strong></font></td>
                           </tr> 
                           <tr valign=\"top\">
    	                    <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
    	                      <font color=\"#330099\"> 
                              </font> 
                              <input type=\"hidden\" name=\"xissue_id\" value=\"$xid2\">
    	                    </td>
    	         ");
                 print("           
                            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                 ");
                 if ($updcnt == 0){
                     $bcolr = "#CCFFCC";
                 } else {
                     $bcolr = "#E8E8E8";
                 }
                 print("           
                        <table border=\"0\" border-color=\"$bcolr\" bgcolor=\"$bcolr\" width=\"100%\" cellpadding=\"0\">
                         <tr>
                 ");              
                 print(" <td align=\"left\" valign=\"middle\" bgcolor=\"$bcolr\" style=\"width:100%; height:75px;\">
                 ");
                 for ($sur=1;$sur<=$issue_sur_cnt0; ++$sur){
                      for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                           if ($issue_typ_id[$v] == $xissue_typ_id0[$sur]){
                               if ($issue_parent_id[$v] <> 0){
                                   for ($v2=1;$v2<=$issue_typ_cnt ; ++$v2) {
                                        if ($issue_typ_id[$v2] == $issue_parent_id[$v]){
                                            $parent_type = $issue_typ[$v2];
                                        } 
                                   }
                                   //$grtchk = $grtchk + 1;
                                   print("<strong><font color=\"#330099\">"."ROOT CAUSE<br></font></strong>".
                                         "<font color=\"blue\">".$parent_type."</font><br><br>".
                                         "<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."</font>"
                                        );
                               } else {
                                   print("<strong><font color=\"#330099\">ROOT CAUSE<br></font></strong><font color=\"blue\">".$issue_typ[$v]."<br><br>"
                                   );
                                   if ($issue_grt[$v] <> 0){
                                       print("<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT SELECTED</font>"
                                       );
                                   
                                   } else {
                                       print("<strong><font color=\"#330099\">GRANULAR ROOT CAUSE<br></font></strong><font color=\"blue\">NOT APPLICABLE</font>"
                                       );
                                   }      
                               }
                           }    
                      }
                 }
                 print("  </td>
                         </tr>
                         <tr>
                          <td align=\"left\" valign=\"top\" bgcolor=\"$bcolr\" style=\"width:100%; height:100px;\">
                           <font color=\"#330099\">
                            <strong>MISSED OPPORTUNITIES</strong>
                           </font> 
                            <br>
                 ");
                 $mochk = 0;        
                 for ($sur=1;$sur<=$issue_sur_cnt0; ++$sur){
                      for ($u=1;$u<=$issue_typ_cnt2 ; ++$u) {
                           if ($issue_typ_id2[$u] == $xissue_typ_id0[$sur]){
                               $mochk = $mochk + 1;
                               print("<font color=\"blue\">&nbsp&nbsp - "."<a>&nbsp&nbsp</a>".$issue_typ2[$u]."</font><br>");
                           }    
                      }
                 }
                 if ($mochk == 0){
                     print("<font color=\"blue\">NONE</a>".$issue_typ2[$u]."</font><br>");
                 }
                 print("  </td>
                         </tr>
                        </table> 
                        </td> 
                 ");
                 print("           
    	                    <td bgcolor=\"$bcolr\" align=\"left\" style=\"width:600px; height:150px; word-wrap: break-word; word-break:break-all; scroll-x: auto;\">
             	             <font color=\"#330099\">
    	                      <div style=\"word-wrap: break-word; word-break:break-all; width:600px; height:150px; overflow-y: auto; background-color: $bcolr;\">
                               <p style=\"width: 575px; word-wrap: break-word; word-break:break-all;\">
                                $xissue_desc
                               </p>
                              </div> 
                             </font> 
    	                    </td>
    	         ");
                 print("
                   <td bgcolor=\"#E8E8E8\" align=\"center\">
                    <font color=\"#330099\">
                     <strong>BY</strong><br><font color=\"blue\">$xcreated_by</font><br><br><strong>ON</strong><br><font color=\"blue\">$xcreate_dt</font><br><br><strong>DEPARTMENT</strong><br><font color=\"blue\">$xissue_area_by</font>
                    </font>
                   </td>
                 ");  
           }

// Display options
print("
            </table>
            <!--<table border='0'>
                <tr>
                 <td>-->
");

//print("
//                   <input type=\"submit\" name=\"submit\" value=\"Save\">
//");

// End of HTML
print("
                   <!--<input type=\"submit\" name=\"submit\" value=\"Issues List\" onclick=\"parent.document.all['content2'].innerHTML='&lt;iframe src=&quot;display_pdp_issues2.php?pdp=$pdp&&start=1&quot; width=&quot;100%&quot; height=&quot;100%&quot; scrolling=&quot;auto&quot; frameborder=&quot;no&quot;&gt;&lt;/iframe&gt;'\">
                   <input type=\"hidden\" name=\"v_issue_id\" value=\"$v_issue_id\">
                   <input type=\"hidden\" name=\"v_issue_hist_id\" value=\"$v_issue_hist_id\">
                   <input type=\"hidden\" name=\"v_usr\" value=\"$usr\">
                   <input type=\"hidden\" name=\"pdp\" value=\"$pdp\">
                 </td>
                </tr>
            </table>
           </form>-->
          </div>   
         </body>
        </html>
     ");

// --------------------------     
// End of the check-01
//}
// --------------------------


?>
