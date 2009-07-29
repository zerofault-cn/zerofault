<?php

class PublicAction extends Action{
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
				Session::set('lastModule', MODULE_NAME);
				//跳转到认证网关
				redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
			}
			// 检查权限
			if(!RBAC::AccessDecision()) {
				$this->assign('message','没有权限！');
				$this->assign('content','Public:error');
				$this->display('Layout:Admin_layout');
				exit;
			}
		}
	}
	/**
	*
	* 验证是否已登录，如果未登录，显示登录框
	*/
	public function login() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('content','login');
			$this->display('Layout:Admin_layout');
		}else{
			redirect(__URL__);
		}
	}
	/**
	*
	* 验证并保存登录信息
	*/
	public function checkLogin(){
		$User	=	D('User');
		if(empty($_POST['account'])) {
			die(self::_error('帐号错误！'));
		}
		elseif (empty($_POST['password'])){
			die(self::_error('密码必须！'));
		}
		//生成认证条件
		$map			= array();
		$map["account"]	= $_POST['account'];
		$map["status"]	= array('gt',0);
		$authInfo = $User->where($map)->find();

		//使用用户名、密码和状态的方式进行认证
		if(false === $authInfo) {
			die(self::_error('用户名不存在或已禁用！'));
		}
		else {
			if($authInfo['password'] != md5($_POST['password'])) {
				die(self::_error('密码错误！'));
			}
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION['loginUserName']	=	$authInfo['nickname'];
			if($authInfo['account']=='admin') {
				// 管理员不受权限控制影响
				$_SESSION['administrator']		=	true;
			}
			else{
				$_SESSION['administrator']		=	false;
			}
			// 缓存访问权限
			RBAC::saveAccessList();
			die(self::_success('登陆成功！',__APP__.'/'.Session::get('lastModule'),500));
		}
	}
	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		die(self::_success('注销成功！', __APP__, 500));
	}

		/**
	*
	* 用PHP的fsockopen模拟HTTP post，用来向ip138网站提交IP查询并获取结果
	*/
	public function httpPost(){
		$url = $_REQUEST['url'];
		$params = $_REQUEST['params'];
		$referrer="";
		// parsing the given URL
		$URL_Info=parse_url($url);
		// Building referrer
		if($referrer==""){ // if not given use this script as referrer
			$referrer=$_SERVER["SCRIPT_URI"];
		}
		// making string from $data
		$data_string=$params;
		// Find out which port is needed - if not given use standard (=80)
		if(!isset($URL_Info["port"])){
			$URL_Info["port"]=80;
		}
		// building POST-request:
		$request.="POST ".$URL_Info["path"]." HTTP/1.1\n";
		$request.="Host: ".$URL_Info["host"]."\n";
		$request.="Referer: $referrer\n";
		$request.="Content-type: application/x-www-form-urlencoded\n";
		$request.="Content-length: ".strlen($data_string)."\n";
		$request.="Connection: close\n";
		$request.="\n";
		$request.=$data_string."\n";
		$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
		fputs($fp, $request);
		while(!feof($fp)) {
			$result .= fgets($fp, 1024);
		}
		fclose($fp);
		echo iconv('','UTF-8',$result);
	}
	/**
	*
	* 生成弹出“操作成功”提示的js代码
	*
	* @param string $msg 弹出框内显示的提示语句 
	* @param string $url 跳转地址，默认为空，表示重新载入当前页
	* @param integer $timeout 弹出框显示的时间，超过时间后自动关闭或页面跳转
	*
	* @return string HTML格式的JS代码
	*/
	protected function _success($msg,$url='',$timeout=2000){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
		$html .= 'parent.myLocation("'.$url.'",'.$timeout.');';
		$html .= '</script>';
		return $html;
	}
	/**
	*
	* 生成弹出“操作失败”提示的js代码
	*
	* @param string $msg 弹出框内显示的提示语句 
	* @param integer $timeout 弹出框显示的时间，如果没有设置，则不会自动关闭，需要用户点OK按钮关闭
	*
	* @return string HTML格式的JS代码
	*/
	protected function _error($msg,$timeout=0){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
		$timeout && $html .= 'parent.myOK('.$timeout.');';
		$html .= '</script>';
		return $html;
	}

}
?>