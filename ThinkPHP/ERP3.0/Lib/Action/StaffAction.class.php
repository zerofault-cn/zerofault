<?php
/**
*
* 员工
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class StaffAction extends BaseAction{

	protected $dao, $time;

	public function _initialize() {
		session('top', 'Basic Data');
		session('sub', MODULE_NAME);
		$this->dao = D('Staff');
		$this->time = time();
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Staff');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');
		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(session('staff_status'))) {
			$status = session('staff_status');
		}
		else{
			$status = 1;
		}
		//Session::set('staff_status', $status);
		$this->assign('status', $status);
		$this->assign('result', $this->dao->relation(true)->where(array('status'=>$status))->order('id')->select());
		$this->display();
	}

	public function form() {
		$this->assign('ACTION_TITLE', 'Add New Staff');
		$this->assign('Balance_year', date('Y', $this->time)-1);
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$this->assign('ACTION_TITLE', 'Edit Staff');
			$info = $this->dao->relation(true)->find($id);
			$info['dept_opts'] = self::genOptions(M('Department')->select(), $info['dept_id']);
			$info['leader_opts'] = self::genOptions($this->dao->where(array('is_leader'=>1))->select(), $info['leader_id'],'realname');
			$info['role_chks'] = self::genCheckbox(D("Role")->where(array('status'=>1))->select(),$info['role'],'role');
			$code = $info['code'];
		}
		else {
			$info = array(
				'id'=>0,
				'name'=>'',
				'realname'=>'',
				'password'=>'',
				'email'=>'',
				'onboard' => date('Y-m-d'),
				'dept_opts' => self::genOptions(M('Department')->select()),
				'leader_opts'=>self::genOptions($this->dao->where(array('is_leader'=>1))->select(),'','realname'),
				'role_chks' => self::genCheckbox(D("Role")->where(array('status'=>1))->select(),'','role')
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'E'.sprintf("%04d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->display();
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Staff Name required!');
		$password = trim($_REQUEST['password']);
		$email = trim($_REQUEST['email']);
		empty($email) && self::_error('E-mail required!');
		!eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$", $email) && self::_error('E-mail address is abnormal!');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			//for edit
			if(1==$id && 1!=$_SESSION[C('USER_AUTH_KEY')]) {
				self::_error('You can\'t edit Super Administrator');
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
		$this->dao->email = $email;
		$this->dao->onboard = $_REQUEST['onboard'];
		$this->dao->balance = $_REQUEST['balance'];
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
			if($staff_id = $this->dao->relation(true)->add()) {
				$this->dao->id = $staff_id;
				self::sync_user($this->dao);
				self::_success('Add staff success!',__URL__);
			}
			else{
				self::_error('Add staff fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function profile() {
		if (!empty($_POST['submit'])) {
			$realname = trim($_REQUEST['realname']);
			if($this->dao->where(array('realname'=>$realname,'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->find()) {
				self::_error('The realname \"'.$realname.'\" has been used by another staff!');
			}
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->find($id);
			if (''!=trim($_REQUEST['password'])) {
				if(''==trim($_REQUEST['old_password'])) {
					self::_error('You must enter your old password!');
				}
				if(md5(trim($_REQUEST['old_password'])) != $this->dao->password) {
					self::_error('You old password is wrong!');
				}
				$this->dao->password = md5(trim($_REQUEST['password']));
				session(null);
			}
			$this->dao->realname = $realname;
			$this->dao->email = trim($_REQUEST['email']);
			if (false !== $this->dao->save()) {
				self::sync_user($this->dao);
				self::_success('Update success!');
			}
		}
		else {
			$info = $this->dao->relation(true)->find($_SESSION[C('USER_AUTH_KEY')]);
			$this->assign('info', $info);
			C('LAYOUT_NAME', 'Layout/content');
			$this->display('Staff:profile');
		}
	}
	public function sync_users() {
		echo "======== [".date("Y-m-d H:i:s").'] '.MODULE_NAME.'.'.ACTION_NAME." ========\n";
		$rs = $this->dao->select();
		empty($rs) && ($rs = array());
		foreach ($rs as $user) {
			self::sync_user($user);
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
		}
	}
}
?>