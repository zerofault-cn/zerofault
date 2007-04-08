<!--更新SDP-1 -->
<html>
<head>
<title>修改电影节目</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	
	if(window.document.modify.sdp_file.value=="")
	{
		alert("您忘了选择文件");
		document.modify.sdp_file.focus();
		return false;
	}
	sdp_file=window.document.modify.sdp_file.value;
	sdp_file_ext=sdp_file.substring(sdp_file.lastIndexOf("."));
	if(sdp_file_ext!='.sdp')
	{
		alert("您选择的不是SDP文件");
		window.document.modify.sdp_file.focus();
		return false;
	}
	return true;
}
</script>
<?
include_once "../include/mysql_connect.php";
$sql1="select station_name,station_path from epg_station where station_id=".$station_id;
$result1=mysql_query($sql1);
$station_name=mysql_result($result1,0,0);
$station_path=mysql_result($result1,0,1);//sdp://sntx.169ol.com:8088/sdp/84-08.xml
$xml_file_name=substr($station_path,strrpos($station_path,'/')+1);
$sdp_file_name=str_replace('xml','sdp',$xml_file_name);
?>
<body>
<form action="epg_modify_sdp_2.php" method=post ENCTYPE="multipart/form-data" name=modify onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>更新 <?=$station_name?> SDP</span></caption>
<tr bgcolor=white>
	<td align=right>原SDP文件名:</td>
	<td><span style="color:red"><?=$sdp_file_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>新的SDP文件:</td>
	<td><input type=file name=sdp_file>(后缀必须是.sdp)</td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=station_id value="<?=$station_id?>"></td>
	<td><input type=submit value=更新></td>
</tr>
</table>
</form>
</body>
</html>
