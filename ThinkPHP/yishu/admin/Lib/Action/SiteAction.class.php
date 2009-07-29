<?php
class SiteAction extends PublicAction{

	/**
	*
	* 显示网站列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '站点管理',
			'url' => __APP__.'/Admin/site_list'
			);

		$dao_cate = D('Category');
		$cate_id = $_REQUEST['id'];
		if(!empty($cate_id)){
			$where['cate_id'] = $cate_id;
			$order = 'status desc, sort';
			$cate_name = $dao_cate->where(array('id'=>$cate_id))->getField('name');
			$topnavi[]=array(
				'text'=> '站点列表 (当前分类：'.$cate_name.')',
				);
		}
		else{
			$order = 'id desc';
			$topnavi[]=array(
				'text'=> '站点列表',
				);
		}
		$where['status'] = array('gt', -1);
		$status = $_REQUEST['status'];
		if(!empty($status)){
			$where['status'] = $status;
			$order = 'id desc';
		}
		
		$dao = D('Website');
		$max_sort = $dao->where($where)->getField("max(sort)");
		$count = $dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		//$p->setConfig('show_num',7);
		//$p->setConfig('side_num',2);
		$p->setConfig('first','<img src="'.APP_PUBLIC_URL.'/Image/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_URL.'/Image/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_URL.'/Image/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_URL.'/Image/last.gif" align="absbottom" alt="Last"/>');
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['cate_info'] = $dao_cate->find($val['cate_id']);
		}

		
		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('cate_list', $dao_cate->where(array('status'=>array('gt',-1)))->order('status desc,sort')->select());
		$this->assign('new_sort', $max_sort+10);
		$this->assign('content','Site:index');
		$this->display('Layout:Admin_layout');
	}
}
?>