<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    header("Location: ../index.php");
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>School Portal</title>
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="#">School Portal</a>
    </div>
    <div class="navbar-right">
        <p>Welcome, <?php echo $_SESSION["name"] ?></p>
        <a href="../controllers/logout-controller.php">Logout</a>
    </div>
</nav>

</body>
</html>
