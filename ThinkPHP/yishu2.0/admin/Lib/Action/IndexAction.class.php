<?php
/**
*
* 管理首页
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class IndexAction extends BaseAction{
	/**
	*
	* 管理后台默认首页
	*/
	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
}
?>