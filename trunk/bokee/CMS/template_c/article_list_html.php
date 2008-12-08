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
<script language="JavaScript" src="dateControl.js"></script>
<SCRIPT LANGUAGE="javascript" type="text/javascript">
/**********************************************************************/
/* 函数：changeCondition                                              */
/* 参数：                                                             */
/* 功能：改变搜索类型                                                 */
/* 返回值：                                                           */
/**********************************************************************/	
function FP_changeProp() {//v1.0
 var args=arguments,d=document,i,j,id=args[0],o=FP_getObjectByID(id),s,ao,v,x;
 d.$cpe=new Array(); if(o) for(i=2; i<args.length; i+=2) { v=args[i+1]; s="o";
 ao=args[i].split("."); for(j=0; j<ao.length; j++) { s+="."+ao[j]; if(null==eval(s)) {
  s=null; break; } } x=new Object; x.o=o; x.n=new Array(); x.v=new Array();
 x.n[x.n.length]=s; eval("x.v[x.v.length]="+s); d.$cpe[d.$cpe.length]=x;
 if(s) eval(s+"=v"); }
}

function FP_getObjectByID(id,o) {//v1.0
 var c,el,els,f,m,n; if(!o)o=document; if(o.getElementById) el=o.getElementById(id);
 else if(o.layers) c=o.layers; else if(o.all) el=o.all[id]; if(el) return el;
 if(o.id==id || o.name==id) return o; if(o.childNodes) c=o.childNodes; if(c)
 for(n=0; n<c.length; n++) { el=FP_getObjectByID(id,c[n]); if(el) return el; }
 f=o.forms; if(f) for(n=0; n<f.length; n++) { els=f[n].elements;
 for(m=0; m<els.length; m++){ el=FP_getObjectByID(id,els[n]); if(el) return el; } }
 return null;
}

function change(myform)
{
  if (document.rss_article_list_serch.Serch_condition.value == "Null")
   {
   FP_changeProp(/*id*/'datetime',0,'style.display','none');
   FP_changeProp(/*id*/'title',0,'style.display','none');
   FP_changeProp(/*id*/'source',0,'style.display','none');
   }
 else if(document.rss_article_list_serch.Serch_condition.value == "datetime")
   {
   FP_changeProp(/*id*/'datetime',0,'style.display','block');
   FP_changeProp(/*id*/'title',0,'style.display','none');
   FP_changeProp(/*id*/'source',0,'style.display','none');
   }
  else if(document.rss_article_list_serch.Serch_condition.value == "title")
  {
   FP_changeProp(/*id*/'datetime',0,'style.display','none');
   FP_changeProp(/*id*/'title',0,'style.display','block');
   FP_changeProp(/*id*/'source',0,'style.display','none');
    }
  else if(document.rss_article_list_serch.Serch_condition.value == "source")
  {
   FP_changeProp(/*id*/'datetime',0,'style.display','none');
   FP_changeProp(/*id*/'title',0,'style.display','none');
   FP_changeProp(/*id*/'source',0,'style.display','block');
  }
}
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
function Checkform1( e ){
	var frm = e;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
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
" target="_self">区块列表</a> | <a href="main.php?do=article_group_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">组文/组图列表</a>
|  <a href="main.php?do=rss_template_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加RSS模板</a> |  <a href="main.php?do=header_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加头条</a> |  <a href="main.php?do=header_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">头条列表</a>| <a href="main.php?do=flash_add_new&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" target="_self">添加flash头条</a> </p>
<?php
echo $_obj['pagebar'];
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p_rss=<?php
echo $_obj['p_rss'];
?>
&p=<?php
echo $_obj['p'];
?>
&chioce=20">20</a>&nbsp;&nbsp;
|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p_rss=<?php
echo $_obj['p_rss'];
?>
&p=<?php
echo $_obj['p'];
?>
&chioce=50">50</a>&nbsp;&nbsp;
|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&p_rss=<?php
echo $_obj['p_rss'];
?>
&p=<?php
echo $_obj['p'];
?>
&chioce=100">100</a>&nbsp;&nbsp;
|
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
<INPUT TYPE="checkbox" NAME="chkall" onClick="CheckAll()"> 全选/取消
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

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
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
&chioce_rss=20">20</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
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
&chioce_rss=50">50</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="main.php?do=article_list&channel_name=<?php
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
&chioce_rss=100">100</a>&nbsp;&nbsp;|
<br>
<form action="main.php?do=rss_article_list_serch" method = "POST" name="rss_article_list_serch">
 <select name="Serch_condition" onchange = "change(this.form)">
    <option value="Null">选择查询方式</option>
    <option value="datetime">发文时间</option>
    <option value="title">文章标题</option>
    <option value="source">文章来源</option>
  </select>
  <input name="datetime" type="text" size="20" maxlength="50" style="display:none" onFocus="calendar()">
  <input name="title" type="text" size="20" maxlength="50" style="display:none">
  <input name="source" type="text" size="20" maxlength="50" style="display:none">
<input type="submit" name="Submit" value="查找">
<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
<input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
</form>
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
echo $_obj['author'];
?>
</a></td>
<td><?php
echo $_obj['datetime'];
?>
</td>
<td>
<a href="#" onClick="window.open('main.php?do=rss_article_copy&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
','rss_transfer','height=600, width=1000, top=0,left=0, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">复制</a>&nbsp;&nbsp;
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
" onClick="javascript:return window.confirm('确定删除？');">删除</a> &nbsp;&nbsp;
<a href="#" onclick="window.open('main.php?do=article_rss_title_modify&id=<?php
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
','','width=400,height=300,menubar=no, scrollbars=yes, resizable=no,location=no, status=no')">修改</a></td>
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