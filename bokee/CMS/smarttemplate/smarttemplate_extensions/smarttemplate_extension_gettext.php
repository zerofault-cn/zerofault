<?php

	/**
	* SmartTemplate Extension gettext
	* Translates Text Calls 
	*
	* Usage Example:
	* Template: {gettext:Welcome}
	* Calls:    gettext('Welcome')
	* Result:   Willkommen
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_gettext ( $param )
	{
		return gettext( $param );
	}

?>