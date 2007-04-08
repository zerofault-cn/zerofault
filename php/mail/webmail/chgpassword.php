<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/


require("./inc/inc.php");
require_once("./inc/userlib.php");

if(isset($save)) {
	
	if ($pwd_new != "" 
		&& $pwd_new == $pwd_confirm) {
		$myinfo['oldpassword'] = $pwd_old;
		$myinfo['newpassword'] = $pwd_new;
		
		if (change_password($myinfo))
		{
			$sess["pass"] = $pwd_new;
			$SS->Save($sess);
			
			$userinfo = getUserInfo($sess["user"]);
						
			$newinfo["uid"] = $sess["user"];
			$newinfo["user"] = $sess["user"];
			$newinfo["mail"] = $sess["email"];
						
			$newinfo["publicinfo"] = $userinfo["publicinfo"];
							
			$newinfo["userpassword"] = $sess["pass"];
			
			//echo "m_publicinfo".$m_publicinfo."<br>";
			//echo "public:".$newinfo["publicinfo"]."<br>";
			if ($newinfo["publicinfo"] == 1)
			{
				LDAPModifyPass($newinfo);
			}

			$result = 'success';
		}
		else
			$result = 'failure';
	}
	else
		$result = 'failure';
}

$jssource = $memujssource;


$smarty->assign("umJS",$jssource);
$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$smarty->assign("umPasswordReult",$result);
$smarty->assign("umGoBack","chgpassword.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");

$smarty->display("$selected_theme/chgpassword.htm");


?>