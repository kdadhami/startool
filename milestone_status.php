<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: pdp_notes.php
// Date: September, 2011
// Notes: This program displays notes for a given pdp (for a given dept) on screen
// --------------------------------------------------------------

// Connection
require_once("./inc/connect.php");
set_time_limit(0);

// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
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
$trans = "loop";
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
$queryx = "select status_type_id,status_type,status_color_code from ".$name.".status_types where status_type_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#23 Could not query: ".mysql_error());
$rowcntx = mysql_num_rows($mysql_datax);    
$st_typ_cnt              = 1;
$st_typ_id[$st_typ_cnt]  = 0;
$st_typ[$st_typ_cnt]     = "";
$st_typ_clr[$st_typ_cnt] = "";
while($rowx = mysql_fetch_row($mysql_datax)) {
      $st_typ_cnt              = $st_typ_cnt + 1;
      $st_typ_id[$st_typ_cnt]  = stripslashes(trim($rowx[0]));
      $st_typ[$st_typ_cnt]     = stripslashes(trim($rowx[1]));      
      $st_typ_clr[$st_typ_cnt] = stripslashes(trim($rowx[2]));
}

// Loading PDP Milestones
$query31      = "   select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq 
                      from ".$name.".pdp_stlc 
                     where issue_area_id = '$uissue_area_id'
                       and milestone_ind = 1 
                  order by milestone_ind desc, milestone_seq asc";
$mysql_data31 = mysql_query($query31, $mysql_link) or die ("#24 Could not query: ".mysql_error());
$rowcnt31         = mysql_num_rows($mysql_data31);
$mil_cnt          = 0;

while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt            = $mil_cnt + 1;
      $mil_id[$mil_cnt]   = stripslashes($row31[0]);
      $mil[$mil_cnt]      = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]  = stripslashes($row31[2]);
      $mil_time[$mil_cnt] = (float)stripslashes($row31[3]);
      $mil_seq[$mil_cnt]  = (float)stripslashes($row31[4]);
}

// loading pdp_periods
$queryx = "select pdp_period_id,pdp_period from ".$name.".pdp_periods where pdp_period_ind = 1"; 
$mysql_datax = mysql_query($queryx, $mysql_link) or die ("#25 Could not query: ".mysql_error());
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
$mysql_datax2 = mysql_query($queryx2, $mysql_link) or die ("#26 Could not query: ".mysql_error());
$rowcntx2 = mysql_num_rows($mysql_datax2);    

$dept_cnt = 0;
while($rowx2 = mysql_fetch_row($mysql_datax2)) {
      $dept_cnt             = $dept_cnt + 1;
      $dept_id[$dept_cnt]   = stripslashes(trim($rowx2[0]));
      $dept[$dept_cnt]      = stripslashes(trim($rowx2[1]));
      $dept_code[$dept_cnt] = stripslashes(trim($rowx2[2])); 
}

$ind[0]    = "";
$ind[1]    = "Yes";
$ind[2]    = "No";
$ind_id[0] = 0;
$ind_id[1] = 1;
$ind_id[2] = 0;


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
                       width: 100%; height: 100%; background: #FFFFF0;
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
         <div id=\"content\">
");

