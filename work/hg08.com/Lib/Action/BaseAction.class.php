<?php
class BaseAction extends Action{

	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		
		$this->assign('setting', F('System-setting'));
		$this->assign('flink', F('System-flink'));
		$this->assign('image_index', F('System-image_index'));
		$this->assign('image_main', F('System-image_main'));

		$Article_about = M('Article')->where('category_id=1 and status>0')->order('sort')->select();
		$this->assign('Article_about', $Article_about);

		$Album_category = M('Category')->where("status>0 and pid=4")->order('sort')->select();
		$this->assign('Album_category', $Album_category);

		$rs = M('Article')->where("category_id=2 and status>1")->order("sort, id desc")->select();
		$this->assign('top_list', $rs);

	}

	protected function success($msg, $url='', $timeout=2000){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
		$html .= 'parent.myLocation("'.$url.'",'.$timeout.');';
		$html .= '</script>';
		die($html);
	}
	protected function error($msg, $timeout=0){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.addslashes($msg).'");';
		$timeout && ($html .= 'parent.myOK('.$timeout.');');
		$html .= '</script>';
		die($html);
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
		!empty($timeout) && ($html .= 'parent.hide_msg("'.$id.'", '.$timeout.');');
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
	protected function genRadios($arr=array(), $checked='', $name='radio', $sp=' ', $force_br=0) {
		$str = '';
		if(empty($arr) || !is_array($arr)) {
			return $arr;
		}
		$i = 0;
		foreach($arr as $key=>$val) {
			$i ++;
			$str .= '<input type="radio" class="radio" name="'.$name.'" id="radio_'.$name.'_'.$key.'" value="'.$key.'" ';
			if($checked == $key) {
				$str .= ' checked="checked"';
			}
			$str .= '><label for="radio_'.$name.'_'.$key.'">'.$val.'</label>'.$sp;
			if ($force_br>0 && $i%$force_br==0) {
				$str .= '<br />';
			}
		}
		return $str;
	}

}
?>