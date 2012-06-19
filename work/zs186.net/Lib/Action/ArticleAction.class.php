<?php
class ArticleAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Article');
		parent::_initialize();
	}
	public function _empty() {
		$id = intval($_REQUEST['id']);
		if (empty($id)) {
			$alias = ACTION_NAME;
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category = M('Category')->where("pid=".$category_id)->select();
			if (!empty($sub_category) && count($sub_category)>0) {
				$this->index($category['id']);
				exit;
			}

			$where = array(
				'category_id' => $category['id'],
				'status' => array('gt', 0)
				);
			$order = 'sort, id';
			$row = $this->dao->where($where)->order($order)->find();
			$id = $row['id'];
			$_GET['id'] = $id;
		}
		else {
			$category_id = $this->dao->where("id=".$id)->getField('category_id');
			$category = M('Category')->find($category_id);
		}
		$this->assign('category', $category);

		$left_list = $this->dao->where("category_id=".$category['id']." and status>0")->order('sort, id')->select();
		$this->assign('left_list', $left_list);
		$this->detail($id);
	}
	public function index($category_id=0) {
		//取第一个子分类
		$first_sub_category = M('Category')->where("pid=".$category_id)->find();

		//子分类文章列表
		$where = array(
			'category_id' => $first_sub_category['id'],
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());
	}

	public function detail($id=0) {
		!empty($_REQUEST['id']) && ($id = intval($_REQUEST['id']));
		$this->dao->setInc('view', 'id='.$id);

		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['title']);
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