// -------------------------------------
// Start of the check-01
if (isset($pdp) && ($start == 1)) {
// -------------------------------------

   $captn="PDP Status";
   // -------------------------------------------------------------------------------------
   //Update pdp
   // -------------------------------------------------------------------------------------
   $queryx = "select a.pdp_id,a.pdp_desc,a.updated_date,a.updated_by,a.pdp_name,a.pdp_owner,a.pdp_launch,
                     a.pdp_status,a.pdp_period_id,a.pdp_category_id,a.complexity_id,a.projection_id,
                     a.revenue_id,a.comparison_id 
               from ".$name.".pdp a
              where a.pdp_desc = '$pdp'"; 
   //print("$queryx"); 
   $mysql_datax = mysql_query($queryx, $mysql_link) or die ("#33 Could not query: ".mysql_error());
   $rowcntx = mysql_num_rows($mysql_datax);    
   //print("$rowcntx");

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

             if (empty($xpdp_launch)) {
                 $xpdp_launch_dt = "00-00-0000";
             } else {
                 $xpdp_launch_d  = date("d",$xpdp_launch);
                 $xpdp_launch_m  = date("M",$xpdp_launch);
                 $xpdp_launch_y  = date("y",$xpdp_launch);    
                 $xpdp_launch_dt = $xpdp_launch_d."-".$xpdp_launch_m."-".$xpdp_launch_y;
             }

			 // Wendy wants to display comments for pdp starting in September, and not from before. 1314849600 is Sep 1, 2011 
			 //1303704000   -> Wrong value
			 //1314849600   -> Correct value
			 if ($xpdp_launch >= 1303704000) {
			     $comdisplay = 1; 
			 } else {
			     $comdisplay = 0;
			 }
			 
             // start of HTML
             print("
                   <form method=\"post\" action=\"./pdp_notes.php?pdp=$pdp&&start=$start\">
                     <table border='0' align=\"center\" width=\"90%\">
                      <caption>$captn</caption>
                      <tr>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:15%;\"><font color=\"#FFFFFF\"><font color=\"#330099\">ID</font></td>
         	           <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#000000\"> 
                          <a>$xid</a>
                        </font>   
         	           </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">User</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\" style=\"width:30%;\"> 
                         $usr
                        </font>
                       </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Department</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         $uissue_area
                        </font>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP No.</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
                        <font color=\"#330099\"> 
                         $xpdp_desc
                        </font>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP Name</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%; word-wrap: break-word;\">
         	           <font color=\"#330099\"> 
                         $xpdp_name
                        </font> 	            
                       </td>
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Owner</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"word-wrap: break-word; width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_owner
                        </font> 	            
         	           </td>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Launch</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_launch_dt
                        </font> 
                       </td>
                      </tr>
                      <tr>
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">Status</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                         $xpdp_status
                        </font> 
                       </td> 
                       <td bgcolor=\"#99CCFF\" align=\"left\" style=\"width:15%;\"><font color=\"#330099\">PDP Type</font></td>
         	           <td align=\"left\" valign=\"middle\" bgcolor=\"#CCFFFF\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
               ");
			   
	   }		   

       // Insert a record in pdp_execution if it does not exist
       // ---------------------------------------------------
       $query32 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind
                     from ".$name.".pdp_execution where pdp_id = '$xid'"; 
       $mysql_data32 = mysql_query($query32, $mysql_link) or die ("#41 Could not query: ".mysql_error());
       $rowcnt32 = mysql_num_rows($mysql_data32);

       if ($rowcnt32 == 0) {
           $query33 = "INSERT into ".$name.".pdp_execution(pdp_id,launch_ind)
                       VALUES('$xid',0)";
           $mysql_data33 = mysql_query($query33, $mysql_link) or die ("#42 Could not query: ".mysql_error());
           $yexecution_id = mysql_insert_id();
       }
       $query42 = "select execution_id,pdp_id,start_date,end_date,updated_by,invoice_count,bill_run_count,
                          ppw_update,comments,launch_ind,running_comments,last_update
                     from ".$name.".pdp_execution where pdp_id = '$xid'"; 
       $mysql_data42 = mysql_query($query42, $mysql_link) or die ("#43 Could not query: ".mysql_error());
       $rowcnt42 = mysql_num_rows($mysql_data42);

       while($row42 = mysql_fetch_row($mysql_data42)) {
               $yexecution_id         = stripslashes($row42[0]);
               $yid                   = stripslashes($row42[0]);
               $ypdp_id               = stripslashes($row42[1]);
               $ystart_dt             = stripslashes($row42[2]);
               $yend_dt               = stripslashes($row42[3]);
               $yupdated_by           = stripslashes($row42[4]);
               $yinvoice_cnt          = stripslashes($row42[5]);
               $ybillrun_cnt          = stripslashes($row42[6]);
               $yppw_update           = stripslashes($row42[7]);
               $ycomments             = stripslashes($row42[8]);
               $ylaunch_ind           = stripslashes($row42[9]);
               $yrunning_com_o        = stripslashes($row42[10]);
               $yrunning_com          = nl2br(stripslashes($row42[10]));
               $ylast_update          = stripslashes($row42[11]);

               $query91 = "select pdp_log_id,updated_by,updated_on,comments,issue_area,phase,phase_desc
                             from ".$name.".pdp_logs   
                            where pdp_id = '$xid'
                              and issue_area = '$uissue_area' 
                              and module = 'TRACKER'
                                    "; 
               //print($query91);               
               $mysql_data91 = mysql_query($query91, $mysql_link) or die ("#91 Could not query: ".mysql_error());
               $rowcnt91 = mysql_num_rows($mysql_data91);

               if ($rowcnt91 > 0){
                             $comcnt = 0;
                             $ycomments = "";
                             while($rowx91 = mysql_fetch_row($mysql_data91)) {
                                   $comcnt                  = $comcnt + 1;
                                   $ypdp_log_id             = stripslashes($rowx91[0]);
                                   $yupdated_by             = stripslashes($rowx91[1]);
                                   $yupdated_on             = stripslashes($rowx91[2]);
                                   $ycomments               = stripslashes($rowx91[3]);
                                   $yissue_area             = stripslashes($rowx91[4]);
								   $yphase                  = stripslashes($rowx91[5]);
								   $yphase_desc             = stripslashes($rowx91[6]);
								   if ($yphase == "OTHER"){
								       $yphase = $yphase." - ".$yphase_desc;
								   }
                                   $urunning_com[$comcnt]   = "<br><font color='black' size='2'>".$ycomments."<font><br>"; 
                                   $urunning_usr[$comcnt]   = "<br><strong><font color='blue' size='2'>UPDATED BY: ".$yupdated_by."<br>FROM: ".$yissue_area."<br>PHASE: ".$yphase."<br>UPDATED ON: ".$yupdated_on."<font></strong><br>"; 
                             }
               }     

               print(" <tr>
                 <td colspan=\"4\" bgcolor=\"#99CC66\" align=\"center\" style=\"word-wrap: break-word; word-break:break-all; width:90%;\">
                  <font color=\"#330099\">
                   Comments Log
                  </font>
                 </td>
                </tr>
                <tr>
                 <td colspan=\"4\" border=\"1\" bgcolor=\"#CCFFCC\" align=\"left\" valign=\"top\" style=\"word-wrap: break-word; word-break:break-all; width:100%; height:600px;  scroll-x: auto;\">
                  <div style=\"word-wrap: break-word; word-break:break-all; width:100%; height:600px; overflow: auto; background-color: #CCFFCC;\">
                   <p>
               ");
			   // Wendy wants to display comments for pdp starting in September, and not from before. $comdisplay = 1 is to display and 0 for not
			   if ($comdisplay == 1){
                   for ($com=$comcnt;$com>=1; --$com) {
                        $wrunning_usr = nl2br($urunning_usr[$com]);
                        $wrunning_com = nl2br($urunning_com[$com]);
                        print($wrunning_usr.$wrunning_com);
                   }
			   } else {
			   }
               print(" <br>
                       </p> 
                      </div>
                     </td>                  
                    </tr>
               ");			   
      }
       $captn = "Rework Effort";
       print(" 
               </table>
               <table id=\"theTable\" border='0' align=\"center\" width=\"90%\">
       ");
       $query44 = "select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq,issue_area_id
                     from ".$name.".pdp_stlc  
                    where issue_area_id = '$uissue_area_id'
					  and milestone_ind = 1
                  ";
       //print($query44);               
       $mysql_data44 = mysql_query($query44, $mysql_link) or die ("#47.5 Could not query: ".mysql_error());
       $rowcnt44     = mysql_num_rows($mysql_data44);
	   $row44cnt     = 0;
	   if ($rowcnt44 == 0) {
	       // Zombie milestone_surrogates record to be purged.
           $query444 = "select milestone_id,milestone,milestone_ind,milestone_time,milestone_seq,issue_area_id
                          from ".$name.".pdp_stlc  
                         where issue_area_id = '$uissue_area_id'
                  ";
           $mysql_data444 = mysql_query($query444, $mysql_link) or die ("#447.5 Could not query: ".mysql_error());
           $rowcnt444     = mysql_num_rows($mysql_data444);
	       $row444cnt     = 0;
           while($row444x = mysql_fetch_row($mysql_data444)) {
             $row444cnt            = $row444cnt + 1;
             $nmil_id[$row444cnt]  = stripslashes($row444x[0]);
			 $nmil[$row444cnt]     = stripslashes($row444x[1]);
             $query355x            = "DELETE from ".$name.".milestone_surrogates
				                       WHERE execution_id = '$yexecution_id' 
				                         AND milestone_id = '$nmil_id[$row444cnt]' ";
             //print($query35x);            
             $mysql_data355x = mysql_query($query355x, $mysql_link) or die ("#485.X Could not query: ".mysql_error());
			 ////////////print("Deleted zombie milestone_surrogate<br>");
			 //$umil[$row44cnt]     = stripslashes($row44x[1]);
           }
	   
	   } else {
         while($row44x = mysql_fetch_row($mysql_data44)) {
             $row44cnt            = $row44cnt + 1;
             $umil_id[$row44cnt]  = stripslashes($row44x[0]);
			 $umil[$row44cnt]     = stripslashes($row44x[1]);
			 //$umil[$row44cnt]     = stripslashes($row44x[1]);
         }
	   }
////////////////print ("Total Milestones: ".$rowcnt44."<br>");	   
       if ($rowcnt44 == 0) {
           print("  
                  <input type=\"hidden\" name=\"stlc\" value=\"0\">
           ");
       } else { 
           print("  
                <input type=\"hidden\" name=\"stlc\" value=\"1\">
                <caption>$captn</caption>
                <tr>
                 <!--<td bgcolor=\"#99CC00\" align=\"center\" rowspan=\"2\"><font color=\"#FFFFFF\">ID</font></td>-->
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">No</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">PDP Rework Effort</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Rework<br>Effort</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Time<br>(Hours)</font></td>
                </tr>
                <tr>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Baseline</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Rework</font></td>
                </tr>
           ");
	       // find out how many stlc milestone are found in milestone_surrogate	   
           $query34 = "select a.execution_id,a.milestone_id,a.iteration_count,b.milestone
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b 
                        where a.execution_id = $yexecution_id
                          and a.milestone_id = b.milestone_id
                          and b.issue_area_id = '$uissue_area_id'
                      ";
           ////////////print($query34."<br>");               
           $mysql_data34 = mysql_query($query34, $mysql_link) or die ("#47 Could not query: ".mysql_error());
           $rowcnt34     = mysql_num_rows($mysql_data34);
           if ($rowcnt34 == 0) {  
            for ($d=1;$d<=$mil_cnt;++$d) {
                if ($mil_ind[$d] == 1) {
                    $query35 = "INSERT into ".$name.".milestone_surrogates(execution_id,milestone_id,iteration_count)
                                VALUES('$yexecution_id','$mil_id[$d]',0)";
                    //print($query35);            
                    $mysql_data35 = mysql_query($query35, $mysql_link) or die ("#48 Could not query: ".mysql_error());
                }    
            }
           }
		   // comparing if milestone on this pdp is the same list as current list of active milestones for this department
	       $row34cnt     = 0;
           while($row34x = mysql_fetch_row($mysql_data34)) {
                 $row34cnt            = $row34cnt + 1;
                 $vmil_id[$row34cnt]  = stripslashes($row34x[1]);
				 $vmil[$row34cnt]     = stripslashes($row34x[3]);
           }
//////////print ("Total Previous Milestone Surrogates: ".$rowcnt34."<br>");
//breakpoint
//print("The next line generates an error.<br>");
//printaline("PLEASE?");
//print("This will not be displayed due to the above error.");
		   
           //if (($rowcnt34 <> $rowcnt44) && $rowcnt34 > 0) {
		   if ($rowcnt34 <> 0) {
            // finding if a milestone_id does not exist in milestone_surrogate table  		   
            for ($u0=1;$u0<=$row44cnt;++$u0) {
			 $fnd_u0 = 0;   
			 for ($u1=1;$u1<=$row34cnt;++$u1) {
			    ///////////////print("Insert Check: ".$umil_id[$u0]."-".$umil[$u0]." || ".$vmil_id[$u1]."-".$vmil[$u1]."<br>");
                if ($umil_id[$u0] == $vmil_id[$u1]) {
				    $fnd_u0 = 1;					
                }
			 }
             if ($fnd_u0 == 0){
                    $query35x = "INSERT into ".$name.".milestone_surrogates(execution_id,milestone_id,iteration_count)
                                VALUES('$yexecution_id','$umil_id[$u0]',0)";
                    //print($query35x);            
                    $mysql_data35x = mysql_query($query35x, $mysql_link) or die ("#48.X Could not query: ".mysql_error());
					////////////print("To be inserted ".$umil[$u0]."<br>");
             } else {
			        //print("No new inserts<br>");
             }			 
            }
            // finding and deleting a milestone_id from milestone_surrogate table for a give execution_id is not in valid in pdp_stlc table  		   
            for ($u1=1;$u1<=$row34cnt;++$u1) {
			 $fnd_u1 = 0;   
			 for ($u0=1;$u0<=$row44cnt;++$u0) {
			    ///////////print("Delete Check: ".$umil_id[$u0]."-".$umil[$u0]." || ".$vmil_id[$u1]."-".$vmil[$u1]."<br>");
                if ($vmil_id[$u1] == $umil_id[$u0]) {
				    $fnd_u1 = 1;
                }
			 }
             if ($fnd_u1 == 0){
                    $query35x = "DELETE from ".$name.".milestone_surrogates
					              WHERE execution_id = '$yexecution_id' 
								    AND milestone_id = '$vmil_id[$u1]' ";
                    //print($query35x);            
                    $mysql_data35x = mysql_query($query35x, $mysql_link) or die ("#48.X Could not query: ".mysql_error());
					///////////print("To be deleted ".$vmil[$u1]."<br>");
             } else {
			        //print("No new deletes<br>");
             }				 
            }
           } 
//breakpoint
//print("The next line generates an error.<br>");
//printaline("PLEASE?");
//print("This will not be displayed due to the above error.");
		   
           //else {
           $query44 = "select a.execution_id,a.milestone_id,a.iteration_count
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b   
                        where a.execution_id = $yexecution_id
                          and a.milestone_id = b.milestone_id 
                          and b.issue_area_id = '$uissue_area_id'
                      ";
           //print($query34);               
           $mysql_data44 = mysql_query($query44, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
           $rowcnt44 = mysql_num_rows($mysql_data44);
////////////////print ("Total Revised Milestone Surrogates: ".$rowcnt44."<br>");       
//breakpoint
//print("The next line generates an error.<br>");
//printaline("PLEASE?");
//print("This will not be displayed due to the above error.");
       $eseq = 0;
       $total_baseline = 0;
       $total_incrementatl = 0;
       while($row44 = mysql_fetch_row($mysql_data44)) {
                $eseq              = $eseq + 1;
                $yexecution_id     = stripslashes($row44[0]);
                $ymilestone_id     = stripslashes($row44[1]);
                $zid               = stripslashes($row44[1]);
                $yiteration_cnt    = stripslashes($row44[2]);
                print("  <tr>
                    <!--<td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                     <font color=\"#330099\">
                      $yexecution_id 
                     </font> 
                    </td>-->
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                     <font color=\"#330099\"> 
                      $eseq
                     </font> 
                    </td>
                ");
                $query36 = "select milestone_id,milestone,milestone_time 
                     from ".$name.".pdp_stlc 
                    where milestone_id = '$zid' 
                      and issue_area_id = '$uissue_area_id' 
                      and milestone_ind = 1 
                           ";
                $mysql_data36 = mysql_query($query36, $mysql_link) or die ("#50 Could not query: ".mysql_error());
                $rowcnt36 = mysql_num_rows($mysql_data36);
                while($row36 = mysql_fetch_row($mysql_data36)) {
                         $ymilestone        = stripslashes($row36[1]);
                         $ymilestone_time   = stripslashes($row36[2]);
                         $ybaseline_time    = $ymilestone_time;
                         $yincremental_time = ($yiteration_cnt) * $ymilestone_time;
                         $total_baseline    = $total_baseline + $ybaseline_time;
                         $total_incremental = $total_incremental + $yincremental_time;
                }      
                print("           
                    <td align=\"left\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                     <font color=\"#330099\"> 
                      $ymilestone
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                     <font color=\"#330099\"> 
                      <input type=\"text\" name=\"yiteration_cnt[$yid][$zid]\" value=\"$yiteration_cnt\" size=\"3\">
                      <input type=\"hidden\" name=\"ymilestone[$yid][$zid]\" value=\"$ymilestone\">
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                     <font color=\"#330099\"> 
                      $ybaseline_time
                     </font> 
                    </td>
                    <td align=\"center\" valign=\"middle\" bgcolor=\"#FFFFCC\">
                     <font color=\"#330099\"> 
                      $yincremental_time
                     </font> 
                    </td>
                   </tr>
                ");
       }
       //$total_time          = round($total_baseline + $total_incremental,2);
       //$percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
       //$percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ; 
       if ($total_incremental == 0){
		      $total_time          = 0; 
	   } else {
              $total_time          = round($total_baseline + $total_incremental,2);
	   }
	   if ($total_baseline == 0){
		      $percent_baseline    = 0;
              $percent_incremental = 0;			  
	   } else {
              $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
              $percent_incremental = round((($total_incremental / $total_baseline) * 100),2) ; 
       }
       print("
                  <tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Work Effort (Hours)</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $total_baseline
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $total_incremental
                    </font> 
                   </td>
                  </tr>
                                              
                  </tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Percentage</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $percent_baseline%
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
                    <font color=\"#FF0000\"> 
                     $percent_incremental%
                    </font> 
                   </td>
                  </tr>

                  </tr>
                   <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"3\">
                    <font color=\"#0000FF\"> 
                     <strong>Total Effort (Hours)</strong>
                    </font> 
                   </td>
                   <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\" colspan=\"2\">
                    <font color=\"#FF0000\"> 
                     $total_time
                    </font> 
                   </td>
                  </tr>                   
       ");
       }
       //}
       // ---------------------------------------------------
       }
       //$zrunning_log = nl2br($yrunning_com);
       //$zrunning_log = str_replace("<br>", "\n\n", $yrunning_com);
       //print($zit);
       // Submit options options
       print(" <tr>
                <td>
                </td colspan=\"6\" bgcolor=\"#FFFFF0\">
               </tr>
               <tr>
                <td align=\"center\" valign=\"middle\" colspan=\"6\"  bgcolor=\"#FFFFF0\">
                <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                 <input type=\"hidden\" name=\"start\" value=\"1\">
                 <input type=\"hidden\" name=\"area_cnt\" value=\"$rowcnty2\">
                 <input type=\"hidden\" name=\"pdpid\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update1[$xid]\" value=\"$xid\">
                 <input type=\"hidden\" name=\"update2[$yid]\" value=\"$yid\">
                 <input type=\"hidden\" name=\"$itcnt\" value=\"$zit\">
                </td>
               </tr>
              </table>
       ");
   } else {
       $found = 0;
       echo "<script type=\"text/javascript\">window.alert(\"PDP No. was not found, Try Again\")</script>";  
   }
   // -------------------------------------------------------------------------------------
} else {
   $found = 0;
// --------------------------     
// End of the check-01
}
// --------------------------

if ($found == 0) {
   print("<form method=\"post\" action=\"./pdp_notes.php\">
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
        </body>
       </html>
");
mysql_close($mysql_link);     
?>
