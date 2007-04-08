<?php
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
if(strpos($source,"\\"))
{
	$source_file_name=substr(strrchr($source,"\\"),1);
}
elseif(strpos($source,"/"))
{
	$source_file_name=substr(strrchr($source,"/"),1);
}
else
{
	$source_file_name=$source;
}
$source_list_name="list__".$source_file_name;
$sql1="select * from daily_source where type='".$type."' and source='".$source_list_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库已存在相同路径");
		window.history.go(-1);
	</script>
	<?
}
else
{
	echo "请把文件上传至:ftp://221.10.222.91/daily_source/";
	/*$list_text="/usr/suit/ad/cnc_china169.wmv\n";
	for($i=0;$i<10;$i++)
	{
		$list_text.="mms://sntx.169ol.com/bod/daily_source/".$source_file_name."\n";
	}*/
	if(strrchr($source_file_name,".")=='.wmv'||strrchr($source_file_name,".")=='.WMV')
	{
		$list_text="mms://sntx.169ol.com/bod/daily_source/".$source_file_name;
	}
	if(strrchr($source_file_name,".")=='.rm'||strrchr($source_file_name,".")=='.RM')
	{
		$list_text="rtsp://sntx.169ol.com:555/bod/daily_source/".$source_file_name;
	}
	$fp=fopen("../daily_list/".$source_list_name,"w"); 
	$fw=fwrite($fp,$list_text); 
	fclose($fp);
	$sql2="insert into daily_source(title,source,descr,time,type) values('".$title."','".$source_list_name."','".format($descr)."',now(),'".$type."')";
	if($fw&&mysql_query($sql2))
	{
		?>
		<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.php?content=daily_add_source_1";
		else
			window.location="index.php?content=daily_source";
		</script>
		<?
	}
	else
	{
		?>
		<script>
		alert("添加记录失败,请检查重试,或者报告管理员");
		window.history.go(-1);
		</script>
		<?
	}
}
?>