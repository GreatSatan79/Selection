<?php
/*
Plugin Name: Selection(7B2版)
Plugin URI: https://saigaocy.me/
Description: 本插件基于7B2主题开发而成 
Version: 超装逼的至尊VIP
Author: 79
Author URI: https://saigaocy.me/
*/

//引用后台配置文件
require_once __DIR__ . '/options/options.php';

/*
短代码判断
*/
add_shortcode('xj', 'selection');
function selection($array_url_title)
{
    $vide_data = get_option('selection');
    $vide_data_ar = array();
    if ($vide_data) {
        $vide_data_ar = json_decode($vide_data, true);
    }
    global $post;
    $post_id = $post->ID;
    //番剧或剧场版的介绍
    $introduction = explode(',', $array_url_title["introduction"]);
    //番剧或剧场版的名称
    $title = explode(',', $array_url_title["title"]);
    //番剧或剧场版的视频地址
    $url = explode(',', $array_url_title["url"]);
    //番剧或剧场版的集数
    $name = explode(',', $array_url_title["name"]);
    //番剧或剧场版的预览图
    $img = explode(',', $array_url_title["img"]);
    //获取数量
    $video_i = count($url);
    $up = $array_url_title["up"];
    $video = "";
    $listskip = '';
    for ($i = 0; $i < $video_i; $i++) {
        $url[$i] = $up . $url[$i];
        foreach ($vide_data_ar as $value) {
            if (preg_match("/" . urldecode($value['name']) . "/i", $url[$i]) && urldecode($value['name']) != "") {
                $video = $value['url'];
                break;
            }
        }
        $j = $i + 1;
        if ($i == 0) {
            print_r($video);
            $one = urldecode($video . $url[$i]);
            $img = urldecode($video . $img[$i]);
            $title = urldecode($video . $title[$i]);
            $jishu = urldecode($video . $name[$i]);
            $introduction = urldecode($video . $introduction[$i]);
            //文章阅读量
            $views = get_post_meta($post_id, 'views', true);
            //如文章没有阅读量则显示为0
            $views = $views ? $views : 0;
            //文章收藏量
            $loveNub = get_post_meta($post_id, 'zrz_favorites', true);
            //如文章没有收藏则显示为0
            $loveNub = !empty($loveNub) ? count($loveNub) : 0;
            //后台功能开关
            $zhibo = get_option('git_zb');
            $zd = get_option('git_zd');
            $yjz = get_option('git_yjz');
            $rj = get_option('git_rj');
            $jt = get_option('git_jt');
            $xh = get_option('git_xh');
            $logo = get_option('git_logo');
            $zts = get_option('git_zts');
            $yl = get_option('git_yl');
            $api = get_option('git_api');
            $cd = wp_unslash(get_option('git_yjcd'));
        }
        $selselect .= '<a href="javascript:void(0)" class="video' . $j . '" value="' . $j . '" data-video="' . urldecode($video . $url[$i]) . '" title="' . urldecode($name[$i]) . '">' . urldecode($name[$i]) . '</a>';
        if (${$video_i} == 1) {
            $selselect_none = 'style=display:none';
        } else {
            $selselect_none = '';
        }
    }
    return <<<EOF
    <link rel='stylesheet' id='selection-css' href='/wp-content/plugins/Selection/assets/css/selection.css' type='text/css' media='all'/>
                <div class="bangumi-header clearfix">
                <div class="header-info">
                    <h2 title="{$title}">{$title}</h2>
                    <div class="count-wrapper clearfix">
                        <div class="view-count">
                            <i>
                            </i>
                            <span>{$views}</span></div>
                        <div class="comment-count">
                            <i>
                            </i>
                            <span>{$loveNub}</span></div>
                    </div>
                </div>
                <div class="Car-player">
                    <div class="Car-iframe">
                        <div id="dplayer"></div>
                    </div>
                    <div class="ep-info-pre clearfix">
                        <div class="clearfix">
                            <div class="ep-info-left">
                                <div class="ep-info-image">
                                    <img src="{$img}" /></div>
                            </div>
                            <div class="ep-info-center">
                                <h2 class="ep-info-title">{$title}</h2>
                                <div class="ep-profile clearfix">
                                    <p>{$introduction}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ep-list-pre-wrapper">
                        <div class="ep-list-pre-header">
                            <span class="season-item on">选集</span></div>
                        <div class="Car-listSkip" {$selselect_none}="">{$selselect}</div></div>
                </div>
            </div>
            <script>
\t\t\tfunction updateVideo(url) {
\t\t\t\tvar id = md5(url);
\t\t\t\tconst dp = new DPlayer({
\t\t\t\t\tcontainer: document.querySelector('#dplayer'),
\t\t\t\t\tvideo: {
\t\t\t\t\t\turl: url
\t\t\t\t\t},
\t\t\t\t\tautoplay: {$zd},
\t\t\t\t\ttheme: '{$zts}',
\t\t\t\t\tpreload: {$yjz},
\t\t\t\t\tloop: {$xh},
\t\t\t\t\tscreenshot: {$jt},
\t\t\t\t\thotkey: {$rj},
\t\t\t\t\tlive: {$zhibo},
\t\t\t\t\tlogo: '{$logo}',
\t\t\t\t\tvolume: '{$yl}',
\t\t\t\t\tdanmaku: {
\t\t\t\t\t\tid: id,
\t\t\t\t\t\tapi: '{$api}'
\t\t\t\t\t},
\t\t\t\t\tcontextmenu: [
{$cd}
\t\t\t\t\t]
\t\t\t\t});
\t\t\t}
</script>
EOF;
}
add_action('after_wp_tiny_mce', 'Cae_iframe');
/*
这里是前端所需文件
*/
if (!is_admin()) {
    //播放器样式
    wp_enqueue_style('selection-dplayer-min', plugins_url("Selection/assets/css/dplayer/dplayer.min.css"), false);
}
function ds_print_jquery_in_footer()
{
    if (!is_admin()) {
        //Javascript库
        if (get_option('git_jq')) {
        wp_enqueue_script('selection-jquery-min', plugins_url("Selection/assets/js/jquery.min.js"), false);
        }
        //前端JS
        wp_enqueue_script('selection', plugins_url('Selection/assets/js/selection.js'), false);
        //播放器JS
        wp_enqueue_script('selection-dplayer-min', plugins_url("Selection/assets/js/dplayer/dplayer.min.js"), false);
        //用于解析HLS
        wp_enqueue_script('selection-dplayer-md5-min', plugins_url("Selection/assets/js/dplayer/md5.min.js"), false);
        if (get_option('git_hls')) {
            wp_enqueue_script('selection-dplayer-hls-min', plugins_url('Selection/assets/js/dplayer/hls.min.js'), false);
        }
        //用于解析MPEG DASH
        if (get_option('git_dash')) {
            wp_enqueue_script('selection-dplayer-dash-min', plugins_url('Selection/assets/js/dplayer/dash.min.js'), false);
        }
        //用于解析FLV
        if (get_option('git_flv')) {
            wp_enqueue_script('selection-dplayer-flv-min', plugins_url('Selection/assets/js/dplayer/flv.min.js'), false);
        }
    }
}
add_action('wp_footer', 'ds_print_jquery_in_footer');
/*
短代码作用解释
<img src="" style="display: none;"> 如已在文章设置了缩略图可将下方这一段删除
[xj introduction=""] 视频的简介
[xj title=""] 视频的标题
[xj img=""] 视频的预览图
[xj url=""] 视频的地址,url="xxx.mp4,xxx.m3u8" 多个用 , 隔开
[xj name=""] 视频的集数,name="第一话,第二话" 多个用 ,隔开
[xj introduction="" title="" img="" url="" name=""] 以上缺一不可
*/
function Cae_iframe($mce_settings)
{
    ?>
    <script type="text/javascript">  
    QTags.addButton('selection','插入Selection','<img src="" style="display: none;">[xj introduction="" title="" img="" url="" name=""]','');
    </script>
<?php 
}
