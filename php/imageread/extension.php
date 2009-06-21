<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<?php
if($dir=="")
$dir=".";
$handle=opendir($dir);
echo "当前目录:$dir<br>";
echo $df = diskfreespace(".");

while($file=readdir($handle))
{
	$extension=strrchr($file,".");
	echo $extension;
	echo "<br>";
}
closedir($handle);
?>
<br>
<button onclick="javascript:history.go(-1)">后退</button>
</body>
</html>