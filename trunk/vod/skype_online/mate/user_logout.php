<?
//userLogout();
function userLogout()
{
	setcookie("cookie_user_id",'');
	setcookie("cookie_user_account","");
	header("location:?action=");
	exit;
}
?>