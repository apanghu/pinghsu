<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

</main><!-- /#main-content -->

<footer id="footer" class="footer <?php if (isset($this->fields->archive)): ?>bg-white<?php elseif($this->is('archive')&&($this->options->colorBgPosts == 'defaultColor')): ?>bg-white<?php elseif($this->is('archive')&&($this->options->colorBgPosts == 'customColor')): ?>bg-grey<?php elseif($this->is('single')): ?>bg-white<?php endif; ?>">
    <div class="footer-social">
        <div class="footer-container clearfix">
            <div class="social-list">
            <?php if ($this->options->socialweibo): ?>
                <a class="social weibo" target="_blank" rel="noopener" href="<?php $this->options->socialweibo(); ?>">WEIBO</a>
            <?php endif; ?>
            <?php if ($this->options->socialzhihu): ?>
                <a class="social zhihu" target="_blank" rel="noopener" href="<?php $this->options->socialzhihu(); ?>">ZHIHU</a>
            <?php endif; ?>
                <a class="social rss" target="_blank" rel="noopener" href="<?php $this->options->feedUrl(); ?>">RSS</a>
            <?php if ($this->options->socialgithub): ?>
                <a class="social github" target="_blank" rel="noopener" href="<?php $this->options->socialgithub(); ?>">GITHUB</a>
            <?php endif; ?>
            <?php if ($this->options->socialtwitter): ?>
                <a class="social twitter" target="_blank" rel="noopener" href="<?php $this->options->socialtwitter(); ?>">TWITTER</a>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer-meta">
        <div class="footer-container">
            <div class="meta-item meta-copyright">
                <div class="meta-copyright-info">
                    <a href="<?php $this->options->siteUrl(); ?>" class="info-logo">
                        <?php if($this->options->footerLogoUrl): ?>
                        <img src="<?php $this->options->footerLogoUrl();?>" alt="<?php $this->options->title() ?>" />
                        <?php else : ?>
                        <?php $this->options->title() ?>
                        <?php endif; ?>
                    </a>
                    <div class="info-text">
                        <p>Theme is <a href="https://github.com/chakhsu/pinghsu" target="_blank" rel="noopener">Pinghsu</a> by <a href="https://www.linpx.com/" target="_blank" rel="noopener">Chakhsu</a></p>
                        <?php if ($this->options->ICPRecordNumber): ?>
                        <p><a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener"><?php $this->options->ICPRecordNumber(); ?></a></p>
                        <?php endif; ?>
                        <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a></p>
                    </div>
                </div>
            </div>
            <div class="meta-item meta-posts">
                <h3 class="meta-title">RECENT POSTS</h3>
                <?php getRecentPosts($this, 8); ?>
            </div>
            <div class="meta-item meta-tags">
                <h3 class="meta-title">HOT TAGS</h3>
                <?php getHotTags($this, 20); ?>
            </div>
        </div>
    </div>
</footer>

<?php if (($this->options->tableOfContents == 'able') && ($this->is('post'))): ?>
<div id="directory-content" class="directory-content">
    <nav class="toc js-toc"></nav>
