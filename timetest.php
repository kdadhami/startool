<?php

$h1 = 2;
$m1 = 26;	
$h2 = 1;
$m2 = 55;
$a = $h1 + $h2;
$b = intval(($m1 + $m2)/60);
$c = ($m1 + $m2)%60;
print ("Total of hours = ".$a."<br>");
print ("Total of minutes (quotient) = ".$b."<br>");
print ("Total of minutes (remainder) = ".$c."<br>");

?>
