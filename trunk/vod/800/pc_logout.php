<?
session_start();
unset($_SESSION['goldsoft_user']);
unset($_SESSION['account']);
unset($_SESSION['menu_focus']);
header("location:index.php");
exit;
?>
