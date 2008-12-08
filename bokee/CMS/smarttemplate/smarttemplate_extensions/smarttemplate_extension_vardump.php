<?php

	/**
	* SmartTemplate Extension vardump
	* Prints variable content for debug purpose
	*
	* Usage Example I:
	* Content:  $template->assign('test', array( "name1", "value1",  "name2", "value2" ) );
	*
	* Template: DEBUG: {vardump:test}
	*
	* Result:   DEBUG: Array
	*                  (
	*                      [name1] => value1
	*                      [name2] => value2
	*                  )
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_vardump ( $param )
	{
		return "<pre>" . print_r($param, true) . "</pre>";
	}

?>