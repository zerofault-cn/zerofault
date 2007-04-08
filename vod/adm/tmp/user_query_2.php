<!--用户查询-2-->
<?
include_once "../include/mysql_connect.php";

//建立用户账号查询条件
if($key_user_account!="")
{
	$account_condition=" and user_account like '%".$key_user_account."%'";
}
else
{
	$account_condition="";
}

//建立开户时间查询条件
if(($from_date!="")&&($to_date!=""))
{
	$date_condition=" and user_opendate>='".$from_date."' and user_opendate<='".$to_date."'";
}
else
{
	$date_condition="";
}

//建立用户姓名查询条件
if($key_user_name!="")
{
	$name_condition=" and user_name like '%".$key_user_name."%'";
}
else
{
	$name_condition="";
}

//建立用户类型查询条件
if($user_type!="")
{
	$user_type_condition=" and utype_id='".$user_type."'";
}
else
{
	$user_type_condition="";
}

//建立交费类型查询条件
if($fee_type!="")
{
	$fee_type_condition=" and user_chargetype='".$fee_type."'";
}
else
{
	$fee_type_condition="";
}

//建立观看权限查询条件
if($prog_limit!="")
{
	$limit_condition=" and user_limit='".$prog_limit."'";
}
else
{
	$limit_condition="";
}

//查询数据
$sql1= "select * from user_info where 1 ".$account_condition.$date_condition.$name_condition.$user_type_condition.$fee_type_condition.$limit_condition." order by user_id";
$result1=mysql_query($sql1);

?>
<script language="javascript">
function del(user_id)
{
	
	if(confirm("确定要删除该用户吗?"))
	{
		window.location="user_del.php?user_id="+user_id;
	}
	else
		return;
}
</script>

<table width="588" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>用户查询结果</caption>
<tr bgcolor=white>
	<td align=center>用户帐户</td>
	<td align=center>用户姓名</td>
	<td align=center>用户类型</td>
	<td align=center>交费类型</td>	
	<td align=center>观看权限</td>
	<td align=center>开户时间</td>
	<td align=center>活动状态</td>
	<td align=center>帐户余额</td>
	<td align=center>操作</td>
</tr>

<?
//输出结果
while($tmp=mysql_fetch_array($result1))
{
	$tmp_user_id=$tmp[0];
	$tmp_user_type=$tmp[1];
	$query_account=$tmp[2];
	$query_name=$tmp[3];
	$tmp_limit=$tmp[5];
	$query_balance=$tmp[11];
	$query_opendate=$tmp[12];
	$tmp_fee_type=$tmp[18];
	$tmp_status=$tmp[19];
	

	$sql2= "select utype_mc from user_type where utype_id='".$tmp_user_type."'";
	$result2=mysql_query($sql2);
	$query_user_type=mysql_result($result2,0,0);

	$sql3= "select dentry_name from dict_entry where dentry_id='".$tmp_fee_type."'";
	$result3=mysql_query($sql3);
	$query_fee_type=mysql_result($result3,0,0);

	$sql4= "select dentry_name from dict_entry where dentry_id='".$tmp_limit."'";
	$result4=mysql_query($sql4);
	$query_limit=mysql_result($result4,0,0);

	$sql5= "select dentry_name from dict_entry where dentry_id='".$tmp_status."'";
	$result5=mysql_query($sql5);
	$query_status=mysql_result($result5,0,0);

	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
?>

<tr bgcolor=<?=$bgcolor?>>
	<td align=center><a href="#"><?=$query_account?></a></td>
	<td align=center><?=$query_name?></td>
	<td align=center><?=$query_user_type?></td>
	<td align=center><?=$query_fee_type?></td>
	<td align=center><?=$query_limit?></td>
	<td align=center><?=$query_opendate?></td>
	<td align=center><?=$query_status?></td>
	<td align=center><?=$query_balance?></td>
		<td align=center><input type=button onclick="javascript:window.open('user_modify_1.php?user_id=<?=$tmp_user_id?>','','width=350,height=490,toolbar=no,status=no,scrollbars=auto,resizable=yes')" value="修改" title="查看或修改用户信息"><input type=button onclick='del(<?=$tmp_user_id?>)' value="删除" title="删除用户"></td>
</tr>

<?
}
?>

</table>

