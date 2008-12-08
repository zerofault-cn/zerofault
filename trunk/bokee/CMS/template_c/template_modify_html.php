<html>
<head>
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
textarea {
	font-size:12px;
}
-->
</style>
<Script>
function repImage()
{
	name = window.prompt("请输入名称","");
	if(name!="null")
	{
		document.getElementById("rep_content").value = document.selection.createRange().text;
		document.selection.createRange().text="[[##]]";
		document.getElementById("rep_category").value = "image";
		document.forms[0].rep_name.value = name;
		document.forms[0].submit();
	}
	else
		return ;
}
function repText()
{
	name = window.prompt("请输入名称","");
	if(name!="null")
	{
		document.getElementById("rep_content").value = document.selection.createRange().text;
		document.selection.createRange().text="[[##]]";
		document.getElementById("rep_category").value = "text";
		document.forms[0].rep_name.value = name;
		document.forms[0].submit();
	}
	else
		return ;
}
function repBlock()
{
	name = window.prompt("请输入名称","");
	if(name!="null")
	{
		document.getElementById("rep_content").value = document.selection.createRange().text;
		document.selection.createRange().text="[[##]]";
		document.getElementById("rep_category").value = "block";
		document.forms[0].rep_name.value = name;
		document.forms[0].submit();
	}
	else
		return ;
}
function repAd()
{
	name = window.prompt("请输入名称","");
	if(name!="null")
	{
		document.getElementById("rep_content").value = document.selection.createRange().text;
		document.selection.createRange().text="[[##]]";
		document.getElementById("rep_category").value = "ad";
		document.forms[0].rep_name.value = name;
		document.forms[0].submit();
	}
	else
		return ;
}
function createOption(value,text,selected_value)
{
		var newOpt	= document.createElement('OPTION'); 
		newOpt.setAttribute('value',value); 
		newOpt.innerHTML = text; 
		if( value == selected_value )
		newOpt.setAttribute('selected',true);
		document.forms[0].select_block.appendChild(newOpt);
}
</Script>
</head>
<body bgcolor="#FFFFFF" text="#000000">

      <form action="main.php?do=template_do_modify" name="template_modify_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC">
          <tr bgcolor="#FFFFFF"> 
            <tr bgcolor="#FFFFFF"> 
            <td>模板名称：</td>
            <td> 
              <input name="name" type="text" value="<?php
