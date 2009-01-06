<?php
/**
 * SpecialSubject.cls.php
 * Generated by BaseClassGen
 * @copyright bokee dot com
 * created at August 12, 2005, 13:22:37
 */

include_once('sql/DAO.cls.php');
include_once('lang/Assert.cls.php');

class SpecialSubject
{
	

	//Properties
	/**
	* @access private
	*/
	var $_id;
	/**
	* @access private
	*/
	var $_special_id;
	/**
	* @access private
	*/
	var $_name;
	/**
	* @access private
	*/
	var $_dao;
	/**
	* @access private
	*/
	var $_row;


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
	function GetSpecialId()
	{
		return $this->_special_id;
	}
	/**
	* @access public
	*/
	function SetSpecialId($value)
	{
		$this->_special_id = $value;
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
	* @param string $channel_db
	* @param array $row
	*/
	function SpecialSubject($channel_db, $row = null)
	{
		if(empty($row))
		{
			$this->SetSpecialId(0);
			$this->SetName("");
		}
		else 
		{
			$this->_row = $row;
			$this->SetSpecialId($this->_row['special_id']);
			$this->SetName($this->_row['name']);
		}
		$this->_db = $channel_db;
		$this->_dao = DAO::CreateInstance();
        $this->_dao->SetCurrentSchema($this->_db);
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
		$get_clause = "select * from special_subject where id=$this->_id";
		$this->_row=$this->_dao->GetRow($get_clause);
		if(!$this->_row)
			return false;
		$this->SetSpecialId($this->_row['special_id']);
		$this->SetName($this->_row['name']);
		return true;
	}
	/**
	* @access public
	* @return bool
	*/
	function Update()
	{
		$update_clause = "update special_subject set 
		special_id = $this->_special_id,
		name = $this->_name
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
		$delete_clause = "delete from special_subject where id= $this->_id";
		return $this->_dao->Query($delete_clause);
	}
	/**
	* @access public
	* @return int
	*/
	function Insert()
	{
		$insert_clause = "insert into special_subject set 
		special_id = $this->_special_id,
		name = $this->_name
		";
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