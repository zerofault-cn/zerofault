<?php
class AdminAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Admin');
		parent::_initialize();
	}
	public function index(){
		$topnavi[]=array(
			'text'=> '管理员列表',
			);
		$this->assign("topnavi",$topnavi);

		$where = array();
		if(!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$user_info = $this->dao->relation(true)->where('id='.$_REQUEST['id'])->find();
		}
		$rs = $this->dao->relation(true)->where($where)->select();
		$this->assign('list',$rs);
		$this->assign('user_info', $user_info);
		$this->assign('role_list', D("Role")->where(array('status'=>1))->select());
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	/**
	*
	* 添加用户
	* 只能被JQuery.post()调用
	* 返回值：
	*     -1：已存在同名纪录；
	*      1：操作成功；
	*   其它：出错的SQL语句
	*/
	public function add(){
		$username = $_REQUEST['username'];
		$realname = $_REQUEST['realname'];
		$realname || ($realname=$username);
		$password = $_REQUEST['password'];
		$rs = $this->dao->where("username='".$username)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$role_ids = $_REQUEST['role_ids'];
		$role_ids || $role_arr = array();
		$role_ids && $role_id_arr = explode(',', $role_ids);
		foreach($role_id_arr as $role_id) {
			$role_arr[] = array('id'=>$role_id);
		}
		$this->dao->username = $username;
		$this->dao->realname = $realname;
		$this->dao->password = md5($password);
		$this->dao->create_time = $this->dao->login_time = date("Y-m-d H:i:s");
		$this->dao->status = 1;
		$this->dao->Role = $role_arr;
		if($this->dao->relation(true)->add()) {
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}
	public function edit(){
		$id = $_REQUEST['id'];
		$realname = $_REQUEST['realname'];
		$role_ids = $_REQUEST['role_ids'];
		$role_arr = array();
		$role_id_arr = array();
		$role_ids && $role_id_arr = explode(',', $role_ids);
		foreach($role_id_arr as $role_id) {
			$role_arr[] = array('id'=>$role_id);
		}
		$this->dao->find($id);
		$this->dao->realname = $realname;
		$this->dao->Role = $role_arr;
		if(false !== $this->dao->relation(true)->save()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}

	/**
	*
	* 调用基类方法
	*/
	public function update(){
		'password'==$_REQUEST['f'] && ($_REQUEST['v']=md5($_REQUEST['v']));
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}
}
?>