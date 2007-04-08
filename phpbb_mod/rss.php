<?php
/***************************************************************************
*					rss.php
*				-------------------
*	begin		: Sat, October 23, 2004
*	copyright	: (c) 2004-2005, Egor Naklonyaeff
*	email		: chyduskam@naklon.info
*   more info   : http://naklon.info/rss/about.htm
*
*	$Id: rss.php,v 2.2.3 2005/04/16 21:57:00 chyduskam Exp $
*
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
****************************************************************************/
define ('IN_PHPBB', true);
$phpbb_root_path = './';

$ProgName='RSS Feed 2.2.3';
$verinfo='V223';
//
// BEGIN Includes of phpBB scripts
//

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/rss_config.'.$phpEx);
include($phpbb_root_path . 'includes/rss_functions.'.$phpEx);
if(!SMARTOR_STATS) {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
}
//
// END Includes of phpBB scripts
//
if(!defined('PAGE_RSS')) define('PAGE_RSS', PAGE_INDEX);
$deadline=0;
if(isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']))
{
    $deadline=strtotime($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']);
	if(CACHE_TIME>0) if((time()-$deadline)<CACHE_TIME)
	{
        ExitWithHeader("304 Not Modified");
	}
}
$sql= "SELECT MAX(post_time) as pt FROM ". POSTS_TABLE;
if ( !($result = $db->sql_query($sql)) )
	{
        ExitWithHeader("500 Internal Server Error","Error in obtaining post data");
	}
if( $row = $db->sql_fetchrow($result) )
{
    if($row['pt']<=$deadline) ExitWithHeader("304 Not Modified");
    $deadline=$row['pt'];
}

// BEGIN Cache Mod
$use_cached=false;
$cache_file ='';
if(CACHE_TO_FILE and CACHE_TIME>0) {
	$cache_file =$phpbb_root_path.$cache_root.$cache_filename;
	if($cache_root!='' and empty($HTTP_GET_VARS))
	{
    	 $cachefiletime=@filemtime($cache_file);
		 $timedif = ($deadline - $cachefiletime);
		 if ($timedif < CACHE_TIME and filesize($cache_file)>0) $use_cached=true;
	}
}
// END Cache Mod
//
// gzip_compression
//
$do_gzip_compress = FALSE;
$useragent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');
if($use_cached && AUTOSTYLED and strpos($useragent,'MSIE'))$use_cached=false;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();
	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			ob_start('ob_gzhandler');
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);
 				header('Content-Encoding: gzip');
			}
		}
	}
}
// end gzip block

// How many posts do you want to returnd (count)?  Specified in the URL with "c=".  Defaults to 25, upper limit of 50.
$count = ( isset($HTTP_GET_VARS['c']) ) ? intval($HTTP_GET_VARS['c']) : DEFAULT_ITEMS;
$count = ( $count == 0 ) ? DEFAULT_ITEMS : $count;
$count = ( $count > MAX_ITEMS ) ? MAX_ITEMS : $count;
// Which forum do you want posts from (forum_id)?  specified in the url with "f=".  Defaults to all (public) forums.
$forum_id = ( isset($HTTP_GET_VARS['f']) ) ? intval($HTTP_GET_VARS['f']) : '';
$no_limit=( isset($HTTP_GET_VARS['nolimit']) ) ? true : false;
$needlogin=( isset($HTTP_GET_VARS['login']) or isset($HTTP_GET_VARS['uid'])) ? true : false;

$sql_forum_where = ( !empty($forum_id) ) ? ' AND f.forum_id = ' . $forum_id : ' ';

// Return topics only, or all posts?  Specified in the URL with "t=".  Defaults to all posts (0).
$topics_only = (isset($HTTP_GET_VARS['t']) ) ? intval($HTTP_GET_VARS['t']) : 0;
$topics_view = (isset($HTTP_GET_VARS['topic']) ) ? intval($HTTP_GET_VARS['topic']) : 0;
$sql_topics_only_where = '';
if ( $topics_only == 1 )
{
	$sql_topics_only_where = 'AND p.post_id = t.topic_first_post_id';
}
if($topics_view != 0)
{
    $sql_topic_view = 'AND t.topic_id ='.$topics_view;
}
//
// BEGIN Session management
//
// Check user
$user_id=($needlogin)? rss_get_user() : ANONYMOUS;
if($user_id==ANONYMOUS && AUTOLOGIN)
{
	$userdata = session_pagestart($user_ip, PAGE_RSS);
	$user_id=$userdata["user_id"];
}
else $userdata=rss_session_begin($user_id, $user_ip, PAGE_RSS);
init_userprefs($userdata);
$username=$userdata["username"];

