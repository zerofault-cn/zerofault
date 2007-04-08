<?
ob_start();
session_start();
$phpbbs_root_path="..";

$submit=$_REQUEST['submit'];
$number=$_REQUEST['number'];
if(''!=$submit)
{
//	mysql_connect('localhost','root','');
	$table='num_'.substr($number,0,3);
	$sql1="select * from ".$table." where number='".substr($number,0,7)."'";
	$result1	=mysql_db_query('mobile',$sql1);
	$province	=mysql_result($result1,0,1);
	$city		=mysql_result($result1,0,2);
	$card		=mysql_result($result1,0,3);
	$telecode	=mysql_result($result1,0,4);
}
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>手机号码归属地查询</title>
<link rel="stylesheet" href="<?=$phpbbs_root_path?>/style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	if(/[^0-9]/g.test(window.document.form1.number.value))
	{
		alert('不能输入除数字外的其他字符！');
		document.form1.number.focus();
		return false;
	}
	if(window.document.form1.number.value=='')
	{
		alert("请输入手机号码！");
		document.form1.number.focus();
		return false;
	}
	if(window.document.form1.number.value.length<7)
	{
		alert("您输入的手机号码位数不够");
		document.form1.number.focus();
		return false;
	}
	return true;
}

</script>
<body topMargin=0>
<center>
<!-- TOP -->
<?
include_once $phpbbs_root_path.'/top.php';
?>
<!-- TOP over -->
<br>
<br>
<table width="760" border=0 cellpadding=0 cellspacing=0>
<form name="form1" action="<?=$PHP_SELF?>" method="post" onsubmit="return check();">
<tr>
	<td align="center"><h3>手机号码归属地查询</h3>
	输入手机号（至少前7位）:<input type="text" name="number" size="11" maxlength="11" value="<?=$number?>">
	&nbsp;<input type="submit" name="submit" value="查询">
	<?
	if(''!=trim($number))
	{
		?>
		<table width="50%" border="1" cellpadding=0 cellspacing=0 style="margin-top:5px;padding:3px;border:1px solid #d0d0d0">
		<tr>
			<td align="right">号码段：</td>
			<td style="color:#ff0000"><?=substr($number,0,7)?></td>
		</tr>
		<tr>
			<td align="right">归属地：</td>
			<td style="color:#ff0000"><?=$province?>&nbsp;<?=$city?></td> 
		</tr>
		<tr>
			<td align="right">卡类型：</td>
			<td style="color:#ff0000"><?=$card?></td>
		</tr>
		<tr>
			<td align="right">区号：</td>
			<td style="color:#ff0000"><?=$telecode?></td>
		</tr>
		</table>
		<?
	}
	?>
	</td>
</tr>
</table>
<br>
<br>
<?
include_once $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>