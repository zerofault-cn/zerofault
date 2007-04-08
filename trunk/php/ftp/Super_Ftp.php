<?php
Ob_Start();//打开缓冲区
Error_Reporting(E_ALL^ E_NOTICE);//设置报错级别，notice错误不报告

Include  "Ftp.Class.php";//引进ftp类
List($start_usec, $start_sec) = Explode(" ",Microtime());//取得网页开始运行时间

//引入template类
Include("template.inc.php");

#实例化一个template类，名字叫$t 
$t = new template();

//设置模板文件
$t->set_file("ftp","Ftp.html");

//读取变量
if($_POST['action']=="login"||$_COOKIE['Have_Login']!="Yes"){
	$Ftp_Host=$_POST['Ftp_Host'];
	$Ftp_User=$_POST['Ftp_User'];
	$Ftp_Pass=$_POST['Ftp_Pass'];
	$Ftp_Port=$_POST['Ftp_Port'];	
}

elseif ($_COOKIE['Have_Login']=="Yes"){
	$Ftp_Host=$_COOKIE['Ftp_Host'];
	$Ftp_User=$_COOKIE['Ftp_User'];
	$Ftp_Pass=$_COOKIE['Ftp_Pass'];
	$Ftp_Port=$_COOKIE['Ftp_Port'];
}

else {
	$Ftp_Host=$_POST['Ftp_Host'];
	$Ftp_User=$_POST['Ftp_User'];
	$Ftp_Pass=$_POST['Ftp_Pass'];
	$Ftp_Port=$_POST['Ftp_Port'];	
}
//读取变量完毕

//读取当前路径
$_GET["dir"]?$Dir=Stripslashes($_GET["dir"]):$Dir="";

$Dir=Preg_Replace ("/[\/]+/","/",$Dir);

//直接输入网址，没有主机变量。
if(!$Ftp_Host){
	$t->Set_Var("错误","<font color=red>非法进入</font><br><a href='index.php'>点击重新登陆</a>");
	$t->Parse("Out","ftp");//分析处理模板
	$t->p("Out");//输出模板
	Exit;
}


//这里执行操作，实例化ftp类
$Ftp=new My_Ftp($Ftp_Host,$Ftp_User,$Ftp_Pass,$Ftp_Port);

//连接ftp服务器
$Connect=$Ftp->Link_Ftp();

if($Connect[0]==0){
	$t->Set_Var("错误",$Connect[1]);
	$t->Parse("Out","ftp");
	$t->p("Out");
	Exit;
}


$Ftp->Cookie_Ftp();


//删除,下载，改名，代码,移动文件



//删除
$Select_Name=Stripslashes($_POST["Select_Name"]);
$Select_Name_Folder=Stripslashes($_POST["Select_Name_Folder"]);


//删除文件夹
if(Eregi("del$",$Select_Name_Folder)){
	$Select_Name_Folder=Stripslashes(Preg_Replace ("/(.*)del$/","\\1",$Select_Name_Folder));
	$Del_Folder=$Ftp->Del_Folder_Ftp($Select_Name_Folder);
	Set_Error_Message($Del_Folder);
}


//删除文件
if(Eregi("del$",$Select_Name)){
	$Select_Name=Stripslashes(Preg_Replace ("/(.*)del$/","\\1",$Select_Name));
	$Del=$Ftp->Del_File_Ftp($Select_Name);
	Set_Error_Message($Del);
}


//下载
if(Eregi("down$",$Select_Name)){
	$Select_Name=Preg_Replace ("/(.*)down$/","\\1",$Select_Name);
	$Down=$Ftp->Down_Ftp($Select_Name);
	Set_Error_Message($Down);
}



//重命名文件,文件夹
if(Eregi("rename$",$Select_Name_Folder)||Eregi("rename$",$Select_Name)){
	$Select_Name?$Select_=Preg_Replace ("/(.*)rename$/","\\1",$Select_Name):$Select_=Preg_Replace ("/(.*)rename$/","\\1",$Select_Name_Folder);
	$To_Name=Stripslashes($_POST['To_Name']);
	$To_Len=Substr_Count($Select_,"/");
	$To_=Explode ("/",$Select_);
	$To_Name_="";
	for($i=0; $i<$To_Len; $i++){
		$To_Name_.=$To_[$i]."/";
	}
	$To_Name=$To_Name_.$To_Name;
	$Re=$Ftp->Rename_Ftp($Select_,$To_Name);
	Set_Error_Message($Re);
}



