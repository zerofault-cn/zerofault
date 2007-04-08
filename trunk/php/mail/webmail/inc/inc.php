<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
S鉶 Paulo - Brasil
*************************************************************************/

@set_time_limit(0);

require("./inc/config.php");

if (strpos(strtolower($HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"]),'gzip') !== false 
	&& $html_compress != "false"){
	@ob_start("ob_gzhandler"); 
}

require("./inc/class.uebimiau.php");
require("./inc/lib.php");

//产生随机数
srand((double)microtime()*1000000);
$retid = rand();

if(empty($sid)) 
	$sid = strtoupper("{".uniqid("")."-".uniqid("")."-".time()."}");

define("SMARTY_DIR","./smarty/");
require_once(SMARTY_DIR."Smarty.class.php");
$smarty = new Smarty;
$smarty->compile_dir = $temporary_directory;
$smarty->security = true;
$smarty->secure_dir=array("./");

//$smarty->debugging = false;
$smarty->assign("umLanguageFile",$selected_language.".txt");

$SS = New Session();
$SS->temp_folder = $temporary_directory;
$SS->sid = $sid;

$sess = $SS->Load();

$start = ($sess["start"] == "") ? time() : $sess["start"];

load_initconfig();

$UM = new UebiMiau();

if(strlen($f_pass) > 0) {
	$mail_servers = load_alldomain();

	if (!isset($six) && !empty($f_domain)){
		$six = -1;
		
		for ($i = count($mail_servers)-1; $i >= 0; $i--){
			if (strtolower($mail_servers[$i]["domain"]) == strtolower($f_domain)){
				$six = $i;
				break;
			}
		}
		
		if ($six == -1){
			Header("Location: index.php?tid=$tid&lid=$lid&retid=$retid\r\n"); 
			exit; 
		}
	}

	setcookie('magicwinmail_domain_name', $mail_servers[$six]["domain"], time()+2592000);
	
	$domain = $mail_servers[$six]["domain"];
	$f_user = strtolower($f_user);
	$f_email = $f_user."@".$domain;
	$f_server = $mail_servers[$six]["server"];
	$login_type = $mail_servers[$six]["login_type"];

	if($login_type != "") 
		$f_user = eregi_replace("%user%",$f_user,eregi_replace("%domain%",$domain,$login_type));

	$UM->mail_email 	= $sess["email"]  = stripslashes($f_email);
	$UM->mail_user 		= $sess["user"]   = stripslashes($f_user);
	$UM->mail_pass 		= $sess["pass"]   = stripslashes($f_pass); 
	$UM->mail_server 	= $sess["server"] = stripslashes($f_server); 

	$sess["start"] = time();

	$refr = 1;

} elseif ($sess["auth"] && intval((time() - $start)/60) < $idle_timeout) {

	$UM->mail_user   = $f_user    = $sess["user"];
	$UM->mail_pass   = $f_pass    = $sess["pass"];
	$UM->mail_server = $f_server  = $sess["server"];
	$UM->mail_email  = $f_email   = $sess["email"];

} else {
	Header("Location: index.php?tid=$tid&lid=$lid&retid=$retid\r\n"); 
	exit; 
}


$sess["start"] = time();

$SS->Save($sess);

$userfolder = $mailstore_directory.strtolower($f_user)."\\";

$UM->mail_port 			= $mail_port;
$UM->debug				= $enable_debug;
$UM->use_html			= $allow_html;
$UM->mail_protocol		= $mail_protocol;

$UM->user_folder 		= $userfolder;
$UM->temp_folder		= $temporary_directory;
$UM->timeout			= $idle_timeout;

$server_time_zone = gettimezone();
$UM->timezone			= $server_time_zone;
$UM->charset			= $default_char_set;

$nocache = "";

/*
Don't remove the fallowing lines, or you will be problems with browser's cache 
Header("Expires: Wed, 11 Nov 1998 11:11:11 GMT\r\n".
"Cache-Control: no-cache\r\n".
"Cache-Control: must-revalidate\r\n".
"Pragma: no-cache");

$nocache = "
<META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"no-cache\">
<META HTTP-EQUIV=\"Expires\" CONTENT=\"-1\">
<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">";
// Sort rules
*/

$smarty->assign("umUserEmail", $UM->mail_email);
$smarty->assign("umWebmasterEmail", $postmaster_address);
$smarty->assign("umAllowSmsCgi", $allow_smscgi);

$prefs = load_prefs();
if (empty($sortby))
	$sortby = $default_sortby;
if (empty($sortorder))
	$sortorder = $default_sortorder;

if($folder == "" || strpos($folder,"..") !== false ) 
	$folder = "INBOX";
else if (!file_exists($userfolder.$folder)) { 
	Header("Location: logout.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid"); 
	exit; 
}

$memujssource = "
<script language=\"JavaScript\">
function goinbox() { location = 'msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=INBOX'; }
function newmsg() { location = 'newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&pag=$pag&folder=".urlencode($folder)."'; }
function folderlist() { location = 'folders.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."'}
function search() { location = 'search.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function addresses() { location = 'addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function signatures() { location = 'signature.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function prefs() { location = 'preferences.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function autoforward() { location = 'autoforward.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function autoreply() { location = 'autoreply.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function externalpop3() { location = 'externalpop3.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function chgpassword() { location = 'chgpassword.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function goend() { location = 'logout.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function netaddress() { location = 'netaddressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function userinfo() { location = 'userinfo.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function group() { location = 'group.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
function smscgi() { location = 'smscgi.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid'; }
</script>
";



?>
