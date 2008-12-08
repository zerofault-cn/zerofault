<?php

	/**
	* SmartTemplate Extension urlencode
	* Inserts URL-encoded String
	*
	* Usage Example:
	* Content:  $template->assign('PARAM', 'Delete User!');
	* Template: go.php?param={urlencode:PARAM}
	* Result:   go.php?param=Delete+User%21
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_urlencode ( $param )
	{
		return urlencode( $param );
	}

?>