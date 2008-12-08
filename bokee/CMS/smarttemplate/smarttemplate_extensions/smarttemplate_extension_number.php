<?php

	/**
	* SmartTemplate Extension number
	* Format a number with grouped thousands
	*
	* Usage Example:
	* Content:  $template->assign('SUM', 2500000);
	* Template: Current balance: {number:SUM}
	* Result:   Current balance: 2.500.000,00
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_number ( $param )
	{
		global $_CONFIG;

		if (empty($_CONFIG['decimal_char']))
		{
			$_CONFIG['decimal_char']  =  ',';
		}
		if (empty($_CONFIG['decimal_places']))
		{
			$_CONFIG['decimal_places']  =  2;
		}
		if (empty($_CONFIG['thousands_sep']))
		{
			$_CONFIG['thousands_sep']  =  '.';
		}

		return number_format( $param, $_CONFIG['decimal_places'], $_CONFIG['decimal_char'], $_CONFIG['thousands_sep'] );
	}

?>