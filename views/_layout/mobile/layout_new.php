<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>
    <?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
    <?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
    <?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
    <?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
    <?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>

    <meta property="fb:app_id" content="<?php echo html_escape(element('facebook_app_id', $layout)); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php echo html_escape(element('og_image', $layout)); ?>"/>
    <meta property="og:url" content="<?php echo html_escape(element('og_url', $layout)); ?>"/>
    <meta property="og:description" content="<?php echo html_escape(element('og_description', $layout)); ?>"/>
    <meta property="og:title" content="<?php echo html_escape(element('og_title', $layout)); ?>"/>

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome-pro/css/all.min.css" />

    <link rel="stylesheet" type="text/css" href="/dist/chunk-common.css" />
    <script src="/dist/chunk-common.js?v=<?php echo time(); ?>"></script>
    <script src="/dist/chunk-vendors.js?v=<?php echo time(); ?>"></script>

    <?php echo $this->managelayout->display_css(); ?>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
        // 자바스크립트에서 사용하는 전역변수 선언
        var cb_url = "<?php echo trim(site_url(), '/'); ?>";
        var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
        var cb_charset = "<?php echo config_item('charset'); ?>";
        var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
        var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
        var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
        var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
        var member_group_name = "<?php echo element('member_group_name', $view); ?>";
        var member = <?php echo json_encode($this->member->get_member()); ?>;
        var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
        var is_admin = "<?php echo $this->member->is_admin(); ?>";
        var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
        var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
        var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
        var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
        var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
        var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";
        var use_sociallogin_facebook = +"<?php echo $this->cbconfig->item('use_sociallogin_facebook'); ?>";
        var use_sociallogin_google = +"<?php echo $this->cbconfig->item('use_sociallogin_google'); ?>";
        var use_sociallogin_twitter = +"<?php echo $this->cbconfig->item('use_sociallogin_twitter'); ?>";
        var use_sociallogin_naver = +"<?php echo $this->cbconfig->item('use_sociallogin_naver'); ?>";
        var use_sociallogin_kakao = +"<?php echo $this->cbconfig->item('use_sociallogin_kakao'); ?>";
    </script>
    <script charset="euc-kr" src="https://tx.allatpay.com/common/NonAllatPayRE.js"></script>
    <script>
        window.allat_shop_receive_url = '<?= site_url('pg/allat/proc') ?>';
    </script>
</head>
<body>
<div id="app">
</div>

<script type="text/javascript">
    $(document).on('click', '.viewpcversion', function(){
        Cookies.set('device_view_type', 'desktop', { expires: 1 });
    });
    $(document).on('click', '.viewmobileversion', function(){
        Cookies.set('device_view_type', 'mobile', { expires: 1 });
    });
</script>

<?php echo $this->managelayout->display_js(); ?>

<!--
Layout Directory : <?php echo element('layout_skin_path', $layout); ?>,
Layout URL : <?php echo element('layout_skin_url', $layout); ?>,
Skin Directory : <?php echo element('view_skin_path', $layout); ?>,
Skin URL : <?php echo element('view_skin_url', $layout); ?>,
-->

</body>
</html>
