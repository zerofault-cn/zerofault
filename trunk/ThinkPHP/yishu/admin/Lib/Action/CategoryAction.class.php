<?php

class CategoryAction extends BaseAction{
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

	public function add(){
		$name=$_REQUEST['name'];
		$sort=intval($_REQUEST['sort']);

		$dCategory = D('Category');
		$where['name'] = $name;
		$rs = $dCategory->where($where)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$dCategory->name = $name;
		$dCategory->addtime = $dCategory->usetime = date("Y-m-d H:i:s");
		$dCategory->sort = $sort;
		$dCategory->status = 1;
		if($dCategory->add()){
			die('1');
		}
		else{
			die('sql:'.$dCategory->getLastSql());
		}
	}
	public function update(){
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=$_REQUEST['v'];
		$dao = D('Category');
		$rs = $dao->where('id='.$id)->setField($field,$value);
		if($rs)
		{
			die(self::_success('更新成功！','',1200));
		}
		else
		{
			die(self::_error('发生错误！<br />sql:'.$dao->getLastSql()));
		}
	}
	public function delete(){
		
		$id=$_REQUEST['id'];
		$dao = D('Category');
		if($dao->find($id) && $dao->delete())
		{
			die(self::_success('删除成功！','',1200));
		}
		else
		{
			die(self::_error('发生错误！<br />sql:'.$dao->getLastSql()));
		}
	}

}
?>