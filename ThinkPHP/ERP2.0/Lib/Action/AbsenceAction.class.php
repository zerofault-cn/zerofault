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
		$this->assign('content', MODULE_NAME.':'.ACTION_NAME);
		$this->display('Layout:ERP_layout');
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
		$name = trim($_REQUEST['name']);
		!$name && self::_error('Staff Name required!');
		$password = trim($_REQUEST['password']);
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
			empty($password) && self::_error('Password required!');
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('The name: '.$name.' has been used by another staff!');
			}
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'E'.sprintf("%04d",$max_id+1);
			$this->dao->code = $code;
			$this->dao->password = md5($password);
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->name = $name;
		$this->dao->realname = trim($_REQUEST['realname']);
		$this->dao->email = trim($_REQUEST['email']);
		$this->dao->dept_id = $_REQUEST['dept_id'];
		$this->dao->leader_id = $_REQUEST['leader_id'];
		$this->dao->is_leader = intval($_REQUEST['is_leader']);
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