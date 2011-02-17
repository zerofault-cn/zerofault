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
			header('Location: '.__APP__);
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
			if (!defined('APP_ROOT')) {
				define('APP_ROOT', 'http://'.$_SERVER['SERVER_NAME'].__APP__);
			}
			empty($name) && self::_error('Input your username first!');
			$staff = M('Staff')->where("name='".$name."'")->find();
			empty($staff) && self::_error('The username is not exists!');
			while(true) {
				$token = self::authcode($staff['id'], 'ENCODE', 'key', 3600);
				if (false === strpos($token, '/')) {
					break;
				}
				sleep(1);
			}
			$url = APP_ROOT."/Public/resetPWD/token/".$token;

			$smtp_config = C('_smtp_');
			include_once (LIB_PATH.'class.phpmailer.php');
			$mail = new PHPMailer();
			$mail->IsSMTP();
		//	$mail->SMTPDebug  = 1;  // 2 = messages only
			$mail->Host       = $smtp_config['host'];
			$mail->Port       = $smtp_config['port'];
			$mail->SetFrom($smtp_config['from_mail'], $smtp_config['from_name']);

			$mail->AddAddress($staff['email'], $staff['realname']);

			$mail->Subject = '[ERP] You have requested to reset password!';
			$body = 'Hi '.$staff['realname'].',<br /><br />';
			$body .= '&nbsp;&nbsp;If you want to reset your password of ERP System['.$_SERVER['SERVER_NAME'].'], please click the following link in an hour (<span style="color:red">before '.date('Y-m-d H:i', time()+3600).'</span>), then set your new password.<br />';
			$body .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$url.'" target="_blank">'.$url.'</a><br /><br />';
			$body .= '&nbsp;&nbsp;Before you have reseted your new password, the old password is always available.<br /><br />';
			$body .= '&nbsp;&nbsp;If this request is not launched by yourself, please ignore it.';
			$body .= '<br /><br /><br />This mail was sent by the ERP system automatically, please don\'t reply it.';
			
			$mail->MsgHTML($body);
			if(!$mail->Send()) {
				Log::Write('Mail Error: '.$mail->ErrorInfo);
				self::_error('mail send failed.');
			}
			else {
				Log::Write('Mail Success: '.$staff['email'], INFO);
				self::_success('Please check your email, and follow the instruction.');
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
			$_SESSION[C('STAFF_AUTH_NAME')]	= $authInfo;
			if(in_array($authInfo['id'], C('SUPER_ADMIN_ID'))) {
				// 管理员不受权限控制影响
				$_SESSION[C('ADMIN_AUTH_NAME')]	=	true;
			}
			else{
				$_SESSION[C('ADMIN_AUTH_NAME')]	=	false;
			}
			//获取当前用户管理的Location信息
			$rs = M('LocationManager')->where(array('staff_id'=>$authInfo['id']))->group('location_id')->getField('location_id,group_concat(fixed order by fixed separator "")');
			empty($rs) && ($rs = array());
			//获取所有Location
			$rs2 = M('Location')->getField('id,name');
			$_SESSION['location'] = $rs2;
			$manager = array();
			foreach($rs as $location_id=>$fixed) {
				$manager[$location_id] = array('name'=>$rs2[$location_id],'fixed'=>$fixed);
			}
			$_SESSION[C('MANAGER_AUTH_NAME')] = $manager;
			
			// 缓存访问权限
			RBAC::saveAccessList($authInfo['id']);
			self::_success('', __APP__, 0);
		}
	}

	public function resetPWD() {
		$token = $_REQUEST['token'];
		$id = self::authcode($token, 'DECODE', 'key');
		if(!empty($_POST['submit'])) {
			if (empty($id)) {
				self::_error('Sorry, your session token is expired!');
				return;
			}
			$password = $_REQUEST['password'];
			$password2 = $_REQUEST['password2'];
			empty($password) && self::_error('You haven\'t input any characters!');
			$password != $password2 && self::_error('Your two passwords are not match!');
			$rs = M('Staff')->where('id='.$id)->setField('password', md5($password));
			if(false !== $rs)
			{
				self::_success('Reset success!', __APP__.C('USER_AUTH_GATEWAY'), 2000);
			}
			else
			{
				self::_error('Reset fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
			return;
		}
		if (empty($id)) {
			die('<h3 style="color:red;text-align:center;">Sorry, your request token is expired!</h3>');
		}
		$this->assign('info', M('Staff')->find($id));
		$this->assign('token', $token);
		$this->assign('content','reset_password');
		$this->display('Layout:base');
	}

	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		self::_success('Logout success!', __APP__);
	}
	public function profile() {
		R('Staff', 'profile');
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
				die(json_encode(array('result'=>1, 'remark_id'=>$remark_id, 'staff_name'=>$_SESSION[C('STAFF_AUTH_NAME')]['realname'], 'create_time'=>$data['create_time'], 'remark'=>nl2br($remark))));
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
		$this->assign('content', ACTION_NAME);
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
	// 参数解释  
	// $string： 明文 或 密文  
	// $operation：DECODE表示解密,其它表示加密  
	// $key： 密匙  
	// $expiry：密文有效期  
	private function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {  
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙  
		$ckey_length = 4;  
		  
		// 密匙  
		$key = md5($key);  
		  
		// 密匙a会参与加解密  
		$keya = md5(substr($key, 0, 16));  
		// 密匙b会用来做数据完整性验证  
		$keyb = md5(substr($key, 16, 16));  
		// 密匙c用于变化生成的密文  
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';  
		// 参与运算的密匙  
		$cryptkey = $keya.md5($keya.$keyc);  
		$key_length = strlen($cryptkey);  
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性  
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确  
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
		$string_length = strlen($string);  
		$result = '';  
		$box = range(0, 255);  
		$rndkey = array();  
		// 产生密匙簿  
		for($i = 0; $i <= 255; $i++) {  
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);  
		}  
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度  
		for($j = $i = 0; $i < 256; $i++) {  
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;  
			$tmp = $box[$i];  
			$box[$i] = $box[$j];  
			$box[$j] = $tmp;  
		}  
		// 核心加解密部分  
		for($a = $j = $i = 0; $i < $string_length; $i++) {  
			$a = ($a + 1) % 256;  
			$j = ($j + $box[$a]) % 256;  
			$tmp = $box[$a];  
			$box[$a] = $box[$j];  
			$box[$j] = $tmp;  
			// 从密匙簿得出密匙进行异或，再转成字符  
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
		}  
		if($operation == 'DECODE') {  
			// substr($result, 0, 10) == 0 验证数据有效性  
			// substr($result, 0, 10) - time() > 0 验证数据有效性  
			// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性  
			// 验证数据有效性，请看未加密明文的格式  
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
				return substr($result, 26);  
			} else {  
				return '';  
			}  
		} else {  
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因  
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码  
			return $keyc.str_replace('=', '', base64_encode($result));  
		}  
	}
	public function sync_users() {
		R('Staff', 'sync_users');
	}
	public function notify() {
		R('Absence', 'notify');
	}
	public function press() {
		R('Absence', 'press');
	}
	public function absence_confirm() {
		R('Absence', 'confirm');
	}
}
?>