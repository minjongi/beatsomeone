<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:image" content="이미지"/>
    <meta property="og:url" content="유알엘"/>
    <meta property="og:description" content="디스크립션"/>
    <meta property="og:title" content="타이틀"/>
    <meta name="viewport" content="width=1180">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>

    <link rel="stylesheet" type="text/css" href="/dist/chunk-common.css" />
    <script src="/dist/chunk-common.js"></script>
    <script src="/dist/chunk-vendors.js"></script>


    <?php echo $this->managelayout->display_css(); ?>
</head>
<body>

<div id="app">
    <?php if (isset($yield))echo $yield; ?>
</div>

</body>


<script type="text/javascript">
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

