<?php
class CompanyAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Company');
		parent::_initialize();
	}

	public function index($category_id=1) {

		$this->assign('MODULE_TITLE', '装修公司');
		$where = array(
			'status' => array('gt', 0)
			);
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 8;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
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