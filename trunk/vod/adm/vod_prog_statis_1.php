<!-- 点播统计 -->
<?
//include "mysql_movie_statistic_divert.php";
include_once "vod_fee_info_divert.php";
?>
<script language="javascript">
function mysubmit()
{
	if(window.document.statistic.name_flag.checked)
	{
		var key_prog_name=window.document.statistic.key_prog_name.value;
		//alert("名称ok");
		//document.statistic.key_prog_name.focus();
		//return;
	}
	else
	{
		var key_prog_name="";
	}
	
	if(window.document.statistic.type_flag.checked)
	{
		var prog_kindthr=window.document.statistic.prog_kindthr.value;
	}
	else
	{
	 	var prog_kindthr="";
	}
		//alert("类型ok");
		//document.statistic.key_prog_name.focus();
		//return;
	
	if(window.document.statistic.time_flag.checked)
	{
		var from_year=window.document.statistic.from_year.value;
		var from_month=window.document.statistic.from_month.value;
		var from_day=window.document.statistic.from_day.value;
		if(from_month.length<2)
		{
			from_month="0"+from_month;
		}
		if(from_day.length<2)
		{
			from_day="0"+from_day;
		}
		var from_date=from_year+"-"+from_month+"-"+from_day;
		
		var to_year=window.document.statistic.to_year.value;
		var to_month=window.document.statistic.to_month.value;
		var to_day=window.document.statistic.to_day.value;
		if(to_month.length<2)
		{
			to_month="0"+to_month;
		}
		if(to_day.length<2)
		{
			to_day="0"+to_day;
		}
		var to_date=to_year+"-"+to_month+"-"+to_day;
	}
	else
	{
		var from_date="";
		var to_date="";
	}
	
	location="index.php?content=vod_prog_statis_2&key_prog_name="+key_prog_name+"&prog_kindthr="+prog_kindthr+"&from_date="+from_date+"&to_date="+to_date;
		//alert("时间ok");
		//document.statistic.key_prog_name.focus();
		//return;
	
	
	
}

</script>

<center>
<form action="" method=post name=statistic onsubmit="mysubmit()">
<table width="90%" border=0 rules=rows cellspacing=1 cellpadding=3 bgcolor=black>
<caption>统计条件</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>电影名称:</td>
	<td><input type=text name="key_prog_name"> (输入关键字即可)</td>
	<td><input type="checkbox" name="name_flag" value="ok" checked></td>
</tr>
<tr bgcolor=white>
	<td width="15%" align=right>统计类型:</td>
	<td><select name="prog_kindthr">
		<option value="">所有类型</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
	<td><input type="checkbox" name="type_flag" value="ok"></td>
</tr>
<tr bgcolor=white>
	<td align=right>统计时间:</td>
	<td>从<select name=from_year>
	<?
	for($i=2004;$i<=2005;$i++)
	{
		echo '<option value='.$i;
		if($i==2004)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?></select>年<select name=from_month>
	<?
	for($i=1;$i<=12;$i++)
	{
		echo '<option value='.$i;
		if($i==6)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>月<select name=from_day>
	<?
	for($i=1;$i<=31;$i++)
	{
		echo '<option value='.$i;
		if($i==1)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>日<br>
	到<select name=to_year>
	<?
	for($i=2004;$i<=2005;$i++)
	{
		echo '<option value='.$i;
		if($i==date("Y"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?></select>年<select name=to_month>
	<?
	for($i=1;$i<=12;$i++)
	{
		echo '<option value='.$i;
		if($i==date("n"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>月<select name=to_day>
	<?
	for($i=1;$i<=31;$i++)
	{
		echo '<option value='.$i;
		if($i==date("j"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>日</td>
	<td><input type="checkbox" name="time_flag" value="ok"></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=button onclick="mysubmit()" value="开始统计"></td>
</tr>
<tr bgcolor=white>
	<td colspan=3>
	提示:<br>
	目前只能统计mp4格式文件;<br>
	如果什么都不输入,则默认统计所有电影的点播情况,结果按点播次数由多到少排列,但是这种方式最好少用,特别是数据较多的时候.
	</td>
</tr>
</table>
</form>
</center>

