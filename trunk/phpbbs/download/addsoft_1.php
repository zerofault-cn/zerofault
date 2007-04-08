<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>添加记录</title>
<link rel="stylesheet" href="../style.css" type="text/css">

<script language="javascript">
function check()
{
	if(window.document.soft.filepath.value=="")
	{
		alert("请输入您的名字");
		document.soft.filepath.focus();
		return false;
	}
	
	if(window.document.soft.name.value=="")
	{
		alert("您忘了写name");
		document.soft.name.focus();
		return false;
	}
	if(window.document.soft.type.value=="")
	{
		alert("您忘了选择类型");
		document.soft.type.focus();
		return false;
	}
	return true;
}
</script>

</head>
<body>
<h2>软件入库</h2>
<form method=post action="addsoft_2.php" name=soft onsubmit="return check();">
软件路径:<input type=file name=filepath size=50><br>
&nbsp;&nbsp;软件名:<input type=text name=name size=20>
类型:
<select name="type">
<option>选择</option>
	<option value=服务器类>服务器类</option>
	<option value=编程语言>编程语言</option>
	<option value=病毒防治>病毒防治</option>
	<option value=电子词典>电子词典</option>
	<option value=媒体播放>媒体播放</option>
	<option value=屏幕保护>屏幕保护</option>
	<option value=驱动程序>驱动程序</option>
	<option value=输入法>输入法</option>
	<option value=图形图像>图形图像</option>
	<option value=网络工具>网络工具</option>
	<option value=网页制作>网页制作</option>
	<option value=文本编辑>文本编辑</option>
	<option value=系统测试>系统测试</option>
	<option value=系统软件>系统软件</option>
	<option value=虚拟光驱>虚拟光驱</option>
	<option value=游戏娱乐>游戏娱乐</option>
	<option value=源代码>源代码</option></select>
<br>
软件说明:<textarea name=info rows=15 cols=56></textarea><br>
<input type="submit" value="提交">
</form>



</body>
</html>