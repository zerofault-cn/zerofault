<?
$login_msg=$_REQUEST["login_msg"];
?>
<script language="javascript">
function check()
{
	
	if(window.document.login.admin_pass.value=="")
	{
		alert("ÄúÍüÁËÊäÈëÃÜÂë");
		document.login.admin_pass.focus();
		return false;
	}
	return true;
}
</script>


<center>
<?
if(isset($login_msg)&&$login_msg!="")
{
	?>
	<script>
		alert("<?=$login_msg?>");
	</script>
	<?
	setcookie("login_msg","");
}
?>
<table>
<caption>ÇëÄúµÇÂ¼</caption>
<form action="login_2.php" name=login method=post>
<tr>
	<td align=right>ÓÃ»§Ãû:</td>
	<td>
	<select name=admin_account>
	<?
	include_once "../include/mysql_connect.php";
	$sql1="select admin_account from admin_info order by admin_id";
	$result1=mysql_query($sql1);
	while($r=mysql_fetch_array($result1))
	{
		$admin_account=$r[0];
		?>
		<option value='<?=$admin_account?>'><?=$admin_account?></option>
		<?
	}
	?>
	</select>
	</td>
</tr>
<tr>
	<td align=right>ÃÜÂë:</td>
	<td><input type=password name=admin_pass value=""></td>
</tr>
<tr>
	<td></td>
	<td><input type=submit value=µÇÂ¼ onclick="return check();"></td>
</tr>
</form>
</table>

</center>
