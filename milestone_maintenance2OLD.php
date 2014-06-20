<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: milestone_maintenance.php
// Date: September, 2011
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

/////////////////////////
// Loading PDP Milestones
/////////////////////////
$query31      = "   select milestone_id,
                           milestone,
						   milestone_ind,
						   milestone_time,
						   milestone_seq,
                           milestone_type,
                           old_milestone_time						   
                      from ".$name.".pdp_stlc 
                     where issue_area_id = '$uissue_area_id'
                       and milestone_ind = 1 
                  order by milestone_ind desc, milestone_seq asc";
$mysql_data31 = mysql_query($query31, $mysql_link) or die ("#24 Could not query: ".mysql_error());
$rowcnt31         = mysql_num_rows($mysql_data31);
$mil_cnt          = 0;
//$mil_cnt          = $mil_cnt + 1;
//$mil_id[$mil_cnt] = 0;
//print($mil_id[$mil_cnt]."<br>");
while($row31 = mysql_fetch_row($mysql_data31)) {
      $mil_cnt              = $mil_cnt + 1;
      $mil_id[$mil_cnt]     = stripslashes($row31[0]);
      $mil[$mil_cnt]        = stripslashes($row31[1]);
      $mil_ind[$mil_cnt]    = stripslashes($row31[2]);
      $mil_time[$mil_cnt]   = (float)stripslashes($row31[3]);
      $mil_seq[$mil_cnt]    = (float)stripslashes($row31[4]);
      $mil_typ[$mil_cnt]    = stripslashes($row31[5]);
      $omil_time[$mil_cnt]  = (float)stripslashes($row31[6]);
      //print($mil_id[$mil_cnt]."-".$mil[$mil_cnt]."-".$mil_ind[$mil_cnt]."-".$mil_time[$mil_cnt]."-".$mil_seq[$mil_cnt]."<br>");
}
//print("Milestone Count = ".$mil_cnt);
/////////////////////////
/////////////////////////


// ============================== MILESTONE TYPE ================================
$mil_type[1]     = "Fixed";
$mil_type_val[1] = "F";
$mil_type[2]     = "Variable";
$mil_type_val[2] = "V";
$mil_type[3]     = "None";
$mil_type_val[3] = "N";
// ==============================================================================


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

