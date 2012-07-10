<?php
class ReserveAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Reservation');
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '预约管理',
			'url' => __APP__.'/Reserve'
			);

		$where = array();
		$where['status'] = 0;
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}
		$order = 'id desc';
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$this->assign("topnavi", $topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function update(){
		parent::_update();
	}
	private function delete(){
		parent::_delete();
	}
}
?>