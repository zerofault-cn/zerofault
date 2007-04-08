<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// search for and include language file
	if(isset($conf_lang_default) && file_exists('lang/' . $conf_lang_default . '.php')) {
		require('lang/' . $conf_lang_default . '.php');
	}

	if(!function_exists('lang')) {
		// translation function
		function lang($key) {
			global $lang;
	
			// check if translated string exists		
			if(isset($lang) && array_key_exists($key, $lang) && strlen($lang[$key]) > 0) {
				// return translated string
				return htmlspecialchars($lang[$key]);
			}
			else {
				// return original string
				return htmlspecialchars($key);
			}
		}
	}

?>