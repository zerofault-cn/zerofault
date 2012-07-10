<?php

class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>