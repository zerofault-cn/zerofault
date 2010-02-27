<?php
/**
*
* 分类管理类
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class SiteAction extends BaseAction{
	protected $dao;
	
	/**
	*
	* 默认构造函数
	*/
	public function _initialize() {
		$this->dao = D('Website');
		parent::_initialize();
	}
	/**
	*
	* 显示网站列表
	* 通过传递参数id来限定某个分类
	* 通过传递参数status来区分有效和无效网站
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '站点管理',
			'url' => __APP__.'/Site'
			);

		$dCategory = D('Category');
		$cate_id = $_REQUEST['id'];
		if(!empty($cate_id)){
			//如果选择了分类，则仅列出该分类下的网站，并按status和sort值排序
			$where['cate_id'] = $cate_id;
			$order = 'status desc, sort';
			$cate_name = $dCategory->where(array('id'=>$cate_id))->getField('name');
			$topnavi[]=array(
				'text'=> '站点列表 (当前分类：'.$cate_name.')',
				);
		}
		else{
			//否则，列出所有网站，按id倒序排列
			$order = 'id desc';
			$topnavi[]=array(
				'text'=> '站点列表',
				);
		}
		$where['status'] = array('gt', -1);//默认仅列出有效网站
		if(!empty($_REQUEST['status'])) {
			//如果选择列出其它状态的网站，则改为按id倒序排列
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		if(!empty($_REQUEST['famous'])) {
			$where['famous'] = $_REQUEST['famous'];
		}
		if(!empty($_REQUEST['recommend'])) {
			$where['recommend'] = $_REQUEST['recommend'];
		}
		
		$max_sort = $this->dao->where($where)->getField("max(sort)");//获取当前条件下所有网站的最大sort值，用于分配给新增网站的默认sort值
		$count = $this->dao->where($where)->getField('count(*)');//获取当前条件下所有网站的个数，用于分页
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		//$p->setConfig('show_num',7);//设定连续显示的页码个数，这里使用默认值7
		//$p->setConfig('side_num',2);//设定两遍保留显示的页码个数，这里使用默认值2
		$p->setConfig('first','<img src="'.APP_PUBLIC_PATH.'/Image/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_PATH.'/Image/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_PATH.'/Image/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_PATH.'/Image/last.gif" align="absbottom" alt="Last"/>');
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach($rs as $key=>$val){
			$rs[$key]['cate_info'] = $dCategory->find($val['cate_id']);
		}

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('cate_list', $dCategory->where(array('status'=>array('gt',-1)))->order('status desc,sort')->select());
		$this->assign('new_sort', $max_sort+10);
		$this->assign('content','Site:index');
		$this->display('Layout:Admin_layout');
	}
	/**
	*
	* 添加网站
	* 只能被JQuery.post()调用
	* 返回值：
	*     -1：已存在同名纪录；
	*      1：操作成功；
	*   其它：出错的SQL语句
	*/
	public function add(){
		$cate_id=intval($_REQUEST['cate_id']);
		$site_id=intval($_REQUEST['site_id']);
		$name=$_REQUEST['name'];
		$url=$_REQUEST['url'];
		$sort=intval($_REQUEST['sort']);
		$descr=$_REQUEST['descr'];
		if($site_id>0)
		{
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$site_id)))->find();
			if($rs && sizeof($rs)>0){
				die('-1');
			}
			$this->dao->find($site_id);
			$this->dao->cate_id = $cate_id;
			$this->dao->name = $name;
			$this->dao->url = $url;
			$this->dao->sort = $sort;
			$this->dao->descr = $descr;
			if($this->dao->save()){
				die('1');
			}
			else{
				die('sql:'.$this->dao->getLastSql());
			}
		}
		else
		{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				die('-1');
			}
			$this->dao->cate_id = $cate_id;
			$this->dao->name = $name;
			$this->dao->url = $url;
			$this->dao->descr = $descr;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->sort = $sort;
			$this->dao->status = 1;
			if($this->dao->add()){
				die('1');
			}
			else{
				die('sql:'.$this->dao->getLastSql());
			}
		}
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		parent::_update();
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