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

		import('@.RBAC');

		!empty($_REQUEST['pmenu']) && Session::set('pmenu', urldecode($_REQUEST['pmenu']));
		$menu = C('_menu_');
		$menu = $menu['menu'];
		foreach($menu as $key=>$val) {
			if(str_replace('&nbsp;',' ',$key) == Session::get('pmenu')) {
				$submenu = $menu[$key]['submenu'];
			}
			if(!RBAC::AccessDecision($val['name'], 'index')) {
				unset($menu[$key]);
				continue;
			}
			if(empty($val['submenu']) || !is_array($val['submenu'])) {
				continue;
			}
			foreach($val['submenu'] as $key2=>$val2) {
				if(!RBAC::AccessDecision($val2, 'index')) {
					unset($menu[$key]['submenu'][$key2]);
				}
			}
		}
		$this->assign('menu', $menu);
		$this->assign('submenu', $submenu);
		$this->assign('action', Session::get('action'));
		$this->assign("current_time", date("l, d/m/Y | h:i A"));//Thursday, 10/09/2009 | 11:53 AM
		// 认证当前操作
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
				if(in_array(ACTION_NAME,C('IFRAME_AUTH_ACTION'))) {
					die(self::_error('No Permission', 2000));
				}
				$this->assign('message','No Permission');
				$this->assign('content','Public:error');
				$this->display('Layout:ERP_layout');
				exit;
			}
		}
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
			die(self::_success('Success!','',1000));
		}
		else
		{
			die(self::_error('Error!'));
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
			die(self::_success('Success!','',1000));
		}
		else
		{
			die(self::_error('Error!'));
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
	protected function genOptions($rs=array(), $selected_id=0, $title='name', $value='id') {
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
	public function update_quantity($product_id) {
		$where = array();
		if(is_array($product_id) && !empty($product_id)) {
			$where['id'] = array('in',implode(',',$product_id));
		}
		elseif(''!=$product_id) {
			$where['id'] = $product_id;
		}
		$rs = D('Product')->where($where)->select();
		if($rs) {
			foreach($rs as $item) {
				$quantity = 0;
				$flow = D('ProductFlow')->where(array('product_id'=>$item['id'],'status'=>1))->select();
				if($flow) {
					foreach($flow as $flow_item) {
						$quantity += (('Storage'==$flow_item['destination'])?1:-1)*$flow_item['quantity'];
					}
				}
				D('Product')->where('id='.$item['id'])->setField('quantity', $quantity);
			}
		}
		return true;
	}
}
?>