<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
S鉶 Paulo - Brasil
*************************************************************************/
require("./inc/class.xmldb.php");
require_once("./inc/ldap_utf8.php");

$phpver = phpversion();
$phpver = doubleval($phpver[0].".".$phpver[2]);

if($phpver >= 4.1) {
	extract($_POST,EXTR_SKIP);
	extract($_GET,EXTR_SKIP);
	extract($_FILES);
}

$strLanguage = strtolower($HTTP_SERVER_VARS["HTTP_ACCEPT_LANGUAGE"]);
if( strchr($strLanguage, 'en') != false )
   	$browserlang = 'en';
else if( strchr($strLanguage, 'zh-cn') != false )
   	$browserlang = 'ch_gb';
else if( strchr($strLanguage, 'zh-tw') != false )
   	$browserlang = 'ch_big5';
   	
for ($i = 0; $i < count($languages); $i++){
	if (strtolower($browserlang) == strtolower($languages[$i]["path"])){
		$default_language = $i; 
		break;
	}
}

if (strlen($f_lang) > 0){
	for ($i = 0; $i < count($languages); $i++){
		if (strtolower($f_lang) == strtolower($languages[$i]["path"])){
			$lng = $i; 
			break;
		}
	}
}

if (strlen($f_theme) > 0){
	for ($i = 0; $i < count($themes); $i++){
		if (strtolower($f_theme) == strtolower($themes[$i]["path"])){
			$tem = $i; 
			break;
		}
	}
}

if(strlen($f_pass) > 0) {
	if($allow_user_change_theme) {
		if(is_numeric($tem)) 
			$tid = $tem;
		else 
			$tid = $default_theme;
	} 
	else
		$tid = $default_theme;

	if($allow_user_change_language) {
		if(is_numeric($lng)) 
			$lid = $lng;
		else 
		 	$lid = $default_language;
	} 
	else
		$lid = $default_language;
}

//set cookie
global $HTTP_COOKIE_VARS;
if (!is_numeric($lid)){
	$langname = $HTTP_COOKIE_VARS['magicwinmail_default_language'];

	for ($i = 0; $i < count($languages); $i++){
		if (strtolower($langname) == strtolower($languages[$i]["path"])){
			$lid = $i; 
			break;
		}
	}
}
else {
	setcookie('magicwinmail_default_language', $languages[$lid]["path"], time()+2592000);
}

if (!is_numeric($tid)) {
	$thename = $HTTP_COOKIE_VARS['magicwinmail_default_theme'];

	for ($i = 0; $i < count($themes); $i++){
		if (strtolower($thename) == strtolower($themes[$i]["path"])){
			$tid = $i; 
			break;
		}
	}
}
else {
	setcookie('magicwinmail_default_theme', $themes[$tid]["path"], time()+2592000);
}

if (empty($f_domain) && !is_numeric($six)){
	$f_domain = $HTTP_COOKIE_VARS['magicwinmail_domain_name'];
}

if(!is_numeric($tid) || $tid >= count($themes)) $tid = $default_theme;
if(!is_numeric($lid) || $lid >= count($languages)) $lid = $default_language;

$selected_theme 	= $themes[$tid]["path"];
if (!$selected_theme) die("<br><br><br><div align=center><h3>Invalid theme, configure your \$default_theme</h3></div>");
$selected_language 	= $languages[$lid]["path"];
if (!$selected_language) die("<br><br><br><div align=center><h3>Invalid language, configure your \$default_language</h3></div>");

/*function simpleoutput($p1) { printf($p1); }
$func = strrev("tuptuoelpmis");
*/

function get_usage_graphic($used,$aval) {
	if($used >= $aval) {
		$redsize = 100;
		$graph = "<img src=images/red.gif height=10 width=$redsize>";
	} elseif($used == 0) {
		$greesize = 100;
		$graph = "<img src=images/green.gif height=10 width=$greesize>";
	} else  {
		$usedperc = $used*100/$aval;
		$redsize = ceil($usedperc);
		$greesize = ceil(100-$redsize);
		$red = "<img src=images/red.gif height=10 width=$redsize>";
		$green = "<img src=images/green.gif height=10 width=$greesize>";
		$graph = $red.$green;
	}
	return $graph;
}

// sort an multidimension array
function array_qsort2 (&$array, $column=0, $order="ASC", $first=0, $last= -2) { 
	if($last == -2) $last = count($array) - 1; 
	if($last > $first) { 
		$alpha = $first; 
		$omega = $last; 
		$guess = $array[$alpha][$column]; 
		while($omega >= $alpha) { 
			if($order == "ASC") { 
				while(strtolower($array[$alpha][$column]) < strtolower($guess)) $alpha++; 
				while(strtolower($array[$omega][$column]) > strtolower($guess)) $omega--; 
			} else {
				while(strtolower($array[$alpha][$column]) > strtolower($guess)) $alpha++; 
				while(strtolower($array[$omega][$column]) < strtolower($guess)) $omega--; 
			} 
			if(strtolower($alpha) > strtolower($omega)) break; 
			$temporary = $array[$alpha]; 
			$array[$alpha++] = $array[$omega]; 
			$array[$omega--] = $temporary; 
		} 
		array_qsort2 ($array, $column, $order, $first, $omega); 
		array_qsort2 ($array, $column, $order, $alpha, $last); 
	} 
} 

function gettimezone()
{
	$tmgmnow = gmmktime(0,0,0,1,1,2000);
	$tmnow = mktime(0,0,0,1,1,2000);
	
	$diff = $tmgmnow-$tmnow;
	if ($diff >= 0 )
		$flag = '+';
	else
		$flag = '-';
	
	$diff = abs($diff);
	$hh = intval($diff/3600);
	$mm = intval(($diff-($hh*3600))/60);
	
	return sprintf("%s%02d%02d", $flag, $hh, $mm);
}

class Session {

	var $temp_folder;
	var $sid;

	function Load() {
		$sessionfile = $this->temp_folder."_sessions/".$this->sid.".usf";
		$result      = Array();
		if(file_exists($sessionfile)) {
			clearstatcache();
			$fp = fopen($sessionfile,"rb");
			$result = fread($fp,filesize($sessionfile));
			fclose($fp);
			$result = unserialize(base64_decode($result));
		}
		return $result;
	}

