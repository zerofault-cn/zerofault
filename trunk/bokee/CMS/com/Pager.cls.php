<?php
/**
 * Pager.cls.php
 * @copyright bokee dot com
 * @version 0.1
 */
class Pager {
    
    /**
    * url
    * @access private
    * @var string
    */
    var $url = null;
    /**
    * 条目偏移量
    * @access private
    * @var integer
    */
    var $offset = 0;
    /**
    * 条目总数
    * @access private
    * @var integer
    */
    var $itemSum;
    /**
    * 每页的条目数
    * @access private
    * @var integer
    */
    var $pageSize;
    /**
    * 总页数
    * @access private
    * @var integer
    */
    var $pageCount;
    /**
    * 当前页号码
    * @access private
    * @var integer
    */
    var $currentPageNumber;
    /**
    * url中的页码标志符
    * @access private
    * @var string
    */
    var $flag = 'p';
    /**
    * separator : url中的串联记号 (?|&)
    * @access private
    * @var string
    */
    var $separator = '?';
    /**
    * 翻页栏中显示页号的数量
    * @access private
    * @var integer
    */
    var $barNumberCount = 10;
    /**
    * 分页栏页面总数
    */
    var $barPageCount;
    /**
    * 当前的分页栏号
    */
    var $barCurrentPage;
	
	/**
	 * Constructor
	 * @access public
	 * @param string $url
	 * @param integer $itemSum 条目总数
	 * @param integer $pageSize 每页的条目数
	 * @param integer $currentPageNumber 当前页号码
	 * @param string $flag 放置在url中的翻页标识
	 */
	function Pager($url, $itemSum, $pageSize = 10, $currentPageNumber = 1, $flag="p"){
		$this->flag = $flag;
	    if (preg_match('/\?/',$url)) $this->separator = '&';
	    $this->url = $url;
        $this->currentPageNumber = max(1, $currentPageNumber);
        $this->itemSum = $itemSum;
        $this->pageSize = $pageSize;
        $this->pageCount = ceil($itemSum/$pageSize);
        if($this->currentPageNumber > $this->pageCount){
            $this->currentPageNumber = $this->pageCount;
        }
        $this->offset = $pageSize *  ($this->currentPageNumber - 1);
        
	    // 分页栏的总页数 : ceil($this->pageCount/$this->barNumberCount)
	    // 分页栏的当前页数 ： ceil($this->currentPageNumber/$this->barNumberCount)
	    $this->barPageCount = ceil($this->pageCount/$this->barNumberCount);
	    $this->barCurrentPage = ceil($this->currentPageNumber/$this->barNumberCount);
	}		
    /**
     * 返回每页的条目数量
     * @access public
     * @return integer
     */
    function getPageSize(){
        return $this->pageSize;
    }
    /**
    * 返回条目的偏移量
    * @access public
    * @return integer
    */
    function getOffset(){
        return $this->offset;
    }
	/**
	 * 取翻页栏的html页面代码
	 * @access public
	 * @return string
	 */
	function getBar() {
	    $template = '共有记录数:0';
	    if ($this->itemSum == 0) return $template;
	    
	    $first = '&lt;&lt;';
	    $last = '&gt;&gt;';
	    $preceding = '上一页';
	    $following = '下一页';
	    $numberLine = ''; // 页码数字链接
	    
	    // first 
	    // 如果当前页超过 $barNumberCount , 这个链接生效
	    if ($this->currentPageNumber > $this->barNumberCount){
	       $first = '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                '=1">'.$first.'</a>';
	    }
	    // last
	    if ($this->barCurrentPage < $this->barPageCount ){
	        $last = '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                '='.$this->pageCount.'">'.$last.'</a>';
	    }
	    // preceding
	    // 如果当前页不等于1，这个链接生效
	    if ($this->currentPageNumber > 1){
	        $preceding = '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                '='.($this->currentPageNumber - 1).'">'.$preceding.'</a>';
	    }
	    // following
	    // 如果当前页不是最后一页，这个链接生效
	    if ($this->currentPageNumber < $this->pageCount){
	        $following = '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                '='.($this->currentPageNumber + 1).'">'.$following.'</a>';
	    }
	    // page numbers
	    if ( $this->barCurrentPage < $this->barPageCount ){
	        // 有 $this->barNumberCount 个号码
	        $startNumber = ($this->barCurrentPage-1) * $this->barNumberCount + 1;
	        $limitNumber = $startNumber+$this->barNumberCount;
	        for ($i=$startNumber;$i<$limitNumber;$i++){
	            if ($i != $this->currentPageNumber){
	                $numberLine .= '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                   '='.$i.'">'.$i.'</a>';
	            } else {
	                $numberLine .= '&nbsp;<font color="#FF0000">'.$i.'</font>';
	            }
	        }
	    } else {
	        // 有 $this->pageCount-ceil($this->currentPageNumber/$this->barNumberCount) 个页号码
	        $startNumber = ($this->barCurrentPage-1) * $this->barNumberCount + 1;
	        $limitNumber = $startNumber + $this->pageCount - (($this->barCurrentPage-1)*$this->barNumberCount);
	        for ($i=$startNumber;$i<$limitNumber;$i++){
	            if ($i != $this->currentPageNumber){
	                $numberLine .= '&nbsp;<a href="'.$this->url.$this->separator.$this->flag.
	                   '='.$i.'">'.$i.'</a>';
	            } else {
	                $numberLine .= '&nbsp;<font color="#FF0000">'.$i.'</font>';
	            }
	        }
	    }
	    // 模板代码
	    $template = $first.'&nbsp;'.$preceding.'&nbsp;'.$numberLine.'&nbsp;'.
	                $following.'&nbsp;'.$last.'&nbsp;共有记录数：'.$this->itemSum;
	    return $template;
	}
	
}
// ------------------- test -------------- //
//header("Content-Type: text/html;charset=utf-8");
//$page = new Pager('http://zhong/Test/int.php',108,10,$_GET['p']);
//print $page->getBar();
?>