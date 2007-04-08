<!-- 添加电影节目-1 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
if(strpos($prog_file,"\\"))
{
	$file_name=substr(strrchr($prog_file,"\\"),1);
}
$sql1="select * from prog_info where SUBSTRING_INDEX(prog_path,'/',-1)='".$file_name."'";
$result1=mysql_query($sql1);
if(mysql_fetch_array($result1))
{
	?>
	<script>
		alert("您已经添加过这个文件了");
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
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	//取得存文件最少的服务器
	if($s_ip==90||$s_ip==91||$s_ip==92)
	{
		$sql3="select count(*),SUBSTRING_INDEX(prog_path, '/', 2) from prog_info where prog_kindsec=1006 and (prog_path like '%server11_%' or prog_path like '%server12_%' or prog_path like '%server13_%') group by 2";
	}
	else
	{
		$sql3="select count(*),SUBSTRING_INDEX(prog_path, '/', 2) from prog_info where prog_kindsec=1006 and (prog_path like '%server14_%' or prog_path like '%server15_%' or prog_path like '%server16_%') and prog_path not like '%server15_3%' group by 2";
	}
	$result3=mysql_query($sql3);
	$min=mysql_result($result3,0,0);
	$min_path=mysql_result($result3,0,1);
	while($r=mysql_fetch_array($result3))
	{
		$tmp=$r[0];
		$tmp_path=$r[1];
		if($tmp<$min)
		{
			$min=$tmp;
			$min_path=$tmp_path;
		}
	}
//	$prog_name=AddSlashes($prog_name);
	$prog_path=$min_path."/".$file_name;
//	$prog_path=AddSlashes($prog_path);
	$publisher=$haibao_file_name;//用publisher列来保存海报
//	$director=AddSlashes($director);
//	$prog_acot=AddSlashes($prog_acot);
//	$prog_describe=addslashes($prog_describe);
	$prog_describe=htmlspecialchars($prog_describe);
	$prog_describe=str_replace(" ","&nbsp;",$prog_describe);
	$prog_describe=nl2br($prog_describe);
	//固定变量
	$depre_id=1;
	$prog_stype=1000;
	$prog_format=1012;
	$prog_kindfir=999;
	$prog_kindsec=1006;
	$prog_kindfor=0;
	$del_flag=-1;//默认为无效,文件上传成功后虚需手动设置有效
	$prog_limit=600;
	$count=0;
	$sql4="insert into prog_info (prog_id,depre_id,prog_name,prog_stype,prog_format,prog_kindfir,prog_kindsec,prog_kindthr,prog_kindfor,prog_indate,prog_path,prog_size,prog_timespan,publisher,pubdate,prog_acot,prog_describe,del_flag,operator,operdate,opertime,director,zoom_flag,prog_limit,count,quality) values(".$prog_id.",".$depre_id.",'".$prog_name."',".$prog_stype.",".$prog_format.",".$prog_kindfir.",".$prog_kindsec.",".$prog_kindthr.",".$prog_kindfor.",CURDATE(),'".$prog_path."','".$prog_size."','".$prog_timespan."','".$publisher."','".$pubdate."','".$prog_acot."','".$prog_describe."',".$del_flag.",'".$goldsoft_admin."',CURDATE(),CURTIME(),'".$director."','".$zoom_flag."',".$prog_limit.",".$count.",'".$quality."')";
	if(mysql_query($sql4))
	{
		echo "提示:您需要用将文件上传到".substr($min_path,4)."目录";
		?>
		<script>
			alert("提示:您需要用将文件上传到<?=substr($min_path,4)?>目录");
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.php?content=vod_add_prog_1";
			else
				window.location="index.php?content=vod_prog";
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