	function Save(&$array2save) {
		$content = base64_encode(serialize($array2save));
		if(!is_writable($this->temp_folder)) die("<h3>The folder \"".$this->temp_folder."\" is not writtable or does not exist!!!</h3>");
		$sessiondir = $this->temp_folder."_sessions/";
		if(!file_exists($sessiondir)) mkdir($sessiondir,0777);
		$f = fopen("$sessiondir".$this->sid.".usf","wb") or die("<h3>Could not open session file</h3>");
		fwrite($f,$content);
		fclose($f);
		return 1;
	}
	function Kill() {
		$sessionfile = $this->temp_folder."_sessions/".$this->sid.".usf";
		return @unlink($sessionfile);
	}
}


function load_alldomain(){
	global $domain_config_file;
	global $xml_database_comname;
	global $pop3_server;
	global $allow_register;
	
	$filename = $domain_config_file;

	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($filename);
	$xml->ResetPos();
	
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("domain") || ($xml->GetTagName() == "domain")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				unset($domain);
				
				$domain["domain"] = "localhost";
				$domain["server"] = $pop3_server;
				$domain["login_type"] = "%user%@%domain%";
				 
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case "domain":
							$domain["domain"] = $strTagValue;
							break;
						case "type":
							if ($strTagValue == 1)
								$domain["login_type"] = "%user%";
							else
								$domain["login_type"] = "%user%@%domain%";
							break;
						case "allowregister":
							if ($strTagValue == 1)
								$allow_register = 1;
						default:
							$domain[strtolower($strTagName)] = $strTagValue;
							break;
					}
					
				}while($xml->FindChildElem(""));
				
				$servers[] = $domain;
			}
		}while($xml->FindElem(""));
	}
	
	return $servers;
}

//load init config
function load_initconfig(){
	global $system_config_file;
	global $xml_database_comname;
	
	global $pop3_server;
	global $smtp_server;
	global $ldap_server;
	
	global $pop3_port;
	global $smtp_port;
	global $ldap_port;
	global $mail_port;
	
	global $mailstore_directory;
	global $postmaster_address;
	global $congratulate_subject;
	global $congratulate_content;
	global $register_user_total;
	
	global $ldap_base_dn;
	global $ldap_root_dn;
	global $ldap_root_pwd;
	
	$filename = $system_config_file;

	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($filename);
	$xml->ResetPos();

	
	$bRet = $xml->FindElem("database");

	if ($bRet){
		$xml->ResetPos();
		if ($xml->GetChildTagName() == "service" || $xml->FindChildElem("service")){
			$xml->IntoElem();
			$xml->IntoElem();

			$xml->ResetChildPos();
			do{
				$strTagName = $xml->GetTagName();
				
				if ($strTagName == "smtp"){
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "bindip" || $xml->FindChildElem("bindip")){
						$bindip = trim($xml->GetChildData());
						if (!empty($bindip) && $bindip != "0.0.0.0")
							$smtp_server = $bindip;
					}
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "port" || $xml->FindChildElem("port")){
						$port = trim($xml->GetChildData());
						if (!empty($port))
							$smtp_port = $port;
					}
				}
	
				if ($strTagName == "pop3"){
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "bindip" || $xml->FindChildElem("bindip")){
						$bindip = trim($xml->GetChildData());
						if (!empty($bindip) && $bindip != "0.0.0.0")
							$pop3_server = $bindip;
					}
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "port" || $xml->FindChildElem("port")){
						$port = trim($xml->GetChildData());
						if (!empty($port))
							$pop3_port = $port;
					}
				}
				
				//ldap begin				
				if($strTagName == "ldap")
				{
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "bindip" || $xml->FindChildElem("bindip")){
						$bindip = trim($xml->GetChildData());
						if (!empty($bindip) && $bindip != "0.0.0.0")
							$ldap_server = $bindip;
					}
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "port" || $xml->FindChildElem("port")){
						$port = trim($xml->GetChildData());
						if (!empty($port))
							$ldap_port = $port;
					}
				}
				//ldap end
				
			}while($xml->FindElem(""));
		}
		
		if (strtolower($mail_protocol) == 'pop3')
			$mail_port = $pop3_port;
		
		$xml->ResetPos();
		if ($xml->GetChildTagName() == "advanced" || $xml->FindChildElem("advanced")){
			$xml->IntoElem();
			$xml->IntoElem();
			
			$xml->ResetChildPos();
			do{
				$strTagName = $xml->GetTagName();
				
				if ($strTagName == "directory" ){
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "mailstore" || $xml->FindChildElem("mailstore")){
						$mailstore = trim($xml->GetChildData());
						if (!empty($mailstore)){
							$mailstore_directory = $mailstore;
							if (substr($mailstore, -1) != '\\')
								$mailstore_directory .= '\\';
						}
					}
				}
				
				if ($strTagName == "mailtemplate" ){
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "congratulatesubject" || $xml->FindChildElem("congratulatesubject")){
						$subject = trim($xml->GetChildData());
						if (!empty($subject)){
							if (strtoupper(substr($subject, 0, 8)) == '{BASE64}') 
								$congratulate_subject = base64_decode(substr($subject, 8));
							else
								$congratulate_subject = $subject;
						}
					}
					
					$xml->ResetChildPos();
					if ($xml->GetChildTagName() == "congratulatecontent" || $xml->FindChildElem("congratulatecontent")){
						$content = trim($xml->GetChildData());
						if (!empty($content)){
							if (strtoupper(substr($content, 0, 8)) == '{BASE64}') 
								$congratulate_content = base64_decode(substr($content, 8));
							else
								$congratulate_content = $content;
						}
					}
				}
			}while($xml->FindElem(""));
		}
		
		$xml->ResetPos();
		if ($xml->GetChildTagName() == "smtpoption" || $xml->FindChildElem("smtpoption")){
			$xml->IntoElem();
			
			$xml->ResetChildPos();
			if ($xml->GetChildTagName() == "option" || $xml->FindChildElem("option")){
				$xml->IntoElem();
				if ($xml->GetChildTagName() == "bouncemailaddress" 
					|| $xml->FindChildElem("bouncemailaddress")){
					$address = trim($xml->GetChildData());
					if (!empty($address)){
						$postmaster_address = $address;
					}
				}
			}
		}

		$xml->ResetPos();
		if ($xml->GetChildTagName() == "license" || $xml->FindChildElem("license")){
			$xml->IntoElem();
			
			$xml->ResetChildPos();
			if ($xml->GetChildTagName() == "regusertotal" || $xml->FindChildElem("regusertotal")){
				$total = trim($xml->GetChildData());
				if (!empty($total)){
					$register_user_total = $total;
				}
			}
		}
		
		$xml->ResetPos();
		if ($xml->GetChildTagName() == "ldapinfo" || $xml->FindChildElem("ldapinfo")){
			$xml->IntoElem();
			
			$xml->ResetChildPos();
			do{
				$strTagName = trim($xml->GetChildTagName());
				$strTagValue = trim($xml->GetChildData());

				if ($strTagName == "basedn")
					$ldap_base_dn = $strTagValue;
				else if ($strTagName == "rootdn")
					$ldap_root_dn = $strTagValue;
				else if ($strTagName == "rootpwd")
					$ldap_root_pwd = $strTagValue;
			}while($xml->FindChildElem(""));
		}
	}
}

