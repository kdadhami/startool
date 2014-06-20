<?php
// --------------------------------------------------------------
// Author: Kashif Adhami
// Program: loadpdpinfo.php
// Date: Oct, 2010
// Notes: This program provides loading of .csv file containing pdp
// information into staging table pdplanding in the uatpdp database
//
// .csv file structure
// program_name,program_number,program_owner,modification_date,launch_date,approval_date,period
//
//
// --------------------------------------------------------------

// Connection
require_once("./inc/connect.php");

// script dies after 300 secs, set to 0 to have no time limit. The default in webserver is enforced via
// max_execution_time = 30 and max_input_time = 64. You can change php.ini and rebound webserver to make
// change happen for good. Else use set_time_limit() in your script to enforce locally.
set_time_limit(300);


// ==============================
// Getting user for this sessrion
session_start();
$xsession = session_id();
//print($xsession."<br>");
$querys5 = "SELECT user FROM ".$name.".sessions
                WHERE sessionid = trim('$xsession')" ;
//print($querys5);
$mysql_data5 = mysql_query($querys5, $mysql_link) or die ("#1 Could not query: ".mysql_error());
while ($row5 = mysql_fetch_row($mysql_data5)) {
       $usr  = stripslashes($row5[0]);
}
//$trans = "loop";
// ==============================

// setting up today's date
$newd  = date("d"); //day
$newm  = date("m"); //month
$newy  = date("Y"); //year
$newt  = time();
$new_dt = mktime(0,0,0,$newm,$newd,$newy);
//print($newd."-".$newm."-".$newy);

// getting id of user
//$usr = strtoupper(trim(getenv("username")));
//print $usr;

// -------------------------------------
// Start of the check-01
//if (isset($yrelid) && isset($yprjtyp)) {
// -------------------------------------

