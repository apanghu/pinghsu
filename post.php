<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<?php if ($this->options->postshowthumb == 'able'): ?>
<?php $thumbUrl = postThumbUrl($this); $bgClass = postBgClass($this); ?>
<div class="post-header-thumb <?php echo $bgClass; ?>">
	<div class="post-header-thumb-op" style="background-image:url(<?php echo htmlspecialchars($thumbUrl, ENT_QUOTES, 'UTF-8'); ?>);"></div>
	<div class="post-header-thumb-cover">
		<div class="post-header-thumb-container">
			<div class="post-header-thumb-title">
				<?php $this->title() ?>
			</div>
			<div class="post-header-thumb-meta">
				<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">Published on <?php $this->date('M j, Y'); ?></time> in <?php $this->category(''); ?> with <a href="#comments"><?php $this->commentsNum(_t(' 0 comment'), _t(' 1 comment'), _t(' %d comments')); ?></a>
			</div>
			<div class="post-tags">
				<?php $this->tags(' ', true, ''); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
$jsonld = [
    '@context' => 'https://schema.org',
    '@type'    => 'Article',
    'headline' => $this->title,
    'datePublished' => date('c', $this->created),
    'dateModified'  => date('c', $this->modified),
    'author' => ['@type' => 'Person', 'name' => $this->author->screenName],
    'publisher' => ['@type' => 'Organization', 'name' => $this->options->title],
    'url' => $this->permalink,
    'description' => $this->excerpt ?: mb_substr(strip_tags($this->content), 0, 160),
];
$thumb = postThumbUrl($this);
if ($thumb) $jsonld['image'] = $thumb;
?>
<script type="application/ld+json"><?php echo json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<article class="main-content <?php if ($this->options->postshowthumb == 'able'): ?>post-page<?php else: ?>page-page<?php endif; ?>">
	<div class="post-header">
		<h1 class="post-title" itemprop="name headline">
			<?php $this->title() ?>
		</h1>
		<div class="post-data">
			<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished">Published on <?php $this->date('M j, Y'); ?></time> in <?php $this->category(''); ?> with <a href="#comments"><?php $this->commentsNum(_t(' 0 comment'), _t(' 1 comment'), _t(' %d comments')); ?></a>
		</div>
	</div>
	<div id="post-content" class="post-content" itemprop="articleBody">
        <p class="post-tags">
            <?php $this->tags(' ', true, ''); ?>
        </p>
		<?php parseContent($this); ?>
		<p class="post-info">
			本文由 <a href="<?php $this->author->permalink(); ?>"><?php $this->author() ?></a> 创作，采用 <a href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer">知识共享署名4.0</a> 国际许可协议进行许可。<br>本站文章除注明转载/出处外，均为本站原创或翻译，转载前请务必署名。
		</p>
	</div>
</article>

<div id="post-bottom-bar" class="post-bottom-bar">
	<div class="bottom-bar-inner">
		<div class="bottom-bar-items social-share left">
			<span class="bottom-bar-item">Share : </span>
			<span class="bottom-bar-item bottom-bar-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($this->permalink); ?>" target="_blank" rel="noopener noreferrer" title="<?php $this->title() ?>">Facebook</a></span>
			<span class="bottom-bar-item bottom-bar-x"><a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($this->permalink); ?>&text=<?php echo urlencode($this->title); ?>" target="_blank" rel="noopener noreferrer" title="<?php $this->title() ?>">X</a></span>
			<span class="bottom-bar-item bottom-bar-weibo"><a href="http://service.weibo.com/share/share.php?url=<?php echo urlencode($this->permalink); ?>&amp;title=<?php echo urlencode($this->title); ?>" target="_blank" rel="noopener noreferrer" title="<?php $this->title() ?>">Weibo</a></span>
			<span class="bottom-bar-item bottom-bar-qrcode"><a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php echo urlencode($this->permalink); ?>" target="_blank" rel="noopener noreferrer">QR code</a></span>
		</div>
		<div class="bottom-bar-items right">
			<span class="bottom-bar-item"><?php theNext($this); ?></span>
			<span class="bottom-bar-item"><?php thePrev($this); ?></span>
			<span class="bottom-bar-item"><a href="#footer">↓</a></span>
			<span class="bottom-bar-item"><a href="#">↑</a></span>
		</div>
	</div>
</div>

<?php if ($this->options->relatedPosts == 'able'): ?>
<?php $this->related(6)->to($relatedPosts); ?>
<?php if($relatedPosts->have()): ?>
<div class="related-post-lists">
	<div class="post-lists">
		<div class="post-lists-body">
		<?php while($relatedPosts->next()): ?>
			<div class="post-list-item">
				<div class="post-list-item-container">
					<div class="item-label">
						<div class="item-title"><a href="<?php $relatedPosts->permalink() ?>"><?php $relatedPosts->title() ?></a></div>
						<div class="item-meta clearfix">
							<div class="item-meta-ico <?php echo postIcoClass($relatedPosts); ?>" style="background: url(<?php $this->options->themeUrl('images/bg-ico.png'); ?>) no-repeat;background-size: 40px auto;"></div>
							<div class="item-meta-cat"><?php $relatedPosts->category(''); ?></div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>

<?php $this->need('comments.php'); ?>

<?php $this->need('footer.php'); ?>
