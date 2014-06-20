<?php

// Connection
require_once("./inc/connect.php");

// setting up today's date
$newd  = date("d"); //day
$newm  = date("m"); //month
$newy  = date("Y"); //year
$newt  = time();
$new_dt = mktime(0,0,0,$newm,$newd,$newy);

if (isset($signout)) {
   //print("Stop here");
   session_start();
   $xsession = session_id();
   //print($xsession."<br>");
   $querys5 = "UPDATE ".$name.".sessions
                  SET logout_state = 1 
                WHERE sessionid    = trim('$xsession')" ;
   //print($querys5);             
   $mysql_data5 = mysql_query($querys5, $mysql_link) or die ("Could not query: ".mysql_error());
   print(" 
           <script type=\"text/javascript\">
             parent.document.all['content1'].innerHTML='<iframe src=\"signin.htm\" width=\"100%\" height=\"100%\" scrolling=\"auto\" frameborder=\"no\"></iframe>';
             parent.document.all['footer'].innerHTML='<iframe src=\"signout-user.php?usr=$xuserid\" width=\"100%\" height=\"100%\" scrolling=\"auto\" frameborder=\"no\"></iframe>';
           </script> 
   ");  
    
}   

print("<html>
        <head>
         <title>Login</title>
         <!--<link rel=\"stylesheet\" type=\"text/css\" href=\"css/common.css\">-->

           <style>
              body {background: #FFFFF0;}
           </style>
           
           <script>
             function PopupCenter(pageURL, title,w,h)
              {
                var left = (screen.width/2)-(w/2);
                var top = (screen.height/2)-(h/2);
                var targetWin = window.open (pageURL, title, 'menubar=no, resizable=yes, scrollbars=yes, fullscreen=yes, location=no, toolbar=no, width='+w+', height='+h+', top='+top+', left='+left);
                window.moveTo(0,0);
                window.resizeTo(screen.width, screen.height);
              }
           </script>
        </head>
        <body>
      ");


// Start of HTMl
if (isset($xuserid) && isset($xpaswd)) {
    //print($found."<br>");
    if ($submit == "GO") {
        $xuserid = strtoupper($xuserid);
        $xpaswd = sha1($xpaswd);
print ("reached here"."<br>");
        $queryh = "SELECT a.lanid,a.paswd,a.user_type_id,a.issue_area_id,b.issue_area 
                     FROM ".$name.".users a, ".$name.".issue_areas b  
                    where UPPER(a.lanid) = '$xuserid' 
                      and a.issue_area_id = b.issue_area_id
                  ";
        $mysql_datah = mysql_query($queryh, $mysql_link) or die ("Could not query: ".mysql_error());
        $cnth = mysql_num_rows($mysql_datah);
        //print("Count:".$cnth."<br>");

        while($row = mysql_fetch_row($mysql_datah)) {
	          $yuserid         = stripslashes($row[0]);
	          $ypaswd          = stripslashes($row[1]);
	          $yuser_type_id   = stripslashes($row[2]);
	          $yissue_area_id  = stripslashes($row[3]);
	          $yissue_area     = stripslashes($row[4]);
	          //print($yuserid."-".$ypaswd."<br>");

              if (($yuserid == $xuserid) && ($ypaswd == $xpaswd)) {
                   $insert_ind = 1;
                   //print("Login good"."<br>");
                   $queryg = "SELECT menu FROM user_types where user_type_id = '$yuser_type_id' ";
                   $mysql_datag = mysql_query($queryg, $mysql_link) or die ("Could not query: ".mysql_error());
                   $cntg = mysql_num_rows($mysql_datag);
                   while($rowg = mysql_fetch_row($mysql_datag)) {
	                     $ymenu = stripslashes($rowg[0]);
	               }
                   //print("Count:".$cnth."<br>");
              } else {
                  	  $insert_ind = 0;
                  	  //print("Login no-good"."<br>");
              }
            }

        if ($insert_ind == 1){
            $allow_login  = 0;
            $launch_menu  = 0;
            $err_msg      = 0;
            $found        = 1;
            session_start();
            $xsession = session_id();
            //print($xsession."<br>");
            // check last entry for the same session (if used previously)
            $querys3 = "SELECT id,sessionid,user,login_date,logout_state 
                          FROM ".$name.".sessions 
                         WHERE sessionid = trim('$xsession')
                      ORDER BY id desc limit 1 "; 
            //print($querys3."<br>");
            $mysql_datas3 = mysql_query($querys3, $mysql_link) or die ("Could not query: ".mysql_error());
            $cnts3 = mysql_num_rows($mysql_datas3);
            //print($cnts3."<br>");
            while($rows3 = mysql_fetch_row($mysql_datas3)) {
                  //$zsessionid    = stripslashes(trim($rows3[1]));
                  $zuserid       = stripslashes($rows3[2]);
                  $zlogout_state = stripslashes($rows3[4]);
                  //print($zuserid."-".$zlogout_state."<br>");
                  if ($zlogout_state == 0) {
                      if ($zuserid == $xuserid) {
                          $allow_login = 1; // Users is logging again after logout under same session
                      } else {
                          $allow_login = 0;
                      }
                  }
                  if ($zlogout_state == 1) {
                      $allow_login = 1;  // allows to login on a used session, as previous user logged out gracefully i.e. logout_state = 1
                  }	                  
            }
	        // insert a session record if user logs in first time today or logging in again with a unique session  
	        if (($cnts3 == 0) && ($allow_login == 0)){
	            $querys2 = "INSERT into ".$name.".sessions(sessionid,user,login_date,logout_state)
                            VALUES('$xsession','$xuserid',$new_dt,0)";
                $mysql_data2 = mysql_query($querys2, $mysql_link) or die ("Could not query: ".mysql_error());
                $launch_menu = 1;
            } 
	        if ($allow_login == 1){
	            $querys4 = "UPDATE ".$name.".sessions
	                           SET user         = '$xuserid',
	                               login_date   = '$new_dt',
	                               logout_state = 0 
                             WHERE sessionid    = trim('$xsession')" ;
                $mysql_data4 = mysql_query($querys4, $mysql_link) or die ("Could not query: ".mysql_error());
                $launch_menu = 1;
            }
            if ($launch_menu == 1) {
                print(" 
                       <script type=\"text/javascript\">
                        parent.document.all['content1'].innerHTML='<iframe src=\"$ymenu?usr=$xuserid\" width=\"100%\" height=\"100%\" scrolling=\"auto\" frameborder=\"no\"></iframe>';
                        parent.document.all['footer'].innerHTML='<iframe src=\"signin-user.php?usr=$xuserid\" width=\"100%\" height=\"100%\" scrolling=\"auto\" frameborder=\"no\"></iframe>';
                       </script> 
                ");
            } else {
              $err_msg = 2;
            } 
        } else {
            $err_msg = 1;
            print("
                    </body>
                   </html>
                  ");
            //echo "<script type=\"text/javascript\">alert(\"Invalid Username or Password\");</script>";
        }
        if ($err_msg <> 0){
            if ($err_msg == 1){
                echo "<script type=\"text/javascript\">alert(\"Invalid Username or Password\");</script>";
            }
            if ($err_msg == 2){
                $found = 0;
                echo "<script type=\"text/javascript\">alert(\"Previous user still logged in or has not exited gracefully, exit user or clear browser cache and restart browser\");</script>";
            }
        }
    }
} else {
  $found = 0;
}
if ($found == 0){
    print("
              <form method=\"post\" action=\"./login.php\">
                <table border=\"0\">
                 <tr>
                  <td><a>Name</a></td>
                  <td><input type=\"text\" name=\"xuserid\" value=\"\" size=\"45\" maxlength=\"45\"></td>
                 </tr>
                 <tr>
                  <td><a>Password</a></td> 
                  <td><input type=\"password\" name=\"xpaswd\" value=\"\" size=\"50\" maxlength=\"50\"></td>
                 </tr>
                 <tr>
                  <td>
                   <input type=\"submit\" name=\"submit\" value=\"GO\">
                   <input type=\"hidden\" name=\"found\" value=\"$found\">
                  </td>
                 </tr>  
                </table>
              </form>
            </body>
           </html>
          ");
}
mysql_close($mysql_link);
?>
