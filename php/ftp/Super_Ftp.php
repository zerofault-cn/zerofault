<?php
Ob_Start();//�򿪻�����
Error_Reporting(E_ALL^ E_NOTICE);//���ñ�����notice���󲻱���

Include  "Ftp.Class.php";//����ftp��
List($start_usec, $start_sec) = Explode(" ",Microtime());//ȡ����ҳ��ʼ����ʱ��

//����template��
Include("template.inc.php");

#ʵ����һ��template�࣬���ֽ�$t 
$t = new template();

//����ģ���ļ�
$t->set_file("ftp","Ftp.html");

//��ȡ����
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
//��ȡ�������

//��ȡ��ǰ·��
$_GET["dir"]?$Dir=Stripslashes($_GET["dir"]):$Dir="";

$Dir=Preg_Replace ("/[\/]+/","/",$Dir);

//ֱ��������ַ��û������������
if(!$Ftp_Host){
	$t->Set_Var("����","<font color=red>�Ƿ�����</font><br><a href='index.php'>������µ�½</a>");
	$t->Parse("Out","ftp");//��������ģ��
	$t->p("Out");//���ģ��
	Exit;
}


//����ִ�в�����ʵ����ftp��
$Ftp=new My_Ftp($Ftp_Host,$Ftp_User,$Ftp_Pass,$Ftp_Port);

//����ftp������
$Connect=$Ftp->Link_Ftp();

if($Connect[0]==0){
	$t->Set_Var("����",$Connect[1]);
	$t->Parse("Out","ftp");
	$t->p("Out");
	Exit;
}


$Ftp->Cookie_Ftp();


//ɾ��,���أ�����������,�ƶ��ļ�



//ɾ��
$Select_Name=Stripslashes($_POST["Select_Name"]);
$Select_Name_Folder=Stripslashes($_POST["Select_Name_Folder"]);


//ɾ���ļ���
if(Eregi("del$",$Select_Name_Folder)){
	$Select_Name_Folder=Stripslashes(Preg_Replace ("/(.*)del$/","\\1",$Select_Name_Folder));
	$Del_Folder=$Ftp->Del_Folder_Ftp($Select_Name_Folder);
	Set_Error_Message($Del_Folder);
}


//ɾ���ļ�
if(Eregi("del$",$Select_Name)){
	$Select_Name=Stripslashes(Preg_Replace ("/(.*)del$/","\\1",$Select_Name));
	$Del=$Ftp->Del_File_Ftp($Select_Name);
	Set_Error_Message($Del);
}


//����
if(Eregi("down$",$Select_Name)){
	$Select_Name=Preg_Replace ("/(.*)down$/","\\1",$Select_Name);
	$Down=$Ftp->Down_Ftp($Select_Name);
	Set_Error_Message($Down);
}



//�������ļ�,�ļ���
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



//�ƶ��ļ�
$Move_To=Stripslashes($_POST["Move_To"]);

if(Eregi("move$",$Select_Name_Folder)||Eregi("move$",$Select_Name)){
	$Select_Name?$Select_=Preg_Replace ("/(.*)move$/","\\1",$Select_Name):$Select_=Preg_Replace ("/(.*)move$/","\\1",$Select_Name_Folder);
	$Select_M=substr(strrchr($Select_, "/"), 1);
	$Move_To=$Move_To."/".$Select_M;
	$Move_To=Preg_Replace("/[\/]+/","/",$Move_To);
	$Move=$Ftp->Rename_Ftp($Select_,$Move_To);
	Set_Error_Message($Move);
}


//�����ļ���
if($Folder_Name=Stripslashes($_POST['Folder_Name'])){
	$Ch_Dir=$Ftp->Chdir_Ftp($Dir);
	if($Ch_Dir==0){
		$Self_Define="<font color=red>�޷��л�Ŀ¼</font>";
		Set_Error_Message($Ch_Dir,$Self_Define);
	}
	$Mk=$Ftp->Folder_Ftp($Folder_Name);
	Set_Error_Message($Mk);
}


//�ϴ��ļ�

$Source_File=$_FILES['Source_File']['tmp_name'];
$Up_Type=$_POST["Up_Type"];

