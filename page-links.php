<?php
/**
 * Template Page of Links
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

$db = Typecho_Db::get();
$prefix = $db->getPrefix();
// the friend links live in the table of the Links plugin
$rows = array();
$linksPlugin = isset($this->options->plugins['activated']['Links']);
if ($linksPlugin) {
    $rows = $db->fetchAll($db->select()->from($prefix . 'links')
        ->where('state = ?', 1)
        ->order($prefix . 'links.order', Typecho_Db::SORT_ASC));
}

$palette = array(
    array('#eb5055', '#fdecec'), array('#f68e5f', '#fef0e9'), array('#d99a12', '#fdf4de'),
    array('#2fa968', '#e6f6ed'), array('#4a86e0', '#e8f0fc'), array('#a06bb0', '#f3ebf6'),
);
$e = function ($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
};

$cards = array();
foreach ($rows as $link) {
    $url = trim((string) $link['url']);
    if (!preg_match('~^https?://~i', $url)) {
        continue;
    }
    $name = trim((string) $link['name']);
    $text = trim((string) $link['description']);
    $img = trim((string) $link['image']);
    $color = $palette[crc32($name) % count($palette)];
    $cards[] = array(
        'url'   => $url,
        'name'  => $name,
        'desc'  => ($text !== '' && $text !== $name) ? $text : '',
        'host'  => preg_replace('~^www\.~i', '', (string) parse_url($url, PHP_URL_HOST)),
        'letter' => mb_strtoupper(Typecho_Common::subStr($name, 0, 1, '')),
        // gravatar urls here only ever give the grey silhouette, the coloured letter looks better
        'img'   => (preg_match('~^https?://~i', $img) && stripos($img, 'gravatar') === false) ? $img : '',
        'fg'    => $color[0],
        'bg'    => $color[1],
    );
}

$siteTitle = $this->options->title;
$siteUrl = rtrim($this->options->siteUrl, '/');
$logo = $this->options->logoUrl ? $this->options->logoUrl : '';
$siteDesc = $this->options->description;
$assetUrl = function ($file) {
    $path = __DIR__ . '/' . $file;
    return Typecho_Widget::widget('Widget_Options')->themeUrl . '/' . $file . '?v=' . (is_file($path) ? filemtime($path) : 0);
};
?>
<link rel="stylesheet" href="<?php echo $assetUrl('pages.css'); ?>">

<div class="main-content pg pg-links">
	<header class="pg-head pg-rise">
		<h1 class="pg-title"><?php $this->title(); ?></h1>
		<p class="pg-sub">共 <?php echo count($cards); ?> 个朋友的小站，欢迎常来串门。</p>
	</header>

	<?php if ($cards): ?>
	<ul class="pg-grid">
		<?php foreach ($cards as $i => $c): ?>
		<li class="pg-rise" style="animation-delay:<?php echo min($i, 11) * 0.04; ?>s">
			<a class="pg-card" href="<?php echo $e($c['url']); ?>" target="_blank" rel="noopener" title="<?php echo $e($c['desc'] !== '' ? $c['desc'] : $c['name']); ?>">
				<span class="pg-avatar" style="--fg:<?php echo $c['fg']; ?>;--bg:<?php echo $c['bg']; ?>" aria-hidden="true">
					<span class="pg-letter"><?php echo $e($c['letter']); ?></span>
					<?php if ($c['img'] !== ''): ?><img src="<?php echo $e($c['img']); ?>" alt="" loading="lazy" referrerpolicy="no-referrer" onerror="this.remove()"><?php endif; ?>
				</span>
				<span class="pg-card-body">
					<span class="pg-card-name"><?php echo $e($c['name']); ?></span>
					<?php if ($c['desc'] !== ''): ?><span class="pg-card-desc"><?php echo $e($c['desc']); ?></span><?php endif; ?>
					<span class="pg-card-host"><span><?php echo $e($c['host']); ?></span><i><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7"/><path d="M8 7h9v9"/></svg></i></span>
				</span>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else: ?>
	<p class="pg-empty"><?php echo $linksPlugin ? '还没有友链，来做第一个吧。' : '需要先启用 Links 友情链接插件。'; ?></p>
	<?php endif; ?>

	<section class="pg-section pg-rise d2">
		<h2 class="pg-h2">申请友链</h2>
		<div class="pg-two">
			<div class="pg-panel">
				<h3 class="pg-h3">本站信息</h3>
				<?php
				$info = array(
					array('名称', $siteTitle, false),
					array('链接', $siteUrl, false),
					array('头像', $logo, true),
					array('描述', $siteDesc, false),
				);
				foreach ($info as $row):
					if ($row[1] === '' || $row[1] === null) continue;
				?>
				<div class="pg-kv">
					<span class="pg-k"><?php echo $row[0]; ?></span>
					<span class="pg-v"><?php if ($row[2]): ?><img src="<?php echo $e($row[1]); ?>" alt="" loading="lazy"><?php endif; ?><?php echo $e($row[1]); ?></span>
					<button class="pg-copy" type="button" data-copy="<?php echo $e($row[1]); ?>" aria-label="复制<?php echo $row[0]; ?>">
						<svg class="cp" viewBox="0 0 24 24" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
						<svg class="ok" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
						<span class="sr">复制</span>
					</button>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="pg-panel">
				<h3 class="pg-h3">如何申请</h3>
				<ol class="pg-steps">
					<li><b>先添加本站</b>：把上面的本站信息放到你的友链里。</li>
					<li><b>留言申请</b>：在下方评论区按这个格式留言：
						<div class="pg-format"><span>网站名称：</span>……<br><span>网站链接：</span>https://……<br><span>网站头像：</span>https://……<br><span>网站描述：</span>一句话介绍</div>
					</li>
					<li><b>等待添加</b>：审核后会加到上面的列表里。</li>
				</ol>
			</div>
		</div>
	</section>
</div>
<script src="<?php echo $assetUrl('pages.js'); ?>" defer></script>

<?php $this->need('comments.php'); ?>

<?php $this->need('footer.php'); ?>
