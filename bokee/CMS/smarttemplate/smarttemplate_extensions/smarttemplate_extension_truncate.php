<?php

	/**
	* SmartTemplate Extension truncate
	* Restricts a String to a specific number characters
	*
	* Usage Example:
	* Content:  $template->assign('TEASER', 'PHP 4.3.0RC1 has been released. This is the first release candidate');
	* Template: News: {truncate:TEASER,50} ... [more]
	* Result:   News: PHP 4.3.0RC1 has been released. This is the first ... [more]
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_truncate ( $param, $size )
	{
		return substr( $param, 0, $size );
	}

?>