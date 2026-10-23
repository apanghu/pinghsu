<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="<?php echo $this->options->lang ? htmlspecialchars($this->options->lang, ENT_QUOTES, 'UTF-8') : 'zh-CN'; ?>">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <?php if ($this->options->DnsPrefetch): ?>
    <meta http-equiv="x-dns-prefetch-control" content="on"><?php if ($this->options->cdn_add): ?>
    <link rel="dns-prefetch" href="<?php $this->options->cdn_add(); ?>"><?php endif; ?><?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <?php if($this->options->favicon): ?>
    <link rel="shortcut icon" href="<?php $this->options->favicon(); ?>"><?php endif; ?>
    <?php if($this->options->iosicon): ?>
    <link rel="apple-touch-icon" href="<?php $this->options->iosicon(); ?>"><?php endif; ?>
    <title><?php $this->archiveTitle(array(
    'category'  =>  _t(' %s '),
    'search'    =>  _t(' %s '),
    'tag'       =>  _t(' %s '),
    'author'    =>  _t(' %s '),
    'date'      =>  _t(' %s ')
    ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <meta name="keywords" content="<?php $this->keywords(); ?>">
    <?php $this->header('keywords=&generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&atom='); ?>
    <link href="<?php $this->options->themeUrl('vendor/xcode.min.css'); ?>?v=<?php echo filemtime(__DIR__ . '/vendor/xcode.min.css'); ?>" rel="stylesheet">
    <?php if ($this->options->useHighline == 'able'): ?>
    <link id="hljs-dark-theme" href="<?php $this->options->themeUrl('vendor/atom-one-dark.min.css'); ?>?v=<?php echo filemtime(__DIR__ . '/vendor/atom-one-dark.min.css'); ?>" rel="stylesheet" media="not all">
    <?php endif; ?>
    <link href="<?php $this->options->themeUrl('style.min.css'); ?>?v=<?php echo filemtime(__DIR__ . '/style.min.css'); ?>" rel="stylesheet">
    <link href="<?php $this->options->themeUrl('extras.css'); ?>?v=<?php echo filemtime(__DIR__ . '/extras.css'); ?>" rel="stylesheet">
    <script>(function(){var s=null;try{s=localStorage.getItem('ph-theme');}catch(e){}if(s==='dark'||s==='light'){document.documentElement.setAttribute('data-theme',s);}var el=document.getElementById('hljs-dark-theme');if(el){var d=s==='dark'||(s!=='light'&&window.matchMedia&&window.matchMedia('(prefers-color-scheme: dark)').matches);el.media=d?'all':'not all';}}());</script>
</head>
<body class="<?php if (isset($this->fields->archive)): ?>bg-grey<?php elseif($this->is('archive')&&($this->options->colorBgPosts == 'defaultColor')): ?>bg-grey<?php elseif($this->is('archive')&&($this->options->colorBgPosts == 'customColor')): ?>bg-white<?php elseif(!$this->is('single')): ?>bg-grey<?php endif; ?>">
<a class="skip-link sr-only sr-only-focusable" href="#main-content">Skip to main content</a>
<header id="header" class="header bg-white" role="banner">
    <div class="navbar-container">
        <a href="<?php $this->options->siteUrl(); ?>" class="navbar-logo" aria-label="<?php $this->options->title(); ?> — 返回首页">
            <?php if($this->options->logoUrl): ?>
            <img src="<?php $this->options->logoUrl();?>" alt="<?php $this->options->title() ?>" height="40">
            <?php elseif($this->is('index')): ?>
            <span><?php $this->options->title() ?></span>
            <?php else: ?>
            <?php $this->options->title() ?>
            <?php endif; ?>
        </a>
        <nav class="navbar-menu" aria-label="主导航">
			<?php if ($this->options->categoryNav == 'able'): ?>
            <?php $this->widget('Widget_Metas_Category_List')->to($category);?>
            <?php while ($category->next()):?>
            <a<?php if($this->is('post')):?> <?php if($this->category == $category->slug):?> class="current"<?php endif;?><?php else:?><?php if($this->is('category', $category->slug)):?> class="current"<?php endif;?> <?php endif;?> href="<?php $category->permalink();?>"><?php $category->name();?></a>
            <?php endwhile; ?>
            <?php endif; ?>
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
        </nav>
        <?php if($this->options->searchPage): ?>
        <a href="<?php $this->options->searchPage(); ?>" class="navbar-search" aria-label="搜索">
            <span class="icon-search" aria-hidden="true"></span>
        </a>
        <?php else: ?>
        <div class="navbar-search" role="search">
            <span class="icon-search" aria-hidden="true"></span>
            <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search" aria-label="站内搜索">
                <span class="search-box">
                    <input type="search" id="input" class="input" name="s" required placeholder="Search..." maxlength="30" autocomplete="off" aria-label="搜索关键词">
                </span>
            </form>
        </div>
        <?php endif;?>
<nav class="navbar-mobile-menu" aria-label="移动端导航">
            <span class="icon-menu cross" aria-hidden="true"><span class="middle"></span></span>
            <ul>
			    <?php if ($this->options->categoryNav == 'able'): ?>
                <?php $this->widget('Widget_Metas_Category_List')->to($category);?>
                <?php while ($category->next()):?>
                <li><a<?php if($this->is('post')):?> <?php if($this->category == $category->slug):?> class="current"<?php endif;?><?php else:?><?php if($this->is('category', $category->slug)):?> class="current"<?php endif;?> <?php endif;?> href="<?php $category->permalink();?>"><?php $category->name();?></a></li>
                <?php endwhile; ?>
                <?php endif; ?>
                <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                <?php while($pages->next()): ?>
                <li><a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </nav>
    </div>
</header>
<main id="main-content">
