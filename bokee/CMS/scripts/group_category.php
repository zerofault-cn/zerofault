<?php
$conn=mysql_connect('221.238.254.187','cms','zmCMS0522') or die("connect error");
mysql_select_db('groupinfo',$conn);

$sort=array();
$sort[1][0]='文学艺术';
$sort[1][1]='wenxueyishu/';
$sort[2][0]='生活';
$sort[2][1]='shenghuo/';
$sort[3][0]='娱乐明星';
$sort[3][1]='yulemingxing/';
$sort[4][0]='时尚';
$sort[4][1]='shishang/';
$sort[5][0]='体育健身';
$sort[5][1]='tiyujianshen/';
$sort[6][0]='休闲情趣';
$sort[6][1]='xiuxianqingqu/';
$sort[7][0]='两性情感';
$sort[7][1]='liangxingqinggan/';
$sort[8][0]='科技数码';
$sort[8][1]='shumakeji/';
$sort[9][0]='旅游地区';
$sort[9][1]='lvyoudiqu/';
$sort[10][0]='财经职场';
$sort[10][1]='caijingzhichang/';
$sort[11][0]='教育校园';
$sort[11][1]='jiaoyuxiaoyuan/';
$sort[12][0]='汽车房产';
$sort[12][1]='qichefangchan/';
$sort[13][0]='时代人生';
$sort[13][1]='shidairensheng/';
$sort[14][0]='品牌';
$sort[14][1]='pinpai/';
$sort[20][0]='其他';
$sort[20][1]='qita/';


$sql = "select * from sort";
$result=mysql_query($sql);
while($r=mysql_fetch_array($result))
{
	$sortid=$r['sortId'];
	$sql2="select * from groupinfo where sortId=".$sortid." and memberNum>=200 order by memberNum desc";
	$result2=mysql_query($sql2);
	if(mysql_num_rows($result2)==0)
	{
		continue;
	}
	?>
	<div id="gamelist_title"><span style="float:left;"><a class="STYLE20" href="<?=$sort[$sortid][1]?>" target="_blank" ><?=conv($r['sortName'])?></a></span></div>
	<div class="gamelist_content"> 
		<table cellSpacing=0 cellPadding=0 align=center border=0 width="100%">
		<tr>
			<td width="100%" style="padding:10px;word-break:keep-all;">
	<?
	while($r2=mysql_fetch_array($result2))
	{
			?>
			<a class="STYLE19" href="http://group.bokee.com/<?=$r2['groupDomain']?>"> <?=conv($r2['groupName'])?></a> 
			<?
	}
	?>
			<a class="STYLE19" href="<?=$sort[$sortid][1]?>"><font color=red>更多&gt;&gt;</font></a>
			</td>
		</tr>
		</table>
	</div>
	<div class="space2"></div>
	<?
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>
