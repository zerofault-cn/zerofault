<?PHP
/** 
 * @Create in 2008/12/17 10:17:53
 * @Smarty Version 2.6.18
 * 
 */
 
class Sync_XML
{	
	var $ID;
	var $UID;
	var $Filename;
	var $Create_Time;
	var $Modify_Time;
	var $status;

	var $table_name = 'Sync_XML';
	var $key = 'ID';
	var $debug = False ;	
	
	function Sync_XML() // initialize
	{
		$this->ID = null;	
		$this->UID = null;	
		$this->Filename = null;	
		$this->Create_Time = null;	
		$this->Modify_Time = null;	
		$this->status = null;	
	}

	function Sync_XML_Default() // get Default
	{
		if(!isset($this->UID)) { $this->UID = '0'; }
		if(!isset($this->status)) { $this->status = '0'; }
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this->Sync_XML_Default(); // get Default

		$iUID = $this->getUID();
		$iFilename = $this->getFilename();
		$iCreate_Time = $this->getCreate_Time();
		$iModify_Time = $this->getModify_Time();
		$istatus = $this->getstatus();

		if(isset($iUID)||isset($iFilename)||isset($iCreate_Time)||isset($iModify_Time)||isset($istatus))
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(`UID`,`Filename`,`Create_Time`,`Modify_Time`,`status`)";
			$sql .= " VALUES(".$iUID.",'".addslashes($iFilename)."','".addslashes($iCreate_Time)."','".addslashes($iModify_Time)."',".$istatus.")";
			
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
		$iUID = $this->getUID();		
		$iFilename = $this->getFilename();		
		$iCreate_Time = $this->getCreate_Time();		
		$iModify_Time = $this->getModify_Time();		
		$istatus = $this->getstatus();		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
			
			if(isset($iUID)) { $sql .= "`UID`='".addslashes($iUID)."',"; }
			
			if(isset($iFilename)) { $sql .= "`Filename`='".addslashes($iFilename)."',"; }
			
			if(isset($iCreate_Time)) { $sql .= "`Create_Time`='".addslashes($iCreate_Time)."',"; }
			
			if(isset($iModify_Time)) { $sql .= "`Modify_Time`='".addslashes($iModify_Time)."',"; }
			
			if(isset($istatus)) { $sql .= "`status`='".addslashes($istatus)."',"; }

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
		
	
	// Property  " UID "  Start ....
	function setUID($input) // UID set
	{
		if($this->UID = trim($input)) { return true; }
	}
		
	function getUID() // UID Get
	{
		if(isset($this->UID)) { return $this->UID; }
	}	
	// Property  " UID "  End ....  
		
	
	// Property  " Filename "  Start ....
	function setFilename($input) // Filename set
	{
		if($this->Filename = trim($input)) { return true; }
	}
		
	function getFilename() // Filename Get
	{
		if(isset($this->Filename)) { return $this->Filename; }
	}	
	// Property  " Filename "  End ....  
		
	
	// Property  " Create_Time "  Start ....
	function setCreate_Time($input) // Create_Time set
	{
		if($this->Create_Time = trim($input)) { return true; }
	}
		
	function getCreate_Time() // Create_Time Get
	{
		if(isset($this->Create_Time)) { return $this->Create_Time; }
	}	
	// Property  " Create_Time "  End ....  
		
	
	// Property  " Modify_Time "  Start ....
	function setModify_Time($input) // Modify_Time set
	{
		if($this->Modify_Time = trim($input)) { return true; }
	}
		
	function getModify_Time() // Modify_Time Get
	{
		if(isset($this->Modify_Time)) { return $this->Modify_Time; }
	}	
	// Property  " Modify_Time "  End ....  
		
	
	// Property  " status "  Start ....
	function setstatus($input) // status set
	{
		if($this->status = trim($input)) { return true; }
	}
		
	function getstatus() // status Get
	{
		if(isset($this->status)) { return $this->status; }
	}	
	// Property  " status "  End ....  
		

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