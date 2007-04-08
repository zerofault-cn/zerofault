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

$signature = load_signature();
array_qsort2($signature,"name");


$jssource = $memujssource;

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$tid);
$smarty->assign("umJS",$jssource);
$smarty->assign("umGoBack","signature.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");


switch($opt) {
        // save an edited contact

        case "save":
                $signature[$id]["name"] = $name;
                $signature[$id]["content"] = $content;

				save_signature($signature);

				$smarty->assign("umOpt",1);
				$templatename = "signature-results.htm";

                break;

        // add a new contact
        case "add":
                $id = count($signature);
                
                $domainInfo = load_alldomain();
				$aval_domains = count($domainInfo);
				$maildomain = substr($sess['email'], strpos($sess['email'], '@')+1);
				for ($i = 0; $i < $aval_domains; $i++){
					if (strtolower($domainInfo[$i]['domain']) == strtolower($maildomain))
						$maxsignnum = $domainInfo[$i]['signaturenum'];
				}	 

                if (!empty($maxsignnum) && $id >= $maxsignnum){
					$smarty->assign("umOpt",-1);
					$templatename = "signature-results.htm";
                }
                else {
	                $signature[$id]["name"] = $name;
	                $signature[$id]["content"] = $content;
	
					save_signature($signature);
	
					$smarty->assign("umOpt",2);
					$templatename = "signature-results.htm";
            	}
                break;

        //delete an existing contact
        case "dele":
                unset($signature[$id]);
                $newsig = Array();
                while(list($l,$value) = each($signature))
                        $newsig[] = $value;
                        
                $signature = $newsig;
				save_signature($signature);

				$smarty->assign("umOpt",3);
				$templatename = "signature-results.htm";

                break;

        // show the form to edit
        case "edit":

				$smarty->assign("umSignName",$signature[$id]["name"]);
				$smarty->assign("umSignContent",$signature[$id]["content"]);

				$smarty->assign("umOpt","save");
				$smarty->assign("umSignID",$id);
				$templatename = "signature-form.htm";


                break;

        // display the details for an especified contact
        case "display":

				$smarty->assign("umSignName",$signature[$id]["name"]);
				$smarty->assign("umSignContent", nl2br(htmlspecialchars($signature[$id]["content"])));

				$smarty->assign("umSignID",$id);
				$templatename = "signature-display.htm";


                break;

        // show the form to a new contact
        case "new":

				$templatename = "signature-form.htm";

				$smarty->assign("umOpt","add");
				$smarty->assign("umSignID","N");

                break;

        // default is list

        default:
				$smarty->assign("umNew","signature.php?opt=new&sid=$sid&tid=$tid&lid=$lid");

				$signaturelist = Array();
                for($i=0; $i < count($signature); $i++) {
						$signaturelist[$i]["viewlink"] = "signature.php?opt=display&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";
						$signaturelist[$i]["editlink"] = "signature.php?opt=edit&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";
						$signaturelist[$i]["dellink"] = "signature.php?opt=dele&id=$i&sid=$sid&tid=$tid&lid=$lid&retid=$retid";

						$signaturelist[$i]["name"] = htmlspecialchars($signature[$i]["name"]);
						$signaturelist[$i]["content"] = htmlspecialchars($signature[$i]["content"]);
                }
				$templatename = "signature-list.htm";
				$smarty->assign("umSignatureList",$signaturelist);
}

$smarty->display("$selected_theme/$templatename");

?>