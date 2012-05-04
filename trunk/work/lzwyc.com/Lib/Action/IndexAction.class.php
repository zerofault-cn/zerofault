<?php
class IndexAction extends BaseAction{

	public function index(){
		$this->assign('MODULE_NAME', MODULE_NAME);
		$this->assign('MODULE_TITLE', '首页');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>