<?
include_once "admin_limit.php";
//print_r($HTTP_POST_VARS);
$cache_profile="../include/html_need_update.ini";
$fp=fopen($cache_profile,"r+");
while($buffer=trim(fgets($fp,4096)))
{
	if(substr($buffer,0,1)=='[')
	{
		continue;
	}
	else
	{
		$php_file=substr($buffer,0,strpos($buffer,'.'));//ȡ�ò�����׺���ļ���
		$flag='flag_'.$php_file;
		if(isset($$flag) && $$flag==1)
		{
			fseek($fp,ftell($fp)-3);
			$fw=fwrite($fp,"1\r\n");
			exec('rm -f ../800/html_cache/'.$php_file.'*');
		}
		else
		{
			fseek($fp,ftell($fp)-3);
			$fw=fwrite($fp,"0\r\n");
		}
	}
}
if($fw && fclose($fp))
{
	?>
	<script>
		alert("�޸ĳɹ���")
		window.location="index.php?content=cache_update_1";
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������,���߱������Ա");
		window.history.go(-1);
	</script>
	<?
}
?>