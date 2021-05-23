<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Responsive for all device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="custom.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Wellcome to lockdoor page</title>        
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="images/minmin_icon.png" id="icon" alt="User Icon" />
    </div>
    <!-- Login Form -->
    <form action="login.php" method="post">
      <input type="text" id="loginname" class="fadeIn second" name="loginname" placeholder="login name">
      <input type="password" id="pw" class="fadeIn third" name="pw" placeholder="password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>   

  </div>
</div>
</body>
</html>