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
$queryl = "select program_name,program_number,program_owner,modification_date,launch_date,approval_status,period from ".$name.".pdplanding "; 
$mysql_datal = mysql_query($queryl, $mysql_link) or die ("Could not query: ".mysql_error());
$rowcntl = mysql_num_rows($mysql_datal);
//print($queryl);

$pdpseq = 0;
while($rowl = mysql_fetch_row($mysql_datal)) {

      $program_name    = stripslashes(trim($rowl[0]));
      $program_number  = stripslashes(trim($rowl[1]));
      $program_owner   = stripslashes(trim($rowl[2]));
      $launch_date_d   = stripslashes(substr($rowl[4],0,2));
      $launch_date_m   = stripslashes(substr($rowl[4],3,2));
      $launch_date_y   = stripslashes(substr($rowl[4],6,4));
      $approval_status = stripslashes(trim($rowl[5]));
      $period          = 0;      
      
      //print($program_number."-".$launch_date_d."-".$launch_date_m."-".$launch_date_y);
                  
      $queryp = "select pdp_id,pdp_desc from ".$name.".pdp where pdp_desc = '$program_number' "; 
      $mysql_datap = mysql_query($queryp, $mysql_link) or die ("Could not query: ".mysql_error());
      $rowcntp = mysql_num_rows($mysql_datap);
      //print("$rowcntp");
      
      if ($rowcntp > 0) {

        $pdpseq = $pdpseq + 1; 
        $new_pdp_desc   = $program_number;
        $new_dt         = mktime(0,0,0,$newm,$newd,$newy);  
        $new_updated_by = strtoupper(trim($usr));
        $new_pdp_name   = addslashes(trim($program_name)); 
        $new_pdp_owner  = addslashes($program_owner);
        $new_pdp_status = addslashes($approval_status);
        $new_period     = 0;

        if (empty($launch_date_d)) {
            //$new_pdp_launch = mktime(0,0,0,$launch_date_d,$launch_date_m,$launch_date_y); 
            $queryi = "UPDATE ".$name.".pdp
		                  SET updated_date = '$new_dt',
		                      updated_by   = '$new_updated_by',
		                      pdp_name     = '$new_pdp_name',
		                      pdp_owner    = '$new_pdp_owner',
		                      pdp_status   = '$new_pdp_status'
		                WHERE pdp_desc = '$program_number' ";
		    //print("$queryi");
		    $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
		    //print("$queryi");
        } else {
            $new_pdp_launch = mktime(0,0,0,$launch_date_m,$launch_date_d,$launch_date_y); 
            $queryi = "UPDATE ".$name.".pdp
		                  SET updated_date = '$new_dt',
		                      updated_by   = '$new_updated_by',
		                      pdp_name     = '$new_pdp_name',
		                      pdp_owner    = '$new_pdp_owner',
		                      pdp_status   = '$new_pdp_status',
		                      pdp_launch   = '$new_pdp_launch'
		                WHERE pdp_desc = '$program_number' ";
		    //print("$queryi");            
		    $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
		    //print("$queryi");
        }
      }
      else
      {
        $pdpseq = $pdpseq + 1; 
        $new_pdp_desc   = $program_number;
        $new_dt         = mktime(0,0,0,$newm,$newd,$newy);  
        $new_updated_by = strtoupper(trim($usr));
        $new_pdp_name   = addslashes(trim($program_name)); 
        $new_pdp_owner  = addslashes($program_owner);
        $new_pdp_status = addslashes($approval_status);
        $new_period     = 0;
         
        if (empty($launch_date_d)) {
           //$new_pdp_launch = mktime(0,0,0,$launch_date_d,$launch_date_m,$launch_date_y); 
           $queryi ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by,pdp_name,pdp_owner,pdp_status,pdp_period_id)
                      VALUES('$new_pdp_desc','$new_dt','$new_updated_by','$new_pdp_name ','$new_pdp_owner',
                             '$new_pdp_status','$new_period')";
           //print($queryi);
           $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
        
        } else {
           $new_pdp_launch = mktime(0,0,0,$launch_date_m,$launch_date_d,$launch_date_y); 
           $queryi ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by,pdp_name,pdp_owner,pdp_launch,pdp_status,pdp_period_id)
                      VALUES('$new_pdp_desc','$new_dt','$new_updated_by','$new_pdp_name ','$new_pdp_owner',
                             '$new_pdp_launch','$new_pdp_status','$new_period')";
           //print($queryi);
           $mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());
        }
        
        //$queryi ="INSERT into ".$name.".pdp(pdp_desc,updated_date,updated_by,pdp_name,pdp_owner,pdp_launch,pdp_status)
        //              VALUES('$new_pdp_desc','$new_dt','$new_updated_by','$new_pdp_name ','$new_pdp_owner',
        //                     '$new_pdp_launch','$new_pdp_status')";
        //$mysql_datai = mysql_query($queryi, $mysql_link) or die ("Could not query: ".mysql_error());

        //$queryp1 = "select pdp_desc from ".$name.".pdp where pdpdesc = $program_number "; 
        //$mysql_datap1 = mysql_query($queryp1, $mysql_link) or die ("Could not query: ".mysql_error());
        //$rowcntp1 = mysql_num_rows($mysql_datap1); 
        //print($rowcntp1);

      } 
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
