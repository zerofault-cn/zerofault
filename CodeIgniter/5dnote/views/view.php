<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?=$title?>我的网络笔记本</title>
	<meta http-equiv="content-type" content="text/html; charset=gb2312" />
	<meta name="keywords" content="网络收藏夹" />
	<meta name="description" content="快速, 简洁, web2.0, 做最好的网络收藏夹. Favorites是一个提供用户收藏, 推荐, 共享网络资源的平台。除了原本的网页收藏, Favorites中加入了图片、音乐和视频收藏的功能，同时用户还可以拥有自己的好友名单,使用户间可以方便的共享网络资源。" />
	<link rel="alternate" type="application/rss+xml" title="zerofault的网络笔记本" href="rss/" />
	<link rel="icon" type="image/x-icon" href="media/favicon.ico" />
	<link rel="Shortcut Icon" type="image/x-icon" href="media/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="media/style.css" />
	<script language="javascript" type="text/javascript" src="media/jquery-1.2.6.pack.js"></script>
</head>
<body>
	<div id="toper">
		<a href="/" id="logo"><img alt="my favorites" src="media/logo.gif" /></a>
		<?php if($_COOKIE['isAdmin']): ?>
			<a href="/add?type=<?=$type?>">添加</a>
		<?php endif; ?>
		<a href="<?=$auth_url?>" class="lm"><?=$auth_text?></a>
	</div>
	<?php include $type.".php";?>
	<div class="clear"></div>
	<div id="footer">
		<a href="/" class="fm">首页</a>
		<a href="#">帮助</a>
		<a href="mailto://zerofault@gmail.com" >联系我</a>
		<br />
		<img src="http://code.google.com/appengine/images/appengine-noborder-120x30.gif" alt="Google App Engine 支持" />
    </div>
</body>
<iframe id="iframe1" name="iframe1" style="display:none;"></iframe>
<script language="javascript" type="text/javascript" defer>
function submit_del(obj){
	$(obj).parent().after('<span style="color:red">正在删除，请稍候...</span>');
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