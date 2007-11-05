<?
ob_start();
$site_title="相关下载";
$page='download';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";
?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outerTable>
<tr>
	<td align=center valign=top>
	<br>
	<table width="80%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2>
		<span class=bigTitle>下载</span>
		<hr class=dotted size="0.5" width="50%" align=left>
		</td>
	</tr>
	<tr>
		<td class=content>
		<li><a href="setup/SkyMate_Setup.exe">本地下载SkyMate</a>(版本Beta1)</li>
		</td>
	</tr>
	<tr>
		<td height=80></td>
	</tr>
	<tr>
		<td>
		<span class=bigTitle>相关下载</span>
		<hr class=dotted size="0.5" width="50%" align=left>
		</td>
	</tr>
	<tr>
		<td class=content>
		<li><a href="setup/SkypeSetup-1.2.0.37.exe">Skype For Windows</a>(版本:1.2.0.37)</li>
		<li><a href="setup/skype-1.0.0.7-suse.i586.rpm">Skype For Linux(RPM)</a>(版本1.0.0.7)</li>
		<li><a href="setup/skype_staticQT-1.0.0.7.tar.bz2">Skype For Linux(Static binary tar.bz2 with Qt 3.2 compiled in)</a>(版本1.0.0.7)</li>
		<li><a href="setup/Skype_1.0.0.0.dmg">MacOS</a></li>
		<li><a href="setup/SkypeForPocketPC.exe">Pocket PC</a></li>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
<?
include_once "footer.php";
ob_end_flush();
?>
