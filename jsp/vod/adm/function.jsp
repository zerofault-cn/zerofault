<!-- ���ܲ˵� -->
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
	<td background="image/top_white.gif" colspan=3 height=20 valign=top align=center><img height=16 src="image/list.gif" width=16>���ܲ˵�</td>
</tr>
<tr>
	<td align=right height=100% rowspan=6 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td>
		&nbsp;&nbsp;<img name=img0 src="image/folder.gif"><a href="javascript: t(document.all.div0,document.img0)">�û�����</a><br>
		<div id=div0 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp">�����û�</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_add_1">����û�</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_showall">�����û�</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=user_search_1">��ѯ�û�</a><br>
		</div></td>
	<td align=left height=100% rowspan=6 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
</tr>

<tr>
	<td>
		&nbsp;&nbsp;<img name=img1 src="image/folder.gif"><a href="javascript: t(document.all.div1,document.img1)">��Ӱ����</a><br>
		<div id=div1 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_add_type_1">�������</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_prog">ӰƬ����</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=vod_add_prog_1">���ӰƬ</a><br>
		
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img2 src="image/folder.gif"><a href="javascript: t(document.all.div2,document.img2)">���ֹ���</a><br>
		<div id=div2 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_singer_list">���и���</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_add_singer_1">��Ӹ���</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog">���и���</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_add_prog_1">��Ӹ���</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+������������<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=1">����Ϊһ</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=2">����Ϊ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=3">����Ϊ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=4">����Ϊ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=5">����Ϊ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_wordcount&var1=wordcount&value1=6">��������</a><br>
		&nbsp;&nbsp;&nbsp;&nbsp;+����������ĸ��<br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=ad">����ĸA-D</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=eh">����ĸE-H</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=il">����ĸI-L</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=mp">����ĸM-P</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=qu">����ĸQ-U</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=music_prog_pinyin&var1=pinyin&value1=wz">����ĸW-Z</a><br>
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img3 src="image/folder.gif"><a href="javascript: t(document.all.div3,document.img3)">���ӵ�̨</a><br>
		<div id=div3 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_station">����Ƶ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_add_station_1">���Ƶ��</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=epg_modify_schedule_1">��Ŀ������</a><br>
		
		</div></td>
</tr>
<tr>
	<td>
		&nbsp;&nbsp;<img name=img4 src="image/folder.gif"><a href="javascript: t(document.all.div4,document.img4)">����Աά��</a><br>
		<div id=div4 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=">�޸���Ϣ</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=">�޸�����</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a class=bigger href="index.jsp?content=admin_add_1">��ӹ���Ա</a><br>
		
		</div></td>
</tr>
<tr>
	<td>&nbsp;&nbsp;<img src="image/link0.gif"><a href='logout.jsp'>�˳�����</a></td>
</tr>
<tr>
	<td background="image/bottom_white.gif" colspan=3 height=20></td>
</tr>
</table>