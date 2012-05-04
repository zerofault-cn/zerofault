<?php
class FeedbackAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Feedback');
		parent::_initialize();
	}
	public function index(){
		$topnavi[]=array(
			'text'=> '留言管理',
			'url' => __APP__.'/Feedback'
			);

		$dCompany = D('Company');
		if(!empty($_REQUEST['id'])){
			$where['company_id'] = $_REQUEST['id'];
			$company_name = $dCompany->where(array('id'=>$_REQUEST['id']))->getField('name');
			$topnavi[]=array(
				'text'=> '给【'.$company_name.'】的留言',
				);
		}
		else{
			$topnavi[]=array(
				'text'=> '所有留言',
				);
		}
		$where['status'] = 1;
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['company_info'] = $dCompany->find($val['company_id']);
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
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