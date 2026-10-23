<?php
/**
 * Template Page of About
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// The page content is split at the first horizontal rule (---): the part before it fills the
// "关于本站" card, the part after it becomes the "版权声明" panel (left out when empty).
$this->need('header.php');

$db = Typecho_Db::get();
$count = function ($sql) use ($db) {
    $row = $db->fetchRow($sql);
    return $row ? (int) $row['n'] : 0;
};
$posts = $count($db->select(array('COUNT(*)' => 'n'))->from('table.contents')->where('type = ?', 'post')->where('status = ?', 'publish'));
$cates = $count($db->select(array('COUNT(*)' => 'n'))->from('table.metas')->where('type = ?', 'category'));
$tags = $count($db->select(array('COUNT(*)' => 'n'))->from('table.metas')->where('type = ?', 'tag'));
$first = $db->fetchRow($db->select(array('MIN(created)' => 'ts'))->from('table.contents')->where('type = ?', 'post')->where('status = ?', 'publish'));
$firstTs = $first && $first['ts'] ? (int) $first['ts'] : 0;
$days = $firstTs ? max(1, (int) floor((time() - $firstTs) / 86400)) : 0;

$e = function ($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
};
$logo = $this->options->logoUrl ? $this->options->logoUrl : '';
$assetUrl = function ($file) {
    $path = __DIR__ . '/' . $file;
    return Typecho_Widget::widget('Widget_Options')->themeUrl . '/' . $file . '?v=' . (is_file($path) ? filemtime($path) : 0);
};

// page content: render it ourselves (the markdown plugins may wrap it for client side rendering), then split
if ($this->isMarkdown && class_exists('\Utils\Markdown')) {
    $html = \Utils\Markdown::convert($this->text);
    $html = preg_replace('~<a href="(https?://[^"]*)">~i', '<a href="$1" target="_blank" rel="noopener">', $html);
} else {
    ob_start();
    parseContent($this);
    $html = ob_get_clean();
}
$parts = preg_split('~<hr\s*/?>~i', $html, 2);
$intro = trim($parts[0]);
$license = isset($parts[1]) ? trim($parts[1]) : '';

// navigation cards, each one only when its target exists
$pageUrl = function ($template) use ($db) {
    $row = $db->fetchRow($db->select('slug')->from('table.contents')
        ->where('type = ?', 'page')->where('status = ?', 'publish')->where('template = ?', $template)->limit(1));
    return $row ? \Typecho\Router::url('page', $row, $this->options->index) : '';
};
$tiles = array();
if ($url = $pageUrl('page-timeline.php')) {
    $tiles[] = array('归档', '按时间浏览全部文章', $url, '<rect x="3" y="3" width="18" height="5" rx="1"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><path d="M10 12h4"/>');
}
if ($url = $pageUrl('page-links.php')) {
    $tiles[] = array('友情链接', '邻居们的小站', $url, '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>');
}
$tiles[] = array('RSS 订阅', '用阅读器订阅更新', $this->options->feedUrl, '<path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/>');
if (isset($this->options->plugins['activated']['Sitemap'])) {
    $tiles[] = array('网站地图', '给搜索引擎看的地图', \Typecho\Common::url('sitemap.xml', $this->options->index), '<polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>');
}

$stats = array(array('文章', $posts), array('分类', $cates), array('标签', $tags), array('运行天数', $days));
?>
<link rel="stylesheet" href="<?php echo $assetUrl('pages.css'); ?>">

<div class="main-content pg pg-about">
	<section class="pg-hero pg-rise">
		<?php if ($logo): ?><img class="pg-logo" src="<?php echo $e($logo); ?>" alt="<?php echo $e($this->options->title); ?>"><?php endif; ?>
		<h1><?php $this->options->title(); ?></h1>
		<?php if ($this->options->description): ?><p class="pg-tagline"><?php $this->options->description(); ?></p><?php endif; ?>
		<div class="pg-badges">
			<?php if ($firstTs): ?><span class="pg-chip">记录于 <?php echo date('Y 年 n 月', $firstTs); ?></span><?php endif; ?>
			<?php if ($this->options->ICPRecordNumber): ?><a class="pg-chip" href="https://beian.miit.gov.cn/" target="_blank" rel="noopener"><?php $this->options->ICPRecordNumber(); ?></a><?php endif; ?>
		</div>
	</section>

	<div class="pg-stats pg-rise d1">
		<?php foreach ($stats as $s): ?>
		<div class="pg-stat"><span class="pg-num" data-to="<?php echo $s[1]; ?>"><?php echo $s[1]; ?></span><span class="pg-lbl"><?php echo $s[0]; ?></span></div>
		<?php endforeach; ?>
	</div>

	<?php if ($intro !== ''): ?>
	<section class="pg-section pg-rise d2">
		<div class="pg-panel pg-intro">
			<h2 class="pg-h3">关于本站</h2>
			<div class="pg-prose"><?php echo $intro; ?></div>
		</div>
	</section>
	<?php endif; ?>

	<section class="pg-section pg-rise d3">
		<h2 class="pg-h2">站点导航</h2>
		<ul class="pg-navgrid">
			<?php foreach ($tiles as $t): ?>
			<li>
				<a class="pg-navcard" href="<?php echo $e($t[2]); ?>">
					<span class="pg-tile-ico"><svg viewBox="0 0 24 24" aria-hidden="true"><?php echo $t[3]; ?></svg></span>
					<b><?php echo $e($t[0]); ?></b>
					<small><?php echo $e($t[1]); ?></small>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<?php if ($license !== ''): ?>
	<section class="pg-section pg-rise d4">
		<h2 class="pg-h2">版权声明</h2>
		<div class="pg-panel pg-license"><?php echo $license; ?></div>
	</section>
	<?php endif; ?>
</div>
<script src="<?php echo $assetUrl('pages.js'); ?>" defer></script>

<?php $this->need('footer.php'); ?>
