<?php
/**
*
* Feedback
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class FeedbackAction extends BaseAction{


	public function _initialize() {
		parent::_initialize();
	}

	public function index(){
		$this->assign('content','');
		$this->display('Layout:ERP_layout');
	}


}
?>