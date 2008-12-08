<?php

	/**
	* SmartTemplate Extension current_date
	* Print Current Date
	*
	* Usage Example:
	* Template: Today: {current_date:}
	* Result:   Today: 30.01.2003
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_current_date ()
	{
		global $_CONFIG;

		if (empty($_CONFIG['date_format']))
		{
			$_CONFIG['date_format']  =  'd.m.Y';
		}
		return date( $_CONFIG['date_format'] );
	}

?>