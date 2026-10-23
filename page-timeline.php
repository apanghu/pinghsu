<?php
/**
* Template Page of Timeline Archives
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');

$stat = Typecho_Widget::widget('Widget_Stat');
$this->widget('Widget_Contents_Post_Recent', 'pageSize='.$stat->publishedPostsNum)->to($archives);

// Group by year
$byYear = [];
while ($archives->next()) {
    $y = date('Y', $archives->created);
    $byYear[$y][] = [
        'permalink' => $archives->permalink,
        'title'     => $archives->title,
        'date'      => date('M j, Y', $archives->created),
    ];
}
?>

<div class="main-content archive-page clearfix">
<div class="categories-item">
<?php foreach ($byYear as $year => $posts): ?>
<details open class="categories-year">
    <summary>
        <a href="<?php echo htmlspecialchars($this->options->siteUrl . $year, ENT_QUOTES, 'UTF-8'); ?>" onclick="event.stopPropagation()" class="categories-title"><?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?></a>
        <span class="year-count"><?php echo count($posts); ?> 篇</span>
    </summary>
    <div class="post-lists"><div class="post-lists-body">
    <?php foreach ($posts as $p): ?>
    <div class="post-list-item"><div class="post-list-item-container"><div class="item-label">
        <div class="item-title"><a href="<?php echo htmlspecialchars($p['permalink'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8'); ?></a></div>
        <div class="item-meta clearfix"><div class="item-meta-date"> <?php echo $p['date']; ?> </div></div>
    </div></div></div>
    <?php endforeach; ?>
    </div></div>
</details>
<?php endforeach; ?>
</div>
</div>

<?php $this->need('footer.php'); ?>
