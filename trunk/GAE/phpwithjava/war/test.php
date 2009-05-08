<?php
function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
$begin = microtime_float();
echo "Hello World from Germany :)<br /><br /> Lets go!<br />";
for($i=1;$i<10000;$i++) {
   $test = "Current microtime: ";
   $test = microtime_float();
   $test = "<br />";
}
echo "<hr>";
$end = microtime_float();
$time = $end-$begin;
echo "This script was computed in: <b>".$time." secs</b>";
?>