//移动文件
$Move_To=Stripslashes($_POST["Move_To"]);

if(Eregi("move$",$Select_Name_Folder)||Eregi("move$",$Select_Name)){
	$Select_Name?$Select_=Preg_Replace ("/(.*)move$/","\\1",$Select_Name):$Select_=Preg_Replace ("/(.*)move$/","\\1",$Select_Name_Folder);
	$Select_M=substr(strrchr($Select_, "/"), 1);
	$Move_To=$Move_To."/".$Select_M;
	$Move_To=Preg_Replace("/[\/]+/","/",$Move_To);
	$Move=$Ftp->Rename_Ftp($Select_,$Move_To);
	Set_Error_Message($Move);
}


//建立文件夹
if($Folder_Name=Stripslashes($_POST['Folder_Name'])){
	$Ch_Dir=$Ftp->Chdir_Ftp($Dir);
	if($Ch_Dir==0){
		$Self_Define="<font color=red>无法切换目录</font>";
		Set_Error_Message($Ch_Dir,$Self_Define);
	}
	$Mk=$Ftp->Folder_Ftp($Folder_Name);
	Set_Error_Message($Mk);
}


//上传文件

$Source_File=$_FILES['Source_File']['tmp_name'];
$Up_Type=$_POST["Up_Type"];

if(is_uploaded_file($Source_File[0])){
	$F_Len=Count($_FILES['Source_File']['tmp_name']);
	for($i=0; $i<$F_Len; $i++)$_FILES['Source_File']['tmp_name'][$i]!=""?$Up_File_Array[]=$_FILES['Source_File']['tmp_name'][$i]:"";
	for($i=0; $i<$F_Len; $i++)$_FILES['Source_File']['tmp_name'][$i]!=""?$Server_File_Array[]=Stripslashes($_FILES['Source_File']['name'][$i]):"";
	$Ch_Dir=$Ftp->Chdir_Ftp($Dir);
	if (!$Ch_Dir){
		$Self_Define="<font color=red>严重错误:无法切换目录</font>";
		Set_Error_Message($Ch_Dir,$Self_Define);
	}
	$R_F_Len=Count($Up_File_Array);
	for($i=0; $i<$R_F_Len; $i++){
		$up_load=$Ftp->Up_Load_Ftp($Server_File_Array[$i],$Up_File_Array[$i],$Up_Type);
	}
	
	if(!$up_load){
		Set_Error_Message(0);
	}else{
		Set_Error_Message(1);
	}
}



$s=$Ftp->List_Ftp($Dir);

//文件夹名数组
$folder_array=array();

//文件数组
$File_array=array();


$Len=count($s);

for($i=0; $i<$Len; $i++) Eregi("^d",$s[$i])?$folder_array[]=$s[$i]:"";
for($i=0; $i<$Len; $i++) Eregi("^-",$s[$i])?$File_array[]=$s[$i]:"";

//文件夹个数
$folder_len=count($folder_array);

//文件个数
$File_len=count($File_array);




$up_dir_Explode=Explode ("/",$Dir);
$up_dir_len=count($up_dir_Explode);

$up_dir='';
for($i=0; $i<$up_dir_len-1; $i++){
	$up_dir.=$up_dir_Explode[$i]."/";
}

$up_dir=urlencode(ereg_replace("(.*)\/$","\\1",$up_dir));

$Dir==""?$go_up="<tr><td bgcolor=\"#023266\"   colspan=\"8\"><a style=\"font-size: 12px;color: #4eaece;\"><img border=0 src=\"img/up.gif\">上级目录</a></td></tr>":$go_up="<tr><td bgcolor=\"#023266\"   colspan=\"8\"><img border=0 src=\"img/up.gif\"><a href=\"?dir=$up_dir\">上级目录</a></td></tr>";

$t->Set_Var(array("文件夹个数"=>$folder_len,"文件个数"=>$File_len,"上级目录"=>$go_up,"当前目录"=>$Dir,"ftp主机"=>$Ftp_Host));

