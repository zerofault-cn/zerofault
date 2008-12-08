<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?php
echo $_obj['TITLE'];
?>
</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;chaset=utf-8">
<META NAME="Cache-Control" CONTENT="no-store, no-cache, must-revalidate">
<META NAME="Author" CONTENT="Liutao">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<META ENCODING="UTF-8">
<script language="Javascript">
function check()
{
	if(!(document.getElementById('limit').value > 0)) 
	{
		alert('请输入正确的区块属性');
		document.forms[0].action = "#";
		return false;
	}

	document.forms[0].action = "main.php?do=block_photo_do_modify";
	return true;
}
</script>
</HEAD>

<BODY>
<table width="100%">
<form  name="block_modify_form" method="post" enctype='multipart/form-data'><TR>
 <TD>图片区块属性：</TD>
</TR>
<TR>
 <TD>选择栏目：		
	<SELECT name="select_subject">
	<?php
echo $_obj['options'];
?>

	</SELECT></TD>
</TR>
<TR>
	<TD>开始ID:<input type="text" id="start_id" name="start_id" value="<?php
echo $_obj['start_id'];
?>
"> &nbsp;&nbsp;&nbsp;&nbsp;最多选取<INPUT TYPE="text" id="limit" name="limit" value="<?php
echo $_obj['limit'];
?>
">条</TD>
</TR>
<?php
echo $_obj['str_title_length'];
?>

<tr>
	<td>显示方式: <?php
echo $_obj['radio_is_group'];
?>
</td>
</tr>
<tr><td>
格式：<br>
<textarea name="format" cols="50" rows="10" id="format"><?php
echo $_obj['format'];
?>
</textarea>
<br>可用标记：图片地址：path，图片链接：url，名称：name
</td>
</tr>
<TR>
	<TD>
	<INPUT TYPE="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
" />
	<INPUT TYPE="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
" />
	<INPUT TYPE="hidden" name="id" value="<?php
echo $_obj['id'];
?>
" />
	<INPUT TYPE="submit" value="确定" onclick="check();"/></TD>
</TR>
</FORM>
</TABLE>
</BODY>
</HTML>