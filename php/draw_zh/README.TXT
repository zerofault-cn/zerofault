说明：
一、PHP文件

  1.函数
    draw1.0.inc.php
      简单中文输出功能
    draw1.1.inc.php
      添加处理中文与ASCII字符输出功能。ASCII没有使用描点法
    draw2.0.inc.php
      添加输出字符到指定位置功能
    draw2.1.inc.php
      添加指定输出字符的颜色功能
    draw3.0.inc.php
      添加指定输出字符的大小功能。你可以试试输出5×6的图像，跟输出5×5的图像有没有区别？
    drawx.inc.php
      在draw3.0的基础上，实现空心字输出
  2.disp*.php
    对应的函数的测试用例
  3.runtime*.php
    对应的函数的运行花销。
    要查看运行所花时间，需要将图片保存，然后用记事本打开，查看。
    如：
       文件 runtime1.1.gif，内容为：
塒NG

   IHDR  �  ,   讁w�   PLTE   �  ��"   oIDATx滍鸦AC�X�0� 6不P斺Z慧%C誙{e~�#MF�0俎飨�%s�qXHNq襥步�3LV厱酒I麷座抚森�             �?|頕	?�    IEND瓸`侱id nothing in 0.020161986351013 seconds

    那么，时间为0.020161986351013秒。
    具体时间，跟系统有关。

二、系统

    我的系统是：
        PENTIUM III 650MHz
        192MB RAM
        WIN98
        OmniHTTPd Professional

三、优化
    drawstatic.php
    dispstatic.php
    是static做的优化。

    drawx.php是中文空心字显示特效



吴志刚
16:26 2003-07-04