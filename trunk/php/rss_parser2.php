<?php
$currentElements = array();
$newsArray = array();
readXml("http://192.168.0.238:8088/rss_mysql.php?channel=8");
echo("<pre>");
print_r($newsArray);
echo("</pre>");

// Reads XML file into formatted html
function readXML($xmlFile)
{
	$xmlParser = xml_parser_create();
	xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, false); 
	xml_set_element_handler($xmlParser, startElement, endElement); 
	xml_set_character_data_handler($xmlParser, characterData);
	$fp = fopen($xmlFile, "r");
	while($data = fread($fp, 4096))
	{
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
	echo '<br>start:'.$name.'<br>';
} 

// Prints XML data; finds highlights and links
function characterData($parser, $data)
{
	global $currentElements, $newsArray, $itemCount;
	$currentCount = count($currentElements);
	$parentElement = $currentElements[$currentCount-2];
	$thisElement = $currentElements[$currentCount-1];
	if($parentElement == "item")
	{
		$newsArray[$itemCount-1][$thisElement] = $data;
	}
	else
	{
		switch($name)
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
	echo 'parentElement:'.$parentElement.'<br>';
	echo 'thisElement:'.$thisElement.'<br>';
	echo 'date:'.$date.'<br>name:'.$name.'<br>';
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
	echo 'end:'.$name.'<br><br>';
} 
?>