<?php
if($Submit){
mail("zerofault@163.com","$subs","$bod");}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=??????">
<title>无标题文档</title>
</head>

<body>
<div align="center">
<table width="400" height="278" border="0">
<tr>
<td valign="top"><form name="form1" method="post" action="<? echo $php_self;?>">
<p align="center">邮件头: 
<input type="text" name="subs">
</p>
<p align="center"> 邮件主体: 
<input type="text" name="bod">
</p>
<p align="center">  </p>
<p align="center"> 
<input type="submit" name="Submit" value="提交">
<input type="reset" name="Submit2" value="重置">
</p>
</form></td>
</tr>
</table>
</div>
</body>
</html>
