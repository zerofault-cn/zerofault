<?php

class IndexAction extends Action{

	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
	}

	public function index(){
		
		$this->display();
	}

	public function search() {
		$result = '';
		if(!empty($_REQUEST['line_name'])) {
			$line_name = trim($_REQUEST['line_name']);
			$this->assign('line_name', $line_name);
			$rs = M('Line')->where("number='".$line_name."' or name='".$line_name."'")->field('id')->select();
			if($rs) {
				foreach($rs as $item)
				{
					$result .= self::line($item['id']);
				}
			}
			else{
				$result = '暂时没有此线路的信息';
			}
		}
		elseif(!empty($_REQUEST['site_name'])) {
			$site_name = trim($_REQUEST['site_name']);
			$this->assign('site_name', $site_name);
			$rs = M('Site')->where("name like '%".$site_name."%'")->select();
			if(empty($rs)) {
				$result = '暂时没有经过此处的公交线路';
			}
			elseif(count($rs)==1) {
				$result = self::site($rs[0]['id']);
			}
			else{
				$result = '<br />您查询的关键字有多个可能，请选择最接近的一个：<ol>';
				foreach($rs as $item)
				{
					$result .= '<li><a href="'.__URL__.'/site/id/'.$item['id'].'">'.$item['name'].'</a></li>';
				}
				$result .= '</ol>';
			}
		}
		elseif(!empty($_REQUEST['from']) && !empty($_REQUEST['to'])) {
			$from = trim($_REQUEST['from']);
			$to = trim($_REQUEST['to']);

			$from_rs = M('Site')->where("name like '%".$from."%'")->select();
			$to_rs =  M('Site')->where("name like '%".$to."%'")->select();
			if(empty($from_rs) || empty($to_rs)) {
				$result = '没有经过这两地的线路!';
			}
			elseif(count($from_rs)==1 && count($to_rs)==1) {
				$from_sid = $from_rs[0]['id'];
				$to_sid = $to_rs[0]['id'];
				$result = self::transfer($from_sid,$to_sid);
			}
			else{
				$result = '<form action="'.__URL__.'/transfer" method="get">';
				$result .= '您查询的起点或终点有多个可能，请选择最准确的一个：<br />';
				$result .= '选择起点：';
				foreach($from_rs as $item)
				{
					$result .= '<input type="radio" name="f_sid" value="'.$item['id'].'" checked="true" />'.$item['name'].'&nbsp;';
				}
				$result .= '<hr>选择终点：';
				foreach($to_rs as $item)
				{
					$result .= '<input type="radio" name="t_sid" value="'.$item['id'].'" checked="true" />'.$item['name'].'&nbsp;';
				}
				$result .= '<br /><input type="submit" name="submit" value="开始查询" />';
				$result .= '</form>';
			}
		}

		$this->assign('result',$result);
		$this->display('index');
	}
	public function line($refer_id='') {
		$id = $_REQUEST['id'];
		$return = false;
		if(''!=$refer_id) {
			$id = $refer_id;
			$return = true;
		}
		$result = '';

		$site_arr = M('Site')->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}
		$line_info = M('Line')->find($id);
		$result .= $line_info['name'].'&nbsp;&nbsp;';
		$result .= '<a href="'.__URL__.'/site/id/'.$line_info['start_sid'].'" title="查看经过【'.$site[$line_info['start_sid']].'】的所有线路">'.$site[$line_info['start_sid']].'</a>(';
		$result .= $line_info['start_first'].'-';
		$result .= $line_info['start_last'].') ';
		$result .= '<a href="'.__URL__.'/site/id/'.$line_info['end_sid'].'" title="查看经过【'.$site[$line_info['end_sid']].'】的所有线路">'.$site[$line_info['end_sid']].'</a>(';
		$result .= $line_info['end_first'].'-';
		$result .= $line_info['end_last'].') ';
		$result .= '普通车:'.$line_info['fare_norm'].' ';
		$result .= '空调车:'.$line_info['fare_cond'].' ';
		$result .= '可使用公交卡:'.$line_info['ic_card'].' ';
		$result .= '服务时间:'.$line_info['service_day'].'<br />';
		
		$route = M('Route')->where(array('lid'=>$id,'dir'=>1))->order('sort')->select();
		$site_info = array();
		foreach($route as $item) {
			$site_info[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'" title="查看经过【'.$site[$item['sid']].'】的所有线路">'.$site[$item['sid']].'</a>';
		}
		$route = M('Route')->where(array('lid'=>$id,'dir'=>-1))->order('sort')->select();
		if(empty($route)) {
			$result .= '<span style="color:#FF00FF">环线：</span>';
			$result .= implode('→',$site_info);
			$result .= '<br />';
		}
		else{
			$result .= '<span style="color:#FF00FF">上行：</span>';
			$result .= implode('→',$site_info);
			$result .= '<br />';

			$sitr_info = array();
			foreach($route as $item) {
				$site_info[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'" title="查看经过【'.$site[$item['sid']].'】的所有线路">'.$site[$item['sid']].'</a>';
			}
			$result .= '<span style="color:#FF00FF">下行：</span>';
			$result .= implode('→',$site_info);
			$result .= '<br />';
		}
		$result .= '<br />';
		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	public function site($refer_id) {
		$id = $_REQUEST['id'];
		$return = false;
		if(''!=$refer_id) {
			$id = $refer_id;
			$return = true;
		}
		$result = '';

		$site_arr = M('Site')->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}

		$rs = M('Route')->where(array('sid'=>$id))->join('bus_hz_line l on l.id=lid')->order('l.number')->field('distinct l.*')->select();
		$result .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		$result .= '<tr bgcolor="#ffffff"><th colspan="3">经过【'.$site[$id].'】的线路('.count($rs).'条)</td></tr>';
		$result .= '<tr bgcolor="#ffffff"><th align="left">序号</th><th>线路名称</th><th>起点－终点</th></tr>';
		foreach($rs as $i=>$item) {
			$result .= '<tr bgcolor="#ffffff">';
			$result .= '<td>'.($i+1).'</td>';
			$result .= '<td><a href="'.__URL__.'/line/id/'.$item['id'].'" title="查看线路【'.$item['name'].'】的详细信息">'.$item['name'].'</a></td>';
			$result .= '<td><a href="'.__URL__.'/site/id/'.$item['start_sid'].'" title="查看经过【'.$site[$item['start_sid']].'】的所有线路">'.$site[$item['start_sid']].'</a>→<a href="'.__URL__.'/site/id/'.$item['end_sid'].'" title="查看经过【'.$site[$item['end_sid']].'】的所有线路">'.$site[$item['end_sid']].'</a></td>';
			$result .= '</tr>';
		}
		$result .= '</table>';
		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	public function transfer($f_sid='', $t_sid='') {
		$from_sid = $_REQUEST['f_sid'];
		$to_sid = $_REQUEST['t_sid'];
		$return = false;
		if(''!=$f_sid  && ''!=$t_sid) {
			$from_sid = $f_sid;
			$to_sid = $t_sid;
			$return = true;
		}
		$result = '';

		$site_arr = M('Site')->select();
		$site = array();
		foreach($site_arr as $arr) {
			$site[$arr['id']] = $arr['name'];
		}

		$route = self::findNext($from_sid,$to_sid);
		$result .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		$result .= '<caption>从【<a href="'.__URL__.'/site/id/'.$from_sid.'" title="查看经过【'.$site[$from_sid].'】的所有线路">'.$site[$from_sid].'</a>】到【<a href="'.__URL__.'/site/id/'.$to_sid.'" title="查看经过【'.$site[$to_sid].'】的所有线路">'.$site[$to_sid].'</a>】的乘车方案</caption>';
		$result .= '<tr bgcolor="#ffffff">';
		$result .= '<th>序号</th>';
	//	echo '<th>起点</th>';
		$result .= '<th>乘坐线路</th>';
		if(sizeof($route[0])>1)
		{
			$result .= '<th>换乘站点</th>';
			$result .= '<th>换乘线路</th>';
		}
	//	echo '<th>终点</th>';
		$result .= '</tr>';
		foreach($route as $i=>$r)
		{
			$result .= '<tr bgcolor="#ffffff">';
			$htmresultl .= '<td>'.($i+1).'</td>';
	//		echo '<td>'.getSname($from_sid).'</td>';
				
			foreach($r as $n=>$info)
			{
				$result .= '<td><a href="?action=query_line&id='.$info['lid'].'">'.$site[$info['lid']]."</a></td>";
				if(count($r)>0 && $n!=(count($r)-1))
				{
					$result .= '<td><a href="?action=query_site&id='.$info['sid'].'">'.$site[$info['sid']]."</a></td>";
				}
			}
			$result .= "</tr>";
		}
		$result .= '</table>';

		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	function findNext($from_sid,$to_sid) {
		//取得该站点在它所在线路上的后续站点
		$nextSidArr=self::getNextSidArr($from_sid);

		$n=0;//换乘次数
		$i=0;//可行方案数
		$result=array();
		foreach($nextSidArr as $lid=>$sidArr)//遍历每条线路,在该线路上找终点
		{
			foreach($sidArr as $sid)//在一条线路上找后续站点
			{
				if($sid==$to_sid)
				{
					$result[$i][$n]['lid']=$lid;
					$result[$i][$n]['sid']=$sid;
					$i++;
					continue;//找到的站点是最近的,到下一条线路上去找
				}
			}
		}
		if(sizeof($result[$i-1])>0)
		{
			return $result;
		}

		$n++;
		//一次换乘
		foreach($nextSidArr as $lid=>$sidArr)
		{
			
			$get=0;
			if($get==1)
			{
				continue;
			}
			foreach($sidArr as $sid)
			{
				$nextSidArr2=self::getNextSidArr($sid);
				foreach($nextSidArr2 as $lid2=>$sidArr2)
				{
					foreach($sidArr2 as $sid2)
					{
						if($sid2==$to_sid)
						{
							$result[$i][0]['lid']=$lid;
							$result[$i][0]['sid']=$sid;
							$result[$i][1]['lid']=$lid2;
							$result[$i][1]['sid']=$sid2;
							$i++;
							$get=1;
							continue;
						}
					}
				}
			}
		}
		if(sizeof($result[$i-1])>0)
		{
			return $result;
		}
		$n++;
		//二次换乘
		foreach($nextSidArr as $lid=>$sidArr)
		{
			$get=0;
			if($get==1)
			{
				continue;
			}
			foreach($sidArr as $sid)
			{
				foreach($nextSidArr as $lid=>$sidArr)
				{
					foreach($sidArr as $sid)
					{
						$nextSidArr2=self::getNextSidArr($sid);
						foreach($nextSidArr2 as $lid2=>$sidArr2)
						{
							foreach($sidArr2 as $sid2)
							{
								if($sid2==$e_sid)
								{
									$result[$i][0]['lid']=$lid;
									$result[$i][0]['sid']=$sid;
									$result[$i][$n]['lid']=$lid2;
									$result[$i][$n]['sid']=$sid2;
									$i++;
									$get=1;
									continue;
								}
							}
						}
					}
				}
			}
		}
		if(sizeof($result[$i-1])>0)
		{
			return $result;
		}
		return $result;
		//二次换乘都无结果，就不用再找了
	}
	function getNextSidArr($sid) {
		$rs = M('Route')->where("sid=".$sid)->field('distinct lid')->select();
		$sid_arr = array($lid=>array());
		if(empty($rs)) {
			return $sid_arr;
		}
		foreach($rs as $item) {
			
			$sql="select distinct r2.sid as sid from bus_hz_route r1,bus_hz_route r2 where r1.lid=".$item['lid']." and r1.sid=".$sid." and r2.direction=r1.direction and r2.i>r1.i and r2.lid=r1.lid order by r2.i";
			$rs2 = M('Route')->query($sql);
			if(empty($rs2)) {
				return $sid_arr;
			}
			foreach($rs2 as $item2) {
				$sid_arr[$lid][]=$item2['sid'];
			}
		}
		return $sid_arr;
	}
}
?>