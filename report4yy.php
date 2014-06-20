<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);




// REINDEX
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
$querysa1 = "ALTER TABLE ".$name.".issue_surrogates ENGINE='InnoDB'" ;
$mysql_dataa1 = mysql_query($querysa1, $mysql_link) or die ("#a1 Could not query: ".mysql_error());
//print("Reindex of issue_surrogates done<br>");

$querysa2 = "ALTER TABLE ".$name.".issue_types ENGINE='InnoDB'" ;
$mysql_dataa2 = mysql_query($querysa2, $mysql_link) or die ("#a2 Could not query: ".mysql_error());
//print("Reindex of issue_types done<br>");

$querysa3 = "ALTER TABLE ".$name.".issue_class ENGINE='InnoDB'" ;
$mysql_dataa3 = mysql_query($querysa3, $mysql_link) or die ("#a3 Could not query: ".mysql_error());
//print("Reindex of issue_class done<br>");

$querysa4 = "ALTER TABLE ".$name.".issues ENGINE='InnoDB'" ;
$mysql_dataa4 = mysql_query($querysa4, $mysql_link) or die ("#a4 Could not query: ".mysql_error());
//print("Reindex of issues done<br>");

$querysa5 = "ALTER TABLE ".$name.".issue_history ENGINE='InnoDB'" ;
$mysql_dataa5 = mysql_query($querysa5, $mysql_link) or die ("#a5 Could not query: ".mysql_error());
//print("Reindex of issue_history done<br>");

$querysa6 = "ALTER TABLE ".$name.".milestone_surrogates ENGINE='InnoDB'" ;
$mysql_dataa3 = mysql_query($querysa6, $mysql_link) or die ("#a6 Could not query: ".mysql_error());
//print("Reindex of milestone_surrogates done<br>");

$querysa7 = "ALTER TABLE ".$name.".pdp ENGINE='InnoDB'" ;
$mysql_dataa7 = mysql_query($querysa7, $mysql_link) or die ("#a7 Could not query: ".mysql_error());
//print("Reindex of pdp done<br>");

$querysa8 = "ALTER TABLE ".$name.".pdp_execution ENGINE='InnoDB'" ;
$mysql_dataa8 = mysql_query($querysa8, $mysql_link) or die ("#a8 Could not query: ".mysql_error());
//print("Reindex of pdp_execution done<br>");

$querysa9 = "ALTER TABLE ".$name.".pdp_stlc ENGINE='InnoDB'" ;
$mysql_dataa9 = mysql_query($querysa9, $mysql_link) or die ("#a9 Could not query: ".mysql_error());
//print("Reindex of pdp_stlc done<br>");
//print("<br>");
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////








// CONTROL VARIABLES
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
$querys5 = "SELECT user FROM ".$name.".sessions
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
        
              //print($yissue_area_id);
       }         
}
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
$yentry_dt  = mktime(0,0,0,$ym,$yd,$yy);
$ym         = date("M");
$ydate      = $yw." ".$yd."-".$ym."-".$yy;
$ydate2     = $yw." ".$yd."-".$ym."-".$yy." ".$yt;
$ydate3     = $yw."-".$yd."-".$ym."-".$yy."-".$yt2;
$xreport_pth = "./reports/";
$xreport_nam = "FULL EXTRACT-".$ydate3.".htm";
//print ($reportname); 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////









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
                    function popup(url) 
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
                     newwin=window.open(url,'windowname5', params);
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
            </head>
            <body>
    "; 
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////








