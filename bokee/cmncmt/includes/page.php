<?php
if(!function_exists(pageft))
{
	function pageft($totle,$pageitem)
	{
		global $page;//���ܵı���
		global $offset,$pagenav;//����ı���
		if(!$page) 
		{
			$page=1;
		}
	
		$lastpg=ceil($totle/$pageitem); //���ҳ��Ҳ����ҳ��
		$page=min($lastpg,$page);
		$prepg=$page-1; //��һҳ
		$nextpg=($page==$lastpg ? 0 : $page+1); //��һҳ
		$offset=($page-1)*$pageitem;
		$pagenav="��ʾ�� <b>".($totle?($offset+1):0)."</b>��<b>".min($offset+$pageitem,$totle)."</b> ����¼���� <b>".$totle."</b> ����¼<br>";
		if($lastpg<=1) 
		{
			return false;
		}
		$pagenav.=' <a href="javascript:page=1;getData();" target="_self">��ҳ</a> ';
		if($prepg) 
		{
			$pagenav.=' <a href="javascript:page='.$prepg.';getData();" target="_self">��һҳ</a> ';
		}
		else
		{
			$pagenav.=" ��һҳ ";
		}
		if($nextpg) 
		{
			$pagenav.=' <a href="javascript:page='.$nextpg.';getData();" target="_self">��һҳ</a> ';
		}
		else
		{
			$pagenav.=" ��һҳ ";
		}
		$pagenav.=' <a href="javascript:page='.$lastpg.';getData();" target="_self">βҳ</a> ';
		
	}
}
?>