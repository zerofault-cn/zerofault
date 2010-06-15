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
		$this->dao = D('Leave');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'System');
	}
	public function index() {
		$where = array();
		if (!empty($_POST['submit'])) {
			$id = intval($_REQUEST['id']);
			$data = array();
			$data['name'] = trim($_REQUEST['name']);
			$data['description'] = trim($_REQUEST['description']);
			$data['sort'] = intval($_REQUEST['sort']);
			if (''==$data['name']) {
				self::_error('Your must input a name!');
				return;
			}
			if ($id>0) {
				if (false !== M('Leave')->where('id='.$id)->save($data)) {
					self::_success('Information updated!',__ACTION__);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			else {
				$data['status'] = 1;
				if (false !== M('Leave')->add($data)) {
					self::_success('New leave type added!',__ACTION__);
				}
				else{
					self::_error('Add fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			return;
		}
		elseif (!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$info = M('Leave')->find($_REQUEST['id']);
		}
		else {
			$info = array(
				'name' => '',
				'description' => '',
				'sort' => M('Leave')->max('sort')+1
				);
		}

		$this->assign('ACTION_TITLE', 'Leave Type Setting');
		$this->assign('result', M('Leave')->where($where)->order('sort')->select());
		$this->assign('info', $info);
		$this->assign('content','Leave:index');
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