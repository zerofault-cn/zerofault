<html>
<script language="javascript">
function init_upload()
{
     var role_num = document.getElementById('role_name').value;
	 if(role_num==0||role_num==1)
	 {
	         document.all.modelTR.style.display= "none";
	 }else
	 {
	 	document.all.modelTR.style.display= "";
	 }
}
function CheckAll(){
	var frm = document.getElementsByName("select_channel[]");
  	for(var ii=0;ii<frm.length;ii++){
    	var e=frm[ii];
       	e.checked = document.all.chkall.checked;
  }
}
</script>
<style type="text/css">
<!--
table {
	font-size: 14px;
}
input {
	height:20px;
}
.error {
color: red;
}
-->
</style>
<body onLoad="init_upload()">
<form action="main.php?do=user_do_modify" name="form" method="post" enctype='multipart/form-data'>
<input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
">
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
  <tr>
    <td nowrap>用户名</td>
    <td width="89%"><input name="username" type="text" id="username" size="20" maxlength="20" value="<?php
echo $_obj['username'];
?>
"> <div class="error"><?php
echo $_obj['action_error_username'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>真实姓名</td>
    <td><input name="real_name" type="text" id="real_name" size="20" maxlength="20" value="<?php
echo $_obj['real_name'];
?>
"> 
      <div class="error"><?php
echo $_obj['action_error_real_name'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>权限</td>
    <td><select name="role_name" onChange="init_upload()" id="role_name">
    <?php
if (!empty($_obj['role'])){
if (!is_array($_obj['role']))
$_obj['role']=array(array('role'=>$_obj['role']));
$_tmp_arr_keys=array_keys($_obj['role']);
if ($_tmp_arr_keys[0]!='0')
$_obj['role']=array(0=>$_obj['role']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['role'] as $rowcnt=>$role) {
$role['ROWCNT']=$rowcnt;
$role['ALTROW']=$rowcnt%2;
$role['ROWBIT']=$rowcnt%2;
$_obj=&$role;
?>
      <option value="<?php
echo $_obj['id'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
	  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
    </select> <div class="error"><?php
echo $_obj['action_error_role'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>电子邮件</td>
    <td><input name="email" type="text" id="email" size="20" maxlength="30" value="<?php
echo $_obj['email'];
?>
"> 
      <div class="error"><?php
echo $_obj['action_error_email'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>手机</td>
    <td><input name="cellphone" type="text" id="cellphone" size="20" maxlength="20" value="<?php
echo $_obj['cellphone'];
?>
"> 
      <div class="error"><?php
echo $_obj['action_error_cellphone'];
?>
</div></td>
  </tr>
 <tr  name="modelTR" id="modelTR">
    <td nowrap>频道</td>
    <td>
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
    <input type="checkbox" name="select_channel[]" value="<?php
echo $_obj['id'];
?>
" <?php
echo $_obj['checked'];
?>
><?php
echo $_obj['name'];
?>
<?php
echo $_obj['br'];
?>

	  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	  </select>
	  <br><INPUT TYPE="checkbox" NAME="chkall" onclick="CheckAll()"> 全选/取消</td>
        </td>
  </tr> 
  <tr>
    <td nowrap>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td><input name="Submit_pub" type="submit" id="Submit_pub" value="修改">
      <input name="Submit_reset" type="reset" id="Submit_reset" value="重置"></td>
  </tr>
</table>
</form>
</body>
</html>