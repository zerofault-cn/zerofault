<?php
//����ͶƱʱ��Σ����ݲ�ͬʱ��Σ���д��ͬ�����ݱ�
if(mktime(14,0,0,1,18,2007)<time() && time()<mktime(14,0,0,4,18,2007))//��ѡͶƱ����
{
	$sms_table="poll_sms1";
	$ip_table="poll_ip1";
}
elseif(mktime(14,0,0,4,18,2007)<time() && time()<mktime(14,0,0,5,18,2007))//����ͶƱ��
{
	$sms_table="poll_sms2";
	$ip_table="poll_ip2";
}
elseif(mktime(14,0,0,5,18,2007)<time())//����ͶƱ��
{
	$sms_table="poll_sms3";
	$ip_table="poll_ip3";
}
else
{
	echo 'ͶƱ���Ѿ����������Ѿ����ڣ�������鿴<a href="http://mm.bokee.com/2007/gonggao.shtml" target="_blank">��������</a>';
	exit;
}
?>