<?php
$this->managelayout->add_script('window.vm.$i18n = "' . element('cit_id', $view) . '";');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1420">

    <meta property="fb:app_id" content="579999516228616"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php echo html_escape(element('og_image', $layout)); ?>"/>
    <meta property="og:url" content="<?php echo html_escape(element('og_url', $layout)); ?>"/>
    <meta property="og:description" content="<?php echo html_escape(element('og_description', $layout)); ?>"/>
    <meta property="og:title" content="<?php echo html_escape(element('og_title', $layout)); ?>"/>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>

    <link rel="stylesheet" type="text/css" href="/dist/chunk-common.css" />
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
            background-color: #FFFFFF;
            z-index: 10001;
            max-width:400px;
            width:100%;
        }
        .noti-content img {
            max-width:400px;
            width:100%;
        }
    </style>
</head>
<body>
<?php if (empty($_COOKIE['mt-popup-close']) || $_COOKIE['mt-popup-close'] !== 'Y') { ?>
    <div id="noti-popup">
        <div class="noti-wrap"></div>
        <div class="noti-content">
            <div>
                <img src="/assets/images/popup/noti_mt1.png">
            </div>
            <div>
                <img src="/assets/images/popup/noti_mt2.png" onclick="closePopup(true)" style="width:49%;">
                <img src="/assets/images/popup/noti_mt3.png" onclick="closePopup()" style="width:49%;">
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
            setCookie('mt-popup-close', 'Y', 365);
        }
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

