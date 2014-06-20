<?php
// Connection
require_once("./inc/connect.php");
set_time_limit(0);


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
                    function popup2(url) 
                    {
                     var width  = 1050;
                     var height = 700;
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

		 "; 
   print($hstart);
   //print(
   //       $sqltyp."<br>".
	//	  $pdptype."<br>".
	//	  $xys."<br>".
	//	  $xye."<br>".
	//	  $xldate."<br>".
   //	  $xldate2."<br>"
   //);
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
   $queryv1       = "  set @rownum  = 0";
   $mysql_datav1  = mysql_query($queryv1, $mysql_link) or die ("#queryv1 Could not query: ".mysql_error());       
   $queryA        = "  select 'tgt_pdp_main'                    as 'DUMMY',
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
                              c.tested                          as 'RA REQUESTED TESTING',
                              1                                 as 'FILTER' 
                     ";
    if ($sqltyp == 1){
	    $captn = "PDP LIST - IN SCOPE";
	    $queryB = "  
                    FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c
                   WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye') )
                     AND a.pdp         = b.pdp AND b.short_desc  = 'UAT'
					 AND a.pdp         = c.pdp AND c.short_desc  = 'RA'
					 AND ( (b.tested = 'YES') OR (b.tested = 'NO' AND a.scoping = 'IN SCOPE') )
                     AND pdp_type     = '$pdptype' 
                     AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
                ORDER BY @rownum asc, a.issues_created desc
					 ";
    }
    if ($sqltyp == 2){
	    $captn = "PDP LIST - OUT OF SCOPE";
	    $queryB = "  
                    FROM ".$name.".tgt_pdp_main a, ".$name.".tgt_pdp_testing b, ".$name.".tgt_pdp_testing c
                   WHERE a.etl_id in (select etl_id from etl_batches where etl_year in ('$xys','$xye') )
                     AND a.pdp         = b.pdp AND b.short_desc  = 'UAT'
					 AND a.pdp         = c.pdp AND c.short_desc  = 'RA'
                     AND (b.tested    = 'NO' AND a.scoping in ('OUT OF SCOPE','NOT SET')) 
                     AND pdp_type     = '$pdptype' 
                     AND ((a.pdp_launch >= '$xldate' and a.pdp_launch <= '$xldate2') or (a.pdp_launch = '0000-00-00' and a.pdp_launch > '2010-09-01'))
                     ORDER BY @rownum asc, a.issues_created desc
					 ";
    }
//       ORDER BY @rownum asc - Added by Zubair - July 23rd 2012 from Above Query
	$querypdp = $queryA.$queryB;	
   //print($querypdp."<br>");                
   $mysql_datap  = mysql_query($querypdp, $mysql_link) or die ("#querypdp Could not query: ".mysql_error());
   $rowcount     = mysql_num_rows($mysql_datap);
   $pcol         = mysql_num_fields($mysql_datap)-1;    // subtracting field/column at [0] i.e the DUMMY field/column                      
   $tp           = 0;
   $pc3a         = 0;                                   // columns not displayed
   while($rowp  = mysql_fetch_row($mysql_datap)) {
         $tp = $tp + 1;
         if ($tp == 1){
             for ($pc=1;$pc<=$pcol;++$pc) {
                  $pdp_head[$pc] = mysql_field_name($mysql_datap,$pc);
                  if ($pc == 0 || $pc == 6 || ($pc >= 8 && $pc <= 19) || $pc == 23){
                      $pdp_head_use[$pc] = 0;
                      $pc3a = $pc3a + 1;
                  } else {
                      $pdp_head_use[$pc] = 1;
                  }
                  $pcx = $pcx + 1;
             }
         }
         for ($pc=1;$pc<=$pcol;++$pc) {
              if ($pc == 7) {
                  $pdp[$tp][$pc] = substr(trim(stripslashes($rowp[$pc])),0,10);
              } else {
                $pdp[$tp][$pc] = trim(stripslashes($rowp[$pc]));
              }
        }
   }
   //print("Last Column ".$pcol." - ".$pc3a."<br>");

   // =======
   // Headers
   $cola = $pcol - $pc3a;
   //print("<input type=\"button\" value=\"Toggle Detail Row Display\" onclick=\"toggleDisplay(document.getElementById('theTable'))\" />");
   //$captn = "PDP LIST";
   print(
          "<div id=\"Two\" class=\"cont2\">
            <div class=\"wrapper2\">
             <table id=\"theTable\" scroll=\"yes\" style=\"border-style:solid 1px; border-color:#CCCCCC; width=100%;\" >
              <caption >$captn</caption>
               <tr class=\"headerRow\">
   ");
   //////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////  
   //tgt_pdp_main
   // Open this for debugging
   //print("<tr class=\"headerRow\">");
   //for ($pc=1;$pc<=$pcol;++$pc) {
   //     if ($pdp_head_use[$pc] == 1) { 
   //         if ($pc == 3 || ($pc >= 10 && $pc <=18) || ($pc >= 20 && $pc <=22)){ 
   //             $wdth = "150px";
   //         } else {
   //             $wdth = "75px"; 
   //         }
   //         print("<th bgcolor=\"#CCCCCC\" align=\"center\" valign=\"top\" style=\"width: $wdth;\">
   //                 <font color=\"#330099\">
   //                  $pc
   //                 </font>
   //                </th>        
   //         ");
   //    }   
   //}
   //print("</tr>");
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
   print("</tr>");   
   //////////////////////////////////////////////////////////////////
   // =============
   // Details Start 
   //$rowcount = 0;
   for ($tp=1;$tp<=$rowcount;++$tp) {
        print("<tr>");
        /////////////////////////////////////////////////////////////////  
        //tgt_pdp_main
        for ($pc=1;$pc<=$pcol;++$pc) {
             if ($pdp_head_use[$pc] == 1) { 
                 if ($pc == 3 || $pc == 11){ 
                     $wdth = "150px";
                 } else {
                     $wdth = "75px"; 
                 }
                 $val = $pdp[$tp][$pc];
                 if ($pc == 2){ 
                     $bcolr = "#E8E8E8";
                     $fcolr = "#FF0000";
                 } else {
                     if ($pc == 20){
                        if ($val == 0){
                            $bcolr = "#FFFFFF";
                            $fcolr = "#330099";
                        } else {
                            $bcolr = "#CCFFCC";
                            $fcolr = "#330099";
                        }   
                     } else {
                       $bcolr = "#FFFFFF";
                       $fcolr = "#330099";
                     }
                 }
                 if ($pc == 2){
                   print("<td bgcolor=\"$bcolr\" align=\"center\" valign=\"middle\" style=\"width: $wdth;\">
                           <font color=\"$fcolr\">
                            <!--<a href=\"javascript:void(0);\" onclick=\"PopupCenter('./pdp_issue_summary.php?pdpdesc=$val', 'myPop1',1200,800);\">$val</a>-->
                             <a href=\"javascript:void(0);\" onclick=\"popup2('./pdp_issue_summary.php?pdpdesc=$val')\">
							  $val
							 </a>
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
        print("</tr>");
   }
   print("     </table>
              </div>
             </div>
            </body>
           </html>                     
   ");
print("  </body>
       </html>
");
?>
