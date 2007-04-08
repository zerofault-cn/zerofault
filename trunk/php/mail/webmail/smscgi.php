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
	if (!$smscgi_status)
		$smscgi_status = 0;
		
	$myinfo["mailnotifystatus"]	= $smscgi_status;
	$myinfo["isp"]	= $smscgi_isp;
	$myinfo["host"]	= $smscgi_host;
	$myinfo["port"]	= $smscgi_port;
	$myinfo["length"]	= $smscgi_length;
	$myinfo["user"]	= $smscgi_user;
	$myinfo["pass"]	= $smscgi_pass;

	save_smscgi($myinfo); 
	
	$info = $myinfo;
}else {
	$info = load_smscgi();
}

$jsisps = '';
for ($i = 0; $i < count($smscgi); $i++){
	$tmp_isp = $smscgi[$i]['isp'];
	$tmp_host = $smscgi[$i]['host'];
	$tmp_port = $smscgi[$i]['port'];
	$tmp_length = $smscgi[$i]['length'];
	
	$jsisps .= "isps[$i] = new Array('$tmp_isp', '$tmp_host', '$tmp_port', '$tmp_length');\r\n";
}

$jssource = $memujssource."
<script language=\"JavaScript\">
function changeIsp()
{
	var isps = new Array();
	$jsisps
	
	var index = document.form1.smscgi_isp.selectedIndex;
	
	document.form1.smscgi_host.value = isps[index][1];
	document.form1.smscgi_port.value = isps[index][2];
	document.form1.smscgi_length.value = isps[index][3];
}
</script>
";

$smarty->assign("umJS",$jssource);
$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$status = ($info["mailnotifystatus"] == 1)?" checked":" ";

$isplist = '<select name="smscgi_isp" onChange="javascript:changeIsp();">';
for ($i = 0; $i < count($smscgi); $i++){
	$isplist .= '<option value="'.$smscgi[$i]['isp'].'"';
	if ($smscgi[$i]['isp'] == $info["isp"])
		$isplist .= ' selected';
	$isplist .= '>'.$smscgi[$i]['ispname'].'</option>';
}
$isplist .= '</select>';

$smarty->assign("umSmsCgiIspList", $isplist);
$smarty->assign("umSmsCgiStatus", $status);
$smarty->assign("umSmsCgiIsp", $info["isp"]);
$smarty->assign("umSmsCgiHost", $info["host"]);
$smarty->assign("umSmsCgiPort", $info["port"]);
$smarty->assign("umSmsCgiLength", $info["length"]);
$smarty->assign("umSmsCgiUser", $info["user"]);
$smarty->assign("umSmsCgiPass", $info["pass"]);


$smarty->display("$selected_theme/smscgi.htm");

?>