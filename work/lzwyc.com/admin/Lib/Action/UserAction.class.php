<?php
class UserAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
	}
	public function index(){
		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/User'
			);
		$topnavi[]=array(
			'text'=> '用户列表',
			);
		$this->assign("topnavi",$topnavi);

		$order = 'id desc';
		$where = array();
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = intval($_REQUEST['status']);
		}
		if (!empty($_REQUEST['type'])) {
			$where['type'] = intval($_REQUEST['type']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach ($rs as $i=>$row) {
			if (2 == $row['type']) {
				$rs[$i]['company_name'] = M('Company')->where("user_id=".$row['id'])->getField('name');
			}
		}

		$this->assign('list',$rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}

}
?>