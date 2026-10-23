<?php
/**
 * @package Pinghsu Theme — homepage redesign (personal site + blog)
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

// ── 个人简介（留空则读取「设置-基本设置」里的站点描述）─────────────────
$heroBio = $this->options->description
    ?: '我是一名全栈工程师，专注 AI 应用开发。在产品、工程和 AI 落地的交叉处工作。';

// ── 项目列表（按需填写，注释掉某项或清空数组可隐藏项目区块）───────────
$projects = [
    // ['name' => '项目名称', 'desc' => '一句话介绍', 'date' => '2026-10', 'url' => 'https://'],
];
// ────────────────────────────────────────────────────────────────────────
?>

<div class="home-page">

<!-- ── Hero ───────────────────────────────────────────────────────── -->
<section class="home-hero">
    <div class="home-wrap">
        <p class="home-handle">@<?php echo htmlspecialchars($this->options->title, ENT_QUOTES, 'UTF-8'); ?></p>
        <p class="home-bio"><?php echo htmlspecialchars($heroBio, ENT_QUOTES, 'UTF-8'); ?></p>
        <nav class="home-hero-nav" aria-label="个人链接">
            <?php if ($this->options->socialgithub): ?>
            <a href="<?php $this->options->socialgithub(); ?>" target="_blank" rel="noopener">GitHub</a>
            <?php endif; ?>
            <?php if ($this->options->socialtwitter): ?>
            <a href="<?php $this->options->socialtwitter(); ?>" target="_blank" rel="noopener">Twitter</a>
            <?php endif; ?>
            <?php if ($this->options->socialweibo): ?>
            <a href="<?php $this->options->socialweibo(); ?>" target="_blank" rel="noopener">微博</a>
            <?php endif; ?>
            <a href="<?php echo rtrim($this->options->siteUrl, '/'); ?>/archiving.html">归档</a>
            <a href="<?php echo rtrim($this->options->siteUrl, '/'); ?>/links.html">友链</a>
        </nav>
    </div>
</section>

<!-- ── Projects ───────────────────────────────────────────────────── -->
<?php if (!empty($projects)): ?>
<section class="home-section">
    <div class="home-wrap">
        <h2 class="home-section-title">项目</h2>
        <div class="home-project-list">
        <?php foreach ($projects as $p): ?>
            <a href="<?php echo htmlspecialchars($p['url'], ENT_QUOTES, 'UTF-8'); ?>" class="home-project-item" target="_blank" rel="noopener">
                <div class="home-project-header">
                    <span class="home-project-name"><?php echo htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="home-project-date"><?php echo htmlspecialchars($p['date'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <p class="home-project-desc"><?php echo htmlspecialchars($p['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
            </a>
        <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── Recent posts ───────────────────────────────────────────────── -->
<section class="home-section">
    <div class="home-wrap">
        <h2 class="home-section-title">最近文章</h2>
        <div class="home-post-list">
        <?php \Widget\Contents\Post\Recent::allocWithAlias('home_recent', 'pageSize=10')->to($hp); ?>
        <?php $n = 1; while ($hp->next()): ?>
            <a href="<?php echo htmlspecialchars($hp->permalink, ENT_QUOTES, 'UTF-8'); ?>" class="home-post-item">
                <span class="home-post-num"><?php printf('%03d', $n++); ?></span>
                <span class="home-post-title"><?php echo htmlspecialchars($hp->title, ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="home-post-date"><?php echo date('Y-m-d', $hp->created); ?></span>
            </a>
        <?php endwhile; ?>
        </div>
        <a href="<?php echo rtrim($this->options->siteUrl, '/'); ?>/archiving.html" class="home-more">查看全部归档 →</a>
    </div>
</section>

</div>

<?php $this->need('footer.php'); ?>