echo $_obj['name'];
?>
" maxlength="20"><?php
echo $_obj['action_error_template_name'];
?>
　　　　　　<a href="main.php?do=template_publish&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
">发布</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <a href=# onclick="window.open('main.php?do=template_preview&id=<?php
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
','preview','width=800,height=600,scrollbars=1')">预览</a>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>生成文件名称：</td>
            <td> 
              <input name="file_name" type="text" value="<?php
echo $_obj['file_name'];
?>
" maxlength="40">              
              <?php
echo $_obj['action_error_template_file_name'];
?>

                  是否设为默认模板：
              <select name="defaulttlist" style="font-size:14;width:120">
			    <?php
if (!empty($_obj['defaulttlist'])){
if (!is_array($_obj['defaulttlist']))
$_obj['defaulttlist']=array(array('defaulttlist'=>$_obj['defaulttlist']));
$_tmp_arr_keys=array_keys($_obj['defaulttlist']);
if ($_tmp_arr_keys[0]!='0')
$_obj['defaulttlist']=array(0=>$_obj['defaulttlist']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['defaulttlist'] as $rowcnt=>$defaulttlist) {
$defaulttlist['ROWCNT']=$rowcnt;
$defaulttlist['ALTROW']=$rowcnt%2;
$defaulttlist['ROWBIT']=$rowcnt%2;
$_obj=&$defaulttlist;
?>
                <option value="<?php
echo $_obj['id'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['id'];
?>
</option>
				<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
              </select>
			  
			   是否需要更多页：
              <select name="is_more" style="font-size:14;width:120">
			    <?php
if (!empty($_obj['is_more'])){
if (!is_array($_obj['is_more']))
$_obj['is_more']=array(array('is_more'=>$_obj['is_more']));
$_tmp_arr_keys=array_keys($_obj['is_more']);
if ($_tmp_arr_keys[0]!='0')
$_obj['is_more']=array(0=>$_obj['is_more']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['is_more'] as $rowcnt=>$is_more) {
$is_more['ROWCNT']=$rowcnt;
$is_more['ALTROW']=$rowcnt%2;
$is_more['ROWBIT']=$rowcnt%2;
$_obj=&$is_more;
?>
                <option value="<?php
echo $_obj['id'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['id'];
?>
</option>
				<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
              </select>
			  
			  </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>模板内容：</td>
            <td> 
            <textarea name="content" cols="100" rows="30" id="content"><?php
echo $_obj['content'];
?>
</textarea>
            <?php
echo $_obj['action_error_template_content'];
?>

            <br>
            <input name="rep_name" type="hidden" value="<?php
echo $_obj['rep_name'];
?>
">
            <input type="button" name="rep_image" onclick="repImage()" value="替换图片">
            <input type="button" name="rep_text" onclick="repText()" value="替换文本">
            <input type="button" name="rep_ad" onclick="repAd()" value="替换广告">
            <select name="select_block" id="select_block">
			<?php
echo $_obj['options'];
?>

	      </select>
            <input type="button" name="rep_block" onclick="repBlock()" value="替换区块"><br><br>
			<input type="button" name="add_block" onclick="window.open('main.php?do=block_new_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
','','width=1000,height=600')" value="添加区块">
			<input type="button" name="add_block" onclick="window.open('main.php?do=block_photo_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
','','width=1000,height=600')" value="添加图片区块">
			<input type="button" name="add_block" onclick="window.open('main.php?do=block_hotcomment_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
','','width=1000,height=600')" value="添加热评区块">
            </td>
          </tr>
        
          <tr bgcolor="#FFFFFF" align="center"> 
            <td colspan="2"> 
            <input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
">
            <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
            <input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
            <input type="hidden" id="rep_content" name="rep_content" value="<?php
echo $_obj['rep_content'];
?>
">
            <input type="hidden" id="rep_category" name="rep_category" value="<?php
echo $_obj['rep_category'];
?>
">
              <input type="submit" name="Submit" value="修改">
            </td>
          </tr>
        </table>
      </form>

      <table>
      	<tr bgcolor="#FFFFFF">
  	  	<td><font color=red>点击碎片名称修改:</font></td>
  	  	<td></td>
  	  </tr>
  <?php
if (!empty($_obj['slashes'])){
if (!is_array($_obj['slashes']))
$_obj['slashes']=array(array('slashes'=>$_obj['slashes']));
$_tmp_arr_keys=array_keys($_obj['slashes']);
if ($_tmp_arr_keys[0]!='0')
$_obj['slashes']=array(0=>$_obj['slashes']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['slashes'] as $rowcnt=>$slashes) {
$slashes['ROWCNT']=$rowcnt;
$slashes['ALTROW']=$rowcnt%2;
$slashes['ROWBIT']=$rowcnt%2;
$_obj=&$slashes;
?>
  	
  <form action="main.php?do=slash_do_modify" name="slash_modify_form" method="post" enctype='multipart/form-data'>
  	  
          <tr bgcolor="#FFFFFF"> 
            <td>碎片：<font color="red"><a href style="cursor:hand" onClick="javascript:window.open('main.php?do=slash_name_modify&channel_name=<?php
echo $_obj['channel_name'];
?>
&slash_id=<?php
echo $_obj['id'];
?>
','slash_name_modify','width=400,height=300')"><?php
echo $_obj['name'];
?>
</a></font><br>(<font color="Green"><?php
echo $_obj['category'];
?>
</font>) <a href="#"  onClick="if(confirm('确定删除？')){location.href='main.php?do=slash_delete&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
&template_id=<?php
echo $_obj['template_id'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
'};">删除</a>
			<br>排序:<input name = "taxis" type=text value="<?php
echo $_obj['taxis'];
?>
" size="4" maxlength="4">
            <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
            <input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
">
            <input type="hidden" name="template_id" value="<?php
echo $_obj['template_id'];
?>
">
            <input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
            <input type="submit" name="Submit" value="修改">
            </td>
            <td> 
            <?php
echo $_obj['edit'];
?>

             
            </td>
          </tr>
          </form>
          <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
          </table>
          
</BODY>
</HTML>
