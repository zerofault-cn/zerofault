<?
$type=$_REQUEST['type'];
$url=$_REQUEST['url'];
$filename=@basename($url);
if($type=='point')
{
	$url="getGoogleData.xml";
//	$url="http://szgoldway.meibu.com:8080/map/getGoogleData.do?un=javalu&pw=123456&date=2006-4-17&random=".date("s");
//	$filename1='point_1.xml';
//	$filename0='point_0.xml';
//	$filename=date("s")%2==0?$filename0:$filename1;
	$filename='xml_file/point_'.date("s").'.xml';
}
if($type=='line')
{
	$filename="line_2006-4-15.xml";
	header("content-type: text/xml");
	header("location:".$filename);
	exit;
	$url="http://szgoldway.meibu.com:8080/map/getGoogleDataforday.do?un=javalu&pw=123456&date=2006-4-15";
	$filename='xml_file/line_'.substr($url,strrpos($url,'=')+1).'.xml';
}
//$url="http://www.whereismygps.net/data.php?user=Leddy";
//$filename='ab.txt';
$source=file_get_contents($url);
$fwp=fopen($filename,"w"); 
$fw=fwrite($fwp,$source);
$fc=fclose($fwp);
if($fw)
{
	header("content-type: text/xml");
	header("location:".$filename);
}
?>