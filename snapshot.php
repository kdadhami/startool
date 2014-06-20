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
                         }
						 
						table.with-border {
							border-color: #c1c1c1;
							border-style: solid;
							border-width: 0 0 1px 1px;
							margin:0px;
							padding:0px
						}	
						table.with-border td {
							border-color: #c1c1c1;
							border-style: solid;
							border-width: 1px 1px 0 0;
							margin:0px;
							padding:2px
						}	
						table.with-border th {
							border-color: #c1c1c1;
							border-style: solid;
							border-width: 1px 1px 0 0;
							margin:0px;
							padding:2px;
							background: #B2B2B2;
						}	
						table.with-border td.normal {
							background: #CCE5F6;
						}
						table.with-border td.in-scope {
							background: #A0EA96;
						}
						table.with-border td.out-scope {
							background: #FBFB89;
						}
						table.with-border td.zero-fill {
							color: #c1c1c1;
						}
						table.with-border th.empty {
							background: #FFFFFF;
						}	
						table.with-border td.gross {
							background: #C5C5C5;
							font-weight:bold;
						}
						table.with-border td.net {
							background: #A0EA96;
							font-weight:bold;
						}
						table.with-border td.seprator {
							background: #FFFFFF;
							border-top: 0px;
							border-bottom: 0px;
						}	
						table.with-border td.empty {
							background: #FFFFFF;
							border-top: 0px;
							border-bottom: 0px;
						}	
						
						
                   th    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                           color: blue;
                           border: 1px solid #CCCCCC; 
                           /*border-style:solid;
                           border-color:#CCCCCC;*/
                         }
                   td    { font-family: Calibri, Helvetica, sans-serif;
                           font-size: 12px;
                           color: #000000;
                           border: 1px solid #CCCCCC; 
                           border-style:solid;
                           border-color:#CCCCCC;
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

// faridi-1
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
$xreport_nam = "SNAPSHOT-".$ydate3.".htm";


// REPORT LOGIC START


//if ($start == 1) {          //// Taken to line 34 above
   // ------------------------------------------------------------------------------------------------------------ //
   ob_start();
   print($hstart);
   // ------------------------------------------------------------------------------------------------------------ //
  
	$query_pdp_type_cat = "
		SELECT 
			m.pdp_type,m.pdp_category,m.scoping
		FROM 
			".$name.".tgt_pdp_main m ,
			".$name.".tgt_pdp_area_work_effort am,
			".$name.".tgt_pdp_area_work_effort ar,
			".$name.".tgt_pdp_area_work_effort ac,
			".$name.".tgt_pdp_area_work_effort au
		WHERE 
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE') AND
			(m.pdp = am.pdp AND am.issue_area = 'MARKETING OPERATIONS') AND
			(m.pdp = ar.pdp AND ar.issue_area = 'REVENUE ASSURANCE') AND
			(m.pdp = ac.pdp AND ac.issue_area = 'CONFIGURATION MANAGEMENT') AND
			(m.pdp = au.pdp AND au.issue_area = 'ENTERPRISE UAT')
		GROUP BY m.pdp_type,m.pdp_category,m.scoping
		ORDER BY m.pdp_type,m.pdp_category,m.scoping";
	
	$data_pdp_type_cat  = mysql_query($query_pdp_type_cat, $mysql_link) or die ("#query_pdp_type_cat Could not query: ".mysql_error()); 
	
	$columns_int = array (
		"SEP-1" => '&nbsp;',
		"C1" => 0,
		"C2-INSCOPE" => 0,
		"C3-OUTSCOPE" => 0,
		"SEP-2" => '&nbsp;',
		"C4" => 0,
		"C5-INSCOPE" => 0,
		"C6-OUTSCOPE" => 0,
		"SEP-3" => '&nbsp;',
		"C7" => 0,
		"C8" => 0,
		"C9" => 0,
		"C10" => 0,
		"SEP-4" => '&nbsp;',
		"C11" => 0,
		"C12-INSCOPE" => 0,
		"C13-OUTSCOPE" => 0,
		"SEP-5" => '&nbsp;',
		"C14" => 0,
		"SEP-6" => '&nbsp;',
		"C15" => 0,
		"C16" => 0,
		"C17" => 0,
		"C18" => 0,
		"SEP-7" => '&nbsp;',
		"C19" => 0,
		"C20-INSCOPE" => 0,
		"C21-OUTSCOPE" => 0,
		"SEP-8" => '&nbsp;',
		"C22" => 0,
		"C23" => 0,
		"C24-INSCOPE" => 0,
		"C25-OUTSCOPE" => 0,
		"C26" => 0,
		"C27" => 0,
		"C28" => 0,
		"C29" => 0,
		"SEP-9" => '&nbsp;',
		"C30" => 0,
		"C31" => 0,
		"C32-INSCOPE" => 0,
		"C33-OUTSCOPE" => 0,
		"C34" => 0,
		"C35" => 0,
		"C36" => 0,
		"C37" => 0,
		"SEP-10" => '&nbsp;',
		"C38" => 0,
		"C39" => 0,
		"C40-INSCOPE" => 0,
		"C41-OUTSCOPE" => 0,
		"C42" => 0,
		"C43" => 0,
		"C44" => 0,
		"C45" => 0,
		"SEP-11" => '&nbsp;',
		"C46" => 0,
		"C47" => 0,
		"C48-INSCOPE" => 0,
		"C49-OUTSCOPE" => 0,
		"C50" => 0,
		"C51" => 0,
		"C52" => 0,
		"C53" => 0,
		"SEP-12" => '&nbsp;',
		"C54" => 0,
		"C55" => 0,
		"C56" => 0,
		"C57" => 0,
		"C58" => 0,
		"C59" => 0,
		"C60" => 0,
		"C61" => 0,
		"C62" => 0,
		"C63" => 0,
		"C64" => 0,
		"C65" => 0,
		"C66" => 0,
		"C67" => 0,
		"C68" => 0,
		"C69" => 0,
		"C70" => 0,
		"C71" => 0,
		"C72" => 0,
		"C73" => 0,
		"C74" => 0,
		"C75" => 0,
		"C76" => 0,
		"C77" => 0,
		"C78" => 0,
		"C79" => 0,
		"C80" => 0,
		"C81" => 0,
		"C82" => 0,
		"C83" => 0,
		"C84" => 0,
		"C85" => 0,
		"C86" => 0,
		"C87" => 0,
		"C88" => 0,
		"SEP-13" => '&nbsp;',
		"C89" => 0,
		"C90" => 0,
		"C91" => 0,
		"C92" => 0,
		"C93" => 0,
		"C94" => 0,
		"C95" => 0,
		"C96" => 0,
		"C97" => 0
	);
	
	$ra_uat_init = array(
		"YESYES" => array(
			"ISSUE_LOGGED" => 0,
			"ISSUE_IN_SCOPE" => 0,
			"ISSUE_OUT_OF_SCOPE" => 0,
			"MO_ISSUES" => 0,
			"RA_ISSUES" => 0,
			"CM_ISSUES" => 0,
			"UAT_ISSUES" => 0,
			"PDP_COUNT" =>0,
		),
		"YESNO" => array(
			"ISSUE_LOGGED" => 0,
			"ISSUE_IN_SCOPE" => 0,
			"ISSUE_OUT_OF_SCOPE" => 0,
			"MO_ISSUES" => 0,
			"RA_ISSUES" => 0,
			"CM_ISSUES" => 0,
			"UAT_ISSUES" => 0,
			"PDP_COUNT" =>0,
		),
		"NOYES" => array(
			"ISSUE_LOGGED" => 0,
			"ISSUE_IN_SCOPE" => 0,
			"ISSUE_OUT_OF_SCOPE" => 0,
			"MO_ISSUES" => 0,
			"RA_ISSUES" => 0,
			"CM_ISSUES" => 0,
			"UAT_ISSUES" => 0,
			"PDP_COUNT" =>0,
		),
		"NONO" => array(
			"ISSUE_LOGGED" => 0,
			"ISSUE_IN_SCOPE" => 0,
			"ISSUE_OUT_OF_SCOPE" => 0,
			"MO_ISSUES" => 0,
			"RA_ISSUES" => 0,
			"CM_ISSUES" => 0,
			"UAT_ISSUES" => 0,
			"PDP_COUNT" =>0,
		)
	);
	
	$arr_pdp_type_cat = array();
	$arr_ra_uat = array();
	
	while($row_pdp_type_cat = mysql_fetch_row($data_pdp_type_cat)) {
		$arr_pdp_type_cat[trim(stripslashes($row_pdp_type_cat[0]))][trim(stripslashes($row_pdp_type_cat[1]))][trim(stripslashes($row_pdp_type_cat[2]))] = $columns_int;
		$arr_ra_uat[trim(stripslashes($row_pdp_type_cat[0]))][trim(stripslashes($row_pdp_type_cat[1]))][trim(stripslashes($row_pdp_type_cat[2]))] = $ra_uat_init;
	}
	
	$query_mis_1 = " 
		SELECT 	
			m.pdp_type             as pdp_type,
			m.pdp_category         as pdp_category,
			m.scoping              as scoping,
			count(*)               as pdp_count,
			sum(m.issues_created)  as issues_created
		FROM 	
			".$name.".tgt_pdp_main m
		WHERE 	
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE')
		GROUP BY m.pdp_type,m.pdp_category,m.scoping
		ORDER BY m.pdp_type,m.pdp_category,m.scoping";
	
	$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
	
	while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
		$data = $arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
		$data['C1'] = trim(stripslashes($row_mis_1[3]));
		if (trim(stripslashes($row_mis_1[2])) == 'IN SCOPE') {
			$data['C2-INSCOPE'] = trim(stripslashes($row_mis_1[3]));
			$data['C3-OUTSCOPE'] = 0;
		} else {
			$data['C2-INSCOPE'] = 0;
			$data['C3-OUTSCOPE'] = trim(stripslashes($row_mis_1[3]));
		}
		$arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $data;
	}
	
	$query_mis_1 = "
		SELECT 
			m.pdp_type             as pdp_type,
			m.pdp_category         as pdp_category,
			m.scoping              as scoping,
			sum(m.issues_created)  as issues_created,
			sum(am.issue_count)    as MO_Issues,
			sum(ar.issue_count)    as RA_Issues,
			sum(ac.issue_count)    as CM1_Issues,
			sum(ac2.issue_count)   as CM2_Issues,
			sum(au.issue_count)    as UAT_Issues
		FROM 
			".$name.".tgt_pdp_main m ,
			".$name.".tgt_pdp_area_execution am,
			".$name.".tgt_pdp_area_execution ar,
			".$name.".tgt_pdp_area_execution ac,
			".$name.".tgt_pdp_area_execution ac2,
			".$name.".tgt_pdp_area_execution au
		WHERE 	
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE') and
			(m.pdp = am.pdp  and am.issue_area  = 'MARKETING OPERATIONS'      and am.test_iteration  = 1) and
			(m.pdp = ar.pdp  and ar.issue_area  = 'REVENUE ASSURANCE'         and ar.test_iteration  = 1) and
			(m.pdp = ac.pdp  and ac.issue_area  = 'CONFIGURATION MANAGEMENT'  and ac.test_iteration  = 1) and
			(m.pdp = ac2.pdp and ac2.issue_area = 'CONFIGURATION MANAGEMENT'  and ac2.test_iteration = 2) and
			(m.pdp = au.pdp  and au.issue_area  = 'ENTERPRISE UAT'            and au.test_iteration  = 1)
		GROUP BY m.pdp_type,m.pdp_category,m.scoping
		ORDER BY m.pdp_type,m.pdp_category,m.scoping";

	$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
	
	while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
		$data = $arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
		$data['C4'] = trim(stripslashes($row_mis_1[3]));
		if (trim(stripslashes($row_mis_1[2])) == 'IN SCOPE') {
			$data['C5-INSCOPE'] = trim(stripslashes($row_mis_1[3]));
			$data['C6-OUTSCOPE'] = 0;
		} else {
			$data['C5-INSCOPE'] = 0;
			$data['C6-OUTSCOPE'] = trim(stripslashes($row_mis_1[3]));
		}
		$data['C7'] = trim(stripslashes($row_mis_1[4]));
		$data['C8'] = trim(stripslashes($row_mis_1[5]));
		$data['C9'] = trim(stripslashes($row_mis_1[6]));
		$data['C10'] = trim(stripslashes($row_mis_1[7]));
		$data['C11'] = trim(stripslashes($row_mis_1[8]));
		if (trim(stripslashes($row_mis_1[2])) == 'IN SCOPE') {
			$data['C12-INSCOPE'] = trim(stripslashes($row_mis_1[8]));
			$data['C13-OUTSCOPE'] = 0;
		} else {
			$data['C12-INSCOPE'] = 0;
			$data['C13-OUTSCOPE'] = trim(stripslashes($row_mis_1[8]));
		}
		
		$arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $data;
	}
	
	$query_mis_1 = "
		SELECT 
			m.pdp_type             as pdp_type,
			m.pdp_category         as pdp_category,
			m.scoping              as scoping,
			sum(m.issues_created)  as issues_created,
			sum(am.back_to_build)  as MO_Back2Build,
			sum(ar.back_to_build)  as RA_Back2Build,
			sum(ac.back_to_build)  as CM1_Back2Build,
			sum(ac2.back_to_build) as CM2_Back2Build,
			sum(au.back_to_build)  as UAT_Back2Build
		FROM 
			".$name.".tgt_pdp_main m ,
			".$name.".tgt_pdp_area_execution am,
			".$name.".tgt_pdp_area_execution ar,
			".$name.".tgt_pdp_area_execution ac,
			".$name.".tgt_pdp_area_execution ac2,
			".$name.".tgt_pdp_area_execution au
		WHERE 	
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE') and
			(m.pdp = am.pdp  and am.issue_area  = 'MARKETING OPERATIONS'      and am.test_iteration  = 1) and
			(m.pdp = ar.pdp  and ar.issue_area  = 'REVENUE ASSURANCE'         and ar.test_iteration  = 1) and
			(m.pdp = ac.pdp  and ac.issue_area  = 'CONFIGURATION MANAGEMENT'  and ac.test_iteration  = 1) and
			(m.pdp = ac2.pdp and ac2.issue_area = 'CONFIGURATION MANAGEMENT'  and ac2.test_iteration = 2) and
			(m.pdp = au.pdp  and au.issue_area  = 'ENTERPRISE UAT'            and au.test_iteration  = 1)
		GROUP BY m.pdp_type,m.pdp_category,m.scoping
		ORDER BY m.pdp_type,m.pdp_category,m.scoping";

	$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
	
	while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
		$data = $arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
		$data['C14'] = trim(stripslashes($row_mis_1[4])) +
					   trim(stripslashes($row_mis_1[5])) +
					   trim(stripslashes($row_mis_1[6])) +
					   trim(stripslashes($row_mis_1[7])) +
					   trim(stripslashes($row_mis_1[8]));
		$data['C15'] = trim(stripslashes($row_mis_1[4]));
		$data['C16'] = trim(stripslashes($row_mis_1[5]));
		$data['C17'] = trim(stripslashes($row_mis_1[6]));
		$data['C18'] = trim(stripslashes($row_mis_1[7]));
		$data['C19'] = trim(stripslashes($row_mis_1[8]));
		if (trim(stripslashes($row_mis_1[2])) == 'IN SCOPE') {
			$data['C20-INSCOPE'] = trim(stripslashes($row_mis_1[8]));
			$data['C21-OUTSCOPE'] = 0;
		} else {
			$data['C20-INSCOPE'] = 0;
			$data['C21-OUTSCOPE'] = trim(stripslashes($row_mis_1[8]));
		}
		$arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $data;
	}

	$query_mis_1 = "
		SELECT 
			m.pdp_type             as pdp_type,
			m.pdp_category         as pdp_category,
			m.scoping              as scoping,
			sum(m.issues_created)  as issues_created,
			sum(am.issue_count)    as MO_Issues,
			sum(ar.issue_count)    as RA_Issues,
			sum(ac.issue_count)    as CM1_Issues,
			sum(au.issue_count)    as UAT_Issues,
			t1.tested              as RA,
			t2.tested              as UAT,
			count(*)               as pdp_count
		FROM 
			tgt_pdp_main m ,
			tgt_pdp_area_execution am,
			tgt_pdp_area_execution ar,
			tgt_pdp_area_execution ac,
			tgt_pdp_area_execution au,
			tgt_pdp_testing t1,
			tgt_pdp_testing t2
		WHERE 
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE') and
			(m.pdp = am.pdp  and am.issue_area  = 'MARKETING OPERATIONS'      and am.test_iteration  = 1) and
			(m.pdp = ar.pdp  and ar.issue_area  = 'REVENUE ASSURANCE'         and ar.test_iteration  = 1) and
			(m.pdp = ac.pdp  and ac.issue_area  = 'CONFIGURATION MANAGEMENT'  and ac.test_iteration  = 1) and
			(m.pdp = au.pdp  and au.issue_area  = 'ENTERPRISE UAT'            and au.test_iteration  = 1) and
			(m.pdp = t1.pdp  and t1.short_desc  = 'RA') and
			(m.pdp = t2.pdp  and t2.short_desc  = 'UAT')
		GROUP BY m.pdp
		ORDER BY m.pdp";

	$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
	
	while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
		$ra_uat_data = $arr_ra_uat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
		
		$flag = trim(stripslashes($row_mis_1[8])).''.trim(stripslashes($row_mis_1[9]));
		
		$issue_logged = $ra_uat_data[$flag]['ISSUE_LOGGED'];
		$issue_logged += trim(stripslashes($row_mis_1[3]));
		$ra_uat_data[$flag]['ISSUE_LOGGED'] = $issue_logged;
		
		$pdp_count = $ra_uat_data[$flag]['PDP_COUNT'];
		$pdp_count += trim(stripslashes($row_mis_1[10]));
		$ra_uat_data[$flag]['PDP_COUNT'] = $pdp_count;
		
		if (trim(stripslashes($row_mis_1[2])) == 'IN SCOPE') {
			$issue_in_scope = $ra_uat_data[$flag]['ISSUE_IN_SCOPE'];
			$issue_in_scope += trim(stripslashes($row_mis_1[3]));
			$ra_uat_data[$flag]['ISSUE_IN_SCOPE'] = $issue_in_scope;
		} else {
			$issue_out_of_scope = $ra_uat_data[$flag]['ISSUE_OUT_OF_SCOPE'];
			$issue_out_of_scope += trim(stripslashes($row_mis_1[3]));
			$ra_uat_data[$flag]['ISSUE_OUT_OF_SCOPE'] = $issue_out_of_scope;
		}
		
		$mo_issues = $ra_uat_data[$flag]['MO_ISSUES'];
		$mo_issues += trim(stripslashes($row_mis_1[4]));
		$ra_uat_data[$flag]['MO_ISSUES'] = $mo_issues;
		
		$ra_issues = $ra_uat_data[$flag]['RA_ISSUES'];
		$ra_issues += trim(stripslashes($row_mis_1[5]));
		$ra_uat_data[$flag]['RA_ISSUES'] = $ra_issues;
		
		$cm_issues = $ra_uat_data[$flag]['CM_ISSUES'];
		$cm_issues += trim(stripslashes($row_mis_1[6]));
		$ra_uat_data[$flag]['CM_ISSUES'] = $cm_issues;
		
		$uat_issues = $ra_uat_data[$flag]['UAT_ISSUES'];
		$uat_issues += trim(stripslashes($row_mis_1[7]));
		$ra_uat_data[$flag]['UAT_ISSUES'] = $uat_issues;
		
		$arr_ra_uat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $ra_uat_data;
	}	
	
	foreach($arr_ra_uat as $key1 => $pdp_type) {
        $pdp_yy = 0;
        $pdp_yn = 0;
        $pdp_ny = 0;
        $pdp_nn = 0;	    
		foreach($pdp_type as $key2 => $pdp_cat) {
			foreach($pdp_cat as $key3 => $pdp_scoping) {
				$data = $arr_pdp_type_cat[$key1][$key2][$key3];
				foreach($pdp_scoping as $key4 => $pdp_testing) {
					if ($key4 == 'YESYES') {
						$data['C22'] = $pdp_yy + $pdp_testing['PDP_COUNT'];
						$data['C23'] = $pdp_testing['ISSUE_LOGGED'];
						$data['C24-INSCOPE'] = $pdp_testing['ISSUE_IN_SCOPE'];
						$data['C25-OUTSCOPE'] = $pdp_testing['ISSUE_OUT_OF_SCOPE'];
						$data['C26'] = $pdp_testing['MO_ISSUES'];
						$data['C27'] = $pdp_testing['RA_ISSUES'];
						$data['C28'] = $pdp_testing['CM_ISSUES'];
						$data['C29'] = $pdp_testing['UAT_ISSUES'];
					} elseif ($key4 == 'YESNO') {
						$data['C30'] = $pdp_yn + $pdp_testing['PDP_COUNT'];
						$data['C31'] = $pdp_testing['ISSUE_LOGGED'];
						$data['C32-INSCOPE'] = $pdp_testing['ISSUE_IN_SCOPE'];
						$data['C33-OUTSCOPE'] = $pdp_testing['ISSUE_OUT_OF_SCOPE'];
						$data['C34'] = $pdp_testing['MO_ISSUES'];
						$data['C35'] = $pdp_testing['RA_ISSUES'];
						$data['C36'] = $pdp_testing['CM_ISSUES'];
						$data['C37'] = $pdp_testing['UAT_ISSUES'];
					} elseif ($key4 == 'NOYES') {
						$data['C38'] = $pdp_ny + $pdp_testing['PDP_COUNT'];
						$data['C39'] = $pdp_testing['ISSUE_LOGGED'];
						$data['C40-INSCOPE'] = $pdp_testing['ISSUE_IN_SCOPE'];
						$data['C41-OUTSCOPE'] = $pdp_testing['ISSUE_OUT_OF_SCOPE'];
						$data['C42'] = $pdp_testing['MO_ISSUES'];
						$data['C43'] = $pdp_testing['RA_ISSUES'];
						$data['C44'] = $pdp_testing['CM_ISSUES'];
						$data['C45'] = $pdp_testing['UAT_ISSUES'];
					} elseif ($key4 == 'NONO') {
						$data['C46'] = $pdp_nn + $pdp_testing['PDP_COUNT'];
						$data['C47'] = $pdp_testing['ISSUE_LOGGED'];
						$data['C48-INSCOPE'] = $pdp_testing['ISSUE_IN_SCOPE'];
						$data['C49-OUTSCOPE'] = $pdp_testing['ISSUE_OUT_OF_SCOPE'];
						$data['C50'] = $pdp_testing['MO_ISSUES'];
						$data['C51'] = $pdp_testing['RA_ISSUES'];
						$data['C52'] = $pdp_testing['CM_ISSUES'];
						$data['C53'] = $pdp_testing['UAT_ISSUES'];
					}
				}
				$arr_pdp_type_cat[$key1][$key2][$key3] = $data;	
			}
		}
	}
	
	for ($i=1;$i<6;$i++) {
		switch ($i) {
			case 1:
				$issue_area = 'MARKETING OPERATIONS';
			break;	
			case 2:
				$issue_area = 'REVENUE ASSURANCE';
			break;	
			case 3:
				$issue_area = 'CONFIGURATION MANAGEMENT';
			break;	
			case 4:
				$issue_area = 'X';
			break;
			case 5:
				$issue_area = 'ENTERPRISE UAT';
			break;
			default:
				$issue_area = 'X';
			break;		
		}

		$query_mis_1 = "
			SELECT 
				m.pdp_type             as pdp_type,
				m.pdp_category         as pdp_category,
				m.scoping              as scoping,
				sum(t1.found_issues)   as issues_created,
				SUM(CASE t1.issue_type WHEN 'PO PDP DOCUMENT UPDATE' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_1,
				SUM(CASE t1.issue_type WHEN 'BUILD' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_2,
				SUM(CASE t1.issue_type WHEN 'KEYING' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_3,
				SUM(CASE t1.issue_type WHEN 'TESTING' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_4,
				SUM(CASE t1.issue_type WHEN 'OTHER' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_5,
				SUM(CASE t1.issue_type WHEN 'ENVIRONMENT ERROR' THEN IFNULL(t1.found_issues,0) ELSE 0 END) AS root_cause_count_6
			FROM 
				".$name.".tgt_pdp_main m,
				".$name.".tgt_pdp_issue_area_summary t1
			where 
				m.pdp_launch >= '$xldate' and
				m.pdp_launch <= '$xldate2' and
				m.scoping in ('IN SCOPE','OUT OF SCOPE') and
				(m.pdp = t1.pdp and t1.issue_area = '$issue_area' and t1.issue_class = 'ROT')
			GROUP BY m.pdp_type,m.pdp_category,m.scoping
			ORDER BY m.pdp_type,m.pdp_category,m.scoping";
	
		$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
		
		while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
			$data = $arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
			
			if ($i == 1) {
				$data['C54'] = trim(stripslashes($row_mis_1[3]));
				$data['C55'] = trim(stripslashes($row_mis_1[4]));
				$data['C56'] = trim(stripslashes($row_mis_1[5]));
				$data['C57'] = trim(stripslashes($row_mis_1[6]));
				$data['C58'] = trim(stripslashes($row_mis_1[7]));
				$data['C59'] = trim(stripslashes($row_mis_1[8]));
				$data['C60'] = trim(stripslashes($row_mis_1[9]));
			} elseif ($i == 2) {
				$data['C61'] = trim(stripslashes($row_mis_1[3]));
				$data['C62'] = trim(stripslashes($row_mis_1[4]));
				$data['C63'] = trim(stripslashes($row_mis_1[5]));
				$data['C64'] = trim(stripslashes($row_mis_1[6]));
				$data['C65'] = trim(stripslashes($row_mis_1[7]));
				$data['C66'] = trim(stripslashes($row_mis_1[8]));
				$data['C67'] = trim(stripslashes($row_mis_1[9]));
			} elseif ($i == 3) {
				$data['C68'] = trim(stripslashes($row_mis_1[3]));
				$data['C69'] = trim(stripslashes($row_mis_1[4]));
				$data['C70'] = trim(stripslashes($row_mis_1[5]));
				$data['C71'] = trim(stripslashes($row_mis_1[6]));
				$data['C72'] = trim(stripslashes($row_mis_1[7]));
				$data['C73'] = trim(stripslashes($row_mis_1[8]));
				$data['C74'] = trim(stripslashes($row_mis_1[9]));
			} elseif ($i == 4) {	
				$data['C75'] = trim(stripslashes($row_mis_1[3]));
				$data['C76'] = trim(stripslashes($row_mis_1[4]));
				$data['C77'] = trim(stripslashes($row_mis_1[5]));
				$data['C78'] = trim(stripslashes($row_mis_1[6]));
				$data['C79'] = trim(stripslashes($row_mis_1[7]));
				$data['C80'] = trim(stripslashes($row_mis_1[8]));
				$data['C81'] = trim(stripslashes($row_mis_1[9]));
			} elseif ($i == 5) {	
				$data['C82'] = trim(stripslashes($row_mis_1[3]));
				$data['C83'] = trim(stripslashes($row_mis_1[4]));
				$data['C84'] = trim(stripslashes($row_mis_1[5]));
				$data['C85'] = trim(stripslashes($row_mis_1[6]));
				$data['C86'] = trim(stripslashes($row_mis_1[7]));
				$data['C87'] = trim(stripslashes($row_mis_1[8]));
				$data['C88'] = trim(stripslashes($row_mis_1[9]));
			}
			
			$arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $data;
		}
	}
	
	$query_mis_1 = "
		SELECT 
			m.pdp_type             as pdp_type,
			m.pdp_category         as pdp_category,
			m.scoping              as scoping,
			count(*)               as pdp_count,
			sum(am.baseline_hours) as MO_Base_Hrs,
			sum(am.rework_hours)   as MO_Rework_Hrs,
			sum(ar.baseline_hours) as RA_Base_Hrs,
			sum(ar.rework_hours)   as RA_Rework_Hrs,
			sum(ac.baseline_hours) as CM_Base_Hrs,
			sum(ac.rework_hours)   as CM_Rework_Hrs,
			sum(au.baseline_hours) as UAT_Base_Hrs,
			sum(au.rework_hours)   as UAT_Rework_Hrs
		FROM 
			".$name.".tgt_pdp_main m ,
			".$name.".tgt_pdp_area_work_effort am,
			".$name.".tgt_pdp_area_work_effort ar,
			".$name.".tgt_pdp_area_work_effort ac,
			".$name.".tgt_pdp_area_work_effort au
		WHERE 
			m.pdp_launch >= '$xldate' and
			m.pdp_launch <= '$xldate2' and
			m.scoping in ('IN SCOPE','OUT OF SCOPE') and
			(m.pdp = am.pdp  and am.issue_area = 'MARKETING OPERATIONS'    ) and
			(m.pdp = ar.pdp  and ar.issue_area = 'REVENUE ASSURANCE'       ) and
			(m.pdp = ac.pdp  and ac.issue_area = 'CONFIGURATION MANAGEMENT') and
			(m.pdp = au.pdp  and au.issue_area = 'ENTERPRISE UAT'          )
		GROUP BY m.pdp_type,m.pdp_category,m.scoping
		ORDER BY m.pdp_type,m.pdp_category,m.scoping";

	$data_mis_1  = mysql_query($query_mis_1, $mysql_link) or die ("#query_mis_1 Could not query: ".mysql_error()); 
	
	while($row_mis_1 = mysql_fetch_row($data_mis_1)) {
		$data = $arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))];
		$data['C89'] = '&nbsp;';
		$data['C90'] = trim(stripslashes($row_mis_1[4]));
		$data['C91'] = trim(stripslashes($row_mis_1[5]));
		$data['C92'] = trim(stripslashes($row_mis_1[6]));
		$data['C93'] = trim(stripslashes($row_mis_1[7]));
		$data['C94'] = trim(stripslashes($row_mis_1[8]));
		$data['C95'] = trim(stripslashes($row_mis_1[9]));
		$data['C96'] = trim(stripslashes($row_mis_1[10]));
		$data['C97'] = trim(stripslashes($row_mis_1[11]));
		
		$arr_pdp_type_cat[trim(stripslashes($row_mis_1[0]))][trim(stripslashes($row_mis_1[1]))][trim(stripslashes($row_mis_1[2]))] = $data;
	}
	
	print("<table width=\"2850px;\" cellspacing=\"0\" cellpadding=\"0\" class=\"with-border\">");
	
	//foreach($arr_pdp_type_cat as $key1 => $pdp_type) {
	//	foreach($pdp_type as $key2 => $pdp_cat) {
	//		foreach($pdp_cat as $key3 => $pdp_scoping) {
	//			print("<tr>");
	//				print("<td class=\"\">PDP TYPE</td>");
	//				print("<td class=\"\">PDP CATEGORY</td>");
	//				print("<td class=\"\">SCOPING</td>");
	//			foreach($pdp_scoping as $key => $val) {
	//				print("<td class=\"\">$key</td>");
	//			}
	//			print("</tr>");
	//			break 3;
	//		}
	//	}
	//}

	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"68\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"35\" align=\"center\" width=\"\">1.PO PDP DOCUMENT UPDATE<br>2.BUILD<br>3.KEYING<br>4.TESTING<br>5.OTHER<br>6.ENVIRONMENT ERROR</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"10\" align=\"center\" width=\"\">&nbsp;</td>");
	print("</tr>");
	
	
	print("<tr>");
	print("<th align=\"center\" width=\"130px\">PDP TYPE</th>");
	print("<th align=\"center\" width=\"580px\">PDP CATEGORY</th>");
	print("<th align=\"center\" width=\"120px\">SCOPING</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"3\" align=\"center\" width=\"\">PDP COUNT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"12\" align=\"center\" width=\"\">ISSUE COUNT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"10\" align=\"center\" width=\"\">BACK TO BUILD</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"35\" align=\"center\" width=\"\">RA AND UAT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"35\" align=\"center\" width=\"\">ROOT CAUSE BY DEPARTMENT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"11\" align=\"center\" width=\"\">PDP TYPE - WORK EFFORT</th>");
	print("</tr>");

	print("<tr>");
	print("<td align=\"center\">&nbsp;</td>");
	print("<td align=\"center\">&nbsp;</td>");	
	print("<td align=\"center\">&nbsp;</td>");
	print("<td align=\"center\">&nbsp;</td>");
    print("<td align=\"center\">1</td>");
    print("<td align=\"center\">2</td>");
    print("<td align=\"center\">3</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">4</td>");
    print("<td align=\"center\">5</td>");
    print("<td align=\"center\">6</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">7</td>");
    print("<td align=\"center\">8</td>");
    print("<td align=\"center\">9</td>");
    print("<td align=\"center\">10</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">11</td>");
    print("<td align=\"center\">12</td>");
    print("<td align=\"center\">13</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">14</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">15</td>");
    print("<td align=\"center\">16</td>");
    print("<td align=\"center\">17</td>");
    print("<td align=\"center\">18</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">19</td>");
    print("<td align=\"center\">20</td>");
    print("<td align=\"center\">21</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">22</td>");
    print("<td align=\"center\">23</td>");
    print("<td align=\"center\">24</td>");
    print("<td align=\"center\">25</td>");
    print("<td align=\"center\">26</td>");
    print("<td align=\"center\">27</td>");
    print("<td align=\"center\">28</td>");
    print("<td align=\"center\">29</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">30</td>");
    print("<td align=\"center\">31</td>");
    print("<td align=\"center\">32</td>");
    print("<td align=\"center\">33</td>");
    print("<td align=\"center\">34</td>");
    print("<td align=\"center\">35</td>");
    print("<td align=\"center\">36</td>");
    print("<td align=\"center\">37</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">38</td>");
    print("<td align=\"center\">39</td>");
    print("<td align=\"center\">40</td>");
    print("<td align=\"center\">41</td>");
    print("<td align=\"center\">42</td>");
    print("<td align=\"center\">43</td>");
    print("<td align=\"center\">44</td>");
    print("<td align=\"center\">45</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">46</td>");
    print("<td align=\"center\">47</td>");
    print("<td align=\"center\">48</td>");
    print("<td align=\"center\">49</td>");
    print("<td align=\"center\">50</td>");
    print("<td align=\"center\">51</td>");
    print("<td align=\"center\">52</td>");
    print("<td align=\"center\">53</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">54</td>");
    print("<td align=\"center\">55</td>");
    print("<td align=\"center\">56</td>");
    print("<td align=\"center\">57</td>");
    print("<td align=\"center\">58</td>");
    print("<td align=\"center\">59</td>");
    print("<td align=\"center\">60</td>");
    print("<td align=\"center\">61</td>");
    print("<td align=\"center\">62</td>");
    print("<td align=\"center\">63</td>");
    print("<td align=\"center\">64</td>");
    print("<td align=\"center\">65</td>");
    print("<td align=\"center\">66</td>");
    print("<td align=\"center\">67</td>");
    print("<td align=\"center\">68</td>");
    print("<td align=\"center\">69</td>");
    print("<td align=\"center\">70</td>");
    print("<td align=\"center\">71</td>");
    print("<td align=\"center\">72</td>");
    print("<td align=\"center\">73</td>");
    print("<td align=\"center\">74</td>");
    print("<td align=\"center\">75</td>");
    print("<td align=\"center\">76</td>");
    print("<td align=\"center\">77</td>");
    print("<td align=\"center\">78</td>");
    print("<td align=\"center\">79</td>");
    print("<td align=\"center\">80</td>");
    print("<td align=\"center\">81</td>");
    print("<td align=\"center\">82</td>");
    print("<td align=\"center\">83</td>");
    print("<td align=\"center\">84</td>");
    print("<td align=\"center\">85</td>");
    print("<td align=\"center\">86</td>");
    print("<td align=\"center\">87</td>");
    print("<td align=\"center\">88</td>");
	print("<td align=\"center\">&nbsp;</td>");	
    print("<td align=\"center\">89</td>");
    print("<td align=\"center\">90</td>");
    print("<td align=\"center\">91</td>");
    print("<td align=\"center\">92</td>");
    print("<td align=\"center\">93</td>");
    print("<td align=\"center\">94</td>");
    print("<td align=\"center\">95</td>");
    print("<td align=\"center\">96</td>");
    print("<td align=\"center\">97</td>");
	print("</tr>");
	
	
	
	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"4\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"3\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"3\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"3\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"3\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=YES,UAT=YES</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=YES,UAT=NO</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=NO,UAT=YES</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=NO,UAT=NO</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\" align=\"center\" width=\"\">&nbsp;</td>");	
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">UAT</td>");
	print("</tr>");
	
	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"32\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;R</td>");
	print("</tr>");

	
	
	print("</tr>");
	print("<tr>");
	print("<td colspan=\"113\" class=\"empty\" align=\"center\" width=\"\">&nbsp;</td>");
	print("</tr>");
	
	$net_total = $columns_int;
	foreach($arr_pdp_type_cat as $key1 => $pdp_type) {
		$gross_total = $columns_int;
		foreach($pdp_type as $key2 => $pdp_cat) {
			foreach($pdp_cat as $key3 => $pdp_scoping) {
				print("<tr>");
					print("<td class=\"normal\" align=\"center\" width=\"130px\">$key1</td>");
					print("<td class=\"normal\" width=\"580px\">$key2</td>");
					if (preg_match("/\in scope\b/i", $key3)) { 
						print("<td class=\"in-scope\" align=\"center\" width=\"120px\">$key3</td>");
					} elseif (preg_match("/\out of scope\b/i", $key3)) { 
						print("<td class=\"out-scope\" align=\"center\" width=\"120px\">$key3</td>");
					} else {
						print("<td align=\"center\" width=\"120px\">$key3</td>");
					}
				foreach($pdp_scoping as $key => $val) {
					$css_class = '';
					if (preg_match("/\-INSCOPE\b/i", $key)) { 
						$css_class = 'in-scope ';
					} elseif (preg_match("/\-OUTSCOPE\b/i", $key)) { 
						$css_class = 'out-scope ';
					} elseif (preg_match('/\SEP-\b/i', $key)) { 
						$css_class = 'empty ';	
					} elseif ($key == 'C1' || $key == 'C4' || $key == 'C14') {
						$css_class = 'normal ';
					} else {
						$css_class = '';
					}
					
					if ($val == 0) {
						$css_class .= ' zero-fill';
					}
					
					print("<td class=\"$css_class\" align=\"center\" width=\"10px\">$val</td>");
					
					if (preg_match('/\SEP-\b/i', $key)) { 
						$gross_total[$key] = '';
						$net_total[$key] = '';
					} else {
						$gross_total[$key] += $val;
						$net_total[$key] += $val;
					}
					
					if ($key == 'C89') {
						$gross_total[$key] = 'TIME';
						$net_total[$key] = 'TIME';
					}
				}
				print("</tr>");
			}
		}
		print("<tr>");
		print("<td colspan=\"3\" class=\"gross\" align=\"right\" width=\"\">GROSS TOTAL</td>");

		foreach($gross_total as $total) {
			if (trim($total) == '') {
				print("<td align=\"center\" class=\"empty\">&nbsp;</td>");
			} elseif (trim($total) == 'TIME') {
				print("<td align=\"center\" class=\"normal\">$total</td>");	
			} else {
				print("<td align=\"center\" class=\"gross\">$total</td>");
			}
		}
		print("</tr>");
		print("<tr>");
		print("<td colspan=\"113\" class=\"empty\" align=\"center\" width=\"\">&nbsp;</td>");
		print("</tr>");
	}
	
	print("<tr>");
	print("<td colspan=\"3\" class=\"net\" align=\"right\" width=\"\">NET TOTAL</td>");
	foreach($net_total as $total) {
		if (trim($total) == '') {
			print("<td align=\"center\" class=\"empty\">&nbsp;</td>");
		} elseif (trim($total) == 'TIME') {
			print("<td align=\"center\" class=\"normal\">$total</td>");	
		} else {
			print("<td align=\"center\" class=\"net\">$total</td>");
		}
	}
	print("</tr>");

	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"32\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;P</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;I</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">1</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">2</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">3</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">4</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">5</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">6</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\"  align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F5ECCE\"                align=\"center\" width=\"\">&#931;R</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;B</td>");
	print("<td bgcolor=\"#F2F5A9\"                align=\"center\" width=\"\">&#931;R</td>");
	print("</tr>");

	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"4\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"3\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"3\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"3\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">&#931;</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\"               align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"3\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"1\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=YES,UAT=YES</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=YES,UAT=NO</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=NO,UAT=YES</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"8\" align=\"center\" width=\"\">RA=NO,UAT=NO</td>");
	print("<td bgcolor=\"#FFFFFF\"               align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">CM1</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">CM2</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"7\" align=\"center\" width=\"\">UAT</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"2\" align=\"center\" width=\"\">&nbsp;</td>");	
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">MO</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">RA</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">CM</td>");
	print("<td bgcolor=\"#E0F8E0\" colspan=\"2\" align=\"center\" width=\"\">UAT</td>");
	print("</tr>");
	
	print("<tr>");
	print("<th align=\"center\" width=\"130px\">PDP TYPE</th>");
	print("<th align=\"center\" width=\"580px\">PDP CATEGORY</th>");
	print("<th align=\"center\" width=\"120px\">SCOPING</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"3\" align=\"center\" width=\"\">PDP COUNT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"12\" align=\"center\" width=\"\">ISSUE COUNT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"10\" align=\"center\" width=\"\">BACK TO BUILD</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"35\" align=\"center\" width=\"\">RA AND UAT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"35\" align=\"center\" width=\"\">ROOT CAUSE BY DEPARTMENT</th>");
	print("<th class=\"empty\" align=\"center\" width=\"\">&nbsp;</th>");
	print("<th colspan=\"11\" align=\"center\" width=\"\">PDP TYPE - WORK EFFORT</th>");
	print("</tr>");
	
	print("<tr>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"68\" align=\"center\" width=\"\">&nbsp;</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"35\" align=\"center\" width=\"\">1.PO PDP DOCUMENT UPDATE<br>2.BUILD<br>3.KEYING<br>4.TESTING<br>5.OTHER<br>6.ENVIRONMENT ERROR</td>");
	print("<td bgcolor=\"#FFFFFF\" colspan=\"10\" align=\"center\" width=\"\">&nbsp;</td>");
	print("</tr>");
	
	print("</table>");
	
   
   $xfilters = "LAUNCH DATE BETWEEN ".$xldate." AND ".$xldate2;
   $xreport_name = "SNAPSHOT"; 
   //var_dump($xreport_contents); 
   $query99      = " INSERT into ".$name.".saved_reports(report_name,filters,etl_id,ran_by) 
                     VALUES('$xreport_name','$xfilters','$yetl_id','$usr')"; 
   //print($query99."<br>");
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
// faridi-1

// ================================================================================================================
// ================================================================================================================
if ($found == 0) {
    if ($start <> 1){
        print($hstart);
    }
    $query1      = " select max(etl_id)
                       from ".$name.".etl_batches ";  
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("#1s Could not query: ".mysql_error());
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
    $mysql_datat = mysql_query($queryt, $mysql_link) or die ("#2s Could not query: ".mysql_error());
    $rowcntt = mysql_num_rows($mysql_datat); 
    $prdcnt = 0;
    while($rowt = mysql_fetch_row($mysql_datat)) {
          $prdcnt            = $prdcnt + 1;
          $pdp_prd           = stripslashes($rowt[0]);
          $xpdp_prd[$prdcnt] = $pdp_prd;
    }
    $captn = "Select Criteria";
    print("<form method=\"post\" action=\"./snapshot.php\">
           <table border='0' scroll=\"yes\">
            <caption>$captn</caption>
    ");        
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

   print("<form method=\"post\" action=\"./snapshot.php\"> 
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
                where rtrim(report_name) = 'SNAPSHOT'
                  and ran_by = '$usr'
             order by filters,report_timestamp desc"; 
             //and etl_id = '$yetl_id'  
   $mysql_data = mysql_query($query, $mysql_link) or die ("#3s Could not query: ".mysql_error());
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
    $mysql_data0 = mysql_query($query0, $mysql_link) or die ("#4s Could not query: ".mysql_error());
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
print("  </body>
       </html>
");
mysql_close($mysql_link);
?>
