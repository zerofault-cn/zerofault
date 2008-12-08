<?php
/**
 * ArticleGroup.cls.php
 * @author yudunde@bokee.com
 * @copyright bokee dot com
 * created at October 26, 2005, 13:22:37
 */

include_once('sql/DAO.cls.php');
include_once('lang/Assert.cls.php');
require_once('com/Log.cls.php');

class ArticleGroup
{
	//Properties
	var $_row;
	/**
	* @access private
	*/
	var $_id;
	/**
	* @access private
	*/
	var $_name;
	/**
	* @access private
	*/
	var $_url;
	/**
	* @access private
	*/
	var $_create_time;
	/**
	* @access private
	*/
	var $_category;
	var $_subject_id;
	
	//Methods
	/**
	* @access public
	*/
	function GetId()
	{
		return $this->_id;
	}
	/**
	* @access public
	*/
	function SetId($value)
	{
		$this->_id = $value;
	}
	/**
	* @access public
	*/
	function GetName()
	{
		return $this->_name;
	}
	/**
	* @access public
	*/
	function SetName($value)
	{
		$this->_name = $value;
	}
	/**
	* @access public
	*/
	function SetUrl($value)
	{
		$this->_url = $value;
	}
	function GetUrl()
	{
		return $this->_url;
	}
	/**
	* @access public
	*/
	function GetCreateTime()
	{
		return $this->_create_time;
	}
	/**
	* @access public
	*/
	function SetCreateTime($value)
	{
		$this->_create_time = $value;
	}
	function GetCategory()
	{
		return $this->_category;
	}
	function SetCategory($value)
	{
		$this->_category = $value;
		return true;
	}
	function GetSubjectId()
	{
		return $this->_subject_id;
	}
	function SetSubjectId($value)
	{
		$this->_subject_id = $value;
		return true;
	}
	/**
	* @access public
	* @param string $channel_db
	* @param array $row;
	*/
	function ArticleGroup($channel_db, $row = null)
	{
		if(empty($row))
		{
			$this->SetName("");
			$this->SetUrl("");
			$this->SetCreateTime(date('Y-m-d H:i:s'));
			$this->SetCategory('article');
			$this->SetSubjectId(0);
		}
		else 
		{
			$this->_row = $row;
			$this->InitUseRow();
		}
		$this->_db = $channel_db;
		$this->_dao = DAO::CreateInstance();
        $this->_dao->SetCurrentSchema($this->_db);
	}
	function InitUseRow()
	{
		$this->SetName($this->_row['name']);
		$this->SetUrl($this->_row['url']);
		$this->SetCreateTime($this->_row['create_time']);
		$this->SetCategory($this->_row['category']);
		$this->SetSubjectId($this->_row['subject_id']);
	}
	/**
	* @access public 
	* @return bool
	*/
	function Get()
	{
		if($this->_id>0)
		{
			return $this->GetByID($this->_id);
		}
		else 
		{
			return false;
		}
	}
	/**
	* @access public
	* @param int $id
	* @return bool
	*/
	function GetByID($id)
	{
		$this->_id = intval($id);
		$get_clause = "select * from article_group where id=$this->_id";
		$this->_row=$this->_dao->GetRow($get_clause);
		if(!$this->_row)
			return false;
		$this->InitUseRow();
		return true;
	}
	/**
	* @access public
	* @return bool
	*/
	function Update()
	{
		$update_clause = "update article_group set 
		name = '$this->_name',
		url = '$this->_url',
		create_time = '$this->_create_time',
		category = '$this->_category',
		subject_id = $this->_subject_id
		where id=$this->_id
		";
		return $this->_dao->Update($update_clause);
	}
	/**
	* @access public
	* @return bool
	*/
	function Delete()
	{
		if($this->_id>0)
		{
			return $this->DeleteByID($this->_id);
		}
		else 
		{
			return false;
		}
	}
	/**
	* @access public
	* @param int $id
	* @return bool
	*/
	function DeleteByID($id)
	{
		$this->_id = intval($id);
		$delete_clause = "delete from article_group where id= $this->_id";
		return $this->_dao->Query($delete_clause);
	}
	/**
	* @access public
	* @return int
	*/
	function Insert()
	{		
		$insert_clause = "insert into article_group set 
		name = '$this->_name',
		url = '$this->_url',
		create_time = '" . date('Y-m-d H:i:s') . "',
		category = '$this->_category',
		subject_id = $this->_subject_id
		";
		//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近sql:" . $insert_clause);
		if($this->_dao->Insert($insert_clause))
		{ 
			return $this->_dao->LastID();
		}
		else 
		{
			return -1;
		}
	}
}
?>