<?php
//ϵͳ������
//����ͶƱʱ��Σ����ݲ�ͬʱ��Σ���д��ͬ�����ݱ�
if(time()<mktime(14,0,0,9,11,2007))//��ѡͶƱ����
{
	$sms_table="poll_sms1";
	$ip_table="poll_ip";
}
elseif(mktime(14,0,0,9,11,2007)<time() && time()<mktime(14,0,0,10,11,2007))//����ͶƱ��
{
	$sms_table="poll_sms2";
	$ip_table="poll_ip";
}
elseif(mktime(14,0,0,10,11,2007)<time())//����ͶƱ��
{
	$sms_table="poll_sms3";
	$ip_table="poll_ip";
}
else
{
	echo '���ڲ���ͶƱ�ڣ�������鿴<a href="http://nurse.bokee.com/gonggao.shtml" target="_blank">��������</a>';
	exit;
}
?>