<?
setcookie('cookie_agent','SkyMate');
setcookie('cookie_user_account',$HTTP_GET_VARS['user_account']);
header("location:index.php");
exit;
?>
