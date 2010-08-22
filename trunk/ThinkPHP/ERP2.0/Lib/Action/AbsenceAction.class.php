<?php
/**
*
* Absence系统
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class AbsenceAction extends BaseAction{

	protected $dao, $Absence_Config;

	public function _initialize() {
		Session::set('top', 'Absence');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Absence');
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
		$this->assign('LeaveType', $LeaveType);
	}

	public function index() {
		$time = time();
	//	$time = mktime(0,0,0,8,31,2011);//for test
		$staff_info = D('Staff')->relation(true)->find($_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('staff_info', $staff_info);

		$where = array(
			'type' => 'Annual',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1,
			'time_from' => array('egt', date('Y', $time).'-01-01'),
			'time_from' => array('lt', (date('Y', $time)+1).'-01-01')
			);
		$used_annual_hours = $this->dao->where($where)->sum('hours');
		$leave_info = array();
		$total_leave = 0 - $used_annual_hours;
		$leave_info['Annual_year'] = date('Y', $time);
		$leave_info['Balance_year'] = date('Y', $time)-1;
		if (strcmp($staff_info['onboard'], date('Y', $time).'-01-00') == 1) {//当年入职的员工，从入职之日算起
			$hour = round(($time-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);
			$total_leave += $hour;
			$leave_info['Annual'] = self::parseHour($hour - $used_annual_hours);
			$leave_info['Balance'] = 'N/A';//往年余额
		}
		else {//其余员工从当年01-01算起
			$hour = round(date('z', $time)*360/365/30*1.25*8);
			$total_leave += $hour;
			$leave_info['Annual'] =  self::parseHour($hour - $used_annual_hours);
			if (date('Y', $time)==2010) {
				//如果现在是2010年，则剩余年假不用计算
				$total_leave += round($staff_info['balance_2009']*8);
				$leave_info['Balance'] = round($staff_info['balance_2009']) . ($staff_info['balance_2009']>1?' days':' day');
			}
			else {
				//2011年或以后
				if (strcmp($staff_info['onboard'], '2010-01-00') == 1) {
					//该员工在2010年后入职，则剩余年假从入职日起计算至去年结束
					$hour = round((mktime(0,0,0,1,1,date('Y', $time))-strtotime($staff_info['onboard']))*360/365/86400/30*1.25*8);
					$total_leave += $hour;
					$leave_info['Balance'] = self::parseHour($hour);
				}
				else {
					//该员工在2010年前入职，则用2009年剩余年假 ＋ 2010至去年结束年假
					$hour = round($staff_info['balance_2009']*8 + (mktime(0,0,0,1,1,date('Y', $time))-mktime(0,0,0,1,1,2010))*360/365/86400/30*1.25*8);
					$total_leave += $hour;
					$leave_info['Balance'] = self::parseHour($hour);
				}
			}
		}
		$this->assign('total_leave', self::parseHour($total_leave));

		$leave_info['Compensatory'] = array();
		$total_all = $total_leave;
		$where = array(
			'type' => 'Compensatory',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1
			);
		$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $time)-3, date('d', $time), date('Y', $time)));
		$arr = array(
			'past' => array('lt', $date_3month_ago),
			'recent' => array('egt', $date_3month_ago)
			);
		foreach ($arr as $key=>$val) {
			$where['time_from'] = $val;
			$hour = $this->dao->where($where)->sum('hours');
			if ('recent' == $key) {
				$total_all += $hour;
			}
			$leave_info['Compensatory'][$key] = self::parseHour($hour);
		}
		$this->assign('total_all', self::parseHour($total_all));
		$this->assign('leave_info', $leave_info);

		$where = array(
			'type' => 'Out',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			);
		$this->assign('out_list', $this->dao->where($where)->order('id desc')->select());

		$where = array(
			'type' => array('not in', array('Overtime', 'Out')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			);
		$arr = array(
			'Waiting for Approval' => 0,
			'Get Approved' => 1,
			'Rejected' => -1
			);
		$this->assign('label_status', $arr);
		$file_path = '../Attach/Absence/';
		$result = array();
		foreach ($arr as $key => $val) {
			$where['status'] = $val;
			$rs = $this->dao->where($where)->order('id desc')->select();
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
			'status' => 1
			);
		$rs = $this->dao->where($where)->group('type')->getField("type,sum(hours)");
		$this->assign('absence_summary', $rs);

		$this->assign('ACTION_TITLE', 'My Absence');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function approve() {
		$lead_staff_arr = M('Staff')->where(array('leader_id'=>$_SESSION[C('USER_AUTH_KEY')],'status'=>1))->getField('id,realname');
		$this->assign('staff', $lead_staff_arr);
		$where = array(
			'type' => array('not in', array('Overtime', 'Out')),
			'staff_id' => array('in', implode(',', array_keys($lead_staff_arr))),
			'status' => 0
			);
		$rs = $this->dao->where($where)->order('id desc')->select();
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

		$this->assign('ACTION_TITLE', 'Staff Application');
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function confirm() {
		$id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		$comment = $_REQUEST['comment'];
		if (empty($id)) {
			return;
		}
		if ($this->dao->where('id='.$id)->setField(array('approver_id','comment','status'),array($_SESSION[C('USER_AUTH_KEY')],$comment, $status))) {
			self::_success('Operation success!','',1000);
		}
		else {
			self::_error('Operation fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}

	public function today() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', MODULE_NAME.':'.ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function history() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', MODULE_NAME.':'.ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function manage() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', MODULE_NAME.':'.ACTION_NAME);
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
		$this->assign('Notification', $this->Absence_Config['notification']);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->relation(true)->find($id);
			$notification_arr = array();
			foreach (explode(';', $info['notification']) as $item) {
				$tmp = explode(':', $item);
				if (count($tmp)==2) {
					$notification_arr[$tmp[0]] = $tmp[1];
				}
			}
			$this->assign('Notification_Ext', $notification_arr);
			$this->assign('info', $info);
		}
		else {
			$time = time();
		//	$time = mktime(13,1,1,7,16,2010);
			if (date('N', $time)>5 || (date('N', $time)==5 && strcmp(date('H:i', $time), $this->Absence_Config['worktime'][1][0])>=0)) {//周末，或周五下午
				$time += (8-date('N', $time))*86400;
				$date_from = date('Y-m-d', $time);
				$time_from = $this->Absence_Config['worktime'][0][0];
				$date_to = date('Y-m-d', $time);
				$time_to = $this->Absence_Config['worktime'][1][1];
			}
			else {
				if (strcmp(date('H:i', $time), $this->Absence_Config['worktime'][0][0])<0) {//上午上班前
					$date_from = date('Y-m-d', $time+86400);
					$time_from = $this->Absence_Config['worktime'][0][0];
					$date_to = date('Y-m-d', $time+86400);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
				elseif (strcmp(date('H:i', $time), $this->Absence_Config['worktime'][1][0])<0) {//下午上班前
					$date_from = date('Y-m-d', $time);
					$time_from = $this->Absence_Config['worktime'][1][0];
					$date_to = date('Y-m-d', $time);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
				else {//下午上班后
					$date_from = date('Y-m-d', $time+86400);
					$time_from = $this->Absence_Config['worktime'][0][0];
					$date_to = date('Y-m-d', $time+86400);
					$time_to = $this->Absence_Config['worktime'][1][1];
				}
			}
		}
		$this->assign('date_from', $date_from);
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
		$hour = self::calculateHour($date_from, $time_from, $date_to, $time_to);
		if ($hour<=0) {
			self::_error('The Hours must be larger then 0!');
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
		$notification_arr = array();
		$notification = array();
		foreach ($_REQUEST['notification'] as $item) {
			if (''!=$item) {
				$tmp = explode(':', $item);
				if (!in_array($tmp[1], $notification_arr)) {
					$notification_arr[$tmp[0]] = $tmp[1];
					$notification[] = $item;
				}
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
			$this->dao->status = 0;
		}
		$this->dao->type = $type;
		$this->dao->staff_id = $_SESSION[C('STAFF_AUTH_NAME')]['id'];
		$this->dao->creator_id = $_SESSION[C('STAFF_AUTH_NAME')]['id'];
		$this->dao->time_from = $date_from.' '.$time_from.':00';
		$this->dao->time_to = $date_to.' '.$time_to.':00';
		$this->dao->hours = $hour;
		$this->dao->deputy_id = $deputy;
		$this->dao->notification = implode(';', $notification);
		$this->dao->note = $note;
		if($id>0) {
			if(false !== $this->dao->save()) {
				self::_success('Application updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Absence apply success!',__URL__);
			}
			else{
				self::_error('Absence apply fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
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
		return $hour.$unit1.' ('.$day.$unit2.')';
	}
	private function calculateHour($date_from, $time_from, $date_to, $time_to) {
		//计算总小时数
		$hour = 0;
		$in = $out = false;
		foreach ($this->Absence_Config['worktime'] as $i=>$arr) {
			foreach ($arr as $j=>$time) {
				if (strcmp($time_from, $time)>=0) {
					$in = true;
				}
				else {
					$out = true;
					break;
				}
				if ($in && strcmp($time_from, $time)<0) {
					$out = true;
					break;
				}
			}
			if ($out) {
				break;
			}
		}
		if (!$out) {
			$j ++;
		}
		$from_i = $i;
		$from_j = $j;

		$in = $out = false;
		foreach ($this->Absence_Config['worktime'] as $i=>$arr) {
			foreach ($arr as $j=>$time) {
				if (strcmp($time_to, $time)>=0) {
					$in = true;
				}
				else {
					$out = true;
					break;
				}
				if ($in && strcmp($time_to, $time)<0) {
					$out = true;
					break;
				}
			}
			if ($out) {
				break;
			}
		}
		if (!$out) {
			$j ++;
		}
		$to_i = $i;
		$to_j = $j;
		if ($from_i==0) {// 0-
			if ($from_j==0) {// 0-0
				if ($to_i==0) {// 0-0 0-
					if ($to_j==0) {// 0-0 0-0
						$hour = 0;
					}
					else {// 0-0 0-1
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][0][0].':00'))/3600;
					}
				}
				else {// 0-0 1-
					$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][0][1].':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][0][0].':00'))/3600;
					if ($to_j == 1) {// 0-0 1-1
						$hour += (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
					elseif ($to_j == 2) {// 0-0 1-2
						$hour += (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][1].':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
				}
			}
			else {// 0-1
				if ($to_i==0) {// 0-1 0-
					if ($to_j == 0) {//0-1 0-0
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][0][0].':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					}
					else {//0-0 0-1
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					}
				}
				else {// 0-1 1-
					$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][0][1].':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					if ($to_j == 1) {// 0-1 1-1
						$hour += (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
					elseif ($to_j == 2) {// 0-1 1-2
						$hour += (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][1].':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
				}
			}
		}
		else {//1-
			if ($from_j==0) {// 1-0
				if ($to_i==0) {// 1-0 0-
					if ($to_j==0) {// 1-0 0-0
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][0][0].':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][0][1].':00'))/3600;
					}
					else {// 1-0 0-1
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][0][1].':00'))/3600;
					}
				}
				else {// 1-0 1-
					if ($to_j == 0) {// 1-0 1-0
						$hour = 0;
					}
					if ($to_j == 1) {// 1-0 1-1
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
					elseif ($to_j == 2) {// 1-0 1-2
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][1].':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00'))/3600;
					}
				}
			}
			else {// 1-1
				if ($to_i==0) {// 1-1 0-
					if ($to_j == 0) {//1-1 0-0
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][1][1].':00'))/3600;
					}
					else {//1-1 0-1
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
						$hour += (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$this->Absence_Config['worktime'][0][1].':00'))/3600;
					}
				}
				else {// 1-1 1-
					if ($to_j == 0) {// 1-1 1-0
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][0].':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					}
					elseif ($to_j == 1) {// 1-1 1-1
						$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					}
					elseif ($to_j == 2) {// 1-1 1-2
						$hour = (strtotime($date_to.' '.$this->Absence_Config['worktime'][1][1].':00') - strtotime($date_to.' '.$time_from.':00'))/3600;
					}
				}
			}
		}
		$hour += (strtotime($date_to)-strtotime($date_from))/86400*8;
		echo $from_i.'-'.$from_j.'-'.$to_i.'-'.$to_j;
		echo "\r\n".$hour;
		return $hour;
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