<?
session_start();

@session_unregister("user");
@session_unregister("admin");
@session_unregister("s_pass");
@session_unregister("order");
@session_unregister("old");
header("location:index.php");
exit;
?>