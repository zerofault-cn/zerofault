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
	if(!(document.getElementById('time').value > 0 && document.getElementById('limit').value > 0)) 
	{
		alert('请输入正确的区块属性');
		document.forms[0].action = "#";
		return false;
	}

	document.forms[0].action = "main.php?do=block_hotcomment_do_add";
	return true;
}
</script>
</HEAD>

<BODY>
<table width="100%">
<FORM METHOD="POST" >
<TR>
 <TD colspan=2>热评文章区块属性：</TD>
</TR>
<TR>
 <TD>选择栏目：</TD>
 <TD>
	<SELECT name="select_subject">
		<?php
if (!empty($_obj['subject_list'])){
if (!is_array($_obj['subject_list']))
$_obj['subject_list']=array(array('subject_list'=>$_obj['subject_list']));
$_tmp_arr_keys=array_keys($_obj['subject_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['subject_list']=array(0=>$_obj['subject_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['subject_list'] as $rowcnt=>$subject_list) {
$subject_list['ROWCNT']=$rowcnt;
$subject_list['ALTROW']=$rowcnt%2;
$subject_list['ROWBIT']=$rowcnt%2;
$_obj=&$subject_list;
?>
		<OPTION value="<?php
echo $_obj['id'];
?>
" <?php
echo $_obj['selectflag'];
?>
><?php
echo $_obj['prefix'];
?>
<?php
echo $_obj['name'];
?>

		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	</SELECT></TD>
</TR>
<TR>
	<TD>
		时间：
	</TD>
	<TD>来自<INPUT TYPE="text" id="time" name="time" value="24">小时以内的热评文章, 从第<input type="text" id="start_id" name="start_id" value="0" size="5">条开始，
	最多选取<INPUT TYPE="text" id="limit" name="limit" value="15" size="5">条</TD>
</TR>

<TR>
	<TD>显示方式:
	</TD>
	<TD>
		<select name="radio_is_group" size="1">
			<option value="0">非组文显示(显示所有组文文章)</option>
			<option value="1">组文显示(只显示每个组文中的一个标题)</option>
			
		</select>
	</TD>
</TR>
<tr>
	<td>标题长度</td>
	<td>
		是否限制:
			是<input name="is_limit_title_length" type="radio" value="1" onclick="document.forms[0].title_length.disabled=false">
			否<input name="is_limit_title_length" type="radio" value="0" onclick="document.forms[0].title_length.disabled=true" checked>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 长度：<input name="title_length" disabled="true" size="5">
	</td>
</tr>
<tr>
	<td>来源：</td>
	<td>
			<input name="radio_source" type="radio" value='cms' checked>本站(CMS)
			<input name="radio_source" type="radio" value='rss'>外部RSS源
	</td>
</tr>
<tr><td colspan=2>
格式：<br>
<textarea name="format" cols="50" rows="10" id="format"><?php
echo $_obj['format'];
?>
</textarea>
<br>可用标记：链接：remote_url，标题：title，评论数：comment_num
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
	<INPUT TYPE="submit" value="确定" onclick="check();"/></TD>
</TR>
</FORM>
</TABLE>
</BODY>
</HTML>