<!-- 功能菜单 -->
<script>
function closebut(x, y) 
{
	if(document.img0) document.img0.src='image/folder.gif';
	if(document.img1) document.img1.src='image/folder.gif';
	if(document.img2) document.img2.src='image/folder.gif';
	if(document.img3) document.img3.src='image/folder.gif';
	if(document.img4) document.img4.src='image/folder.gif';
	if(document.img5) document.img5.src='image/folder.gif';
	if(document.img6) document.img6.src='image/folder.gif';
	if(document.img7) document.img7.src='image/folder.gif';
	if(document.img8) document.img8.src='image/folder.gif';
	if(document.all.div0) document.all.div0.style.display='none';
	if(document.all.div1) document.all.div1.style.display='none';
	if(document.all.div2) document.all.div2.style.display='none';
	if(document.all.div3) document.all.div3.style.display='none';
	if(document.all.div4) document.all.div4.style.display='none';
	if(document.all.div5) document.all.div5.style.display='none';
	if(document.all.div6) document.all.div6.style.display='none';
	if(document.all.div7) document.all.div7.style.display='none';
	if(document.all.div8) document.all.div8.style.display='none';
	x.style.display='block';
	y.src='image/folder2.gif';
}
function t(x, y) 
{
	if(x.style.display!='none') 
	{
		x.style.display='none';
		y.src='image/folder.gif';
	}
	else
		closebut(x, y);
}
</script>

<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
	<td background="image/top_white.gif" colspan=3 height=20 valign=top align=center><img height=16 src="image/list.gif" width=16>功能菜单</td>
</tr>
<tr>
	<td align=right height=100% rowspan=6 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td>
		&nbsp;&nbsp;<img name=img0 src="image/folder.gif"><a href="javascript: t(document.all.div0,document.img0)">用户管理</a><br>
		<div id=div0 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp">在线用户</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_add_1">添加用户</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_showall">所有用户</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_search_1">查询用户</a><br>
		</div></td>
	<td align=left height=100% rowspan=6 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
</tr>

<tr>
	<td>
		&nbsp;&nbsp;<img name=img1 src="image/folder.gif"><a href="javascript: t(document.all.div1,document.img1)">电影管理</a><br>
		<div id=div1 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_add_type_1">分类管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_prog">影片管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_add_prog_1">添加影片</a><br>
		
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img2 src="image/folder.gif"><a href="javascript: t(document.all.div2,document.img2)">音乐管理</a><br>
		<div id=div2 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_singer_list">所有歌手</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_add_singer_1">添加歌手</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog">所有歌曲</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_add_prog_1">添加歌曲</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+按曲名字数分<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=1">字数为一</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=2">字数为二</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=3">字数为三</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=4">字数为四</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=5">字数为五</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=6">五字以上</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+按曲名首字母分<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=ad">首字母A-D</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=eh">首字母E-H</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=il">首字母I-L</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=mp">首字母M-P</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=qu">首字母Q-U</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=wz">首字母W-Z</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img3 src="image/folder.gif"><a href="javascript: t(document.all.div3,document.img3)">电视电台</a><br>
		<div id=div3 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_station">已有频道</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_add_station_1">添加频道</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_modify_schedule_1">节目单管理</a><br>
		
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img4 src="image/folder.gif"><a href="javascript: t(document.all.div4,document.img4)">管理员维护</a><br>
		<div id=div4 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=">修改信息</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=">修改密码</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=admin_add_1">添加管理员</a><br>
		
		</div></td>
</tr>
<tr>
	<td>&nbsp;&nbsp;<img src="image/link0.gif"><a href='logout.jsp'>退出管理</a></td>
</tr>
<tr>
	<td background="image/bottom_white.gif" colspan=3 height=20></td>
</tr>
</table>