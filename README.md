# Pinghsu Theme · Typecho 1.3 / PHP 8 适配版

> **这是 [chakhsu/pinghsu](https://github.com/chakhsu/pinghsu) 的 fork。**
> 主题的设计与绝大部分代码出自原作者 [Chakhsu Lau](https://github.com/chakhsu)（主题预览：[linpx.com](https://www.linpx.com)）。
> 本仓库沿用原作者的 **MIT 协议**并保留其版权声明（见 [LICENSE.md](LICENSE.md)）；只是在原版基础上做了下面列出的改动。想要原汁原味的主题，请直接使用[原仓库](https://github.com/chakhsu/pinghsu)。

[English](README_en.md)

## 本分支改了什么

原版在 PHP 7.0 下测试，放到 Typecho 1.3 + PHP 8.2 上会在页面里打印一堆 `Deprecated` / `Warning`（每个页面的页脚、文章页的分享栏和上一篇/下一篇都会出现）。这个分支修掉了这些问题，并新增了两个页面模板。

### 一、兼容 Typecho 1.3 / PHP 8.2

| 文件 | 问题 | 改法 |
|---|---|---|
| `functions.php` → `getHotTags()` | 页脚“热门标签”。Typecho 1.2+ 的 `filter()` 不再返回 `permalink`，且这里把标签行交给了文章组件，报 `Undefined array key "created"` / `"permalink"`（每个标签一次，页面上刷一排） | 直接用 `\Typecho\Router::url('tag', …)` 生成标签链接 |
| `functions.php` → `theNext()` / `thePrev()` | 文章页“上一篇/下一篇”同样拿不到 `permalink` | 改用核心的 `\Widget\Contents\From` 组件取文章，由它给出固定链接 |
| `post.php` | 分享按钮里的 `urlencode($this->permalink())`、`urlencode($this->title())`：这两个方法是直接输出、返回 `null` 的，PHP 8.1+ 报 `urlencode(): Passing null` 弃用，分享链接本身也是坏的 | 改为读属性 `$this->permalink` / `$this->title` |
| `comments.php` | （不是兼容性修复）在评论表单后新增 reCAPTCHA v3 的输出 | 先用 `class_exists('reCAPTCHAv3_Plugin')` 判断，没装插件不受影响 |

### 二、新增两个页面模板

| 页面 | 文件 | 说明 |
|---|---|---|
| 友情链接 | `page-links.php` | 卡片网格（三列 / 两列 / 单列自适应）：彩色首字头像（有真实头像才用图片）、名称、简介、域名；下方是“本站信息”（一键复制）和“如何申请”；评论区保留，可继续用来收友链申请。数据读取 [Links 友情链接插件](#使用新页面)的 `links` 表（`state = 1`，按 `order` 排序），没启用插件时会给出提示 |
| 关于 | `page-about.php` | 站点 logo / 名称 / 简介 / 备案号、实时统计（文章 / 分类 / 标签 / 运行天数）、“关于本站”介绍、站点导航卡片、可选的“版权声明”区域 |
| 共用 | `pages.css`、`pages.js` | 样式全部限定在 `.pg` 下，不影响主题其他页面；脚本负责点击复制和数字动画。不依赖任何外部库或字体，尊重 `prefers-reduced-motion` |

| 友情链接 | 关于 |
|:--|:--|
| ![友情链接页](./doc/page-links.png) | ![关于页](./doc/page-about.png) |

（截图里的站名、友链、邮箱等都是占位内容。）

### 变更文件一览

| 文件 | 状态 |
|---|---|
| `functions.php` | 修改（`getHotTags`、`theNext`、`thePrev`） |
| `post.php` | 修改（分享按钮 4 处） |
| `comments.php` | 修改（新增 1 行，可选的 reCAPTCHA） |
| `page-links.php` | **新增** |
| `page-about.php` | **新增** |
| `pages.css` | **新增** |
| `pages.js` | **新增** |
| `doc/page-links.png`、`doc/page-about.png` | **新增**（截图） |
| `README.md`、`README_en.md` | 修改（顶部加入本说明，原文保留在下方） |

其余文件与原版 v1.6.2（上游最新提交 `ed2e5f5`）完全一致。

### 使用新页面

1. 把仓库里的文件覆盖到 `usr/themes/pinghsu/`（和原版安装方式相同）。
2. 后台「独立页面」→ 新建页面，在右侧“自定义模板”里选 **Template Page of Links**（友情链接）或 **Template Page of About**（关于）。
3. **友情链接页**：需要安装并启用 Links 友情链接插件（该插件在数据库里建 `links` 表，页面读取其中的 `name`、`url`、`description`、`image`、`state`、`order` 字段）。在插件的管理页里增删友链即可，页面自动更新。头像为空时显示首字色块；头像地址里含 `gravatar` 的会被当作占位图而忽略。
4. **关于页**：页面正文用 Markdown 写。第一个 `---`（水平线）**之前**的内容显示在“关于本站”卡片里，**之后**的内容显示在“版权声明”区域（不写就不显示这个区域）。站名、站点描述、logo（外观设置里的 `logoUrl`）、备案号（外观设置里的 `ICPRecordNumber`）自动读取；导航卡片会按实际情况出现：归档页（使用 `page-timeline.php` 模板的页面）、友链页、RSS、网站地图（需启用 Sitemap 插件）。正文里的 `<code class="pg-mail" data-copy="name#example.com" data-at tabindex="0" role="button">name#example.com</code>` 点击后会复制邮箱，并把 `#` 换成 `@`。

### 兼容性与已知限制

- **只在 Typecho 1.3.0 + PHP 8.2 下测试过。** 改动用到了 Typecho 1.2 以后的命名空间 API（`\Typecho\Router`、`\Widget\Options`、`\Widget\Contents\From`、`\Utils\Markdown`），更旧的版本没有测试，需要的话请使用原版。
- 主题之外，不少旧插件在 Typecho 1.3 / PHP 8 下也有同类问题（例如 Markdown 编辑器插件调用了已经变成 `protected` 的 `markdown()` / `autoP()`），那些不在本仓库的范围内。
- 页面文案是中文，没有做多语言。

### 致谢

- 原主题：[chakhsu/pinghsu](https://github.com/chakhsu/pinghsu)，作者 **Chakhsu Lau**，MIT 协议。
- 本分支的改动同样以 MIT 协议发布。

---

# 以下为原版 README

## Pinghsu Theme

[English](README_en.md)

![](./doc/pinghsu-theme-preview.jpg)

**主题介绍**

Pinghsu是一款以前端性能优化为出发点而制作的Typecho主题，同时又兼顾设计美学和视觉传达。主题命名取自作者姓名和其女朋友姓名的最后一个字的港式英文，挣扎于Hsuping还是Pinghsu，最后取为Pinghsu，意为一切都是Ping先Hsu后，即系要听女朋友的话。

**下载地址**

https://github.com/chakhsu/pinghsu

**主题预览**

https://www.linpx.com

## 主题亮点

 - 页面预加载与DNS预解析保证极快访问速度
 - 无JQuery，无前端框架，轻量级
 - 几乎零代码冗余，几乎每句代码都是有意义的
 - HighlightJS代码高亮，支持22种编程代码
 - 响应式设计，支持平板与手机，访问体验甚至优于桌面
 - 支持图片CDN镜像，支持多种文章缩略图设置
 - 支持首页三栏和单栏选择，文章题图和色块
 - 支持文章目录、相关文章与数学公式渲染
 - 支持文章个性化标徽设置，10种标徽选择
 - 支持个人社交按钮，社交分享
 - 主题设置添加XSS检测，评论提交防止触发多次
 - 还有更多亮点等你去发现~

## 更多预览

|首页 - 三栏|首页 - 单栏|
|:------|:------|
|![首页-三栏.png](./doc/首页-三栏.png)|![首页-单栏.png](./doc/首页-单栏.png)|

|文章内容页 - 题图|文章内容页 - 目录|
|:------|:------|
|![文章内容页-题图.png](./doc/文章内容页-题图.png)|![文章内容页-目录.png](./doc/文章内容页-目录.png)|

|页面内容页|内容页 - 评论|
|:------|:------|
|![页面内容页.png](./doc/页面内容页.png)|![内容页-评论.png](./doc/内容页-评论.png)|

|分类页|模板归档页|
|:------|:------|
|![分类页.png](./doc/分类页.png)|![模版归档页.png](./doc/模版归档页.png)|

|搜索页|404|
|:------|:------|
|![搜索页.png](./doc/搜索页.png)|![404页.png](./doc/404页.png)|

|移动端 - 首页|移动端 - 文章页|移动端 - 分类页|
|:------|:------|:------|
|![移动端-首页.png](./doc/移动端-首页.png)|![移动端-内容页.png](./doc/移动端-内容页.png)|![移动端-分类页.png](./doc/移动端-分类页.png)|

## 主题使用

**注意事项**：目前主题仅在 typecho 开发版，PHP7.0 下测试通过，其他情况未作太多测试

到 Github 下载，点击"Download ZIP"下载，解压后将文件夹改名为`pinghsu`后上传到 `/usr/themes`，并启用主题。

如果需要更新主题，则先下载最新文件，然后覆盖原文件即可完成更新，部分新增加的功能需要到后台开启才会生效

## 外观设置

外观设置主要分为四部分，分别为 logo、icon 的设置，功能开关，社交按钮设置，图片CDN镜像

使用注意事项都在设置里写得比较清楚了，如果遇到不明白的地方，可以给我留言反馈

下面有几点补充

 - CDN设置部分仅仅测试了七牛的，理论上也支持有镜像服务的CDN
 - 创建模板归档页，无论选择了哪个模板都要加上自定义字段`archive`

**独立搜索页**

设置方法看这里：[Here](https://www.linpx.com/p/add-a-separate-search-page-to-the-pinghsu-theme.html)

**文章缩略图**

文章设置缩略图方法有四种，自定义字段`thumb`，文章附件第一张图片，文章内图片，默认缩略图

优先级顺序 ：自定义字段 thumb -> 附件第一张图片 -> 文章图片 -> 默认缩略图 -> 随机图片 -> 无

缩略图尺寸大小，高度至少有250px，宽度大于高度，推荐高度为400px的

**个性化标徽**

个性化标徽出现的地方有首页、分类页，标签页，作者页和相关文章

设置方法是在文章编辑内填写自定义字段，支持的字段如下

`book` 、 `game` 、 `note` 、 `chat` 、 `code` 、 `image` 、 `web` 、 `link` 、 `design` 、 `lock`

**个性化色块**

个性化色块需要到外观设置那开启才能激活使用，色块出现的地方有首页，分类页，标签页，独立搜索页等等

设置方法是在文章编辑内填写自定义字段，支持的字段如下

`blue`、`purple`、`green`、`yellow`、`red`

**友情链接**

如果你想获取跟我一样的友情链接页面，因为是 typecho 开发版，支持在页面内写`<ul><li>`

所以你可以直接在`<ul>`内联一个`class="flinks"`,然后在`<li>`插入你的友链，即可

更多设置教程 : [Here](https://www.linpx.com/p/more-detailed-pinghsu-theme-set-tutorial.html)

## 浏览器兼容情况

这个····现代浏览器都兼容····

## Contributing 贡献

All kinds of contributions (enhancements, new features, documentation & code improvements, issues & bugs reporting) are welcome.

欢迎各种形式的贡献，包括但不限于优化，添加功能，文档 & 代码的改进，问题和 bugs 的报告。

## License 许可证

Open sourced under the MIT license.

根据 MIT 许可证开源。
