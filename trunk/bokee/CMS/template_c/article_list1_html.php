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
function Checkform( e ){
	var frm = e;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=article_delete_group";
		return window.confirm("确定删除？");
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
function RssCheckAll(){
	var frm = document.articleRssDeleteGroupForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>

<body>

<p><a href="main.php?do=article_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p=<?php
echo $_obj['p'];
?>
" target="_self">添加新文章</a> | <a href="main.php?do=template_new_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加模板</a> | <a href="main.php?do=template_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">模板列表</a> | <a href="main.php?do=block_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">区块列表</a> |  <a href="main.php?do=rss_template_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加RSS模板</a></p>
<?php
echo $_obj['pagebar'];
?>

<form method="post" name="articleDeleteGroupForm" onSubmit="return Checkform(this)">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>文章ID</td>
<td>文章标题</td>
<td>发表时间</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['articles'])){
if (!is_array($_obj['articles']))
$_obj['articles']=array(array('articles'=>$_obj['articles']));
$_tmp_arr_keys=array_keys($_obj['articles']);
if ($_tmp_arr_keys[0]!='0')
$_obj['articles']=array(0=>$_obj['articles']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['articles'] as $rowcnt=>$articles) {
$articles['ROWCNT']=$rowcnt;
$articles['ALTROW']=$rowcnt%2;
$articles['ROWBIT']=$rowcnt%2;
$_obj=&$articles;
?>
<tr bgcolor="<?php
echo $_obj['bgcolor'];
?>
">
<td><input type="checkbox" name="article_id[]" value="<?php
echo $_obj['id'];
?>
"></td>
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="<?php
echo $_obj['remote_url'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
<td><?php
echo $_obj['create_time'];
?>
</td>
<td><a href="main.php?do=article_delete&id=<?php
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
&p_rss=<?php
echo $_obj['p_rss'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a> <a href="main.php?do=article_modify&id=<?php
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
&p_rss=<?php
echo $_obj['p_rss'];
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

<form action="main.php?do=article_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p=<?php
echo $_obj['p'];
?>
&p_rss=<?php
echo $_obj['p_rss'];
?>
" name="articleRssListForm" method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p" id="p" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>
<hr>
<?php
echo $_obj['pagebar_rss'];
?>

<?php
echo $_obj['rss_begin'];
?>

<?php
if (!empty($_obj['articles_rss'])){
if (!is_array($_obj['articles_rss']))
$_obj['articles_rss']=array(array('articles_rss'=>$_obj['articles_rss']));
$_tmp_arr_keys=array_keys($_obj['articles_rss']);
if ($_tmp_arr_keys[0]!='0')
$_obj['articles_rss']=array(0=>$_obj['articles_rss']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['articles_rss'] as $rowcnt=>$articles_rss) {
$articles_rss['ROWCNT']=$rowcnt;
$articles_rss['ALTROW']=$rowcnt%2;
$articles_rss['ROWBIT']=$rowcnt%2;
$_obj=&$articles_rss;
?>
<tr bgcolor="<?php
echo $_obj['bgcolor'];
?>
">
<td><input type="checkbox" name="article_id[]" value="<?php
echo $_obj['id'];
?>
"></td>
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="<?php
echo $_obj['url'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
<td><?php
echo $_obj['datetime'];
?>
</td>
<td>
<a href="#" onClick="window.open('main.php?do=rss_article_local_transfer&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
','rss_transfer','height=600, width=1000, top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">转移</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="main.php?do=rel_article_delete&id=<?php
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
&p_rss=<?php
echo $_obj['p_rss'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php?do=article_rss_title_modify&id=<?php
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
&p_rss=<?php
echo $_obj['p_rss'];
?>
">修改</a></td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
<?php
echo $_obj['rss_end'];
?>

<?php
echo $_obj['pagebar_rss'];
?>

</body>
</html>