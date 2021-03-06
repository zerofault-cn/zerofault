<a name="top"></a>
<script language="javascript" type="text/javascript" src="js/checkform.js"></script>
<form name="form1" action="" method="post" enctype="multipart/form-data" onsubmit="return check()">
  <h4 class="title-l-1" id="protocol_head">报名第三步</h4>
  <div id="protocol_outside">
    <div id="protocol_inside">
      <h2>特别提示</h2>
      <em></em>1、以本人在博客网的个人博客参加本次评选，也可推荐他人的博客参赛； <br>
2、正确填写您的博客名称（八个字以内）和博客链接地址；  <br>
3、请完全真实的填写您的个人资料，以便颁发奖项；  <br>
4、正确选择您的参赛地区；  <br>
5、带“<em>＊</em>”为必填项； <br>
<em>6、特别注意：请正确填写您的博客连接地址与邮箱，报名后在该邮箱会有系统提示是否报名成功；</em> <br>
      <ul>
        <li><span>参选博客名称：</span>
          <input name="blogname" type="text" class="input_s" value="" />
          <em>＊</em></li>
        <li><span>博客链接地址：</span>
          <input name="blogurl" type="text" class="input_s" value="http://" onchange="checkurl(this.value)" onblur="checkurl(this.value)" />
          <em>＊</em><em id="blogurl_msg"></em></li>
        <li><span>真实姓名：</span>
          <input name="realname" type="text" class="input_s" value="" />
        <em>＊</em> </li>
        <li><span>年龄：</span>
          <input name="age" type="text" class="input_s" value="" />
        </li>
        <li><span>身高：</span>
          <input name="height" type="text" class="input_s" value="" />
        </li>
        <li><span>体重：</span>
          <input name="weight" type="text" class="input_s" value="" />
        </li>
        <li><span>报名地区：</span>
          <select name="area">
		    <option value="">请选择</option>
            <option value="1">武汉</option>
            <option value="2">杭州</option>
			<option value="3">石家庄</option>
          </select>
          <em>＊</em></li>
        <li><span>证件种类：</span>
          <select name="certitype">
		    <option value="">请选择</option>
            <option value="1">身份证</option>
            <option value="2">学生证</option>
          </select>
        </li>
        <li><span>证件号码：</span>
          <input name="certinum" type="text" class="input_s" value="" />
        </li>
        <li><span>联系地址：</span>
          <input name="address" type="text" class="input_l" value="" />
        </li>
        <li><span>邮编：</span>
          <input name="postcode" type="text" class="input_s" value="" />
        </li>
        <li><span>联系电话：</span>
          <input name="telenum" type="text" class="input_s" value="" onchange="checknum(this.value)" onblur="checknum(this.value)" />
          <em>＊</em><em id="telenum_msg"></em></li>
        <li><span>E_mail：</span>
          <input name="email" type="text" class="input_s" value="" />
         <em>＊</em></li>
        <li><span>其他联系方式：</span>
          <input name="other" type="text" class="input_m" value="" />
          <em>（MSN或QQ）</em></li>
        <li><span>英语水平：</span>
          <input name="english" type="text" class="input_s" value="" />
        </li>
        <li><span>普通话水平：</span>
          <input name="putonghua" type="text" class="input_s" value=""/>
        </li>
        <li><span>个人特长：</span>
          <input name="intro" type="text" class="input_s" value="" />
        </li>
        <li><span>上传照片：</span>
          <input name="photo" type="file" class="input_s" /><em>＊</em>（照片尺寸:130*130）
          </li>
      </ul>
    </div>
  </div>
<h5 id="protocol_foot"><input type="submit" name="submit" value="提交" class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重填" class="btn"/></h5>
</form>
<iframe id="iframe1" frameborder="0" allowTransparency="true" scrolling="no" width="0" height="0" src=""></iframe>