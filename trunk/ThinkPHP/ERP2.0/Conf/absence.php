<?php
return array(
	'LeaveType' => array( //系统支持的假期类型，键名为关键字，后面的中文仅用于识别，不被使用
		'Annual'		=> '年假',
		'Compensatory'	=> '补休',
		'Sick'			=> '病假',
		'Personal'		=> '事假',
		'Marriage'		=> '婚假',
		'Maternity'		=> '产假',
		'Antenatal'		=> '产前检查假',
		'Paternity'		=> '陪产假',
		'Bereavement'	=> '丧假'
		),

	'CashoutMonth' => array(2,12), //Cash out的月份，纯数字数组，默认2月和8月

	'ReservedHours' => 40, //Cash out最少保留小时数，默认40小时（5天）

	'worktime' => array( //工作时间区间
		array('09:00','12:00'),
		array('13:00', '18:00')
		),
	
	'workday' => array( //法定工作日，即原本是周末，被调为上班
		'2011-01-30', '2011-02-12'
		),
	'holiday' => array( //法定休息日，即原本是工作日，被调为休假
		'2011-02-02', '2011-02-03', '2011-02-04', '2011-02-07', '2011-02-08'
		),
	'notification' => array( //即时通知邮件的cc list，不论请假多少天，不论审批或拒绝
		'BINL' => 'bin.li@agigatech.com',
		'JALI' => 'jali@agigatech.com',
		'JFAN' => 'fan@agigatech.com'
		),

	'application' => array( //请假申请时，需发给哪些人审批，以及默认抄送地址
		'level_0' => array( //请假时间小于等于1天
			'approver' => array( //除Leader外的固定审批人
				),
			'cc' => array( //在休假当天需通知的除相关Staff以外的人员，注意键名必须与ERP系统对应一致，并用大写
				'BINL' => 'bin.li@agigatech.com',
				'JALI' => 'jali@agigatech.com',
				'JFAN' => 'fan@agigatech.com'
				)
			),
		'level_1' => array( //请假时间大于1天，小于等于2天
			'approver' => array(
				'BINL' => 'bin.li@agigatech.com',
				),
			'cc' => array(
				'NLIU' => 'li@agigatech.com',
				'JALI' => 'jali@agigatech.com',
				'JFAN' => 'fan@agigatech.com'
				)
			),
		'level_2' => array( //请假时间大于2天
			'approver' => array(
				'BINL' => 'bin.li@agigatech.com',
				'NLIU' => 'li@agigatech.com',
				),
			'cc' => array(
				'JALI' => 'jali@agigatech.com',
				'JFAN' => 'fan@agigatech.com'
				)
			)
		)
	);
?>