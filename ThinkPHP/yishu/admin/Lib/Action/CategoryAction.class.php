<?php

class CategoryAction extends PublicAction{
	/**
	*
	* 显示分类列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '分类管理',
			'url' => __APP__.'/Admin/cate_list'
			);

		$dao = D('Category');
		$where['status'] = array('gt', -1);
		$where['pid']  = 0;
		$order = 'status desc, sort';

		$status = $_REQUEST['status'];
		if(!empty($status)){
			$where['status'] = $status;
			$order = 'id desc';

			$topnavi[]=array(
				'text'=> '已删除的分类',
			);
		}
		else{
			$topnavi[]=array(
				'text'=> '分类列表',
			);
		}

		$rs = $dao->where($where)->order($order)->select();
		foreach($rs as $key=>$val){
			$site = D('Website');
			$rs[$key]['site_count'] = $site->where(array('cate_id'=>$val['id']))->getField('count(*) as count');
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('new_cate_sort', $dao->where($where)->getField('max(sort) as max_sort')+10);
		$this->assign('content','Category:index');
		$this->display('Layout:Admin_layout');
	}
}
?>