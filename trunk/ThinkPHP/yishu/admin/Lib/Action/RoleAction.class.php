<?php

class RoleAction extends Action{
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