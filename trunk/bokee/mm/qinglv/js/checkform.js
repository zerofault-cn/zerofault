/**
*检验用户输入是否合法
*/
var blogurl_err='';
function check()
{
	if(document.form1.blogname.value=="")
	{
		alert("请填写参选博客名称！");
		document.form1.blogname.focus();
		return false;
	}
	if(document.form1.blogurl.value.length<8)
	{
		alert("请填写参选博客地址！");
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.blogurl.value.length>7 && !isbokee(document.form1.blogurl.value))
	{
		alert("请以博客网个人博客参选！");
		document.form1.blogurl.focus();
		return false;
	}
	if(blogurl_err.length>0)
	{
		alert(blogurl_err);
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.realname.value=="")
	{
		alert("请填写您的真实姓名！");
		document.form1.realname.focus();
		return false;
	}
	if(document.form1.cardnum.value.length>0 && !/^\d+$/.test(document.form1.cardnum.value))
	{
		alert("您填写的证件号码只能是数字!");
		document.form1.cardnum.focus();
		return false;
	}
	if(document.form1.phone.value.length<10)//最短的含区号电话号码是10位
	{
		alert("请正确填写您的联系电话！");
		document.form1.phone.focus();
		return false;
	}
	if(document.form1.phone.value.length>9 && !isphone(document.form1.phone.value))
	{
		alert("您的联系电话非法！");
		document.form1.phone.focus();
		return false;
	}
	if(document.form1.email.value!="" && !ismail(document.form1.email.value))
	{
		alert("您的E-Mail地址非法,请检查重填！");
		document.form1.email.focus();
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
*检验邮件地址是否合法
*/
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
/**
*检查是否博客用户
*/
function isbokee(url)
{
	return (new RegExp(/^http:\/\/[_A-Za-z0-9]+\.((bokee.com)|(blogchina.com)|(blogdriver.com)|(home.hb.vnet.cn))(\/)?$/).test(url));
}
/**
*检查是否合法电话号码
*/
function isphone(num)
{
	return (new RegExp(/^((0(\d{2,3})[_\-－]?(\d{7,8}))|(1[35](\d{9})))$/).test(num));
	//这里要求包含区号，如果可以不包含区号，可以这样写：/^((0\d{2,3})|(0\d{2,3}-))?[1-9]\d{6,7}$/
	//后面是手机号判断,座机（含区号）必须以0开头，手机必须以13或15开头
}
/**
*检查blogurl
*/
function checkurl(url)
{
	if(url.length>17 && isbokee(url))//最短的域名”http://a.bokee.com“的字符长度是18
	{
		document.getElementById('iframe1').src='qinglv/checkurl.php?url='+url;
	}
	else
	{
		showMsg('blogurl_msg','这个地址不是博客网的个人博客!');
	}
}
function checknum(num)
{
	if(num.length<10)
	{
		showMsg('telenum_msg','请输入含区号的电话号码或手机号码');
	}
	else if(num.length>9 && isphone(num))
	{
		showMsg('telenum_msg','联系电话符合要求!');
	}
	else
	{
		showMsg('telenum_msg','您输入的号码不符合要求');
	}
}
/**
*显示提示信息
*/
function showMsg(id,str)
{
	document.getElementById(id).innerHTML=str;
	return;
}
function setErr(str)
{
	blogurl_err=str;
}