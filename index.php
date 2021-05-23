<?php session_start(); include 'html-header.php';?>
    <img id='banner' class='mx-auto d-block img-fluid' src='' alt='img'>
    <img id='rule' class='mx-auto d-block img-fluid' src='' alt='img'>
    <script>
        $(document).ready(function () {
            if ($(window).width() >= 750) {
                $('#banner').attr('src', 'images/template/desktop_banner.jpeg')
                $('#rule').attr('src', 'images/template/desktop_rule.jpeg')
            } else {
                $('#banner').attr('src', 'images/template/mobile_banner.jpeg')
                $('#rule').attr('src', 'images/template/mobile_rule.jpeg')
            }
            $(window).bind('resize', function () {
                if ($(window).width() >= 750) {
                    $('#banner').attr('src', 'images/template/desktop_banner.jpeg')
                    $('#rule').attr('src', 'images/template/desktop_rule.jpeg')
                } else {
                    $('#banner').attr('src', 'images/template/mobile_banner.jpeg')
                    $('#rule').attr('src', 'images/template/mobile_rule.jpeg')
                }
            });
        });        
    </script>
<?php include 'html-footer.php';?>