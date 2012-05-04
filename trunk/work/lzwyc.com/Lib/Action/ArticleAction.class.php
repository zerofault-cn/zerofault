<?php
class ArticleAction extends BaseAction {
	protected $dao, $category;

	public function _initialize() {
		$this->dao = D('Article');
		parent::_initialize();
		$options = C('_options_');
		$this->category = $options['article_category'];
	}

	public function knowledge() {
		if (empty($_REQUEST['id'])) {
			$this->index(2);
		}
		else {
			$this->detail(intval($_REQUEST['id']));
		}
	}
	public function activity() {
		$this->index(4);
	}

	public function index($category_id=1) {

		if(!empty($_REQUEST['cid'])) {
			$category_id = $_REQUEST['cid'];
		}
		$this->assign('category', $this->category[$category_id]);
		$this->assign('MODULE_TITLE', $this->category[$category_id]);
		$where = array(
			'category_id' => $category_id,
			'status' => array('gt', 0)
			);
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 30;
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