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
$username=$_REQUEST['username'];
$email=$_REQUEST['email'];
$title=$_REQUEST['title'];
$content=$_REQUEST['content'];
$time=date("Y-m-d H:i:s");

$text=$username."\r\n";
$text.=$email."\r\n";
$text.=$time."\r\n";
$text.=$_SERVER["REMOTE_ADDR"]."\r\n";
$text.=$title."\r\n";
$text.=format($content)."\r\n";

$msgFilename=date("Y-m-d_H-i-s").'_'.rand(1000,9999);
$fp1=fopen($index_file,"r+");
$fp2=fopen($msgDir.$msgFilename.$msgFileExt,"w");
$old_index=@fread($fp1,filesize($index_file));
rewind($fp1);
fwrite($fp1,$msgFilename."\r\n".$old_index);
fwrite($fp2,$text);
fclose($fp1);
fclose($fp2);
if(''!=$refer)
{
	header("location:".$refer);
	exit;
}
header("location:index.php");
exit;
?>