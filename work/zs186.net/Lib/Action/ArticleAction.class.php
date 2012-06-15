<?php
class ArticleAction extends BaseAction {
	protected $dao, $category;

	public function _initialize() {
		$this->dao = D('Article');
		parent::_initialize();
		$options = C('_options_');
		$this->category = $options['article_category'];
	}
	public function _empty() {
		if (empty($_REQUEST['id'])) {
			$this->index(ACTION_NAME);
		}
		else {
			$this->detail($_REQUEST['id']);
		}
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
		$order = 'sort, id desc';
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
	public function detail() {
		if (empty($_REQUEST['id'])) {
			redirect(__URL__);
		}
		$id = intval($_REQUEST['id']);
		$this->dao->setInc('view', 'id='.$id);

		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['title']);
		$this->assign('MODULE_TITLE', $this->category[$info['category_id']]);
		$this->assign('category', $this->category[$info['category_id']]);
		$this->assign('info', $info);

		//获取上一篇，下一篇
		$rel_link = array();
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id<".$id." or sort<".$info['sort'].")")->order('sort desc, id desc')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['prev'] = $rs;
		}
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id>".$id." or sort>".$info['sort'].")")->order('sort, id')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['next'] = $rs;
		}
		$this->assign('rel_link', $rel_link);

		$this->assign('content', 'detail');
		$this->display('Layout:main');
	}
}
?>