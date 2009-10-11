<?php
/**
*
* 分类管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class LineAction extends BaseAction{
	protected $dao;
	

	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		$this->dao = M('Line');

		parent::_initialize();
	}

	/**
	*
	* 分类列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '线路管理',
			'url' => __APP__.'/Line'
			);
			$topnavi[]=array(
				'text'=> '线路列表',
			);

		$order = 'update_time';
		$where = array();
		$where['status'] = array('gt', 0);
		if(''!=$_REQUEST['status']) {
			$where['status'] = $_REQUEST['status'];
			$order = '';
		}
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$dSite = M('Site');
		$site_arr = $dSite->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}


		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list',$rs);
		$this->assign('site', $site);
		$this->assign('content','Line:index');
		$this->display('Layout:Admin_layout');
	}
	function edit() {
		$topnavi[]=array(
			'text'=> '线路管理',
			'url' => __APP__.'/Line'
			);
		$topnavi[]=array(
			'text'=> '编辑资料',
			);
		$id = $_REQUEST['id'];
		$local_info = $this->dao->find($id);

		$dSite = M('Site');
		$site_arr = $dSite->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}
		$dRoute = M('Route');
		$local_list1 = $dRoute->where(array('lid'=>$id,'direction'=>1))->order('i')->select();
		$local_list2 = $dRoute->where(array('lid'=>$id,'direction'=>-1))->order('i')->select();

		$remote_info = S($local_info['name']);
		if(false === $remote_info){
			foreach(explode('/',$local_info['name']) as $name);
			require_cache(LIB_PATH.'/simple_html_dom.php');
			global $table,$remote_info;
			$c = curl_init();
			curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
			curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$name);
			$data = curl_exec($c);
			//$data = iconv('gb2312','utf-8',$data);
			$data = mb_convert_encoding($data,'UTF-8','GBK');
			$data=str_get_html($data);
			$table=$data->find('table[width="98%"] table',0);
			$descr=$table->children(1)->plaintext;
			
			if(strlen(trim($descr))<2) {
				$remote_info = array();
			}
			else{
				if(strlen(trim($descr))>2 &&strlen(trim($descr))<20) {
					$offset=2;
				}
				$descr=$table->children(1+$offset)->plaintext;
				self::parseLineInfo($descr,2+$offset);
				if($offset==2) {
					$descr=$table->children(4+$offset)->plaintext;
					self::parseLineInfo($descr,5+$offset);
				}
			}
			$data->clear();
			unset($data);
			S($local_info['name'], $remote_info);
		}
		$this->assign("topnavi",$topnavi);
		$this->assign('site', $site);
		$this->assign('local_info', $local_info);
		$this->assign('local_list1', $local_list1);
		$this->assign('local_list2', $local_list2);
		$this->assign('remote_info', $remote_info);
		if(sizeof($local_list1) != sizeof($remote_info['list1'])) {
			$this->assign('E1', 1);
		}
		else{
			foreach($local_list1 as $i=>$val) {
				if($site[$val['sid']] != $remote_info['list1'][$i]) {
					$this->assign('E1', 1);
				}
			}
		}
		if(sizeof($local_list2) != sizeof($remote_info['list2'])) {
			$this->assign('E2', 1);
		}
		else{
			foreach($local_list2 as $i=>$val) {
				if($site[$val['sid']] != $remote_info['list2'][$i]) {
					$this->assign('E2', 1);
				}
			}
		}
		$this->assign('test','abcdef');
		$this->assign('content','Line:edit');
		$this->display('Layout:Admin_layout');
	}
	function parseLineInfo($descr,$tmp_offset)
	{
		require_cache(LIB_PATH.'/simple_html_dom.php');
		global $table,$remote_info;
		$config = C('_config_hz_');
		$line_arr=explode("\n",$descr);

		$remote_info['name'] = trim($line_arr[1]);
		$numbers= explode("/",$remote_info['name']);
		$number = str_ireplace("K",'',$numbers[0]);
		$number = str_ireplace("(夜间线)",'',$number);
		$number = str_ireplace("(区间)",'',$number);
		$number = str_ireplace("B支",'',$number);
		$number = str_ireplace("B",'',$number);
		$number = str_ireplace("Y",'',$number);
		$number = str_ireplace("J",'',$number);
		$number = intval($number);

		$term_arr=explode("--",$line_arr[6]);
		$remote_info['start_name'] = trim($term_arr[0]);
		$remote_info['end_name'] = trim($term_arr[1]);

		$time1_arr=explode("-",$line_arr[14]);
		$time2_arr=explode("-",$line_arr[15]);
		$remote_info['start_first'] = trim($time1_arr[0]);
		$remote_info['start_last'] = trim($time1_arr[1]);
		$remote_info['end_first'] = trim($time2_arr[0]);
		$remote_info['end_last'] = trim($time2_arr[1]);
		
		$remote_info['fare_norm'] = trim($line_arr[18]);
		$remote_info['fare_cond'] = trim($line_arr[22]);

		$remote_info['ic_card'] = trim($line_arr[26]);
		$remote_info['service_hour'] = trim($line_arr[30]);
		$route_arr=$table->children($tmp_offset)->find('table[bgcolor="3E89C0"]');
		$tmp_arr = array();
		$tmp_arr['_0'] = array();
		$tmp_arr['_1'] = array();
		foreach($route_arr as $r=>$route) {
			if($r==1 && in_array($number,$config['circleLines'])) {
				continue;
			}
			$tr_arr=$route->children();
			foreach($tr_arr as $row=>$tr) {
				if($row==0 || $row==1) {
					continue;
				}
				$tmp_arr['_'.$r][] = trim($tr->children(1)->plaintext);
				
			}
		}
		$remote_info['list1'] = $tmp_arr['_0'];
		$remote_info['list2'] = $tmp_arr['_1'];
	}
	/**
	*
	* 添加分类
	* 只能被JQuery.post()调用
	* 返回值：
	*     -1：已存在同名纪录；
	*      1：操作成功；
	*   其它：出错的SQL语句
	*/
	public function add(){
		$name=$_REQUEST['name'];

		$where['name'] = $name;
		$rs = $this->dao->where($where)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$this->dao->name = $name;
		$this->dao->status = 0;
		if($this->dao->add()){
			die('1');
		}
		else{
			die('sql:'.$this->dao->getLastSql());
		}
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		if('route' == $_POST['type']) {
			$direction = $_POST['direction'];
			$lid = $_POST['lid'];
			$site_arr = $_POST['site'];
			if(empty($direction) || empty($lid)) {
				return;
			}
			$dRoute = M("Route");
			if(false === $dRoute->where(array('lid'=>$lid,'direction'=>$direction))->delete()) {
				self::_error('删除旧数据失败！');
			}
			foreach($site_arr as $i=>$site) {
				$data['lid'] = $lid;
				$data['direction'] = $direction;
				$data['i'] = 10*($i+1);
				$data['sid'] = self::getSiteId($site);
				$dRoute->add($data);
			}
			$this->dao->where('id='.$lid)->setField('update_time', date("Y-m-d H:i:s"));
			//$this->dao->where('id='.$lid)->setField('status', 1);
			self::_success('更新成功');
			
		}
		else{
			$id=$_REQUEST['id'];
			$field=$_REQUEST['f'];
			$value=$_REQUEST['v'];
			if('sid' == substr($field,-3)) {
				$value = self::getSiteId($value);
			}
			if('name'== $field) {
				$value = str_replace('_','/',$value);
			}
			$rs = $this->dao->where('id='.$id)->setField(array('update_time',$field), array(date("Y-m-d H:i:s"),$value));
			if($rs)
			{
				if($field=='status') {
					self::_success('操作成功！',__URL__.'/index/status/0',0);
				}
				else{
					self::_success('操作成功！','',0);
				}
			}
			else
			{
				self::_error('发生错误！<br />sql:'.$this->dao->getLastSql());
			}
		}
	}
	function getSiteId($name) {
		$sid = M('Site')->where(array('name'=>$name))->getField('id');
		if(empty($sid))
		{
			$sid = M('Site')->add(array('name'=>$name));
		}
		return $sid;
	}

	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}
}
?>