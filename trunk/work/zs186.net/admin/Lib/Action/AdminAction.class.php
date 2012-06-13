<?php
class AdminAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Admin');
		parent::_initialize();
	}
	public function index(){
		$topnavi[]=array(
			'text'=> '管理员管理',
			'url' => __APP__.'/Admin'
			);
		$topnavi[]=array(
			'text'=> '管理员列表',
			);
		$where = array();
		if(!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$user_info = $this->dao->where('id='.$_REQUEST['id'])->find();
		}
		$rs = $this->dao->where($where)->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('user_info', $user_info);
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
		$this->dao->username = $username;
		$this->dao->realname = $realname;
		$this->dao->password = md5($password);
		$this->dao->create_time = $this->dao->login_time = date("Y-m-d H:i:s");
		$this->dao->status = 1;
		if($this->dao->add()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}
	public function edit(){
		$id = $_REQUEST['id'];
		$realname = $_REQUEST['realname'];
		$this->dao->find($id);
		$this->dao->realname = $realname;
		if(false !== $this->dao->save()){
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