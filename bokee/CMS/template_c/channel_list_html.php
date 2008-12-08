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
	var frm = document.channelListForm;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=channel_delete";
		return window.confirm("确定删除？");
	}else{
		window.alert("没有选择条目");
    	return false;
	}
}
//
function CheckAll(){
	var frm = document.channelListForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>
<body>
<p><a href="main.php?do=channel_add" target="_self">添加新频道</a></p>
<?php
echo $_obj['pagebar'];
?>

<form method="post" name="channelListForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>频道ID</td>
<td>频道名称</td>
<td>频道目录</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['channel'])){
if (!is_array($_obj['channel']))
$_obj['channel']=array(array('channel'=>$_obj['channel']));
$_tmp_arr_keys=array_keys($_obj['channel']);
if ($_tmp_arr_keys[0]!='0')
$_obj['channel']=array(0=>$_obj['channel']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['channel'] as $rowcnt=>$channel) {
$channel['ROWCNT']=$rowcnt;
$channel['ALTROW']=$rowcnt%2;
$channel['ROWBIT']=$rowcnt%2;
$_obj=&$channel;
?>
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="channel_id[]" value="<?php
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
<td><?php
echo $_obj['dir_name'];
?>
</td>
<td><a href="main.php?do=channel_delete&id=<?php
echo $_obj['id'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a></td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
<INPUT TYPE="checkbox" NAME="chkall" onclick="CheckAll()"> 全选/取消
<input type="submit" value="删除选中">
</form>
<?php
echo $_obj['pagebar'];
?>

<form action="main.php?do=channel_list"  method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p" id="p" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>
</body>
</html>