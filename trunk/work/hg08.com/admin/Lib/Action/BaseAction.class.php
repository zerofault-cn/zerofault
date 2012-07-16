<?php
class BaseAction extends Action {
	protected $category_array;

	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		
		import('@.RBAC');
		//检查是否已登录
		if('Public'!=MODULE_NAME && empty($_SESSION[C('USER_AUTH_KEY')])) {
			//跳转到认证网关
			redirect(__APP__.'/Public/login');
			exit;
		}

		$this->category_array = array(
			'Article' => M('Category')->where("type='Article' and status>0 and pid=0")->order('sort')->getField('id,name'),
			'Album' => M('Category')->where("type='Album' and status>0 and pid!=0")->order('sort')->getField('id,name')
			);
		$Article_Category = $this->category_array['Article'];
	//	$this->assign("Article_Category", $Article_Category);
		$Album_Category = $this->category_array['Album'];
	//	$this->assign("Album_Category", $Album_Category);
		
		$menu = C('menu');
		//dump($menu);
		//确定可显示的一级菜单
		$tmp_menu = array();
		foreach ($menu as $name=>$submenu) {
			$tmp_submenu = array();
			foreach ($submenu as $sub_name=>$sub_action) {
				if (RBAC::AccessDecision($sub_action[0], $sub_action[1])) {
					if ('foreach' == strtolower($sub_name)) {
						foreach (${$sub_action[2]} as $key=>$val) {
							$sub_action[2] = array('category_id', $key);
							$tmp_submenu[$val] = $sub_action;
						}
					}
					else {
						$tmp_submenu[$sub_name] = $sub_action;
					}
					
				}
			}
			if (!empty($tmp_submenu)) {
				$tmp_menu[$name] = $tmp_submenu;
			}
		}
		$this->assign('menu', $tmp_menu);

		// 检查权限
		if(!RBAC::AccessDecision()) {
			if(in_array(ACTION_NAME, C('IFRAME_ACTION'))) {
				die(self::_error('没有权限！', 2000));
			}
			$this->assign('message','没有权限！');
			$this->assign('content','Public:error');
			$this->display('Layout:default');
			exit;
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
	protected function _success($msg, $url='', $timeout=2000) {
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
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
		$html .= 'parent.myAlert("<i>'.$msg.'</i>");';
		$timeout && $html .= 'parent.myOK('.$timeout.');';
		$html .= '</script>';
		die($html);
	}
	/**
	*
	* 根据数组生成HTML格式的下拉列表选项
	*
	* @param array $rs 预设的二维数组，key作为值，val作为显示
	*
	*/
	protected function genOptions($rs=array(), $selected='') {
		$str = '';
		if(empty($rs) || !is_array($rs)) {
			return $str;
		}
		foreach($rs as $key=>$val) {
			$str .= '<option value="'.$key.'" ';
			if(isset($selected) && ''!==$selected && (is_array($selected)? in_array($key, $selected) : $selected==$key)) {
				$str .= ' selected="selected"';
			}
			$str .= '>'.$val.'</option>';
		}
		return $str;
	}
	protected function genRadios($arr=array(), $checked='', $name='radio', $sp=' ') {
		$str = '';
		if(empty($arr) || !is_array($arr)) {
			return $arr;
		}
		foreach($arr as $key=>$val) {
			$str .= '<input type="radio" class="radio" name="'.$name.'" id="radio_'.$name.'_'.$key.'" value="'.$key.'" ';
			if($checked == $key) {
				$str .= ' checked="checked"';
			}
			$str .= '><label for="radio_'.$name.'_'.$key.'">'.$val.'</label>'.$sp;
		}
		return $str;
	}

	/**
	*
	* 更新某条纪录的某个字段
	* 只能在_iframe中执行，执行后在父窗口提示结果
	*/
	protected function _update(){
		if (!empty($_REQUEST['t'])) {
			$this->dao = M(trim($_REQUEST['t']));
		}
		if (false !== strpos($_REQUEST['f'], '_')) {
			list($table, $field) = explode('_', trim($_REQUEST['f']));
			$this->dao = M(ucfirst($table));
			$_REQUEST['f'] = $field;
		}

		$id = intval($_REQUEST['id']);
		$field = $_REQUEST['f'];
		$value = $_REQUEST['v'];
		'password'==$field && ($value = md5($value));
		//$value = iconv("GB2312", "UTF-8", $value);
		if(false !== $this->dao->where('id='.$id)->setField($field, $value))
		{
			self::_success('操作成功！');
		}
		else
		{
			self::_error('发生错误！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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
			self::_success('删除成功！');
		}
		else
		{
			self::_error('发生错误！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
}
?>