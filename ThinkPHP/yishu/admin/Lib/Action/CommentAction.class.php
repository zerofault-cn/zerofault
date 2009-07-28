<?php

class CommentAction extends Action{
	/**
	*
	* 对象初始化时自动执行
	*/
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
	//	dump($_SESSION);

		import('ORG.RBAC.RBAC');
		// 检查认证
		if(RBAC::checkAccess()) {
			//检查认证识别号
			if(!$_SESSION[C('USER_AUTH_KEY')]) {
				//记下刚才的Action
				Session::set('lastAction', ACTION_NAME);
				//跳转到认证网关
				redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
			}
			// 检查权限
			if(!RBAC::AccessDecision()) {
				$this->assign('message','没有权限！');
				$this->assign('content','error');
				$this->display('Layout:Admin_layout');
				exit;
			}
		}
	}
	
	/**
	*
	* 显示评论列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '评论管理',
			'url' => __APP__.'/Admin/comment_list'
			);

		$dao_site = D('Website');
		$sie_id = $_REQUEST['id'];
		if(!empty($site_id)){
			$where['site_id'] = $site_id;
			$site_name = $dao_site->where(array('id'=>$site_id))->getField('name');
			$topnavi[]=array(
				'text'=> '给网站【'.$site_name.'】的评论',
				);
		}
		else{
			$topnavi[]=array(
				'text'=> '所有评论',
				);
		}
		$where['status'] = 1;
		$status = $_REQUEST['status'];
		if(!empty($status)){
			$where['status'] = $status;
		}
		$order = 'id desc';
		$dao = D('Comment');
		$count = $dao->where($where)->getField('count(*)');
		import("ORG.Util.Page");
		$listRows = 10;
		$p = new Page($count, $listRows);
		$rs = $dao->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['site_info'] = $dao_site->find($val['site_id']);
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->show());
		$this->assign('list', $rs);
		$this->assign('content','Comment:index');
		$this->display('Layout:Admin_layout');
	}
}
?>