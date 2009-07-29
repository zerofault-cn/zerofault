<?php
class RoleAction extends PublicAction{
	/**
	*
	* 用户列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '角色管理',
			'url' => __APP__.'/Role/'
			);
		$topnavi[]=array(
			'text'=> '角色列表',
			);
		$dao = D('Role');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','Role:index');
		$this->display('Layout:Admin_layout');
	}

}
?>