</div>
<script src="<?php $this->options->themeUrl('vendor/tocbot.min.js'); ?>"></script>
<?php endif; ?>
<?php if(($this->is('single')) && ($this->allow('comment'))): ?>
<script>
(function () {
    window.TypechoComment = {
        dom : function (id) {
            return document.getElementById(id);
        },
        create : function (tag, attr) {
            var el = document.createElement(tag);
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
            return el;
        },
        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom('<?php echo $this->respondId(); ?>'),
                input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];
            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });

                form.appendChild(input);
            }
            input.setAttribute('value', coid);
            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id' : 'comment-form-place-holder'
                });

                response.parentNode.insertBefore(holder, response);
            }
            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';
            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }
            return false;
        },
        cancelReply : function () {
            var response = this.dom('<?php echo $this->respondId(); ?>'),
            holder = this.dom('comment-form-place-holder'),
            input = this.dom('comment-parent');
            if (null != input) {
                input.parentNode.removeChild(input);
            }
            if (null == holder) {
                return true;
            }
            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
})();
<?php if(!$this->user->hasLogin()): ?>
function getCommentCookie(name){
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) {
        return decodeURIComponent(arr[2]);
    } else {
        return null;
    }
}
function addCommentInputValue(){
    var prefix = '<?php echo \Typecho\Cookie::getPrefix(); ?>';
    document.getElementById('author').value = getCommentCookie(prefix + '__typecho_remember_author') || '';
    document.getElementById('mail').value   = getCommentCookie(prefix + '__typecho_remember_mail')   || '';
    document.getElementById('url').value    = getCommentCookie(prefix + '__typecho_remember_url')    || '';
}
addCommentInputValue();
<?php endif; ?>
</script>
<?php endif; ?>
<?php $this->footer(); ?>
<script src="<?php $this->options->themeUrl('vendor/headroom.min.js'); ?>"></script>
<?php if ($this->options->useHighline == 'able'): ?>
<script src="<?php $this->options->themeUrl('vendor/highlight.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->options->pjaxSet == 'able'): ?>
<script src="<?php $this->options->themeUrl('vendor/instantclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->options->fastClickSet == 'able'): ?>
<script src="<?php $this->options->themeUrl('vendor/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<script>
<?php if (($this->options->tableOfContents == 'able') && ($this->is('post'))): ?>
var _dirEl = document.getElementById("directory-content");
if (_dirEl && typeof Headroom !== 'undefined') {
    (new Headroom(_dirEl, {
        tolerance: 0,
        offset: <?php echo $this->options->postshowthumb == 'able' ? 280 : 90; ?>,
        classes: { initial: "initial", pinned: "pinned", unpinned: "unpinned" }
    })).init();
}
if (typeof tocbot !== 'undefined') {
    tocbot.init({
        tocSelector: '.toc',
        contentSelector: '.post-content',
        headingSelector: 'h1, h2, h3, h4, h5',
        collapseDepth: 2,
        scrollSmooth: true,
        scrollSmoothDuration: 600,
        scrollSmoothOffset: -80,
        headingsOffset: 80,
    });
}
<?php endif; ?>
var _hdrEl = document.getElementById("header");
if (_hdrEl && typeof Headroom !== 'undefined') {
    (new Headroom(_hdrEl, {
        tolerance: 0,
        offset: 70,
        classes: { initial: "animated", pinned: "slideDown", unpinned: "slideUp" }
    })).init();
}
<?php if (($this->options->pjaxSet == 'disable') && ($this->options->useHighline == 'able') && ($this->is('post'))): ?>
hljs.highlightAll();
<?php endif; ?>
<?php if ($this->options->fastClickSet == 'able'): ?>
if ('addEventListener' in document) {
    document.addEventListener('DOMContentLoaded', function() {
        FastClick.attach(document.body);
    }, false);
}
<?php endif; ?>
</script>
<?php if ($this->options->useMathjax == 'able'): ?>
<script type="text/x-mathjax-config">
MathJax.Hub.Config({
    showProcessingMessages: false,
    messageStyle: "none",
    extensions: ["tex2jax.js"],
    jax: ["input/TeX", "output/HTML-CSS"],
    tex2jax: {
        inlineMath: [ ['$','$'], ["\\(","\\)"] ],
        displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
        skipTags: ['script', 'noscript', 'style', 'textarea', 'pre','code','a'],
        ignoreClass:"comment-content"
    },
    "HTML-CSS": {
        availableFonts: ["STIX","TeX"],
        showMathMenu: false
    }
});
MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>
<?php $mjUrl = !empty($this->options->mathjaxUrl) ? htmlspecialchars($this->options->mathjaxUrl, ENT_QUOTES, 'UTF-8') : 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.9/MathJax.js?config=TeX-AMS-MML_HTMLorMML'; ?>
<script src="<?php echo $mjUrl; ?>" crossorigin="anonymous"></script>
<?php endif; ?>
<?php if($this->options->GoogleAnalytics): ?>
<?php $this->options->GoogleAnalytics(); ?>
<?php endif; ?>
<?php if ($this->options->postExtras == 'able'): ?>
<script src="<?php $this->options->themeUrl('extras.js'); ?>?v=<?php echo filemtime(__DIR__ . '/extras.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->options->pjaxSet == 'able'): ?>
<script data-no-instant>
InstantClick.on('change', function(isInitialLoad){
    <?php if ($this->options->useHighline == 'able'): ?>
    var blocks = document.querySelectorAll('pre code');
    for (var i = 0; i < blocks.length; i++) {
        hljs.highlightElement(blocks[i]);
    }
    <?php endif; ?>

    if (isInitialLoad === false) {
    <?php if($this->options->GoogleAnalytics): ?>
        if (typeof ga !== 'undefined') ga('send', 'pageview', location.pathname + location.search);
    <?php endif; ?>
    <?php if($this->options->useMathjax == 'able'): ?>
        if (typeof MathJax !== 'undefined'){MathJax.Hub.Queue(["Typeset",MathJax.Hub]);}
    <?php endif; ?>
    }
});
InstantClick.init('mousedown');
</script>
<?php endif; ?>
</body>
</html>
<?php if ($this->options->htmlCompress == 'able'): $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); endif; ?>
