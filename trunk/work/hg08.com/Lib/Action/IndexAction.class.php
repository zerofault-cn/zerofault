<?php
class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index() {

		$news_category_arr = M('Category')->where("pid=7 and status>0")->getField('id,name');
		$rs = M('Article')->where("category_id in (".implode(',', array_keys($news_category_arr)).")")->order("sort, id desc")->limit(12)->select();
		$this->assign('news_list', $rs);


		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>