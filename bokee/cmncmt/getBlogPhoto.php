<?php
header ("Content-type: image/png");
$sid=$_REQUEST['sid'];
$username=$_REQUEST['username'];
$blogPhoto='http://'.$username.'.bokee.com/inc/logo_s.png';
$file=file_get_contents($blogPhoto);
if(strlen($file)>100)
{
	echo $file;
}
else
{
	if('2008'==$sid)
	{
		echo file_get_contents('userBlogPhoto2008.png');
	}
}
?>