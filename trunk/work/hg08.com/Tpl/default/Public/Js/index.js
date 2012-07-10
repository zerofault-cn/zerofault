$(document).ready(function() {

    var autoTabs = true;
    var tagsNum = $(".showCase .showTitle .tabs .item").size();
    var nowTagNum = 0;
    //初始化
    $(".showCase .showTitle .tabs ul").tabs(".showCase .showCont .tagBox",{initialIndex:nowTagNum, current:'tagHover'});

    window.setInterval(function(){
        nowTagNum++;
        if(nowTagNum >= tagsNum){
            nowTagNum = 0;
        }
        if (autoTabs) {
            $(".showCase .showTitle .tabs ul").tabs(".showCase .showCont .tagBox",{initialIndex:nowTagNum, current:'tagHover'});
        }
    }, 5000);

 $("#showCase .showTitle .tabs, #showCase .showCont .tagBox").hover(function(){
        autoTabs = false;
    },function(){
        autoTabs = true;
    });
});

