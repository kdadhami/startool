<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: setup_pdp2.php
// Date: Oct, 2010
// Notes: Hardcoding used in the following query in ('UAT')
// $queryy2 = "select pdp_id,issue_area_id,test_ind,short_desc from ".$name.".pdp_testing where pdp_id = '$xid' and short_desc in ('RA')"; 
// --------------------------------------------------------------

// Connection
require_once("./inc/connect.php");

// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
$querys5 = "SELECT user 
              FROM ".$name.".sessions
             WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#1.1 Could not query: ".mysql_error());
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
//$trans = "loop";
// ==============================

// setting up today's date
$newd  = date("d"); //day
$newm  = date("m"); //month
$newm2  = date("M"); //month
$newy  = date("Y"); //year
$newt  = time();
$new_dt = mktime(0,0,0,$newm,$newd,$newy);
$today_dt = $newd."-".$newm2."-".$newy." : ";

//load status types
$queryx = "select status_type_id,status_type,status_color_code 
             from ".$name.".status_types 
            where status_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#1 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    
$st_typ_cnt              = 1;
$st_typ_id[$st_typ_cnt]  = 0;
$st_typ[$st_typ_cnt]     = "N/A";
$st_typ_clr[$st_typ_cnt] = "";
//print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
while($rowx = mysql_fetch_row($mysql_datax)) {
      $st_typ_cnt              = $st_typ_cnt + 1;
      $st_typ_id[$st_typ_cnt]  = stripslashes(trim($rowx[0]));
      $st_typ[$st_typ_cnt]     = stripslashes(trim($rowx[1]));      
      $st_typ_clr[$st_typ_cnt] = stripslashes(trim($rowx[2]));
      //print($st_typ_id[$st_typ_cnt]."-".$st_typ[$st_typ_cnt]."-".$st_typ_clr[$st_typ_cnt]."-");
}
//print($st_typ_cnt);

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period 
             from ".$name.".pdp_periods 
            where pdp_period_ind = 1 
         order by pdp_period asc "; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#2 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    

$pdp_prd_cnt = 1;
$pdp_prd_id[$pdp_prd_cnt] = 0;
$pdp_prd[$pdp_prd_cnt] = "N/A";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $pdp_prd_cnt              = $pdp_prd_cnt + 1;
      $pdp_prd_id[$pdp_prd_cnt] = stripslashes(trim($rowx[0]));
      $pdp_prd[$pdp_prd_cnt]    = stripslashes(trim($rowx[1]));
}

//loading departments
$queryx2 = "select issue_area_id,issue_area,short_desc 
              from ".$name.".issue_areas 
             where issue_area_ind = 1 
               and test_ind = 1 "; 
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#3 Could not query: ".mysql_error());
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
$queryx5 = "select category_scope_id,category_scope 
              from ".$name.".category_scope 
             where category_scope_ind = 1 
          order by category_scope_id "; 
$mysql_datax5 = mysql_query($queryx5, $mysql_link) or die ("#4 Could not query: ".mysql_error());
$rowcntx5 = mysql_num_rows($mysql_datax5);    
$scope_cnt = 0;
while($rowx5 = mysql_fetch_row($mysql_datax5)) {
      $scope_cnt            = $scope_cnt + 1;
      $scope_id[$scope_cnt] = stripslashes(trim($rowx5[0]));
      $scope[$scope_cnt]    = stripslashes(trim($rowx5[1]));
}

//loading PDP Categories
$queryx4 = "select pdp_category_id,pdp_category,category_scope_id 
              from ".$name.".pdp_categories 
             where pdp_category_ind = 1 
          order by category_scope_id,pdp_category asc "; 
$mysql_datax4 = mysql_query($queryx4, $mysql_link) or die ("#5 Could not query: ".mysql_error());
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

