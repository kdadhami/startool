<?php

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

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


//load status types
$query99 = "select status_type_id,status_type,status_color_code from ".$name.".status_types where status_type_ind = 1"; 
$mysql_data99 = mysql_query($query99, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt99 = mysql_num_rows($mysql_data99);    
$st_typ_cnt              = 1;
$st_typ_id[$st_typ_cnt]  = 0;
$st_typ[$st_typ_cnt]     = "";
$st_typ_clr[$st_typ_cnt] = "";
//print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
while($row99 = mysql_fetch_row($mysql_data99)) {
      $st_typ_cnt              = $st_typ_cnt + 1;
      $st_typ_id[$st_typ_cnt]  = stripslashes(trim($row99[0]));
      $st_typ[$st_typ_cnt]     = stripslashes(trim($row99[1]));      
      $st_typ_clr[$st_typ_cnt] = stripslashes(trim($row99[2]));
      //print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
}
//print($st_typ_cnt);

$queryx = "select issue_type_id,issue_type,issue_type_ind from ".$name.".issue_types order by issue_type asc"; //where issue_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax); 
//print($rowcntx);   

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

// Select PDP Periods
$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1"; 
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

//loading departments
$queryx2 = "select issue_area_id,issue_area,short_desc from ".$name.".issue_areas where issue_area_ind = 1 and test_ind = 1 "; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx2 = mysql_num_rows($mysql_datax2);    

$dept_cnt = 0;
//$dept_id[$dept_cnt] = 0;
//$dept[$dept_cnt] = "";
while($rowx2 = mysql_fetch_row($mysql_datax2)) {
      $dept_cnt             = $dept_cnt + 1;
      $dept_id[$dept_cnt]   = stripslashes(trim($rowx2[0]));
      $dept[$dept_cnt]      = stripslashes(trim($rowx2[1]));
      $dept_code[$dept_cnt] = stripslashes(trim($rowx2[2]));      
}

// Yes and No Values
$ind[0]    = "";
$ind[1]    = "Yes";
$ind[2]    = "No";
$ind_id[0] = 0;
$ind_id[1] = 1;
$ind_id[2] = 0;

//loading Scope Categories (i.e. In Scope or Out of Scope)
$queryx5 = "select category_scope_id,category_scope from ".$name.".category_scope where category_scope_ind = 1 order by category_scope_id "; 
$mysql_datax5 = mysql_query($queryx5, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx5 = mysql_num_rows($mysql_datax5);    
$scope_cnt = 0;
while($rowx5 = mysql_fetch_row($mysql_datax5)) {
      $scope_cnt            = $scope_cnt + 1;
      $scope_id[$scope_cnt] = stripslashes(trim($rowx5[0]));
      $scope[$scope_cnt]    = stripslashes(trim($rowx5[1]));
}

//loading PDP Categories
$queryx4 = "select pdp_category_id,pdp_category,category_scope_id from ".$name.".pdp_categories where pdp_category_ind = 1 order by category_scope_id "; 
$mysql_datax4 = mysql_query($queryx4, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntx4 = mysql_num_rows($mysql_datax4);    
//print($rowcntx4);
$pcat_cnt = 0;
$s = 0;
//for ($i=1;$i<=$scope_cnt ; ++$i) {
     $pcat_cnt            = $pcat_cnt + 1;
     $pcat_id[$pcat_cnt]  = 0;
     $pcat[$pcat_cnt]     = "VALUE NOT SET";
     $scp_id[$pcat_cnt]   = 0;
     //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");
     $pcat_cnt            = $pcat_cnt + 1;
     $s                   = $s + 1;
     $pcat_id[$pcat_cnt]  = -1;
     $pcat[$pcat_cnt]     = $scope[$s];
     $scp_id[$pcat_cnt]   = $scope_id[$s];
     //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");
     //$chk = 0;
     while($rowx4 = mysql_fetch_row($mysql_datax4)) {
           //$chk = $chk + 1;
           $pcat_cnt               = $pcat_cnt + 1;
           $scp_id[$pcat_cnt]      = stripslashes(trim($rowx4[2]));
           //print("Scope Id: ".$scp_id[$pcat_cnt]."-");
           if ($scp_id[$pcat_cnt] <> $scp_id[$pcat_cnt-1]) {
               $s                  = $s + 1;
               $pcat_id[$pcat_cnt] = -1;
               $pcat[$pcat_cnt]    = $scope[$s];
               //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");
               $pcat_cnt           = $pcat_cnt + 1;
               $pcat_id[$pcat_cnt] = stripslashes(trim($rowx4[0]));
               $pcat[$pcat_cnt]    = stripslashes(trim($rowx4[1]));
               $scp_id[$pcat_cnt]  = stripslashes(trim($rowx4[2]));
               //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");               
           } else
           {
               $pcat_id[$pcat_cnt] = stripslashes(trim($rowx4[0]));
               $pcat[$pcat_cnt]    = stripslashes(trim($rowx4[1]));
               //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");
           }
           //print($pcat_cnt."-".$pcat_id[$pcat_cnt]."-".$pcat[$pcat_cnt]."<br>");
     }
//print($pcat_cnt);     
//print ("check while count: ".$chk);
//}

//loading Status Types (i.e. High Medium Low)
$query6 = "select status_type_id,status_type from ".$name.".status_types where status_type_ind = 1 order by status_type_id "; 
$mysql_data6 = mysql_query($query6, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt6 = mysql_num_rows($mysql_data6);    
$st_cnt = 0;
while($row6 = mysql_fetch_row($mysql_data6)) {
      $st_cnt             = $st_cnt + 1;
      $status_id[$st_cnt] = stripslashes(trim($row6[0]));
      $status[$st_cnt]    = stripslashes(trim($row6[1]));
}
//print("status count: ".$st_cnt."<br>");

//loading Complexities
$query21 = "select complexity_id,complexity,status_type_id from ".$name.".complexity where complexity_ind = 1 and status_type_id <> 0 order by status_type_id,complexity asc "; 
$mysql_data21 = mysql_query($query21, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt21 = mysql_num_rows($mysql_data21);    
//print($rowcnt21."<br>");
$comp_cnt = 0;
//$s1 = 0;
//for ($i=1;$i<=$scope_cnt ; ++$i) {
     $comp_cnt           = $comp_cnt + 1;
     $comp_id[$comp_cnt] = 0;
     $comp[$comp_cnt]    = "VALUE NOT SET";
     $st_id[$comp_cnt]   = 0;
     //print($comp_cnt."-".$comp_id[$comp_cnt]."-".$comp[$comp_cnt]."<br>");
     while($row21 = mysql_fetch_row($mysql_data21)) {
           $comp_cnt = $comp_cnt + 1;
           $chkst    = stripslashes(trim($row21[2])); 
           //print($chkst."-".$st_id[$comp_cnt - 1]."<br>");
           if ($chkst <> $st_id[$comp_cnt - 1]) {
               //print("I am here");
               //loading Status Types (i.e. High Medium Low)
               $query6      = "select status_type from ".$name.".status_types where status_type_id =  '$chkst' "; 
               $mysql_data6 = mysql_query($query6, $mysql_link) or die ("Could not query: ".mysql_error());
               $rowcnt6     = mysql_num_rows($mysql_data6);
               //print("Rows fetched:".$rowcnt6."<br>");    
               //$st_cnt = 0;
               while($row6 = mysql_fetch_row($mysql_data6)) {
                     //print("I am here");
                     $comp_id[$comp_cnt] = -1;
                     $comp[$comp_cnt]    = stripslashes(trim($row6[0]));
                     $st_id[$comp_cnt]   = stripslashes(trim($row21[2]));
                     //print($comp_cnt."-".$comp_id[$comp_cnt]."-".$comp[$comp_cnt]."<br>");
                     $comp_cnt           = $comp_cnt + 1;
                     $comp_id[$comp_cnt] = stripslashes(trim($row21[0]));
                     $comp[$comp_cnt]    = stripslashes(trim($row21[1]));
                     $st_id[$comp_cnt]   = stripslashes(trim($row21[2]));
                     //print($comp_cnt."-".$comp_id[$comp_cnt]."-".$comp[$comp_cnt]."<br>");
               }
           }
           else
           { 
               $comp_id[$comp_cnt] = stripslashes(trim($row21[0]));
               $comp[$comp_cnt]    = stripslashes(trim($row21[1]));
               $st_id[$comp_cnt]   = stripslashes(trim($row21[2]));
               //print($comp_cnt."-".$comp_id[$comp_cnt]."-".$comp[$comp_cnt]."<br>");
           }
     }
//print("Count is: ".$comp_cnt);     
//}

//loading Revenue
$query22 = "select revenue_id,revenue,status_type_id from ".$name.".revenue where revenue_ind = 1 and status_type_id <> 0 order by status_type_id,revenue asc "; 
$mysql_data22 = mysql_query($query22, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt22 = mysql_num_rows($mysql_data22);    
//print($rowcnt21."<br>");
$revn_cnt = 0;
//$s1 = 0;
//for ($i=1;$i<=$scope_cnt ; ++$i) {
     $revn_cnt           = $revn_cnt + 1;
     $revn_id[$revn_cnt] = 0;
     $revn[$revn_cnt]    = "VALUE NOT SET";
     $st_id[$revn_cnt]   = 0;
     //print($revn_cnt."-".$revn_id[$revn_cnt]."-".$revn[$revn_cnt]."<br>");
     while($row22 = mysql_fetch_row($mysql_data22)) {
           $revn_cnt = $revn_cnt + 1;
           $chkst    = stripslashes(trim($row22[2])); 
           //print($chkst."-".$st_id[$revn_cnt - 1]."<br>");
           if ($chkst <> $st_id[$revn_cnt - 1]) {
               //print("I am here");
               //loading Status Types (i.e. High Medium Low)
               $query6      = "select status_type from ".$name.".status_types where status_type_id =  '$chkst' "; 
               $mysql_data6 = mysql_query($query6, $mysql_link) or die ("Could not query: ".mysql_error());
               $rowcnt6     = mysql_num_rows($mysql_data6);
               //print("Rows fetched:".$rowcnt6."<br>");    
               //$st_cnt = 0;
               while($row6 = mysql_fetch_row($mysql_data6)) {
                     //print("I am here");
                     $revn_id[$revn_cnt] = -1;
                     $revn[$revn_cnt]    = stripslashes(trim($row6[0]));
                     $st_id[$revn_cnt]   = stripslashes(trim($row22[2]));
                     //print($revn_cnt."-".$revn_id[$revn_cnt]."-".$revn[$revn_cnt]."<br>");
                     $revn_cnt           = $revn_cnt + 1;
                     $revn_id[$revn_cnt] = stripslashes(trim($row22[0]));
                     $revn[$revn_cnt]    = stripslashes(trim($row22[1]));
                     $st_id[$revn_cnt]   = stripslashes(trim($row22[2]));
                     //print($revn_cnt."-".$revn_id[$revn_cnt]."-".$revn[$revn_cnt]."<br>");
               }
           }
           else
           { 
               $revn_id[$revn_cnt] = stripslashes(trim($row22[0]));
               $revn[$revn_cnt]    = stripslashes(trim($row22[1]));
               $st_id[$revn_cnt]   = stripslashes(trim($row22[2]));
               //print($revn_cnt."-".$revn_id[$revn_cnt]."-".$revn[$revn_cnt]."<br>");
           }
     }


//loading Projection
$query23 = "select projection_id,projection,status_type_id from ".$name.".projection where projection_ind = 1 and status_type_id <> 0 order by status_type_id,projection asc "; 
$mysql_data23 = mysql_query($query23, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt23 = mysql_num_rows($mysql_data23);    
//print($rowcnt21."<br>");
$prjc_cnt = 0;
//$s1 = 0;
//for ($i=1;$i<=$scope_cnt ; ++$i) {
     $prjc_cnt           = $prjc_cnt + 1;
     $prjc_id[$prjc_cnt] = 0;
     $prjc[$prjc_cnt]    = "VALUE NOT SET";
     $st_id[$prjc_cnt]   = 0;
     //print($prjc_cnt."-".$prjc_id[$prjc_cnt]."-".$prjc[$prjc_cnt]."<br>");
     while($row23 = mysql_fetch_row($mysql_data23)) {
           $prjc_cnt = $prjc_cnt + 1;
           $chkst    = stripslashes(trim($row23[2])); 
           //print($chkst."-".$st_id[$prjc_cnt - 1]."<br>");
           if ($chkst <> $st_id[$prjc_cnt - 1]) {
               //print("I am here");
               //loading Status Types (i.e. High Medium Low)
               $query6      = "select status_type from ".$name.".status_types where status_type_id =  '$chkst' "; 
               $mysql_data6 = mysql_query($query6, $mysql_link) or die ("Could not query: ".mysql_error());
               $rowcnt6     = mysql_num_rows($mysql_data6);
               //print("Rows fetched:".$rowcnt6."<br>");    
               //$st_cnt = 0;
               while($row6 = mysql_fetch_row($mysql_data6)) {
                     //print("I am here");
                     $prjc_id[$prjc_cnt] = -1;
                     $prjc[$prjc_cnt]    = stripslashes(trim($row6[0]));
                     $st_id[$prjc_cnt]   = stripslashes(trim($row23[2]));
                     //print($prjc_cnt."-".$prjc_id[$prjc_cnt]."-".$prjc[$prjc_cnt]."<br>");
                     $prjc_cnt           = $prjc_cnt + 1;
                     $prjc_id[$prjc_cnt] = stripslashes(trim($row23[0]));
                     $prjc[$prjc_cnt]    = stripslashes(trim($row23[1]));
                     $st_id[$prjc_cnt]   = stripslashes(trim($row23[2]));
                     //print($prjc_cnt."-".$prjc_id[$prjc_cnt]."-".$prjc[$prjc_cnt]."<br>");
               }
           }
           else
           { 
               $prjc_id[$prjc_cnt] = stripslashes(trim($row23[0]));
               $prjc[$prjc_cnt]    = stripslashes(trim($row23[1]));
               $st_id[$prjc_cnt]   = stripslashes(trim($row23[2]));
               //print($prjc_cnt."-".$prjc_id[$prjc_cnt]."-".$prjc[$prjc_cnt]."<br>");
           }
     }


//loading Comparison
$query24 = "select comparison_id,comparison,status_type_id from ".$name.".comparison where comparison_ind = 1 and status_type_id <> 0 order by status_type_id,comparison asc "; 
$mysql_data24 = mysql_query($query24, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcnt24 = mysql_num_rows($mysql_data24);    
//print($rowcnt21."<br>");
$cmpr_cnt = 0;
//$s1 = 0;
//for ($i=1;$i<=$scope_cnt ; ++$i) {
     $cmpr_cnt           = $cmpr_cnt + 1;
     $cmpr_id[$cmpr_cnt] = 0;
     $cmpr[$cmpr_cnt]    = "VALUE NOT SET";
     $st_id[$cmpr_cnt]   = 0;
     //print($cmpr_cnt."-".$cmpr_id[$cmpr_cnt]."-".$cmpr[$cmpr_cnt]."<br>");
     while($row24 = mysql_fetch_row($mysql_data24)) {
           $cmpr_cnt = $cmpr_cnt + 1;
           $chkst    = stripslashes(trim($row24[2])); 
           //print($chkst."-".$st_id[$cmpr_cnt - 1]."<br>");
           if ($chkst <> $st_id[$cmpr_cnt - 1]) {
               //print("I am here");
               //loading Status Types (i.e. High Medium Low)
               $query6      = "select status_type from ".$name.".status_types where status_type_id =  '$chkst' "; 
               $mysql_data6 = mysql_query($query6, $mysql_link) or die ("Could not query: ".mysql_error());
               $rowcnt6     = mysql_num_rows($mysql_data6);
               //print("Rows fetched:".$rowcnt6."<br>");    
               //$st_cnt = 0;
               while($row6 = mysql_fetch_row($mysql_data6)) {
                     //print("I am here");
                     $cmpr_id[$cmpr_cnt] = -1;
                     $cmpr[$cmpr_cnt]    = stripslashes(trim($row6[0]));
                     $st_id[$cmpr_cnt]   = stripslashes(trim($row24[2]));
                     //print($cmpr_cnt."-".$cmpr_id[$cmpr_cnt]."-".$cmpr[$cmpr_cnt]."<br>");
                     $cmpr_cnt           = $cmpr_cnt + 1;
                     $cmpr_id[$cmpr_cnt] = stripslashes(trim($row24[0]));
                     $cmpr[$cmpr_cnt]    = stripslashes(trim($row24[1]));
                     $st_id[$cmpr_cnt]   = stripslashes(trim($row24[2]));
                     //print($cmpr_cnt."-".$cmpr_id[$cmpr_cnt]."-".$cmpr[$cmpr_cnt]."<br>");
               }
           }
           else
           { 
               $cmpr_id[$cmpr_cnt] = stripslashes(trim($row24[0]));
               $cmpr[$cmpr_cnt]    = stripslashes(trim($row24[1]));
               $st_id[$cmpr_cnt]   = stripslashes(trim($row24[2]));
               //print($cmpr_cnt."-".$cmpr_id[$cmpr_cnt]."-".$cmpr[$cmpr_cnt]."<br>");
           }
     }

//$usr = strtoupper(trim(getenv("username")));

// setting up today's date
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

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

// =========================================================================================
// Start of ETL
// =========================================================================================

   //$captn = "PDP Summary Report";
   //print("     <table border='1' scroll=\"yes\" style=\"width: 300%; border-style:solid; border-color:#CCCCCC;\" >
   //                 <caption >$captn</caption>
   //");             
   $queryx      = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                          a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                          a.revenue_id,a.comparison_id,a.pdp_period_id,b.pdp_period,a.main_pdp_id,a.parent_pdp_id 
                     from ".$name.".pdp a, pdp_periods b 
                    where a.pdp_period_id = b.pdp_period_id
                 order by main_pdp_id,a.pdp_id ";
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx     = mysql_num_rows($mysql_datax);
   $trucnt      = 0;
   $xjob_log   = "Job Started at: ".date("l F d, Y, h:i:s A").chr(10)."Query:".chr(10).$queryx.chr(10);
   $xjob_log_y = "Job Started at: ".date("l F d, Y, h:i:s A")."<br> Query:<br>".$queryx."<br>";     
   // *******************
   // writing etl_monitor
   // *******************
   $query101 = "INSERT into ".$name.".etl_monitor(etl_status,target_cube,header_rows,detail_rows,footer_rows,ran_by,job_log)
                VALUES('ETL Initiated','cube_1_main',0,0,0,'$usr','$xjob_log')";
   $mysql_data101 = mysql_query($query101, $mysql_link) or die ("Could not query: ".mysql_error());
   $xetl_id = mysql_insert_id();
   // *******************
   // *******************
   print($xjob_log_y);
   $xjob_log   = $xjob_log.chr(10)."ETL ID: ".$xetl_id.chr(10);
   $xjob_log_y = "ETL ID: ".$xetl_id."<br>"; 
   // ***************
   // updating status
   // ***************  
   $query111 = "UPDATE ".$name.".etl_monitor
                   SET job_log    = '$xjob_log',
                       etl_status = 'In-Process: Creating ETL ID'
                 WHERE etl_id     = '$xetl_id' ";
   $mysql_data111 = mysql_query($query111, $mysql_link) or die ("Could not query: ".mysql_error());
   // ***************
   // ***************
   print($xjob_log_y);

   // $rowcntx is no. of pdps found
   $seq1 = 0;
   $seq  = 0;
   if ($rowcntx > 0) {
       //$found  = 1;
       $tbrun    = 0;
       $tinvc    = 0;
       $tppw     = 0;
       $tdfct    = 0;
       $tprwk    = (float)0;
       $tisue    = 0;
       $t_total  = array();

       if ($xpdp_period_id == 0) {
           $xpdp_period = "VALUE NOT SET";
       } else {
                     $query100 = "select b.pdp_period 
                                    from ".$name.".pdp a, pdp_periods b 
                                   where a.pdp_desc = '$pdp' 
                                     and a.pdp_period_id = b.pdp_period_id";
                     //print($query100);
                     $mysql_data100 = mysql_query($query100, $mysql_link) or die ("Could not query: ".mysql_error());
                     $rowcnt100 = mysql_num_rows($mysql_data100);
                     //if ($rowcnt100 <> 0) {
                         while($row100 = mysql_fetch_row($mysql_data100)) {
                               $xpdp_period = stripslashes(trim($row100[0]));
                         }
                     //} else {
                     //$xpdp_period = "VALUE NOT SET";
                     //}
       }
       while($rowx = mysql_fetch_row($mysql_datax)) {
             $seq              = $seq + 1;
	         $xid              = stripslashes($rowx[0]);
	         $xpdp_desc        = stripslashes($rowx[1]);
             $xupdated_date    = stripslashes($rowx[2]);
             $xd               = date("d",$xupdated_date);
             $xm               = date("M",$xupdated_date);
             $xy               = date("Y",$xupdated_date);
             $xdt              = $xd."-".$xm."-".$xy;
             $xupdated_by      = stripslashes($rowx[3]);
             $xpdp_name        = stripslashes($rowx[4]);    
             $xpdp_owner       = stripslashes($rowx[5]); 
             $xpdp_launch      = stripslashes($rowx[6]);
             $xpdp_status      = stripslashes($rowx[7]); 
             $xpdp_period_id   = stripslashes($rowx[8]);
             $xpdp_category_id = stripslashes($rowx[9]);
             $xcomplexity_id   = stripslashes($rowx[10]);
             $xprojection_id   = stripslashes($rowx[11]);
             $xrevenue_id      = stripslashes($rowx[12]);
             $xcomparison_id   = stripslashes($rowx[13]);
             $xpdp_period_id   = stripslashes($rowx[14]);
             $xpdp_period      = stripslashes($rowx[15]);
             $xmain_pdp_id     = stripslashes($rowx[16]);
             $xparent_pdp_id   = stripslashes($rowx[17]);
             $xpdp_owner       = str_replace("'","",$xpdp_owner);

             if (empty($xparent_pdp_id) && empty($xmain_pdp_id)){
                 $xparent_pdp_id = $xid;
                 $xmain_pdp_id   = $xid;
             }

             if (empty($xpdp_launch)){
                 $xpdp_launch_dt = "-";
                 $xdate = "0000-00-00 00:00:00";
                 //print ("True");
                 //$trucnt = $trucnt + 1;
             } else {
                     $xld            = date("d",$xpdp_launch);
                     $xlm            = date("M",$xpdp_launch);
                     $xly            = date("Y",$xpdp_launch);
                     $xpdp_launch_dt = $xld."-".$xlm."-".$xly;
                     $xdate          = date("Y-m-d",$xpdp_launch)." 00:00:00";
             }

             // --------------------------------------------------- pdp_tesing
             $queryy = "select pdp_id,issue_area_id,test_ind 
                          from ".$name.".pdp_testing 
                         where pdp_id = '$xid'"; 
             $mysql_datay = mysql_query($queryy, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnty = mysql_num_rows($mysql_datay);  

             // Insert a record
             if ($rowcnty == 0) {
                $d = 0;
                for ($d=1;$d<=$dept_cnt ; ++$d) {
                         //test_ind = 0 means NO
                         $queryi = "INSERT into ".$name.".pdp_testing(pdp_id,issue_area_id,test_ind,short_desc)
                                    VALUES('$xid','$dept_id[$d]',0,'$dept_code[$d]')";
                         $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
                        }
             } 
             // --------------------------------------------------- pdp_tesing
       
       
       
             
       if ($seq == 1) { 
       //print("I am Here");     
       //========================================================
       //======== Table Headers Start ===========================
       //========================================================
       //print("
       //       <tr>
       //        <td bgcolor=\"#CCCCCC\" colspan=\"11\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //          PDP Information
       //         </font>
       //        </td>
       //        <td bgcolor=\"#CCCCCC\" colspan=\"6\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //          Scoping
       //         </font>
       //        </td>
       //        <td bgcolor=\"#CCCCCC\" colspan=\"9\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //          Testing Execution
       //         </font>
       //        </td>
       //        <td bgcolor=\"#CCCCCC\" colspan=\"$issue_typ_cnt\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //          Root Causes
       //         </font>
       //        </td>
       //        <td bgcolor=\"#CCCCCC\" colspan=\"2\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //         Extracted
       //         </font>
       //        </td>
       //       </tr>
       //");
       //print("
       //              <tr>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 PDP No.
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
       //                <font color=\"#330099\">
       //                 Description
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Owner
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Type
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Status
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Launch
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Parent PDP
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Main PDP
       //                </font>
       //               </td>                      
       //");
       $queryy2      = "select pdp_id,issue_area_id,test_ind 
                          from ".$name.".pdp_testing 
                         where pdp_id = '$xid'"; 
       $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnty2     = mysql_num_rows($mysql_datay2);  
       $y            = 0; 
       if ($rowcnty2 > 0) {
          while($rowy2 = mysql_fetch_row($mysql_datay2)) {
                $y                  = $y + 1;
	            $yissue_area_id[$y] = stripslashes($rowy2[1]);
                $ytest_ind[$y]      = stripslashes($rowy2[2]);

                //loading departments
                $queryx3 = "select issue_area 
                              from ".$name.".issue_areas 
                             where issue_area_id = '$yissue_area_id[$y]' "; 
                $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("Could not query: ".mysql_error());
                $rowcntx3 = mysql_num_rows($mysql_datax3);    
                while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                      $deptx = stripslashes(trim($rowx3[0]));
                }
                //print("<td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">$deptx Testing</font></td>");
          }
       }
       //print("
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Issue Created
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:150px;\">
       //                <font color=\"#330099\">
       //                 PDP Category
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Scoping
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Complexity
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Revenue Impact
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Customer Impact
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Past Impact
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Execution Start Date
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Execution End Date
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Bill Runs
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Invoice Generated
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 PPW Changes
       //                </font>
       //               </td>
       //               <!--<td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Defects
       //                </font>
       //               </td>-->
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Launch in Jeopardy
       //              </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Baseline Work (Hours)
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Rework (Hours)
       //                </font>
       //               </td>                      
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Percentage Rework
       //                </font>
       //               </td>
       //");
       // print("
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Issue Created
       //                </font>
       //               </td>
       // ");
       $query79      = "select issue_type_id,issue_type,issue_type_ind 
                          from ".$name.".issue_types
                      order by issue_type"; 
       $mysql_data79 = mysql_query($query79, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt79     = mysql_num_rows($mysql_data79); 

       $isue_typ_cnt = 0;
       while($row79 = mysql_fetch_row($mysql_data79)) {
             $isue_typ_cnt                      = $isue_typ_cnt + 1;
             $isue_typ_id[$isue_typ_cnt]        = stripslashes($row79[0]);            //all issues types
             $isue_typ[$isue_typ_cnt]           = stripslashes($row79[1]);
             $isue_typ_ind[$isue_typ_cnt]       = stripslashes($row79[2]);
             $isue_typ_used_isue[$isue_typ_cnt] = 0;                                  // will be used to accumulate total
        }
        for ($t=1;$t<=$isue_typ_cnt ; ++$t) {
            $ptotal            = $isue_typ_used_isue[$t];
            $p_total[$xid][$t] = $ptotal; 
            //print("
            //          <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
            //           <font color=\"#330099\">
            //            $isue_typ[$t] 
            //           </font>
            //          </td>
            //"); 
        }       
        //print("
        //              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
        //               <font color=\"#330099\">
        //                On
        //               </font>
        //              </td>
        //              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
        //               <font color=\"#330099\">
        //                By
        //               </font>
        //              </td>
        //             </tr>
        //");
       }
       //======== Table Headers End =============================
       //========================================================
       //========================================================
       
       
       
       //======== Table Details Start =============================
       //========================================================
       //========================================================
       //print("
       //     <tr>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
	   //       <font color=\"#330099\"> 
       //        $xpdp_desc
       //       </font> 
       //      </td>
       //");
       $queryx2      = "select pdp_desc from ".$name.".pdp where pdp_id = '$xmain_pdp_id'"; 
       $mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcntx2     = mysql_num_rows($mysql_datax2);  
       $x2           = 0; 
       if ($rowcntx2 > 0) {
          while($rowx2 = mysql_fetch_row($mysql_datax2)) {
	            $xmain_pdp_desc = stripslashes($rowx2[0]);
          }
       } else {
                $xmain_pdp_desc = "";
       }          
       $queryx3      = "select pdp_desc from ".$name.".pdp where pdp_id = '$xparent_pdp_id'"; 
       $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcntx3     = mysql_num_rows($mysql_datax3);  
       $x3           = 0; 
       if ($rowcntx3 > 0) {
          while($rowx3 = mysql_fetch_row($mysql_datax3)) {
	            $xparent_pdp_desc = stripslashes($rowx3[0]);
          }
       } else {
                $xparent_pdp_desc = "";
       }
       //print("  
       //      <td bgcolor=\"#FFFFFF\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
       //       <font color=\"#330099\">                
       //        <p>$xpdp_name</p>
       //       </font>
       //      </td>             
	   //      <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
	   //        <font color=\"#330099\"> 
       //         $xpdp_owner
       //        </font> 	            
	   //       </td>
       //      <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //        <font color=\"#330099\">  
       //         $xpdp_period
       //        </font>
       //      </td>
       //      <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
	   //        <font color=\"#330099\"> 
       //         $xpdp_status
       //        </font> 
       //       </td>
       //      <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
       //       <font color=\"#330099\">
       //        $xpdp_launch_dt
       //       </font>
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //       <font color=\"#330099\">
       //        <p>$xparent_pdp_desc</p>                
       //       </font>
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //       <font color=\"#330099\">                
       //       <p>$xmain_pdp_desc</p>
       //       </font>
       //      </td>
       //");      
       // --------------------------------------------------- pdp_tesing  
       // Display records for update
       $queryy2      = "select pdp_id,issue_area_id,test_ind 
                          from ".$name.".pdp_testing 
                         where pdp_id = '$xid'"; 
       $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnty2     = mysql_num_rows($mysql_datay2);  
       $y            = 0; 
       if ($rowcnty2 > 0) {
          while($rowy2 = mysql_fetch_row($mysql_datay2)) {
                $y                  = $y + 1;
	            $yissue_area_id[$y] = stripslashes($rowy2[1]);
                $ytest_ind[$y]      = stripslashes($rowy2[2]);

                //loading departments
                $queryx3      = "select issue_area,short_desc 
                                   from ".$name.".issue_areas 
                                  where issue_area_id = '$yissue_area_id[$y]' "; 
                $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("Could not query: ".mysql_error());
                $rowcntx3     = mysql_num_rows($mysql_datax3);    
                while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                      $deptx       = stripslashes(trim($rowx3[0]));
                      $xshort_desc = stripslashes(trim($rowx3[1])); 
                }
                     //print("
                     //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" width=\"75px\">
                     //         <font color=\"#330099\">
                     //");
                     for ($e=1;$e<=2; ++$e) {
                          if ($ytest_ind[$y] == $ind_id[$e]) {
                              //print("$ind[$e]");
                              // ***************
                              // writing cube1_a
                              // *************** 
                              $query102 = "INSERT into ".$name.".cube1_a(etl_id,pdp,short_desc,tested,department)
                                           VALUES('$xetl_id','$xpdp_desc','$xshort_desc','$ind[$e]','$deptx')";
                                           //print($query102."<br>");
                              $mysql_data102 = mysql_query($query102, $mysql_link) or die ("Could not query: ".mysql_error());
                              // ***************
                              // *************** 
                          }   
                     }
                     //$xjob_log = $xjob_log."For PDP $pdp_desc record successfully inserted into cube1_a for $deptx".chr(10); 
                     // ***************
                     // updating status
                     // ***************  
                     $query112 = "UPDATE ".$name.".etl_monitor
                                     SET job_log    = '$xjob_log',
                                         etl_status = 'In-Process: Loading Cube1' 
                                   WHERE etl_id = '$xetl_id' ";
                     $mysql_data112 = mysql_query($query112, $mysql_link) or die ("Could not query: ".mysql_error());
                     // ***************
                     // ***************                               
                     //print($xjob_log);                          
                     //print("        
                     //          </font>
                     //        </td>
                     //");
          }
       }
       // $rowcnt is the no. of issues found in a pdp
       // Select all issues for given pdp
       $query      = "select issue_id,pdp_id,issue_desc,created_by,created_on,issue_area_id,issue_type_id 
                        from ".$name.".issues where pdp_id = '$xid' 
                    order by issue_id";
       $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt     = mysql_num_rows($mysql_data);
       $tisue      = $tisue + $rowcnt;

       if ($rowcnt == 0) {
             //print("
             //      <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
             //       <font color=\"#330099\">
             //        0
             //       </font>
             //      </td>
             //    ");
       } else {
             //print("
             //      <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
             //       <font color=\"#330099\">
             //        $rowcnt
             //       </font>
             //      </td>
             //");
                                 
           $seq1 = 0;
           while($row = mysql_fetch_row($mysql_data)) {
                 $delcnt          = 0;
                 $seq1            = $seq1 + 1;
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

                 $query22        = "select issue_surrogate_id,issue_type_id 
                                      from ".$name.".issue_surrogates 
                                     where issue_surrogate_id = '$xid2' 
                                       and surrogate_type = 0"; 
                 $mysql_data22   = mysql_query($query22, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcnt22       = mysql_num_rows($mysql_data22);
                 $issue_sur_cnt0 = 0;
                 $xissue_sur_id0 = array();
                 $xissue_typ_id0 = array();
                 while($row22 = mysql_fetch_row($mysql_data22)) {
                       $issue_sur_cnt0                       = $issue_sur_cnt0 + 1;
                       $xissue_sur_id0[$issue_sur_cnt0]       = $row22[0];
                       $xissue_typ_id0[$issue_sur_cnt0]       = $row22[1];
                 }
                 //find out total updates on this issue   
                 $queryk      = "select issue_history_id,issue_id,issue_assignee,
                                        issue_note_dt,issue_note,issue_type_id,issue_area_id 
                                   from ".$name.".issue_history 
                                  where issue_id = '$xid2' ";
                 $mysql_datak = mysql_query($queryk, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcntk     = mysql_num_rows($mysql_datak); 

                 //pick the last one 
                 $queryh = "select issue_history_id,issue_id,issue_assignee,issue_note_dt,
                                   issue_note,issue_area_id 
                              from ".$name.".issue_history 
                             where issue_id = '$xid2' 
                          order by issue_history_id desc limit 1";
                 $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
                 $rowcnth = mysql_num_rows($mysql_datah);                 
                 
                 if ($rowcnth == 1) {
                     while($rowh = mysql_fetch_row($mysql_datah)) {
                           $xid3              = stripslashes($rowh[0]);
                           $xissue_assignee   = stripslashes(strtoupper(trim($rowh[2])));
                           $xissue_note_dt    = stripslashes($rowh[3]);
                           $xd                = date("d",$xissue_note_dt);
                           $xm                = date("M",$xissue_note_dt);
                           $xy                = date("Y",$xissue_note_dt);
                           $xdt               = $xd."-".$xm."-".$xy;
                           $xissue_note       = stripslashes(trim($rowh[4]));
                           $xissue_area_id_n  = stripslashes($rowh[5]);     //will superimpose $xissue_area_id above
                           $query21 = "select issue_surrogate_id,issue_type_id from ".$name.".issue_surrogates where issue_surrogate_id = '$xid3' and surrogate_type = 1"; 
                           $mysql_data21 = mysql_query($query21, $mysql_link) or die ("Could not query: ".mysql_error());
                           $rowcnt21 = mysql_num_rows($mysql_data21);
                           $issue_sur_cnt = 0;
                           $xissue_sur_id = array();
                           $xissue_typ_id = array();
                           while($row21 = mysql_fetch_row($mysql_data21)) {
                                 $issue_sur_cnt                       = $issue_sur_cnt + 1;
                                 $xissue_sur_id[$issue_sur_cnt]       = $row21[0];
                                 $xissue_typ_id[$issue_sur_cnt]       = $row21[1];
                           }
                 }
                  $rowcnt1 = $rowncnth;
                } else 
                {
                  $xissue_note      = ""; //$xissue_desc; 
                  $xissue_area_id_n = ""; //$xissue_area_id;
                  $xdt              = ""; //$xcreate_dt;
                  $xissue_assignee  = ""; //$xcreated_by; 
                }
           if ($seq1 == 1) {         
           for ($st=1;$st<=$isue_typ_cnt ; ++$st) {
           }
           }
           $w = 0;
           for ($w=1;$w<=$issue_area_cnt ; ++$w) {
              if ($issue_area_id[$w] == $xissue_area_id) {
                  $dept_c = $issue_area[$w];
              }
           }
           $w1 = 0;
           for ($w1=1;$w1<=$issue_area_cnt ; ++$w1) {
              if ($issue_area_id[$w1] == $xissue_area_id_n) {
                  $dept_u = $issue_area[$w1];
              }
           }
           $selctn_c  = "";
           $selctn_u  = "";
           $selctn_c1 = "";
           $selctn_u1 = "";           
           for ($sur=1;$sur<=$issue_sur_cnt0; ++$sur){
             for ($v=1;$v<=$issue_typ_cnt ; ++$v) {
                 if ($issue_typ_id[$v] == $xissue_typ_id0[$sur]){
                     $selctn_c = $selctn_c.$issue_typ[$v]."<br>";
                 }    
             }
           }
           if ($rowcnth == 0) {
           } else {
             for ($sur1=1;$sur1<=$issue_sur_cnt; ++$sur1){
                 for ($v1=1;$v1<=$issue_typ_cnt ; ++$v1) {
                      if ($issue_typ_id[$v1] == $xissue_typ_id[$sur1]){
                          $selctn_u = $selctn_u.$issue_typ[$v1]."<br>";
                      }    
                 }
             }
           }
          for ($p=1;$p<=$isue_typ_cnt ; ++$p) {
          }
       }
           for ($t2=1;$t2<=$isue_typ_cnt ; ++$t2) {
                $ptotal = $p_total[$xid][$t2];
           }      
       }

      // --------------------------------------------------- pdp_tesing      
      //print("
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:150px;\">
      //         <font color=\"#330099\">
      //      ");
      $pcat_found = 0; 
      if ($xpdp_category_id == 0) {
          //print("-");    
      } else {
        for ($f=1;$f<=$pcat_cnt; ++$f) {
            if ($xpdp_category_id == $pcat_id[$f])  {
                //print(" $pcat[$f] ");
                $xpcat        = $pcat[$f]; 
                $query11      = "select b.category_scope 
                                   from ".$name.".pdp_categories a, category_scope b
                                  where a.pdp_category_id = '$pcat_id[$f]'
                                    and a.category_scope_id = b.category_scope_id "; 
                $mysql_data11 = mysql_query($query11, $mysql_link) or die ("Could not query: ".mysql_error());
                $rowcnt11     = mysql_num_rows($mysql_data11);
                while($row11 = mysql_fetch_row($mysql_data11)) {
	                        $zcategory_scope = stripslashes($row11[0]);
                }
                $pcat_found = 1;    
             }
        }
      }
      if ($pcat_found == 0) {
          $zcategory_scope = "";
      } else {
      }                        
      //print("     </a>
      //         </font>
 	  //        </td>
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
      //         <font color=\"#330099\"> 
      //          $zcategory_scope
      //         </font>
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
      //         <font color=\"#330099\"> 
      //");
      $comp_found = 0; 
      if ($xcomplexity_id == 0) {
          //print("-");
      }
      for ($f=1;$f<=$st_typ_cnt; ++$f) {
              if ($xcomplexity_id == $st_typ_id[$f]) {
                  //print("$st_typ[$f]");
                  $xcomplexity = $st_typ[$f];
              }
      }
      //print("        
      //         </font>
	  //        </td>
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
      //         <font color=\"#330099\">
      //");
      $revn_found = 0;
      if ($xrevenue_id == 0) {
          //print("-");  
      }
      $revn_found = 0;
      for ($f=1;$f<=$st_typ_cnt; ++$f) {
              if ($xrevenue_id == $st_typ_id[$f]) {
                  //print("$st_typ[$f]");
                  $xrevenue = $st_typ[$f];
              }
      }
      //print("        
      //         </font>
	  //        </td>
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
      //         <font color=\"#330099\">
      //");
      $prjc_found = 0;              
      if ($xprojection_id == 0) {
          //print("-");
      }          
      for ($f=1;$f<=$st_typ_cnt; ++$f) {
              if ($xprojection_id == $st_typ_id[$f]) {
                  //print("$st_typ[$f]");
                  $xprojection = $st_typ[$f];
              }
      }
      //print("        
      //         </font>
	  //        </td>
	  //        <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
      //         <font color=\"#330099\">
      //");
      $cmpr_found = 0; 
      if ($xcomparison_id == 0) {
          //print("-");
      } 
      $cmpr_found = 0;       
      for ($f=1;$f<=$st_typ_cnt; ++$f) {
              if ($xcomparison_id == $st_typ_id[$f]) {
                  //print("$st_typ[$f]");
                  $xpast = $st_typ[$f];
              } 
      }
      //print("        
      //         </font>
      //       </td>
      //");
      //==================================================================================================
      $query42      = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,
                              bill_run_count,ppw_update,comments,launch_ind,defects,
                              running_comments 
                         from ".$name.".pdp_execution 
                        where pdp_id = '$xid' "; 
      $mysql_data42 = mysql_query($query42, $mysql_link) or die ("Could not query: ".mysql_error());
      $rowcnt42     = mysql_num_rows($mysql_data42);
      if ($rowcnt42 == 0) {
           $ysdt                = "-";
           $yedt                = "-";
           $yinvoice_cnt        = 0;
           $ybillrun_cnt        = 0;
           $yppw_update         = 0;
           $ydefects            = 0;
           $ylaunch             = "";
           $total_baseline      = 0;
           $total_incremental   = 0;           
           $percent_incremental = 0;
      } else {
         while($row42 = mysql_fetch_row($mysql_data42)) {
               $yexecution_id = stripslashes($row42[0]);
               $yid           = stripslashes($row42[0]);
               $ypdp_id       = stripslashes($row42[1]);
               $ystart_dt     = stripslashes($row42[2]);
               $yend_dt       = stripslashes($row42[3]);
               $yupdated_by   = stripslashes($row42[4]);
               $yinvoice_cnt  = stripslashes($row42[5]);
               $ybillrun_cnt  = stripslashes($row42[6]);
               $yppw_update   = stripslashes($row42[7]);
               $ycomments     = stripslashes($row42[8]);
               $ylaunch_ind   = stripslashes($row42[9]);
               $yrunning_com  = nl2br(stripslashes($row42[11]));
               $tbrun = $tbrun + $ybillrun_cnt;
               $tinvc = $tinvc + $yinvoice_cnt;
               $tppw  = $tppw  + $yppw_update;
               $tdfct = $tdfct + $ydefects;
               if ($ylaunch_ind == 0){
                   $ylaunch     = "NO";
               } else {
                   $ylaunch     = "YES";
               }
               if (!empty($ystart_dt)){
	               $yds         = date("d",$ystart_dt);
                   $yms         = date("m",$ystart_dt);
                   $yms2        = date("M",$ystart_dt);
                   $yys         = date("Y",$ystart_dt);
                   $ysdt        = "$yds"."-"."$yms2"."-"."$yys";
                   $xstart_date = date("Y-m-d)",$ystart_dt)." 00:00:00";
               } else {
                   $ysdt = "-";
                   $xstart_date = "0000-00-00 00:00:00";    
               }
               if (!empty($yend_dt)){
	               $yde         = date("d",$yend_dt);
                   $yme         = date("m",$yend_dt);
                   $yme2        = date("M",$yend_dt);
                   $yye         = date("Y",$yend_dt); 
                   $yedt        = "$yde"."-"."$yme2"."-"."$yye";
                   $xend_date   = date("Y-m-d)",$yend_dt)." 00:00:00";
               } else {
                   $yedt = "-";
                   $xend_date = "0000-00-00 00:00:00";
               }
               $query44            = "select execution_id,milestone_id,iteration_count
                                        from ".$name.".milestone_surrogates 
                                       where execution_id = $yexecution_id";
               $mysql_data44       = mysql_query($query44, $mysql_link) or die ("Could not query: ".mysql_error());
               $rowcnt44           = mysql_num_rows($mysql_data44);
               $eseq               = 0;
               $total_baseline     = 0;
               $total_incremental  = 0;
               while($row44 = mysql_fetch_row($mysql_data44)) {
                              $eseq              = $eseq + 1;
                              $yexecution_id     = stripslashes($row44[0]);
                              $ymilestone_id     = stripslashes($row44[1]);
                              $zid               = stripslashes($row44[1]);
                              $yiteration_cnt    = stripslashes($row44[2]);
                              $query36 = "select milestone_id,milestone,milestone_time 
                                            from ".$name.".pdp_stlc 
                                           where milestone_id = $zid";
                              $mysql_data36 = mysql_query($query36, $mysql_link) or die ("Could not query: ".mysql_error());
                              $rowcnt36 = mysql_num_rows($mysql_data36);
                              while($row36 = mysql_fetch_row($mysql_data36)) {
                                    $ymilestone        = stripslashes($row36[1]);
                                    $ymilestone_time   = stripslashes($row36[2]);
                                    $ybaseline_time    = $ymilestone_time;
                                    $yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                                    $total_baseline    = $total_baseline + $ybaseline_time;
                                    $total_incremental = $total_incremental + $yincremental_time;
                              }      
               }
                     $total_time          = round($total_baseline + $total_incremental,2);
                     $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
                     $percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ;
                     $tbasewk             = (float)$tbasewk + (float)$total_baseline;
                     $trewk               = (float)$trewk + (float)$total_incremental;
                     $tprwk               = (float)$tprwk + (float)$percent_incremental; 
          }
       }
       // print("
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $ysdt
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $yedt
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $ybillrun_cnt
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $yinvoice_cnt
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $yppw_update
       //       </font>               
       //      </td>
       //      <!--<td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $ydefects
       //       </font>               
       //      </td>-->
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $ylaunch
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $total_baseline
       //       </font>               
       //      </td>
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $total_incremental
       //       </font>               
       //      </td>             
       //      <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	   //       <font color=\"#330099\"> 
       //        $percent_incremental%
       //       </font>               
       //      </td>
       // ");
       //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

       // select all issue types
       $query79      = "select issue_type_id,issue_type,issue_type_ind 
                          from ".$name.".issue_types
                      order by issue_type"; 
       $mysql_data79 = mysql_query($query79, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt79     = mysql_num_rows($mysql_data79); 

       $isue_typ_cnt = 0;
       while($row79 = mysql_fetch_row($mysql_data79)) {
             $isue_typ_cnt                      = $isue_typ_cnt + 1;
             $isue_typ_id[$isue_typ_cnt]        = stripslashes($row79[0]);            //all issues types
             $isue_typ[$isue_typ_cnt]           = stripslashes($row79[1]);
             $isue_typ_ind[$isue_typ_cnt]       = stripslashes($row79[2]);
             $isue_typ_used_isue[$isue_typ_cnt] = 0;                                  // will be used to accumulate total
        }
       $query80 = "select distinct(issue_id) 
                     from ".$name.".issues
                    where pdp_id = '$xid' 
                 order by issue_id";
       $mysql_data80 = mysql_query($query80, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt80 = mysql_num_rows($mysql_data80);
       $pdp_isue_cnt = 0;
       while($row80 = mysql_fetch_row($mysql_data80)) {
             $pdp_isue_cnt               = $pdp_isue_cnt + 1;
             $pdp_isue_id[$pdp_isue_cnt] = stripslashes($row80[0]);
             $p_isue_id                  = $pdp_isue_id[$pdp_isue_cnt];
             $upd_found = 0;
             $query57 = "select issue_history_id 
                           from ".$name.".issue_history  
                          where issue_id = $pdp_isue_id[$pdp_isue_cnt]";
             $mysql_data57 = mysql_query($query57, $mysql_link) or die ("Could not query: ".mysql_error());
             $rowcnt57 = mysql_num_rows($mysql_data57);
             if ($rowcnt57 == 0){
             } else {
               $upd_found = 1;    
             } 
             for ($s=1;$s<=$isue_typ_cnt ; ++$s) {
                  $pdp_isue_typ_id[$pdp_isue_cnt][$s] = $isue_typ_id[$s];             // all issues types for each issue in this pdp 
                  ///////////////////////////////////////////////////////////////////////
                  // Start Number Crunching for Root Cause Analysis
                  ///////////////////////////////////////////////////////////////////////
                  if ($upd_found == 0){
                      // Master Record
                      $query91 = "select count(distinct(issue_type_id)) 
                                    from ".$name.".issue_surrogates 
                                   where issue_surrogate_id = $pdp_isue_id[$pdp_isue_cnt]
                                     and issue_type_id = $isue_typ_id[$s] ";
                      $mysql_data91 = mysql_query($query91, $mysql_link) or die ("Could not query: ".mysql_error());
                      $rowcnt91 = mysql_num_rows($mysql_data91);
                      while($row91 = mysql_fetch_row($mysql_data91)) {
                            $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] = stripslashes($row91[0]);         // count of occurance of issue types for master record (issues)
                      }                   
                  } else {
                      // Updates
                      $query92 = "select count(distinct(a.issue_type_id)) 
                                    from ".$name.".issue_surrogates a, issue_history b 
                                   where a.issue_type_id = $isue_typ_id[$s]
                                     and (
                                           a.issue_surrogate_id = b.issue_history_id
                                         ) 
                                     and b.issue_id = $pdp_isue_id[$pdp_isue_cnt] 
                                order by b.issue_history_id desc limit 1   ";
                      $mysql_data92 = mysql_query($query92, $mysql_link) or die ("Could not query: ".mysql_error());
                      $rowcnt92 = mysql_num_rows($mysql_data92);
                      //print($query92);
                      while($row92 = mysql_fetch_row($mysql_data92)) {
                            $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s] = stripslashes($row92[0]);         // count of occurance of issue types for master record (issues)
                      }
                  }
                  ///////////////////////////////////////////////////////////////////////
                  // End Number Crunching for Root Cause Analysis
                  ///////////////////////////////////////////////////////////////////////
                  // issue type used in master + update records for given issues
                  $pdp_isue_typ_used_isue[$pdp_isue_cnt][$s] = $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
                  $pdp_isue_typ_id[$p_isue_id][$s]           = $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
                  // issue type used in master + update records for given pdp (running total)
                  $isue_typ_used_isue[$s]                    = $isue_typ_used_isue[$s] + $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
             }
        }       
        $p_total = array(); 
        for ($t=1;$t<=$isue_typ_cnt ; ++$t) {
             $ptotal            = $isue_typ_used_isue[$t];
             $p_total[$xid][$t] = $ptotal;
             $ttotal            = $t_total[$t] + $p_total[$xid][$t]; 
             $t_total[$t]       = $ttotal;
             //print("
             //        <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	         //         <font color=\"#330099\"> 
             //          $isue_typ_used_isue[$t]
             //         </font>               
             //        </td>
            //"); 
            // ***************
            // writing cube1_b
            // *************** 
            $query104 = "INSERT into ".$name.".cube1_b(etl_id,pdp,issue_type,occurance)
                         VALUES('$xetl_id','$xpdp_desc','$issue_typ[$t]','$isue_typ_used_isue[$t]')";
            //print($query104."<br>");             
            $mysql_data104 = mysql_query($query104, $mysql_link) or die ("Could not query: ".mysql_error());
            // ***************
            // ***************
        }
        //print("
        //        <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	    //         <font color=\"#330099\"> 
        //          $ydate
        //         </font>               
        //        </td>
        //        <td bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">                
	    //         <font color=\"#330099\"> 
        //          $usr
        //         </font>               
        //        </td>                
        //       </tr> 
        //");

        // ******************
        // writing cube1_main
        // ****************** 
        $query103 = "INSERT into ".$name.".cube1_main(etl_id,
                                                      row_type,
                                                      pdp,
                                                      pdp_desc,
                                                      pdp_owner,
                                                      pdp_type,
                                                      pdp_status,
                                                      pdp_launch,
                                                      parent_pdp,
                                                      main_pdp,
                                                      issues_created,
                                                      pdp_category,
                                                      scoping,
                                                      complexity_factor,
                                                      revenue_factor,
                                                      customer_factor,
                                                      past_factor,
                                                      testing_start_date,
                                                      testing_end_date,
                                                      bills_run,
                                                      invoices_generated,
                                                      ppw_changes,
                                                      launch_in_jeopardy,
                                                      baseline_hours,
                                                      rework_hours,
                                                      percentage_rework
                                                     )
                     VALUES('$xetl_id',
                            '1',
                            '$xpdp_desc',
                            '$xpdp_name',
                            '$xpdp_owner',
                            '$xpdp_period',
                            '$xpdp_status',
                            '$xdate',
                            '$xparent_pdp_desc',
                            '$xmain_pdp_desc',
                            '$rowcnt',
                            '$xpcat',
                            '$zcategory_scope',
                            '$xcomplexity',
                            '$xrevenue',
                            '$xprojection',
                            '$xpast',
                            '$xstart_date',
                            '$xend_date',
                            '$ybillrun_cnt',
                            '$yinvoice_cnt',
                            '$yppw_update',
                            '$ylaunch',
                            '$total_baseline',
                            '$total_incremental',
                            '$percent_incremental'  
                           )";
        print($query103."<br>");                   
        //print($query103);                   
        $mysql_data103 = mysql_query($query103, $mysql_link) or die ("Could not query: ".mysql_error());
        $xjob_log   = $xjob_log."$seq: For PDP $xpdp_desc record successfully inserted".chr(10);
        $xjob_log_y = "$seq: For PDP $xpdp_desc record successfully inserted <br>";  
        // ***************
        // updating status
        // ***************
        $query114      = "UPDATE ".$name.".etl_monitor
                             SET job_log = '$xjob_log',
                                 etl_status = 'In-Process: Loading cube1 (2)'
                           WHERE etl_id = '$xetl_id' ";
        $mysql_data114 = mysql_query($query114, $mysql_link) or die ("Could not query: ".mysql_error());
        // ***************
        // *************** 
        //print($xjob_log_y);                              
       }
       $xjob_log   = $xjob_log."$seq PDP successfully inserted into cube1_main".chr(10)."Job Finished at: ".date("l F d, Y, h:i:s A").chr(10); 
       $xjob_log_y = "$seq PDP successfully inserted into cube1_main<br>Job Finished at: ".date("l F d, Y, h:i:s A"); 
       // ***************
       // updating status
       // ***************  
       $query113 = "UPDATE ".$name.".etl_monitor
                       SET job_log = '$xjob_log',
                           etl_status = 'Successful'
                     WHERE etl_id = '$xetl_id' ";
       $mysql_data113 = mysql_query($query113, $mysql_link) or die ("Could not query: ".mysql_error());
       // ***************
       // ***************
       print($xjob_log_y);
       //======== Table Details End =============================
       //========================================================
       //========================================================
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"No PDP found under this criteria, Please Try Again\")</script>";  
   }

   //======== Table Footer Starts============================
   //========================================================
   //========================================================

   //if ($rowcntx <> 0) {
   //       print("
   //                  <tr>
   //                   <td bgcolor=\"#E8E8E8\" colspan=\"10\" align=\"center\" valign=\"middle\">
   //                    <font color=\"#330099\">
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >                
   //	                   <font color=\"#330099\"> 
   //                     $tisue
   //                    </font>               
   //                   </td>
   //                   <td bgcolor=\"#E8E8E8\" colspan=\"8\" align=\"center\" valign=\"middle\">
   //                    <font color=\"#330099\">
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tbrun
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tinvc
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tppw 
   //                    </font>
   //                   </td>
   //                   <!--<td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tdfct
   //                    </font>
   //                   </td>-->
   //                   <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tbasewk
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $trewk
   //                    </font>
   //                   </td>                      
   //         ");
   //         (float)$trewk_effort = round(((float)$trewk / (float)$tbasewk) * 100,2);
   //         print("
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     <!--$tprwk%-->
   //                     $trewk_effort%
   //                    </font>
   //                   </td>
   //         ");
   //        for ($t3=1;$t3<=$isue_typ_cnt ; ++$t3) {
   //              //$ptotal            = $isue_typ_used_isue[$t];
   //              //$p_total[$xid][$t] = $ptotal;
   //              //$ttotal            = $t_total[$t] + $p_total[$xid][$t]; 
   //              //$t_total[$t]       = $ttotal;
   //              print("
   //                 <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >                
   //	                  <font color=\"#330099\"> 
   //                    $t_total[$t3]
   //                   </font>               
   //                  </td>
   //        "); 
   //        }            
   //        print("     
   //                   <!--<td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tisue
   //                    </font>
   //                   </td>-->                                                                                                                                                          
   //                   <td bgcolor=\"#E8E8E8\" colspan=\"2\" align=\"center\" valign=\"middle\">
   //                    <font color=\"#330099\">
   //                    </font>
   //                   </td>
   //                  </tr> 
   //    ");
   //    print("</table>");
   //======== Table Footer Starts============================
   //========================================================
   //========================================================
   //}       

print("  </div>
        </body>
       </html>
");

?>
