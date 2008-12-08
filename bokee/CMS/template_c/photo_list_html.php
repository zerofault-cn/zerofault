<html>
<style type="text/css">
<!--
table {
font-size: 14px;
}
.wraper {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width:160px;
	border:1px solid black;
	padding:20px 10px;
}
-->
</style>

<SCRIPT LANGUAGE="javascript" type="text/javascript">
function Checkform(){
	var frm = document.templateListForm;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=photo_delete";
		return window.confirm("确定删除？");
	}else{
		window.alert("没有选择条目");
    	return false;
	}
}
//
function CheckAll(){
	var frm = document.templateListForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>

<body>
<p><a href="main.php?do=photo_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加图片</a></p>
<form method="post" name="photoListForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>图片ID</td>
<td>名称</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['photos'])){
if (!is_array($_obj['photos']))
$_obj['photos']=array(array('photos'=>$_obj['photos']));
$_tmp_arr_keys=array_keys($_obj['photos']);
if ($_tmp_arr_keys[0]!='0')
$_obj['photos']=array(0=>$_obj['photos']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['photos'] as $rowcnt=>$photos) {
$photos['ROWCNT']=$rowcnt;
$photos['ALTROW']=$rowcnt%2;
$photos['ROWBIT']=$rowcnt%2;
$_obj=&$photos;
?>
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="photo_id[]" value="<?php
echo $_obj['id'];
?>
"></td>
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href=<?php
echo $_obj['path'];
?>
><?php
echo $_obj['name'];
?>
</a></td>
<td><a href="main.php?do=photo_delete&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p=<?php
echo $_obj['p'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a> 　<a href="main.php?do=photo_modify&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p=<?php
echo $_obj['p'];
?>
">修改</a></td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
<input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
<INPUT TYPE="checkbox" NAME="chkall" onclick="CheckAll()"> 全选/取消
<input type="submit" value="删除选中">
</form>
<?php
echo $_obj['pagebar'];
?>

<form action="main.php?do=photo_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p=<?php
echo $_obj['p'];
?>
"  method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p" id="p" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>
</body>
</html>