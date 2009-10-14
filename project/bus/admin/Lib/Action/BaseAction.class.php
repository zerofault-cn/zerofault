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
		if(!defined('CLI')) {
			if(!Session::is_set('isAdmin') && ACTION_NAME != 'login' && ACTION_NAME != 'checkLogin'){
				Session::set('lastModule', MODULE_NAME);
				redirect(__APP__.'/Public/login');
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
		if($rs)
		{
			self::_success('操作成功！',__URL__.'/index/status/0',1200);
		}
		else
		{
			self::_error('发生错误！<br />sql:'.$this->dao->getLastSql());
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
	protected function httpPost($url,$params,$refer){
		$result = '';
		
		$URL_Info=parse_url($url);
		if(empty($URL_Info["port"])) {
			$URL_Info["port"]=80;
		}
		if(empty($refer)) {
			$refer = $URL_Info['scheme'].'://'.$URL_Info['host'];
		}
		
		// building POST-request:
		$request .= "POST ".$URL_Info["path"]." HTTP/1.1\n";
		$request .= "Host: ".$URL_Info["host"]."\n";
		$request .= "Referer: ".$refer."\n";
		$request .= "Content-type: application/x-www-form-urlencoded\n";
		$request .= "Content-length: ".strlen($params)."\n";
		$request .= "Connection: close\n";
		$request .= "\n";
		//$request.=$data_string."\n";
		$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
		fputs($fp, $request);
		while(!feof($fp)) {
			$result .= fgets($fp, 1024);
		}
		fclose($fp);
		return $result;
	}
}
?>