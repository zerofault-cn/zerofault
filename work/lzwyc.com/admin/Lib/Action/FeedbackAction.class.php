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

		$where = array();
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
			$where['status'] = 0;
			if(!empty($_REQUEST['status'])) {
				$where['status'] = $_REQUEST['status'];
			}
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
	public function reply() {
		if (!empty($_POST['id'])) {
			if ($this->dao->where('id='.intval($_POST['id']))->setField(array('reply','replytime'), array(trim($_REQUEST['reply']), date("Y-m-d H:i:s")))) {
				die('1');
			}
			else {
				die('Error:'.C('APP_DEBUG')?$this->dao->getLastSql():'');
			}
		}
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