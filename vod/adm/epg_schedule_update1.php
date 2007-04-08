<?
//本程序目前只能针对凤凰网的节目单,最终版本
if($station_id!=1&&$station_id!=3&&$station_id!=4)
{
//	header("location:index.php?content=epg_schedule_update2&station_id=$station_id");
	echo '<meta http-equiv="refresh" content="0;url=index.php?content=epg_schedule_update2&station_id='.$station_id.'">';
	
}
else
{
include_once "../include/mysql_connect.php";
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

if($station_id==1)
{
	$tmpurl="http://www.phoenixtv.com.cn/home/phoenixtv/jiemubiao/new/program.php3?tv_id=1";
}
if($station_id==3)
{
	$tmpurl="http://www.phoenixtv.com.cn/home/phoenixtv/jiemubiao/new/program.php3?tv_id=4";
}
if($station_id==4)
{
	$tmpurl="http://www.phoenixtv.com.cn/home/phoenixtv/jiemubiao/new/program.php3?tv_id=5";
}

echo "删除上月节目单:";
$sql1="delete from epg_schedule where date<'".date("Ym").'01'."' and station_id=".$station_id;
if(mysql_query($sql1))
{
	echo "<span class=blue>ok</span><br>";
}
echo "下载本月节目单:<br>";
$maxday=date("d",mktime(0,0,0,date("m")+1,0,date("Y")));
$monday_date=date("Ymd",mktime(0,0,0,date("m"),(date("d")-date("w")+1),date("Y")));
for($j=0;$j<7;$j++)
{
	$tmp_stamp=mktime(0,0,0,date("m"),(date("d")-date("w")+1+$j),date("Y"));
	$tmp_date=date("Ymd",$tmp_stamp);
	$sql2="select * from epg_schedule where station_id=".$station_id." and date=".$tmp_date." and length(program)>35";
	$result2=mysql_query($sql2);
	if(mysql_fetch_array($result2))
	{
		echo $tmp_date.":已经更新,跳过!<br>";//已经更新的日期则跳过
		continue;
	}
	$tmp_week=date("w",$tmp_stamp);
	$url_ext='&date='.date("Y/m/d",$tmp_stamp);
//	$url_ext='&date=2004/09/04';
	$url=$tmpurl.$url_ext;
	if(!$fp=@fopen($url,"r"))//; or die("不能连接到凤凰网");
	{
		echo '不能连接到凤凰网';
		break;
	}
	while ($buffer = fgets($fp, 4096))
	{
		$source.=$buffer;
	}
	@fclose($fp);

	$source=str_replace('<table width="100%" border="0" cellspacing="0" cellpadding="0" class="p2">','^',$source);
	$source=substr($source,strpos($source,'^')+1);
	$source=substr($source,strpos($source,'^')+1);
	$source=str_replace('</table>','^',$source);
	$source1=substr($source,0,strpos($source,'^'));
	$source2=substr($source,strpos($source,'^')+1);
	$source2=substr($source2,strpos($source2,'^')+1);
	$source2=substr($source2,0,strpos($source2,'^'));
	$source=$source1.$source2;

	$text='';
	while($i=indexOf($source,'<tr><td>'))
	{
		$source=substr($source,$i+8);
		$text.=substr($source,0,indexOf($source,'</td>'));
		$text=eregi_replace("<a.*html'>","",$text);
		$text=str_replace("</a>","",$text);
		$text.='<br>';
	}
	//echo $text;
	$sql2="insert into epg_schedule values(".$station_id.",'".$tmp_date."','".$tmp_week."','".addslashes($text)."')";
	if(mysql_query($sql2))
	{
		echo $tmp_date.':<span class=blue>ok</span><br>';
	}
	else
	{
		echo $tmp_date.':<span class=red>error</span><br>';
	}
}
}
?>
