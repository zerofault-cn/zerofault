<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
		
$imgfile1=file_get_contents("http://my.bobo.com.cn/bokee/changepic.php?userid=1");
$imgfile2=file_get_contents("http://my.bobo.com.cn/bokee/changepic.php?userid=2");
echo strlen($imgfile1);
echo '<br>';
echo strlen($imgfile2);
?>