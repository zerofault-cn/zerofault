<?php
class AdminMiniAction extends Action{
	var $lastAction;
	public function _initialize() {
		//每个操作都会执行此方法
		if(!Cookie::get('isAdmin') && ACTION_NAME != 'login_form' && ACTION_NAME != 'login'){
			$this->lastAction = ACTION_NAME;
			redirect(__APP__.'/AdminMini/login_form',2,'&#36716;&#21521;&#30331;&#24405;&#31383;&#21475;');//转向登录窗口
		}
	}
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'dvmadmin' == $password)
		{
			Cookie::set('isAdmin',1,time()+43200);
			redirect(__APP__.'/AdminMini/'.$this->lastAction,1,'&#30331;&#24405;&#25104;&#21151;');//登录成功
		}
	}
	public function index(){
		$dao = D('Category');
		$where['flag'] = array('gt', -1);
		$order = 'flag desc, sort';
		$rs = $dao->where($where)->order($order)->select();
		!$rs && $rs = array();
		$this->assign('new_cate_sort',$rs[sizeof($rs)-1]['sort']+10);

		$dao = D('Website');
		foreach($rs as $key=>$val){
			$list[$val['id']] = $val;
			$list[$val['id']]['site_list'] = array();
			$list[$val['id']]['new_site_sort'] = 10;
			$where['cate_id'] = $val['id'];
			$where['flag'] = array('gt', -1);
			$order = 'flag desc, sort';
			$rs2 = $dao->where($where)->order($order)->select();
			!$rs2 && $rs2 = array();
			foreach($rs2 as $key2=>$val2){
				$list[$val['id']]['site_list'][$val2['id']] = $val2;
				$list[$val['id']]['new_site_sort'] = $val2['sort']+10;
			}
		}
		//dump($list);
		$this->assign('list',$list);
		$this->display();
	}
	public function add(){
		$table=$_REQUEST['table'];
		$cate_id=intval($_REQUEST['cate_id']);
		$site_id=intval($_REQUEST['site_id']);
		$name=$_REQUEST['name'];
		$url=$_REQUEST['url'];
		$sort=intval($_REQUEST['sort']);
		$descr=$_REQUEST['descr'];
		if('website'==$table)
		{
			$dao = D('Website');
			if($site_id>0)
			{
				$rs = $dao->where(array('name'=>$name,'id'=>array('neq',$site_id)))->find();
				if($rs && sizeof($rs)>0){
					die('-1');
				}
				$dao->find($site_id);
				$dao->name = $name;
				$dao->url = $url;
				$dao->descr = $descr;
				if($dao->save()){
					die('1');
				}
				else{
					die('sql:'.$dao->getLastSql());
				}
			}
			else
			{
				$rs = $dao->where(array('name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					die('-1');
				}
				$dao->cate_id = $cate_id;
				$dao->name = $name;
				$dao->url = $url;
				$dao->descr = $descr;
				$dao->addtime = date("Y-m-d H:i:s");
				$dao->sort = $sort;
				$dao->flag = 1;
				if($dao->add()){
					die('1');
				}
				else{
					die('sql:'.$dao->getLastSql());
				}
			}
		}
		else
		{
			$dao = D('Category');
			$where['name'] = $name;
			$rs = $dao->where($where)->find();
			if($rs && sizeof($rs)>0){
				die('-1');
			}
			$dao->name = $name;
			$dao->addtime = $dao->usetime = date("Y-m-d H:i:s");
			$dao->sort = $sort;
			$dao->flag = 1;
			if($dao->add()){
				die('1');
			}
			else{
				die('sql:'.$dao->getLastSql());
			}
		}
	}
	public function update(){
		$table=$_REQUEST['table'];
		$id=$_REQUEST['id'];
		$field=$_REQUEST['field'];
		$value=$_REQUEST['value'];
		$dao = D(ucfirst($table));
		$rs = $dao->where('id='.$id)->setField($field,$value);
		if($rs)
		{
			die('1');
		}
		else
		{
			die('sql:'.$dao->getLastSql());
		}
	}
	public function remote_add(){
		$this->assign('name',$_REQUEST['title']);
		$this->assign('url','http://'.$_REQUEST['url'].'/');
		$this->assign('descr',$_REQUEST['content']);
		$dao = D('Category');
		$rs = $dao->where(array('flag'=>array('neq',-1)))->order('usetime')->select();
		$this->assign('cate_list',$rs);
		$this->display();
	}
	public function remote_submit(){
		$name = $_REQUEST['name'];
		$cate_id = intval($_REQUEST['cate_id']);
		$category = $_REQUEST['category'];
		$url = $_REQUEST['url'];
		$descr=$_REQUEST['descr'];

		$dao = D('Category');
		if($cate_id==0){
			$rs = $dao->where(array('name'=>$category))->find();
			if($rs && sizeof($rs)>0){
				$cate_id = $rs['id'];
			}
			else{
				$rs = $dao->field('max(sort) as sort')->find();
				$max_sort = $rs['sort'];
				$dao->name = $category;
				$dao->addtime = $dao->usetime = date("Y-m-d H:i:s");
				$dao->sort = $max_sort+10;
				$dao->flag = 1;
				$cate_id = $dao->add();
			}
		}
		else{
			$dao->where('id='.$cate_id)->setField('usetime',date("Y-m-d H:i:s"));
		}

		$dao = D('Website');
		$rs = $dao->where('cate_id='.$cate_id)->field('max(sort) as sort')->find();
		$max_sort = $rs['sort'];
		$dao->cate_id = $cate_id;
		$dao->name = $name;
		$dao->url = $url;
		$dao->descr = $descr;
		$dao->addtime = date("Y-m-d H:i:s");
		$dao->sort = $max_sort+10;
		$dao->flag = 1;
		if($dao->add()){
			header("Content-Type:text/html; charset=utf-8");
			die('<script>alert("添加成功");window.close();</script>');
		}
		else{
			die('sql:'.$dao->getLastSql());
		}
	}
}
?>