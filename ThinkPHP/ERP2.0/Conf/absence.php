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
	'CashOutMonth' => array(2,8), //Cash out的月份，纯数字数组，默认2月和8月

	'worktime' => array( //工作时间区间
		array('09:00','12:00'),
		array('13:00', '18:00')
		),

	'application' => array( //请假申请时，需发给哪些人审批，以及默认抄送地址
		'level_0' => array( //请假时间小于等于1天
			'approver' => array(
				),
			'cc' => array(
				'Tracy'=>'jali@agigatech.com',
				'Matty'=>'fan@agigatech.com',
				'Bin' => 'bin.li@agigatech.com'
				)
			),
		'level_1' => array( //请假时间大于1天，小于等于2天
			'approver' => array(
				'Bin' => 'bin.li@agigatech.com',//'mzhu@agigatech.com',//
				),
			'cc' => array(
				'Tracy' => 'jali@agigatech.com',
				'Matty' => 'fan@agigatech.com',
				'Yingnan' => 'li@agigatech.com'
				)
			),
		'level_2' => array( //请假时间大于2天
			'approver' => array(
				'Bin' => 'bin.li@agigatech.com',//'mzhu@agigatech.com',//
				'Yingnan' => 'li@agigatech.com',//'mzhu@agigatech.com',//
				),
			'cc' => array(
				'Tracy'=>'jali@agigatech.com',
				'Matty'=>'fan@agigatech.com'
				)
			)
		)
	);
?>