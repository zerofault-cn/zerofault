<!-- 用户查询-1 -->

<script language="javascript">
function mysubmit()
{
	//判断是否根据用户账号查询
	if(window.document.user_query.account_flag.checked)
	{
		var key_user_account=window.document.user_query.key_user_account.value;
	}
	else
	{
		var key_user_account="";
	}
	
	//判断是否根据用户姓名查询
	if(window.document.user_query.name_flag.checked)
	{
		var key_user_name=window.document.user_query.key_user_name.value;
	}
	else
	{
	 	var key_user_name="";
	}
	
	//判断是否根据开户时间查询
	if(window.document.user_query.time_flag.checked)
	{
		var from_year=window.document.user_query.from_year.value;
		var from_month=window.document.user_query.from_month.value;
		var from_day=window.document.user_query.from_day.value;
		if(from_month.length<2)
		{
			from_month="0"+from_month;
		}
		if(from_day.length<2)
		{
			from_day="0"+from_day;
		}
		var from_date=from_year+"-"+from_month+"-"+from_day;
		
		var to_year=window.document.user_query.to_year.value;
		var to_month=window.document.user_query.to_month.value;
		var to_day=window.document.user_query.to_day.value;
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
	
	//判断是否根据用户类型查询
	if(window.document.user_query.user_type_flag.checked)
	{
		var user_type=window.document.user_query.user_type.value;
	}
	else
	{
	 	var user_type="";
	}
	
	//判断是否根据交费类型查询
	if(window.document.user_query.fee_type_flag.checked)
	{
		var fee_type=window.document.user_query.fee_type.value;
	}
	else
	{
	 	var fee_type="";
	}
	
	//判断是否根据观看权限查询
	if(window.document.user_query.prog_limit_flag.checked)
	{
		var prog_limit=window.document.user_query.prog_limit.value;
	}
	else
	{
	 	var prog_limit="";
	}
	location="index.php?content=user_query_2&key_user_account="+key_user_account+"&key_user_name="+key_user_name+"&from_date="+from_date+"&to_date="+to_date+"&user_type="+user_type+"&fee_type="+fee_type+"&prog_limit="+prog_limit;
}
</script>

<center>
<form action="" method=post name=user_query>
<table width="90%" border=0 rules=rows cellspacing=1 cellpadding=3 bgcolor=black>
<caption>用户查询</caption>
<tr bgcolor=white>
	<td align=right>用户账号:</td>
	<td><input type=text name="key_user_account"> (输入关键字即可)</td>
	<td><input type="checkbox" name="account_flag" value="ok" ></td>
</tr>
<tr bgcolor=white>
	<td align=right>用户姓名:</td>
	<td><input type=text name="key_user_name"> (输入关键字即可)</td>
	<td><input type="checkbox" name="name_flag" value="ok" ></td>
</tr>
<tr bgcolor=white>
	<td align=right>开户时间:</td>
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
  <td align=right>客户类型:</td>
  <td><select name="user_type">
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select utype_id,utype_mc from user_type order by utype_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
		<td><input type="checkbox" name="user_type_flag" value="ok" ></td>
</tr>
<tr bgcolor=white>
  <td align=right>缴费类型:</td>
  <td><select name="fee_type">
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=80 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
		<td><input type="checkbox" name="fee_type_flag" value="ok" ></td>
</tr>
<tr bgcolor=white>
  <td align=right>观看权限:</td>
  <td><select name="prog_limit">
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
		<td><input type="checkbox" name="prog_limit_flag" value="ok" ></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=button onclick="mysubmit()" value="开始查询"></td>
</tr>
</table>
</form>
</center>
