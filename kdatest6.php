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
// ==============================

// setting up today's date
$yw        = date("D");
$yd        = date("d");
$ym        = date("m");
$yy        = date("Y");
$yentry_dt = mktime(0,0,0,$ym,$yd,$yy);
$ym        = date("M");
$ydate     = $yw." ".$yd."-".$ym."-".$yy;

//Start of HTML
//================================================================================================================
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
// Start
if ($start == 1) {
// =========================================================================================

   $captn = "PDP Summary Report";
   print("     <table border='1' scroll=\"yes\" style=\"width: 300%; border-style:solid; border-color:#CCCCCC;\" >
                    <caption >$captn</caption>
   ");
   
   $cnd1 = 0;
   $cnd2 = 0;
   
   if ($prd == "ALL") {
       $cnd1 = 1; 
   } else {
       $cnd1 = 2;
   }

   if ($ra_ind == "BOTH") {
       $cnd2 = 1; 
   } else {
       $cnd2 = 2;
   }
   
   if ($pdpcat == "ALL") {
       $cnd3 = 1; 
   } else {
       $cnd3 = 2;
   }      
    
   // ==================================================
   // Select from cube1_main
   // ==================================================
   $selectx     = "select a.etl_id,a.row_type,a.pdp,a.pdp_desc,a.pdp_owner,a.pdp_type,a.pdp_status,a.pdp_launch,
                          a.parent_pdp,a.main_pdp,a.issues_created,a.pdp_category,a.scoping,a.complexity_factor,
                          a.revenue_factor,a.customer_factor,a.past_factor,a.testing_start_date,a.testing_end_date,
                          a.bills_run,a.invoices_generated,a.ppw_changes,a.launch_in_jeopardy,a.baseline_hours,
                          a.rework_hours,a.percentage_rework ";
   $orderbyx    = " order by a.pdp ";
   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 1)) {
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.etl_id = b.etl_id
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;               
   } 
   
   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.pdp_type = '$prd' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }      

   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.pdp_category = '$pdpcat' ";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id' 
                       and a.etl_id = b.etl_id
                       and a.pdp_category = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }

   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and a.pdp_category = '$pdpcat'";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;                
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd' 
                       and a.etl_id = b.etl_id
                       and a.pdp    = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex  = " where a.etl_id = '$yetl_id'
                       and a.pdp_type = '$prd'
                       and a.etl_id = b.etl_id
                       and a.pdp_category = '$pdpcat'
                       and a.pdp = b.pdp
                       and b.short_desc = 'RA'
                       and b.tested = ucase('$ra_ind')";
        $queryx  = $selectx.$fromx.$wherex.$orderbyx;
   }
   //print("$queryx");
                 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx     = mysql_num_rows($mysql_datax);

   // $rowcntx is no. of pdps found
   $seq1 = 1;
   $seq  = 0;
   if ($rowcntx > 0) {
       $found  = 1;
       $tbrun    = 0;
       $tinvc    = 0;
       $tppw     = 0;
       $tbase    = (float)0;
       $trwrk    = (float)0;
       //$tprwk    = (float)0;
       $tisue    = 0;
       $toccurance = array();
       $toccurance[1]  = 0;
       $toccurance[2]  = 0;
       $toccurance[3]  = 0;       
       $toccurance[4]  = 0;
       $toccurance[5]  = 0;
       $toccurance[6]  = 0;
       $toccurance[7]  = 0;
       $toccurance[8]  = 0;
       $toccurance[9]  = 0;       
       $toccurance[10] = 0;
       $toccurance[11] = 0;
       $toccurance[12] = 0;
       $aoccurance     = 0;       
       //*** 
       while($rowttl = mysql_fetch_row($mysql_datax)) {
	         $xetl_id             = stripslashes($rowttl[0]);
	         //$xrow_type           = stripslashes($rowttl[1]);
	         $xpdp                = stripslashes($rowttl[2]);
	         //$xpdp_desc           = stripslashes($rowx[3]);
	         //$xpdp_owner          = stripslashes($rowx[4]);
	         //$xpdp_type           = stripslashes($rowx[5]);
	         //$xpdp_status         = stripslashes($rowx[6]);
	         //$xpdp_launch         = substr(stripslashes($rowx[7]),0,-9);
	         //$xparent_pdp         = stripslashes($rowx[8]);
	         //$xmain_pdp           = stripslashes($rowx[9]);
	         $xissues_created     = stripslashes($rowttl[10]);
	         //$xpdp_category       = stripslashes($rowx[11]);
	         //$xscoping            = stripslashes($rowx[12]);
	         //$xcomplexity_factor  = stripslashes($rowx[13]);
	         //$xrevenue_factor     = stripslashes($rowx[14]);
	         //$xcustomer_factor    = stripslashes($rowx[15]);
	         //$xpast_factor        = stripslashes($rowx[16]);
	         //$xtesting_start_date = substr(stripslashes($rowx[17]),0,-9);
	         //$xtesting_end_date   = substr(stripslashes($rowx[18]),0,-9);
	         $xbills_run          = stripslashes($rowttl[19]);
	         $xinvoices_generated = stripslashes($rowttl[20]);
	         $xppw_changes        = stripslashes($rowttl[21]);
	         //$xlaunch_in_jeopardy = stripslashes($rowx[22]);
	         $xbaseline_hours     = (float)stripslashes($rowttl[23]);
	         $xrework_hours       = (float)stripslashes($rowttl[24]);
	         $xpercentage_rework  = (float)stripslashes($rowttl[25]);
             $tbrun    = $tbrun + $xbills_run;
             $tinvc    = $tinvc + $xinvoices_generated;
             $tppw     = $tppw  + $xppw_changes;
             $tbase    = $tbase + $xbaseline_hours;
             $trwrk    = $trwrk + $xrework_hours;
             $tisue    = $tisue + $xissues_created;
             $yroot[1]  = "A-PO PPW UPDATE";
             $yroot[2]  = "B-TEST DATA (COPY BAN)";
             $yroot[3]  = "C-BUILD ERROR";
             $yroot[4]  = "D-BUILD VALIDATION";
             $yroot[5]  = "E-KEYING";
             $yroot[6]  = "F-TEST ENVIRONMENT";
             $yroot[7]  = "G-TEST ERROR";
             $yroot[8]  = "H-TEST SCENARIO (RA)";
             $yroot[9]  = "I-TEST SCENARIO (UAT)";
             $yroot[10] = "J-INVOICE VALIDATION (RA)";
             $yroot[11] = "K-INVOICE VALIDATION (UAT)";
             $yroot[12] = "L-OTHER";
             // ==================================================
             // Select from cube1_b for detail records
             // ==================================================
             for ($r=1;$r<=12 ; ++$r) {
                  $xroot          = $yroot[$r];
                  $queryttl2      = "select occurance 
                                       from ".$name.".cube1_b 
                                      where pdp        = '$xpdp' 
                                        and etl_id     = '$xetl_id'
                                        and issue_type = '$xroot'"; 
                  $mysql_datattl2 = mysql_query($queryttl2, $mysql_link) or die ("Could not query: ".mysql_error());
                  $rowcntttl2     = mysql_num_rows($mysql_datattl2);
                  if ($rowcntttl2 == 1) {
                      while($rowttl2 = mysql_fetch_row($mysql_datattl2)) {
                            $yoccurance_x[$r] = stripslashes($rowttl2[0]);
                            $toccurance[$r] = $toccurance[$r] + $yoccurance_x[$r];
                            $aoccurance     = $aoccurance + $yoccurance_x[$r];
                      }
                  }
             }  
       }
      
   if ($seq1 == 1) {
       //========================================================
       //======== Table Headers Start ===========================
       //========================================================
       print("
              <tr>
               <td bgcolor=\"#CCCCCC\" colspan=\"12\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 PDP Information
                </font>
               </td>
               <td bgcolor=\"#CCCCCC\" colspan=\"6\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 Scoping
                </font>
               </td>
               <td bgcolor=\"#CCCCCC\" colspan=\"9\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 Testing Execution
                </font>
               </td>
               <td bgcolor=\"#CCCCCC\" colspan=\"12\" align=\"center\" valign=\"middle\">
                <font color=\"#330099\">
                 Root Causes
                </font>
               </td>
              </tr>
       ");
       print("
                     <tr>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        No.
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        PDP No.
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                       <font color=\"#330099\">
                        Description
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Owner
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Type
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Status
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Launch (YYYY-MM-DD)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Parent PDP
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Main PDP
                       </font>
                      </td>                      
       ");
       // ==================================================
       // Select Headers for cube1_a
       // ==================================================
       $ydept[1] = "RA";
       $ydept[2] = "UAT";
       print("
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Revenue Assurance Testing
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Enterprise UAT Testing
                       </font>
                      </td>                      
       ");

       print("
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Issue Created
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:150px;\">
                       <font color=\"#330099\">
                        PDP Category
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Scoping
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Complexity
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Revenue Impact
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Customer Impact
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Past Impact
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Execution Start Date (YYYY-MM-DD)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Execution End Date (YYYY-MM-DD)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Bill Runs
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Invoice Generated
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        PPW Changes
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Launch in Jeopardy
                     </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Baseline Work (Hours)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Rework (Hours)
                       </font>
                      </td>                      
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        Percentage Rework
                       </font>
                      </td>
       ");
       // ==================================================
       // Select Headers for cube1_b
       // ==================================================       
       //$yroot[1]  = "A-PO PPW UPDATE";
       //$yroot[2]  = "B-TEST DATA (COPY BAN)";
       //$yroot[3]  = "C-BUILD ERROR";
       //$yroot[4]  = "D-BUILD VALIDATION";
       //$yroot[5]  = "E-KEYING";
       //$yroot[6]  = "F-TEST ENVIRONMENT";
       //$yroot[7]  = "G-TEST ERROR";
       //$yroot[8]  = "H-TEST SCENARIO (RA)";
       //$yroot[9]  = "I-TEST SCENARIO (UAT)";
       //$yroot[10] = "J-INVOICE VALIDATION (RA)";
       //$yroot[11] = "K-INVOICE VALIDATION (UAT)";
       //$yroot[12] = "L-OTHER";
       print("
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        A-PO PPW UPDATE
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        B-TEST DATA (COPY BAN)
                       </font>
                      </td>                      
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        C-BUILD ERROR
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        D-BUILD VALIDATION
                       </font>
                      </td> 
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        E-KEYING
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        F-TEST ENVIRONMENT
                       </font>
                      </td> 
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        G-TEST ERROR
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        H-TEST SCENARIO (RA)
                       </font>
                      </td>                      
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        I-TEST SCENARIO (UAT)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        J-INVOICE VALIDATION (RA)
                       </font>
                      </td> 
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        K-INVOICE VALIDATION (UAT)
                       </font>
                      </td>
                      <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        L-OTHER
                       </font>
                      </td>               
                    </tr>
       ");   
          $tprwk = (float)round(($trwrk/$tbase)*100,2);
          print("
                     <tr>
                      <td bgcolor=\"#E8E8E8\" colspan=\"11\" align=\"center\" valign=\"middle\">
                       <font color=\"#330099\">
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >                
   	                   <font color=\"#330099\"> 
                        $tisue
                       </font>               
                      </td>
                      <td bgcolor=\"#E8E8E8\" colspan=\"8\" align=\"center\" valign=\"middle\">
                       <font color=\"#330099\">
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $tbrun
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $tinvc
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $tppw 
                       </font>
                      </td>
                      <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $tbase
                       </font>
                      </td>
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $trwrk
                       </font>
                      </td>                      
                      <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
                       <font color=\"#330099\">
                        $tprwk%
                       </font>
                      </td>
            ");
            //(float)$trewk_effort = round(((float)$trewk / (float)$tbasewk) * 100,2);
            //print("
            //          <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
            //           <font color=\"#330099\">
            //            <!--$tprwk%-->
            //            $trewk_effort%
            //           </font>
            //          </td>
            //");
            for ($t=1;$t<=12 ; ++$t) {
                 print("
                    <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >                
   	                  <font color=\"#330099\"> 
                       $toccurance[$t]
                      </font>               
                     </td>
           "); 
           }            
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
   print(" </tr>
           <tr>
            <td bgcolor=\"#E8E8E8\" colspan=\"27\" align=\"center\" valign=\"middle\">
             <font color=\"#330099\">
             </font>
            </td>
         ");
   for ($t=1;$t<=12 ; ++$t) {
        if ($aoccurance == 0) {
            $poccurance = 0;
        } else {
            $poccurance[$t] = (float)round(($toccurance[$t]/$aoccurance)* 100,2);
        }
        print("
                <td bgcolor=\"#00FF00\" align=\"center\" valign=\"middle\" >                
                 <font color=\"#330099\"> 
                  $poccurance[$t]%
                 </font>               
                </td>
        ");
   }      
   print(" </tr> ");
   //======== Table Summary Ends ============================
   //========================================================
   //========================================================
   } 

   //****           

   $selectx1     = "select a.etl_id,a.row_type,a.pdp,a.pdp_desc,a.pdp_owner,a.pdp_type,a.pdp_status,a.pdp_launch,
                          a.parent_pdp,a.main_pdp,a.issues_created,a.pdp_category,a.scoping,a.complexity_factor,
                          a.revenue_factor,a.customer_factor,a.past_factor,a.testing_start_date,a.testing_end_date,
                          a.bills_run,a.invoices_generated,a.ppw_changes,a.launch_in_jeopardy,a.baseline_hours,
                          a.rework_hours,a.percentage_rework ";
   $orderbyx1    = " order by a.pdp ";
   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 1)) {
        $fromx1   = "  from ".$name.".cube1_main a ";
        $wherex1  = " where a.etl_id = '$yetl_id' ";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx1   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex1  = " where a.etl_id = '$yetl_id'
                        and a.etl_id = b.etl_id
                        and a.pdp = b.pdp
                        and b.short_desc = 'RA'
                        and b.tested = ucase('$ra_ind')";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;               
   } 
   
   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 1)) {            
        $fromx1   = "  from ".$name.".cube1_main a ";
        $wherex1  = " where a.etl_id = '$yetl_id' 
                        and a.pdp_type = '$prd' ";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;                
   }      

   if (($cnd1 == 1) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx1   = "  from ".$name.".cube1_main a ";
        $wherex1  = " where a.etl_id = '$yetl_id' 
                        and a.pdp_category = '$pdpcat' ";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;
   }

   if (($cnd1 == 1) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx1   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex1  = " where a.etl_id = '$yetl_id' 
                        and a.etl_id = b.etl_id
                        and a.pdp_category = '$pdpcat'
                        and a.pdp = b.pdp
                        and b.short_desc = 'RA'
                        and b.tested = ucase('$ra_ind')";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;
   }

   if (($cnd1 == 2) && ($cnd2 == 1) && ($cnd3 == 2)) {            
        $fromx1   = "  from ".$name.".cube1_main a";
        $wherex1  = " where a.etl_id = '$yetl_id'
                        and a.pdp_type = '$prd' 
                        and a.pdp_category = '$pdpcat'";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;                
   }

   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 1)) {            
        $fromx1   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex1  = " where a.etl_id = '$yetl_id'
                        and a.pdp_type = '$prd' 
                        and a.etl_id = b.etl_id
                        and a.pdp    = b.pdp
                        and b.short_desc = 'RA'
                        and b.tested = ucase('$ra_ind')";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;
   }
   
   if (($cnd1 == 2) && ($cnd2 == 2) && ($cnd3 == 2)) {            
        $fromx1   = "  from ".$name.".cube1_main a, ".$name.".cube1_a b ";
        $wherex1  = " where a.etl_id = '$yetl_id'
                        and a.pdp_type = '$prd'
                        and a.etl_id = b.etl_id
                        and a.pdp_category = '$pdpcat'
                        and a.pdp = b.pdp
                        and b.short_desc = 'RA'
                        and b.tested = ucase('$ra_ind')";
        $queryx1  = $selectx1.$fromx1.$wherex1.$orderbyx1;
   }   
   
   $mysql_datax1 = mysql_query($queryx1, $mysql_link) or die ("Could not query: ".mysql_error());
   $rowcntx1     = mysql_num_rows($mysql_datax1);

       while($rowx = mysql_fetch_row($mysql_datax1)) {
             $seq                 = $seq + 1;
             $seq1                = 2;
	         //$xid               = stripslashes($rowx[0]);
	         $xetl_id             = stripslashes($rowx[0]);
	         $xrow_type           = stripslashes($rowx[1]);
	         $xpdp                = stripslashes($rowx[2]);
	         $xpdp_desc           = stripslashes($rowx[3]);
	         $xpdp_owner          = stripslashes($rowx[4]);
	         $xpdp_type           = stripslashes($rowx[5]);
	         $xpdp_status         = stripslashes($rowx[6]);
	         $xpdp_launch         = substr(stripslashes($rowx[7]),0,-9);
	         $xparent_pdp         = stripslashes($rowx[8]);
	         $xmain_pdp           = stripslashes($rowx[9]);
	         $xissues_created     = stripslashes($rowx[10]);
	         $xpdp_category       = stripslashes($rowx[11]);
	         $xscoping            = stripslashes($rowx[12]);
	         $xcomplexity_factor  = stripslashes($rowx[13]);
	         $xrevenue_factor     = stripslashes($rowx[14]);
	         $xcustomer_factor    = stripslashes($rowx[15]);
	         $xpast_factor        = stripslashes($rowx[16]);
	         $xtesting_start_date = substr(stripslashes($rowx[17]),0,-9);
	         $xtesting_end_date   = substr(stripslashes($rowx[18]),0,-9);
	         $xbills_run          = stripslashes($rowx[19]);
	         $xinvoices_generated = stripslashes($rowx[20]);
	         $xppw_changes        = stripslashes($rowx[21]);
	         $xlaunch_in_jeopardy = stripslashes($rowx[22]);
	         $xbaseline_hours     = (float)stripslashes($rowx[23]);
	         $xrework_hours       = (float)stripslashes($rowx[24]);
	         $xpercentage_rework  = (float)stripslashes($rowx[25]);
             $tbrun    = 0;
             $tinvc    = 0;
             $tppw     = 0;
             $tbase    = 0;
             $trwrk    = 0;
             $tisue    = 0;
             if (empty($xscoping)){
                 $xscoping = "&nbsp";    
             }
             if (empty($xcomplexity_factor)){
                 $xcomplexity_factor = "&nbsp";    
             }
             if (empty($xrevenue_factor )){
                 $xrevenue_factor  = "&nbsp";    
             } 
             if (empty($xcustomer_factor)){
                 $xcustomer_factor = "&nbsp";    
             }
             if (empty($xpast_factor)){
                 $xpast_factor = "&nbsp";    
             }                                       
             //$tbrun    = $tbrun + $xbills_run;
             //$tinvc    = $tinvc + $xinvoices_generated;
             //$tppw     = $tppw  + $xppw_changes;
             //$tbase    = $tbase + $xbaseline_hours;
             //$trwrk    = $trwrk + $xrework_hours;
             //$tisue    = $tisue + $xissues_created;
	         

       //if ($seq == 1) { 
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
       //        <td bgcolor=\"#CCCCCC\" colspan=\"12\" align=\"center\" valign=\"middle\">
       //         <font color=\"#330099\">
       //          Root Causes
       //         </font>
       //        </td>
       //       </tr>
       // ");
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
       //                 Launch (YYYY-MM-DD)
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
       // ==================================================
       // Select Headers for cube1_a
       // ==================================================
       //$ydept[1] = "RA";
       //$ydept[2] = "UAT";
       //print("
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Revenue Assurance Testing
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Enterprise UAT Testing
       //                </font>
       //               </td>                      
       //");

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
       //              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
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
       //              <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Execution Start Date (YYYY-MM-DD)
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 Execution End Date (YYYY-MM-DD)
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
       //              </td>
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
       // ==================================================
       // Select Headers for cube1_b
       // ==================================================       
       //$yroot[1]  = "A-PO PPW UPDATE";
       //$yroot[2]  = "B-TEST DATA (COPY BAN)";
       //$yroot[3]  = "C-BUILD ERROR";
       //$yroot[4]  = "D-BUILD VALIDATION";
       //$yroot[5]  = "E-KEYING";
       //$yroot[6]  = "F-TEST ENVIRONMENT";
       //$yroot[7]  = "G-TEST ERROR";
       //$yroot[8]  = "H-TEST SCENARIO (RA)";
       //$yroot[9]  = "I-TEST SCENARIO (UAT)";
       //$yroot[10] = "J-INVOICE VALIDATION (RA)";
       //$yroot[11] = "K-INVOICE VALIDATION (UAT)";
       //$yroot[12] = "L-OTHER";
       //print("
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 A-PO PPW UPDATE
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 B-TEST DATA (COPY BAN)
       //                </font>
       //               </td>                      
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 C-BUILD ERROR
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 D-BUILD VALIDATION
       //                </font>
       //               </td> 
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 E-KEYING
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 F-TEST ENVIRONMENT
       //               </font>
       //               </td> 
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 G-TEST ERROR
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 H-TEST SCENARIO (RA)
       //                </font>
       //               </td>                      
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 I-TEST SCENARIO (UAT)
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 J-INVOICE VALIDATION (RA)
       //                </font>
       //               </td> 
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 K-INVOICE VALIDATION (UAT)
       //                </font>
       //               </td>
       //               <td bgcolor=\"#99CCFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
       //                <font color=\"#330099\">
       //                 L-OTHER
       //                </font>
       //               </td>               
       //             </tr>
       //");
       //}
       //======== Table Headers End =============================
       //========================================================
       //========================================================
       
       
       
       //======== Table Details Start ===========================
       //========================================================
       //========================================================
       print("
                     <tr>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $seq
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpdp
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:200px;\">
                       <font color=\"#330099\">
                        $xpdp_desc
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpdp_owner
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpdp_type
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpdp_status
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpdp_launch
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xparent_pdp
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xmain_pdp
                       </font>
                      </td>                      
       ");
       // ==================================================
       // Select from cube1_a for detail records
       // ==================================================
       for ($d=1;$d<=2 ; ++$d) {
            $xdept        = $ydept[$d];
            $queryy2      = "select tested 
                               from ".$name.".cube1_a 
                              where pdp        = '$xpdp' 
                                and etl_id     = '$xetl_id'
                                and short_desc = '$xdept'"; 
            $mysql_datay2 = mysql_query($queryy2, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnty2     = mysql_num_rows($mysql_datay2);
            if ($rowcnty2 == 1) {
                while($rowy2 = mysql_fetch_row($mysql_datay2)) {
                      $ytested = stripslashes($rowy2[0]);
                      print("
                              <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" width=\"75px\">
                               <font color=\"#330099\">
                                $ytested
                               </font>
                              </td>
                      ");                
                }
            } else {
                      print("
                              <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" width=\"75px\">
                               <font color=\"#330099\">
                               </font>
                              </td>
                      ");            
            }
       }  
       print("
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xissues_created
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:150px;\">
                       <font color=\"#330099\">
                        $xpdp_category
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xscoping
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xcomplexity_factor
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xrevenue_factor
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xcustomer_factor
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpast_factor
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xtesting_start_date
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xtesting_end_date
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xbills_run
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xinvoices_generated
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xppw_changes
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xlaunch_in_jeopardy
                     </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xbaseline_hours
                       </font>
                      </td>
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xrework_hours
                       </font>
                      </td>                      
                      <td bgcolor=\"#FFFFFF\" align=\"center\" valign=\"middle\" style=\"word-wrap: break-word; word-break:break-all; width:75px;\">
                       <font color=\"#330099\">
                        $xpercentage_rework%
                       </font>
                      </td>
       ");
       // ==================================================
       // Select from cube1_b for detail records
       // ==================================================
       for ($r=1;$r<=12 ; ++$r) {
            $xroot        = $yroot[$r];
            $yoccurance[$r] = 0;
            $queryy3      = "select occurance 
                               from ".$name.".cube1_b 
                              where pdp        = '$xpdp' 
                                and etl_id     = '$xetl_id'
                                and issue_type = '$xroot'"; 
            $mysql_datay3 = mysql_query($queryy3, $mysql_link) or die ("Could not query: ".mysql_error());
            $rowcnty3     = mysql_num_rows($mysql_datay3);
            if ($rowcnty3 == 1) {
                while($rowy3 = mysql_fetch_row($mysql_datay3)) {
                      $yoccurance[$r] = stripslashes($rowy3[0]);
                      $toccurance[$r] = $toccurance[$r] + $yoccurance[$r];
                      $aoccurance     = $aoccurance + $yoccurance[$r];
                      print("
                              <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" width=\"75px\">
                               <font color=\"#330099\">
                                $yoccurance[$r]
                               </font>
                              </td>
                      ");                
                }
            } else {
                      print("
                              <td valign=\"middle\" bgcolor=\"#FFFFFF\" align=\"center\" width=\"75px\">
                               <font color=\"#330099\">
                               </font>
                              </td>
                      ");            
            }
       }  
       print("
              </tr> 
       ");
       //======== Table Details End =============================
       //========================================================
       //========================================================
       }  
   } else
   {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"No PDP found under this criteria, Please Try Again\")</script>";  
   }

   //======== Table Footer Starts============================
   //========================================================
   //========================================================

   //if ($rowcntx <> 0) {
   //       $tprwk = (float)round(($trwrk/$tbase)*100,2);
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
   //                   <td bgcolor=\"#E8E8E8\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                    </font>
   //                   </td>
   //                  <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tbase
   //                    </font>
   //                   </td>
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $trwrk
   //                    </font>
   //                   </td>                      
   //                   <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //                    <font color=\"#330099\">
   //                     $tprwk%
   //                    </font>
   //                   </td>
   //         ");
   //         //(float)$trewk_effort = round(((float)$trewk / (float)$tbasewk) * 100,2);
   //         //print("
   //         //          <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >
   //         //           <font color=\"#330099\">
   //         //            <!--$tprwk%-->
   //         //            $trewk_effort%
   //         //           </font>
   //         //          </td>
   //         //");
   //         for ($t=1;$t<=12 ; ++$t) {
   //              print("
   //                 <td bgcolor=\"#FFFF00\" align=\"center\" valign=\"middle\" >                
   //	                  <font color=\"#330099\"> 
   //                    $toccurance[$t]
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
   //print(" </tr>
   //        <tr>
   //         <td bgcolor=\"#E8E8E8\" colspan=\"26\" align=\"center\" valign=\"middle\">
   //          <font color=\"#330099\">
   //          </font>
   //         </td>
   //      ");
   //for ($t=1;$t<=12 ; ++$t) {
   //     $poccurance[$t] = (float)round(($toccurance[$t]/$aoccurance)* 100,2);
   //     print("
   //             <td bgcolor=\"#00FF00\" align=\"center\" valign=\"middle\" >                
   //              <font color=\"#330099\"> 
   //               $poccurance[$t]%
   //              </font>               
   //             </td>
   //     ");
   //}      
   print(" </tr>
          </table>");
   //======== Table Footer Starts============================
   //========================================================
   //========================================================
   //}       
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
    $query1      = "select max(etl_id)
                      from ".$name.".etl_monitor
                     where target_cube = 'cube_1_main'";  
    $mysql_data1 = mysql_query($query1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1     = mysql_num_rows($mysql_data1);
    //print("$query1"."<br>".$rowcnt1."<br>");
    while($row1 = mysql_fetch_row($mysql_data1)) {
	         $yetl_id = stripslashes($row1[0]);
    }

    //$ind[0]    = "ALL";
    $ind[1]    = "YES";
    $ind[2]    = "NO";
    //$ind_id[0] = 0;
    $ind_id[1] = 1;
    $ind_id[2] = 0;

    // PDP Type
    $queryt = "select distinct(pdp_type) from ".$name.".cube1_main";
    $mysql_datat = mysql_query($queryt, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcntt = mysql_num_rows($mysql_datat); 
    $prdcnt = 0;
    while($rowt = mysql_fetch_row($mysql_datat)) {
          $prdcnt            = $prdcnt + 1;
          $pdp_prd           = stripslashes($rowt[0]);
          $xpdp_prd[$prdcnt] = $pdp_prd;
    }
    print("<form method=\"post\" action=\"./kdatest6.php\">
           <table border='0' scroll=\"yes\">
            <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
              <font color=\"#330099\">Select Period:</font>
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
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
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
    $queryt1       = "select distinct(pdp_category) 
                        from ".$name.".cube1_main
                       where pdp_category <> '' ";
    $mysql_datat1  = mysql_query($queryt1, $mysql_link) or die ("Could not query: ".mysql_error());
    $rowcnt1       = mysql_num_rows($mysql_datat1); 
    $catcnt        = 0;
    while($rowt1 = mysql_fetch_row($mysql_datat1)) {
          $catcnt            = $catcnt + 1;
          $pdpcat            = stripslashes($rowt1[0]);
          $xpdpcat[$catcnt] = $pdpcat;
    }
    print(" <tr>
             <td bgcolor=\"#99CCFF\" align=\"right\" style=\"width:100px;\">
              <font color=\"#330099\">Select Category:</font>
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
             <td>
              <input type=\"submit\" name=\"submit\" value=\"OK\">
              <input type=\"hidden\" name=\"start\" value=\"1\">
              <input type=\"hidden\" name=\"yetl_id\" value=\"$yetl_id\">
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

?>
