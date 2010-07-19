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
		$this->assign('update_time',M('Line')->getField('max(update_time)'));
	}

	public function index(){
		
		$this->display();
	}

	public function search() {
		$result = '';
		if(!empty($_REQUEST['line_name'])) {
			$line_name = trim($_REQUEST['line_name']);
			$this->assign('line_name', $line_name);
			$rs = M('Line')->where("(number='".$line_name."' or name='".$line_name."') and status=1")->field('id')->select();
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
					$result .= '<li><a href="'.__APP__.'?m=Index&a=site&id='.$item['id'].'">'.$item['name'].'</a></li>';
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
				$result = '<form action="'.__APP__.'" method="get">';
				$result .= '<input type="hidden" name="m" value="Index" /><input type="hidden" name="a" value="route" />';
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
		$result .= '<a href="'.__APP__.'?m=Index&a=site&id='.$line_info['start_sid'].'" title="查看经过【'.$site[$line_info['start_sid']].'】的所有线路">'.$Site[$line_info['start_sid']].'</a>(';
		$result .= $line_info['start_first'].'-';
		$result .= $line_info['start_last'].') ';
		$result .= '<a href="'.__APP__.'?m=Index&a=site&id='.$line_info['end_sid'].'" title="查看经过【'.$Site[$line_info['end_sid']].'】的所有线路">'.$Site[$line_info['end_sid']].'</a>(';
		$result .= $line_info['end_first'].'-';
		$result .= $line_info['end_last'].') ';
		$result .= '普通车:'.$line_info['fare_norm'].' ';
		$result .= '空调车:'.$line_info['fare_cond'].' ';
		$result .= '可使用公交卡:'.$line_info['ic_card'].' ';
		$result .= '服务时间:'.$line_info['service_day'].'<br />';
		
		$route = M('Route')->where(array('lid'=>$id,'dir'=>1))->order('sort')->select();
		$site_info = array();
		foreach($route as $item) {
			$site_info[] = '<a href="'.__APP__.'?m=Index&a=site&id='.$item['sid'].'" title="查看经过【'.$Site[$item['sid']].'】的所有线路">'.$Site[$item['sid']].'</a>';
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

			$site_info = array();
			foreach($route as $item) {
				$site_info[] = '<a href="'.__APP__.'?m=Index&a=site&id='.$item['sid'].'" title="查看经过【'.$Site[$item['sid']].'】的所有线路">'.$Site[$item['sid']].'</a>';
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

		$rs = M('Route')->where(array('sid'=>$id))->join('bus_hz_line l on l.id=lid and l.status=1')->order('l.number')->field('distinct l.*')->select();
	//	dump($rs);
		$result .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		$result .= '<tr bgcolor="#ffffff"><th colspan="3">经过【'.$Site[$id].'】的线路('.count($rs).'条)</td></tr>';
		$result .= '<tr bgcolor="#ffffff"><th align="left">序号</th><th>线路名称</th><th>起点－终点</th></tr>';
		foreach($rs as $i=>$item) {
			$result .= '<tr bgcolor="#ffffff">';
			$result .= '<td>'.($i+1).'</td>';
			$result .= '<td><a href="'.__APP__.'?m=Index&a=line&id='.$item['id'].'" title="查看线路【'.$item['name'].'】的详细信息">'.$item['name'].'</a></td>';
			$result .= '<td><a href="'.__APP__.'?m=Index&a=site&id='.$item['start_sid'].'" title="查看经过【'.$Site[$item['start_sid']].'】的所有线路">'.$Site[$item['start_sid']].'</a>→<a href="'.__APP__.'?m=Index&a=site&id='.$item['end_sid'].'" title="查看经过【'.$Site[$item['end_sid']].'】的所有线路">'.$Site[$item['end_sid']].'</a></td>';
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

		$rs = M('Line')->where('status=1')->select();
		$Line = array();
		foreach($rs as $item) {
			$Line[$item['id']] = $item['name'];
		}

		$rs = array();
		if(empty($_REQUEST['trans'])) {
			//未强制查询换乘路线
			//查询直达线路
			$rs = M('Route')->query("select distinct r2.lid as lid,r2.dir as dir,r1.sort as sort1,r2.sort as sort2 from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$from_sid." and r2.sid=".$to_sid." and r1.dir=r2.dir and r1.lid=r2.lid and r1.sort<r2.sort");
		}
		if(empty($rs)) {
			//没有直达线路，查找一次换乘线路
			$rs = self::getTrans($from_sid,$to_sid);
		}
		$result .= '<table border="1" cellspacing="0" cellpadding="1" bordercolor="#999999" style="border-collapse:collapse;">';
		$result .= '<tr>';
		if(!empty($rs[0]['lid'])) {
			$result .= '<td colspan="4" align="center">';
		}
		else{
			$result .= '<td colspan="6" align="center">';
		}
		$result .= '[<a href="'.__APP__.'?m=Index&a=site&id='.$from_sid.'" title="查看经过【'.$Site[$from_sid].'】的所有线路">'.$Site[$from_sid].'</a>]→[<a href="'.__APP__.'?m=Index&a=site&id='.$to_sid.'" title="查看经过【'.$Site[$to_sid].'】的所有线路">'.$Site[$to_sid].'</a>]</td></tr>';
		$result .= '<tr>';
		$result .= '<th>序号</th>';
		$result .= '<th>乘坐线路</th>';
		if(empty($rs[0]['lid'])) {
			$result .= '<th>换乘站点</th>';
			$result .= '<th>换乘线路</th>';
		}
		$result .= '<th>站数</th>';
		$result .= '<th nowrap="true">详细</th>';
		$result .= '</tr>';
		$count = array();
		foreach($rs as $i=>$item) {
			if(!empty($item['lid'])) {
				$count[] = $rs[$i]['count'] = M('Route')->where(array('lid'=>$item['lid'],'dir'=>$item['dir'],'sort'=>array('between',$item['sort1'].','.$item['sort2'])))->order('sort')->count();
			}
			else{
				$count1 = M('Route')->where(array('lid'=>$item['from_lid'],'dir'=>$item['from_dir'],'sort'=>array('between',$item['from_sort1'].','.$item['from_sort2'])))->order('sort')->count();
				$count2 = M('Route')->where(array('lid'=>$item['to_lid'],'dir'=>$item['to_dir'],'sort'=>array('between',$item['to_sort1'].','.$item['to_sort2'])))->order('sort')->count();
				$count[] = $rs[$i]['count'] = $count1+$count2;
			}
		}
		array_multisort($count,$rs);
		foreach($rs as $i=>$item) {
			$result .= '<tr>';
			$result .= '<td align="center">'.($i+1).'</td>';
			if(!empty($item['lid'])) {
				$result .= '<td><a href="'.__APP__.'?m=Index&a=line&id='.$item['lid'].'">'.$Line[$item['lid']].'</a></td>';
				$result .= '<td align="center">'.$item['count'].'</td>';
				$result .= '<td><a href="'.__APP__.'?m=Index&a=transfer&from_sid='.$from_sid.'&from_lid='.$item['lid'].'&from_dir='.$item['dir'].'&to_sid='.$to_sid.'">查看</a></td>';
			}
			else{
				$result .= '<td><a href="'.__APP__.'?m=Index&a=line&id='.$item['from_lid'].'">'.$Line[$item['from_lid']].'</a></td>';
				
				$tmp = array();
				foreach(explode(',', $item['trans_sids']) as $trans_sid) {
					$tmp[] = '<a href="'.__APP__.'?m=Index&a=site&id='.$trans_sid.'">'.$Site[$trans_sid].'</a>';
				}
				$tmp_size = count($tmp);
				$result .= '<td>'.implode('/',array_slice($tmp,0,3)).($tmp_size>3?'/...':'').'</td>';
				$result .= '<td><a href="'.__APP__.'?m=Index&a=line&id='.$item['to_lid'].'">'.$Line[$item['to_lid']].'</a></td>';
				
				$result .= '<td align="center">'.$item['count'].'</td>';
				$result .= '<td><a href="'.__APP__.'?m=Index&a=transfer&from_sid='.$item['from_sid'].'&from_lid='.$item['from_lid'].'&to_sid='.$item['to_sid'].'&to_lid='.$item['to_lid'].'">查看</a></td>';
			}
			
			$result .= "</tr>";
		}
		if(!empty($rs[0]['lid'])) {
			$result .= '<tr><td colspan="4">';
			$result .= '<a href="'.__APP__.'?m=Index&a=route&from_sid='.$from_sid.'&to_sid='.$to_sid.'&trans=1">搜索更多路线</a>';
			$result .= '</td></tr>';
		}
		$result .= '</table>';
		
		if(empty($rs)) {
			$result = '没有直达线路，也没有一次换乘线路<br />';
		}

		if($return) {
			return $result;
		}
		$this->assign('result',$result);
		$this->display('index');
	}

	function getTrans($from_sid,$to_sid) {
		$rs = M('Trans')->where(array('from_sid'=>$from_sid,'to_sid'=>$to_sid))->select();
		if(empty($rs)) {
			$rs = M('Route')->query("select distinct r2.sid as sid, r2.lid as lid, r2.dir as dir,r1.sort as sort1,r2.sort as sort2 from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$from_sid." and r2.dir=r1.dir and r2.lid=r1.lid and r2.sort>r1.sort order by r2.sort");
			foreach($rs as $item) {
				$next_rs = M('Route')->query("select distinct r2.sid as sid, r2.lid as lid, r2.dir as dir,r1.sort as sort1,r2.sort as sort2 from bus_hz_route r1,bus_hz_route r2 where r1.sid=".$item['sid']." and r2.lid!=".$item['lid']." and r2.sid=".$to_sid." and r1.dir=r2.dir and r1.lid=r2.lid and r1.sort<r2.sort");
				if(empty($next_rs)) {
					continue;
				}
				foreach($next_rs as $next_item) {
					$data = array();
					$data['from_sid'] = $from_sid;
					$data['from_lid'] = $item['lid'];
					$data['from_dir'] = $item['dir'];
					$data['from_sort1'] = $item['sort1'];
					$data['from_sort2'] = $item['sort2'];
					$data['trans_sid'] = $item['sid'];
					$data['to_sid'] = $next_item['sid'];
					$data['to_lid'] = $next_item['lid'];
					$data['to_dir'] = $next_item['dir'];
					$data['to_sort1'] = $next_item['sort1'];
					$data['to_sort2'] = $next_item['sort2'];
					$data['id'] = M('Trans')->add($data);
				}
			}
		}
		return M('Trans')->where(array('from_sid'=>$from_sid,'to_sid'=>$to_sid))->order('from_lid,from_sid,to_sid,trans_sid')->group('from_lid,to_lid')->field('*,group_concat(distinct trans_sid) as trans_sids')->select();
	}
	
	function transfer($f_sid='',$f_lid='',$t_sid='',$t_lid='') {
		$from_sid = $_REQUEST['from_sid'];
		$from_lid = $_REQUEST['from_lid'];
		$from_dir = $_REQUEST['from_dir'];
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
		if(empty($to_lid)) {
			$trans = array('trans_sids'=>$to_sid);
			$from_line = M('Line')->find($from_lid);
			$from_route = M('Route')->where(array('lid'=>$from_lid,'dir'=>$from_dir))->order('sort')->select();
		}
		else{
			$where['to_lid'] = $to_lid;
			$trans = M('Trans')->where($where)->order('from_sid,to_sid,trans_sid')->group('from_lid,to_lid')->field('*,group_concat(distinct trans_sid) as trans_sids')->find();
			$from_line = M('Line')->find($trans['from_lid']);
			$from_route = M('Route')->where(array('lid'=>$trans['from_lid'],'dir'=>$trans['from_dir']))->order('sort')->select();
			$to_line = M('Line')->find($trans['to_lid']);
			$to_route = M('Route')->where(array('lid'=>$trans['to_lid'],'dir'=>$trans['to_dir']))->order('sort')->select();
		}
		$result .= '搭乘：<a href="'.__APP__.'?m=Index&a=line&id='.$from_line['id'].'">'.$from_line['name'].'</a> ('.(1==$trans['from_dir']?('上行，'.$from_line['start_first'].'~'.$from_line['start_last']):('下行，'.$from_line['end_first'].'~'.$from_line['end_last'])).')<br />';
		
		$end = false;
		$color = '#BBBBBB';
		$end_flag = 999;
		$tmp = array();
		foreach($from_route as $i=>$item) {
			if(!$end && $item['sid']==$from_sid) {
				$color = 'auto';
			}
			if($i>0 && in_array($item['sid'], explode(',', $trans['trans_sids']))) {
				$end_flag = $i;
			}
			if(($end_flag+1) == $i) {
				$color = '#BBBBBB';
				$end = true;
			}
			$tmp[] = '<a style="color:'.$color.'" href="'.__APP__.'?m=Index&a=site&id='.$item['sid'].'">'.$Site[$item['sid']].'</a>';
		}

		if(empty($to_lid)) {
			
		}
		else{
			$result .= '经由：'.implode('→', $tmp).'<br />';
			$tmp = array();
			foreach(explode(',', $trans['trans_sids']) as $trans_sid) {
				$tmp[] = '<a style="color:#ff00ff" href="'.__APP__.'?m=Index&a=site&id='.$trans_sid.'">'.$Site[$trans_sid].'</a>';
			}
			$result .= '　在：'.implode('、', $tmp).' 下车，<br />';
			
			$result .= '换乘：<a href="'.__APP__.'?m=Index&a=line&id='.$to_line['id'].'">'.$to_line['name'].'</a> ('.(1==$trans['to_dir']?('上行，'.$to_line['start_first'].'~'.$to_line['start_last']):('下行，'.$to_line['end_first'].'~'.$to_line['end_last'])).')<br />';

			$color = '#BBBBBB';
			$end = false;
			$end_flag = 999;
			$tmp = array();
			//dump($to_route);
			$trans_sid_arr = explode(',', $trans['trans_sids']);
			foreach($to_route as $i=>$item) {
				if(!$end  && in_array($item['sid'], explode(',', $trans['trans_sids']))) {
					$color = 'auto';
				}
				if($item['sid'] == $to_sid) {
					$end_flag = $i;//这个标记过后结束显示
				}
				if(($end_flag+1) == $i) {
					$color = '#BBBBBB';
					$end = true;
				}
				$tmp[] = '<a style="color:'.$color.'" href="'.__APP__.'?m=Index&a=site&id='.$item['sid'].'">'.$Site[$item['sid']].'</a>';
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