<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('页头logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($logoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $footerLogoUrl = new Typecho_Widget_Helper_Form_Element_Text('footerLogoUrl', NULL, NULL, _t('页尾logo地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($footerLogoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('favicon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置favicon'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $iosicon = new Typecho_Widget_Helper_Form_Element_Text('iosicon', NULL, NULL, _t('apple touch icon地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则不设置Apple Touch Icon'));
    $form->addInput($iosicon->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));

    $searchPage = new Typecho_Widget_Helper_Form_Element_Text('searchPage', NULL, NULL, _t('搜索页地址'), _t('输入你的 Template Page of Search 的页面地址,记得带上 http:// 或 https://'));
    $form->addInput($searchPage->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));

    $pjaxSet = new Typecho_Widget_Helper_Form_Element_Radio('pjaxSet',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('PJAX加速设置'), _t('默认禁止，若启用则需提前到关闭\'开启反垃圾保护\',开关在\'设置-评论\''));
    $form->addInput($pjaxSet);

    $DnsPrefetch = new Typecho_Widget_Helper_Form_Element_Radio('DnsPrefetch',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('DNS预解析加速'), _t('默认禁止，启用则会对CDN资源和Gravatar进行加速'));
    $form->addInput($DnsPrefetch);

    $htmlCompress = new Typecho_Widget_Helper_Form_Element_Radio('htmlCompress',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('代码压缩设置'), _t('默认禁止，启用则会对HTML代码进行压缩，可能会跟部分插件存在兼容问题，请自行测试'));
    $form->addInput($htmlCompress);

    $fastClickSet = new Typecho_Widget_Helper_Form_Element_Radio('fastClickSet',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('移动端点击延迟消除设置'), _t('默认禁止，好多安卓原生浏览器有点击延迟，想开启就开启吧'));
    $form->addInput($fastClickSet);

    $postListSwitch = new Typecho_Widget_Helper_Form_Element_Radio('postListSwitch',
        array('threeList' => _t('三栏'),
            'oneList' => _t('单栏'),
        ),
        'oneList', _t('首页文章列表设置'), _t('默认单栏，根据自己的喜好去做切换吧'));
    $form->addInput($postListSwitch);

    $categoryNav = new Typecho_Widget_Helper_Form_Element_Radio('categoryNav',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('导航菜单是否启动分类'), _t('默认禁止，启用后导航菜单会展示分类'));
    $form->addInput($categoryNav);

    $colorBgPosts = new Typecho_Widget_Helper_Form_Element_Radio('colorBgPosts',
        array('customColor' => _t('启用'),
            'defaultColor' => _t('禁用'),
        ),
        'defaultColor', _t('文章色块设置'), _t('默认禁止，启用则可以通过文章字段控制色块颜色，仅支持blue、purple、green、yellow、red'));
    $form->addInput($colorBgPosts);

    $postshowthumb = new Typecho_Widget_Helper_Form_Element_Radio('postshowthumb',
        array('able' => _t('启用'),
            'disable' => _t('禁用'),
        ),
        'disable', _t('文章题图设置'), _t('默认禁止，启用则在文章页内显示缩略图'));
    $form->addInput($postshowthumb);

    $relatedPosts = new Typecho_Widget_Helper_Form_Element_Radio('relatedPosts',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('相关文章设置'), _t('默认禁止，仅在文章页中生效，最多显示六条，文章是根据标签进行相关的'));
    $form->addInput($relatedPosts);

    $tableOfContents = new Typecho_Widget_Helper_Form_Element_Radio('tableOfContents',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('文章目录设置'), _t('默认禁止，文章页右边目录生成，仅在网页宽度大于1000px时显示'));
    $form->addInput($tableOfContents);

    $useHighline = new Typecho_Widget_Helper_Form_Element_Radio('useHighline',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('代码高亮设置'), _t('默认禁止，启用则会对 ``` 进行代码高亮，支持22种编程语言的高亮'));
    $form->addInput($useHighline);

    $useMathjax = new Typecho_Widget_Helper_Form_Element_Radio('useMathjax',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('文章Mathjax设置'), _t('默认禁止，启用则会对内容页进行数学公式渲染，仅支持 $公式$ 和 $$公式$$ '));
    $form->addInput($useMathjax);

    $GoogleAnalytics = new Typecho_Widget_Helper_Form_Element_Textarea('GoogleAnalytics', NULL, NULL, _t('Google Analytics代码'), _t('填写你从Google Analytics获取到的Universal Analytics跟踪代码，需要script标签'));
    $form->addInput($GoogleAnalytics);


    $socialweibo = new Typecho_Widget_Helper_Form_Element_Text('socialweibo', NULL, NULL, _t('输入微博链接'), _t('在这里输入微博链接,支持 http:// 或 https:// 或 //'));
    $form->addInput($socialweibo->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $socialzhihu = new Typecho_Widget_Helper_Form_Element_Text('socialzhihu', NULL, NULL, _t('输入知乎链接'), _t('在这里输入知乎链接,支持 http:// 或 https:// 或 //'));
    $form->addInput($socialzhihu->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $socialgithub = new Typecho_Widget_Helper_Form_Element_Text('socialgithub', NULL, NULL, _t('输入GitHub链接'), _t('在这里输入GitHub链接,支持 http:// 或 https://或 //'));
    $form->addInput($socialgithub->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $socialtwitter = new Typecho_Widget_Helper_Form_Element_Text('socialtwitter', NULL, NULL, _t('输入Twitter链接'), _t('在这里输入twitter链接,支持 http:// 或 https:// 或 //'));
    $form->addInput($socialtwitter->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));


    $srcAddress = new Typecho_Widget_Helper_Form_Element_Text('src_add', NULL, NULL, _t('图片CDN替换前地址'), _t('即你的附件存放链接，一般为http://www.yourblog.com/usr/uploads/'));
    $form->addInput($srcAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $cdnAddress = new Typecho_Widget_Helper_Form_Element_Text('cdn_add', NULL, NULL, _t('图片CDN替换后地址'), _t('即你的七牛云存储域名，一般为http://yourblog.qiniudn.com/，可能也支持其他有镜像功能的CDN服务'));
    $form->addInput($cdnAddress->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
    $default_thumb = new Typecho_Widget_Helper_Form_Element_Text('default_thumb', NULL, '', _t('默认缩略图'), _t('文章没有图片时的默认缩略图，留空则无，一般为http://www.yourblog.com/image.png'));
    $form->addInput($default_thumb->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));

    $ICPRecordNumber = new Typecho_Widget_Helper_Form_Element_Text('ICPRecordNumber', NULL, '', _t('ICP备案号'), _t('ICP备案号，一般为你备案申请审批通过后返回的认证序列号，也就是ICP备案号，一般为粤XXXXXXX'));
    $form->addInput($ICPRecordNumber->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));

    $darkMode = new Typecho_Widget_Helper_Form_Element_Radio('darkMode',
        array('able' => _t('启用'), 'disable' => _t('禁止')),
        'able', _t('深色模式开关'), _t('默认启用，在导航栏显示深色/浅色切换按钮，访客偏好通过 localStorage 保存'));
    $form->addInput($darkMode);

    $postExtras = new Typecho_Widget_Helper_Form_Element_Radio('postExtras',
        array('able' => _t('启用'), 'disable' => _t('禁止')),
        'able', _t('文章增强功能'), _t('默认启用：阅读进度条、字数/阅读时间估算、代码一键复制、移动端目录抽屉'));
    $form->addInput($postExtras);

    $gravatarMirror = new Typecho_Widget_Helper_Form_Element_Text('gravatarMirror', NULL, '', _t('Gravatar 镜像地址'), _t('留空使用 https://secure.gravatar.com，中国大陆可填镜像如 https://gravatar.loli.net'));
    $form->addInput($gravatarMirror->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));

    $mathjaxUrl = new Typecho_Widget_Helper_Form_Element_Text('mathjaxUrl', NULL, '', _t('MathJax CDN 地址'), _t('留空使用 cdnjs 默认地址；中国大陆可改为国内 CDN，需包含 ?config=TeX-AMS-MML_HTMLorMML'));
    $form->addInput($mathjaxUrl->addRule('xssCheck', _t('请不要在链接中使用特殊字符')));
}

function t($zh, $en = '') {
    $lang = Typecho_Widget::widget('Widget_Options')->lang;
    if ($lang && substr($lang, 0, 2) !== 'zh') {
        return $en !== '' ? $en : $zh;
    }
    return $zh;
}

function themeInit($archive) {
    Helper::options()->commentsMaxNestingLevels = 999;
    if ($archive->is('archive')) {
        $archive->parameter->pageSize = 12;
    }
}

/**
 * Return the background CSS class for a post card or header.
 * Uses custom-field color when colorBgPosts=customColor, a deterministic
 * fallback derived from the post cid, or bg-deepgrey for defaultColor.
 */
function postBgClass($obj) {
    $opts = Typecho_Widget::widget('Widget_Options');
    if ($opts->colorBgPosts === 'defaultColor') {
        return 'bg-deepgrey';
    }
    if ($opts->colorBgPosts === 'customColor') {
        $fields = $obj->fields;
        foreach (['green', 'red', 'yellow', 'blue', 'purple'] as $c) {
            if (isset($fields->$c)) return 'bg-' . $c;
        }
        $colors = ['blue', 'purple', 'green', 'yellow', 'red', 'orange'];
        return 'bg-' . $colors[abs((int)$obj->cid % 6)];
    }
    return '';
}

/**
 * Return the icon CSS class (bg-ico-*) for a post, taken from the first
 * matching custom field or derived deterministically from the post cid.
 */
function postIcoClass($obj) {
    $fields = $obj->fields;
    $icons  = ['book', 'game', 'note', 'chat', 'code', 'image', 'web', 'link', 'design', 'lock'];
    foreach ($icons as $ico) {
        if (isset($fields->$ico)) return 'bg-ico-' . $ico;
    }
    return 'bg-ico-' . $icons[abs((int)$obj->cid % 10)];
}

/**
 * Return the thumbnail URL for a post.  Resolution order:
 *   1. Custom field `thumb`
 *   2. First attached image
 *   3. First <img> or Markdown image in the raw post text
 *   4. Configured default_thumb option
 *   5. Deterministic fallback from the bundled thumbs sprite (cid % 10)
 * CDN substitution (src_add / cdn_add) is applied when configured.
 */
function postThumbUrl($obj) {
    $options = Typecho_Widget::widget('Widget_Options');
    $thumb   = '';

    if (isset($obj->fields->thumb)) {
        $thumb = (string)$obj->fields->thumb;
    }

    if ($thumb === '') {
        $attach = $obj->attachments(1)->attachment;
        if (isset($attach->isImage) && $attach->isImage == 1) {
            $thumb = $attach->url;
        }
    }

    if ($thumb === '') {
        if (preg_match('/<img\b[^>]*\bsrc=[\'"]([^\'"]+)[\'"]/i', $obj->text, $m)) {
            $thumb = $m[1];
        } elseif (preg_match('/!\[[^\]]*\]\(([^)\s]+)\)/', $obj->text, $m)) {
            $thumb = $m[1];
        }
    }

    if ($thumb === '') {
        $thumb = !empty($options->default_thumb)
            ? $options->default_thumb
            : $options->themeUrl . '/images/thumbs/' . (abs((int)$obj->cid % 10)) . '.jpg';
    }

    if (!empty($options->src_add) && !empty($options->cdn_add)) {
        $thumb = str_ireplace($options->src_add, $options->cdn_add, $thumb);
    }

    return $thumb;
}

/** @deprecated Use postThumbUrl() */
function showThumb($obj, $size = null, $link = false) {
    if (!$link) return null;
    // Return the real thumb URL or empty string (no deterministic fallback).
    $options = Typecho_Widget::widget('Widget_Options');

    if (isset($obj->fields->thumb)) {
        $thumb = (string)$obj->fields->thumb;
        if (!empty($options->src_add) && !empty($options->cdn_add)) {
            $thumb = str_ireplace($options->src_add, $options->cdn_add, $thumb);
        }
        return $thumb;
    }

    $attach = $obj->attachments(1)->attachment;
    if (isset($attach->isImage) && $attach->isImage == 1) {
        $thumb = $attach->url;
        if (!empty($options->src_add) && !empty($options->cdn_add)) {
            $thumb = str_ireplace($options->src_add, $options->cdn_add, $thumb);
        }
        return $thumb;
    }

    if (preg_match('/<img\b[^>]*\bsrc=[\'"]([^\'"]+)[\'"]/i', $obj->text, $m)) {
        return $m[1];
    }
    if (preg_match('/!\[[^\]]*\]\(([^)\s]+)\)/', $obj->text, $m)) {
        return $m[1];
    }

    if (!empty($options->default_thumb)) {
        return $options->default_thumb;
    }

    return '';
}

function parseFieldsThumb($obj) {
    $options = Typecho_Widget::widget('Widget_Options');
    $thumb   = (string)$obj->fields->thumb;
    if (!empty($options->src_add) && !empty($options->cdn_add)) {
        $thumb = str_ireplace($options->src_add, $options->cdn_add, $thumb);
    }
    echo htmlspecialchars(trim($thumb), ENT_QUOTES, 'UTF-8');
}

function parseContent($obj) {
    $options = Typecho_Widget::widget('Widget_Options');
    $content = $obj->content;
    if (!empty($options->src_add) && !empty($options->cdn_add)) {
        $content = str_ireplace($options->src_add, $options->cdn_add, $content);
    }
    $content = preg_replace('/<a href="([^"]*)">/i', '<a href="$1" target="_blank" rel="noopener noreferrer">', $content);
    $content = preg_replace('/<img(.*?)src(.*?)=(.*?)"(.*?)">/i', '<img$1src$3="$4"$5 loading="lazy">', $content);
    $content = preg_replace_callback('/<h([1-5])>(.*?)<\/h\1>/i', function ($matches) {
        static $id = 1;
        $hyphenated = 'anchor-' . $id++;
        return '<h' . $matches[1] . ' id="' . $hyphenated . '">' . $matches[2] . '</h' . $matches[1] . '>';
    }, $content);
    echo trim($content);
}

/**
 * Echo the @Author reply-to link for a comment.
 * Uses a static cache to avoid two SQL queries per comment on threaded pages.
 */
function getCommentAt($coid) {
    static $cache = [];
    if (!array_key_exists($coid, $cache)) {
        $db   = Typecho_Db::get();
        $prow = $db->fetchRow($db->select('parent')
            ->from('table.comments')
            ->where('coid = ? AND status = ?', $coid, 'approved'));
        $parent = $prow ? (int)$prow['parent'] : 0;
        if ($parent > 0) {
            $arow   = $db->fetchRow($db->select('author')
                ->from('table.comments')
                ->where('coid = ? AND status = ?', $parent, 'approved'));
            $author = $arow ? $arow['author'] : '';
            $cache[$coid] = $author
                ? '<a href="#comment-' . $parent . '">@' . htmlspecialchars($author, ENT_QUOTES, 'UTF-8') . '</a>'
                : '';
        } else {
            $cache[$coid] = '';
        }
    }
    echo $cache[$coid];
}

function getRecentPosts($obj, $pageSize) {
    \Widget\Contents\Post\Recent::allocWithAlias(
        'footer_recent',
        'pageSize=' . (int)$pageSize
    )->to($recent);
    while ($recent->next()) {
        echo '<li><a href="' . htmlspecialchars($recent->permalink, ENT_QUOTES, 'UTF-8') . '">'
            . htmlspecialchars($recent->title, ENT_QUOTES, 'UTF-8') . '</a></li>';
    }
}

function getHotTags($obj, $limit) {
    $db   = Typecho_Db::get();
    $tags = $db->fetchAll($db->select()
        ->from('table.metas')
        ->where('type = ?', 'tag')
        ->order('count', Typecho_Db::SORT_DESC)
        ->limit($limit));
    foreach ($tags as $tag) {
        $opts = Typecho_Widget::widget('Widget_Options');
        $permalink = \Typecho\Router::url('tag', $tag, $opts->index);
        echo '<li><a href="' . htmlspecialchars($permalink, ENT_QUOTES, 'UTF-8') . '"># '
            . htmlspecialchars($tag['name'], ENT_QUOTES, 'UTF-8') . '</a></li>';
    }
}

/** @deprecated Use postBgClass() for deterministic colors */
function randBgColor() {
    $colors = ['blue', 'purple', 'green', 'yellow', 'red', 'orange'];
    return $colors[mt_rand(0, 5)];
}

/** @deprecated Use postIcoClass() for deterministic icons */
function randBgIco() {
    $icons = ['book', 'game', 'note', 'chat', 'code', 'image', 'web', 'link', 'design', 'lock'];
    return $icons[mt_rand(0, 9)];
}

function theNext($widget, $default = null) {
    $db  = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created > ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_ASC)
        ->limit(1);
    $content = \Widget\Contents\From::allocWithAlias('next:' . $widget->cid, ['query' => $sql]);
    if ($content->have()) {
        echo '<a href="' . htmlspecialchars($content->permalink, ENT_QUOTES, 'UTF-8')
            . '" title="' . htmlspecialchars($content->title, ENT_QUOTES, 'UTF-8') . '">←</a>';
    } else {
        echo $default;
    }
}

function thePrev($widget, $default = null) {
    $db  = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created < ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1);
    $content = \Widget\Contents\From::allocWithAlias('prev:' . $widget->cid, ['query' => $sql]);
    if ($content->have()) {
        echo '<a href="' . htmlspecialchars($content->permalink, ENT_QUOTES, 'UTF-8')
            . '" title="' . htmlspecialchars($content->title, ENT_QUOTES, 'UTF-8') . '">→</a>';
    } else {
        echo $default;
    }
}

function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}
