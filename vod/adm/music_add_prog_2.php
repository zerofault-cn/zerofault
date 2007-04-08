<!-- 添加音乐节目-2 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
include_once "toPinyin.php";
$sql1="select count(*),SUBSTRING_INDEX(prog_path, '/', 2) from prog_info where prog_kindsec=1026 and (prog_path like '%server11%' or prog_path like '%server12%' or prog_path like '%server13%') group by 2";
$result1=mysql_query($sql1);
$min=mysql_result($result1,0,0);
$min_path=mysql_result($result1,0,1);
while($r=mysql_fetch_array($result1))
{
	$tmp=$r[0];
	$tmp_path=$r[1];
	if($tmp<$min)
	{
		$min=$tmp;
		$min_path=$tmp_path;
	}
}
//$publisher=AddSlashes($publisher);
$prog_acot=words($prog_name);
//$prog_acot=addslashes($prog_acot);
$prog_timespan=strlen($prog_name);
//$prog_name=AddSlashes($prog_name);//先取得拼音和字数,再添加"\"
$prog_path=$min_path."/".substr(strrchr($prog_path,"\\"),1);
//$prog_path=AddSlashes($prog_path);
$sql1="select * from prog_info where binary prog_path='".$prog_path."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("数据库已存在相同路径!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	$sql2="select max(prog_id) from prog_info";
	$result2=mysql_query($sql2);
	$prog_id=mysql_result($result2,0,0);
	$prog_id=$prog_id+1;
	
	$depre_id=1;
	$prog_stype=1000;
	$prog_format=1012;
	$prog_kindfir=999;
	$prog_kindsec=1026;
	$prog_kindthr=1026;
	$prog_kindfor=0;
	$del_flag=-1;
	$director="";
	$prog_limit=600;
	$count=0;
	$sql3="insert into prog_info (prog_id,depre_id,prog_name,prog_stype,prog_format,prog_kindfir,prog_kindsec,prog_kindthr,prog_kindfor,prog_indate,prog_path,prog_size,prog_timespan,publisher,pubdate,prog_acot,prog_describe,del_flag,operator,operdate,opertime,director,zoom_flag,prog_limit,count,quality) values(".$prog_id.",".$depre_id.",'".$prog_name."',".$prog_stype.",".$prog_format.",".$prog_kindfir.",".$prog_kindsec.",".$prog_kindthr.",".$prog_kindfor.",CURDATE(),'".$prog_path."','".$prog_size."','".$prog_timespan."','".$publisher."','".$pubdate."','".$prog_acot."','".$prog_describe."',".$del_flag.",'".$goldsoft_admin."',CURDATE(),CURTIME(),'".$director."','".$zoom_flag."',".$prog_limit.",".$count.",'".$quality."')";
	if(mysql_query($sql3))
	{
		?>
		<script>
			alert("提示:您需要用将文件上传到<?=substr($min_path,4)?>目录");
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=music_add_prog_1";
			else
				window.location="index.php";
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
