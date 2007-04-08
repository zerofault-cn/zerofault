<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	@mysql_connect($conf_mysql_hostname, $conf_mysql_username, $conf_mysql_password) or die('MySQL错误: ' . mysql_errno() . ' ' . mysql_error());
	mysql_select_db($conf_mysql_database);

?>