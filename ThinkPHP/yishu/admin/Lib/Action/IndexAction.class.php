<?php
class IndexAction extends PublicAction{
	
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