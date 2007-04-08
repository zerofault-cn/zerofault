<?php
/*
* @abstract XMLReader
*/
class XMLReader
{
	var $id;
	var $XMLFile = "http://reg.bokee.com/account/BlogCardCtrl.b?id=";
	var $aReturnIndex;
	var $aReturnSrc;
	var $aReturnUrl;
	var $sReturnStr;

	var $xmlParser = null;
	var $tagName = "";
	var $tagValue = "";
	var $tagAttribute;
	var $xmlData;
	var $bInProcess = false;

	var $aXMLItem = array();
	var $sXMLItem = "";

	function XMLReader($id)
	{
		$this->id = $id;
/*
		$this->aReturnIndex = $this->getData("index");
		$this->aReturnSrc = $this->getData("url");
		$this->aReturnUrl = $this->getData("link");

		for($i=0;$i<count($this->aReturnIndex);$i++)
		{
			$this->sReturnStr .= "imgUrl[".$this->aReturnIndex[$i]['index']."]=\"upload/shequ/".$this->aReturnSrc[$i]['url']."\"\n";
			$this->sReturnStr .= "imgLink[".$this->aReturnIndex[$i]['index']."]=\"".$this->aReturnUrl[$i]['link']."\"\n";
		}
*/
	}

	function setXMLFile($file)
	{
		$this->XMLFile = $file;
	}

	function readXML()
	{
		$this->XMLFile = $this->XMLFile.$this->id;
		if (!is_resource($this->xmlParser))
			$this->xmlParser = xml_parser_create(); 

		// set options
		xml_set_object($this->xmlParser, &$this);
		xml_set_element_handler($this->xmlParser, "startElement", "endElement"); 
		xml_set_character_data_handler($this->xmlParser, "characterData"); 
		xml_parser_set_option($this->xmlParser, XML_OPTION_CASE_FOLDING, 0); 	
		xml_parser_set_option($this->xmlParser, XML_OPTION_SKIP_WHITE, 1);

		if (!($fp = fopen($this->XMLFile,"r")))
		{
			die ("could not open RSS for input"); 
		} 
			
		while ($data = fread($fp, 100000)) 
		{ 
			if (!xml_parse($this->xmlParser, $data, feof($fp))) 
			{ 
				die(sprintf("XML error: %s at line %d", 
					xml_error_string(xml_get_error_code($this->xmlParser)), 
					xml_get_current_line_number($this->xmlParser))); 
			} 
		}
		xml_parser_free($this->xmlParser);

		fclose($fp);

		return $this->xmlData;
	}

	function startElement(&$xmlParser, $name, $attr) 
	{
		for($i=0;$i<count($this->aXMLItem);$i++)
		{
			if($name == $this->aXMLItem[$i])
			{
				$this->bInProcess = true;
			}
		}

		if($this->bInProcess)
		{
			$this->tagName = $name;
			$this->tagAttribue = $attr;
		}
			
	}

	function endElement(&$xmlParser, $name) 
	{
		if ($this->bInProcess)
		{
			$this->xmlData[$this->tagName] = $this->tagValue;
			$this->bInProcess = false;
		}	
	}

	function characterData(&$xmlParser, $data) 
	{
		if ($this->bInProcess)
		{
			$this->tagValue = $data;
		}
	}

	function getData($tag)
	{
		if(is_array($tag))
		{
			$this->aXMLItem = $tag;
		}
		else
		{
			$this->aXMLItem[] = $tag;
		}

		if ( !empty($this->aXMLItem) )
		{
			$process = $this->readXML();
		}

		return $process;
	}
}

?>