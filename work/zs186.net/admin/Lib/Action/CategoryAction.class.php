<?php
class CategoryAction extends BaseAction{
	protected $dao, $topnavi;
	
	protected function _initialize() {
		parent::_initialize();
		$this->dao = M('Category');
		$this->topnavi[] = array(
			'text' => '分类管理'
			);
	}
	Public function _empty() {
		$type = ACTION_NAME; 
		$this->index($type); 
	}

	public function index($type='Hotel'){
		$this->topnavi[]=array(
			'text'=> 'Hotel'==$type?'酒店分类':'内容分类',
			);
		$this->assign("topnavi", $this->topnavi);
		$where = array(
			'type' => $type,
			'pid' => 0
			);
		$order = 'sort';
		$rs = $this->dao->where($where)->order($order)->select();
		foreach($rs as $key=>$val) {
			$rs[$key]['count'] = M($type)->where(array('category_id'=>$val['id']))->count();
			$tmp_rs = $this->dao->where("pid=".$val['id'])->select();
			if (!empty($tmp_rs) && count($tmp_rs)>0) {
				foreach ($tmp_rs as $tmp_key=>$tmp_val) {
					$tmp_rs[$tmp_key]['count'] = M($type)->where(array('category_id'=>$tmp_val['id']))->count();
					$rs[$key]['count'] += $tmp_rs[$tmp_key]['count'];
				}
				$rs[$key]['sub'] = $tmp_rs;
			}
		}


		$this->assign('list', $rs);
		$this->assign('type', $type);
		$this->assign('new_sort', $this->dao->where($where)->getField('max(sort) as max_sort')+1);

		$this->assign('content', 'index');
		$this->display('Layout:default');
	}
	public function add(){
		$pid = intval($_REQUEST['pid']);
		$type = trim($_REQUEST['type']);

		$name = trim($_REQUEST['name']);
		empty($name) && die('<i>名称必须填写！</i>');
		$sort = intval($_REQUEST['sort']);

		$where['name'] = $name;
		$count = $this->dao->where($where)->count();
		if(!empty($count) && $count>0) {
			die('<i>已经存在同名分类！</i>');
		}
		$this->dao->pid = $pid;
		$this->dao->type = $type;
		$this->dao->name = $name;
		$this->dao->sort = $sort;
		$this->dao->status = 1;
		if($this->dao->add()){
			die('1');
		}
		else{
			die('sql:'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
	public function update(){
		parent::_update();
	}
	private function delete(){
		parent::_delete();
	}
}
?>