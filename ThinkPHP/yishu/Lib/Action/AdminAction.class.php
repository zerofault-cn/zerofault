<?php
/**
*
* 负责后台管理的全部操作处理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/7/27
*/
class AdminAction extends Action{
	/**
	*
	* 对象初始化时自动执行
	*/
	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		dump($_SESSION);

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
	* 生成弹出“操作成功”提示的js代码
	*
	* @param string $msg 弹出框内显示的提示语句 
	* @param string $url 跳转地址，默认为空，表示重新载入当前页
	* @param integer $timeout 弹出框显示的时间，超过时间后自动关闭或页面跳转
	*
	* @return string HTML格式的JS代码
	*/
	protected function _success($msg,$url='',$timeout=2000){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
		$html .= 'parent.myLocation("'.$url.'",'.$timeout.');';
		$html .= '</script>';
		return $html;
	}
	/**
	*
	* 生成弹出“操作失败”提示的js代码
	*
	* @param string $msg 弹出框内显示的提示语句 
	* @param integer $timeout 弹出框显示的时间，如果没有设置，则不会自动关闭，需要用户点OK按钮关闭
	*
	* @return string HTML格式的JS代码
	*/
	protected function _error($msg,$timeout=0){
		$html  = '<script language="JavaScript" type="text/javascript">';
		$html .= 'parent.myAlert("'.$msg.'");';
		$timeout && $html .= 'parent.myOK('.$timeout.');';
		$html .= '</script>';
		return $html;
	}
	/**
	*
	* 验证是否已登录，如果未登录，显示登录框
	*/
	public function login() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('content','login');
			$this->display('Layout:Admin_layout');
		}else{
			redirect(__URL__);
		}
	}
	/**
	*
	* 验证并保存登录信息
	*/
	public function checkLogin(){
		$User	=	D('User');
		if(empty($_POST['account'])) {
			die(self::_error('帐号错误！'));
		}
		elseif (empty($_POST['password'])){
			die(self::_error('密码必须！'));
		}
		//生成认证条件
		$map			= array();
		$map["account"]	= $_POST['account'];
		$map["status"]	= array('gt',0);
		$authInfo = $User->where($map)->find();

		//使用用户名、密码和状态的方式进行认证
		if(false === $authInfo) {
			die(self::_error('用户名不存在或已禁用！'));
		}
		else {
			if($authInfo['password'] != md5($_POST['password'])) {
				die(self::_error('密码错误！'));
			}
			$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
			$_SESSION['loginUserName']	=	$authInfo['nickname'];
			if($authInfo['account']=='admin') {
				// 管理员不受权限控制影响
				$_SESSION['administrator']		=	true;
			}
			else{
				$_SESSION['administrator']		=	false;
			}
			// 缓存访问权限
			RBAC::saveAccessList();
			die(self::_success('登陆成功！',__URL__.'/'.Session::get('lastAction'),500));
		}
	}
	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		die(self::_success('注销成功！', __URL__, 500));
	}

	/**
	*
	* 管理后台默认首页
	*/
	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 显示分类列表
	*/
	public function cate_list(){
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
		$this->assign('content','cate_list');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 显示网站列表
	*/
	public function site_list(){
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
		$this->assign('cate_list', $dao_cate->where(array('status'=>array('gt',-1)))->order('status desc,sort')->select());
		$this->assign('new_sort', $max_sort+10);
		$this->assign('content','site_list');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 显示评论列表
	*/
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
		$this->assign('content','comment_list');
		$this->display('Layout:Admin_layout');
	}
	
	/**
	*
	* 用户列表
	*/
	public function user_list(){
		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/Admin/user_list'
			);
		$topnavi[]=array(
			'text'=> '用户列表',
			);
		$dao = D('User');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','user_list');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 用户组列表
	*/
	public function group_list(){
		$topnavi[]=array(
			'text'=> '用户组管理',
			'url' => __APP__.'/Admin/user_list'
			);
		$topnavi[]=array(
			'text'=> '用户组列表',
			);
		$dao = D('Group');
		$rs = $dao->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('list',$rs);
		$this->assign('content','group_list');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 用PHP的fsockopen模拟HTTP post，用来向ip138网站提交IP查询并获取结果
	*/
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
	/**
	*
	* 通用的添加网站和添加分类的方法
	*/
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
				$dao->status = 1;
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
			$dao->status = 1;
			if($dao->add()){
				die('1');
			}
			else{
				die('sql:'.$dao->getLastSql());
			}
		}
	}
	/**
	*
	* 更新某个表某条记录某个字段的值，通用
	*/
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
	/**
	*
	* 从某个表删除某条记录
	*/
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