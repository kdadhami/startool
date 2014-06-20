<?php
  $host = "localhost:3306";
  //$name = "preprod";
  //$name = "myenv";
  $name = "newuatpdp";
  $user = "root";
  $pass  = "esf";
  $mysql_link = mysql_connect($host,$user,$pass) or die ("Connection not established with Server".mysql_error());
  print $mysql_link;
  mysql_select_db($name,$mysql_link) or die ("Connection not established with Database".mysql_error());

?>