// load preferences
function load_prefs() {
	global 	$userfolder;
	global	$default_preferences;
	global	$userinfo_config_file;
	global 	$xml_database_comname;
	
	$pref_file = $userfolder.$userinfo_config_file;
	
	extract($default_preferences);

	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($pref_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$bRet = $xml->FindChildElem("preference") || ($xml->GetChildTagName() == "preference");
	
	if ($bRet)
	{
		$xml->IntoElem();
		$xml->ResetChildPos();	
		do {
			$strTagName = $xml->GetChildTagName();
			$strTagValue = $xml->GetChildData();
			
			switch(strtolower($strTagName)){
				case "realname":
					$prefs["real-name"] = $strTagValue;
					break;
				case "replyto":
					$prefs["reply-to"] = $strTagValue;
					break;
				case "savetotrash":
					$prefs["save-to-trash"] = $strTagValue;
					break;
				case "emptytrash":
					$prefs["empty-trash"] = $strTagValue;
					break;
				case "savetosent":
					$prefs["save-to-sent"] = $strTagValue;
					break;
				case "recodeperpage":
					$prefs["rpp"] = $strTagValue;
					break;
				case "displayimages":
					$prefs["display-images"] = $strTagValue;
					break;
				case "editormode":
					$prefs["editor-mode"] = $strTagValue;
					break;
				case "firstlogin":
					$prefs["first-login"] = $strTagValue;
					break;
			}
		}while($xml->FindChildElem(""));
	} else{
		$prefs["real-name"]     = UCFirst(substr($sess["email"],0,strpos($sess["email"],"@")));
		$prefs["reply-to"]      = $sess["email"];
		$prefs["save-to-trash"] = $send_to_trash_default;
		$prefs["empty-trash"]   = $empty_trash_default;
		$prefs["save-to-sent"]  = $save_to_sent_default;
		$prefs["rpp"]           = $rpp_default;
		$prefs["display-images"]= $display_images_deafult;
		$prefs["editor-mode"]	= $editor_mode_default;
	}

	return $prefs;
}

//save preferences
function save_prefs($prefarray) {
	global $userfolder, $userinfo_config_file;
	global 	$xml_database_comname;
	
	$pref_file = $userfolder.$userinfo_config_file;

	$strContent = '<preference>'."\r\n";
	$strContent .= '<realname>'.htmlspecialchars($prefarray['real-name']).'</realname>'."\r\n";
	$strContent .= '<replyto>'.htmlspecialchars($prefarray['reply-to']).'</replyto>'."\r\n";
	$strContent .= '<savetotrash>'.$prefarray['save-to-trash'].'</savetotrash>'."\r\n";
	$strContent .= '<emptytrash>'.$prefarray['empty-trash'].'</emptytrash>'."\r\n";
	$strContent .= '<recodeperpage>'.$prefarray['rpp'].'</recodeperpage>'."\r\n";
	$strContent .= '<savetosent>'.$prefarray['save-to-sent'].'</savetosent>'."\r\n";
	$strContent .= '<displayimages>'.$prefarray['display-images'].'</displayimages>'."\r\n";
	$strContent .= '<editormode>'.$prefarray['editor-mode'].'</editormode>'."\r\n";
	$strContent .= '<firstlogin>'.$prefarray['first-login'].'</firstlogin>'."\r\n";
	$strContent .= '</preference>'."\r\n";

	if (!file_exists($pref_file)){
		$strTemp = $strContent;
		
		$strContent = '<database>'."\r\n";
		$strContent .= $strTemp;
		$strContent .= '</database>'."\r\n";
		
		save_file($pref_file, $strContent);
	} else {
		$xml = new COM($xml_database_comname) or die ("create com instance error");
		$xml->ReadDB($pref_file);
		$xml->ResetPos();
			
		if ($xml->FindElem("database")){
			if ($xml->FindChildElem("preference") || $xml->GetChildTagName() == "preference") {
				$xml->IntoElem();
				$xml->ResetChildPos();	
		
				do {
					$strTagName = $xml->GetChildTagName();
					
					switch(strtolower($strTagName)){
						case "realname":
							$xml->SetChildData($prefarray["real-name"]);
							break;
						case "replyto":
							$xml->SetChildData($prefarray["reply-to"]);
							break;
						case "savetotrash":
							$xml->SetChildData($prefarray["save-to-trash"]);
							break;
						case "emptytrash":
							$xml->SetChildData($prefarray["empty-trash"]);
							break;
						case "savetosent":
							$xml->SetChildData($prefarray["save-to-sent"]);
							break;
						case "recodeperpage":
							$xml->SetChildData($prefarray["rpp"]);
							break;
						case "displayimages":
							$xml->SetChildData($prefarray["display-images"]);
							break;
						case "editormode":
							$xml->SetChildData($prefarray["editor-mode"]);
							break;
						case "firstlogin":
							$xml->SetChildData($prefarray["first-login"]);
							break;
					}
				}while($xml->FindChildElem(""));
			}
			else
			{
				$xml->AddChildSubDoc($strContent);
			}
	
			$xml->WriteDB($pref_file);
		}else{
			$strTemp = $strContent;
			$strContent = '<database>'."\r\n";
			$strContent .= $strTemp;
			$strContent .= '</database>'."\r\n";
			
			save_file($pref_file, $strContent);
		}
	}
}

//load address book
function load_addressbook(){
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	if (!file_exists($pref_file)) 
		return;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($pref_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	$bRet = $xml->FindElem("addressbook") || ($xml->GetTagName() == "addressbook");
	if ($bRet){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				unset($address);
				
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					$address[strtolower($strTagName)] = $strTagValue;
				}while($xml->FindChildElem(""));
				
				$addresslist[] = $address;
			}
		}while($xml->FindElem(""));
	}
	return $addresslist;
}

