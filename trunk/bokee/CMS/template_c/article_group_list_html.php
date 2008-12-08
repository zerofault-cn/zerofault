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
	var frm = document.articleGroupListForm;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=article_group_delete";
		return window.confirm("确定删除？");
	}else{
		window.alert("没有选择条目");
    	return false;
	}
}
//
function CheckAll(){
	var frm = document.articleGroupListForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>

<body>
<p> 
<a href="main.php?do=article_group_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加组文/组图</a> </p>
<?php
echo $_obj['pagebar'];
?>

<form method="post" name="articleGroupListForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>ID</td>
<td>名称</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['article_group'])){
if (!is_array($_obj['article_group']))
$_obj['article_group']=array(array('article_group'=>$_obj['article_group']));
$_tmp_arr_keys=array_keys($_obj['article_group']);
if ($_tmp_arr_keys[0]!='0')
$_obj['article_group']=array(0=>$_obj['article_group']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['article_group'] as $rowcnt=>$article_group) {
$article_group['ROWCNT']=$rowcnt;
$article_group['ALTROW']=$rowcnt%2;
$article_group['ROWBIT']=$rowcnt%2;
$_obj=&$article_group;
?>
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="article_group_id[]" value="<?php
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
<td><a href="#" onClick="javascript:if(confirm('确定删除？')){location.href='main.php?do=article_group_delete&id=<?php
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
'};">删除</a> <a href="main.php?do=article_group_modify&id=<?php
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

<form action="main.php?do=article_group_list&channel_name=<?php
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