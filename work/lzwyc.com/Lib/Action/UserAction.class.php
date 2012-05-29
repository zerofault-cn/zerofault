<?php
class UserAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
		$this->assign('MODULE_TITLE', '用户中心');
	}

	public function index() {
		if (empty($_SESSION[C('USER_ID')])) {
			redirect(__URL__.'/login');
			exit;
		}
		if (2==$_SESSION['user_type']) {
			$this->assign('ACTION_TITLE', '已投标');
			//显示投标记录
			$dao = D('Tender');
			$rs = $dao->relation(true)->where("company_id=".$_SESSION['company_id'])->select();
			foreach ($rs as $i=>$row) {
				$rs[$i]['invite']['region'] = M('Region')->where("id=".$row['invite']['district'])->getField('name');
				$rs[$i]['invite']['room_str'] = $options['room'][$row['invite']['room']];
			}
			$this->assign('list', $rs);
		}
		else {
			$this->assign('ACTION_TITLE', '发布的招标');
			//显示招标记录
			$dao = M('Invite');
			$rs = $dao->where("user_id=".$_SESSION[C('USER_ID')])->select();
			foreach ($rs as $i=>$row) {
				$rs[$i]['region'] = M('Region')->where("id=".$row['district'])->getField('name');
				$rs[$i]['room_str'] = $options['room'][$row['room']];
				$rs[$i]['tender_list'] = D('Tender')->relation(true)->where("invite_id=".$row['id']." and status>0")->select();
				$rs[$i]['tender_count'] = count($rs[$i]['tender_list']);
			}
			$this->assign('list', $rs);
		}
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function register() {
		$this->assign('ACTION_TITLE', '注册账号');
		$type = 1;
		!empty($_REQUEST['type']) && ($type = intval($_REQUEST['type']));
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

			if (2==$type) {
				$name = trim($_REQUEST['name']);
				empty($name) && self::_error('公司名称必须填写！');
				$telephone = trim($_REQUEST['telephone']);
				$mobile = trim($_REQUEST['mobile']);
				(empty($telephone)&&empty($mobile)) && self::_error('固定电话和移动电话必须至少填一种！');
				$address = trim($_REQUEST['address']);
				empty($address) && self::_error('公司地址必须填写！');
				$introduction = trim($_REQUEST['introduction']);
			}

			$this->dao->type = $type;
			$this->dao->email = $email;
			$this->dao->password = md5($password);
			$this->dao->realname = $realname;
			$this->dao->sex = $sex;
			$this->dao->reg_time = date('Y-m-d H:i:s');
			$this->dao->status = 1;
			if($user_id = $this->dao->add()) {
				if (2==$type) {
					$data = array();
					$data['user_id'] = $user_id;
					$data['name'] = $name;
					$data['telephone'] = $telephone;
					$data['mobile'] = $mobile;
					$data['address'] = $address;
					$data['introduction'] = $introduction;
					$data['addtime'] = date('Y-m-d H:i:s');
					$data['status'] = 0;
					if (!$company_id = M('Company')->data($data)->add()) {
						self::_error('提交公司资料出错！');
					}
				}
				$_SESSION[C('USER_ID')] = $user_id;
				$_SESSION['user_name'] = $realname;
				$_SESSION['user_type'] = $type;
				if (!empty($company_id)) {
					$_SESSION['company_id'] = $company_id;
				}
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
		$this->assign('type', $type);
		$this->assign('last_url', $_SERVER['HTTP_REFERER']);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function login() {
		$this->assign('ACTION_TITLE', '登录');
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
				$_SESSION['user_type'] = $rs['type'];
				if (2 == $rs['type']) {
					$company_id = M('Company')->where("user_id=".$rs['id'])->getField('id');
					if (!empty($company_id)) {
						$_SESSION['company_id'] = $company_id;
					}
				}
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
	public function profile() {
		$this->assign('ACTION_TITLE', '编辑资料');
		if (empty($_SESSION[C('USER_ID')])) {
			redirect(__URL__.'/login');
			exit;
		}
		if (!empty($_POST['submit'])) {
			$this->dao->find($_SESSION[C('USER_ID')]);

			$realname = trim($_REQUEST['realname']);
			empty($realname) && self::_error('真实姓名必须填写！');
			$sex = intval($_REQUEST['sex']);
			$password0 = trim($_REQUEST['password0']);
			empty($password0) && self::_error('必须提供原始密码！');
			md5($password0)!=$this->dao->password && self::_error('原始密码错误！');
			$password = trim($_REQUEST['password']);
			if (!empty($password)) {
				strlen($password)<6 && self::_error('新密码至少需要6个字符！');
				strlen($password)>20 && self::_error('新密码不能超过20个字符！');
				$password2 = trim($_REQUEST['password2']);
				$password!=$password2 && self::_error('两次输入的新密码不一致！');
				$this->dao->password = md5($password);
			}
			if (2==$_SESSION['user_type']) {
				$name = trim($_REQUEST['name']);
				empty($name) && self::_error('公司名称必须填写！');
				$telephone = trim($_REQUEST['telephone']);
				$mobile = trim($_REQUEST['mobile']);
				(empty($telephone)&&empty($mobile)) && self::_error('固定电话和移动电话必须至少填一种！');
				$address = trim($_REQUEST['address']);
				empty($address) && self::_error('公司地址必须填写！');
				$introduction = trim($_REQUEST['introduction']);
				$qualifications = trim($_REQUEST['qualifications']);
			}

			$this->dao->realname = $realname;
			$this->dao->sex = $sex;
			if(false !== $this->dao->save()) {
				if (2==$_SESSION['user_type']) {
					$company_dao = M('Company')->where("user_id=".$_SESSION[C('USER_ID')])->find();
					$data = array();
					$data['id'] = $_SESSION['company_id'];
					$data['name'] = $name;
					$data['telephone'] = $telephone;
					$data['mobile'] = $mobile;
					$data['address'] = $address;
					$data['introduction'] = $introduction;
					$data['qualifications'] = $qualifications;
					if (false === M('Company')->save($data)) {
						self::_error('提交公司资料出错！');
					}
				}
				self::_success('更新成功！');
			}
			else {
				self::_error('提交过程中发生未知错误！');
			}
		}

		$rs = $this->dao->relation(true)->find($_SESSION[C('USER_ID')]);
		$this->assign('info', $rs);

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