//save address book
function save_addressbook($addresslist)
{
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	$strContent = "";
	$nCount = count($addresslist);
	if ($nCount != 0) {
		$strContent = "<addressbook>\r\n";
		for ($id = 0; $id < $nCount; $id++){
			$strContent .= "<item>\r\n";
			$strContent .= "<name>".htmlspecialchars($addresslist[$id]["name"])."</name>\r\n";
			$strContent .= "<email>".htmlspecialchars($addresslist[$id]["email"])."</email>\r\n";
			$strContent .= "<phone>".htmlspecialchars($addresslist[$id]["phone"])."</phone>\r\n";
			$strContent .= "<address>".htmlspecialchars($addresslist[$id]["address"])."</address>\r\n";
			$strContent .= "<work>".htmlspecialchars($addresslist[$id]["work"])."</work>\r\n";
			$strContent .= "</item>\r\n";
		}
		$strContent .= "</addressbook>\r\n";
	}
	
	if (!file_exists($pref_file)) {
		$strTempContent = "<database>\r\n";
		$strTempContent .= $strContent;
		$strTempContent .= "</database>\r\n";

		$strContent = $strTempContent;

		save_file($pref_file, $strContent);
	}else {
		$xml = new COM($xml_database_comname) or die ("create com instance error");
		$xml->ReadDB($pref_file);
		$xml->ResetPos();
		
		if ($xml->FindElem("database")){
			if ($xml->FindChildElem("addressbook") || $xml->GetChildTagName() == "addressbook"){
				$xml->RemoveChildElem();
			}
			$xml->AddChildSubDoc($strContent);
		
			$xml->WriteDB($pref_file);
		}else {
			$strTempContent = "<database>\r\n";
			$strTempContent .= $strContent;
			$strTempContent .= "</database>\r\n";
	
			$strContent = $strTempContent;
			
			save_file($pref_file, $strContent);
		}
	}
}

//load signature
function load_signature(){
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	if (!file_exists($pref_file)) 
		return;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($pref_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	$bRet = $xml->FindElem("signature") || ($xml->GetTagName() == "signature");
	$xml->IntoElem();

	do {
		if ($xml->GetTagName() == "item") {
			unset($signature);
	
			$xml->ResetChildPos();	
			do {
				$strTagName = $xml->GetChildTagName();
				$strTagValue = $xml->GetChildData();
				
				$signature[strtolower($strTagName)] = $strTagValue;
			}while($xml->FindChildElem(""));
			
			$signaturelist[] = $signature;
		}
	}while($xml->FindElem(""));

	return $signaturelist;
}

//save signature
function save_signature($signaturelist)
{
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	$strContent = "";
	$nCount = count($signaturelist);
	if ($nCount != 0) {
		$strContent = "<signature>\r\n";
		for ($id = 0; $id < $nCount; $id++){
			$strContent .= "<item>\r\n";
			$strContent .= "<name>".htmlspecialchars($signaturelist[$id]["name"])."</name>\r\n";
			$strContent .= "<content>".htmlspecialchars($signaturelist[$id]["content"])."</content>\r\n";
			$strContent .= "</item>\r\n";
		}
		$strContent .= "</signature>\r\n";
	}
	
	if (!file_exists($pref_file)) {
		$strTempContent = "<database>\r\n";
		$strTempContent .= $strContent;
		$strTempContent .= "</database>\r\n";

		$strContent = $strTempContent;
		save_file($pref_file, $strContent);
	}else {
		$xml = new COM($xml_database_comname) or die ("create com instance error");
		$xml->ReadDB($pref_file);
		$xml->ResetPos();
		
		if ($xml->FindElem("database")){
			if ($xml->FindChildElem("signature") || $xml->GetChildTagName() == "signature"){
				$xml->RemoveChildElem();
			}
			$xml->AddChildSubDoc($strContent);
		
			$xml->WriteDB($pref_file);
		}else {
			$strTempContent = "<database>\r\n";
			$strTempContent .= $strContent;
			$strTempContent .= "</database>\r\n";
	
			$strContent = $strTempContent;
			save_file($pref_file, $strContent);
		}
	}
}


//load external pop3
function load_externalpop3(){
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	if (!file_exists($pref_file)) 
		return;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($pref_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	$bRet = $xml->FindElem("pop3mail") || ($xml->GetTagName() == "pop3mail");
	if ($bRet){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				unset($externalpop3);
		
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					if (strtolower($strTagName) == 'password')
					{
						$iTagLen = strlen('{BASE64}');
						$strTmpTag = substr($strTagValue, 0, $iTagLen);
						if (strtoupper($strTmpTag) == '{BASE64}')
						{
							$strTemp = substr($strTagValue, $iTagLen);
							$externalpop3['password'] = base64_decode($strTemp);
						}
						else
						{
							$externalpop3['password'] = $strTagValue;
						}
					}
					else
					{
						$externalpop3[strtolower($strTagName)] = $strTagValue;
					}
				}while($xml->FindChildElem(""));
				
				$externalpop3list[] = $externalpop3;
			}
		}while($xml->FindElem(""));
	}
	
	return $externalpop3list;
}

//save external pop3
function save_externalpop3($externalpop3list)
{
	global 	$userfolder;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$pref_file = $userfolder.$userinfo_config_file;

	$strContent = "";
	$nCount = count($externalpop3list);
	if ($nCount != 0) {
		$strContent = "<pop3mail>\r\n";
		for ($id = 0; $id < $nCount; $id++){
			$strContent .= "<item>\r\n";
			$strContent .= "<username>".htmlspecialchars($externalpop3list[$id]["username"])."</username>\r\n";
			$strContent .= "<password>{BASE64}".base64_encode($externalpop3list[$id]["password"])."</password>\r\n";
			$strContent .= "<host>".htmlspecialchars($externalpop3list[$id]["host"])."</host>\r\n";
			$strContent .= "<port>".$externalpop3list[$id]["port"]."</port>\r\n";
			$strContent .= "<enable>".$externalpop3list[$id]["enable"]."</enable>\r\n";
			$strContent .= "<savecopy>".$externalpop3list[$id]["savecopy"]."</savecopy>\r\n";
			$strContent .= "</item>\r\n";
		}
		$strContent .= "</pop3mail>\r\n";
	}

	if (!file_exists($pref_file)) {
		$strTempContent = "<database>\r\n";
		$strTempContent .= $strContent;
		$strTempContent .= "</database>\r\n";

		$strContent = $strTempContent;

		save_file($pref_file, $strContent);
	}else {
		$xml = new COM($xml_database_comname) or die ("create com instance error");
		$xml->ReadDB($pref_file);
		$xml->ResetPos();
		
		if ($xml->FindElem("database")){
			if ($xml->FindChildElem("pop3mail") || $xml->GetChildTagName() == "pop3mail"){
				$xml->RemoveChildElem();
			}
			$xml->AddChildSubDoc($strContent);
		
			$xml->WriteDB($pref_file);
		}else {
			$strTempContent = "<database>\r\n";
			$strTempContent .= $strContent;
			$strTempContent .= "</database>\r\n";
	
			$strContent = $strTempContent;
			
			save_file($pref_file, $strContent);
		}
	}
}

