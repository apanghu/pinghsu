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

$byYear = [];
while ($archives->next()) {
    $y = date('Y', $archives->created);
    $byYear[$y][] = [
        'permalink' => $archives->permalink,
        'title'     => $archives->title,
        'date'      => date('m/d', $archives->created),
    ];
}
?>

<div class="main-content archive-page clearfix">
<div class="timeline-wrap">
<?php foreach ($byYear as $year => $posts): ?>
<div class="timeline-year-group">
    <div class="timeline-year-node">
        <span class="timeline-year-label"><?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?></span>
        <small class="year-count"><?php echo count($posts); ?> 篇</small>
    </div>
    <ul class="timeline-list">
    <?php foreach ($posts as $p): ?>
        <li class="timeline-item">
            <span class="timeline-dot"></span>
            <time class="timeline-date"><?php echo $p['date']; ?></time>
            <a class="timeline-title" href="<?php echo htmlspecialchars($p['permalink'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8'); ?></a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
<?php endforeach; ?>
</div>
</div>

<?php $this->need('footer.php'); ?>
