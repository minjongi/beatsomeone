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
    <title><?php echo html_escape(element('page_title', $layout)); ?></title>
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <link rel="stylesheet" type="text/css" href="/dist/app.css" />
</head>
<body>

<div id="app">


    <?php if (isset($yield))echo $yield; ?>
</div>
<!-- built files will be auto injected -->
</body>


<script type="text/javascript">
    $(document).on('click', '.viewpcversion', function(){
        Cookies.set('device_view_type', 'desktop', { expires: 1 });
    });
    $(document).on('click', '.viewmobileversion', function(){
        Cookies.set('device_view_type', 'mobile', { expires: 1 });
    });
</script>

</html>

