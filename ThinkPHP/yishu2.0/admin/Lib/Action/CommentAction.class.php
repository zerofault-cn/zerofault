<?php
/**
*
* 网站评论管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class CommentAction extends BaseAction{
	protected $dao;

	/**
	*
	* 默认构造函数
	*/
	public function _initialize() {
		$this->dao = D('Comment');
		parent::_initialize();
	}
	/**
	*
	* 显示评论列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '评论管理',
			'url' => __APP__.'/Comment'
			);

		$dWebsite = D('Website');
		if(!empty($_REQUEST['id'])){
			$where['site_id'] = $_REQUEST['id'];
			$site_name = $dWebsite->where(array('id'=>$_REQUEST['id']))->getField('name');
			$topnavi[]=array(
				'text'=> '给网站【'.$site_name.'】的评论',
				);
		}
		else{
			$topnavi[]=array(
				'text'=> '所有评论',
				);
		}
		$where['status'] = 1;
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		$p->setConfig('first','<img src="'.APP_PUBLIC_URL.'/Image/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_URL.'/Image/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_URL.'/Image/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_URL.'/Image/last.gif" align="absbottom" alt="Last"/>');
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['site_info'] = $dWebsite->find($val['site_id']);
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('content','Comment:index');
		$this->display('Layout:Admin_layout');
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