<?php
/**
 * CoopMedia.cls.php
 * Generated by BaseClassGen
 * @copyright bokee dot com
 * created at August 12, 2005, 13:22:37
 */

require_once('sql/DAO.cls.php');
require_once('lang/Assert.cls.php');
require_once('com/Log.cls.php');

class CoopMedia
{
	//Properties
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
	var $_linkman;
	/**
	* @access private
	*/
	var $_phone;
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
	function GetUrl()
	{
		return $this->_url;
	}
	/**
	* @access public
	*/
	function SetUrl($value)
	{
		$this->_url = $value;
	}
	/**
	* @access public
	*/
	function GetLinkman()
	{
		return $this->_linkman;
	}
	/**
	* @access public
	*/
	function SetLinkman($value)
	{
		$this->_linkman = $value;
	}
	/**
	* @access public
	*/
	function GetPhone()
	{
		return $this->_phone;
	}
	/**
	* @access public
	*/
	function SetPhone($value)
	{
		$this->_phone = $value;
	}
	/**
	* @access public
	* @param array $row
	*/
	function CoopMedia($row = null)
	{
		if(empty($row))
		{
			$this->SetName("");
			$this->SetUrl("");
			$this->SetLinkman("");
			$this->SetPhone("");
		}
		else 
		{
			$this->_row = $row;
			$this->_id = $this->_row["id"];
			$this->SetName($this->_row['name']);
			$this->SetUrl($this->_row['url']);
			$this->SetLinkman($this->_row['linkman']);
			$this->SetPhone($this->_row['phone']);
		}
		$this->_dao = DAO::CreateInstance();
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
		$get_clause = "select * from coop_media where id=$this->_id";
		$this->_row=$this->_dao->GetRow($get_clause);
		if(!$this->_row)
			return false;
		$this->SetName($this->_row['name']);
		$this->SetUrl($this->_row['url']);
		$this->SetLinkman($this->_row['linkman']);
		$this->SetPhone($this->_row['phone']);
		return true;
	}
	/**
	* @access public
	* @return bool
	*/
	function Update()
	{
		echo $update_clause = "update coop_media set 
		name = '$this->_name',
		url = '$this->_url',
		linkman = '$this->_linkman',
		phone = '$this->_phone'
		where id='$this->_id'
		";
		return $this->_dao->Update($update_clause);
	}
	/**
	* @access public
	* @return  bool
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
		$delete_clause = "delete from coop_media where id= $this->_id";
		return $this->_dao->Query($delete_clause);
	}
	/**
	* @access public
	* @return int
	*/
	function Insert()
	{
		$insert_clause = "insert into coop_media set 
		name = '$this->_name',
		url = '$this->_url',
		linkman = '$this->_linkman',
		phone = '$this->_phone'
		";
		Log::Append($insert_clause);
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