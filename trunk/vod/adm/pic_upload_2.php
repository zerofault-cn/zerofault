<!-- 添加歌手信息-2,涉及文件上传 -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
if($pic_type=="haibao")
{
	$haibao_file_name=$id.strrchr($pic_name,".");
	$upflag=copy($pic,"/jbproject/tomcat/goldsoft/php-vod/haibao/".$haibao_file_name);
	if($upflag)
	{
		$sql1="update prog_info set publisher='".$haibao_file_name."' where prog_id=".$id;
	}
}
elseif($pic_type=="photo")
{
	if(isset($pic)&&$pic!="")
	{
		$fp=fopen($pic,"r");
		$photo_data=addslashes(fread($fp,filesize($pic)));
		fclose($fp);
		$upflag=1;
		$sql1="update singer_info set photo='".$photo_data."' where singer_id=".$id;
	}
}
elseif($pic_type!='')
{
	$pic_dir='/jbproject/tomcat/goldsoft/php-vod/'.$pic_type;
	if(!file_exists($pic_dir))
	{
		umask(000);
		mkdir($pic_dir,0777);
	}
	$pic_file_name=date("YmdHis").strrchr($pic_name,".");
	$upflag=copy($pic,$pic_dir.'/'.$pic_file_name);
	$imgsize=GetImageSize($pic);
}
if($upflag&&$pic_type!='haibao'&&$pic_type!='photo')
{
	?>
	<script language="javascript" type="text/javascript">
	text ="<div align=center><img src=http://<?=$_SERVER['HTTP_HOST']?>/<?=$pic_type?>/<?=$pic_file_name?> width=<?=$imgsize[0]?> height=<?=$imgsize[1]?>></div>";
	opener.document.forms['add'].info.focus();
	opener.document.forms['add'].info.value+= text;
	opener.document.forms['add'].info.focus();
//	alert("插入成功");
	window.close();
	</script>
	<?
}
elseif($upflag)
{
	if(mysql_query($sql1))
	{
		?>
		<script>
			alert("上传成功!");
			window.opener.location.reload();
			window.close();
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
else
{
	?>
	<script>
		alert("文件上传失败，请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>
