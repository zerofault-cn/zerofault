<?php
define('SESSION_METHOD_COOKIE', 100);
define('SESSION_METHOD_GET', 101);

function session_begin($user_name, $user_ip, $auto_create = 0, $enable_autologin = 0)
{
	global $db;
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;

	if ( isset($HTTP_COOKIE_VARS['mm_sid']) || isset($HTTP_COOKIE_VARS['mm_data']) )
	{
		$session_id = isset($HTTP_COOKIE_VARS['mm_sid']) ? $HTTP_COOKIE_VARS['mm_sid'] : '';
		$sessiondata = isset($HTTP_COOKIE_VARS['mm_data']) ? unserialize(stripslashes($HTTP_COOKIE_VARS['mm_data'])) : array();
		$sessionmethod = SESSION_METHOD_COOKIE;
	}
	else
	{
		$sessiondata = array();
		$session_id = ( isset($HTTP_GET_VARS['sid']) ) ? $HTTP_GET_VARS['sid'] : '';
		$sessionmethod = SESSION_METHOD_GET;
	}

	$current_time = time();

	//
	// Try and pull the last time stored in a cookie, if it exists
	//
	$login = 1;
	$userdata = array();
	$userdata["user_name"] = $user_name;

	//
	// Create or update the session
	//
	$session_id = md5(uniqid($user_ip));
	$userdata['session_id'] = $session_id;
	$userdata['user_ip'] = $user_ip;
	$userdata['login'] = $login;
	
	if ( $user_name != '' )
	{
		$sessiondata["user_name"] = $userdata["user_name"];
		$sessiondata["user_ip"] = $userdata["user_ip"];
		$sessiondata["user_level"] = $userdata["user_level"];
		$sessiondata["login"] = $userdata["login"];
		$sessiondata['autologinid'] = ( $enable_autologin && $sessionmethod == SESSION_METHOD_COOKIE ) ? $auto_login_key : '';
	}
	
	setcookie('mm_data', serialize($sessiondata));
	setcookie('mm_sid', $session_id);

	$SID = 'sid=' . $session_id;

	return $userdata;
}

//
// session_end closes out a session
// deleting the corresponding entry
// in the sessions table
//
function session_end($session_id, $user_name)
{
	global $db;
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;

	$current_time = time();

	//
	// Pull cookiedata or grab the URI propagated sid
	//
	if ( isset($HTTP_COOKIE_VARS['mm_sid']) )
	{
		$session_id = isset( $HTTP_COOKIE_VARS['mm_sid'] ) ? $HTTP_COOKIE_VARS['mm_sid'] : '';
		$sessionmethod = SESSION_METHOD_COOKIE;
	}
	else
	{
		$session_id = ( isset($HTTP_GET_VARS['sid']) ) ? $HTTP_GET_VARS['sid'] : '';
		$sessionmethod = SESSION_METHOD_GET;
	}

	setcookie('mm_data', '');
	setcookie('mm_sid', '');

	return true;
}

function append_sid($url, $non_html_amp = false)
{
	global $SID;

	if ( !empty($SID) && !preg_mm('#sid=#', $url) )
	{
		$url .= ( ( strpos($url, '?') != false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
	}

	return $url;
}

?>