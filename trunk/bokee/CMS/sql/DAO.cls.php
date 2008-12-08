<?
/**
* DAO.cls.php
* @copyright  bokee dot com 
* @abstract  操作MySQL数据库
* @version 0.1
*/
class DAO{
	
    // ----------------- public variable -------------- //
	/**
     * 结果常量 : 选择 schema 失败
     * @access public
     * @staticvar final
     * @var integer
     */    
	var $MYSQL_ERR_SELECT_DB = 101;
	/**
     * 结果常量 : 连接失败 
     * @access public
     * @staticvar final
     * @var integer
     */
	var $MYSQL_ERR_CONNECT = 102;
	/**
     * 结果常量 : 操作成功
     * @access public
     * @staticvar final
     * @var integer
     */
	var $MYSQL_SUCCESS = 100;
	
	// ----------------- private variable ---------------- //
	/**
     * 连接句柄
     * @access private
     * @var resource
     */
	var $connection = null;
	/**
     * 当前的schema
     * @access private
     */
	var $currentSchema = null;

	/**
	@
	*/
	var $assoc = false;
	
	// ------------------- public method -------------- //
	/**
     * 创建一个数据库对象，使用默认连接及数据库
     * @access public
     * @return DAO 数据库操作对象
     */	
	function CreateInstance(){
	    $dao = new DAO();
	    if ($dao->MYSQL_SUCCESS != 
	      $dao->Connect(DB_SCHEMA,DB_USERNAME,DB_PASSWORD,DB_HOST,DB_PORT) ){
            
            // 数据连接失败
            Assert::fail("数据库连接失败 \tat ".__CLASS__.' '.__FUNCTION__.' '.__LINE__);
	  	}
	  	return $dao;
	}
	
	/**
	* @abstract  创建空DAO对象
	* @access public
	*/
	function CreateInstanceEmpty(){
		$dao = new DAO();
		return $dao;
	}
	/**
     * 连接数据库
     * @access public
     * @param string $dbname
     * @param string $dbuser
     * @param string $dbpass
     * @param string $dbhost
     * @return object
     */
	function Connect( $dbschema = '', $dbuser = '', $dbpass = '', 
                                              $dbhost = 'localhost', $dbport = '3306' ){
		if ( ($this->connection = 
		mysql_pconnect($dbhost . ':' . $dbport, $dbuser, $dbpass)) != false ){
			if ( $this->setCurrentSchema($dbschema) == $this->MYSQL_SUCCESS ) {
				return $this->MYSQL_SUCCESS;
			} 
			else {
                return $this->MYSQL_ERR_SELECT_DB;
            }
		} 
		else {
            return $this->MYSQL_ERR_CONNECT;
        }
	}
	/**
     * 设置当前的 schema
     * @access public
     * @param string  $schema
     * @return boolean
     */
	function SetCurrentSchema( $schema ){
	    $this->schema = $schema;
	    if(mysql_select_db($this->schema, $this->connection))
	    {
	    	return $this->MYSQL_SUCCESS;
	    }
	    else 
	    {
	    	mysql_select_db(DB_SCHEMA, $this->connection);
	    	$sql = "select db_host, db_port from channel where dir_name='" . $this->schema . "'";
	    	$row = $this->GetRow($sql);
	    	if($dao->MYSQL_SUCCESS != $this->Connect($this->schema, DB_USERNAME, DB_PASSWORD,$row['db_host'],$row['db_port']))
	    	{
	    		return $dao->MYSQL_SUCCESS;
	    	}
	    	else 
	    	{
	    		return $this->MYSQL_ERR_SELECT_DB;
	    	}
	    }
	}
	/**
     * 取得当前的 schema
     * @access public
     * @return string
     */
	function GetCurrentSchema(){
	    return $this->currentSchema;
	}
	/**
     * 取一个值
     * @access public
     * @param string $sql example : select field_a from table_a Limit 1
     * @return mixed
     */
	function GetOne($sql){
		$row = $this->getRow($sql);	
		return $row[0];
	}
	/**
     * 取一行(一维数组)
     * @access public
     * @param string $sql example : select field_a from table_a Limit 1
     * @return array| false
     */
	function GetRow($sql){
		$rs = $this->query($sql,$this->connection);
		$row = $this->fa($rs);
		mysql_free_Result($rs);
		return $row;
	}
	/**
     * 取一列(一维数组)
     * @access public
     * @param string $sql sql语句
     * @return array
     */
	function GetCol($sql){
		$rs = $this ->query($sql);
		$data = array();
		while( ($row = $this ->fa($rs)) != false ){
			$data[] = $row[0];
		}
		@mysql_free_Result($rs);
		return $data;
	}
	/**
     * 取多行(二维数组)
     * @access public
     * @param string $sql
     * @return array
     */
	function GetPlan($sql){
		$rs = $this ->query($sql);		
		if ( $rs == false ){
		    return false;
		}
		$data = array();
		while( ($row = $this ->fa($rs)) != false ){
			$data[] = $row;
		}
		@mysql_free_Result($rs);
		return $data;
	}
	/**
     * 更新
     * @param string $sql 更新命令
     * @return boolean
     */
	function Update($sql){
	    return @mysql_query($sql, $this->connection);
	}
	/**
     * 插入
     * @param string $sql 插入命令
     * @return boolean
     */
	function Insert($sql){
	    return mysql_query($sql, $this->connection);
	}	
	/**
     * 取得上一步 INSERT 操作产生的 ID
     * @access public
     * @return integer
     */
	function LastID(){
		return mysql_insert_id($this ->connection);
	}
	
