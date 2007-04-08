<?php
//设置投票时间段，根据不同时间段，读写不同的数据表
if(mktime(14,0,0,1,18,2007)<time() && time()<mktime(14,0,0,4,12,2007))//海选投票日期
{
	$sms_table="poll_sms1";
	$ip_table="poll_ip1";
}
elseif(mktime(14,0,0,4,18,2007)<time() && time()<mktime(14,0,0,5,16,2007))//复赛投票期
{
	$sms_table="poll_sms2";
	$ip_table="poll_ip2";
}
elseif(mktime(14,0,0,5,18,2007)<time() && time()<mktime(14,0,0,6,17,2007))//决赛投票期
{
	$sms_table="poll_sms3";
	$ip_table="poll_ip3";
}
else
{
	echo '现在不是投票期，详情请查看大赛公告';
	exit;
}
?>