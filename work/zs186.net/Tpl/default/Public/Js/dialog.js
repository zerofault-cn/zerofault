/*
Lee dialog 1.0 http://www.xij.cn/blog/?p=68
content
url: get或post某一页面里的html，该页面要求只包含body的子标签
text: 直接写入内容
id: 显示页面里某id的子标签
iframe: 层内内容以框架显示
 */
var dialogFirst=true;
var maxtime=5;
var timer;
function dialog(title,type,content,width,height,cssName,autofade,closefun){
    if(dialogFirst==true){
        var temp_float=new String;
        temp_float="<div id=\"floatBoxBg\" style=\"height:"+$(document).height()+"px;filter:alpha(opacity=0);opacity:0;\">";
        temp_float+="<iframe id='bgframe' scrolling='no' frameborder='0' style='position:absolute;width:100%;height:100%;z-index:-1;_filter:alpha(opacity=0);opacity=0;border-style:none;'></iframe></div>";
        temp_float+="<div id=\"floatBox\" class=\"floatBox\" >";
        temp_float+="<div class=\"up-bar\" style=\"width:160px;height:89px;\"><div class=\"up-left png_bg\"></div><div class=\"up-right png_bg\"></div><div class=\"down-left png_bg\"></div><div class=\"down-right png_bg\"></div></div>";
        temp_float+="<div class=\"down-bar\" style=\"width:196px;height:60px;\">";
        temp_float+="<div class=\"title\"><h4></h4><span><abbr id=\"ct\"></abbr><img src='"+IMAGE_FOLDER+"cancel.gif' align='absmiddle'/></span></div>";
        temp_float+="<div class=\"content\" style=\"\"></div>";
        temp_float+="<div class=\"popfoot\"><input type=\"button\" onclick=\"closepopdiv()\">&nbsp;</div>";
        temp_float+="</div>";
        $("body").appendTo(temp_float);
        dialogFirst=false;
    }
    maxtime=5;
    $("#ct").text("");
    clearInterval(timer);
    $("#floatBox .title span").unbind( "click" );
    $("#floatBox .title span").click(function(){
        $("#floatBoxBg").animate({
            opacity:0
        },0,function(){
            $(this).css("display","none");
        });
        $("#floatBox").css({
            display:"none"
        });
        clearInterval(timer);
        if(closefun){
            eval(closefun);
        }
    });

    $("#floatBox .title h4").html(title);
    switch(type){
        case "url":
            $("#floatBox .content").ajaxStart(function(){
                $(this).html("请稍等...");
            });
            $.ajax({
                type:content.t,
                url:content.u,
                data:content.d,
                dataType:"html",
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    $("#floatBox .content").html("网站返回错误！"+errorThrown+textStatus+XMLHttpRequest);
                },
                success:function(html){
                    $("#floatBox .content").html(html);
                }
            });
            break;
        case "text":
            $("#floatBox .content").html(content);
            break;
        case "id":
            $("#floatBox .content").html($("#"+content+"").html());
            break;
        case "iframe":
            $("#floatBox .content").css({
                width:(width=="auto"?140:parseInt(width)+140)+"px",
                height:(height=="auto"?30:parseInt(height)+30)+"px"
            });
            $("#floatBox .content").html("<iframe id=\"popiframe\" width=\"100%\" height=\""+(parseInt(height)+30)+"px"+"\" scrolling=\"auto\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>");
            $("#popiframe").attr("src",content);
    }
    $("#floatBoxBg").show().animate({
        opacity:"0.3"
    },"normal");
    if(!autofade){
        $("#floatBox .popfoot").css("display","none");
    }else
    {
        $("#floatBox .popfoot").css("display","block");
        timer = setInterval("CountDown()",1000);
    }
    if($.browser.msie && ($.browser.version == "6.0"))
	{
            $("#floatBox .up-bar").css({
                width:(width=="auto"?160:parseInt(width)+160)+"px",
                height:(height=="auto"?89:parseInt(height)+89)+"px"
            });
            $("#floatBox .down-bar").css({
                width:(width=="auto"?195:parseInt(width)+195)+"px",
                height:(height=="auto"?60:parseInt(height)+60)+"px"
            });
            $("#floatBox .down-left").css({
                height:"20px",
                bottom:"-6px"
            });
            $("#floatBox .down-right").css({
                height:"20px",
                bottom:"-6px"
            });
	}
        else
	{
            $("#floatBox .up-bar").css({
                width:(width=="auto"?160:parseInt(width)+160)+"px",
                height:(height=="auto"?89:parseInt(height)+89)+"px"
            });
            $("#floatBox .down-bar").css({
                width:(width=="auto"?196:parseInt(width)+196)+"px",
                height:(height=="auto"?60:parseInt(height)+60)+"px"
            });
        }
    $("#floatBox").css({
        display:"block",
        left:(($(document).width())/2-(parseInt(width)+160)/2)+"px",
        top:($(document).scrollTop()+122)+"px"
    });
}
function closepopdiv()
{
    $("#floatBox .title span").trigger("click") ;
}
function CountDown(){   
    if(maxtime>=0){
        $("#ct").text("("+maxtime+')');
        --maxtime;
    }
    else{   
        $("#ct").text("");
        $("#floatBox .title span").trigger("click");
    }   
} 
function correctPNG() 
{
    for(var i=0; i<document.images.length; i++)
    {
        var img = document.images[i]
        var imgName = img.src.toUpperCase()
        if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
        { 
            var imgID = (img.id) ? "id='" + img.id + "' " : "";
            var imgClass = (img.className) ? "class='" + img.className + "' " : "";
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' ";
            var imgStyle = "display:inline-block;" + img.style.cssText;
            if (img.align == "left") imgStyle = "float:left;" + imgStyle;
            if (img.align == "right") imgStyle = "float:right;" + imgStyle;
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle;
            var strNewHTML = "<span "+ imgID + imgClass + imgTitle + "style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";" 
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader" + "(src='" + img.src + "');\"></span>";
            img.outerHTML = strNewHTML;
        }
    }
}