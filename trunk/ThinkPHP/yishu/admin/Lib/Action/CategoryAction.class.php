<?php
/**
*
* 分类管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class CategoryAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = D('Category');
		parent::_initialize();
	}

	/**
	*
	* 分类列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '分类管理',
			'url' => __APP__.'/Category'
			);

		$where['status'] = array('gt', -1);
		$where['pid']  = 0;
		$order = 'status desc, sort';

		if(isset($_REQUEST['status'])){
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';

			$topnavi[]=array(
				'text'=> '已删除的分类',
			);
		}
		else{
			$topnavi[]=array(
				'text'=> '分类列表',
			);
		}

		$rs = $this->dao->where($where)->order($order)->select();
		foreach($rs as $key=>$val){
			$site = D('Website');
			$rs[$key]['site_count'] = $site->where(array('cate_id'=>$val['id']))->getField('count(*) as count');
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('new_cate_sort', $this->dao->where($where)->getField('max(sort) as max_sort')+10);
		$this->assign('content','Category:index');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 添加分类
	* 只能被JQuery.post()调用
	* 返回值：
	*     -1：已存在同名纪录；
	*      1：操作成功；
	*   其它：出错的SQL语句
	*/
	public function add(){
		$name=$_REQUEST['name'];
		$sort=intval($_REQUEST['sort']);

		$where['name'] = $name;
		$rs = $this->dao->where($where)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$this->dao->name = $name;
		$this->dao->addtime = $this->dao->usetime = date("Y-m-d H:i:s");
		$this->dao->sort = $sort;
		$this->dao->status = 1;
		if($this->dao->add()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
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