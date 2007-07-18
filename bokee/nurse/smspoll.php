<?
$id=sprintf("%05d",$_REQUEST['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>感动社会十大护士评选</title>
<link href="../images/hushi.css" rel="stylesheet" type="text/css" />
<link href="../images/bao.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.STYLE1 {
	font-size: 16px;
	color: #EE1D78;
	font-weight: bold;
}
.STYLE2 {
	font-size: 16px;
	font-weight: bold;
	color: #FCFEFC;
}
.STYLE3 {font-size: 16px}
-->
</style>
</head>

<body>
	<!--主框架 -->
	<div id="container" style="width:700px;">
		<!--内容-->
		<div class="con" style="width:700px;">
			<div class="baodtit">
				<h2>投票方法</h2>
			</div>	
			<div class="bmdiv">
				<div class="baotop"></div>
				<div class="baocon">
					<div class="baotext">
					<h2 class="STYLE3">本次大赛短信投票收入将捐献给护士基金</h2>
					</div>
					<p>
						（1）投票时间：选手必须在投票规定时间以内投票，投票时间以外的短信投票将不计入票数统计中；<br />
						（2）短信投票方法：<br />
						<p style="margin-left:2em">
							为<span style="color:#FF33CC;text-decoration:underline;"><?=$id?></span>号选手一次投1票，联通用户编辑“<span style="color:red;text-decoration:underline;">HS<?=$id?></span>”发送到9951 （资费：1元/次）<br />
							为<span style="color:#FF33CC;text-decoration:underline;"><?=$id?></span>号选手一次投1票，移动用户编辑“<span style="color:red;text-decoration:underline;">HS<?=$id?></span>”发送到10665110   （资费：1元/次）<br />
							为<span style="color:#FF33CC;text-decoration:underline;"><?=$id?></span>号选手一次投5票，联通用户编辑“<span style="color:red;text-decoration:underline;">HS<?=$id?></span>”发送到9951   （资费：5元/次）<br />
							为<span style="color:#FF33CC;text-decoration:underline;"><?=$id?></span>号选手一次投5票，移动用户编辑“<span style="color:red;text-decoration:underline;">HS<?=$id?></span>”发送到10665110   （资费：5元/次）
						</p>
					</p>
					<p>每天同一号码：限投30票<br />
					每月同一号码：限投30票<br />
					提示：如果您的投票超过30票/日、30票/月的限制，系统将不再回复。客服：010-51818877<br />
					</p>
				</div>
				<div class="baobot"></div>
			</div>
		</div>
	</div>
</body>
</html>
