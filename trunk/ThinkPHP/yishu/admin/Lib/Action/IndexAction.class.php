<?php

class IndexAction extends Action{
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
	* 管理后台默认首页
	*/
	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
}
?>