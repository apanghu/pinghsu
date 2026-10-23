<!DOCTYPE html>
<html lang="<?php echo $this->options->lang ? htmlspecialchars($this->options->lang, ENT_QUOTES, 'UTF-8') : 'zh-CN'; ?>">
    <head>
		<meta charset="<?php $this->options->charset(); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Cache-Control" content="no-transform">
		<meta http-equiv="Cache-Control" content="no-siteapp">
		<?php if($this->options->favicon): ?>
        <link rel="shortcut icon" href="<?php $this->options->favicon(); ?>"><?php endif; ?><?php if($this->options->iosicon): ?>
        <link rel="apple-touch-icon" href="<?php $this->options->iosicon(); ?>"><?php endif; ?>
        <title>404 Not Found - <?php $this->options->title() ?></title>
        <style>
        body{
            margin:0;padding:0;
            font-family: PingFang SC,Microsoft YaHei,WenQuanYi Micro Hei,sans-serif;
        }
        a {
            color:#6E7173;
            text-decoration:none;
            transition:all .1s ease-in;
        }
        a:hover, a:active {
            color:#6E7173;
        }
        .body404{
            position: absolute;
            height: 100%;
            width: 100%;
            background:#fff;
            background-size: auto 100%;
        }
        .site-name404 {
            margin: 0 auto;
            text-align: center;
            letter-spacing: 2px;
            font-size: 150px;
            line-height: 1;
            font-weight: 100;
            color: #f35626;
            background-image: linear-gradient(92deg,#f35626,#feab3a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: hue 60s infinite linear;
        }
        .title404 p{
            font-size: 20px;
            line-height:1.5;
            margin:0;
            color:#7b8993;
        }
        .info404{
            position: absolute;
            top: 50%;
            text-align: center;
            width: 100%;
            margin-top: -160px;
        }
        #footer404{
            margin-top:30px;
            font-size:10px;
        }
        .index404 {
            margin-top: 24px;
            display: inline-block;
            cursor: pointer;
            letter-spacing: 1px;
            font-size: 14px;
            border: 2px solid #7b8993;
            line-height: 36px;
            text-align: center;
            height: 36px;
            padding: 0 25px;
            border-radius: 25px;
            background-color: #fff;
            color: #7b8993;
        }
        @keyframes hue {
          from { filter: hue-rotate(0deg); }
          to   { filter: hue-rotate(-360deg); }
        }
        </style>
    </head>
    <body>
        <div class="body404" role="main">
            <div class="info404">
                <div class="site-name404" aria-label="404">404</div>
                <main>
                    <div class="title404">
                        <p>页面不存在，或已被删除。</p>
                    </div>
                    <a href="<?php $this->options->siteUrl(); ?>" class="index404">返回首页</a>
                </main>
            </div>
        </div>
    </body>
</html>
