<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	function truncate($string, $max) {
		
		if(strlen($string) > $max) {
			$trunc = ceil(($max - 8) / 2);
			//$trunc = ceil(4);
			$string = htmlspecialchars(trim(substr($string, 0, $trunc))) . "..." . htmlspecialchars(trim(substr($string, -$trunc, strlen($string))));
		}
		else {
			$string = htmlspecialchars($string);
		}
		
		return $string;
	}

?>