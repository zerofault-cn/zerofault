<?
//header("location:music/index.php");
//exit;

ob_start();

?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>海天一色欢迎你</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body topmargin=0>
<center>
<?
$phpbbs_root_path=".";
include_once $phpbbs_root_path.'/top.php';
include_once $phpbbs_root_path.'/main.php';
include_once $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>