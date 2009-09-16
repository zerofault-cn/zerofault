<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo L('_SYSTEM_FAILURE_')?></title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="Generator" content="EditPlus"/>
<style>
body{
	font-family: Verdana;
	font-size:14px;
}
a{text-decoration:none;color:#174B73;}
a:hover{ text-decoration:none;color:#FF6600;}
h2{
	border-bottom:1px solid #DDD;
	padding:8px 0;
    font-size:25px;
}
.title{
	margin:4px 0;
	color:#F60;
	font-weight:bold;
}
.message,#trace{
	padding:1em;
	border:solid 1px #000;
	margin:10px 0;
	background:#FFD;
	line-height:150%;
}
.message{
	background:#FFD;
	color:#2E2E2E;
		border:1px solid #E0E0E0; 
}
#trace{
	background:#E7F7FF;
	border:1px solid #E0E0E0; 
	color:#535353;
}
.notice{
    padding:10px;	
	margin:5px; 
	color:#666; 
	background:#FCFCFC; 
	border:1px solid #E0E0E0; 
}
.red{
	color:red;
	font-weight:bold;
}
</style>
</head>
<body>
<div class="notice">
<h2><?php echo L('_SYSTEM_FAILURE_')?> </h2>
<div ><?php echo L('_YOU_CAN_')?>  [ <A HREF="<?php echo($_SERVER['PHP_SELF'])?>"><?php echo L('_REFRESH_')?></A> ] [ <A HREF="javascript:history.back()"><?php echo L('_BACK_')?></A> ] <?php echo L('_OR_')?> [ <A HREF="<?php echo(__APP__);?>"><?php echo L('_GO_HOME_')?></A> ]</div>
<?php if(isset($e['file'])) {?>
<p><strong><?php echo L('_ERROR_POSITION_')?>:</strong>　FILE: <span class="red"><?php echo $e['file'] ;?></span>　LINE: <span class="red"><?php echo $e['line'];?></span></p>
<?php }?>
<p class="title">[ <?php echo L('_ERROR_INFO_')?> ]</p>
<p class="message"><?php echo $e['message'];?></p>
<?php if(isset($e['trace'])) {?>
<p class="title">[ TRACE ]</p>
<p id="trace">
<?php echo nl2br($e['trace']);?>
</p>	
<?php }?>
</div>
<div align="center" style="color:#FF3300;margin:5pt;font-weight:bold"> ThinkPHP <sup style='color:gray;font-size:9pt'><?php echo THINK_VERSION;?></sup><span style='color:silver'> { Fast,Compatible & Simple OOP PHP Framework }</span>
</div>
</body>
</html>
