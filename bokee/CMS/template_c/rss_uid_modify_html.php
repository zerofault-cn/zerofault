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
<form action="main.php?do=rss_uid_do_modify" name="form" method="post" enctype='multipart/form-data'>
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
 
  <tr>
    <td nowrap>RSS用户ID</td>
    <td><input name="rss_uid" type="text" id="rss_uid" size="20" maxlength="20" value="<?php
echo $_obj['rss_uid'];
?>
"><div class="error"><?php
echo $_obj['action_error_password'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td>(可以添加RSSID，记得用半角的“,”分隔开。例如两个 123,124, 三个就是123,124,125)</td>
  </tr>
  <tr>
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