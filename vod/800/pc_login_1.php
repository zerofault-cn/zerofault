<?
session_start();
$_SESSION['goldsoft_user']='guest';
if(isset($_SESSION['goldsoft_user']) && $_SESSION['goldsoft_user']!='')
{
	header("location:menu_1.php");
	exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�û���¼</title>
<link rel="stylesheet" href="../adm/style.css" type="text/css">
<script language="javascript">
function check()
{
	if(window.document.login.user_account.value=="")
	{
		alert("�����������û���");
		document.login.user_account.focus();
		return false;
	}
	if(window.document.login.user_pass.value=="")
	{
		alert("��������������");
		document.login.user_pass.focus();
		return false;
	}
	return true;
}
</script>


<center>
<?
if(isset($_SESSION['login_msg']) && $_SESSION['login_msg']!="")
{
	?>
	<script>
		alert("<?=$_SESSION['login_msg']?>");
	</script>
	<?
	$_SESSION['login_msg']='';
}
?>
<table width=580 border=0 cellpadding=0 cellspacing=0>
<caption>�û�˵��</caption>
<tr>
	<td style="font-size:13px;">
	<ol>
	<li>��¼������<br>
	<div style="text-indent:2em;">�����ͬʱ�Ǽ���ͨ���û�����ʹ�����ļ���ͨ���䵽��IP�ĺ��������������������û���(����λ)������:���ļ���ͨ�����IP��172.18.<u style="color:red">145</u>.<u style="color:red">001</u>������Ӧʹ���û���<u style="color:red">145001</u>��¼�����IP��172.18.<u style="color:red">145</u>.<u style="color:red">012</u>����Ӧʹ��<u style="color:red">145012</u>��¼���������ƣ�������û���һ����</div>
	<div style="text-indent:2em;">�����㲥���С��򡰸ߡ�Ʒ�ʵ�ӰƬʱ�п�����Ҫ��������û��������롣</div>
	<li>������أ�<br>
		<ul type="disc">
		<li>���ĳЩWMV��ʽ��ӰƬ���Ų��ˣ�����Ҫ���ز���װ���°�ġ�Windows Media Player����<a href="/setup/media10.exe">����������</a>��
		<li>���ĳЩMP4��ʽ��ӰƬ���Ų��ˣ�����Ҫ���ز���װר�õ�MP4��������<a href="/setup/SetupXP.exe">����������</a>��
		<li>�����Ҫʹ�á��������顱��������Ҫ���ز���װ��JAVA���������<a href="/setup/j2re-1_4_2_04-windows-i586-p.exe">����������</a>��
		</ul>
	</ol>
	</td>
</tr>
</table>
<table border=0 cellpadding=0 cellspacing=0>
<caption>������¼</caption>
<form action="pc_login_2.php" name=login method=post>
<tr>
	<td align=right>�û���:</td>
	<td><input type=text name=user_account></td>
</tr>
<tr>
	<td align=right>����:</td>
	<td><input type=password name=user_pass></td>
</tr>
<tr>
	<td colspan=2 align=center><input type=submit value=��¼ onclick="return check();">&nbsp;&nbsp;<input type=reset value="����"></td>
</tr>
</form>
</table>
</center>
</body>
</html>
