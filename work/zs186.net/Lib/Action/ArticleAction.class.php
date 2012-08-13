<?php
class ArticleAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Article');
		parent::_initialize();
	}
	public function _empty() {
		$id = intval($_REQUEST['id']);
		$alias = ACTION_NAME;
		$this->assign('alias', $alias);
		if (empty($id)) {
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category = M('Category')->where("pid=".$category['id']." and status>0")->order('sort')->find();
			if (!empty($sub_category)) {
				$_GET['id'] = $sub_category['id'];
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
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category_count = M('Category')->where("pid=".$category['id']." and status>0")->count();
			if (!empty($sub_category_count) && $sub_category_count>0) {
				$this->index();
				exit;
			}
			$category_id = $this->dao->where("id=".$id)->getField('category_id');
			$category = M('Category')->find($category_id);
		}
		$this->assign('category', $category);

		$left_list = $this->dao->where("category_id=".$category['id']." and status>0")->order('sort, id')->select();
		$this->assign('left_list', $left_list);
		$this->detail($id);
	}
	public function index($pid=0) {
		if (!empty($_REQUEST['id'])) {
			$category_id = intval($_REQUEST['id']);
			$category = M('Category')->find($category_id);
			$pid = $category['pid'];
		}
		$sub_category = M('Category')->where("pid=".$pid." and status>0")->order('sort, id desc')->select();
		$this->assign('left_list', $sub_category);
		if (empty($_REQUEST['id'])) {
			//取第一个子分类
			$category = array_shift($sub_category);
		}
		$this->assign('category', $category);
		//子分类文章列表
		$where = array(
			'category_id' => $category['id'],
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

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}

	public function detail($id=0) {
		$detail_id = $id;
		!empty($_REQUEST['id']) && ($id = intval($_REQUEST['id']));
		$this->dao->setInc('view', 'id='.$id);

		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['title']);
		$this->assign('info', $info);

		if (0 == $detail_id) {
			//url传参
			$category = M('Category')->find($info['category_id']);
			$this->assign('category', $category);
			$sub_category = M('Category')->where("pid=".$category['pid']." and status>0")->order('sort')->select();
			$this->assign('left_list', $sub_category);
			$this->assign('alias', M('Category')->where("id=".$category['pid'])->getField('alias'));
			$_GET['id'] = $category['id'];
		}

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