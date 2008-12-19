<?PHP
/** 
 * @Create in <!!--{$smarty.now|date_format:'%Y/%m/%d %H:%M:%S'}-->
 * @Smarty Version <!!--{$smarty.version}-->
 * 
 */
 
class <!!--{$tpl}-->
{	
<!!--{section name=show loop=$columns}-->
	var $<!!--{$columns[show]}-->;
<!!--{/section }-->

	var $table_name = '<!!--{$tpl}-->';
	var $key = '<!!--{$columns[0]}-->';
	var $debug = False ;	
	
	function <!!--{$tpl}-->() // initialize
	{
<!!--{section name=show loop=$columns}-->
		$this-><!!--{$columns[show]}--> = null;	
<!!--{/section }-->
	}

	function <!!--{$tpl}-->_Default() // get Default
	{
<!!--{section name=show loop=$columns}-->
<!!--{if $Out.Default[show] != 'null' }-->
		if(!isset($this-><!!--{$columns[show]}-->)) { $this-><!!--{$columns[show]}--> = <!!--{$Out.Default[show]}-->; }
<!!--{/if}-->
<!!--{/section }-->
	}

##########     Member function     ##########

	// Add one record into table
	function Add() 
	{
		global $db;	
		
		$this-><!!--{$tpl}-->_Default(); // get Default

<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0 }-->
		$i<!!--{$columns[show]}--> = $this->get<!!--{$columns[show]}-->();
<!!--{/if}-->
<!!--{/section }-->

		if(<!!--{section name=show loop=$columns}--><!!--{if $smarty.section.show.index != 0 }-->isset($i<!!--{$columns[show]}-->)<!!--{if ! $smarty.section.show.last }-->||<!!--{/if}--><!!--{/if}--><!!--{/section }-->)
		{
			$sql = "INSERT INTO `$this->table_name` ";
			$sql .= "(<!!--{section name=show loop=$columns}--><!!--{if $smarty.section.show.index != 0 }-->`<!!--{$columns[show]}-->`<!!--{if ! $smarty.section.show.last }-->,<!!--{/if}--><!!--{/if}--><!!--{/section }-->)";
			$sql .= " VALUES(<!!--{section name=show loop=$columns}--><!!--{if $smarty.section.show.index != 0 }--><!!--{if $Out.Type[show] != 0 }-->'<!!--{/if}-->".<!!--{if $Out.Type[show] != 0 }-->addslashes(<!!--{/if}-->$i<!!--{$columns[show]}--><!!--{if $Out.Type[show] != 0 }-->)<!!--{/if}-->."<!!--{if $Out.Type[show] != 0 }-->'<!!--{/if}--><!!--{if ! $smarty.section.show.last }-->,<!!--{/if}--><!!--{/if}--><!!--{/section }-->)";
			
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
<!!--{section name=show loop=$columns}-->		
		$i<!!--{$columns[show]}--> = $this->get<!!--{$columns[show]}-->();<!!--{/section }-->		

		if(isset($input)&&trim($input)!='') {
			$sql = "UPDATE `$this->table_name` SET ";			
<!!--{section name=show loop=$columns}--><!!--{if $smarty.section.show.index != 0 }-->			
			if(isset($i<!!--{$columns[show]}-->)) { $sql .= "`<!!--{$columns[show]}-->`='".addslashes($i<!!--{$columns[show]}-->)."',"; }
<!!--{/if}--><!!--{/section }-->

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

<!!--{section name=show loop=$columns}-->	
	// Property  " <!!--{$columns[show]}--> "  Start ....
	function set<!!--{$columns[show]}-->($input) // <!!--{$columns[show]}--> set
	{
		if($this-><!!--{$columns[show]}--> = trim($input)) { return true; }
	}
		
	function get<!!--{$columns[show]}-->() // <!!--{$columns[show]}--> Get
	{
		if(isset($this-><!!--{$columns[show]}-->)) { return $this-><!!--{$columns[show]}-->; }
	}	
	// Property  " <!!--{$columns[show]}--> "  End ....  
		
<!!--{/section }-->

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