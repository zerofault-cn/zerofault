<?
include_once "config.php";
$id=$_REQUEST['id'];
$index=file($index_file);
for($i=0;$i<count($index);$i++)
{
	if($id==substr($index[$i],0,strlen($index[$i])-2))
	{
		$index[$i]="";
		$newindex=implode("",$index);
		$fp1=fopen($index_file,"w");
		fwrite($fp1,$newindex);
		fclose($fp1);
		@unlink($msgDir.$id.$msgFileExt);
		break;
	}
	else
	{
		continue;
	}
}
header("location:index.php");
exit;
?>