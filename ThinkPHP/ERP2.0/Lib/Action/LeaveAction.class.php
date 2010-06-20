<?php
/**
*
* 休假类型管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2010/6/15
*/
class LeaveAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'System');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Options');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'System');
	}
	public function index() {
		$Absence_Config = C('_absence_');
		
		$where = array();
		if (!empty($_POST['submit'])) {
			$id = intval($_REQUEST['id']);
			$data = array();
			$data['type'] = trim($_REQUEST['type']);
			$data['name'] = trim($_REQUEST['name']);
			$data['description'] = trim($_REQUEST['description']);
			if (''==$data['name']) {
				self::_error('Your must input a name!');
				return;
			}
			if ($id>0) {
				if (false !== $this->dao->where('id='.$id)->save($data)) {
					self::_success('Information updated!',__ACTION__);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			else {
				if (false !== $this->dao->add($data)) {
					self::_success('New leave type added!',__ACTION__);
				}
				else{
					self::_error('Add fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			return;
		}

		foreach($Absence_Config['leavetype'] as $key=>$val) {
			$rs = $this->dao->where(array('type'=>$key))->find();
			if (empty($rs)) {
				$result[$key] = array(
					'id' => -1,
					'type' => $key,
					'name' => $val,
					'description' => ''
				);
			}
			else {
				$result[$key] = array(
					'id' => $rs['id'],
					'type' => $key,
					'name' => empty($rs['name']) ? $val : $rs['name'],
					'description' => $rs['description']
					);
			}
		}
		$this->assign('ACTION_TITLE', 'Leave Type Definition');
		$this->assign('result', $result);
		$this->assign('content', MODULE_NAME.':'.ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function update() {
		parent::_update();
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('Absence')->where("leave_id=".$id)->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('This item is in-use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>