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
		global $LeaveType;
		Session::set('top', 'Absence');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Absence');
		$this->time = time();
//		$this->time = mktime(0,0,0,2,28,2012);
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

		//计算用户可分配的年假限额，每年分配15/20/25天
		$Accrual = array(0, 0);
		$AccrualTime = array();
		foreach ($this->Absence_Config['accrualrate'] as $key=>$val) {
			$AccrualTime[] = $key;
			if ($this->time - strtotime($staff_info['onboard']) > $key) {
				$Accrual = $val;
			}
		}
		$where = array(
			'type' => array('in', array('Annual','CashOut')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1
			);
		$used_annual_hours = $this->dao->where($where)->sum('hours');
		$leave_info = array();
		$total_annual = 0;
		$total_leave = 0;
		$leave_info['Annual_year'] = date('Y', $this->time);
		$leave_info['Balance_year'] = date('Y', $this->time)-1;
		
		if (strcmp($staff_info['onboard'], date('Y', $this->time).'-01-00')>0) {
			//今年入职的员工，从入职之日算起，忽略预设Balance
			$leave_info['Balance'] = 'N/A';

			$added_annual_hour = round(($this->time - strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8);
			$left_annual_hour = $added_annual_hour - $used_annual_hours;
			$total_annual += $left_annual_hour;
		}
		else {
			//今年之前入职的员工，从今年01-01算起
			$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);
			//到达新的等级后，之前的年假按之前的额度来分配，剩下的天数按新额度来分配
			foreach ($AccrualTime as $i=>$period) {
				if ($i>0 && $this->time >= strtotime($staff_info['onboard'])+$period) {
					$tmp_time1 = mktime(0,0,0,1,1,date('Y', $this->time));
					if ($tmp_time1 >= strtotime($staff_info['onboard'])+$period) {
						$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);
					}
					else {
						$added_annual_hour = round(date('z', strtotime($staff_info['onboard'])+$period)/365*$this->Absence_Config['accrualrate'][$AccrualTime[$i-1]][0]*8);
						$added_annual_hour += round(($this->time-strtotime($staff_info['onboard'])-$period)/86400/365*$Accrual[0]*8);
					}
				}
			}

			if (date('Y', $this->time)==2011) {
				//如果现在是2011年，则读取2010剩余年假，并减除已使用假期
				$balance_hour = max(0, round($staff_info['balance']*8)-$used_annual_hours);
			
				$left_annual_hour = $added_annual_hour + round($staff_info['balance']*8) - $used_annual_hours;
				$total_annual += $left_annual_hour;
			}
			else {
				//现在是2012年或以后
				if (strcmp($staff_info['onboard'], '2011-01-00')>0) {
					//该员工在2011年后入职，则从入职日起计算至去年结束的年假
					$tmp_balance_hour = (mktime(0,0,0,1,1,date('Y', $this->time))-strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8;

					$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
					if (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
						//去年达到10年工龄的
						$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
						$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
						$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
					}
					elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
						//去年达到4年工龄的
						$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
						$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
					}
				}
				else {
					//该员工在2011年前入职，则用2010年剩余年假 + 2011年至去年的整年假
					$tmp_balance_hour = $staff_info['balance']*8 + (date('Y', $this->time)-2011)*$Accrual[0]*8;
					//到达新的等级后
					$tmp_balance_hour = $staff_info['balance']*8;
					$tmp_time1 = mktime(0,0,0,1,1,2011);
					$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
					if (strtotime($staff_info['onboard'])+$AccrualTime[2] < $tmp_time1) {
						//2011年初已有10年工龄的，即2001年1月1日前入职，此时$Accrual[0]＝25
						$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
					}
					elseif (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
						//去年达到10年工龄的，在2017年后才会出现
						$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
						$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
						$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
					}
					elseif (strtotime($staff_info['onboard'])+$AccrualTime[1] < $tmp_time1) {
						//2011年初已有4年工龄的，即2007年1月1日入职，此时$Accrual[0]＝20
						$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
					}
					elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
						//去年达到4年工龄的
						$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
						if (strtotime($staff_info['onboard'])+$AccrualTime[2] >= $tmp_time2) {
							//去年未达到10年的
							$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
						}
						else {
							$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
							$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
						}
					}
					else {
						$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
					}
				}
				$tmp_balance_hour = round($tmp_balance_hour);
				$balance_hour = max(0, $tmp_balance_hour-$used_annual_hours);

				$left_annual_hour = $added_annual_hour + $tmp_balance_hour - $used_annual_hours;
				$total_annual += $left_annual_hour;
			}
			$leave_info['Balance'] = self::parseHour($balance_hour);
		}
		
		$leave_info['Annual'] =  self::parseHour($left_annual_hour);
		$this->assign('total_annual', self::parseHour($total_annual));
		$total_leave = $total_annual;

		$leave_info['CashOut'] = array();
		$where = array(
			'type' => 'CashOut',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1
			);
		$arr = array(
			array(
				array('egt', date('Y', $this->time).'-01-01'),
				array('lt', date('Y', $this->time).'-07-01')
				),
			array(
				array('egt', date('Y', $this->time).'-07-01'),
				array('lt', (date('Y', $this->time)+1).'-01-01')
				)
			);
		foreach ($arr as $key=>$val) {
			$where['create_time'] = $val;
			$hour = $this->dao->where($where)->sum('hours');
			$leave_info['CashOut'][$key]['days'] = self::parseHour($hour);
			$leave_info['CashOut'][$key]['Month'] = date('M', mktime(0,0,0,$this->Absence_Config['cashoutmonth'][$key],1,date('Y', $this->time)));
			if ($hour==0 && date('n', $this->time) == $this->Absence_Config['cashoutmonth'][$key]) {
				$leave_info['CashOut'][$key]['enable'] = true;
			}
		}
		$leave_info['Overtime'] = array();
		$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $this->time)-3, date('d', $this->time), date('Y', $this->time)));
		$where = array(
			'type'=> 'Overtime',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_from' => array('lt', $date_3month_ago),
			'status' => 1
		);
		$leave_info['Overtime']['past'] = self::parseHour($this->dao->where($where)->sum('hours_remain')); 
		
		$where['time_from'] = array('egt', $date_3month_ago);
		$hour = $this->dao->where($where)->sum('hours_remain');
		$total_leave += $hour;
		$leave_info['Overtime']['recent'] = self::parseHour($hour);

		$this->assign('total_leave', self::parseHour($total_leave));
		$this->assign('leave_info', $leave_info);

		$where = array(
			'type' => 'Out',
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_to' => array('gt', date('Y-m-d', $this->time-30*86400))//最近1月
			);
		$this->assign('out_list', $this->dao->relation(true)->where($where)->order('id desc')->select());

		$where = array(
			'type' => array('neq', 'Out'),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'time_to' => array('gt', (date('Y', $this->time)-1).'-'.date('m', $this->time).'-'.date('d', $this->time))//最近1年
			);
		$label_arr = array(
			'Waiting for Approval' => array('lt', 1),
			'Get Approved' => 1,
			'Rejected' => 2
			);
		$this->assign('label_status', $label_arr);
		$file_path = '../Attach/Absence/';
		$result = array();
		foreach ($label_arr as $label => $val) {
			$where['status'] = $val;
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			foreach ($rs as $i=>$item) {
				$rs[$i]['days'] = self::parseHour($item['hours']);
				if ($item['hours'] <= 8) {
					$rs[$i]['approver'] = $staff_info['leader']['realname'];
				}
				elseif ($item['hours'] <= 16) {
					if ($item['status'] == -1) {
						$rs[$i]['approver'] = $staff_info['leader']['realname'];
					}
					else {
						reset($this->Absence_Config['application']['level_1']['approver']);
						list($name, $email) = each($this->Absence_Config['application']['level_1']['approver']);
						$rs[$i]['approver'] = $name;
					}
				}
				else {
					if ($item['status'] == -2) {
						$rs[$i]['approver'] = $staff_info['leader']['realname'];
					}
					elseif ($item['status'] == -1) {
						reset($this->Absence_Config['application']['level_2']['approver']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$rs[$i]['approver'] = $name;
					}
					else {
						reset($this->Absence_Config['application']['level_2']['approver']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$rs[$i]['approver'] = $name;
					}
				}
				$rs[$i]['attachment_url'] = '';
				if (''==trim($item['attachment'])) {
					continue;
				}
				foreach (explode(';', $item['attachment']) as $j=>$file_name) {
					$rs[$i]['attachment_url'] .= '[<a href="'.$file_path.$file_name.'" target="_blank"> '.($j+1).' </a>] ';
				}
			}
			!empty($rs) && ($result[$label] = $rs);
		}
		$this->assign('apply_list', $result);

		$where = array(
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			'status' => 1,
			'time_from' => array(array('egt', date('Y', $this->time).'-01-01'), array('lt', (date('Y', $this->time)+1).'-01-01'))
			);
		$rs = $this->dao->where($where)->group('type')->getField("type,sum(hours)");
		$this->assign('absence_summary', $rs);

		$this->assign('ACTION_TITLE', 'My Leave Summary');
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
					'description' => str_replace(array("'", "\r\n"), array("\'", "<br />"), $rs['descr'])
					);
			}
		}
		$this->assign('LeaveType', $result);

		$type = '';
		if (!empty($_REQUEST['type'])) {
			$type = $_REQUEST['type'];
			$this->assign('type', $type);
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			//edit form
			$info = $this->dao->relation(true)->find($id);
			$this->assign('info', $info);

			if ('CashOut' == $type) {
				$total = self::get_avaliable('Annual', $info['staff_id'], $id);
				$reserved = $this->Absence_Config['reservedhours'];
				$this->assign('total_leave', self::parseHour($total));
				$this->assign('reserved', self::parseHour($reserved));
				$this->assign('available', self::parseHour($total-$reserved));
			}
		}
		else {
			//new form
			if ('CashOut' == $type) {
				$total = self::get_avaliable('Annual', $_SESSION[C('USER_AUTH_KEY')]);
				$reserved = $this->Absence_Config['reservedhours'];
				$this->assign('total_leave', self::parseHour($total));
				$this->assign('reserved', self::parseHour($reserved));
				$this->assign('available', self::parseHour($total-$reserved));
			}
			else {
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
		}
		if (!empty($type)) {
			$this->assign('date_from', date('Y-m-d', $this->time-30*86400));
		}
		else {
			$this->assign('date_from', $date_from);
		}
		$this->assign('time_from', $time_from);
		$this->assign('date_to', $date_to);
		$this->assign('time_to', $time_to);

		$dept_staff_arr = array();
		$dept_arr = M('Department')->order('name')->select();
		empty($dept_arr) && ($dept_arr = array());
		foreach ($dept_arr as $dept) {
			$dept_staff_arr[$dept['name']] = array();
			if (!empty($dept['leader_id'])) {
				$dept_staff_arr[$dept['name']]['leader'] = M('Staff')->field('id, realname')->find($dept['leader_id']);
			}
			$where = array(
				'dept_id' => $dept['id'],
				'status' => 1
			);
			if (!empty($dept['leader_id'])) {
				$where['id'] = array('neq', $dept['leader_id']);
			}
			$rs = M('Staff')->field('id, realname')->where($where)->order('realname')->select();
			if (!empty($rs)) {
				$dept_staff_arr[$dept['name']]['staff']  = $rs;
			}
		}
		$rs = M('Staff')->where(array('dept_id'=>0, 'status'=>1))->order('realname')->field('id,realname')->select();
		if (!empty($rs)) {
			$dept_staff_arr['No Department']['staff'] = $rs;
		}
		$this->assign('DeptStaff', $dept_staff_arr);

		$this->assign('content', ACTION_NAME.(empty($type)?'':'-'.$type));
		$this->display('Layout:content');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$type = $_REQUEST['type'];
		!$type && self::_error('Absense Type didn\'t select!');
		$staff_id = empty($_REQUEST['staff_id'])?$_SESSION[C('USER_AUTH_KEY')]:$_REQUEST['staff_id'];

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ('CashOut' == $type) {
			$days = intval($_REQUEST['days']);
			if ($days <= 0) {
				self::_error('Your input is not a positive number!');
			}
			$days2 = intval($_REQUEST['days2']);
			if ($days2 != $days) {
				self::_error('Your two input are not match!');
			}
			$total = self::get_avaliable('Annual', $_SESSION[C('USER_AUTH_KEY')], $id);
			$reserved = $this->Absence_Config['reservedhours'];
			if ($days*8 > $total-$reserved) {
				self::_error('Your input is out of limit!');
			}
			if ($id>0) {
				//for edit
				$this->dao->find($id);
			}
			else {
				//for add
				$this->dao->type = $type;
				$this->dao->create_time = date("Y-m-d H:i:s");
				$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
				$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
				$this->dao->status = 1;
			}
			$this->dao->hours = $days*8;
			if($id>0) {
				if(false !== $this->dao->save()) {
					self::_success('Application updated!', $_SERVER["HTTP_REFERER"]);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			else{
				if($this->dao->add()) {
					self::_success('Apply successfully!',__URL__);
				}
				else{
					self::_error('Apply failed!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
		}
		else {
			$date_from = trim($_REQUEST['date_from']);
			$tmp_str = trim($_REQUEST['time_from']);
			$tmp = explode(':', $tmp_str);
			$time_from = sprintf('%02d', intval($tmp[0])).':'.sprintf('%02d', intval($tmp[1]));
			$date_to = trim($_REQUEST['date_to']);
			$tmp_str = trim($_REQUEST['time_to']);
			$tmp = explode(':', $tmp_str);
			$time_to = sprintf('%02d', intval($tmp[0])).':'.sprintf('%02d', intval($tmp[1]));
			if (false === strtotime($date_from.' '.$time_from.':00')) {
				self::_error('The begin date/time of the duration is not invalid!');
			}
			elseif (false === strtotime($date_to.' '.$time_to.':00')) {
				self::_error('The end date/time of the duration is not invalid!');
			}
			elseif (strcmp($date_from.$time_from, $date_to.$time_to)>=0) {
				self::_error('The end datetime must be later than the begin datetime!');
			}
			global $hour;
			$hour = 0;
			if ('Overtime'==$type) {
				$hour = (strtotime($date_to.' '.$time_to.':00') - strtotime($date_from.' '.$time_from.':00'))/3600;
				if (strcmp($date_from.' '.$time_from, $date_from.' '.$this->Absence_Config['worktime'][0][1])<=0 && strcmp($date_to.' '.$time_to, $date_from.' '.$this->Absence_Config['worktime'][1][0])>=0) {
					$hour -= 1;
				}
			}
			else {
				self::calculateHour($date_from, $time_from, $date_to, $time_to);
			}
			echo 'applied hour:'.$hour."\n";
			$avaliable_hour = self::get_avaliable($type, $staff_id, $id);
			echo 'avaliable hour:'.$avaliable_hour."\n";
			if ($hour<=0) {
				self::_error('The hours must be larger than 0!');
			}
			elseif ('Compensatory'==$type && $hour>$avaliable_hour && $id==0) {
				self::_error('You can\'t apply more than '.$avaliable_hour.' hours');
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
				$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
				if ($hour<=8) {
					$this->dao->status = 0;
				}
				elseif ($hour<=16) {
					$this->dao->status = -1;
				}
				else {
					$this->dao->status = -2;
				}
				if ('Out' == $type) {
					$this->dao->status = 1;
				}
			}
			$this->dao->type = $type;
			$this->dao->staff_id = $staff_id;
			$this->dao->time_from = $date_from.' '.$time_from.':00';
			$this->dao->time_to = $date_to.' '.$time_to.':00';
			$this->dao->hours = $hour;
			$this->dao->hours_remain = $hour;
			$this->dao->deputy_id = $deputy;
			$this->dao->note = $note;
			if($id>0) {
				if(false !== $this->dao->save()) {
	//				self::mail_application($this->dao);//不允许员工编辑，因此不需要重发application
					self::_success('Application updated!', $_SERVER["HTTP_REFERER"]);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			else{
				if($ab_id = $this->dao->add()) {
					$this->dao->id = $ab_id;
					if ($type != 'Out' && $type!= 'CashOut') {
						self::mail_application($this->dao);
					}
					self::_success('Application created success!',__URL__);
				}
				else{
					self::_error('Application created fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
		}
	}
	public function manage() {
		if (isset($_REQUEST['staff_id'])) {
			$staff_id = intval($_REQUEST['staff_id']);
		}
		elseif('' != $tmp=Session::get(ACTION_NAME.'_staff_id')) {
			$staff_id = $tmp;
		}
		else {
			$staff_id = 0;
		}
		Session::set(ACTION_NAME.'_staff_id', $staff_id);
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), $staff_id, 'realname'));

		if (isset($_REQUEST['type'])) {
			$type = $_REQUEST['type'];
		}
		elseif('' != $tmp=Session::get(ACTION_NAME.'_type')) {
			$type = $tmp;
		}
		else {
			$type = '';
		}
		Session::set(ACTION_NAME.'_type', $type);
		global $LeaveType;
		$type_arr = array();
		foreach ($LeaveType as $key=>$val) {
			$type_arr[] = array('type'=>$key, 'alias'=>$val);
		}
		$this->assign('type_opts', self::genOptions($type_arr, $type, 'alias', 'type'));
		
		if(isset($_REQUEST['from'])) {
			$from = $_REQUEST['from'];
		}
		elseif(''!= $tmp=Session::get(ACTION_NAME.'_from')) {
			$from = Session::get(ACTION_NAME.'_from');
		}
		else{
			$from = date('Y-m-d', $this->time-15*86400);
		}
		Session::set(ACTION_NAME.'_from', $from);
		$this->assign('from', $from);

		if(isset($_REQUEST['to'])) {
			$to = $_REQUEST['to'];
		}
		elseif(''!= $tmp=Session::get(ACTION_NAME.'_to')) {
			$to = Session::get(ACTION_NAME.'_to');
		}
		else{
			$to = date('Y-m-d', $this->time+15*86400);
		}
		Session::set(ACTION_NAME.'_to', $to);
		$this->assign('to', $to);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!= $tmp=Session::get(ACTION_NAME.'_status')) {
			$status = Session::get(ACTION_NAME.'_status');
		}
		else{
			$status = '-';
		}
		Session::set(ACTION_NAME.'_status', $status);
		$status_arr = array(
			array('id'=>'0', 'name'=>'Un-approved'),
			array('id'=>'1', 'name'=>'Approved'),
			array('id'=>'2', 'name'=>'Rejected')
			);
		$this->assign('status_opts', self::genOptions($status_arr, $status));

		$where = array();
		$where['type'] = array('neq', 'CashOut');
		!empty($staff_id) && ($where['staff_id'] = $staff_id);
		!empty($type) && ($where['type'] = $type);
		!empty($_REQUEST['to']) && ($where['time_from'] = array('lt', $_REQUEST['to']));
		!empty($_REQUEST['from']) && ($where['time_to'] = array('egt', $_REQUEST['from']));
		if ('-'!=$status) {
			$where['status'] = $status;
			if ('0' == $status) {
				$where['status'] = array('lt', 1);
			}
		}
		$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
		empty($rs) && ($rs = array());
		$this->assign('result', $rs);

		$this->assign('ACTION_TITLE', 'Team Absence Query');
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function approve() {
		//approve for level_0
		$lead_staff_arr = M('Staff')->where(array('leader_id'=>$_SESSION[C('USER_AUTH_KEY')],'status'=>1))->getField('id,realname');
	//	$this->assign('staff', $lead_staff_arr);
		$where = array(
			'type' => array('neq', 'Out'),
			'staff_id' => array('in', implode(',', array_keys($lead_staff_arr))),
		//	'status' => array('lt', 1)
			);
		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		else{
			$status = 0;
		}
		if ($status == 0) {
			$where['status'] = array('lt', 1);
		}
		else {
			$where['status'] = $status;
		}
		$this->assign('status', $status);
		$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $row) {
			if ($row['type'] == 'CashOut' || $row['status']>0) {
				$result[] = $row;
			}
			elseif ($row['hours'] <= 8) {
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
		if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
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
		if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
			$where = array(
				'type' => array('neq', 'Out'),
				'hours' => array('gt', 16),
				'status' => -1
				);
			$rs = $this->dao->relation(true)->where($where)->order('id desc')->select();
			!empty($rs) && ($result = array_merge($result, $rs));
		}
		list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
		if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
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
		if (empty($id)) {
			return;
		}
		$info = $this->dao->find($id);
		$status = intval($_REQUEST['status']);
		if ($status == '-1' && $info['hours']>16) {
			list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
			if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
				$status = 0;
			}
			else {
				list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
				if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
					$status = 1;
				}
			}
		}
		elseif ($status == '0' && $info['hours']>8 && $info['hours']<=16) {
			list($name, $email) = each($this->Absence_Config['application']['level_1']['approver']);
			if (strtoupper($_SESSION[C('STAFF_AUTH_NAME')]['name']) == $name) {
				$status = 1;
			}
		}
		$comment_prefix = '['.date('Y-m-d H:i:s').' by '.$_SESSION[C('STAFF_AUTH_NAME')]['realname'].'] ';
		$comment = $_REQUEST['comment'];
		if (''==trim($comment)) {
			if ('2'==$status) {
				$comment = 'Rejected';
			}
			elseif ('1'==$status) {
				$comment = 'Approved';
			}
		}
		$comment = $comment_prefix.$comment;
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
			if ($info['type']!= 'CashOut') {
				$this->dao->comment = $comment;
				$this->dao->status = $status;
				self::mail_application($this->dao);
			}
			if (1==$status && 'Compensatory'==$info['type']) {
				//从Overtime记录的hours_remain中减除相应hour数
				$time = strtotime($info['time_from']);
				$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $time)-3, date('d', $time), date('Y', $time)));
				$where = array(
					'type'=> 'Overtime',
					'staff_id' => $info['staff_id'],
					'time_from' => array('egt', $date_3month_ago),
					'status' => 1
					);
				$rs = $this->dao->where($where)->order('time_from')->select();
				foreach ($rs as $row) {
					$remain = $row['hours_remain'];
					$this->dao->where('id='.$row['id'])->setField('hours_remain', max(0, $remain-$info['hours']));
					if ($remain-$info['hours']>=0) {
						break;
					}
					$info['hours'] -= $remain;
				}
			}
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

		import("@.Paginator");
		$limit = 10;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$where = array(
			'type' => array('not in', array('Overtime', 'CashOut')),
			'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
			);
		$count = $this->dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$rs = $this->dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->select();
		$this->assign('result', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('ACTION_TITLE', 'My absence history');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function summary() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$leave_info = array();
		$leave_info['Annual_year'] = date('Y', $this->time);
		$leave_info['Balance_year'] = date('Y', $this->time)-1;
		$leave_info['CashOut'][0]['Month'] = date('M', mktime(0,0,0,$this->Absence_Config['cashoutmonth'][0],1,date('Y', $this->time)));
		$leave_info['CashOut'][1]['Month'] = date('M', mktime(0,0,0,$this->Absence_Config['cashoutmonth'][1],1,date('Y', $this->time)));
		$this->assign('leave_info', $leave_info);
		
		$where = array();
		$where['status'] = 1;
		if (!in_array($_SESSION[C('USER_AUTH_KEY')], C('SUPER_ADMIN_ID')) && !in_array($_SESSION[C('USER_AUTH_KEY')], C('ABSENCE_ADMIN_ID'))) {//不是超级管理员，也不是Absence管理员，那么只能看自己的下属
			$where['leader_id'] = $_SESSION[C('USER_AUTH_KEY')];
		}
		$rs = M('Staff')->where($where)->select();
		foreach ($rs as $n=>$staff_info) {
			//计算用户可分配的年假限额，每年分配15/20/25天
			$Accrual = array(0, 0);
			$AccrualTime = array();
			foreach ($this->Absence_Config['accrualrate'] as $key=>$val) {
				$AccrualTime[] = $key;
				if ($this->time - strtotime($staff_info['onboard']) > $key) {
					$Accrual = $val;
				}
			}
			//历年用掉的年假
			$where = array(
				'type' => 'Annual',
				'staff_id' => $staff_info['id'],
				'status' => 1,
				'time_from' => array('lt', date('Y', $this->time).'-01-01')
				);
			$history_used = $this->dao->where($where)->sum('hours');
			//历年的Cash Out
			$where = array(
				'type' => 'CashOut',
				'staff_id' => $staff_info['id'],
				'status' => 1,
				'create_time' => array('lt', date('Y', $this->time).'-01-01')
				);
			$history_used += $this->dao->where($where)->sum('hours');
			//今年用掉的年假
			$where = array(
				'type' => 'Annual',
				'staff_id' => $staff_info['id'],
				'status' => 1,
				'time_from' => array(array('egt', date('Y', $this->time).'-01-01'), array('lt', (date('Y', $this->time)+1).'-01-01'))
				);
			$annual_used = $this->dao->where($where)->sum('hours');
			
			$balance_hour = $added_annual_hour = 0;
			if (strcmp($staff_info['onboard'], date('Y', $this->time).'-01-00')>0) {
				//今年入职的员工，从入职之日算起，忽略预设Balance
				$rs[$n]['Balance'] = 'N/A';
				$added_annual_hour = round(($this->time - strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8);
			}
			else {
				//今年之前入职的员工，从今年01-01算起
				$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);
				//到达新的等级后，之前的年假按之前的额度来分配，剩下的天数按新额度来分配
				foreach ($AccrualTime as $i=>$period) {
					if ($i>0 && $this->time >= strtotime($staff_info['onboard'])+$period) {
						$tmp_time1 = mktime(0,0,0,1,1,date('Y', $this->time));
						if ($tmp_time1 >= strtotime($staff_info['onboard'])+$period) {
							$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);
						}
						else {
							$added_annual_hour = round(date('z', strtotime($staff_info['onboard'])+$period)/365*$this->Absence_Config['accrualrate'][$AccrualTime[$i-1]][0]*8);
							$added_annual_hour += round(($this->time-strtotime($staff_info['onboard'])-$period)/86400/365*$Accrual[0]*8);
						}
					}
				}
			//	echo $added_annual_hour.'<br />';
				if (date('Y', $this->time)==2011) {
					$balance_hour = round($staff_info['balance']*8);
				}
				else {
					//现在是2012年或以后
					if (strcmp($staff_info['onboard'], '2011-01-00')>0) {
						//该员工在2011年后入职，则从入职日起计算至去年结束的年假
						$tmp_balance_hour = (mktime(0,0,0,1,1,date('Y', $this->time))-strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8;

						$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
						if (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
							//去年达到10年工龄的
							$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
							$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
							$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
						}
						elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
							//去年达到4年工龄的
							$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
							$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
						}
					}
					else {
						//该员工在2011年前入职，则用2010年剩余年假 + 2011年至去年的整年假
						$tmp_balance_hour = $staff_info['balance']*8 + (date('Y', $this->time)-2011)*$Accrual[0]*8;

						//到达新的等级后
						$tmp_balance_hour = $staff_info['balance']*8;
						$tmp_time1 = mktime(0,0,0,1,1,2011);
						$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
						if (strtotime($staff_info['onboard'])+$AccrualTime[2] < $tmp_time1) {
							//2011年初已有10年工龄的，即2001年1月1日前入职，此时$Accrual[0]＝25
							$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
						}
						elseif (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
							//去年达到10年工龄的，在2017年后才会出现
							$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
							$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
							$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
						}
						elseif (strtotime($staff_info['onboard'])+$AccrualTime[1] < $tmp_time1) {
							//2011年初已有4年工龄的，即2007年1月1日入职，此时$Accrual[0]＝20
							$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
						}
						elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
							//去年达到4年工龄的
							$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
							if (strtotime($staff_info['onboard'])+$AccrualTime[2] >= $tmp_time2) {
								//去年未达到10年的
								$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
							}
							else {
								$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
								$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
							}
						}
						else {
							$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
						}
					}
					$balance_hour = round($tmp_balance_hour);
				}
				$rs[$n]['Balance'] = self::parseHour($balance_hour-$history_used);
			}
			$rs[$n]['Annual'] =  self::parseHour($added_annual_hour);
			$rs[$n]['Annual_used'] = self::parseHour($annual_used);

			$cashout_used = 0;
			unset($where['time_from']);
			$where['type'] = 'CashOut';
			$arr = array(
				array(
					array('egt', date('Y', $this->time).'-01-01'),
					array('lt', date('Y', $this->time).'-07-01')
					),
				array(
					array('egt', date('Y', $this->time).'-07-01'),
					array('lt', (date('Y', $this->time)+1).'-01-01')
					)
				);
			foreach ($arr as $key=>$val) {
				$where['create_time'] = $val;
				$hour = $this->dao->where($where)->sum('hours');
				$cashout_used += $hour;
				$rs[$n]['CashOut'][$key] = self::parseHour($hour);
			}

			$annual_available = $balance_hour-$history_used+$added_annual_hour-$annual_used-$cashout_used;
			$rs[$n]['Annual_available'] = self::parseHour($annual_available);
			$leave_available = $annual_available;

			$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $this->time)-3, date('d', $this->time), date('Y', $this->time)));
			unset($where['create_time']);
			$where['type'] = 'Overtime';
			$where['time_from'] = array('egt', $date_3month_ago);
			$rs[$n]['Overtime'] = self::parseHour($this->dao->where($where)->sum('hours'));

			$where['type'] = 'Compensatory';
			$rs[$n]['Compensatory'] = self::parseHour($this->dao->where($where)->sum('hours'));

			$rs[$n]['Total'] = self::parseHour($leave_available);

			//预估到下次CashOut时可获得的年假
			if ($this->Absence_Config['cashoutmonth'][0]<=date('n', $this->time) && date('n', $this->time)<$this->Absence_Config['cashoutmonth'][1]) {
				$future_annual_hour = round((mktime(0,0,0,$this->Absence_Config['cashoutmonth'][1],1,date('Y', $this->time)) - $this->time)/86400/365*$Accrual[0]*8);
			}
			elseif (date('n', $this->time) < $this->Absence_Config['cashoutmonth'][0]) {
				$future_annual_hour = round((mktime(0,0,0,$this->Absence_Config['cashoutmonth'][0],1,date('Y', $this->time)) - $this->time)/86400/365*$Accrual[0]*8);
			}
			else {
				$future_annual_hour = round((mktime(0,0,0,$this->Absence_Config['cashoutmonth'][0],1,date('Y', $this->time)+1) - $this->time)/86400/365*$Accrual[0]*8);
			}
			if ($leave_available+$future_annual_hour > $Accrual[1]*8) {
				$rs[$n]['Exceed'] = 1;
			}
			else {
				$rs[$n]['Exceed'] = 0;
			}
			$rs[$n]['Accrual'] = round(($leave_available+$future_annual_hour)/8, 1);
			$rs[$n]['MaxAccrual'] = $Accrual[1];
		}
		$this->assign('result', $rs);

		$this->assign('ACTION_TITLE', 'Staff Leave Summary');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	private function get_avaliable($type, $staff_id, $id=0) {
		$total_leave = 0;
		switch ($type) {
			case 'Annual':
				$staff_info = D('Staff')->find($staff_id);
				//计算用户可分配的年假限额，每年分配15/20/25天
				$Accrual = array(0, 0);
				$AccrualTime = array();
				foreach ($this->Absence_Config['accrualrate'] as $key=>$val) {
					$AccrualTime[] = $key;
					if ($this->time - strtotime($staff_info['onboard']) > $key) {
						$Accrual = $val;
					}
				}
				$where = array(
					'id' => array('neq', $id),
					'type' => array('in', array('Annual','CashOut')),
					'staff_id' => $staff_id,
					'status' => 1
					);
				$used_annual_hours = $this->dao->where($where)->sum('hours');
				if (strcmp($staff_info['onboard'], date('Y', $this->time).'-01-00')>0) {
					//当年入职的员工，从入职之日算起，忽略预设Balance
					$added_annual_hour = round(($this->time - strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8);
					$total_leave = $added_annual_hour - $used_annual_hours;
				}
				else {
					//当年之前入职的员工，从当年01-01算起
					$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);

					//到达新的等级后，之前的年假按之前的额度来分配，剩下的天数按新额度来分配
					foreach ($AccrualTime as $i=>$period) {
						if ($i>0 && $this->time >= strtotime($staff_info['onboard'])+$period) {
							$tmp_time1 = mktime(0,0,0,1,1,date('Y', $this->time));
							if ($tmp_time1 >= strtotime($staff_info['onboard'])+$period) {
								$added_annual_hour = round(date('z', $this->time)/365*$Accrual[0]*8);
							}
							else {
								$added_annual_hour = round(date('z', strtotime($staff_info['onboard'])+$period)/365*$this->Absence_Config['accrualrate'][$AccrualTime[$i-1]][0]*8);
								$added_annual_hour += round(($this->time-strtotime($staff_info['onboard'])-$period)/86400/365*$Accrual[0]*8);
							}
						}
					}

					if (date('Y', $this->time)==2011) {
						//如果现在是2011年，则读取2010剩余年假，并减除已使用假期
						$balance_hour = max(0, round($staff_info['balance']*8-$used_annual_hours));

						$total_leave = $added_annual_hour + round($staff_info['balance']*8) - $used_annual_hours;
					}
					else {
						//2012年或以后
						if (strcmp($staff_info['onboard'], '2011-01-00')>0) {
							//该员工在2011年后入职，则从入职日起计算至去年结束
							$tmp_balance_hour = (mktime(0,0,0,1,1,date('Y', $this->time))-strtotime($staff_info['onboard']))/86400/365*$Accrual[0]*8;

							$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
							if (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
								//去年达到10年工龄的
								$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
								$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
								$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
							}
							elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
								//去年达到4年工龄的
								$tmp_balance_hour = $AccrualTime[1]/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
								$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
							}
						}
						else {
							//该员工在2011年前入职，则用2010年剩余年假 + 2011年到去年的整年假
							$tmp_balance_hour = $staff_info['balance']*8 + (date('Y', $this->time)-2011)*$Accrual[0]*8;

							//到达新的等级后
							$tmp_balance_hour = $staff_info['balance']*8;
							$tmp_time1 = mktime(0,0,0,1,1,2011);
							$tmp_time2 = mktime(0,0,0,1,1,date('Y', $this->time));
							if (strtotime($staff_info['onboard'])+$AccrualTime[2] < $tmp_time1) {
								//2011年初已有10年工龄的，即2001年1月1日前入职，此时$Accrual[0]＝25
								$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
							}
							elseif (strtotime($staff_info['onboard'])+$AccrualTime[2]<$tmp_time2) {
								//去年达到10年工龄的，在2017年后才会出现
								$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
								$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
								$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
							}
							elseif (strtotime($staff_info['onboard'])+$AccrualTime[1] < $tmp_time1) {
								//2011年初已有4年工龄的，即2007年1月1日入职，此时$Accrual[0]＝20
								$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
							}
							elseif (strtotime($staff_info['onboard'])+$AccrualTime[1]<$tmp_time2) {
								//去年达到4年工龄的
								$tmp_balance_hour += (strtotime($staff_info['onboard'])+$AccrualTime[1]-$tmp_time1)/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[0]][0]*8;
								if (strtotime($staff_info['onboard'])+$AccrualTime[2] >= $tmp_time2) {
									//去年未达到10年的
									$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
								}
								else {
									$tmp_balance_hour += ($AccrualTime[2]-$AccrualTime[1])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[1]][0]*8;
									$tmp_balance_hour += ($tmp_time2-strtotime($staff_info['onboard'])-$AccrualTime[2])/86400/365*$this->Absence_Config['accrualrate'][$AccrualTime[2]][0]*8;
								}
							}
							else {
								$tmp_balance_hour += (date('Y', $this->time)-2011)*$Accrual[0]*8;
							}
						}
						$tmp_balance_hour = round($tmp_balance_hour);
						$total_leave = $added_annual_hour + $tmp_balance_hour - $used_annual_hours;
					}
				}
				break;
			
			case 'Compensatory':
				$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $this->time)-3, date('d', $this->time), date('Y', $this->time)));
				$where = array(
					'id' => array('neq', $id),
					'type'=> 'Overtime',
					'staff_id' => $staff_id,
					'time_from' => array('egt', $date_3month_ago),
					'status' => 1
					);
				$total_leave = $this->dao->where($where)->sum('hours_remain');
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
		if (!is_numeric($hour)) {
			return $hour;
		}
		$unit1 = ' hour';
		if ($hour>1) {
			$unit1 = ' hours';
		}
		$day = round($hour/8, 1);
		$unit2 = '&nbsp;day';
		if ($day>1) {
			$unit2 = '&nbsp;days';
		}
		return round($hour).$unit1.' ('.$day.$unit2.')';
	}
	private function calculateHour($date_from, $time_from, $date_to, $time_to) {
		global $hour;
		echo $hour."\n";
		$from = $date_from.' '.$time_from;
		$stamp_from = strtotime($from);
		while (date('N', $stamp_from)>=6 && !in_array($date_from, $this->Absence_Config['workday'])) {//如果开始时间在周末，且不是法定上班日，则跳过该日
			$stamp_from += 86400;
			$date_from = date('Y-m-d', $stamp_from);
			$time_from = $this->Absence_Config['worktime'][0][0];
			$from = $date_from.' '.$time_from;
		}
		while (date('N', $stamp_from)<=5 && in_array($date_from, $this->Absence_Config['holiday'])) {//如果是工作日，但却是法定休息日，则跳过该日
			$stamp_from += 86400;
			$date_from = date('Y-m-d', $stamp_from);
			$time_from = $this->Absence_Config['worktime'][0][0];
			$from = $date_from.' '.$time_from;
		}
		while (date('N', $stamp_from)>=6 && !in_array($date_from, $this->Absence_Config['workday'])) {//如果开始时间在周末，且不是法定上班日，则跳过该日
			$stamp_from += 86400;
			$date_from = date('Y-m-d', $stamp_from);
			$time_from = $this->Absence_Config['worktime'][0][0];
			$from = $date_from.' '.$time_from;
		}
		while (date('N', $stamp_from)<=5 && in_array($date_from, $this->Absence_Config['holiday'])) {//如果是工作日，但却是法定休息日，则跳过该日
			$stamp_from += 86400;
			$date_from = date('Y-m-d', $stamp_from);
			$time_from = $this->Absence_Config['worktime'][0][0];
			$from = $date_from.' '.$time_from;
		}
		echo $from."\n";
		$to = $date_to.' '.$time_to;
		$stamp_to = strtotime($to);
		while (date('N', $stamp_to)<=5 && in_array($date_to, $this->Absence_Config['holiday'])) {//如果是工作日，但却是法定休息日，则后退一日
			$stamp_to -= 86400;
			$date_to = date('Y-m-d', $stamp_to);
			$time_to = $this->Absence_Config['worktime'][1][1];
			$to = $date_to.' '.$time_to;
		}
		while (date('N', $stamp_to)>=6 && !in_array($date_to, $this->Absence_Config['workday'])) {//如果结束时间在周末，且不是法定上班日，则后退一日
			$stamp_to -= 86400;
			$date_to = date('Y-m-d', $stamp_to);
			$time_to = $this->Absence_Config['worktime'][1][1];
			$to = $date_to.' '.$time_to;
		}
		while (date('N', $stamp_to)<=5 && in_array($date_to, $this->Absence_Config['holiday'])) {//如果是工作日，但却是法定休息日，则后退一日
			$stamp_to -= 86400;
			$date_to = date('Y-m-d', $stamp_to);
			$time_to = $this->Absence_Config['worktime'][1][1];
			$to = $date_to.' '.$time_to;
		}
		while (date('N', $stamp_to)>=6 && !in_array($date_to, $this->Absence_Config['workday'])) {//如果结束时间在周末，且不是法定上班日，则后退一日
			$stamp_to -= 86400;
			$date_to = date('Y-m-d', $stamp_to);
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
					//09:01~12:00
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
	/*
	type:邮件通知类型
	默认：通知领导审批
	deputy:特别通知deputy
	notify:休假当日通知所有相关人员
	*/
	private function mail_application($dao, $type='') {
		global $LeaveType;
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
		timespan		approvor					notification CC list
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
		$leader = array(
			'email' => 'bin.li@agigatech.com',
			'realname' => 'Bin.Li'
		);
		if (!empty($staff['leader_id'])) {
			//get leader info, 如果没有leader或leader没有email，将默认发给Bin.Li
			$rs = M('Staff')->find($staff['leader_id']);
			!empty($rs['email']) && ($leader = $rs);
		}

		switch($type) {
			case 'deputy':
				$subject = '[Absence] Need Deputy: '.$staff['realname'].', '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
				$mail->AddAddress($deputy['email'], $deputy['realname']);
				break;

			case 'notify':
				$subject = '[Absence] Absent: '.$staff['realname'].', '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
				if ('Out'==$dao->type) {
					$subject = '[Absence] Out of Office: '.$staff['realname'].', '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
				}
				if ('Out'==$dao->type || $dao->hours <= 8) {
					$mail->AddAddress($leader['email'], $leader['realname']);
					if (!empty($deputy)) {
						$mail->AddCC($deputy['email'], $deputy['realname']);
					}
					foreach ($this->Absence_Config['application']['level_0']['cc'] as $name=>$email) {
						$mail->AddCC($email, $name);
					}
				}
				elseif ($dao->hours <= 16) {
					$mail->AddAddress($leader['email'], $leader['realname']);
					if (!empty($deputy)) {
						$mail->AddCC($deputy['email'], $deputy['realname']);
					}
					foreach ($this->Absence_Config['application']['level_1']['cc'] as $name=>$email) {
						$mail->AddCC($email, $name);
					}
				}
				else {
					$mail->AddAddress($leader['email'], $leader['realname']);
					if (!empty($deputy)) {
						$mail->AddCC($deputy['email'], $deputy['realname']);
					}
					foreach ($this->Absence_Config['application']['level_2']['cc'] as $name=>$email) {
						$mail->AddCC($email, $name);
					}
				}
				break;

			default:
				$subject = '[Absence] Application: '.$staff['realname'].' apply for leave, '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
				if ('Overtime' == $dao->type) {
					$subject = '[Absence] Application: '.$staff['realname'].' apply for overtime, '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16);
				}
				if ($dao->hours <= 8) {
					if ($dao->status == 0) {//待批准，通知leader
						$mail->AddAddress($leader['email'], $leader['realname']);
						$new_status = 1;
					}
					elseif ($dao->status == 1) {//通过，通知staff+deputy+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is approved.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
						if (!empty($deputy)) {
							self::mail_application($dao, 'deputy');
						}
					}
					elseif ($dao->status == 2) {//拒绝，通知staff+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is rejected.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
					}
				}
				elseif ($dao->hours <= 16) {
					if ($dao->status == -1) {//待批准，通知leader
						$mail->AddAddress($leader['email'], $leader['realname']);
						$new_status = 0;
					}
					elseif ($dao->status == 0) {//待批准，通知director
						list($name, $email) = each($this->Absence_Config['application']['level_1']['approver']);
						$mail->AddAddress($email, $name);
						$new_status = 1;
					}
					elseif ($dao->status == 1) {//通过，通知staff+leader+deputy+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is approved.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						$mail->AddCC($leader['email'], $leader['realname']);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
						if (!empty($deputy)) {
							self::mail_application($dao, 'deputy');
						}
					}
					elseif ($dao->status == 2) {//拒绝，通知staff+leader+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is rejected.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						$mail->AddCC($leader['email'], $leader['realname']);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
					}
				}
				else {
					if ($dao->status == -2) {//待批准，通知leader
						$mail->AddAddress($leader['email'], $leader['realname']);
						$new_status = -1;
					}
					elseif ($dao->status == -1) {//待批准，通知director
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$mail->AddAddress($email, $name);
						$new_status = 0;
					}
					elseif ($dao->status == 0) {//待批准，通知VP
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$mail->AddAddress($email, $name);
						$new_status = 1;
					}
					elseif ($dao->status == 1) {//通过，通知staff+leader+director+deputy+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is approved.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						$mail->AddCC($leader['email'], $leader['realname']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$mail->AddCC($email, $name);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
						if (!empty($deputy)) {
							self::mail_application($dao, 'deputy');
						}
					}
					elseif ($dao->status == 2) {//拒绝，通知staff+leader+director+HR
						$subject = '[Absence] Notification: '.$staff['realname'].', your application is rejected.';
						$mail->AddAddress($staff['email'], $staff['realname']);
						$mail->AddCC($leader['email'], $leader['realname']);
						list($name, $email) = each($this->Absence_Config['application']['level_2']['approver']);
						$mail->AddCC($email, $name);
						foreach ($this->Absence_Config['notification'] as $name=>$email) {
							$mail->AddCC($email, $name);
						}
					}
				}
		}
		$mail->Subject    = $subject;
		
		$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
		$body .= '<form name="_form" id="_form" action="'.APP_ROOT.'/Public/absence_confirm" method="post" target="_blank">';
		$body .= '<input type="hidden" name="id" value="'.$dao->id.'" />';
		$body .= '<input type="hidden" name="status" value="'.$new_status.'" />';
		$body .= '<input type="hidden" name="from" value="mail" />';
		$body .= '<table border="0" cellspacing="1" cellpadding="7" bgcolor="#CCCCCC">';
		if ('deputy' == $type) {
			$body .= '<tr><td colspan="2">'.$staff['realname'].' need deputy: '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
		}
		elseif ('notify' == $type) {
			$body .= '<tr><td colspan="2">'.$staff['realname'].' Absent: '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
		}
		else {
			if ('Overtime' == $dao->type) {
				$body .= '<tr><td colspan="2">'.$staff['realname'].' apply for overtime: '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
			}
			else {
				$body .= '<tr><td colspan="2">'.$staff['realname'].' apply for leave: '.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
			}
		}
		$body .= '<tr bgcolor="#FFFFFF"><td>Absence ID : </td><td>A'.sprintf('%05d', $dao->id).'</td></tr>';
		$body .= '<tr bgcolor="#FFFFFF"><td width="120">Applicant :</td><td width="400">'.$staff['realname'].'</td></tr>';
		$body .= '<tr bgcolor="#FFFFFF"><td>Type : </td><td>'.$LeaveType[$dao->type].'</td></tr>';
		$body .= '<tr bgcolor="#FFFFFF"><td>Duration : </td><td>'.substr($dao->time_from, 0, 16).' ~ '.substr($dao->time_to, 0, 16).'</td></tr>';
		if(!empty($dao->deputy_id)) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Deputy : </td><td>'.$deputy['realname'].'</td></tr>';
		}
		if (''!=$dao->note) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Note :</td><td>'.nl2br($dao->note).'</td></tr>';
		}
		if ($dao->status < 1) {
			$body .= '<tr bgcolor="#FFFFFF"><td>Comment :</td><td><textarea name="comment" cols="40" rows="4"></textarea></td></tr>';
			$body .= '<tr bgcolor="#FFFFFF"><td>Operation :</td><td><input type="submit" value="Approve" /><br />You can also do the operation in the <a target="_blank" href="'.APP_ROOT.'/Absence/approve">ERP System</a></td></tr>';
		}
		else {
			$body .= '<tr bgcolor="#FFFFFF"><td>Comment :</td><td>'.nl2br($dao->comment).'</td></tr>';
		}
		$body .= '</table>';
		$body .= '<br /><br />Best Regards,<br />ERP Absence System';
		$body .= '</form>';
		$body .= '</body></html>';

		$mail->MsgHTML($body);
		if(!$mail->Send()) {
			Log::Write('Mail Error: '.$mail->ErrorInfo, LOG::ERR);
			return false;
		}
		Log::Write('Mail Success: '.$type.' '.$dao->id, LOG::INFO);
		return true;
	}
	public function notify(){
		echo "======== [".date("Y-m-d H:i:s").'] '.MODULE_NAME.'.'.ACTION_NAME." ========\n";
		$where = array(
			'mail_status' => 0,
			'status' => 1,
			'type' => array('not in', array('Overtime', 'CashOut')),
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
			if (self::mail_application($this->dao, 'notify')) {
				if(false !== $this->dao->where('id='.$item['id'])->setField('mail_status',1)) {
					echo "Success!<br />\n";
					Log::Write('Notify '.$item['staff']['email'].' success', LOG::INFO);
				}
				else{
					echo 'SQL error'.(C('APP_DEBUG')?$this->dao->getLastSql():'');
				}
			}
		}
	}
	public function press(){
		echo "======== [".date("Y-m-d H:i:s").'] '.MODULE_NAME.'.'.ACTION_NAME." ========\n";
		$where = array(
			'status' => array('lt', 1),
			'create_time' => array('lt', date("Y-m-d"))
			);
		$rs = $this->dao->relation(true)->where($where)->select();
		if (empty($rs)) {
			echo 'No application to press';
			return;
		}
		echo 'Get '.count($rs)." records.<br />\n";
		foreach ($rs as $item) {
			echo "\tFor ID:".$item['id']."\t";
			$this->dao->find($item['id']);
			if (self::mail_application($this->dao)) {
				echo "Success!<br />\n";
				Log::Write('Press '.$item['staff']['email'].' success', LOG::INFO);
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
		$id = $_REQUEST['id'];
		$op = $_REQUEST['op'];
		$info = $this->dao->find($id);
		if (1==$info['status']) {
			if ('cancel'==$op) {
				self::_error('The application has been approved, you can\'t cancel it now!');
			}
			elseif ('Compensatory'==$info['type']) {
				//给Overtime记录的hours_remain中补回相应hour数
				$time = strtotime($info['time_from']);
				$date_3month_ago = date('Y-m-d', mktime(0,0,0,date('m', $time)-3, date('d', $time), date('Y', $time)));
				$where = array(
					'type'=> 'Overtime',
					'staff_id' => $info['staff_id'],
					'time_from' => array('egt', $date_3month_ago),
					'status' => 1
					);
				$rs = $this->dao->where($where)->order('time_from')->select();
				foreach ($rs as $row) {
					$add = min($row['hours'] - $row['hours_remain'], $info['hours']);
					$new_remain = $row['hours_remain']+$add;
					$this->dao->where('id='.$row['id'])->setField('hours_remain', $new_remain);
					$info['hours'] -= $add;
					if ($info['hours']<=0) {
						break;
					}
				}
			}
		}
		self::_delete();
	}
}
?>