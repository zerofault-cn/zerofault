<?
$lng=$_REQUEST['lng'];
$lat=$_REQUEST['lat'];
$url="http://freemosp.51ditu.com/mosp/encrypt.jsp?ps=".$lng.",".$lat;

$source=file_get_contents($url);

$source=str_replace('<html>','',$source);
$source=str_replace('<head>','',$source);
$source=str_replace('</head>','',$source);
$source=str_replace('<body>','',$source);
$source=str_replace('</body>','',$source);
$source=str_replace('</html>','',$source);
$source=trim($source);
echo $source;
?>
