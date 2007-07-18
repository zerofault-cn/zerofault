<?php
//系统管理用
//设置投票时间段，根据不同时间段，读写不同的数据表
if(time()<mktime(14,0,0,9,11,2007))//海选投票日期
{
	$sms_table="poll_sms1";
	$ip_table="poll_ip";
}
elseif(mktime(14,0,0,9,11,2007)<time() && time()<mktime(14,0,0,10,11,2007))//复赛投票期
{
	$sms_table="poll_sms2";
	$ip_table="poll_ip";
}
elseif(mktime(14,0,0,10,11,2007)<time())//决赛投票期
{
	$sms_table="poll_sms3";
	$ip_table="poll_ip";
}
else
{
	echo '现在不是投票期，详情请查看<a href="http://nurse.bokee.com/gonggao.shtml" target="_blank">大赛公告</a>';
	exit;
}
?>