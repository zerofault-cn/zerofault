<?php

	/**
	* SmartTemplate Extension db_time
	* Convert Oracle Date (British Format) to Local Formatted Time
	*
	* Usage Example:
	* Content:  $template->assign('UPDATE', $result['LAST_UPDATE_DATE_TIME']);
	* Template: Last update: {db_time:UPDATE}
	* Result:   Last update: 12:46:00
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_db_time ( $param )
	{
		global $configuration;

		if (preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $param)) {
			return date( $configuration['time_format'],  strtotime($param) );
		} else {
			return "Invalid Dateformat!";
		}
	}

?>