<?php
/**
*
* 自定义的Action基类，被其它Action继承
* 用来统一调用RBAC认证模块
* 以及定义一些系统公用的方法
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class BaseAction extends Action{
	/**
	*
	* 对象初始化时自动执行
	*/
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		//判断是否登录
		if(!$_SESSION[C('USER_AUTH_KEY')] && 'Public'!=MODULE_NAME) {
			//记下Module
			//Session::set('lastModule', MODULE_NAME);
			//跳转到认证网关
			redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
		}

		import('@.RBAC');
		// 认证当前操作
		if(RBAC::checkAccess()) {
			// 检查权限
			if(!RBAC::AccessDecision()) {
				if(in_array(ACTION_NAME,C('IFRAME_AUTH_ACTION'))) {
					die(self::_error('Permission denied!', 3000));
				}
				$this->assign('message','Permission denied!');
				$this->assign('content','Public:error');
				$this->display('Layout:ERP_layout');
				exit;
			}
		}

		//准备导航菜单
	//	$top = empty($_REQUEST['top']) ? '' : $_REQUEST['top'];
	//	!$top && ($top = Session::get('top'));
	//	!$top && ($top = 'Assets Management');
	//	Session::set('top', urldecode($top));
		$top = Session::get('top');

		$_menu_ = C('_menu_');//载入menu.php的内容
		$menu = $_menu_['menu'];
		$topmenu = array();
		foreach($menu as $key=>$val) {
			if(empty($val['submenu'])) {//单层菜单
				if(RBAC::AccessDecision($val['name'], 'index')) {
					$topmenu[$key] = $val['name'];
				}
			}
			else {//有子菜单
				if(str_replace('&nbsp;',' ',$key) == $top) {//获取当前子菜单所有项目，供再次过滤
					$tmp_submenu = $menu[$key]['submenu'];
				}
				//确定顶部可显示的菜单项
				foreach($val['submenu'] as $sub_title=>$sub_action) {
					if(false === strpos($sub_action, '/')) {//子菜单是Module，如Supplier
						if(RBAC::AccessDecision($sub_action, 'index')) {
							$topmenu[$key] = $sub_action;
							break;
						}
					}
					else{
						$sub_action_arr = explode('/', $sub_action);
						if(RBAC::AccessDecision($sub_action_arr[0], $sub_action_arr[1])) {
							$topmenu[$key] = $sub_action;
							break;
						}
					}
				}
			}
		}
		//确定可显示的子菜单项
		$submenu = array();
		//根据是否manager增加Asset子菜单
		if ('Assets Management' == $top) {
			foreach($_SESSION[C('MANAGER_AUTH_NAME')] as $location_id=>$location) {
				$submenu['Transfer to '.ucfirst($location['name'])] = 'Asset/location/id/'.$location_id;
			}
			//判断是否Leader，以增加request子菜单
			if (!empty($_SESSION[C('STAFF_AUTH_NAME')]['is_leader'])) {
				$submenu['Staff Apply Request'] = 'Asset/request';
			}
		}

		foreach($tmp_submenu as $sub_title=>$sub_action) {
			if(false === strpos($sub_action, '/')) {//子菜单是Module，如Supplier
				if(!RBAC::AccessDecision($sub_action, 'index')) {
					continue;
				}
			}
			else{//子菜单是Module/Action，如Asset/apply
				if (empty($_SESSION[C('STAFF_AUTH_NAME')]['is_leader']) && 'Asset/request'==$sub_action) {
					continue;
				}
				$sub_action_arr = explode('/', $sub_action);
				if(!RBAC::AccessDecision($sub_action_arr[0], $sub_action_arr[1])) {
					continue;
				}
			}
			$submenu[$sub_title] = $sub_action;
		}
		//根据location增加Inventory子菜单
		if ('Inventory Inquire'==$top) {
			foreach($_SESSION['location'] as $location_id=>$location) {
				if ($location_id==1) {
					continue;
				}
				$submenu[ucfirst($location).' Inventory'] = 'Inventory/location/id/'.$location_id;
			}
			$submenu['Staff Inquire'] = 'Inventory/staff';
		}
		$this->assign("current_time", date("l, d/m/Y | h:i A"));//Thursday, 10/09/2009 | 11:53 AM
		$this->assign('topmenu', $topmenu);
		$this->assign('submenu', $submenu);
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
		if($msg) {
			$html .= 'parent.myAlert("'.$msg.'");';
		}
		$html .= 'parent.myLocation("'.$url.'",'.$timeout.');';
		$html .= '</script>';
		die($html);
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
		!empty($timeout) && $html .= 'parent.myOK('.$timeout.');';
		$html .= '</script>';
		die($html);
	}
	/**
	*
	* 生成弹出“确认”提示的js代码
	*
	* @param string $msg 确认提示语句
	* @param string $times 确认次数
	*
	* @return string HTML格式的js代码
	*/
	protected function _confirm2($msg, $times) {
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myConfirm2("'.$msg.'", '.$times.');';
		$html .= '</script>';
		die($html);
	}
	/**
	*
	* 更新某条纪录的某个字段
	* 只能在_iframe中执行，执行后在父窗口提示结果
	*/
	protected function _update(){
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=$_REQUEST['v'];
		$rs = $this->dao->where('id='.$id)->setField($field,$value);
		if(false !== $rs)
		{
			die(self::_success('Update success!','',1000));
		}
		else
		{
			die(self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():'')));
		}
	}
	/**
	*
	* 彻底删除纪录
	* 只能在_iframe中执行，执行后在父窗口提示结果
	*/
	protected function _delete(){
		$id=$_REQUEST['id'];
		if($this->dao->find($id) && $this->dao->delete())
		{
			print(self::_success('Delete success!','',1000));
		}
		else
		{
			die(self::_error('Delete fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():'')));
		}
	}

	/**
	*
	* 根据数组生成HTML格式的下拉列表选项
	* 生成格式<options value="id" selected="true">name</option>
	* @param array $rs 从元数据表中取出的ResultSet
	* @param integer $selected_id 默认选中的value值
	* @param string $title 供下拉列表中显示的字段
	* @param string $value 充当下拉列表值的字段
	*/
	protected function genOptions($rs=array(), $selected_id='', $title='name', $value='id') {
		$str = '';
		if(empty($rs) || !is_array($rs)) {
			return $str;
		}
		foreach($rs as $key=>$val) {
			$str .= '<option value="'.$val[$value].'" ';
			if($selected_id == $val[$value]) {
				$str .= ' selected="true"';
			}
			$str .= '>'.$val[$title].'</option>';
		}
		return $str;
	}
	protected function genCheckbox($rs=array(), $checked_arr = array(), $chk_name='') {
		$str = '';
		if(empty($rs) || !is_array($rs)) {
			return $str;
		}
		$checked_id_arr = array();
		if(!empty($checked_arr) && is_array($checked_arr)) {
			foreach($checked_arr as $val) {
				$checked_id_arr[] = $val['id'];
			}
		}
		foreach($rs as $val) {
			$str .= '<input type="checkbox" name="'.$chk_name.'[]" value="'.$val['id'].'" ';
			if(in_array($val['id'], $checked_id_arr)) {
				$str .= ' checked="true"';
			}
			$str .= '/>'.$val['name'].' ';
		}
		return $str;
	}
	protected function MAX_FILE_SIZE($k=NULL){
		$tmp = 1024*1024*min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize'));
		if(is_null($k)) {
			return $tmp;
		}else{
			return min($tmp, 1024*$k);
		}
	}
	/*
	*
	* 根据flow信息发送邮件
	* @param string $type 邮件类型：apply:申请，approve:Leader同意，transfer:转移，return:归还
	* @param int $flow_id product_flow.ID
	*/
	protected function _mail($flow_id=0,$do='new') {
		$mail_tpl = array();
		foreach(M('Template')->where(array('status'=>1))->select() as $item) {
			if (!array_key_exists($item['action'], $mail_tpl)) {
				$mail_tpl[$item['action']] = array();
			}
			$mail_tpl[$item['action']][$item['do']] = array(
				'subject' => $item['subject'],
				'body'    => $item['body']
				);
		}
		//$mail_body_ext = "\n\n\nThis mail was sent by the System automatically, please don't reply it.";
		
		$flow = M('ProductFlow')->find($flow_id);
		$staff = M('Staff')->find($flow['staff_id']);
		if ($staff['leader_id']>0) {
			$leader = M('Staff')->find($staff['leader_id']);
		}
		if ('location' == $flow['to_type']) {
			$staff_id = M('LocationManager')->where(array('location_id'=>$flow['to_id'], 'fixed'=>$flow['fixed']))->getField('staff_id');
			$to_staff = M('Staff')->find($staff_id);
		}
		else {
			$to_staff = M('Staff')->find($flow['to_id']);
		}
		if ('location' == $flow['from_type']) {
			$staff_id = M('LocationManager')->where(array('location_id'=>$flow['from_id'], 'fixed'=>$flow['fixed']))->getField('staff_id');
			$from_staff = M('Staff')->find($staff_id);
		}
		else {
			$from_staff = M('Staff')->find($flow['from_id']);
		}

		$manager_id = M('LocationManager')->where(array('location_id'=>1,'fixed'=>$flow['fixed']))->getField('staff_id');
		$manager = M('Staff')->find($manager_id);
		$product = M('Product')->find($flow['product_id']);
		$unit_name = M('Options')->where('id='.$product['unit_id'])->getField('name');

		$send_to = array();
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		switch ($flow['action'].'_'.$do) {
			case 'apply_new' :
			case 'apply_edit' :
			case 'apply_delete' :
				if (!empty($leader)) {
					$send_to[] = $leader['email'];
					$send_to[] = $manager['email'];
					$send_to[] = $staff['email'];
					$url = APP_ROOT."/Asset/request";
					break;
				}
				elseif($do == 'new') {
					$do = 'approve';
				}
				//continue to approve

			case 'apply_approve' :
				$send_to[] = $manager['email'];
				$send_to[] = $staff['email'];
				if (!empty($leader)) {
					$send_to[] = $leader['email'];
				}
				$url = APP_ROOT."/Asset/request";
				break;

			case 'apply_reject' :
				$send_to[] = $staff['email'];
				$send_to[] = $manager['email'];
				$send_to[] = $leader['email'];
				$url = APP_ROOT."/Asset/apply/status/-1";
				break;

			case 'apply_confirm' :
				if (!empty($leader)) {
					$send_to[] = $leader['email'];
					$send_to[] = $manager['email'];
					$send_to[] = $staff['email'];
				}
				else{
					$send_to[] = $staff['email'];
					$send_to[] = $manager['email'];
				}
				$url = APP_ROOT."/Asset/apply/status/1";
				break;

			case 'transfer_new':
			case 'transfer_edit':
			case 'transfer_delete':
				$send_to[] = $to_staff['email'];
				$send_to[] = $from_staff['email'];
				if ('location' == $flow['to_type']) {
					$url = APP_ROOT."/ProductOut/transfer";
				}
				else {
					$url = APP_ROOT."/Asset/transferIn";
				}
				break;

			case 'transfer_reject' :
			case 'transfer_confirm':
				$send_to[] = $from_staff['email'];
				$send_to[] = $to_staff['email'];
				if ('location' == $flow['to_type']) {
					$url = APP_ROOT."/ProductOut/transfer/status/-1";
				}
				else {
					$url = APP_ROOT."/Asset/transferOut/status/-1";
				}
				break;

			case 'return_new':
			case 'return_edit':
			case 'return_delete':
				$send_to[] = $manager['email'];
				$send_to[] = $staff['email'];
				$url = APP_ROOT."/ProductOut/returns";
				break;

			case 'return_confirm':
				$send_to[] = $staff['email'];
				$send_to[] = $manager['email'];
				$url = APP_ROOT."/Asset/returns";
				break;

			default :
				//do not send any mail
				Log::Write('Not in case :'.$flow['action'].'->'.$do);
				return;
		}
		if (empty($mail_tpl[$flow['action']][$do])) {
			Log::Write('Mail template of Action: '.$flow['action'].'->'.$do.' not exists!', INFO);
			return;
		}
		$subject = str_replace(
			array(
				'[staff]',
				'[from_staff]',
				'[to_staff]',
				'[product]',
				'[code]'),
			array(
				$staff['realname'],
				$from_staff['realname'],
				$to_staff['realname'],
				$product['Internal_PN'].'('.$product['description'].')',
				$flow['code']),
			$mail_tpl[$flow['action']][$do]['subject']);
		$body = str_replace(
			array(
				'[staff]',
				'[from_staff]',
				'[to_staff]',
				'[leader]',
				'[manager]',
				'[product]',
				'[quantity]',
				'[unit]',
				'[remark]',
				'[url]'),
			array(
				$staff['realname'],
				$from_staff['realname'],
				$to_staff['realname'],
				$leader['realname'],
				$manager['realname'],
				$product['Internal_PN'].'('.$product['description'].')',
				$flow['quantity'],
				$unit_name,
				$flow['remark'],
				$url),
			$mail_tpl[$flow['action']][$do]['body']);
		$body .= "\n[From ".C('ERP_TITLE')."]\n";
		if ('check'==ACTION_NAME && !C('NOTIFICATION_MAILTO')) {
			$send_to = array_unique(array_merge($send_to, C('NOTIFICATION_MAILTO')));
		}
		$cmd = 'echo "'.$body.'"|/usr/bin/mutt -s "'.$subject.'" '.$send_to[0];
		if (count($send_to)>1) {
			$cmd .= ' -c '.implode(' -c ', array_slice($send_to,1));
		}
		Log::Write($cmd, INFO);
		system($cmd,$ret);
		if('0'==$ret) {
			Log::Write('Success', INFO);
			return true;
		}
		else{
			Log::Write('Fail');
			return false;
		}
	}

	protected function sync_user($data) {
		$USER_SYNC_TARGET = C('USER_SYNC_TARGET');
		if (!empty($data) && !empty($USER_SYNC_TARGET) && is_array($USER_SYNC_TARGET)) {
			foreach ($USER_SYNC_TARGET as $app=>$baseurl) {
				switch ($app) {
					case 'CuteFlow':
						echo "Start to sync to CuteFlow\n";
						$params = array();
						$params['strLastName'] = 'AGIGA';
						if (is_object($data)) {
							echo "User: ".$data->name."\n";
							$params['UserName'] = $data->name;
							$params['strFirstName'] = $data->realname;
							$params['strEMail'] = $data->email;
							$params['Password'] = $data->password;
							$params['UserAccessLevel'] = $data->is_leader?8:1;
							$params['Deleted'] = intval(!$data->status);
						}
						elseif (is_array($data)) {
							echo "User: ".$data['name']."\n";
							$params['UserName'] = $data['name'];
							$params['strFirstName'] = $data['realname'];
							$params['strEMail'] = $data['email'];
							$params['Password'] = $data['password'];
							$params['UserAccessLevel'] = $data['is_leader']?8:1;
							$params['Deleted'] = intval(!$data['status']);
						}
						
						if(false && function_exists('curl_init')) {
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $baseurl.'pages/sync_user.php');
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
							curl_exec($ch);
							curl_close($ch);
						}
						else {
							self::httpPost($baseurl.'pages/sync_user.php', $params);
						}
						break;

					default:
						//nothing
				}
			}
		}
	}
	protected function httpPost($url, $params){
		$result = '';
		
		$URL_Info=parse_url($url);
		if(empty($URL_Info["port"])) {
			$URL_Info["port"]=80;
		}
		$param_str = self::getParametersAsString($params);
		// building POST-request:
		$request .= "POST ".$URL_Info["path"]." HTTP/1.0\r\n";
		$request .= "Host: ".$URL_Info["host"]."\r\n";
		$request .= "Referer: ".$refer."\r\n";
		$request .= "Content-type: application/x-www-form-urlencoded\r\n";
		$request .= "Content-length: ".strlen($param_str)."\r\n";
		$request .= "Connection: close\r\n";
		$request .= "\r\n";
		$request .= $param_str;

		$fp = fsockopen($URL_Info["host"], $URL_Info["port"]);
		fputs($fp, $request);
		while(!feof($fp)) {
			$result .= fgets($fp, 1024);
		}
		fclose($fp);
		return $result;
	}
	protected function getParametersAsString(array $parameters)
	{
		$queryParameters = array();
		foreach ($parameters as $key => $value) {
			$queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
		}
		return implode('&', $queryParameters);
	}
}
?>