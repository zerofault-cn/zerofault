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
			self::_error('Error: User ID/Password is wrong!');
		}
		else{
			D('Staff')->where('id='.$authInfo['id'])->setField('login_time',date("Y-m-d H:i:s"));
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION['loginUserName']		=	$authInfo['realname'];
			if(in_array($authInfo['id'], C('SUPER_ADMIN_ID'))) {
				// 管理员不受权限控制影响
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	true;
			}
			else{
				$_SESSION[C('ADMIN_AUTH_KEY')]	=	false;
			}
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
		if (!empty($_POST['submit'])) {
			$id = $_REQUEST['id'];
			$remark = $_REQUEST['remark'];
			if ('' == trim($remark)) {
				self::_error('Content is empty!');
			}
			$data = array();
			$data['flow_id'] = $id;
			$data['staff_id'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['remark'] = $remark;
			$data['create_time'] = date("Y-m-d H:i:s");
			$data['status'] = 1;
			if (M('Remark2')->add($data)) {
				echo '<script>parent.myAlert("Post success");parent.myOK(1000);parent.tb_remove();</script>';
			}
			else {
				self::_error('Post fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
			exit;
		}
		$staff = array();
		foreach(M('Staff')->where(array('status'=>1))->select() as $item) {
			$staff[$item['id']] = $item['name'];
		}
		$this->assign('staff', $staff);

		$id = $_REQUEST['id'];
		$remark = M('ProductFlow')->field('staff_id,create_time,remark')->where('id='.$id)->select();
		$remark2 = M('Remark2')->where(array('flow_id'=>$id, 'status'=>1))->select();
		$this->assign('id', $id);
		$this->assign('result', array_merge($remark,$remark2));
		$this->assign('content', 'Public:remark');
		$this->display('Layout:content');
	}

}
?>