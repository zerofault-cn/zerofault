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

		$order = 'number';
		$where = array();
		$where['status'] = array('gt', 0);
		if(''!=$_REQUEST['status']) {
			$where['status'] = $_REQUEST['status'];
			$order = 'update_time';
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
	function clear() {
		$number = $_REQUEST['number'];
		S($number, NULL);
		$this->dao->where('number='.$number)->setField('status',0);
		self::_success('缓存已清除','',0);
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
		$local_list1 = $dRoute->where(array('lid'=>$id,'dir'=>1))->order('sort')->select();
		$local_list2 = $dRoute->where(array('lid'=>$id,'dir'=>-1))->order('sort')->select();

		$remote_info = S($local_info['number']);
		if(false === $remote_info && $local_info['status']!=1) {
			$name = $local_info['name'];
			if($local_info['number']<1000) {
				$name = $local_info['number'];
			}
			$remote_info = self::getRemoteData($name);
			S($local_info['number'], $remote_info, 7*86400);
		}
		foreach($remote_info as $info) {
			if($local_info['name'] == $info['name']) {
				$remote_info = $info;
				break;
			}
			continue;
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
		$this->assign('content','Line:edit');
		$this->display('Layout:Admin_layout');
	}
	function batch() {
		$local_list = $this->dao->where(array('status'=>0))->order('update_time,id')->limit(20)->select();
		foreach($local_list as $n=>$local_info) {
			echo $n.". ".$local_info['name']."\t\n\t";
			$remote_info = S($local_info['number']);
			if(false === $remote_info){
				echo "Get data\t";
				$name = $local_info['name'];
				if($local_info['number']<1000) {
					$name = $local_info['number'];
				}
				$remote_info = self::getRemoteData($name);
				S($local_info['number'], $remote_info, 7*86400);
			}
			if(empty($remote_info)) {
				echo "Not Exists.\t";
				$this->dao->where('id='.$local_info['id'])->setField(array('update_time','status'), array(date("Y-m-d H:i:s"),-1));
				echo "Delete Done\n";
				continue;
			}
			foreach($remote_info as $info) {
				if($local_info['name'] == $info['name']) {
					$remote_info = $info;
					break;
				}
				else{
					$remote_info = array();
				}
			}
			if(empty($remote_info)) {
				echo "Wrong Data.\tPass\n";
				continue;
			}
			//更新line
			echo "Base info\t";
			$data = array();
			$data['start_sid']   = self::getSiteId($remote_info['start_name']);
			$data['start_first'] = $remote_info['start_first'];
			$data['start_last']  = $remote_info['start_last'];
			$data['end_sid']     = self::getSiteId($remote_info['end_name']);
			$data['end_first']   = $remote_info['end_first'];
			$data['end_last']    = $remote_info['end_last'];
			$data['fare_norm']   = $remote_info['fare_norm'];
			$data['fare_cond']   = $remote_info['fare_cond'];
			$data['ic_card']     = $remote_info['ic_card'];
			$data['service_day'] = $remote_info['service_day'];
			$data['update_time'] = date("Y-m-d H:i:s");
			$data['status'] = 1;
			$this->dao->where('id='.$local_info['id'])->data($data)->save();
			//更新route
			echo "Route1\t";
			foreach($remote_info['list1'] as $i=>$site) {
				$data = array();
				$data['lid'] = $local_info['id'];
				$data['sid'] = self::getSiteId($site);
				$data['sort'] = 10*($i+1);
				$data['dir'] = 1;
				M('Route')->add($data);
			}
			if(empty($remote_info['list2']) || $remote_info['list1']==$remote_info['list2']) {
				echo "Circle Line Done\n";
				continue;
			}
			echo "Route2\t";
			foreach($remote_info['list2'] as $i=>$site) {
				$data = array();
				$data['lid'] = $local_info['id'];
				$data['sid'] = self::getSiteId($site);
				$data['sort'] = $i;
				$data['dir'] = -1;
				M('Route')->add($data);
			}
			echo "Done\n";
		}
	}
	function getRemoteData($name) {
		require_cache(LIB_PATH.'/simple_html_dom.php');
		global $table,$remote_info,$offset;
		$remote_info = array();
		if(function_exists('curl_init')) {
			$c = curl_init();
			curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
			curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".iconv('GBK','UTF-8',$name));
			$data = curl_exec($c);
		}
		else{
			$data = self::httpPost("http://www.hzbus.com.cn/content/busline/line_search.jsp","line_name=".iconv('GBK','UTF-8',$name),"http://www.hzbus.com.cn/");
		}
		$data = iconv('GBK','UTF-8',$data);
		//$data = mb_convert_encoding($data,'UTF-8','GBK');
		$data=str_get_html($data);
		$table=$data->find('table[width="98%"] table',0);
		$descr=$table->children(1)->plaintext;
		if(strlen(trim($descr))>=2) {//表示存在此条线路的信息
			$offset = 0;
			if(strlen(trim($descr))<20) {//表示至少有两条同名线路
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
		return $remote_info;
	}
	function parseLineInfo($descr,$tmp_offset) {
		require_cache(LIB_PATH.'/simple_html_dom.php');
		global $table,$remote_info,$offset;
		$config_hz = C('_config_hz_');

		$tmp_remote_info = array();
		$line_arr=explode("\n",$descr);
		$tmp_remote_info['name'] = trim($line_arr[1]);
		
		$numbers= explode("/",$tmp_remote_info['name']);
		$number = str_ireplace("K",'',$numbers[0]);
		$number = str_ireplace("(夜间线)",'',$number);
		$number = str_ireplace("(区间)",'',$number);
		$number = substr($number,0,3)=='B支'? (2000+intval(str_ireplace("B支",'',$number))) : $number;
		$number = substr($number,0,1)=='B' ? (1000+intval(str_ireplace("B",'',$number))) : $number;
		$number = substr($number,0,1)=='Y' ? (3000+intval(str_ireplace("Y",'',$number))) : $number;
		$number = substr($number,0,1)=='J' ? (4000+intval(str_ireplace("J",'',$number))) : $number;
		$number = intval($number);

		$term_arr=explode("--",$line_arr[6]);
		$tmp_remote_info['start_name'] = trim($term_arr[0]);
		$tmp_remote_info['end_name'] = trim($term_arr[1]);

		$time1_arr=explode("-",$line_arr[14]);
		$time2_arr=explode("-",$line_arr[15]);
		$tmp_remote_info['start_first'] = trim($time1_arr[0]);
		$tmp_remote_info['start_last'] = trim($time1_arr[1]);
		$tmp_remote_info['end_first'] = trim($time2_arr[0]);
		$tmp_remote_info['end_last'] = trim($time2_arr[1]);
		
		$tmp_remote_info['fare_norm'] = trim($line_arr[18]);
		$tmp_remote_info['fare_cond'] = trim($line_arr[22]);

		$tmp_remote_info['ic_card'] = trim($line_arr[26]);
		$tmp_remote_info['service_day'] = trim($line_arr[30]);
		$route_arr=$table->children($tmp_offset)->find('table[bgcolor="3E89C0"]');
		$tmp_arr = array();
		$tmp_arr['_0'] = array();
		$tmp_arr['_1'] = array();
		foreach($route_arr as $r=>$route) {
			if($r==1 && in_array($number, $config_hz['circlelines'])) {
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
		$tmp_remote_info['list1'] = $tmp_arr['_0'];
		$tmp_remote_info['list2'] = $tmp_arr['_1'];
		$remote_info[] = $tmp_remote_info;
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
			self::_error('已存在此线路名！');
		}
		$numbers= explode("/",$name);
		$number = str_ireplace("K",'',$numbers[0]);
		$number = str_ireplace("(夜间线)",'',$number);
		$number = str_ireplace("(区间)",'',$number);
		$number = substr($number,0,3)=='B支'? (2000+intval(str_ireplace("B支",'',$number))) : $number;
		$number = substr($number,0,1)=='B' ? (1000+intval(str_ireplace("B",'',$number))) : $number;
		$number = substr($number,0,1)=='Y' ? (3000+intval(str_ireplace("Y",'',$number))) : $number;
		$number = substr($number,0,1)=='J' ? (4000+intval(str_ireplace("J",'',$number))) : $number;
		$number = intval($number);
		$this->dao->name = $name;
		$this->dao->number = $number;
		$this->dao->status = 0;
		if($this->dao->add()){
			self::_success('添加成功','',0);
		}
		else{
			self::_error('sql:'.$this->dao->getLastSql());
		}
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		if('route' == $_POST['type']) {
			$dir = $_POST['dir'];
			$lid = $_POST['lid'];
			$site_arr = $_POST['site'];
			if(empty($dir) || empty($lid)) {
				return;
			}
			$dRoute = M("Route");
			if(false === $dRoute->where(array('lid'=>$lid,'dir'=>$dir))->delete()) {
				self::_error('删除旧数据失败！');
			}
			foreach($site_arr as $i=>$site) {
				$data['lid'] = $lid;
				$data['dir'] = $dir;
				$data['sort'] = $i;
				$data['sid'] = self::getSiteId($site);
				$dRoute->add($data);
			}
			$this->dao->where('id='.$lid)->setField('update_time', date("Y-m-d H:i:s"));
			//$this->dao->where('id='.$lid)->setField('status', 1);
			self::_success('更新成功','',0);
			
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