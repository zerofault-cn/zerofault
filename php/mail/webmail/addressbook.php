<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/


// load session management
require("./inc/inc.php");
// keep cache clean
//echo($nocache);

$addressbook = load_addressbook();
array_qsort2($addressbook,"name");


$jssource = $memujssource;

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$tid);
$smarty->assign("umJS",$jssource);
$smarty->assign("umGoBack","addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");


switch($opt) {
        // save an edited contact

        case "save":
                $addressbook[$id]["name"] = $name;
                $addressbook[$id]["email"] = $email;
                $addressbook[$id]["phone"] = $phone;
                $addressbook[$id]["address"] = $address;
                $addressbook[$id]["work"] = $work;

				save_addressbook($addressbook);

				$smarty->assign("umOpt",1);
				$templatename = "address-results.htm";

                break;

        // add a new contact
        case "add":
                $id = count($addressbook);
                $addressbook[$id]["name"] = $name;
                $addressbook[$id]["email"] = $email;
                $addressbook[$id]["phone"] = $phone;
                $addressbook[$id]["address"] = $address;
                $addressbook[$id]["work"] = $work;

				save_addressbook($addressbook);

				$smarty->assign("umOpt",2);
				$templatename = "address-results.htm";

                break;

        //delete an existing contact
        case "dele":
                unset($addressbook[$id]);
                $newaddr = Array();
                while(list($l,$value) = each($addressbook))
                        $newaddr[] = $value;
                $addressbook = $newaddr;
				save_addressbook($addressbook);

				$smarty->assign("umOpt",3);
				$templatename = "address-results.htm";

                break;

        // show the form to edit
        case "edit":

				$smarty->assign("umAddrName",$addressbook[$id]["name"]);
				$smarty->assign("umAddrEmail",$addressbook[$id]["email"]);
				$smarty->assign("umAddrPhone",$addressbook[$id]["phone"]);
				$smarty->assign("umAddrAddress",$addressbook[$id]["address"]);
				$smarty->assign("umAddrWork",$addressbook[$id]["work"]);
				$smarty->assign("umOpt","save");
				$smarty->assign("umAddrID",$id);
				$templatename = "address-form.htm";


                break;

        // display the details for an especified contact
        case "display":

				$smarty->assign("umAddrName",$addressbook[$id]["name"]);
				$smarty->assign("umAddrEmail",$addressbook[$id]["email"]);
				$smarty->assign("umAddrPhone",$addressbook[$id]["phone"]);
				$smarty->assign("umAddrAddress",$addressbook[$id]["address"]);
				$smarty->assign("umAddrWork",$addressbook[$id]["work"]);

				$smarty->assign("umAddrID",$id);
				$templatename = "address-display.htm";


                break;

        // show the form to a new contact
        case "new":

				$templatename = "address-form.htm";

				$smarty->assign("umOpt","add");
				$smarty->assign("umAddrID","N");

                break;

        // export a contact

        case "expo":
                require("./inc/lib.export.php");
                export2ou($addressbook[$id]);
                break;

        // default is list

        default:
				$smarty->assign("umNew","addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&opt=new");

				$addresslist = Array();
                for($i=0; $i < count($addressbook); $i++) {
						$addresslist[$i]["viewlink"] = "addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&opt=display&id=$i";
						$addresslist[$i]["composelink"] = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&nameto=".urlencode($addressbook[$i]["name"])."&mailto=".urlencode($addressbook[$i]["email"]);
						$addresslist[$i]["editlink"] = "addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&opt=edit&id=$i";
						$addresslist[$i]["dellink"] = "addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&opt=dele&id=$i";

						$addresslist[$i]["name"] = htmlspecialchars($addressbook[$i]["name"]);
						$addresslist[$i]["email"] = htmlspecialchars($addressbook[$i]["email"]);
                }
				$templatename = "address-list.htm";
				$smarty->assign("umAddressList",$addresslist);
}

$smarty->display("$selected_theme/$templatename");

?>