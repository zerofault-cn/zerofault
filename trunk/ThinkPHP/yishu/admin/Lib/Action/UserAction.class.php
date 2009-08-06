<?php
/**
*
* 用户管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class UserAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
	}
	/**
	*
	* 用户列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/User'
			);
		$topnavi[]=array(
			'text'=> '用户列表',
			);
		$rs = $this->dao->relation(true)->select();
		//dump($rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','User:index');
		$this->display('Layout:Admin_layout');
	}

}
?>