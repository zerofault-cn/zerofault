<?php
class BaseAction extends Action{
	protected $category_array;

	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");

		$this->category_array = array(
			'Hotel' => M('Category')->where("type='Hotel' and status>0")->order('sort')->getField('id,name'),
			'Article' => M('Category')->where("type='Article' and status>0 and pid=0")->order('sort')->getField('id,name')
			);
		$this->assign("Hotel_Category", $this->category_array['Hotel']);
		$this->assign("Article_Category", $this->category_array['Article']);
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
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=$_REQUEST['v'];
		//$value = iconv("GB2312", "UTF-8", $value);
		$rs = $this->dao->where('id='.$id)->setField($field,$value);
		if(false !== $rs)
		{
		//	Log::Write($this->dao->getLastSql(), INFO);
			self::_success('操作成功！','',1200);
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
			self::_success('删除成功！','',1200);
		}
		else
		{
			self::_error('发生错误！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
}
?>