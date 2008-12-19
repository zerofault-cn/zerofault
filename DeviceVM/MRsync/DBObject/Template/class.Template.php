<?PHP

class <!!--{$tpl}-->
{

<!!--{section name=show loop=$columns}-->
	var $<!!--{$columns[show]}-->;
<!!--{/section }-->	

	var $table_name = '<!!--{$tpl}-->';
	var $key = '<!!--{$columns[0]}-->';
	
	
	
	function <!!--{$tpl}-->() // initialize
	{
<!!--{section name=show loop=$columns}-->
		$this-><!!--{$columns[show]}--> = null;
<!!--{/section }-->			
	}


	
//member function 

	function Add() // Add   
	{
		global $db;	
			
<!!--{section name=show loop=$columns}-->
<!!--{if $smarty.section.show.index != 0 }-->
		$i<!!--{$columns[show]}--> = $this->get<!!--{$columns[show]}-->();
<!!--{/if}-->
<!!--{/section }-->	 		


		if(<!!--{section name=show loop=$columns}--><!!--{if $smarty.section.show.index != 0 }-->isset($i<!!--{$columns[show]}-->)<!!--{if ! $smarty.section.show.last }-->||<!!--{/if}--><!!--{/if}--><!!--{/section }-->)
		{
			$sql .= "INSERT INTO `$this->table_name` VALUES(";
			$sql .= "<!!--{section name=show loop=$columns}-->'$i<!!--{$columns[show]}-->'<!!--{if ! $smarty.section.show.last }-->,<!!--{/if}--><!!--{/section }-->)";

//			echo $sql . '<hr>';

			if($db->Execute($sql))
			{
				//return 1 ;
				return $db->Insert_ID();
			}else{
				return 0;
			}	
		}else{
			return 0;
		}
	}
	



	function View($input=null) // View Subject one  record
	{
		if($input)
		{
			global $db;
			$sql = "select * from `$this->table_name` where `$this->key` = '$input'";
			// echo $sql .'<hr>';
			$rs = $db->Execute($sql);
			if($rs->RecordCount())
			{
				$arr = $rs->FetchRow();
				foreach($arr as $key => $value)
				{
					//echo $key . ' => ' . $value .'<br>';
					$tmp = 'set'.$key;
					$this->$tmp($value);
				}
				return $arr ;
			}else{
				return 0;
			}			
		}
	}


	function Del($input) // Delete a user 
	{
		global $db;
		if(isset($input))
		{
			$sql = "delete from `$this->table_name` where `$this->key` = '$input' ;";
			$rs = $db->Execute($sql);
			if($rs)
			{
				return true;
			}else{
				return false;
			}
		}
		return $rs ;
	}


	function Browse($option='',$row=-1,$start=0) // Browse all user
	{

		global $db;
		$sql = "select * from `$this->table_name` ";
		if(trim($option)!='')
		{
			$sql .= $option;
		}
		//echo $sql . '<hr>';
		
		$rs = $db->SelectLimit($sql,$row,$start);
		
		if($rs->RecordCount())
		{
			$d = $rs->GetRows();
		
			$key = array_keys($d[0]);
			
			for($i=0;$i<count($d);$i++)
			{
				for($j=0;$j<count($key);$j++)
				{
					$newkey = $key[$j];
					$d2[$newkey][]= $d[$i][$newkey];
				}
			}
			return $d2;
		}else{
			return null;
		}
	}

	function Update($input) //
	{
		global $db;
		
<!!--{section name=show loop=$columns}-->		
		$i<!!--{$columns[show]}--> = $this->get<!!--{$columns[show]}-->();<!!--{/section }-->		


		if(isset($input))
		{			
			$sql  = "UPDATE `$this->table_name` SET ";
<!!--{section name=show loop=$columns}-->			
			if(isset($i<!!--{$columns[show]}-->))  {
				$sql .= "`<!!--{$columns[show]}-->`='$i<!!--{$columns[show]}-->'," ;  }	
<!!--{/section }-->

			$sql = substr($sql,0,(strlen(trim($sql))-1));
			$sql .= " where `$this->key` = '$input' ";
			
			
//			echo $sql;
			if($db->Execute($sql))
			{
				return 1 ;
			}else{
				return 0;
			}
		}else{
			return 0;
		}			
	}

	function RecordCount($option='') // Count all Records
	{

		global $db;
		$sql = "select * from `$this->table_name` ";
		if(trim($option)!='')
		{
			$sql .= $option;
		}
		//echo $sql . '<hr>';
		
		$rs = $db->Execute($sql);
		
		if($rs)
		{
			return $rs->RecordCount();
		}else{
			return null;
		}
	}

	
	function ChangeOne($input='',$field='',$value='')
	{
		global $db; 
		if( $input!='' && $field!='' && $value!='')
		{
			$sql = "UPDATE `$this->table_name` SET `$field` = '$value' WHERE `$this->key` = '$input'"	;
//			echo $sql .'<hr>';
			if($db->Execute($sql))
			{
				return 1 ;
			}else{
				return 0;
			}	
		}else{
			return 0;
		}
	}


	function Exec($input) // Exec   
	{
		global $db;	
			
		if(isset($input)&&$input!='')
		{
			$sql = $input;

		//	echo $sql . '<hr>';
			$rs = $db->Execute($sql);
			
			
			if($rs->RecordCount())
			{
				$d = $rs->GetRows();
		
				$key = array_keys($d[0]);
			
				for($i=0;$i<count($d);$i++)
				{
					for($j=0;$j<count($key);$j++)
					{
						$newkey = $key[$j];
						$d2[$newkey][]= $d[$i][$newkey];
					}
				}
				return $d2;
			}else{
				return null;
			}
		}

}


//  Property set / Get



<!!--{section name=show loop=$columns}-->	
	// Property  " <!!--{$columns[show]}--> "  Start ....
	function set<!!--{$columns[show]}-->($input) // <!!--{$columns[show]}--> set
	{
		if($this-><!!--{$columns[show]}--> = trim($input))
		{
			return true;
		}
	}
		
	function get<!!--{$columns[show]}-->() // <!!--{$columns[show]}--> Get
	{
		if(isset($this-><!!--{$columns[show]}-->))
		{
			return $this-><!!--{$columns[show]}-->;
		}
	}	
	// Property  " <!!--{$columns[show]}--> "  End ....  
	
	
<!!--{/section }-->		


}

?>