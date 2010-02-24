<?php
/**
*
* 所有操作流水记录
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductFlowAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'System');
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	public function index() {
		Session::set('sub', MODULE_NAME);
		$this->assign('MODULE_TITLE', 'Operation Logs');
		$this->assign('ACTION_TITLE', 'List');
		
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get(MODULE_NAME.ACTION_NAME.'_status'))) {
			$status = Session::get(MODULE_NAME.ACTION_NAME.'_status');
		}
		else{
			$status = 0;
		}
		Session::set(MODULE_NAME.ACTION_NAME.'_status', $status);
		$this->assign('status', $status);
		
		$staff_id = empty($_REQUEST['staff_id']) ? 0 : intval($_REQUEST['staff_id']);
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), $staff_id, 'realname'));

		import("@.Paginator");
		$limit = 50;
		$where = array();
		$where['status'] = $status;
		if(!empty($_REQUEST['submit'])) {
			$p_where = array();
			!empty($_REQUEST['Internal_PN']) && ($p_where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			!empty($_REQUEST['description']) && ($p_where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			if (!empty($p_where)) {
				$rs = M('Product')->where($p_where)->getField('id,id');
				$where['product_id'] = array('IN', array_values($rs));
			}
			$staff_id>0 && $where['staff_id'] = $staff_id;
		}
		$count = $this->dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		//dump($rs);
		empty($rs) && ($rs = array());
		$result = array();
		foreach($rs as $item) {
			if ('location' == $item['from_type']) {
				$item['from_name'] = M('Location')->where('id='.$item['from_id'])->getField('name');
			}
			else {
				$item['from_name'] = M('Staff')->where('id='.$item['from_id'])->getField('realname');
			}
			if ('location' == $item['to_type']) {
				$item['to_name'] = M('Location')->where('id='.$item['to_id'])->getField('name');
			}
			else {
				$item['to_name'] = M('Staff')->where('id='.$item['to_id'])->getField('realname');
			}
			$result[] = $item;
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductFlow:index');
		$this->display('Layout:ERP_layout');
	}

}
?>