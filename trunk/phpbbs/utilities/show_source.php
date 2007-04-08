<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body style="text-align:left">
<?php
if($sourcefile||$_SERVER['HTTP_REFERER'])
{
	if(strrchr($_SERVER['HTTP_REFERER'],'?'))
	{
		$sourcefile=substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'],'?'));
	}
	else
	{
		$sourcefile=$_SERVER['HTTP_REFERER'];
	}
	$sourcefile=str_replace('http://'.$_SERVER["HTTP_HOST"],'',$sourcefile);
	echo '<h1>Source of:<span class=blue>'.$sourcefile.'</span></h1><hr>';
	highlight_file(realpath($sourcefile));
	echo '<hr><h2>文件最后修改时间:'.date("Y-n-j H:i:s",filemtime(realpath($sourcefile))).'</h2>';
}
else
{
	echo '<br><hr><center><h2><span class=red>无效地址，无法查看!</span></h2><hr></center>';
}
?>
<button onclick="javascript:history.go(-1)">后退</button>
</body>
</html>