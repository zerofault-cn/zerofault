<html>
<head>
<title>修改用户资料-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";

//查询数据
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
		alert("新密码前后不一致!");
		document.amend.user_repass.focus();
		return false;
	}
	
	return true;
}
</script>

<form action="user_modify_2.php" method=post name=amend onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=white align=center>
<caption>修改用户资料</caption>

<tr>
	<td bgcolor=#d0d0d0 align=center>用户ID</td>
	<td><?=$user_id?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>用户账号</td>
	<td><?=$tmp[2]?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>用户密码</td>
	<td><input type=password name=user_pass>(不修改则留空)</td>
	
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>确认密码</td>
	<td><input type=password name=user_repass></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>用户姓名</td>
	<td><input type=text name=user_name value=<?=$user_name?>></td>
</tr>
<tr bgcolor=white>
  <td align=center bgcolor=#d0d0d0>客户类型</td>
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
  <td align=center bgcolor=#d0d0d0>缴费类型</td>
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
  <td align=center bgcolor=#d0d0d0>观看权限</td>
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
  <td align=center bgcolor=#d0d0d0>活动状态</td>
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
  <td align=center bgcolor=#d0d0d0>是否删除</td>
  <td><select name=user_del>
	<option value="1" <? if($del==1) echo "selected";?> >否</option>
	<option value="-1" <? if($del!=1) echo "selected";?> >是</option>	
	</select></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>开户日期</td>
	<td align=left><?=$tmp[12]?></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>账户余额</td>
	<td align=left><?=$tmp[11]?></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>身份证号</td>
	<td align=left><input type=text name=user_idcard value="<?=$user_idcard?>"></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>邮政编码</td>
	<td align=left><input type=text name=user_post value="<?=$user_post?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>联系电话</td>
	<td align=left><input type=text name=user_tel value="<?=$user_tel?>"></td>
</tr>
<tr>
	<td bgcolor=#d0d0d0 align=center>E-mail</td>
	<td align=left><input type=text name=user_email value="<?=$user_email?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=center>用户地址</td>
	<td align=left><input type=text name=user_addr value="<?=$user_addr?>"></td>
</tr>
<tr bgcolor=white>
        <td bgcolor=#d0d0d0 align=center>最近操作时间</td>
	<td align=left><?=$tmp[16]?>&nbsp&nbsp<?=$tmp[17]?></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
	
</table>
<input type=hidden name=user_id value="<?=$user_id?>">
</form>
</body>
</html>