if ($submit == "Submit") {

// Update all edited records
if (isset($update)) {
    while (list($key) = each($update)) {
	       //$xid[$key]            = addslashes($xid[$key]);
	       //$xpdp_desc[$key]      = strtoupper($xpdp_desc[$key]);
           $xupdated_dt[$key]      = mktime(0,0,0,$newm,$newd,$newy);
           $xupdated_by[$key]      = strtoupper(trim($usr));
           $xpdp_period_id[$key]   = addslashes($xpdp_period_id[$key]);
           $xpdp_category_id[$key] = addslashes($xpdp_category_id[$key]);
           $xcomplexity_id[$key]   = addslashes($xcomplexity_id[$key]);
           $xprojection_id[$key]   = addslashes($xprojection_id[$key]);
           $xrevenue_id[$key]      = addslashes($xrevenue_id[$key]);
           $xcomparison_id[$key]   = addslashes($xcomparison_id[$key]);
           $xparent_pdp_desc[$key] = trim($xparent_pdp_desc[$key]);
		   //$xmigration_ind[$key]   = addslashes($xmigration_ind[$key]);
           //$ycomments[$key]        = str_replace("'","",$ycomments[$key]);
           //$ycomments[$key]        = str_replace(chr(34),"",$ycomments[$key]);
           //$dontupdate             = 0;
           
           //if (strlen($ycomments[$key]) == 0) {
           //    $dontupdate = 1;
           //} else {
           //    $log_entry          = $usr." from ".$uissue_area." updated on ".$today_dt."<br>".$ycomments[$key]."<br>";
           //    $running_com        = $log_entry.$yrunning_com[$key];
           //    $yrunning_com[$key] = $running_com;    ///substr($running_com,0,4999);
           //}           
           
           if (empty($ycomments[$key])){
           } else {
                        $ycomments[$key]      = str_replace("'","",$ycomments[$key]);
                        $ycomments[$key]      = str_replace(chr(34),"",$ycomments[$key]);
                        $query110 = "INSERT into ".$name.".pdp_logs(pdp_id,issue_area,updated_by,updated_on,comments,module,action,followup)
                                     VALUES('$key','$uissue_area','$usr',current_timestamp,'$ycomments[$key]','SCOPING',0,1)";
                        $mysql_data110 = mysql_query($query110, $mysql_link) or die ("#110 Could not query: ".mysql_error());
                        $ypdp_log_id   = mysql_insert_id();
           }

           //print($log_entry."<br>".$runnig_com."<br>");
           if (empty($xparent_pdp_desc[$key])) {
               $xparent_pdp_id[$key]     = 0;
               $xmain_pdp_id[$key]       = 0;
           } else {
             //find out parent
             $queryx3 = "select a.pdp_id,a.pdp_desc
                           from ".$name.".pdp a 
                          where a.pdp_desc      = '$xparent_pdp_desc[$key]'
                            and a.parent_pdp_id = 0
                            and a.main_pdp_id   = 0 
                          ";
             $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("#6 Could not query: ".mysql_error());
             $rowcntx3 = mysql_num_rows($mysql_datax3);
             //print("$queryx3"."-".$rowcntx3); 
             if ($rowcntx3 == 1) {               
                 while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                       $xparent_pdp_id[$key] = stripslashes($rowx3[0]);
                       $xmain_pdp_id[$key]   = $xparent_pdp_id[$key];   
                 }
             } else {
                     $queryx4 = "select a.pdp_id,a.pdp_desc,a.parent_pdp_id,a.main_pdp_id
                                   from ".$name.".pdp a 
                                  where a.pdp_desc = '$xparent_pdp_desc[$key]'
                                    and a.parent_pdp_id <> 0
                                 ";
                     //print("$queryx4"); 
                     $mysql_datax4 = mysql_query($queryx4, $mysql_link) or die ("#7 Could not query: ".mysql_error());
                     $rowcntx4 = mysql_num_rows($mysql_datax4);
                     if ($rowcntx4 <> 0) {
                        //print("<br>"."herehere".$rowcntx4);
                         while($rowx4 = mysql_fetch_row($mysql_datax4)) {
                               $xparent_pdp_id[$key] = stripslashes($rowx4[0]);
                               $xmain_pdp_id[$key]   = stripslashes($rowx4[3]); 
                               //print( $xparent_pdp_id[$key]."-".$xmain_pdp_id[$key] );
                         }
                     } else {
                             $xparent_pdp_id[$key]   = 0;
                             $xmain_pdp_id[$key]     = 0;
                          //print("<br>"."no here");   
                     }                                
             }
           }
           
           //print($ld[$key].$lm[$key].$ly[$key]."<br>");
           $xpdp_launch_date[$key] = mktime(0,0,0,$lm[$key],$ld[$key],$ly[$key]);
           //print($xpdp_launch_date[$key]);
           // Check if date is January 1, 2007
           if ($xpdp_launch_date[$key] == 1167627600) {
               $xpdp_launch_date[$key] = 0;
           } 
                      
           //$new_entry_dt[$key]         = mktime(0,0,0,$new_xm[$key],$new_xd[$key],$new_xy[$key]);
           if ($xpdp_category_id[$key] == -1){
               $xpdp_category_id[$key] = 0;
           }
           
           //if ($dontupdate == 1){
           //} else {
  	       //   $query = "UPDATE ".$name.".pdp
		   //                SET comments         = '$ycomments[$key]',
           //                    running_comments = '$yrunning_com[$key]'
		   //              WHERE pdp_id           = '$key' ";
		   //   //print($query);
           //   //print($key);
		   //   $mysql_data = mysql_query($query, $mysql_link) or die ("#8 Could not query: ".mysql_error());
		   //}
    }
    //print($pdpid."key");
    if (isset($area_cnt)) {
        //print($area_cnt); 
        for ($h=1;$h<=$area_cnt ; ++$h) {
             //print("-".$yissue_area_id[$h]."-".$ytest_ind[$h]);
  	         $queryy = "UPDATE ".$name.".pdp_testing
		                SET test_ind      = '$ytest_ind[$h]'
		              WHERE pdp_id        = '$pdpid' 
                        and issue_area_id = '$yissue_area_id[$h]' ";
           //print($queryy);            
		   $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#9 Could not query: ".mysql_error());
        }    
    }
}
}

