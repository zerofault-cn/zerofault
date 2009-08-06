<?php

class UserAction extends BaseAction{
	
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
		$dao = D('User');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','User:index');
		$this->display('Layout:Admin_layout');
	}

}
?>