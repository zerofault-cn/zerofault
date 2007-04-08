<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// RSS version switch
	if(isset($_GET['mode'])) {
		$mode = $_GET['mode'];
	}
	else {
		$mode = null;
	}

	// some important stuff
	require('../inc/config.php');
	require('../inc/mysql.php');
	require('../inc/lang.php');
	require('../inc/func_bbcode.php');
	require('../inc/func_bbcode_strip.php');

	$query = "SELECT id, UNIX_TIMESTAMP(date_created) AS date_created, UNIX_TIMESTAMP(date_modified) AS date_modified, topic, text FROM " . $conf_mysql_prefix . "data ORDER BY date_created DESC LIMIT 100";
	
	$q = mysql_query($query);
	$n = mysql_num_rows($q);
	
	if($n > 0) {
		$r = mysql_fetch_assoc($q);
	
		// check if there's new data in document
		if(function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
		}
		else if(function_exists('getallheaders')) {
			$headers = getallheaders();
		}
	
		// Return a 304 to client if there's nothing new
		if(isset($headers['If-Modified-Since']) && $headers['If-Modified-Since'] == gmdate('D, d M Y H:i:s', $r['date_modified']) . ' GMT') {
			mysql_close();
			header('HTTP/1.1 304 Not Modified' . "\r\n");
			exit;
		}
	
		// headers
		header('Content-type: application/xml; charset=gb2312' . "\r\n");
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT' . "\r\n");
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $r['date_modified']) . ' GMT' . "\r\n");
		header('Cache-Control: max-age=3600' . "\r\n");
		header('ETag: ' . $r['date_modified'] . "\r\n");
	
		// determine RSS version
		switch($mode) {
			case '0.91':
				// generate rss feed
				mysql_data_seek($q, 0);
				
				// Channel
				echo '<?xml version="1.0" encoding="gb2312"?>' . "\r\n";
				echo '<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">' . "\r\n";
				echo '<rss version="0.91">' . "\r\n";
				echo '<channel>' . "\r\n";
				echo "\t" . '<title><![CDATA[' . htmlspecialchars(stripslashes($conf_page_title)) . ' (RSS 0.91)]]></title>' . "\r\n";
				echo "\t" . '<link>' . $conf_web_root . '</link>' . "\r\n";
				echo "\t" . '<description>RSS feed of ' . $conf_page_title . '</description>' . "\r\n";
				echo "\t" . '<language>zh-cn</language>' . "\r\n";
			
				if($n > 0) {
					// Items
					while($r = mysql_fetch_assoc($q)) {
						echo "\t" . '<item>' . "\r\n";
						echo "\t\t" . '<title><![CDATA[' . htmlspecialchars(substr(stripslashes($r['topic']), 0, 40)) . ']]></title>' . "\r\n";	// max 40 chars
						echo "\t\t" . '<link>' . $conf_web_root . 'blog.php?id=' . $r['id'] . '</link>' . "\r\n";
						echo "\t\t" . '<description><![CDATA[' . bbcode($r['text']) . ']]></description>' . "\r\n";
						echo "\t" . '</item>' . "\r\n";
					}
				
				}
			
				echo '</channel>' . "\r\n";
				echo '</rss>';
				break;
			default:
				// generate RSS 2.0
				mysql_data_seek($q, 0);
	
				// Channel
				echo '<?xml version="1.0" encoding="gb2312"?>' . "\r\n";
				echo '<rss version="2.0">' . "\r\n";
				echo '<channel>' . "\r\n";
				echo "\t" . '<title><![CDATA[' . htmlspecialchars(stripslashes($conf_page_title)) . ' (RSS 2.0)]]></title>' . "\r\n";
				echo "\t" . '<link>' . $conf_web_root . '</link>' . "\r\n";
				echo "\t" . '<description>RSS feed of ' . $conf_page_title . '</description>' . "\r\n";
				echo "\t" . '<language>zh-cn</language>' . "\r\n";
				echo "\t" . '<copyright><![CDATA[&copy; ' . $conf_admin_username . ' @ ' . $conf_web_root . ']]></copyright>' . "\r\n";
				echo "\t" . '<generator>sBLOG ' . $conf_current_version . ' (Build ' . $conf_current_build . ')</generator>' . "\r\n";
				echo "\t" . '<pubDate>' . gmdate('D, d M Y H:i:s', $r['date_created']) . ' GMT</pubDate>' . "\r\n";
				echo "\t" . '<lastBuildDate>' . gmdate('D, d M Y H:i:s', $r['date_modified']) . ' GMT</lastBuildDate>' . "\r\n";
			
				if($n > 0) {
					// Items
					while($r = mysql_fetch_assoc($q)) {
						echo "\t" . '<item>' . "\r\n";
						echo "\t\t" . '<title><![CDATA[' . htmlspecialchars(substr(stripslashes($r['topic']), 0, 40)) . ']]></title>' . "\r\n";	// max 40 chars
						echo "\t\t" . '<link>' . $conf_web_root . 'blog.php?id=' . $r['id'] . '</link>' . "\r\n";
						echo "\t\t" . '<description><![CDATA[' . bbcode($r['text']) . ']]></description>' . "\r\n";
						echo "\t\t" . '<pubDate>' . gmdate('D, d M Y H:i:s', $r['date_created']) . ' GMT</pubDate>' . "\r\n";
						echo "\t\t" . '<comments>' . $conf_web_root . 'comments.php?id=' . $r['id'] . '</comments>' . "\r\n";
						echo "\t\t" . '<author><![CDATA[' . $conf_admin_username . ' <' . $conf_admin_email . '>]]></author>' . "\r\n";
						echo "\t\t" . '<guid isPermaLink="true">' . $conf_web_root . 'blog.php?id=' . $r['id'] . '</guid>' . "\r\n";
						echo "\t" . '</item>' . "\r\n";
					}
				
				}
			
				echo '</channel>' . "\r\n";
				echo '</rss>';
				break;
		}
	}
	
	mysql_close();

?>