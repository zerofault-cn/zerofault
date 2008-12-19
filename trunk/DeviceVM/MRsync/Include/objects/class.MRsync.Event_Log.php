<?PHP
/** 
 * @Create in 2008/12/17 10:17:53
 * @Smarty Version 2.6.18
 * 
 */
 
class Event_Log
{	
	var $ID;
	var $ETID;
	var $Timestamp;
	var $Source;
	var $User;
	var $Action;
	var $Info_XML;
	var $Description;

	var $table_name = 'Event_Log';
	var $key = 'ID';
	var $debug = False ;	
	
	function Event_Log() // initialize
	{
		$this->ID = null;	
		$this->ETID = null;	
		$this->Timestamp = null;	
		$this->Source = null;	
		$this->User = null;	
		$this->Action = null;	
		$this->Info_XML = null;	
		$this->Description = null;	
	}

	function Event_Log_Default() // get Default
	{
		if(!isset($this->ETID)) { $this->ETID = '0'; }
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this->Event_Log_Default(); // get Default

		$iETID = $this->getETID();
		$iTimestamp = $this->getTimestamp();
		$iSource = $this->getSource();
		$iUser = $this->getUser();
		$iAction = $this->getAction();
		$iInfo_XML = $this->getInfo_XML();
		$iDescription = $this->getDescription();

		if(isset($iETID)||isset($iTimestamp)||isset($iSource)||isset($iUser)||isset($iAction)||isset($iInfo_XML)||isset($iDescription))
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(`ETID`,`Timestamp`,`Source`,`User`,`Action`,`Info_XML`,`Description`)";
			$sql .= " VALUES(".$iETID.",'".addslashes($iTimestamp)."','".addslashes($iSource)."','".addslashes($iUser)."','".addslashes($iAction)."','".addslashes($iInfo_XML)."','".addslashes($iDescription)."')";
			
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
		$iETID = $this->getETID();		
		$iTimestamp = $this->getTimestamp();		
		$iSource = $this->getSource();		
		$iUser = $this->getUser();		
		$iAction = $this->getAction();		
		$iInfo_XML = $this->getInfo_XML();		
		$iDescription = $this->getDescription();		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
			
			if(isset($iETID)) { $sql .= "`ETID`='".addslashes($iETID)."',"; }
			
			if(isset($iTimestamp)) { $sql .= "`Timestamp`='".addslashes($iTimestamp)."',"; }
			
			if(isset($iSource)) { $sql .= "`Source`='".addslashes($iSource)."',"; }
			
			if(isset($iUser)) { $sql .= "`User`='".addslashes($iUser)."',"; }
			
			if(isset($iAction)) { $sql .= "`Action`='".addslashes($iAction)."',"; }
			
			if(isset($iInfo_XML)) { $sql .= "`Info_XML`='".addslashes($iInfo_XML)."',"; }
			
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
		
	
	// Property  " ETID "  Start ....
	function setETID($input) // ETID set
	{
		if($this->ETID = trim($input)) { return true; }
	}
		
	function getETID() // ETID Get
	{
		if(isset($this->ETID)) { return $this->ETID; }
	}	
	// Property  " ETID "  End ....  
		
	
	// Property  " Timestamp "  Start ....
	function setTimestamp($input) // Timestamp set
	{
		if($this->Timestamp = trim($input)) { return true; }
	}
		
	function getTimestamp() // Timestamp Get
	{
		if(isset($this->Timestamp)) { return $this->Timestamp; }
	}	
	// Property  " Timestamp "  End ....  
		
	
	// Property  " Source "  Start ....
	function setSource($input) // Source set
	{
		if($this->Source = trim($input)) { return true; }
	}
		
	function getSource() // Source Get
	{
		if(isset($this->Source)) { return $this->Source; }
	}	
	// Property  " Source "  End ....  
		
	
	// Property  " User "  Start ....
	function setUser($input) // User set
	{
		if($this->User = trim($input)) { return true; }
	}
		
	function getUser() // User Get
	{
		if(isset($this->User)) { return $this->User; }
	}	
	// Property  " User "  End ....  
		
	
	// Property  " Action "  Start ....
	function setAction($input) // Action set
	{
		if($this->Action = trim($input)) { return true; }
	}
		
	function getAction() // Action Get
	{
		if(isset($this->Action)) { return $this->Action; }
	}	
	// Property  " Action "  End ....  
		
	
	// Property  " Info_XML "  Start ....
	function setInfo_XML($input) // Info_XML set
	{
		if($this->Info_XML = trim($input)) { return true; }
	}
		
	function getInfo_XML() // Info_XML Get
	{
		if(isset($this->Info_XML)) { return $this->Info_XML; }
	}	
	// Property  " Info_XML "  End ....  
		
	
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