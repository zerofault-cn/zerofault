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
<title>回复留言</title>
<link rel="stylesheet" href="/phpbbs/style.css" type="text/css">
</head>
<body>
<center>
<?php
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$query1="select * from board where id=$id";
$result1=mysql_query($query1);
$r=mysql_fetch_array($result1);
$title=$r["title"];
?>
<table border=2 width=520 cellpadding=0 cellspacing=0 bordercolor=#d0dce0>
<form method=post action="insert_2.php" name=board onsubmit="return check();">
	<tr><td width=520 colspan=2 align=center><font color=red>注意,每项都必须填写</font></td></tr>
	<tr><td width=20% align=right bgcolor=#c2e0a5>回复者:</td>
		<td width=80% align=left><input type=text name=username size=20></td></tr>
	<tr><td align=right bgcolor=#c2e0a5>回复标题:</td>
		<td align=left><INPUT TYPE="text" NAME="title" value='<?=$title?>' size=30 readonly></td></tr>
	<tr><td align=right bgcolor=#c2e0a5>回复内容:</td>
		<td>
			<textarea name=info rows=15 cols=56></textarea></td></tr>
	<tr><td align=right bgcolor=#c2e0a5>辅助功能选择:</td>
		<td align=left>
			<input type=radio name=extension value=enubb checked>使用UBB代码<br>
			<input type=radio name=extension value=enphp>PHP语法高亮显示<br>
			<input type=radio name=extension value=enhtml>使用HTML标签</td></tr>
	
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td>
		<td align=left valign=bottom>
			<input type="hidden" name=pid value=<?=$id?>>
			<input type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE="reset" value="重写">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
</form>
</table>

</center>
</body>
</html>