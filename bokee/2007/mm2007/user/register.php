<?
define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$phone=$_REQUEST['phone'];
$passwd=$_REQUEST['passwd'];
$re_passwd=$_REQUEST['re_passwd'];
$mm_id=$_REQUEST['mm_id'];

if(''!=$_REQUEST['submit'] && $passwd==$re_passwd)
{
	//�ȼ����ֻ����Ƿ��Ѿ���ĳ��MMͶ��Ʊ
	$sql1="select count(*) from poll_sms1 where mm_id=".$mm_id." and status=1 and phone='".$phone."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_fetchfield(0,0,$result1)>0)//��ͶƱ
	{
		//�ټ����ֻ��Ż�û���û�ע��
		$sql2="select count(*) from user_phone where phone='".$phone."'";
		$result2=$db->sql_query($sql2);
		if($db->sql_fetchfield(0,0,$result2)>0)//��ע��
		{
			echo $phone.'��ע��';
		}
		else
		{
			//����ֻ����û���
			$sql3="insert into poll_user set phone='".$phone."',passwd='".md5($passwd)."'";
			if($db->sql_query($sql3))
			{
				$uid=$db->sql_nextid();
				$sql4="insert into user_phone set uid=".$uid.",phone='".$phone."'";
				if($db->sql_query($sql4))
				{
					echo 'ע��ok,�û�ID��'.$uid;
				}
			}
		}
	}
	else
	{
		echo $phone.'��δͶ��Ʊ';
		echo "<br>���ߣ�";
		echo $phone.'δ��'.$mm_id.'Ͷ��Ʊ';
	}
}
else
{
	?>
<form action="" method="post" name="form1">
�ֻ��ţ�<input type="text" name="phone"><br>
���룺<input type="password" name="passwd"><br>
����ȷ�ϣ�<input type="password" name="re_passwd"><br>
���ֻ���ͶƱ����Ů����ID��<input type="text" name="mm_id"><br>
<input type="submit" name="submit" value="�ύ">
</form>
	<?
}
?>