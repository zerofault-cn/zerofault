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
var source = {<?php
echo $_obj['SOURCES'];
?>
};
var sampleRow = {<?php
echo $_obj['FIELDS'];
?>
};
var preview = null;


function updateFormat(str)
{
	var str = document.anotherform.format.value;
	var result;

	if(!preview)
	{
		preview = document.createElement("div");
		preview.setAttribute("align","center");
		document.body.appendChild(preview);
	}

	pattern = /\{([^\}]+)\}/g;

	result = str.match(pattern);

	if(result != null)
	{
		for(var i=0;i<result.length;i++)
		{
			name = result[i];
			field = name.substring(1,name.length-1);
			if(sampleRow.hasOwnProperty(field))
			{				
				var foo = new RegExp(name,"gi");
				str = str.replace(foo,sampleRow[field]['data']);				
			}
			else
			{
				//Ajax?
			}
		}
	}

	str = str.replace(/\n/,"<br>");



	preview.innerHTML = "<H5>" + str + "</H5>";

	return false;

}
function checkFormat(isChecked,name,str)
{
	var brick = "{" + name + "}";
	if(isChecked)
	{
		if(str.indexOf(brick) < 0)
		{
			str += brick;
		}
	}
	else
	{
		if(str.indexOf(brick) >= 0)
		{
			str = str.slice(0,str.indexOf(brick)) + str.slice(str.indexOf(brick)+brick.length);
		}
	}
	return str;
}

function initSource()
{
	for(value in source)
	{
		if(source[value])
		{
			eval("document.form." + value + ".checked = true;");
		}
	}

	return false;
}

function getValue()
{
	var str = document.anotherform.format.value;
	var needPreview = arguments.length > 0?true:false;
	var error = false;
	var strSend = "";

	var channelId;
	var channelType;
	var Fields = 0;
	var Sources = 0;
	var limit = document.form.limit.value;
	var mark = document.form.mark.value;	
	var sourceSend = "";

	for(var i = 0;i<document.form.channel.options.length;i++)
	{
		if(document.form.channel.options[i].selected)
		{
			channelId = document.form.channel.options[i].value;
			channelType = document.form.channel.options[i].id;		
		}
	}

	for(value in source)
	{
		source[value] = eval("document.form." + value + ".checked;");
		if(source[value])
		{
			Sources++;
			sourceSend += value + "|";
		}
	}

	for(field in sampleRow)
	{
		sampleRow[field]['flag'] = eval("document.form." + field + "_info.checked;");
		if(sampleRow[field]['flag'])
		{
			Fields++;
		}
	}

	for(field in sampleRow)
	{
		str = checkFormat(sampleRow[field]['flag'],field,str);
	}

	strSend += "{" + channelType + " = " + channelId +"}";
	strSend += "{LIMIT = "+ limit +"}";
	strSend += "{mark = "+ mark +"}";
	strSend += "{FROM = " + sourceSend + "}";

	strSend += str;

	if(Fields > 0)
	{
		document.anotherform.hiddenValue.value = strSend;
	}
	else
	{
		document.anotherform.hiddenValue.value = "";
	}

	if(!needPreview)
	{
		document.anotherform.format.value = str;
		document.anotherform.format.focus();

		return true;
	}

	return false;

}

function checkName()
{
	if(document.anotherform.blockname.value.length == 0)
	{
		alert("请填写要添加的区块名称");
		document.anotherform.action = "#";
		return false;
	}

	document.anotherform.action = "main.php?do=block_save";
	return true;

}
</script>
</HEAD>

<BODY onload="initSource();getValue();">

<TABLE width="100%" align="center">
<FORM METHOD=POST ACTION="" name="form" onsubmit="getValue();return false;">
<TR>
	<TD> | 来自：
		<SELECT ID="channel" onchange="getValue();return false">
			<OPTION name="" value="-1"><b>频道</b>
			<?php
