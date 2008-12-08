<?php

/**
 * BaseClassGen.cls.php
 * @copyright bokee dot com
 * @created at 2005-7-26 13:10
 * 基类生成类
 */

define("DEBUG", "true");

//用于从数据表生成对应基类
class BaseClassGen
{
	/**
	* @access private
	*/
	var $_table_name;
	/**
	* @access private
	*/
	var $_class_name;
	/**
	* @access private
	*/
	var $_output_cls_str;
	/**
	* @access private
	*/
	var $_properties;
	/**
	* @access private
	*/
	var $_output_file_name;
	/**
	* @access private
	*/
	var $_conn;

	//构造
	/**
	* @access public
	*/
	function BaseClassGen()
	{
		$this->_conn = mysql_connect('localhost', 'root', '');
		mysql_select_db('cms', $this->_conn);
		$this->_properties = array();
	}

	//回收
	/**
	* @access public
	*/
	function Recycle()
	{
		mysql_close($this->_conn);
	}
	
	//设置表名
	/**
	* @access public
	*/
	function SetTableName($table)
	{
		$this->_table_name = $table;
	}

	//基础初始化
	/**
	* @access private
	*/
	function BaseInit()
	{
		$this->_properties = array();
		$sql = "select * from " . $this->_table_name . " limit 1";
		$result = mysql_query($sql, $this->_conn) or die("Query failed: " . mysql_error());
		
		if (defined('DEBUG')) 
		{
			echo mysql_num_fields($result) . "\n";
		}

		while ($meta = mysql_fetch_field($result)) 
		{
			if (!$meta) 
			{
				echo "没有可用信息<br>\n";
			}
			else
			{
				$this->_properties[] = $meta->name;
			}
		}
		
		if (defined('DEBUG')) 
		{
			print_r($this->_properties);
		}
		
		//初始化class name
		$this->_class_name = "";
		$class_name_arr = split("_", $this->_table_name);
		$this->_class_name = "";
		for($i=0;$i<count($class_name_arr);$i++)
		{
			$this->_class_name .= strtoupper(substr($class_name_arr[$i], 0, 1)) . substr($class_name_arr[$i], 1);
			if (defined('DEBUG')) 
			{
				echo $this->_class_name . "\n";
			}
		}		
	}

	//初始化属性
	/**
	* @access private
	*/
	function InitProperties()
	{
		$str = "\n\t//Properties\n";
		for($i=0;$i<count($this->_properties);$i++)
		{
			$str .= "\t/**\n";
			$str .= "\t* @access private\n";
			$str .= "\t*/\n";
			$str .= "\tvar \$_" . $this->_properties[$i] . ";\n";
		}
		//添加数据库存取内部变量声明
		$str .= "\t/**\n";
		$str .= "\t* @access private\n";
		$str .= "\t*/\n";
		$str .= "\tvar \$_dao;\n";
		//添加行数据声明
		$str .= "\t/**\n";
		$str .= "\t* @access private\n";
		$str .= "\t*/\n";
		$str .= "\tvar \$_row;\n";
		return $str;
	}

	//初始化方法
	/**
	* @access private
	*/
	function InitMethods()
	{
		$str = "\n\t//Methods\n";
		for($i=0;$i<count($this->_properties);$i++)
		{
			$function_name_arr = split("_", $this->_properties[$i]);
			$function_name = "";
			for($j=0;$j<count($function_name_arr);$j++)
			{
				$function_name .= strtoupper(substr($function_name_arr[$j], 0, 1)) . substr($function_name_arr[$j], 1);
				if (defined('DEBUG')) 
				{
					echo $function_name . "\n";
				}
			}
			$str .= "\t/**\n";
			$str .= "\t* @access public\n";
			$str .= "\t*/\n";
			$str .= "\tfunction Get" . $function_name . "()\n";
			$str .= "\t{\n";
			$str .= "\t\treturn \$this->_" . $this->_properties[$i] . ";\n";
			$str .= "\t}\n";
			$str .= "\t/**\n";
			$str .= "\t* @access public\n";
			$str .= "\t*/\n";
			$str .= "\tfunction Set" . $function_name . "(\$value)\n";
			$str .= "\t{\n";
			$str .= "\t\t\$this->_" . $this->_properties[$i] ." = \$value;\n";
			$str .= "\t}\n";
		}
		return $str;
	}
	
