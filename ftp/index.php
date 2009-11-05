<?php

Setcookie("Ftp_Host");
Setcookie("Ftp_User");
Setcookie("Ftp_Pass");
Setcookie("Ftp_Port");
Setcookie("Have_Login");
?>
<meta http-equiv=Content-Type content=text/html; charset=gb2312>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>FTP登陆系统 </title>
<meta name="generator" Content="editplus">

<style>
input{font-family:tahoma,helvetica,宋体;font-size:12px;border:1px solid #6699cc;background-color:#e8f4ff; 	background-image: url(./img/input.gif);}
</style>
</head>

<body bgcolor="#023266">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="ftp" action="Super_Ftp.php" method="post">
<input type="hidden" name="action" value="login">
<table border="0" cellpadding="1" cellspacing="1"  align="center">
<tr>
<td>
<table border="0" cellspacing=0 cellpadding=5 align="center">
<tr >
<td width="75" align="right" bgcolor="#006666">
<font face="Tahoma" size="-1" color=#99CC99>
FTP://
</font>
</td>
<td  bgcolor="#006666">
<font face="Tahoma" size="-1">
<input type="text" size=15 name="Ftp_Host" value="" style="color: green">
</font>
</td>
</tr>

<tr bgcolor="#dddddd">
<td align="right" bgcolor="#ffe98e">
<font face="Tahoma" size="-1">
LOGIN:
</font>
</td>
<td bgcolor="#ffe98e">
<font face="Tahoma" size="-1">
<input type="text" size="15" name="Ftp_User" maxlength="20" value="anonymous" style="color:#074EF1">
</font>
</td>
</tr>
<tr >
<td align="right" bgcolor="#ffe98e">
<font face="Tahoma" size="-1">
PASSWORD:
</font>
</td>
<td bgcolor="#ffe98e">
<font face="Tahoma" size="-1">
<input type="password" size="15" name="Ftp_Pass" maxlength="20"  style="color:#074EF1" value="">
</font>
</td>
</tr>
<tr bgcolor="#bbbbbb">
<td align="right" bgcolor="#006666">
<font face="Tahoma" size="-1">
PORT:
</font>
</td>
<td bgcolor="#006666">
<font face="Tahoma" size="-1"> 
<input type="text" size="15" name="Ftp_Port" maxlength="20" value="21" style="color: green">
</font></td>
</tr>
<tr bgcolor="#ffffff">
<td colspan="2" align="center">
<font face="Tahoma" size="-2">
<input type="submit" value="login">
<input type=reset value="reset"><br>
power by xltxlm
</font></td></tr></table></td></tr></table></form>



</body>
</html>
