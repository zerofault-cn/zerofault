<?php
function filter($val) {
	return('.'!=substr($val,0,1));
}
function myReadDir($dir)//�ݹ���ã��Ա���Ŀ¼��
{
	echo $dir."<br>";
	$file_arr=array_filter(scandir($dir),"filter");
	foreach($file_arr as $file)
	{
		if(is_dir($subdir=$dir.'/'.$file))//Ŀ¼
		{
			myReadDir($subdir);
		}
		elseif(is_file($filepath=$dir.'/'.$file))//��ͨ�ļ�,�ҷ������ļ�
		{
			echo $filepath."<br>";
		}
	}
	
}

$dir=$_GET['dir'];
myReadDir($dir);

exit;
?>