<?

$url="http://szgoldway.meibu.com:8080/map/getDateforday.do?un=javalu&pw=123456&date=2006-4-15";
$source=@file_get_contents($url);
$fwp=fopen('getGoogleData.xml',"w"); 
$fw=fwrite($fwp,$source);
$fc=fclose($fwp);

header("location:getGoogleData.xml");
?>