<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ҳ</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script type="text/JavaScript" language="javascript" src="function.js"></script>
</head>

<body bgcolor="#ffa042">
<div id="titlelayer"><!-- ��ʾ��Ϣ�� --></div>
<!-- 169OL LOGO -->
<?
include_once "169ol.inc";
include_once "top.inc";
?>
<table width="993" height="208" border="0" cellpadding="0" cellspacing="0" background="image/index1_01.jpg">
<tr>
	<td></td>
</tr>
</table>
<table width="993" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td valign="top">
	<?
	//<!-- ��¼�� -->
	include_once "login.inc";
	//<!-- �����б� -->
	include_once "typelist.inc";
	//<!-- ���ŵ㲥 -->
	include_once "hotlist.inc";
	//<!-- ���а� -->
	include_once "paihanglist.inc";
	?>
	</td>
	<td valign="top">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		<?
		//<!-- ������� -->
		include_once "search.inc";
		?>
		</td>
		<td>
		<!-- С��� -->
		<div id="miniad">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
		<?
		//<!-- ���� -->
		include_once "info.inc";
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>

<!-- �ײ� -->
<?
include_once "footer.inc";
?>

</body>
<script type="text/JavaScript" language="javascript" src="function_title.js"></script>
</html>
