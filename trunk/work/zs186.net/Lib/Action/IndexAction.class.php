<?php
class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index() {
		$this->assign('MODULE_TITLE', '宜昌最有活力最具竞争力的会务会展全程服务专业团队');

		//酒店类型
		$this->assign('category_arr', M('Category')->where("type='Hotel'")->order('sort')->select());

		//酒店区域选项
		$this->assign('region_options', self::genOptions(M('Region')->where('pid=2')->order('sort')->getField('id,name')));

		$news_category_arr = M('Category')->where("pid=7 and status>0")->getField('id,name');
		$rs = M('Article')->where("category_id in (".implode(',', array_keys($news_category_arr)).")")->order("sort, id desc")->limit(12)->select();
		$this->assign('news_list', $rs);

		$this->assign('flink', F('Index-flink'));

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>