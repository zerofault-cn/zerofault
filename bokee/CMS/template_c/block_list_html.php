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
		frm.action="main.php?do=block_delete";
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

<?php
echo $_obj['pagebar'];
?>

<form method="post" name="templateListForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>区块ID</td>
<td>区块名称</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['template_block'])){
if (!is_array($_obj['template_block']))
$_obj['template_block']=array(array('template_block'=>$_obj['template_block']));
$_tmp_arr_keys=array_keys($_obj['template_block']);
if ($_tmp_arr_keys[0]!='0')
$_obj['template_block']=array(0=>$_obj['template_block']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['template_block'] as $rowcnt=>$template_block) {
$template_block['ROWCNT']=$rowcnt;
$template_block['ALTROW']=$rowcnt%2;
$template_block['ROWBIT']=$rowcnt%2;
$_obj=&$template_block;
?>
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="block_id[]" value="<?php
echo $_obj['id'];
?>
"></td>
<td><?php
echo $_obj['id'];
?>
</td>
<td><?php
echo $_obj['name'];
?>
</td>
<td><a href="#" onClick="javascript:if(confirm('确定删除？')){location.href='main.php?do=block_delete&id=<?php
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
'};">删除</a> <a href="<?php
echo $_obj['link'];
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

<form action="main.php?do=template_list&channel_name=<?php
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