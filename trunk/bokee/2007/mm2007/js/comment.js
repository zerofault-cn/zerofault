function check()
{
	if(document.form2.content.value.length<2)
	{
		alert("您的留言内容太短！");
		document.form2.content.focus();
		return false;
	}
	if(document.form2.content.value=='{LASTCONTENT}')
	{
		alert("请不要重复留言!");
		document.form2.content.focus();
		return false;
	}
	if(isstart=='true' && time2>0)
	{
		alert("您留言也太快了吧!");
		return false;
	}
}

var time2=60;//设定冷冻时间,在此时间内不能提交留言
var isstart='{ISSTART}';
function start()
{
	if (time2<0)
	{
		time2=0;
	//	document.form2.submit.value='提交';
	//	document.form2.submit.disabled=false;
	}
	else
	{
	//	document.form2.submit.value=time2+'秒后提交';
	//	document.form2.submit.disabled=true;
	}
	time2--;
	setTimeout("start()",1000);
}
function startif()
{
	if(isstart=='true')
	{
		start();
	}
}