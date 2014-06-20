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



   //print("$pdp");
   //$queryu = "select lanid,fullname from ".$name.".users"; 
   //$mysql_datau = mysql_query($queryu, $mysql_link) or die ("Could not query: ".mysql_error());
   //$rowcntu = mysql_num_rows($mysql_datau);    

   //    while($rowu = mysql_fetch_row($mysql_datau)) {
   //          $usr      = stripslashes($rowu[1]);
   //    }

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
//print ("$yentry_dt");
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

// -------------------------------------
// Start of the check-01
//if (isset($pdp) && ($start == 1)) {
if (isset($pdp) && ($start == 1)) {
// -------------------------------------
$captn = "PDP Summary Report";

    $queryx = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                     a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                     a.revenue_id,a.comparison_id,a.pdp_period_id 
                from ".$name.".pdp a 
               where a.pdp_desc = '$pdp' "; //a.pdp_period_id = b.pdp_period_id and
   //$queryx = "select a.pdp_id,a.pdp_desc,a.pdp_name,a.pdp_period_id,a.pdp_launch from ".$name.".pdp a where a.pdp_desc = '$pdp' "; 
   //print("$queryx"); 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$rowcntx");

   //$captn = "Issue List (Click the Issue No hyper link to see updates)";
   $trucnt = 0;

   // $rowcntx is no. of pdps found in a quarter
   $seq1 = 0;
   if ($rowcntx == 1) {
       $found = 1;

       if ($xpdp_period_id == 0) {
           $xpdp_period = "VALUE NOT SET";
       } else {
                     $query100 = "select b.pdp_period from ".$name.".pdp a, pdp_periods b where a.pdp_desc = '$pdp' and a.pdp_period_id = b.pdp_period_id";
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
             $seq = $seq + 1;
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
             //$xpdp_period      = stripslashes($rowx[14]);

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

             // --------------------------------------------------- pdp_tesing
             $queryy = "select pdp_id,issue_area_id,test_ind from ".$name.".pdp_testing where pdp_id = '$xid'"; 
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
             
       print("
         <form method=\"post\" action=\"./list_by_pdp4.php\">
           <table border='0' scroll=\"yes\" style=\" border-style:solid; border-color:#CCCCCC;\" >
           <caption >$captn</captn>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\" style=\"width:200px\">
              <font color=\"#330099\">
               PDP No.
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\" style=\"width:300px\">
	          <font color=\"#330099\"> 
               $xpdp_desc
              </font> 
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               PDP Description
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\">
              <font color=\"#330099\">                
               <p>$xpdp_name</p>
              </font>
             </td>
            </tr>
            <!--<tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Owner</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word;\">
	           <font color=\"#330099\"> 
                $xpdp_owner
               </font> 	            
	          </td>
            </tr>-->
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               PDP Type
              </font>
             </td>
             <td valign=\"middle\" bgcolor=\"#CCFFFF\">
               <font color=\"#330099\">  
                $xpdp_period
               </font>
             </td>
            <!--</tr>
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Status</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\">
	           <font color=\"#330099\"> 
                $xpdp_status
               </font> 
              </td> 
            </tr>-->
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
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
      ");      
      // --------------------------------------------------- pdp_tesing  
      // Display records for update
      $queryy2 = "select pdp_id,issue_area_id,test_ind from ".$name.".pdp_testing where pdp_id = '$xid'"; 
      $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("Could not query: ".mysql_error());
      $rowcnty2 = mysql_num_rows($mysql_datay2);  
      $y = 0; 
      if ($rowcnty2 > 0) {
          while($rowy2 = mysql_fetch_row($mysql_datay2)) {
                $y                  = $y + 1;
	            $yissue_area_id[$y] = stripslashes($rowy2[1]);
                $ytest_ind[$y]      = stripslashes($rowy2[2]);
                //print($ytest_ind[$y]);

                //loading departments
                $queryx3 = "select issue_area from ".$name.".issue_areas where issue_area_id = '$yissue_area_id[$y]' "; 
                $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("Could not query: ".mysql_error());
                $rowcntx3 = mysql_num_rows($mysql_datax3);    
                while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                      $deptx = stripslashes(trim($rowx3[0]));
                }
                     print("
                            <tr>
                             <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">$deptx Testing</font></td>
                             <td valign=\"middle\" bgcolor=\"#CCFFFF\">
                              <font color=\"#330099\">
                     ");
                     for ($e=1;$e<=2; ++$e) {
                          if ($ytest_ind[$y] == $ind_id[$e]) {
                              print("$ind[$e]"); 
                          }   
                     }                         
                     print("        
                               </font>
                             </td>
                     ");
          }
          print("</tr>
                ");
      } 
      // --------------------------------------------------- pdp_tesing      
      print("
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">PDP Category</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; \"> <!--width=\50\ can be added to style-->
               <font color=\"#330099\">
            ");
     $pcat_found = 0; 
     if ($xpdp_category_id == 0) {
         print("VALUE NOT SET");    
     } else {
     for ($f=1;$f<=$pcat_cnt; ++$f) {
             if ($xpdp_category_id == $pcat_id[$f])  {
                      print(" $pcat[$f] "); 
                      $query11 = "select b.category_scope from ".$name.".pdp_categories a, category_scope b
                                   where a.pdp_category_id = '$pcat_id[$f]'
                                     and a.category_scope_id = b.category_scope_id "; 
                      $mysql_data11 = mysql_query($query11, $mysql_link) or die ("Could not query: ".mysql_error());
                      $rowcnt11 = mysql_num_rows($mysql_data11);
                      while($row11 = mysql_fetch_row($mysql_data11)) {
	                        $zcategory_scope = stripslashes($row11[0]);
                      }
                      $pcat_found = 1;    
             }
     }
     }
     if ($pcat_found == 0) {
         $zcategory_scope = "SCOPING NOT DONE";
     } else {
     }                        
     print("     </a>
               </font>
 	          </td>
 	          <td>
 	          </td>
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Scoping</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; \">
               <font color=\"#330099\"> 
                $zcategory_scope
               </font>
 	          <td>
 	          </td>
             </tr>
             
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Complexity</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; \">
               <font color=\"#330099\"> 
            ");
     $comp_found = 0; 
     if ($xcomplexity_id == 0) {
         print("VALUE NOT SET");
     } //else {
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xcomplexity_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print("$st_typ[$f]");
             } //else
             //{
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             //}
     }
     //for ($f=1;$f<=$comp_cnt; ++$f) {
     //        if ($xcomplexity_id == $comp_id[$f]) {
     //                  print(" $comp[$f] "); 
     //                  $query11 = "select b.status_type from ".$name.".complexity a, status_types b
     //                               where a.complexity_id = '$comp_id[$f]'
     //                                 and a.status_type_id = b.status_type_id ";
     //                  $mysql_data11 = mysql_query($query11, $mysql_link) or die ("Could not query: ".mysql_error());
     //                  $rowcnt11 = mysql_num_rows($mysql_data11);  
     //                  while($row11 = mysql_fetch_row($mysql_data11)) {
	 //                        $zstatus_type = stripslashes($row11[0]);
     //                  }
     //                  $comp_found = 1;
     //              }
     //}
     //}
     //if ($comp_found == 0) {
     //    $zstatus_type = ""; 
     //}                         
     print("        
               </font>
	          </td>
	          <td></td>
              <!--<td bgcolor=\"#CCFFFF\" align=\"center\" style=\"width:100px;\"><font color=\"#330099\">$zstatus_type</font></td>-->
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Revenue Impact</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word;\"> <!--width=\50\ can be added to style-->
               <font color=\"#330099\">
            ");
     $revn_found = 0;
     if ($xrevenue_id == 0) {
         print("VALUE NOT SET");  
     } //else {
     $revn_found = 0;
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xrevenue_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print("$st_typ[$f]");
             } //else
             //{
             //    print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             //}
     }
     //}
     //for ($f=1;$f<=$revn_cnt; ++$f) {
     //        if ($xrevenue_id == $revn_id[$f]) {
     //                  print($revn[$f]); 
     //                  $query13 = "select b.status_type from ".$name.".revenue a, status_types b
     //                               where a.revenue_id = '$revn_id[$f]'
     //                                 and a.status_type_id = b.status_type_id ";
     //                  $mysql_data13 = mysql_query($query13, $mysql_link) or die ("Could not query: ".mysql_error());
     //                  $rowcnt13 = mysql_num_rows($mysql_data13);  
     //                  while($row13 = mysql_fetch_row($mysql_data13)) {
	 //                        $zstatus_type3 = stripslashes($row13[0]);
     //                  }
     //                  $revn_found = 1;
     //        }
     //}
     //}
     //if ($revn_found == 0) {
     //    $zstatus_type3= ""; 
     //}                         
     print("        
               </font>
	          </td>
	          <td></td>
              <!--<td bgcolor=\"#CCFFFF\" align=\"center\" style=\"width:100px;\"><font color=\"#330099\">$zstatus_type</font></td>-->
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Customer Impact</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word;\"> <!--width=\50\ can be added to style-->
               <font color=\"#330099\">
            ");
     $prjc_found = 0;              
     if ($xprojection_id == 0) {
         //print(" <select align=\"center\" name=\"xprojection_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
         print("VALUE NOT SET");
     } //else {          
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xprojection_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print("$st_typ[$f]");
             } //else
             //{
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             //}
     }
     //for ($f=1;$f<=$prjc_cnt; ++$f) {
     //        if ($xprojection_id == $prjc_id[$f]) {
     //                  print($prjc[$f]);
     //                  $query12 = "select b.status_type from ".$name.".projection a, status_types b
     //                               where a.projection_id = '$prjc_id[$f]'
     //                                 and a.status_type_id = b.status_type_id ";
     //                  $mysql_data12 = mysql_query($query12, $mysql_link) or die ("Could not query: ".mysql_error());
     //                  $rowcnt12 = mysql_num_rows($mysql_data12);  
     //                  while($row12 = mysql_fetch_row($mysql_data12)) {
	 //                       $zstatus_type2 = stripslashes($row12[0]);
     //                 }
     //                  $prjc_found = 1;
     //        }
     //}
     //}
     //if ($prjc_found == 0) {
     //    $zstatus_type2 = ""; 
     //}                         
     print("        
               </font>
	          </td>
	          <td></td>
              <!--<td bgcolor=\"#CCFFFF\" align=\"center\" style=\"width:100px;\"><font color=\"#330099\">$zstatus_type</font></td>-->
             </tr>
             
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"left\"><font color=\"#330099\">Past Impact</font></td>
	          <td valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word;\"> <!--width=\50\ can be added to style-->
               <font color=\"#330099\">
            ");
     $cmpr_found = 0; 
     if ($xcomparison_id == 0) {
         //print(" <select align=\"center\" name=\"xcomparison_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
         print("VALUE NOT SET");
     } //else { 
     $cmpr_found = 0;       
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xcomparison_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print("$st_typ[$f]");
             } //else
             //{
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             //}
     }
     //for ($f=1;$f<=$cmpr_cnt; ++$f) {
     //        if ($xcomparison_id == $cmpr_id[$f]) {
     //                  print($cmpr[$f]); 
     //                  $query14 = "select b.status_type from ".$name.".comparison a, status_types b
     //                               where a.comparison_id = '$cmpr_id[$f]'
     //                                 and a.status_type_id = b.status_type_id ";
     //                  $mysql_data14 = mysql_query($query14, $mysql_link) or die ("Could not query: ".mysql_error());
     //                  $rowcnt14 = mysql_num_rows($mysql_data14);  
     //                  while($row14 = mysql_fetch_row($mysql_data14)) {
	 //                        $zstatus_type4 = stripslashes($row14[0]);
     //                  }
     //                  $cmpr_found = 1;
     //        }
     //}
     //}
     //if ($cmpr_found == 0) {
     //    $zstatus_type4= ""; 
     //}                         
     print("        
               </font>
	          </td>
	          <td></td>
              <!--<td bgcolor=\"#CCFFFF\" align=\"center\" style=\"width:100px;\"><font color=\"#330099\">$zstatus_type</font></td>-->
	        </tr>  
            <!--<tr>
             <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\">
              <font color=\"#330099\">
               Current User
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $usr
              </font>               
             </td>
            </tr>-->
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Report Date
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ydate
              </font>               
             </td>
            </tr>
            ");
       //==================================================================================================
       $query42 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind,defects,running_comments 
                     from ".$name.".pdp_execution where pdp_id = '$xid' "; 
       $mysql_data42 = mysql_query($query42, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt42 = mysql_num_rows($mysql_data42);
       if ($rowcnt42 == 0) {
           $ysdt          = "DATE NOT SET";
           $yedt          = "DATE NOT SET";
           $yinvoice_cnt  = 0;
           $ybillrun_cnt  = 0;
           $yppw_update   = 0;
           $ydefects      = 0;
           $ylaunch        = "-";
           $percent_incremental = "0";
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
               $ydefects      = stripslashes($row42[10]);
               $yrunning_com  = nl2br(stripslashes($row42[11]));
               if ($ylaunch_ind == 0){
                   $ylaunch = "NO";
               } else {
                   $ylaunch = "YES";
               }
               if (!empty($ystart_dt)){
	           $yds  = date("d",$ystart_dt);
                   $yms  = date("m",$ystart_dt);
                   $yms2 = date("M",$ystart_dt);
                   $yys  = date("Y",$ystart_dt);
                   $ysdt = "$yds"."-"."$yms2"."-"."$yys";
               } else {
                   $ysdt = "DATE NOT SET";    
               }
               if (!empty($yend_dt)){
	           $yde  = date("d",$yend_dt);
                   $yme  = date("m",$yend_dt);
                   $yme2 = date("M",$yend_dt);
                   $yye  = date("Y",$yend_dt); 
                   $yedt = "$yde"."-"."$yme2"."-"."$yye";
               } else {
                   $yedt = "DATE NOT SET";
               }
                     //************************************************************ 
                     $query44 = "select execution_id,milestone_id,iteration_count
                                   from ".$name.".milestone_surrogates where execution_id = $yexecution_id";
                     $mysql_data44 = mysql_query($query44, $mysql_link) or die ("Could not query: ".mysql_error());
                     $rowcnt44 = mysql_num_rows($mysql_data44);
       
                     $eseq = 0;
                     $total_baseline = 0;
                     $total_incrementatl = 0;
                     while($row44 = mysql_fetch_row($mysql_data44)) {
                              $eseq              = $eseq + 1;
                              $yexecution_id     = stripslashes($row44[0]);
                              $ymilestone_id     = stripslashes($row44[1]);
                              $zid               = stripslashes($row44[1]);
                              $yiteration_cnt    = stripslashes($row44[2]);
                     $query36 = "select milestone_id,milestone,milestone_time from ".$name.".pdp_stlc where milestone_id = $zid";
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
                     //************************************************************ 

        //}


        }
        }
        print("
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Testing Start Date
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ysdt
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Testing End Date
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $yedt
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Bill Runs
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ybillrun_cnt
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Invoice Generated
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $yinvoice_cnt
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               PPW Changes
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $yppw_update
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Pests
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ydefects
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Launch in Jeopardy
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $ylaunch
              </font>               
             </td>
            </tr>
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
              <font color=\"#330099\">
               Percentage Rework
              </font>
             </td>
             <td bgcolor=\"#CCFFFF\" valign=\"middle\">                
	          <font color=\"#330099\"> 
               $percent_incremental%
              </font>               
             </td>
            </tr>
        ");
        //}

       //==================================================================================================



       //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

       // select all issue types
       $query79 = "select issue_type_id,issue_type,issue_type_ind 
                     from ".$name.".issue_types
                 order by issue_type"; 
       $mysql_data79 = mysql_query($query79, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt79 = mysql_num_rows($mysql_data79); 
       //print($query79."<br>");
       //print($rowcnt79."<br>");
       // To open trail, just remove //***
       //***print("---------------"."<br>");
       //***print("Issue Types"."<br>");
       //***print("---------------"."<br>");

       $isue_typ_cnt = 0;
       while($row79 = mysql_fetch_row($mysql_data79)) {
             $isue_typ_cnt                      = $isue_typ_cnt + 1;
             $isue_typ_id[$isue_typ_cnt]        = stripslashes($row79[0]);            //all issues types
             $isue_typ[$isue_typ_cnt]           = stripslashes($row79[1]);
             $isue_typ_ind[$isue_typ_cnt]       = stripslashes($row79[2]);
             $isue_typ_used_isue[$isue_typ_cnt] = 0;                                  // will be used to accumulate total
             //***print($isue_typ_id[$isue_typ_cnt]."-".$isue_typ[$isue_typ_cnt]."<br>");
        }
       // To open trail, just remove //***
       //***print("-----------"."<br>");
       //***print($pdp."<br>");
       //***print("-----------"."<br>");

       $query80 = "select distinct(issue_id) 
                     from ".$name.".issues
                    where pdp_id = '$xid' 
                   order by issue_id";
       $mysql_data80 = mysql_query($query80, $mysql_link) or die ("Could not query: ".mysql_error());
       $rowcnt80 = mysql_num_rows($mysql_data80);
       //print($query80."<br>");
       //print($rowcnt80."<br>");

       $pdp_isue_cnt = 0;
       while($row80 = mysql_fetch_row($mysql_data80)) {
             $pdp_isue_cnt               = $pdp_isue_cnt + 1;
             $pdp_isue_id[$pdp_isue_cnt] = stripslashes($row80[0]);
             $p_isue_id                  = $pdp_isue_id[$pdp_isue_cnt]; 
             // all issues in this pdp
             //***print("**".$pdp_isue_id[$pdp_isue_cnt]."** issue id in pdp $pdp"."<br>");

             for ($s=1;$s<=$isue_typ_cnt ; ++$s) {
                  $pdp_isue_typ_id[$pdp_isue_cnt][$s] = $isue_typ_id[$s];             // all issues types for each issue in this pdp 

                  // Master Record
                  $query91 = "select count(*) 
                                from ".$name.".issue_surrogates 
                               where issue_surrogate_id = $pdp_isue_id[$pdp_isue_cnt]
                                 and issue_type_id      = $isue_typ_id[$s] ";
                  $mysql_data91 = mysql_query($query91, $mysql_link) or die ("Could not query: ".mysql_error());
                  $rowcnt91 = mysql_num_rows($mysql_data91);
                  //print($query91."<br>");
                  //print($rowcnt91."<br>");

                  while($row91 = mysql_fetch_row($mysql_data91)) {
                        //***print("************ Master Record *************"."<br>");
                        //print($row91[0]." issue type not found =0, issue type found = 1"."<br>");
                        //***print($isue_typ[$s]."<br>");
                        $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] = stripslashes($row91[0]);         // count of occurance of issue types for master record (issues)
                        //***print($pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s]." no. of times used"."<br>");
                  }                   

                  // Updates
                  $query92 = "select count(*) 
                                from ".$name.".issue_surrogates a, issue_history b 
                               where a.issue_type_id      = $isue_typ_id[$s]
                                 and a.issue_surrogate_id = b.issue_history_id
                                 and b.issue_id           = $pdp_isue_id[$pdp_isue_cnt] ";
                  $mysql_data92 = mysql_query($query92, $mysql_link) or die ("Could not query: ".mysql_error());
                  $rowcnt92 = mysql_num_rows($mysql_data92);
                  //print($query92."<br>");
                  //print($rowcnt92."<br>");

                  while($row92 = mysql_fetch_row($mysql_data92)) {
                        //***print("*************** Updates ****************"."<br>");
                        //print($row92[0]." issue type not found =0, issue type found = 1"."<br>");
                        //***print($isue_typ[$s]."<br>");
                        $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s] = stripslashes($row92[0]);         // count of occurance of issue types for master record (issues)
                        //***print($pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s]." no. of times used"."<br>");
                  }
                  // issue type used in master + update records for given issues
                  $pdp_isue_typ_used_isue[$pdp_isue_cnt][$s] = $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
                  $pdp_isue_typ_id[$p_isue_id][$s]           = $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
                  // issue type used in master + update records for given pdp (running total)
                  $isue_typ_used_isue[$s]                    = $isue_typ_used_isue[$s] + $pdp_isue_typ_cnt_i[$pdp_isue_cnt][$s] + $pdp_isue_typ_cnt_u[$pdp_isue_cnt][$s];
                  //***print("****** Usage Total for given issue *******"."<br>");
                  //***print("** In the Issue ** ".$pdp_isue_typ_used_isue[$pdp_isue_cnt][$s]."<br>");
                  //***print("**  In the PDP  ** ".$isue_typ_used_isue[$s]."<br>");
             }
             //***print("<br>"); 
        }       

       for ($t=1;$t<=$isue_typ_cnt ; ++$t) {
            print("
                    <tr>
                     <td bgcolor=\"#99CCFF\" align=\"left\" valign=\"middle\">
                      <font color=\"#330099\">
                       $isue_typ[$t] 
                      </font>
                     </td>
                     <td bgcolor=\"#FFFF00\" valign=\"middle\">                
	                  <font color=\"#330099\"> 
                       $isue_typ_used_isue[$t]
                      </font>               
                     </td>
                    </tr>
           "); 

       //while($row79 = mysql_fetch_row($mysql_data79)) {
             //$isue_typ_cnt                      = $isue_typ_cnt + 1;
             //$isue_typ_id[$isue_typ_cnt]        = stripslashes($row79[0]);            //all issues types
             //$isue_typ[$isue_typ_cnt]           = stripslashes($row79[1]);
             //$isue_typ_ind[$isue_typ_cnt]       = stripslashes($row79[2]);
             //$isue_typ_used_isue[$isue_typ_cnt] = 0;                                  // will be used to accumulate total
             //print($isue_typ_id[$isue_typ_cnt]."-".$isue_typ[$isue_typ_cnt]."<br>");
        }

       
       // select all distinct issues for pdp
       //$query81 = "select b.issue_type_id,issue_id,count(*) 
       //              from ".$name.".issues a, issue_surrogates b
       //             where a.issue_id = b.issue_surrogate_id
       //               and a.pdp_id = '$xid'
       //          group by b.issue_type_id,a.issue_id
       //          order by a.issue_id,b.issue_type_id ";
       //$mysql_data81 = mysql_query($query81, $mysql_link) or die ("Could not query: ".mysql_error());
       //$rowcnt81 = mysql_num_rows($mysql_data81);
       //print($query81."<br>");
       //print($rowcnt81."<br>");
       //$pdp_isue_cnt = 0;
       //while($row80 = mysql_fetch_row($mysql_data80)) {
       //      $pdp_isue_typ_cnt               = $pdp_isue_typ_cnt + 1;
       //      $pdp_isue_id[$pdp_isue_typ_cnt] = stripslashes(trim($row80[0]));
       //      print($pdp_isue_id[$pdp_isue_typ_cnt]."<br>");
       // }       

       
       // select all distinct issue_id,issut_type_id
       //$query81 = "select b.issue_type_id,issue_id,count(*) 
       //              from ".$name.".issues a, issue_surrogates b
       //             where a.issue_id = b.issue_surrogate_id
       //               and a.pdp_id = '$xid'
       //          group by b.issue_type_id,a.issue_id
       //          order by a.issue_id,b.issue_type_id ";
       //$mysql_data81 = mysql_query($query81, $mysql_link) or die ("Could not query: ".mysql_error());
       //$rowcnt81 = mysql_num_rows($mysql_data81);
       //print($query81."<br>");
       //print($rowcnt81);

       // select all distinct issue_history_id,issue_type_id
       //$query82 = "select a.issue_type_id,issue_history_id,b.issue_id,count(*) 
       //              from ".$name.".issue_surrogates a, issue_history b
       //             where a.issue_surrogate_id = b.issue_history_id and b.issue_id in (select a.issue_id from issues a where a.pdp_id = '$xid')
       //          group by b.issue_id,a.issue_type_id
       //          order by b.issue_id,a.issue_type_id";
       //$mysql_data82 = mysql_query($query82, $mysql_link) or die ("Could not query: ".mysql_error());
       //$rowcnt82 = mysql_num_rows($mysql_data82);
       //print($query82."<br>");
       //print($rowcnt82);       

              
       
       
       //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

              
           // $rowcnt is the no. of issues found in a pdp
           // Select all issues for given pdp
           $query = "select issue_id,pdp_id,issue_desc,created_by,created_on,issue_area_id,issue_type_id from ".$name.".issues where pdp_id = '$xid' order by issue_id";   // and created_by = '$usr'
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
                   <td bgcolor=\"#CCFFFF\" style=\"width:75px\">
                    <font color=\"#330099\">
                     NONE
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
                   <td bgcolor=\"#CCFFF\" style=\"width:75px\">
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
               <td bgcolor=\"#99CCFF\" align=\"center\" colspan=\"2\" width=\"400px\"><font color=\"#330099\">Created</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" colspan=\"2\" width=\"400px\"><font color=\"#330099\">Last Updated</font></td>
               <td bgcolor=\"#99CCFF\" align=\"center\" width=\"50px\"><font color=\"#330099\">Updates</font></td>
             </tr>
           ");
           }
           print("
                  <tr>
                   <td bgcolor=\"#FFC000\" align=\"center\" rowspan=\"7\" width=\"50px\">
                    <font color=\"#330099\">
                     $seq
                    </font>
                   </td> 
                   <td bgcolor=\"#99CCFF\" align=\"center\" rowspan=\"7\">
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

                  <tr> 
                   <td bgcolor=\"#FFFF00\" align=\"left\" colspan=\"4\">
                   <font color=\"#330099\">
          ");
          //print("<a>$xid2</a>"."<br>");
          for ($p=1;$p<=$isue_typ_cnt ; ++$p) {
               print("&nbsp&nbsp ".$pdp_isue_typ_id[$xid2][$p]."<a>&nbsp&nbsp</a>".$isue_typ[$p]."<br>");
          }
          print("         
                    </font>
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
       echo "<script type=\"text/javascript\">window.alert(\"PDP was not found, Try Again\")</script>";  
   }
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
   print("<form method=\"post\" action=\"./list_by_pdp4.php\">
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
          <div id=\"contentb\">
          </div>   
          <div id=\"contentc\">
          </div>     
        </body>
       </html>
");

?>