	/**
	* @access private
	*/
	function InitOperations()
	{
		$str = "";
		
		//初始化Get操作
		$str .= "\t/**\n";
		$str .= "\t* @access public\n";
		$str .= "\t* @param int \$id\n";
		$str .= "\t*/\n";
		$str .= "\tfunction Get(\$id)\n";
		$str .= "\t{\n";
		$str .= "\t\t\$id = intval(\$id);\n";
		$str .= "\t\t\$get_clause = \"select * from " . $this->_table_name . " where id=\$this->_id\";\n";
		$str .= "\t\t\$this->_row=\$this->_dao->GetRow(\"" . $this->_table_name . "\", \$get_clause);\n";
		$str .= "\t\tif(!\$this->_row)\n";
		$str .= "\t\t\treturn false;\n";
		
		//根据返回行设置属性值
		for($i=0;$i<count($this->_properties);$i++)
		{
			if($this->_properties[$i] == "id")
				continue;
			$function_name_arr = split("_", $this->_properties[$i]);
			$function_name = "";
			for($j=0;$j<count($function_name_arr);$j++)
			{
				$function_name .= strtoupper(substr($function_name_arr[$j], 0, 1)) . substr($function_name_arr[$j], 1);
			}
			$str .= "\t\t\$this->Set" . $function_name . "(\$this->_row['" . $this->_properties[$i] . "']);\n";
		}
		$str .= "\t\treturn true;\n";
		$str .= "\t}\n";
		
		$str .= "\t/**\n";
		$str .= "\t* @access public\n";
		$str .= "\t*/\n";
		$str .= "\tfunction Update()\n";
		$str .= "\t{\n";
		$str .= "\t\t\$update_clause = \"update " . $this->_table_name . " set \n";
		for($i=0;$i<count($this->_properties);$i++)
		{
			if($this->_properties[$i] == "id")
				continue;
			if($i == (count($this->_properties)-1))
				$str .= "\t\t" . $this->_properties[$i] . " = \$this->_" . $this->_properties[$i] . "\n";
			else 
				$str .= "\t\t" . $this->_properties[$i] . " = \$this->_" . $this->_properties[$i] . ",\n";
		}
		$str .= "\t\twhere id=\$this->_id\n";
		$str .= "\t\t\";\n";
		$str .= "\t\treturn \$this->_dao->Exec(\"" . $this->_table_name . "\", \$update_clause);\n";
		$str .= "\t}\n";
		
		$str .= "\t/**\n";
		$str .= "\t* @access public\n";
		$str .= "\t* @param int \$id\n";
		$str .= "\t*/\n";
		$str .= "\tfunction Delete(\$id)\n";
		$str .= "\t{\n";
		$str .= "\t\t\$id = intval(\$id);\n";
		$str .= "\t\t\$delete_clause = \"delete from " . $this->_table_name . " where id= \$id\";\n";
		$str .= "\t\treturn \$this->_dao->Exec(\"" . $this->_table_name . "\", \$delete_clause);\n";
		$str .= "\t}\n";
		
		$str .= "\t/**\n";
		$str .= "\t* @access public\n";
		$str .= "\t*/\n";
		$str .= "\tfunction Insert()\n";
		$str .= "\t{\n";
		$str .= "\t\t\$insert_clause = \"insert into " . $this->_table_name . " set \n";
		for($i=0;$i<count($this->_properties);$i++)
		{
			if($this->_properties[$i] == "id")
				continue;
			if($i == (count($this->_properties)-1))
				$str .= "\t\t" . $this->_properties[$i] . " = \$this->_" . $this->_properties[$i] . "\n";
			else 
				$str .= "\t\t" . $this->_properties[$i] . " = \$this->_" . $this->_properties[$i] . ",\n";
		}
		$str .= "\t\t\";\n";
		$str .= "\t\treturn \$this->_dao->Exec(\"" . $this->_table_name . "\", \$insert_clause);\n";
		$str .= "\t}\n";
		
		return $str;
	}
	
	/**
	* @access private
	*/
	function InitConstructor()
	{
		$str = "";
		$str .= "\t/**\n";
		$str .= "\t* @access public\n";
		$str .= "\t*/\n";
		$str .= "\tfunction " . $this->_class_name . "()\n";
		$str .= "\t{\n";
		$str .= "\t\t\$this->_dao = new DAO;\n";
		$str .= "\t}";
		return $str;
	}

	/**
	* @access private
	*/
	function Init()
	{
		$this->BaseInit();
		$properties_str = $this->InitProperties();
		$methods_str = $this->InitMethods();
		$operations_str = $this->InitOperations();
		$constructor_str = $this->InitConstructor();

		$this->_output_cls_str = "<?php\n";
		$this->_output_cls_str .= "/**\n";
		$this->_output_cls_str .= " * " .$this->_class_name . ".cls.php\n";
		$this->_output_cls_str .= " * Generated by BaseClassGen\n";
		$this->_output_cls_str .= " * @copyright bokee dot com\n";
		$this->_output_cls_str .= " * created at " . date("F j, Y, G:i:s") . "\n";
		$this->_output_cls_str .= " */\n\n";
		
		$this->_output_cls_str .= "include_once('DAO.cls.php');\n\n";
		
		$this->_output_cls_str .= "class " . $this->_class_name . "\n";
		$this->_output_cls_str .= "{\n";
		$this->_output_cls_str .= $constructor_str . "\n";
		$this->_output_cls_str .= $properties_str . "\n";
		$this->_output_cls_str .= $methods_str . "\n";
		$this->_output_cls_str .= $operations_str . "\n";
		$this->_output_cls_str .= "}\n?>";
	}

	/**
	* @access  public
	*/
	function GetClassStr()
	{
		$this->Init();
		return $this->_output_cls_str;
	}

	/**
	* @access public
	* @param string $path
	*/
	function WriteClass($path)
	{
		$this->Init();

		$file_name = $path . "/" . $this->_class_name . ".cls.php";
		$fp = fopen($file_name, 'w');
		if(!fwrite($fp, $this->_output_cls_str))
		{
			echo "不能写入到文件 $file_name";
			exit;
		}
		fclose($fp);
	}
}

$cls = new BaseClassGen();
$cls->SetTableName("article");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("subject");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("channel");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("user");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("role");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("coop_media");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("gallery");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("special");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("special_subject");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("area");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->SetTableName("template");
$cls->WriteClass("/var/www/html/CMS/mod");

$cls->Recycle();
?>