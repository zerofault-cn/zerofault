<?php

class AttachmentAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Attachment');
		parent::_initialize();
	}

	public function delete() {
		$id = $_REQUEST['id'];
		$path = $this->dao->where('id='.$id)->getField('path');
		@unlink($path);
		self::_delete();
		
	}
}
?>