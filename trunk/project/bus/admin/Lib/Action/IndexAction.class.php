<?php
/**
*
* 管理首页
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class IndexAction extends BaseAction{
	/**
	*
	* 管理后台默认首页
	*/
	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);
		
		$list = M('Line')->where(array('status'=>array('gt',0)))->order('number')->select();
		$this->assign('list', $list);
		$this->assign('content','index');
		$this->display('Layout:Admin_layout');
	}
	public function dump() {
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=hangzhou_".date("Ymd").".txt"); 
		
		$str = ";应用名称\n";
		$str .= "[APPTITLE]=杭州公交\n\n";
		$str .= ";数据版本\n";
		$str .= "[DATAVERSION]=HZ".date("Ymd")."\n\n";
		$str .= ";公交数据\n";
		$str .= ";线路名称,起点站,起点站首班时间,起点站末班时间,终点站,终点站首班时间,终点站末班时间,类型,上行,下行,备注\n\n";
		$str .= "[MAINDATASTART]\n";

		$site_arr = M('Site')->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}
		$line = M('Line')->where(array('status'=>array('gt',0)))->order('number')->select();
		foreach($line as $item) {
			if ($item['number']<1000) {
				$str .= $item['number'].",";
			}
			else {
				$str .= $item['name'].",";
			}
			$str .= $site[$item['start_sid']].",";
			$str .= $item['start_first'].",";
			$str .= $item['start_last'].",";
			$str .= $site[$item['end_sid']].",";
			$str .= $item['end_first'].",";
			$str .= $item['end_last'].",";
			$str .= $item['service_day'].",";
			
			$route = M('Route')->where(array('lid'=>$item['id']))->join('bus_hz_site s on s.id=bus_hz_route.sid')->group('dir')->order('dir desc')->field('group_concat(name ORDER BY sort SEPARATOR "-") as route')->select();
			
			$str .= $route[0]['route'].",";
			$str .= $route[1]['route'].",";
			$str .= $item['fare_norm']."/".$item['fare_cond']."(".$item['ic_card'].")\n";
		}
		$str .= "[MAINDATAEND]\n\n";
		echo $str;
	}
	
}
?>