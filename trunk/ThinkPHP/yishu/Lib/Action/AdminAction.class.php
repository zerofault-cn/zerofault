<?php
class AdminAction extends Action{
	public function index(){
		if(!cookie::get('isAdmin')){
			redirect(__APP__.'/admin/login_form',1,'转向登录窗口');
		}
		else{
			$this->assign('cate_list',$cate_list);
			$this->display();
		}
	}

	public function login_form(){
		$this->display();
	}
	public function login(){

		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'admin' == $password)
		{
			cookie::set('isAdmin',1);
			redirect(__APP__.'/admin',1,'登录成功');
		}
	}
}
?>