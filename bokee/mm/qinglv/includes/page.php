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
		$url_query=$parse_url["query"]; //单独取出URL的查询字串
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
		$lastpg=ceil($totle/$pageitem); //最后页，也是总页数
		$page=min($lastpg,$page);
		$prepg=$page-1; //上一页
		$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
		$offset=($page-1)*$pageitem;
		//$pagenav="显示第 <B>".($totle?($firstcount+1):0)."</B>-<B>".min($firstcount+$displaypg,$totle)."</B> 条记录，共 $totle 条记录<BR>";
		if($lastpg<=1) 
		{
			return false;
		}
		$pagenav.=' <a href="'.$url.'=1">首页</a> ';
		if($prepg) 
		{
			$pagenav.=' <a href="'.$url.'='.$prepg.'">上一页</a> ';
		}
		else
		{
			$pagenav.=" 上一页 ";
		}
		if($nextpg) 
		{
			$pagenav.=' <a href="'.$url.'='.$nextpg.'">下一页</a> ';
		}
		else
		{
			$pagenav.=" 下一页 ";
		}
		$pagenav.=' <a href="'.$url.'='.$lastpg.'">尾页</a> ';
	
		//$pagenav.="(当前为第".$page."页　共".$lastpg."页)";
	
		$pagenav.='　转到第<select name="topage" style="font-size:11px;" onchange="window.location=\''.$url.'=\'+this.value">';
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
		$pagenav.="</select> 页";
	}
}
?>