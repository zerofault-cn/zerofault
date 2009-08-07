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
		$topnavi[]=array(
			'text'=> '角色管理',
			'url' => __APP__.'/Role'
			);
		$topnavi[]=array(
			'text'=> '角色列表',
			);
		$rs = $this->dao->relation(true)->select();
		$dNode = D('Node');
		foreach($rs as $key=>$val) {
			foreach($val['Node'] as $key2=>$val2) {
				$subnode = $dNode->where(array('pid'=>$val2['id']))->getFields('name,title');
				$subnode || $rs[$key]['Node'][$key2]['subNode'] = '*';
				$subnode && $rs[$key]['Node'][$key2]['subNode'] = self::_implode(', ', $subnode);
			}
		}
		//dump($rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','Role:index');
		$this->display('Layout:Admin_layout');
	}

	public function removeNode() {
		$role_id = $_REQUEST['role_id'];
		$node_id = $_REQUEST['node_id'];

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