<!-- ͳ������ת�Ƶ��±� -->
<?
include_once "../include/mysql_connect.php";
//ȡδ������Ϣ��־λ��Ӧ���������
$sql1= "select feeinfo_id from fee_info where compute_flag=1";
$result1= mysql_query($sql1);
$id_start= mysql_result($result1,0,0);

//ȡ�������������ֵ
$sql2= "select max(feeinfo_id) from fee_info";
$result2= mysql_query($sql2);
$id_max=mysql_result($result2,0,0);
 
//������ת����Ϣ
$sql3="select user_account,prog_path,fee_begindate,fee_begintime,client_addr from fee_info where fee_flux=0 and feeinfo_id>'".$id_start."' group by user_account,prog_path,fee_begindate,fee_begintime,client_addr";
$result3= mysql_query($sql3);
while($r=mysql_fetch_array($result3))
{
	$sql4= "insert into movie_statistic(user_account,prog_path,point_date,point_time,client_addr) values ('".$r[0]."','".$r[1]."','".$r[2]."','".$r[3]."','".$r[4]."')";
	mysql_query($sql4);
}
 
//ԭ��־λ����
$sql5= "update fee_info set compute_flag=0 where feeinfo_id='".$id_start."'";
mysql_query($sql5);
 
//�����±�־λ
$sql7= "update fee_info set compute_flag=1 where feeinfo_id='".$id_max."'";
mysql_query($sql7);
?>