// LOGIC START
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
if ($start == 1) {

   // ------------------------------------------------------------------------------------------------------------ //
   ob_start();
   print($hstart);
   // ------------------------------------------------------------------------------------------------------------ //









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
   //print($prd."<br>".$fltr1."<br>");  
   //print($pdpcat."<br>".$fltr3."<br>");
   // setting up today's date
   $newd  = date("d");   //day
   $newm  = date("m");   //month
   $newy  = date("Y");   //year
   // 30 days from today
   $new_dt = mktime(0,0,0,$newm,$newd,$newy) + (60*60*24*30);
   $newd  = date("d",$new_dt);   //day
   $newm  = date("m",$new_dt);   //month
   $newy  = date("Y",$new_dt);   //year
   $today_dt = $newy."-".$newm."-".$newd;
   //print("Today's date :".$today_dt."<br>"); 
   $fromdt = mktime(0,0,0,$xms,$xds,$xys);
   $todate = mktime(0,0,0,$xme,$xde,$xye);
   if (($fromdt == $todate) && ($fromdt == 1283313600)){
        $xldate  = "2010-09-01";
        $xldate2 = $today_dt;
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
    } else {
       $xldate2 = $xldate;
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

   //print($xds."<br>");
   //print($xms."<br>");
   
   //print($xys."<br>"); 
   //print("From Date: ".$xldate."<br>"."To Date: ".$xldate2."<br>");
   // ===============================================================













   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =========================== LOAD PDP ARRAY ==========================
   //                            0 'tgt_pdp_main'       as 'DUMMY',
   //                            1 @rownum:=@rownum+1   as 'NO',
   //                            2 a.pdp                as 'PDP',
   //                            3 a.pdp_desc           as 'DESCRIPTION',
   //                            4 a.pdp_owner          as 'OWNER',
   //                            5 a.pdp_type           as 'TYPE',
   //                            6 a.pdp_status         as 'STATUS',
   //                            7 a.pdp_launch         as 'LAUNCH',
   //                            8 a.parent_pdp         as 'PARENT',
   //                            9 a.main_pdp           as 'MAIN',
   //                           10 a.scoping            as 'SCOPE',
   //                           11 a.pdp_category       as 'CATEGORY',
   //                           12 a.complexity_factor  as 'COMPLEIXTY',
   //                           13 a.revenue_factor     as 'REVENUE IMPACT',
   //                           14 a.customer_factor    as 'CUSTOMER IMPACT',
   //                           15 a.past_factor        as 'PAST PERFORMANCE',
   //                           16 a.bills_run          as 'BILL RUNS',
   //                           17 a.invoices_generated as 'INVOICE GENERATED',
   //                           18 a.ppw_changes        as 'PPW CHANGES',
   //                           19 a.launch_in_jeopardy as 'LAUNCH IN JEOPARDY',
   //                           20 a.issues_created     as 'ISSUES CREATED',
   //                           21 b.tested             as 'UAT TESTED',
   //                           22 c.tested             as 'RA TESTED',
   //                           23 1                    as 'FILTER' 
   //$cnd1 = "HIGH";
   //$cnd2 = "MEDIUM";
   //$cnd3 = "LOW";
   $queryv1       = "  set @rownum  = 0";
   $mysql_datav1  = mysql_query($queryv1, $mysql_link) or die ("#queryv1 Could not query: ".mysql_error());       
   $querypdp      = "  select 'tgt_pdp_main'                    as 'DUMMY',
                              @rownum:=@rownum+1                as 'NO',
                              a.pdp                             as 'PDP',
                              a.pdp_desc                        as 'DESCRIPTION',
                              a.pdp_owner                       as 'OWNER',
                              a.pdp_type                        as 'TYPE',
                              a.pdp_status                      as 'STATUS',
                              a.pdp_launch                      as 'LAUNCH',
                              a.parent_pdp                      as 'PARENT',
                              a.main_pdp                        as 'MAIN',
                              a.scoping                         as 'SCOPE',
                              upper(rtrim(a.pdp_category))      as 'CATEGORY',
                              upper(rtrim(a.complexity_factor)) as 'COMPLEIXTY',
                              upper(rtrim(a.revenue_factor))    as 'REVENUE IMPACT',
                              upper(rtrim(a.customer_factor))   as 'CUSTOMER IMPACT',
                              upper(rtrim(a.past_factor))       as 'PAST PERFORMANCE',
                              a.bills_run                       as 'BILL RUNS',
                              a.invoices_generated              as 'INVOICE GENERATED',
                              a.ppw_changes                     as 'PPW CHANGES',
                              a.launch_in_jeopardy              as 'LAUNCH IN JEOPARDY',
                              a.issues_created                  as 'TOTAL ISSUES CREATED',
                              b.tested                          as 'UAT TESTED',
                              c.tested                          as 'RA TESTED',
                              1                                 as 'FILTER'  
                         from ".$name.".tgt_pdp_main a ,".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c  
                        where a.etl_id = '$yetl_id' 
                          and trim(a.pdp_status) <> 'Cancelled'
                          and (a.pdp_launch >= '2010-09-01' or (a.pdp_launch = '0000-00-00' and a.issues_created <> 0))
                          and ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01')) 
                          and (a.pdp = b.pdp and b.short_desc = 'UAT' and b.etl_id = '$yetl_id') 
                          and (a.pdp = c.pdp and c.short_desc = 'RA'  and c.etl_id = '$yetl_id') 
                   ";
   //print($querypdp."<br>");                
   $mysql_datap  = mysql_query($querypdp, $mysql_link) or die ("#querypdp Could not query: ".mysql_error());
   $pdp_rows     = mysql_num_rows($mysql_datap);
   $pcol         = mysql_num_fields($mysql_datap)-1;    // subtracting field/column at [0] i.e the DUMMY field/column                      
   $total_pdp    = 0;
   //$pcol_supress = 2;        // No. of columns not need displayed
   //print($pdp_rows." Rows <br>");
   //print($pcol." Columns <br>");
   $pc3a        = 0;  // columns not displayed
   while($rowp  = mysql_fetch_row($mysql_datap)) {
         $total_pdp = $total_pdp + 1;
         //$pcx       = 0;
         if ($total_pdp == 1){
             for ($pc=1;$pc<=$pcol;++$pc) {
                  $pdp_head[$pc] = mysql_field_name($mysql_datap,$pc);
                  if ($pc == 0){
                      $pdp_head_use[$pc] = 0;
                      if ($pc <> 0){
                          $pc3a = $pc3a + 1;
                      }           // Counter should be used only when $pc <> 0
                  } else {
                      $pdp_head_use[$pc] = 1;
                  }
                  $pcx = $pcx + 1;
                  //print($pc." - ".$pdp_head[$pc]." - ".$pdp_head_use[$pc]."<br>");
             }
         }
         for ($pc=1;$pc<=$pcol;++$pc) {
              if ($pc == 7) {
                  $pdp[$total_pdp][$pc] = substr(trim(stripslashes($rowp[$pc])),0,10);
              } else {
                $pdp[$total_pdp][$pc] = trim(stripslashes($rowp[$pc]));
                //if ($pc == 1){
                //       $sum1[1] = $sum1[1] + 1;
                //    $analsis[1] = $sum1[1];
                //}
              }
        }
   }
   //print("Last Column ".$pcol."<br>");


   // =========================== FILTER PDP ARRAY ==========================   
   
   // filtr1 (PDP_TYPE)
   $fltcnt1 = 0;
   if ($fltr1 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 5 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 5 means PDP_TYPE
                     if ($pdp[$tp][$pc] <> $prd){
                         $fltcnt1 = $fltcnt1 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  
   
   // filtr3 (PDP_CATEGORY)
   $fltcnt3 = 0;
   if ($fltr3 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 10 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 10+11 means concat(SCOPING." - ".PDP_CATEGORY)
                     $valx = $pdp[$tp][$pc]." - ".$pdp[$tp][$pc+1];
                     //if ($pdp[$tp][$pc] <> $pdpcat){
                     if ($valx <> $pdpcat){
                         $fltcnt3 = $fltcnt3 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  

   // filtr2 (RA_TESTING)
   $fltcnt2 = 0;
   if ($fltr2 == 1){
   } else { 
     for ($tp=1;$tp<=$total_pdp;++$tp) {
        for ($pc=1;$pc<=$pcol;++$pc) {
                 if ($pc == 22 && $pdp[$tp][$pcol] == 1){                       // Change the $pc value for different filters, $pc = 22 means RA_IND
                     $valx = $pdp[$tp][$pc];
                     //if ($pdp[$tp][$pc] <> $pdpcat){
                     if ($valx <> $ra_ind){
                         $fltcnt2 = $fltcnt2 + 1;
                         $pdp[$tp][$pcol] = 0;
                     }
                 }   
        }
     }
   }  

   // CREATE XPDP from PDP TO INCLUDE ONLY PDP THAT ARE VALID AS PER ABOVE FILTERS
   $rowcount = 0;
   for ($tp=1;$tp<=$total_pdp;++$tp) {
    if ($pdp[$tp][$pcol] == 1){
        $rowcount = $rowcount + 1;
        print("<tr>");
        for ($pc=1;$pc<=$pcol;++$pc) {
             if ($pdp_head_use[$pc] == 1) { 
                 if ($pc == 1){
                     $xpdp[$rowcount][$pc] = $rowcount;
                 } else {
                     $xpdp[$rowcount][$pc] = $pdp[$tp][$pc];
                     if ($pc == 20){
                         $pdpisu[$rowcount] = stripslashes($rowp[$pc]); 
                     }
                 }
             }   
        }
        //$uno  = $xpdp[$rowcount][1];
        //$updp = $xpdp[$rowcount][2]; 
        //print($uno." - ".$updp."<br>");
    }    
   }
   //ANALYSIS
   ////////////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////////////
   $analsis[1]  = "&nbsp";
   $sum1[1]     = 0; //NO. OF PDP
   $analsis[2]  = "&nbsp";
   $analsis[3]  = "&nbsp";
   $analsis[4]  = "&nbsp";
   $analsis[5]  = "&nbsp";
   $analsis[6]  = "&nbsp";
   $analsis[7]  = "&nbsp";
   $analsis[8]  = "&nbsp";
   $analsis[9]  = "&nbsp";
   $analsis[10] = "&nbsp";
   $sum1[10][1] = 0; //IN SCOPE 
   $sum1[10][2] = 0; //OUT OF SCOPE
   $sum1[10][3] = 0; //NOT SET
   $analsis[11] = "&nbsp";
   $sum1[12][1] = 0; //HIGH
   $sum1[12][2] = 0; //MEDIUM
   $sum1[12][3] = 0; //LOW
   $sum1[12][4] = 0; //NOT SET
   $analsis[12] = "&nbsp";
   $sum1[13][1] = 0; //HIGH
   $sum1[13][2] = 0; //MEDIUM
   $sum1[13][3] = 0; //LOW
   $sum1[13][4] = 0; //NOT SET
   $analsis[13] = "&nbsp";
   $sum1[14][1] = 0; //HIGH
   $sum1[14][2] = 0; //MEDIUM
   $sum1[14][3] = 0; //LOW
   $sum1[14][4] = 0; //NOT SET
   $analsis[14] = "&nbsp";
   $sum1[15][1] = 0; //HIGH
   $sum1[15][2] = 0; //MEDIUM
   $sum1[15][3] = 0; //LOW
   $sum1[15][4] = 0; //NOT SET
   $analsis[15] = "&nbsp";
   $analsis[16] = "&nbsp";
   $sum1[16]    = 0; //BILLS RUN 
   $analsis[17] = "&nbsp";
   $sum1[17]    = 0; //INVOICE GENERATED 
   $analsis[18] = "&nbsp";
   $sum1[18]    = 0; //PPW CHANGES 
   $analsis[19] = "&nbsp";
   $analsis[20] = "&nbsp";
   $sum1[20]    = 0; //ISSUES CREATED
   $sum1x[20][1]= 0;
   $sum1x[20][2]= 0;
   $sum1x[20][3]= 0;
   $sum1x[20][4]= 0;
   $analsis[21] = "&nbsp";
   $sum1[21][1] = 0;
   $sum1[21][2] = 0;
   $sum1[21][3] = 0;
   $sum1[21][4] = 0;
   $sum1x[21][1] =0;
   $sum1x[21][2] =0;
   $sum1x[21][3] =0;
   $sum1x[21][4] =0;
   $analsis[22] = "&nbsp";
   $analsis[23] = "&nbsp";
   for ($tp=1;$tp<=$rowcount;++$tp) {
         for ($pc=1;$pc<=$pcol;++$pc) {
                //NO.
                if ($pc == 1){
                    $sum1[1]    = $sum1[1] + 1;
                    $ypdp       = $sum1[1]; 
                    //Analysis
                    $analsis[1] = "<u>TOTAL PDPs FOUND</u><br><br>".$sum1[1];
                }
                //SCOPE
                if ($pc == 10){
                    switch ($xpdp[$tp][$pc]) {
                            case "IN SCOPE":
                            $sum1[$pc][1] = $sum1[10][1] + 1;
                            break;
                            case "OUT OF SCOPE":
                            $sum1[$pc][2] = $sum1[10][2] + 1;
                            break;
                            case "NOT SET":
                            $sum1[$pc][3] = $sum1[10][3] + 1;
                            break;
                    }
                    $sumx = $sum1[$pc][1] + $sum1[$pc][2] + $sum1[$pc][3];
                    // Calculate percentages
                    if ($sumx == 0){
                        $sumy[$pc][1] = 0;
                        $sumy[$pc][2] = 0;
                        $sumy[$pc][3] = 0;
                    } else { 
                      (float)$sumy[$pc][1] = round(($sum1[$pc][1]/$sumx)*100,2);
                      (float)$sumy[$pc][2] = round(($sum1[$pc][2]/$sumx)*100,2);
                      (float)$sumy[$pc][3] = round(($sum1[$pc][3]/$sumx)*100,2);
                    }
                    //Analysis
                    $analsis[10] = "<u>IN SCOPE</u><br>".$sum1[10][1]." PDPs<br>(".$sumy[10][1]."%)"."<br><br><u>OUT OF SCOPE</u><br>".$sum1[10][2]." PDPs<br>(".$sumy[10][2]."%)"."<br><br><u>NOT SET</u><br>".$sum1[10][3]." PDPs<br>(".$sumy[10][3]."%)";
                }
                // 12 COMPLEXITY
                // 13 REVENUE IMPACT
                // 14 CUSTOMER IMPACT
                // 15 PAST PERFORMANCE
                if ($pc >= 12 && $pc <= 15){
                    switch ($xpdp[$tp][$pc]) {
                            case "HIGH":
                            $sum1[$pc][1] = $sum1[$pc][1] + 1;
                            break;
                            case "MEDIUM":
                            $sum1[$pc][2] = $sum1[$pc][2] + 1;
                            break;
                            case "LOW":
                            $sum1[$pc][3] = $sum1[$pc][3] + 1;
                            break;
                            case "NOT SET":
                            $sum1[$pc][4] = $sum1[$pc][4] + 1;
                            break;
                    }
                    $sumx = $sum1[$pc][1] + $sum1[$pc][2] + $sum1[$pc][3] + $sum1[$pc][4];
                    // Calculate percentages
                    if ($sumx == 0){
                        $sumy[$pc][1] = 0;
                        $sumy[$pc][2] = 0;
                        $sumy[$pc][3] = 0;
                        $sumy[$pc][4] = 0;
                    } else { 
                      (float)$sumy[$pc][1] = round(($sum1[$pc][1]/$sumx)*100,2);
                      (float)$sumy[$pc][2] = round(($sum1[$pc][2]/$sumx)*100,2);
                      (float)$sumy[$pc][3] = round(($sum1[$pc][3]/$sumx)*100,2);
                      (float)$sumy[$pc][4] = round(($sum1[$pc][4]/$sumx)*100,2);
                    }
                    //Analysis 
                    $analsis[12] = "<u>HIGH</u><br>".$sum1[12][1]."<br>(".$sumy[12][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[12][2]."<br>(".$sumy[12][2]."%)"."<br><br><u>LOW</u><br>".$sum1[12][3]."<br>(".$sumy[12][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[12][4]."<br>(".$sumy[12][4]."%)";
                    $analsis[13] = "<u>HIGH</u><br>".$sum1[13][1]."<br>(".$sumy[13][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[13][2]."<br>(".$sumy[13][2]."%)"."<br><br><u>LOW</u><br>".$sum1[13][3]."<br>(".$sumy[13][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[13][4]."<br>(".$sumy[13][4]."%)";
                    $analsis[14] = "<u>HIGH</u><br>".$sum1[14][1]."<br>(".$sumy[14][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[14][2]."<br>(".$sumy[14][2]."%)"."<br><br><u>LOW</u><br>".$sum1[14][3]."<br>(".$sumy[14][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[14][4]."<br>(".$sumy[14][4]."%)";
                    $analsis[15] = "<u>HIGH</u><br>".$sum1[15][1]."<br>(".$sumy[15][1]."%)"."<br><br><u>MEDIUM</u><br>".$sum1[15][2]."<br>(".$sumy[15][2]."%)"."<br><br><u>LOW</u><br>".$sum1[15][3]."<br>(".$sumy[15][3]."%)"."<br><br><u>NOT SET</u><br>".$sum1[15][4]."<br>(".$sumy[15][4]."%)";
                }
                // 16 BILL RUNS
                // 17 INVOICE GENERATED
                // 18 PPW CHANGES
                // 20 ISSUES CREATED
                if (($pc >= 16 && $pc <=18) || $pc == 20){
                    if ($xpdp[$tp][$pc] > 0){
                        $sum1[$pc] = $sum1[$pc] + $xpdp[$tp][$pc];
                        if ($pc == 20){
                            $yisu = $sum1[$pc];
                        }
                    }    
                    $analsis[$pc] = $sum1[$pc];
                }
                // UAT and RA TESTED
                if ($pc == 21){
                    switch ($xpdp[$tp][21]) {
                       case ($xpdp[$tp][21] == "YES" && $xpdp[$tp][22] == "YES"):
                             $sum1[21][1] = $sum1[21][1] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][1] = $sum1x[$pc][1] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][1] = 0;
                                 $sumy[$pc][1] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "YES" && $xpdp[$tp][22] == "NO"): 
                             $sum1[21][2] = $sum1[21][2] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][2] = $sum1x[21][2] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][2] = 0;
                                 $sumy[$pc][2] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "NO" && $xpdp[$tp][22] == "YES"): 
                             $sum1[21][3] = $sum1[21][3] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][3] = $sum1x[21][3] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][3] = 0;
                                 $sumy[$pc][3] = 0;
                             }
                             break;
                       case ($xpdp[$tp][21] == "NO" && $xpdp[$tp][22] == "NO"): 
                             $sum1[21][4] = $sum1[21][4] + 1; 
                             if ($xpdp[$tp][20] > 0){
                                 $sum1x[21][4] = $sum1x[21][4] + $xpdp[$tp][20];
                             } else {
                                 $sumz[$pc][4] = 0;
                                 $sumy[$pc][4] = 0;
                             }
                             break;
                    }
                    if ($tp == $rowcount){
                        for ($x=1;$x<=4;++$x) {
                             if ($sum1[21][$x] == 0){
                                 $sumz[21][$x] = 0;
                             } else {
                                 (float)$sumz[21][$x] = round(($sum1[21][$x]/$ypdp)*100,2);
                             }
                             if ($sum1x[21][$x] == 0){
                                 $sumy[21][$x] = 0;
                             } else {
                                 (float)$sumy[21][$x] = round(($sum1x[21][$x]/$yisu)*100,2);
                             }
                        }    
                    }
                    //Analysis
                    $analsis[21] = "<u><br>UAT=YES,RA=YES<br></u><br>PDP<br>".$sum1[21][1]." out of ".$ypdp."<br>(".$sumz[21][1].")%<br><br>ISSUES<br>".$sum1x[21][1]." out of ".$yisu."<br>(".$sumy[21][1].")%<br><br>".
                                   "<u><br>UAT=YES,RA=NO<br></u><br>PDP<br>".$sum1[21][2]." out of ".$ypdp."<br>(".$sumz[21][2].")%<br><br>ISSUES<br>".$sum1x[21][2]." out of ".$yisu."<br>(".$sumy[21][2].")%<br><br>".
                                   "<u><br>UAT=NO,RA=YES<br></u><br>PDP<br>".$sum1[21][3]." out of ".$ypdp."<br>(".$sumz[21][3].")%<br><br>ISSUES<br>".$sum1x[21][3]." out of ".$yisu."<br>(".$sumy[21][3].")%<br><br>".
                                   "<u><br>UAT=NO,RA=NO<br></u><br>PDP<br>".$sum1[21][4]." out of ".$ypdp."<br>(".$sumz[21][4].")%<br><br>ISSUES<br>".$sum1x[21][4]." out of ".$yisu."<br>(".$sumy[21][4].")%";
                }
         }
   } 
   //print("Filter 1 Found :".$fltcnt1."To filter out<br>");
   //print("Filter 3 Found :".$fltcnt3."To filter out<br>");
   //print($rowcount."<br>");


   // =========================== LOAD AREA EXECUTION ==========================
   //$query2        = "  select sum(iterations) from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   //$mysql_data2   = mysql_query($query2, $mysql_link) or die ("#query2 Could not query: ".mysql_error());       
   //while($row2    = mysql_fetch_row($mysql_data2)) {
   //      $itcnt   = stripslashes($row2[0]);          
   //}
   $pc3b            = 0;  // columns not displayed
   for ($tp=1;$tp<=$rowcount;++$tp) {
        //                            0 'tgt_pdp_area_execution'                                   as 'DUMMY',
        //                            1 @rownum2:=@rownum2+1                                       as 'NO',
        //                            2 a.pdp                                                      as 'PDP',
        //                            3 a.issue_area                                               as 'DEPARTMENT',
        //                            4 if(a.test_iteration=1,'PRE-PRODUCTION','POST-PRODUCTION')  as 'ITERATION',
        //                            5 a.issue_count                                              as 'ISSUE COUNT',
        //                            6 a.back_to_build                                            as 'BACK TO BUILD',
        //                            7 a.testing_start_date                                       as 'TESTING START DATE',
        //                            8 a.testing_end_date                                         as 'TESTING END DATE',
        //                            9 a.planned_wkd                                              as 'PLANNED WEEKDAYS',
        //                           10 a.planned_wked                                             as 'PLANNED WEEKEND DAYS',
        //                           11 a.actual_start_date                                        as 'ACTUAL START DATE',
        //                           12 a.actual_end_date                                          as 'ACTUAL END DATE',
        //                           13 a.actual_available_wkd                                     as 'ACTUAL AVAILABLE WEEKDAYS',
        //                           14 a.actual_available_wked                                    as 'ACTUAL AVAILABLE WEEKENDAYS',
        //                           15 a.utilized_wkd                                             as 'UTILIZED WEEK DAYS',
        //                           16 a.utilized_wked                                            as 'UTILIZED WEEKEDND DAYS'
        $paecol        = 0;
        $updp          = $xpdp[$tp][2];
        $queryv        = "  set @rownum2  = 0";
        $mysql_datav   = mysql_query($queryv, $mysql_link) or die ("#queryv Could not query: ".mysql_error());       
        $querypae      = "  select 'tgt_pdp_area_execution'                                   as 'DUMMY',
                                   @rownum2:=@rownum2+1                                       as 'NO',
                                   a.pdp                                                      as 'PDP',
                                   a.issue_area                                               as 'DEPARTMENT',
                                   if(a.test_iteration=1,'PRE-PRODUCTION','POST-PRODUCTION')  as 'ITERATION',
                                   a.issue_count                                              as 'ISSUE COUNT',
                                   a.back_to_build                                            as 'BACK TO BUILD',
                                   a.testing_start_date                                       as 'TESTING START DATE',
                                   a.testing_end_date                                         as 'TESTING END DATE',
                                   a.planned_wkd                                              as 'PLANNED WEEKDAYS',
                                   a.planned_wked                                             as 'PLANNED WEEKEND DAYS',
                                   a.actual_start_date                                        as 'ACTUAL START DATE',
                                   a.actual_end_date                                          as 'ACTUAL END DATE',
                                   a.actual_available_wkd                                     as 'ACTUAL AVAILABLE WEEKDAYS',
                                   a.actual_available_wked                                    as 'ACTUAL AVAILABLE WEEKENDAYS',
                                   a.utilized_wkd                                             as 'UTILIZED WEEK DAYS',
                                   a.utilized_wked                                            as 'UTILIZED WEEKEDND DAYS'
                              from ".$name.".tgt_pdp_area_execution a 
                             where a.etl_id = '$yetl_id'
                               and a.pdp = '$updp' 
                          order by a.pdp,a.issue_area,a.test_iteration
                        ";
        //print($querypdp2."<br>");                
        $mysql_datapae = mysql_query($querypae, $mysql_link) or die ("#querypae Could not query: ".mysql_error());
        $paerows       = mysql_num_rows($mysql_datapae);
        $paecol        = mysql_num_fields($mysql_datapae)-1;                // subtracting field/column at [0] i.e the DUMMY field/column                      
        $paestart      = 1;                                                 //($paecol - $paecol2)+1;
        $paeend        = $paecol;
        $totl          = 0;
        //print("Rows :".$paerows."  Columns :".$paecol."<br>");
        while($rowpae  = mysql_fetch_row($mysql_datapae)) {
              $totl = $totl + 1;
              if ($totl == 1){
              } else {
                  $paestart = $paestart + $paecol;
                  $paeend   = $paeend + $paecol;
                  //print("Start: ".$paestart." - End: ".$paeend."<br>");
              }
              //print("Start :".$paestart."  End :".$paeend."<br>");              
              $pc2 = 0;
              for ($pc=$paestart;$pc<=$paeend;++$pc) {
                   $pc2    = $pc2 + 1;
                   if ($tp == 1){
                       $analsis2[$pc]  = 0;
                       $sum2[$pc]      = 0;
                   } 
                   //LOADING HEADING NAMES      
                   if ($tp == 1){
                       $pae_head[$pc] = mysql_field_name($mysql_datapae,$pc2);
                       if ($pc == $paestart){
                           // SUPRESSING THE FIRST COLUMN TO DISPLAY
                           $pae_head_use[$pc] = 0;
                           if ($pc <> 0){
                               $pc3b = $pc3b + 1;
                           }           // Counter should be used only when $pc <> 0
                       } else {
                           $pae_head_use[$pc] = 1;
                       }
                   }
                   //$pae[$tp][$pc] = stripslashes($rowpae[$pc2]);
                   if ($pc2 == 7 || $pc2 == 8 || $pc2 == 11 || $pc2 == 12){
                       $pae[$tp][$pc] = substr(stripslashes($rowpae[$pc2]),0,10);
                       if (trim($pae[$tp][$pc]) == "0000-00-00" ){
                           $pae[$tp][$pc] = "&nbsp";
                       }
                   } else {
                       $pae[$tp][$pc] = stripslashes($rowpae[$pc2]);
                       //////////////////////////////////////////////
                       //ANALYSIS FOR ISSUE COUNT AND BACK TO BUILD//
                       //////////////////////////////////////////////
                       // ISSUE COUNT
                       if ($pc2 == 5){
                           //if ($pae[$tp][$pc] > 0){
                               $xy = $pc-2;
                               $xz = $pc-1;
                               $sum2head[$pc] = $pae[$tp][$xy]."<br><br>".$pae[$tp][$xz];
                               $sum2[$pc]     = $sum2[$pc] + $pae[$tp][$pc];
                               if ($sum2[$pc] == 0){
                                   $sum2y[$pc] = 0;
                               } else {
                                 (float)$sum2y[$pc] = round(($sum2[$pc]/$yisu)*100,2); 
                               }  
                               // ANALYSIS 
                               $analsis2[$pc] = "<u>".$sum2head[$pc]."</u>"."<br><br>".$sum2[$pc]." out of ".$yisu."<br>(".$sum2y[$pc].")%";
                               //$xy = $pc - 2;
                               //$analsis2[$xy] =  $analsis2[$pc]."<br><br>".$analsis2[$xy];
                           //}
                           //////////////////////////////////////////////
                           // ISSUE COUNT SUM FOR PRE AND POST PRODUCTION
                           //////////////////////////////////////////////
                           //$u = $pc-1;
                           //$v = $pc;
                           //$valx1 = $pae[$tp][$u];
                           //$valx2 = $pae[$tp][$v];
                           //print("PC: ".$u." - ".$valx1." || PC2: ".$v." - ".$valx2."<br>");
                           // TOTAL PRE-PRODUCTION and PC 112
                           if (trim($pae[$tp][$pc-1]) == "PRE-PRODUCTION"){
                               $x                = 1; // FILLER "TOTAL ISSUES PRE-PRODUCION";
                               $xfilr[$tp][$x]   = $xfilr[$tp][$x] + $pae[$tp][$pc];
                           } 
                           // TOTAL POST-PRODUCTION and PC 113
                           if (trim($pae[$tp][$pc-1]) == "POST-PRODUCTION"){
                               $x                = 2; // FILLER "TOTAL ISSUES POST-PRODUCION";
                               $xfilr[$tp][$x]   = $xfilr[$tp][$x] + $pae[$tp][$pc];
                           } 
                       }
                       // BACK TO BUILD
                       if ($pc2 == 6 || ($pc2 >= 9 && $pc2 <= 16)){
                           if ($pae[$tp][$pc] > 0){
                               $sum2[$pc] = $sum2[$pc] + $pae[$tp][$pc];
                               if ($pc2 == 6){
                                   $x               = 3;      // FILLER "TOTAL BACK TO BUILD";
                                   $xfilr[$tp][$x]  = $xfilr[$tp][$x] + $pae[$tp][$pc];
                               }
                               // ANALYSIS
                               $analsis2[$pc]        = $sum2[$pc]; 
                           }    
                       }
                   }
              }
         }
   }
   for ($x=1;$x<=3;++$x) {
        $paeend                 = $paeend + 1;
        $pae_head_use[$paeend]  = 1;
        switch ($x){
             case 1:
                $pae_head[$paeend] = "TOTAL ISSUES PRE-PRODUCION";
                break;
             case 2:
                $pae_head[$paeend] = "TOTAL ISSUES POST-PRODUCTION";
                break;
             case 3:
                $pae_head[$paeend] = "TOTAL BACK TO BUILD";
                break;
        } 
        //FILLER "TOTAL BACK TO BUILD";
        for ($tp=1;$tp<=$rowcount;++$tp) {
             $pae[$tp][$paeend] = $xfilr[$tp][$x];
             $yfilr[$x]         = $yfilr[$x] + $pae[$tp][$paeend];
        }
        $analsis2[$paeend]      = $yfilr[$x];
   }
   //print("Last Column ".$paeend."<br>");
   
   // =========================== LOAD WORK EFFORT ==========================
   //$query2a       = "  select count(*) from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   //$mysql_data2a  = mysql_query($query2a, $mysql_link) or die ("#query2a Could not query: ".mysql_error());       
   //while($row2a   = mysql_fetch_row($mysql_data2a)) {
   //      $areacnt   = stripslashes($row2a[0]);          
   //}
   $pc3c          = 0;  // columns not displayed
   for ($tp=1;$tp<=$rowcount;++$tp) {
        //                          0 'tgt_pdp_area_work_effort'                                 as 'DUMMY',
        //                          1 @rownum3:=@rownum3+1                                       as 'NO',
        //                          2 a.pdp                                                      as 'PDP',
        //                          3 a.issue_area                                               as 'AREA',
        //                          4 a.baseline_hours                                           as 'BASELINE HOURS',
        //                          5 a.rework_hours                                             as 'REWORK HOURS',
        //                          6 a.percentage_rework                                        as 'BASELINE HOURS UTILIZED',
        //                          7 a.percentage_baseline                                      as 'REWORK HOURS REQUIRED'
        $pwecol = 0;
        $updp          = $xpdp[$tp][2];
        $queryv2       = "  set @rownum3  = 0";
        $mysql_datav2  = mysql_query($queryv2, $mysql_link) or die ("#queryv2 Could not query: ".mysql_error());       
        $querypwe      = "  select 'tgt_pdp_area_work_effort'                                 as 'DUMMY',
                                   @rownum3:=@rownum3+1                                       as 'NO',
                                   a.pdp                                                      as 'PDP',
                                   a.issue_area                                               as 'DEPARTMENT',
                                   a.baseline_hours                                           as 'BASELINE HOURS',
                                   a.rework_hours                                             as 'REWORK HOURS',
                                   a.percentage_baseline                                      as 'BASELINE HOURS UTILIZED',
                                   a.percentage_rework                                        as 'REWORK HOURS REQUIRED'
                              from ".$name.".tgt_pdp_area_work_effort a 
                             where a.etl_id = '$yetl_id'
                               and a.pdp = '$updp' 
                          order by a.pdp,a.issue_area
                        ";
        //print($querypdp2."<br>");                
        $mysql_datapwe = mysql_query($querypwe, $mysql_link) or die ("#querypwe Could not query: ".mysql_error());
        $pwerows       = mysql_num_rows($mysql_datapwe);
        $pwecol        = mysql_num_fields($mysql_datapwe)-1;                // subtracting field/column at [0] i.e the DUMMY field/column                      
        $pwestart      = 1;                                                 //($pwecol - $pwecol2)+1;
        $pweend        = $pwecol;
        $totl          = 0;
        //print("Rows :".$paerows."  Columns :".$paecol."<br>");
        while($rowpwe  = mysql_fetch_row($mysql_datapwe)) {
              $totl = $totl + 1;
              if ($totl == 1){
              } else {
                  $pwestart = $pwestart + $pwecol;
                  $pweend   = $pweend + $pwecol;
              }
              //print("Start :".$pwestart."  End :".$pweend."<br>");              
              $pc2 = 0;
              for ($pc=$pwestart;$pc<=$pweend;++$pc) {
                   //$ytp[$pc] = 0;
                   $pc2    = $pc2 + 1;
                   if ($tp == 1){
                       $analsis3[$pc]  = 0;
                       $sum3[$pc]      = 0;
                       $ytp[$pc]       = 0;
                       $sum3y[$pc]     = 0;
                       $pwe_head[$pc] = mysql_field_name($mysql_datapwe,$pc2);
                       if ($pc == $pwestart){
                           $pwe_head_use[$pc] = 0;
                           if ($pc <> 0){
                               $pc3c = $pc3c + 1;
                           }           // Counter should be used only when $pc <> 0
                       } else {
                           $pwe_head_use[$pc] = 1;
                       }
                   }

                   $pwe[$tp][$pc] = stripslashes($rowpwe[$pc2]);
                   if ($pc2 == 6 || $pc2 == 7){
                       //$pwe[$tp][$pc] = stripslashes($rowpwe[$pc2]);
                       //if ($pwe[$tp][$pc] > 0){
                           if ($pc2 == 6){
                               $xy = $pc - 3;
                           } else {
                               $xy = $pc - 4;
                           }
                           $sum3head[$pc] = $pwe[$tp][$xy];
                           if ($pwe[$tp][$pc] > 0){
                               $ytp[$pc]      = $ytp[$pc]  + 1;
                               $sum3[$pc]     = $sum3[$pc] + $pwe[$tp][$pc];
                               $sum3y[$pc]    = round(($sum3[$pc]/$ytp[$pc]),2); 
                               // ANALYSIS 
                               //$analsis3[$pc] = $sum3[$pc]."<br>".$sum3y[$pc]."<br>".$ytp[$pc];    //." for ".$ypdp." PDP<br>(".$sum3y[$pc].")%"; 
                               //$analsis3[$pc] =  $sum3head[$pc]."<br><br>".$sum3y[$pc];
                           }
                           //$sum3y[$pc]    = round(($sum3[$pc]/$ytp[$pc]),2);
                           $analsis3[$pc] =  "<u>".$sum3head[$pc]."</u>"."<br><br>".$sum3y[$pc];
                       //}
                   } else {
                       //$pwe[$tp][$pc] = stripslashes($rowpwe[$pc2]);
                       if ($pc2 == 4 || $pc2 == 5){
                           if ($pwe[$tp][$pc] > 0){
                               $sum3[$pc]     = $sum3[$pc] + $pwe[$tp][$pc];
                               // ANALYSIS 
                               $analsis3[$pc] = $sum3[$pc];    //." for ".$ypdp." PDP<br>(".$sum3y[$pc].")%"; 
                           }
                       }
                   }

              }
        }
   }
   //print("Last Column ".$paeend."<br>");

   // =========================== LOAD ISSUE ANALYTICS ==========================
   $query1a       = " select issue_area from ".$name.".tgt_areas where etl_id = '$yetl_id' ";
   $mysql_data1a  = mysql_query($query1a, $mysql_link) or die ("#query1a Could not query: ".mysql_error());
   $arearows      = mysql_num_rows($mysql_data1a);
   $areacnt       = 0;          
   while($row1a   = mysql_fetch_row($mysql_data1a)) {
         $areacnt = $areacnt + 1; 
         $ara[$areacnt]   = stripslashes($row1a[0]);          
   }
   $query2a       = "  select issue_type,issue_class,report_group
                         from ".$name.".tgt_report_groups
                        where etl_id = '$yetl_id' ";
   $mysql_data2a  = mysql_query($query2a, $mysql_link) or die ("#query2a Could not query: ".mysql_error());       
   $isucnt = 0;
   while($row2a   = mysql_fetch_row($mysql_data2a)) {
         $isucnt       = $isucnt + 1;
         $isu[$isucnt] = stripslashes($row2a[0]);
         $isc[$isucnt] = stripslashes($row2a[1]);
         $isr[$isucnt] = stripslashes($row2a[2]); 
   }
   /////////////////////////////////////////////////////////////////
   $pc4  = $isucnt + 1;     // Headers are Area + All Issue Types 
   $pc4h = $pc4 * $areacnt;
   for ($tp=1;$tp<=$rowcount;++$tp) {
        $pc = 0;
    for ($ar=1;$ar<=$areacnt;++$ar) {
         $pc             = $pc + 1;
         $pc3            = $pc;
         $pia_head[$pc]  = "DEPARTMENT"; //$ara[$ar];     // AREA is the first HEADER
         $pia[$tp][$pc]  = $ara[$ar];
         $valx           = $pia[$tp][$pc];
         $pc2            = 0;
         $pc2            = $pc2 + 1;
         //$chk[$pc]       = $pc2;                   // $pc2 works just like $bpc (used in issue summary per area)
         //print($pc." - ".$pia_head[$pc]."<br>");
         //print($pc." - ".$valx."<br>");
         $sum4grsrot     = 0;
         $sum4grscnt     = 0;
     for ($is=1;$is<=$isucnt;++$is) {
          $pc            = $pc + 1;                // Counter for all Other HEADERS
          $pc2           = $pc2 + 1;
          $chk[$pc]      = $pc2;                   // $pc2 works just like $bpc (used in issue summary per area)         
          $pia_head[$pc] = $isu[$is];              // Setting up HEADER
          //$xhead = $pia_head[$pc];          $pia_head1[$pc]= "<br><br>".$isc[$is]."<br><br>".$isr[$is];
          $piac[$pc]     = $isc[$is];              // ISSUE CLASS
          $piar[$pc]     = $isr[$is];              // ISSUE GROUP  
          $updp          = $xpdp[$tp][2];
          //if ($pdpisu[$tp] == 0){
          //    $pia[$tp][$pc] = 0;
          //} else { 
            $querypia      = "  select a.found_issues 
                                  from ".$name.".tgt_pdp_issue_area_summary a 
                                 where a.etl_id     = '$yetl_id'
                                   and a.pdp        = '$updp'
                                   and a.issue_area = '$ara[$ar]'
                                   and a.issue_type = '$isu[$is]'  
                            ";
            //print($querypia."<br>");                
            $mysql_datapia = mysql_query($querypia, $mysql_link) or die ("#querypia Could not query: ".mysql_error());
            $piarows       = mysql_num_rows($mysql_datapia);
            //print($pc." - ".$pia_head[$pc]." - Class: ".$piac[$pc]." - Report Group: ".$piar[$pc]."<br>");
            //print($pc."ROWS RETURNED - ".$piarows."<br>");
            if ($piarows == 0){
                $pia[$tp][$pc] = 0;
                //$valx = $pia[$tp][$pc];
                //print($pc." - ".$valx."<br>");
            } else {
                while($rowpia = mysql_fetch_row($mysql_datapia)) {
                      $pia[$tp][$pc] = stripslashes($rowpia[0]); 
                }        
            }
            //////////
            //ANALYSIS
            //////////
            if ($piac[$pc] == "ROT" || $piac[$pc] == "GRT"){
                //$totalrot        = $totalrot + $pia[$tp][$pc];       // Total of all ROT Issues Types for all PDPs
                $sum4[$pc]       = $sum4[$pc] + $pia[$tp][$pc];        // Total of specific Issue Type for all PDPs
                ///// CALCULATE (A) TOTALROT (TOTAL OF ROOT CAUSE FOR ALL PDP, SUM4ROT (SUM OF ROOT CAUSE FOR A GIVEN DEPARTMENT
                if ($piac[$pc] == "ROT"){
                    $totalrot        = $totalrot + $pia[$tp][$pc];       // Total of all ROT Issues Types for all PDPs
                    $sum4rot[$ar]    = $sum4rot[$ar] + $pia[$tp][$pc];   // Total of all Issues Types in a specific area i.e. MO, RA, UAT, CMGT
                }
                ///// CALCULATE (A) TOTALROT (TOTAL OF ROOT CAUSE FOR ALL PDP, SUM4ROT (SUM OF ROOT CAUSE FOR A GIVEN DEPARTMENT
                if (($sum4[$pc] == 0 && $sum4rot[$ar] == 0) && $piac[$pc] == "ROT"){
                    $sum4a[$pc]  = 0;
                    $sum4b[$pc] = 0;
                } else {
                    if ($piac[$pc] == "ROT"){
                        $sum4a[$pc]  = round(($sum4[$pc]/$sum4rot[$ar])*100,2);
                        $sum4b[$pc]  = round(($sum4[$pc]/$totalrot)*100,2);
                    }
                }
                if ($piac[$pc] == "ROT"){
                    //$xhead = $pia_head[$pc];
                    //print($xhead." - ".$piar[$pc]."<br>");
                    if (trim($pia_head[$pc]) == trim($piar[$pc])){                        //print($piar[$pc]."<br>");
                        $xpc          = $pc; 
                        $xcause       = trim($pia_head[$pc]);
                        $piaxp[$xpc]  = 1;
                        $xp           = 0;
                        $analsis4x[$xpc] = "<br><u>GRANULAR ROOT CAUSE COUNT</u><br><br>";
                    }
                    $analsis4[$pc]   = "(R)<br>".$sum4[$pc]."<br><br>(A)<br>".$sum4a[$pc]."%<br>(B)<br>".$sum4b[$pc]."%"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4rot[$ar]."<br><br>Total: ".$totalrot;
                } else {
                    $analsis4[$pc]   = "(R)<br>".$sum4[$pc];
                    if (trim($piar[$pc]) == $xcause){
                        //print("YES"."<br>");
                        if ($sum4[$pc] == 0){
                          $grtchk[$xpc] = 0;
                        } else {
                          $xp = $xp + 1;
                          $grtchk[$xpc] = $xp;
                          $analsis4x[$xpc] = $analsis4x[$xpc]."<br><br>".$pia_head[$pc]." = ".$sum4[$pc];
                        }
                    }
                }
            }
            if ($piac[$pc] == "CNT" && (trim($pia_head[$pc]) <> trim($piar[$pc]))){
                $totalcnt        = $totalcnt + $pia[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                $sum4[$pc]       = $sum4[$pc] + $pia[$tp][$pc];      // Total of specific Issue Type for all PDPs
                $sum4cnt[$ar]    = $sum4cnt[$ar] + $pia[$tp][$pc];   // Total of all Issues Types in a specific area i.e. MO, RA, UAT, CMGT
                if ($sum4[$pc] == 0 && $sum4cnt[$ar] == 0){
                    $sum4c[$pc]  = 0;
                    $sum4d[$pc]  = 0;
                } else {
                    $sum4c[$pc]  = round(($sum4[$pc]/$sum4cnt[$ar])*100,2);
                    $sum4d[$pc]  = round(($sum4[$pc]/$totalcnt)*100,2);
                }
                $analsis4[$pc]   = "(M)<br>".$sum4[$pc]."<br><br>(C)<br>".$sum4c[$pc]."%<br>(D)<br>".$sum4d[$pc]."%"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4cnt[$ar]."<br><br>Total: ".$totalcnt
            }
            if ($pc2 == $pc4){
                if ($sum4rot[$ar] == 0){
                    $analsis4a  = 0;
                } else {
                  $analsis4a  = round((($sum4rot[$ar]/$totalrot)*100),2);
                }
                if ($sum4cnt[$ar] == 0){
                    $analsis4c  = 0;
                } else {
                  $analsis4c  = round((($sum4cnt[$ar]/$totalcnt)*100),2);
                }
                $analsis4[$pc3] = "<u>".$ara[$ar]."</u><br><br>(R)<br><u>ROOT CAUSE COUNT</u><br>(A of B) <br>".$sum4rot[$ar]." of ".$totalrot."<br>(".$analsis4a.")%".
                                                  "<br><br>(M)<br><u>MISSED OPPORTUNITIES</u><br>(C of D)<br>".$sum4cnt[$ar]." of ".$totalcnt."<br>(".$analsis4c.")%";
            }               
     }
    }
   }
   ///////////////////////////////////////////////////////////////
   $pc5  = $isucnt;     // Headers are Area + All Issue Types 
   $pc5h = $pc5;
   for ($tp=1;$tp<=$rowcount;++$tp) {
        $pc = 0;
     for ($is=1;$is<=$isucnt;++$is) {
          $pc            = $pc + 1;                // Counter for all Other HEADERS
          $pii_head[$pc] = $isu[$is];              // Setting up HEADER
          $pii_head1[$pc]= "<br><br>".$isc[$is]."<br><br>".$isr[$is];
          $piic[$pc]     = $isc[$is];
          $piir[$pc]     = $isr[$is];
          $updp          = $xpdp[$tp][2];
          $querypii      = "  select a.occurance 
                                from ".$name.".tgt_pdp_issue_summary a 
                               where a.etl_id     = '$yetl_id'
                                 and a.pdp        = '$updp'
                                 and a.issue_type = '$isu[$is]'  
                           ";
          //print($querypia."<br>");                
          $mysql_datapii = mysql_query($querypii, $mysql_link) or die ("#querypii Could not query: ".mysql_error());
          $piirows       = mysql_num_rows($mysql_datapii);
          if ($piirows == 0){
              $pii[$tp][$pc] = 0;
              $sum5[$pc]     = $sum5[$pc] + $pii[$tp][$pc];
              $analsis5[$pc] = $sum5[$pc];
          } else {
              while($rowpii = mysql_fetch_row($mysql_datapii)) {
                    $pii[$tp][$pc] = stripslashes($rowpii[0]); 
                    //////////
                    //ANALYSIS
                    //////////
                    //$sum5[$pc]     = $sum5[$pc] + $pii[$tp][$pc];
                    //$analsis5[$pc] =  $sum5[$pc];
              }        
          }
            //////////
            //ANALYSIS
            //////////
            if ($piic[$pc] == "ROT" || $piic[$pc] == "GRT"){
                $sum5[$pc] = $sum5[$pc] + $pii[$tp][$pc];                  // Total of specific Issue Type for all PDPs
                if ($piic[$pc] == "ROT"){
                    $totalrot2 = $totalrot2 + $pii[$tp][$pc];
                    if (trim($pii_head[$pc]) == trim($piir[$pc])){
                        $xpc          = $pc; 
                        $xcause       = trim($pii_head[$pc]);
                        $piixp[$xpc]  = 1;
                        $xp           = 0;
                        $analsis5x[$xpc] = "<br><u>GRANULAR ROOT CAUSE COUNT</u><br><br>";
                    }
                    $analsis5[$pc]   =  $sum5[$pc];                  //"(R)<br>".$sum5[$pc]."<br><br>(A)<br>".$sum5a[$pc]."%";   //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4rot[$ar]."<br><br>Total: ".$totalrot;
                } else {
                    $analsis5[$pc]   = $sum5[$pc];
                    if (trim($piir[$pc]) == $xcause){
                        //print("YES"."<br>");
                        if ($sum5[$pc] == 0){
                            $grtchk2[$xpc] = 0;
                        } else {
                          $xp = $xp + 1;
                          $grtchk2[$xpc] = $xp;
                          $analsis5x[$xpc] = $analsis5x[$xpc]."<br><br>".$pii_head[$pc]." = ".$sum5[$pc];
                        }
                    }
                }
            }
            if ($piic[$pc] == "CNT"){
                $sum5[$pc]      = $sum5[$pc] + $pii[$tp][$pc];        // Total of specific Issue Type for all PDPs
                if ($pii_head[$pc] == $piir[$pc]){
                    //$totalcnt2      = $totalcnt2 + $pii[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                } else {
                    $totalcnt2  = $totalcnt2 + $pii[$tp][$pc];       // Total of all CNT Issues Types for all PDPs
                }
                $analsis5[$pc]   =  $sum5[$pc];                 //"(M)<br>".$sum5[$pc]."<br><br>(C)<br>".$sum5c[$pc]."%<br>(D)<br>".$sum5d[$pc]."%"; //.$piac[$pc]." - ".$piar[$pc]; ."<br><br>Area Total: ".$sum4cnt[$ar]."<br><br>Total: ".$totalcnt
            }
     }
   }
   //print("Last Column ".$paeend."<br>");

   











   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   //print($total_pdp." Total PDPs<br>");
   // ============================ PDP AND CRITERIA ===========================
   $captnx = "Criteria";
   print("
                        <div id=\"One\" class=\"cont\"> 
                         <table>
                          <caption>$captnx</caption>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Type</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$prd</font>
                           </th>
                          </tr>
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">RA Testing</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$ra_ind</font>
                           </th>
                          </tr>             
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Category</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$pdpcat</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">PDP Launch Date (YYYY-MM-DD)</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">Between $xldate and $xldate2</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">Run Date</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$ydate2</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">ETL JOB</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$yetl_id</font>
                           </th>
                          </tr> 
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">REPORT</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">FULL EXTRACT</font>
                           </th>
                          </tr>                                         
                          <tr>
                           <th bgcolor=\"#99CCFF\" align=\"right\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                            <font color=\"#330099\">USER</font>
                           </th>
                           <th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:300px;\">
                            <font color=\"#330099\">$usr</font>
                           </th>
                          </tr>
   ");
   if ($total_pdp == 0){
       print("                        
                          <tr>
                           <th colspan=\"2\" bgcolor=\"#FF0000\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:500px;\">
                            <font color=\"#FFFFFF\">
                             NO RECORDS FOUND FOR THIS CRITERIA
                            </font>
                           </th>
                          </tr>
       "); 
   }
   print("                       
                         </table>
                        </div> 
   ");










   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =============
   // Headers Start 
   // ============= 
   //print("pcol: ".$pcol." pc3a = ".$pc3a." - paeend: ".$paeend." pc3b = ".$pc3b." - pweend: ".$pweend." pc3c = ".$pc3c."<br>");
   $cola = $pcol - $pc3a;
   $colb = $paeend - $pc3b;
   $colc = $pweend - $pc3c;
   //print("cola: ".$cola." - "."colb: ".$colb." - "."colc: ".$colc."<br>");
   print("<input type=\"button\" value=\"Toggle Detail Row Display\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");
   //$pcolx = $pcol - $pcol_supress;
   $captn = "FULL EXTRACT";
   print(
          "<div id=\"Two\" class=\"cont2\">
            <div class=\"wrapper2\">
             <table id=\"theTable\" scroll=\"yes\" style=\"border-style:solid 1px; border-color:#CCCCCC; width=500%;\" >
              <caption >$captn</caption>
               <tr class=\"headerRow\">
                <th bgcolor=\"#CCCCCC\" colspan=\"$cola\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  PDP GENERAL INFORMATION
                 </font>
                </th>            
                <th bgcolor=\"#AFC7C7\" colspan=\"$colb\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  EXECUTION DETAILS PER AREA
                 </font>
                </th>            
                <th bgcolor=\"#CCCCCC\" colspan=\"$colc\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  REWORK EFFORT PER AREA
                 </font>
                </th>            
                <th bgcolor=\"#AFC7C7\" colspan=\"$pc4h\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  ISSUES FOUND PER ISSUE TYPE PER AREA
                 </font>
                </th>            
                <th bgcolor=\"#CCCCCC\" colspan=\"$pc5h\" align=\"center\" valign=\"middle\">
                 <font color=\"#330099\" font-size=\"18px\">
                  ISSUES SUMMARY
                 </font>
                </th>            
               </tr>
   ");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   // Open this for debugging
   print("<tr class=\"headerRow\">");
   for ($pc=1;$pc<=$pcol;++$pc) {
        if ($pdp_head_use[$pc] == 1) { 
            if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
                $wdth = "150px";
            } else {
                $wdth = "75px"; 
            }
            print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"#330099\">
                     $pc
                    </font>
                   </th>        
            ");
       }   
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$paeend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#AFC7C7";
            $fcolr = "#330099"; 
        }
        if ($pae_head_use[$pc] == 1) {
            $wdth = "75px";
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pc
                    </font>
                   </th>        
            ");
       } 
       if ($bpc == $paecol){
           $bpc = 0;
       }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$pweend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#CCCCCC";
            $fcolr = "#330099"; 
        }
        if ($pwe_head_use[$pc] == 1) {
            $wdth = "75px";
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pc
                    </font>
                   </th>        
            ");
       }
       if ($bpc == $pwecol){
           $bpc = 0;
       }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$pc4h;++$pc) {
        $bpc = $bpc + 1;
        $wdth = "75px";
        if ($bpc == 1){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#AFC7C7";
            $fcolr = "#330099"; 
        }
        print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                <font color=\"$fcolr\">
                 $pc&nbsp$pia_head1[$pc]
                </font>
               </th>        
        ");
        if ($bpc == $pc4){
            $bpc = 0;
        }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary
   // Open this for debugging
   for ($pc=1;$pc<=$pc5h;++$pc) {
        $wdth = "75px";
        print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                <font color=\"#330099\">
                 $pc&nbsp$pii_head1[$pc]
                </font>
               </th>        
        ");
   }
   print("</tr>");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   print("<tr class=\"headerRow\">");
   for ($pc=1;$pc<=$pcol;++$pc) {
        if ($pdp_head_use[$pc] == 1) {
            if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
                $wdth = "150px";
            } else {
                $wdth = "75px"; 
            }
            print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"#330099\">
                     $pdp_head[$pc]
                    </font>
                   </th>        
            ");
       }   
   } 
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution                        
   $bpc = 0;
   for ($pc=1;$pc<=$paeend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#AFC7C7";
            $fcolr = "#330099"; 
        }
        if ($pae_head_use[$pc] == 1) {
            $wdth = "75px";
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pae_head[$pc]
                    </font>
                   </th>        
            ");
       }   
       if ($bpc == $paecol){
           $bpc = 0;
       }
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort                        
   $bpc = 0;
   for ($pc=1;$pc<=$pweend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){ 
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#CCCCCC";
            $fcolr = "#330099"; 
        }
        if ($pwe_head_use[$pc] == 1) {
            $wdth = "75px";
            //if ($pc == 3 || $pc == 11){ 
            //    $wdth = "150px";
            //} else {
            //    $wdth = "75px"; 
            //}
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pwe_head[$pc]
                    </font>
                   </th>        
            ");
       }   
       if ($bpc == $pwecol){
           $bpc = 0;
       }
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary 
   $bpc = 0;                       
   for ($pc=1;$pc<=$pc4h;++$pc) {
        $bpc = $bpc + 1;
        //if ($pia_head_use[$pc] == 1) {
            $wdth = "75px";
            //if ($pc == 3 || $pc == 11){ 
            //    $wdth = "150px";
            //} else {
            //    $wdth = "75px"; 
            //}
                   if($piac[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "CNT"){
                      if($piar[$pc] == "NO" || $piar[$pc] == $pia_head[$pc]){
                         $bcolr = "#9AFEFF";
                         $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
                 if ($bpc == 1){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 }
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pia_head[$pc]
                    </font>
                   </th>        
            ");
            if ($bpc == $pc4){
                $bpc = 0;
            }
       //}   
   }                         
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_issue_summary 
   //$bpc = 0;                       
   for ($pc=1;$pc<=$pc5h;++$pc) {
        //$bpc = $bpc + 1;
        //if ($pia_head_use[$pc] == 1) {
            $wdth = "75px";
            //if ($pc == 3 || $pc == 11){ 
            //    $wdth = "150px";
            //} else {
            //    $wdth = "75px"; 
            //}
                   if($piic[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piic[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                      $fcolr = "#330099";
                   }
                   if($piic[$pc] == "CNT"){
                      if($piir[$pc] == "NO" || $piir[$pc] == $pii_head[$pc]){
                         $bcolr = "#9AFEFF";
                         $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
            print("<th bgcolor=\"$bcolr\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $pii_head[$pc]
                    </font>
                   </th>        
            ");
             //if ($bpc == $pc4){
             //    $bpc = 0;
             //}
       //}   
   }                         
   print("</tr>");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   // ===========
   // Headers End 
   // =========== 


   // =============
   // Summary Start 
   // ============= 
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   // Open this for debugging
   print("<tr class=\"headerRow\">");
   for ($pc=1;$pc<=$pcol;++$pc) {
        if ($pdp_head_use[$pc] == 1) { 
            if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
                $wdth = "150px";
            } else {
                $wdth = "75px"; 
            }
            if ($pc == 21 || $pc == 22){
                if ($pc == 21){
                    print("<th bgcolor=\"#FFFFCC\" align=\"left\" colspan=\"2\" valign=\"top\" style=\"width: $wdth;\">
                            <font color=\"#FF0000\">
                             $analsis[$pc]
                            </font>
                           </th>        
                    ");
                }
            } else {
              print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"#FF0000\">
                     $analsis[$pc]
                    </font>
                   </th>        
              ");
            }
       }   
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   $bpc = 0;
   for ($pc=1;$pc<=$paeend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3 || $pc >= $paeend-2){
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#FFFFCC";
            $fcolr = "#330099";
        }
        if ($pae_head_use[$pc] == 1) {
            $wdth = "75px";
            if ($bpc == 5 || $bpc == 6 || $bpc >= 9 && $bpc <= 16 || $pc >= $paeend-2){
                print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"$fcolr\">
                         $analsis2[$pc]
                        </font>
                       </th>        
                ");
            } else {
                print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     &nbsp
                    </font>
                   </th>        
                ");
              //}  
            }
        }
        if ($bpc == $paecol){
            $bpc = 0;
        }
   }
   //$colsp = $colc + $pc4h + $pc5h;
   //print("<th bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" colspan=\"$colsp\">
   //                 <font color=\"#330099\">
   //                  &nbsp
   //                 </font>
   //                </th>        
   //");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_execution
   // Open this for debugging
   //for ($pc=1;$pc<=$paeend;++$pc) {
   //     if ($pae_head_use[$pc] == 1) {
   //         $wdth = "75px";
   //         print("<th bgcolor=\"#FFFFCC\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
   //                 <font color=\"#330099\">
   //                  $pc
   //                 </font>
   //                </th>        
   //         ");
   //    }   
   //}
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_work_effort
   // Open this for debugging
   $bpc = 0;
   //print("PWECOL: ".$pwecol."<br>");
   for ($pc=1;$pc<=$pweend;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 3){
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#FFFFCC";
            $fcolr = "#330099";
        }
        //print("PC: ".$pc." - BPC: ".$bpc."HEADING: ".$pwe_head_use[$pc]."<br>");
        if ($pwe_head_use[$pc] == 1) {
            $wdth = "75px";
            if ($bpc >= 4 && $bpc <= 7){ 
                if ($bpc == 6 || $bpc == 7){
                  print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                          <font color=\"$fcolr\">
                           $analsis3[$pc]%
                          </font>
                         </th>        
                  ");
                } else {
                  print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                          <font color=\"$fcolr\">
                           $analsis3[$pc]
                          </font>
                         </th>        
                  ");
                }
           } else {
                print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"$fcolr\">
                         &nbsp
                        </font>
                       </th>        
                ");
           }
       }   
       if ($bpc == $pwecol){
           $bpc = 0;
       }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_area_issue_summary
   // Open this for debugging
   //$bpc = 0;
   for ($pc=1;$pc<=$pc4h;++$pc) {
        $bpc = $bpc + 1;
        if ($bpc == 1){
            $bcolr = "#E8E8E8";
            $fcolr = "#FF0000";
        } else {
            $bcolr = "#FFFFCC";
            $fcolr = "#330099";
        }
        $wdth = "75px";
        if (trim($piaxp[$pc]) == 1){
            if ($grtchk[$pc] == 0){
                $analsis4x[$pc] = $analsis4x[$pc]."<br>NOT USED";
            }
            print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $analsis4[$pc]<br> $analsis4x[$pc]
                    </font>
                   </th>        
            ");
        } else { 
            print("<th bgcolor=\"$bcolr\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                    <font color=\"$fcolr\">
                     $analsis4[$pc]
                    </font>
                   </th>        
            ");
        }    
        //} else {
        //    print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
        //            <font color=\"#330099\">
        //             &nbsp
        //            </font>
        //           </th>        
        //    ");
        //}
        if ($bpc == $pc4){
            $bpc = 0;
        }
   }
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_issue_summary
   // Open this for debugging
   for ($pc=1;$pc<=$pc5h;++$pc) {
        $wdth = "75px";
        $wdth = "75px";
        if (trim($piixp[$pc]) == 1){
            if ($grtchk2[$pc] == 0){
                $analsis5x[$pc] = $analsis5x[$pc]."<br>NOT USED";
            }
            if ($piic[$pc] == "ROT"){
                print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"#330099\">
                         $analsis5[$pc]<br><br>$totalrot2<br><br>$analsis5x[$pc]
                        </font>
                       </th>        
                ");
            }
        } else { 
            if ($piic[$pc] == "ROT"){
                print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"#330099\">
                         $analsis5[$pc]<br><br>$totalrot2
                        </font>
                       </th>        
                ");
            }
            if ($piic[$pc] == "GRT"){
                print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"#330099\">
                         $analsis5[$pc]
                        </font>
                       </th>        
                ");
            }
            if ($piic[$pc] == "CNT"){
                print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
                        <font color=\"#330099\">
                         $analsis5[$pc]<br><br>$totalcnt2
                        </font>
                       </th>        
                ");
            }
        }    
        //print("<th bgcolor=\"#FFFFCC\" align=\"left\" valign=\"top\" style=\"width: $wdth;\">
        //        <font color=\"#330099\">
        //         $analsis5[$pc]
        //        </font>
        //       </th>        
        //");
   }
   print("</tr>");
   // ===========
   // Summary End 
   // =========== 















   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////////////////
   // =============
   // Details Start 
   //$rowcount = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
    //if ($xpdp[$tp][$pcol] == 1){
        //$rowcount = $rowcount + 1;
        print("<tr>");
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_main
        for ($pc=1;$pc<=$pcol;++$pc) {
             if ($pdp_head_use[$pc] == 1) { 
                 if ($pc == 3 || $pc == 11){ 
                     $wdth = "150px";
                 } else {
                     $wdth = "75px"; 
                 }
                 //if ($pc == 1){
                     //$val = $rowcount;
                 //} else {
                 $val = $xpdp[$tp][$pc];
                 //}
                 if ($pc == 2 || $pc == 20){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099";
                 }
                 if ($pc == 2){
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            <!--<a href=\"javascript:void(0);\" onclick=\"PopupCenter('../pdp_issue_summary.php?pdpdesc=$val', 'myPop1',1200,800);\">$val</a>-->
                            <a href=\"javascript:void(0);\" onclick=\"popup('../pdp_issue_summary.php?pdpdesc=$val')\">$val</a>
                           </font>
                          </td>        
                   ");
                 } else {
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            $val
                           </font>
                          </td>        
                   ");
                 }
             }   
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_execution
        $bpc = 0;
        for ($pc=1;$pc<=$paeend;++$pc) {
             $bpc = $bpc + 1;
             if ($pae_head_use[$pc] == 1) {
                 $wdth = "75px"; 
                 $val = $pae[$tp][$pc]; 
                 if (($bpc == 3 || $bpc == 4 || $bpc == 5 || $bpc == 6) || $pc >= ($paeend - 2)){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099"; 
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             }
             if ($bpc == $paecol){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_work_effort
        $bpc = 0;
        for ($pc=1;$pc<=$pweend;++$pc) {
             $bpc = $bpc + 1;
             if ($pwe_head_use[$pc] == 1) {
                 $wdth = "75px"; 
                 if ($bpc == 6 || $bpc == 7){
                     $val = $pwe[$tp][$pc]."%";
                 } else {
                     $val = $pwe[$tp][$pc];
                 }
                 if ($bpc == 3 || $bpc == 4 || $bpc == 5 || $bpc == 6 || $bpc == 7){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099"; 
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             }
             if ($bpc == $pwecol){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_issue_summary
        $bpc = 0;
        for ($pc=1;$pc<=$pc4h;++$pc) {
             $bpc = $bpc + 1;
                 $wdth = "75px"; 
                 $val = $pia[$tp][$pc];
                 if ($bpc == 1){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099"; 
                 }
                 if ($val == 0){
                 } else {
                   if($piac[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                      $fcolr = "#330099";
                   }
                   if($piac[$pc] == "CNT"){
                      if($piar[$pc] == "NO" || $piar[$pc] == $pia_head[$pc]){
                         $bcolr = "#9AFEFF";
                         $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
                      
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             if ($bpc == $pc4){
                 $bpc = 0;
             }
        }
        //////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_area_issue_summary
        $bpc = 0;
        for ($pc=1;$pc<=$pc5h;++$pc) {
             $bpc = $bpc + 1;
                 $wdth = "75px"; 
                 $val = $pii[$tp][$pc];
                 //if ($bpc == 1){ 
                 //    $bcolr = "#E8E8E8";
                 //    $fcolr = "#FF0000";
                 //} else {
                 //    $bcolr = "#FFFFFF";
                 //    $fcolr = "#330099"; 
                 //}
                 if ($val == 0){
                     $bcolr = "#FFFFFF";
                     $fcolr = "#330099";
                 } else {
                   if($piic[$pc] == "ROT"){
                      $bcolr = "#CCFFCC";
                      $fcolr = "#330099";
                   }
                   if($piic[$pc] == "GRT"){
                      $bcolr = "#FFFF00";
                      $fcolr = "#330099";
                   }
                   if($piic[$pc] == "CNT"){
                      if($piir[$pc] == "NO" || $piir[$pc] == $pii_head[$pc]){
                         $bcolr = "#9AFEFF";
                         $fcolr = "#330099";
                      } else {
                         $bcolr = "#FFFF00";
                         $fcolr = "#330099";
                      }
                   }
                      
                 }
                 print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                         <font color=\"$fcolr\">
                          $val
                         </font>
                        </td>        
                 ");
             if ($bpc == $pc4){
                 $bpc = 0;
             }
        }
        print("</tr>");
    //}    
   }
   print("     </table>
              </div>
             </div>
            </body>
           </html>                     
   ");
   // =============
   // Details End 
   // ============= 
   $xfilters = "Type = ".$prd."<br>REVENUE ASSURANCE TESTING = ".$ra_ind."<br>PDP CATEGORY = ".$pdpcat."<br>LAUNCH DATE BETWEEN ".$xldate." AND ".$xldate2;
   $xreport_name = "FULL EXTRACT"; 
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
    print("<form method=\"post\" action=\"./report4yy.php\">
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">Select PDP Type:</font>
             </td>
             <td> 
              <select name=\"prd\">
    ");
    $p = 0;
    print("<option selected value=\"ALL\">ALL</option>");
    for ($p=1;$p<=$prdcnt ; ++$p) {
        print("<option value=\"$xpdp_prd[$p]\">$xpdp_prd[$p]</option>");
    }     
    print("
              </select>
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">
               RA Testing:
              </font>
             </td>
             <td align=\"left\" valign=\"middle\">
              <select align=\"left\" name=\"ra_ind\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\">
    ");
    $e = 0;
    print(" <option selected value=\"BOTH\">BOTH</option> ");
    for ($e=1;$e<=2; ++$e) {
         print(" <option value=\"$ind[$e]\">$ind[$e]</option> "); 
    }                         
    print("   </select>
             <input type=\"hidden\" name=\"yshort_desc\" value=\"RA\"> 
             </td>
    ");         
    //$queryt1       = "select distinct(pdp_category) 
    //                    from ".$name.".cube1_main
    //                   where pdp_category <> '' ";
    $queryt1       = "select concat(c.category_scope,' - ',p.pdp_category) as pdpcat 
                        from ".$name.".pdp_categories p, category_scope c
                       where p.category_scope_id = c.category_scope_id 
                    group by c.category_scope,p.pdp_category ";
    $mysql_datat1  = mysql_query($queryt1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1       = mysql_num_rows($mysql_datat1); 
    $catcnt        = 0;
    while($rowt1 = mysql_fetch_row($mysql_datat1)) {
          $catcnt            = $catcnt + 1;
          $pdpcat            = stripslashes($rowt1[0]);
          $xpdpcat[$catcnt] = $pdpcat;
    }
    print(" <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\">
              <font color=\"#330099\">Select PDP Category:</font>
             </td>
             <td> 
              <select name=\"pdpcat\">
    ");
    $c = 0;
    print("<option selected value=\"ALL\">ALL</option>");
    for ($c=1;$c<=$catcnt ; ++$c) {
        print("<option value=\"$xpdpcat[$c]\">$xpdpcat[$c]</option>");
    }     
    print("
              </select>
             </td>
            </tr> 
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:150px;\"><font color=\"#330099\">Launch Date (dd-mm-yyyy)</font></td>
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:150px;\">
              <font color=\"#330099\">
    ");
    $yms = 9;
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
         if ($yys == $xyr_s) {
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
             <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFFF\" style=\"width:150px;\">
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
         if ($yys == $xyr_s) {
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

   print("<form method=\"post\" action=\"./report4yy.php\"> 
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
              <tr>
               <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">ID</font</td>
               <!--<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Pathname</font</td>-->
               <td bgcolor=\"#99CCFF\" align=\"center\" style=\"width: 400px;\"><font color=\"#330099\">Ran Date</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Ran By</font</td>
               <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Extract</font</td>
               <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Delete</font</td>
              </tr>
   ");

   $query = "  select saved_report_id,report_name,filters,report_path,etl_id,report_timestamp,ran_by from ".$name.".saved_reports
                where rtrim(report_name) = 'FULL EXTRACT'
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
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\">
	             <font color=\"#330099\"> 
                  $yetl_timestamp
                 </font>  	             
	            </td>
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
