<?php
/**
*
* Absence系统
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class AbsenceAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'Absence');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Absence');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Absence');
	}

	public function index() {
		$time = time();
	//	$time = mktime(0,0,0,2,2,2011);//for test
		$staff_info = D('Staff')->relation(true)->find($_SESSION[C('USER_AUTH_KEY')]);
		$leave_info = array();
		$leave_info['Annual_year'] = date('Y', $time);
		$leave_info['Balance_year'] = date('Y', $time)-1;

		if (strcmp($staff_info['onboard'], date('Y', $time).'-01-00') == 1) {//当年入职的员工，从入职之日算起
			$leave_info['Annual'] = round(($time-strtotime($staff_info['onboard']))/86400/30*1.25, 1);
			$leave_info['Balance'] = 0;//往年余额
		}
		else {//其余员工从当年01-01算起
			$leave_info['Annual'] = round(date('z', $time)/30*1.25, 1);
			if (date('Y', $time)==2010) {
				//如果现在是2010年，则剩余年假不用计算
				$leave_info['Balance'] = $staff_info['balance_2009'];
			}
			else {
				//2011年或以后
				if (strcmp($staff_info['onboard'], '2010-01-00') == 1) {
					//该员工在2010年后入职，则剩余年假从入职日起计算至去年结束
					$leave_info['Balance'] = round((mktime(0,0,0,1,1,date('Y', $time))-strtotime($staff_info['onboard']))/86400/30*1.25, 1);
				}
				else {
					//该员工在2010年前入职，则用2009年剩余年假 ＋ 2010至去年结束年假
					$leave_info['Balance'] = $staff_info['balance_2009'] + round((mktime(0,0,0,1,1,date('Y', $time))-mktime(0,0,0,1,1,2010))/86400/30*1.25, 1);
				}
			}
		}
	//	dump($leave_info);
		$this->assign('staff_info', $staff_info);
		$this->assign('leave_info', $leave_info);
		$this->assign('ACTION_TITLE', 'Personal');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	
	public function form() {
		$Absence_Config = C('_absence_');
		$result = array();
		foreach($Absence_Config['leavetype'] as $key=>$val) {
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

		$time = time();
	//	$time = mktime(13,1,1,7,16,2010);
		if (date('N', $time)>5 || (date('N', $time)==5 && strcmp(date('H:i', $time), $Absence_Config['worktime'][1][0])>=0)) {//周末，或周五下午
			$time += (8-date('N', $time))*86400;
			$date_from = date('Y-m-d', $time);
			$time_from = $Absence_Config['worktime'][0][0];
			$date_to = date('Y-m-d', $time);
			$time_to = $Absence_Config['worktime'][1][1];
		}
		else {
			if (strcmp(date('H:i', $time), $Absence_Config['worktime'][0][0])<0) {//上午上班前
				$date_from = date('Y-m-d', $time+86400);
				$time_from = $Absence_Config['worktime'][0][0];
				$date_to = date('Y-m-d', $time+86400);
				$time_to = $Absence_Config['worktime'][1][1];
			}
			elseif (strcmp(date('H:i', $time), $Absence_Config['worktime'][1][0])<0) {//下午上班前
				$date_from = date('Y-m-d', $time);
				$time_from = $Absence_Config['worktime'][1][0];
				$date_to = date('Y-m-d', $time);
				$time_to = $Absence_Config['worktime'][1][1];
			}
			else {//下午上班后
				$date_from = date('Y-m-d', $time+86400);
				$time_from = $Absence_Config['worktime'][0][0];
				$date_to = date('Y-m-d', $time+86400);
				$time_to = $Absence_Config['worktime'][1][1];
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

		$this->assign('Notification', $Absence_Config['notification']);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
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
			self::_error('The end datetime must be later then the begin datetime');
		}
		$deputy = $_REQUEST['deputy'];
		$file_arr = array();
		foreach ($_FILES['file']['size'] as $i=>$size) {
			if ($size>0) {
				$file_arr[] = array(
					'name' => $_FILES['file']['name'][$i],
					'tmp_name' => $_FILES['file']['tmp_name'][$i]
					);
			}
		}
		$notification = $_REQUEST['notification'];
		$reason = trim($_REQUEST['reason']);
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			//for edit
			if(1==$id && 1!=$_SESSION[C('USER_AUTH_KEY')]) {
				self::_error("You can\'t edit Super Administrator");
			}
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('The name: '.$name.' has been used by another staff!');
			}
			$this->dao->find($id);
			if(''!=$password) {
				$this->dao->password = md5($password);
			}
		}
		else {
			//for add
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->type = $type;
		$this->dao->staff_id = $_SESSION[C('STAFF_AUTH_NAME')]['id'];
		$this->dao->creator_id = $_SESSION[C('STAFF_AUTH_NAME')]['id'];
		$this->dao->time_from = $date_from.' '.$time_from.':00';
		$this->dao->time_to = $date_to.' '.$time_to.':00';
		$this->dao->deputy_id = $deputy;
		$this->dao->notification = implode(';', $notification);
		$this->dao->status = 1;
		if (empty($_REQUEST['role'])) {
			$role_arr = array();
			//删除已有role
			M('StaffRole')->where('staff_id='.$id)->delete();
		}
		else{
			foreach($_REQUEST['role'] as $role_id) {
				$role_arr[] = array('id'=>$role_id);
			}
		}
		$this->dao->role = $role_arr;
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->relation(true)->save()){
				self::sync_user($this->dao);
				self::_success('Staff information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->relation(true)->add()) {
				self::sync_user($this->dao);
				self::_success('Add staff success!',__URL__);
			}
			else{
				self::_error('Add staff fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('ProductFlow')->where("to_type='staff' and to_id=".$id." and status=1")->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('Something relate to him, can\'t be deleted!');
		}
		else{
			self::_delete();
		//	self::sync_user($this->dao, 'delete');
		}
	}
}
?>