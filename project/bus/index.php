<html>
<head>
<title>���ݹ�����·��ѯ���ֻ�ʵʱ��</title>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query" />
<input type="hidden" name="url" value="" />
������·��ţ�<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="��ѯ" />
</form>
<?php
$action=$_REQUEST['action'];
$url=$_REQUEST['url'];
if('query'==$action)
{
	include_once 'simple_html_dom.php';
	$c = curl_init();
	curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
	curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	$line_name=intval(trim($_REQUEST['line_name']));
	if($line_name>0)
	{
		curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$line_name);
		$data = curl_exec($c);
		$html=str_get_html($data);//'4.html'
		$table=$html->find('table[width="98%"] table',0);
		$descr=$table->children(1)->plaintext;
		if(strlen(trim($descr))<2)
		{
			echo '����·��δ��ͨ��';
		}
		else
		{
			echo $descr;
			echo '<br />';
			$route_arr=$table->children(2)->find('table[bgcolor="3E89C0"]');
			foreach($route_arr as $r=>$route)
			{
				$tr_arr=$route->children();
				foreach($tr_arr as $row=>$tr)
				{
					if($row==0)
					{
						echo '<span style="color:blue">';
						if($r==0)
						{
							echo '���У�';
						}
						else
						{
							echo '���У�';
						}
						echo $tr->plaintext;
						echo '��</span><br />';
					}
					elseif($row==1)
					{
						continue;
					}
					else
					{
						echo trim($tr->children(1)->plaintext);
					}
					if($row!=0 && $row!=(sizeof($tr_arr)-1))
					{
						echo '��';
					}
				}
				echo '</br /></br />';
			}
		}
	}
	curl_close($c);
echo '<br /><br /><br />������Ŀǰ��������<span style="color:red">ʵʱ</span>��Դ�ں��ݹ���������վ(http://www.hzbus.com.cn)�����˽���ѧϰ�����ã���Ȩ����ԭ��վ<br />';
echo '�����Ի��Ĺ������˲�ѯ�������ڿ����У������ڴ�...<br />';
}
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">�ҵ�BLOG</a>
</body>
</html>