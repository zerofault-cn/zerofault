<link rel="stylesheet" href="style.css" type="text/css">
<?
include_once "mysql_connect.php";
include_once "functions.php";
addFriend();
function addFriend()
{
	global $HTTP_GET_VARS;
	$user_id=$HTTP_GET_VARS['user_id'];
	$sql1="select * from user_friend where user_id=".$_COOKIE['cookie_user_id']." and friend_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="select * from user_info where user_id=".$user_id." and user_permit=1";
	$result2=mysql_query($sql2);
	$sql3="insert into user_friend(user_id,friend_id,friend_addtime) values(".$_COOKIE['cookie_user_id'].",".$user_id.",NOW())";
	if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
	{
		errorMsg("����δ��¼,�������ѳ�ʱ,������<a href='?action=login1'>��¼</a>");
	}
	elseif($_COOKIE['cookie_user_id']==$user_id)
	{
		errorMsg("�����ܼ��Լ�Ϊ����!");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg("���Ѿ��������û�Ϊ������!");
	}
	elseif(mysql_fetch_array($result2))
	{
		errorMsg("���û���ֹ�����˼�Ϊ����!");
	}
	elseif(mysql_query($sql3))
	{
		okMsg("��ӳɹ�<br>������<a href='window.history.go(-1);'>����</a>,����<a href='javascript:window.close();'>�رմ���</a>");
	}
	else
	{
		errorMsg("ϵͳ���ݿ����!");
	}
}
?>