//
// END session management
//

// BEGIN Cache Mod
if($user_id==ANONYMOUS && $use_cached) {
    $MyETag='"RSS'.gmdate("YmdHis", $cachefiletime).$verinfo.'"';
	$MyGMTtime=gmdate("D, d M Y H:i:s", $cachefiletime)." GMT";
    if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
	{
		header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
	}
	else
	{
		header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
	}
	header("Last-Modified: ".$MyGMTtime);
	header("Etag: ".$MyETag);
	header("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
	header ('Content-Type: text/xml; charset='.$lang['ENCODING']);
	readfile($cache_file);
	}
	else
{
// END Cache Mod
//-----------------------------------------------------

// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
//
// BEGIN Create main board information (some code borrowed from functions_post.php)
//

// Build URL components
$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$viewpost = ( $script_name != '' ) ? $script_name . '/viewtopic.' . $phpEx : 'viewtopic.'. $phpEx;
$replypost = ( $script_name != '' ) ? $script_name . '/posting.' . $phpEx.'?mode=quote' : 'posting.'. $phpEx.'?mode=quote';
$index = ( $script_name != '' ) ? $script_name . '/index.' . $phpEx : 'index.'. $phpEx;
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
// Assemble URL components
$index_url = $server_protocol . $server_name . $server_port . (( $script_name != '' )? $script_name . '/':'');
$viewpost_url = $server_protocol . $server_name . $server_port . $viewpost;
$replypost_url =$server_protocol . $server_name . $server_port . $replypost;
// Reformat site name and description
$site_name = strip_tags($board_config['sitename']);
$site_description = strip_tags($board_config['site_desc']);
// Set the fully qualified url to your smilies folder
$smilies_path = $board_config['smilies_path'];
$smilies_url = $index_url . $smilies_path;
$smilies_path = preg_replace("/\//", "\/", $smilies_path);
//
// END Create main board information
//

// Auth check
$sql_forum_where="";
if($userdata['user_level']<>ADMIN)
{
	$is_auth = array();
	$is_auth = auth(AUTH_READ, AUTH_LIST_ALL, $userdata);
	if($forum_id=='') {
		while ( list($forumId, $auth_mode) = each($is_auth) )
		{
			if ( !$auth_mode['auth_read'] )
			{
				$unauthed .= ',' . $forumId;
			}
		}
	$sql_forum_where="AND f.forum_id NOT IN (" . $unauthed . ")";
	}
	else
	{
		if((!$is_auth[$forum_id]['auth_read']) or (strpos(",$unauthed," , ",$forum_id,")))
         {
          if($needlogin) ExitWithHeader("404 Not Found","This forum does not exists");
          else
          {
			header('Location: ' .$index_url.'rss.'.$phpEx.'?f='.$forum_id.(($no_limit)?'&nolimit':'').(isset($HTTP_GET_VARS['atom'])?'&atom':'').(isset($HTTP_GET_VARS['c'])?'&c='.$count:'').(isset($HTTP_GET_VARS['t'])?'&t='.$topics_only:'').(isset($HTTP_GET_VARS['styled'])?'&styled':'').'&login');
          	ExitWithHeader('301 Moved Permanently');
          }
		 }
		else $sql_forum_where = 'AND f.forum_id = ' . $forum_id;
	}
unset($is_auth);
}
elseif($forum_id!='')
{
	$sql_forum_where = 'AND f.forum_id = ' . $forum_id;
}

//
// BEGIN Initialise template
//
if(isset($HTTP_GET_VARS['atom']))
{
    $template->set_filenames(array("body" => "atom_body.tpl"));
    $verinfo.="A";
}
else
{
	$template->set_filenames(array("body" => "rss_body.tpl"));
    $verinfo.="R";
}
//
// END Initialise template
//
if(isset($HTTP_GET_VARS['styled']) or (AUTOSTYLED and strpos($useragent,'MSIE')))
{
	$template->assign_block_vars('switch_enable_xslt', array());
}
//
// BEGIN SQL statement to fetch active posts of allowed forums
//
$sql_limit_by_http='';
$MaxRecordAge=time()-MAX_WEEKS_AGO*604800;
$sql_limit_time=(MAX_WEEKS_AGO>0)?"p.post_time >".$MaxRecordAge:"1";
if (!$no_limit){
	if(isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE'])) {
		$NotErrorFlag=true;
		$NotModifiedSince=strtotime($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']);
		if(SEE_MODIFYED) $sql_limit_by_http =  "AND (p.post_time > ".$NotModifiedSince." OR p.post_edit_time >".$NotModifiedSince." )";
		else if($NotModifiedSince>$MaxRecordAge) $sql_limit_time="p.post_time > ".$NotModifiedSince;
	}
}
$getdesc=($forum_id<>'')?'f.forum_desc,':'';
$sql = "SELECT f.forum_name,".$getdesc." t.topic_id, t.topic_title, u.user_id,
	 u.username, u.user_sig, u.user_sig_bbcode_uid,u.user_allowsmile, p.post_time,p.post_username, p.post_edit_time,
	 p.enable_sig,p.enable_smilies,p.enable_bbcode,p.enable_html,pt.*, t.topic_replies, t.topic_first_post_id
	FROM " . FORUMS_TABLE . " AS f, " . TOPICS_TABLE . " AS t, " . USERS_TABLE . " AS u, " . POSTS_TABLE . " AS p, " . POSTS_TEXT_TABLE . " as pt
	WHERE
            $sql_limit_time
            $sql_forum_where
            $sql_limit_by_http
            AND pt.post_id = p.post_id
			AND t.forum_id = f.forum_id
			AND p.poster_id = u.user_id
			AND p.topic_id = t.topic_id
			AND p.hiding_type = 0
			$sql_topics_only_where
			$sql_topic_view
	ORDER BY p.post_time DESC LIMIT $count";
$posts_query = $db->sql_query($sql);
//
// END SQL statement to fetch active posts of public forums
//

//
// BEGIN Query failure check
//
if ( !$posts_query )
{
  ExitWithHeader("500 Internal Server Error","Could not query list of active posts");
}

$allposts = $db->sql_fetchrowset($posts_query);
if(($forum_id<>'')&&(count($allposts) != 0)) {
      $site_name=strip_tags($allposts[0]["forum_name"]);
      $site_description=$allposts[0]["forum_desc"];
      }

//
// BEGIN Assign static variables to template
//
// Variable reassignment for Topic Replies
$l_topic_replies = $lang['Topic'] . ' ' . $lang['Replies'];
$user_lang=$userdata['user_lang'];
if(empty($user_lang))$user_lang=$board_config['default_lang'];
$template->assign_vars(array(
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'BOARD_URL' => $index_url,
	'BOARD_TITLE' => htmlspecialchars(undo_htmlspecialchars($site_name)),
	'PROGRAM' => $ProgName,
	'BOARD_DESCRIPTION' => htmlspecialchars(undo_htmlspecialchars($site_description)),
	'BOARD_MANAGING_EDITOR' => $board_config['board_email'],
	'BOARD_WEBMASTER' => $board_config['board_email'],
	'BUILD_DATE' => gmdate('D, d M Y H:i:s').' GMT',
	'ATOM_BUILD_DATE'=>gmdate("Y-m-d\TH:i:s")."Z",
	'READER' => $username,
	'L_AUTHOR' => $lang['Author'],
	'L_POSTED' => $lang['Posted'],
	'L_TOPIC_REPLIES' => $l_topic_replies,
	'LANGUAGE'=>FormatLanguage($user_lang),
	'L_POST' => $lang['Post'])
);
//
// END Assign static variabless to template
//
$LastPostTime=0;
if ( count($allposts) == 0 )
{
 	if($NotErrorFlag) ExitWithHeader("304 Not Modified");
}
else
{
//
// BEGIN "item" loop
//
	$PostCount=0;
	$SeenTopics=array();
	foreach ($allposts as $post)
	 {
		if( $post['post_time']>$LastPostTime) $LastPostTime=$post['post_time'];
		if( $post['post_edit_time']>$LastPostTime) $LastPostTime=$post['post_edit_time'];
		$topic_id=$post['topic_id'];
        $PostCount++;
        $SeenTopics["$topic_id"]++;
		// Variable reassignment and reformatting for post text
		$post_id=$post['post_id'];
	   	$post_subject = ( $post['post_subject'] != '' ) ? $post['post_subject'] : '';
        $message = $post['post_text'];
		$bbcode_uid = $post['bbcode_uid'];
		$user_sig = ( $post['enable_sig'] && $post['user_sig'] != '' && $board_config['allow_sig'] ) ? $post['user_sig'] : '';
		$user_sig_bbcode_uid = $post['user_sig_bbcode_uid'];
	//
	// If the board has HTML off but the post has HTML
	// on then we process it, else leave it alone
	//
	if ( !$board_config['allow_html']||!$userdata['user_allowhtml'])
	{
		if ( $user_sig != '')
		{
			$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
		}

		if ( $post['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}
	}
	//
	// Parse message and/or sig for BBCode if reqd
	//
	if ( $board_config['allow_bbcode'] )
	{
		if ( $user_sig != '' && $user_sig_bbcode_uid != '' )
		{
			$user_sig = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $user_sig);
		}

		if ( $bbcode_uid != '' )
		{
			$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
		}
	}

	if ( $user_sig != '' )
	{
		$user_sig = make_clickable($user_sig);
	}
	$message = make_clickable($message);

	//
	// Parse smilies
	//
	if ( $board_config['allow_smilies'] )
	{
		if ( $post['user_allowsmile'] && $user_sig != '' )
		{
			$user_sig = smilies_pass($user_sig);
			$user_sig = preg_replace("/$smilies_path/", $smilies_url, $user_sig);
		}

		if ( $post['enable_smilies'] )
		{
			$message = smilies_pass($message);
			$message = preg_replace("/$smilies_path/", $smilies_url, $message);
		}
	}
	//
	// Replace naughty words
	//
	if (count($orig_word))
	{
		$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);

		if ($user_sig != '')
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
    	}

      $message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
	}
	//
	// Replace newlines (we use this rather than nl2br because
	// till recently it wasn't XHTML compliant)
	//
	if ( $user_sig != '' )
	{
		$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
	}

	$message = str_replace("\n", "\n<br />\n", $message);
		if ( $post_subject != '' )
		{
			$post_subject = htmlspecialchars($lang['Subject'].': '.$post_subject.'<br />');
		}
		// Variable reassignment for topic title, and show whether it is the start of topic, or a reply
		$topic_title = $post['topic_title'];
		if ( $post['post_id'] != $post['topic_first_post_id'] )
		{
			$topic_title = 'RE: ' . $topic_title;
		}
		// Variable reassignment and reformatting for author
		$author = $post['username'];
		$author0 =$author;
		if ( $post['user_id'] != -1 )
		{
			 $author = '<a href="' . $index_url . 'profile.' . $phpEx . '?mode=viewprofile&u=' . $post['user_id'] . '" target="_blank">'
			 . $author . '</a>';
		}
		else
		{
			// Uncomment next string if you want or $author0=='Anonymus'.
			//  $author0= $post['post_username'];
		    $author= $post['post_username'];
		}
		$author = make_clickable($author);
		// Assign "item" variables to template
		$template->assign_block_vars('post_item', array(
			'POST_URL' => $viewpost_url . '?' . POST_POST_URL . '=' . $post['post_id'] . '#' . $post['post_id'],
			'FIRST_POST_URL' => $viewpost_url . '?' . POST_POST_URL . '=' . $post['topic_first_post_id'] . '#' . $post['topic_first_post_id'],
			'REPLY_URL'=>$replypost_url."&amp;".POST_POST_URL."=".$post['post_id'],
            'TOPIC_TITLE' =>htmlspecialchars(undo_htmlspecialchars($topic_title)),
			'AUTHOR0' => htmlspecialchars($author0),
			'AUTHOR' => htmlspecialchars($author),
			'POST_TIME' => create_date($board_config['default_dateformat'], $post['post_time'], $board_config['board_timezone']).' (GMT ' . $board_config['board_timezone'] . ')',
			'ATOM_TIME'=>gmdate("Y-m-d\TH:i:s", $post['post_time'])."Z",
            'ATOM_TIME_M'=>($post['post_edit_time']<>"" ? gmdate("Y-m-d\TH:i:s", $post['post_edit_time'])."Z": gmdate("Y-m-d\TH:i:s", $post['post_time'])."Z"),
			'POST_SUBJECT' => $post_subject,
			'FORUM_NAME' => htmlspecialchars($post['forum_name']),
			'UTF_TIME'=>RSSTimeFormat($post['post_time'],$userdata['user_timezone']),
			'POST_TEXT' => htmlspecialchars(preg_replace('|[\x00-\x08\x0B\x0C\x0E-\x1f]|','',$message)),
			'USER_SIG' => htmlspecialchars($user_sig),
			'TOPIC_REPLIES' => $post['topic_replies']
			)
		);
	}
//
// END "item" loop
//
if($user_id!=ANONYMOUS && UPDATE_VIEW_COUNT)
{
    $updlist='';
	foreach ($SeenTopics as $topic_id=>$tcount)
	{
        $updlist.=(empty($updlist))? $topic_id : ",".$topic_id;
		if(defined('TOPIC_VIEW_TABLE') and AUTO_WVT_MOD)
		{
	        $sql='UPDATE '.TOPIC_VIEW_TABLE.' SET topic_id="'.$topic_id.'", view_time="'.time().'", view_count=view_count+1 WHERE topic_id='.$topic_id.' AND user_id='.$user_id;
			if ( !$db->sql_query($sql) || !$db->sql_affectedrows() )
			{
				$sql = 'INSERT IGNORE INTO '.TOPIC_VIEW_TABLE.' (topic_id, user_id, view_time,view_count)
				VALUES ('.$topic_id.', "'.$user_id.'", "'.time().'","1")';
				if ( !($db->sql_query($sql)) )
				{
					ExitWithHeader("500 Internal Server Error",'Error create user view topic information');
				}
			}
		}
		// End add - Who viewed a topic MOD
    }
    if($updlist!='')
    {
        //
		// Update the topic view counter
		//
		$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_views = topic_views + 1
		WHERE topic_id IN ($updlist)";
		if ( !$db->sql_query($sql) )
		{
			ExitWithHeader("500 Internal Server Error","Could not update topic views");
		}
    }
}
        // LAstvisit MOD
        if(LV_MOD_INSTALLED and $user_id!=ANONYMOUS){
		 $sql = "UPDATE " . USERS_TABLE . "
		  SET user_totalpages=user_totalpages+$PostCount
          WHERE user_id = $user_id";
		  if ( !$db->sql_query($sql) )
		{
			ExitWithHeader("500 Internal Server Error",'Error updating user totalpages ');
		}}
}
// Check for E-Tag
if($LastPostTime==0) $LastPostTime=$deadline;
$MyETag='"RSS'.gmdate("YmdHis", $LastPostTime).$verinfo.'"';
$MyGMTtime=gmdate("D, d M Y H:i:s", $LastPostTime)." GMT";
if(isset($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH'])&& ($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH']== $MyETag)) ExitWithHeader("304 Not Modified");
if(isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']) && ($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE'] == $MyGMTtime)) ExitWithHeader("304 Not Modified");

