<?PHP
/** 
 * @Create in 2009/02/13 11:28:24
 * @Smarty Version 2.6.18
 * 
 */
 
class Admin_User
{	
	var $ID;
	var $Type;
	var $Role;
	var $Username;
	var $Password;
	var $PassValidate;
	var $PassChangeTime;
	var $Name;
	var $EMail;
	var $Memo;
	var $CreateTime;
	var $LastLoginTime;
	var $LastLoginIP;

	var $table_name = 'Admin_User';
	var $key = 'ID';
	var $debug = False ;	
	
	function Admin_User() // initialize
	{
		$this->ID = null;	
		$this->Type = null;	
		$this->Role = null;	
		$this->Username = null;	
		$this->Password = null;	
		$this->PassValidate = null;	
		$this->PassChangeTime = null;	
		$this->Name = null;	
		$this->EMail = null;	
		$this->Memo = null;	
		$this->CreateTime = null;	
		$this->LastLoginTime = null;	
		$this->LastLoginIP = null;	
	}

	function Admin_User_Default() // get Default
	{
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this->Admin_User_Default(); // get Default

		$iType = $this->getType();
		$iRole = $this->getRole();
		$iUsername = $this->getUsername();
		$iPassword = $this->getPassword();
		$iPassValidate = $this->getPassValidate();
		$iPassChangeTime = $this->getPassChangeTime();
		$iName = $this->getName();
		$iEMail = $this->getEMail();
		$iMemo = $this->getMemo();
		$iCreateTime = $this->getCreateTime();
		$iLastLoginTime = $this->getLastLoginTime();
		$iLastLoginIP = $this->getLastLoginIP();

		if(isset($iType)||isset($iRole)||isset($iUsername)||isset($iPassword)||isset($iPassValidate)||isset($iPassChangeTime)||isset($iName)||isset($iEMail)||isset($iMemo)||isset($iCreateTime)||isset($iLastLoginTime)||isset($iLastLoginIP))
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(`Type`,`Role`,`Username`,`Password`,`PassValidate`,`PassChangeTime`,`Name`,`EMail`,`Memo`,`CreateTime`,`LastLoginTime`,`LastLoginIP`)";
			$sql .= " VALUES('".addslashes($iType)."','".addslashes($iRole)."','".addslashes($iUsername)."','".addslashes($iPassword)."','".addslashes($iPassValidate)."','".addslashes($iPassChangeTime)."','".addslashes($iName)."','".addslashes($iEMail)."','".addslashes($iMemo)."','".addslashes($iCreateTime)."','".addslashes($iLastLoginTime)."','".addslashes($iLastLoginIP)."')";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql,"Add one record");
			}

			if($db->Execute($sql)) {// exec sql statement
				return $db->Insert_ID();
			}
			else { return false; }	
		}
		else{ return false; }
	}
	

	// View one record from table
	function View($input=null) 
	{
		if(isset($input)&&trim($input)!='') {
			global $db;
			$sql = "select * from `$this->table_name` where `$this->key` = '$input'";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "View one record");
			}
			
			$rs = $db->Execute($sql); // exec sql statement
			
			if($rs->RecordCount()) {
				$arr = $rs->FetchRow();
				foreach($arr as $key => $value) {
					$tmp = 'set'.$key;
					$this->$tmp($value);
					/*
					if($this->$tmp($value))
					{
						$arr[$key] = AddSlashes($value);
					}
					*/
				}
				return $arr ;
			}
			else { return false; }			
		}
	}
	
	
	// Delete one record from table
	function Del($input) 
	{
		global $db;
		if(isset($input)) {
			$sql = "delete from `$this->table_name` where `$this->key` = '$input'";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "Delete one record");
			}
			
			$rs = $db->Execute($sql); // exec sql statement
			
			if($rs) { return true; }
		}
		return false;
	}


	// Delete one record from table with option
	function DelOpt($option='') 
	{
		global $db;
		if(trim($option)!='') {
			$sql = "delete from `$this->table_name` where $option";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "Delete one record");
			}
			
			$rs = $db->Execute($sql); // exec sql statement
			
			if($rs) { return true; }
		}
		return false;
	}

	
	// Browse Records
	function Browse($option='',$row=-1,$start=0) 
	{
		global $db;
		$sql = "select * from `$this->table_name` ";
		if(trim($option)!='') { $sql .= $option; }
		
		if($this->debug) {// print sql for debug
			$this->ShowSQL($sql, "Browse Records");
		}
		
		$rs = $db->SelectLimit($sql,$row,$start); // exec sql statement 
		
		if($rs->RecordCount()) {
			$arr = $rs->GetRows();
		
			$key = array_keys($arr[0]);
			
			for($i=0;$i<count($arr);$i++) {
				for($j=0;$j<count($key);$j++) {
					$newkey = $key[$j];
					$Newarr[$newkey][]= $arr[$i][$newkey];
				}
			}
			return $Newarr;
		}
		else { return null; }
	}


	// Update one record from table
	function Update($input) 
	{
		global $db;		
		
		$iID = $this->getID();		
		$iType = $this->getType();		
		$iRole = $this->getRole();		
		$iUsername = $this->getUsername();		
		$iPassword = $this->getPassword();		
		$iPassValidate = $this->getPassValidate();		
		$iPassChangeTime = $this->getPassChangeTime();		
		$iName = $this->getName();		
		$iEMail = $this->getEMail();		
		$iMemo = $this->getMemo();		
		$iCreateTime = $this->getCreateTime();		
		$iLastLoginTime = $this->getLastLoginTime();		
		$iLastLoginIP = $this->getLastLoginIP();		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
			
			if(isset($iType)) { $sql .= "`Type`='".addslashes($iType)."',"; }
			
			if(isset($iRole)) { $sql .= "`Role`='".addslashes($iRole)."',"; }
			
			if(isset($iUsername)) { $sql .= "`Username`='".addslashes($iUsername)."',"; }
			
			if(isset($iPassword)) { $sql .= "`Password`='".addslashes($iPassword)."',"; }
			
			if(isset($iPassValidate)) { $sql .= "`PassValidate`='".addslashes($iPassValidate)."',"; }
			
			if(isset($iPassChangeTime)) { $sql .= "`PassChangeTime`='".addslashes($iPassChangeTime)."',"; }
			
			if(isset($iName)) { $sql .= "`Name`='".addslashes($iName)."',"; }
			
			if(isset($iEMail)) { $sql .= "`EMail`='".addslashes($iEMail)."',"; }
			
			if(isset($iMemo)) { $sql .= "`Memo`='".addslashes($iMemo)."',"; }
			
			if(isset($iCreateTime)) { $sql .= "`CreateTime`='".addslashes($iCreateTime)."',"; }
			
			if(isset($iLastLoginTime)) { $sql .= "`LastLoginTime`='".addslashes($iLastLoginTime)."',"; }
			
			if(isset($iLastLoginIP)) { $sql .= "`LastLoginIP`='".addslashes($iLastLoginIP)."',"; }

			$sql = substr($sql,0,(strlen($sql)-1));
			
			$sql .= " where `$this->key` = '$input' ";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "Update one record from table");
			}
		
			if($db->Execute($sql)) {// exec sql statement 
				return true ;
			}
			else{ return false; }
		}
		else{ return false; }			
	}
	
	
	// Count Records
	function RecordCount($option='') 
	{
		global $db;
		$sql = "select count(`ID`) as `RecNum` from `$this->table_name` ";
		if(trim($option)!='') { $sql .= $option; }
			
		if($this->debug) {// print sql for debug
			$this->ShowSQL($sql,"Count Records");
		}
		
		$rs = $db->Execute($sql); // exec sql statement 
		
		if($rs->RecordCount()) {
			$arr = $rs->FetchRow();
			return $arr['RecNum'];
		}
		//else { return null; }
		else { return 0; }
	}
	
	
	// Change one fields from one record 
	function ChangeOne($input='',$field='',$value='') 
	{
		global $db; 
		if(trim($input)!='' && trim($field)!='') {
			$sql = "UPDATE `$this->table_name` SET `$field` = '$value' WHERE `$this->key` = '$input'";
			
			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "Change one fields from one record");
			}
			
			if($db->Execute($sql)) {// exec sql statement 
				return true ;
			}
			else { return false; }	
		}
		else { return false; }
	}


	// Exec custom sql statement
	function Exec($input)  
	{
		global $db;	
			
		if(isset($input)&&$input!='') {
			$sql = $input;

			if($this->debug) {// print sql for debug
				$this->ShowSQL($sql, "Exec custom sql statement ");
			}
			
			$rs = $db->Execute($sql); // exec sql statement 
			if($rs) {
				if($rs->RecordCount()) {
					$arr = $rs->GetRows();
		
					$key = array_keys($arr[0]);
			
					for($i=0;$i<count($arr);$i++) {
						for($j=0;$j<count($key);$j++) {
							$newkey = $key[$j];
							$Newarr[$newkey][]= $arr[$i][$newkey];
						}
					}
					return $Newarr;
				}
				else { return true; }
			}
			else { return false ; }
		}
	}


