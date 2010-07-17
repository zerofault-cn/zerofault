<?php
return array(
	'LeaveType' => array( //系统支持的假期类型，键名为关键字，键值仅用于理解，不被使用
		'Annual' => '年假',
		'Compensatory' => '补休',
		'Sick' => '病假',
		'Personal' => '事假',
		'Marriage' => '婚假',
		'Maternity' => '产假',
		'Antenatal' => '产前检查假',
		'Paternity' => '陪产假',
		'Bereavement' => '丧假'
		),
	'CashOutMonth' => array(2,8), //Cash out的月份，纯数字数组
	'worktime' => array(array('09:00','12:00'), array('13:00', '18:00')),
	'notification' => array('Tracy'=>'jali@agigatech.com', 'Matty'=>'fan@agigatech.com')
	);
?>