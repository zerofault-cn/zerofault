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
<body>
<form action="main.php?do=channel_do_add" name="article_form" method="post" enctype='multipart/form-data'>
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
  <tr>
    <td nowrap>频道名</td>
    <td width="89%"><input name="name" type="text" id="name" size="20" maxlength="20" value="<?php
echo $_obj['name'];
?>
"> <div class="error"><?php
echo $_obj['action_error_name'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>频道目录</td>
    <td><input name="dir_name" type="text" id="dir_name" size="20" maxlength="20" value="<?php
echo $_obj['dir_name'];
?>
"> 
    <div class="error"><?php
echo $_obj['action_error_dir_name'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td><input name="Submit_pub" type="submit" id="Submit_pub" value="添加">
      <input name="Submit_reset" type="reset" id="Submit_reset" value="重置"></td>
  </tr>
</table>
</form>
</body>
</html>