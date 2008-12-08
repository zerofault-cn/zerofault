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
	var frm = document.feedArticleCopyGroupForm;
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
	var frm = document.feedArticleCopyGroupForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall'){
       		e.checked = frm.chkall.checked;
			if( 'checkbox' == e.type){
       			changeItem(e);
       		}
		}
  }
}
function validator(){
	var tag = 0;
	var frm = document.feedArticleCopyGroupForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall'){
       		if(e.checked){
       			tag = 1;
       		}
       	}
    }  	
    if( 0 == tag ){
    	alert("请先选择文章!");
    	return(false);
    }
    else{
    	return(true);
    }
}
var rss_string = "";
function changeItem(item){
	if( "" != rss_string )
	{
		if( item.checked )
		{
			if( -1 == rss_string.indexOf( item.value ) )
		        {
				rss_string = rss_string + "||"+ item.value;
			}
		}
		else
		{
			if( -1 != rss_string.indexOf( item.value ) )
		          {
		          	var tmp_res = "";
		          	rss_array = rss_string.split("||");
		          	for(var ii=0;ii<rss_array.length;ii++)
		          	{
		          		if( rss_array[ii] == item.value )
		          		{
		          			continue;
		          		}
		          		else
		          		{
		          			tmp_res += rss_array[ii] + "||";
		          		}
		          	}
		          	rss_string = tmp_res.substring(0,tmp_res.length-2);
		          }
		          if(rss_string == item.value)
		          {
		          	rss_string = "";
		          }
		}
	}
	else
	{
		if( item.checked )
		{
			rss_string = item.value;
		}
	}
}
</script>

<body>
<p><input type="button" name="附加内容源到栏目" value="附加内容源到栏目" onClick="javascrpt:window.open('main.php?do=feed_attach_to_subject&feed_id=<?php
echo $_obj['feed_id'];
?>
', '附加内容源到栏目', 'height=500, width=400, top=100,left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no') ">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="更新内容" value="更新内容" onClick="javascrpt:window.open('http://rss.bokee.com/main.php?do=updateContent&feed_id=<?php
echo $_obj['feed_id'];
?>
', '更新内容', 'height=200, width=300, top=100,left=100, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no') ">

</p>
<?php
echo $_obj['pagebar'];
?>

<form method="post" name="feedArticleCopyGroupForm" onSubmit="return Checkform()">
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
<tr bgcolor="#FFFFFF">
<td><input type="checkbox" name="article_id[]" value="<?php
echo $_obj['id'];
?>
" onClick="javascrpt:changeItem(this)"></td>
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
echo $_obj['date_time'];
?>
</td>
<td><?php
echo $_obj['view_record'];
?>
</td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
<INPUT TYPE="checkbox" NAME="chkall" onclick="CheckAll()"> 全选/取消
<input type="button" value="转移到其他栏目" onClick="javascript:if(validator()){window.open('main.php?do=feed_article_transfer&feed_string=' + rss_string,'rss_transfer','height=600, width=1000, top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')}">
</form>
<?php
echo $_obj['pagebar'];
?>

<form action="main.php?do=feed_article_list&feed_id=<?php
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