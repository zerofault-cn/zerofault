<?php
class UserAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
	}

	public function index() {
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function register() {
		if (!empty($_POST['submit'])) {
			if($_SESSION['verify'] != md5(trim($_REQUEST['verify']))) {
				self::_error('验证码错误!');
			}
			$email = trim($_REQUEST['email']);
			empty($email) && self::_error('邮箱地址必须填写！');
			!eregi("^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}[0-9a-z]\.){1,4}[a-z]{2,4}$", $email) && self::_error('邮箱地址格式错误！');
			//检测邮箱是否已注册
			$rs = $this->dao->where("email='".$email."'")->find();
			if (!empty($rs) && count($rs)>0) {
				self::_error('该邮箱地址已被注册过！');
			}
			$realname = trim($_REQUEST['realname']);
			empty($realname) && self::_error('真实姓名必须填写！');
			$sex = intval($_REQUEST['sex']);
			empty($sex) && self::_error('性别必须选择！');
			$password = trim($_REQUEST['password']);
			empty($password) && self::_error('密码不能为空！');
			strlen($password)<6 && self::_error('密码至少需要6个字符！');
			strlen($password)>20 && self::_error('密码不能超过20个字符！');
			$password2 = trim($_REQUEST['password2']);
			$password!=$password2 && self::_error('两次输入的密码不一致！');

			$this->dao->type = 1;
			$this->dao->email = $email;
			$this->dao->password = md5($password);
			$this->dao->realname = $realname;
			$this->dao->sex = $sex;
			$this->dao->reg_time = date('Y-m-d H:i:s');
			$this->dao->status = 1;
			if($user_id = $this->dao->add()) {
				$_SESSION[C('USER_ID')] = $user_id;
				$_SESSION['user_name'] = $realname;
				if (!empty($_REQUEST['last_url']) && substr($_REQUEST['last_url'], -8)!='register' && substr($_REQUEST['last_url'], -5)!='login') {
					self::_success('注册成功，即将跳转到之前的页面！', $_REQUEST['last_url']);
				}
				else {
					self::_success('注册成功，即将跳转到首页！', __APP__);
				}
				self::_success('注册成功！');
			}
			else {
				self::_error('注册过程中发生未知错误！');
			}
			$this->assign('last_url', $_REQUEST['last_url']);
			$this->display('Layout:default');
			exit;
		}
		elseif (!empty($_SESSION[C('USER_ID')])) {
			redirect(__APP__);
		}
		$this->assign('last_url', $_SERVER['HTTP_REFERER']);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function login() {
		if (!empty($_POST['submit'])) {
			$email = trim($_REQUEST['email']);
			$password = trim($_REQUEST['password']);
			$keepme = intval($_REQUEST['keepme']);
			$where = array(
				'email' => $email,
				'password' => md5($password),
				'status' => 1
				);
			$rs = $this->dao->where($where)->find();
			if (!empty($rs) && count($rs)>0) {
				$_SESSION[C('USER_ID')] = $rs['id'];
				$_SESSION['user_name'] = $rs['realname'];
				if ($keepme) {
					cookie(C('USER_ID'), $rs['id']);
				}
				$this->dao->where("id=".$rs['id'])->setField('login_time', date('Y-m-d H:i:s'));
				if (!empty($_REQUEST['last_url']) && substr($_REQUEST['last_url'], -8)!='register') {
					self::_success('登录成功，即将跳转到之前的页面！', $_REQUEST['last_url']);
				}
				else {
					self::_success('登录成功，即将跳转到首页！', __APP__);
				}
			}
			else {
				self::_error('账号不存在或已被禁用！');
			}
			$this->display('Layout:default');
			exit;
		}
		elseif (!empty($_SESSION[C('USER_ID')])) {
			redirect(__APP__);
		}
		$this->assign('last_url', $_SERVER['HTTP_REFERER']);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function logout(){
		$_SESSION[C('USER_ID')] = 0;
		cookie(C('USER_ID'), null);
		self::_success('注销成功！', __APP__, 500, 'header_message_box');
	}
}
?>