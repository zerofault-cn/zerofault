<?php

	/**
	* SmartTemplate Extension stringformat
	* Inserts a formatted String
	*
	* Usage Example:
	* Content:  $template->assign('SUM', 25);
	* Template: Current balance: {stringformat:SUM,'$ %01.2f'}
	* Result:   Current balance: $ 25.00
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_stringformat ( $param, $format )
	{
		return sprintf( $format,  $param );
	}

?>