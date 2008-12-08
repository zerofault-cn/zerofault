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
<script language="Javascript">

var channelSwitch;

var blockType;
var id;


var showAdArea = <?php
echo $_obj['showAd'];
?>
;


function showAd()
{
	for(var i=0;i<document.getElementsByTagName('textarea').length;i++)
	{
		eval("var name = document.getElementById('name_" + i + "').value");
		var result = name.match(/ad\:/);
		if(result != null)
		{
			if(showAdArea)
			{
				eval("document.getElementById('area_" + i + "').style.display = \"\";");
			}
			else
			{
				eval("document.getElementById('area_" + i + "').style.display = \"none\";");
			}			
		}
	}
}

function editBlock(id)
{
	var selector = eval("document.getElementById('blocklist_'" + id + ");");
	var index =selector.selectedIndex;

	var block_id = selector.options[selectedIndex].value;

	var url = "main.php?do=block_edit&channel_name=<?php
echo $_obj['CHANNEL_NAME'];
?>
&id=" + block_id;
	var local = window.open(url,'编辑区块');

	if(local.opener == null)
	{
		local.opener = window;
	}

	local.opener.blur();

	return false;
}

function getSel()
{
	var txt = '';
	if (window.getSelection)
	{
		txt = window.getSelection();
		alert(txt.nodeType);
		txt = txt.toString();
	}
	else if (document.getSelection)
	{
		txt = document.getSelection();
	}
	else if (document.selection)
	{
		txt = document.selection.createRange().text;
	}
	alert(txt);
	return false;
}

function getData()
{
	var channelSwitch = showChannel();

	var index = eval("document.editform." + channelSwitch + ".selectedIndex;");
	idv = eval("document.editform." + channelSwitch + ".options[index].value;");

	if(idv < 0)
		idv = 0;


	blockType = eval("document.editform." + channelSwitch + ".options[" + idv + "].id;");

	var block = {type : blockType,
				 id : idv};

	return block;
}

function showChannel()
{
	for(var i=0;i<document.editform.showchannel.length;i++)
	{
		var name = document.editform.showchannel[i].value;
		if(document.editform.showchannel[i].checked)
		{
			channelSwitch = name;
			eval("document.editform." + name + ".style.display = \"\";");
		}
		else
		{
			eval("document.editform." + name + ".style.display = \"none\";");
		}
	}


	return channelSwitch;
}

function checkData()
{
	if(document.editform.name.value.length > 0)
	{
		var block = getData();
		document.editform.channel.value = block['type'] + "=" + block['id']; 
		return true;
	}

	alert('请填写要添加的模板名称');
	return false;
}
</script>
</HEAD>

<body onload="<?php
echo $_obj['JS'];
?>
;showChannel();showAd();">

<FORM METHOD="POST" ACTION="main.php?do=tpl_save" name="editform" onsubmit="return checkData();" ENCTYPE="multipart/form-data">
<TABLE width="100%" name="template">
<TR>
	<TD>模板名称</TD>
	<TD><input name="name" type="text" size="80" value="<?php
echo $_obj['NAME'];
?>
"></TD>
</TR>
<TR>
	<TD>模板所属的频道／专题</TD>
	<TD><input type="radio" name="showchannel" value="subjectlist" onclick="showChannel();">频道
		<select id="subjectlist">
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
			<option id="subject_id" value="<?php
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
		</select> ｜ 
		<input type="radio" name="showchannel" value="speciallist" onclick="showChannel();">专题

		<select id="speciallist">
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
			<option id="<?php
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
		</select>
	</TD>
