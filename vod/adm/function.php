<!-- 功能菜单 -->
<script>
function t(x, y) 
{
	if(x.style.display!='none') 
	{
		x.style.display='none';
		y.src='image/folder.gif';
	}
	else
	{
		x.style.display='block';
		y.src='image/folder2.gif';
	}
}
</script>

<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr>
	<td background="image/top_white.gif" colspan=3 height=20 valign=top align=center><img height=16 src="image/list.gif" width=16>功能菜单</td>
</tr>
<tr>
	<td align=right height="100%" rowspan=14 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td>
		&nbsp;&nbsp;<img name="img0" src="image/folder.gif"><a href="javascript: t(document.getElementById('div0'),document.img0)" title="">系统统计</a><br>
		<div id="div0" style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=user_online_view">在线用户</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=user_count_view">访问统计</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="../webalizer/index.html" title="webalize">日志分析</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=server_stat_add_path_1" title="">统计管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=server_stat" title="">查看结果</a><br>
		</div></td>
	<td align=left height="100%" rowspan=14 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
</tr>

<tr>
	<td>
		&nbsp;&nbsp;<img name=img1 src="image/folder.gif"><a href="javascript: t(document.getElementById('div1'),document.img1)">电影管理</a><br>
		<div id=div1 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vod_add_type_1">分类管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vod_prog">影片列表</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vod_add_prog_1">添加影片</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vod_search_prog_1">快速搜索</a><br>&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vod_prog_statis_1">快速统计</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img2 src="image/folder.gif"><a href="javascript: t(document.getElementById('div2'),document.img2)">音乐管理</a><br>
		<div id=div2 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_singer_list">所有歌手</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_add_singer_1">添加歌手</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog">所有歌曲</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_add_prog_1">添加歌曲</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_search_prog_1">快速搜索</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+按曲名字数分<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=1">字数为一</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=2">字数为二</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=3">字数为三</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=4">字数为四</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=5">字数为五</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_wordcount&wordcount=6">五字以上</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+按曲名首字母分<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=ad">首字母A-D</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=eh">首字母E-H</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=il">首字母I-L</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=mp">首字母M-P</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=qu">首字母Q-U</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=music_prog_pinyin&pinyin=wz">首字母W-Z</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img10 src="image/folder.gif"><a href="javascript: t(document.getElementById('div10'),document.img10)">MP3管理</a><br>
		<div id=div10 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=mp3_list">所有MP3</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=mp3_add_1">添加MP3</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=mp3_query_1">快速搜索</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img3 src="image/folder.gif"><a href="javascript: t(document.getElementById('div3'),document.img3)">电视电台</a><br>
		<div id=div3 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=epg_station">已有节目</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=epg_add_tv_1">添加电视</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=epg_add_radio_1">添加电台</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img5 src="image/folder.gif"><a href="javascript: t(document.getElementById('div5'),document.img5)">实时新闻</a><br>
		<div id=div5 style="display: none">
		&nbsp;&nbsp;&nbsp;&nbsp;+外部RSS资源<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=rss_source">已有资源</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=rss_add_source_1">添加资源</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+本地RSS<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=rss_add_channel_1">频道管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=rss_news">已有内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=rss_add_news_1">添加内容</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img6 src="image/folder.gif"><a href="javascript: t(document.getElementById('div6'),document.img6)">天天在线</a><br>
		<div id=div6 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=daily_add_type_1">分类管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=daily_source">已有内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=daily_add_source_1">添加内容</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img12 src="image/folder.gif"><a href="javascript: t(document.getElementById('div12'),document.img12)">Flash天地</a><br>
		<div id=div12 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=flash_add_type_1">分类管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=flash_source">已有内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=flash_add_source_1">添加内容</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img7 src="image/folder.gif"><a href="javascript: t(document.getElementById('div7'),document.img7)">极速下载</a><br>
		<div id=div7 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=bt_add_type_1">分类管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=bt_add_source_1">添加内容</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img8 src="image/folder.gif"><a href="javascript: t(document.getElementById('div8'),document.img8)">政务便民</a><br>
		<div id=div8 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=zw_add_1">添加政务内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=zw_source">管理政务内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=bm_add_1">添加便民内容</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=bm_source">管理便民内容</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img9 src="image/folder.gif"><a href="javascript: t(document.getElementById('div9'),document.img9)">用户管理</a><br>
		<div id=div9 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=user_add_1">添加用户</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=user_query_1">查询用户</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img4 src="image/folder.gif"><a href="javascript: t(document.getElementById('div4'),document.img4)">管理员管理</a><br>
		<div id=div4 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=admin_info">管理员列表</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=admin_add_limittype_1">权限类别管理</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=admin_update_limit_1">权限设置</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.php?content=admin_add_1">添加管理员</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=admin_modify_password_1">修改密码</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img11 src="image/folder.gif"><a href="javascript: t(document.getElementById('div11'),document.img11)">其他功能</a><br>
		<div id=div11 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=cache_update_1">缓存更新设置</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=message_index">留言板</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=notice_update_1">修改通告</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=help_update_1">修改在线帮助</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=update_batch">批量更新</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=disk_free_space">磁盘使用情况</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="?content=vote_subject">投票管理</a><br>
		</div></td>
</tr>
<tr>
	<td>&nbsp;&nbsp;<img src="image/link0.gif"><a href="logout.php">退出管理</a></td>
</tr>
<tr>
	<td background="image/bottom_white.gif" colspan=3 height=20></td>
</tr>
</table>