<?
$dir='../meitong';//初始化目录
$conn=mysql_connect('211.152.20.11','root','10y9c2U5');
//$conn=mysql_connect('localhost','root','');
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
	$xmldata=file_get_contents($xmlFile);
	
	$is_tw=has_str($xmldata,'zh-TW');//判定是否繁体
	preg_match('/<DateAndTime>(.*?)<\/DateAndTime>.+<NewsItemId>(.*?)<\/NewsItemId>.+<HeadLine>(.*?)<\/HeadLine>.+<DataContent>(.*?)<\/DataContent>/is',$xmldata,$matchs);

	$datetime=$matchs[1];
	$itemId=$matchs[2];
	$title=$matchs[3];

	$title=htmlspecialchars(conv($title));
	$content=$matchs[4];
	$content=str_replace('&lt;![CDATA[','',str_replace(']]&gt;','',$content));

	$sql="insert into article set itemId='".$itemId."',datetime='".$datetime."',title='".$title."',content='".addslashes(conv($content))."'";
//	if($is_tw)
//	{
//		$olddir=$dir.'/'.substr($datetime,0,6);
//		@mkdir($olddir);
//		rename($xmlFile,$olddir.'/'.$file);
//	}
	if(mysql_query($sql,$conn))
	{
		$olddir=$dir.'/'.substr($datetime,0,6);
		@mkdir($olddir);
		rename($xmlFile,$olddir.'/'.$file);
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
function conv($str)
{
	return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
}


?>