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
	//	dump($_SESSION);

		import('@.RBAC');
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
				if(in_array(ACTION_NAME,C('IFRAME_AUTH_ACTION'))) {
					die(self::_error('没有权限！', 2000));
				}
				$this->assign('message','没有权限！');
				$this->assign('content','Public:error');
				$this->display('Layout:Admin_layout');
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
	/**
	*
	* 更新某条纪录的某个字段
	* 只能在_iframe中执行，执行后在父窗口提示结果
	*/
	protected function _update(){
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=$_REQUEST['v'];
		$value = iconv("GB2312", "UTF-8", $value);
		$rs = $this->dao->where('id='.$id)->setField($field,$value);
		if(false !== $rs)
		{
			Log::Write($this->dao->getLastSql(), INFO);
			die(self::_success('操作成功！','',1200));
		}
		else
		{
			die(self::_error('发生错误！<br />sql:'.$this->dao->getLastSql()));
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
			die(self::_success('删除成功！','',1200));
		}
		else
		{
			die(self::_error('发生错误！<br />sql:'.$this->dao->getLastSql()));
		}
	}
}
?>