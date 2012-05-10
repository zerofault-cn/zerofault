<?php
class BaseAction extends Action{
	/**
	*
	* 对象初始化时自动执行
	*/
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		if (cookie(C('USER_ID'))) {
			//自动登录
			$rs = M('User')->where("status=1")->find(cookie(C('USER_ID')));
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
			}
		}
	}
	protected function _success($msg='', $url='', $timeout=1000, $id='message_box'){
		$html  = '<script language="JavaScript" type="text/javascript">';
		if($msg) {
			$html .= 'parent.show_msg("'.$id.'", "<b>'.$msg.'</b>");';
		}
		$html .= 'parent.myLocation("'.$url.'",'.$timeout.');';
		$html .= '</script>';
		die($html);
	}
	protected function _error($msg='', $id='message_box', $timeout=0){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.show_msg("'.$id.'", "<i>'.$msg.'</i>");';
		!empty($timeout) && $html .= 'parent.hide_msg("'.$id.'", '.$timeout.');';
		$html .= '</script>';
		die($html);
	}

	protected function genOptions($arr=array(), $selected='') {
		$str = '';
		if(empty($arr) || !is_array($arr)) {
			return $arr;
		}
		foreach($arr as $key=>$val) {
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

}
?>