</TR>
<?php
if (!empty($_obj['block'])){
if (!is_array($_obj['block']))
$_obj['block']=array(array('block'=>$_obj['block']));
$_tmp_arr_keys=array_keys($_obj['block']);
if ($_tmp_arr_keys[0]!='0')
$_obj['block']=array(0=>$_obj['block']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['block'] as $rowcnt=>$block) {
$block['ROWCNT']=$rowcnt;
$block['ALTROW']=$rowcnt%2;
$block['ROWBIT']=$rowcnt%2;
$_obj=&$block;
?>
<TR>
	<TD colspan="5">
<TABLE width="100%" id="area_<?php
echo $_obj['count'];
?>
">
<TR>
	<TD>模块名称</TD>
	<TD><?php
echo $_obj['name'];
?>
</TD>
</TR>
<TR>
	<TD>模块内容</TD>
	<TD colspan="2">
	<textarea id="content_<?php
echo $_obj['count'];
?>
" name="block[content][]" cols="80" rows="10"><?php
echo $_obj['content'];
?>
</textarea>
	<input type="hidden" id="name_<?php
echo $_obj['count'];
?>
" value="<?php
echo $_obj['name'];
?>
">
	<input type="hidden" name="block[type][]" value="<?php
echo $_obj['type'];
?>
">
	<input type="hidden" name="block[startpos][]" value="<?php
echo $_obj['startpos'];
?>
">
	<input type="hidden" name="block[length][]" value="<?php
echo $_obj['length'];
?>
">
</TR>
<TR>
	<TD>操作</TD>
	<TD>
		<button name="put" onclick="var index = document.editform.selectBlock[<?php
echo $_obj['count'];
?>
].selectedIndex;document.getElementById('content_<?php
echo $_obj['count'];
?>
').value += '\{' + document.editform.selectBlock[<?php
echo $_obj['count'];
?>
].options[index].innerHTML + '\}'; document.getElementById('content_<?php
echo $_obj['count'];
?>
').focus(); return false;">放置区块</button> ｜ 区块列表:
		<select name="selectBlock">
			<?php
if (!empty($_obj['block_list'])){
if (!is_array($_obj['block_list']))
$_obj['block_list']=array(array('block_list'=>$_obj['block_list']));
$_tmp_arr_keys=array_keys($_obj['block_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['block_list']=array(0=>$_obj['block_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['block_list'] as $rowcnt=>$block_list) {
$block_list['ROWCNT']=$rowcnt;
$block_list['ALTROW']=$rowcnt%2;
$block_list['ROWBIT']=$rowcnt%2;
$_obj=&$block_list;
?>
			<OPTION VALUE="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['name'];
?>
</OPTION>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>

	</TD>
</TR>
</TABLE>
	</TD>
</TR>
<?php
if (!empty($_obj['used_blocks'])){
if (!is_array($_obj['used_blocks']))
$_obj['used_blocks']=array(array('used_blocks'=>$_obj['used_blocks']));
$_tmp_arr_keys=array_keys($_obj['used_blocks']);
if ($_tmp_arr_keys[0]!='0')
$_obj['used_blocks']=array(0=>$_obj['used_blocks']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['used_blocks'] as $rowcnt=>$used_blocks) {
$used_blocks['ROWCNT']=$rowcnt;
$used_blocks['ALTROW']=$rowcnt%2;
$used_blocks['ROWBIT']=$rowcnt%2;
$_obj=&$used_blocks;
?>
<TR>
	<TD colspan="5">已使用区块：<?php
echo $_obj['name'];
?>
 文章条目：<input type="text" size="2" name="block_limit[<?php
echo $_obj['id'];
?>
]" value="<?php
echo $_obj['limit'];
?>
"></TD>
</TR>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
<?php
if (!empty($_obj['template_images'])){
if (!is_array($_obj['template_images']))
$_obj['template_images']=array(array('template_images'=>$_obj['template_images']));
$_tmp_arr_keys=array_keys($_obj['template_images']);
if ($_tmp_arr_keys[0]!='0')
$_obj['template_images']=array(0=>$_obj['template_images']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['template_images'] as $rowcnt=>$template_images) {
$template_images['ROWCNT']=$rowcnt;
$template_images['ALTROW']=$rowcnt%2;
$template_images['ROWBIT']=$rowcnt%2;
$_obj=&$template_images;
?>
<TR>
	<TD colspan="5">上传图片：
		<input type="file" size="60" name="template_images[]" />
		<input type="hidden" name="template_images[<?php
echo $_obj['count'];
?>
][startpos]" value="<?php
echo $_obj['startpos'];
?>
" />
		<input type="hidden" name="template_images[<?php
echo $_obj['count'];
?>
][length]" value="<?php
echo $_obj['length'];
?>
" />
	</TD>
</TR>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
<TR>
	<TD colspan="5"><hr></TD>
</TR>

<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>

<TR>
	<TD colspan="5" align="center">是否设为正式页面：
	<?php
if ($_obj['is_default'] == "Y"){
?>
	<input type="radio" name="is_default" value="Y" CHECKED />是
	<input type="radio" name="is_default" value="N" />否
	<?php
} else {
?>
	<input type="radio" name="is_default" value="Y" />是
	<input type="radio" name="is_default" value="N" CHECKED />否
	<?php
}
?>
	<hr>
	</TD>
</TR>
<TR>
	<TD colspan="5" align="center">
	<input type="submit" value="保存" onsubmit="checkData();getChannel();return false;"/> 
	<input type="reset" value="重设" />
	<input type="hidden" name="file" value="<?php
echo $_obj['FILE'];
?>
">
	<input type="hidden" name="id" value="<?php
echo $_obj['ID'];
?>
">
	<input type="hidden" name="channel" value="">
	<input type="hidden" name="channel_name" value="<?php
echo $_obj['CHANNEL_NAME'];
?>
">
	</TD>
</TR>
</TABLE>
</form>
</body>
</html>
