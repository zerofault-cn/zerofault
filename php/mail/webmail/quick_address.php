<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
S�o Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

$addressbook = load_addressbook();

array_qsort2($addressbook,"name");
$listbox = "<select name=contacts size=10 onDblClick=\"Add('to')\" multiple>\r\n";
for($i=0;$i<count($addressbook);$i++) {
	$line = $addressbook[$i];
	$name = htmlspecialchars(trim($line["name"]));;
	$email = htmlspecialchars(trim($line["email"]));
	$listbox .= "<option value=\"&quot;$name&quot; &lt;$email&gt;\"> &quot;$name&quot; &lt;$email&gt;";
}
$listbox .= "</select>";


$smarty->assign("umContacts",$listbox);
$smarty->display("$selected_theme/quick_address.htm");

?>