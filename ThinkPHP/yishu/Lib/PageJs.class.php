<?php
class PageJs extends Base{
	protected $firstRow;
	protected $listRows;
	protected $parameter;
	protected $totalPages;
	protected $totalRows;
	protected $nowPage    ;
	protected $coolPages   ;
	protected $rollPage   ;


	protected $config   =   array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页');

	public function __construct($totalRows,$listRows='',$parameter='')
	{
		$this->totalRows = $totalRows;
		$this->parameter = $parameter;
		$this->listRows = !empty($listRows)?$listRows:C('LIST_NUMBERS');
		$this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
		$this->coolPages  = ceil($this->totalPages/$this->rollPage);
		$this->nowPage  = !empty($_GET[C('VAR_PAGE')])&&($_GET[C('VAR_PAGE')] >0)?$_GET[C('VAR_PAGE')]:1;

		if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
			$this->nowPage = $this->totalPages;
		}
		$this->firstRow = $this->listRows*($this->nowPage-1);
	}

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }



	function show()
	{
		if(0 == $this->totalRows) return;
	
		$prepg = $this->nowPage-1; //上一页
		$nextpg=($this->nowPage==$this->totalPages ? 0 : $this->nowPage+1); //下一页
		$pagenav="显示第 <b>".($this->firstRow+1)."</b>—<b>".min($this->firstRow+$this->listRows,$this->totalRows)."</b> 条记录，共 <b>".$this->totalRows."</b> 条记录<br>";
		$pagenav.=' <a href="javascript:getPage(1);" target="_self">'.$this->config['first'].'</a> ';
		if($prepg) 
		{
			$pagenav.=' <a href="javascript:getPage('.$prepg.');" target="_self">'.$this->config['prev'].'</a> ';
		}
		else
		{
			$pagenav.= $this->config['prev'];
		}
		if($nextpg) 
		{
			$pagenav.=' <a href="javascript:getPage('.$nextpg.');" target="_self">'.$this->config['next'].'</a> ';
		}
		else
		{
			$pagenav.= $this->config['next'];
		}
		$pagenav.=' <a href="javascript:getPage('.$this->totalPages.');" target="_self">'.$this->config['last'].'</a> ';
		return $pagenav;
	}
}
?>