<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<center>
<nobr>
������:<?=date("Y-m-d")?>
<?
$week=array('0'=>'������','1'=>'����һ','2'=>'���ڶ�','3'=>'������','4'=>'������','5'=>'������','6'=>'������');
echo $week[date("w")];
?>
</center>
</body>
</html>