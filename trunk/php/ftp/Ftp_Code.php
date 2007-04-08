<title>查看代码</title>
<?php
$file=Stripslashes($_GET['file']);
$Exten=Substr(Strrchr($file, "."), 1);
$Allow_Nmae=array("php","txt","html","html");
If(!In_Array($Exten,$Allow_Nmae)){
Echo"<script>alert('只能查看PHP代码')</script>";
exit();

}

$str="";
$handle = @Fopen ($file, "r"); 
Ob_Start();
while (!@Feof ($handle)) { 
    $buffer =@Fgets($handle); 
    $str.=$buffer; 
    } 
Ob_End_Flush();
$str= Highlight_String($str);
$str=Preg_Replace ("/(.*)1$/","\\1",$str);
Echo   "<pre>";
Echo   "$str";
Echo   "</pre>";
?>