$captn = "Scoping";

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
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
          /*caption    { background:#FFC000; color:#0000FF; font-size:1em;}*/  
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
           #contentb { top:0%;
                       width: 100%; height: 1%; /*background: #CEE3F6;*/
                     }
           #contentc { top:0%;
                       width: 100%; height: 34%; /*background: #CEF6E3;*/
                       /*border: 1px solid; border-color:#BDBDBD;*/
                     }
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
         <div id=\"content\">
");

// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------

// Start of HTMl
//---------
   //print("$pdp");
   $queryx = "select a.pdp_id,
                     a.pdp_desc,
					 a.updated_date,
					 a.updated_by,
					 a.pdp_name,
					 a.pdp_owner,
					 a.pdp_launch,
                     a.pdp_status,
					 a.pdp_period_id,
					 a.pdp_category_id,
					 a.complexity_id,
					 a.projection_id,
                     a.revenue_id,
					 a.comparison_id,
					 a.parent_pdp_id,
					 a.main_pdp_id,
				     a.migration_ind,
					 a.v21buildstatus,
					 a.programcategory,
					 a.segment,
					 a.productline,
					 a.lob
               from ".$name.".pdp a 
              where a.pdp_desc = '$pdp'"; 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#22 Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$rowcntx");
   //$captn = "Issue List (Click the Issue No hyper link to see updates)";

   if ($rowcntx == 1) {
       $found = 1;   
     
       $seq = 0;
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
             $xparent_pdp_id   = stripslashes($rowx[14]);
             $xmain_pdp_id     = stripslashes($rowx[15]); 
			 $xmigration_ind   = stripslashes($rowx[16]);
             //$xpdp_period    = stripslashes($rowx[14]);
             //$ycomments        = ""; stripslashes($rowx[16]);
             //$yrunning_com     = nl2br(stripslashes($rowx[17])); 
             //$zrunning_log     = str_replace("<br>", "\n\n", $yrunning_com);                        
			 $xv21buildstatus  = stripslashes($rowx[17]);
			 $xprogramcategory = stripslashes($rowx[18]);
			 $xsegment         = stripslashes($rowx[19]);
			 $xproductline     = stripslashes($rowx[20]);
			 $xlob             = stripslashes($rowx[21]);

	         if ($xproductline == "ALL"){
	             $ylob   = "ALL";
	         }
	         // Cable
	         if ($xproductline == "CABLE" || $xproductline == "HP" || $xproductline == "INTFIX" || $xproductline == "VIDEO" || $xproductline == "CABLE TV" || $xproductline == "RCG" || $xproductline == "RHSI"){
	             $ylob   = "CABLE";
	         }
	         // Wireless
	         if ($xproductline == "FIDO" || $xproductline == "INTMOB" || $xproductline == "WDATA" || $xproductline == "WDUAL" || $xproductline == "WI" || $xproductline == "WVOICE" || $xproductline == "RWI"){
	             $ylob   = "WIRELESS";
	         }

			 
             $queryx1 = "select a.pdp_desc
                           from ".$name.".pdp a 
                          where a.pdp_id = '$xparent_pdp_id'"; 
             //print("$queryx1"); 
             $mysql_datax1 = mysql_query($queryx1, $mysql_link) or die ("#23 Could not query: ".mysql_error());
             $rowcntx1 = mysql_num_rows($mysql_datax1);
             if ($rowcntx1 == 1){
                 while($rowx1 = mysql_fetch_row($mysql_datax1)) {
                       $xparent_pdp_desc = stripslashes($rowx1[0]);   
                 }
             } else {
                 $xparent_pdp_desc = ""; 
             }

             $queryx2 = "select a.pdp_desc
                           from ".$name.".pdp a 
                          where a.pdp_id = '$xmain_pdp_id'"; 
             //print("$queryx2"); 
             $mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#24 Could not query: ".mysql_error());
             $rowcntx2 = mysql_num_rows($mysql_datax2);
             if ($rowcntx2 == 1){
                 while($rowx2 = mysql_fetch_row($mysql_datax2)) {
                       $xmain_pdp_desc = stripslashes($rowx2[0]);   
                 }
             } else {
                 $xmain_pdp_desc = ""; 
             }

             if (empty($xpdp_launch)) {
                 $xpdp_launch_dt = "00-00-0000";
             } else {
                 $xpdp_launch_d    = date("d",$xpdp_launch);
                 $xpdp_launch_m    = date("M",$xpdp_launch);
                 $xpdp_launch_m1   = date("m",$xpdp_launch);
                 $xpdp_launch_y    = date("y",$xpdp_launch); 
                 $xpdp_launch_y1   = date("Y",$xpdp_launch);   
                 $xpdp_launch_dt   = $xpdp_launch_d."-".$xpdp_launch_m."-".$xpdp_launch_y;
                 $xpdp_launch_date = mktime(0,0,0,$xpdp_launch_m1,$xpdp_launch_d,$xpdp_launch_y1);
             }

             // --------------------------------------------------- pdp_tesing
             $queryy = "select pdp_id,issue_area_id,test_ind from ".$name.".pdp_testing where pdp_id = '$xid'"; 
             $mysql_datay = mysql_query($queryy, $mysql_link) or die ("#25 Could not query: ".mysql_error());
             $rowcnty = mysql_num_rows($mysql_datay);  

             // Insert a record
             if ($rowcnty == 0) {
                $d = 0;
                for ($d=1;$d<=$dept_cnt ; ++$d) {
                         //test_ind = 0 means NO
                         $queryi = "INSERT into ".$name.".pdp_testing(pdp_id,issue_area_id,test_ind,short_desc)
                                    VALUES('$xid','$dept_id[$d]',0,'$dept_code[$d]')";
                         $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#26 Could not query: ".mysql_error());
                        }
             } 
             // --------------------------------------------------- pdp_tesing

             // --------------------------------------------------- Extracting Logs

                         $query92 = "select pdp_log_id,updated_by,updated_on,comments,issue_area
                                      from ".$name.".pdp_logs   
                                     where pdp_id = '$xid'
                                       and issue_area = '$uissue_area' 
                                       and module = 'SCOPING'
                                    "; 
                         //print($query91);               
                         $mysql_data92 = mysql_query($query92, $mysql_link) or die ("#91 Could not query: ".mysql_error());
                         $rowcnt92 = mysql_num_rows($mysql_data92);

                         if ($rowcnt92 > 0){
                             $comcnt = 0;
                             $ycomments = "";
                             while($rowx92 = mysql_fetch_row($mysql_data92)) {
                                   $comcnt                  = $comcnt + 1;
                                   $ypdp_log_id             = stripslashes($rowx92[0]);
                                   $yupdated_by             = stripslashes($rowx92[1]);
                                   $yupdated_on             = stripslashes($rowx92[2]);
                                   $ycomments               = stripslashes($rowx92[3]);
                                   $yissue_area             = stripslashes($rowx92[4]);
                                   $urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   $urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                                   //print($urunning_com[$comcnt]);
                             }
                         }

             // --------------------------------------------------- Extracting Logs

          // Start of HTMl
          print("
           <form method=\"post\" action=\"./setup_pdp2_cm.php?pdp=$pdp&&start=$start\">
            <table border='0' align=\"center\" scroll=\"yes\" width=\"80%\">
             <caption>$captn</caption>
             <tr>
              <td bgcolor=\"#99CC00\" align=\"center\"><font color=\"#FFFFFF\">No</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#99CC00\" style=\"width:500px;\">
               $seq
	          </td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
              </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Id</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:500px;\">
	           <font color=\"#000000\"> 
                 <a>$xid</a>
               </font>   
	          </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">PDP No.</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\"> 
                $xpdp_desc
               </font>
              </td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
              </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">PDP Name</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"word-wrap: break-word; width:500px;\">
	           <font color=\"#330099\"> 
                <p style=\"word-wrap: break-word; width:500px;\">$xpdp_name</p>
               </font> 	            
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Owner</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\"> <!--width=\50\ can be added to style-->
	           <font color=\"#330099\"> 
                $xpdp_owner
               </font> 	            
	          </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Launch<br>(DD-MM-YYYY)</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
	           <font color=\"#330099\"> 
	            <a>$xpdp_launch_dt</a>
	           </font> 
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Status</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
	           <font color=\"#330099\"> 
                $xpdp_status
               </font> 
              </td> 
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Type</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
          ");
          //if ($xpdp_period_id == 0) {
          //    print(" <select align=\"center\" name=\"xpdp_period_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
          //} else {
          //    print(" <select align=\"center\" name=\"xpdp_period_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
          //}
          //     <select align=\"center\" name=\"xpdp_period_id[$xid]\">  
          //");
          $w = 0;
          for ($w=1;$w<=$pdp_prd_cnt ; ++$w) {
               if ($pdp_prd_id[$w] == $xpdp_period_id) {
                   //print(" <option selected value=\"$pdp_prd_id[$w]\">$pdp_prd[$w]</option> ");
                   print("
	                      <font color=\"#330099\"> 
	                       <a>$pdp_prd[$w]</a>
	                      </font>                           
                   ");
               }
               //else {
                   //print(" <option value=\"$pdp_prd_id[$w]\">$pdp_prd[$w]</option> ");
               //}
          }
          print(" <!--</select>-->
             </td>
	         <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	         </td>	          
            </tr>

			<tr>
             <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Migration Testing</font></td>
             <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
          ");
          //if ($xmigration_ind[$y] == 0) {
          //    print(" <select align=\"center\" name=\"xmigration_ind[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
          //} else {
          //    print(" <select align=\"center\" name=\"xmigration_ind[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
          //}
          for ($e=1;$e<=2; ++$e) {
               if ($xmigration_ind == $ind_id[$e]) {
                   //print(" <option selected value=\"$ind_id[$e]\">$ind[$e]</option> ");
                   print("
				         <font color=\"#330099\"> 
	                       <a>$ind[$e]</a>
	                      </font>                           
                   ");				   
               } //else {
                 //  //print(" <option value=\"$ind_id[$e]\">$ind[$e]</option> ");    
                 // print("
				 //        <font color=\"#330099\"> 
	             //          <a>$ind[$e]</a>
	             //         </font>                           
                 //  ");				   
			   //}   
          }                         
          print("        
                 </select>
                </td>
	            <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	            </td>	          
  		     </tr> 			
			
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Parent PDP</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">
                <!--<input type=\"text\" name=\"xparent_pdp_desc[$xid]\" value=\"$xparent_pdp_desc\" size=\"9\" maxlength=\"9\">-->
                <font color=\"#330099\">
                 $xparent_pdp_desc
                </font>
               </font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Main PDP</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">
                $xmain_pdp_desc
               </font>
               <input type=\"hidden\" name=\"xmain_pdp_id[$xid]\" value=\"$xmain_pdp_id\">
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Last Updated On</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xdt</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Last Updated By</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xupdated_by</font>
	          </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>
      ");
      // --------------------------------------------------- pdp_tesing  
      // Display records for update
      $queryy2 = "select pdp_id,issue_area_id,test_ind,short_desc from ".$name.".pdp_testing where pdp_id = '$xid' and short_desc in ('UAT')"; 
      $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("#31 Could not query: ".mysql_error());
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
                $mysql_datax3 = mysql_query($queryx3, $mysql_link) or die ("#32 Could not query: ".mysql_error());
                $rowcntx3 = mysql_num_rows($mysql_datax3);    
                while($rowx3 = mysql_fetch_row($mysql_datax3)) {
                      $deptx = stripslashes(trim($rowx3[0]));
                }

                //$d = 0;
                //for ($d=1;$d<=$dept_cnt ; ++$d) {
                     //test_ind = 0 means NO and 1 means YES 
                     print("
                            <tr>
                             <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">$deptx Testing</font></td>
                             <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
                     ");
                     if ($ytest_ind[$y] == 0) {
                         //print(" <select align=\"center\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
                     } else {
                         //print(" <select align=\"center\" name=\"ytest_ind[$y]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
                     }
                     //         <select align=\"center\" name=\"ytest_ind[$y]\">
                     //");
                     for ($e=1;$e<=2; ++$e) {
                          if ($ytest_ind[$y] == $ind_id[$e]) {
                                  print("
         	                             <font color=\"#330099\"> 
                                          $ind[$e]
                                         </font>
                                         <input type=\"hidden\" name=\"ytest_ind[$y]\" value=\"$ind_id[$e]\">                                   
                                  ");  
                          }
                     }                         
                     print("        
                               <!--</select>-->
                              <input type=\"hidden\" name=\"yissue_area_id[$y]\" value=\"$yissue_area_id[$y]\"> 
                             </td>
  	                         <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	                         </td>	          
                     ");
          }
          print("   <input type=\"hidden\" name=\"area_cnt\" value=\"$rowcnty2\">
                    <input type=\"hidden\" name=\"pdpid\" value=\"$xid\"> 
                  </tr>
                ");
      } 
      // --------------------------------------------------- pdp_tesing      
      print("
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">PDP Category</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\"> <!--width=\50\ can be added to style-->
            ");
     if ($xpdp_category_id == 0) {
         //print(" <select align=\"center\" name=\"xpdp_category_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
     } else {
         //print(" <select align=\"center\" name=\"xpdp_category_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
     }
     $pcat_found = 0;       
     for ($f=1;$f<=$pcat_cnt; ++$f) {
         if ($pcat_id[$f] == -1)
         {
             //print(" <option value=\"$pcat_id[$f]\" disabled=\"disabled\" style=\"color: #0000FF; font-weight: bold; background-color: #000000;\">$pcat[$f]</option> ");
         } 
         if ($pcat_id[$f] == 0)
         {
             //print(" <option value=\"$pcat_id[$f]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\">$pcat[$f]</option> ");
             //print(" <font color=\"#330099\">$pcat[$f]</font> ");  
         }         
         if (($pcat_id[$f] <> -1) && ($pcat_id[$f] <> 0))
         {
             if ($xpdp_category_id == $pcat_id[$f])  {
                  if ($pcat_id[$f] <> 0) {
                      //print(" <option selected value=\"$pcat_id[$f]\" style=\"color: #0000FF; font-weight: bold; background-color: #FFFFFF;\">$pcat[$f]</option> "); 
                      print(" <font color=\"#330099\">$pcat[$f]</font> ");   
                      $query11 = "select b.category_scope from ".$name.".pdp_categories a, category_scope b
                                   where a.pdp_category_id = '$pcat_id[$f]'
                                     and a.category_scope_id = b.category_scope_id "; 
                      $mysql_data11 = mysql_query($query11, $mysql_link) or die ("#35 Could not query: ".mysql_error());
                      $rowcnt11 = mysql_num_rows($mysql_data11);  
                      while($row11 = mysql_fetch_row($mysql_data11)) {
	                        $zcategory_scope = stripslashes($row11[0]);
                      }
                      $pcat_found = 1;    
                  } 
             }
             else
             {
               //print(" <option value=\"$pcat_id[$f]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\" >$pcat[$f]</option> ");
               //print(" <font color=\"#330099\"><br>$pcat[$f]</font> ");
             }
         }            
     }
     if ($pcat_found == 0) {
         $zcategory_scope = ""; 
     }                         
     print("        
               </select>
	          </td>
              <td bgcolor=\"#CCFFFF\" align=\"center\" style=\"width:100px;\"><font color=\"#330099\">$zcategory_scope</font></td>
             </tr>
             
             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\">Complexity</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\">
     ");

     if ($xcomplexity_id == 0) {
         //print(" <select align=\"center\" name=\"xcomplexity_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
     } else {
         //print(" <select align=\"center\" name=\"xcomplexity_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
     }           
     $comp_found = 0;       
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xcomplexity_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print(" <font color=\"#330099\">$st_typ[$f]</font> ");
             } else
             {
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             }
     }
     print("        
               </select>
	          </td>
              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">&nbsp</td>
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\">Revenue Impact</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\"> <!--width=\50\ can be added to style-->
     ");

     if ($xrevenue_id == 0) {
         //print(" <select align=\"center\" name=\"xrevenue_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
     } else {
         //print(" <select align=\"center\" name=\"xrevenue_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
     }           
     $revn_found = 0;
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xrevenue_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print(" <font color=\"#330099\">$st_typ[$f]</font> ");
             } else
             {
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             }
     }
     print("        
               </select>
	          </td>
              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">&nbsp</td>
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\">Customer Impact</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\"> <!--width=\50\ can be added to style-->
     ");     

     if ($xprojection_id == 0) {
         //print(" <select align=\"center\" name=\"xprojection_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
     } else {
         //print(" <select align=\"center\" name=\"xprojection_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
     }           
     $prjc_found = 0;       
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xprojection_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print(" <font color=\"#330099\">$st_typ[$f]</font> ");
             } else
             {
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             }
     }
     print("        
               </select>
	          </td>
              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">&nbsp</td>
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\"><font color=\"#330099\">Past Impact</font></td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\"  style=\"word-wrap: break-word; width:500px;\">
     ");     

     if ($xcomparison_id == 0) {
         //print(" <select align=\"center\" name=\"xcomparison_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFF00;\"> ");
     } else {
         //print(" <select align=\"center\" name=\"xcomparison_id[$xid]\" style=\"color: #000000; font-weight: normal; background-color: #FFFFFF;\"> ");
     }           
     $cmpr_found = 0;       
     for ($f=1;$f<=$st_typ_cnt; ++$f) {
             if ($xcomparison_id == $st_typ_id[$f]) {
                 //print(" <option selected value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
                 print(" <font color=\"#330099\">$st_typ[$f]</font> ");
             } else
             {
                 //print(" <option value=\"$st_typ_id[$f]\">$st_typ[$f]</option> ");
             }
     }
     print("        
               </select>
	          </td>
              <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\">&nbsp</td>
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">V21 Build Status</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xv21buildstatus</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Program Category</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xprogramcategory</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Segment</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xsegment</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>

             <tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Product Line</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$ylob</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:100px;\">
			   <font color=\"#330099\">$xproductline</font>
	          </td>	          
             </tr>

             <!--<tr>
              <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Line of Business</font></td>
              <td align=\"center\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:500px;\">
               <font color=\"#330099\">$xlob</font>
              </td>
	          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	          </td>	          
             </tr>-->
			 
			 
                <tr>
                 <td colspan=\"3\" bgcolor=\"#99CCFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Enter New Comments
                  </font>
                 </td>
                </tr>
                      <tr>
                       <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\">
         	            <font color=\"#330099\">
                         <textarea name=\"ycomments[$xid]\" cols=\"1\" rows=\"2\" style=\"word-wrap: break-word; word-break:break-all; width:100%;\"></textarea> 
                        </font>
                       </td>
                       <input type=\"hidden\" name=\"yrunning_com[$xid]\" value=\"$yrunning_com\">
                      </tr>
                <tr>
                 <td colspan=\"3\" bgcolor=\"#99CCFF\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Comments Log
                  </font>
                 </td>
                </tr>
                <tr>
                 <td colspan=\"3\" border=\"1\" bgcolor=\"#FFFFFF\" align=\"left\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px;  scroll-x: auto;\">
                  <div style=\"word-wrap: break-word; word-break:break-all; width:100%; height:100px; overflow: auto; background-color: #CCCCCC;\">
                   <p>
               ");
               for ($com=$comcnt;$com>=1; --$com) {
                    $wrunning_usr = nl2br($urunning_usr[$com]);
                    $wrunning_com = nl2br($urunning_com[$com]);
                    print($wrunning_usr.$wrunning_com);
               }
               print("<br>");
               print("
                    </p> 
                   </div>
                 </td>                  
                </tr>
     ");

      // checking if this pdp has issues, so to ascertain to allow delete of pdp or not
      $queryi = "select issue_id from ".$name.".issues where pdp_id = '$xid'"; 
      $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#51 Could not query: ".mysql_error());
      $rowcnti = mysql_num_rows($mysql_datai);
      //print("
      //       <tr>
      //        <td bgcolor=\"#ECE5B6\" align=\"center\"><font color=\"#330099\">Update</font></td>
      //        <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:500px;\">
      //          <input type=\"checkbox\" name=\"update[$xid]\" value=\"Update\">
      //          <input type=\"hidden\" name=\"start\" value=\"1\">
      //        </td>
	  //        <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:100px;\">
	  //        </td>	          
      //       </tr>
      //");
}
// Display options
print("
            </table>
            <table border='0' align=\"center\">
             <tr>
              <td>
               <br />
     ");

// End of HTML
print("            <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                   <input type=\"hidden\" name=\"update[$xid]\" value=\"$xid\"> 
                 </td>
                </tr>
           </form>
     ");
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"PDP No. was not found, Try Again\")</script>";  
   }
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
   print("<form method=\"post\" action=\"./setup_pdp2_cm.php\">
           <table border='0' scroll=\"yes\">
            <!--<caption>$captn</caption>-->
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
