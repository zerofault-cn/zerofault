<?php
class DistrictAction extends BaseAction{
	protected $dao, $topnavi;
	
	protected function _initialize() {
		parent::_initialize();
		$this->dao = M('District');
		$this->topnavi[] = array(
			'text' => '区域设置'
			);
	}
	public function index(){
		$this->topnavi[]=array(
			'text'=> '商业区域',
			);
		$this->assign("topnavi", $this->topnavi);
		$where = array(
			'pid' => 2
			);
		$order = 'sort';
		$rs = $this->dao->where($where)->order($order)->select();
		$this->assign('list', $rs);

		$this->assign('content', 'index');
		$this->display('Layout:default');
	}
	public function add(){
		$name = trim($_REQUEST['name']);
		$sort = intval($_REQUEST['sort']);

		$where['name'] = $name;
		$count = $this->dao->where($where)->count();
		if(!empty($count) && $count>0) {
			self::_error('已经存在同名分类！');
		}
		$this->dao->pid = 2;
		$this->dao->name = $name;
		$this->dao->sort = $sort;
		if($this->dao->add()){
			self::_success('添加成功！');
		}
		else{
			self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
	public function update(){
		parent::_update();
	}
	public function delete(){
		parent::_delete();
	}
}
?>