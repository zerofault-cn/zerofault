<?php
header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=shop_".date("YmdHis").".csv");

mysql_connect('localhost', 'root', '');
mysql_select_db('test');

$month_arr = array('2010-10', '2010-11', '2010-12');

$sql = "select code,group_concat(distinct name) as names from shop group by code";
$rs = mysql_query($sql);
$i = 0;
echo "序号,商户代码,商户名称,10月金额,10月笔数,10月分润,11月金额,11月笔数,11月分润,12月金额,12月笔数,12月分润,10-12平均金额,10-12平均笔数,10-12平均分润,1月金额,1月笔数,1月分润,11-1月平均金额,11-1月平均笔数,11-1月平均分润,2月金额,2月笔数,2月分润,商户类型\r\n";
while($row = mysql_fetch_array($rs)) {
	$i++;
	$code = $row['code'];
	$names = $row['names'];
	$name_arr = explode(',', $names);
	$name = '';
	foreach ($name_arr as $val) {
		if (strlen(trim($val)) > strlen($name)) {
			$name = trim($val);
		}
	}
	
	$money = $count = $split = array();
	foreach ($month_arr as $month) {
		$sql2 = "select money,count,split from shop where code='".$code."' and month='".$month."'";
		$rs2 = mysql_query($sql2);
		while ($row2 = mysql_fetch_array($rs2)) {
			$money[$month] = $row2['money'];
			$count[$month] = $row2['count'];
			$split[$month] = $row2['split'];
		}
	}

	echo $i.",";
	echo "'".$code .',';
	echo $name .",";
	echo $money['2010-10'].",";
	echo $count['2010-10'].",";
	echo $split['2010-10'].",";

	echo $money['2010-11'].",";
	echo $count['2010-11'].",";
	echo $split['2010-11'].",";

	echo $money['2010-12'].",";
	echo $count['2010-12'].",";
	echo $split['2010-12'].",";

	echo round(array_sum($money)/max(1, count($money)), 2).",";
	echo round(array_sum($count)/max(1, count($count)), 1).",";
	echo round(array_sum($split)/max(1, count($split)), 2).",";

	unset($money['2010-10']);
	unset($count['2010-10']);
	unset($split['2010-10']);

	$month = '2011-01';
	$sql2 = "select money,count,split from shop where code='".$code."' and month='".$month."'";
	$rs2 = mysql_query($sql2);
	while ($row2 = mysql_fetch_array($rs2)) {
		$money[$month] = $row2['money'];
		$count[$month] = $row2['count'];
		$split[$month] = $row2['split'];
	}
	echo $money['2011-01'].",";
	echo $count['2011-01'].",";
	echo $split['2011-01'].",";

	echo round(array_sum($money)/max(1, count($money)), 2).",";
	echo round(array_sum($count)/max(1, count($count)), 1).",";
	echo round(array_sum($split)/max(1, count($split)), 2).",";

	$month = '2011-02';
	$sql2 = "select money,count,split from shop where code='".$code."' and month='".$month."'";
	$rs2 = mysql_query($sql2);
	while ($row2 = mysql_fetch_array($rs2)) {
		$money[$month] = $row2['money'];
		$count[$month] = $row2['count'];
		$split[$month] = $row2['split'];
	}
	echo $money['2011-02'].",";
	echo $count['2011-02'].",";
	echo $split['2011-02'].",";

	$type = '';
	$sql3 = "select type from shop where type!='' and code='".$code."' limit 1";
	$rs3 = mysql_query($sql3);
	if (mysql_num_rows($rs3)>0) {
		$type = mysql_result($rs3, 0, 0);
	}
	echo trim($type);

	echo "\r\n";

	if ($i>6) {
//		break;
	}
}
?>
