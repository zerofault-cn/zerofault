<?
@session_start();
$index_file="index.txt";//��¼������Ϣ�ļ����ļ���
$msgDir="data/";//����������Ϣ�ļ���Ŀ¼
$msgFileExt=".txt";//�趨�ļ���չ��
$pageitem=5;//�趨ÿҳ��ʾ������

//�趨����Ա�û�������
$adminArr[0][0]='admin';
$adminArr[0][1]='nimda';
$adminArr[1][0]='wxh';
$adminArr[1][1]='wxh';

if(''!=$_SESSION['boardadmin'])
{
	$echoEmail=1;//�趨��ʾemail
}
?>