<?
$s=basename($_SERVER['REQUEST_URI']);
?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outerTable>
<tr>
	<td align=center valign=top><a name=top></a>
	<table width="90%" height=24 border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td align=center  bgcolor="<?if($s=='profile.php')echo '#a5bede'?>" onMouseOver='this.style.backgroundColor="#a5bede"' onMouseOut='this.style.backgroundColor=""'><a href="profile.php">������Ϣ</a></td>
		<td align=center  bgcolor="<?if($s=='password.php')echo '#a5bede'?>" onMouseOver='this.style.backgroundColor="#a5bede"' onMouseOut='this.style.backgroundColor=""'><a href="password.php">�޸�����</a></td>
		<td align=center  bgcolor="<?if($s=='mate_setting.php')echo '#a5bede'?>" onMouseOver='this.style.backgroundColor="#a5bede"' onMouseOut='this.style.backgroundColor=""'><a href="mate_setting.php">ת������</a></td>
	</tr>
	</table>
	</td>
</tr>
</table>