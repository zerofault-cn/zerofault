<?php
class AdminAction extends Action{
	var $lastAction;
	private function _htmlentities($str){
		return mb_convert_encoding($str,'HTML-ENTITIES', 'UTF-8');
	}

	public function _initialize() {
		//每个操作都会执行此方法
		if(!Cookie::get('isAdmin') && ACTION_NAME != 'login_form' && ACTION_NAME != 'login'){
			$this->lastAction = ACTION_NAME;
			redirect(__APP__.'/Admin/login_form',1,$this->_htmlentities('转向登录窗口'));
		}
	}
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'dvmadmin' == $password){
			Cookie::set('isAdmin',1,time()+43200);
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
		Cookie::delete('isAdmin');
		redirect(__APP__.'/Admin/',1,$this->_htmlentities('退出成功！'));
	}

	public function index(){
		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
	public function cate_list(){
		$dao = D('Category');
		$where['flag'] = array('gt', -1);
		$where['pid']  = 0;
		$order = 'flag desc, sort';
		$rs = $dao->where($where)->order($order)->select();
		$this->assign('list',$rs);

		$rs = $dao->where($where)->getField('max(sort) as max_sort');
		$this->assign('new_cate_sort',intval($rs['max_sort'].'0')+10);

		$this->assign('content','cate_list');
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

}
?>