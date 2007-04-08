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

$externalpop3 = load_externalpop3();
array_qsort2($externalpop3, "username");


$jssource = $memujssource;

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$tid);
$smarty->assign("umJS",$jssource);
$smarty->assign("umGoBack","externalpop3.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");


switch($opt) {
        // save an edited contact

        case "save":
        		$port = is_int($port) ? $port : '110';
        		
                $externalpop3[$id]["username"] = $username;
                $externalpop3[$id]["password"] = $password;
                $externalpop3[$id]["host"] = $host;
                $externalpop3[$id]["port"] = $port;
                $externalpop3[$id]["enable"] = $enable;
                $externalpop3[$id]["savecopy"] = $savecopy;

				save_externalpop3($externalpop3);

				$smarty->assign("umOpt",1);
				$templatename = "externalpop3-results.htm";

                break;

        // add a new external pop3
        case "add":
                $id = count($externalpop3);
                
                $domainInfo = load_alldomain();
				$aval_domains = count($domainInfo);
				$maildomain = substr($sess['email'], strpos($sess['email'], '@')+1);
				for ($i = 0; $i < $aval_domains; $i++){
					if (strtolower($domainInfo[$i]['domain']) == strtolower($maildomain))
						$maxpop3num = $domainInfo[$i]['externalmailnum'];
				}	 
                
                if (!empty($maxpop3num) && $id >= $maxpop3num){
					$smarty->assign("umOpt",-1);
					$templatename = "externalpop3-results.htm";
                }
                else {
        			$port = is_int($port) ? $port : '110';
        			
	                $externalpop3[$id]["username"] = $username;
	                $externalpop3[$id]["password"] = $password;
	                $externalpop3[$id]["host"] = $host;
	                $externalpop3[$id]["port"] = $port;
	                $externalpop3[$id]["enable"] = $enable;
	                $externalpop3[$id]["savecopy"] = $savecopy;
	
					save_externalpop3($externalpop3);
	
					$smarty->assign("umOpt",2);
					$templatename = "externalpop3-results.htm";
				}
				
                break;

        //delete an existing contact
        case "dele":
                unset($externalpop3[$id]);
                $newpop3 = Array();
                while(list($l,$value) = each($externalpop3))
                        $newpop3[] = $value;
                $externalpop3 = $newpop3;
				save_externalpop3($externalpop3);

				$smarty->assign("umOpt",3);
				$templatename = "externalpop3-results.htm";

                break;

        // show the form to edit
        case "edit":
				$smarty->assign("umUserName", $externalpop3[$id]["username"]);
				$smarty->assign("umPassword", $externalpop3[$id]["password"]);
				$smarty->assign("umHost", $externalpop3[$id]["host"]);
				$smarty->assign("umPort", ($externalpop3[$id]["port"] ? $externalpop3[$id]["port"] : '110'));

				$status = ($externalpop3[$id]["enable"] == 1) ? 'checked' : '';
				$smarty->assign("umEnable", $status);
				
				$status = ($externalpop3[$id]["savecopy"] == 1) ? 'checked' : '';
				$smarty->assign("umSaveCopy", $status);
				
				$smarty->assign("umOpt","save");
				$smarty->assign("umPop3ID",$id);
				$templatename = "externalpop3-form.htm";

                break;

        // display the details for an especified contact
        case "display":
				$smarty->assign("umUserName", $externalpop3[$id]["username"]);
				$smarty->assign("umPassword", $externalpop3[$id]["password"]);
				$smarty->assign("umHost", $externalpop3[$id]["host"]);
				$smarty->assign("umPort", ($externalpop3[$id]["port"] ? $externalpop3[$id]["port"] : '110'));
				
				$status = ($externalpop3[$id]["enable"] == 1) ? 'Enable' : 'Disable';
				$smarty->assign("umEnable", $status);
				
				$status = ($externalpop3[$id]["savecopy"] == 1) ? 'Enable' : 'Disable';
				$smarty->assign("umSaveCopy", $status);

				$smarty->assign("umPop3ID",$id);
				$templatename = "externalpop3-display.htm";

                break;

        // show the form to a new contact
        case "new":
				$templatename = "externalpop3-form.htm";

				$smarty->assign("umPort","110");
				$smarty->assign("umOpt","add");
				$smarty->assign("umPop3ID","N");

                break;

        // default is list
        default:
				$smarty->assign("umNew","externalpop3.php?opt=new&sid=$sid&tid=$tid&lid=$lid&retid=$retid");

				$externalpop3list = Array();
                for($i=0; $i < count($externalpop3); $i++) {
						$externalpop3list[$i]["viewlink"] = "externalpop3.php?opt=display&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";
						$externalpop3list[$i]["editlink"] = "externalpop3.php?opt=edit&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";
						$externalpop3list[$i]["dellink"] = "externalpop3.php?opt=dele&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";

						$externalpop3list[$i]["username"] = htmlspecialchars($externalpop3[$i]["username"]);
						$externalpop3list[$i]["host"] = htmlspecialchars($externalpop3[$i]["host"]).':'.($externalpop3[$i]["port"] ? $externalpop3[$i]["port"] : '110');
						$externalpop3list[$i]["enable"] = ($externalpop3[$i]["enable"] == 1) ? 'Enable' : 'Disable';
						$externalpop3list[$i]["statusimg"] = ($externalpop3[$i]["enable"] == 1) ? 'images/enable.gif' : 'images/disable.gif';
                }
				$templatename = "externalpop3-list.htm";
				$smarty->assign("umExternalPop3List",$externalpop3list);
}

$smarty->display("$selected_theme/$templatename");

?>