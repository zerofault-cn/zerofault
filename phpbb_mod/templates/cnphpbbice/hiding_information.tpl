<!-- BEGIN selling -->
	<form method="post" action="{selling.S_BUYPOST_ACTION}"> 
	<table cellpadding="2" cellspacing="1" class="forumline" nowrap><tr><td class="row2" colspan="2" align="center"><span class="gen">{selling.L_SELL_DESCRIPTION}</span></td></tr><tr><td class="row1"><span class="gen"><b>{selling.L_SELLING_PRICE}&nbsp;{selling.SELLING_PRICE}</b></span></td><td class="row1" align="right"><input type="hidden" name="p" value="{selling.U_POST_ID}"><input type="submit" name="buypost" value="{selling.L_BUY}"></td></tr></table></form>
<!-- END selling -->
<!-- BEGIN bought -->
	<br /><br />
	<table cellpadding="2" cellspacing="1" class="forumline" nowrap><tr><td class="row1" align="center"><span class="gen"><b>{bought.L_SELLING_PRICE}&nbsp;{bought.SELLING_PRICE}</b>&nbsp;&nbsp;</span></td><td class="row1"><span class="gen">{bought.L_BOUGHT_DESCRIPTION}</span></td></tr></table>
<!-- END bought -->
<!-- BEGIN simple_hiding_box -->
	<br /><br />
	<table cellpadding="2" cellspacing="1" class="forumline" nowrap><tr><td class="row1" align="center"><span class="gen">{simple_hiding_box.L_HIDING_DESCRIPTION}</span></td></tr></table>
<!-- END simple_hiding_box -->
