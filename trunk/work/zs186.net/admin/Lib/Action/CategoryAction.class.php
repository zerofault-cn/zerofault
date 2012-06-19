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
			'text'=> 'Hotel'==$type?'酒店分类':'文章分类',
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
		$type = trim($_REQUEST['type']);
		$name = trim($_REQUEST['name']);
		$sort = intval($_REQUEST['sort']);

		$where['name'] = $name;
		$count = $this->dao->where($where)->count();
		if(!empty($count) && $count>0) {
			self::_error('已经存在同名分类！');
		}
		$this->dao->type = $type;
		$this->dao->name = $name;
		$this->dao->create_time = date("Y-m-d H:i:s");
		$this->dao->sort = $sort;
		$this->dao->status = 1;
		if($this->dao->add()){
			self::_success('添加成功！');
		}
		else{
			self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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