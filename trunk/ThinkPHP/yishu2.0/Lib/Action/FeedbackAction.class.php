<?php
class FeedbackAction extends Action{
	public function index(){
		

		$this->assign('content','index');
		$this->display('Layout:Index_layout');
	}

}
?>