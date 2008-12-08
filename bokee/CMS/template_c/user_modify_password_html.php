<html>

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
<body onLoad="init()">
<form action="main.php?do=user_do_modify_password" name="form" method="post" enctype='multipart/form-data'>
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
 
  <tr>
    <td nowrap>旧密码</td>
    <td><input name="password" type="password" id="password" size="20" maxlength="20"><div class="error"><?php
echo $_obj['action_error_password'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>新密码</td>
    <td><input name="password_new" type="password" id="password_new" size="20" maxlength="20"> 
    <div class="error"><?php
echo $_obj['action_error_password_new'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>确认密码</td>
    <td><input name="password_new_re" type="password" id="password_new_re" size="20" maxlength="20"> 
    <div class="error"><?php
echo $_obj['action_error_password_new_diff'];
?>
</div></td>
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