<?
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';

$project	= $_POST['project'];
$prid1		= $_POST['prid1'];
$prid2		= $_POST['prid2']==''?0:$_POST['prid2'];

$name		= mysql_escape_string($_POST['name']);
$email		= mysql_escape_string($_POST['email']);
$homepage	= mysql_escape_string(str_replace('http://','',$_POST['homepage']));
$content	= mysql_escape_string($_POST['content']);

$sql1="insert into comments set project='".$project."',prid1='".$prid1."',prid2='".$prid2."',name='".$name."',email='".$email."',homepage='".$homepage."',content='".$content."',posttime=NOW()";
$db->sql_query($sql1);
header("location:".$_SESSION['comment_url']."#comment");
exit;

?>