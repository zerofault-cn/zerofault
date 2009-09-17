<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
body{
	background-color:#FFFFFF;
}
table{
	background-color:transparent;
}
table#login{
	position:absolute;
	top:50%;
	left:50%;
	margin:-130px 0 0 -260px;
}
.text {
	color:#006699;
	font-family:"Verdana","Arial","Helvetica","sans-serif";
	font-size:10px;
	font-style:normal;
	height:18px;
	line-height:12px;
}
label {
	font-family:Arial,Helvetica,sans-serif;
	font-size:12px;
}
</style>
<table id="login" height="265" cellspacing="0" cellpadding="0" border="0" width="525">
<tr>
	<td background="../Public/Images/login_bg.png">
	<form method="post" action="__APP__/Public/checkLogin" target="_iframe">
	<table height="221" cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td height="40" width="297"> </td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td height="25"> </td>
		<td width="65">User ID : </td>
		<td width="133"><input type="text" maxlength="20" size="18" value="admin" class="text" tabindex="1" name="name"/></td>
	</tr>
	<tr>
		<td height="25"> </td>
		<td>Password : </td>
		<td><input type="password" maxlength="15" size="18" value="admin" tabindex="2" class="text" name="password"/></td>
	</tr>
	<tr>
		<td rowspan="2"> </td>
		<td height="11" colspan="2"><!-- <label><input type="checkbox" value="yes" id="signed" tabindex="3" name="signed"/>Keep me signed in.</label> --></td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
			<a href="#"><img height="27" border="0" width="83" tabindex="5" src="../Public/Images/loginGetpw.gif"/></a> 
			<input type="image" tabindex="4" src="../Public/Images/loginLogin.gif" value="submit" name="imageField"/></td>
	</tr>
	</table>
	</form>
	</td>
</tr>
</table>