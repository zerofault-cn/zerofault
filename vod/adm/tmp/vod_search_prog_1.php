<!-- ��ӵ�Ӱ��Ŀ-1 -->
<script language="javascript">
function mysubmit()
{
	if(window.document.search.key_prog_name.value=="")
	{
		alert("��������������");
		document.search.key_prog_name.focus();
		return;
	}
	else if(window.document.search.key_prog_name.value.length<2)
	{
		alert("������Ĺؼ���̫����!");
		document.search.key_prog_name.focus();
		return;
	}
	else
	{
		var key_prog_name=window.document.search.key_prog_name.value;
		var prog_kindthr=window.document.search.prog_kindthr.value;
		var from_year=window.document.search.from_year.value;
		var from_month=window.document.search.from_month.value;
		var from_day=window.document.search.from_day.value;
		if(from_month.length<2)
		{
			from_month="0"+from_month;
		}
		if(from_day.length<2)
		{
			from_day="0"+from_day;
		}
		var from_date=from_year+"-"+from_month+"-"+from_day;
		var to_year=window.document.search.to_year.value;
		var to_month=window.document.search.to_month.value;
		var to_day=window.document.search.to_day.value;
		if(to_month.length<2)
		{
			to_month="0"+to_month;
		}
		if(to_day.length<2)
		{
			to_day="0"+to_day;
		}
		var to_date=to_year+"-"+to_month+"-"+to_day;
		location="index.php?content=vod_search_prog_2&key_prog_name="+key_prog_name+"&prog_kindthr="+prog_kindthr+"&from_date="+from_date+"&to_date="+to_date;
	}
	
}
function check()
{
	if(window.document.search.key_prog_name.value=="")
	{
		alert("��������������");
		document.search.key_prog_name.focus();
		return false;
	}
	return true;
}

</script>
<center>
<form action="index.php?content=vod_search_prog_2" method=post name=search onsubmit="return check()">
<table width="70%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>ӰƬ��������</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
	<td><input type=text name=key_prog_name>(����ؼ��ּ���)</td>
</tr>
<tr bgcolor=white>
	<td width="25%" align=right>��������:</td>
	<td><select name="prog_kindthr">
		<option value="">��������</option>
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
</tr>
<tr bgcolor=white>
	<td align=right>¼��ʱ��:</td>
	<td>��<select name=from_year>
	<?
	for($i=2004;$i<=2005;$i++)
	{
		echo '<option value='.$i;
		if($i==2004)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?></select>��<select name=from_month>
	<?
	for($i=1;$i<=12;$i++)
	{
		echo '<option value='.$i;
		if($i==6)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>��<select name=from_day>
	<?
	for($i=1;$i<=31;$i++)
	{
		echo '<option value='.$i;
		if($i==1)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>��<br>
	��<select name=to_year>
	<?
	for($i=2004;$i<=2005;$i++)
	{
		echo '<option value='.$i;
		if($i==date("Y"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?></select>��<select name=to_month>
	<?
	for($i=1;$i<=12;$i++)
	{
		echo '<option value='.$i;
		if($i==date("n"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>��<select name=to_day>
	<?
	for($i=1;$i<=31;$i++)
	{
		echo '<option value='.$i;
		if($i==date("j"))
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
	</select>��</td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="��ʼ����"></td>
</tr>
</table>
</form>
</center>
