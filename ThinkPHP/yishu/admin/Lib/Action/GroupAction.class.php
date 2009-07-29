<?php

class GroupAction extends PublicAction{
	/**
	*
	* 用户组列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '用户组管理',
			'url' => __APP__.'/Admin/user_list'
			);
		$topnavi[]=array(
			'text'=> '用户组列表',
			);
		$dao = D('Group');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','Group:index');
		$this->display('Layout:Admin_layout');
	}

}
?>