<html>
<head>
<meta http-equiv="refresh" content="5;">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body topmargin=0 leftmargin=0 style="background:transparent;overflow:auto">
<table width="98%"  border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="19"></td>
		<td width="5">&nbsp;</td>
		<td width="80" align="left"><span id="showtime">00:00:00</span></td>
		<td width="80" align="left"></td>
		<td width="5">&nbsp;</td>
		<td>admin; <span id="chat_man"></span></td>
	</tr>
	</table>
	<table width="98%" height="100%"  border="1" align="center" cellspacing="1">
	<tr>
		<td valign="top" ><iframe id="showmsg" name="showmsg" marginheight="0" marginwidth="0" width="100%" height="100%" frameborder="0" scrolling=auto src="chat_showmsg.php"></iframe></td>
	</tr>
	</table><?
include_once "mysql_connect.php";
$sql1="select message_info from im_info where user_flag='".session_id()."' and revert_flag=1 order by message_send_ID desc limit 1";
$result1=mysql_query($sql1);
if(mysql_num_rows($result1)>0)
{
	$message=mysql_result($result1,0,0).'<br>';
	?>
	<script>
	showmsg.getElementById("showmsg").innerHTML+="<?=$message?>";
	</script>
	<?
}
?>
</body>
</html>