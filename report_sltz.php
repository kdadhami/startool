<?php
// Connection
require_once("./inc/connect.php");
set_time_limit(0);

// HTML START
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
$hstart = "<html>
            <head>
             <style>
                 body    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px; 
                           font-size: 12px; 
                         }
                   th    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                           color: #FFFFFF;
                           border: 1px solid #CCCCCC; 
                           /*border-style:solid;
                           border-color:#CCCCCC;*/
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
                 caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 24px; font-weight: bold;}       
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
                           color: #330099;
                         }
                a:visited 
                         {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: none;
                           color: #FF0000;
                         }
                a:hover  {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: underline overline;
                           color: #330099;
                         }
                a:active {
                           font-family: Calibri, Helvetica, sans-serif;
                           text-decoration: none;
                           color: #330099;
                         }
                .cont{ overflow:auto }
                .cont2{ overflow:auto }
                .wrapper2{width: 100%; height: 75%; background-color: #FFFFFF; overflow-x: scroll; overflow-y:scroll; }
                /*.div2 {width:100%; height: 75%; background-color: #FFFFFF; overflow-x: scroll; overflow-y:scroll;}*/
             </style>       

             <script type=\"text/javascript\">
                     function PopupCenter(pageURL, title,w,h)
                      {
                        w = window.screen.availWidth;
                        h = window.screen.availHeight;
                        var left = (screen.width/2)-(w/2);
                        var top = (screen.height/2)-(h/2);
                        var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                      }
             </script>
 
             <script type=\"text/javascript\">
                    function popup1(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname6', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>
 
             <script type=\"text/javascript\">
                    function popup3(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname7', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>

             <script type=\"text/javascript\">
                    function popup10(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname10', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>

             <script type=\"text/javascript\">
                    function popup11(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname11', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>

             <script type=\"text/javascript\">
                    function popup12(url) 
                    {
                     var width  = 1000;
                     var height = 800;
                     var left   = (screen.width  - width)/2;
                     var top    = (screen.height - height)/2;
                     var params = 'width='+width+', height='+height;
                     params += ', top='+top+', left='+left;
                     params += ', directories=no';
                     params += ', location=no';
                     params += ', menubar=no';
                     params += ', resizable=no';
                     params += ', scrollbars=yes';
                     params += ', status=no';
                     params += ', toolbar=no';
                     newwin=window.open(url,'windowname12', params);
                     if (window.focus) {newwin.focus()}
                     return false;
                    }
             </script>
			 
             <script type=\"text/javascript\">
              var rowVisible = true;
              function toggleDisplay(tbl) {
               var tblRows = tbl.rows;
               for (i = 0; i < tblRows.length; i++) {
                if (tblRows[i].className != \"headerRow\") {
                    tblRows[i].style.display = (rowVisible) ? \"none\" : \"\";
                }
               }
               rowVisible = !rowVisible;
              }
             </script>

             <script type=\"text/javascript\">
              var rowVisible = true;
              function toggleDisplay2(tbl) {
               var tblRows = tbl.rows;
               for (i = 0; i < tblRows.length; i++) {
                if (tblRows[i].className != \"headerRow2\") {
                    tblRows[i].style.display = (rowVisible) ? \"none\" : \"\";
                }
               }
               rowVisible = !rowVisible;
              }
             </script>

             <script type=\"text/javascript\">
              var rowVisible = true;
              function toggleDisplay3(tbl) {
               var tblRows = tbl.rows;
               for (i = 0; i < tblRows.length; i++) {
                if (tblRows[i].className != \"headerRow3\") {
                    tblRows[i].style.display = (rowVisible) ? \"none\" : \"\";
                }
               }
               rowVisible = !rowVisible;
              }
             </script>

             <script type=\"text/javascript\">
              var rowVisible = true;
              function toggleDisplay4(tbl) {
               var tblRows = tbl.rows;
               for (i = 0; i < tblRows.length; i++) {
                if (tblRows[i].className != \"headerRow4\") {
                    tblRows[i].style.display = (rowVisible) ? \"none\" : \"\";
                }
               }
               rowVisible = !rowVisible;
              }
             </script>
			 
			 
			 </head>
            <body>
    "; 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////


// ============================== SESSION START ==============================
session_start();
$xsession = session_id();
$querys5 = "SELECT user 
              FROM ".$name.".sessions
             WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#21 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),b.short_desc,u.user_type
                     FROM ".$name.".users a, ".$name.".issue_areas b, ".$name.".user_types u   
                    WHERE trim(a.lanid) = '$usr' 
                      AND a.issue_area_id = b.issue_area_id 
                      AND a.user_type_id = u.user_type_id
                    group by b.issue_area_id";
       //print($querys6);             
       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#22 Could not query: ".mysql_error());                    
       while ($row6 = mysql_fetch_row($mysql_data6)) {
              $uissue_area_id  = stripslashes($row6[0]); 
              $uissue_area     = stripslashes($row6[1]);
              $ushort_desc     = stripslashes($row6[2]);
              $uuser_type      = stripslashes($row6[3]);
       }         
}
// =============================== SESSION END ===============================

if ($start == 1) {     // the cheque now starts early to have incremental ETL run every time to hash current year YTD

    //echo "<script type=\"text/javascript\">window.alert('Please wait while system reconcile data for reports and hashed YTD data')</script>";

   /////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////
   // setting up today's date
   $newd  = date("d");   //day
   $newm  = date("m");   //month
   $newy  = date("Y");   //year
   $tdate = $newy."-".$newm."-".$newd;
   //print("Today's Date: ".$tdate."<br>");
   // 30 days from today
   $new_dt = mktime(0,0,0,$newm,$newd,$newy) + (60*60*24*30);
   $newd  = date("d",$new_dt);   //day
   $newm  = date("m",$new_dt);   //month
   $newy  = date("Y",$new_dt);   //year
   $st_beg_dt = "(YYY-MM-DD)<br>2010-09-01 TO 2010-12-31";
   $beg_dt    = $newy."-"."01-01";
   $today_dt  = $newy."-".$newm."-".$newd;
   //print("Today's date :".$today_dt."<br>"); 
   $fromdt = mktime(0,0,0,$xms,$xds,$xys);
   $todate = mktime(0,0,0,$xme,$xde,$xye);
   
   if (($fromdt == $todate) && ($fromdt == 1283313600)){
        $xldate  = "2010-09-01";
        $xldate2 = "2010-09-01";  //$today_dt;
   }
   if ($fromdt <> $todate){
    if ($fromdt == 1283313600){
        $xldate = "2010-09-01";
    } else {
       if (strlen($xds) == 1){
           $xds = "0".$xds;
       } 
       if (strlen($xms) == 1){
           $xms = "0".$xms;
       }
       $xldate = $xys."-".$xms."-".$xds;
    }
    if ($todate > $fromdt){    
       if (strlen($xde) == 1){
           $xde = "0".$xde;
       } 
       if (strlen($xme) == 1){
           $xme = "0".$xme;
       }
       $xldate2 = $xye."-".$xme."-".$xde;
	   //$xldate2_x = $xldate2;
    } else {
       $xldate2 = $xldate;
	   //$xldate2_x = $xldate2;
    }   
   } 
   if (($fromdt == $todate) && ($fromdt <> 1283313600)){
       if (strlen($xds) == 1){
           $xds = "0".$xds;
       } 
       if (strlen($xms) == 1){
           $xms = "0".$xms;
       }
       $xldate = $xys."-".$xms."-".$xds;
       if (strlen($xde) == 1){
           $xde = "0".$xde;
       } 
       if (strlen($xme) == 1){
           $xme = "0".$xme;
       }
       $xldate2 = $xye."-".$xme."-".$xde;
   }
   //print("Date: ".$xldate2."<br>");
   /////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////
//print($xldate2."<br>");
// INCREMENTAL ETL
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

       // ============================== PDP TYPES ==============================
       $queryptyp = "select pdp_period_id,pdp_period 
                       from ".$name.".pdp_periods 
                      where pdp_period_ind = 1 
                   order by pdp_period asc "; 
       $mysql_dataptyp = mysql_query($queryptyp, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcntptyp     = mysql_num_rows($mysql_dataptyp);    
       
       $pdp_prd_cnt = 1;
       $pdp_prd_id[$pdp_prd_cnt] = 0;
       $pdp_prd[$pdp_prd_cnt]    = "NOT SET";
       //print($pdp_prd[$pdp_prd_cnt]."<br>");
       while($rowptyp = mysql_fetch_row($mysql_dataptyp)) {
             $pdp_prd_cnt              = $pdp_prd_cnt + 1;
             $pdp_prd_id[$pdp_prd_cnt] = stripslashes(trim($rowptyp[0]));
             $pdp_prd[$pdp_prd_cnt]    = stripslashes(trim($rowptyp[1]));
             //print($pdp_prd[$pdp_prd_cnt]."<br>");
       }



// setting up today's date
$yw         = date("D");
$yd         = date("d");
$ym         = date("m");
$yy         = date("Y");
$yt         = date("H:i:s T");
$yt2        = date("HisT");
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ym1        = date("m");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
$yearstart  = $yy."-01-01";
$datetoday  = $yy."-".$ym1."-".$yd;
$yeartoday  = $yy;
$etl_year   = $yy;

// setting up start and end date
$start_d    = 1;
$start_m    = 1;
$start_y    = $etl_year;
$start_dmy  = mktime(0,0,0,$start_m,$start_d,$start_y);
$end_d      = 31;
$end_m      = 12;
$end_y      = $etl_year;
$end_dmy    = mktime(0,0,0,$end_m,$end_d,$end_y);
//print($start_d."-".$start_m."-".$start_y." - "."      ".$end_d."-".$end_m."-".$end_y."<br>");
//print($start_dmy." - ".$end_dmy."<br>");

// REAL TIME UPDATE HAS BEEN TAKEN OUT

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////



// START OF REPORT
// CONTROL VARIABLES
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
// ==============================
// Getting user for this sessrion
//session_start();
//$xsession = session_id();
//$querys5 = "SELECT user FROM ".$name.".sessions
//             WHERE sessionid = trim('$xsession')" ;
////print($querys5);
//$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#21 Could not query: ".mysql_error());
//while ($row5 = mysql_fetch_row($mysql_data5)) {
//       $usr  = stripslashes($row5[0]);
//       $querys6 = "SELECT b.issue_area_id,UPPER(trim(b.issue_area)),b.short_desc,u.user_type
//                     FROM ".$name.".users a, ".$name.".issue_areas b, ".$name.".user_types u   
//                    WHERE trim(a.lanid) = '$usr' 
//                      AND a.issue_area_id = b.issue_area_id 
//                      AND a.user_type_id = u.user_type_id
//                    group by b.issue_area_id";
//       //print($querys6);             
//       $mysql_data6 = mysql_query($querys6, $mysql_link) or die ("#22 Could not query: ".mysql_error());                    
//       while ($row6 = mysql_fetch_row($mysql_data6)) {
//              $uissue_area_id  = stripslashes($row6[0]); 
//              $uissue_area     = stripslashes($row6[1]);
//              $ushort_desc     = stripslashes($row6[2]);
//              $uuser_type      = stripslashes($row6[3]);
//              //print($yissue_area_id);
//      }         
//}
// ==============================

$h_dpt[1] = 'REVENUE ASSURANCE';
$h_dpt[2] = 'ENTERPRISE UAT';

// setting up today's date
$yw         = date("D");
$yd         = date("d");
$ym         = date("m");
$yy         = date("Y");
$yt         = date("H:i:s T");
$yt2        = date("HisT");
$yt3        = date("H-i-s-T");  
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt3;
$xreport_pth = "./reports/";
$xreport_nam = "PDP_SLT_REPORT-".$ydate3.".htm";

//print ($reportname); 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

















// REPORT LOGIC START
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

//if ($start == 1) {          //// Taken to line 34 above
   // ------------------------------------------------------------------------------------------------------------ //
   ob_start();
   print($hstart);
   // ------------------------------------------------------------------------------------------------------------ //

   //print($xldate2."<br>");
   
   $querysa1 = "ALTER TABLE ".$name.".issue_surrogates ENGINE='InnoDB'" ;
   $mysql_dataa1 = mysql_query($querysa1, $mysql_link) or die ("#a1 Could not query: ".mysql_error());




   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // ============================== ISSUE AREA START ==============================
   //print("AREAS<br>");
   $query96                = "select distinct issue_area
                                from ".$name.".tgt_areas
                               where etl_id = '$yetl_id'
                            order by issue_area asc"; 
   $mysql_data96           = mysql_query($query96, $mysql_link) or die ("#2.1 Could not query: ".mysql_error());
   $rowcnt96               = mysql_num_rows($mysql_data96);
   //print($query96."<br>"); 
   $dcnt2                  = 0;
   while($row96            = mysql_fetch_row($mysql_data96)) {
         $dcnt2            = $dcnt2 + 1;
         $darea[$dcnt2]    = stripslashes($row96[0]);  //issue_area
         $disuecnt[$dcnt2] = 0;
         //print($dcnt2." - ".$darea[$dcnt2]."<br>");
   }
   // =============================== ISSUE AREA END ===============================



   // ============================= PDP TESTING START ==============================
   $query70               = "select distinct issue_area,short_code
                               from ".$name.".tgt_areas
                              where etl_id = '$yetl_id'  
                           order by issue_area asc"; 
                           //where etl_id = '$yetl_id'
   //print($query70."<br>");                        
   $mysql_data70          = mysql_query($query70, $mysql_link) or die ("#2.5 Could not query: ".mysql_error());
   $rowcnt70              = mysql_num_rows($mysql_data70); 
   $dcnt                  = 0;
   while($row70           = mysql_fetch_row($mysql_data70)) {
         $dcnt            = $dcnt + 1;
         $dpt[$dcnt]      = stripslashes($row70[0]);        //department
         $dsc[$dcnt]      = trim(stripslashes($row70[1]));  //department short description
         //print($dcnt." - ".$dpt[$dcnt]." - ".$dsc[$dcnt]."<br>");
   }
   //print("Total Departments: ".$dcnt."<br>");
   // ============================== PDP TESTING END ===============================


   // ===================== APPLYING THE FILTERS ====================
   // 0 means filtered
   // 1 means not filtered
   //print($prd."<br>".$pdpcat."<br>");
   $fltr1 = 0;     // pdp_type
   $fltr2 = 0;     // RA_IND
   $fltr3 = 0;     // pdp_category
   $fltr4 = 0;     // Date
   if ($prd == "ALL") {
       $fltr1 = 1; 
   }
   if ($ra_ind == "BOTH") {
       $fltr2 = 1; 
   }
   if ($pdpcat == "ALL") {
       $fltr3 = 1; 
   } 
   ////print($prd."<br>".$fltr1."<br>");  
   ////print($pdpcat."<br>".$fltr3."<br>");
   //// setting up today's date
   //$newd  = date("d");   //day
   //$newm  = date("m");   //month
   //$newy  = date("Y");   //year
   //// 30 days from today
   //$new_dt = mktime(0,0,0,$newm,$newd,$newy) + (60*60*24*30);
   //$newd  = date("d",$new_dt);   //day
   //$newm  = date("m",$new_dt);   //month
   //$newy  = date("Y",$new_dt);   //year
   //$st_beg_dt = "(YYY-MM-DD)<br>2010-09-01 TO 2010-12-31";
   //$beg_dt    = $newy."-"."01-01";
   //$today_dt  = $newy."-".$newm."-".$newd;
   ////print("Today's date :".$today_dt."<br>"); 
   //$fromdt = mktime(0,0,0,$xms,$xds,$xys);
   //$todate = mktime(0,0,0,$xme,$xde,$xye);
   
   //if (($fromdt == $todate) && ($fromdt == 1283313600)){
   //     $xldate  = "2010-09-01";
   //     $xldate2 = "2010-09-01";  //$today_dt;
   //}
   //if ($fromdt <> $todate){
   // if ($fromdt == 1283313600){
   //     $xldate = "2010-09-01";
   // } else {
   //    if (strlen($xds) == 1){
   //        $xds = "0".$xds;
   //    } 
   //    if (strlen($xms) == 1){
   //        $xms = "0".$xms;
   //    }
   //    $xldate = $xys."-".$xms."-".$xds;
   // }
   // if ($todate > $fromdt){    
   //    if (strlen($xde) == 1){
   //        $xde = "0".$xde;
   //    } 
   //    if (strlen($xme) == 1){
   //        $xme = "0".$xme;
   //    }
   //    $xldate2 = $xye."-".$xme."-".$xde;
   // } else {
   //    $xldate2 = $xldate;
   // }   
   //} 
   //if (($fromdt == $todate) && ($fromdt <> 1283313600)){
   //    if (strlen($xds) == 1){
   //        $xds = "0".$xds;
   //    } 
   //    if (strlen($xms) == 1){
   //        $xms = "0".$xms;
   //    }
   //    $xldate = $xys."-".$xms."-".$xds;
   //    if (strlen($xde) == 1){
   //        $xde = "0".$xde;
   //    } 
   //    if (strlen($xme) == 1){
   //        $xme = "0".$xme;
   //    }
   //    $xldate2 = $xye."-".$xme."-".$xde;
   //}

   ////print($xds."<br>");
   ////print($xms."<br>");
   
   ////print($xys."<br>"); 
   ////print("From Date: ".$xldate."<br>"."To Date: ".$xldate2."<br>");
   //// ===============================================================


  










   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////

   $captnx0 = $ydate;
   $captnx  = "PDP SLT REPORT";
   $captnx1 = "PDP TYPE"; 


   $query_pdp0 = "  SELECT ytd_year
                      FROM ".$name.".tgt_ytd_main 
                  GROUP BY ytd_year 
                 ";
   //print($query_pdp0."<br>");				 
   $mysql_data0  = mysql_query($query_pdp0, $mysql_link) or die ("#query1 Could not query: ".mysql_error()); 
   $qry1_rows0    = mysql_num_rows($mysql_data0); 
   $qry0 = 0;                
   while($row0   = mysql_fetch_row($mysql_data0)) {
         $qry0            = $qry0 + 1;
         $yr[$qry0]       = trim(stripslashes($row0[0]));
		 //print($yr[$qry0]."<br>");
         $ypdp_in[$qry0]  = 0;
         $yisu_in[$qry0]  = 0;
         $ypdp_out[$qry0] = 0;
         $yisu_out[$qry0] = 0;
   }
   
   print("<input type=\"button\" value=\"Toggle Detail Rows\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");
   
   print("               <table id=\"theTable\" width=\"100%\">
                          <caption>$captnx0</caption>
						  <tr class=\"headerRow\"></tr>
 						  <caption>$captnx</caption>
						  <tr class=\"headerRow\"></tr>
						  <caption>$captnx1</caption>
                          <tr class=\"headerRow\">
                           <th bgcolor=\"#CCFFCC\" colspan=\"5\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                            <font color=\"#330099\">
                             (YYYY-MM-DD)&nbsp&nbsp&nbsp$xldate &nbsp&nbspTO&nbsp&nbsp $xldate2
                            </font>
                           </th>
    ");
    $clrcnt = 0;
    //for ($h=1;$h<=$qry0;++$h) {
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
		 if ($h == 1){
		     $dsp_dt_range = $st_beg_dt; 
		 }
		 if ($h == $qry0){
		     $dsp_dt_range = "YTD";               //"(YYY-MM-DD)<br>".$beg_dt." TO TODATE"; 
		 }
		 if (($h <> 1) && ($h <> $qry0)){
		     $dsp_dt_range = "(YYY-MM-DD)<br>".$yr[$h]."-01-01 TO ".$yr[$h]."-12-31";
		 }
         print("<th bgcolor=\"$colr\" colspan=\"4\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                  <font color=\"#330099\">
                   $yr[$h]<br>$dsp_dt_range
                  </font>
                 </th>
         ");
	 }	 
    }
    print("</tr>");
    print("                       
                          <tr class=\"headerRow\">
                           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                            <font color=\"#330099\">PDP Type</font>
                           </th>
                           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">IN SCOPE</font>
                           </th>
                           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">ISSUES CREATED</font>
                           </th>
                           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                            <font color=\"#330099\">OUT OF SCOPE</font>
                           </th>
                           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">ISSUES CREATED</font>
                           </th>
   ");
    $clrcnt = 0;
    //for ($h=1;$h<=$qry0;++$h) {
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
		print("
                           <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">$yr[$h]<br>IN SCOPE</font>
                           </th>
                           <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">$yr[$h]<br>ISSUES CREATED</font>
                           </th>
                           <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">$yr[$h]<br>OUT OF SCOPE</font>
                           </th>
                           <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                            <font color=\"#330099\">$yr[$h]<br>ISSUES CREATED</font>
                           </th>
         ");
	 }	 
    }
   print("</tr>");
   $xpdp_in  = 0;
   $xpdp_out = 0;
   $xisu_in  = 0;
   $xisu_out = 0;
   for ($pt=1;$pt<=$pdp_prd_cnt;++$pt) {
        //print("<tr>
        //        <td bgcolor=\"#C6DEFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
        //         <font color=\"#330099\">
        //          $pdp_prd[$pt]
        //         </font>
        //        </td>
        //");       
        //Current In-Scope       
        $query_pdp1 = "         SELECT a.etl_id,a.pdp_type,count(*),sum(a.issues_created)
                                  FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b
                                 WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye'))
                                   AND a.pdp         = b.pdp 
                                   AND b.short_desc  = 'UAT'
                                   AND (   (b.tested = 'YES')
                                        OR (b.tested = 'NO' AND a.scoping = 'IN SCOPE')
                                        )
                                   AND pdp_type = '$pdp_prd[$pt]' 
                                   AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
                              GROUP BY a.pdp_type
                      ";
		//if ($pt == 1){
        //    print("In Scope<br>");		 
        //    print("Start Year: ".$xys." - End Year: ".$xye."<br>");
        //    print("Start Date YYY-MM-DD: ".$xldate." - End Date YYYY-MM-DD: ".$xldate2."<br>"); 		 
		//}
        //print("IN<br>".$query_pdp1."<br>"); 
        $mysql_data1  = mysql_query($query_pdp1, $mysql_link) or die ("#query1 Could not query: ".mysql_error()); 
        $qry_rows1    = mysql_num_rows($mysql_data1); 
        //print($qry_rows1."<br>"); 
        if ($qry_rows1 == 0){
               $pdp_in[$pt] = 0;
               $isu_in[$pt] = 0;
        } //else {               
        while($row1   = mysql_fetch_row($mysql_data1)) {
               $pdp_in[$pt] = trim(stripslashes($row1[2]));
               $isu_in[$pt] = trim(stripslashes($row1[3]));
        }
		//PRINT IN-SCOPE FOR DATE RANGE
        //print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
        //         <font color=\"#000000\">
        //          $pdp_in[$pt]
        //         </font>
        //        </td>
        //        <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
        //         <font color=\"#000000\">
        //          $isu_in[$pt]
        //         </font>
        //        </td>            
        //");
        $xpdp_in = $xpdp_in + $pdp_in[$pt];
        $xisu_in = $xisu_in + $isu_in[$pt];       
        //Current Out-of-Scope       
        $query_pdp2 = "         SELECT a.etl_id,a.pdp_type,count(*),sum(a.issues_created)
                                  FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b
                                 WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye') )
                                   AND a.pdp         = b.pdp 
                                   AND b.short_desc  = 'UAT'
                                   AND (b.tested    = 'NO' AND a.scoping in ('OUT OF SCOPE','NOT SET')) 
                                   AND pdp_type     = '$pdp_prd[$pt]' 
                                   AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
                              GROUP BY a.pdp_type
                                 ";
		//if ($pt == 1){
		//print("OUT<br>".$query_pdp2."<br>"); 
        //    print("Out Of Scope<br>");		 
        //    print("Start Year: ".$xys." - End Year: ".$xye."<br>");
        //    print("Start Date YYY-MM-DD: ".$xldate." - End Date YYYY-MM-DD: ".$xldate2."<br>"); 		 
		//}
        $mysql_data2  = mysql_query($query_pdp2, $mysql_link) or die ("#query2 Could not query: ".mysql_error()); 
        $qry1_rows2    = mysql_num_rows($mysql_data2); 
        //print($qry1_rows2."<br>");                 
        if ($qry1_rows2 == 0){
               $pdp_out[$pt] = 0;
               $isu_out[$pt] = 0;
        } //else {               
        while($row2   = mysql_fetch_row($mysql_data2)) {
               $pdp_out[$pt] = trim(stripslashes($row2[2]));
               $isu_out[$pt] = trim(stripslashes($row2[3]));
			   //print($pdp_prd[$pt]." has out-of-scope pdps = ".$pdp_out[$pt]." and issues created = ".$isu_out[$pt]."<br>");
        }
		//PRINT OUT-OF-SCOPE FOR DATE RANGE
        //print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
        //        <font color=\"#000000\">
        //         $pdp_out[$pt]
        //        </font>
        //       </td>
        //       <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
        //        <font color=\"#000000\">
        //         $isu_out[$pt]
        //        </font>
        //       </td>            
        //");
        $xpdp_out = $xpdp_out + $pdp_out[$pt];
        $xisu_out = $xisu_out + $isu_out[$pt];       
        $y = 0;
		//PRINT YTD
        //for ($x=1;$x<=$qry0;++$x) {
        for ($x=$qry0;$x>=1;$x=$x-1) {
              $query_pdp3 = "         SELECT etl_id,ytd_count_in,ytd_count_issues_in,ytd_count_out,ytd_count_issues_out
                                        FROM ".$name.".tgt_ytd_main 
                                       WHERE ytd_year = '$yr[$x]' 
                                         AND pdp_type = '$pdp_prd[$pt]' 
                                       ";
               //print("YTD<br>".$query_pdp3."<br>");                        
               $mysql_data3  = mysql_query($query_pdp3, $mysql_link) or die ("#query3 Could not query: ".mysql_error()); 
               $qry1_rows3    = mysql_num_rows($mysql_data3); 
               while($row3   = mysql_fetch_row($mysql_data3)) {
                     $pdp_ytd_in[$pt][$x]  = trim(stripslashes($row3[1]));
                     $isu_ytd_in[$pt][$x]  = trim(stripslashes($row3[2]));
                     $pdp_ytd_out[$pt][$x] = trim(stripslashes($row3[3]));
                     $isu_ytd_out[$pt][$x] = trim(stripslashes($row3[4]));
                     // Totals
                     $ypdp_in[$x]  = $ypdp_in[$x]  + $pdp_ytd_in[$pt][$x];
                     $yisu_in[$x]  = $yisu_in[$x]  + $isu_ytd_in[$pt][$x];
                     $ypdp_out[$x] = $ypdp_out[$x] + $pdp_ytd_out[$pt][$x];
                     $yisu_out[$x] = $yisu_out[$x] + $isu_ytd_out[$pt][$x];
                     //print("<td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                     //        <font color=\"#000000\">
                     //         $pdp_ytd_in[$pt]
                     //        </font>
                     //       </td>
                     //       <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                     //        <font color=\"#000000\">
                     //         $isu_ytd_in[$pt]
                     //        </font>
                     //       </td> 
                     //       <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                     //        <font color=\"#000000\">
                     //         $pdp_ytd_out[$pt]
                     //        </font>
                     //       </td>
                     //       <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                     //        <font color=\"#000000\">
                     //         $isu_ytd_out[$pt]
                     //        </font>
                     //       </td>
                     //");
               }
        }
        //print("</tr>");
    }
	for ($pt=1;$pt<=$pdp_prd_cnt;++$pt) {
	     if ($pdp_in[$pt] <> 0){ 
	         $prc_pdp_in = round(($pdp_in[$pt]/$xpdp_in)*100,2);
		 } else {
		     $prc_pdp_in = 0;
		 }
	     if ($isu_in[$pt] <> 0){ 
	         $prc_isu_in = round(($isu_in[$pt]/$xisu_in)*100,2);
		 } else {
		     $prc_isu_in = 0;
		 }
	     if ($pdp_out[$pt] <> 0){ 
	         $prc_pdp_out = round(($pdp_out[$pt]/$xpdp_out)*100,2);
		 } else {
		     $prc_pdp_out = 0;
		 }
	     if ($isu_out[$pt] <> 0){ 
	         $prc_isu_out = round(($isu_out[$pt]/$xisu_out)*100,2);
		 } else {
		     $prc_isu_out = 0;
		 }
         print("<tr>
                 <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\">
                  <font color=\"#330099\">
                   $pdp_prd[$pt]
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                  <font color=\"#330099\">
                   <a href=\"javascript:void(0);\" onclick=\"popup1('../list_pdps.php?sqltyp=1&&pdptype=$pdp_prd[$pt]&&xys=$xys&&xye=$xye&&xldate=$xldate&&xldate2=$xldate2')\">
				    $pdp_in[$pt]<br>($prc_pdp_in%)
				   </a>
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                  <font color=\"#330099\">
				    $isu_in[$pt]<br>($prc_isu_in%)
                  </font>
                 </td>            
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                  <font color=\"#330099\">
                   <a href=\"javascript:void(0);\" onclick=\"popup3('../list_pdps.php?sqltyp=2&&pdptype=$pdp_prd[$pt]&&xys=$xys&&xye=$xye&&xldate=$xldate&&xldate2=$xldate2')\">
				    $pdp_out[$pt]<br>($prc_pdp_out%)
				   </a>
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                  <font color=\"#330099\">
                   $isu_out[$pt]<br>($prc_isu_out%)
                  </font>
                 </td>
         "); 				
    	 for ($h=$qry0;$h>=1;$h=$h-1) {
	      // Suppress Presenting beyone YTD for current and previous year
          if ($h == ($qry0-1) or $h == $qry0){     		 
		      $xpdp_ytd_in  = $pdp_ytd_in[$pt][$h]; 
			  $xisu_ytd_in  = $isu_ytd_in[$pt][$h];
			  $xpdp_ytd_out = $pdp_ytd_out[$pt][$h];
			  $xisu_ytd_out = $isu_ytd_out[$pt][$h];
    	      if ($xpdp_ytd_in <> 0){ 
	              $prc_xpdp_ytd_in = round(($xpdp_ytd_in/$ypdp_in[$h])*100,2);
		      } else {
		          $prc_xpdp_ytd_in = 0;
		      }
    	      if ($xisu_ytd_in <> 0){ 
	              $prc_xisu_ytd_in = round(($xisu_ytd_in/$yisu_in[$h])*100,2);
		      } else {
		          $prc_xisu_ytd_in = 0;
		      }
    	      if ($xpdp_ytd_out <> 0){ 
	              $prc_xpdp_ytd_out = round(($xpdp_ytd_out/$ypdp_out[$h])*100,2);
		      } else {
		          $prc_xpdp_ytd_out = 0;
		      }
    	      if ($xisu_ytd_out <> 0){ 
	              $prc_xisu_ytd_out = round(($xisu_ytd_out/$yisu_out[$h])*100,2);
		      } else {
		          $prc_xisu_ytd_out = 0;
		      }
		      print("
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                      <font color=\"#330099\">
                       $xpdp_ytd_in<br>($prc_xpdp_ytd_in%)
                      </font>
                     </td>
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                      <font color=\"#330099\">
                       $xisu_ytd_in<br>($prc_xisu_ytd_in%)
                      </font>
                     </td> 
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                      <font color=\"#330099\">
                       $xpdp_ytd_out<br>($prc_xpdp_ytd_out%)
                      </font>
                     </td>
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 100px;\">
                      <font color=\"#330099\">
                       $xisu_ytd_out<br>($prc_xisu_ytd_out%)
                      </font>
                     </td>
             ");
		 }	 
		}
		print("</tr>");
	}
    print("<tr class=\"headerRow\">
           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
            <font color=\"#330099\">Total</font>
           </th>
           <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
             <font color=\"#330099\">$xpdp_in<br>(100%)</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
             <font color=\"#330099\">$xisu_in<br>(100%)</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
             <font color=\"#330099\">$xpdp_out<br>(100%)</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
             <font color=\"#330099\">$xisu_out<br>(100%)</font>
            </th>
    ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
         print("
                <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                 <font color=\"#330099\">$ypdp_in[$h]<br>(100%)</font>
                </th>
                <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                 <font color=\"#330099\">$yisu_in[$h]<br>(100%)</font>
                </th>
                <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                 <font color=\"#330099\">$ypdp_out[$h]<br>(100%)</font>
                </th>
                <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                 <font color=\"#330099\">$yisu_out[$h]<br>(100%)</font>
                </th>
         ");
	 }	 
    }
	print("   </tr>
	");
	$yy = date("Y");
	for ($d=1;$d<=$dcnt2;++$d) {
	     // Current In-Scope
         $query_pdp1x = "         SELECT sum(c.issue_count)
                                    FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_area_execution c
                                   WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye'))
                                     AND a.pdp         = b.pdp 
                                     AND b.short_desc  = 'UAT'
                                     AND (   (b.tested = 'YES')
                                          OR (b.tested = 'NO' AND a.scoping = 'IN SCOPE')
                                          )
                                     AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
									 AND a.pdp = c.pdp
									 AND trim(upper(c.issue_area)) = trim(upper('$darea[$d]'))
 							    GROUP BY c.issue_area
                       ";
	     //print("T-IN:<br>".$query_pdp1x."<br>");				   
         $mysql_data1x  = mysql_query($query_pdp1x, $mysql_link) or die ("#query1_1 Could not query: ".mysql_error()); 
         $qry_rows1x    = mysql_num_rows($mysql_data1x);
         //print($qry1_rows1x."<br>");		 
         if ($qry_rows1x == 0){
             //$pdp_in1x = 0;
             $isu_in1x = 0;
			 $prc_in1x = 0;
         }               
         while($row1x   = mysql_fetch_row($mysql_data1x)) {
               //$pdp_in1x = trim(stripslashes($row1x[2]));
               $isu_in1x = trim(stripslashes($row1x[0]));
                if ($isu_in1x == 0){
                    $prc_in1x = 0;
                } else { 				
			        $prc_in1x = round(($isu_in1x/$xisu_in)*100,2);
			   }
         }
         //Current Out-of-Scope       
         $query_pdp2x = "         SELECT sum(c.issue_count)
                                    FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_area_execution c 
                                   WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye') )
                                     AND a.pdp         = b.pdp 
                                     AND b.short_desc  = 'UAT'
                                     AND (b.tested    = 'NO' AND a.scoping in ('OUT OF SCOPE','NOT SET')) 
                                     AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
									 AND a.pdp = c.pdp
									 AND trim(upper(c.issue_area)) = trim(upper('$darea[$d]'))
                                GROUP BY c.issue_area
                                  ";
		 //print("T-OUT:<br>".$query_pdp2x."<br>");						  
         $mysql_data2x  = mysql_query($query_pdp2x, $mysql_link) or die ("#query2_1 Could not query: ".mysql_error()); 
         $qry1_rows2x   = mysql_num_rows($mysql_data2x);
         //print($qry1_rows2x."<br>"); 		 
         if ($qry1_rows2x == 0){
             //$pdp_out2x = 0;
             $isu_out2x = 0;
			 $prc_out2x = 0;
         }               
         while($row2x   = mysql_fetch_row($mysql_data2x)) {
                //$pdp_out2x = trim(stripslashes($row2x[2]));
                $isu_out2x = trim(stripslashes($row2x[0]));
                //print("isu_out2x is ".$isu_out2x."and xisu_out is ".$xisu_out."<br>");
                if ($isu_out2x == 0){
                    $prc_out2x = 0;
                } else {
                  if($xisu_out == 0){
                     $prc_out2x = 0;
                  } else {				  
				     $prc_out2x = round(($isu_out2x/$xisu_out)*100,2);
				  }
				}
         }
         print("<tr class=\"headerRow\">
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                  <font color=\"#330099\">$darea[$d]</font>
                 </th>
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                  <font color=\"#330099\">&nbsp</font>
                 </th>
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                  <font color=\"#330099\">$isu_in1x<br>($prc_in1x%)</font>
                 </th>
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100x;\">
                  <font color=\"#330099\">&nbsp</font>
                 </th>
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                  <font color=\"#330099\">$isu_out2x<br>($prc_out2x%)</font>
                 </th>
         ");
         $clrcnt = 0;
         for ($h=$qry0;$h>=1;$h=$h-1) {
	      // Suppress Presenting beyone YTD for current and previous year
          if ($h == ($qry0-1) or $h == $qry0){     		 
		      //
              $start_d = 1;
              $start_m = 1;
              $start_y = $yr[$h];
			  //print("Tdate: ".$tdate."<br>");
			  if ($yr[$h] <> $newy){
                  $xldate3 = $yr[$h]."-12-31"; 
              } else {
                  //$xldate3 = $xldate2;
				  $xldate3 = $tdate;                       //Fixing problem when department totals SQL does not have end_date = todate for current year
              }
			  $xldatey = $start_y."-".$start_m."-".$start_d;
			  //print($yr[$h].": ".$xldatey."<br>");
			  //print($yr[$h].": ".$xldate3."<br>");
              //print("--------------------------<br>");			  
              $start_dmy  = mktime(0,0,0,$start_m,$start_d,$start_y);
			  if ($yr[$h] == $yy){
                      $end_d = date("d");
                      $end_m = date("m");
              } else {			  
                      $end_d = 31;
                      $end_m = 12;
			  }
              $end_y = $yr[$h];
			  $xldate2y = $end_y."-".$end_m."-".$end_d;
              $end_dmy  = mktime(0,0,0,$end_m,$end_d,$end_y);
			  //
              $clrcnt = $clrcnt + 1;
              if ($clrcnt == 1){
                  $colr = "#ECE5B6";
              } else {
                  $colr = "#FFF8C6";
              }
              if ($clrcnt == 2){
                  $clrcnt = 0;
              }
              // setting up start and end date

	          // Current In-Scope
              $query_pdp1y = "         SELECT sum(c.issue_count)
                                         FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_area_execution c
                                        WHERE a.pdp         = b.pdp 
                                          AND b.short_desc  = 'UAT'
                                          AND (   (b.tested = 'YES')
                                               OR (b.tested = 'NO' AND a.scoping = 'IN SCOPE')
                                               )
                                          AND ((a.pdp_launch >= '$xldatey' and a.pdp_launch <= '$xldate3') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
		     							 AND a.pdp = c.pdp
		     							 AND trim(upper(c.issue_area)) = trim(upper('$darea[$d]'))
 		        				    GROUP BY c.issue_area
                            ";
	          //print("T-YTD-IN:<br>".$query_pdp1y."<br>");
              //print ($newy."<br>");
              //print ($end_y."<br>");
              //print ($xye." - ".$xme." - ".$xde."<br>");			  
              $mysql_data1y  = mysql_query($query_pdp1y, $mysql_link) or die ("#query1_1 Could not query: ".mysql_error()); 
              $qry_rows1y    = mysql_num_rows($mysql_data1y); 
			  //print($qry_rows1y."<br>");
              if ($qry_rows1y == 0){
                  //$pdp_in1x = 0;
                  $isu_in1y = 0;
				  $prc_in1y = 0;
              }               
              while($row1y   = mysql_fetch_row($mysql_data1y)) {
                    //$pdp_in1x = trim(stripslashes($row1x[2]));
                    $isu_in1y = trim(stripslashes($row1y[0]));
					if ( $isu_in1y == 0){
					     $prc_in1y = 0; 
					} else {
					     $prc_in1y = round(($isu_in1y/$yisu_in[$h])*100,2);
					}
              }
              //Current Out-of-Scope       
              $query_pdp2y = "         SELECT sum(c.issue_count)
                                         FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_area_execution c 
                                        WHERE a.pdp         = b.pdp 
                                          AND b.short_desc  = 'UAT'
                                          AND (b.tested    = 'NO' AND a.scoping in ('OUT OF SCOPE','NOT SET')) 
                                          AND ((a.pdp_launch >= '$xldatey' and a.pdp_launch <= '$xldate3') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
			     						 AND a.pdp = c.pdp
			     						 AND trim(upper(c.issue_area)) = trim(upper('$darea[$d]'))
                                    GROUP BY c.issue_area
                                  ";
		      //print("T-YTD-OUT:<br>".$query_pdp2y."<br>");						  
              $mysql_data2y  = mysql_query($query_pdp2y, $mysql_link) or die ("#query2_1 Could not query: ".mysql_error()); 
              $qry1_rows2y   = mysql_num_rows($mysql_data2y);
              //print($qry_rows2y."<br>");
              if ($qry_rows2y == 0){
                  //$pdp_out2x = 0;
                  $isu_out2y = 0;
				  $prc_out2y = 0;
              }               
              while($row2y   = mysql_fetch_row($mysql_data2y)) {
                    //$pdp_out2x = trim(stripslashes($row2x[2]));
                    $isu_out2y = trim(stripslashes($row2y[0]));
					if ($isu_out2y == 0){
					    $prc_out2y = 0;
					} else {
					    if($yisu_out[$h] == 0){
						   $prc_out2y = 0;
						} else {
					       $prc_out2y = round(($isu_out2y/$yisu_out[$h])*100,2);
						}
					}
              }
              print("
                     <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                      <font color=\"#330099\">&nbsp</font>
                     </th>
                     <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                      <font color=\"#330099\">$isu_in1y<br>($prc_in1y%)</font>
                     </th>
                     <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                      <font color=\"#330099\">&nbsp</font>
                     </th>
                     <th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100px;\">
                      <font color=\"#330099\">$isu_out2y<br>($prc_out2y%)</font>
                     </th>
              ");
		  }	  
         }
   }
	print("
	         </table>
			<!--</div>
           </div>-->			
          </br>
          </br>		  
	");

   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   $captnx2 = "ROOT CAUSE"; 


   $query_pdp0 = "         SELECT etl_year
                             FROM ".$name.".tgt_root_cause_ytd 
                         GROUP BY etl_year 
                 ";
   $mysql_data0  = mysql_query($query_pdp0, $mysql_link) or die ("#query1.1 Could not query: ".mysql_error()); 
   $qry1_rows0    = mysql_num_rows($mysql_data0); 
   $qry0 = 0;                
   while($row0   = mysql_fetch_row($mysql_data0)) {
         $qry0 = $qry0 + 1;
         $yr[$qry0]  = trim(stripslashes($row0[0]));
		 $ytd_tot_iusse_cnt[$qry0] = 0;
   }

   $query_pdp1 = " SELECT distinct issue_type
                    FROM ".$name.".tgt_root_cause_ytd 
                 ";
   $mysql_data1  = mysql_query($query_pdp1, $mysql_link) or die ("#query1.2 Could not query: ".mysql_error()); 
   $qry1_rows1    = mysql_num_rows($mysql_data1); 
   $qry1 = 0;                
   while($row1   = mysql_fetch_row($mysql_data1)) {
         $qry1 = $qry1 + 1;
         $rootcause[$qry1] = trim(stripslashes($row1[0]));
   }

   print("<input type=\"button\" value=\"Toggle Detail Rows\" onclick=\"toggleDisplay2(document.getElementById('theTable2'))\" />");
   
   print("
                        <!--<div id=\"One\" class=\"cont\">--> 
                         <table id=\"theTable2\">
						  <caption>$captnx2</caption>
                          <tr class=\"headerRow2\">
                           <th bgcolor=\"#CCFFCC\" colspan=\"2\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
                            <font color=\"#330099\">
                             (YYYY-MM-DD)<br>$xldate &nbsp&nbspTO&nbsp&nbsp $xldate2
                            </font>
                           </th>
    ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
		 if ($h == 1){
		     $dsp_dt_range = $st_beg_dt; 
		 }
		 if ($h == $qry0){
		     $dsp_dt_range = "YTD"; 
		 }
		 if (($h <> 1) && ($h <> $qry0)){
		     $dsp_dt_range = "(YYY-MM-DD)<br>".$yr[$h]."-01-01 TO ".$yr[$h]."-12-31";
		 }
         print("<th bgcolor=\"$colr\" colspan=\"1\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
                  <font color=\"#330099\">
                   $yr[$h]<br>$dsp_dt_range
                  </font>
                 </th>
         ");
	 }	 
    }
    print("</tr>");
    print("<tr class=\"headerRow2\">
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
             <font color=\"#330099\">ROOT CAUSE</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
             <font color=\"#330099\">COUNT & AVERAGE</font>
            </th>
   ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
         print("<th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                 <font color=\"#330099\">COUNT & AVERAGE</font>
                </th>
         ");
	 }	 
    }
    print("</tr>");
	$tot_issue_cnt = 0;
    for ($r=1;$r<=$qry1;++$r) {
         $query_root = " SELECT issue_type,sum(occurance)
	                       FROM ".$name.".tgt_pdp_issue_summary
                          WHERE pdp in (        
 	                           SELECT a.pdp
                                  FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c 
                                 WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye'))
                                   AND a.pdp = b.pdp AND b.short_desc  = 'UAT'
								   AND a.pdp = c.pdp AND c.short_desc  = 'RA'
                                   AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
           			                   )
  	       			     AND issue_class = 'ROT'
						 AND issue_type  = '$rootcause[$r]'
                      GROUP BY issue_type						   
                       ";
         //print($query_root."<br>");
         $mysql_root  = mysql_query($query_root, $mysql_link) or die ("#query_root Could not query: ".mysql_error()); 
         $qry_root    = mysql_num_rows($mysql_root); 
         $root_cnt      = 0;	
         //$tot_issue_cnt = 0;
         if ($qry_root == 0){
             $root_issue[$r] = $rootcause[$r];
			 $issue_cnt[$r]  = 0;
			 $tot_issue_cnt  = $tot_issue_cnt + $issue_cnt[$r];
         } else {		 
           while($rowroot     = mysql_fetch_row($mysql_root)) {
	             //$root_cnt    = $root_cnt + 1;
                 $root_issue[$r] = trim(stripslashes($rowroot[0]));
                 $issue_cnt[$r]  = trim(stripslashes($rowroot[1]));
	       	     $tot_issue_cnt  = $tot_issue_cnt + $issue_cnt[$r];
           }
		 }
	     //for ($r=1;$r<=$root_cnt;++$r) {
	     //if ($issue_cnt[$r] == 0){
	     //    $issue_prc[$r] = 0; 
	     //} else {
	     //    $issue_prc[$r] = round(($issue_cnt[$r]/$tot_issue_cnt)*100,2);
	     //}
		 
	     for ($x=$qry0;$x>=1;$x=$x-1) {
              $query_ytd = " SELECT etl_id,ytd_count
                               FROM ".$name.".tgt_root_cause_ytd 
                              WHERE etl_year = '$yr[$x]' 
                                AND issue_type = '$rootcause[$r]' 
                          ";
			  //print($query_ytd."<br>");			  
              $mysql_ytd  = mysql_query($query_ytd, $mysql_link) or die ("#query_ytd Could not query: ".mysql_error()); 
              $qry_ytd    = mysql_num_rows($mysql_ytd);
              //$ytd_tot_iusse_cnt[$x] = 0; 
              if ($qry_ytd == 0){
                  $ytd_root_issue[$r][$x] = 0;
				  $ytd_tot_iusse_cnt[$x]  = $ytd_tot_iusse_cnt[$x] + $ytd_root_issue[$r][$x];
              }	else {		  
	     	    while($row_ytd = mysql_fetch_row($mysql_ytd)) {
                      $ytd_root_issue[$r][$x] = trim(stripslashes($row_ytd[1]));
	     		      $ytd_tot_iusse_cnt[$x]  = $ytd_tot_iusse_cnt[$x] + $ytd_root_issue[$r][$x];
				  	  //$a = $ytd_root_issue[$r][$x];
                      //print($rootcause[$r]." = ".$a."<br>");					
	     	    }
              }			  
	     }
	     //}
	}
    $y = 0;
	for ($r=1;$r<=$qry1;++$r) {
	     if ($issue_cnt[$r] == 0){
	         $issue_prc[$r] = 0; 
	     } else {
	         $issue_prc[$r] = round(($issue_cnt[$r]/$tot_issue_cnt)*100,2);
	     }
	     print("<tr>
                 <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
                   $root_issue[$r]
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
                   <!--<a href=\"javascript:void(0);\" onclick=\"popup10('../list_pdps.php?sqltyp=10&&pdptype=$pdp_prd[$pt]&&xys=$xys&&xye=$xye&&xldate=$xldate&&xldate2=$xldate2')\">-->
				    $issue_cnt[$r]<br>($issue_prc[$r]%)
				   <!--</a>-->
                  </font>
                 </td>
        "); 				
    	for ($h=$qry0;$h>=1;$h=$h-1) {
	     // Suppress Presenting beyone YTD for current and previous year
         if ($h == ($qry0-1) or $h == $qry0){     		 
		      $x_ytd_root_issue = $ytd_root_issue[$r][$h];
			  if ($x_ytd_root_issue == 0){
			      $x_issue_prc = 0; 
			  } else {
			      $x_issue_prc = round(($x_ytd_root_issue/$ytd_tot_iusse_cnt[$h])*100,2);
			  }
		      print("
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                      <font color=\"#330099\">
                       $x_ytd_root_issue<br>($x_issue_prc%)
                      </font>
                     </td>
             ");
		 } 	 
		}
		print("</tr>");
	}
    print("<tr class=\"headerRow2\">
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
				   <strong>Total</strong>
                  </font>
                 </th>
                 <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
                   <!--<a href=\"javascript:void(0);\" onclick=\"popup1('../list_pdps.php?sqltyp=1&&pdptype=$pdp_prd[$pt]&&xys=$xys&&xye=$xye&&xldate=$xldate&&xldate2=$xldate2')\">-->
				    <strong>$tot_issue_cnt<br>(100%)</strong>
				   <!--</a>-->
                  </font>
                 </th>
    "); 				
    $clrcnt = 0;
  	for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
		 print("
                     <th bgcolor=\"$colr\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                      <font color=\"#330099\">
                       <strong>$ytd_tot_iusse_cnt[$h]<br>(100%)</strong>
                      </font>
                     </th>
        ");
	 }	
    }
	print(" </tr> 
	       </table>
          </br>
          </br>		  
	");
    
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   $captnx2 = "BACK TO BUILD"; 


   $query_pdp0 = "         SELECT etl_year
                             FROM ".$name.".tgt_back_to_build_ytd 
                         GROUP BY etl_year 
                 ";
   $mysql_data0  = mysql_query($query_pdp0, $mysql_link) or die ("#query1.1 Could not query: ".mysql_error()); 
   $qry1_rows0    = mysql_num_rows($mysql_data0); 
   $qry0 = 0;                
   while($row0   = mysql_fetch_row($mysql_data0)) {
         $qry0 = $qry0 + 1;
         $yr[$qry0]  = trim(stripslashes($row0[0]));
		 $ytd_tot_b2b_cnt[$qry0] = 0;
   }

   $query_pdp1 = " SELECT distinct area
                    FROM ".$name.".tgt_back_to_build_ytd 
                 ";
   $mysql_data1  = mysql_query($query_pdp1, $mysql_link) or die ("#query1.2 Could not query: ".mysql_error()); 
   $qry1_rows1   = mysql_num_rows($mysql_data1); 
   $qry1         = 0;                
   while($row1   = mysql_fetch_row($mysql_data1)) {
         $qry1 = $qry1 + 1;
         $pdparea[$qry1] = trim(stripslashes($row1[0]));
   }

   print("<input type=\"button\" value=\"Toggle Detail Rows\" onclick=\"toggleDisplay4(document.getElementById('theTable4'))\" />");
   
   print("
          <!--<div id=\"One\" class=\"cont\">--> 
           <table id=\"theTable4\">
	        <caption>$captnx2</caption>
            <tr class=\"headerRow4\">
             <th bgcolor=\"#CCFFCC\" colspan=\"2\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
              <font color=\"#330099\">
               (YYYY-MM-DD)<br>$xldate &nbsp&nbspTO&nbsp&nbsp $xldate2
              </font>
             </th>
    ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
		 if ($h == 1){
		     $dsp_dt_range = $st_beg_dt; 
		 }
		 if ($h == $qry0){
		     $dsp_dt_range = "YTD"; 
		 }
		 if (($h <> 1) && ($h <> $qry0)){
		     $dsp_dt_range = "(YYY-MM-DD)<br>".$yr[$h]."-01-01 TO ".$yr[$h]."-12-31";
		 }
         print("<th bgcolor=\"$colr\" colspan=\"1\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
                  <font color=\"#330099\">
                   $yr[$h]<br>$dsp_dt_range
                  </font>
                 </th>
         ");
	 }	 
    }
    print("</tr>");
    print("<tr class=\"headerRow4\">
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
             <font color=\"#330099\">AREA</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
             <font color=\"#330099\">COUNT & AVERAGE</font>
            </th>
   ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
         print("<th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                 <font color=\"#330099\">COUNT & AVERAGE</font>
                </th>
         ");
	 }	 
    }
    print("</tr>");
	$tot_b2b_cnt = 0;
    for ($r=1;$r<=$qry1;++$r) {
         $query_b2b = " SELECT issue_area,sum(back_to_build)
	                       FROM ".$name.".tgt_pdp_area_execution 
                          WHERE pdp in (        
 	                           SELECT a.pdp
                                  FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c 
                                 WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye'))
                                   AND a.pdp = b.pdp AND b.short_desc  = 'UAT'
								   AND a.pdp = c.pdp AND c.short_desc  = 'RA'
                                   AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
           			                   )
						 AND issue_area  = '$pdparea[$r]'
                      GROUP BY issue_area						   
                       ";
         //print($query_rwrk."<br>");
         $mysql_b2b  = mysql_query($query_b2b, $mysql_link) or die ("#query_b2b Could not query: ".mysql_error()); 
         $qry_b2b   = mysql_num_rows($mysql_b2b); 
         $b2b_cnt      = 0;	
         if ($qry_b2b == 0){
             $issue_area[$r] = $pdparea[$r];
			 $area_b2b[$r]  = 0;
			 $tot_b2b_cnt  = $tot_b2b_cnt + $area_b2b[$r];
         } else {		 
           while($rowb2b    = mysql_fetch_row($mysql_b2b)) {
                 $issue_area[$r] = trim(stripslashes($rowb2b[0]));
                 $area_b2b[$r]  = trim(stripslashes($rowb2b[1]));
	       	     $tot_b2b_cnt   = $tot_b2b_cnt + $area_b2b[$r];
           }
		 }
	     for ($x=$qry0;$x>=1;$x=$x-1) {
              $query_ytd = " SELECT etl_id,ytd_count
                               FROM ".$name.".tgt_back_to_build_ytd 
                              WHERE etl_year = '$yr[$x]' 
                                AND area = '$pdparea[$r]' 
                          ";
			  //print($query_ytd."<br>");			  
              $mysql_ytd  = mysql_query($query_ytd, $mysql_link) or die ("#query_ytd Could not query: ".mysql_error()); 
              $qry_ytd    = mysql_num_rows($mysql_ytd);
              if ($qry_ytd == 0){
                  $ytd_b2b_cnt[$r][$x] = 0;
				  $ytd_tot_b2b_cnt[$x]  = $ytd_tot_b2b_cnt[$x] + $ytd_b2b_cnt[$r][$x];
              }	else {		  
	     	    while($row_ytd = mysql_fetch_row($mysql_ytd)) {
                      $ytd_b2b_cnt[$r][$x] = trim(stripslashes($row_ytd[1]));
	     		      $ytd_tot_b2b_cnt[$x] = $ytd_tot_b2b_cnt[$x] + $ytd_b2b_cnt[$r][$x];
	     	    }
              }			  
	     }
	}
    $y = 0;
	for ($r=1;$r<=$qry1;++$r) {
	     if ($area_b2b[$r] == 0){
	         $b2b_prc[$r] = 0; 
	     } else {
	         $b2b_prc[$r] = round(($area_b2b[$r]/$tot_b2b_cnt)*100,2);
	     }
	     print("<tr>
                 <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
                   $pdparea[$r]
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
				   $area_b2b[$r]<br>($b2b_prc[$r]%)
                  </font>
                 </td>
        "); 				
    	for ($h=$qry0;$h>=1;$h=$h-1) {
	     // Suppress Presenting beyone YTD for current and previous year
         if ($h == ($qry0-1) or $h == $qry0){     		 
		      $x_ytd_b2b_cnt = $ytd_b2b_cnt[$r][$h];
			  if ($x_ytd_b2b_cnt == 0){
			      $x_b2b_prc = 0; 
			  } else {
			      $x_b2b_prc = round(($x_ytd_b2b_cnt/$ytd_tot_b2b_cnt[$h])*100,2);
			  }
		      print("
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                      <font color=\"#330099\">
                       $x_ytd_b2b_cnt<br>($x_b2b_prc%)
                      </font>
                     </td>
             ");
		 }	 
		}
		print("</tr>");
	}
    print("<tr class=\"headerRow4\">
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
             <font color=\"#330099\">
		      <strong>Total</strong>
             </font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
             <font color=\"#330099\">
      		  <strong>$tot_b2b_cnt<br>(100%)</strong>
             </font>
            </th>
    "); 				
    $clrcnt = 0;
  	for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
		 print("
                <th bgcolor=\"$colr\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                 <font color=\"#330099\">
                  <strong>$ytd_tot_b2b_cnt[$h]<br>(100%)</strong>
                 </font>
                </th>
        ");
	 }	
    }
	print("    </tr>
              </table>
          </br>
          </br>		  
	");


   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   $captnx2 = "REWORK EFFORT"; 


   $query_pdp0 = "         SELECT etl_year
                             FROM ".$name.".tgt_rework_hours_ytd 
                         GROUP BY etl_year 
                 ";
   $mysql_data0  = mysql_query($query_pdp0, $mysql_link) or die ("#query1.1 Could not query: ".mysql_error()); 
   $qry1_rows0    = mysql_num_rows($mysql_data0); 
   $qry0 = 0;                
   while($row0   = mysql_fetch_row($mysql_data0)) {
         $qry0 = $qry0 + 1;
         $yr[$qry0]  = trim(stripslashes($row0[0]));
		 $ytd_tot_rwrk_hrs[$qry0] = 0;
   }

   $query_pdp1 = " SELECT distinct area
                     FROM ".$name.".tgt_rework_hours_ytd 
                 ";
   $mysql_data1  = mysql_query($query_pdp1, $mysql_link) or die ("#query1.2 Could not query: ".mysql_error()); 
   $qry1_rows1   = mysql_num_rows($mysql_data1); 
   $qry1         = 0;                
   while($row1   = mysql_fetch_row($mysql_data1)) {
         $qry1 = $qry1 + 1;
         $pdparea[$qry1] = trim(stripslashes($row1[0]));
   }

   print("<input type=\"button\" value=\"Toggle Detail Rows\" onclick=\"toggleDisplay3(document.getElementById('theTable3'))\" />");
   
   print("
          <!--<div id=\"One\" class=\"cont\">--> 
           <table id=\"theTable3\">
	        <caption>$captnx2</caption>
            <tr class=\"headerRow3\">
             <th bgcolor=\"#CCFFCC\" colspan=\"2\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
              <font color=\"#330099\">
               (YYYY-MM-DD)<br>$xldate &nbsp&nbspTO&nbsp&nbsp $xldate2<br>
              </font>
             </th>
    ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
		 if ($h == 1){
		     $dsp_dt_range = $st_beg_dt; 
		 }
		 if ($h == $qry0){
		     $dsp_dt_range = "YTD"; 
		 }
		 if (($h <> 1) && ($h <> $qry0)){
		     $dsp_dt_range = "(YYY-MM-DD)<br>".$yr[$h]."-01-01 TO ".$yr[$h]."-12-31";
		 }
         print("<th bgcolor=\"$colr\" colspan=\"1\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
                  <font color=\"#330099\">
                   $yr[$h]<br>$dsp_dt_range
                  </font>
                 </th>
         ");
	 }	 
    }
    print("</tr>");
    print("<tr class=\"headerRow3\">
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200x;\">
             <font color=\"#330099\">AREA</font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
             <font color=\"#330099\">HRS : MINS</font>
            </th>
   ");
    $clrcnt = 0;
    for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
         if ($clrcnt == 2){
             $clrcnt = 0;
         }
         print("<th bgcolor=\"$colr\" align=\"center\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                 <font color=\"#330099\">HRS : MINS</font>
                </th>
         ");
	 }	 
    }
    print("</tr>");
	$tot_rwrk_hrs = 0;
    for ($r=1;$r<=$qry1;++$r) {
         $query_rwrk = " SELECT issue_area,sum(rework_hours)
	                       FROM ".$name.".tgt_pdp_area_work_effort
                          WHERE pdp in (        
 	                           SELECT a.pdp
                                  FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c 
                                 WHERE a.etl_id in (select etl_id from ".$name.".etl_batches where etl_year in ('$xys','$xye'))
                                   AND a.pdp = b.pdp AND b.short_desc  = 'UAT'
								   AND a.pdp = c.pdp AND c.short_desc  = 'RA'
                                   AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
           			                   )
						 AND issue_area  = '$pdparea[$r]'
                      GROUP BY issue_area						   
                       ";
         //print($query_rwrk."<br>");
         $mysql_rwrk  = mysql_query($query_rwrk, $mysql_link) or die ("#query_rwrk Could not query: ".mysql_error()); 
         $qry_rwrk    = mysql_num_rows($mysql_rwrk); 
         $rwrk_hrs      = 0;	
         if ($qry_rwrk == 0){
             $issue_area[$r] = $pdparea[$r];
			 $area_rwrk[$r]  = 0;
			 $tot_rwrk_hrs  = $tot_rwrk_hrs + $area_rwrk[$r];
         } else {		 
           while($rowrwrk     = mysql_fetch_row($mysql_rwrk)) {
                 $issue_area[$r] = trim(stripslashes($rowrwrk[0]));
                 $area_rwrk[$r]  = trim(stripslashes($rowrwrk[1]));   //intval(trim(stripslashes($rowrwrk[1]))/60);
	       	     $tot_rwrk_hrs   = $tot_rwrk_hrs + $area_rwrk[$r];
           }
		 }
	     for ($x=$qry0;$x>=1;$x=$x-1) {
              $query_ytd = " SELECT etl_id,ytd_count_rework
                               FROM ".$name.".tgt_rework_hours_ytd 
                              WHERE etl_year = '$yr[$x]' 
                                AND area = '$pdparea[$r]' 
                          ";
			  //print($query_ytd."<br>");			  
              $mysql_ytd  = mysql_query($query_ytd, $mysql_link) or die ("#query_ytd Could not query: ".mysql_error()); 
              $qry_ytd    = mysql_num_rows($mysql_ytd);
              if ($qry_ytd == 0){
                  $ytd_rwrk_hrs[$r][$x] = 0;
				  $ytd_tot_rwrk_hrs[$x]  = $ytd_tot_rwrk_hrs[$x] + $ytd_rwrk_hrs[$r][$x];
              }	else {		  
	     	    while($row_ytd = mysql_fetch_row($mysql_ytd)) {
                      $ytd_rwrk_hrs[$r][$x] = trim(stripslashes($row_ytd[1]));
	     		      $ytd_tot_rwrk_hrs[$x] = $ytd_tot_rwrk_hrs[$x] + $ytd_rwrk_hrs[$r][$x];
	     	    }
              }			  
	     }
	}
    $y = 0;
	for ($r=1;$r<=$qry1;++$r) {
	    if ($area_rwrk[$r] == 0){
	         $rwrk_prc[$r] = 0; 
	     } else {
	         $rwrk_prc[$r] = round(($area_rwrk[$r]/$tot_rwrk_hrs)*100,2);
		}
	    $y_area_rwrk_hrs[$r]    = intval($area_rwrk[$r]);                    //derives hours 
        $y_area_rwrk_mins[$r]   = $area_rwrk[$r] - $y_area_rwrk_hrs[$r];     //derives fraction that represents minutes
		$u_area_rwrk_mins[$r]   = round(($y_area_rwrk_mins[$r]*60),0);
		$la_area_rwrk_hrs[$r]   = strlen($y_area_rwrk_hrs[$r]);
		$la_area_rwrk_mins[$r]  = 2 - strlen($u_area_rwrk_mins[$r]);
		if ($la_area_rwrk_hrs[$r] == 0){
		    $lb_area_rwrk_hrs[$r] = "00";
		} else {
		  if ($la_area_rwrk_hrs[$r] == 1){
		      $lb_area_rwrk_hrs[$r] = "0".$y_area_rwrk_hrs[$r];
		  } else {
              $lb_area_rwrk_hrs[$r] = $y_area_rwrk_hrs[$r];
          }		  
        }
		if ($la_area_rwrk_mins[$r] == 0){
		    $lb_area_rwrk_mins[$r] = $u_area_rwrk_mins[$r];
		} else {		
			if($la_area_rwrk_mins[$r] == 2){
			   $lb_area_rwrk_mins[$r] = "00"; //$u_area_rwrk_mins[$r]; 
			}
			if($la_area_rwrk_mins[$r] == 1){
			   $lb_area_rwrk_mins[$r] = "0".$u_area_rwrk_mins[$r]; 
			}
        }		
	     print("<tr>
                 <td bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
                   $pdparea[$r]
                  </font>
                 </td>
                 <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                  <font color=\"#330099\">
				   $lb_area_rwrk_hrs[$r] : $lb_area_rwrk_mins[$r]<br>($rwrk_prc[$r]%)
                  </font>
                 </td>
        "); 				
    	for ($h=$qry0;$h>=1;$h=$h-1) {
	     // Suppress Presenting beyone YTD for current and previous year
         if ($h == ($qry0-1) or $h == $qry0){     		 
		     $x_ytd_rwrk_hrs = $ytd_rwrk_hrs[$r][$h];
			 if ($x_ytd_rwrk_hrs == 0){
			     $x_rwrk_prc = 0; 
			 } else {
			     $x_rwrk_prc = round(($x_ytd_rwrk_hrs/$ytd_tot_rwrk_hrs[$h])*100,2);
			 }
	         $y_ytd_rwrk_hrs[$r][$h]    = intval($ytd_rwrk_hrs[$r][$h]);                       //derives hours 
             $y_ytd_rwrk_mins[$r][$h]   = $ytd_rwrk_hrs[$r][$h]- $y_ytd_rwrk_hrs[$r][$h];     //derives fraction that represents minutes
		     $u_ytd_rwrk_mins[$r][$h]   = round(($y_ytd_rwrk_mins[$r][$h]*60),0);
		     $la_ytd_rwrk_hrs[$r][$h]   = strlen($y_ytd_rwrk_hrs[$r][$h]);
		     $la_ytd_rwrk_mins[$r][$h]  = 2 - strlen($u_ytd_rwrk_mins[$r][$h]);
		     if ($la_ytd_rwrk_hrs[$r][$h]  == 0){
		         $lb_ytd_rwrk_hrs[$r][$h]  = "00";
		     } else {
		   	   if ($la_ytd_rwrk_hrs[$r][$h] == 1){
		  	       $lb_ytd_rwrk_hrs[$r][$h] = "0".$y_ytd_rwrk_hrs[$r][$h];
		   	   } else {
                   $lb_ytd_rwrk_hrs[$r][$h] = $y_ytd_rwrk_hrs[$r][$h];     
               }			   
             }
		     if ($la_ytd_rwrk_mins[$r][$h] == 0){
		         $lb_ytd_rwrk_mins[$r][$h] = $u_ytd_rwrk_mins[$r][$h];
		     } else {		
		   	     if ($la_ytd_rwrk_mins[$r][$h] == 2){
		   	         $lb_ytd_rwrk_mins[$r][$h] = "00"; //$u_ytd_rwrk_mins[$r][$h];
		   	     } 
		   	     if ($la_ytd_rwrk_mins[$r][$h] == 1){
		  	          $lb_ytd_rwrk_mins[$r][$h] = "0".$u_ytd_rwrk_mins[$r][$h];
		   	     } 
             }
             $lb_hrs  =   $lb_ytd_rwrk_hrs[$r][$h];
             $lb_mins =   $lb_ytd_rwrk_mins[$r][$h];			 
		      print("
                     <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                      <font color=\"#330099\">
                       $lb_hrs : $lb_mins<br>($x_rwrk_prc%)
                      </font>
                     </td>
             ");
		 }	 
		}
		print("</tr>");
	}
	///////////////////////////////////////
	         $y_tot_rwrk_hrs    = intval($tot_rwrk_hrs);               //derives hours 
             $y_tot_rwrk_mins   = $tot_rwrk_hrs - $y_tot_rwrk_hrs;     //derives fraction that represents minutes
		     $u_tot_rwrk_mins   = round(($y_tot_rwrk_mins*60),0);
			 /////////////////////////////////////////////////////print($y_tot_rwrk_hrs." - ".$u_tot_rwrk_mins."<br>");
		     $la_tot_rwrk_hrs   = strlen($y_tot_rwrk_hrs);
		     $la_tot_rwrk_mins  = 2 - strlen($u_tot_rwrk_mins);
		     if ($la_tot_rwrk_hrs  == 0){
		         $lb_tot_rwrk_hrs  = $y_tot_rwrk_hrs."0";
		     } else {
		   	   if ($la_tot_rwrk_hrs  == 1){
		  	       $lb_tot_rwrk_hrs = "0".$y_tot_rwrk_hrs;
		   	   } else {
                   $lb_tot_rwrk_hrs = $y_tot_rwrk_hrs;     
               }			   
             }
		     if ($la_tot_rwrk_mins == 0){
		         $lb_tot_rwrk_mins = $u_tot_rwrk_mins;
		     } else {
		   	     if ($la_tot_rwrk_mins == 2){
		   	         $lb_tot_rwrk_mins = "00"; //$u_ytd_rwrk_mins[$r][$h];
		   	     } 
		   	     if ($la_tot_rwrk_mins == 1){
		  	          $lb_tot_rwrk_mins = "0".$u_tot_rwrk_mins;
		   	     } 
             }
             $lt_hrs  =   $lb_tot_rwrk_hrs;
             $lt_mins =   $lb_tot_rwrk_mins;			 
	///////////////////////////////////////
	//$tot_rwrk_hrs
    print("<tr class=\"headerRow3\">
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
             <font color=\"#330099\">
		      <strong>Total</strong>
             </font>
            </th>
            <th bgcolor=\"#CCFFCC\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
             <font color=\"#330099\">
      		  <strong>$lt_hrs : $lt_mins <br>(100%)</strong>
             </font>
            </th>
    "); 				
    $clrcnt = 0;
  	for ($h=$qry0;$h>=1;$h=$h-1) {
	 // Suppress Presenting beyone YTD for current and previous year
     if ($h == ($qry0-1) or $h == $qry0){     		 
         $clrcnt = $clrcnt + 1;
         if ($clrcnt == 1){
             $colr = "#ECE5B6";
         } else {
             $colr = "#FFF8C6";
         }
	     ///////////////////////////////////////
	         $y_ytd_tot_rwrk_hrs[$h]   = intval($ytd_tot_rwrk_hrs[$h]);                       //derives hours 
             $y_ytd_tot_rwrk_mins[$h]  = $ytd_tot_rwrk_hrs[$h] - $y_ytd_tot_rwrk_hrs[$h];     //derives fraction that represents minutes
		     $u_ytd_tot_rwrk_mins[$h]  = round(($y_ytd_tot_rwrk_mins[$h]*60),0);
			 //print($y_tot_rwrk_hrs." - ".$u_tot_rwrk_mins."<br>");
		     $la_ytd_tot_rwrk_hrs[$h]   = strlen($y_ytd_tot_rwrk_hrs[$h]);
		     $la_ytd_tot_rwrk_mins[$h]  = 2 - strlen($u_ytd_tot_rwrk_mins[$h]);
		     if ($la_ytd_tot_rwrk_hrs[$h]  == 0){
		         $lb_ytd_tot_rwrk_hrs[$h]  = $y_ytd_tot_rwrk_hrs[$h]."0";
		     } else {
		   	   if ($la_ytd_tot_rwrk_hrs[$h]  == 1){
		  	       $lb_ytd_tot_rwrk_hrs[$h] = "0".$y_ytd_tot_rwrk_hrs[$h];
		   	   } else {
                   $lb_ytd_tot_rwrk_hrs[$h] = $y_ytd_tot_rwrk_hrs[$h];     
               }			   
             }
		     if ($la_ytd_tot_rwrk_mins[$h] == 0){
		         $lb_ytd_tot_rwrk_mins[$h] = $u_ytd_tot_rwrk_mins[$h];
		     } else {		
		   	     if ($la_ytd_tot_rwrk_mins[$h] == 2){
		   	         $lb_ytd_tot_rwrk_mins[$h] = "00"; //$u_ytd_rwrk_mins[$r][$h];
		   	     } 
		   	     if ($la_ytd_tot_rwrk_mins[$h] == 1){
		  	         $lb_ytd_tot_rwrk_mins[$h] = "0".$u_ytd_tot_rwrk_mins[$h];
		   	     } 
             }
             $lytdt_hrs  =   $lb_ytd_tot_rwrk_hrs[$h];
             $lytdt_mins =   $lb_ytd_tot_rwrk_mins[$h];			 
	     ///////////////////////////////////////
		 //$ytd_tot_rwrk_hrs[$h]
		 print("
                <th bgcolor=\"$colr\" align=\"center\" valign=\"middle\" style=\"width: 200px;\">
                 <font color=\"#330099\">
                  <strong>$lytdt_hrs : $lytdt_mins<br>(100%)</strong>
                 </font>
                </th>
        ");
	 }	
    }
	print(" </tr>
	       </table>
          </div>
         </div>   			  
        </br>
        </br>		  
	");


   $xfilters = "LAUNCH DATE BETWEEN ".$xldate." AND ".$xldate2;
   $xreport_name = "PDP_SLT_REPORT"; 
   //var_dump($xreport_contents); 
   $query99      = " INSERT into ".$name.".saved_reports(report_name,filters,etl_id,ran_by) 
                     VALUES('$xreport_name','$xfilters','$yetl_id','$usr')"; 
   $mysql_data99 = mysql_query($query99, $mysql_link) or die ("#insert saved_reports - Could not query: ".mysql_error());
   $savedrepid   = mysql_insert_id();
   $xreport_path = $xreport_pth.$savedrepid."-".$xreport_nam;
   $query100      = " UPDATE ".$name.".saved_reports
                         SET report_path = '$xreport_path' 
                       WHERE saved_report_id = '$savedrepid' "; 
   $mysql_data100 = mysql_query($query100, $mysql_link) or die ("#update saved_reports - Could not query: ".mysql_error());
   $loc  =  $_SERVER['REQUEST_URI'];
   //print($loc."<br>");
   $locx = substr($loc,0,-15);
   //print($locx."<br>");   
   $pagelink = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$locx."/reports/". $savedrepid."-".$xreport_nam;             //getenv('REQUEST_URI');
   print("               <table>
                          <tr>
                           <th bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">LOCATION</font>
                           </th>
                           <th bgcolor=\"#FFFFFF\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:600px;\">
                            <font color=\"#000000\">$pagelink</font>
                           </th>
                          </tr>
   						 </table> 
   ");
   $xreport_contents = ob_get_clean();
   //$replen = strlen($xreport_contents);
   //print($xreport_contents);
   $f = fopen($xreport_path, "w+") or die ("could not open file.");
   fwrite($f, $xreport_contents) or die ("could not write to file");
   fclose($f);
   $found = 0;
   $start = 0;
} else {
  // ------------ //
  $found = 0;
  ob_end_clean();
  // ------------ //
}
// ================================================================================================================
// ================================================================================================================
if ($found == 0) {
    if ($start <> 1){
        print($hstart);
    }
    $query1      = " select max(etl_id)
                       from ".$name.".etl_batches ";  
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1     = mysql_num_rows($mysql_data1);
    //print("$query1"."<br>".$rowcnt1."<br>");
    while($row1 = mysql_fetch_row($mysql_data1)) {
	         $yetl_id = stripslashes($row1[0]);
    }

    //$ind[0]    = "ALL";
    $ind[1]      = "YES";
    $ind[2]      = "NO";
    //$ind_id[0] = 0;
    $ind_id[1]   = 1;
    $ind_id[2]   = 0;

    // PDP Type
    //$queryt = "select distinct(pdp_type) from ".$name.".cube1_main";
    $queryt = "select distinct(pdp_period) from ".$name.".pdp_periods";
    $mysql_datat = mysql_query($queryt, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcntt = mysql_num_rows($mysql_datat); 
    $prdcnt = 0;
    while($rowt = mysql_fetch_row($mysql_datat)) {
          $prdcnt            = $prdcnt + 1;
          $pdp_prd           = stripslashes($rowt[0]);
          $xpdp_prd[$prdcnt] = $pdp_prd;
    }
    $captn = "Select Criteria";
    print("<form method=\"post\" action=\"./report_slt.php\">
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
    ");        
    //        <tr>
    //         <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
    //          <font color=\"#330099\">Select PDP Type:</font>
    //         </td>
    //         <td> 
    //          <select name=\"prd\">
    //");
    //$p = 0;
    //print("<option selected value=\"ALL\">ALL</option>");
    //for ($p=1;$p<=$prdcnt ; ++$p) {
    //    print("<option value=\"$xpdp_prd[$p]\">$xpdp_prd[$p]</option>");
    //}     
    //print("
    //          </select>
    //         </td>
    //        </tr>
    //        <tr>
    //         <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
    //          <font color=\"#330099\">
    //           RA Testing:
    //          </font>
    //         </td>
    //         <td align=\"left\" valign=\"middle\">
    //          <select align=\"left\" name=\"ra_ind\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
    //");
    //$e = 0;
    //print(" <option selected value=\"BOTH\">BOTH</option> ");
    //for ($e=1;$e<=2; ++$e) {
    //     print(" <option value=\"$ind[$e]\">$ind[$e]</option> "); 
    //}                         
    //print("   </select>
    //         <input type=\"hidden\" name=\"yshort_desc\" value=\"RA\"> 
    //         </td>
    //");         
    ////$queryt1       = "select distinct(pdp_category) 
    ////                    from ".$name.".cube1_main
    ////                   where pdp_category <> '' ";
    //$queryt1       = "select concat(c.category_scope,' - ',p.pdp_category) as pdpcat 
    //                    from ".$name.".pdp_categories p, category_scope c
    //                   where p.category_scope_id = c.category_scope_id 
    //                group by c.category_scope,p.pdp_category ";
    //$mysql_datat1  = mysql_query($queryt1, $mysql_link) or die ("Could not query: ".mysql_error());
    //$rowcnt1       = mysql_num_rows($mysql_datat1); 
    //$catcnt        = 0;
    //while($rowt1 = mysql_fetch_row($mysql_datat1)) {
    //      $catcnt            = $catcnt + 1;
    //      $pdpcat            = stripslashes($rowt1[0]);
    //      $xpdpcat[$catcnt] = $pdpcat;
    //}
    //print(" <tr>
    //         <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
    //          <font color=\"#330099\">Select PDP Category:</font>
    //         </td>
    //         <td> 
    //          <select name=\"pdpcat\">
    //");
    //$c = 0;
    //print("<option selected value=\"ALL\">ALL</option>");
    //for ($c=1;$c<=$catcnt ; ++$c) {
    //    print("<option value=\"$xpdpcat[$c]\">$xpdpcat[$c]</option>");
    //}     
    //print("
    //          </select>
    //         </td>
    //        </tr>
    $yyr  = date("Y");
	//print($yyr."<br>");
    print(" 
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\"><font color=\"#330099\">Launch Date (dd-mm-yyyy)</font></td>
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:300px;\">
              <font color=\"#330099\">
    ");
    $yms = 1;
    print(" <select align=\"left\" name=\"xds\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
         if ($yds == $xdy_s) {
             print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
         } else {
             print(" <option value=\"$xdy_s\">$xdy_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xms\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
         if ($yms == $xmon_s) {
             print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
         } else {
             print(" <option value=\"$xmon_s\">$xmon_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xys\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xyr_s=2010;$xyr_s<=2015; ++$xyr_s) {
         if ($yyr == $xyr_s) {
             print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
         } else {
             print(" <option value=\"$xyr_s\">$xyr_s</option> ");
         }
    }
    print("    
               </font>
              </select>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\"><font color=\"#330099\">Launch Date (dd-mm-yyyy)</font></td>
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:300px;\">
              <font color=\"#330099\">
    ");
    print(" <select align=\"left\" name=\"xde\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xdy_s=1;$xdy_s<=31; ++$xdy_s) {
         if ($yds == $xdy_s) {
             print(" <option selected value=\"$xdy_s\">$xdy_s</option> ");
         } else {
             print(" <option value=\"$xdy_s\">$xdy_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xme\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xmon_s=1;$xmon_s<=12; ++$xmon_s) {
         if ($yms == $xmon_s) {
             print(" <option selected value=\"$xmon_s\">$xmon_s</option> ");
         } else {
             print(" <option value=\"$xmon_s\">$xmon_s</option> ");
         }
    }
    print(" </select> ");
    print(" <select align=\"left\" name=\"xye\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
    for ($xyr_s=2010;$xyr_s<=2015; ++$xyr_s) {
         if ($yyr == $xyr_s) {
             print(" <option selected value=\"$xyr_s\">$xyr_s</option> ");
         } else {
             print(" <option value=\"$xyr_s\">$xyr_s</option> ");
         }
    }
    print("    
               </font>
              </select>
             </td>
            </tr>
            <tr>
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
              <input type=\"hidden\" name=\"yetl_id\" value=\"$yetl_id\">
             </td>
            </tr>
           </table>
          </form>  
           <br><br>
   ");
  
   $captn = "Saved Reports";

   if ($submit == "Submit") {
	while (list($key) = each($delete)) {
		   $query = "DELETE FROM ".$name.".saved_reports WHERE saved_report_id = '$key' ";
		   $mysql_data = mysql_query($query, $mysql_link);
		   unlink($delfile[$key]);
	}
   }

   print("<form method=\"post\" action=\"./report_slt.php\"> 
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
              <tr>
               <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">ID</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Pathname</font</td>-->
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width: 400px;\"><font color=\"#330099\">Ran Date</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Ran By</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Extract</font</td>-->
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
              </tr>
   ");

   $query = "  select saved_report_id,report_name,filters,report_path,etl_id,report_timestamp,ran_by from ".$name.".saved_reports
                where rtrim(report_name) = 'PDP_SLT_REPORT'
                  and ran_by = '$usr'
             order by filters,report_timestamp desc"; 
             //and etl_id = '$yetl_id'  
   $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcnt = mysql_num_rows($mysql_data); 

   $seq = 0;
   while($row = mysql_fetch_row($mysql_data)) {
    $seq                     = $seq + 1;
	$wid[$seq]               = stripslashes($row[0]);
    $wreport_name[$seq]      = stripslashes($row[1]);
	$wfilters[$seq]          = stripslashes($row[2]);
	$wreport_path[$seq]      = stripslashes($row[3]);
	$wreport_path2[$seq]     = str_replace("./reports/","",$wreport_path[$seq]);
	$wetl_id[$seq]           = stripslashes($row[4]);
	$wreport_timestamp[$seq] = stripslashes($row[5]);
	$wran_by[$seq]           = stripslashes($row[6]);
    $save_id                 = $wid[$seq];
    $del_file                = $wreport_path[$seq];
    
    $query0      = "select etl_timestamp
                      from ".$name.".etl_monitor
                     where etl_id = '$wetl_id[$seq]' ";  
    $mysql_data0 = mysql_query($query0, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt0     = mysql_num_rows($mysql_data0);
    while($row0 = mysql_fetch_row($mysql_data0)) {
          $yetl_timestamp = stripslashes($row0[0]);
    }
    
    $seq1 = $seq - 1;
    if (($seq <> 0) && ($wfilters[$seq] <> $wfilters[$seq1])){
	print("   <tr>
	            <td colspan=\"6\" align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#000000\"> 
                  $wfilters[$seq]
                 </font>   
	            </td>
	          </tr>  
    ");    
    }
	print("   <tr>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\">
                 $seq 
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
	             <font color=\"#330099\"> 
                  $wid[$seq]
                 </font>   
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width: 400px;\">
	             <font color=\"#330099\">
                  <a href=\"javascript:void(0);\" onclick=\"PopupCenter('$wreport_path[$seq]', 'myPop1',1200,800);\">$wreport_path2[$seq]</a>
                 </font>  	             
	            </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                  $wran_by[$seq]
                 </font>  	             
	            </td>
	            <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                  $yetl_timestamp
                 </font>  	             
	            </td>-->
                <td align=\"center\" bgcolor=\"#E8E8E8\">
                 <input type=\"checkbox\" name=\"delete[$save_id]\" value=\"Delete\">
                 <input type=\"hidden\" name=\"delfile[$save_id]\" value=\"$del_file\">
                </td>
	          </tr>
	     ");
   }
      
   print(" </table>           
            <input type=\"submit\" name=\"submit\" value=\"Submit\">
            <input type=\"hidden\" name=\"start\" value=\"0\">
          </form>  
    "); 
}
//var_dump();
print("  </body>
       </html>
");
mysql_close($mysql_link);
?>
