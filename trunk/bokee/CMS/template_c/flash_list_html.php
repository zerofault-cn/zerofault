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
	var frm = document.articleDeleteGroupForm;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=feed_article_copy_group";
		return window.confirm("确定复制？");
	}else{
		window.alert("没有选择条目");
    	return false;
	}
}
//
function CheckAll(){
	var frm = document.articleDeleteGroupForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>

<body>
</p><a href="main.php?do=flash_add&channel_name=<?php
echo $_obj['channel_name'];
?>
">添加flash头图</a></p>
<?php
echo $_obj['pagebar'];
?>

<form method="post" name="feedArticleCopyGroupForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>ID</td>
<td>名称</td>
<td>路径</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['flash'])){
if (!is_array($_obj['flash']))
$_obj['flash']=array(array('flash'=>$_obj['flash']));
$_tmp_arr_keys=array_keys($_obj['flash']);
if ($_tmp_arr_keys[0]!='0')
$_obj['flash']=array(0=>$_obj['flash']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['flash'] as $rowcnt=>$flash) {
$flash['ROWCNT']=$rowcnt;
$flash['ALTROW']=$rowcnt%2;
$flash['ROWBIT']=$rowcnt%2;
$_obj=&$flash;
?>
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="article_id[]" value="<?php
echo $_obj['id'];
?>
"></td>
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="main.php?do=flash_edit&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['name'];
?>
</a></td>
<td><?php
echo $_obj['path'];
?>
</td>
<td><a href="main.php?do=flash_delete&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
">删除</a></td>
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

<form action="main.php?do=rss_article_list&feed_id=<?php
echo $_obj['feed_id'];
?>
&p=<?php
echo $_obj['p'];
?>
" name="rssArticleListForm" method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p" id="p" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>
</body>
</html>