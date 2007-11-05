<html>
<head>
<meta http-equiv="refresh" content="5;">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body topmargin=0 leftmargin=0 style="background:transparent;overflow:auto">
<?
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