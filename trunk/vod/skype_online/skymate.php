<?
ob_start();
$site_title="SkyCall Product";
$page='product';
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
		<td width=400 align=right valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 style="line-height:130%" bgcolor="#E5F4FF">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/skymate_logo.gif"><img src="image/skymate_title1.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td colspan=2 align=center><img src="image/skymate_intro.gif"></td>
		</tr>
		<tr>
			<td><img src="image/table_bottom_left.gif"></td>
			<td colspan=2 background="image/table_bottom.gif"></td>
			<td><img src="image/table_bottom_right.gif"></td>
		</tr>
		</table>
		</td>
		<td width=10><!-- ÖÐ¼ä¿ÕÏ¶ --></td>
		<td valign=top>
		<!-- ÓÒ±ß -->
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td><img src="image/skymate_intro2.gif"></td>
		</tr>
		<tr>
			<td align=center><a href="setup/SkyMate_Setup.exe"><img src="image/download_btn.gif" border=0></a></td>
		</tr>
		</table>
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
