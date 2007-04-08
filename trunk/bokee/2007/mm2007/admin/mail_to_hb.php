<?
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");


$sql="select * from mm_info where pass=1 and blogurl like '%home.hb.vnet.cn%'";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$blogurl=$row['blogurl'];
	$bokeeurl=substr($blogurl,7);
	if(strpos($bokeeurl,'/')>0)
	{
		$bokeeurl=substr($bokeeurl,0,strpos($bokeeurl,'/'));
	}
	$email=$row['email'];
//	if(mailtohb($id,$bokeeurl,$email))
	{
		echo ++$i;
		echo ': '.$email.'<br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;http://my.bobo.com.cn/bokee/zhong.php?flag=up&userid='.$id.'&bokeeURL='.$bokeeurl.'<br>';
	}
}

//²âÊÔ
//mailtohb(1,'haha.bokee.com','zerofault@gmail.com');

$db->sql_close();

?>