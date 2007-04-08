<?php
	require("connect.php");
	require("copyleft.env");
	
	echo "<title>".$ver."  ".$copyleft."</title>";
	
	if($userfile=="none")
		{
			echo "文件不能为空！";
			exit;
		}
	if($userfile_size==0)
		{
			echo "文件大小不能为0！";
			exit;
		}
	if(!is_uploaded_file($userfile))
		{
			echo "文件上传失败！";
			exit;
		}
	$upfile=$dbbackdir."/".$userfile_name;
	if(!copy($userfile,$upfile))
		{
			echo "文件上传失败！";
			exit;
		}
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>文件　".$userfile_name."　已经成功上传！请等待页面自动跳转</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>或者<a href=\"index.php\">点击返回</a></div>";	
?>