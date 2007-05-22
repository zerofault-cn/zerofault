/**
*检验用户输入是否合法
*/
var blogurl_err='';
function check()
{
	if(document.form1.name.value=="")
	{
		alert("请填写参选群组名称！");
		document.form1.name.focus();
		return false;
	}
	if(document.form1.name.value.length<2)
	{
		alert("您填写的群组名称太短！");
		document.form1.name.focus();
		return false;
	}
	if(document.form1.url.value.length<24)
	{
		alert("请填写参选群组链接地址！");
		document.form1.url.focus();
		return false;
	}
	if(document.form1.url.value.length>23 && !isGroup(document.form1.url.value))
	{
		alert("请以博客网群组地址参选！");
		document.form1.url.focus();
		return false;
	}
	if(blogurl_err.length>0)
	{
		alert(blogurl_err);
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.city.value=="")
	{
		alert("请填写所在城市！");
		document.form1.city.focus();
		return false;
	}
	if(document.form1.address.value=="")
	{
		alert("请填写联系地址！");
		document.form1.address.focus();
		return false;
	}
	if(document.form1.post.value=='')//最短的含区号电话号码是10位
	{
		alert("请填写您的邮编！");
		document.form1.post.focus();
		return false;
	}
	if(document.form1.post.value.length!=6 || !/^\d+$/.test(document.form1.post.value))
	{
		alert("您填写的邮编只能是数字!");
		document.form1.post.focus();
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
	if(document.form1.email.value.length<5)
	{
		alert("请填写您的E-mail！");
		document.form1.email.focus();
		return false;
	}
	if(document.form1.email.value!="" && !ismail(document.form1.email.value))
	{
		alert("您的E-Mail地址非法,请检查重填！");
		document.form1.email.focus();
		return false;
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
function isGroup(url)
{
	return (new RegExp(/^http:\/\/group.bokee.com\/[A-Za-z0-9]+$/).test(url));
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
function foc(obj)
{
	var val=obj.getAttribute('name');
	switch (val)
	{
	case 'username':
		tips='请填写您的登录名！';
		break;
	case 'password':
		tips='请填写密码！';
		break;
	case 'repassword':
		tips='重复输入密码以确认！';
		break;
	case 'nickname':
		tips='昵称！';
		break;
	case 'email':
		tips='您的E-mail！';
		break;
	}
	t(val+'_tip').style.display='';
	t(val+'_tip').className='tip';
	t(val+'_tip').innerHTML=tips;
}
function blu(obj)
{
	var val=obj.getAttribute('name');
	if(obj.value=='')
	{
	//	foc(obj);
		t(val+'_tip').style.display='none';
		return;
	}
	switch (val)
	{
	case 'username':
		if(obj.value.length<4 || obj.value.length>16)
		{
			t(val+'_tip').style.display='';
			t(val+'_tip').className='tip_err';
			t(val+'_tip').innerHTML='你输入的字数不符合要求，请输入4-16个字符！';
		}
		else
		{
			res=checkUserName(obj.value);
			if(res==1)
			{
				t(val+'_tip').style.display='';
				t(val+'_tip').className='tip_ok';
				t(val+'_tip').innerHTML='群组名称符合要求！';
			}
			else
			{
				t(val+'_tip').style.display='';
				t(val+'_tip').className='tip_err';
				t(val+'_tip').innerHTML=res;
			}
			break;
	case 'url':
		res=checkurl(obj.value);
	
		if(res==0)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='您填写的不是博客群组地址';
		}
		else if(res==1)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_0';
			t(val+'_tips').innerHTML='群组名称符合要求！';
			setTimeout("hidden_url_tips()",5000);
		}
		else
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML=res;
		}
		break;
	case 'city':
		if(obj.value.length<2)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='城市名太短！';
		}
		else
		{
			t(val+'_tips').style.display='none';
		}
		break;
	case 'address':
		if(obj.value.length<6)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='联系地址太短！';
		}
		else
		{
			t(val+'_tips').style.display='none';
		}
		break;
	case 'post':
		if(obj.value.length!=6)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='邮编是6位数字！';
		}
		else if(!/^\d+$/.test(document.form1.post.value))
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='邮编只能是数字，不能包含其他字符！';
		}
		else
		{
			t(val+'_tips').style.display='none';
		}
		break;
	case 'phone':
		if(obj.value.length<10)
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='您的联系电话太短，座机号前必须带区号！';
		}
		else if(!isphone(obj.value))
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='联系电话号码不合法！';
		}
		else
		{
			t(val+'_tips').style.display='none';
		}
		break;
	case 'email':
		if(!ismail(obj.value))
		{
			t(val+'_tips').style.display='';
			t(val+'_tips').className='msg_1';
			t(val+'_tips').innerHTML='您填写的不是E-mail地址！';
		}
		else
		{
			t(val+'_tips').style.display='none';
		}
		break;
	case 'other':
		t(val+'_tips').style.display='none';
		break;
	}
}
function hidden_url_tips()
{
	t('url_tips').style.display='none';
}
/**
*检查blogurl
*/
var xmlhttp = createXMLHTTP();
function checkurl(url)
{
	if(isGroup(url))
	{
		xmlhttp.open("get","group_campus/signup.php?action=checkurl&url="+url+"&"+Math.random(),false);
		xmlhttp.send(null);
		return str=xmlhttp.responseText.rtrim();
	}
	else
	{
		return 0;
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
function createXMLHTTP() {
	var XMLHTTP=null;
	try {
		XMLHTTP=new ActiveXObject("Msxml2.XMLHTTP");//适用IE
	}
	catch(e) {
		try {
			XMLHTTP=new ActiveXObject("Microsoft.XMLHTTP");//适用IE
		}
		catch(oc) {
			XMLHTTP=null;
		}
	}
	if ( !XMLHTTP && typeof XMLHttpRequest != "undefined" ) { 
		XMLHTTP=new XMLHttpRequest();//适用Firefox
	} 
	return XMLHTTP;
}
function t(obj)
{
	return document.getElementById(obj);
}
String.prototype.rtrim=function()
{
	return this.replace(/(\s*$)/g,"");
}