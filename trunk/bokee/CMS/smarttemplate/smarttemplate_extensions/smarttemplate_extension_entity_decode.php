<?php

	/**
	* SmartTemplate Extension entity_decode
	* Convert all HTML entities to their applicable characters
	*
	* Usage Example:
	* Content:  $template->assign('MESSAGE', 'Nicht m&ouml;glich!');
	* Template: <a href="alert('{entity_decode:MESSAGE}');">Alert</a>
	* Result:   <a href="alert('Nicht mglich!');">Alert</a>
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_entity_decode ( $param )
	{
		$param  =  strtr($param, array_flip(get_html_translation_table(HTML_ENTITIES)));
		$param  =  preg_replace("/&#([0-9]+);/me", "chr('\\1')", $param);
		return $param;
	}

?>