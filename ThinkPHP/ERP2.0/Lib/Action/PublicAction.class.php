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
	* 发送重置密码请求、验证并保存登录信息
	*/
	public function checkLogin() {
		$action = $_REQUEST['action'];
		$name = trim($_REQUEST['name']);
		$password = trim($_REQUEST['password']);
		if ('getPWD' == $action) {
			if (''==$name) {
				self::_error('Enter your User ID first!');
			}
			$email = M('Staff')->where(array('name'=>$name))->getField('email');
			
			$admin_email = M('Staff')->where(array('id'=>1))->getField('email');
			empty($admin_email) && self::_error('The System Admin haven\'t set his email,<br />Can\'t send notification!'); 
			$title = 'Staff ask for reseting his password!';
			$body = "Hi SuperAdmin,\n  A staff can't remember his password, could you please help to reset his password.\nStaff Login Account is: ".$name;
			$email && ($body .= ", and his email is: ".$email);
			$body .= "\n\nThanks.\nBest Regards.";
			$mail_body_ext = "\n\n\nThis mail was sent by the ERP system automatically, please don't reply it.";
			
			$cmd = 'echo "'.$body.$mail_body_ext.'"|/usr/bin/mutt -s "'.$title.'" '.$admin_email;
			Log::Write($cmd, INFO);
			system($cmd,$ret);
			if ('0'==$ret) {
				self::_success('A password reset request have been send to the System Administrator.');
			}
			else{
				self::_error('send request fail.');
			}
			return;
		}
		'' == $name && self::_error('User ID required');
		'' == $password && self::_error('Password Required');
		
		//生成认证条件
		$map			= array();
		$map["name"]	= $name;
		$map['password']= md5($password);
		$map["status"]	= 1;

		// 进行委托认证
		$authInfo = RBAC::authenticate($map);
//		dump($authInfo);
		if(empty($authInfo)) {
			self::_error('Error: User ID/Password is wrong!');
		}
		else{
			D('Staff')->where('id='.$authInfo['id'])->setField('login_time',date("Y-m-d H:i:s"));
			$_SESSION[C('USER_AUTH_KEY')]	= $authInfo['id'];
			$_SESSION['staff']		= $authInfo;
			if(in_array($authInfo['id'], C('SUPER_ADMIN_ID'))) {
				// 管理员不受权限控制影响
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	true;
			}
			else{
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	false;
			}
			//获取当前用户管理的Location信息
			$rs = M('LocationManager')->where(array('staff_id'=>$authInfo['id'],'location_id'=>array('gt',1)))->group('location_id')->getField('location_id,group_concat(fixed order by fixed separator "")');
			empty($rs) && ($rs = array());
			//获取所有Location
			$rs2 = M('Location')->where(array('id'=>array('gt',1)))->getField('id,name');
			$_SESSION['location'] = $rs2;
			$manager = array();
			foreach($rs as $location_id=>$fixed) {
				$manager[$location_id] = array('name'=>$rs2[$location_id],'fixed'=>$fixed);
			}
			$_SESSION['manager'] = $manager;
			// 缓存访问权限
			RBAC::saveAccessList($authInfo['id']);
			self::_success('', __APP__, 0);
		}
	}

	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		self::_success('Logout success!', __APP__);
	}

	public function remark() {
		if (!empty($_GET['remark_id'])) {
			die(M('Remark2')->where('id='.$_GET['remark_id'])->getField('remark'));
		}
		if (!empty($_POST['submit'])) {
			$remark_id = intval($_REQUEST['remark_id']);
			$product_id = intval($_REQUEST['product_id']);
			$remark = trim($_REQUEST['remark']);
			if ('' == $remark) {
				die(json_encode(array('result'=>0, 'msg'=>'Content is empty!')));
			}
			$data = array();
			$data['flow_id'] = 0;
			$data['product_id'] = $product_id;
			$data['staff_id'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['remark'] = $remark;
			$data['create_time'] = date("Y-m-d H:i:s");
			$data['status'] = 1;
			if ($remark_id>0) {
				$res = M('Remark2')->where('id='.$remark_id)->save($data);
			}
			else {
				$res = M('Remark2')->add($data);
			}
			if ($res) {
				die(json_encode(array('result'=>1, 'remark_id'=>$remark_id, 'staff_name'=>$_SESSION['staff']['realname'], 'create_time'=>$data['create_time'], 'remark'=>nl2br($remark))));
			}
			else {
				die(json_encode(array('result'=>0, 'msg'=>'Post fail!'.(C('APP_DEBUG')?M('Remark2')->getLastSql():''))));
			}
		}
		$staff = array();
		foreach(M('Staff')->where(array('status'=>1))->select() as $item) {
			$staff[$item['id']] = $item['realname'];
		}
		$this->assign('staff', $staff);

		$product_id = intval($_REQUEST['product_id']);
		//$flow_id = intval($_REQUEST['flow_id']);
		$remark = M('Product')->field('remark')->where('id='.$product_id)->select();
		$remark1 = M('ProductFlow')->field('staff_id,create_time,remark')->where('product_id='.$product_id)->order('id')->select();
		$remark2 = M('Remark2')->where(array('product_id'=>$product_id, 'status'=>1))->order('id')->select();
		if (empty($remark2)) {
			$remark2 = array();
		}
		$this->assign('product_id', $product_id);
		$this->assign('result', array_merge($remark, $remark1, $remark2));
		$this->assign('content', 'Public:remark');
		$this->display('Layout:content');
	}
	public function check(){
		$rs = M('ProductFlow')->where('status=-2 or status=0')->select();
		empty($rs) && ($rs = array());
		echo 'Get :'.count($rs)."\n";
		foreach ($rs as $item) {
			if (-2 == $item['status']) {
				self::_mail($item['id']);
			}
			else {
				if ('apply' == $item['action']) {
					self::_mail($item['id'], 'approve');
				}
				elseif ('transfer' == $item['action']) {
					self::_mail($item['id']);
				}
				elseif ('return' == $item['action']) {
					self::_mail($item['id']);
				}
				else{
					//nothing
				}
			}
		}
	}
}
?>