<?php
/**
*
* 分类管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class LineAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = M('Line');
		parent::_initialize();
	}

	/**
	*
	* 分类列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '线路管理',
			'url' => __APP__.'/Line'
			);
			$topnavi[]=array(
				'text'=> '线路列表',
			);

		$where = array();
		$order = 'update_time';
		$order = '';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$dSite = M('Site');
		$site_arr = $dSite->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}


		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list',$rs);
		$this->assign('site', $site);
		$this->assign('content','Line:index');
		$this->display('Layout:Admin_layout');
	}
	function check() {
		foreach(explode('/',$_REQUEST['name']) as $name);
		
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