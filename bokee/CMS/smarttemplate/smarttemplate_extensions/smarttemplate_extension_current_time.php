<?php

	/**
	* SmartTemplate Extension current_time
	* Print Current Time
	*
	* Usage Example:
	* Template: Time: {current_time:}
	* Result:   Time: 12:46:00
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_current_time ()
	{
		global $_CONFIG;

		if (empty($_CONFIG['time_format']))
		{
			$_CONFIG['time_format']  =  'H:i:s';
		}
		return date( $_CONFIG['time_format'] );
	}

?>