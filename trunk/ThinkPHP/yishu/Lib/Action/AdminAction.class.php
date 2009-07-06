<?php
class AdminAction extends Action{
	var $lastAction;
	private function _htmlentities($str){
		return mb_convert_encoding($str,'HTML-ENTITIES', 'UTF-8');
	}

	public function _initialize() {
		//每个操作都会执行此方法
		if(!Cookie::get('isAdmin') && ACTION_NAME != 'login_form' && ACTION_NAME != 'login'){
			$this->lastAction = ACTION_NAME;
			redirect(__APP__.'/Admin/login_form',1,$this->_htmlentities('转向登录窗口'));
		}
	}
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'dvmadmin' == $password){
			Cookie::set('isAdmin',1,time()+43200);
			redirect(__APP__.'/Admin/'.$this->lastAction,1,$this->_htmlentities('登录成功'));
		}
		elseif('admin' == $username){
			redirect(__APP__.'/Admin/login_form',2,$this->_htmlentities('密码错误，请重试'));
		}
		else{
			redirect(__APP__.'/Admin/login_form',2,$this->_htmlentities('错误的管理员帐号，请重试'));
		}
	}
	public function logout(){
		Cookie::delete('isAdmin');
		redirect(__APP__.'/Admin/',1,$this->_htmlentities('退出成功！'));
	}

	public function index(){
		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
	public function cate_list(){
		$dao = D('Category');
		$where['flag'] = array('gt', -1);
		$order = 'flag desc, sort';
		$rs = $dao->where($where)->order($order)->select();
		$this->assign('list',$rs);
		$this->assign('content','cate_list');
		$this->display('Layout:Admin_layout');
	}
	public function cate_add(){
		$this->assign('content','cate_add');
		$this->display('Layout:Admin_layout');
	}
}
?>