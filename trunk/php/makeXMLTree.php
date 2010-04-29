<? 
// Remember to put your own values in here (look at my sample XML feed above) 
$XML_LIST_ELEMENTS = array( "Item", "Attribute", "DomainName" );

function makexmltree($data) 
{
	// create parser 
	$parser = xml_parser_create(); 
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0); 
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1); 
	xml_parse_into_struct($parser,$data,$values,$tags); 
	xml_parser_free($parser);

	// we store our path here 
	$hash_stack = array(); 

	// this is our target 
	$ret = array(); 
	foreach ($values as $key => $val) { 
		switch ($val['type']) { 
			case 'open': 
				array_push($hash_stack, $val['tag']); 
				if (isset($val['attributes'])) {
					$ret = composeArray($ret, $hash_stack, $val['attributes']); 
				}
				else {
					$ret = composeArray($ret, $hash_stack); 
				}
				break;
			
			case 'close': 
				array_pop($hash_stack); 
				break;

			case 'complete': 
				array_push($hash_stack, $val['tag']); 
				$ret = composeArray($ret, $hash_stack, $val['value']); 
				array_pop($hash_stack); 

				// handle attributes 
				if (isset($val['attributes'])) {
					while(list($a_k,$a_v) = each($val['attributes'])) {
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

function &composeArray($array, $elements, $value=array()) {
	global $XML_LIST_ELEMENTS; 

	// get current element 
	$element = array_shift($elements); 

	// does the current element refer to a list 
	if (in_array($element,$XML_LIST_ELEMENTS)) {
		// more elements? 
		if(sizeof($elements) > 0) {
			$array[$element][sizeof($array[$element])-1] = &composeArray($array[$element][sizeof($array[$element])-1], $elements, $value); 
		}
		else // if (is_array($value)) 
		{ 
			$array[$element][sizeof($array[$element])] = $value; 
		} 
	} 
	else {
		// more elements? 
		if(sizeof($elements) > 0) {
			$array[$element] = &composeArray($array[$element], $elements, $value); 
		}
		else {
			$array[$element] = $value; 
		}
	}
	return $array; 
}
?> 