//
// BEGIN XML and nocaching headers (copied from page_header.php)
//

if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0, max-age=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header("Last-Modified: ".$MyGMTtime);
header("Etag: ".$MyETag);
header("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
header ('Content-Type: text/xml; charset='.$lang['ENCODING']);
//
// End XML and nocaching headers
//
//
// BEGIN Output XML page
//
// BEGIN Cache Mod
if(($user_id==ANONYMOUS) and CACHE_TO_FILE and ($cache_root!='') and empty($HTTP_GET_VARS) and !isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']) and !(AUTOSTYLED and strpos($useragent,'MSIE')))
{
	ob_start();
	$template->pparse('body');
	$out=ob_get_contents();
	ob_end_flush();
    if ($f = @fopen($cache_file, 'w')) {
		fwrite ($f, $out,strlen($out));
		fclose($f);
		}
}
else {
	 $template->pparse('body');
	 }
}// END Cache Mod
$gzip_text = ($board_config['gzip_compress']) ? 'GZIP enabled' : 'GZIP disabled';
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$gentime = round(($endtime - $starttime), 4);
if($show_time) {
	echo '<!-- Page generation time: '.$gentime .'s ';
    if(SMARTOR_STATS) {
      	$sql_time = round($db->sql_time, 4);
 		$sql_part = round($sql_time / $gentime * 100);
 		$excuted_queries = $db->num_queries;
		$php_part = 100 - $sql_part;
		echo '(PHP: '. $php_part .'% - SQL: '. $sql_part .'%) - SQL queries: '. $excuted_queries;
     }
    echo  ' - '. $gzip_text.' -->';
}
//
// END Output XML page
//
$db->sql_close();
//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}
exit;
?>