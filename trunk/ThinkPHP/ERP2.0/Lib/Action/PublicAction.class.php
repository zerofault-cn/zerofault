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
			self::_error('User ID required');
		}
		elseif (empty($_REQUEST['password'])){
			self::_error('Password Required');
		}
		//生成认证条件
		$map			= array();
		$map["name"]	= $_REQUEST['name'];
		$map['password']= md5($_REQUEST['password']);
		$map["status"]	= 1;

		// 进行委托认证
		$authInfo = RBAC::authenticate($map);
//		dump($authInfo);
		if(empty($authInfo)) {
			self::_error('Error: Wrong User ID or Password!');
		}
		else{
			D('Staff')->where('id='.$authInfo['id'])->setField('login_time',date("Y-m-d H:i:s"));
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION['loginUserName']		=	$authInfo['realname'];
			if($authInfo['id']=='1') {
				// 管理员不受权限控制影响
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	true;
			}
			else{
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	false;
			}
			// 缓存访问权限
			RBAC::saveAccessList($authInfo['id']);
			self::_success('',__APP__.'/'.Session::get('lastModule'),0);
		}
	}
	public function profile() {
		if(!empty($_POST['submit'])) {
			if(empty($_SESSION[C('USER_AUTH_KEY')])) {
				self::_error('You haven\'t login or session timeout!');
			}
			$realname = trim($_REQUEST['realname']);
			if(M('Staff')->where(array('realname'=>$realname,'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->find()) {
				self::_error('The realname: '.$realname.' has been used by another staff!');
			}
			$staff = M('Staff');
			$staff->find($_SESSION[C('USER_AUTH_KEY')]);
			if(''!=trim($_REQUEST['password'])) {
				if(''==trim($_REQUEST['old_password'])) {
					self::_error('You must enter your old password!');
				}
				if(md5(trim($_REQUEST['old_password'])) != $staff->password) {
					self::_error('You old password is wrong!');
				}
				$staff->password = md5(trim($_REQUEST['password']));
			}
			$staff->realname = $realname;
			$staff->email = trim($_REQUEST['email']);
			if($staff->save()) {
				self::_success('Update success!');
			}
			exit;
		}
		if(empty($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('message','<p class="center">You haven\'t login or session timeout!<br /><br /><br /><input type="button" value="Close" onclick="tb_remove();" /></p>');
			$this->assign('content','Public:error');
			$this->display('Layout:base');
			return;
		}
		$info = D('Staff')->relation(true)->find($_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('info', $info);
		$this->assign('content', 'Public:profile');
		$this->display('Layout:base');
	}
	
	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		self::_success('You have Logout!', __APP__);
	}

}
?>