// load quotalimit
function load_quotalimit() {
	global 	$sess;
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;
	
	if (!file_exists($user_conf_file)) 
		return 0;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
		
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xml->ResetChildPos();	
					
					if ($xml->FindChildElem("mailquota")){
						return $xml->GetChildData()/1024;
						
						break;
					}
				}
			}
		}while($xml->FindElem(""));
	}

	return 0;
}

// load forward
function load_forward() {
	global 	$sess;
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;
	
	$info['forwardaddress'] = '';
	
	if (!file_exists($user_conf_file)) 
		return;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
		
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
						
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("forwardaddr")){
						$info['forwardaddress'] = $xml->GetChildData();
					}
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("savecopy")){
						$info['forwardsavecopy'] = $xml->GetChildData();
					}
					break;
				}
			}
		}while($xml->FindElem(""));
	}

	return $info;
}

//save forward
function save_forward($info) {
	global 	$sess;
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
		$xml->IntoElem();
		
		do {
			if ($xml->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
				
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
					
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("forwardaddr")) {
						$xml->SetChildData($info['forwardaddress']);
					}else {
						$xml->AddChildElem("forwardaddr", $info['forwardaddress']);
					}
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("savecopy")) {
						$xml->SetChildData($info['forwardsavecopy']);
					}else {
						$xml->AddChildElem("savecopy", $info['forwardsavecopy']);
					}
						
					$xml->WriteDB($user_conf_file);
					break;
				}
			}
		}while($xml->FindElem(""));
	}
	
	return;
}

// load autoreply
function load_autoreply() {
	global 	$userfolder, $sess;
	global	$userauth_config_file;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	$info['autoreplystatus'] = '';
	$info['autoreplycontent'] = '';
	
	if (!file_exists($user_conf_file)) 
		return;
	
	$xmlUser = new COM($xml_database_comname) or die ("create com instance error");
	$xmlUser->ReadDB($user_conf_file);
	$xmlUser->ResetPos();
		
	$bRet = $xmlUser->FindElem("database");
	$xmlUser->IntoElem();

	if ($xmlUser->FindElem("user") || ($xmlUser->GetTagName() == "user")){
		$xmlUser->IntoElem();

		do {
			if ($xmlUser->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
		
				$xmlUser->ResetChildPos();	
				do {
					$strTagName = $xmlUser->GetChildTagName();
					$strTagValue = $xmlUser->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xmlUser->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xmlUser->ResetChildPos();	
					
					if ($xmlUser->FindChildElem("autoreplystatus")){
						$info['autoreplystatus'] = $xmlUser->GetChildData();
						
						break;
					}
				}
			}
		}while($xmlUser->FindElem(""));
	}

	//load content
	$pref_file = $userfolder.$userinfo_config_file;
	if (file_exists($pref_file)) {
		$xmlPref = new COM($xml_database_comname) or die ("create com instance error");
		$xmlPref->ReadDB($pref_file);
		$xmlPref->ResetPos();
			
		$bRet = $xmlPref->FindElem("database");
		$xmlPref->IntoElem();
	
		$bRet = ($xmlPref->FindElem("autoreply")) || ($xmlPref->GetTagName() == "autoreply");
		if ($bRet) {
			$xmlPref->ResetChildPos();	
			if ($xmlPref->FindChildElem("content"))
				$info['autoreplycontent'] = $xmlPref->GetChildData();
		}
	}

	return $info;
}

//save autoreply
function save_autoreply($info) {
	global 	$userfolder, $sess;
	global	$userauth_config_file;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return;
		
	$xmlUser = new COM($xml_database_comname) or die ("create com instance error");
	$xmlUser->ReadDB($user_conf_file);
	$xmlUser->ResetPos();
		
	$bRet = $xmlUser->FindElem("database");
	$xmlUser->IntoElem();

	if ($xmlUser->FindElem("user") || ($xmlUser->GetTagName() == "user")){
		$xmlUser->IntoElem();
	
		do {
			if ($xmlUser->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";

				$xmlUser->ResetChildPos();	
				do {
					$strTagName = $xmlUser->GetChildTagName();
					$strTagValue = $xmlUser->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xmlUser->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xmlUser->ResetChildPos();	
					
					if ($xmlUser->FindChildElem("autoreplystatus")) {
						$xmlUser->SetChildData($info['autoreplystatus']);
					}
					else {
						$xmlUser->AddChildElem("autoreplystatus", $info['autoreplystatus']);
					}
					
					$xmlUser->WriteDB($user_conf_file);
					break;
				}
			}
		}while($xmlUser->FindElem(""));
	}
	
	//save content
	$pref_file = $userfolder.$userinfo_config_file;
	$strContent = "<autoreply>\r\n";
	$strContent .= "<content>";
	$strContent .= htmlspecialchars($info['autoreplycontent']);
	$strContent .= "</content>\r\n";
	$strContent .= "</autoreply>\r\n";
	
	if (!file_exists($pref_file)) {
		$strTempContent = "<database>\r\n";
		$strTempContent .= $strContent;
		$strTempContent .= "</database>\r\n";

		$strContent = $strTempContent;
		save_file($pref_file, $strContent);
	}else {
		$xmlPref = new COM($xml_database_comname) or die ("create com instance error");
		$xmlPref->ReadDB($pref_file);
		
		$xmlPref->ResetPos();
		if ($xmlPref->FindElem("database")){
			$xmlPref->ResetChildPos();
			if ($xmlPref->FindChildElem("autoreply") || $xmlPref->GetChildTagName()=="autoreply"){
				$xmlPref->RemoveChildElem();
			}
			
			$xmlPref->AddChildSubDoc($strContent);
			$xmlPref->WriteDB($pref_file);
		}else {
			$strTempContent = "<database>\r\n";
			$strTempContent .= $strContent;
			$strTempContent .= "</database>\r\n";
	
			$strContent = $strTempContent;
			save_file($pref_file, $strContent);
		}
	}
	
	return;
}

