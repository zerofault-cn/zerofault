<?php
if(!function_exists(pageft))
{
	function pageft($totle,$pageitem,$url='')
	{
		global $page,$offset,$pagenav,$_SERVER;
		if(!$page) 
		{
			$page=1;
		}
		if(!$url)
		{
			$url=$_SERVER["REQUEST_URL"];
		}
		$parse_url=parse_url($url);
		$url_query=$parse_url["query"]; //����ȡ��URL�Ĳ�ѯ�ִ�
		if($url_query)
		{
			$url_query=ereg_replace("(^|&)page=$page","",$url_query);
			$url=str_replace($parse_url["query"],$url_query,$url);
			if($url_query) 
			{
				$url.="&page"; 
			}
			else 
			{
				$url.="page";
			}
		}
		else 
		{
			$url.="?page";
		} 
		$lastpg=ceil($totle/$pageitem); //���ҳ��Ҳ����ҳ��
		$page=min($lastpg,$page);
		$prepg=$page-1; //��һҳ
		$nextpg=($page==$lastpg ? 0 : $page+1); //��һҳ
		$offset=($page-1)*$pageitem;
		//$pagenav="��ʾ�� <B>".($totle?($firstcount+1):0)."</B>-<B>".min($firstcount+$displaypg,$totle)."</B> ����¼���� $totle ����¼<BR>";
		if($lastpg<=1) 
		{
			return false;
		}
		$pagenav.=' <a href="'.$url.'=1">��ҳ</a> ';
		if($prepg) 
		{
			$pagenav.=' <a href="'.$url.'='.$prepg.'">��һҳ</a> ';
		}
		else
		{
			$pagenav.=" ��һҳ ";
		}
		if($nextpg) 
		{
			$pagenav.=' <a href="'.$url.'='.$nextpg.'">��һҳ</a> ';
		}
		else
		{
			$pagenav.=" ��һҳ ";
		}
		$pagenav.=' <a href="'.$url.'='.$lastpg.'">βҳ</a> ';
	
		//$pagenav.="(��ǰΪ��".$page."ҳ����".$lastpg."ҳ)";
	
		$pagenav.='��ת����<select name="topage" style="font-size:11px;" onchange="window.location=\''.$url.'=\'+this.value">';
		for($i=1;$i<=$lastpg;$i++)
		{
			if($i==$page) 
			{
				$pagenav.='<option value="'.$i.'" selected>'.$i.'</option>';
			}
			else 
			{
				$pagenav.='<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$pagenav.="</select> ҳ";
	}
}
?>