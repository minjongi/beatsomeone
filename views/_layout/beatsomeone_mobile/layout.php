<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="fb:app_id" content="579999516228616"/>
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>
    <?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
    <?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
    <?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
    <?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
    <?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php echo html_escape(element('og_image', $layout)); ?>"/>
    <meta property="og:url" content="<?php echo html_escape(element('og_url', $layout)); ?>"/>
    <meta property="og:description" content="<?php echo html_escape(element('og_description', $layout)); ?>"/>
    <meta property="og:title" content="<?php echo html_escape(element('og_title', $layout)); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "<?php echo html_escape(element('page_title', $layout)); ?>",
            "url": "http://beatsomeone.com",
            "sameAs": [
                "https://www.instagram.com/beatsomeone",
                "https://www.youtube.com/channel/UCkOZTgnHFgC0Cb04W0AJ1LQ",
                "https://www.facebook.com/beatsomeone",
                "https://twitter.com/beatsomeone1"
            ]
        }
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '916279525470405');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=916279525470405&ev=PageView&noscript=1"
        /></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163407325-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-163407325-2');
    </script>

    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "4cfe6334e1f218";
        if(window.wcs) {
            wcs_do();
        }
    </script>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!--    <link rel="stylesheet" type="text/css" href="/dist/chunk-common.css" />-->
    <script src="/dist/chunk-common.js?v=<?php echo time(); ?>"></script>
    <script src="/dist/chunk-vendors.js?v=<?php echo time(); ?>"></script>
    <script src="/src/common.js?v=<?php echo time(); ?>"></script>

    <?php echo $this->managelayout->display_css(); ?>

    <style>
        .noti-wrap {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #000000;
            z-index: 10000;
            opacity: 0.7;
        }
        .noti-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10001;
            max-width:400px;
            width:100%;
        }
        .noti-content img {
            max-width:400px;
            width:100%;
            margin:0;
            padding:0;
            border:0;
        }
    </style>
</head>
<body>
<?php if (empty($_COOKIE['mt-popup-close']) || $_COOKIE['mt-popup-close'] !== 'Y') { ?>
<style>
    body, html {
        overflow: hidden;
        width: 100%;
        height: 100%;
    }
</style>
<div id="noti-popup">
    <div class="noti-wrap"></div>
    <div class="noti-content">
        <div>
            <img src="/assets_m/images/popup/0901/1.png">
        </div>
        <div>
            <img src="/assets_m/images/popup/0901/2.png" onclick="closePopup(true)" style="width:50%;"><img src="/assets_m/images/popup/0901/3.png" onclick="closePopup()" style="width:50%;">
        </div>
    </div>
</div>
 <?php } ?>

<div id="app">
    <?php if (isset($yield))echo $yield; ?>
</div>

</body>

<script type="text/javascript">
    function closePopup(isForever) {
        if (isForever) {
            setCookie('mt-popup-close', 'Y', 1);
        }
        $('html, body').css({'overflow': 'auto', 'height': 'auto'});
        document.querySelector('#noti-popup').remove();
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    $(document).on('click', '.viewpcversion', function(){
        Cookies.set('device_view_type', 'desktop', { expires: 1 });
    });
    $(document).on('click', '.viewmobileversion', function(){
        Cookies.set('device_view_type', 'mobile', { expires: 1 });
    });
</script>

<?php echo $this->managelayout->display_js(); ?>

<?php echo $this->managelayout->display_script(); ?>

</html>
