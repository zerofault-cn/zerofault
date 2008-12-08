<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>博客网CMS系统</title>
<style type="text/css">
<!--
form {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	padding:30px 30px;
	margin:30px 300px;
	border:1px solid green;
	background-color:#eeeeee;
	text-align:center;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<h1 align="center">博客网CMS系统</h1>
<h2 align="center">用户登录</h2>
<center><?php
echo $_obj['action_error_notice'];
?>
</center>
<form name="login" method="post" action="main.php?do=login">
  <p>用户名
      <input name="username" type="text" size="20" maxlength="20" value="<?php
echo $_obj['username'];
?>
"> <?php
echo $_obj['action_error_username'];
?>

    </p>
  <p>密　码
      <input name="password" type="password" size="20" maxlength="20" value="<?php
echo $_obj['password'];
?>
"> <?php
echo $_obj['action_error_password'];
?>

</p>
<input name="back_url" type="hidden" id="back_url" value="<?php
echo $_obj['back_url'];
?>
" />
  <p>
    <input type="submit" name="Submit" value="提交">
    <input type="reset" name="Submit2" value="取消">
</p>
</form>
<p align="center">版本 0.1 copyright bokee.com </p>
</body>

</html>
