<?php
include_once "config.php";
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=str_replace("\r\n","<br />",$text);
	return $text;
}

$refer=$_REQUEST['refer'];
$msgFilename=$_REQUEST['msgFilename'];
$content=$_REQUEST['reContent'];
$time=date("Y-m-d H:i:s");

$text=$time."|><|";
$text.=format($content)."\r\n";

$fp2=fopen($msgDir.$msgFilename.$msgFileExt,"a+");
fwrite($fp2,$text);
fclose($fp2);
if(''!=$refer)
{
	header("location:".$refer);
	exit;
}
header("location:index.php");
exit;
?>