<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");
if(!isset($folder) || !isset($ix)) die("Expected parameters");
echo($nocache);
$body = $sess["currentbody"];

if($block_external_images) {
	$body = eregi_replace("src=([\"]?)(http[s]?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_-]+)([\"]?)","src=\\1images/trans.gif\\3 original_url=\"\\2\"",$body);
	$body = eregi_replace("background=([\"]?)(http[s]?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_-]+)([\"]?)","background=\\1images/trans.gif\\3 original_url=\"\\2\"",$body);
}

$body = eregi_replace("target=[\"]?[A-Z_]+[\"]?","",$body);
$body = eregi_replace("href=([\"]?)http([s]?)://","target=\"_blank\" href=\\1http\\2://",$body);
//$body = eregi_replace("<a","<a target=\"_blank\"",$body);

$body = eregi_replace("href=\"mailto:","target=\"_top\" href=\"newmsg.php?sid=$sid&tid=$tid&lid=$lid&nameto=",$body);

echo ("<STYLE>
	BODY {font-size: 10.8pt}
</STYLE>
");

if (!empty($body)){
	echo ($body);
	
	echo ("<script>
		if (document.body.scrollHeight > 300)
			parent.document.getElementById('readerframe').style.height = document.body.scrollHeight + 50 + 'px';
	</script>
	");
}
?>
