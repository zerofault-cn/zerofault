function checkform1()
{
	if(window.document.form1.keyword.value=="")
	{
		alert("ÇëÊäÈëËÑË÷¹Ø¼ü×Ö");
		document.form1.keyword.focus();
		return false;
	}
	return true;
}

function closebut(x, y) 
{
//	if(document.img0) document.img0.src='image/folder1.gif';
//	if(document.img1) document.img1.src='image/folder1.gif';
//	if(document.all.div0) document.all.div0.style.display='none';
//	if(document.all.div1) document.all.div1.style.display='none';
	x.style.display='block';
	y.src='image/folder2.gif';
}
function t(x, y) 
{
	if(x.style.display!='none') 
	{
		x.style.display='none';
		y.src='image/folder1.gif';
	}
	else
		closebut(x, y);
}
function wordCount()
		{
			var maxLen=1000;
			if (document.form3.content.value.length > maxLen)
			{
				document.form3.content.value = document.form3.content.value.substring(0,maxLen);
			}
			else
			{
				document.getElementById('wordCount').innerHTML=document.form3.content.value.length;
			}
		}
		function addface(id)
		{
			document.form3.content.value+='[face]'+id+'[/face]';
		}