if ($submit == "Submit") {

    if (isset($delete)) {
	    while (list($key) = each($delete)) {
		       // print($key." - ".$xexecution_id."<br>");
			   // Delete form milestone_surrogates table
               $query = "DELETE FROM ".$name.".milestone_surrogates 
			              WHERE milestone_id = '$key'
                            AND execution_id = '$xexecution_id'";
		       $mysql_data = mysql_query($query, $mysql_link);
			   // Delete form milestone_surrogates_archive table
               $query_b = "DELETE FROM ".$name.".milestone_surrogates_archive 
			                WHERE milestone_id = '$key'
                              AND execution_id = '$xexecution_id'";
		       $mysql_data_b = mysql_query($query_b, $mysql_link);
	    }
    }

}


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

   $captn="General Information";
   // -------------------------------------------------------------------------------------
   //Update pdp
   // -------------------------------------------------------------------------------------
   $queryx = "select a.pdp_id,
                     a.pdp_desc,
					 a.updated_date,
					 a.updated_by,
					 a.pdp_name,
					 a.pdp_owner,
					 a.pdp_launch,
                     a.pdp_status,
					 a.pdp_period_id
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
                   <form method=\"post\" action=\"./milestone_maintenance2.php?pdp=$pdp&&start=$start\">
                     <table border='0' align=\"center\" width=\"90%\">
                      <caption>$captn</caption>
                      <tr>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:15%;\"><font color=\"#FFFFFF\"><font color=\"#330099\">PDP ID</font></td>
         	           <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
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
               $query51 = "select a.pdp_id,
			                      a.pdp_period_id,
								  b.pdp_period 
						    from ".$name.".pdp a, pdp_periods b 
					       where a.pdp_id = '$xid' 
						     and a.pdp_period_id = b.pdp_period_id"; 
               $mysql_data51 = mysql_query($query51, $mysql_link) or die ("#36 Could not query: ".mysql_error());
               $rowcnt51 = mysql_num_rows($mysql_data51);
               if ($rowcnt51 == 1) {  
                   while($row51 = mysql_fetch_row($mysql_data51)) {
         	             $xpdp_period = stripslashes($row51[2]);
                   }
               } else {
                 $xpdp_period = "VALUE NOT SET"; 
               }
               print("   $xpdp_period
                        </font> 
                       </td> 
                      </tr>
               ");
			   
	   }		   

       // Insert a record in pdp_execution if it does not exist
       // ---------------------------------------------------
       $query32 = "select execution_id,
	                      pdp_id,
						  start_date,
						  end_date,
						  updated_by,
						  invoice_count,
						  bill_run_count,
                          ppw_update,
						  comments,
						  launch_ind
                     from ".$name.".pdp_execution 
					where pdp_id = '$xid'"; 
       $mysql_data32 = mysql_query($query32, $mysql_link) or die ("#41 Could not query: ".mysql_error());
       $rowcnt32 = mysql_num_rows($mysql_data32);

       if ($rowcnt32 == 0) {
           $query33 = "INSERT into ".$name.".pdp_execution(pdp_id,launch_ind)
                       VALUES('$xid',0)";
           $mysql_data33 = mysql_query($query33, $mysql_link) or die ("#42 Could not query: ".mysql_error());
           $yexecution_id = mysql_insert_id();
       }
       $query42 = "select execution_id,
	                      pdp_id,
						  start_date,
						  end_date,
						  updated_by,
						  invoice_count,
						  bill_run_count,
                          ppw_update,
						  comments,
						  launch_ind,
						  running_comments,
						  last_update
                     from ".$name.".pdp_execution 
				    where pdp_id = '$xid'"; 
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
      }
	  //print("Execution ID: ".$yexecution_id."<br>");
      print("
                      <tr>
                       <td align=\"left\" valign=\"middle\" bgcolor=\"#99CCFF\" style=\"width:15%;\"><font color=\"#FFFFFF\"><font color=\"#330099\">Execution ID</font></td>
         	           <td colspan=\"3\" align=\"left\" valign=\"middle\" bgcolor=\"#E8E8E8\" style=\"width:30%;\">
         	            <font color=\"#330099\"> 
                          <a>$yexecution_id</a>
                        </font>   
         	           </td>
                      </tr>
      ");	  
	  ////////////////////////////////////
	  ///////// WORK EFFORT //////////////
	  ///////////////////////////////////
      $captn = "Work Effort Status";
           print(" 
               </table>
               <table id=\"theTable\" border='0' align=\"center\" width=\"90%\">
                <input type=\"hidden\" name=\"stlc\" value=\"1\">
                <caption>$captn</caption>
                <tr>
                 <td bgcolor=\"#99CC00\" align=\"center\" rowspan=\"2\"><font color=\"#FFFFFF\">ID</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">No</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Activity<br>Order</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Department</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Update<br>No</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Adjusted<br>No</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Work Activities</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Iterations</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"3\"><font color=\"#330099\">Time Taken<br>HH:MM</font></td>
                 <td bgcolor=\"#CCCCCC\" align=\"center\" colspan=\"2\"><font color=\"#330099\">Last<br>Updated</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Milestone Type<br>F=Fixed<br>V=Variable<br>N=None</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">R=Retrofit<br>N=New</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\" rowspan=\"2\"><font color=\"#330099\">Delete</font></td>
                </tr>
                <tr>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Baseline</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Rework</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">Total</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">By</font></td>
                 <td bgcolor=\"#CCCC99\" align=\"center\"><font color=\"#330099\">On</font></td>
                </tr>
           ");
           $query44 = "select a.execution_id,
		                      a.milestone_id,
							  a.iteration_count,
							  a.updated_by,
							  a.updated_on,
							  a.baseline_time,
							  a.total_time,
							  a.incremental_time,
							  a.occurance,
							  b.milestone_type, 
							  b.milestone_time,
                              b.milestone,
                              a.retrofit_parity,
                              a.base_variance,
                              a.incremental_variance,
                              b.milestone_seq,
                              a.adjust_occurance,
                              c.issue_area							  
                         from ".$name.".milestone_surrogates a, ".$name.".pdp_stlc b, ".$name.".issue_areas c   
                        where a.execution_id  = $yexecution_id
                          and a.milestone_id  = b.milestone_id 
                          and b.issue_area_id = c.issue_area_id
					 order by b.issue_area_id,b.milestone_seq asc	  
                      ";
           //print($query34);               
           $mysql_data44       = mysql_query($query44, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
           $rowcnt44           = mysql_num_rows($mysql_data44);
           $eseq               = 0;
           $total_baseline     = 0;
           $total_incrementatl = 0;
           while($row44 = mysql_fetch_row($mysql_data44)) {
                $eseq                          = $eseq + 1;
                $yexecution_id                 = stripslashes($row44[0]);
                $ymilestone_id                 = stripslashes($row44[1]);
                $zid                           = stripslashes($row44[1]);
                $yiteration_cnt                = stripslashes($row44[2]);
                $yupdated_on                   = stripslashes($row44[3]);
                $yupdated_by                   = stripslashes($row44[4]);
                (float)$ybaseline_time         = stripslashes($row44[5]);
	            $ybase_hrs                     = intval($ybaseline_time/60);      //derives hours 
                $ybase_mins                    = $ybaseline_time%60;              // derives minutes beyond 60 but less then 60 in the last hour
                (float)$ytotal_time            = stripslashes($row44[6]);
	            $ytotal_hrs                    = intval($ytotal_time/60);         //derives hours 
                $ytotal_mins                   = $ytotal_time%60;                 // derives minutes beyond 60 but less then 60 in the last hour
                (float)$yincremental_time      = stripslashes($row44[7]);
	            $yincr_hrs                     = intval($yincremental_time/60);   //derives hours 
                $yincr_mins                    = $yincremental_time%60;           // derives minutes beyond 60 but less then 60 in the last hour
				$yoccurance                    = stripslashes($row44[8]);
				$ymilestone_type               = stripslashes($row44[9]);
				(float)$ymilestone_time        = stripslashes($row44[10]);
				$ymilestone                    = stripslashes($row44[11]);
				$yretrofit_parity              = stripslashes($row44[12]);
				(float)$ybase_variance         = stripslashes($row44[13]);
				(float)$yincremental_variance  = stripslashes($row44[14]);
				(float)$ymilestone_seq         = stripslashes($row44[15]);
				$yadjusted_occurance           = stripslashes($row44[16]);
				$yarea                         = stripslashes($row44[17]);
				//if ($yadjusted_occurance <> 0){
				//    $yfocus = 0;
				//} else {
				//    $yfocus = 1;
				//}
				//Base
				if (strlen($ybase_hrs) == 1){
				    $ybase_hrs_x = "0".$ybase_hrs;
				} else {
				    $ybase_hrs_x = $ybase_hrs;
				}
				//print($ybase_hrs_x);
				if (strlen($ybase_mins) == 1){
				    $ybase_mins_x = "0".$ybase_mins;
				} else {
				    $ybase_mins_x = $ybase_mins;
				}
				//print(" : ".$ybase_mins_x."<br>");
				//Increment
				if (strlen($yincr_hrs) == 1){
				    $yincr_hrs_x = "0".$yincr_hrs;
				} else {
				    $yincr_hrs_x = $yincr_hrs;
				}
				//print($yincr_hrs_x);
				if (strlen($yincr_mins) == 1){
				    $yincr_mins_x = "0".$yincr_mins;
				} else {
				    $yincr_mins_x = $yincr_mins;
				}
				//Totals
				if (strlen($ytotal_hrs) == 1){
				    $ytotal_hrs_x = "0".$ytotal_hrs;
				} else {
				    $ytotal_hrs_x = $ytotal_hrs;
				}
				//print($ytotal_hrs_x);
				if (strlen($ytotal_mins) == 1){
				    $ytotal_mins_x = "0".$ytotal_mins;
				} else {
				    $ytotal_mins_x = $ytotal_mins;
				}
				//print(" : ".$ytotal_mins_x."<br>");
				//if ($yfocus = 1){
				//    $fcolr = "#330099";
				//} else {
				//    $fcolr = "#CCCCCC";
				//}
                print("  <tr>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                           <font color=\"#330099\">
                            $ymilestone_id 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                           <font color=\"#330099\"> 
                            $eseq
                           </font> 
                          </td>
                ");
                $total_baseline    = $total_baseline + $ybaseline_time;
                $total_incremental = $total_incremental + $yincremental_time;
				$colr1 = "#C3FDB8";
                print("           
				       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $ymilestone_seq
						</font> 
                       </td>
				       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $yarea
						</font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
						 $yoccurance
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
						 $yadjusted_occurance
                        </font> 
                       </td>
				       <td align=\"left\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $ymilestone
                         <input type=\"hidden\" name=\"xexecution_id\" value=\"$yexecution_id\">
						</font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
						 $yiteration_cnt
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $ybase_hrs_x : $ybase_mins_x 
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $yincr_hrs_x : $yincr_mins_x 
                        </font> 
                      </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $ytotal_hrs_x : $ytotal_mins_x 
                        </font> 
                      </td>
                      <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $yupdated_by
                        </font> 
                       </td>
                       <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $yupdated_on
                        </font> 
                      </td>
                      <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $ymilestone_type
                        </font> 
                      </td>
                      <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\"> 
                         $yretrofit_parity
                        </font> 
                      </td>
                      <td align=\"center\" valign=\"middle\" bgcolor=\"$colr1\">
                        <font color=\"#330099\">
                         <input type=\"checkbox\" name=\"delete[$ymilestone_id]\" value=\"Delete\">
                        </font> 
                      </td>
                     </tr>
                ");
				////////////////////////////////////////////////
				/// milestone_surrogate_archive
				////////////////////////////////////////////////
                $query44_a = "select 
				              a.execution_id,
		                      a.milestone_id,
							  a.iteration_count,
							  a.updated_by,
							  a.last_update,
							  a.baseline_time,
							  a.total_time,
							  a.incremental_time,
							  a.occurance,
							  b.milestone_type, 
							  b.milestone_time,
                              b.milestone,
                              a.retrofit_parity,
                              a.active_ind,
                              a.milestone_surrogate_archive_id,
                              a.base_variance,
                              a.incremental_variance,
							  b.milestone_seq,
							  a.adjust_occurance
                         from ".$name.".milestone_surrogates_archive a, ".$name.".pdp_stlc b   
                        where a.execution_id  = '$yexecution_id' 
                          and a.milestone_id  = '$ymilestone_id' 
						  and a.milestone_id  = b.milestone_id
						  and a.retrofit_parity <> 'R'
				     order by a.last_update desc 		  
                      ";
                //print($query44_a."<br>");               
                $mysql_data44_a     = mysql_query($query44_a, $mysql_link) or die ("#49.2 Could not query: ".mysql_error());
                $rowcnt44_a         = mysql_num_rows($mysql_data44_a);
				//print($rowcnt44_a."<br>");
                $eseq_a             = 0;
                //$a_total_baseline     = 0;
                //$total_incrementatl = 0;
                while($row44_a = mysql_fetch_row($mysql_data44_a)) {
                 $eseq_a                                    = $eseq_a + 1;
                 $yexecution_id_a                           = stripslashes($row44_a[0]);
                 $ymilestone_id_a                           = stripslashes($row44_a[1]);
                 $zid_a                                     = stripslashes($row44_a[1]);
                 $yiteration_cnt_a                          = stripslashes($row44_a[2]);
                 $yupdated_on_a                             = stripslashes($row44_a[3]);
                 $yupdated_by_a                             = stripslashes($row44_a[4]);
                 (float)$ybaseline_time_a                   = stripslashes($row44_a[5]);
	             $ybase_hrs_a                               = intval($ybaseline_time_a/60);      //derives hours 
                 $ybase_mins_a                              = $ybaseline_time_a%60;              // derives minutes beyond 60 but less then 60 in the last hour
                 (float)$ytotal_time_a                      = stripslashes($row44_a[6]);
	             $ytotal_hrs_a                              = intval($ytotal_time_a/60);         //derives hours 
                 $ytotal_mins_a                             = $ytotal_time_a%60;                 // derives minutes beyond 60 but less then 60 in the last hour
                 (float)$yincremental_time_a                = stripslashes($row44_a[7]);
	             $yincr_hrs_a                               = intval($yincremental_time_a/60);   //derives hours 
                 $yincr_mins_a                              = $yincremental_time_a%60;           // derives minutes beyond 60 but less then 60 in the last hour
				 $yoccurance_a                              = stripslashes($row44_a[8]);
				 $ymilestone_type_a                         = stripslashes($row44_a[9]);
				 (float)$ymilestone_time_a                  = stripslashes($row44_a[10]);
				 $ymilestone_a                              = stripslashes($row44_a[11]);
				 $yretrofit_parity_a                        = stripslashes($row44_a[12]);
				 $yactive_ind_a                             = stripslashes($row44_a[13]);
				 $ymilestone_surrogate_archive_id_a         = stripslashes($row44_a[14]);
				(float)$ybase_variance                      = stripslashes($row44_a[15]);
				(float)$yincremental_variance               = stripslashes($row44_a[16]);
				(float)$ymilestone_seq                      = stripslashes($row44_a[17]);
				$yadjusted_occurance_a                      = stripslashes($row44_a[18]);
				//if ($yadjusted_occurance_a <> 0){
				//    $yfocus = 0;
				//} else {
				//    $yfocus = 1;
				//}
		   		//Aggregate Sum - Base
		   		if (strlen($ybase_hrs_a) == 1){
					  $ybase_hrs_x = "0".$ybase_hrs_a;
		   		} else {
					  $ybase_hrs_x = $ybase_hrs_a;
		   		}
		   		//print($total_hrs_x);
		   		if (strlen($ybase_mins_a) == 1){
			   		$ybase_mins_x = "0".$ybase_mins_a;
		   		} else {
			   		$ybase_mins_x = $ybase_mins_a;
		   		}	
		   		//print(" : ".$total_mins_x."<br>");
		   		//Aggregate Sum - Incremental
		   		if (strlen($yincr_hrs_a) == 1){
			  		$yincr_hrs_x = "0".$yincr_hrs_a;
		   		} else {
			  		$yincr_hrs_x = $yincr_hrs_a;
		   		}
		   		//print($total_hrs_x);
		   		if (strlen($yincr_mins_a) == 1){
			   		$yincr_mins_x = "0".$yincr_mins_a;
		   		} else {
			   		$yincr_mins_x = $yincr_mins_a;
		   		}	
		   		//print(" : ".$total_mins_x."<br>");
		   		//Aggregate Sum - Total
		   		if (strlen($ytotal_hrs_a) == 1){
			  		$ytotal_hrs_x = "0".$ytotal_hrs_a;
		   		} else {
			  		$ytotal_hrs_x = $ytotal_hrs_a;
		   		}
		   		//print($total_hrs_x);
		   		if (strlen($ytotal_mins_a) == 1){
			   		$ytotal_mins_x = "0".$ytotal_mins_a;
		   		} else {
			   		$ytotal_mins_x = $ytotal_mins_a;
		   		}	
		   		//print(" : ".$total_mins_x."<br>");
				//if ($yfocus = 1){
				//    $fcolr = "#330099";
				//} else {
				//    $fcolr = "#CCCCCC";
				//}
				$colr2  = "#E8E8E8";
				$fcolr2 = "#666362";
                print("  <tr>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"#E8E8E8\">
                           <font color=\"#330099\">
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCCCC\">
                           <font color=\"#330099\"> 
                           </font> 
                          </td>
                          <td align=\"left\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                           </font> 
                          </td>
                          <td align=\"left\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
						    $yoccurance_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
						    $yadjusted_occurance_a
                           </font> 
                          </td>
                          <td align=\"left\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            <!--<input type=\"text\"   name=\"yiteration_cnt[$yid][$zid]\"   value=\"$yiteration_cnt\" size=\"3\">-->
						    $yiteration_cnt_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $ybase_hrs_x : $ybase_mins_x 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $yincr_hrs_x : $yincr_mins_x 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $ytotal_hrs_x : $ytotal_mins_x 
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $yupdated_by_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $yupdated_on_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $ymilestone_type_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\"> 
                            $yretrofit_parity_a
                           </font> 
                          </td>
                          <td align=\"center\" valign=\"middle\" bgcolor=\"$colr2\">
                           <font color=\"$fcolr2\">
                           </font> 
                          </td>
                         </tr>
                ");
				///////////////////////////////
				/// milestone_surrogate_archive
				///////////////////////////////
           }
           if ($total_incremental == 0){
			  $incr_hrs             = 0;
			  $incr_mins            = 0;
              $percent_incremental  = 0;	
	       } else {
	          $incr_hrs             = intval($total_incremental/60);      //derives hours 
              $incr_mins            = $total_incremental%60;              // derives minutes beyond 60 but less then 60 in the last hour
			  if ($total_baseline == 0){
			      $percent_incremental  = 0; 
			  } else {
			    //print($total_incrementatl." - ".$total_baseline."<br>");
                $percent_incremental  = round((($total_incremental / $total_baseline) * 100),2) ;
              }			  
	       }
	       if ($total_baseline == 0){
		       $percent_baseline    = 0;
			   $base_hrs            = 0;
			   $base_mins           = 0; 
	       } else {
               $percent_baseline    = round((($total_baseline / $total_baseline) * 100),2);
	           $base_hrs            = intval($total_baseline/60);      //derives hours 
               $base_mins           = $total_baseline%60;              // derives minutes beyond 60 but less then 60 in the last hour
           }
		   $total_time              = $total_baseline + $total_incremental;
		   if ($total_time == 0){
		       $total_time          = 0; 
			   $total_hrs           = 0;
			   $total_mins          = 0;
		   } else {
	           $total_hrs           = intval($total_time/60);      //derives hours 
               $total_mins          = $total_time%60;              // derives minutes beyond 60 but less then 60 in the last hour
		   }
		  } 
          // print("
          //        <tr>
          //         <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"5\">
          //          <font color=\"#0000FF\"> 
          //           <strong>Totals</strong>
          //          </font> 
          //         </td>
          //         <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
          //          <font color=\"#FF0000\"> 
          //           $base_hrs : $base_mins
          //          </font> 
          //         </td>
          //         <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
          //          <font color=\"#FF0000\"> 
          //           $incr_hrs : $incr_mins
          //          </font> 
          //         </td>
          //         <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
          //          <font color=\"#FF0000\"> 
          //           $total_hrs : $total_mins
          //          </font> 
          //         </td>
          //        </tr>
          //                                    
          //        </tr>
          //         <td align=\"right\" valign=\"middle\" bgcolor=\"#FFFFFF\" colspan=\"5\">
          //          <font color=\"#0000FF\"> 
          //           <strong>Percentage</strong>
          //          </font> 
          //         </td>
          //         <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
          //          <font color=\"#FF0000\"> 
          //           $percent_baseline%
          //          </font> 
          //         </td>
          //         <td align=\"center\" valign=\"middle\" bgcolor=\"#CCCC99\">
          //          <font color=\"#FF0000\"> 
          //           $percent_incremental%
          //          </font> 
          //         </td>
          //        </tr>
          // ");
	      //}
       //}
       print(" <tr>
                <td>
                </td colspan=\"6\" bgcolor=\"#FFFFF0\">
               </tr>
               <tr>
                <td align=\"center\" valign=\"middle\" colspan=\"16\"  bgcolor=\"#FFFFF0\">
                 <input type=\"submit\" name=\"submit\" value=\"Submit\"> 
                 <input type=\"hidden\" name=\"start\"  value=\"1\">
                 <input type=\"hidden\" name=\"pdp\"    value=\"$pdp\">
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
   print("<form method=\"post\" action=\"./milestone_maintenance2.php\">
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
