<script language="javascript">
function check()
{
	if(window.document.board.username.value=="")
	{
		alert("请输入您的名字");
		document.board.username.focus();
		return false;
	}
	if(window.document.board.title.value=="")
	{
		alert("请输入留言标题");
		document.board.title.focus();
		return false;
	}
	if(window.document.board.info.value=="")
	{
		alert("您忘了写留言内容");
		document.board.info.focus();
		return false;
	}
	return true;
}
</script>

<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>插入留言</title>
<link rel="stylesheet" href="../main.css" type="text/css">
</head>
<body>
<center>
<table border=2 width=520 cellpadding=0 cellspacing=0 bordercolor=#d0dce0>
<form method=post action="insert_2.php" name=board onsubmit="return check();">
<tr><td width=520 colspan=2 align=center><font color=red>注意,*项必须填写</font></td></tr>
<tr><td width=20% align=right bgcolor=#c2e0a5><span class=red>*</span>留言人:</td>
	<td width=80% align=left><input type=text name=username size=20 value=
	<?php 
	if($username)
	{
		echo $username;
	}
	elseif($REMOTE_ADDR==$SERVER_ADDR || $REMOTE_ADDR=='127.0.0.1')
	{
		echo "朱明";
	}
	?>
	></td></tr>
<tr><td align=right bgcolor=#c2e0a5><span class=red>*</span>留言标题:</td>
	<td align=left><INPUT TYPE="text" NAME="title" value='<?=$title?>' size=30></td></tr>
<tr><td align=right bgcolor=#c2e0a5><span class=red>*</span>留言内容:</td>
	<td>
		<textarea name=info rows=15 cols=56 onkeydown='if(event.keyCode==87 && event.ctrlKey) {document.board.submit(); return false;}'  onkeypress='if(event.keyCode==10) return document.board.submit()'></textarea></td></tr>
<tr><td align=right bgcolor=#c2e0a5>辅助功能选择:</td>
	<td align=left>
		<input type=radio name=extension value=enubb checked>使用UBB代码<br>
		<input type=radio name=extension value=enphp>PHP语法高亮显示<br>
		<input type=radio name=extension value=enhtml>使用HTML标签</td></tr>
<tr><td align=right bgcolor=#c2e0a5>留言分类:</td>
	<td><table>
		<tr><td><input type=radio name=type value=message 
		<?
		if(isset($disabled))
		{
			echo 'disabled';
		}
		?>
		>message</td><td>&nbsp;</td></tr>
		<tr><td><input type=radio name=type value=tech 
		<?
		if(isset($disabled))
		{
			echo 'disabled';
		}
		?>
		>tech</td><td>&nbsp;</td></tr>
		<tr><td><input type=radio name=type value=feeling 
		<?
		if(isset($disabled))
		{
			echo 'disabled';
		}
		?>
		>feeling</td><td>&nbsp;</td></tr>
		<tr><td><input type=radio name=type value=joke 
		<?
		if(isset($disabled))
		{
			echo 'disabled';
		}
		?>
		>joke</td><td>&nbsp;</td></tr></table></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td>
	<td align=left valign=bottom>
		<input type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;
		<INPUT TYPE="reset" value="重写">&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=button value="查看留言" onclick="javascript:window.location='index.php'"></td></tr>
</form>
</table>

</center>
</body>
</html>