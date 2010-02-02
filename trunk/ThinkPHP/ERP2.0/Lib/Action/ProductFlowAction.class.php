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
		elseif(''!=(Session::get(ACTION_NAME.'_status'))) {
			$status = Session::get(ACTION_NAME.'_status');
		}
		else{
			$status = 0;
		}
		//Session::set(ACTION_NAME.'_status', $status);
		$this->assign('status', $status);
		
		$where = array();
		$where['status'] = $status;
		
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 20;
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
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductFlow:index');
		$this->display('Layout:ERP_layout');
	}

}
?>