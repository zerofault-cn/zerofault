<?php

class AttachmentAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Attachment');
		parent::_initialize();
	}

	public function upload() {
		$return = !empty($_REQUEST['return']);
		$model_name = empty($_REQUEST['model_name']) ? MODULE_NAME : trim($_REQUEST['model_name']);
		$model_id = empty($_REQUEST['model_id']) ? 0 : intval($_REQUEST['model_id']);
		$input_name = $_REQUEST['input_name'];
		$file = $_FILES[$input_name];
		if($file['size'] > 0) {
			$data = array(
				'name' => $file['name'],
				'type' => $file['type'],
				'size' => $file['size'] ,
				'path' => 'html/Attach/'.$model_name.'/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)),
				'model_name' => $model_name,
				'model_id' => $model_id,
				'staff_id' => $_SESSION[C('ADMIN_ID')],
				'upload_time' => date('Y-m-d H:i:s'),
				'status' => 1
				);
			if (move_uploaded_file($file['tmp_name'], $data['path'])) {
				if (!M('Attachment')->add($data)) {
					if ($return) {
						return false;
					}
					else {
						die('{error: "Insert fail!'.$this->dao->getLastSql().'"}');
					}
				}
				else {
					if ($return) {
						return true;
					}
					else {
						die('{path:"'.__APP__.'/../'.$data['path'].'"}');
					}
				}
			}
			else {
				if ($return) {
					return false;
				}
				else {
					die('{error: "Move '.$file['tmp_name'].' to '.$data['path'].' fail!"}');
				}
			}
		}
	}

	public function delete() {
		$id = $_REQUEST['id'];
		$path = $this->dao->where('id='.$id)->getField('path');
		@unlink($path);
		if($this->dao->find($id) && $this->dao->delete())
		{
			self::success('删除成功！','',1200);
		}
		else
		{
			self::error('发生错误！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}

	}
}
?>