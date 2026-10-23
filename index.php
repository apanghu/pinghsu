<?php
/**
 * Pinghsu是一款以前端性能优化为出发点而制作的Typecho主题，同时又兼顾设计美学和视觉传达。主题命名取自作者姓名和其女朋友姓名的最后一个字的港式英文，挣扎于Hsuping还是Pinghsu，最后取为Pinghsu，意为一切都是Ping先Hsu后，即系要听女朋友的话。
 *
 * @package Pinghsu Theme
 * @author Chakhsu Lau
 * @version 1.6.2
 * @link https://www.linpx.com/
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="main-content index-page clearfix <?php if ($this->options->postListSwitch == 'oneList'): ?>onelist-page<?php endif; ?>">

<?php
$bioBio = $this->options->description
    ?: '从全栈工程师转型 AI 应用开发，专注于把模型能力做成真正有人使用的产品。在产品、工程和人机协作的交叉处工作。';
?>
<div class="site-bio">
    <p class="site-bio-handle">@<?php echo htmlspecialchars($this->options->title, ENT_QUOTES, 'UTF-8'); ?></p>
    <p class="site-bio-text" data-typetext="<?php echo htmlspecialchars($bioBio, ENT_QUOTES, 'UTF-8'); ?>"></p>
</div>
<script>
(function(){
    var el = document.querySelector('.site-bio-text[data-typetext]');
    if (!el) return;
    var text = el.getAttribute('data-typetext');
    el.textContent = '';
    var i = 0;
    function tick() {
        el.textContent = text.slice(0, ++i);
        if (i < text.length) requestAnimationFrame(function(){ setTimeout(tick, 28); });
        else el.classList.add('typed');
    }
    setTimeout(tick, 300);
}());
</script>
	<div class="post-lists">
		<div class="post-lists-body">
		<?php while($this->next()): ?>
		<?php $bgClass = postBgClass($this); ?>
			<?php if ($this->options->postListSwitch == 'threeList'): ?>
			<div class="post-list-item">
				<div class="post-list-item-container">
					<div class="item-thumb <?php echo $bgClass; ?>" style="background-image:url(<?php echo htmlspecialchars(postThumbUrl($this), ENT_QUOTES, 'UTF-8'); ?>);"></div>
					<a href="<?php $this->permalink() ?>">
	                	<div class="item-desc">
							<p><?php $this->excerpt(80, '...');?></p>
						</div>
					</a>
					<div class="item-slant reverse-slant <?php echo $bgClass; ?>"></div>
					<div class="item-slant"></div>
					<div class="item-label">
						<div class="item-title"><a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a></div>
						<div class="item-meta clearfix">
							<div class="item-meta-date"><time datetime="<?php $this->date('c'); ?>"><?php $this->date('Y/m/d'); ?></time></div>
							<div class="item-meta-ico <?php echo postIcoClass($this); ?>" style="background: url(<?php $this->options->themeUrl('images/bg-ico.png'); ?>) no-repeat;background-size: 40px auto;"></div>
							<div class="item-meta-cat"><?php $this->category(''); ?></div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($this->options->postListSwitch == 'oneList'): ?>
			<div class="post-onelist-item">
				<div class="post-onelist-item-container">
					<a href="<?php $this->permalink(); ?>">
						<div class="onelist-item-thumb <?php echo $bgClass; ?>" style="background-image:url(<?php echo htmlspecialchars(postThumbUrl($this), ENT_QUOTES, 'UTF-8'); ?>);"></div>
					</a>
					<div class="onelist-item-info">
						<div class="item-title">
							<a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
						</div>
						<div class="item-meta">
							<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"> Published on <?php $this->date('M j, Y'); ?></time> in <?php $this->category(''); ?>
						</div>
						<div class="item-meta-hr <?php echo $bgClass; ?>"></div>
						<div class="item-content">
							<p><?php $this->excerpt(150, '...');?></p>
						</div>
						<div class="item-readmore">
							<a href="<?php $this->permalink(); ?>"> Continue Reading → </a>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>
	</div>
	<div class="lists-navigator clearfix">
    <?php $this->pageNav('←','→','2','...'); ?>
  </div>
</div>

<?php $this->need('footer.php'); ?>
