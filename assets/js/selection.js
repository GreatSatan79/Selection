$(document).ready(function() {
    var url = location.href; //当前url
    var video_page = /.*#(\d+)$/.exec(url); //正则查找	
    if (video_page != null) {
            url = url.replace(/#\d+$/i, ""); //正则删除链接后面的#XXX
            updateVideo($(".video" + video_page[1]).attr("data-video")); //更新播放视频地址
            $(".Car-listSkip a").removeAttr("style");
            $(".video" + video_page[1]).css("background", "#00bcd4");
    } else {
            updateVideo($(".video1").attr("data-video")); //默认播放第一个视频
            $("a.video1").css("background", "#00bcd4");
    }
    $(".Car-listSkip a").click(function() {
            updateVideo($(this).attr("data-video")); //更新播放视频地址
            $(".Car-listSkip a").removeAttr("style");
            $(this).css("background", "#00bcd4");
            document.location.href = url + "#" + ($(this).attr("value")); //改变url
    });
});