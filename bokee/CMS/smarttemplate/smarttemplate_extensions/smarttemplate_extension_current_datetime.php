<?php

	/**
	* SmartTemplate Extension current_datetime
	* Print Current Date and Time
	*
	* Usage Example:
	* Template: Time: {current_datetime:}
	* Result:   Time: 30.01.2003 - 12:46:00
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_current_datetime ()
	{
		global $_CONFIG;

		if (empty($_CONFIG['datetime_format']))
		{
			$_CONFIG['datetime_format']  =  'd.m.Y H:i:s';
		}
		return date( $_CONFIG['datetime_format'] );
	}

?>