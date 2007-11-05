<?
ob_start();
if(''==$_COOKIE['goldsoft_user'])
{
//	header("location:syslogin.php");
//	exit;
}
$site_title="SkyCall社区";
$page='community';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";
?>
<center>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	<tr>
		<td width=210 align=right valign=top>
		<?
		setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
		if(!isset($_COOKIE['cookie_user_id']) || ''==$_COOKIE['cookie_user_id'])
		{
			loginTable();
		}
		else
		{
			infoTable();
			onlineTable();
		}
		searchTable();
		otherLinkTable();
		?>
		</td>
		<td width="10"></td>
		<td valign=top align=center>
		<!-- 会员列表 -->
		<?
		if(!isset($p) || ''==$p)
		{
			$p='member_list';
		}
		include_once "$p.php";
		?>
		</td>
	</tr>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
<?
include_once "footer.php";
ob_end_flush();
?>
