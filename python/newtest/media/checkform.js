/**
*检验用户输入是否合法
*/
var blogurl_err='';
function check()
{
	fields=document.getElementsByTagName("input");
	for(i=0;i<fields.length-2;i++)
	{
		val=fields[i].getAttribute('name');
		if(fields[i].value=='')
		{
			alert('每一项都必须填写');
			eval('document.form1.'+val).focus();
			return false;
		}
		else if(t(val+'_tip').className=='tip_err')
		{
			alert(t(val+'_tip').innerHTML);
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
		tips='只能使用小写字母，数字和下划线（_）的混合！';
		break;
	case 'password':
		tips='可以输入任意字符，不少于6个字符！';
		break;
	case 'repassword':
		tips='请重复输入一次上面的密码以确认！';
		break;
	case 'nickname':
		tips='请设定一个昵称，以后将在评论中显示！可以是中文';
		break;
	case 'email':
		tips='请填写您常用的E-mail，以方便接受最新消息！';
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
		if(!new RegExp(/^[a-z]+/).test(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='您的输入不合要求，只能以小写字母开头！';
		}
		else if(!new RegExp(/^[a-z]+[a-z0-9_]+$/).test(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='您的输入不合要求，只能输入数字，字母或下划线！';
		}
		else if(obj.value.length<4 || obj.value.length>16)
		{
			t(val+'_tip').className='tip_err';
			tips='你输入的长度不符合要求，请输入4-16个字符！';
		}
		else
		{
			res=parseInt(checkUsername(obj.value));
			if(res==0)
			{
				t(val+'_tip').className='tip_ok';
				tips='恭喜，您的用户名符合要求，并可以使用！';
				setTimeout("hidden_tip('"+val+"')",2000);
			}
			else
			{
				t(val+'_tip').className='tip_err';
				tips='抱歉，您选择的用户名已被注册！';
			}
		}
		break;
	case 'password':
		if(obj.value.length<6)
		{
			t(val+'_tip').className='tip_err';
			tips='你输入的密码太短，应至少6个字符！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='密码设置符合要求！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'repassword':
		if(obj.value!=document.getElementById('password').value)
		{
			t(val+'_tip').className='tip_err';
			tips='两次密码输入不一致，请检查确认！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='两次输入的密码一致！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'nickname':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='您的昵称太短了！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='ok！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'email':
		if(!ismail(obj.value))
		{
			t(val+'_tip').className='tip_err';
			t(val+'_tip').innerHTML='您填写的不是E-mail地址！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			t(val+'_tip').innerHTML='E_mail地址符合规范！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	}
	t(val+'_tip').style.display='';
	t(val+'_tip').innerHTML=tips;
}
var xmlhttp = createXMLHTTP();
function checkUsername(str)
{
	xmlhttp.open("get","../checkUsername/?username="+str,false);
	xmlhttp.send(null);
	return str=xmlhttp.responseText;
}
function hidden_tip(val)
{
	t(val+'_tip').style.display='none';
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