$Dir?$t->Set_Var("路径",$Dir):$t->Set_Var("路径","/");

$t->set_block("ftp","folder","block_folder");
$t->set_block("ftp","file","block_file");


//替換文件夾
for($i=0; $i<$folder_len; $i++){
	if(count(Explode ("|",$folder_array[$i]))>3){
	$folder_Explode=Explode ("|",$folder_array[$i]);
	$t->Set_Var(array(
				"夹属性"=>$folder_Explode[0],
				"夹|使用者|所在组"=>$folder_Explode[2]."|".$folder_Explode[3],
				"夹创建时间"=>$folder_Explode[5]."|".$folder_Explode[6]."|".$folder_Explode[7],
				"文件夹名"=>$folder_Explode[8],
				"文件夹名_"=>urlencode($folder_Explode[8]),
				)
	);
}else{
	$folder_Explode=Explode(" ",$folder_array[$i]);
	for($h=0;$h<count($folder_Explode);$h++){
		if($folder_Explode[$h]!=""&&$folder_Explode[$h]!=" "){
			$newSet[$i][]=$folder_Explode[$h];
		}
	}

	$t->Set_Var(array(
			"夹属性"=>$newSet[$i][0],
			"夹|使用者|所在组"=>$newSet[$i][2]."|".$newSet[$i][3],
			"夹创建时间"=>$newSet[$i][5]."|".$newSet[$i][6]."|".$newSet[$i][7],
			"文件夹名"=>$newSet[$i][8],
			"文件夹名_"=>urlencode($newSet[$i][8]),
		)
	);
	$folder_Explode[8]=$newSet[$i][8];
}


$child_folder=@$Ftp->List_Ftp($Dir."/".$folder_Explode[8]);

$File_Folder_Len=@File_Folder_Len($child_folder);


$child_folder=@$Ftp->List_Ftp($Dir."/".$folder_Explode[8]);

$File_Folder_Len=@File_Folder_Len($child_folder);

$t->Set_Var(array(
			"夹次序"=>$i,
			"子夹数"=>$File_Folder_Len[0],
			"子文件数"=>$File_Folder_Len[1],
			"当前目录"=>$Dir,
			"当前目录_"=>urlencode($Dir),
		)
	);

$t->Parse("block_folder","folder",true);
}

$t->Parse("Out","ftp");

//替换文件
for($i=0; $i<$File_len; $i++){
$File_Explode=Explode ("|",$File_array[$i]);

$t->Set_Var( array(
				"文件属性"=>$File_Explode[0],
				"文件|使用者|所在组"=>$File_Explode[2]."|".$File_Explode[3],
				"大小"=>number_format($File_Explode[4]),
				"创建时间"=>$File_Explode[5]."|".$File_Explode[6]."|".$File_Explode[7],
				"文件名"=>$File_Explode[8],
				"主机"=>"ftp://".$Ftp_User.":".$Ftp_Pass."@".$Ftp_Host.":".$Ftp_Port,
				"次序"=>$i,
				"当前目录"=>$Dir,
				)
	);


$size=Ftp_Mdtm($Connect[1],$Dir."/".$File_Explode[8]);
$t->Set_Var("文件修改时间",@date("y-m-d h:i:s", $size));
$t->Parse("block_file","file",true);
}





//查看代码
if(Eregi("source$",$Select_Name)){
	$Select_Name=Preg_Replace ("/(.*)source$/","\\1",$Select_Name);
	Echo "<script>window.open('ftp_code.php?file=ftp://".$Ftp_User.":".$Ftp_Pass."@".$Ftp_Host.":".$Ftp_Port."/".urlencode($Select_Name)."')</script>";
}

//网页处理完毕，输出
$t->Parse("Out","ftp");
$t->p("Out");
$Ftp->Quite_Ftp();

//计算运行时间
List($End_Usec, $End_Sec) = Explode(" ",microtime());
$Last=Sprintf("%.5f",$End_Sec+$End_Usec-$start_sec-$start_usec);

Echo '页面执行时间'.$Last."秒</center><p>&nbsp;<p></body></html>";
?>