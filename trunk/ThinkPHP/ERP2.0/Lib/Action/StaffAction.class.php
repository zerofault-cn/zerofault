<?php
/**
*
* 员工
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class StaffAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Staff');
		parent::_initialize();
	}

	public function index(){
		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get('staff_status'))) {
			$status = Session::get('staff_status');
		}
		else{
			$status = 1;
		}
		Session::set('staff_status', $atatus);
		$this->assign('status', $status);
		$this->assign('result', $this->dao->relation(true)->where(array('status'=>$status))->select());
		$this->assign('content','Staff:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['dept_opts'] = self::genOptions(M('Department')->select(), $info['dept_id']);
			$info['leader_opts'] = self::genOptions($this->dao->where(array('is_leader'=>1))->select(), $info['leader_id'],'realname');
			$info['role_chks'] = self::genCheckbox(D("Role")->where(array('status'=>1))->select(),$info['role'],'role');
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'name'=>'',
				'realname'=>'',
				'password'=>'',
				'email'=>'',
				'dept_opts' => self::genOptions($dDepartment->select()),
				'leader_opts'=>self::genOptions($this->dao->where(array('is_leader'=>1))->select(),'','realname'),
				'role_chks' => self::genCheckbox(D("Role")->where(array('status'=>1))->select(),'','role')
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'E'.sprintf("%04d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('content', 'Staff:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Staff Name required');
		if(!empty($id) && $id>0) {
			//for edit
			if(1==$id && 1!=$_SESSION[C('USER_AUTH_KEY')]) {
				self::_error("You can\'t edit Super Administrator");
			}
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('The name: '.$name.' has been used by another staff!');
			}
			$this->dao->find($id);
			if(''!=trim($_REQUEST['password'])) {
				$this->dao->password = md5(trim($_REQUEST['password']));
			}
		}
		else{
			//for add
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('The name: '.$name.' has been used by another staff!');
			}
			$this->dao->code = $_REQUEST['code'];
			$this->dao->password = md5(trim($_REQUEST['password']));
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->name = $name;
		$this->dao->realname = trim($_REQUEST['realname']);
		$this->dao->email = trim($_REQUEST['email']);
		$this->dao->dept_id = $_REQUEST['dept_id'];
		$this->dao->leader_id = $_REQUEST['leader_id'];
		$this->dao->is_leader = intval($_REQUEST['is_leader']);
		$this->dao->status = 1;
		if(empty($_REQUEST['role'])) {
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
				self::_success('Staff information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->relation(true)->add()) {
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
}
?>