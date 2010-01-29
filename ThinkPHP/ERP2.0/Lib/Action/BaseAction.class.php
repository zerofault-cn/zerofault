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
		$top = empty($_REQUEST['top']) ? '' : $_REQUEST['top'];
		!$top && ($top = Session::get('top'));
		!$top && ($top = 'Assets Management');
		Session::set('top', urldecode($top));

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
			foreach($_SESSION['manager'] as $location_id=>$location) {
				$submenu['Transfer to '.ucfirst($location['name'])] = 'Asset/location/id/'.$location_id;
			}
			//判断是否Leader，以增加request子菜单
			if (!empty($_SESSION['staff']['is_leader'])) {
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
				if (empty($_SESSION['staff']['is_leader']) && 'Asset/request'==$sub_action) {
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
			die(self::_success('Delete success!','',1000));
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
	protected function _mail($type='apply',$flow_id=0) {
		$mail_tpl = array(
			'apply' => array(
				'title' => "[staff] apply Product Requisition [code] for approval",
				'body'  => "Hi [leader],\n\n  [staff] need to apply [product] [quantity] [unit], please login into the ERP System and approve the ER in the system. Thanks.\n  Direct access link as below:\n\t[url]"),
			'apply_reject' => array(
				'title' => "Apply Product Requisition [code] for [staff] was rejected",
				'body' => "Hi [staff],\n\n[leader] rejected your application [product] [quantity] [unit], please noted. Thanks.\n  Direct access link as below:\n\t[url]"),
			'apply_approve' => array(
				'title' => "ER was approved, please release the product [product]",
				'body'  => "Hi [manager],\n\n  [staff] need to apply [product] [quantity] [unit], it's approved, please release the product to him and confirm the ER in the System. Thanks.\n  Direct access link as below:\n\t[url]"),
			'transfer' => array(
				'title' => "[from_staff] Transfer Request [code]",
				'body'  => "Hi [to_staff],\n\n  [from_staff] want to transfer [product] [quantity] [unit] to you, please login into the system and confirm the Transfer Request in the system. Thanks.\n  Direct access link as below:\n\t[url]"),
			'transfer_reject' => array(
				'title' => "[from_staff] Transfer Request was rejected by [to_staff] [code]",
				'body'  => "Hi [from_staff],\n\n  [to_staff] rejected your transfer request [product] [quantity] [unit], please be noted. Thanks.\n  Direct access link as below:\n\t[url]"),
			'return'  => array(
				'title' => "[staff] Return Request [code]",
				'body'  => "Hi [manager],\n\n  [staff] want to return [product] [quantity] [unit] to you, please login into the System and operate it quickly. Thanks.\n  Direct access link as below:\n\t[url]"),
			'modify' => array(
				'title' => "Administrator modified your Requisition",
				'body' => "Hi [staff],\n\n  Administrator modified your requisition [product] [quantity] [unit], please noted. Thanks.\n ")
			);
		$mail_body_ext = "\n\n\nThis mail was sent by the System automatically, please don't reply it.";
		
		$flow_info = M('ProductFlow')->find($flow_id);
		$staff_info = M('Staff')->find($flow_info['staff_id']);
		if ($staff_info['leader_id']>0) {
			$leader_info = M('Staff')->find($staff_info['leader_id']);
		}
		if ('location' == $flow_info['to_type']) {
			$manager_id = M('LocationManager')->where(array('location_id'=>$flow_info['to_id'], 'fixed'=>$flow_info['fixed']))->getField('staff_id');
			$to_staff_info = M('Staff')->find($manager_id);
		}
		else {
			$to_staff_info = M('Staff')->find($flow_info['to_id']);
		}
		if ('location' == $flow_info['from_type']) {
			$manager_id = M('LocationManager')->where(array('location_id'=>$flow_info['from_id'], 'fixed'=>$flow_info['fixed']))->getField('staff_id');
			$from_staff_info = M('Staff')->find($manager_id);
		}
		else {
			$from_staff_info = M('Staff')->find($flow_info['from_id']);
		}

		$manager_id = M('LocationManager')->where(array('location_id'=>1,'fixed'=>$flow_info['fixed']))->getField('staff_id');
		$manager = M('Staff')->find($manager_id);
		$product_info = M('Product')->find($flow_info['product_id']);
		$unit_name = M('Options')->where('id='.$product_info['unit_id'])->getField('name');

		$send_to = array();
		if ('reject' == $type) {
			$type = $flow_info['action'].'_reject';
		}

		switch ($type) {
			case 'apply' :
				if (!empty($leader_info)) {
					$send_to[] = $leader_info['email'];
					$send_to[] = $manager['email'];
					$send_to[] = $staff_info['email'];
					$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/Asset/request";

					$title = str_replace(
						array('[staff]','[code]'),
						array($staff_info['realname'], $flow_info['code']),
						$mail_tpl[$type]['title']);
					$body = str_replace(
						array('[leader]','[staff]','[product]','[quantity]','[unit]','[url]'),
						array($leader_info['realname'],$staff_info['realname'],
						'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
					break;
				}
				//continue to approve

			case 'apply_approve' :
				$send_to[] = $manager['email'];
				$send_to[] = $staff_info['email'];
				$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/Asset/request";

				$title = str_replace(
					'[product]',
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'],
					$mail_tpl[$type]['title']);
				$body = str_replace(
					array('[manager]', '[leader]','[staff]','[product]','[quantity]','[unit]','[url]'),
					array($manager['realname'], $leader_info['realname'],$staff_info['realname'],
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
				break;

			case 'apply_reject' :
				$send_to[] = $staff_info['email'];
				$send_to[] = $manager['email'];
				$send_to[] = $leader_info['email'];
				$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/Asset/apply/status/-1";

					$title = str_replace(
						array('[staff]','[code]'),
						array($staff_info['realname'], $flow_info['code']),
						$mail_tpl[$type]['title']);
				$body = str_replace(
					array('[leader]','[staff]','[product]','[quantity]','[unit]','[url]'),
					array($leader_info['realname'],$staff_info['realname'],
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
				break;
			
			case 'transfer':
				if ('location' == $flow_info['to_type']) {
					$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/ProductOut/transfer";
				}
				else {
					$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/Asset/transferIn";
				}
				$send_to[] = $to_staff_info['email'];

				$send_to[] = $from_staff_info['email'];

				$title = str_replace(
					array('[from_staff]','[code]'),
					array($from_staff_info['realname'], $flow_info['code']),
					$mail_tpl[$type]['title']);
				$body = str_replace(
					array('[to_staff]','[from_staff]','[product]','[quantity]','[unit]','[url]'),
					array($to_staff_info['realname'],$from_staff_info['realname'],
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
				break;

			case 'transfer_reject' :
				$send_to[] = $from_staff_info['email'];
				$send_to[] = $to_staff_info['email'];
				$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/Asset/transferOut/status/-1";

				$title = str_replace(
					array('[from_staff]','[to_staff]','[code]'),
					array($from_staff_info['realname'], $to_staff_info['realname'], $flow_info['code']),
					$mail_tpl[$type]['title']);
				$body = str_replace(
					array('[from_staff]','[to_staff]','[product]','[quantity]','[unit]','[url]'),
					array($from_staff_info['realname'],$to_staff_info['realname'],
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
				break;

			case 'return':
				$send_to[] = $manager['email'];
				$send_to[] = $staff_info['email'];
				$url = "http://".$_SERVER['SERVER_ADDR'].__APP__."/ProductOut/returns";

				$title = str_replace(
					array('[staff]','[code]'),
					array($staff_info['realname'],$flow_info['code']),
					$mail_tpl[$type]['title']);
				$body = str_replace(
					array('[manager]','[staff]','[product]','[quantity]','[unit]','[url]'),
					array($manager['realname'], $staff_info['realname'],
					'Component'==$product_info['type']?$product_info['Internal_PN']:$product_info['description'], $flow_info['quantity'], $unit_name, $url), $mail_tpl[$type]['body']);
				break;

			default :
				//do not send any mail
				return;
		}
		$cmd = 'echo "'.$body.$mail_body_ext.'"|/usr/bin/mutt -s "'.$title.'" '.$send_to[0];
		if (count($send_to)>1) {
			$cmd .= ' -c '.implode(' -c ', array_slice($send_to,1));
		}
		Log::Write($cmd, INFO);
		system($cmd,$ret);
		if('0'==$ret) {
			Log::Write('Success@'.date("Y-m-d H:i:s"));
			return true;
		}
		else{
			Log::Write('Fail@'.date("Y-m-d H:i:s"));
			return false;
		}
	}
}
?>