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
		if(empty($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('content', ACTION_NAME);
			$this->display();
		}
		else{
			redirect(__APP__);
		}
	}
	/**
	*
	* 验证并保存登录信息
	*/
	public function checkLogin(){
		$User	=	D('Admin');
		if(''==trim($_REQUEST['username'])) {
			die(self::_error('用户名必须!'));
		}
		elseif (''==trim($_REQUEST['password'])){
			die(self::_error('密码必须！'));
		}
		$where = array(
			'username' => trim($_POST['username']),
			'password' => md5(trim($_POST['password']))
			);

		$info = $User->where($where)->find();
		if(empty($info)) {
			self::_error('登录失败，请检查用户名和密码是否有误！');
		}
		else{
			if ($info['status'] < 1) {
				self::_error('此用户账号已被停用！');
			}
			$_SESSION[C('USER_AUTH_KEY')]	=	$info['id'];
			$_SESSION['admin_name'] = empty($info['realname'])?$info['username']:$info['realname'];
			$User->where("id=".$info['id'])->setField('login_time', date('Y-m-d H:i:s'));
			self::_success('登陆成功！',__APP__.'/'.Session::get('lastModule'),500);
		}
	}
	/**
	*
	* 注销处理
	*/
	public function logout(){
		$_SESSION[C('USER_AUTH_KEY')] = 0;
		self::_success('注销成功！', __APP__, 500);
	}

}
?>