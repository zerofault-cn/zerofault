<!-- �޸ĸ�����Ϣ -->
<?
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="update singer_info set singer_name='".$singer_name."',singer_name_fc='".strtoupper($singer_name_fc)."',type_area_id=".$type_area_id.",type_chorus_id=".$type_chorus_id.",type_other_id=".$type_other_id.",introduce='".$introduce."' where singer_id=".$singer_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("�޸ĳɹ�!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("�޸�ʧ��,��������");
		window.history.go(-1);
	</script>
	<?
}
?>