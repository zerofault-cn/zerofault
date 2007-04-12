<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0047)http://reg.bokee.com/account/web/navigator1.jsp -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>博客文章分类投稿</TITLE>


<META http-equiv=Content-Type content="text/html; charset=gb2312"><LINK 
href="images/style.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript" src="./js/contribute.js"></script>
<STYLE type=text/css>
.dazi {
	FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #0033cc; TEXT-DECORATION: underline
}
.style1 {color: #FF0000}
.STYLE2 {font-size: 10px}
</STYLE>

<META content="MSHTML 6.00.2900.2722" name=GENERATOR></HEAD>
<BODY onbeforeunload=closeIt()>
<DIV class=main>
<!--注册和登录模块开始-->
	<iframe  marginheight=0 marginwidth=0 frameborder=0 width=760px height=38px scrolling=no  src="http://blogs.bokee.com/zhuanti/toubu/index.shtml">
</iframe>
<!--iframe  marginheight=0 marginwidth=0 frameborder=0 width=760px height=32px scrolling=no  src="gb/include-0426/login.html"-->
	</iframe><!--注册和登录模块结束-->
<TABLE height=59 cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
    <TR>
      <TD vAlign=bottom background=images/header.gif>
        <TABLE cellSpacing=0 cellPadding=0 width=181 align=right border=0>
          <TBODY>
            <TR>
              <TD class=headert1 height=26>&nbsp;</TD>
            </TR>
          </TBODY>
      </TABLE></TD>
    </TR>
  </TBODY>
</TABLE>
<p>&nbsp;</p>
<TABLE cellSpacing=0 cellPadding=0 width=760 border=0>
  <TBODY>
  <TR>
    <TD vAlign=top width=215>
      <TABLE cellSpacing=0 cellPadding=0 width=210 border=0>
        <TBODY>
        <TR>
          <TD background=images/myblog.gif height=56>
	<TABLE cellSpacing=0 cellPadding=0 width="75%" align=right 
              border=0><TBODY>
              <TR>
                <TD class=title2>热门分类</TD>
              </TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD background=images/myblogbg.gif>
           <TABLE cellSpacing=0 cellPadding=0 width="93%" align=center 
border=0>
              <TBODY>
              <!-- BEGIN sortList -->
              <TR>
                <TD class=zt1><span style="float:left">·{sortList.CHANNEL}</span><span style="float:right;margin-right:10px;">{sortList.NUM}</span></TD>
              </TR>
              <!-- END sortList -->
              </TBODY></TABLE> 
          </TD></TR>
        <TR>
          <TD><IMG height=10 src="images/mybloged.gif" 
        width=210></TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top rowSpan=3>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" align=right border=0>
        <TBODY>
        <TR>
          <TD>
            <TABLE cellSpacing=0 cellPadding=0 width=544 
            background=images/200604.gif border=0>
              <TBODY>
              <TR>
                <TD vAlign=top align=left><IMG height=7 
                  src="images/200602.gif" width=545></TD></TR>
              <TR>
                <TD align=middle><TABLE height=115 cellSpacing=0 cellPadding=0 width="93%" align=center 
      bgColor=#eceaea border=0>
                  <TBODY>
                    <TR>
                      <TD width="18%">
                      {HINT}
                      </TD>
              </TR>
              <TR>
                <TD vAlign=bottom align=left><IMG height=7 
                  src="images/200603.gif" 
        width=545></TD></TR></TBODY></TABLE>
            <br>
            <TABLE cellSpacing=0 cellPadding=0 width=544 
            background=images/200604.gif border=0>
              <TBODY>
                <TR>
                  <TD vAlign=top align=left><IMG height=7 
                  src="images/200602.gif" width=545></TD>
                </TR>
                <TR>
                  <TD align=middle>  
<span class="zt1">{message}{vusername}</span>       
      <form name="addForm" action="{Query}" method=post onSubmit="return checkAddForm();" enctype="multipart/form-data" {disabled}>
      <TABLE cellSpacing=0 cellPadding=0 width=90% align=center border=0>
        <TBODY>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>文章标题：</DIV></TD>
          <TD width=402><INPUT id=article_title name=article_title size="50"> <SPAN 
            class=linktext><SPAN class=xing style1><font color=red>*</font></SPAN></SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>文章链接地址：</DIV></TD>
          <TD width=402><INPUT id=article_link name=article_link size="50" value="http://">
                      <SPAN class=linktext><font color=red>*</font></SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>博客名称：</DIV></TD>
          <TD width=402><INPUT id=blog_name name=blog_name size="50"> <SPAN 
            class=linktext><SPAN class=xing style1><font color=red>*</font></SPAN></SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
          </TD>
          <TD width=402>
<INPUT type="hidden" id=blog_link name=blog_link size="50"  value="http://{vusername}.bokee.com">
           </TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD bgColor=#f4f4f4 height=27><div align="right"><span class="hongtextg">分类/频道：</span></div></TD>
          <TD>最多可同时选择三个频道 <SPAN class=linktext><SPAN 
            class=xing style1><font color=red>*</font></SPAN></SPAN></TD>
        </TR>
        <TR class="zt1">
          <TD bgColor=#f4f4f4 height=27><div align="right"><span class="hongtextg"><SPAN class=linktext></SPAN></span></div></TD>
          <TD>
          <!-- BEGIN channelList -->
          <INPUT type=checkbox  value={channelList.CHANNELID} name="channel[]">
            {channelList.CHANNELNAME} 
          <!-- END channelList -->
	 </TD>
        </TR>
	<TR class="zt1"><TD></TD><TD height="30"><span class="hongtextg"><font color=red>(以下项目为选填)</font></span></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>姓名：</DIV></TD>
          <TD width=402><INPUT id=user_name name=user_name size="50"> <SPAN 
            class=linktext></SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=27>
            <DIV align=right>证件种类：</DIV></TD>
          <TD width=402><SELECT class=input3 id=certify_type 
            name=certify_type> <OPTION value="身份证" selected>身份证</OPTION> <OPTION 
              value="军官证">军官证</OPTION> <OPTION value="学生证">学生证</OPTION></SELECT></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>证件号码：</DIV></TD>
          <TD width=402><INPUT id=certify_num name=certify_num size="50"></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD width=89 bgColor=#f4f4f4 height=27>
            <DIV class=hongtextg align=right>联系地址：</DIV></TD>
          <TD width=402><INPUT id=contact_address name=contact_address size="50"></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=27>
            <DIV align=right>邮编：</DIV></TD>
          <TD width=402><INPUT id=contact_post name=contact_post size="50"></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=27>
            <DIV align=right>联系电话：</DIV></TD>
          <TD width=402><INPUT id=contact_phone name=contact_phone size="50"> <SPAN 
            class=linktext></SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=27>
            <DIV align=right>E-mail：</DIV></TD>
          <TD width=402><SPAN class=linktext><INPUT id=contact_email name=contact_email size="50">
           </SPAN></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=27>
            <DIV align=right>其它联系方式：</DIV></TD>
          <TD width=402><INPUT id=contact_other name=contact_other size="50"></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD  colSpan=2 height=1></TD></TR>
        <TR class="zt1">
          <TD class=hongtextg width=89 bgColor=#f4f4f4 height=32>&nbsp;</TD>
          <TD width=402>&nbsp; <INPUT id=Submit type=submit value=提交 name=Submit> 　 <INPUT type=reset value=重填 name=Submit3> </TD></TR>
        <TR>
          <TD  colSpan=2 
        height=1></TD></TR></TBODY></TABLE>
                  </FORM></TD>
                </TR>
                <TR>
                  <TD vAlign=bottom align=left><IMG height=7 
                  src="images/200603.gif" 
        width=545></TD>
                </TR>
              </TBODY>
            </TABLE>
            <p>&nbsp;</p></TD></TR>
        <TR>
          <TD height=5></TD></TR>
        <TR>
          <TD align=left>
            <TABLE cellSpacing=0 cellPadding=0 width=325 align=left border=0>
              <TBODY>
              <TR>
                <TD height=28 valign="middle" background=images/changeh.gif><span class="title2">·最新文章</span>
                  <TABLE cellSpacing=0 cellPadding=0 width="50%" align=right 
                  border=0>
                    <TBODY>
                    <TR>                    </TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD vAlign=bottom background=images/changebg.gif 
height=244>
                  <TABLE height=233 cellSpacing=0 cellPadding=0 width=310 
                  align=center border=0>
                    <TBODY>
                    <TR>
                      <TD background=images/table1bg.gif>
                        <TABLE height=233 cellSpacing=0 cellPadding=0 
                        width="98%" align=right border=0>
                          <TBODY>
                          <TR>
                            <TD class=th1 width=71 height=29>作者</TD>
                            <TD class=th2 width=233><div align="center"><span class="th1">文章标题</span></div></TD>
                          </TR>
                          <!-- BEGIN newList -->
                          <TR>
                            <TD class=th1 width=71 height=29><span class="zt1">{newList.AUTHOR}</span></TD>
                            <TD class=th2><span class="zt1"><A href="{newList.LINK}" target="_blank" title="{newList.TITLE0}">·{newList.TITLE}</A></span></TD>
                          </TR>
                          <!-- END newList -->
			</TBODY></TABLE><!-----11.17-----><!-----11.17-----></TD></TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD><IMG height=8 src="images/changeed.gif" 
              width=325></TD></TR></TBODY></TABLE>
            <TABLE cellSpacing=0 cellPadding=0 width=180 align=right border=0>
              <TBODY>
              <TR>
                <TD width=180 background=images/changeh.gif 
                height=28><span class="title2">·更多文章</span> </TD>
              </TR>
              <TR>
                <TD vAlign=bottom background=images/bbsbg.gif height=244>
                  <TABLE cellSpacing=0 cellPadding=0 width=200 align=center 
                  border=0>
                    <TBODY>
                    <TR>
                      <TD background="" height=233>
			{MOREARTICLE}
			</TD></TR></TBODY></TABLE></TD></TR>
              <TR>
                <TD><IMG height=8 src="images/bbsed.gif" 
              width=215></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD height=5></TD></TR>
        <TR>
          <TD>
            <TABLE height=61 cellSpacing=0 cellPadding=0 width=545 
            background=images/boosobg.gif border=0>
              <TBODY>
              <TR>
                <TD>
                  <TABLE cellSpacing=0 cellPadding=0 width="70%" align=right 
                  border=0>
                    <TBODY>
                    <TR>
                      <TD width="79%">
                        <FORM action=http://www.booso.com/search
                        method=get><INPUT class=input3 name=keyword> <TD align=left width="21%"><INPUT 
                        onclick=javascript:doIt(); type=image height=25 width=66 
                        src="images/bn3.gif" border=none> </TD><INPUT 
                      type=hidden value=1 name=blogspan> <INPUT type=hidden 
                      value=1 name=rssspan> <INPUT type=hidden value=1 
                      name=imagespan> <INPUT type=hidden value=any 
                      name=category> <INPUT type=hidden value=1 name=sorttype> 
                        <input type="hidden" name="radiobutton" value="orderByRelate">
                      <INPUT type=hidden value=main 
                  name=type></FORM></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD height=5></TD></TR>
        <TR>
          <TD>{AD}</TD>
        </TR></TBODY></TABLE></TD></TR>
  <TR>
    <TD height=5></TD></TR>
  <TR>
    <TD vAlign=top>
      <TABLE cellSpacing=0 cellPadding=0 width=210 border=0>
        <TBODY>
        <TR>
          <TD background=images/myrss.gif height=56>
            <TABLE cellSpacing=0 cellPadding=0 width="75%" align=right 
              border=0><TBODY>
              <TR>
                <TD class=title2>本月热门作者</TD>
              </TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD background=images/myblogbg.gif>
            <TABLE cellSpacing=0 cellPadding=0 width="93%" align=center 
border=0>
              <TBODY>
              <!-- BEGIN authorList -->
              <TR>
                <TD class=zt1><span style="float:left">·<A href="{authorList.LINK}" target="_blank">{authorList.AUTHOR}</a></span><span style="float:right;margin-right:10px">{authorList.NUM}</span></TD>
              </TR>
              <!-- END authorList -->
              </TBODY></TABLE>
          </TD></TR>
        <TR>
          <TD><IMG height=10 src="images/mybloged.gif" 
        width=210></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><!--页尾--><!--#include virtual="/include/channelfooter.shtml" -->
<DIV id=footer><A href="mailto:ceditor@bokee.com">主编信箱</A> | <A 
href="http://www.bokee.com/new/about/aboutus.html">关于本站</A> | <A 
href="http://adimage.bokee.com/images/ad/minisite/service/serve.htm">广告服务</A> | 
<A href="http://www.bokee.com/new/about/contact.html">联系我们</A> | <A 
href="http://www.bokee.com/new/about/service.htm">服务条款</A> | <A 
href="http://www.bokee.com/new/about/privacy.htm">隐私保护</A> | <A 
href="http://service.bokee.com/">客服中心</A> | <A 
href="http://column.bokee.com/37233.html">人员招聘 </A>| <A 
href="http://www.bokee.com/new/about/morelink.htm">友情链接</A> | <A 
href="http://www.bokee.com/new/about/sitemap.html">导航</A> | <A 
href="http://publishblog.bokee.com/reg.b">注册</A></DIV>
<DIV id=copyright>
<P>Copyright 2002 - 2005 Bokee.com, All Rights Reserved</P>
<P>增值电信业务经营许可证编号：B2-20050016</P>
<P><IMG alt=京ICP证040883号 src="images/icp.gif"><A 
href="http://www.hd315.gov.cn/beian/view.asp?bianhao=010202004121300015">京ICP证040883号</A> 
<A href="http://net.china.cn/chinese/index.htm"><IMG alt=不良信息举报中心 
src="images/netcn.jpg" border=0></A> <A href="http://www.allyes.com/"><IMG 
alt=好耶广告网络 src="images/allyes.gif" 
border=0></A></P></DIV></DIV></BODY></HTML>
