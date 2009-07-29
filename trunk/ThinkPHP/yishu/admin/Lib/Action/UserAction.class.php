<?php

class UserAction extends PublicAction{
	
	/**
	*
	* 用户列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/Admin/user_list'
			);
		$topnavi[]=array(
			'text'=> '用户列表',
			);
		$dao = D('User');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','User:index');
		$this->display('Layout:Admin_layout');
	}

}
?>