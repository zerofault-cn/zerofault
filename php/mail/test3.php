<?php
if($Submit){
mail("zerofault@163.com","$subs","$bod");}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=??????">
<title>�ޱ����ĵ�</title>
</head>

<body>
<div align="center">
<table width="400" height="278" border="0">
<tr>
<td valign="top"><form name="form1" method="post" action="<? echo $php_self;?>">
<p align="center">�ʼ�ͷ: 
<input type="text" name="subs">
</p>
<p align="center"> �ʼ�����: 
<input type="text" name="bod">
</p>
<p align="center">  </p>
<p align="center"> 
<input type="submit" name="Submit" value="�ύ">
<input type="reset" name="Submit2" value="����">
</p>
</form></td>
</tr>
</table>
</div>
</body>
</html>
