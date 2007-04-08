<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

$addressbook = load_addressbook();

function valid_email($thismail) {
	if (!eregi("([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_]+)", $thismail)) 
		return 0;

	global $addressbook;
	for($i = 0; $i < count($addressbook); $i++){
		if(trim($addressbook[$i]["email"]) == trim($thismail)) 
			return 0;
	}

	return 1;
}

if(isset($opt)) {
    $id = count($addressbook);
    $addressbook[$id]["name"] = $name;
    $addressbook[$id]["email"] = $email;
    $addressbook[$id]["phone"] = urldecode($phone);
    $addressbook[$id]["address"] = $address;
    $addressbook[$id]["work"] = $work;

	save_addressbook($addressbook);
	
	echo("
	<script language=javascript>
		self.close();
	</script>
	");
} else {

	$smarty->assign("umLid",$lid);
	$smarty->assign("umSid",$sid);
	$smarty->assign("umTid",$sid);
	$smarty->assign("umAddrName",$name);
	$smarty->assign("umAddrEmail",$mail);
	$smarty->assign("umAddrPhone",$phone);

	$smarty->display("$selected_theme/catch-publicaddress.htm");
}
?>