if (!empty($_obj['subject'])){
if (!is_array($_obj['subject']))
$_obj['subject']=array(array('subject'=>$_obj['subject']));
$_tmp_arr_keys=array_keys($_obj['subject']);
if ($_tmp_arr_keys[0]!='0')
$_obj['subject']=array(0=>$_obj['subject']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['subject'] as $rowcnt=>$subject) {
$subject['ROWCNT']=$rowcnt;
$subject['ALTROW']=$rowcnt%2;
$subject['ROWBIT']=$rowcnt%2;
$_obj=&$subject;
?>
			<OPTION id="<?php
echo $_obj['type'];
?>
" value="<?php
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
			<OPTION name="" value="-1"><b>专题</b>
			<?php
if (!empty($_obj['special'])){
if (!is_array($_obj['special']))
$_obj['special']=array(array('special'=>$_obj['special']));
$_tmp_arr_keys=array_keys($_obj['special']);
if ($_tmp_arr_keys[0]!='0')
$_obj['special']=array(0=>$_obj['special']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['special'] as $rowcnt=>$special) {
$special['ROWCNT']=$rowcnt;
$special['ALTROW']=$rowcnt%2;
$special['ROWBIT']=$rowcnt%2;
$_obj=&$special;
?>
			<OPTION id="<?php
echo $_obj['type'];
?>
" value="<?php
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
	<TD> | <INPUT TYPE="checkbox" name="cms" checked>从频道中选取</TD>
</TR>
<TR>
	<TD> | <INPUT TYPE="checkbox" name="blog">从公社中选取</TD>
</TR>
<TR>
	<TD> | <INPUT TYPE="checkbox" name="column">从专栏中选取</TD>
</TR>
<TR>
	<TD> | <INPUT TYPE="checkbox" name="rss">从RSS中选取</TD>
</TR>
<TR>
	<TD> | <INPUT TYPE="checkbox" name="blogmark">从博采中选取</TD>
</TR>
	<?php
if (!empty($_obj['field'])){
if (!is_array($_obj['field']))
$_obj['field']=array(array('field'=>$_obj['field']));
$_tmp_arr_keys=array_keys($_obj['field']);
if ($_tmp_arr_keys[0]!='0')
$_obj['field']=array(0=>$_obj['field']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['field'] as $rowcnt=>$field) {
$field['ROWCNT']=$rowcnt;
$field['ALTROW']=$rowcnt%2;
$field['ROWBIT']=$rowcnt%2;
$_obj=&$field;
?>
</TR>
	<TD> | <INPUT TYPE="checkbox" name="<?php
echo $_obj['key'];
?>
_info" <?php
echo $_obj['selectflag'];
?>
>显示<?php
echo $_obj['tip'];
?>
信息</TD>
</TR>
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>

<TR>
	<TD> | 最多显示<INPUT TYPE="text" name="limit" value="<?php
echo $_obj['LIMIT'];
?>
" size="1" onchange="getValue();return false">条</TD>
</TR>
<TR>
	<TD> | 文章等级
		<SELECT name="mark" onchange="getValue();return false">
	<?php
if (!empty($_obj['mark'])){
if (!is_array($_obj['mark']))
$_obj['mark']=array(array('mark'=>$_obj['mark']));
$_tmp_arr_keys=array_keys($_obj['mark']);
if ($_tmp_arr_keys[0]!='0')
$_obj['mark']=array(0=>$_obj['mark']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['mark'] as $rowcnt=>$mark) {
$mark['ROWCNT']=$rowcnt;
$mark['ALTROW']=$rowcnt%2;
$mark['ROWBIT']=$rowcnt%2;
$_obj=&$mark;
?>
			<OPTION value="<?php
echo $_obj['key'];
?>
" <?php
echo $_obj['selectflag'];
?>
><?php
echo $_obj['key'];
?>

	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</SELECT>
</TR>
</FORM>
<TR align="center" >
	<TD colspan="100"><button name="getValue" onclick="return getValue();return false;">提交</TD>
</TR>
</TABLE>

<TABLE width="100%" align="center" name="formattable">
<FORM METHOD=POST ACTION="main.php?do=block_save" name="anotherform">
<TR>
<TD align="center" colspan="2">
区块名称：<input type="text" size="70" name="blockname" value="<?php
echo $_obj['BLOCK_NAME'];
?>
"/>
</TD>
</TR>
<TR>
<TD align="center" colspan="2">
条目显示格式：
</TD>
</TR>
<TR>
<TD align="center" colspan="2">
<textarea cols="80" rows="4" name="format"><?php
echo $_obj['BLOCK_FORMAT'];
?>
</textarea>
</TD>
</TR>
<TR>
<TD align="center" width="100%">
<button name="update" onclick="return updateFormat();return false;">更新格式</button>
<input type="submit" name="submit" value="确认" onmouseover="getValue();" onsubmit="checkName();">
</TD>
<input type="hidden" name="hiddenValue">
<input type="hidden" name="id" value="<?php
echo $_obj['BLOCK_ID'];
?>
">
<input type="hidden" name="channel_name" value="<?php
echo $_obj['CHANNEL_NAME'];
?>
">
</TR>
</FORM>

</TABLE>
</BODY>
</HTML>
