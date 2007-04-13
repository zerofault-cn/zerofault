<?php
//*******************************************************************//
//php.net�������ṩ��RSS������
//��֧��rss0.91,1.0,2.0,Ҳ����˵����һ����׼��XML��ʽ������.
//Դ��������һ������,����$newsArray[$itemCount-1][$thisElement] = $data;Ӧ��Ϊ$newsArray[$itemCount-1][$thisElement] .= $data;
//����,Դ����ֻ������һ������newsArray.
//�����ɴ򿪱����ļ���Զ��URL,������������newsArray��channelArray,�ֱ�洢������Ŀ��Ϣ��������Ŀ��Ϣ.
//����RSS�ı�׼��ǩ���Բο�ͬĿ¼�µ�rss_class_RSSBuilder.inc.php
//******************************************************************//
$currentElements = array();
$channelArray=array();
$newsArray = array();
/*
readXML("http://www.kantianxia.com/rss/newsrss1.xml");
echo("<pre>");
print_r($newsArray);
echo("</pre>");
*/
// Reads XML file into formatted html
include_once "../include/class.Chinese.php";
function readXML($xmlFile)
{
	static $is_UTF;
	$xmlParser = xml_parser_create();
	xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, false); 
	xml_set_element_handler($xmlParser, startElement, endElement); 
	xml_set_character_data_handler($xmlParser, characterData);
	$fp = fopen($xmlFile, "r");
	while($data = fread($fp, 4096))
	{
		if($is_UTF=($is_UTF || eregi("((utf-8){1})",$data)))
		{
			$chs = new Chinese("UTF8","GB2312",$data);
			$data=$chs->ConvertIT();
		}
		xml_parse($xmlParser,$data, feof($fp));
	}
	xml_parser_free($xmlParser);
}

// Sets the current XML element, and pushes itself onto the element hierarchy
function startElement($parser, $name, $attrs)
{
	global $currentElements, $itemCount;
	array_push($currentElements, $name);
	if($name == "item")
	{
		$itemCount += 1;
	}
} 

// Prints XML data; finds highlights and links
function characterData($parser, $data)
{
	global $currentElements, $newsArray, $itemCount,$channelArray;
	$currentCount = count($currentElements);
	$parentElement = $currentElements[$currentCount-2];
	$thisElement = $currentElements[$currentCount-1];
	
	if($parentElement == "channel")
	{
		if($thisElement!='item')
		{
			$channelArray[$thisElement]=$data;
		}
		
	}
	if($parentElement == "item")
	{
		$newsArray[$itemCount-1][$thisElement] .= $data;
	}
	else
	{
		switch($name)//��֪�����������ֵ���Ƕ���
		{
			case "pubDate":
//				break;
			case "lastBuildDate":
//				break;
			case "docs":
//				break;
			case "description":
//				break;
			case "link":
//				break;
			case "title":
//				break;
			case "language":
//				break;
			case "dc:date":
//				break;
			case "dc:language":
//				break;
			case "item":
//				break;
		}
	}
} 

// If the XML element has ended, it is poped off the hierarchy
function endElement($parser, $name)
{
	global $currentElements;
	$currentCount = count($currentElements);
	if($currentElements[$currentCount-1] == $name)
	{
		array_pop($currentElements);
	}
}
?>