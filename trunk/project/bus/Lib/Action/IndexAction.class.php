<?php

class IndexAction extends Action{

	protected $Site;

	public function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
		$this->Site = S('Site');
		if(false === $this->Site) {
			$rs = M('Site')->select();
			$Site = array();
			foreach($rs as $item) {
				$Site[$item['id']] = $item['name'];
			}
			$this->Site = $Site;
			S('Site',$Site,86400);
		}
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
			$this->assign('from', $from);
			$this->assign('to', $to);

			$from_rs = M('Site')->where("name like '%".$from."%'")->select();
			$to_rs =  M('Site')->where("name like '%".$to."%'")->select();
			if(empty($from_rs) || empty($to_rs)) {
				$result = '没有经过这两地的线路!';
			}
			elseif(count($from_rs)==1 && count($to_rs)==1) {
				$from_sid = $from_rs[0]['id'];
				$to_sid = $to_rs[0]['id'];
				$result = self::route($from_sid,$to_sid);
			}
			else{
				$result = '<form action="'.__URL__.'/route" method="get">';
				$result .= '您查询的起点或终点有多个可能，请选择最准确的一个：<br />';
				$result .= '选择起点：';
				foreach($from_rs as $item)
				{
					$result .= '<input type="radio" name="from_sid" value="'.$item['id'].'" checked="true" />'.$item['name'].'&nbsp;';
				}
				$result .= '<hr>选择终点：';
				foreach($to_rs as $item)
				{
					$result .= '<input type="radio" name="to_sid" value="'.$item['id'].'" checked="true" />'.$item['name'].'&nbsp;';
				}
				$result .= '<br /><input type="submit" value="开始查询" />';
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

		$Site = $this->Site;

		$line_info = M('Line')->find($id);
		$this->assign('line_name', $line_info['name']);

		$result .= $line_info['name'].'&nbsp;&nbsp;';
		$result .= '<a href="'.__URL__.'/site/id/'.$line_info['start_sid'].'" title="查看经过【'.$site[$line_info['start_sid']].'】的所有线路">'.$Site[$line_info['start_sid']].'</a>(';
		$result .= $line_info['start_first'].'-';
		$result .= $line_info['start_last'].') ';
		$result .= '<a href="'.__URL__.'/site/id/'.$line_info['end_sid'].'" title="查看经过【'.$Site[$line_info['end_sid']].'】的所有线路">'.$Site[$line_info['end_sid']].'</a>(';
		$result .= $line_info['end_first'].'-';
		$result .= $line_info['end_last'].') ';
		$result .= '普通车:'.$line_info['fare_norm'].' ';
		$result .= '空调车:'.$line_info['fare_cond'].' ';
		$result .= '可使用公交卡:'.$line_info['ic_card'].' ';
		$result .= '服务时间:'.$line_info['service_day'].'<br />';
		
		$route = M('Route')->where(array('lid'=>$id,'dir'=>1))->order('sort')->select();
		$site_info = array();
		foreach($route as $item) {
			$site_info[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'" title="查看经过【'.$Site[$item['sid']].'】的所有线路">'.$Site[$item['sid']].'</a>';
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
				$site_info[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'" title="查看经过【'.$Site[$item['sid']].'】的所有线路">'.$Site[$item['sid']].'</a>';
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

		$Site = $this->Site;
		$this->assign('site_name', $Site[$id]);

		$rs = M('Route')->where(array('sid'=>$id))->join('bus_hz_line l on l.id=lid')->order('l.number')->field('distinct l.*')->select();
		$result .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		$result .= '<tr bgcolor="#ffffff"><th colspan="3">经过【'.$Site[$id].'】的线路('.count($rs).'条)</td></tr>';
		$result .= '<tr bgcolor="#ffffff"><th align="left">序号</th><th>线路名称</th><th>起点－终点</th></tr>';
		foreach($rs as $i=>$item) {
			$result .= '<tr bgcolor="#ffffff">';
			$result .= '<td>'.($i+1).'</td>';
			$result .= '<td><a href="'.__URL__.'/line/id/'.$item['id'].'" title="查看线路【'.$item['name'].'】的详细信息">'.$item['name'].'</a></td>';
			$result .= '<td><a href="'.__URL__.'/site/id/'.$item['start_sid'].'" title="查看经过【'.$Site[$item['start_sid']].'】的所有线路">'.$Site[$item['start_sid']].'</a>→<a href="'.__URL__.'/site/id/'.$item['end_sid'].'" title="查看经过【'.$Site[$item['end_sid']].'】的所有线路">'.$Site[$item['end_sid']].'</a></td>';
			$result .= '</tr>';
		}
		$result .= '</table>';
		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	public function route($f_sid='', $t_sid='') {
		$from_sid = $_REQUEST['from_sid'];
		$to_sid = $_REQUEST['to_sid'];
		$trans = $_REQUEST['trans'];
		$return = false;
		if(''!=$f_sid  && ''!=$t_sid) {
			$from_sid = $f_sid;
			$to_sid = $t_sid;
			$return = true;
		}
		$result = '';

		$Site = $this->Site;

		$this->assign('from', $Site[$from_sid]);
		$this->assign('to', $Site[$to_sid]);

		$rs = M('Line')->select();
		$Line = array();
		foreach($rs as $item) {
			$Line[$item['id']] = $item['name'];
		}

		$rs = array();
		if(empty($_REQUEST['trans'])) {
			//未强制查询换乘路线
			$rs = M('Route')->query("select distinct r2.lid as lid from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$from_sid." and r2.sid=".$to_sid." and r1.dir=r2.dir and r1.lid=r2.lid and r1.sort<r2.sort");
		}
		if(empty($rs)) {
			//没有直达线路，查找一次换乘线路
			$rs = self::getTrans($from_sid,$to_sid);
		}
		if(empty($rs)) {
			$result = '没有直达线路，也没有一次换乘线路<br />';
		}
		$result .= '<table border="1" cellspacing="0" cellpadding="1" bordercolor="#999999" style="border-collapse:collapse;">';
		$result .= '<tr>';
		if(sizeof($rs[0])>1) {
			$result .= '<td colspan="5" align="center">';
		}
		else{
			$result .= '<td colspan="2" align="center">';
		}
		$result .= '[<a href="'.__URL__.'/site/id/'.$from_sid.'" title="查看经过【'.$Site[$from_sid].'】的所有线路">'.$Site[$from_sid].'</a>]→[<a href="'.__URL__.'/site/id/'.$to_sid.'" title="查看经过【'.$Site[$to_sid].'】的所有线路">'.$Site[$to_sid].'</a>]</td></tr>';
		$result .= '<tr>';
		$result .= '<th>序号</th>';
		$result .= '<th>乘坐线路</th>';
		if(sizeof($rs[0])>1)
		{
			$result .= '<th>换乘站点</th>';
			$result .= '<th>换乘线路</th>';
			$result .= '<th>详细</th>';
		}
		$result .= '</tr>';
		foreach($rs as $i=>$item)
		{
			$result .= '<tr>';
			$result .= '<td align="center">'.($i+1).'</td>';
			if(!empty($item['lid'])) {
				$result .= '<td><a href="'.__URL__.'/line/id/'.$item['lid'].'">'.$Line[$item['lid']].'</a></td>';
			}
			else{
				$result .= '<td><a href="'.__URL__.'/line/id/'.$item['from_lid'].'">'.$Line[$item['from_lid']].'</a></td>';
				$tmp = array();
				foreach(explode(',', $item['trans_sids']) as $trans_sid) {
					$tmp[] = '<a href="'.__URL__.'/site/id/'.$trans_sid.'">'.$Site[$trans_sid].'</a>';
				}
				$result .= '<td>'.implode(', ',$tmp).'</td>';
				$result .= '<td><a href="'.__URL__.'/line/id/'.$item['to_lid'].'">'.$Line[$item['to_lid']].'</a></td>';
				$result .= '<td><a href="'.__URL__.'/transfer/from_sid/'.$item['from_sid'].'/from_lid/'.$item['from_lid'].'/to_sid/'.$item['to_sid'].'/to_lid/'.$item['to_lid'].'">查看</a></td>';
			}
			$result .= "</tr>";
		}
		if(sizeof($rs[0])==1) {
			$result .= '<tr><td colspan="2">';
			$result .= '<a href="'.__URL__.'/route/from_sid/'.$from_sid.'/to_sid/'.$to_sid.'/trans/1">搜索更多路线</a>';
			$result .= '</td></tr>';
		}
		$result .= '</table>';

		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	function getTrans($from_sid,$to_sid) {
		$rs = M('Trans')->where(array('from_sid'=>$from_sid,'to_sid'=>$to_sid))->select();
		if(empty($rs)) {
			$rs = M('Route')->query("select distinct r2.sid as sid, r2.lid as lid, r2.dir as dir from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$from_sid." and r2.dir=r1.dir and r2.lid=r1.lid and r2.sort>r1.sort order by r2.sort");
			foreach($rs as $item) {
				$next_rs = M('Route')->query("select distinct r2.sid as sid, r2.lid as lid, r2.dir as dir from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$item['sid']." and r2.lid!=".$item['lid']." and r2.sid=".$to_sid." and r1.dir=r2.dir and r1.lid=r2.lid and r1.sort<r2.sort");
				if(empty($next_rs)) {
					continue;
				}
				foreach($next_rs as $next_item) {
					$data = array();
					$data['from_sid'] = $from_sid;
					$data['from_lid'] = $item['lid'];
					$data['from_dir'] = $item['dir'];
					$data['trans_sid'] = $item['sid'];
					$data['to_sid'] = $next_item['sid'];
					$data['to_lid'] = $next_item['lid'];
					$data['to_dir'] = $next_item['dir'];
					$data['id'] = M('Trans')->add($data);
					$result[] = $data;
				}
			}
		}
		return M('Trans')->where(array('from_sid'=>$from_sid,'to_sid'=>$to_sid))->order('from_lid,from_sid,to_sid,trans_sid')->group('from_lid,to_lid')->field('*,group_concat(trans_sid) as trans_sids')->select();
	}
	
	function transfer($f_sid='',$f_lid='',$t_sid='',$t_lid='') {
		$from_sid = $_REQUEST['from_sid'];
		$from_lid = $_REQUEST['from_lid'];
		$to_sid = $_REQUEST['to_sid'];
		$to_lid = $_REQUEST['to_lid'];
		$return = false;
		if(''!=$f_sid) {
			$from_sid = $f_sid;
			$from_lid = $f_lid;
			$to_sid = $t_sid;
			$to_lid = $t_lid;
			$return = true;
		}
		$result = '';

		$Site = $this->Site;
		$this->assign('from', $Site[$from_sid]);
		$this->assign('to', $Site[$to_sid]);

		$where['from_sid'] = $from_sid;
		$where['from_lid'] = $from_lid;
		$where['to_sid'] = $to_sid;
		$where['to_lid'] = $to_lid;
		$trans = M('Trans')->where($where)->order('from_sid,to_sid,trans_sid')->group('from_lid,to_lid')->field('*,group_concat(trans_sid) as trans_sids')->find();
		$from_line = M('Line')->find($trans['from_lid']);
		$from_route = M('Route')->where(array('lid'=>$trans['from_lid'],'dir'=>$trans['from_dir']))->select();
		$to_line = M('Line')->find($trans['to_lid']);
		$to_route = M('Route')->where(array('lid'=>$trans['to_lid'],'dir'=>$trans['to_dir']))->select();
		
		$result .= '搭乘：<a href="'.__URL__.'/line/id/'.$from_line['id'].'">'.$from_line['name'].'</a> ('.(1==$trans['from_dir']?($from_line['start_first'].'~'.$from_line['start_last']):($from_line['end_first'].'~'.$from_line['end_last'])).')<br />';
		
		$echo = false;
		$tmp = array();
		foreach($from_route as $i=>$item) {
			if($item['sid']==$from_sid) {
				$echo = true;
			}
			if(in_array($item['sid'], explode(',', $trans['trans_sids']))) {
				$echo = false;
			}
			if($echo) {
				$tmp[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'">'.$Site[$item['sid']].'</a>';
			}
		}
		$result .= '经由：'.implode('→', $tmp).'<br />';

		$tmp = array();
		foreach(explode(',', $trans['trans_sids']) as $trans_sid) {
			$tmp[] = '<a style="color:#ff00ff" href="'.__URL__.'/site/id/'.$trans_sid.'">'.$Site[$trans_sid].'</a>';
		}
		$result .= '　在：'.implode('、', $tmp).' 下车，<br />';
		
		$result .= '换乘：<a href="'.__URL__.'/line/id/'.$to_line['id'].'">'.$to_line['name'].'</a> ('.(1==$trans['to_dir']?($to_line['start_first'].'~'.$to_line['start_last']):($to_line['end_first'].'~'.$to_line['end_last'])).')<br />';

		$echo = false;
		$start_flag = $end_flag = 0;
		$tmp = array();
		foreach($to_route as $i=>$item) {
			foreach(explode(',', $trans['trans_sids']) as $trans_sid);
			if($item['sid'] == $trans_sid) {
				$start_flag = $i;//这个标记过后开始显示
			}
			if($item['sid'] == $to_sid) {
				$end_flag = $i;//这个标记过后结束显示
			}
			if($start_flag == ($i-1)) {
				$echo = true;
			}
			if($end_flag == ($i-1)) {
				$echo = false;
			}
			if($echo) {
				$tmp[] = '<a href="'.__URL__.'/site/id/'.$item['sid'].'">'.$Site[$item['sid']].'</a>';
			}
		}
		$result .= '经由：'.implode('→', $tmp).' 到达目的地。';

		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}
	
}
?>