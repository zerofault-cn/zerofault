<script language="javascript">
function check()
{
	if(window.document.board.username.value=="")
	{
		alert("请填写您的昵称！");
		document.board.username.focus();
		return false;
	}
	if(window.document.board.email.value!="" && !ismail(window.document.board.email.value))
	{
		alert("您的E-Mail地址非法！");
		document.board.email.focus();
		return false;
	}

	if(window.document.board.content.value=="")
	{
		alert("您忘了写留言内容");
		document.board.content.focus();
		return false;
	}
	return true;
}
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
</script>

<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>插入留言</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<div>给我留言</a>
<div> 昵 称 :<input type=text name="username" size=20><input type="checkbox" onclick="if(this.checked)document.board.username.value='匿名';else document.board.username.value='';">匿名</div>
<div>E-Mail:<input type="text" name="email" size=20>(不会对外公开)</div>
<div> 标 题 :<input type="text" name="title" size=20></div>
<div>内 容 :<textarea name="content" rows=6 cols=40></textarea></div>
<div style="padding-left:3em;"><input type="submit" value="提交">&nbsp;&nbsp;<input type="reset" value="重写">&nbsp;&nbsp;<button onclick="javascript:location='index.php'">返回</button></div>
</form>
</body>
</html>