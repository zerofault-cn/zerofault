#!/bin/sh

function getmodule(){
OBJECT=$2
SOURCE=$1
echo $OBJECT
echo $SOURCE
wget $SOURCE -O temp/$OBJECT.temp -q
FILESIZE=`ls temp/$OBJECT.temp -l|gawk '{print $5}'`
if [ $FILESIZE -gt 500 ]
then
        if [ -f $OBJECT ]
        then
        cp $OBJECT old/$OBJECT.old -f
        fi
        cp temp/$OBJECT.temp $OBJECT -f
fi
}

function checkmodule(){
OBJECT=$1
echo $OBJECT
FILESIZE=`ls temp/$OBJECT.temp -l|gawk '{print $5}'`
if [ $FILESIZE -gt 500 ]
then
        if [ -f $OBJECT ]
        then
        cp $OBJECT old/$OBJECT.old -f
        fi
        cp temp/$OBJECT.temp $OBJECT -f
fi
}

#首页三个赛区票数前10名滚动列表
getmodule http://211.152.19.81/mm2007/mm_hot.php?area=1         mm_hot_wh_gb.html
iconv -f GBK -t utf8 ./mm_hot_wh_gb.html > mm_hot_wh.html;
getmodule http://211.152.19.81/mm2007/mm_hot.php?area=2         mm_hot_hz_gb.html
iconv -f GBK -t utf8 ./mm_hot_hz_gb.html > mm_hot_hz.html;
getmodule http://211.152.19.81/mm2007/mm_hot.php?area=3         mm_hot_sjz_gb.html
iconv -f GBK -t utf8 ./mm_hot_sjz_gb.html > mm_hot_sjz.html;

#三个分赛区页面上4个最新报名用户列表
getmodule http://211.152.19.81/mm2007/mm_list.php?area=1\&type=new\&limit=4             mm_list_new_wh_gb.html
iconv -f GBK -t utf8 ./mm_list_new_wh_gb.html > mm_list_new_wh.html;
getmodule http://211.152.19.81/mm2007/mm_list.php?area=2\&type=new\&limit=4             mm_list_new_hz_gb.html
iconv -f GBK -t utf8 ./mm_list_new_hz_gb.html > mm_list_new_hz.html;
getmodule http://211.152.19.81/mm2007/mm_list.php?area=3\&type=new\&limit=4             mm_list_new_sjz_gb.html
iconv -f GBK -t utf8 ./mm_list_new_sjz_gb.html > mm_list_new_sjz.html;

#三个分赛区页面上票数前8名用户列表
getmodule http://211.152.19.81/mm2007/mm_list.php?area=1\&type=hot\&limit=8             mm_list_hot_wh_gb.html
iconv -f GBK -t utf8 ./mm_list_hot_wh_gb.html > mm_list_hot_wh.html;
getmodule http://211.152.19.81/mm2007/mm_list.php?area=2\&type=hot\&limit=8             mm_list_hot_hz_gb.html
iconv -f GBK -t utf8 ./mm_list_hot_hz_gb.html > mm_list_hot_hz.html;
getmodule http://211.152.19.81/mm2007/mm_list.php?area=3\&type=hot\&limit=8             mm_list_hot_sjz_gb.html
iconv -f GBK -t utf8 ./mm_list_hot_sjz_gb.html > mm_list_hot_sjz.html;

#分赛区页面上5条推荐留言
getmodule http://211.152.19.81/mm2007/comm_list.php?limit=5             comm_list_gb.html
iconv -f GBK -t utf8 ./comm_list_gb.html > comm_list.html;
