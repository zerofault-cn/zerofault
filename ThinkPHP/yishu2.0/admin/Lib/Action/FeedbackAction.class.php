<?php
/**
*
* 网站留言管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class FeedbackAction extends BaseAction{
	protected $dao;

	/**
	*
	* 默认构造函数
	*/
	public function _initialize() {
		$this->dao = M('Feedback');
		parent::_initialize();
	}
	/**
	*
	* 显示评论列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '留言管理',
			'url' => __APP__.'/Feedback'
			);

		$topnavi[]=array(
			'text'=> '所有留言',
			);
		$where = array();
		$where['status'] = array('neq', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		$p->setConfig('first','<img src="'.APP_PUBLIC_PATH.'/Image/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_PATH.'/Image/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_PATH.'/Image/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_PATH.'/Image/last.gif" align="absbottom" alt="Last"/>');
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('content','Feedback:index');
		$this->display('Layout:Admin_layout');
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