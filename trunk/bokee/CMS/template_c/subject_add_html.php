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

<body bgcolor="#FFFFFF" text="#000000">
<table width="90%" border="1" align="center" cellpadding="20" bordercolor="C1D7F4">
  <tr>
    <td><table width="98%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td width="100" bgcolor="C1D7F4" align="center">栏目添加</td>
        <td >&nbsp;</td>
      </tr>
      <tr bgcolor="C1D7F4">
        <td height="1"></td>
        <td height="1"></td>
        <td height="1"></td>
      </tr> 
    </table>
  
<table width="80%" border="0" cellspacing="2" cellpadding="10" bgcolor="#c1d7f4" align="center">
  <tr> 
    <td bgcolor="#FFFFFF"> 
      <form action="main.php?do=subject_do_add" name="subject_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC">
          <tr bgcolor="#FFFFFF"> 
            <tr bgcolor="#FFFFFF"> 
            <td>栏目名称：</td>
            <td> 
              <input name="name" type="text" value="<?php
echo $_obj['name'];
?>
" maxlength="20"><?php
echo $_obj['action_error_subject_name'];
?>

            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>栏目目录：</td>
            <td> 
              <input name="dir_name" type="text" value="<?php
echo $_obj['dir_name'];
?>
" maxlength="20"><?php
echo $_obj['action_error_subject_dir'];
?>

            </td>
          </tr>
		  <tr bgcolor="#FFFFFF"> 
            <td valign="top">上级栏目：</td>
            <td> 
              <select name="parentid" style="font-size:14;width:120">
                <option value="0" >---顶级频道---</option>
                <?php
if (!empty($_obj['subject_1'])){
if (!is_array($_obj['subject_1']))
$_obj['subject_1']=array(array('subject_1'=>$_obj['subject_1']));
$_tmp_arr_keys=array_keys($_obj['subject_1']);
if ($_tmp_arr_keys[0]!='0')
$_obj['subject_1']=array(0=>$_obj['subject_1']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['subject_1'] as $rowcnt=>$subject_1) {
$subject_1['ROWCNT']=$rowcnt;
$subject_1['ALTROW']=$rowcnt%2;
$subject_1['ROWBIT']=$rowcnt%2;
$_obj=&$subject_1;
?>
                <option value="<?php
echo $_obj['subid'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['prefix'];
?>
<?php
echo $_obj['name'];
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
            <td valign="top">滚动方式：</td>
            <td> 
              <select name="cateid" style="font-size:14;width:120">
                <option value="0" <?php
echo $_obj['selected'];
?>
>只显示此栏目下文章</option>
                <option value="1" <?php
echo $_obj['selected'];
?>
>全频道文章滚动</option>
              </select>
</td>
          </tr>
          <tr bgcolor="#FFFFFF" align="center"> 
            <td colspan="2"> 
            <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
			
              <input type="submit" name="Submit" value="添加">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</BODY>
</HTML>
