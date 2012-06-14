<?php
class HotelAction extends BaseAction{
	protected $dao, $topnavi;

	protected function _initialize() {
		parent::_initialize();
		$this->dao = D('Hotel');
		$this->topnavi[] = array(
			'text' => '酒店管理'
			);
	}
	public function category() {
		$this->topnavi[]=array(
			'text'=> '酒店分类',
			'url' => __URL__.'/category'
			);
		$this->assign("topnavi", $this->topnavi);

		R('Category', 'index');
	}
	public function index(){

		$topnavi[]=array(
			'text'=> empty($_REQUEST['category_id'])?'酒店列表':M('Category')->where("id=".intval($_REQUEST['category_id']))->getField('name'),
			);
		$this->assign("topnavi",$topnavi);

		$where = array();
		$order = 'sort desc';
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		if (!empty($_REQUEST['category_id'])) {
			$where['category_id'] = intval($_REQUEST['category_id']);
		}
		if (!empty($_REQUEST['s_name'])) {
			$where['name'] = array('LIKE', '%'.trim($_REQUEST['s_name']).'%');
			$this->assign('s_name', $_REQUEST['s_name']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function update(){
		parent::_update();
	}
	public function delete(){
		parent::_delete();
	}
}
?>