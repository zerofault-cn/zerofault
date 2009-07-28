<?php

class GroupAction extends Action{
	/**
	*
	* 对象初始化时自动执行
	*/
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
	//	dump($_SESSION);

		import('ORG.RBAC.RBAC');
		// 检查认证
		if(RBAC::checkAccess()) {
			//检查认证识别号
			if(!$_SESSION[C('USER_AUTH_KEY')]) {
				//记下刚才的Action
				Session::set('lastAction', ACTION_NAME);
				//跳转到认证网关
				redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
			}
			// 检查权限
			if(!RBAC::AccessDecision()) {
				$this->assign('message','没有权限！');
				$this->assign('content','error');
				$this->display('Layout:Admin_layout');
				exit;
			}
		}
	}
	
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