// load smscgi
function load_smscgi() {
	global 	$userfolder, $sess;
	global	$userauth_config_file;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	$info['mailnotifystatus'] = '';
	
	if (!file_exists($user_conf_file)) 
		return;
	
	$xmlUser = new COM($xml_database_comname) or die ("create com instance error");
	$xmlUser->ReadDB($user_conf_file);
	$xmlUser->ResetPos();
		
	$bRet = $xmlUser->FindElem("database");
	$xmlUser->IntoElem();

	if ($xmlUser->FindElem("user") || ($xmlUser->GetTagName() == "user")){
		$xmlUser->IntoElem();

		do {
			if ($xmlUser->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
		
				$xmlUser->ResetChildPos();	
				do {
					$strTagName = $xmlUser->GetChildTagName();
					$strTagValue = $xmlUser->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xmlUser->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xmlUser->ResetChildPos();	
					
					if ($xmlUser->FindChildElem("mailnotifystatus")){
						$info['mailnotifystatus'] = $xmlUser->GetChildData();
						
						break;
					}
				}
			}
		}while($xmlUser->FindElem(""));
	}

	//load smscgi
	$pref_file = $userfolder.$userinfo_config_file;
	if (file_exists($pref_file)) {
		$xmlPref = new COM($xml_database_comname) or die ("create com instance error");
		$xmlPref->ReadDB($pref_file);
		$xmlPref->ResetPos();
			
		$bRet = $xmlPref->FindElem("database");
		$xmlPref->IntoElem();
	
		$bRet = ($xmlPref->FindElem("smscgi")) || ($xmlPref->GetTagName() == "smscgi");
		if ($bRet) {
			$xmlPref->ResetChildPos();	
			do {
				$strTagName = $xmlPref->GetChildTagName();
				$strTagValue = $xmlPref->GetChildData();

				if (strtolower($strTagName) == 'pass')
				{
					$iTagLen = strlen('{BASE64}');
					$strTmpTag = substr($strTagValue, 0, $iTagLen);
					if (strtoupper($strTmpTag) == '{BASE64}')
					{
						$strTemp = substr($strTagValue, $iTagLen);
						$info['pass'] = base64_decode($strTemp);
					}
					else
					{
						$info['pass'] = $strTagValue;
					}
				}
				else
				{
					$info[strtolower($strTagName)] = $strTagValue;
				}
			}while($xmlPref->FindChildElem(""));
		}
	}

	return $info;
}

//save sms cgi
function save_smscgi($info) {
	global 	$userfolder, $sess;
	global	$userauth_config_file;
	global	$userinfo_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return;
		
	$xmlUser = new COM($xml_database_comname) or die ("create com instance error");
	$xmlUser->ReadDB($user_conf_file);
	$xmlUser->ResetPos();
		
	$bRet = $xmlUser->FindElem("database");
	$xmlUser->IntoElem();

	if ($xmlUser->FindElem("user") || ($xmlUser->GetTagName() == "user")){
		$xmlUser->IntoElem();
	
		do {
			if ($xmlUser->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";

				$xmlUser->ResetChildPos();	
				do {
					$strTagName = $xmlUser->GetChildTagName();
					$strTagValue = $xmlUser->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xmlUser->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xmlUser->ResetChildPos();	
					
					if ($xmlUser->FindChildElem("mailnotifystatus")) {
						$xmlUser->SetChildData($info['mailnotifystatus']);
					}
					else {
						$xmlUser->AddChildElem("mailnotifystatus", $info['mailnotifystatus']);
					}
					
					$xmlUser->WriteDB($user_conf_file);
					break;
				}
			}
		}while($xmlUser->FindElem(""));
	}
	
	//save content
	$pref_file = $userfolder.$userinfo_config_file;
	$strContent = "<smscgi>\r\n";
	$strContent .= "<isp>".$info['isp']."</isp>\r\n";
	$strContent .= "<host>".$info['host']."</host>\r\n";
	$strContent .= "<port>".$info['port']."</port>\r\n";
	$strContent .= "<length>".$info['length']."</length>\r\n";
	$strContent .= "<user>".$info['user']."</user>\r\n";
	$strContent .= "<pass>{BASE64}".base64_encode($info['pass'])."</pass>\r\n";
	$strContent .= "</smscgi>\r\n";
	
	if (!file_exists($pref_file)) {
		$strTempContent = "<database>\r\n";
		$strTempContent .= $strContent;
		$strTempContent .= "</database>\r\n";

		$strContent = $strTempContent;
		save_file($pref_file, $strContent);
	}else {
		$xmlPref = new COM($xml_database_comname) or die ("create com instance error");
		$xmlPref->ReadDB($pref_file);
		
		$xmlPref->ResetPos();
		if ($xmlPref->FindElem("database")){
			$xmlPref->ResetChildPos();
			if ($xmlPref->FindChildElem("smscgi") || $xmlPref->GetChildTagName() == "smscgi"){
				$xmlPref->RemoveChildElem();
			}
			
			$xmlPref->AddChildSubDoc($strContent);
			$xmlPref->WriteDB($pref_file);
		}else {
			$strTempContent = "<database>\r\n";
			$strTempContent .= $strContent;
			$strTempContent .= "</database>\r\n";
	
			$strContent = $strTempContent;
			save_file($pref_file, $strContent);
		}
	}
	
	return;
}

function change_password($myinfo){
	global 	$sess;
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return false;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				$strUser = "";
				$strDomain = "";
				
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;
				
				if (strtolower($strUser) == strtolower($sess['user'])) {
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("password")) {
						$strOldPassword = $xml->GetChildData();
	
						if (substr($strOldPassword, 0, 5) == '{md5}'){
							if ($strOldPassword != '{md5}'.md5($myinfo['oldpassword']))
								return false;
						}else {
							if ($strOldPassword != $myinfo['oldpassword'])
								return false;
						}
							
						if($xml->SetChildData('{md5}'.md5($myinfo['newpassword'])))
							return $xml->WriteDB($user_conf_file);
					}
				}
			}
		}while($xml->FindElem(""));
	}

	return false;
}


