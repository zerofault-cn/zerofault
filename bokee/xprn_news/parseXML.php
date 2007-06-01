<?
$XML_LIST_ELEMENTS = array('DataContent');


$dir=$_REQUEST['dir'];
$file=$_REQUEST['file'];
$xmlFile=$dir.'/'.$file;
$xmldata=file_get_contents($xmlFile);

//$xmldata=str_replace('&gt;','>',str_replace('&lt;','<',$xmldata));
//$xml_arr=makeXMLTree($xmldata);

echo $is_tw=has_str($xmldata,'zh-TW');//判定是否繁体

preg_match('/<DateAndTime>(.*?)<\/DateAndTime>.+<NewsItemId>(.*?)<\/NewsItemId>.+<HeadLine>(.*?)<\/HeadLine>.+<DataContent>(.*?)<\/DataContent>/is',$xmldata,$matchs);

echo '<pre>';
//print_r($matchs);
echo '</pre>';

$datetime=$matchs[1];
$itemId=$matchs[2];
echo $title=conv($matchs[3]);
$content=conv($matchs[4]);
$content=str_replace('&lt;![CDATA[','',str_replace(']]&gt;','',$content));
mysql_connect('211.152.20.11','root','10y9c2U5');
mysql_select_db('xprn_news');

$sql="insert into article set itemId='".$itemId."',datetime='".$datetime."',title='".$title."',content='".$content."'";
if(mysql_query($sql))
{
	$olddir=$dir.'/'.substr($datetime,0,6);
	mkdir($olddir);
	rename($xmlFile,$olddir.'/'.$file);
	echo 'ok';
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
	global $is_tw;
	if($is_tw)
	{
		return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
	}
	else
	{
		return mb_convert_encoding($str,"gb2312","utf-8,gbk,gb2312");
	}
}
function makeXMLTree($data)
{
	// create parser
	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$data,$values,$tags);
	xml_parser_free($parser);

echo '<pre>';
print_r($values);
echo '</pre>';

	// we store our path here
	$hash_stack = array();

	// this is our target
	$ret = array();
	foreach ($values as $key => $val)
	{
		switch ($val['type'])
		{
			case 'open':
				array_push($hash_stack, $val['tag']);
				if (isset($val['attributes']))
					$ret = composeArray($ret, $hash_stack, $val['attributes']);
				else
					$ret = composeArray($ret, $hash_stack);
				break;

			case 'close':
				array_pop($hash_stack);
				break;

			case 'complete':
				array_push($hash_stack, $val['tag']);
				$ret = composeArray($ret, $hash_stack, $val['value']);
				array_pop($hash_stack);

				// handle attributes
				if (isset($val['attributes']))
				{
					while(list($a_k,$a_v) = each($val['attributes']))
					{
						$hash_stack[] = $val['tag']."_attribute_".$a_k;
						$ret = composeArray($ret, $hash_stack, $a_v);
						array_pop($hash_stack);
					}
				}
				break;
		}
	}
	return $ret;
}

function &composeArray($array, $elements, $value=array())
{
	global $XML_LIST_ELEMENTS;
	// get current element
	$element = array_shift($elements);

	// does the current element refer to a list
	if (in_array($element,$XML_LIST_ELEMENTS))
	{
		// more elements?
		if(sizeof($elements) > 0)
		{
			$array[$element][sizeof($array[$element])-1] = &composeArray($array[$element][sizeof($array[$element])-1], $elements, $value);
		}
		else // if (is_array($value))
		{
			$array[$element][sizeof($array[$element])] = str_replace("\t","<br>",nl2br($value));
		}
	}
	else
	{
		// more elements?
		if(sizeof($elements) > 0)
		{
			$array[$element] = &composeArray($array[$element], $elements, $value);
		}
		else
		{
			$array[$element] = $value;
		}
	}
	return $array;
}
?>