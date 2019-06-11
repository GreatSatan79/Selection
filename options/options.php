<?php
$options = array(
    array(
        'title' => '播放格式设置', 
        'id' => 
        'bf', 
        'type' => 'panelstart'
        ), 
    array(
        'name' => '是否开启对JQ?', 
        'desc' => '你的主题未自带JQ请启用本功能!<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PS:启用插件后无法播放或不显示播放器请开启本功能!', 
        'id' => 'git_jq', 
        'type' => 'checkbox'
        ), 
    array(
        'name' => '是否开启对HLS的支持', 
        'desc' => '开启后，即可播放M3U8格式的视频', 
        'id' => 'git_hls', 
        'type' => 'checkbox'
        ), 
    array(
        'name' => '是否开启对MPEG DASH的支持',
        'desc' => '开启后，即可播放MPD格式的视频', 
        'id' => 'git_dash', 
        'type' => 'checkbox'
        ), 
    array(
        'name' => '是否开启对FLV的支持',
        'desc' => '开启后，即可播放FLV格式的视频', 
        'id' => 'git_flv', 
        'type' => 'checkbox'
        ),
    array(
        'type' => 'panelend'
    ), 
    array(
        'title' => '功能设置', 
        'id' => 'gn', 
        'type' => 'panelstart'
    ), 
    array(
        'name' => '是否开启自动播放', 
        'desc' => '开启后打开页面将会自动播放视频', 
        'id' => 'git_zd', 
        'type' => 'radio', 
        'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 
        'std' => 'false'
    ), 
    array(
        'name' => '是否开启预加载', 
        'desc' => '开启后打开视频将会预加载', 
        'id' => 'git_yjz', 
        'type' => 'radio', 
        'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 
        'std' => 'false'
    ), 
    array(
        'name' => '是否开启直播', 
        'desc' => '开启后无法拖动进度条', 
        'id' => 'git_zb', 'type' => 
        'radio', 'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 
        'std' => 'false'
    ), 
    array(
        'name' => '是否开启热键', 
        'desc' => '开启后将会启用热键功能', 
        'id' => 'git_rj', 'type' => 
        'radio', 'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 'std' => 'false'
    ), 
    array(
        'name' => '是否开启截图', 
        'desc' => '如果开启，视频和视频封面需要开启跨域', 
        'id' => 'git_jt', 
        'type' => 'radio', 
        'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 'std' => 'false'
    ), 
    array(
        'name' => '是否开启循环', 
        'desc' => '开启后将会启用视循环功能', 
        'id' => 'git_xh', 
        'type' => 'radio', 
        'options' => array(
            '开启' => 'true', 
            '关闭' => 'false'
        ), 
        'std' => 'false'
    ), 
    array(
        'type' => 'panelend'
    ), 
    array(
        'title' => '其他设置', 
        'id' => 'qt', 
        'type' => 'panelstart'
    ), 
    array(
        'name' => '弹幕API', 
        'desc' => '默认为:https://dplayer.moerats.com/', 
        'id' => 'git_api', 
        'type' => 'text', 
        'std' => 'https://dplayer.moerats.com/'
    ), 
    array(
        'name' => 'LOGO', 
        'desc' => '在左上角展示一个 logo，你可以通过 CSS 调整它的大小和位置', 
        'id' => 'git_logo', 
        'type' => 'text', 
        'std' => ''
    ), 
    array('name' => '插件色', 
    'desc' => '默认#FADFA3', 
    'id' => 'git_zts', 
    'type' => 'text', 
    'std' => '#FADFA3'
), 
array(
    'name' => '视频音量', 
    'desc' => '默认为0.7,请注意播放器会记忆用户设置，手动设置音量后默认音量即失效', 
    'id' => 'git_yl', 
    'type' => 'text', 
    'std' => '0.7'
), 
array(
    'name' => '自定义右键菜单', 
    'id' => 'git_yjcd', 
    'type' => 'textarea', 
    'std' => '
        {
            text: \'关于作者\',
            link: \'https://diygod.me\'
        },
        {
            text: "DPlayer v1.25.0",
            link:"https://github.com/MoePlayer/DPlayer"
        }'), 
        array('type' => 'panelend')
    );

/*
插件后台设置已完成，下面可以不用看了
*/
function git_add_options_page()
{
    global $options;
    if ($_GET['page'] == basename(__FILE__)) {
        if ('update' == $_REQUEST['action']) {
            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            update_option('git_options_setup', true);
            header('Location: admin.php?page=options.php&update=true');
            die;
        } else {
            if ('reset' == $_REQUEST['action']) {
                foreach ($options as $value) {
                    delete_option($value['id']);
                }
                delete_option('git_options_setup');
                header('Location: admin.php?page=options.php&reset=true');
                die;
            }
        }
    }
    add_menu_page('Selection插件设置', 'Selection插件设置', 'edit_theme_options', basename(__FILE__), 'git_options_page');
}
add_action('admin_menu', 'git_add_options_page');
function git_options_page()
{
    global $options;
    $optionsSetup = get_option('git_options_setup') != '';
    if ($_REQUEST['update']) {
        echo '<div class="updated"><p><strong>设置已保存。</strong></p></div>';
    }
    if ($_REQUEST['reset']) {
        echo '<div class="updated"><p><strong>设置已重置。</strong></p></div>';
    }
    ?>

<div class="wrap">
    <h2>DPlayer For Selection By WordPress </h2>
    <form method="post">
    <h2 class="nav-tab-wrapper">
        <?php 
    $panelIndex = 0;
    foreach ($options as $value) {
        if ($value['type'] == 'panelstart') {
            echo '<a href="#' . $value['id'] . '" class="nav-tab' . ($panelIndex == 0 ? ' nav-tab-active' : '') . '">' . $value['title'] . '</a>';
        }
        $panelIndex++;
    }
    echo '<a href="#about_theme" class="nav-tab">关于本插件[新手必看]</a>';
    ?>
    </h2>
<?php 
    $panelIndex = 0;
    foreach ($options as $value) {
        switch ($value['type']) {
            case 'panelstart':
                echo '<div class="panel" id="' . $value['id'] . '" ' . ($panelIndex == 0 ? ' style="display:block"' : '') . '><table class="form-table">';
                $panelIndex++;
                break;
            case 'panelend':
                echo '</table></div>';
                break;
            case 'subtitle':
                echo '<tr><th colspan="2"><h3>' . $value['title'] . '</h3></th></tr>';
                break;
            case 'text':
                ?>
<tr>
    <th><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['name'];
                ?></label></th>
    <td>
        <label>
        <input name="<?php 
                echo $value['id'];
                ?>" class="regular-text" id="<?php 
                echo $value['id'];
                ?>" type='text' value="<?php 
                if ($optionsSetup || get_option($value['id']) != '') {
                    echo stripslashes(get_option($value['id']));
                } else {
                    echo $value['std'];
                }
                ?>" />
        <span class="description"><?php 
                echo $value['desc'];
                ?></span>
        </label>
    </td>
</tr>
<?php 
                break;
            case 'number':
                ?>
<tr>
    <th><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['name'];
                ?></label></th>
    <td>
        <label>
        <input name="<?php 
                echo $value['id'];
                ?>" class="small-text" id="<?php 
                echo $value['id'];
                ?>" type="number" value="<?php 
                if ($optionsSetup || get_option($value['id']) != '') {
                    echo get_option($value['id']);
                } else {
                    echo $value['std'];
                }
                ?>" />
        <span class="description"><?php 
                echo $value['desc'];
                ?></span>
        </label>
    </td>
</tr>
<?php 
                break;
            case 'password':
                ?>
<tr>
    <th><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['name'];
                ?></label></th>
    <td>
        <label>
        <input name="<?php 
                echo $value['id'];
                ?>" class="regular-text" id="<?php 
                echo $value['id'];
                ?>" type="password" value="<?php 
                if ($optionsSetup || get_option($value['id']) != '') {
                    echo get_option($value['id']);
                } else {
                    echo $value['std'];
                }
                ?>" />
        <span class="description"><?php 
                echo $value['desc'];
                ?></span>
        </label>
    </td>
</tr>
<?php 
                break;
            case 'textarea':
                ?>
<tr>
    <th><?php 
                echo $value['name'];
                ?></th>
    <td>
        <p><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['desc'];
                ?></label></p>
        <p><textarea name="<?php 
                echo $value['id'];
                ?>" id="<?php 
                echo $value['id'];
                ?>" rows="5" cols="50" class="large-text code"><?php 
                if ($optionsSetup || get_option($value['id']) != '') {
                    echo stripslashes(get_option($value['id']));
                } else {
                    echo $value['std'];
                }
                ?></textarea></p>
    </td>
</tr>
<?php 
                break;
            case 'select':
                ?>
<tr>
    <th><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['name'];
                ?></label></th>
    <td>
        <label>
            <select name="<?php 
                echo $value['id'];
                ?>" id="<?php 
                echo $value['id'];
                ?>">
                <?php 
                foreach ($value['options'] as $option) {
                    ?>
                <option value="<?php 
                    echo $option;
                    ?>" <?php 
                    selected(get_option($value['id']), $option);
                    ?>>
                    <?php 
                    echo $option;
                    ?>
                </option>
                <?php 
                }
                ?>
            </select>
            <span class="description"><?php 
                echo $value['desc'];
                ?></span>
        </label>
    </td>
</tr>

<?php 
                break;
            case 'radio':
                ?>
<tr>
    <th><label for="<?php 
                echo $value['id'];
                ?>"><?php 
                echo $value['name'];
                ?></label></th>
    <td>
        <?php 
                foreach ($value['options'] as $name => $option) {
                    ?>
        <label>
            <input type="radio" name="<?php 
                    echo $value['id'];
                    ?>" id="<?php 
                    echo $value['id'];
                    ?>" value="<?php 
                    echo $option;
                    ?>" <?php 
                    checked(get_option($value['id']), $option);
                    ?>>
            <?php 
                    echo $name;
                    ?>
        </label>
        <?php 
                }
                ?>
        <p><span class="description"><?php 
                echo $value['desc'];
                ?></span></p>
    </td>
</tr>
 
<?php 
                break;
            case 'checkbox':
                ?>
<tr>
    <th><?php 
                echo $value['name'];
                ?></th>
    <td>
        <label>
            <input type='checkbox' name="<?php 
                echo $value['id'];
                ?>" id="<?php 
                echo $value['id'];
                ?>" value="1" <?php 
                echo checked(get_option($value['id']), 1);
                ?> />
            <span><?php 
                echo $value['desc'];
                ?></span>
        </label>
    </td>
</tr>

<?php 
                break;
            case 'checkboxs':
                ?>
<tr>
    <th><?php 
                echo $value['name'];
                ?></th>
    <td>
        <?php 
                $checkboxsValue = get_option($value['id']);
                if (!is_array($checkboxsValue)) {
                    $checkboxsValue = array();
                }
                foreach ($value['options'] as $id => $title) {
                    ?>
        <label>
            <input type="checkbox" name="<?php 
                    echo $value['id'];
                    ?>[]" id="<?php 
                    echo $value['id'];
                    ?>[]" value="<?php 
                    echo $id;
                    ?>" <?php 
                    checked(in_array($id, $checkboxsValue), true);
                    ?>>
            <?php 
                    echo $title;
                    ?>
        </label>
        <?php 
                }
                ?>
        <span class="description"><?php 
                echo $value['desc'];
                ?></span>
    </td>
</tr>
<?php 
                break;
        }
    }
    ?>
<div class="panel" id="about_theme">
	<h2>其他事项说明</h2>
	<p>本插件原版由
		<code>Carseason</code>提供,后经本人修改</p>
	<p>本插件后台基于
		<code>极客公园</code>后台主题框架开发:
		<a target="_blank" href="https://gitcafe.net/archives/3995.html">官网下载</a></p>
	<p>本插件基于
		<code>7B2</code>主题开发而成,如想要兼容你自己所用的主题,请修改
		<code>assets/css/selection.css</code>文件<a target="_blank" href="https://saigaocy.me/wp-admin/plugin-editor.php?file=selection%2Fassets%2Fcss%2Fselection.css&plugin=selection%2Fselection.php""></a>点我修改</p>
    <hr>
    <script>
var Words = "%20%20%20%20%3Cp%3E%u7279%u6B64%u9E23%u8C22%28%u6392%u540D%u4E0D%u5206%u524D%u540E%29%3A%3C/p%3E%0A%20%20%20%20%3Cp%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//avatars3.githubusercontent.com/u/8266075%3Fs%3D180%26v%3D4%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//diygod.me/%22%3EDIYgod%3C/a%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//avatars3.githubusercontent.com/u/4526339%3Fs%3D180%26v%3D4%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//biji.io/%22%3ETokinx%3C/a%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//avatars3.githubusercontent.com/u/25239238%3Fs%3D180%26v%3D4%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//ecy1.com/%22%3ECarseason%3C/a%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//avatars3.githubusercontent.com/u/4999291%3Fs%3D180%26v%3D4%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//gitcafe.net/%22%3Eyunluo%3C/a%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//www.bgbk.org/wp-content/avatar/518sn2dvlgp0.png%3Fver%3D1559746130%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//www.bgbk.org/%22%3EMr.Bing%3C/a%3E%0A%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//i.loli.net/2019/06/12/5cffd9601beb574509.jpg%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//www.moerats.com/%22%3ERat%27s%3C/a%3E%0A%20%20%20%20%3Cimg%20style%3D%22border-radius%3A%2050px%3Bheight%3A%2040px%3B%22%20src%3D%22https%3A//i.loli.net/2019/06/12/5cffd8b00328e48808.png%22%3E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//7b2.com/%22%3E%u6625%u54E5%3C/a%3E%3C/p%3E%0A%0A%20%20%20%20%3Cp%3E%u7531%u8877%u611F%u8C22%u4EE5%u4E0A%u6240%u6709%u4EBA%u5BF9%u672C%u63D2%u4EF6%u7684%u8D21%u732E%2C%u8C22%u8C22%21%3C/p%3E%0A%20%20%20%20%3Chr%3E%0A%20%20%20%20%3Cp%3ESelection%u63D2%u4EF6%u8BA8%u8BBA%u7FA4%3A%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//jq.qq.com/%3F_wv%3D1027%26k%3D5AFXgbv%22%3E951636879%3C/a%3E%3C/p%3E%0A%20%20%20%20%20%3Cp%3E%u5982%u679C%u89C9%u5F97%u672C%u63D2%u4EF6%u5BF9%u4F60%u6709%u7528%u7684%u8BDD%u8BF7%u7ED9%u4E00%u4E2AStar%u5427%7E%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//github.com/GreatSatan79/Selection%22%3E%u9879%u76EE%u5730%u5740%3C/a%3E%3C/p%3E"
function OutWord() {
    var NewWords;
    NewWords = unescape(Words);
    document.write(NewWords);
}
OutWord();
    </script>
    <hr>
	<p>文章编辑页面:
		<code>
			<b>文本编辑模式下</b>
		</code>有短代码快捷键</p>
	<p>短代码调用:
		<code>[xj introduction="" title="" img="" url="" name=""]</code></p>
	<p>
		<code>[xj introduction=""]</code>视频的简介</p>
	<p>
		<code>[xj title=""]</code>视频的标题</p>
	<p>
		<code>[xj img=""]</code>视频的预览图</p>
	<p>
		<code>[xj url=""]</code>视频的地址,
		<code>[url="xxx.mp4,xxx.m3u8"]</code>多个用 , 隔开</p>
	<p>
		<code>[xj name=""]</code>视频的集数,
		<code>[name="第一话,第二话"]</code>多个用 ,隔开</p>
	<p>
		<code>[xj introduction="" title="" img="" url="" name=""]</code>以上缺一不可</p>
        <hr>
        </div>
<p>
	<input name="submit" type="submit" class="button button-primary" value="保存选项" />
	<input type="hidden" name="action" value="update" /></p>
</form>
<form method="post">
	<p>
		<input name="reset" type="submit" class="button button-secondary" value="重置选项" onclick="return confirm('你确定要重置选项吗？重置之后您的全部设置将被清空，您确定您没有搞错？？ ');" />
		<input type="hidden" name="action" value="reset" /></p>
</form>
</div>
<style>.panel{display:none}.panel h3{margin:0;font-size:1.2em}#panel_update ul{list-style-type:disc}.nav-tab-wrapper{clear:both}.nav-tab{position:relative}.nav-tab i:before{position:absolute;top:-10px;right:-8px;display:inline-block;padding:2px;border-radius:50%;background:#e14d43;color:#fff;content:"\f463";vertical-align:text-bottom;font:400 18px/1 dashicons;speak:none}#theme-options-search{display:none;float:right;margin-top:-34px;width:280px;font-weight:300;font-size:16px;line-height:1.5}.updated+#theme-options-search{margin-top:-91px}.wrap.searching .nav-tab-wrapper a,.wrap.searching .panel tr,#attrselector{display:none}.wrap.searching .panel{display:block !important}#attrselector[attrselector*=ok]{display:block}</style>
<style id="theme-options-filter"></style>
<div id="attrselector" attrselector="ok"></div>
<script>
jQuery(function($) {
        $(".nav-tab").click(function() {
                $(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
                $(".panel").hide();
                $($(this).attr("href")).show();
                return false;
        });

        var themeOptionsFilter = $("#theme-options-filter");
        themeOptionsFilter.text("ok");
        if ($("#attrselector").is(":visible") && themeOptionsFilter.text() != "") {
                $(".panel tr").each(function(el) {
                        $(this).attr("data-searchtext", $(this).text().replace(/\r|\n/g, '').replace(/ +/g, ' ').toLowerCase());
                });

                var wrap = $(".wrap");
                $("#theme-options-search").show().on("input propertychange",
                function() {
                        var text = $(this).val().replace(/^ +| +$/, "").toLowerCase();
                        if (text != "") {
                                wrap.addClass("searching");
                                themeOptionsFilter.text(".wrap.searching .panel tr[data-searchtext*='" + text + "']{display:block}");
                        } else {
                                wrap.removeClass("searching");
                                themeOptionsFilter.text("");
                        };
                });
        };
});
</script>
<?php 
}

/*
启用插件后自动跳转至选项页面
*/
global $pagenow;
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
    wp_redirect(admin_url('admin.php?page=options.php'));
    exit;
}
function git_enqueue_pointer_script_style($hook_suffix)
{
    $enqueue_pointer_script_style = false;
    $dismissed_pointers = explode(',', get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
    if (!in_array('git_options_pointer', $dismissed_pointers)) {
        $enqueue_pointer_script_style = true;
        add_action('admin_print_footer_scripts', 'git_pointer_print_scripts');
    }
    if ($enqueue_pointer_script_style) {
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
    }
}
add_action('admin_enqueue_scripts', 'git_enqueue_pointer_script_style');
function remove_footer_admin()
{
    return <<<EOF
<script>
var Words = "%3Cp%3E%u611F%u8C22%u4F7F%u7528%3Ca%20target%3D%22_blank%22%20href%3D%22https%3A//saigaocy.me%22%3ESelection%3C/a%3E%u8FDB%u884C%u521B%u4F5C%3C/p%3E"
function OutWord() {
        var NewWords;
        NewWords = unescape(Words);
        document.write(NewWords);
}
OutWord();
</script>
EOF;
}
add_filter('admin_footer_text', 'remove_footer_admin');
function git_pointer_print_scripts()
{
    ?>
<script>
jQuery(document).ready(function($) {
        var $menuAppearance = $("#menu-appearance");
        $menuAppearance.pointer({
                content: '<h3>恭喜，您的插件安装成功！</h3><p>该插件支持选项，请访问<a href="admin.php?page=options.php">插件选项</a>页面进行配置。</p>',
                position: {
                        edge: "left",
                        align: "center"
                },
                close: function() {
                        $.post(ajaxurl, {
                                pointer: "git_options_pointer",
                                action: "dismiss-wp-pointer"
                        });
                }
        }).pointer("open").pointer("widget").find("a").eq(0).click(function() {
                var href = $(this).attr("href");
                $menuAppearance.pointer("close");
                setTimeout(function() {
                        location.href = href;
                },
                700);
                return false;
        });

        $(window).on("resize scroll",
        function() {
                $menuAppearance.pointer("reposition");
        });
        $("#collapse-menu").click(function() {
                $menuAppearance.pointer("reposition");
        });
});
</script>
<?php 
}
