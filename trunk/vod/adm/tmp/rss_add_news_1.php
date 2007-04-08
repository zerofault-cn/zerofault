<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("请选择类型");
		return false;
	}
	if(window.document.add.title.value=="")
	{
		alert("请输入标题");
		document.add.title.focus();
		return false;
	}
	if(window.document.add.info.value=="")
	{
		alert("请输入内容");
		document.add.info.focus();
		return false;
	}
	return true;
}
</script>
<script language="JavaScript">
<!--
	var lastScrollY = 0;
	function floatRefresh() {
		diffY = document.body.scrollTop;
		percent =.1*(diffY-lastScrollY);
		if(percent>0){
			percent = Math.ceil(percent);
		}else{
			percent = Math.floor(percent);
		}
		document.all.float.style.pixelTop += percent;
		lastScrollY = lastScrollY + percent;
	}
	window.setInterval("floatRefresh()",1);
//-->
</script>
<DIV id='float' style='left:400px;POSITION:absolute;TOP:320px;'>
	<a href='#' style='color:red' onclick="window.open('pic_upload_1.php?pic_type=news_pic&name=RSS新闻','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes')">&lt;--在当前位置插入图片</a>
</div>
<form method=post action="rss_add_news_2.php" name="add" onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加"RSS新闻"内容</caption>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>内容分类:</td>
	<td align=left>
	<select name=channel onchange="document.add_news.select_flag.value=1">
	<option>-请选择-</option>
	<?
	include_once "../include/mysql_connect.php";
	$sql1="select * from rss_channel where del_flag=1";
	$result1=mysql_query($sql1);
	while($r=mysql_fetch_array($result1))
	{
		?>
		<option value="<?=$r["id"]?>"><?=$r["channel_name"]?></option>
		<?
	}
	?>
	</select> <a href="index.php?content=rss_add_channel_1">添加分类</a>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>标题:</td>
	<td align=left><INPUT TYPE="text" NAME="title" size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>出处(作者):</td>
	<td align=left><INPUT TYPE="text" NAME="author" size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>详细内容:</td>
	<td><textarea name=info rows=25 cols=66></textarea></td>
</tr>
<tr bgcolor=white>
	<td>需要格式化:</td>
	<td><input type=radio name=need_f value=1>是<input type=radio name=need_f value=0 checked>否</td>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=select_flag><input type="submit" value="&nbsp;添加&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;重填&nbsp;"></td>
</tr>
</table>
</form>