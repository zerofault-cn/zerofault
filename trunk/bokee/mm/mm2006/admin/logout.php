<?
session_start();

@session_unregister("user");
@session_unregister("admin");
@session_unregister("admin_area");
@session_unregister("s_pass");
@session_unregister("order");
header("location:index.php");
exit;
?>