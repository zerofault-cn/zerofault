<?php
	require("connect.php");
	require("copyleft.env");
	
	echo "<title>".$ver."  ".$copyleft."</title>";
	
	if($userfile=="none")
		{
			echo "�ļ�����Ϊ�գ�";
			exit;
		}
	if($userfile_size==0)
		{
			echo "�ļ���С����Ϊ0��";
			exit;
		}
	if(!is_uploaded_file($userfile))
		{
			echo "�ļ��ϴ�ʧ�ܣ�";
			exit;
		}
	$upfile=$dbbackdir."/".$userfile_name;
	if(!copy($userfile,$upfile))
		{
			echo "�ļ��ϴ�ʧ�ܣ�";
			exit;
		}
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>�ļ���".$userfile_name."���Ѿ��ɹ��ϴ�����ȴ�ҳ���Զ���ת</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>����<a href=\"index.php\">�������</a></div>";	
?>