<?php

class CommentAction extends BaseAction{

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