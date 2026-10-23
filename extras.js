/*!
 * extras.js — Pinghsu theme add-ons (dark mode, post extras, code copy, back-to-top)
 * MIT — part of apanghu/pinghsu
 */
(function () {
    'use strict';

    /* ─── Dark mode ───────────────────────────────────────────────── */

    var DM = {
        KEY: 'ph-theme',
        // Set theme: 'dark' | 'light' | null (remove override)
        set: function (val) {
            var html = document.documentElement;
            if (val === 'dark' || val === 'light') {
                html.setAttribute('data-theme', val);
                try { localStorage.setItem(DM.KEY, val); } catch (e) {}
            } else {
                html.removeAttribute('data-theme');
                try { localStorage.removeItem(DM.KEY); } catch (e) {}
            }
            DM.updateIcon();
            DM.updateHljsTheme();
        },
        updateHljsTheme: function () {
            var el = document.getElementById('hljs-dark-theme');
            if (!el) return;
            el.media = DM.isDark() ? 'all' : 'not all';
        },
        // Read stored preference
        stored: function () {
            try { return localStorage.getItem(DM.KEY); } catch (e) { return null; }
        },
        isDark: function () {
            var v = document.documentElement.getAttribute('data-theme');
            if (v) return v === 'dark';
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        },
        toggle: function () { DM.set(DM.isDark() ? 'light' : 'dark'); },
        updateIcon: function () {
            var btn = document.getElementById('dm-toggle');
            if (!btn) return;
            btn.setAttribute('aria-label', DM.isDark() ? '切换为浅色模式' : '切换为深色模式');
            btn.setAttribute('title', DM.isDark() ? '浅色' : '深色');
            var icon = btn.querySelector('.dm-icon');
            if (icon) icon.textContent = DM.isDark() ? '☀' : '🌙';
        },
        init: function () {
            // Apply stored preference immediately (this also runs inline in header)
            var stored = DM.stored();
            if (stored) document.documentElement.setAttribute('data-theme', stored);

            var btn = document.getElementById('dm-toggle');
            if (btn) {
                btn.addEventListener('click', function () { DM.toggle(); });
                DM.updateIcon();
                DM.updateHljsTheme();
            }
            // Watch OS preference changes
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
                    if (!DM.stored()) { DM.updateIcon(); DM.updateHljsTheme(); }
                });
            }
        }
    };

    /* ─── Back to top ─────────────────────────────────────────────── */

    var BackTop = {
        el: null,
        init: function () {
            var btn = document.createElement('button');
            btn.id = 'back-top';
            btn.type = 'button';
            btn.setAttribute('aria-label', '回到顶部');
            btn.textContent = '↑';
            document.body.appendChild(btn);
            BackTop.el = btn;
            btn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            window.addEventListener('scroll', BackTop.update, { passive: true });
            BackTop.update();
        },
        update: function () {
            if (!BackTop.el) return;
            BackTop.el.classList.toggle('visible', window.pageYOffset > 300);
        }
    };

    /* ─── Reading time & word count ───────────────────────────────── */

    function initReadingTime() {
        var post = document.getElementById('post-content');
        var header = document.querySelector('.post-data, .post-header-thumb-meta');
        if (!post || !header) return;
        var text = post.innerText || post.textContent || '';
        var words = text.trim().split(/\s+/).length;
        // Chinese: count characters differently
        var cjk = (text.match(/[一-鿿㐀-䶿豈-﫿]/g) || []).length;
        // ~300 CJK chars/min, ~200 words/min
        var mins = Math.max(1, Math.round((cjk / 300) + ((words - cjk) / 200)));
        var span = document.createElement('span');
        span.className = 'read-time';
        span.setAttribute('aria-label', '预计阅读时间');
        span.textContent = ' · ' + mins + ' min read · ' + (cjk + (words - cjk)) + ' 字';
        header.appendChild(span);
    }

    /* ─── Code copy buttons ───────────────────────────────────────── */

    function initCodeCopy() {
        var blocks = document.querySelectorAll('pre');
        blocks.forEach(function (pre) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'code-copy-btn';
            btn.setAttribute('aria-label', '复制代码');
            btn.textContent = '复制';
            pre.style.position = 'relative';
            pre.appendChild(btn);
            btn.addEventListener('click', function () {
                var code = pre.querySelector('code');
                var text = code ? code.innerText : pre.innerText;
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(function () {
                        btn.textContent = '已复制 ✓';
                        setTimeout(function () { btn.textContent = '复制'; }, 2000);
                    }).catch(function () { fallbackCopy(text, btn); });
                } else {
                    fallbackCopy(text, btn);
                }
            });
        });
    }

    function fallbackCopy(text, btn) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;opacity:0';
        document.body.appendChild(ta);
        ta.focus(); ta.select();
        try {
            document.execCommand('copy');
            btn.textContent = '已复制 ✓';
            setTimeout(function () { btn.textContent = '复制'; }, 2000);
        } catch (e) {}
        document.body.removeChild(ta);
    }

    /* ─── Mobile TOC drawer ───────────────────────────────────────── */

    function initMobileToc() {
        var toc = document.getElementById('directory-content');
        if (!toc) return;
        // Only on mobile (<= 1000px)
        if (window.innerWidth > 1000) return;
        var btn = document.createElement('button');
        btn.id = 'toc-toggle';
        btn.type = 'button';
        btn.setAttribute('aria-label', '显示/隐藏目录');
        btn.setAttribute('aria-expanded', 'false');
        btn.textContent = '目录';
        // Insert before the post content
        var postContent = document.getElementById('post-content');
        if (postContent) postContent.parentNode.insertBefore(btn, postContent);
        btn.addEventListener('click', function () {
            var open = toc.classList.toggle('toc-open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    /* ─── Prev/next cards ─────────────────────────────────────────── */
    // Already handled in post.php via theNext/thePrev; no JS needed.

    /* ─── Search: highlight term ─────────────────────────────────── */

    function initSearchHighlight() {
        var params = new URLSearchParams(window.location.search);
        var q = params.get('s') || params.get('q');
        if (!q) return;
        q = q.trim();
        if (!q) return;
        var titles = document.querySelectorAll('.item-title a');
        var re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        titles.forEach(function (a) {
            a.innerHTML = a.textContent.replace(re, '<mark>$1</mark>');
        });
    }

    /* ─── Init ────────────────────────────────────────────────────── */

    function init() {
        DM.init();

        // Post-specific features (guarded by presence of post-content)
        var isPost = !!document.getElementById('post-content');
        if (isPost) {
            initReadingTime();
            initCodeCopy();
            initMobileToc();
        }

        // Back to top on all pages
        BackTop.init();

        // Search highlight on archive pages
        if (document.querySelector('.main-content.common-page')) {
            initSearchHighlight();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Re-init on InstantClick page changes (PJAX)
    if (window.InstantClick) {
        InstantClick.on('change', function () {
            // Re-run post extras on new page
            init();
        });
    } else {
        document.addEventListener('instantclick:change', init);
    }

})();
