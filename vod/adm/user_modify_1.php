<html>
<head>
<title>�޸��û�����-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";

//��ѯ����
$sql1= "select * from user_info where user_id='".$user_id."'";
$result1=mysql_query($sql1);

$tmp=mysql_fetch_array($result1);

$user_type=$tmp[1];
$user_name=$tmp[3];
$fee_type=$tmp[18];
$prog_limit=$tmp[5];
$user_status=$tmp[19];
$user_id=$tmp[0];
$del=$tmp[13];
$user_idcard=$tmp[6];
$user_post=$tmp[7];
$user_tel=$tmp[8];
$user_addr=$tmp[9];
$user_email=$tmp[10];
?>

<script language="javascript">
function check()
{
	
	if(window.document.amend.user_pass.value!=window.document.amend.user_repass.value)
	{
		alert("������ǰ��һ��!");
		document.amend.user_repass.focus();
		return false;
	}
	
	return true;
}
</script>

<form action="user_modify_2.php" method=post name=amend onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=white align=center>
<caption>�޸��û�����</caption>

<tr>
	<td bgcolor=#d0d0d0 align=center>�û�ID</td>
	<td><?=$user_id?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>�û��˺�</td>
	<td><?=$tmp[2]?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>�û�����</td>
	<td><input type=password name=user_pass>(���޸�������)</td>
	
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>ȷ������</td>
	<td><input type=password name=user_repass></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>�û�����</td>
	<td><input type=text name=user_name value=<?=$user_name?>></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>�ͻ�����</td>
  <td><select name=user_type>
		<?
		$sql7="select utype_id,utype_mc from user_type order by utype_id";
		$result7=mysql_query($sql7);
		while($r=mysql_fetch_array($result7))
		{
			?>
			<option value="<?echo $tmp_utype=$r[0];?>"
			<?
			if($user_type==$tmp_utype)
			      echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>�ɷ�����</td>
  <td><select name="fee_type">
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=80 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?echo $r[0]?>"
			<?
			if($fee_type==$r[0])
			    echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>�ۿ�Ȩ��</td>
  <td><select name="prog_limit">
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?echo $r[0]?>"
			<?
			if($prog_limit==$r[0])
			    echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>�״̬</td>
  <td><select name=user_status>
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=120 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?echo $r[0]?>"
			<?
			if($user_status==$r[0])
			    echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>�Ƿ�ɾ��</td>
  <td><select name=user_del>
	<option value="1" <? if($del==1) echo "selected";?> >��</option>
	<option value="-1" <? if($del!=1) echo "selected";?> >��</option>	
	</select></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>��������</td>
	<td align=left><?=$tmp[12]?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>�˻����</td>
	<td align=left><?=$tmp[11]?></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>���֤��</td>
	<td align=left><input type=text name=user_idcard value="<?=$user_idcard?>"></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>��������</td>
	<td align=left><input type=text name=user_post value="<?=$user_post?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>��ϵ�绰</td>
	<td align=left><input type=text name=user_tel value="<?=$user_tel?>"></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>E-mail</td>
	<td align=left><input type=text name=user_email value="<?=$user_email?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>�û���ַ</td>
	<td align=left><input type=text name=user_addr value="<?=$user_addr?>"></td>
</tr>
<tr bgcolor=white>
        <td bgcolor=#d0d0d0 align=center>�������ʱ��</td>
	<td align=left><?=$tmp[16]?>&nbsp&nbsp<?=$tmp[17]?></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
	
</table>
<input type=hidden name=user_id value="<?=$user_id?>">
</form>
</body>
</html>