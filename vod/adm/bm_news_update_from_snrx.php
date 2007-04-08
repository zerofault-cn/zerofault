<?
function indexOf($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中needle最先出现的位置 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
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
		return $i; //找到则返回第几个位置 ,0为计数起点
	else 
		return 0;//没找到就返回0 
}
function has_str($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中needle最先出现的位置 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
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
function insert_news_from_snrx($news_url,$news_title,$news_time)
{
	$news_url='http://news.snrx.com/'.$news_url;
	if($fp=fopen($news_url,"r"))
	{
		while ($buffer = fgets($fp, 4096))
		{
			$news_source.=$buffer;
		}
		fclose($fp);
	}
	$news_source=substr($news_source,indexOf($news_source,'<td width="555" valign="top">')+29);
	$news_source=substr($news_source,0,indexOf($news_source,'</table>')+8);
	$info=str_replace('width="555"','width="100%"',$news_source);
	$info=str_replace('news_title','style24b',$info);
	$info=str_replace('news_time','style22b',$info);
	$info=str_replace('p10','style22b',$info);
	$info=str_replace('size=3 ','',$info);
	$info=str_replace('-----------------','',$info);
	$news_time=date("YmdHis",mktime(date("H"),date("i"),date("s"),substr($news_time,3,2),substr($news_time,6,2),substr($news_time,0,2)));
	$sql2="insert into bianmin(city,type,title,info,time) values('suining','news','".$news_title."','".$info."','".$news_time."')";
	if(mysql_query($sql2))
	{
		if($_REQUEST['item_limit'])
		{
			echo '添加新闻:'.$news_title.'<span style=color:blue>OK!</span><br>';
		}
	}
	else
	{
		echo '<span style=color:red>ERROR:</span>'.$sql2."<br>\n";
	}
}
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
//mysql_connect("localhost","dba","sql");
//mysql_select_db("BOD_WIN");
$url= "http://news.snrx.com/";
$source_item=array();
if(!$_REQUEST['item_limit'])//定义每次取前面的行数
{
	$item_limit=5;
}
else
{
	$item_limit=$_REQUEST['item_limit'];
}
$i=0;
if($fp=fopen($url,"r"))
{
	while ($buffer = fgets($fp, 4096))
	{
		if(has_str($buffer,'<li>'))
		{
			if($i>=$item_limit)
			{
				break;
			}
			$source_item[$i++]=$buffer;
			
		}
		elseif(has_str($buffer,'<BR><BR>'))
		{
			break;
		}
		else
		{
			continue;
		}
		
	}
	fclose($fp);
}
//print_r($source_item);
$i=0;
while($has_inserted!=1&&$i<$item_limit)
{
	$news_url=substr($source_item[$i],indexOf($source_item[$i],'shownews'),indexOf($source_item[$i],'" >')-indexOf($source_item[$i],'shownews'));
	if(indexOf($source_item[$i],'<font color="#FF0000">[附图]</font>'))
	{
		$has_pic=1;
		$source_item[$i]=substr($source_item[$i],indexOf($source_item[$i],'</font>')+7);
	}
	else
	{
		$has_pic=0;
	}
	$news_title=substr($source_item[$i],indexOf($source_item[$i],'<font class="p10">')+18,indexOf($source_item[$i],'</font>')-indexOf($source_item[$i],'<font class="p10">')-18);
	if($has_pic)
	{
		$news_title='[附图]'.$news_title;
	}
	$source_item[$i]=substr($source_item[$i],indexOf($source_item[$i],'</font>')+7);
	$news_time=substr($source_item[$i],indexOf($source_item[$i],'>(')+2,8);
	$sql1="select * from bianmin where city='suining' and type='news' and title='".$news_title."'";
	$result1=mysql_query($sql1);
	if(mysql_fetch_array($result1))
	{
	//	$has_inserted=1;
		if($_REQUEST['item_limit'])
		{
			echo $news_title.':<span style=color:#FF9900>已添加,跳过...</span><br>';
		}
		$i++;
		continue;
	}
	else
	{
		insert_news_from_snrx($news_url,$news_title,$news_time);
	}
	$i++;
//	$has_inserted=1;
}
?>
