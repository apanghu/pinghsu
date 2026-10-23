<?php
/**
* Template Page of Search
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

// Pre-fill input with the current search query if one exists
$searchQuery = trim($this->request->get('s', ''));
$encodedQuery = htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8');
?>

<div class="main-content page-page">
    <div class="search-page">
        <form id="search" class="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search" aria-label="<?php echo t('站内搜索', 'Site search'); ?>">
            <span class="search-box clearfix">
                <input type="search" id="input" class="input" name="s" required placeholder="<?php echo t('搜索文章…', 'Search posts…'); ?>" maxlength="60" autocomplete="off" aria-label="<?php echo t('搜索关键词', 'Search keyword'); ?>"<?php if ($searchQuery !== ''): ?> value="<?php echo $encodedQuery; ?>"<?php endif; ?>>
                <button type="submit" class="spsubmit"><i class="icon-search"></i></button>
            </span>
        </form>

        <?php
        $this->widget('Widget_Metas_Tag_Cloud', 'sort=count&ignoreZeroCount=1&desc=1&limit=50')->to($tags);
        $tagColors = ['blue', 'purple', 'green', 'yellow', 'red', 'orange'];
        ?>
        <div class="search-tags">
        <?php parseContent($this); ?>
        <?php if ($tags->have()): ?>
            <?php if ($searchQuery !== ''): ?>
            <p class="search-hint"><?php echo t('没找到？试试浏览这些标签：', 'No results? Try browsing these tags:'); ?></p>
            <?php else: ?>
            <p class="search-hint"><?php echo t('热门标签', 'Popular tags'); ?></p>
            <?php endif; ?>
            <?php while ($tags->next()): ?>
            <a href="<?php $tags->permalink(); ?>" class="<?php if ($this->options->colorBgPosts === 'defaultColor'): ?>bg-white<?php else: ?>text-white bg-<?php echo $tagColors[abs((int)$tags->mid % 6)]; ?><?php endif; ?>"># <?php $tags->name(); ?>(<?php $tags->count(); ?>)</a>
            <?php endwhile; ?>
        <?php else: ?>
            <p><?php echo t('暂无标签。', 'No tags yet.'); ?></p>
        <?php endif; ?>
        <div class="search-tags-hr <?php if ($this->options->colorBgPosts === 'defaultColor'): ?>bg-deepgrey<?php else: ?>bg-blue<?php endif; ?>"></div>
        </div>
    </div>
</div>

<?php $this->need('footer.php'); ?>
