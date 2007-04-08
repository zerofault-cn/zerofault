<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

echo($nocache);
if (isset($rem) && $rem != "") {

	$attchs = $sess["attachments"];
	@unlink($attchs[$rem]["localname"]);
	unset($attchs[$rem]);
	$c = 0;
	$newlist = Array();
	while(list($key,$value) =  each($attchs)) {
		$newlist[$c] = $value; $c++;
	}
	$sess["attachments"] = $newlist;
	$SS->Save($sess);
	
	if (!isset($closewin) || $closewin == "") {
		echo("
		<script language=javascript>\n
			if(window.opener) window.opener.doupload();\n
			setTimeout('self.close()',500);\n
		</script>\n
		");
		
		exit;
	}

} elseif (is_uploaded_file($userfile) || is_uploaded_file($userfile["tmp_name"])) {

	if($phpver >= 4.1) {
		$userfile_name  = $userfile["name"];
		$userfile_type	= $userfile["type"];
		$userfile_size	= $userfile["size"];
		$userfile		= $userfile["tmp_name"];
	}

	if (file_exists($userfile)){
	
		if(!is_array($sess["attachments"])) $ind = 0;
		else $ind = count($sess["attachments"]);
		
		if(!file_exists($temporary_directory."_attachments")) {
			mkdir($temporary_directory."_attachments");
		}
	
		$filename = $temporary_directory."_attachments\\".$sess['user'].'_'.md5(uniqid("")).$userfile_name;
	
	    move_uploaded_file($userfile, $filename);
	
		$sess["attachments"][$ind]["localname"] = $filename;
		$sess["attachments"][$ind]["name"] = $userfile_name;
		$sess["attachments"][$ind]["type"] = $userfile_type;
		$sess["attachments"][$ind]["size"] = $userfile_size;
	
		if (strrpos($userfile_name, '.') !== false) {
			$filename = substr($userfile_name, strrpos($userfile_name, '.')+1);
			$iconfile = $fileiconpath.$filename.".gif";
			if (!file_exists($iconfile))
				$iconfile = $fileiconpath."unknown.gif";
		}	
		else
			$iconfile = $fileiconpath."unknown.gif";
		$sess["attachments"][$ind]["iconfile"] = $iconfile;
	
		$SS->Save($sess);
	}
}

$haveAttachs = (is_array($attachs = $sess["attachments"]) && count($sess["attachments"]) != 0)?1:0;
$smarty->assign("umHaveAttachs",$haveAttachs);

if(is_array($attachs = $sess["attachments"]) && count($sess["attachments"]) != 0) {

	$attachlist = Array();
	for($i = 0; $i < count($attachs); $i++) {
		$index = count($attachlist);

		$attachlist[$index]["name"] = $attachs[$i]["name"];
		$attachlist[$index]["size"] = ceil($attachs[$i]["size"]/1024);
		
		if (!empty($attachs[$i]["iconfile"]))
		{
			$iconfile = $attachs[$i]["iconfile"];
		}
		else
		{
			if (strrpos($attachs[$i]["name"], '.') !== false) {
				$iconname = substr($attachs[$i]["name"], strrpos($attachs[$i]["name"], '.')+1);
				$iconfile = $fileiconpath.$iconname.".gif";
				if (!file_exists($iconfile))
					$iconfile = $fileiconpath."unknown.gif";
			}	
			else
				$iconfile = $fileiconpath."unknown.gif";
		}

		$attachlist[$index]["iconfile"] = $iconfile;
		$attachlist[$index]["type"] = $attachs[$i]["type"];
		$attachlist[$index]["link"] = "upload.php?rem=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid&closewin=false";
	}
	$smarty->assign("umAttachList",$attachlist);
}

$forms = "<input type=hidden name=lid value=$lid>
<input type=hidden name=sid value=\"$sid\">
<input type=hidden name=tid value=\"$tid\">";

$smarty->assign("umForms", $forms);

$smarty->assign("umSid",$sid);
$smarty->display("$selected_theme/upload-attach.htm");

?>
