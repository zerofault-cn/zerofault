<?php
class CompanyAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Company');
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '公司管理',
			'url' => __APP__.'/Company'
			);

		$order = 'id desc';
		$topnavi[]=array(
			'text'=> '公司列表',
			);
		$this->assign("topnavi",$topnavi);

		$where = array();
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		if (!empty($_REQUEST['s_name'])) {
			$where['name'] = array('LIKE', '%'.trim($_REQUEST['s_name']).'%');
			$this->assign('s_name', $_REQUEST['s_name']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改公司资料',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加公司',
				);
			$info = array('id' => 0);
			$max_sort = $this->dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$this->assign("topnavi", $topnavi);
		$this->assign("info", $info);

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$name = trim($_REQUEST['name']);
		''==$name && self::_error('公司名称必须填写！');
		$address = trim($_REQUEST['address']);
		$mobile = trim($_REQUEST['mobile']);
		$telephone = trim($_REQUEST['telephone']);
		$introduction = trim($_REQUEST['introduction']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('此公司名称已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->address = $address;
			$this->dao->mobile = $mobile;
			$this->dao->telephone = $telephone;
			$this->dao->introduction = $introduction;
			$this->dao->sort = $sort;
			if($this->dao->where("id=".$id)->save()) {
				self::_success('修改成功！', __URL__);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('name'=>$name))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('此公司名称已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->address = $address;
			$this->dao->mobile = $mobile;
			$this->dao->telephone = $telephone;
			$this->dao->introduction = $introduction;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->sort = $sort;
			$this->dao->status = 1;
			if($this->dao->add()) {
				self::_success('添加成功！', __URL__);
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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