###############   Property set / Get   ###############

	
	// Property  " ID "  Start ....
	function setID($input) // ID set
	{
		if($this->ID = trim($input)) { return true; }
	}
		
	function getID() // ID Get
	{
		if(isset($this->ID)) { return $this->ID; }
	}	
	// Property  " ID "  End ....  
		
	
	// Property  " Type "  Start ....
	function setType($input) // Type set
	{
		if($this->Type = trim($input)) { return true; }
	}
		
	function getType() // Type Get
	{
		if(isset($this->Type)) { return $this->Type; }
	}	
	// Property  " Type "  End ....  
		
	
	// Property  " Role "  Start ....
	function setRole($input) // Role set
	{
		if($this->Role = trim($input)) { return true; }
	}
		
	function getRole() // Role Get
	{
		if(isset($this->Role)) { return $this->Role; }
	}	
	// Property  " Role "  End ....  
		
	
	// Property  " Username "  Start ....
	function setUsername($input) // Username set
	{
		if($this->Username = trim($input)) { return true; }
	}
		
	function getUsername() // Username Get
	{
		if(isset($this->Username)) { return $this->Username; }
	}	
	// Property  " Username "  End ....  
		
	
	// Property  " Password "  Start ....
	function setPassword($input) // Password set
	{
		if($this->Password = trim($input)) { return true; }
	}
		
	function getPassword() // Password Get
	{
		if(isset($this->Password)) { return $this->Password; }
	}	
	// Property  " Password "  End ....  
		
	
	// Property  " PassValidate "  Start ....
	function setPassValidate($input) // PassValidate set
	{
		if($this->PassValidate = trim($input)) { return true; }
	}
		
	function getPassValidate() // PassValidate Get
	{
		if(isset($this->PassValidate)) { return $this->PassValidate; }
	}	
	// Property  " PassValidate "  End ....  
		
	
	// Property  " PassChangeTime "  Start ....
	function setPassChangeTime($input) // PassChangeTime set
	{
		if($this->PassChangeTime = trim($input)) { return true; }
	}
		
	function getPassChangeTime() // PassChangeTime Get
	{
		if(isset($this->PassChangeTime)) { return $this->PassChangeTime; }
	}	
	// Property  " PassChangeTime "  End ....  
		
	
	// Property  " Name "  Start ....
	function setName($input) // Name set
	{
		if($this->Name = trim($input)) { return true; }
	}
		
	function getName() // Name Get
	{
		if(isset($this->Name)) { return $this->Name; }
	}	
	// Property  " Name "  End ....  
		
	
	// Property  " EMail "  Start ....
	function setEMail($input) // EMail set
	{
		if($this->EMail = trim($input)) { return true; }
	}
		
	function getEMail() // EMail Get
	{
		if(isset($this->EMail)) { return $this->EMail; }
	}	
	// Property  " EMail "  End ....  
		
	
	// Property  " Memo "  Start ....
	function setMemo($input) // Memo set
	{
		if($this->Memo = trim($input)) { return true; }
	}
		
	function getMemo() // Memo Get
	{
		if(isset($this->Memo)) { return $this->Memo; }
	}	
	// Property  " Memo "  End ....  
		
	
	// Property  " CreateTime "  Start ....
	function setCreateTime($input) // CreateTime set
	{
		if($this->CreateTime = trim($input)) { return true; }
	}
		
	function getCreateTime() // CreateTime Get
	{
		if(isset($this->CreateTime)) { return $this->CreateTime; }
	}	
	// Property  " CreateTime "  End ....  
		
	
	// Property  " LastLoginTime "  Start ....
	function setLastLoginTime($input) // LastLoginTime set
	{
		if($this->LastLoginTime = trim($input)) { return true; }
	}
		
	function getLastLoginTime() // LastLoginTime Get
	{
		if(isset($this->LastLoginTime)) { return $this->LastLoginTime; }
	}	
	// Property  " LastLoginTime "  End ....  
		
	
	// Property  " LastLoginIP "  Start ....
	function setLastLoginIP($input) // LastLoginIP set
	{
		if($this->LastLoginIP = trim($input)) { return true; }
	}
		
	function getLastLoginIP() // LastLoginIP Get
	{
		if(isset($this->LastLoginIP)) { return $this->LastLoginIP; }
	}	
	// Property  " LastLoginIP "  End ....  
		

###############  Other Function  ############
	
	// show SQL statement for debug 
	function ShowSQL($zSQL=null,$zFunc=null)
	{
		if(isset($zSQL)&&trim($zSQL)!='') {
			echo '<br><hr><B>Table : </B>' . $this->table_name . '<br>';
			echo '<B>Action : </B>' . $zFunc . '<br>';
			echo '<B>SQL : </B><font color="#FF3300"> ' . $zSQL . ' </font><br><hr>';
		}
	}	
	
}

?>