if(is_uploaded_file($Source_File[0])){
	$F_Len=Count($_FILES['Source_File']['tmp_name']);
	for($i=0; $i<$F_Len; $i++)$_FILES['Source_File']['tmp_name'][$i]!=""?$Up_File_Array[]=$_FILES['Source_File']['tmp_name'][$i]:"";
	for($i=0; $i<$F_Len; $i++)$_FILES['Source_File']['tmp_name'][$i]!=""?$Server_File_Array[]=Stripslashes($_FILES['Source_File']['name'][$i]):"";
	$Ch_Dir=$Ftp->Chdir_Ftp($Dir);
	if (!$Ch_Dir){
		$Self_Define="<font color=red>���ش���:�޷��л�Ŀ¼</font>";
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

//�ļ���������
$folder_array=array();

//�ļ�����
$File_array=array();


$Len=count($s);

for($i=0; $i<$Len; $i++) Eregi("^d",$s[$i])?$folder_array[]=$s[$i]:"";
for($i=0; $i<$Len; $i++) Eregi("^-",$s[$i])?$File_array[]=$s[$i]:"";

//�ļ��и���
$folder_len=count($folder_array);

//�ļ�����
$File_len=count($File_array);




$up_dir_Explode=Explode ("/",$Dir);
$up_dir_len=count($up_dir_Explode);

$up_dir='';
for($i=0; $i<$up_dir_len-1; $i++){
	$up_dir.=$up_dir_Explode[$i]."/";
}

$up_dir=urlencode(ereg_replace("(.*)\/$","\\1",$up_dir));

$Dir==""?$go_up="<tr><td bgcolor=\"#023266\"   colspan=\"8\"><a style=\"font-size: 12px;color: #4eaece;\"><img border=0 src=\"img/up.gif\">�ϼ�Ŀ¼</a></td></tr>":$go_up="<tr><td bgcolor=\"#023266\"   colspan=\"8\"><img border=0 src=\"img/up.gif\"><a href=\"?dir=$up_dir\">�ϼ�Ŀ¼</a></td></tr>";

$t->Set_Var(array("�ļ��и���"=>$folder_len,"�ļ�����"=>$File_len,"�ϼ�Ŀ¼"=>$go_up,"��ǰĿ¼"=>$Dir,"ftp����"=>$Ftp_Host));

$Dir?$t->Set_Var("·��",$Dir):$t->Set_Var("·��","/");

$t->set_block("ftp","folder","block_folder");
$t->set_block("ftp","file","block_file");


//��Q�ļ��A
for($i=0; $i<$folder_len; $i++){
	if(count(Explode ("|",$folder_array[$i]))>3){
	$folder_Explode=Explode ("|",$folder_array[$i]);
	$t->Set_Var(array(
				"������"=>$folder_Explode[0],
				"��|ʹ����|������"=>$folder_Explode[2]."|".$folder_Explode[3],
				"�д���ʱ��"=>$folder_Explode[5]."|".$folder_Explode[6]."|".$folder_Explode[7],
				"�ļ�����"=>$folder_Explode[8],
				"�ļ�����_"=>urlencode($folder_Explode[8]),
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
			"������"=>$newSet[$i][0],
			"��|ʹ����|������"=>$newSet[$i][2]."|".$newSet[$i][3],
			"�д���ʱ��"=>$newSet[$i][5]."|".$newSet[$i][6]."|".$newSet[$i][7],
			"�ļ�����"=>$newSet[$i][8],
			"�ļ�����_"=>urlencode($newSet[$i][8]),
		)
	);
	$folder_Explode[8]=$newSet[$i][8];
}


$child_folder=@$Ftp->List_Ftp($Dir."/".$folder_Explode[8]);

$File_Folder_Len=@File_Folder_Len($child_folder);


$child_folder=@$Ftp->List_Ftp($Dir."/".$folder_Explode[8]);

$File_Folder_Len=@File_Folder_Len($child_folder);

$t->Set_Var(array(
			"�д���"=>$i,
			"�Ӽ���"=>$File_Folder_Len[0],
			"���ļ���"=>$File_Folder_Len[1],
			"��ǰĿ¼"=>$Dir,
			"��ǰĿ¼_"=>urlencode($Dir),
		)
	);

$t->Parse("block_folder","folder",true);
}

$t->Parse("Out","ftp");

//�滻�ļ�
for($i=0; $i<$File_len; $i++){
$File_Explode=Explode ("|",$File_array[$i]);

$t->Set_Var( array(
				"�ļ�����"=>$File_Explode[0],
				"�ļ�|ʹ����|������"=>$File_Explode[2]."|".$File_Explode[3],
				"��С"=>number_format($File_Explode[4]),
				"����ʱ��"=>$File_Explode[5]."|".$File_Explode[6]."|".$File_Explode[7],
				"�ļ���"=>$File_Explode[8],
				"����"=>"ftp://".$Ftp_User.":".$Ftp_Pass."@".$Ftp_Host.":".$Ftp_Port,
				"����"=>$i,
				"��ǰĿ¼"=>$Dir,
				)
	);


$size=Ftp_Mdtm($Connect[1],$Dir."/".$File_Explode[8]);
$t->Set_Var("�ļ��޸�ʱ��",@date("y-m-d h:i:s", $size));
$t->Parse("block_file","file",true);
}





//�鿴����
if(Eregi("source$",$Select_Name)){
	$Select_Name=Preg_Replace ("/(.*)source$/","\\1",$Select_Name);
	Echo "<script>window.open('ftp_code.php?file=ftp://".$Ftp_User.":".$Ftp_Pass."@".$Ftp_Host.":".$Ftp_Port."/".urlencode($Select_Name)."')</script>";
}

//��ҳ������ϣ����
$t->Parse("Out","ftp");
$t->p("Out");
$Ftp->Quite_Ftp();

//��������ʱ��
List($End_Usec, $End_Sec) = Explode(" ",microtime());
$Last=Sprintf("%.5f",$End_Sec+$End_Usec-$start_sec-$start_usec);

Echo 'ҳ��ִ��ʱ��'.$Last."��</center><p>&nbsp;<p></body></html>";
?>