<?php
class AdminAction extends Action{
	var $lastAction;
	private function _htmlentities($str){
		//return mb_convert_encoding($str,'HTML-ENTITIES', 'UTF-8');
		//return iconv('UTF-8','HTML-ENTITIES', $str);
		return $str;
	}

	public function _initialize() { //每个操作都会执行此方法
		if(!Session::is_set('isAdmin') && ACTION_NAME != 'login_form' && ACTION_NAME != 'login'){
			$this->lastAction = ACTION_NAME;
			header("Content-Type:text/html; charset=utf-8");
			redirect(__APP__.'/Admin/login_form',1,$this->_htmlentities('转向登录窗口'));
		}
	}
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		header("Content-Type:text/html; charset=utf-8");
		if('admin' == $username && 'dvmadmin' == $password){
			Session::setExpire(43200, true);
			Session::set('isAdmin', 1);
			Session::set('adminName', $username);
			redirect(__APP__.'/Admin/'.$this->lastAction,1,$this->_htmlentities('登录成功'));
		}
		elseif('admin' == $username){
			redirect(__APP__.'/Admin/login_form',2,$this->_htmlentities('密码错误，请重试'));
		}
		else{
			redirect(__APP__.'/Admin/login_form',2,$this->_htmlentities('错误的管理员帐号，请重试'));
		}
	}
	public function logout(){
		Session::clear();
		header("Content-Type:text/html; charset=utf-8");
		redirect(__APP__.'/Admin/',1,$this->_htmlentities('退出成功！'));
	}

	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
	public function cate_list(){
		$topnavi[]=array(
			'text'=> '分类管理',
			'url' => __APP__.'/Admin/cate_list'
			);

		$dao = D('Category');
		$where['flag'] = array('gt', -1);
		$where['pid']  = 0;
		$order = 'flag desc, sort';

		$flag = $_REQUEST['flag'];
		if(!empty($flag)){
			$where['flag'] = $flag;
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
		$this->assign('content','cate_list');
		$this->display('Layout:Admin_layout');
	}
	
	public function site_list(){
		$topnavi[]=array(
			'text'=> '站点管理',
			'url' => __APP__.'/Admin/site_list'
			);

		$dao_cate = D('Category');
		$cate_id = $_REQUEST['id'];
		if(!empty($cate_id)){
			$where['cate_id'] = $cate_id;
			$order = 'flag desc, sort';
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
		$where['flag'] = array('gt', -1);
		$flag = $_REQUEST['flag'];
		if(!empty($flag)){
			$where['flag'] = $flag;
			$order = 'id desc';
		}
		
		$dao = D('Website');
		$count = $dao->where($where)->getField('count(*) as count');
		import("ORG.Util.Page");
		$listRows = 10;
		$p = new Page($count, $listRows);
		$rs = $dao->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['cate_info'] = $dao_cate->find($val['cate_id']);
		}

		
		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->show());
		$this->assign('list', $rs);
		$this->assign('cate_list', $dao_cate->where(array('flag'=>array('gt',-1)))->order('flag desc,sort')->select());
		$this->assign('content','site_list');
		$this->display('Layout:Admin_layout');
	}
	public function add(){
		$table=$_REQUEST['table'];
		$cate_id=intval($_REQUEST['cate_id']);
		$site_id=intval($_REQUEST['site_id']);
		$name=$_REQUEST['name'];
		$url=$_REQUEST['url'];
		$sort=intval($_REQUEST['sort']);
		$descr=$_REQUEST['descr'];
		if('Website'==$table)
		{
			$dao = D('Website');
			if($site_id>0)
			{
				$rs = $dao->where(array('name'=>$name,'id'=>array('neq',$site_id)))->find();
				if($rs && sizeof($rs)>0){
					die('-1');
				}
				$dao->find($site_id);
				$dao->cate_id = $cate_id;
				$dao->name = $name;
				$dao->url = $url;
				$dao->sort = $sort;
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
		$table=$_REQUEST['t'];
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=$_REQUEST['v'];
		$dao = D($table);
		$rs = $dao->where('id='.$id)->setField($field,$value);
		if($rs)
		{
			header("Content-Type:text/html; charset=utf-8");
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("操作成功！");parent.myLocation("");</script>');
		}
		else
		{
			header("Content-Type:text/html; charset=utf-8");
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("发生错误！<br />sql:'.$dao->getLastSql().'");</script>');
		}
	}
	public function delete(){
		$table=$_REQUEST['t'];
		$id=$_REQUEST['id'];
		$dao = D($table);
		if($dao->find($id) && $dao->delete())
		{
			header("Content-Type:text/html; charset=utf-8");
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("删除成功！");parent.myLocation("");</script>');
		}
		else
		{
			header("Content-Type:text/html; charset=utf-8");
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("发生错误！<br />sql:'.$dao->getLastSql().'");</script>');
		}
	}

}
?>