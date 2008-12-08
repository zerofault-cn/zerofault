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
<script language="JavaScript"">
function ShowMenu(MenuID) 
{ 
if(MenuID.style.display=="none") 
{ 
MenuID.style.display=""; 
} 
else 
{ 
MenuID.style.display="none"; 
} 
} 
</script> 

<body bgcolor="#FFFFFF" text="#000000">
<?php
echo $_obj['op'];
?>

<p>
<form name="serch" method="POST" action="main.php?do=subject_serch_do">
查询:
<select name="select">
  <option value="1" selected>按标题查询</option>
  <option value="2">按URL查询</option>
</select>
<input name= "serch_contact" type="text">
<input name= "channel_name" type="hidden" value = "<?php
echo $_obj['channen_name'];
?>
">
<input name="submit" type="submit" value="查询">[按跳转文章URL地址查询]
</p>
<table width="80%"  border="0" cellpadding="10" cellspacing="1" bgcolor="C1D7F4">

<tr bgcolor="#F0F4FF"> 
<td>
<?php
if (!empty($_obj['subjects'])){
if (!is_array($_obj['subjects']))
$_obj['subjects']=array(array('subjects'=>$_obj['subjects']));
$_tmp_arr_keys=array_keys($_obj['subjects']);
if ($_tmp_arr_keys[0]!='0')
$_obj['subjects']=array(0=>$_obj['subjects']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['subjects'] as $rowcnt=>$subjects) {
$subjects['ROWCNT']=$rowcnt;
$subjects['ALTROW']=$rowcnt%2;
$subjects['ROWBIT']=$rowcnt%2;
$_obj=&$subjects;
?>
<?php
echo $_obj['name'];
?>
 目录名:<?php
echo $_obj['dir_name'];
?>
 <?php
echo $_obj['operations'];
?>
<br>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?></td>
</tr>

</table>
</body>
</html>
