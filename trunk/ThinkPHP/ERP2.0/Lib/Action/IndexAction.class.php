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
	//	$this->assign('content','index');
	//	$this->display('Layout:ERP_layout');
		$this->redirect('Asset/index');
	}
}
?>