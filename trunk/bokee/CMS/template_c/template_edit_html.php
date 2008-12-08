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
</Script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
　<a href="main.php?do=template_publish&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
">发布</a>
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
  	
  <form action="main.php?do=slash_do_edit" name="slash_edit_form" method="post" enctype='multipart/form-data'>
  	  
          <tr bgcolor="#FFFFFF"> 
            <td>碎片：<font color="red"><?php
echo $_obj['name'];
?>
</font><br>(<font color="Green"><?php
echo $_obj['category'];
?>
</font>)
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