// Start of HTMl
print("<html>
        <head>
          <!--<link rel=\"stylesheet\" type=\"text/css\" href=\"css/common.css\">-->
           <style>
             body { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px; 
                  }
               td { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                    color: #FFFFFF; 
                  }
          caption { background:#FFFFF0; /*#FFC000;*/ color:#0000FF; font-size: 18x; font-weight: bold;}       
            input { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }
           select { font-family: Calibri, Helvetica, sans-serif;
                    font-size: 12px;
                  }                   
           #content
                  { top:0%;
                    width: 100%; height: 49%; background: #CEE3F6;
                    border: 1px solid; border-color:#BDBDBD;
                  }
           #contentb
                  { top:0%;
                    width: 100%; height: 1%; background: #FFFFF0;
                  }
           #contentc
                  { top:0%;
                    width: 100%; height: 49%; background: #CEF6E3;
                    border: 1px solid; border-color:#BDBDBD;
                  }
           div.scrollWrapper{
                   /*float:left;*/
                   margin-left: auto; 
                   margin-right: auto;
                   overflow:visible /*!important;*/
                   overflow:scroll;
                   height:280px;
                  }
           /*div.scrollWrapper.table{
                   margin-left: auto; 
                   margin-right: auto;
                  }*/
           table.scrollable{
                   width:600px;
                   margin-right:0 /*!important;*/
                   margin-right:16px;
                   border-collapse:separate;
                  }
           table.scrollable tbody{
                   height:280px;
                   /*overflow:auto;*/
                   overflow-x:hidden;
                   overflow-y:auto;
                  }
            a:link {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:visited {
            font-family: Calibri, Helvetica, sans-serif;
            text-decoration: none;
            color: #000000;
            }
            a:hover {
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

        </head>
        <body>
      ");

// Select all pdp from pdplanding
$queryl      = "select program_name,program_number,program_owner,modification_date,
                       launch_date,approval_status,v21buildstatus,programcategory,
					   segment,productline 
                  from ".$name.".pdplanding "; 
$mysql_datal = mysql_query($queryl, $mysql_link) or die ("#2 Could not query: ".mysql_error());
$rowcntl     = mysql_num_rows($mysql_datal);
//print($queryl);

$updlog      = "";
$updcnt      = 0;
$inslog      = "";
$inscnt      = 0;
$pdpseq      = 0;
while($rowl = mysql_fetch_row($mysql_datal)) {

      $program_name    = stripslashes(trim($rowl[0]));
      $program_number  = stripslashes(trim($rowl[1]));
      $program_owner   = stripslashes(trim($rowl[2]));
      // mofidiction date is not stored in table pdp from table pdplanding
      $launch_dt       = stripslashes($rowl[4]);
      if (empty($launch_dt)) {
      } else { 
          $launch_date_d   = stripslashes(substr($rowl[4],0,2));
          $launch_date_m   = stripslashes(substr($rowl[4],3,2));
          $launch_date_y   = stripslashes(substr($rowl[4],6,4));
      }
      $approval_status = stripslashes(trim($rowl[5]));
      $v21buildstatus  = stripslashes(trim($rowl[6]));
      $programcategory = stripslashes(trim($rowl[7]));
      $segment         = stripslashes(trim($rowl[8]));
      $productline     = strtoupper(trim(stripslashes(trim($rowl[9]))));
      // 1 is Cable + Wireless
      // 2 is Cable
      // 3 is Wireless	  
	  
	  // Enabled RWI for 2012
	  // Not in use
	  //if ( $productline == "RWI"){
	  //    $lob   = 0;
	  //}
	  // Cable + Wireless
	  if ($productline == "ALL"){
	      $lob   = 1;
	  }
	  // Cable
	  if ($productline == "CABLE" || $productline == "HP" || $productline == "INTFIX" || $productline == "VIDEO" || $productline == "CABLE TV" || $productline == "RCG" || $productline == "RHSI" || $productline == "SHM"){
	      $lob   = 2;
	  }
	  // Wireless
	  if ($productline == "FIDO" || $productline == "INTMOB" || $productline == "WDATA" || $productline == "WDUAL" || $productline == "WI" || $productline == "WVOICE" || $productline == "RWI"){
	      $lob   = 3;
	  }
	  	  
      //$period_id       = stripslashes($rowl[6]);    // this has been taken out from table pdplanding  
      
      //print($program_number."-".$launch_date_d."-".$launch_date_m."-".$launch_date_y);
                  
      $queryp = "select pdp_id,pdp_desc 
	               from ".$name.".pdp 
				  where pdp_desc = '$program_number' "; 
      $mysql_datap = mysql_query($queryp, $mysql_link) or die ("#3 Could not query: ".mysql_error());
      $rowcntp = mysql_num_rows($mysql_datap);
      //print("$rowcntp");
      
      if ($rowcntp > 0) {
        $pdpseq              = $pdpseq + 1; 
        $new_pdp_desc        = $program_number;
        $new_dt              = mktime(0,0,0,$newm,$newd,$newy);  
        $new_updated_by      = strtoupper(trim($usr));
        $new_pdp_name        = addslashes(trim($program_name)); 
        $new_pdp_owner       = addslashes($program_owner);
        $new_pdp_status      = addslashes($approval_status);
		$new_v21buildstatus  = addslashes($v21buildstatus);
        $new_programcategory = addslashes($programcategory);
        $new_segment         = addslashes($segment);
        $new_productline     = addslashes($productline);		
        $new_period_id       = 0;

        if (empty($launch_dt)) {
            //$new_pdp_launch = mktime(0,0,0,$launch_date_d,$launch_date_m,$launch_date_y); 
            $queryi = "UPDATE ".$name.".pdp
		                  SET updated_date    = '$new_dt',
		                      updated_by      = '$new_updated_by',
		                      pdp_name        = '$new_pdp_name',
		                      pdp_owner       = '$new_pdp_owner',
		                      pdp_status      = '$new_pdp_status',
							  v21buildstatus  = '$new_v21buildstatus',
                              programcategory = '$new_programcategory', 
                              segment         = '$new_segment ', 
                              productline     = '$new_productline',
                              lob             = '$lob' 							  
		                WHERE pdp_desc = '$program_number' ";
		    //print("$queryi");
		    $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#4 Could not query: ".mysql_error());
		    //print("$queryi");
        } else {
            $new_pdp_launch = mktime(0,0,0,$launch_date_m,$launch_date_d,$launch_date_y); 
            $queryi = "UPDATE ".$name.".pdp
		                  SET updated_date    = '$new_dt',
		                      updated_by      = '$new_updated_by',
		                      pdp_name        = '$new_pdp_name',
		                      pdp_owner       = '$new_pdp_owner',
		                      pdp_status      = '$new_pdp_status',
		                      pdp_launch      = '$new_pdp_launch',
							  v21buildstatus  = '$new_v21buildstatus',
                              programcategory = '$new_programcategory', 
                              segment         = '$new_segment ', 
                              productline     = '$new_productline',
                              lob             = '$lob' 							  
					    WHERE pdp_desc = '$program_number' ";
		    //print("$queryi");            
		    $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#5 Could not query: ".mysql_error());
		    //print("$queryi");
        }
        //$progrs = round(($pdpseq / $rowcntp) * 100,2);
 		$updcnt = $updcnt + 1;
		//print($progrs."%");
        //print($pdpseq.": ".$program_number." Updated"."<br>");
      }
      else
      {
        $pdpseq              = $pdpseq + 1; 
        $new_pdp_desc        = $program_number;
        $new_dt              = mktime(0,0,0,$newm,$newd,$newy);  
        $new_updated_by      = strtoupper(trim($usr));
        $new_pdp_name        = addslashes(trim($program_name)); 
        $new_pdp_owner       = addslashes($program_owner);
        $new_pdp_status      = addslashes($approval_status);
		$new_v21buildstatus  = addslashes($v21buildstatus);
        $new_programcategory = addslashes($programcategory);
        $new_segment         = addslashes($segment);
        $new_productline     = addslashes($productline);		
        $new_period_id       = 0;
         
        if (empty($launch_dt)) {
           //$new_pdp_launch = mktime(0,0,0,$launch_date_d,$launch_date_m,$launch_date_y); 
           $queryi ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by,pdp_name,
		                                       pdp_owner,pdp_status,pdp_period_id,v21buildstatus,
											   programcategory,segment,productline,lob)
                      VALUES('$new_pdp_desc','$new_dt','$new_updated_by','$new_pdp_name ','$new_pdp_owner',
                             '$new_pdp_status','$new_period_id','$new_v21buildstatus',
							 '$new_programcategory','$new_segment','$new_productline','$lob')";
           //print("<br>".$queryi);
           $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#6 Could not query: ".mysql_error());
        
        } else {
           $new_pdp_launch = mktime(0,0,0,$launch_date_m,$launch_date_d,$launch_date_y); 
           $queryi ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by,pdp_name,
		                                       pdp_owner,pdp_launch,pdp_status,pdp_period_id,v21buildstatus,
											   programcategory,segment,productline,lob)
                      VALUES('$new_pdp_desc','$new_dt','$new_updated_by','$new_pdp_name ','$new_pdp_owner',
                             '$new_pdp_launch','$new_pdp_status','$new_period_id',
							 '$new_v21buildstatus','$new_programcategory','$new_segment',
							 '$new_productline','$lob')";
           //print($queryi);
           $mysql_datai = mysql_query($queryi, $mysql_link) or die ("#7 Could not query: ".mysql_error());
        }
        //$progrs = round(($pdpseq / $rowcntp) * 100,2);
        $inscnt = $inscnt + 1;
		$inslog = $inslog.$program_number." inserted"."<br>";
		//print($progrs."%");
        //print($pdpseq.": ".$program_number." Inserted"."<br>");  
      } 
}
if ($updcnt > 0){
    print("Previous ".$updcnt." PDPs updated");
}
if ($inscnt > 0){
    print("<br><br>Following New PDP were inserted<br><br>");
    str_replace("<br>","\n\n",$inslog);
    print($inslog);
}

// End of HTML
print("
         </body>
        </html>
     ");

// --------------------------     
// End of the check-01
//}
// --------------------------

     
?>
