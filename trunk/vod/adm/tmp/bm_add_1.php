<script language="javascript">
function check()
{
	if(window.document.add.title.value=="")
	{
		alert("您忘了标题");
		document.add.title.focus();
		return false;
	}
	if(window.document.add.type.value=="")
	{
		alert("您忘了选择类型");
		return false;
	}
	return true;
}
</script>
<script language="JavaScript">
<!--
//	var lastScrollY = 0;
//	function floatRefresh() 
	{
//		diffY = document.body.scrollTop;
//		percent =.1*(diffY-lastScrollY);
//		if(percent>0)
		{
//			percent = Math.ceil(percent);
		}
//		else
		{
//			percent = Math.floor(percent);
		}
//		document.all.float.style.pixelTop += percent;
//		lastScrollY = lastScrollY + percent;
	}
//	window.setInterval("floatRefresh()",1);
//-->
</script>
<!-- <DIV id='float' style='left:400px;POSITION:absolute;TOP:360px;'>
	<a href='#' style='color:red' onclick="window.open('pic_upload_1.php?pic_type=bm_pic&name=便民服务','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes')">&lt;--在当前位置插入图片</a>
</div> -->
<form action="bm_add_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加"便民服务"内容</caption>
<tr bgcolor=white>
	<td align=right width="12%">当前城市：</td>
	<td class=blue>
		<select name=city>
		<option value="suining">遂宁</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=left rowspan=6 width="10%">选择分类:</td>
	<td align=left><input type=radio name=select_type onfocus="document.add.type.value='dianhua'" disabled>常用电话</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type.value='gongjiao'" disabled>公交路线</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type.value='huoche'" disabled>火车时刻表</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type.value='shenghuo'">生活提示</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type.value='yiliao'">医疗保健</input></td>
</tr>
<tr bgcolor=white>
	<td><input type=radio name=select_type onfocus="document.add.type.value='lvyou'">旅游信息</input></td>
</tr>
<tr bgcolor=white>
	<td align=right width="12%">标题：</td>
	<td><input type=text name=title size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>内容：</td>
	<td colspan=2><textarea rows=16 name=info cols=60></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=type value="">
</form>
