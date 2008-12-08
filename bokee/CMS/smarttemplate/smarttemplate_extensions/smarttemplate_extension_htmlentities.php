<?php

	/**
	* SmartTemplate Extension htmlentities
	* Converts Special Characters to HTML Entities
	*
	* Usage Example:
	* Content:  $template->assign('NEXT', 'Next Page >>');
	* Template: <a href="next.php">{htmlentities:NEXT}</a>
	* Result:   <a href="next.php">Next Page &gt;&gt;</a>
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_htmlentities ( $param )
	{
		return htmlentities( $param );
	}

?>