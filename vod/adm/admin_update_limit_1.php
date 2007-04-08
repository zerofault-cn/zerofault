<SCRIPT language=JavaScript>
function checkAll()
{
	document.form1.allsel.checked=false;
	var coll=document.forms["form1"].tags("input");
	for (i=0;i<coll.length;i++)
	{
		if (coll.item(i).name.substr(0,9)=="limitflag") 
		{
			coll.item(i).checked=false;
		}
	}
}
function change(col,v)
{
	var f = document.forms["form1"];
	for (i=0;i<f.elements.length;i++)
    {
		elem_name=f.elements[i].name;
		if (elem_name.substr(0,9)=="limitflag"&&elem_name.substring(elem_name.lastIndexOf('[')+1,elem_name.lastIndexOf(']'))==col)
		{
			f.elements[i].checked = v;
		}
	}
	
}	
</SCRIPT>

<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<form action="admin_update_limit_2.php" method=post name=form1>
<caption>更新管理员权限设置</caption>
<tr bgcolor=white>
	<td	align=center>权限描述</td>
	<td align=center>管理员列表</td>
</tr>
<tr bgcolor=white>
	<td valign=top>
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
	<tr bgcolor=#ffffff>
	<td align=center style="color:#ffffff">&nbsp;</td>
	</tr>
	<?
	include_once "../include/mysql_connect.php";
	$sql1="select dentry_id,dentry_name from dict_entry where del_flag=1 and dtype_id=70 order by dentry_id";
	$result1=mysql_query($sql1);
	$limittype_count=mysql_num_rows($result1);
	while($r=mysql_fetch_array($result1))
	{
		$dentry_id=$r[0];
		$dentry_id_r[]=$dentry_id;
		$dentry_name=$r[1];
		if($bgcolor!='#d0d0d1')
		{
			$bgcolor='#d0d0d1';
		}
		else
		{
			$bgcolor='#f0f0f1';
		}
		?>
		<tr bgcolor=<?=$bgcolor?>>
		<input type=hidden name="dentry_id_r[]" value="<?=$dentry_id?>">
		<td><?=$dentry_name?></td>
		</tr>
	<?
	}
	?>
	<tr bgcolor=#4682B4>
	<td align=right>选择整列--></td>
	</tr>
	</table>
	</td>
	<td valign=top>

<table width="100%" border=0 rules=cols cellspacing=1 cellpadding=0 bgcolor=black bordercolor=black>
<tr bgcolor=white>
<?
$sql2="select admin_id,admin_name from admin_info where del_flag=1 order by admin_id";
$result2=mysql_query($sql2);
$admin_count=mysql_num_rows($result2);
while($r=mysql_fetch_array($result2))
{
	$admin_id=$r[0];
	$admin_id_r[]=$admin_id;
	$admin_name=$r[1];
	?>
	<input type=hidden name="admin_id_r[]" value="<?=$admin_id?>">
	<td align="center"><?=$admin_name?></td>
	<?
}
?>
</tr>
<?
for($i=0;$i<$limittype_count;$i++)
{
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
	<?
	for($j=0;$j<$admin_count;$j++)
	{
		$sql3="select limitflag from admin_priority where admin_id='".$admin_id_r[$j]."' and limittype='".$dentry_id_r[$i]."'";
		$result3=mysql_query($sql3);
		if($r=mysql_fetch_array($result3))
		{
			$flag=$r[0];
		}
		else
		{
			$flag=0;
		}
		?>
		<td align=center><input type="checkbox" name="limitflag[<?=$i?>][<?=$j?>]" value="1" 
		<?
		if($flag)
		{
			echo ' checked ';
		}
		?>
		></td>
		<?
	}
	?>
	</tr>
	<?
}
?>
<tr bgcolor=#4682B4>
	<?
	for($j=0;$j<$admin_count;$j++)
	{
		?>
		<td align=center><input type="checkbox" name="colselect<?=$j?>" onclick="change(<?=$j?>,this.checked)"></td>
		<?
	}
	?>
</tr>
</table>
</td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="保存设置">&nbsp;&nbsp;<input type=reset value="重置"></td>
</tr>
</form>
</table>
