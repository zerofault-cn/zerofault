<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	function bbcode($string) {
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
							'/\[code\](.*?)\[\/code\]/is',			// [code]
							'/\[flash\](.*?)\[\/flash\]/ise',		//[flash]
							'/\[music\](.*?)\[\/music\]/ise',		//[music]
							'/\[movie\](.*?)\[\/movie\]/ise',		//[movie]
					/*		'/\:\)/s',										// :)
							'/\:\|/s',										// :|
							'/\=\)/s',										// =)
							'/\=\|/s',										// =|
							'/\:\(/s',										// :(
							'/\=\(/s',										// =(
							'/\:D/is',										// :D
							'/\=D/is',										// =D
							'/\:o/is',										// :o
							'/\;\)/s',										// ;)
							'/\=\//s',										// =/
							'/\:p/is',										// :P
							'/\=p/is',										// =P
							'/\:lol\:/is',									// :lol:
							'/\:mad\:/is',									// :mad:
							'/\:roll\:/is',								// :rool:
							'/\:cool\:/is'									// :cool:
					*/
						);
	
		$replace	=	array(
							'',																// \n
							'',																// \r
							'<b>\1</b>',													// [b]
							'<strong>\1</strong>',											// [strong]
							'<i>\1</i>',													// [i]
							'<span style="text-decoration: underline;">\1</span>',			// [u]
							'<span style="text-decoration: line-through;">\1</span>',		// [s]
							'<span style="text-decoration: line-through;">\1</span>',		// [del]
							'urlfix(\'\\1\',\'\\2\')',										// [url]
							'<a href="mailto:\1" title="\1">\2</a>',						// [email]
							'imagefix(\'\\1\')',											// [img]
							'<span style="color: \1;">\2</span>',							// [color]
							'<div class="sblog_line"></div>',								// [line]
							'<div class="sblog_quote">\1</div>',							// [quote]
							'<pre class="sblog_code">\1</pre>',								// [code]
							'flashfix(\'\\1\')',											// [flash]
							'musicfix(\'\\1\')',											// [music]
							'moviefix(\'\\1\')',											// [movie]
					/*		'<img src="' . $conf_web_root . 'img/smilies/smile.png" alt=":)" />',		// :)
							'<img src="' . $conf_web_root . 'img/smilies/neutral.png" alt=":|" />',		// :|
							'<img src="' . $conf_web_root . 'img/smilies/smile.png" alt="=)" />',		// =)
							'<img src="' . $conf_web_root . 'img/smilies/neutral.png" alt="=|" />',		// =|
							'<img src="' . $conf_web_root . 'img/smilies/sad.png" alt=":(" />',			// :(
							'<img src="' . $conf_web_root . 'img/smilies/sad.png" alt="=(" />',			// =(
							'<img src="' . $conf_web_root . 'img/smilies/big_smile.png" alt=":D" />',	// :D
							'<img src="' . $conf_web_root . 'img/smilies/big_smile.png" alt="=D" />',	// =D
							'<img src="' . $conf_web_root . 'img/smilies/yikes.png" alt=":o" />',		// :o
							'<img src="' . $conf_web_root . 'img/smilies/wink.png" alt=";)" />',			// ;)
							'<img src="' . $conf_web_root . 'img/smilies/hmm.png" alt="=/" />',			// =/
							'<img src="' . $conf_web_root . 'img/smilies/tongue.png" alt=":p" />',		// :P
							'<img src="' . $conf_web_root . 'img/smilies/tongue.png" alt=":P" />',		// =P
							'<img src="' . $conf_web_root . 'img/smilies/lol.png" alt=":lol:" />',		// :lol:
							'<img src="' . $conf_web_root . 'img/smilies/mad.png" alt=":mad:" />',		// :mad:
							'<img src="' . $conf_web_root . 'img/smilies/roll.png" alt=":roll:" />',	// :rool:
							'<img src="' . $conf_web_root . 'img/smilies/cool.png" alt=":cool:" />'		// :cool:
					*/
						);
						
		return preg_replace($pattern, $replace, sCensor(nl2br(htmlspecialchars(($string)))));
	}
	
	function imagefix($img) {
		global $conf_web_root;

		if(substr($img, 0, 7) != 'http://') {
			// add the web root if url is relative
			$img = $conf_web_root . $img;
		}
		$imgsize = getimagesize($img);
		$img_w=$imgsize[0];
		if($img_w>420)
		{
			$img_w=420;
		}
		return '<img src="' . $img . '" width="'.$img_w.'" style="padding:5px;border:#a0a0a0 1px dashed;" alt="' . $img . '" title="' . $img . '" />';
	}
	
	function urlfix($url, $title) {
		global $conf_link_new;
		
		if($conf_link_new == 1) {
			return '<a href="' . $url . '" rel="external" title="' . lang('Open link in new window') . '" class="sblog_external">' . $title . '</a>';
		}
		else {
			return '<a href="' . $url . '">' . $title . '</a>';
		}
	}
	function flashfix($url){
		return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="400" height="300"><param name="src" value="'.$url.'"><embed pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash" type="application/x-shockwave-flash" width="400" height="300" src="'.$url.'"></embed></object>';
	}
	function musicfix($url){
		return '<object id="mplayer" width="420" height="68" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="FileName" value="'.$url.'"><param name="ShowPositionControls" value="0"><param name="ShowStatusBar" value="1"><param name="EnableContextMenu" value="0"><embed src="'.$url.'" border="0" width="400" height="68" type="application/x-mplayer2" pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=media&sba=plugin&" showpositioncontrols="0" showstatusbar="1" enablecontextmenu="0"></embed></object>';
	}
	function moviefix($url){
		return '<object id="mplayer" width="400" height="370" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="FileName" value="'.$url.'"><param name="ShowPositionControls" value="0"><param name="ShowStatusBar" value="1"><param name="EnableContextMenu" value="0"><embed src="'.$url.'" border="0" width="400" height="370" type="application/x-mplayer2" pluginspage="http://www.microsoft.com/isapi/redir.dll?prd=windows&sbp=mediaplayer&ar=media&sba=plugin&" showpositioncontrols="0" showstatusbar="1" enablecontextmenu="0"></embed></object>';
	}
?>