<? 
if($_REQUEST['send'])
{ 
	$hearer="From:".$_REQUEST['from']."\nReply-To:".$_REQUEST['from']."\nX-Mailer: PHP/".phpversion()."\nContent-Type:text/html"; 
	$result=mail($_REQUEST['to'],$_REQUEST['subject'],$_REQUEST['body'],$hearer); 
	if($result) 
	{
		echo "邮件已成功发送"; 
	}
	else
	{
		echo 'error';
	}
} 
?> 
<html> 
<body> 
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#6699FF"> 
<form method="post"> 
<tr bgcolor="#E7E7CB"> 
<td width="20%" height="26">发件人：</td> 
<td width="80%"><input name="from" type="text"></td> 
</tr> 
<tr bgcolor="#E7E7CB"> 
<td height="25">收件人：</td> 
<td><input name="to" type="text"></td> 
</tr> 
<tr bgcolor="#E7E7CB"> 
<td height="24">邮件标题：</td> 
<td><input name="subject" type="text" size="50"></td> 
</tr> 
<tr bgcolor="#E7E7CB"> 
<td height="27">邮件内容：</td> 
<td><textarea name="body" cols="60" rows="10"></textarea></td> 
</tr> 
<tr bgcolor="#E7E7CB"> 
<td height="28"> </td> 
<td> 
<input type="hidden" value="1" name="send"> 
<input type="submit" name="Submit" value="提交"> 
<input type="reset" name="Submit2" value="重置"></td> 
</tr> 
</form> 
</table> 
</body> 
</html> 