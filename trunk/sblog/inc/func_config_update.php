<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(!function_exists('sblog_config_update')) {
		function sblog_config_update($conf_name, $conf_value) {
			global $conf_mysql_prefix;
			
			$query = 'SELECT conf_name FROM ' . $conf_mysql_prefix . 'config WHERE conf_name=\'' . $conf_name . '\'';
			
			$q = mysql_query($query);
			$n = mysql_num_rows($q);
	
			if($n > 0) {
				$query = 'UPDATE ' . $conf_mysql_prefix . 'config SET conf_value=\'' . $conf_value . '\' WHERE conf_name=\'' . $conf_name . '\'';
			}
			else {
				$query = 'INSERT INTO ' . $conf_mysql_prefix . 'config SET conf_value=\'' . $conf_value . '\', conf_name=\'' . $conf_name . '\'';
			}
			
			mysql_query($query);
		}
	}

?>