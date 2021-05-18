<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!-- Responsive for all device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Wellcome to lockdoor page</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="navbar-nav ml-auto">
            <a class="nav-item nav-link active" href="login.php">เข้าสู่ระบบ<span class="sr-only">(current)</span></a>
        </div>
    </nav>
    <img id='banner' class='mx-auto d-block img-fluid' src='' alt='img'>
    <img id='rule' class='mx-auto d-block img-fluid' src='' alt='img'>
    <script>
        $(document).ready(function () {
            if ($(window).width() >= 750) {
                $('#banner').attr('src', 'images/desktop_banner.jpeg')
                $('#rule').attr('src', 'images/desktop_rule.jpeg')
            } else {
                $('#banner').attr('src', 'images/mobile_banner.jpeg')
                $('#rule').attr('src', 'images/mobile_rule.jpeg')
            }
            $(window).bind('resize', function () {
                if ($(window).width() >= 750) {
                    $('#banner').attr('src', 'images/desktop_banner.jpeg')
                    $('#rule').attr('src', 'images/desktop_rule.jpeg')
                } else {
                    $('#banner').attr('src', 'images/mobile_banner.jpeg')
                    $('#rule').attr('src', 'images/mobile_rule.jpeg')
                }
            });
        });        
    </script>
</body>

</html>