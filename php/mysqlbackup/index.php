<?php
	require("copyleft.env");
	echo "<html><head><title>".$ver."  ".$copyleft."</title>";
	
	if(!file_exists("connect.php"))
	{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<p><p>";
	echo "<div align=center>ȱ�������ļ���</div>";
	echo "<div align=center>����ת������ҳ�棡</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=config.php\">";
	exit ;
	}
	else
	{
	require("connect.php");
	
	}
?>
<?
if ($downfile) 
	{
        if (!@ is_file($downfile))
            echo "��Ҫ���ص��ļ������ڣ�";
        $filename = basename($downfile);
        $filename_info = explode('.', $filename);
        $fileext = $filename_info[count($filename_info)-1];
        header('Content-type: application/x-'.$fileext);
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Description: PHP3 Generated Data');
        readfile($downfile);
        exit;
    }
?>
<style type="text/css">
.style1 {color: #000000; font-size:13px}
.style2 {color: #000000; font-size:13px}

a {
    font-size: 12px;
    color: #000000;
}
a:link {
    text-decoration: none;
    color: #000000;
}
a:visited {
    text-decoration: none;
    color: #666666;
}
a:hover {
    text-decoration: none;
    color: #000000;
}
a:active {
    text-decoration: none;
    color: #666666;
}
</style>
  <meta http-equiv="Content-Type" content="text/html; charset=GB18030">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body>
<center>
<p><p>
<h2><?php echo $ver;?></h2>
<p><h4><?php echo $copyleft;?></h4><p><p>
<table>
<tr>
<td>
	<form action=backup_sql.php method=post>
	<table border=0>
	<tr>
		<td>��ѡ��Ҫ���ݵ����ݿ⣺&nbsp</td>
		<td>
			<select name=dbname>
			<?php
			$sql_dbname="show databases";
			$result=mysql_query($sql_dbname);
			while($row_dbname=mysql_fetch_array($result))
				{
				echo "<option value=$row_dbname[0]>".$row_dbname[0]."</option>";
				}
			?>
			</select>
		</td>
		<td>
			<input type="submit" value="����">
		</td>
	</tr>
	</table>
	</form>
</td>
<td width="20"></td>
<td>
	<form action="upload_sql.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="1024000000">
	<table>
	<tr>
		<td>�ϴ����б����ļ���</td>
		<td>
			<input type="file" name="userfile">
		</td>
		<td><input type="submit" value="�ϴ�"></td>
	</tr>
	</table>
	</form>
</td>
</tr>
</table>
<p><p>
<table border="1" width="800" bgcolor="#09CCFD" class=style1>
	<tr align="center">
		<td width="50">���</td>
		<td width="150">���ݿ�����</td>
		<td width="150">���ݿⱸ��ʱ��</td>
		<td width="150">���ر����ļ�</td>
		<td width="150">���ݿ⻹ԭ</td>
		<td width="150">ɾ�������ļ�</td>
	</tr>
<?php
	if(!file_exists($dbbackdir))
	{
		mkdir($dbbackdir,0777);
	
	}
	if($handle_file=opendir($dbbackdir))
	{
		while(false !==($file=readdir($handle_file)))
		{
			$files[]=$file;
		}
		closedir($handle_file);
	}
	$count=count($files);
	for($i=2;$i<$count;$i++){
?>
	<tr align="center">
		<td><?php echo $i-1;?></td>
		<td>
	<?php
		$file_name=$files[$i];
		$fp=fopen($dbbackdir."/".$file_name,"r");
		$string=fgets($fp);
		$string_array=explode(" ",$string);
		echo $string_array[1];
	?>
		</td>
		<td>
	<?php
		$filetime_array=explode(".",$file_name);
		$filetime=$filetime_array[0];
		echo substr($filetime,0,4)."-".substr($filetime,4,2)."-".substr($filetime,6,2)." ".substr($filetime,8,2).":".substr($filetime,10,2).":".substr($filetime,12,2);
	?>
		</td>
	 	<td><div align="center" class="style2"><?php echo "<a href='test.php?downfile=$dbbackdir/$file_name' target='_blank'>����</a>";?></div></td>
		<td class=style2><a href="recover_sql.php?filename=<?php echo $dbbackdir."/".$file_name;?>">��ԭ</a></td>
		<td class=style2><a href="delete_sql.php?filename=<?php echo $dbbackdir."/".$file_name;?>">ɾ��</a></td>
	</tr>
	
<?php } ?>
</table>
</body>
</html>
