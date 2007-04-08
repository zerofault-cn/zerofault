<style>
/* ========== 全局CSS定义 ====== */
body {font: 12px/1.5 Simsun,sans-serif,Arial;}
input {font-family: Simsun,sans-serif,Arial;}
img {border: 0;}
ul{list-style:none; margin:0px; padding:0px;}
body,form,dl,dt,dd,ul,p,h1,h2,h3,h4,h5,h6{margin: 0px;padding: 0px;}
p {text-align: left;padding: 5px;}
a { color:#000;text-decoration: none;}
a:hover {text-decoration: underline;}
.clear{ clear:both;}
.jiyucon{
	overflow:hidden;
	margin-left:12px;
}		
.jiyucon li{
	height:20px;
	padding:5px 0px 0px 10px;
	background: url(images/listico.gif) no-repeat 0px 10px;
	border-bottom:1px dotted #bbb;}
.jiyu_2{
	overflow:hidden;
	float:left;
	display:inline;
	margin:12px 0px 0px 20px;}
.jiyucon_2{
	overflow:hidden;
	margin-left:12px;
}		
.jiyucon_2 li{
	height:20px;
	padding:5px 0px 0px 13px;
	background: url(images/listico.gif) no-repeat 0px 10px;
	border-bottom:1px dotted #bbb;}	
.morerl_2{
	float:right;
	margin-right:20px;
	margin-top:8px;
}
</style>
<body topmargin=0 leftmargin=0>

<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
$sid=$_REQUEST['sid'];
if(''==$sid)
{
	$sid='1';
}
$limit=$_REQUEST['limit'];
if(''==$limit)
{
	$limit=8;
}
$pageitem=$_REQUEST['pageitem'];
if(''==$pageitem)
{
	$pageitem=30;
}
if($_REQUEST['submit'])
{
	$content=conv($_REQUEST['content']);
	$username=conv($_REQUEST['username']);
	$ip=GetIP();
	$sql="insert into comment set sid='".$sid."',username='".$username."',content='".format($content)."',addtime=UNIX_TIMESTAMP(),ip='".$ip."'";
	if($db->sql_query($sql))
	{
	}
	else
	{
		echo $sql;
	}
}
if($_REQUEST['more']!='y')
{
	$sql="select * from comment where sid='".$sid."' order by id desc limit ".$limit;
	$result=$db->sql_query($sql);
	echo '<div class="jiyucon">';
	echo '<ul>';
	while($row=$db->sql_fetchrow($result))
	{
		$username=$row['username'];
		if(''==$username)
		{
			$username='匿名用户';
		}
		$content=$row['content'];
		if(''==trim($content))
		{
			continue;
		}
		$addtime=date("Y-m-d H:i",$row['addtime']);
		$ip=$row['ip'];
		$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
		echo '<li>'.$content.'<br /><div style="float:right;color:#585858;line-height:20px;background-color:#ddd">来自 '.$ip1.' 的 '.$username.' 发表于 '.$addtime.'</div></li>';
	}
	echo '</ul></div>';
}
else
{
	$sql="select * from comment where sid='".$sid."' order by id desc ";
	$result=$db->sql_query($sql);
	$total=$db->sql_numrows($result);
	pageft($total,$pageitem,"?sid=".$sid."&more=1");
	$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);
	$i=0;
	while($row=$db->sql_fetchrow($result))
	{
		if($i==0 || $i%($pageitem/2)==0)
		{
			?>
			<div class="jiyu_2">
				<div class="jiyucon_2">
				<ul>
			<?
		}
		$username=$row['username'];
		$content=$row['content'];
		$ip=$row['ip'];
		$ip1=substr($ip,0,strrpos($ip,'.')).'.*';
		$addtime=date("Y-m-d H:i",$row['addtime']);
		echo '<li>'.$content.'<br /><span style="float:right;color:#585858;line-height:20px;background-color:#ddd">'.$username.'发表于'.$addtime.' 来自'.$ip1.'</span></li>';
		if($i%($pageitem/2)==($pageitem/2-1))
		{
			?>
				</ul>
				</div>
			</div>
			<?
		}
		$i++;
		
	}
	?>
		<div class="clear"></div>
			<div class="morerl_2">
				<?=$pagenav?>
			</div>
	<?
}

$db->sql_close();
?>
</body>