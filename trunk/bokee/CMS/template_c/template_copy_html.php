<html>
<head>
	<title>复制模版</title>
<script language="javascript">
	function validator(a){
		if( ""== a.new_tpl_name.value )
		{
			alert("新模版名称不能为空！");
			a.new_tpl_name.focus();
			return(false);
		}
		if( ""== a.file_name.value )
		{
			alert("新目标文件名称不能为空！");
			a.file_name.focus();
			return(false);
		}
		return(true);

	}
	
	function subjectList(formName, url)  
	{
		var winFeatures, num, stepNum, linkAddress;
		// 得到每页显示数量
		//num = formName.recordsPerPage.value;
		num = 9;
		channelName = formName.channel_name.value;
		//operType = formName.operType.value;
		linkAddress = url+ "&channelName="+channelName;
		if(num < 10)
		{
			// 计算窗口高度
			listHeight = 29 * num + 244;
			winFeatures = "dialogWidth:521 px; dialogHeight:"+listHeight+" px; ";
		}
		else
		{
			winFeatures = "dialogWidth:535 px; dialogHeight:532 px; ";	
		}
		// 拼接其余窗口属性
		winFeatures += "dialogLeft:px; dialogTop:px; ";
		winFeatures += "edge:raised; center:yes; scroll:yes; resizable:no; status:no; help:no; "; 
		window.showModalDialog(linkAddress, window, winFeatures);
	}
</script>
</head>
<body>
	<br><br><br><br><br>
<center>
	<form action="main.php?do=template_do_copy" method="post" name="template_copy" onSubmit="return validator(this)">
		<font color="red">源模版：</font><br><br>
		选择已有模版：
		<select name="template_id" size="1">
			<?php
if (!empty($_obj['tpl_list'])){
if (!is_array($_obj['tpl_list']))
$_obj['tpl_list']=array(array('tpl_list'=>$_obj['tpl_list']));
$_tmp_arr_keys=array_keys($_obj['tpl_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['tpl_list']=array(0=>$_obj['tpl_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['tpl_list'] as $rowcnt=>$tpl_list) {
$tpl_list['ROWCNT']=$rowcnt;
$tpl_list['ALTROW']=$rowcnt%2;
$tpl_list['ROWBIT']=$rowcnt%2;
$_obj=&$tpl_list;
?>
				<option value="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>
		<br><br><br><br>
		<font color="red">目标模版：</font><br><br><input type="text" name="subject_name" readonly>
		<input type="button" name="selectsubject" value="选择目标模版" onclick="subjectList(this.form, 'main.php?do=template_copy_subject')">
		<br><br><br>
		输入新模版名称:
		<input name="new_tpl_name" size="20">
		<br><br><br>
		目标文件名称：
		<input name="file_name" size="20">
		<br><br><br>
		<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
		<input type="hidden" name="subject_id">
		<input type="submit" name="submit" value="提交">
	</form>
</center>
</body>
</html>