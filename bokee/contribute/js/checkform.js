function checkform1()
{
	if(document.addForm.title.value=="")
	{ 
		alert("���������±��⣡");
		document.addForm.title.focus();
		return false;
	}  
	if(document.addForm.url.value.length<8)
	{
		alert("�������������ӵ�ַ��");
		document.addForm.url.focus();
		return false;
	}
	if(document.addForm.blogname.value=="")
	{
		alert("�����벩�����ƣ�");
		document.addForm.blogname.focus();
		return false;
	}
	if(document.addForm.blogurl.value=="" || document.addForm.blogurl.value.indexOf('?')>0)
	{
		alert("�����벩�����ӵ�ַ��");
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
		alert("����û��ѡ���κ�Ƶ����!");
		return false;
	}
	if(check_count>3)
	{
		alert("�����ֻ��ѡȡ3��Ƶ��Ͷ�壡");
		return false;
	}
	return true;
}
function checkform2()
{
	if(document.addForm.title.value=="")
	{ 
		alert("���������±��⣡");
		document.addForm.title.focus();
		return false;
	}  
	if(document.addForm.url.value.length<8)
	{
		alert("�������������ӵ�ַ��");
		document.addForm.url.focus();
		return false;
	}
	if(document.addForm.blogname.value=="")
	{
		alert("�����벩�����ƣ�");
		document.addForm.blogname.focus();
		return false;
	}
	if(document.addForm.blogurl.value=="" || document.addForm.blogurl.value.indexOf('?')>0)
	{
		alert("�����벩�����ӵ�ַ��");
		document.addForm.blogurl.focus();
		return false;
	}
	return true;
}
