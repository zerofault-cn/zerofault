<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

########################################################################
#Defaults:
#1 - Yes/On/True
#0 - No/Off/False
# do not remove or change this

define("yes", 1);
define("no", 0);

$themes 	= Array();
$languages 	= Array();

$fileiconpath = 'icon/';

$webmail_directory = substr(dirname(__FILE__), 0, -3);			//directory must end \

$temporary_directory = $webmail_directory.'.\\temp\\';				//directory must end \
$mailstore_directory = $webmail_directory.'..\\store\\';			//directory must end \

$system_config_file = $webmail_directory.'..\\system.cfg';
$userauth_config_file = $webmail_directory.'..\\userauth.cfg';
$domain_config_file = $webmail_directory.'..\\domain.cfg';
$userinfo_config_file = 'userinfo.dat';

$xml_database_comname = 'XmlDataBase.XmlParse';

########################################################################
# Your local SMTP Server (alias or IP) such as "smtp.yourdomain.com"
# eg. "server1;server2;server3"   -> specify main and backup server
########################################################################

$smtp_server = "127.0.0.1";  #YOU NEED CHANGE IT !!
$smtp_port = 25;
$pop3_server = "127.0.0.1";  #YOU NEED CHANGE IT !!
$pop3_port = 110;
$ldap_server = "127.0.0.1";
$ldap_port   = 389;

//ldap begin loyalman insert 
#######################################################################
# ldap basedn and bind dn
#######################################################################
$ldap_base_dn = "o=magicwinmail";
$ldap_root_dn = "o=magicwinmail";
$ldap_root_pwd = "";
//ldap end


########################################################################
# register new mailbox
########################################################################
$allow_register = no;					//allow user register
$congratulate_subject = 'Welcome';
$congratulate_content = 'Hi, %user%
Welcome to use the mail system!';
$quota_limit = 0;  //  in KB, eg. 5120 Kb = 5MB

$postmaster_address = '#@[]';

########################################################################
# Session timeout for inactivity
########################################################################

$idle_timeout = 30; //minutes

########################################################################
# Protocol and port
# Choose "imap" as protocol to use the Internet Mail Access Protocol, 
# or "pop3" to use the Post Office Protocol.
# The default ports are:
# pop3 -> 110
# imap -> 143
# The imap is more fast, but all functions of UebiMiau works with POP3
########################################################################

$mail_protocol 	= "pop3";
$mail_port	= 110;

########################################################################
# The TIME ZONE of server, format (+|-)HHMM (H=hours, M=minutes), eg. +0100
########################################################################
$server_time_zone = "+0800";

########################################################################
# Use SMTP password (AUTH LOGIN type)
########################################################################
$use_password_for_smtp	= yes;

########################################################################
# Redirect new users to the preferences page at first login
########################################################################
$check_first_login		= no;

########################################################################
# Enable visualization of HTML messages
# *This option afect only incoming messages, the  HTML editor
# for new messages (compose page) is automatically activated 
# when the client's browser support it (IE5 or higher)
########################################################################

$allow_html 		= yes;

########################################################################
# FILTER javascript (and others scripts) from incoming messages
########################################################################
$allow_scripts		= no;

########################################################################
# LOGIN_TYPE

# Note. You can supply the LOGIN_TYPE according to your MAIL SERVER.
# Eg. If your mail server requires usernames in user@domain.com, you must
# specify the LOGIN_TYPE as "%user%@%domain%". You can combine it according to 
# your server. eg.

# %user%
# %user%@%domain%
# %user%.%domain%

$mail_servers[] = Array(
	"domain" => "localhost", 
	"server" => "localhost", 
	"login_type" => "%user%"
);

########################################################################
# Language & themes settings
########################################################################

require("./inc/config.languages.php");

########################################################################
# Sms cgi settings
########################################################################

require("./inc/config.smscgi.php");

########################################################################
# Support for SendMail (DEFAULT DISABLED (using SMTP))
# Only for *nix Systems (NOT Win32)
########################################################################
$use_sendmail     = no;

########################################################################
$register_user_total = 20;

########################################################################
# In some POP3 servers, if you send a "RETR" command, your
# message will be automatically deleted :(
# This option prevents this inconvenience
########################################################################

$mail_use_top = yes;

########################################################################
# Name and Version, it's used in many places, like as
# "X-Mailer" field, footer
########################################################################

$appversion = "3.0";
$appname = "WebMail | Power by Magic Winmail Server";


########################################################################
# Add a "footer" to sent mails
########################################################################

$footer = "

_________________________________________________________
Message sent using $appname $appversion
";

########################################################################
# Enable debug :)
# no - disabled
# 1 or yes -> enabled with full results
# 2 -> enable with servers communications only
# ********************************************************/
$enable_debug = no;

########################################################################
# from url in message list.
########################################################################
$msglist_allowfromurl = yes;

########################################################################
# Block external images.
# If an HTML message have external images, it will be 
# blocked. This feature prevent spam tracking
########################################################################
$block_external_images = no;

########################################################################
# Order setting
########################################################################

$default_sortby = "date";
$default_sortorder = "DESC";

########################################################################
# Default preferences...
########################################################################

$default_preferences = Array(
	"send_to_trash_default" 	=> yes,		# send deleted messages to trash
	"save_to_sent_default"		=> yes,		# send sent messages to sent
	"empty_trash_default"		=> yes,		# empty trash on logout
	"rpp_default"				=> 20,		# records per page (messages), alowed: 10,20,30,40,50,100,200
	"display_images_deafult"	=> yes,		# automatically show attached images in the body of message
	"editor_mode_default"		=> "html",	# use "html" or "text" to set default editor. "html" will be used only in IE5+ browsers
	);
?>