function checkform1()
{
	if(document.addForm.title.value=="")
	{ 
		alert("请输入文章标题！");
		document.addForm.title.focus();
		return false;
	}  
	if(document.addForm.url.value.length<8)
	{
		alert("请输入文章链接地址！");
		document.addForm.url.focus();
		return false;
	}
	if(document.addForm.blogname.value=="")
	{
		alert("请输入博客名称！");
		document.addForm.blogname.focus();
		return false;
	}
	if(document.addForm.blogurl.value=="" || document.addForm.blogurl.value.indexOf('?')>0)
	{
		alert("请输入博客链接地址！");
		document.addForm.blogurl.focus();
		return false;
	}
	var c = document.getElementsByName("id[]");
	var check_flag=false;
	var check_count=0;
	for(i=0;i<c.length;i++)
	{
		if(c[i].checked == true)
		{
			check_flag=true;
			check_count++;
		}
	}
	if(!check_flag)
	{
		alert("您还没有选择任何频道呢!");
		return false;
	}
	if(check_count>3)
	{
		alert("您最多只能选取3个频道投稿！");
		return false;
	}
	return true;
}
function checkform2()
{
	if(document.addForm.title.value=="")
	{ 
		alert("请输入文章标题！");
		document.addForm.title.focus();
		return false;
	}  
	if(document.addForm.url.value.length<8)
	{
		alert("请输入文章链接地址！");
		document.addForm.url.focus();
		return false;
	}
	if(document.addForm.blogname.value=="")
	{
		alert("请输入博客名称！");
		document.addForm.blogname.focus();
		return false;
	}
	if(document.addForm.blogurl.value=="" || document.addForm.blogurl.value.indexOf('?')>0)
	{
		alert("请输入博客链接地址！");
		document.addForm.blogurl.focus();
		return false;
	}
	return true;
}
