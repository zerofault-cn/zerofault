<?php
function filter($val) {
	return('.'!=substr($val,0,1));
}
function myReadDir($dir)//递归调用，以遍历目录树
{
	echo $dir."<br>";
	$file_arr=array_filter(scandir($dir),"filter");
	foreach($file_arr as $file)
	{
		if(is_dir($subdir=$dir.'/'.$file))//目录
		{
			myReadDir($subdir);
		}
		elseif(is_file($filepath=$dir.'/'.$file))//普通文件,且非隐藏文件
		{
			echo $filepath."<br>";
		}
	}
	
}

$dir=$_GET['dir'];
myReadDir($dir);

exit;
?>