#!/opt/bokee/php/bin/php
<?php
/**
* sync_attach_feed_entry.php
* @abstract  同步附加至栏目种子的内容，将符合条件的文章从RSS服务器抓取至CMS服务器，放入rss_entry_attach表中，并在rss_article_subject中添加相应记�?
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
/*
if(file_exists("sync.pid"))
{
	exit;
}

$fp = fopen("sync.pid", 'w');
fwrite($fp, date('Y-m-d H:i:s'));
fclose($fp);
*/
define('DB_HOST','211.152.20.34');
define('DB_PORT','3306');
define('DB_USERNAME','root');
define('DB_PASSWORD','10y9c2U5');
define('DB_SCHEMA','cms');
define('PATH_ROOT', '/opt/bokee/www');
define('SLASH', '/');
define('PATH_MODULE', PATH_ROOT.SLASH.'CMS');
define('PATH_INF', PATH_MODULE.SLASH.'WEB-INF');
define('PATH_CLASS', PATH_INF.SLASH.'classes');
define('PATH_TPL', PATH_INF.SLASH.'tpl');
define('PATH_TEMPLATE', PATH_INF.SLASH.'html'.SLASH.'templates'.SLASH.'init');
define('PATH_HTML', PATH_INF.SLASH.'html');
define('PATH_HTML_ROOT', PATH_MODULE.SLASH."web".SLASH."root");
define('PATH_IMAGES', PATH_MODULE.SLASH."web".SLASH."images");
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // 页面缓存的存放路�?

require_once('../sql/DAO.cls.php');
require_once('../lang/Assert.cls.php');

set_magic_quotes_runtime(1);

$dao = DAO::CreateInstance();
$dao_group = DAO::CreateInstanceEmpty();
if(!$dao_group->Connect('party', 'cms', 'zmCMS0522', '221.238.254.186'))
	die("connect error");
			
$channel_name='group';
$db="cms_".$channel_name;
$dao->SetCurrentSchema($db);

$sql_group_party = "select max(id) from group_party";
//cms数据库group_party表的最大id
$max_local_id = $dao->GetOne($sql_group_party);
if(!$max_local_id)
{
	$max_local_id=0;
}
echo 'max_local_id:'.$max_local_id."\n";

//group数据库party表的最大id
$sql_party = "select max(partyid) from party";
$max_remote_id = $dao_group->GetOne($sql_party);
echo 'max_remote_id:'.$max_remote_id."\n";

//如果本地最大id小于远程最大id,则表示有新数据需要同步
if($max_local_id<$max_remote_id)
{
	$sql_entry = "select * from party where partyid>".$max_local_id;
	$rows_entry = $dao_group->GetPlan($sql_entry);
	$rows_num_entry = count($rows_entry);//需要同步的行数
	echo 'rows_num_entry:'.$rows_num_entry."\n";
	for($k=0;$k<$rows_num_entry;$k++)
	{
		$sql_insert="insert into group_party set id=".$rows_entry[$k]['partyid'].",groupid=".$rows_entry[$k]['groupid'].",creatorid=".$rows_entry[$k]['creatorid'].",title='".conv($rows_entry[$k]['title'])."',begintime='".$rows_entry[$k]['begintime']."',endtime='".$rows_entry[$k]['endtime']."',province='".conv($rows_entry[$k]['province'])."',city='".conv($rows_entry[$k]['city'])."',address='".conv($rows_entry[$k]['address'])."',membernum='".$rows_entry[$k]['membernum']."',memberlimit='".$rows_entry[$k]['memberlimit']."',commentnum='".$rows_feed[$k]['commentnum']."'";
		if($dao->Insert($sql_insert))
		{
			echo "group entry: " . $rows_entry[$k]['partyid'] . "sync ok!<br>\n";
		}
		else
		{
			echo $sql_insert;
			break;
		}
	}
}

for($i=1;$i<$max_local_id;$i++)
{
	$sql_entry="select membernum,commentnum from party where partyid=".$i;
	if($rows=$dao_group->GetRow($sql_entry))
	{
		$membernum=$rows['membernum'];
		$commentnum=$rows['commentnum'];
		$sql_update="update group_party set membernum=".$membernum.",commentnum=".$commentnum." where id=".$i;
		if($dao->Query($sql_update))
		{
			echo 'update group_party ok '.$i."<br>\n";
		}
		else
		{
			break;
		}
	}
}

echo 'done';
function getField($id,$field,$table)
{
	global $dao_rss;
	$sql0="select ".$field." from ".$table." where id=".$id;
	return $dao_rss->GetOne($sql0);
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>
