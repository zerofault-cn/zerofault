<?
@session_start();
$index_file="index.txt";//记录留言信息文件的文件名
$msgDir="data/";//保存留言信息文件的目录
$msgFileExt=".txt";//设定文件扩展名
$pageitem=5;//设定每页显示多少条

//设定管理员用户名密码
$adminArr[0][0]='admin';
$adminArr[0][1]='nimda';
$adminArr[1][0]='wxh';
$adminArr[1][1]='wxh';

if(''!=$_SESSION['boardadmin'])
{
	$echoEmail=1;//设定显示email
}
?>