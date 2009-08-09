<?php
/**
*
* 用户管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class UserAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
	}
	/**
	*
	* 用户列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/User'
			);
		$topnavi[]=array(
			'text'=> '用户列表',
			);
		$where = array();
		if(!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$user_info = $this->dao->relation(true)->where('id='.$_REQUEST['id'])->find();
		}
		$rs = $this->dao->relation(true)->where($where)->select();
		
		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('user_info', $user_info);
		$this->assign('role_list', D("Role")->where(array('status'=>1))->select());
		$this->assign('content','User:index');
		$this->display('Layout:Admin_layout');
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
		$account = $_REQUEST['account'];
		$name = $_REQUEST['name'];
		$name || $name = $account;
		$password = $_REQUEST['password'];
		$role_ids = $_REQUEST['role_ids'];
		$role_ids || $role_arr = array();
		$role_ids && $role_id_arr = explode(',', $role_ids);
		foreach($role_id_arr as $role_id) {
			$role_arr[] = array('id'=>$role_id);
		}
		$where['account'] = $account;
		$rs = $this->dao->where($where)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$this->dao->account = $account;
		$this->dao->name = $name;
		$this->dao->password = md5($password);
		$this->dao->create_time = $this->dao->login_time = date("Y-m-d H:i:s");
		$this->dao->status = 1;
		$this->dao->Role = $role_arr;
		if($this->dao->relation(true)->add()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}
	public function update(){
		$id = $_REQUEST['id'];
		$name = $_REQUEST['name'];
		$role_ids = $_REQUEST['role_ids'];
		$role_ids || $role_arr = array() && $role_id_arr = array();
		$role_ids && $role_id_arr = explode(',', $role_ids);
		foreach($role_id_arr as $role_id) {
			$role_arr[] = array('id'=>$role_id);
		}
		$this->dao->find($id);
		$this->dao->name = $name;
		$this->dao->Role = $role_arr;
		if($this->dao->relation(true)->save()){
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
	public function chgpwd(){
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