<?php
/**
 * Paginator Class
 *
 * @category	Pagination
 * @author		zerofault@gmail.com
 * @created		2009/7/20
 * @modified	2009/7/20
 */
class Paginator{
	protected $offset;			//当前offset
	protected $limit;			//每页显示条数
	protected $parameter;		//已有的url参数
	protected $page_count;		//总页数
	protected $record_count;	//总记录数
	protected $current_page;	//当前页数
	protected $pre_url;

	protected $config = array(
		'first'=>'|&lt;',
		'prev'=>'&lt;',
		'next'=>'&gt;',
		'last'=>'&gt;|',
		'show_num'=>9,		//设定中间连续显示的页码个数，如...4,5,6,7,8,9,10...，最小为3
		'side_num'=>3		//设定边界显示的页码个数，如1,2......21,22，最小为1
	);

	public function __construct($record_count,$limit=10,$parameter='')
	{
		$this->record_count = $record_count; 
		$this->parameter = $parameter;
		$this->limit = $limit;
		$this->page_count = ceil($this->record_count/$this->limit);
		$this->current_page = min(!empty($_GET['p'])&&($_GET['p']>0) ? $_GET['p']:1, $this->page_count);

		$this->offset = $this->limit*($this->current_page-1);
		
		$param_str = $_SERVER['QUERY_STRING'];
		if($param_str) {
			$param_str = ereg_replace("(^|&)p=([0-9]{1,})","",$param_str);
			if($param_str) {
				$this->pre_url = '?'.$param_str.'&p=';
			}
			else{
				$this->pre_url = '?p=';
			}
		}
		else{
			$this->pre_url = '?p=';
		}
	}

	public function setConfig($name,$value) {
		if(isset($this->config[$name])) {
			$this->config[$name] = $value;
		}
		$this->config['show_num'] = max(3,$this->config['show_num']);
		$this->config['side_num'] = max(1,$this->config['side_num']);
	}

	function showJsNavi()
	{
		//页面风格：共 9 条/ 2 页，当前第 1 页    |<  <  >  >|
		//链接地址为：javascript:getPage(1);
		if($this->record_count<=0) return;
	
		$pagenav = '共 '.$this->record_count.' 条/ '.$this->page_count.' 页，当前第 '.$this->current_page.' 页&nbsp;&nbsp;&nbsp;&nbsp;';
		if($this->page_count<=1){
			return $pagenav;
		}
		if($this->current_page>1){
			$pagenav .= '<a href="javascript:getPage(1);" target="_self">'.$this->config['first'].'</a>&nbsp;&nbsp;';
			$pagenav .= '<a href="javascript:getPage('.($this->current_page-1).');" target="_self">'.$this->config['prev'].'</a>&nbsp;&nbsp;';
		}
		else{
			$pagenav .= $this->config['first'].'&nbsp;&nbsp;';
			$pagenav .= $this->config['prev'].'&nbsp;&nbsp;';
		}
		if($this->current_page!=$this->page_count) {
			$pagenav .= '<a href="javascript:getPage('.($this->current_page+1).');" target="_self">'.$this->config['next'].'</a>&nbsp;&nbsp;';
			$pagenav .= '<a href="javascript:getPage('.$this->page_count.');" target="_self">'.$this->config['last'].'</a>';
		}
		else
		{
			$pagenav .= $this->config['next'].'&nbsp;&nbsp;';
			$pagenav .= $this->config['last'];
		}
		return $pagenav;
	}

	function showMultiNavi()
	{
		//页码风格：1 2 ... 11 12 13 14 15 16 17 ... 21 22
		if($this->record_count<=0) return;
	
		$pagenav = '<table class="paginator" width="100%"><tr>';
		
		if($this->page_count>1){
			$pagenav .= '<td class="a_left">';

			if($this->current_page>1){
				$pagenav .= '<a href="'.$this->pre_url.'1">'.$this->config['first'].'</a>&nbsp;&nbsp;';
				$pagenav .= '<a href="'.$this->pre_url.($this->current_page-1).'">'.$this->config['prev'].'</a>&nbsp;&nbsp;';
			}
			else{
				$pagenav .= $this->config['first'].'&nbsp;&nbsp;';
				$pagenav .= $this->config['prev'].'&nbsp;&nbsp;';
			}
			if($this->page_count < $this->config['show_num']){
				for($i=1;$i<$this->page_count+1;$i++){
					if($i==$this->current_page){
						$pagenav .= ''.$i.'&nbsp;&nbsp;';
					}
					else{
						$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
					}
				}
			}
			else{
				if($this->current_page <= $this->config['side_num']+floor($this->config['show_num']/2)+1){
					for($i=1;$i<max(1,$this->current_page-floor($this->config['show_num']/2));$i++){
						if($i==$this->current_page){
							$pagenav .= ''.$i.'&nbsp;&nbsp;';
						}
						else{
							$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
						}
					}
				}
				else{
					for($i=1;$i<$this->config['side_num']+1;$i++){
						if($i==$this->current_page){
							$pagenav .= ''.$i.'&nbsp;';
						}
						else{
							$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
						}
					}
					$pagenav .= '<span class="dot">...</span>&nbsp;&nbsp;';
				}
				for($i=max(1,$this->current_page-floor($this->config['show_num']/2));$i<min($this->current_page+ceil($this->config['show_num']/2),$this->page_count+1);$i++){
					if($i==$this->current_page){
						$pagenav .= ''.$i.'&nbsp;&nbsp;';
					}
					else{
						$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
					}
				}
				if($this->current_page >= $this->page_count-$this->config['side_num']-ceil($this->config['show_num']/2)+1){
					for($i=min($this->current_page+$this->config['show_num']-$this->config['side_num']-1,$this->page_count+1);$i<$this->page_count+1;$i++){
						if($i==$this->current_page){
							$pagenav .= ''.$i.'&nbsp;&nbsp;';
						}
						else{
							$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
						}
					}
				}
				else{
					$pagenav .= '<span class="dot">...</span>&nbsp;&nbsp;';
					for($i=$this->page_count-$this->config['side_num']+1;$i<$this->page_count+1;$i++){
						if($i==$this->current_page){
							$pagenav .= ''.$i.'&nbsp;&nbsp;';
						}
						else{
							$pagenav .= '<a href="'.$this->pre_url.$i.'">'.$i.'</a>&nbsp;&nbsp;';
						}
					}
				}
			}
			if($this->current_page!=$this->page_count) {
				$pagenav .= '<a href="'.$this->pre_url.($this->current_page+1).'">'.$this->config['next'].'</a>&nbsp;&nbsp;';
				$pagenav .= '<a href="'.$this->pre_url.$this->page_count.'">'.$this->config['last'].'</a>';
			}
			else
			{
				$pagenav .= $this->config['next'].'&nbsp;&nbsp;';
				$pagenav .= $this->config['last'];
			}


			$pagenav .= '</td>';
		}
		$pagenav .= '<td class="a_right">共 '.$this->record_count.' 条记录，'.$this->page_count.' 页</td>';
		$pagenav .= '</tr></table>';

		return $pagenav;
	}
}
?>