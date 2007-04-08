<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

@set_time_limit(0);

require("./inc/config.php");

if (strpos(strtolower($HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"]),'gzip') !== false 
	&& $html_compress != "false"){
	@ob_start("ob_gzhandler"); 
}

require("./inc/lib.php");
define("SMARTY_DIR","./smarty/");
require_once(SMARTY_DIR."Smarty.class.php");

$smarty = new Smarty;
$smarty->security=true;
$smarty->secure_dir=array("./");
$smarty->compile_dir = $temporary_directory;
$smarty->assign("umLanguageFile",$selected_language.".txt");

srand((double)microtime()*1000000);
$retid = rand();

$jssource = "
<script language=javascript>
	function selectLanguage() {
		sSix		= '';
		sUser		= '';
		sEmail		= '';
		sLanguage	= '';
		sTheme		= '';
		
		frm = document.forms[0];
		if(frm.six && frm.six.options)
			sSix = frm.six.options[frm.six.selectedIndex].value;
		if(frm.f_user)
			sUser = frm.f_user.value;
		if(frm.tem)
			sTheme = frm.tem.options[frm.tem.selectedIndex].value;
		if(frm.lng)
			sLanguage = frm.lng.options[frm.lng.selectedIndex].value;

		sLocation = 'index.php?lid='+sLanguage+'&tid='+sTheme+'retid=$retid&f_user='+escape(sUser)+'&six='+sSix;
		location.replace(sLocation);
	}
</script>
";
//$smarty->debugging = true;

load_initconfig();
$mail_servers = load_alldomain();

$aval_servers = count($mail_servers);
$smarty->assign("umAvailableServers",$aval_servers);
		
if(!$aval_servers) die("You must set at least one domain, please review setup your mail server");

$iPos = strpos($HTTP_SERVER_VARS["HTTP_HOST"], ':');
if ($iPos !== false)
	$strVisitHost = substr($HTTP_SERVER_VARS["HTTP_HOST"], 0, $iPos);
else
	$strVisitHost = $HTTP_SERVER_VARS["HTTP_HOST"];

$directly_visit = false;
for($i = 0; $i < $aval_servers; $i++) {
	$strUrl = $mail_servers[$i]["directlyvisiturl"];
	if (strtolower(substr($strUrl, 0, 7)) == "http://")
		$strUrl = substr($strUrl, 7);
		
	if (strtolower(substr($strUrl, 0, 8)) == "https://")
		$strUrl = substr($strUrl, 8);
		
	$iPos = strpos($strUrl, '/');
	if ($iPos !== false)
		$strUrl = substr($strUrl, 0, $iPos);

	$iPos = strpos($strUrl, ':');
	if ($iPos !== false)
		$strUrl = substr($strUrl, 0, $iPos);

	if($strUrl != '' && ($strUrl == $strVisitHost || $strUrl == $HTTP_SERVER_VARS["QUERY_STRING"])){
		$allow_register = $mail_servers[$i]["allowregister"];
		$strServers = "@".$mail_servers[$i]["domain"]." <input type=hidden name=six value=$i>";
		$directly_visit = true;
		break;
	}
}

if (!isset($six) && !empty($f_domain)){
	$six = -1;
	for ($i = count($mail_servers)-1; $i >= 0; $i--){
		if (strtolower($mail_servers[$i]["domain"]) == strtolower($f_domain)){
			$six = $i;
			break;
		}
	}
}	

if ($directly_visit === false){
	if ($aval_servers == 1) {
		$allow_register = $mail_servers[0]["allowregister"];
		$strServers = "@".$mail_servers[0]["domain"]." <input type=hidden name=six value=0>";
	} else {
		$strServers = "@<select name=six>\r";
		
		for($i = 0; $i < $aval_servers; $i++) {
			$sel = ($i == $six)?" selected":"";
			$strServers .= "<option value=$i$sel>".$mail_servers[$i]["domain"]."\r";
		}
		$strServers .= "</select>\r";
	}
}

setcookie('magicwinmail_domain_name', $mail_servers[$six]["domain"], time()+2592000);

$smarty->assign("umServer",$strServers);
$smarty->assign("umRegister",$allow_register);
$smarty->assign("umUser",$f_user);
$smarty->assign("umPass",$f_pass);
$smarty->assign("umJS",$jssource);
$smarty->assign("umRetID",$retid);
$smarty->assign("umWebmasterEmail", $postmaster_address);

$avallangs = count($languages);
if($avallangs == 0) die("You must provide at least one language");

$avalthemes = count($themes);
if($avalthemes == 0) die("You must provide at least one theme");

$smarty->assign("umAllowSelectLanguage",$allow_user_change_language); 

if($allow_user_change_language) {
	$def_lng = (is_numeric($lid))?$lid:$default_language;
	$langsel = "<select name=lng onChange=selectLanguage()>\r";
	for($i=0;$i<$avallangs;$i++) {
		$selected = ($lid == $i)?" selected":"";
		$langsel .= "<option value=$i$selected>".$languages[$i]["name"]."</option>\r";
	}
	$langsel .= "</select>\r";
	$smarty->assign("umLanguages",$langsel);
}

$smarty->assign("umAllowSelectTheme",$allow_user_change_theme);

if($allow_user_change_theme) {
	$def_tem = (is_numeric($tid))?$tid:$default_theme;
	$themsel = "<select name=tem onChange=selectLanguage()>\r";
	for($i=0;$i<$avalthemes;$i++) {
		$selected = ($tid == $i)?" selected":"";
		$themsel .= "<option value=$i$selected>".$themes[$i]["name"]."</option>\r";
	}
	$themsel .= "</select>\r";
	$smarty->assign("umThemes",$themsel);
}


$smarty->display("$selected_theme/login.htm");