//get only headers from a file
function get_headers_from_file($strfile) {
	if(!file_exists($strfile)) return;
	$f = fopen($strfile,"rb");
	while(!feof($f)) {
		$result .= ereg_replace("\n","",fread($f,100));
		$pos = strpos($result,"\r\r");
		if(!($pos === false)) {
			$result = substr($result,0,$pos);
			break;
		}
	}
	fclose($f);
	unset($f); unset($pos); unset($strfile);
	return ereg_replace("\r","\r\n",trim($result));
}


function save_file($fname,$fcontent) {
	if($fname == "") return;
	
	$fp = fopen($fname,"w");
	fwrite($fp,$fcontent);
	fclose($fp);
}

function read_file($fname) {
	if($fname == "") return;
	
	$fp = fopen($fname,"r");
	$fcontent = fread($fp, filesize($fname));
	fclose($fp);

	return $fcontent;
}

//ldap begin
function convertMD5Passwd_b64($passwd)
{
	$tmp = substr($passwd, 0 , 5);
	if(strcasecmp($tmp, "{md5}") != 0)
		$passwd = md5($passwd);
	else
		$passwd = substr($passwd, 5);
		
	$tmp = "";
	for($i = 0; $i < 16; $i++)
	{
		$str = substr($passwd, 2*$i, 2);
		$k = hexdec( $str );
		$tmp .= chr($k);
	}
	
	$tmp = base64_encode($tmp);	
	$tmp = "{md5}".$tmp;
	return $tmp;
}

// ldap utf8
// 字符集的转换
function encode_utf8($lanstr)
{
	global $smarty;
	global $UM;
	global $default_char_set;
	
	$utf8 = "";
	$charset = $default_char_set;
	//debug	echo "charset encode : ".$charset;
	
	if(strcasecmp($charset, "gb2312") == 0)
	{
		$utf8 = GB2312toUTF8($lanstr);
	}
	else if(strcasecmp($charset, "big5") == 0)
	{
		$utf8 = BIG5toUTF8($lanstr);
	}
	else
	{
		//默认的字符集未西欧字符集 iso-8859-x
		$utf8 = utf8_encode($lanstr);
	}
		
	return $utf8;
}

function decode_utf8($utf8)
{
	global $smarty;
	global $UM;
	global $default_char_set;
	
	$lanstr = "";
	$charset = $default_char_set;
	//debug	echo "charset decode : ".$charset;
	
	if(strcasecmp($charset, "gb2312") == 0)
	{
		$lanstr = UTF8toGB2312($utf8);
	}
	else if(strcasecmp($charset, "big5") == 0)
	{
		$lanstr = UTF8toBIG5($utf8);
	}
	else
	{
		$lanstr = utf8_decode($utf8);
	}
	
	return $lanstr;
}

function LDAPQueryResult($keyword, $flag = 0)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_dn;
	global $ldap_root_pwd;

	$ln = ldap_connect($ldap_server,$ldap_port);
	if($ln === false )
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) === false )
	{
		ldap_close($ln);
		return false;		
	}
	
	if($keyword == "")
	{
		$filter = "(|(cn=*))";	
	}
	else
	{
		if($flag == 1)
			$filter = "(|(cn=$keyword*))";	
		else
			$filter = "(|(cn=*$keyword*)(sn=*$keyword*)(mail=*$keyword*))";	
	}
	$justthese = array("cn", "mail", "telephonenumber");	
	
	$rs = ldap_search($ln, $ldap_base_dn, $filter, $justthese);
	
	if($rs === false)
	{
		$ret = false;
	}
	else
	{
		$ret = ldap_get_entries($ln, $rs);		
		ldap_free_result($rs);
	}
	
	ldap_close($ln);
		
	return $ret;
}

function LDAPUserInfo($mail)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_dn;
	global $ldap_root_pwd;
	
	
	if($mail == ""){
		return false;			
	}
	else{
		$filter = "(|(mail=$mail))";	
	}
	$justthese = array("cn", "sn", "mail", "homepostaladdress", "homephone", 
		"mobile", "ou", "title", "physicaldeliveryofficename", "telephonenumber");
	
	$ln = ldap_connect($ldap_server, $ldap_port);
	if($ln === false )
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) === false ){
		ldap_close($ln);
		
		return false;		
	}		
	
	$rs = ldap_search($ln, $ldap_base_dn, $filter, $justthese);
	
	if($rs === false) {
		$ret = false;
	}
	else {
		$ret = ldap_get_entries($ln, $rs);		
		ldap_free_result($rs);
	}
	
	ldap_close($ln);
		
	return $ret;	
}

