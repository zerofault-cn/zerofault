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

getmodule http://mm.bokee.com/xiu/mm2006/user_list.php\?type=hot\&limit=8          mm_hot_gb.html
iconv -f GBK -t utf8 ./mm_hot_gb.html > mm_hot.html;
getmodule http://mm.bokee.com/xiu/mm2006/user_list.php\?type=new\&limit=8          mm_new_gb.html
iconv -f GBK -t utf8 ./mm_new_gb.html > mm_new.html;

getmodule http://mm.bokee.com/xiu/mm2006/ph_list.php\?type=vote            ph_list_vote_gb.html
iconv -f GBK -t utf8 ./ph_list_vote_gb.html > ph_list_vote.html;
getmodule http://mm.bokee.com/xiu/mm2006/ph_list.php\?type=msg             ph_list_msg_gb.html
iconv -f GBK -t utf8 ./ph_list_msg_gb.html > ph_list_msg.html;
getmodule http://mm.bokee.com/xiu/mm2006/ph_list.php\?type=monthvote             ph_list_month_gb.html
iconv -f GBK -t utf8 ./ph_list_month_gb.html > ph_list_month.html;

getmodule http://mm.bokee.com/xiu/mm2006/comm_list.php\?type=mark             comm_list_mark_gb.html
iconv -f GBK -t utf8 ./comm_list_mark_gb.html > comm_list_mark.html;
getmodule http://mm.bokee.com/xiu/mm2006/comm_list.php\?type=new             comm_list_new_gb.html
iconv -f GBK -t utf8 ./comm_list_new_gb.html > comm_list_new.html;
