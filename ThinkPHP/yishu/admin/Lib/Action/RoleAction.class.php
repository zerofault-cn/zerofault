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
		$rs = $this->dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','Role:index');
		$this->display('Layout:Admin_layout');
	}

}
?>