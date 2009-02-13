<?PHP
/** 
 * @Create in 2009/02/13 11:28:24
 * @Smarty Version 2.6.18
 * 
 */
 
class Rsync_Host
{	
	var $ID;
	var $Name;
	var $Host;
	var $Path;
	var $Description;

	var $table_name = 'Rsync_Host';
	var $key = 'ID';
	var $debug = False ;	
	
	function Rsync_Host() // initialize
	{
		$this->ID = null;	
		$this->Name = null;	
		$this->Host = null;	
		$this->Path = null;	
		$this->Description = null;	
	}

	function Rsync_Host_Default() // get Default
	{
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this->Rsync_Host_Default(); // get Default

		$iName = $this->getName();
		$iHost = $this->getHost();
		$iPath = $this->getPath();
		$iDescription = $this->getDescription();

		if(isset($iName)||isset($iHost)||isset($iPath)||isset($iDescription))
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(`Name`,`Host`,`Path`,`Description`)";
			$sql .= " VALUES('".addslashes($iName)."','".addslashes($iHost)."','".addslashes($iPath)."','".addslashes($iDescription)."')";
			
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
		$iName = $this->getName();		
		$iHost = $this->getHost();		
		$iPath = $this->getPath();		
		$iDescription = $this->getDescription();		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
			
			if(isset($iName)) { $sql .= "`Name`='".addslashes($iName)."',"; }
			
			if(isset($iHost)) { $sql .= "`Host`='".addslashes($iHost)."',"; }
			
			if(isset($iPath)) { $sql .= "`Path`='".addslashes($iPath)."',"; }
			
			if(isset($iDescription)) { $sql .= "`Description`='".addslashes($iDescription)."',"; }

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
		
	
	// Property  " Host "  Start ....
	function setHost($input) // Host set
	{
		if($this->Host = trim($input)) { return true; }
	}
		
	function getHost() // Host Get
	{
		if(isset($this->Host)) { return $this->Host; }
	}	
	// Property  " Host "  End ....  
		
	
	// Property  " Path "  Start ....
	function setPath($input) // Path set
	{
		if($this->Path = trim($input)) { return true; }
	}
		
	function getPath() // Path Get
	{
		if(isset($this->Path)) { return $this->Path; }
	}	
	// Property  " Path "  End ....  
		
	
	// Property  " Description "  Start ....
	function setDescription($input) // Description set
	{
		if($this->Description = trim($input)) { return true; }
	}
		
	function getDescription() // Description Get
	{
		if(isset($this->Description)) { return $this->Description; }
	}	
	// Property  " Description "  End ....  
		

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