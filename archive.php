<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-content common-page clearfix">
    <div class="common-item">
        <h1 class="common-title">
            <?php $this->archiveTitle(array(
		        'category'  =>  _t('Category : %s'),
		        'search'    =>  _t('Search : %s'),
		        'tag'       =>  _t('Tag : %s'),
		        'author'    =>  _t('Author : %s'),
		        'date'      =>  _t('Date : %s')
		    ), '', ''); ?>
        </h1>
        <div class="post-lists">
			<div class="post-lists-body">
				<?php if ($this->have()): ?>
				<?php while($this->next()): ?>
				<?php $bgClass = postBgClass($this); ?>
				<div class="post-list-item">
					<div class="post-list-item-container <?php echo $bgClass; ?>">
						<div class="item-label <?php echo $bgClass; ?>">
							<div class="item-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></div>
							<div class="item-meta clearfix">
								<div class="item-meta-ico <?php echo postIcoClass($this); ?>" style="background: url(<?php $this->options->themeUrl('images/bg-ico.png'); ?>) no-repeat;background-size: 40px auto;"></div>
								<div class="item-meta-date"> <?php $this->date('M j, Y'); ?> </div>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				<?php else: ?>
                <div class="post-list-item"><?php _e('没有找到内容,请换别的关键字进行检索'); ?></div>
		        <?php endif; ?>
			</div>
		</div>
	</div>
	<div class="lists-navigator clearfix">
        <?php $this->pageNav('←','→'); ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>
