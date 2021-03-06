<?php
/*
 * 分页显示类
 * PageItem.php　v 1.0.2
 * 编程：Boban<boban@21php.com>
 * 讨论：http://www.21php.com/forums/
 * 更新：2004-06-01  
 * 说明：
 * 1. 配合MYSQL数据库使用
 * 2. 类没有提供连接数据库的功能，需在外部建立数据库连接。
 * */
/*
 * 使用方法：
 * $sql = "select * from news limit 0,10";
 * $hdc = new PageItem($sql);
 * echo $hdc->myPageItem();
 * $arrRecords = $hdc->ReadList();
 * */
if (!defined("_BB_PAGEITEM_")) {
    define("_BB_PAGEITEM_", 1);
} 
else return; 

class PageItem {
    var $iDefaultRecords = 15; // 默认每页显示记录数，如果没有设置，就使用默认值    
    var $iMaxRecord; //每页记录数
    var $iTotal; //记录总数
    var $sqlRecord; // 获取记录的SQL查询
    var $iPages; //总页数  
    var $CPages; //当前页数
    /*
	 * 构造函数 －－ 初始化变量
	 * 参数：SQL查询语句，将忽略LIMIT语句
	 * */

    function PageItem($sql = "")
    { 
        // register_shutdown_function($this->_PageItem());
        if(!@mysql_ping()) 
        {
        	echo "本类需要在类外建立MySQL数据库连接";
        	exit;
        }        
        /*
     	 * 解析SQL语句
     	 * */
        if ($sql <> "") {
            list($sql,$limit) = spliti("LIMIT", $sql); 
            // 分析LIMIT语句,如果设置了，则以limit后面的记录为分页的记录数
            list($cnt1,$cnt2) = explode(",",$limit);
            if(!empty($cnt2))	$this->SetMaxRecord($cnt2);
            elseif(!empty($cnt1)) $this->SetMaxRecord($cnt1);

            unset($cnt1);
            unset($cnt2);
            
            $this->sqlRecord = trim($sql);
            list(, $sql) = spliti("FROM", $sql);
            $sql = trim($sql);
			if(preg_match ("/\bGROUP\b \bBY\b/i", $sql))
			{
				if(preg_match ("/\bHAVING\b/i", $sql))	list(,$field) = spliti("HAVING",$sql);
				list($field) = spliti(' ',trim($field));
				$this->iTotal = $this->CountRecord("SELECT $field,COUNT(DISTINCT $field) AS cnt FROM " . $sql,2);
			}
			else	$this->iTotal = $this->CountRecord("SELECT COUNT(*) AS cnt FROM " . $sql,1);
        } 
        if($this->iMaxRecord<=0) $this->SetMaxRecord($this->iDefaultRecords);
        $this->iPages = ceil($this->iTotal / $this->iMaxRecord);
        $this->CPages = $_REQUEST['page'];
        if ($this->CPages <= 0) $this->CPages = 1;
        if ($this->CPages > $this->iPages) $this->CPages = $this->iPages;
    } 
    /*
   	 * 析构函数 -- 暂时不可用
   	 * */
    function _PageItem()
    { 
        // $this->linkid = NULL;
    } 

    function SetMaxRecord($cnt)
    {
        $this->iMaxRecord = $cnt;
    } 

    /*
   	 * 统计匹配的记录总数
   	 * */
    function CountRecord($sql,$type)
    {
		if($type == 1)
		{
			if (($records = mysql_query($sql)) && ($record = mysql_fetch_assoc($records))) {
				return $record['cnt'];
			} else return 0;
		}
		elseif($type == 2)
		{
			if($records = mysql_query($sql))
				return mysql_affected_rows();
		}
    } 
	/* 
	 * 读取记录
	 * */
	function GetRecord()
	{
		$ret = array();
		$this->sqlRecord.=" LIMIT ".($this->CPages-1)*$this->iMaxRecord.",".$this->iMaxRecord;
		$records = mysql_query($this->sqlRecord);
		if(!$records) return;
		while($record = mysql_fetch_array($records))
		{
			$ret[] = $record;
		}
		return $ret;
	}

    function LinktoPage($page, $msg)
    {
        $link = $this->PageUrl($page);
        return "<A href=\"$link\">$msg</A>\n";
    } 
    function PageUrl($page)
    {
    	// 有些服务器设置的ServerName跟常用的不同，需要更改这里
        $phpself = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        $phpself ='';
        $querystring = $_SERVER['QUERY_STRING'];
        $querystring = preg_replace("/page=[0-9]*&?/i", "", $querystring);
        $link = $phpself . "?page=$page&" . $querystring;
        return $link;
    } 

    /* 
	 * 显示当前页及总页数   
	 * */
    function PageNav()
    {
        echo "第" . $this->CPages . "页/共" . $this->iPages . "页";
    } 

    /* 
 	 * 显示翻页按钮，包括首页、下页、上页、未页
 	 * */

    function PageButton()
    {
        if ($this->CPages > 1) {
            echo $this->LinktoPage(1, "首页");
            echo " | ";
            echo $this->LinktoPage($this->CPages-1, "上一页");
        } else {
            echo "首页 | 上一页";
        } 

        if ($this->CPages < $this->iPages) {
            echo " | ";
            echo $this->LinktoPage($this->CPages + 1, "下一页");
            echo " | ";
            echo $this->LinktoPage($this->iPages, "首页");
        } else {
            echo " | 下一页 | 尾页";
        } 
    } 
    /* 
 	 * 显示跳转页选择框
 	 * */

    function SelectItem()
    {
        echo "&nbsp;&nbsp;跳到第<SELECT name='topage' size='1' onchange='window.location=this.value'>&nbsp;&nbsp;\n";
        for($i = 1;$i <= $this->iPages;$i++) {
            if ($this->CPages == $i)
                $extra = "selected";
            else
                $extra = "";
            echo "<OPTION VALUE='" . $this->PageUrl($i) . "' $extra>$i</OPTION>";
        } 
        echo "</SELECT>\n";
    } 

    /*
   	 * 一次性显示所有按钮组件
   	 * */
    function myPageItem()
    {
        $this->PageButton();
        $this->SelectItem();
        $this->PageNav();
    } 
} // 类结束

?>   
 