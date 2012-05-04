<?php
class StaticAction extends BaseAction {

	public function _initialize() {
		parent::_initialize();
	}

	public function Indemnity() {
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:main');
	}

}
?>