<?php
/**
*
* 角色管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class RoleAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = D('Role');
		parent::_initialize();
	}
	/**
	*
	* 角色列表
	*/
	public function index(){
		$where = array();
		//有编辑请求
		if(!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$role_info = $this->dao->relation(true)->where(array('id'=>$_REQUEST['id']))->find();
			$tmp = $role_info;
			unset($tmp['Node']);
			foreach($role_info['Node'] as $key2=>$val2) {
				$tmp['Node'][$val2['id']] = $role_info['Node'][$key2];
				$sql = "select node.id ".
					"from ".C('DB_PREFIX')."node as node,".C('DB_PREFIX')."role_node as role_node ".
					"where role_node.role_id=".$role_info['id']." and role_node.node_id=node.id and node.pid=".$val2['id'];
				$rs2 = $this->dao->query($sql);
				$tmp['Node'][$val2['id']]['subNode'] = $rs2;
			}
			$role_info = $tmp;
		}
		else{
			$role_info = array(
				'id' => '',
				'name' => '',
				'Node' => array()
				);
		}
//		dump($role_info);
		$rs = $this->dao->relation(true)->where($where)->select();
		foreach($rs as $key=>$val) {
			foreach($val['Node'] as $key2=>$val2) {
				$sql = "select node.* ".
					"from ".C('DB_PREFIX')."node as node,".C('DB_PREFIX')."role_node as role_node ".
					"where role_node.role_id=".$val['id']." and role_node.node_id=node.id and node.pid=".$val2['id'];
				$rs2 = $this->dao->query($sql);
				$subNode_arr = array();
				if(empty($rs2)) {
					$subNode_arr = array('无');
					$rs2 = array();
				}
				foreach($rs2 as $node) {
					$subNode_arr[] = $node['title']?$node['title']:$node['name'];
				}
				$rs[$key]['Node'][$key2]['subNode'] = implode(', ',$subNode_arr);
			}
		}
	//	dump($rs);
		$dNode = D('Node');

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('node_list',$dNode->relation(true)->where(array('pid'=>0))->select());
		if(!empty($_REQUEST['id'])) {
			$this->assign('role_info',$role_info);
		}
		$this->assign('content','Role:index');
		$this->display('Layout:ERP_layout');
	}

	public function add() {
		$name = $_REQUEST['name'];
		$node_ids = $_REQUEST['node_ids'];
		$node_ids || $node_arr = array() && $node_id_arr = array();
		$node_ids && $node_id_arr = explode(',', $node_ids);
		foreach($node_id_arr as $node_id) {
			$node_arr[] = array('id'=>$node_id);
		}
		$where['name'] = $name;
		$rs = $this->dao->where($where)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$this->dao->name = $name;
		$this->dao->status = 1;
		$this->dao->descr = $name;
		$this->dao->Node = $node_arr;
		if($this->dao->relation(true)->add()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}
	public function edit(){
		$id = $_REQUEST['id'];
		$name = $_REQUEST['name'];
		$node_ids = $_REQUEST['node_ids'];
		$node_ids || $node_arr = array() && $node_id_arr = array();
		$node_ids && $node_id_arr = explode(',', $node_ids);
		foreach($node_id_arr as $node_id) {
			$node_arr[] = array('id'=>$node_id);
		}
		$this->dao->find($id);
		$this->dao->name = $name;
		$this->dao->Node = $node_arr;
		if(false !== $this->dao->relation(true)->save()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}

	/**
	*
	* 定制的implode方法，针对关联数组，如果值不为空，则取其值，否则取其键
	*/
	protected function _implode($sep, $arr) {
		foreach($arr as $key=>$val) {
			$tmp[] = empty($val) ? $key : $val;
		}
		return implode($sep,$tmp);
	}
	/**
	*
	* 关联更新
	*/
	public function update(){
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		$id=$_REQUEST['id'];
		if($this->dao->relation(true)->delete($id))
		{
			die(self::_success('删除成功！','',1200));
		}
		else
		{
			die(self::_error('发生错误！<br />sql:'.$this->dao->getLastSql()));
		}
	}
}
?>