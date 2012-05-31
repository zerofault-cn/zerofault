<?php
class DesignerAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Designer');
		parent::_initialize();
	}

	public function index() {

		$this->assign('MODULE_TITLE', '设计师列表');
		$where = array(
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 5;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach ($rs as $i=>$row) {
			$rs[$i]['workage'] = ceil((date('Y')+date('m')/12)-substr($row['workdate'], 0, 4)-substr($row['workdate'], 5,2)/12);
		}

		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}
	public function detail($id=0) {
		if (empty($id)) {
			redirect(__URL__);
		}
		$id = intval($_REQUEST['id']);
		$info = $this->dao->find($id);

		$this->assign('ACTION_TITLE', $info['title']);
		$this->assign('MODULE_TITLE', $this->category[$info['category_id']]);
		$this->assign('category', $this->category[$info['category_id']]);
		$this->assign('info', $info);


		$this->dao->setInc('view', 'id='.$id);

		$this->assign('content', 'detail');
		$this->display('Layout:main');
	}
}
?>