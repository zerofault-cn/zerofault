<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	if(!function_exists('bbcode_strip')) {
		function bbcode_strip($string) {
			global $conf_web_root;
	
			$pattern	=	array(
								'/\\n/',											// \n
								'/\\r/',											// \r
								'/\[b\](.*?)\[\/b\]/is',					// [b]
								'/\[strong\](.*?)\[\/strong\]/is',		// [strong]
								'/\[i\](.*?)\[\/i\]/is',					// [i]
								'/\[u\](.*?)\[\/u\]/is',					// [u]
								'/\[s\](.*?)\[\/s\]/is',					// [s]
								'/\[del\](.*?)\[\/del\]/is',				// [del]
								'/\[url=(.*?)\](.*?)\[\/url\]/ise',		// [url]
								'/\[email=(.*?)\](.*?)\[\/email\]/is',	// [email]
								'/\[img](.*?)\[\/img\]/ise',				// [img]
								'/\[color=(.*?)\](.*?)\[\/color\]/is',	// [color]
								'/\[line\]/is',								// [line]
								'/\[quote\](.*?)\[\/quote\]/is',			// [quote]
								'/\[code\](.*?)\[\/code\]/is'				// [quote]
							);
		
			$replace	=	array(
								' ',												// \n
								'',												// \r
								'\1',												// [b]
								'\1',												// [strong]
								'\1',												// [i]
								'\1',												// [u]
								'\1',												// [s]
								'\1>',											// [del]
								'url_strip(\'\2\', \'\1\')',				// [url]
								'\2 [\1]',										// [email]
								'truncate(imagefix_strip(\'\\1\'), 40)',	// [img]
								'\2',												// [color]
								'--',												// [line]
								'\1',												// [quote]
								'\1'												// [code]
							);
							
			return preg_replace($pattern, $replace, stripslashes($string));
		}
	}

	function imagefix_strip($img) {
		global $conf_web_root;

		if(substr($img, 0, 7) != 'http://') {
			// add the web root if url is relative
			$img = $conf_web_root . $img;
		}

		return $img;
	}

	function url_strip($title, $url) {
		return $title . ' [' . truncate($url, 40) . ']';
	}

?>