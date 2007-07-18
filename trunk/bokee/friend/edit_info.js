var edit_count=0;
function do_edit(field)
{
	t(field).style.display = 'none';
	t('edit_'+field).style.display = 'block';
	edit_count++;
	t('submitBtn').style.display = 'block';
	t('op_'+field).innerHTML='<a href="javascript:void(0)" onclick="do_submit(\''+field+'\');">保存</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="cancel_edit(\''+field+'\');">取消</a>';
}
function cancel_edit(field)
{
	t(field).style.display = 'block';
	t('edit_'+field).style.display = 'none';
	edit_count--;
	if(edit_count==0)
	{
		t('submitBtn').style.display = 'none';
	}
	t('op_'+field).innerHTML='<a href="javascript:void(0)" onclick="do_edit(\''+field+'\');">修改</a>';
}
function do_submit(field)
{
	var value='';
	if(field=='characters' || field=='interest' || field=='movie' || field=='music' || field=='book')
	{
		var f = document.forms["edit_info"];
		for (i=0;i<f.elements.length;i++)
		{
			if(f.elements[i].name=='input_'+field+'[]')
			{
				if(f.elements[i].checked == true)
				{
					value+=f.elements[i].value;
					value+=',';
				}
			}
		}
		value=value.substring(0,value.length-1);
	}
	else if(field=='want_age' || field=='want_height' || field=='want_weight')
	{
		value=t('input_'+field+'1').value+'-'+t('input_'+field+'2').value;
	}
	else
	{
		value=t('input_'+field).value;
	}
	if(value=='未填写' || value=='' || value==0 || value=='-' || value=='保密---请选择--')
	{
		cancel_edit(field);
		return;
	}
//	alert(value);
	document.getElementById('iframe1').src='?action=modify&id='+id+'&field='+field+'&value='+value+'&'+Math.random();
}
function t(id)
{
	return document.getElementById(id);
}
function setBirthday(year,month,day)
{
	if(year!=0)
	{
		t('input_birthday').value=year+t('input_birthday').value.substr(4,6);
	}
	if(month!=0)
	{
		t('input_birthday').value=t('input_birthday').value.substr(0,5)+month+t('input_birthday').value.substr(7,3);
	}
	if(day!=0)
	{
		t('input_birthday').value=t('input_birthday').value.substr(0,8)+day;
	}
}
function setLocation(location1,location2)
{
	if(location1!=0)
	{
		t('input_location').value=location1+'-';
	}
	if(location2!=0)
	{
		t('input_location').value=t('input_location').value.substr(0,t('input_location').value.indexOf('-')+1)+location2;
	}
//	alert(t('input_location').value);
}
function change_province(province)//根据省份切换城市
{
	for (m = t('input_location2').options.length; m >= 0; m--)
	{
		t('input_location2').options[m]=null;
	}
	for (key in city[province])
	{
		cityOption = new Option(city[province][key],city[province][key]);
		t('input_location2').options.add(cityOption);
	}
}

function checkGroup()
{
	if(groupID==1 || groupID==2 || groupID==3 || groupID==98 || groupID==99)
	{
		alert('对不起，老公社用户不支持此功能');
		return true;
	}
	else
	{
		return false;
	}
}
function doAddFriend(addBlogId)
{
	if(blogID==null || blogID == ""){
		alert('请先登录，然后才能添加好友！');
	//	window.location.href='http://reg.bokee.com/account/web/login.jsp?url='+window.location.href;
		return ;
	}
	else if(checkGroup())
	{
		return;
	}
	if(blogID==addBlogId)
	{
		alert('您不能把自己添加成好友！');
		return ;
	}

	var sUrl ="http://"+blogID+".bokee.com/sn/addfriend.b?friendName="+addBlogId+".bokee.com";
	var diaType = "scrollbars=no,resizable=no,help=no,status=no,center=yes,width=400px,height=330px";
	window.open(sUrl,"addFriend",diaType);
}
function popPostMsg(postBlogId){
	if(blogID == null || blogID == "")
	{
		alert('请先登录，然后才能发送信息!');
	//	window.location.href='http://reg.bokee.com/account/web/login.jsp?url='+ window.location.href;
		return;
	}
	else if(checkGroup())
	{
		return;
	}
	var sUrl ="http://"+blogID+".bokee.com/mes/poppostmsg.b?message.receiver="+postBlogId+".bokee.com";
	var diaType = "scrollbars=no,resizable=no,help=no,status=no,center=yes,width=400px,height=330px";
	window.open(sUrl,"postMsg",diaType);
}
function addFavorite(favName,url){
	if(blogID==null)
	{
		alert('您还没有登陆，请先登陆后再收藏！');
	//	window.location.href='http://reg.bokee.com/account/web/login.jsp?url='+ window.location.href;
		return;
	}
	else if(checkGroup())
	{
		return;
	}
	document.getElementById('iframe1').src='http://'+blogID+'.bokee.com/list/addDiaryFavorite.b?favorite.blogId='+blogID+'.bokee.com&favorite.favName='+favName+'&favorite.url='+url+'&favorite.property=1';
	alert('操作成功！');
}
function jionChatRoomMyPhoto(){
	if(blogID== null)
	{
		alert('您还没有登录，请先登录后再进入聊天室');
		return;
	}
	else if(checkGroup())
	{
		return;
	}
	document.getElementById("chatRoomFrmMyPhoto").action = "http://"+blogID+".bokee.com/control/showChat.b?chatNamePost1="+ encodeURI(document.getElementById("chatRoomFrmMyPhoto").chatNamePost.value);
	document.getElementById("chatRoomFrmMyPhoto").submit();
}