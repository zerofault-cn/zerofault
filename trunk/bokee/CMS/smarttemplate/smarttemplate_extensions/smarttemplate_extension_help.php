<?php

	/**
	* SmartTemplate Extension help
	* Insert ROSI Helptext / Link
	*
	* Usage Example:
	* Content:  No Assignment required
	* Template: {help:}
	* Result:   <a href="/main/help.php?id=12356" target="_blank">HELP</a>   	(e.g.)
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_help ()
	{
		global $_ITEM_ID;

		if (is_numeric($_ITEM_ID))
		{
			$id  =  $_ITEM_ID;
		}
		//	'/apps/application_name.php?id=7' => 'apps_application_name'
		$id  =  urlencode(substr(str_replace('.php', '', str_replace('/', '_', $_SERVER['PHP_SELF'])),1));
		if ($id)
		{
			$code  =  '<a href="javascript:void(0)" onclick="hlpwin=window.open(\'/help/help.php?id=' . $id . '\',\'help\',\'width=600,height=400;resizable=yes\'); hlpwin.focus(); return false;"><img src="/images/aral/help_weiss.gif" width="14" height="14" border="0" align="absmiddle" hspace="10"></a>';
			return  $code;
		}
	}

?>