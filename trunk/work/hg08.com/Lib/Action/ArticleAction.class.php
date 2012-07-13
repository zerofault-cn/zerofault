<?php
class ArticleAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Article');
		parent::_initialize();
	}
	public function _empty() {
		$this->assign('alias', ACTION_NAME);
		$left_list = $this->dao->where("category_id=1 and status>0")->order('sort, id desc')->select();
		array_unshift($left_list, array('alias'=> 'news', 'name'=>'最新活动', ));
		$this->assign('left_list', $left_list);
		
		$id = intval($_REQUEST['id']);
		if (empty($id)) {
			if ('news' == ACTION_NAME) {
				$this->assign('MODULE_TITLE', '最新活动');
				$this->index(2);
				exit;
			}

			$where = array(
				'category_id' => 1,
				'status' => array('gt', 0)
				);
			$order = 'sort, id desc';
			$row = $this->dao->where($where)->order($order)->find();
			$id = $row['id'];
			$_GET['id'] = $id;
		}
		$this->detail($id);
	}
	public function index($category_id) {
		empty($category_id) && ($category_id=2);
		$where = array(
			'category_id' => $category_id,
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