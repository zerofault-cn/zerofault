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

<?php
echo $_obj['pagebar'];
?>

<form method="post" name="articleDeleteGroupForm" onSubmit="return Checkform()">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>ID</td>
<td>内容源</td>
<td>栏目</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['mapping'])){
if (!is_array($_obj['mapping']))
$_obj['mapping']=array(array('mapping'=>$_obj['mapping']));
$_tmp_arr_keys=array_keys($_obj['mapping']);
if ($_tmp_arr_keys[0]!='0')
$_obj['mapping']=array(0=>$_obj['mapping']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['mapping'] as $rowcnt=>$mapping) {
$mapping['ROWCNT']=$rowcnt;
$mapping['ALTROW']=$rowcnt%2;
$mapping['ROWBIT']=$rowcnt%2;
$_obj=&$mapping;
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
<td><a href="http://rss.bokee.com/feed.<?php
echo $_obj['feed_id'];
?>
.html" target="_blank"><?php
echo $_obj['feed_title'];
?>
</a></td>
<td><?php
echo $_obj['subject_title'];
?>
 (<?php
echo $_obj['subject_id'];
?>
)</td>
<td><a href="main.php?do=feed_attach_delete&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
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