<?php
	if(unlink($filename))
	{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>���ݿⱸ���ļ���".$filename."���ѳɹ�ɾ������ȴ�ҳ���Զ���ת</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>����<a href=\"index.php\">�������</a></div>";
	}
	else
	{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
	echo "<div align=center>���ݿⱸ���ļ���".$filename."��ɾ��ʧ�ܣ���ȴ�ҳ���Զ���ת</div>";
	echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
	echo "<br><div align=center>����<a href=\"index.php\">�������</a></div>";
	}
?>