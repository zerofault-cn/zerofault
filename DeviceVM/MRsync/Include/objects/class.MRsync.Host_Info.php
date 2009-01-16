<?PHP
/** 
 * @Create in 2009/01/16 02:08:08
 * @Smarty Version 2.6.18
 * 
 */
 
class Host_Info
{	
	var $ID;
	var $Host;
	var $Host_Chroot;
	var $Local_Chroot;
	var $Time;
	var $Sync_ID;
	var $Mail;

	var $table_name = 'Host_Info';
	var $key = 'ID';
	var $debug = False ;	
	
	function Host_Info() // initialize
	{
		$this->ID = null;	
		$this->Host = null;	
		$this->Host_Chroot = null;	
		$this->Local_Chroot = null;	
		$this->Time = null;	
		$this->Sync_ID = null;	
		$this->Mail = null;	
	}

	function Host_Info_Default() // get Default
	{
		if(!isset($this->Sync_ID)) { $this->Sync_ID = '0'; }
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this->Host_Info_Default(); // get Default

		$iHost = $this->getHost();
		$iHost_Chroot = $this->getHost_Chroot();
		$iLocal_Chroot = $this->getLocal_Chroot();
		$iTime = $this->getTime();
		$iSync_ID = $this->getSync_ID();
		$iMail = $this->getMail();

		if(isset($iHost)||isset($iHost_Chroot)||isset($iLocal_Chroot)||isset($iTime)||isset($iSync_ID)||isset($iMail))
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(`Host`,`Host_Chroot`,`Local_Chroot`,`Time`,`Sync_ID`,`Mail`)";
			$sql .= " VALUES('".addslashes($iHost)."','".addslashes($iHost_Chroot)."','".addslashes($iLocal_Chroot)."','".addslashes($iTime)."',".$iSync_ID.",'".addslashes($iMail)."')";
			
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
		$iHost = $this->getHost();		
		$iHost_Chroot = $this->getHost_Chroot();		
		$iLocal_Chroot = $this->getLocal_Chroot();		
		$iTime = $this->getTime();		
		$iSync_ID = $this->getSync_ID();		
		$iMail = $this->getMail();		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
			
			if(isset($iHost)) { $sql .= "`Host`='".addslashes($iHost)."',"; }
			
			if(isset($iHost_Chroot)) { $sql .= "`Host_Chroot`='".addslashes($iHost_Chroot)."',"; }
			
			if(isset($iLocal_Chroot)) { $sql .= "`Local_Chroot`='".addslashes($iLocal_Chroot)."',"; }
			
			if(isset($iTime)) { $sql .= "`Time`='".addslashes($iTime)."',"; }
			
			if(isset($iSync_ID)) { $sql .= "`Sync_ID`='".addslashes($iSync_ID)."',"; }
			
			if(isset($iMail)) { $sql .= "`Mail`='".addslashes($iMail)."',"; }

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
		
	
	// Property  " Host_Chroot "  Start ....
	function setHost_Chroot($input) // Host_Chroot set
	{
		if($this->Host_Chroot = trim($input)) { return true; }
	}
		
	function getHost_Chroot() // Host_Chroot Get
	{
		if(isset($this->Host_Chroot)) { return $this->Host_Chroot; }
	}	
	// Property  " Host_Chroot "  End ....  
		
	
	// Property  " Local_Chroot "  Start ....
	function setLocal_Chroot($input) // Local_Chroot set
	{
		if($this->Local_Chroot = trim($input)) { return true; }
	}
		
	function getLocal_Chroot() // Local_Chroot Get
	{
		if(isset($this->Local_Chroot)) { return $this->Local_Chroot; }
	}	
	// Property  " Local_Chroot "  End ....  
		
	
	// Property  " Time "  Start ....
	function setTime($input) // Time set
	{
		if($this->Time = trim($input)) { return true; }
	}
		
	function getTime() // Time Get
	{
		if(isset($this->Time)) { return $this->Time; }
	}	
	// Property  " Time "  End ....  
		
	
	// Property  " Sync_ID "  Start ....
	function setSync_ID($input) // Sync_ID set
	{
		if($this->Sync_ID = trim($input)) { return true; }
	}
		
	function getSync_ID() // Sync_ID Get
	{
		if(isset($this->Sync_ID)) { return $this->Sync_ID; }
	}	
	// Property  " Sync_ID "  End ....  
		
	
	// Property  " Mail "  Start ....
	function setMail($input) // Mail set
	{
		if($this->Mail = trim($input)) { return true; }
	}
		
	function getMail() // Mail Get
	{
		if(isset($this->Mail)) { return $this->Mail; }
	}	
	// Property  " Mail "  End ....  
		

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