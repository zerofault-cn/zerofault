<?
// db debug
$time_start = getmicrotime();
mysql_connect("localhost","root","123456");
//@mysql_select_db("cms");
//@mysql("create database testdb");
mysql_select_db("mm2007");

include("./PageItem.php");
$pi = new PageItem("select * from mm_comment order by id desc limit 0,20");

echo "<html><head>\n";
echo "<head><meta http-equiv='content-type' content='text/html;charset=gb2312'>\n<title>类使用示例--Boban@21php.com</title></head>";
echo "<body>";
echo "<p align=center style='font-size:9pt'>PHP服务器系统：".PHP_OS."<br>";
echo "<br>";
$records = $pi->getrecord();
if(is_array($records))
{
	while(list($key,$val)=each($records))
	{
		echo $key.":".$val['username'].":".$val['content']."(".date("Y-m-d h:i:s",$val['addtime']).")<br>\n";;
	}
}
echo "<br>";
$pi->myPageItem();

//$charset = mysql_client_encoding($auth->bb_db_conn);
//printf ("current character set is %s\n", $charset);

?>

<?
echo "</body></html>";
$time_end = getmicrotime();
printf("<br>{程序执行时间: %0.3f 秒}</p>\n",$time_end - $time_start);
function getmicrotime()
{ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
} 
?>