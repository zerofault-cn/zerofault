<?php
// rss_funtions.php
// Part of RSS Feed MOD
// Edit: 2005-04-15
// Copyright (c) 2004-2005, Egor Naklonyaeff

function FormatLanguage($lng)
{
// You can add you ISO 639 coutry code here or remove unused codes
	$iso639=array("albanian"=>"sq","arabic"=>"ar","azerbaijani"=>"az",
	    "bulgarian"=>"bg","chinese"=>"zh","chinese_simplified"=>"zh",
	    "chinese_traditional"=>"zh","croatian"=>"hr","czech"=>"cs",
	    "danish"=>"da","dutch"=>"nl","english"=>"en",
	    "esperanto"=>"eo","estonian"=>"et","finnish"=>"fi",
	    "french"=>"fr","japanese"=>"ja","galego"=>"gl",
	    "german"=>"de","greek"=>"el","hungarian"=>"hu",
	    "hebrew"=>"he","icelandic"=>"is","indonesian"=>"id",
	    "italian"=>"it","korean"=>"ko","kurdish"=>"ku",
	    "macedonian"=>"mk","moldavian"=>"mo","mongolian"=>"mn",
	    "norwegian"=>"no","polish"=>"pl","portuguese"=>"pt",
	    "romanian"=>"ro","russian"=>"ru","russian_tu"=>"ru",
	    "serbian"=>"sr","slovak"=>"sk","slovenian"=>"sl",
	    "spanish"=>"es","swedish"=>"sv","thai"=>"th",
	    "turkish"=>"tr","uigur"=>"ug","ukrainian"=>"uk",
	    "vietnamese"=>"vi","welsh"=>"cy");
    $user_lang=(isset($iso639[$lng]))? $iso639[$lng]:'';
	return(($user_lang!='')?"\n<language>$user_lang</language>":'');
}
function RSSTimeFormat($utime,$uoffset=0)
{
    global $HTTP_GET_VARS,$user_id,$useragent;
    if(CACHE_TO_FILE && ($user_id==ANONYMOUS) && empty($HTTP_GET_VARS))$uoffset=0;
    if((isset($HTTP_GET_VARS['time']) && $HTTP_GET_VARS['time']=='local')|| (strpos($useragent,'Abilon')!==false)|| (strpos($useragent,'ActiveRefresh')!==false))
    {
    	$uoffset=intval($uoffset);
    }
    else $uoffset=0;
	$result=gmdate("D, d M Y H:i:s", $utime + (3600 * $uoffset));
	$uoffset=intval($uoffset*100);
	$result.=' '.(($uoffset>0)?'+':'').(($uoffset==0)? 'GMT': sprintf((($uoffset<0)?"%05d":"%04d"),$uoffset));
	return $result;
}
function GetHTTPPasswd()
{
	header('WWW-Authenticate: Basic realm="For registred users only"');
    ExitWithHeader('401 Unauthorized','For registred users only');
}
function ExitWithHeader($output,$message='')
{
	global $db, $HTTP_SERVER_VARS;
	$db->sql_close();
	if(function_exists("getallheaders")) header("HTTP/1.1 $output");
	else header('Status: '.$output);
	$code=intval(substr($output,0,3));
	if(($code==200)||($code==304))
	{
	if(isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE'])) header("Last-Modified: ".$HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']);
	if(isset($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH'])) header("Etag: ".$HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH']);
	}
	if(!empty($message)) {
		header ('Content-Type: text/plain');
        echo $message;
	}
	exit;
}
function rss_session_begin($user_id, $user_ip, $page_id)
{
	global $db, $board_config,$HTTP_SERVER_VARS;
	$page_id = (int) $page_id;
	$user_id= (int) $user_id;
	$password=md5($HTTP_SERVER_VARS['PHP_AUTH_PW']);
   	$last_visit = 0;
	$current_time = time();
	$expiry_time = $current_time - $board_config['session_length'];
	$sql = "SELECT *
		FROM " . USERS_TABLE . "
		WHERE user_id = $user_id";
	if ( !($result = $db->sql_query($sql)) )
	{
        ExitWithHeader('500 Internal Server Error','Could not obtain lastvisit data from user table');
	}
	$userdata = $db->sql_fetchrow($result);
    if(($user_id!=ANONYMOUS) && (!$userdata || ($password != $userdata['user_password'])))
    {
        ExitWithHeader('500 Internal Server Error','Error while create session');
    }
	$login=( $user_id != ANONYMOUS )?1:0;

	//
	// Initial ban check against user id, IP and email address
	//
	preg_match('/(..)(..)(..)(..)/', $user_ip, $user_ip_parts);

	$sql = "SELECT ban_ip, ban_userid, ban_email
		FROM " . BANLIST_TABLE . "
		WHERE ban_ip IN ('" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . $user_ip_parts[4] . "', '" . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . "ff', '" . $user_ip_parts[1] . $user_ip_parts[2] . "ffff', '" . $user_ip_parts[1] . "ffffff')
			OR ban_userid = $user_id";
	if ( $user_id != ANONYMOUS )
	{
		$sql .= " OR ban_email LIKE '" . str_replace("\'", "''", $userdata['user_email']) . "'
			OR ban_email LIKE '" . substr(str_replace("\'", "''", $userdata['user_email']), strpos(str_replace("\'", "''", $userdata['user_email']), "@")) . "'";
	}
	if ( !($result = $db->sql_query($sql)) )
	{
        ExitWithHeader("500 Internal Server Error","Could not obtain ban information");
	}

	if ( $ban_info = $db->sql_fetchrow($result) )
	{
		if ( $ban_info['ban_ip'] || $ban_info['ban_userid'] || $ban_info['ban_email'] )
		{
            ExitWithHeader("403 Forbidden","You been banned");
		}
	}

	$session_id = md5(uniqid($user_ip));
	$sql = "INSERT INTO " . SESSIONS_TABLE . "
			(session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in)
			VALUES ('$session_id', $user_id, $current_time, $current_time, '$user_ip', $page_id, $login)";
		if ( !$db->sql_query($sql) )
		{
            ExitWithHeader("500 Internal Server Error","Error creating new session");
		}
		$last_visit = ( $userdata['user_session_time'] > 0 ) ? $userdata['user_session_time'] : $current_time;
		$sql = "UPDATE " . USERS_TABLE . " SET user_session_time = $current_time, user_session_page = $page_id, user_lastvisit = $last_visit ";
        if(LV_MOD_INSTALLED) $sql.= ",user_lastlogon=$current_time, user_totallogon=user_totallogon+1";
		$sql .=" WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			 ExitWithHeader("500 Internal Server Error",'Error updating last visit time');
		}

	$userdata['user_lastvisit'] = $last_visit;
	$userdata['session_id'] = $session_id;
	$userdata['session_ip'] = $user_ip;
	$userdata['session_user_id'] = $user_id;
	$userdata['session_logged_in'] = $login;
	$userdata['session_page'] = $page_id;
	$userdata['session_start'] = $current_time;
	$userdata['session_time'] = $current_time;
    return $userdata;
}
function rss_get_user()
{
	global $db, $HTTP_SERVER_VARS, $HTTP_GET_VARS;
	if((!isset($HTTP_SERVER_VARS['PHP_AUTH_USER']) || !isset($HTTP_SERVER_VARS['PHP_AUTH_PW']))
		&& isset($HTTP_SERVER_VARS['REMOTE_USER']) && preg_match('/Basic\s+(.*)$/i', $HTTP_SERVER_VARS['REMOTE_USER'], $matches)) {
		list($name, $password) = explode(':', base64_decode($matches[1]), 2);
		$HTTP_SERVER_VARS['PHP_AUTH_USER'] = strip_tags($name);
		$HTTP_SERVER_VARS['PHP_AUTH_PW']	= strip_tags($password);
	}
	if (isset($HTTP_SERVER_VARS['PHP_AUTH_USER']) && isset($HTTP_SERVER_VARS['PHP_AUTH_PW'])) {
		$username=phpbb_clean_username($HTTP_SERVER_VARS['PHP_AUTH_USER']);
		$password=md5($HTTP_SERVER_VARS['PHP_AUTH_PW']);
		if(isset($HTTP_GET_VARS['uid'])){
			$uid=intval($HTTP_GET_VARS['uid']);
	   		$sql = "SELECT * FROM " . USERS_TABLE . " WHERE user_id = $uid";
	   	}
	   	else
	   		$sql = "SELECT user_id, username, user_password, user_active, user_level
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\\'", "''", $username) . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}
		if( $row = $db->sql_fetchrow($result) )
        {
         if( $password == $row['user_password'] && $row['user_active'] )
         {
	      // Yes!!!  It's good user
    	    return $row['user_id'];
         }
       	 else GetHTTPPasswd();
    }
    }
	else GetHTTPPasswd();
	return ANONYMOUS;
}
?>