function LDAPAddUser($userinfo)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_dn;
	global $ldap_root_pwd;
	
	$uid = "uid=".$userinfo["uid"];
	$dn = $uid.",".$ldap_base_dn;

	$ldapuserinfo["objectclass"][0] = "top";
	$ldapuserinfo["objectclass"][1] = "person";
	$ldapuserinfo["objectclass"][2] = "organizationalPerson";
	$ldapuserinfo["objectclass"][3] = "inetorgperson";
	$ldapuserinfo["objectclass"][4] = "officeperson";
	
	$ldapuserinfo["uid"] = $userinfo["uid"];
	$ldapuserinfo["cn"] = $userinfo["user"];	
	$ldapuserinfo["mail"] = $userinfo["mail"];
	
	if($userinfo["userpassword"] == "")
		$ldapuserinfo["userpassword"] = " ";
	else
		$ldapuserinfo["userpassword"] = convertMD5Passwd_b64($userinfo["userpassword"]);
	
	if ($userinfo["fullname"] == "")
		$ldapuserinfo["sn"] = " ";
	else
		$ldapuserinfo["sn"] = encode_utf8($userinfo["fullname"]);
	
	if ($userinfo["homeaddress"] == "")
		$ldapuserinfo["homepostaladdress"] = " ";
	else
		$ldapuserinfo["homepostaladdress"] = encode_utf8($userinfo["homeaddress"]);
	
	if ($userinfo["homephone"] == "")
		$ldapuserinfo["homephone"] = " ";
	else
		$ldapuserinfo["homephone"] = encode_utf8($userinfo["homephone"]);
	
	if ($userinfo["mobile"] == "")
		$ldapuserinfo["mobile"] = " ";
	else
		$ldapuserinfo["mobile"] = encode_utf8($userinfo["mobile"]);
	
	if ($userinfo["organizationunit"] == "")
		$ldapuserinfo["ou"] = " ";
	else
		$ldapuserinfo["ou"] = encode_utf8($userinfo["organizationunit"]);
	
	if ($userinfo["jobtitle"] == "")
		$ldapuserinfo["title"] = " ";
	else
	    $ldapuserinfo["title"] = encode_utf8($userinfo["jobtitle"]);
	        
	if ($userinfo["office"] == "")
		$ldapuserinfo["physicaldeliveryofficename"] = " ";
	else
		$ldapuserinfo["physicaldeliveryofficename"] = encode_utf8($userinfo["office"]);
	
	if ($userinfo["officephone"] == "")
		$ldapuserinfo["telephonenumber"] = " ";
	else
		$ldapuserinfo["telephonenumber"] = encode_utf8($userinfo["officephone"]);
	
	$ln = ldap_connect($ldap_server, $ldap_port);
	if($ln === false)
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) === false){		
		ldap_close($ln);

		return false;	
	}
	
	$ret = ldap_add($ln, $dn, $ldapuserinfo);

	ldap_close($ln);
		
	return $ret;
}
function LDAPModifyPass($userinfo)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_pwd;
	global $ldap_root_dn;
	
	$uid = "uid=".$userinfo["uid"];
	$dn = $uid.",".$ldap_base_dn;
	
	//echo "DN:".$dn."&nbsp;";
	$ln = ldap_connect($ldap_server, $ldap_port);
	if($ln == false)
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) == false)	{
		ldap_close($ln);

		return false;	
	}
	
	if($userinfo["userpassword"] == "")
		$ldapuserinfo["userpassword"] = " ";
	else
		$ldapuserinfo["userpassword"] = convertMD5Passwd_b64($userinfo["userpassword"]);	
	
	$ret = ldap_modify($ln, $dn, $ldapuserinfo);
		
	ldap_close($ln);
		
	return $ret;	
}

function LDAPModifyUser($userinfo)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_pwd;
	global $ldap_root_dn;
	
	$uid = "uid=".$userinfo["uid"];
	$dn = $uid.",".$ldap_base_dn;
	
	//echo "DN:".$dn."&nbsp;";
	$ln = ldap_connect($ldap_server, $ldap_port);
	if($ln == false)
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) == false)	{
		ldap_close($ln);

		return false;	
	}

	ldap_delete($ln, $dn);
	
	$ldapuserinfo["objectclass"][0] = "top";
	$ldapuserinfo["objectclass"][1] = "person";
	$ldapuserinfo["objectclass"][2] = "organizationalPerson";
	$ldapuserinfo["objectclass"][3] = "inetorgperson";
	$ldapuserinfo["objectclass"][4] = "officeperson";
	
	$ldapuserinfo["uid"] = $userinfo["uid"];
	$ldapuserinfo["cn"] = $userinfo["user"];	
	$ldapuserinfo["mail"] = $userinfo["mail"];
	
	if($userinfo["userpassword"] == "")
		$ldapuserinfo["userpassword"] = " ";
	else
		$ldapuserinfo["userpassword"] = convertMD5Passwd_b64($userinfo["userpassword"]);
	
	
	if ($userinfo["fullname"] == "")
		$ldapuserinfo["sn"] = " ";
	else
		$ldapuserinfo["sn"] = encode_utf8($userinfo["fullname"]);
	
	if ($userinfo["homeaddress"] == "")
		$ldapuserinfo["homepostaladdress"] = " ";
	else
		$ldapuserinfo["homepostaladdress"] = encode_utf8($userinfo["homeaddress"]);
	
	if ($userinfo["homephone"] == "")
		$ldapuserinfo["homephone"] = " ";
	else
		$ldapuserinfo["homephone"] = encode_utf8($userinfo["homephone"]);
	
	if ($userinfo["mobile"] == "")
		$ldapuserinfo["mobile"] = " ";
	else
		$ldapuserinfo["mobile"] = encode_utf8($userinfo["mobile"]);
	
	if ($userinfo["organizationunit"] == "")
		$ldapuserinfo["ou"] = " ";
	else
		$ldapuserinfo["ou"] = encode_utf8($userinfo["organizationunit"]);
	
	if ($userinfo["jobtitle"] == "")
		$ldapuserinfo["title"] = " ";
	else
	    $ldapuserinfo["title"] = encode_utf8($userinfo["jobtitle"]);
	        
	if ($userinfo["office"] == "")
		$ldapuserinfo["physicaldeliveryofficename"] = " ";
	else
		$ldapuserinfo["physicaldeliveryofficename"] = encode_utf8($userinfo["office"]);
	
	if ($userinfo["officephone"] == "")
		$ldapuserinfo["telephonenumber"] = " ";
	else
		$ldapuserinfo["telephonenumber"] = encode_utf8($userinfo["officephone"]);
	
	$ret = ldap_add($ln, $dn, $ldapuserinfo);
		
	ldap_close($ln);
		
	return $ret;	
}

function LDAPDelUser($userid)
{
	global $ldap_server;
	global $ldap_port;
	global $ldap_base_dn;
	global $ldap_root_pwd;
	global $ldap_root_dn;
	
	$uid = "uid=".$userid;
	$dn = $uid.",".$ldap_base_dn;
	
	//echo "DN:".$dn."&nbsp;";
	$ln = ldap_connect($ldap_server, $ldap_port);
	if($ln === false )
		return false;
	
	if(ldap_bind($ln, $ldap_root_dn, $ldap_root_pwd) === false )	{
		ldap_close($ln);

		return false;	
	}
	
	$ret = ldap_delete($ln, $dn);	
	ldap_close($ln);
		
	return $ret;	
}
//ldap end


$lg = file("langs/".$selected_language.".txt");

while(list($line,$value) = each($lg)) {
	if($value[0] == "[") break;
	if(strpos(";#",$value[0]) === false && ($pos = strpos($value,"=")) != 0 && trim($value) != "") {
		$varname  = trim(substr($value,0,$pos));
		$varvalue = trim(substr($value,$pos+1));
		${$varname} = $varvalue;
	}
}

/*
function print_struc($obj) {
	echo("<pre>");
	print_r($obj);
	echo("</pre>");
}
*/

?>