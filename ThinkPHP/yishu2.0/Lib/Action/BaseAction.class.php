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

}
?>