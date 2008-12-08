<?php

	/**
	* SmartTemplate Extension hidemail
	* Protects email address from being scanned by spam bots
	*
	* Usage Example:
	* Content:  $template->assign('AUTHOR', 'philipp@criegern.com' );
	* Template: Author: {hidemail:AUTHOR}
	* Result:   Author: philipp at criegern dot de
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_hidemail ( $param )
	{
		return str_replace('@', ' at ', str_replace('.', ' dot ', $param));
	}

?>