	// --------------- 很少使用的 public method ----------------- //
	/**
     * 取得结果集的行数
     * @access public
     * @param resource result set
     */
	function CountResultRows($rs){
		return mysql_num_rows($rs);
	}
	/**
     * 取到最后一次操作所影响的行数
     * @access public
     * @return integer
     */
	function CountAffectedRows(){
		return mysql_affected_rows($this->connection);
	}
	/**
     * 断开连接,在使用mysql_connect函数时使用,
     * 如果用mysql_pconnect连接则无需使用
     * @access public
     * @return boolean
     */
	function Disconnect(){
		return mysql_close($this ->connection);
	}
	
	// ----------------- private method --------------------- //
	/**
    * 执行一条查询命令
    * @access private
    * @param string $sql sql
    * @return resource|boolean
    */
	function Query($sql){
	  return @mysql_query($sql, $this->connection);
	}
	/**
	* 取一行
	* @access private
	* @param resource $rs 结果集
	* @return array
	*/
	function fa($rs){
		if(!$this->assoc)
		{
			return @mysql_fetch_array($rs);
		}
		else
		{
			return @mysql_fetch_assoc($rs);
		}
	}
	
	// ------------- assistant method ----------------- //
	/**
    * 将值转换成SQL可读格式
    * @access public
    * @staitc
    * @return string|integer
    */
    function FormatValue( $theValue, $theType=null ,$slashes='gpc' ) {
        
        // 发现在PHP4.3.6中，quote_gpc 并不如意
        // 如果 quote gpc 没有效果， 则
        // $theValue = addslashes($theValue);
        if ($slashes == 'gpc'){
            $theValue = get_magic_quotes_gpc() ? $theValue : addslashes($theValue);
        } elseif ($slashes == 'rt') {
            $theValue = get_magic_quotes_runtime() ? $theValue : addslashes($theValue);
        }
        
        
               
        if (empty($theType)) 
            $theType = gettype($theValue);
        
        switch ( $theType ) {
            case "integer":
                $theValue = ($theValue === '') ? "NULL"
                                               : intval($theValue) ;
                break;
            case "double":
                $theValue = ($theValue != '') ? "'".doubleval($theValue)."'" 
                                              : "NULL";
                break;
            case "string":
                if ($theValue != "NOW()") {
                    $theValue = "'" . $theValue . "'";
                }
                break;
        	default :
                $theValue = "NULL";
                break;
        }
        Return $theValue;
    }
    /**
    * 格式化SQL成员字段名
    * @access public
    * @static
    * @param string $theField
    * @return string
    */
    function FormatField( $theField ){
        return '`'.$theField.'`';
    }
}
?>