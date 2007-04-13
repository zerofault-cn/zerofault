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
<title>用户登录</title>
<link rel="stylesheet" href="../adm/style.css" type="text/css">
<script language="javascript">
function check()
{
	if(window.document.login.user_account.value=="")
	{
		alert("您忘了输入用户名");
		document.login.user_account.focus();
		return false;
	}
	if(window.document.login.user_pass.value=="")
	{
		alert("您忘了输入密码");
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
<caption>用户说明</caption>
<tr>
	<td style="font-size:13px;">
	<ol>
	<li>登录方法：<br>
	<div style="text-indent:2em;">如果您同时是家易通的用户，请使用您的家易通分配到的IP的后两段数字连接起来做用户名(共六位)，例如:您的家易通分配的IP是172.18.<u style="color:red">145</u>.<u style="color:red">001</u>，则您应使用用户名<u style="color:red">145001</u>登录；如果IP是172.18.<u style="color:red">145</u>.<u style="color:red">012</u>，则应使用<u style="color:red">145012</u>登录，依次类推；密码和用户名一样！</div>
	<div style="text-indent:2em;">在您点播“中”或“高”品质的影片时有可能需要输入这个用户名和密码。</div>
	<li>相关下载：<br>
		<ul type="disc">
		<li>如果某些WMV格式的影片播放不了，您需要下载并安装最新版的“Windows Media Player”，<a href="/setup/media10.exe">点这里下载</a>。
		<li>如果某些MP4格式的影片播放不了，您需要下载并安装专用的MP4播放器，<a href="/setup/SetupXP.exe">点这里下载</a>。
		<li>如果您要使用“股市行情”服务，您需要下载并安装“JAVA虚拟机”，<a href="/setup/j2re-1_4_2_04-windows-i586-p.exe">点这里下载</a>。
		</ul>
	</ol>
	</td>
</tr>
</table>
<table border=0 cellpadding=0 cellspacing=0>
<caption>请您登录</caption>
<form action="pc_login_2.php" name=login method=post>
<tr>
	<td align=right>用户名:</td>
	<td><input type=text name=user_account></td>
</tr>
<tr>
	<td align=right>密码:</td>
	<td><input type=password name=user_pass></td>
</tr>
<tr>
	<td colspan=2 align=center><input type=submit value=登录 onclick="return check();">&nbsp;&nbsp;<input type=reset value="重填"></td>
</tr>
</form>
</table>
</center>
</body>
</html>
