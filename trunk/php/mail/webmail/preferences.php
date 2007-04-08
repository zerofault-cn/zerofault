<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/


require("./inc/inc.php");



if(isset($save)) {
	if (!$f_save_trash)
		$f_save_trash = 0;
	if (!$f_empty_on_exit)
		$f_empty_on_exit = 0;
	if (!$f_save_sent)
		$f_save_sent = 0;
	if (!$f_display_images)
		$f_display_images = 0;
		
	$myprefs["real-name"]		= $f_real_name;
	$myprefs["reply-to"]		= $f_reply_to;
	$myprefs["save-to-trash"]	= $f_save_trash;
	$myprefs["empty-trash"]		= $f_empty_on_exit;
	$myprefs["save-to-sent"]	= $f_save_sent;
	$myprefs["rpp"]				= $f_rpp;
	$myprefs["display-images"]	= $f_display_images;
	$myprefs["editor-mode"]		= $f_editor_mode;
	$myprefs["first-login"] 	= 1;

	save_prefs($myprefs);
	
	$prefs = $myprefs;
}else {
	$prefs = load_prefs();
}

$jssource = $memujssource;

$smarty->assign("umJS",$jssource);
$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$aval_rpp = Array(10,20,30,40,50,100,200);
$sel_rpp = "<select name=f_rpp>\r";
for($i=0;$i<count($aval_rpp);$i++) {
	$selected = ($prefs["rpp"] == $aval_rpp[$i])?" selected":"";
	$sel_rpp .= "<option value=".$aval_rpp[$i].$selected.">".$aval_rpp[$i]."\r";
}
$sel_rpp .= "</select>";

if ($prefs["real-name"] == ""){
	$prefs["real-name"] = $sess["user"];
}

if ($prefs["reply-to"] == ""){
	$prefs["reply-to"] = $sess["email"];
}

$smarty->assign("umRealName",$prefs["real-name"]);
$smarty->assign("umReplyTo",$prefs["reply-to"]);
$status = ($prefs["save-to-trash"])?" checked":"";
$smarty->assign("umSaveTrash",$status);
$status = ($prefs["empty-trash"])?" checked":"";
$smarty->assign("umEmptyTrashOnExit",$status);
$status = ($prefs["save-to-sent"])?" checked":"";
$smarty->assign("umSaveSent",$status);
$status = ($prefs["display-images"])?" checked":"";
$smarty->assign("umDisplayImages",$status);

$smarty->assign("umEditorMode",$prefs["editor-mode"]);
$smarty->assign("umRecordsPerPage",$sel_rpp);


$smarty->display("$selected_theme/preferences.htm");

?>