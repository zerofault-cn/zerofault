<?php
	require("copyleft.env");
	require("connect.php");
	
	echo "<html><head><title>".$ver."  ".$copyleft."</title></head>";
	
	$select_db=mysql_select_db($dbname,$con) or die("Could not open database");
	
	$file=$dbbackdir."/".date("YmdHis").".sql";
	$fp=fopen($file,"w");
	
	fwrite($fp,"# ".$dbname." \n");
	fwrite($fp,"# ".$ver."\n");
	fwrite($fp,"# ".$copyleft."\n");
	fwrite($fp,"# ��������".$dbhost."  ���ݿ�����".$dbname."\n");
	fwrite($fp,"#---------------------------------------------------\n");
	
	//д�����ݿ�汾
	$show_version="select version()";
	$result_version=mysql_query($show_version,$con);
	$row_version=mysql_fetch_array($result_version);
	
	$str_version="#\n# MySQL Server Version: ".$row_version[0]."\n#;\n";
	fwrite($fp,$str_version);
	
	//ʹ�õ����ݿ���
	fwrite($fp,"use $dbname;\n");
	
	//�쿴���ݿ��еı�
	$show_tables="show tables";
	$result_tables=mysql_query($show_tables,$con);
	
	while($row_tables=mysql_fetch_array($result_tables))
	{
		
		fwrite($fp,"# ���ݱ�".$row_tables[0]."���Ľṹ;\n");
				
		//�������ھ�ɾ�����ڵı�
		fwrite($fp,"DROP TABLE IF EXISTS `$row_tables[0]`;\n");
		
		//д���Ľṹ
		$show_create="show create table $row_tables[0]";
		$result_create=mysql_query($show_create,$con) or die("error");
		$row_create=mysql_fetch_array($result_create);
		
		fwrite($fp,$row_create[1].";\n");
		
		fwrite($fp,"#\n# ���".$row_tables[0]."���в�������;\n#\n");
		
		$query="select * from $row_tables[0]";
		$result=mysql_query($query,$con);
		while($row_result=mysql_fetch_array($result))
		{
			//�������е��ֶ���
			$fields=mysql_list_fields($dbname,$row_tables[0],$con) or die("error");
			$colnum=mysql_num_fields($fields) or die("not read");
			
			fwrite($fp,"insert into `$row_tables[0]` (");
			
			for($i=0;$i<$colnum;$i++)
			{
				$field_name=mysql_field_name($fields,$i);
				fwrite($fp," `$field_name`");
				if($i!=$colnum-1)
				{
					fwrite($fp,", ");
				}
				else
				{
					fwrite($fp,") values (");
				}
			}
			
			for($i=0;$i<$colnum;$i++)
			{
				$field_name=mysql_field_name($fields,$i);
				fwrite($fp,"\"$row_result[$field_name]\"");
				if($i!=$colnum-1)
				{
					fwrite($fp,", ");
				}
				else
				{
					fwrite($fp,");\n");
				}
			}
		}
	}
	fclose($fp);
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
echo "<div align=center>���ݿ� ".$dbname." ���ݳɹ�����ȴ�ҳ���Զ���ת</div>";
echo "<meta HTTP-EQUIV=REFRESH CONTENT=\"3;URL=index.php\">";
echo "<br><div align=center>����<a href=\"index.php\">�������</a></div>";	
?>
