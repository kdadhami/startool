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
$trans = "loop";
// ==============================

if ($submit == "Submit") {    
   // Update all edited records
   if (isset($update)) {
       while (list($key) = each($update)) {
	          $xid[$key]    = addslashes($xid[$key]);
	          $xpaswd[$key] = addslashes($xpaswd[$key]);
              $query2       = "select paswd from ".$name.".users where lanid = '$xlanid[$key]' "; 
              $mysql_data2  = mysql_query($query2, $mysql_link) or die ("Could not query: ".mysql_error());
              $rowcnt2      = mysql_num_rows($mysql_data2);
              while($row2 = mysql_fetch_row($mysql_data2)) {
                    $ypaswd  = stripslashes($row2[0]);
                    $ypaswd2 = sha1($ypaswd);
              }
              $query = "UPDATE ".$name.".users
                           SET   paswd = sha1('$xpaswd[$key]')
                         WHERE user_id = '$key'";
	          $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
	          $trans = "done";
	   }
   }
}

print("<html>
        <head>
           <style>
             html {height: 100%;}
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
                  }
           div.scrollWrapper{
                   /*float:left;*/
                   margin-left: auto; 
                   margin-right: auto;
                   /*overflow:visible*/ /*!important;*/
                   /*overflow:scroll;*/
                   height:90%;  /*600px;*/
                  }
           /*div.scrollWrapper.table{
                   margin-left: auto; 
                   margin-right: auto;
                  }*/
           table.scrollable{
                   width:90%;   /*600px;*/
                   margin-right:0 /*!important;*/
                   margin-right:16px;
                   border-collapse:separate;
                  }
           table.scrollable tbody{
                   height:90%; /*600px;*/
                   /*overflow:auto;*/
                   overflow-x:hidden;
                   overflow-y:auto;
                  }
 
           </style>       
        </head>
        <body>
");        

if (isset($usr) && ($trans <> "done")) {
   $usr = strtoupper(trim($usr));
   //if ($submit == "GO") {
      $captn = "Reset Password";
      print("
             <div id=\"content\">
              <form method=\"post\" action=\"./resetpassword.php\">
               <table border='0' align=\"center\">
                <caption>$captn</caption>
                 <tr>
                  <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">lan Id</font</td>
                  <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Password</font</td>
                  <td bgcolor=\"#99CCFF\" align=\"center\"><font color=\"#330099\">Full Name</font</td>
                 </tr>
      ");

      $query = "select user_id,lanid,fullname,user_type_id,paswd from ".$name.".users
                 where lanid = '$usr' order by user_id desc limit 1 "; 
      $mysql_data = mysql_query($query, $mysql_link) or die ("Could not query: ".mysql_error());
      $rowcnt = mysql_num_rows($mysql_data);
      $found = 0;
      if ($rowcnt == 1){
          $seq = 0;
          while($row = mysql_fetch_row($mysql_data)) {
  	            $xid            = stripslashes($row[0]);
                $xlanid         = stripslashes($row[1]);
	            $xfullname      = stripslashes($row[2]);
	            $xpaswd         = stripslashes($row[4]);
	            if (trim($xlanid) == strtoupper(trim($usr))) {
	                $found = 1;
                    $seq = $seq + 1;
	                print("   <tr rowspan=\"3\" valign=\"top\" scroll=\"yes\">
	                           <td align=\"center\" bgcolor=\"#AFDCEC\">
	                            <font color=\"#000000\"> 
                                 $xusr
                                </font>
                                <input type=\"hidden\" name=\"xid[$xid]\" value=\"$xid\"> 
	                           </td>
	                           <td align=\"center\" bgcolor=\"#AFDCEC\">
                                 <input type=\"password\" name=\"xpaswd[$xid]\" value=\"$xpaswd\" size=\"50\" maxlength=\"50\">
	                           </td>
	                           <td align=\"center\" bgcolor=\"#AFDCEC\">
	                             <font color=\"#000000\"> 
                                  $xfullname
                                 </font> 
                                  <input type=\"hidden\" name=\"update[$xid]\" value=\"Update\">
	                           </td>
	                          </tr>
	                ");
	            }	            
	      }  
          print("     </table>
                      <table border='0' align=\"center\">
                       <tr>
                        <td>
                         <br />
                         <input type=\"submit\" name=\"submit\" value=\"Submit\">
                        </td>
                       </tr>
                      </table>
                     </form>
                    </div>   
          ");
     }
  //}   
} else {
  if ($trans == "done"){
      echo "<script type=\"text/javascript\">alert(\"Password has been reset\");</script>";
  } else {
    //$found = 0;
    echo "<script type=\"text/javascript\">alert(\"User not found, Try Again\");</script>";
  }
}
//if ($found == 0){
//    print("
//              <form method=\"post\" action=\"./resetpassword.php\">
//                <table border=\"0\">
//                 <tr>
//                  <td>
//                   <font color=\"#000000\"> 
//                    Name
//                   </font>                  
//                  </td>
//                  <td>
//                   <input type=\"text\" name=\"yuserid\" value=\"\" size=\"45\" maxlength=\"45\">
//                  </td>
//                  <td>
//                   <input type=\"submit\" name=\"submit\" value=\"GO\">
//                   <input type=\"hidden\" name=\"found\" value=\"$found\">
//                  </td>
//                 </tr>  
//                </table>
//              </form>
//          ");
//}
print("
         </body>
        </html>
");
mysql_close($mysql_link);
?>
