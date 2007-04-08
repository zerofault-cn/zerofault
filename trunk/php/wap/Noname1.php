<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="/phpbbs/main.css" type="text/css">
</head>
<body>
<center>
<nobr>
今天是:<?=date("Y-m-d")?>
<?
$week=array('0'=>'星期日','1'=>'星期一','2'=>'星期二','3'=>'星期三','4'=>'星期四','5'=>'星期五','6'=>'星期六');
echo $week[date("w")];
?>
</center>
</body>
</html>