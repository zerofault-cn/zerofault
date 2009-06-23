<?php
class AdminAction extends Action{
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'admin' == $password)
		{
			cookie::set('isAdmin',1);
			redirect(__APP__.'/admin',1,'登录成功');
		}
	}
	public function index(){
		if(!cookie::get('isAdmin')){
			redirect(__APP__.'/admin/login_form',3,'转向登录窗口');
		}
		else{
			$dao = D('category');
			$rs = $dao->where(array('flag'=>array('gt',-1)))->order('sort')->select();
			$this->assign('cate_list',$rs);
			$this->assign('new_cate_sort',$rs[sizeof($rs)-1]['sort']+10);

			$dao = D('website');
			$rs = $dao->where(array('flag'=>array('gt',-1)))->order('sort')->select();
			foreach($rs as $val){
				$site_list[$val['cate_id']][]=$val;
				$site_list[$val['cate_id']]['new_site_sort'] = $val['sort']+10;
			}
			//dump($site_list);
			$this->assign('site_list',$site_list);
			$this->display();
		}
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
			$dao = D('website');
			if($site_id>0)
			{
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
			$dao = D('category');
			$where['name'] = $name;
			$rs = $dao->where($where)->find();
			if($rs && sizeof($rs)>0){
				die('-1');
			}
			$dao->name = $name;
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
	public function update(){
		$table=$_REQUEST['table'];
		$id=$_REQUEST['id'];
		$field=$_REQUEST['field'];
		$value=$_REQUEST['value'];
		$dao = D($table);
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
}
?>