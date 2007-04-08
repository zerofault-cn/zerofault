<?php
/*
 * ��ҳ��ʾ��
 * PageItem.php��v 1.0.2
 * ��̣�Boban<boban@21php.com>
 * ���ۣ�http://www.21php.com/forums/
 * ���£�2004-06-01  
 * ˵����
 * 1. ���MYSQL���ݿ�ʹ��
 * 2. ��û���ṩ�������ݿ�Ĺ��ܣ������ⲿ�������ݿ����ӡ�
 * */
/*
 * ʹ�÷�����
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
    var $iDefaultRecords = 10; // Ĭ��ÿҳ��ʾ��¼�������û�����ã���ʹ��Ĭ��ֵ    
    var $iMaxRecord; //ÿҳ��¼��
    var $iTotal; //��¼����
    var $sqlRecord; // ��ȡ��¼��SQL��ѯ
    var $iPages; //��ҳ��  
    var $CPages; //��ǰҳ��
    /*
	 * ���캯�� ���� ��ʼ������
	 * ������SQL��ѯ��䣬������LIMIT���
	 * */

    function PageItem($sql = "")
    { 
        // register_shutdown_function($this->_PageItem());
        if(!@mysql_ping()) 
        {
        	echo "������Ҫ�����⽨��MySQL���ݿ�����";
        	exit;
        }        
        /*
     	 * ����SQL���
     	 * */
        if ($sql <> "") {
            list($sql,$limit) = spliti("LIMIT", $sql); 
            // ����LIMIT���,��������ˣ�����limit����ļ�¼Ϊ��ҳ�ļ�¼��
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
   	 * �������� -- ��ʱ������
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
   	 * ͳ��ƥ��ļ�¼����
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
	 * ��ȡ��¼
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
    	// ��Щ���������õ�ServerName�����õĲ�ͬ����Ҫ��������
        $phpself = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        
        $querystring = $_SERVER['QUERY_STRING'];
        $querystring = preg_replace("/page=[0-9]*&?/i", "", $querystring);
        $link = $phpself . "?page=$page&" . $querystring;
        return $link;
    } 

    /* 
	 * ��ʾ��ǰҳ����ҳ��   
	 * */
    function PageNav()
    {
        echo "��" . $this->CPages . "ҳ/��" . $this->iPages . "ҳ";
    } 

    /* 
 	 * ��ʾ��ҳ��ť��������ҳ����ҳ����ҳ��δҳ
 	 * */

    function PageButton()
    {
        if ($this->CPages > 1) {
            echo $this->LinktoPage(1, "��ҳ");
            echo " | ";
            echo $this->LinktoPage($this->CPages-1, "��һҳ");
        } else {
            echo "��ҳ | ��һҳ";
        } 

        if ($this->CPages < $this->iPages) {
            echo " | ";
            echo $this->LinktoPage($this->CPages + 1, "��һҳ");
            echo " | ";
            echo $this->LinktoPage($this->iPages, "��ҳ");
        } else {
            echo " | ��һҳ | βҳ";
        } 
    } 
    /* 
 	 * ��ʾ��תҳѡ���
 	 * */

    function SelectItem()
    {
        echo "&nbsp;&nbsp;������<SELECT name='topage' size='1' onchange='window.location=this.value'>&nbsp;&nbsp;\n";
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
   	 * һ������ʾ���а�ť���
   	 * */
    function myPageItem()
    {
        $this->PageButton();
        $this->SelectItem();
        $this->PageNav();
    } 
} // �����

?>   
 