<!--�û���ѯ-2-->
<?
include_once "../include/mysql_connect.php";

//�����û��˺Ų�ѯ����
if($key_user_account!="")
{
	$account_condition=" and user_account like '%".$key_user_account."%'";
}
else
{
	$account_condition="";
}

//��������ʱ���ѯ����
if(($from_date!="")&&($to_date!=""))
{
	$date_condition=" and user_opendate>='".$from_date."' and user_opendate<='".$to_date."'";
}
else
{
	$date_condition="";
}

//�����û�������ѯ����
if($key_user_name!="")
{
	$name_condition=" and user_name like '%".$key_user_name."%'";
}
else
{
	$name_condition="";
}

//�����û����Ͳ�ѯ����
if($user_type!="")
{
	$user_type_condition=" and utype_id='".$user_type."'";
}
else
{
	$user_type_condition="";
}

//�����������Ͳ�ѯ����
if($fee_type!="")
{
	$fee_type_condition=" and user_chargetype='".$fee_type."'";
}
else
{
	$fee_type_condition="";
}

//�����ۿ�Ȩ�޲�ѯ����
if($prog_limit!="")
{
	$limit_condition=" and user_limit='".$prog_limit."'";
}
else
{
	$limit_condition="";
}

//��ѯ����
$sql1= "select * from user_info where 1 ".$account_condition.$date_condition.$name_condition.$user_type_condition.$fee_type_condition.$limit_condition." order by user_id";
$result1=mysql_query($sql1);

?>
<script language="javascript">
function del(user_id)
{
	
	if(confirm("ȷ��Ҫɾ�����û���?"))
	{
		window.location="user_del.php?user_id="+user_id;
	}
	else
		return;
}
</script>

<table width="588" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�û���ѯ���</caption>
<tr bgcolor=white>
	<td align=center>�û��ʻ�</td>
	<td align=center>�û�����</td>
	<td align=center>�û�����</td>
	<td align=center>��������</td>	
	<td align=center>�ۿ�Ȩ��</td>
	<td align=center>����ʱ��</td>
	<td align=center>�״̬</td>
	<td align=center>�ʻ����</td>
	<td align=center>����</td>
</tr>

<?
//������
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
		<td align=center><input type=button onclick="javascript:window.open('user_modify_1.php?user_id=<?=$tmp_user_id?>','','width=350,height=490,toolbar=no,status=no,scrollbars=auto,resizable=yes')" value="�޸�" title="�鿴���޸��û���Ϣ"><input type=button onclick='del(<?=$tmp_user_id?>)' value="ɾ��" title="ɾ���û�"></td>
</tr>

<?
}
?>

</table>

