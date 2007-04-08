<script>
function closebut(x, y) 
{
	if(document.img0) document.img0.src='image/folder.gif';
	if(document.img1) document.img1.src='image/folder.gif';
	if(document.img2) document.img2.src='image/folder.gif';
	if(document.img3) document.img3.src='image/folder.gif';
	if(document.img4) document.img4.src='image/folder.gif';
	if(document.img5) document.img5.src='image/folder.gif';
	if(document.all.div0) document.all.div0.style.display='none';
	if(document.all.div1) document.all.div1.style.display='none';
	if(document.all.div2) document.all.div2.style.display='none';
	if(document.all.div3) document.all.div3.style.display='none';
	if(document.all.div4) document.all.div4.style.display='none';
	if(document.all.div5) document.all.div5.style.display='none';
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
	<tr><td background="image/top_white.gif" colspan=3 height=20 valign=top align=center><img height=16 src="image/list.gif" width=16>功能菜单</td></tr>
	<tr><td align=right height=100% rowspan=4 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
		<td>&nbsp;&nbsp;<img name=img0 src="image/folder.gif"><a href="javascript: t(document.all.div0,document.img0)">学生管理</a><br>
		<div id=div0 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp">到校情况</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=add_student_1">添加学生</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=search_student_1">查询学生</a><br>
		</div></td>
		<td align=left height=100% rowspan=4 valign=top width=10><img height="100%" src="image/point.gif" width=1></td></tr>

	<tr><td>
		&nbsp;&nbsp;<img name=img1 src="image/folder.gif"><a href="javascript: t(document.all.div1,document.img1)">教师功能</a><br>
		<div id=div1 style="display: none">
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=search_skaoqin">学生考勤记录</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=view_feedback">查看反馈</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=modify_1&action=modify_passwd">修改密码</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?content=modify_1&action=modify_phone">修改联系电话</a><br>
		</div></td></tr>
	<tr><td>
		&nbsp;&nbsp;<img name=img2 src="image/folder.gif"><a href="javascript: t(document.all.div2,document.img2)">校方功能</a><br>
		<div id=div2 style="display: none">
                &nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?manage_content=search_tkaoqin">老师考勤记录</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?manage_content=view_teacher">查看老师/班级</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="index.jsp?manage_content=add_teacher_1">添加老师/班级</a><br>
		&nbsp;&nbsp;<img src="image/link.gif"><a href="logout.jsp?type=manage_out">退出管理</a><br>
		</div></td></tr>
	<tr><td>&nbsp;&nbsp;<img src="image/link0.gif"><a href='logout.jsp?type=teacher_out'>老师注销</a></td></tr>
	<tr><td background="image/bottom_white.gif" colspan=3 height=20></td></tr>
	</table>