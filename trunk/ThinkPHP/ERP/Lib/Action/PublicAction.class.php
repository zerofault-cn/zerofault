<?php
/**
*
* 公共操作类
* 无需RBAC认证
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class PublicAction extends BaseAction{
	/**
	*
	* 验证是否已登录，如果未登录，显示登录框
	*/
	public function login() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('content','login');
			$this->display('Layout:base');
		}else{
			redirect(__URL__);
		}
	}
	/**
	*
	* 验证并保存登录信息
	*/
	public function checkLogin(){
		if(empty($_REQUEST['name'])) {
			die(self::_error('User ID required'));
		}
		elseif (empty($_REQUEST['password'])){
			die(self::_error('Password Required'));
		}
		//生成认证条件
		$map			= array();
		$map["name"]	= $_REQUEST['name'];
		$map['password']= md5($_REQUEST['password']);
		$map["status"]	= 1;

		// 进行委托认证
		$authInfo = RBAC::authenticate($map, 'Staff');
		if(false === $authInfo) {
			die(self::_error('Error: Wrong account or password!'));
		}
		else{
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION['loginUserName']		=	$authInfo['realname'];
			if($authInfo['name']=='admin') {
				// 管理员不受权限控制影响
				$_SESSION['administrator']	=	true;
			}
			else{
				$_SESSION['administrator']	=	false;
			}
			// 缓存访问权限
			RBAC::saveAccessList($authInfo['id']);
			die(self::_success('Success!',__APP__.'/'.Session::get('lastModule'),0));
		}
	}
	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		die(self::_success('You have Logout!', __APP__, 500));
	}

}
?>