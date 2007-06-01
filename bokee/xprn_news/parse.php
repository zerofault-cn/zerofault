<?
$filename = "includes/codetable/big5-gb.table";
$fp = fopen($filename, "rb");
$big5 = fread($fp,filesize($filename));
fclose($fp);
$filename = "includes/codetable/gb-big5.table";
$fp = fopen($filename, "rb");
$gb = fread($fp,filesize($filename));
fclose($fp);

/**
big5码转换成gb码
*/
function big52gb($text) {
	global $big5;
	$max = strlen($text)-1;
	for($i=0;$i<$max;$i++)
	{
		$h = ord($text[$i]);
		if($h>=160)
		{
			$l = ord($text[$i+1]);
			if($h==161 && $l==64)
			{
				$gb = "　"; 
			}
			else
			{
				$p = ($h-160)*510+($l-1)*2;
				$gb = $big5[$p].$big5[$p+1];
			}
			$text[$i] = $gb[0];
			$text[$i+1] = $gb[1];
			$i++;
		}
	}
	return $text;
}

$dir='../meitong';//初始化目录
//$conn=mysql_connect('211.152.20.11','root','10y9c2U5');
$conn=mysql_connect('localhost','root','');
mysql_select_db('xprn_news',$conn);
$handle=opendir($dir);
while($file=readdir($handle))
{
	if(is_file($dir.'/'.$file) && strrchr($file,".")=='.xml')
	{
		parse($file);
	}
}

function parse($file)
{
	global $dir,$conn;
	$xmlFile=$dir.'/'.$file;
	$xmldata=big52gb(file_get_contents($xmlFile));
	$is_tw=has_str($xmldata,'zh-TW');//判定是否繁体
	preg_match('/<DateAndTime>(.*?)<\/DateAndTime>.+<NewsItemId>(.*?)<\/NewsItemId>.+<HeadLine>(.*?)<\/HeadLine>.+<DataContent>(.*?)<\/DataContent>/is',$xmldata,$matchs);

	$datetime=$matchs[1];
	$itemId=$matchs[2];
echo	$title=$matchs[3];
	if($is_tw)
	{
	//	echo $title=big52gb($title);
	}
	$title=htmlspecialchars($title);
	$content=conv($matchs[4],$is_tw);
	$content=str_replace('&lt;![CDATA[','',str_replace(']]&gt;','',$content));

	$sql="insert into article set itemId='".$itemId."',datetime='".$datetime."',title='".$title."',content='".addslashes($content)."'";

	if(mysql_query($sql,$conn))
	{
		$olddir=$dir.'/'.substr($datetime,0,6);
		@mkdir($olddir);
	//	rename($xmlFile,$olddir.'/'.$file);
		echo 'ok<br>'."\n";
	}
}
function has_str($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中是否含needle 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//找到退出循环 
			break; 
		} 
	}
	if($find)
		return 1; //找到则返回1
	else 
		return 0;//没找到就返回0 
}
function conv($data,$is_tw)
{
	if($is_tw)
	{
//		$chs = new Chinese("BIG5","UNICODE",$data);
//		$data=$chs->ConvertIT();
//		$chs = new Chinese("UNICODE","GB2312",$data);
//		return $chs->ConvertIT();
	//	return $data;
	}
	else
	{
		return $data;
	}
}


?>