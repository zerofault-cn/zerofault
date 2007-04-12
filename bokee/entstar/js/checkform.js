/**
*检验用户输入是否合法
*/
var blogurl_err='';
function check()
{
	if(document.form1.realname.value=="")
	{
		alert("请填写您推荐的明星名人的名字！");
		document.form1.realname.focus();
		return false;
	}
	if(document.form1.cate_select.value=="")
	{
		alert("请选择适当的分类！");
		return false;
	}
	if(document.form1.blogurl.value.length<8)
	{
		alert("请填写您推荐的博客地址！");
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.blogurl.value.length>7 && !isbokee(document.form1.blogurl.value))
	{
		alert("请推荐本网站的博客地址！");
		document.form1.blogurl.focus();
		return false;
	}
	if(blogurl_err.length>0)
	{
		alert(blogurl_err);
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.groupurl.value.length<=23)
	{
		alert("请填写您推荐的博客地址！");
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.photo.value=="")
	{
		alert("您忘了提交照片！");
		document.form1.photo.focus();
		return false;
	}
	if(document.form1.photo.value!="")
	{
		var filename=document.form1.photo.value;
		var ext=filename.substring(filename.lastIndexOf('.')+1);
		if(ext!='jpg' && ext!='JPG' && ext!='jpeg' && ext!='JPEG' && ext!='gif' && ext!='GIF' && ext!='png' && ext!='PNG' && ext!='bmp' && ext!='BMP')
		{
			alert("您提交的照片格式不对!必须是jpg|jpeg|gif|png|bmp格式的");
			document.form1.photo.focus();
			return false;
		}
	}
	return true;
}
/**
*检查是否博客用户
*/
function isbokee(url)
{
	return (new RegExp(/^http:\/\/[_A-Za-z0-9]+\.((bokee.com)|(blogchina.com)|(blogdriver.com))(\/)?$/).test(url));
}
/**
*检查blogurl
*/
function checkurl(field,url)
{
	if(field=='blogurl')
	{
		if(url.length>17 && isbokee(url))//最短的域名”http://a.bokee.com“的字符长度是18
		{
			document.getElementById('iframe1').src='checkurl.php?blogurl='+url;
		}
		else
		{
			showMsg('blogurl_msg','<b style="color:#F33;">←这个地址不是博客网的个人博客！</b>');
		}
	}
	if(field=='groupurl')
	{
		if(url.length>23 && url!='http://group.bokee.com/?')
		{
			document.getElementById('iframe1').src='checkurl.php?groupurl='+url;
		}
		else
		{
			showMsg('groupurl_msg','<b style="color:#F33;">←博客群组地址格式不正确！</b>');
		}
	}
}
/**
*显示提示信息
*/
function showMsg(id,code)
{
	switch (code)
	{
	case 0:
		str='<b style="color:#96F;">←此博客地址可以被推荐！</b>';
		break;
	case 1:
		str='<b style="color:#F33;">←此博客地址已经被推荐！</b>';
		break;
	case 2:
		str='<b style="color:#96F;">←此群组地址可以被推荐！</b>';
		break;
	case 3:
		str='<b style="color:#F33;">←此群组地址已经被推荐！</b>';
		break;
	default:
		str=code;
	}
	document.getElementById(id).innerHTML=str;
	return;
}
function setErr(code)//当点击提交按钮时需要检验此变量
{
	switch (code)
	{
	case 0:
		form_err='';
		break;
	case 1:
		form_err='您填写的博客地址已经被推荐了,不能重复推荐！';
		break;
	case 2:
		form_err='您填写的群组地址已经被推荐了，不能重复推荐！';
	}
	
}