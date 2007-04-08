<?php
/***************************************************************************
 *                              admin_board.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_board.php,v 1.51.2.9 2004/11/18 17:49:33 acydburn Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Configuration'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_hide.' . $phpEx);
//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	if ( $HTTP_POST_VARS['email_enabled'] == '0' )
 	{
 		$HTTP_POST_VARS['board_email_form'] = 0;
 		$HTTP_POST_VARS['require_activation'] = USER_ACTIVATION_NONE;
 	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ($config_name == 'cookie_name')
		{
			$cookie_name = str_replace('.', '_', $new['cookie_name']);
		}

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$style_select = style_select($new['default_style'], 'default_style', "../templates");
$lang_select = language_select($new['default_lang'], 'default_lang', "language");
$timezone_select = tz_select($new['board_timezone'], 'board_timezone');

$disable_board_yes = ( $new['board_disable'] ) ? "checked=\"checked\"" : "";
$disable_board_no = ( !$new['board_disable'] ) ? "checked=\"checked\"" : "";

$cookie_secure_yes = ( $new['cookie_secure'] ) ? "checked=\"checked\"" : "";
$cookie_secure_no = ( !$new['cookie_secure'] ) ? "checked=\"checked\"" : "";

$html_tags = $new['allow_html_tags'];

$override_user_style_yes = ( $new['override_user_style'] ) ? "checked=\"checked\"" : "";
$override_user_style_no = ( !$new['override_user_style'] ) ? "checked=\"checked\"" : "";

$html_yes = ( $new['allow_html'] ) ? "checked=\"checked\"" : "";
$html_no = ( !$new['allow_html'] ) ? "checked=\"checked\"" : "";

$bbcode_yes = ( $new['allow_bbcode'] ) ? "checked=\"checked\"" : "";
$bbcode_no = ( !$new['allow_bbcode'] ) ? "checked=\"checked\"" : "";

$activation_none = ( $new['require_activation'] == USER_ACTIVATION_NONE ) ? "checked=\"checked\"" : "";
$activation_user = ( $new['require_activation'] == USER_ACTIVATION_SELF ) ? "checked=\"checked\"" : "";
$activation_admin = ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "";

$disable_board_admin_mod_none = ( $new['board_disable_admin_mod'] == BOARD_DISABLE_ADMIN_MOD_NONE ) ? "checked=\"checked\"" : "";
$disable_board_admin_mod_mod = ( $new['board_disable_admin_mod'] == BOARD_DISABLE_ADMIN_MOD_MOD ) ? "checked=\"checked\"" : "";
$disable_board_admin_mod_admin = ( $new['board_disable_admin_mod'] == BOARD_DISABLE_ADMIN_MOD_ADMIN ) ? "checked=\"checked\"" : "";

$confirm_yes = ($new['enable_confirm']) ? 'checked="checked"' : '';
$confirm_no = (!$new['enable_confirm']) ? 'checked="checked"' : '';

$allow_autologin_yes = ($new['allow_autologin']) ? 'checked="checked"' : '';
$allow_autologin_no = (!$new['allow_autologin']) ? 'checked="checked"' : '';

$board_email_form_yes = ( $new['board_email_form'] ) ? "checked=\"checked\"" : "";
$board_email_form_no = ( !$new['board_email_form'] ) ? "checked=\"checked\"" : "";

$email_enabled_yes = ( $new['email_enabled'] ) ? "checked=\"checked\"" : "";
$email_enabled_no = ( !$new['email_enabled'] ) ? "checked=\"checked\"" : "";

$gzip_yes = ( $new['gzip_compress'] ) ? "checked=\"checked\"" : "";
$gzip_no = ( !$new['gzip_compress'] ) ? "checked=\"checked\"" : "";

$privmsg_on = ( !$new['privmsg_disable'] ) ? "checked=\"checked\"" : "";
$privmsg_off = ( $new['privmsg_disable'] ) ? "checked=\"checked\"" : "";

$prune_yes = ( $new['prune_enable'] ) ? "checked=\"checked\"" : "";
$prune_no = ( !$new['prune_enable'] ) ? "checked=\"checked\"" : "";
// Start add - Birthday MOD
$birthday_greeting_yes = ( $new['birthday_greeting'] ) ? "checked=\"checked\"" : "";
$birthday_greeting_no = ( !$new['birthday_greeting'] ) ? "checked=\"checked\"" : "";
$birthday_required_yes = ( $new['birthday_required'] ) ? "checked=\"checked\"" : "";
$birthday_required_no = ( !$new['birthday_required'] ) ? "checked=\"checked\"" : "";
// End add - Birthday MOD

$smile_yes = ( $new['allow_smilies'] ) ? "checked=\"checked\"" : "";
$smile_no = ( !$new['allow_smilies'] ) ? "checked=\"checked\"" : "";

$sig_yes = ( $new['allow_sig'] ) ? "checked=\"checked\"" : "";
$sig_no = ( !$new['allow_sig'] ) ? "checked=\"checked\"" : "";

$namechange_yes = ( $new['allow_namechange'] ) ? "checked=\"checked\"" : "";
$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";
$sellpost_yes = ( $new['allow_sellpost'] ) ? "checked=\"checked\"" : "";
$sellpost_no = ( !$new['allow_sellpost'] ) ? "checked=\"checked\"" : "";
$hide4reply_yes = ( $new['allow_hide4reply'] ) ? "checked=\"checked\"" : "";
$hide4reply_no = ( !$new['allow_hide4reply'] ) ? "checked=\"checked\"" : "";
$hide4posts_yes = ( $new['allow_hide4posts'] ) ? "checked=\"checked\"" : "";
$hide4posts_no = ( !$new['allow_hide4posts'] ) ? "checked=\"checked\"" : "";
$hide4fortune_yes = ( $new['allow_hide4fortune'] ) ? "checked=\"checked\"" : "";
$hide4fortune_no = ( !$new['allow_hide4fortune'] ) ? "checked=\"checked\"" : "";
$cashtype_others = ( $new['cash_system_type'] == CASH_TYPE_OTHERS ) ? "checked=\"checked\"" : "";
$cashtype_points = ( $new['cash_system_type'] == CASH_TYPE_POINTS ) ? "checked=\"checked\"" : "";
$cashtype_cashmod2 = ( $new['cash_system_type'] == CASH_TYPE_CASHMOD2 ) ? "checked=\"checked\"" : "";

$quickreply_yes = ( $new['allow_quickreply'] ) ? "checked=\"checked\"" : "";
$quickreply_no = ( !$new['allow_quickreply'] ) ? "checked=\"checked\"" : "";
$anonymous_sqr_mode_basic = ( $new['anonymous_sqr_mode']==0 ) ? 'checked="checked"' : '';
$anonymous_sqr_mode_advanced = ( $new['anonymous_sqr_mode']!=0 ) ? 'checked="checked"' : '';

$anonymous_sqr_select = quick_reply_select($new['anonymous_show_sqr'], 'anonymous_show_sqr');
$anonymous_open_sqr_yes = ( $new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";
$anonymous_open_sqr_no = ( !$new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";

$avatars_local_yes = ( $new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_local_no = ( !$new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_remote_yes = ( $new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_remote_no = ( !$new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_upload_yes = ( $new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";
$avatars_upload_no = ( !$new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";

$smtp_yes = ( $new['smtp_delivery'] ) ? "checked=\"checked\"" : "";
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

$template->set_filenames(array(
	"body" => "admin/board_config_body.tpl")
);

//report forum selection
$sql = "SELECT f.forum_name, f.forum_id
	FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE c.cat_id = f.cat_id ORDER BY c.cat_order ASC, f.forum_order ASC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain forum list", "", __LINE__, __FILE__, $sql);
}
$report_forum_rows = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$report_forum_select_list = '<select name="report_forum">';
$report_forum_select_list .= '<option value="0">' . $lang['None'] . '</option>';
for($i = 0; $i < count($report_forum_rows); $i++)
{
	$report_forum_select_list .= '<option value="' . $report_forum_rows[$i]['forum_id'] . '">' . $report_forum_rows[$i]['forum_name'] . '</option>';
}
$report_forum_select_list .= '</select>';
$report_forum_select_list = str_replace("value=\"".$new['report_forum']."\">", "value=\"".$new['report_forum']."\" SELECTED>*" ,$report_forum_select_list);

//
// Escape any quotes in the site description for proper display in the text
// box on the admin page 
//
$new['site_desc'] = str_replace('"', '&quot;', $new['site_desc']);
$new['sitename'] = str_replace('"', '&quot;', strip_tags($new['sitename']));
$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_CONFIGURATION_TITLE" => $lang['General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['General_settings'],
	"L_SERVER_NAME" => $lang['Server_name'], 
	"L_SERVER_NAME_EXPLAIN" => $lang['Server_name_explain'], 
	"L_SERVER_PORT" => $lang['Server_port'], 
	"L_SERVER_PORT_EXPLAIN" => $lang['Server_port_explain'], 
	"L_SCRIPT_PATH" => $lang['Script_path'], 
	"L_SCRIPT_PATH_EXPLAIN" => $lang['Script_path_explain'], 
	"L_SITE_NAME" => $lang['Site_name'],
	"L_SITE_DESCRIPTION" => $lang['Site_desc'],
	"L_DISABLE_BOARD" => $lang['Board_disable'], 
	"L_DISABLE_BOARD_EXPLAIN" => $lang['Board_disable_explain'],
	"L_DISABLE_BOARD_MSG" => $lang['Board_disable_msg'],
	"L_DISABLE_BOARD_MSG_EXPLAIN" => $lang['Board_disable_msg_explain'],
	"L_DISABLE_BOARD_DOWNTIME" => $lang['Board_disable_downtime'],
	"L_DISABLE_BOARD_DOWNTIME_EXPLAIN" => $lang['Board_disable_downtime_explain'],
	"L_DISABLE_BOARD_NOTES" => $lang['Board_disable_notes'],
	"L_DISABLE_BOARD_NOTES_EXPLAIN" => $lang['Board_disable_notes_explain'],
	"L_DISABLE_BOARD_ADMIN_MOD" => $lang['Board_disable_admin_mod'],
	"L_DISABLE_BOARD_ADMIN_MOD_EXPLAIN" => $lang['Board_disable_admin_mod_explain'],
	"L_DISABLE_BOARD_SETTINGS" => $lang['Board_disable_settings'],
	"L_MOD" => $lang['Board_disable_Moderator'], 
	"L_D_ADMIN" => $lang['Board_disable_Admin'], 
	"L_ACCT_ACTIVATION" => $lang['Acct_activation'], 
	"L_NONE" => $lang['Acc_None'], 
	"L_USER" => $lang['Acc_User'], 
	"L_ADMIN" => $lang['Acc_Admin'], 
	"L_VISUAL_CONFIRM" => $lang['Visual_confirm'], 
	"L_VISUAL_CONFIRM_EXPLAIN" => $lang['Visual_confirm_explain'], 
	"L_ALLOW_AUTOLOGIN" => $lang['Allow_autologin'],
	"L_ALLOW_AUTOLOGIN_EXPLAIN" => $lang['Allow_autologin_explain'],
	"L_AUTOLOGIN_TIME" => $lang['Autologin_time'],
	"L_AUTOLOGIN_TIME_EXPLAIN" => $lang['Autologin_time_explain'],
	"L_COOKIE_SETTINGS" => $lang['Cookie_settings'], 
	"L_COOKIE_SETTINGS_EXPLAIN" => $lang['Cookie_settings_explain'], 
	"L_COOKIE_DOMAIN" => $lang['Cookie_domain'],
	"L_COOKIE_NAME" => $lang['Cookie_name'], 
	"L_COOKIE_PATH" => $lang['Cookie_path'], 
	"L_COOKIE_SECURE" => $lang['Cookie_secure'], 
	"L_COOKIE_SECURE_EXPLAIN" => $lang['Cookie_secure_explain'], 
	"L_SESSION_LENGTH" => $lang['Session_length'], 
	"L_PRIVATE_MESSAGING" => $lang['Private_Messaging'], 
	"L_INBOX_LIMIT" => $lang['Inbox_limits'], 
	"L_SENTBOX_LIMIT" => $lang['Sentbox_limits'], 
	"L_SAVEBOX_LIMIT" => $lang['Savebox_limits'], 
	"L_DISABLE_PRIVATE_MESSAGING" => $lang['Disable_privmsg'], 
	"L_ENABLED" => $lang['Enabled'], 
	"L_DISABLED" => $lang['Disabled'], 
	"L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],
	"L_WHO_IS_ONLINE_TIME" => $lang['who_is_online_time'],
	"L_MAX_POLL_OPTIONS" => $lang['Max_poll_options'],
	"L_FLOOD_INTERVAL" => $lang['Flood_Interval'],
	"L_FLOOD_INTERVAL_EXPLAIN" => $lang['Flood_Interval_explain'],
	'L_MAX_LOGIN_ATTEMPTS' => $lang['Max_login_attempts'],
	'L_MAX_LOGIN_ATTEMPTS_EXPLAIN' => $lang['Max_login_attempts_explain'],
	'L_LOGIN_RESET_TIME' => $lang['Login_reset_time'],
	'L_LOGIN_RESET_TIME_EXPLAIN' => $lang['Login_reset_time_explain'],
	'MAX_LOGIN_ATTEMPTS' => $new['max_login_attempts'],
	'LOGIN_RESET_TIME' => $new['login_reset_time'],
 
	"L_BOARD_EMAIL_FORM" => $lang['Board_email_form'], 
	"L_BOARD_EMAIL_FORM_EXPLAIN" => $lang['Board_email_form_explain'],
	"L_EMAIL_ENABLED" => $lang['Email_enabled'], 
 	"L_EMAIL_ENABLED_EXPLAIN" => $lang['Email_enabled_explain'], 
	"L_TOPICS_PER_PAGE" => $lang['Topics_per_page'],
	"L_POSTS_PER_PAGE" => $lang['Posts_per_page'],
	"L_HOT_THRESHOLD" => $lang['Hot_threshold'],
	"L_DEFAULT_STYLE" => $lang['Default_style'],
	"L_OVERRIDE_STYLE" => $lang['Override_style'],
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],
	"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
	"L_DATE_FORMAT" => $lang['Date_format'],
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],
	"L_ENABLE_GZIP" => $lang['Enable_gzip'],
	"L_ENABLE_PRUNE" => $lang['Enable_prune'],
// Start add - Birthday MOD
	"L_ENABLE_BIRTHDAY_GREETING" => $lang['Enable_birthday_greeting'],
	"L_BIRTHDAY_GREETING_EXPLAIN" => $lang['Birthday_greeting_expain'],
	"L_BIRTHDAY_REQUIRED" => $lang['Birthday_required'],
	"L_MAX_USER_AGE" => $lang['Max_user_age'],
	"L_MIN_USER_AGE" => $lang['Min_user_age'],
	"L_MIN_USER_AGE_EXPLAIN" => $lang['Min_user_age_explain'],
	"L_BIRTHDAY_LOOKFORWARD" => $lang['Birthday_lookforward'],
	"L_BIRTHDAY_LOOKFORWARD_EXPLAIN" => $lang['Birthday_lookforward_explain'],
// End add - Birthday MOD
	'L_BLUECARD_LIMIT' => $lang['Bluecard_limit'], 
    'L_BLUECARD_LIMIT_EXPLAIN' => $lang['Bluecard_limit_explain'], 
    'L_BLUECARD_LIMIT_2' => $lang['Bluecard_limit_2'], 
    'L_BLUECARD_LIMIT_2_EXPLAIN' => $lang['Bluecard_limit_2_explain'], 
    'L_MAX_USER_BANCARD' => $lang['Max_user_bancard'], 
    'L_MAX_USER_BANCARD_EXPLAIN' => $lang['Max_user_bancard_explain'], 
    'L_REPORT_FORUM' => $lang['Report_forum'],
    'L_REPORT_FORUM_EXPLAIN' => $lang['Report_forum_explain'],
	"L_ALLOW_HTML" => $lang['Allow_HTML'],
	"L_ALLOW_BBCODE" => $lang['Allow_BBCode'],
	"L_ALLOWED_TAGS" => $lang['Allowed_tags'],
	"L_ALLOWED_TAGS_EXPLAIN" => $lang['Allowed_tags_explain'],
	"L_ALLOW_SMILIES" => $lang['Allow_smilies'],
	"L_SMILIES_PATH" => $lang['Smilies_path'],
	"L_SMILIES_PATH_EXPLAIN" => $lang['Smilies_path_explain'],
	"L_ALLOW_SIG" => $lang['Allow_sig'],
	"L_MAX_SIG_LENGTH" => $lang['Max_sig_length'],
	"L_MAX_SIG_LENGTH_EXPLAIN" => $lang['Max_sig_length_explain'],
	"L_ALLOW_NAME_CHANGE" => $lang['Allow_name_change'],
	"L_SQR_SETTINGS" => $lang['SQR_settings'],
	"L_ALLOW_QUICK_REPLY" => $lang['Allow_quick_reply'],
	"L_ANONYMOUS_SHOW_SQR" => $lang['Anonymous_show_SQR'],
	"L_ANONYMOUS_SQR_MODE" => $lang['Anonymous_SQR_mode'],
	"L_ANONYMOUS_SQR_MODE_BASIC" => $lang['Quick_reply_mode_basic'],
	"L_ANONYMOUS_SQR_MODE_ADVANCED" => $lang['Quick_reply_mode_advanced'],
	"L_ANONYMOUS_OPEN_SQR" => $lang['Anonymous_open_SQR'],
	"L_AVATAR_SETTINGS" => $lang['Avatar_settings'],
	"L_ALLOW_LOCAL" => $lang['Allow_local'],
	"L_ALLOW_REMOTE" => $lang['Allow_remote'],
	"L_ALLOW_REMOTE_EXPLAIN" => $lang['Allow_remote_explain'],
	"L_ALLOW_UPLOAD" => $lang['Allow_upload'],
	"L_MAX_FILESIZE" => $lang['Max_filesize'],
	"L_MAX_FILESIZE_EXPLAIN" => $lang['Max_filesize_explain'],
	"L_MAX_AVATAR_SIZE" => $lang['Max_avatar_size'],
	"L_MAX_AVATAR_SIZE_EXPLAIN" => $lang['Max_avatar_size_explain'],
	"L_AVATAR_STORAGE_PATH" => $lang['Avatar_storage_path'],
	"L_AVATAR_STORAGE_PATH_EXPLAIN" => $lang['Avatar_storage_path_explain'],
	"L_AVATAR_GALLERY_PATH" => $lang['Avatar_gallery_path'],
	"L_AVATAR_GALLERY_PATH_EXPLAIN" => $lang['Avatar_gallery_path_explain'],
	"L_COPPA_SETTINGS" => $lang['COPPA_settings'],
	"L_COPPA_FAX" => $lang['COPPA_fax'],
	"L_COPPA_MAIL" => $lang['COPPA_mail'],
	"L_COPPA_MAIL_EXPLAIN" => $lang['COPPA_mail_explain'],
	"L_EMAIL_SETTINGS" => $lang['Email_settings'],
	"L_ADMIN_EMAIL" => $lang['Admin_email'],
	"L_EMAIL_SIG" => $lang['Email_sig'],
	"L_EMAIL_SIG_EXPLAIN" => $lang['Email_sig_explain'],
	"L_USE_SMTP" => $lang['Use_SMTP'],
	"L_USE_SMTP_EXPLAIN" => $lang['Use_SMTP_explain'],
	"L_SMTP_SERVER" => $lang['SMTP_server'], 
	"L_SMTP_USERNAME" => $lang['SMTP_username'], 
	"L_SMTP_USERNAME_EXPLAIN" => $lang['SMTP_username_explain'], 
	"L_SMTP_PASSWORD" => $lang['SMTP_password'], 
	"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'], 
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	"L_HIDE_POST" => $lang['Hide_post'],
	"L_ALLOW_SELL_POST" => $lang['Allow_sell_post'],
	"L_MAX_SELLINGPRICE" => $lang['Max_sellingprice'],
	"L_MAX_PRICE_EXPLAIN" => $lang['Max_price_explain'],
	"L_MIN_SELLINGPRICE" => $lang['Min_sellingprice'],
	"L_MIN_PRICE_EXPLAIN" => $lang['Min_price_explain'],
	"SELLPOST_YES" => $sellpost_yes,
	"SELLPOST_NO" => $sellpost_no,
	"MAX_SELLINGPRICE" => $new['max_sellingprice'],
	"MIN_SELLINGPRICE" => $new['min_sellingprice'],	
	"L_ALLOW_HIDE4REPLY" => $lang['Allow_hide4reply'],
	"HIDE4REPLY_YES" => $hide4reply_yes,
	"HIDE4REPLY_NO" => $hide4reply_no,
	"L_ALLOW_HIDE4POSTS" => $lang['Allow_hide4posts'],
	"L_MAX_POSTS_REQUIRED" => $lang['Max_posts_required'],
	"L_MAX_POSTS_EXPLAIN" => $lang['Max_posts_explain'],
	"L_MIN_POSTS_REQUIRED" => $lang['Min_posts_required'],
	"L_MIN_POSTS_EXPLAIN" => $lang['Min_posts_explain'],
	"HIDE4POSTS_YES" => $hide4posts_yes,
	"HIDE4POSTS_NO" => $hide4posts_no,	
	"MAX_POSTSREQUIRED" => $new['max_postsrequired'],
	"MIN_POSTSREQUIRED" => $new['min_postsrequired'],
	"L_ALLOW_HIDE4FORTUNE" => $lang['Allow_hide4fortune'],
	"L_MAX_FORTUNE_REQUIRED" => $lang['Max_fortune_required'],
	"L_MAX_FORTUNE_EXPLAIN" => $lang['Max_fortune_explain'],
	"L_MIN_FORTUNE_REQUIRED" => $lang['Min_fortune_required'],
	"L_MIN_FORTUNE_EXPLAIN" => $lang['Min_fortune_explain'],
	"HIDE4FORTUNE_YES" => $hide4fortune_yes,
	"HIDE4FORTUNE_NO" => $hide4fortune_no,
	"MAX_FORTUNEREQUIRED" => $new['max_fortunerequired'],
	"MIN_FORTUNEREQUIRED" => $new['min_fortunerequired'],
	"L_CASHSYSTEMTYPE" => $lang['Cash_system_type'],
	"L_CASH_TYPE_EXPLAIN" => $lang['Cash_type_explain'],
	"L_CASH_OTHERS" => $lang['Cash_others'],
	"L_CASH_FIELDNAME" => $lang['Cash_fieldname'],
	"L_CASH_FIELD_EXPLAIN" => $lang['Cash_fieldname_explain'],
	"L_CASH_NAME" => $lang['Cash_name'],
	"L_CASH_NAME_EXPLAIN" => $lang['Cash_name_explain'],
	"CASHTYPE_POINTS" => $cashtype_points,
	"CASHTYPE_CASHMOD2" => $cashtype_cashmod2,
	"CASHTYPE_OTHERS" => $cashtype_others,
	"CASH_FIELD_NAME" => $new['cash_field_name'],
	"CASH_NAME" => $new['cash_type_name'],

	
	"SERVER_NAME" => $new['server_name'], 
	"SCRIPT_PATH" => $new['script_path'], 
	"SERVER_PORT" => $new['server_port'], 
	"SITENAME" => $new['sitename'],
	"SITE_DESCRIPTION" => $new['site_desc'], 
	"S_DISABLE_BOARD_YES" => $disable_board_yes,
	"S_DISABLE_BOARD_NO" => $disable_board_no,
	"ACTIVATION_NONE" => USER_ACTIVATION_NONE, 
	"ACTIVATION_NONE_CHECKED" => $activation_none,
	"ACTIVATION_USER" => USER_ACTIVATION_SELF, 
	"ACTIVATION_USER_CHECKED" => $activation_user,
	"ACTIVATION_ADMIN" => USER_ACTIVATION_ADMIN, 
	"ACTIVATION_ADMIN_CHECKED" => $activation_admin,
	"BOARD_DISABLE_MSG" => $new['board_disable_msg'],
	"BOARD_DISABLE_DOWNTIME" => $new['board_disable_downtime'],
	"BOARD_DISABLE_NOTES" => $new['board_disable_notes'],
	"DISABLE_BOARD_ADMIN_MOD_NONE" => BOARD_DISABLE_ADMIN_MOD_NONE,
	"DISABLE_BOARD_ADMIN_MOD_NONE_CHECKED" => $disable_board_admin_mod_none,
	"DISABLE_BOARD_ADMIN_MOD_MOD" => BOARD_DISABLE_ADMIN_MOD_MOD,
	"DISABLE_BOARD_ADMIN_MOD_MOD_CHECKED" => $disable_board_admin_mod_mod,
	"DISABLE_BOARD_ADMIN_MOD_ADMIN" => BOARD_DISABLE_ADMIN_MOD_ADMIN,
	"DISABLE_BOARD_ADMIN_MOD_ADMIN_CHECKED" => $disable_board_admin_mod_admin, 
	"CONFIRM_ENABLE" => $confirm_yes,
	"CONFIRM_DISABLE" => $confirm_no,
	'ALLOW_AUTOLOGIN_YES' => $allow_autologin_yes,
	'ALLOW_AUTOLOGIN_NO' => $allow_autologin_no,
	'AUTOLOGIN_TIME' => (int) $new['max_autologin_time'],
	"BOARD_EMAIL_FORM_ENABLE" => $board_email_form_yes, 
	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 
	"EMAIL_ENABLED_YES" => $email_enabled_yes,
 	"EMAIL_ENABLED_NO" => $email_enabled_no,
	"WHO_IS_ONLINE_TIME" => $new['who_is_online_time'],
	"MAX_POLL_OPTIONS" => $new['max_poll_options'], 
	"FLOOD_INTERVAL" => $new['flood_interval'],
	"TOPICS_PER_PAGE" => $new['topics_per_page'],
	"POSTS_PER_PAGE" => $new['posts_per_page'],
	"HOT_TOPIC" => $new['hot_threshold'],
	"STYLE_SELECT" => $style_select,
	"OVERRIDE_STYLE_YES" => $override_user_style_yes,
	"OVERRIDE_STYLE_NO" => $override_user_style_no,
	"LANG_SELECT" => $lang_select,
	"L_DATE_FORMAT_EXPLAIN" => $lang['Date_format_explain'],
	"DEFAULT_DATEFORMAT" => $new['default_dateformat'],
	"TIMEZONE_SELECT" => $timezone_select,
	"S_PRIVMSG_ENABLED" => $privmsg_on, 
	"S_PRIVMSG_DISABLED" => $privmsg_off, 
	"INBOX_LIMIT" => $new['max_inbox_privmsgs'], 
	"SENTBOX_LIMIT" => $new['max_sentbox_privmsgs'],
	"SAVEBOX_LIMIT" => $new['max_savebox_privmsgs'],
	"COOKIE_DOMAIN" => $new['cookie_domain'], 
	"COOKIE_NAME" => $new['cookie_name'], 
	"COOKIE_PATH" => $new['cookie_path'], 
	"SESSION_LENGTH" => $new['session_length'], 
	"S_COOKIE_SECURE_ENABLED" => $cookie_secure_yes, 
	"S_COOKIE_SECURE_DISABLED" => $cookie_secure_no, 
	"GZIP_YES" => $gzip_yes,
	"GZIP_NO" => $gzip_no,
	"PRUNE_YES" => $prune_yes,
	"PRUNE_NO" => $prune_no, 
	"BIRTHDAY_GREETING_YES" => $birthday_greeting_yes,
	"BIRTHDAY_GREETING_NO" => $birthday_greeting_no,
	"BIRTHDAY_REQUIRED_YES" => $birthday_required_yes,
	"BIRTHDAY_REQUIRED_NO" => $birthday_required_no, 
	"MAX_USER_AGE" => $new['max_user_age'],
	"MIN_USER_AGE" => $new['min_user_age'],
	"BIRTHDAY_LOOKFORWARD" => $new['birthday_check_day'],
	'BLUECARD_LIMIT' => $new['bluecard_limit'], 
    'BLUECARD_LIMIT_2' => $new['bluecard_limit_2'], 
    'MAX_USER_BANCARD' => $new['max_user_bancard'], 
    'S_REPORT_FORUM' => $report_forum_select_list,
	"HTML_TAGS" => $html_tags, 
	"HTML_YES" => $html_yes,
	"HTML_NO" => $html_no,
	"BBCODE_YES" => $bbcode_yes,
	"BBCODE_NO" => $bbcode_no,
	"SMILE_YES" => $smile_yes,
	"SMILE_NO" => $smile_no,
	"SIG_YES" => $sig_yes,
	"SIG_NO" => $sig_no,
	"SIG_SIZE" => $new['max_sig_chars'], 
	"NAMECHANGE_YES" => $namechange_yes,
	"NAMECHANGE_NO" => $namechange_no,
	"ANONYMOUS_SQR_SELECT" => $anonymous_sqr_select,
	"QUICKREPLY_YES" => $quickreply_yes,
	"QUICKREPLY_NO" => $quickreply_no,
	"ANONYMOUS_SQR_MODE_BASIC" => $anonymous_sqr_mode_basic,
	"ANONYMOUS_SQR_MODE_ADVANCED" => $anonymous_sqr_mode_advanced,
	"ANONYMOUS_OPEN_SQR_YES" => $anonymous_open_sqr_yes,
	"ANONYMOUS_OPEN_SQR_NO" => $anonymous_open_sqr_no,
	"AVATARS_LOCAL_YES" => $avatars_local_yes,
	"AVATARS_LOCAL_NO" => $avatars_local_no,
	"AVATARS_REMOTE_YES" => $avatars_remote_yes,
	"AVATARS_REMOTE_NO" => $avatars_remote_no,
	"AVATARS_UPLOAD_YES" => $avatars_upload_yes,
	"AVATARS_UPLOAD_NO" => $avatars_upload_no,
	"AVATAR_FILESIZE" => $new['avatar_filesize'],
	"AVATAR_MAX_HEIGHT" => $new['avatar_max_height'],
	"AVATAR_MAX_WIDTH" => $new['avatar_max_width'],
	"AVATAR_PATH" => $new['avatar_path'], 
	"AVATAR_GALLERY_PATH" => $new['avatar_gallery_path'], 
	"SMILIES_PATH" => $new['smilies_path'], 
	"INBOX_PRIVMSGS" => $new['max_inbox_privmsgs'], 
	"SENTBOX_PRIVMSGS" => $new['max_sentbox_privmsgs'], 
	"SAVEBOX_PRIVMSGS" => $new['max_savebox_privmsgs'], 
	"EMAIL_FROM" => $new['board_email'],
	"EMAIL_SIG" => $new['board_email_sig'],
	"SMTP_YES" => $smtp_yes,
	"SMTP_NO" => $smtp_no,
	"SMTP_HOST" => $new['smtp_host'],
	"SMTP_USERNAME" => $new['smtp_username'],
	"SMTP_PASSWORD" => $new['smtp_password'],
	"COPPA_MAIL" => $new['coppa_mail'],
	"COPPA_FAX" => $new['coppa_fax'])
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
