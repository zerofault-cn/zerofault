<?php

	/**
	* SmartTemplate Extension session
	* Print Content of Session variables
	*
	* Usage Example:
	* Content:  $_SESSION['userName']  =  'Philipp von Criegern';
	* Template: Current User: {session:"userName"}
	* Result:   Current User: Philipp von Criegern
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_session ( $param )
	{
		return $_SESSION[$param];
	}

?>