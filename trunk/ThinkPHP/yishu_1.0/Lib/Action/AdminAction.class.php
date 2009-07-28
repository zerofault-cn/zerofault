<?php
class AdminAction extends Action{

	public function _initialize() { //每个操作都会执行此方法
		header("Content-Type:text/html; charset=utf-8");
		if(!Session::is_set('isAdmin') && ACTION_NAME != 'login_form' && ACTION_NAME != 'login'){
			Session::set('lastAction', ACTION_NAME);
			redirect(__URL__.'/login_form',1,'转向登录窗口');
		}
	}
	public function login_form(){
		$this->display();
	}
	public function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if('admin' == $username && 'dvmadmin' == $password){
			Session::setExpire(43200, true);
			Session::set('isAdmin', 1);
			Session::set('adminName', $username);
			redirect(__URL__.'/'.Session::get('lastAction'),1,'登录成功');
		}
		elseif('admin' == $username){
			redirect(__URL__.'/login_form',2,'密码错误，请重试');
		}
		else{
			redirect(__URL__.'/login_form',2,'错误的管理员帐号，请重试');
		}
	}
	public function logout(){
		Session::clear();
		redirect(__URL__.'/',1,'退出成功！');
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
		$max_sort = $dao->where($where)->getField("max(sort)");
		$count = $dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		//$p->setConfig('show_num',7);
		//$p->setConfig('side_num',2);
		$p->setConfig('first','<img src="'.APP_PUBLIC_URL.'/Images/admin/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_URL.'/Images/admin/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_URL.'/Images/admin/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_URL.'/Images/admin/last.gif" align="absbottom" alt="Last"/>');
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['cate_info'] = $dao_cate->find($val['cate_id']);
		}

		
		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('cate_list', $dao_cate->where(array('flag'=>array('gt',-1)))->order('flag desc,sort')->select());
		$this->assign('new_sort', $max_sort+10);
		$this->assign('content','site_list');
		$this->display('Layout:Admin_layout');
	}
	public function comment_list(){
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
		$where['flag'] = 1;
		$flag = $_REQUEST['flag'];
		if(!empty($flag)){
			$where['flag'] = $flag;
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
		$this->assign('content','comment_list');
		$this->display('Layout:Admin_layout');
	}
	public function httpPost(){
		$url = $_REQUEST['url'];
		$params = $_REQUEST['params'];
		$referrer="";
		// parsing the given URL
		$URL_Info=parse_url($url);
		// Building referrer
		if($referrer==""){ // if not given use this script as referrer
			$referrer=$_SERVER["SCRIPT_URI"];
		}
		// making string from $data
		$data_string=$params;
		// Find out which port is needed - if not given use standard (=80)
		if(!isset($URL_Info["port"])){
			$URL_Info["port"]=80;
		}
		// building POST-request:
		$request.="POST ".$URL_Info["path"]." HTTP/1.1\n";
		$request.="Host: ".$URL_Info["host"]."\n";
		$request.="Referer: $referrer\n";
		$request.="Content-type: application/x-www-form-urlencoded\n";
		$request.="Content-length: ".strlen($data_string)."\n";
		$request.="Connection: close\n";
		$request.="\n";
		$request.=$data_string."\n";
		$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
		fputs($fp, $request);
		while(!feof($fp)) {
			$result .= fgets($fp, 1024);
		}
		fclose($fp);
		echo iconv('','UTF-8',$result);
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
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("操作成功！");parent.myLocation("",1200);</script>');
		}
		else
		{
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("发生错误！<br />sql:'.$dao->getLastSql().'");</script>');
		}
	}
	public function delete(){
		$table=$_REQUEST['t'];
		$id=$_REQUEST['id'];
		$dao = D($table);
		if($dao->find($id) && $dao->delete())
		{
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("删除成功！");parent.myLocation("","");</script>');
		}
		else
		{
			die('<script language="JavaScript" type="text/javascript">parent.myAlert("发生错误！<br />sql:'.$dao->getLastSql().'");</script>');
		}
	}
}
?>