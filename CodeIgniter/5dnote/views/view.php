<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$title?>�ҵ�����ʼǱ�</title>
	<meta http-equiv="content-type" content="text/html; charset=gb2312" />
	<meta name="keywords" content="�����ղؼ�" />
	<meta name="description" content="����, ���, web2.0, ����õ������ղؼ�. Favorites��һ���ṩ�û��ղ�, �Ƽ�, ����������Դ��ƽ̨������ԭ������ҳ�ղ�, Favorites�м�����ͼƬ�����ֺ���Ƶ�ղصĹ��ܣ�ͬʱ�û�������ӵ���Լ��ĺ�������,ʹ�û�����Է���Ĺ���������Դ��" />
	<link rel="alternate" type="application/rss+xml" title="zerofault������ʼǱ�" href="rss/" />
	<link rel="icon" type="image/x-icon" href="media/favicon.ico" />
	<link rel="Shortcut Icon" type="image/x-icon" href="media/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="media/style.css" />
	<script language="javascript" type="text/javascript" src="media/jquery-1.2.6.pack.js"></script>
</head>
<body>
	<div id="toper">
		<a href="/" id="logo"><img alt="my favorites" src="media/logo.gif" /></a>
		<?php if($_COOKIE['isAdmin']): ?>
			<a href="/add?type=<?=$type?>">���</a>
		<?php endif; ?>
		<a href="<?=$auth_url?>" class="lm"><?=$auth_text?></a>
	</div>
	<?php include $type.".php";?>
	<div class="clear"></div>
	<div id="footer">
		<a href="/" class="fm">��ҳ</a>
		<a href="#">����</a>
		<a href="mailto://zerofault@gmail.com" >��ϵ��</a>
		<br />
		<img src="http://code.google.com/appengine/images/appengine-noborder-120x30.gif" alt="Google App Engine ֧��" />
    </div>
</body>
<iframe id="iframe1" name="iframe1" style="display:none;"></iframe>
<script language="javascript" type="text/javascript" defer>
function submit_del(obj){
	$(obj).parent().after('<span style="color:red">����ɾ�������Ժ�...</span>');
	key=$(obj).attr('value');
	$.get("/delkey",{
		key : key
		},function(str){
			if(str == '1')
			{
				$("#item_"+key).hide('slow');
				//$("#item_"+key).remove();
			}
			else if(str == '0')
			{
				alert('No such entry/key!');
			}
			else if(str == '-1')
			{
				alert('The entry is not yours!');
			}
			else
			{
			}
		});
}
</script>
</html>