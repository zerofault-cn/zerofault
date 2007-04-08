<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(!function_exists('sCensor')) {
		function sCensor($string) {
			global $conf_mysql_prefix;
			// load censoring table
			$query = 'SELECT word_orig, word_repl FROM ' . $conf_mysql_prefix . 'censoring';
			
			$q = mysql_query($query);
			$n = mysql_num_rows($q);
		
			// define arrays
			$censoring_pattern = array();
			$censoring_replace = array();
			
			// if censored words exists
			if($n > 0) {
				// create array with words
				while($r = mysql_fetch_assoc($q)) {
					$censoring_pattern[] = '/ ' . $r['word_orig'] . '/i';
					$censoring_replace[] = ' <span class="sblog_censor">' . $r['word_repl'] . '</span> ';
				}
			}
			
			return preg_replace($censoring_pattern, $censoring_replace, $string);
		}
	}

?>