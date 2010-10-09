<?php
/**
*
* Absence系统
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class AbsenceAction extends BaseAction{

	protected $dao, $Absence_Config,$time;

	public function _initialize() {
		Session::set('top', 'Absence');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Absence');
		$this->time = time();
//		$this->time = mktime(0,0,0,8,23,2010);
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Absence');
		$this->Absence_Config = C('_absence_');
		$LeaveType = array();
		foreach($this->Absence_Config['leavetype'] as $key=>$val) {
			$rs = M('Options')->where(array('type'=>$key))->find();
			if (empty($rs)) {
				$LeaveType[$key] = $val;
			}
			else {
				$LeaveType[$key] = empty($rs['name']) ? $val : $rs['name'];
			}
		}
		$LeaveType['Overtime'] = 'Overtime';
		$LeaveType['Out'] ='Out of office';
		$this->assign('LeaveType', $LeaveType);
	}

	public function index() {
		$staff_info = D('Staff')->relation(true)->find($_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('staff_info', $staff_info);

		$where = array(
			'type' => array('in', array('Annual','CashOut')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1
			);
		$used_annual_hours = $this->dao->where($where)->sum('hours');
		$leave_info = array();
		$total_leave = 0;
		$leave_info['Annual_year'] = date('Y', $this->time);
		$leave_info['Balance_year'] = date('Y', $this->time)-1;
		if (strcmp($staff_info['onboard'], date('Y', $this->time).'-01-00')>0) {
			//当年入职的员工，从入职之日算起
			$added_annual_hour = round(($this->time-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);//每个月1.25天
			$total_leave = $added_annual_hour - $used_annual_hours;
			$leave_info['Annual'] = self::parseHour($added_annual_hour - $used_annual_hours);
			$leave_info['Balance'] = 'N/A';//往年余额
		}
		else {
			//当年之前入职的员工，从当年01-01算起
			$added_annual_hour = round(date('z', $this->time)*360/365/30*1.25*8);
			if (date('Y', $this->time)==2010) {
				//如果现在是2010年，则读取2009剩余年假，并减除已使用假期
				$balance_hour_2009 = max(0, round($staff_info['balance_2009']*8-$used_annual_hours));
				$total_leave += $balance_hour_2009;
				$leave_info['Balance'] = self::parseHour($balance_hour_2009);
				$leave_info['Annual'] =  self::parseHour($added_annual_hour - max(0, $used_annual_hours-round($staff_info['balance_2009']*8)));
				$total_leave += $added_annual_hour - max(0, $used_annual_hours-round($staff_info['balance_2009']*8));
			}
			else {
				//2011年或以后
				if (strcmp($staff_info['onboard'], '2010-01-00')>0) {
					//该员工在2010年后入职，则剩余年假从入职日起计算至去年结束
					$balance_hour = round((mktime(0,0,0,1,1,date('Y', $this->time))-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);
				}
				else {
					//该员工在2010年前入职，则用2009年剩余年假 ＋ 2010年到去年的整年假
					$balance_hour = round($staff_info['balance_2009']*8) + (date('Y', $this->time)-2010)*12*1.25*8;
				}
				$hour = max(0, $balance_hour-$used_annual_hours);
				$total_leave += $hour;
				$leave_info['Balance'] = self::parseHour($hour);
				$leave_info['Annual'] =  self::parseHour($added_annual_hour - max(0, $used_annual_hours-$balance_hour));
				$total_leave += $added_annual_hour - max(0, $used_annual_hours-$balance_hour);
			}
		}
		$this->assign('total_leave', self::parseHour($total_leave));

		$leave_info['CashOut'] = array();
		$where = array(
			'type' => 'CashOut',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1
			);
		$arr = array(
			'first_half' => array(
				array('egt', date('Y', $this->time).'-01-01'),
				array('lt', date('Y', $this->time).'-07-01')
				),
			'second_half' => array(
				array('egt', date('Y', $this->time).'-07-01'),
				array('lt', (date('Y', $this->time)+1).'-01-01')
				)
			);
		foreach ($arr as $key=>$val) {
			$where['create_time'] = $val;
			$hour = $this->dao->where($where)->sum('hours');
			$leave_info['CashOut'][$key] = self::parseHour($hour);
		}
		$leave_info['Compensatory'] = array();
		$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $this->time)-3, date('d', $this->time), date('Y', $this->time)));
		$where = array(
			'type'=> 'Compensatory',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_from' => array('egt', $date_3month_ago),
			'status' => 1
		);
		$last_apply_time = $this->dao->where($where)->max('time_from');
		$where['type'] = 'Overtime';
		if (!empty($last_apply_time)) {
			$where['time_from'] = array('egt', $last_apply_time);
			$hour = $this->dao->where($where)->sum('hours');
			$total_leave += $hour;
			$leave_info['Compensatory']['recent'] = self::parseHour($hour);
			$leave_info['Compensatory']['past'] = self::parseHour(0);
		}
		else {
			$where['time_from'] = array('egt', $date_3month_ago);
			$hour = $this->dao->where($where)->sum('hours');
			$total_leave += $hour;
			$leave_info['Compensatory']['recent'] = self::parseHour($hour);
			$where['time_from'] = array('lt', $date_3month_ago);
			$hour = $this->dao->where($where)->sum('hours');
			$leave_info['Compensatory']['past'] = self::parseHour($hour);
		}
		$this->assign('total_leave', self::parseHour($total_leave));
		$this->assign('leave_info', $leave_info);

		$where = array(
			'type' => 'Out',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			);
		$this->assign('out_list', $this->dao->relation(true)->where($where)->order('id desc')->select());

		$where = array(
			'type' => array('not in', array('Overtime', 'Out', 'CashOut')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_from' => array('egt', date('Y', $this->time).'-01-01')
			);
		$arr = array(
			'Waiting for Approval' => array('lt', 1),
			'Get Approved' => 1,
			'Rejected' => 2
			);
		$this->assign('label_status', $arr);
		$file_path = '../Attach/Absence/';
		$result = array();
		foreach ($arr as $key => $val) {
			$where['status'] = $val;
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			foreach ($rs as $i=>$item) {
				$rs[$i]['attachment_url'] = '';
				if (''==trim($item['attachment'])) {
					continue;
				}
				foreach (explode(';', $item['attachment']) as $j=>$file_name) {
					$rs[$i]['attachment_url'] .= '[<a href="'.$file_path.$file_name.'" target="_blank"> '.($j+1).' </a>] ';
				}
			}
			!empty($rs) && ($result[$key] = $rs);
		}
		$this->assign('apply_list', $result);

		$where = array(
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1,
			'time_from' => array(array('egt', date('Y', $this->time).'-01-01'), array('lt', (date('Y', $this->time)+1).'-01-01'))
			);
		$rs = $this->dao->where($where)->group('type')->getField("type,sum(hours)");
		$this->assign('absence_summary', $rs);

		$this->assign('ACTION_TITLE', 'My Absence');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$result = array();
		foreach($this->Absence_Config['leavetype'] as $key=>$val) {
			$rs = M('Options')->where(array('type'=>$key))->find();
			if (empty($rs)) {
				$result[$key] = array(
					'type' => $key,
					'name' => $val,
					'description' => ''
				);
			}
			else {
				$result[$key] = array(
					'type' => $key,
					'name' => empty($rs['name']) ? $val : $rs['name'],
					'description' => str_replace(array("'", "\r\n"), array("\'", "<br />"), $rs['description'])
					);
			}
		}
		$this->assign('LeaveType', $result);

		if (!empty($_REQUEST['type'])) {
			$this->assign('type', $_REQUEST['type']);
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			//edit form
			$info = $this->dao->relation(true)->find($id);
			$this->assign('info', $info);
		}
		else {
			//new form
			if (date('N', $this->time)>5 || (date('N', $this->time)==5 && strcmp(date('H:i', $this->time), $this->Absence_Config['worktime'][1][0])>=0)) {//周末，或周五下午
				$this->time += (8-date('N', $this->time))*86400;
				$date_from = date('Y-m-d', $this->time);
				$time_from = $this->Absence_Config['worktime'][0][0];
				$date_to = date('Y-m-d', $this->time);
				$time_to = $this->Absence_Config['worktime'][1][1];
			}
			else {
				if (strcmp(date('H:i', $this->time), $this->Absence_Config['worktime'][0][0])<0) {//上午上班前
					$date_from = date('Y-m-d', $this->time+86400);
					$time_from = $this->Absence_Config['worktime'][0][0];
					$date_to = date('Y-m-d', $this->time+86400);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
				elseif (strcmp(date('H:i', $this->time), $this->Absence_Config['worktime'][1][0])<0) {//下午上班前
					$date_from = date('Y-m-d', $this->time);
					$time_from = $this->Absence_Config['worktime'][1][0];
					$date_to = date('Y-m-d', $this->time);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
				else {//下午上班后
					$date_from = date('Y-m-d', $this->time+86400);
					$time_from = $this->Absence_Config['worktime'][0][0];
					$date_to = date('Y-m-d', $this->time+86400);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
			}
		}
		if (!empty($_REQUEST['type'])) {
			$this->assign('date_from', date('Y-m-d', $this->time-30*86400));
		}
		else {
			$this->assign('date_from', $date_from);
		}
		$this->assign('time_from', $time_from);
		$this->assign('date_to', $date_to);
		$this->assign('time_to', $time_to);

		$dept_staff_arr = array();
		$has_other = false;
		$rs = M('Staff')->where('status=1')->distinct(true)->field('dept_id')->select();
		foreach ($rs as $arr) {
			if (0==$arr['dept_id']) {
				$has_other = true;
				continue;
			}
			$dept = M('Department')->find($arr['dept_id']);
			$dept_staff_arr[$dept['name']] = M('Staff')->where(array('id'=>array('neq', $dept['leader_id']), 'dept_id'=>$dept['id'], 'status'=>1))->order('realname')->field('id,realname,email')->select();
			if ($dept['leader_id']>0) {
				array_unshift($dept_staff_arr[$dept['name']], M('Staff')->field('id,realname,email')->find($dept['leader_id']));
			}
		}
		ksort($dept_staff_arr);
		if ($has_other) {
			$dept_staff_arr['No Department'] = M('Staff')->where(array('dept_id'=>0, 'status'=>1))->order('realname')->field('id,realname,email')->select();
		}
		$this->assign('DeptStaff', $dept_staff_arr);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$type = $_REQUEST['type'];
		!$type && self::_error('Absense Type didn\'t select!');
		$staff_id = empty($_REQUEST['staff_id'])?$_SESSION[C('STAFF_AUTH_NAME')]['id']:$_REQUEST['staff_id'];

		$date_from = trim($_REQUEST['date_from']);
		$time_from = trim($_REQUEST['time_from']);
		$date_to = trim($_REQUEST['date_to']);
		$time_to = trim($_REQUEST['time_to']);
		if (false === strtotime($date_from.' '.$time_from.':00')) {
			self::_error('The begin date/time of the duration is not invalid!');
		}
		elseif (false === strtotime($date_to.' '.$time_to.':00')) {
			self::_error('The end date/time of the duration is not invalid!');
		}
		elseif (strcmp($date_from.$time_from, $date_to.$time_to)>=0) {
			self::_error('The end datetime must be later then the begin datetime!');
		}
		global $hour;
		$hour = 0;
		self::calculateHour($date_from, $time_from, $date_to, $time_to);
		echo 'applied hour:'.$hour."\n";
		$avaliable_hour = self::get_avaliable($type, $staff_id);
		echo 'avaliable hour:'.$avaliable_hour."\n";
		if ($hour<=0) {
			self::_error('The hours must be larger then 0!');
		}
		elseif ($hour>$avaliable_hour) {
			self::_error('You can\'t apply more then '.$avaliable_hour.' hours');
		}
		$deputy = $_REQUEST['deputy'];
		$file_path = 'Attach/Absence/';
		$file_arr = array();
		foreach ($_FILES['file']['size'] as $i=>$size) {
			if ($size>0) {
				$file_arr[] = array(
					'name' => $_FILES['file']['name'][$i],
					'tmp_name' => $_FILES['file']['tmp_name'][$i]
					);
			}
		}
		$note = trim($_REQUEST['note']);
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			//for edit
			$this->dao->find($id);
			$file_name = array();
			foreach ($file_arr as $i=>$file) {
				$file_name[$i] = date("YmdHis").substr(microtime(),1,7).'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
				if(!move_uploaded_file($file['tmp_name'], $file_path.$file_name[$i])) {
					self::_error('Attachment upload fail!');
				}
				$i++;
			}
			!empty($_REQUEST['new_attachment']) && ($this->dao->attachment = implode(';', $file_name));
		}
		else {
			//for add
			$file_name = array();
			foreach ($file_arr as $i=>$file) {
				$file_name[$i] = date("YmdHis").substr(microtime(),1,7).'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
				if(!move_uploaded_file($file['tmp_name'], $file_path.$file_name[$i])) {
					self::_error('Attachment upload fail!');
				}
				$i++;
			}
			$this->dao->attachment = implode(';', $file_name);
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->creator_id = $_SESSION[C('STAFF_AUTH_NAME')]['id'];
			if ($hour<=8) {
				$this->dao->status = 0;
			}
			elseif ($hour<=16) {
				$this->dao->status = -1;
			}
			else {
				$this->dao->status = -2;
			}
		}
		$this->dao->type = $type;
		$this->dao->staff_id = $staff_id;
		$this->dao->time_from = $date_from.' '.$time_from.':00';
		$this->dao->time_to = $date_to.' '.$time_to.':00';
		$this->dao->hours = $hour;
		$this->dao->deputy_id = $deputy;
		$this->dao->notification = '';
		$this->dao->note = $note;
		if($id>0) {
			if(false !== $this->dao->save()) {
//				self::mail_application($this->dao);//不允许员工编辑，因此不需要重发application
				self::_success('Application updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($ab_id = $this->dao->add()) {
				$this->dao->id = $ab_id;
				if ($type != 'Out') {
					self::mail_application($this->dao);
				}
				self::_success('Absence apply success!',__URL__);
			}
			else{
				self::_error('Absence apply fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function approve() {
		//approve for level_0
		$lead_staff_arr = M('Staff')->where(array('leader_id'=>$_SESSION[C('USER_AUTH_KEY')],'status'=>1))->getField('id,realname');
	//	$this->assign('staff', $lead_staff_arr);
		$where = array(
			'type' => array('neq', 'Out'),
			'staff_id' => array('in', implode(',', array_keys($lead_staff_arr))),
			'status' => array('lt', 1)
			);
		$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $row) {
			if ($row['hours'] <= 8) {
				if ($row['status'] == 0) {
					$result[] = $row;
				}
			}
			elseif ($row['hours'] <= 16) {
				if ($row['status'] == -1) {
					$result[] = $row;
				}
			}
			else {
				if ($row['status'] == -2) {
					$result[] = $row;
				}
			}
		}
		//approve for level_1
		list($name, $email) = each($this->Absence_Config['application']['level_1']['approver']);
		if ($_SESSION[C('STAFF_AUTH_NAME')]['email'] == $email) {
			$where = array(
				'type' => array('neq', 'Out'),
				'hours' => array(array('gt', 8), array('elt',16)),
				'status' => 0
				);
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			!empty($rs) && ($result = array_merge($result, $rs));
		}
		//approve for level_2
		list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
		if ($_SESSION[C('STAFF_AUTH_NAME')]['email'] == $email) {
			$where = array(
				'type' => array('neq', 'Out'),
				'hours' => array('gt', 16),
				'status' => -1
				);
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			!empty($rs) && ($result = array_merge($result, $rs));
		}
		list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
		if ($_SESSION[C('STAFF_AUTH_NAME')]['email'] == $email) {
			$where = array(
				'type' => array('neq', 'Out'),
				'hours' => array('gt', 16),
				'status' => 0
				);
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			!empty($rs) && ($result = array_merge($result, $rs));
		}

		$this->assign('result', $result);

		$this->assign('ACTION_TITLE', 'Staff Application');
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function confirm() {
		$id = $_REQUEST['id'];
		$status = intval($_REQUEST['status']);
		$comment = $_REQUEST['comment'];
		if (empty($id)) {
			return;
		}
		$info = $this->dao->find($id);
		if ($info['status']>=$status) {
			if (!empty($_REQUEST['from']) && 'mail'==$_REQUEST['from']) {
				exit('You have approved.');
			}
			else {
				self::_success('You have approved!','',1000);
			}
		}
		if (''!=trim($info['comment'])) {
			$comment = $info['comment']."\r\n--\r\n".$comment;
		}
		if (false !== $this->dao->where('id='.$id)->setField(array('approver_id','comment','status'), array($_SESSION[C('USER_AUTH_KEY')], $comment, $status))) {
			$this->dao->find($id);
			self::mail_application($this->dao);
			if (!empty($_REQUEST['from']) && 'mail'==$_REQUEST['from']) {
				exit('Operation success!');
			}
			else {
				self::_success('Operation success!','',1000);
			}
		}
		else {
			if (!empty($_REQUEST['from']) && 'mail'==$_REQUEST['from']) {
				exit('Operation fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
			else {
				self::_error('Operation fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}

	public function today() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$where = array(
			'status' => 1,
			'type' => array('not in', array('Overtime', 'CashOut')),
			'time_from' => array('lt', date('Y-m-d', $this->time+86400)),
			'time_to' => array('egt', date('Y-m-d', $this->time))
			);
		$rs = $this->dao->relation(true)->where($where)->select();
		$this->assign('result', $rs);

		$this->assign('ACTION_TITLE', 'Today\'s absence');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function history() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$where = array(
			'type' => array('not in', array('Overtime', 'CashOut')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_to' => array('lt', date('Y', $this->time).'-01-01')
			);
		$rs = $this->dao->relation(true)->where($where)->select();
				foreach ($rs as $i=>$item) {
			$rs[$i]['attachment_url'] = '';
			if (''==trim($item['attachment'])) {
				continue;
			}
			foreach (explode(';', $item['attachment']) as $j=>$file_name) {
				$rs[$i]['attachment_url'] .= '[<a href="'.$file_path.$file_name.'" target="_blank"> '.($j+1).' </a>] ';
			}
		}
		$this->assign('result', $rs);

		$this->assign('ACTION_TITLE', 'My absence history');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function manage() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	private function get_avaliable($type, $staff_id) {
		switch ($type) {
			case 'Annual':
				$staff_info = D('Staff')->find($staff_id);
				$where = array(
					'type' => array('in', array('Annual','CashOut')),
					'staff_id' => $staff_id,
					'status' => 1
					);
				$used_annual_hours = $this->dao->where($where)->sum('hours');
				$total_leave = 0;
				if (strcmp($staff_info['onboard'], date('Y', $this->time).'-01-00')>0) {
					//当年入职的员工，从入职之日算起
					$added_annual_hour = round(($this->time-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);//每个月1.25天
					$total_leave = $added_annual_hour - $used_annual_hours;
				}
				else {
					//当年之前入职的员工，从当年01-01算起
					$added_annual_hour = round(date('z', $this->time)*360/365/30*1.25*8);
					if (date('Y', $this->time)==2010) {
						//如果现在是2010年，则读取2009剩余年假，并减除已使用假期
						$balance_hour_2009 = max(0, round($staff_info['balance_2009']*8-$used_annual_hours));
						$total_leave += $balance_hour_2009;
						$total_leave += $added_annual_hour - max(0, $used_annual_hours-round($staff_info['balance_2009']*8));
					}
					else {
						//2011年或以后
						if (strcmp($staff_info['onboard'], '2010-01-00')>0) {
							//该员工在2010年后入职，则剩余年假从入职日起计算至去年结束
							$balance_hour = round((mktime(0,0,0,1,1,date('Y', $this->time))-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);
						}
						else {
							//该员工在2010年前入职，则用2009年剩余年假 ＋ 2010年到去年的整年假
							$balance_hour = round($staff_info['balance_2009']*8) + (date('Y', $this->time)-2010)*12*1.25*8;
						}
						$hour = max(0, $balance_hour-$used_annual_hours);
						$total_leave += $hour;
						$total_leave += $added_annual_hour - max(0, $used_annual_hours-$balance_hour);
					}
				}
				break;
			case 'Compensatory':
				$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $this->time)-3, date('d', $this->time), date('Y', $this->time)));
				$where = array(
					'type'=> 'Compensatory',
					'staff_id' => $staff_id,
					'time_from' => array('egt', $date_3month_ago),
					'status' => 1
					);
				$last_apply_time = $this->dao->where($where)->max('time_from');
				$where['type'] = 'Overtime';
				if (!empty($last_apply_time)) {
					$where['time_from'] = array('egt', $last_apply_time);
				}
				$total_leave = intval($this->dao->where($where)->sum('hours'));
				break;
			default:
				$total_leave = 999999;
		}
		return $total_leave;
	}
	private function parseHour($hour) {
		if (empty($hour)) {
			return '0 day';
		}
		$unit1 = ' hour';
		if ($hour>1) {
			$unit1 = ' hours';
		}
		$day = round($hour/8, 2);
		$unit2 = ' day';
		if ($day>1) {
			$unit2 = ' days';
		}
		return round($hour).$unit1.' ('.$day.$unit2.')';
	}
	private function calculateHour($date_from, $time_from, $date_to, $time_to) {
		global $hour;
		$from = $date_from.' '.$time_from;
		$stamp_from = strtotime($from);
		if (date('N', $stamp_from)>5) {
			$date_from = date('Y-m-d', $stamp_from+86400*(8-date('N', $stamp_from)));
			$time_from = $this->Absence_Config['worktime'][0][0];
			$from = $date_from.' '.$time_from;
		}
		echo $from."\n";
		$to = $date_to.' '.$time_to;
		$stamp_to = strtotime($to);
		if (date('N', $stamp_to)>5) {
			$date_to = date('Y-m-d', $stamp_to-86400*(date('N', $stamp_to)-5));
			$time_to = $this->Absence_Config['worktime'][1][1];
			$to = $date_to.' '.$time_to;
		}
		echo $to."\n";
		if (strcmp($from, $to)>=0) {
			return;
		}
		$Time_SP = array(
			$date_from.' 00:00',//0
			$date_from.' '.$this->Absence_Config['worktime'][0][0],//1
			$date_from.' '.$this->Absence_Config['worktime'][0][1],//2
			$date_from.' '.$this->Absence_Config['worktime'][1][0],//3
			$date_from.' '.$this->Absence_Config['worktime'][1][1],//4
			$date_from.' 24:00'
		);
		foreach ($Time_SP as $i=>$sp) {
			if (strcmp($from, $sp)>=0 && strcmp($from, $Time_SP[$i+1])<0) {
				break;
			}
		}
		switch($i) {
			case 0:
				$time_from = $this->Absence_Config['worktime'][0][0];
				if (strcmp($to, $date_from.' '.$time_from)<=0) {
					return;
				}
				else {
					self::calculateHour($date_from, $time_from, $date_to, $time_to);
				}
				break;
			case 1:
				if (strcmp($to, $date_from.' '.$this->Absence_Config['worktime'][0][1])<=0) {
					//09:01~11:00
					$hour += (strtotime($to) - strtotime($date_from.' '.$time_from))/3600;
					return;
				}
				else {
					$hour += (strtotime($date_from.' '.$this->Absence_Config['worktime'][0][1]) - strtotime($date_from.' '.$time_from))/3600;
					$time_from = $this->Absence_Config['worktime'][1][0];
					self::calculateHour($date_from, $time_from, $date_to, $time_to);
				}
				break;
			case 2:
				$time_from = $this->Absence_Config['worktime'][1][0];
				if (strcmp($to, $date_from.' '.$time_from)<=0) {
					return;
				}
				else {
					self::calculateHour($date_from, $time_from, $date_to, $time_to);
				}
				break;
			case 3:
				if (strcmp($to, $date_from.' '.$this->Absence_Config['worktime'][1][1])<=0) {
					//13:01~14:00
					$hour += (strtotime($to) - strtotime($date_from.' '.$time_from))/3600;
					return;
				}
				else {
					$hour += (strtotime($date_from.' '.$this->Absence_Config['worktime'][1][1]) - strtotime($date_from.' '.$time_from))/3600;
					$date_from = date('Y-m-d', strtotime($date_from)+86400);
					$time_from = $this->Absence_Config['worktime'][0][0];
					self::calculateHour($date_from, $time_from, $date_to, $time_to);
				}
				break;
			case 4:
				$date_from = date('Y-m-d', strtotime($date_from)+86400);
				$time_from = $this->Absence_Config['worktime'][0][0];
				if (strcmp($to, $date_from.' '.$time_from)<=0) {
					return;
				}
				else {
					self::calculateHour($date_from, $time_from, $date_to, $time_to);
				}
				break;
		}
	}
	private function mail_application($dao) {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}

		$smtp_config = C('_smtp_');
		include_once (LIB_PATH.'class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
	//	$mail->SMTPDebug  = 1;  // 2 = messages only
		$mail->Host       = $smtp_config['host'];
		$mail->Port       = $smtp_config['port'];
		$mail->SetFrom($smtp_config['from_mail'], $smtp_config['from_name']);

		/*
		day<=1			Supervisor					Matty+Tracy+ Bin 
		1< day <= 2		Supervisor->Bin				Matty+Tracy+Yingnan
		day > 2			Supervisor->Bin->Yingnan	Matty+Tracy
		*/
		//get staff info
		$staff = M('Staff')->find($dao->staff_id);
		if ($dao->staff_id != $dao->creator_id) {
			$creator = M('Staff')->find($dao->creator_id);
		}
		else {
			$creator = $staff;
		}
		if(!empty($dao->deputy_id)) {
			$deputy = M('Staff')->find($dao->deputy_id);
		}
		if ($dao->status < 1) {
			//get leader info
			if (!empty($staff['leader_id'])) {
				$leader = M('Staff')->find($staff['leader_id']);
				if (''==$leader['email']) {
					$leader = array(
					//	'email' => 'bin.li@agigatech.com',
						'email' => 'mzhu@agigatech.com',
						'realname' => 'Bin.Li'
					);
				}
			}
			else {
				$leader = array(
				//	'email' => 'bin.li@agigatech.com',
					'email' => 'mzhu@agigatech.com',
					'realname' => 'Bin.Li'
				);
			}
		}

		if ($dao->hours <= 8) {
			if ($dao->status == 0) {
				$mail->AddAddress($leader['email'], $leader['realname']);
				$new_status = 1;
			}
			elseif ($dao->status == 1) {
				$mail->AddAddress($staff['email'], $staff['realname']);
				if (!empty($deputy)) {
					$mail->AddCC($deputy['email'], $deputy['realname']);
				}
				foreach ($this->Absence_Config['application']['level_0']['cc'] as $name=>$email) {
					$mail->AddCC($email, $name);
				}
			}
			elseif ($dao->status == 2) {
				$mail->AddAddress($staff['email'], $staff['realname']);
			}
		}
		elseif ($dao->hours <= 16) {
			if ($dao->status == -1) {
				$mail->AddAddress($leader['email'], $leader['realname']);
				$new_status = 0;
			}
			elseif ($dao->status == 0) {
				list($name, $email) = each($this->Absence_Config['application']['level_1']['approver']);
				$mail->AddAddress($email, $name);
				$new_status = 1;
			}
			elseif ($dao->status == 1) {
				$mail->AddAddress($staff['email'], $staff['realname']);
				if (!empty($deputy)) {
					$mail->AddCC($deputy['email'], $deputy['realname']);
				}
				foreach ($this->Absence_Config['application']['level_1']['cc'] as $name=>$email) {
					$mail->AddCC($email, $name);
				}
			}
			elseif ($dao->status == 2) {
				$mail->AddAddress($staff['email'], $staff['realname']);
			}
		}
		else {
			if ($dao->status == -2) {
				$mail->AddAddress($leader['email'], $leader['realname']);
				$new_status = -1;
			}
			elseif ($dao->status == -1) {
				list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
				$mail->AddAddress($email, $name);
				$new_status = 0;
			}
			elseif ($dao->status == 0) {
				list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
				list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
				$mail->AddAddress($email, $name);
				$new_status = 1;
			}
			elseif ($dao->status == 1) {
				$mail->AddAddress($staff['email'], $staff['realname']);
				if (!empty($deputy)) {
					$mail->AddCC($deputy['email'], $deputy['realname']);
				}
				foreach ($this->Absence_Config['application']['level_2']['cc'] as $name=>$email) {
					$mail->AddCC($email, $name);
				}
			}
			elseif ($dao->status == 2) {
				$mail->AddAddress($staff['email'], $staff['realname']);
			}
		}
		if ($dao->status < 1) {
			$subject = '[Absence]Application: '.$staff['realname'].' apply for leave, '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
		}
		elseif ($dao->status == 1) {
			$subject = '[Absence]Notification: '.$staff['realname'].', your application is approved.';
		}
		elseif ($dao->status == 2) {
			$subject = '[Absence]Notification: '.$staff['realname'].', your application is rejected.';
		}
		$mail->Subject    = $subject;
		
		$body = '';
		$body  = '<form name="_form" id="_form" action="'.APP_ROOT.'/Public/absence_confirm" method="post" target="_blank">';
		$body .= '<input type="hidden" name="id" value="'.$dao->id.'" />';
		$body .= '<input type="hidden" name="status" value="'.$new_status.'" />';
		$body .= '<input type="hidden" name="from" value="mail" />';
		$body .= '<table width="700" border="0" cellspacing="1" cellpadding="7" bgcolor="#CCCCCC">';
		if ('Out'==$dao->type) {
			$body .= '<tr><td colspan="2">'.$staff['realname'].' made an out of office request.</td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td width="177">Creator :</td><td width="492">'.$creator['realname'].'</td></tr>';
		}
		else {
			$body .= '<tr><td colspan="2">'.$staff['realname'].' will be absent on '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td width="177">Applicant :</td><td width="492">'.$creator['realname'].'</td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td>Type : </td><td>'.$dao->type.' leave</td></tr>';
		}
		$body .= '<tr bgcolor="#FFFFFF"><td>Duration : </td><td>'.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
		if ('Out'==$dao->type) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Members : </td><td>'.$staff['realname'].'</td></tr>';
		}
		elseif(!empty($dao->deputy_id)) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Deputy : </td><td>'.$deputy['realname'].'</td></tr>';
		}
		if (''!=$dao->note) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Note :</td><td>'.nl2br($dao->note).'</td></tr>';
		}
		if ($dao->status < 1) {
		//	$body .= '<tr bgcolor="#FFFFFF"><td colspan="2">Please approve the application in our <a target="_blank" href="'.APP_ROOT.'/Absence/approve">ERP System</a></td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td>Comment :</td><td><textarea name="comment" cols="40" rows="4"></textarea></td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td>Operation :</td><td><input type="submit" value="Approve" /><br />You can also do the operation in our <a target="_blank" href="'.APP_ROOT.'/Absence/approve">ERP System</a></td></tr>';
		}
		else {
			$body .= '<tr bgcolor="#FFFFFF"><td>Comment :</td><td>'.nl2br($dao->comment).'</td></tr>';
		}
		$body .= '</table>';
		$body .= '</form>';

		$mail->MsgHTML($body);
		if(!$mail->Send()) {
		//	echo "Mailer Error: " . $mail->ErrorInfo;
			Log::Write('Mail Error '.$mail->ErrorInfo);
			return false;
		}
		return true;
	}
	public function notify(){
		$where = array(
			'mail_status' => 0,
			'status' => 1,
			'type' => array('not in', array('Out','Overtime', 'CashOut')),
			'time_from' => array('lt', date('Y-m-d', $this->time+86400)),
			'time_to' => array('egt', date('Y-m-d', $this->time))
			);
		$rs = $this->dao->relation(true)->where($where)->select();
		if (empty($rs)) {
			echo 'No absence to notify';
			return;
		}
		echo 'Get '.count($rs)." records.<br />\n";
		foreach ($rs as $item) {
			echo "\tFor ID:".$item['id']."\t";
			$this->dao->find($item['id']);
			if (self::mail_application($this->dao)) {
				if(false !== $this->dao->setField('mail_status',1)) {
					echo "Success!<br />\n";
					Log::Write('Notify '.$item['staff']['email'].' success', INFO);
				}
				else{
					echo 'SQL error'.(C('APP_DEBUG')?$this->dao->getLastSql():'');
				}
			}
		}
	}

	/**
	*
	* 调用基类方法
	*/
	public function update(){
		parent::_update();
	}
	public function delete() {
		self::_delete();
	}
}
?>