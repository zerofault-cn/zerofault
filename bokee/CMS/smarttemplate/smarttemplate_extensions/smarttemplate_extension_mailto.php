<?php

	/**
	* SmartTemplate Extension mailto
	* creates Mailto-Link from email address
	*
	* Usage Example:
	* Content:  $template->assign('CONTACT', 'philipp@criegern.com' );
	* Template: Mail to Webmaster: {mailto:CONTACT}
	* Result:   Mail to Webmaster: <a href="mailto:philipp@criegern.com">philipp@criegern.com</a>
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_mailto ( $param )
	{
		return "<a href=\"mailto:$param\">$param</a>";
	}

?>