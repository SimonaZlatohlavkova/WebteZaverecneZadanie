<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION["role"] == "teacher") {
    header("Location: teacherMenu.php");
    exit();
}

$language = $_SESSION['lang'] ?? 'SK';

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Portal</title>
    <link href="../css/styles.css" rel="stylesheet"/>
    <link href="../css/menu.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <link href="teacherMenu.css" rel="stylesheet" />
</head>
<body>

<?php

if ($language === "SK") {
?>


<header id="nav-wrapper">
    <nav id="nav">
        <div class="nav left">
            <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">Školský portál  </a></h1></span>
            <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
        </div>
        <div class="nav right">
            <a href="../informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Návod</span></span></a>
            <a href="../latexHandling/php/studentQuestions.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Príklady</span></span></a>
            <a href="../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Odhlásenie</span></span></a>
        </div>
    </nav>
</header>

<input id="toggle" type="checkbox">

<label for="toggle" class="hamburger">
    <div class="top-bun"></div>
    <div class="meat"></div>
    <div class="bottom-bun"></div>
</label>

<div class="navSmall">
    <div class="navSmall-wrapperSmall">
        <nav id="navSmallHref">
            <a href="../informations/informations.php">Návod</a><br>
        </nav>
        <nav id="navSmallHref">
            <a href="../latexHandling/php/studentQuestions.php">Príklady</a><br>
        </nav>
        <nav id="navSmallHref">
            <a href="../controllers/logout-controller.php">Odhlásenie</a><br>
        </nav>
    </div>
</div>


<div class="welcomeDiv">
    <p class="Welcome">Vitajte !</p>
    <p class="welcomeMessage">Ste prihlásený ako študent pod menom <?php echo $_SESSION["name"] ?></p>
</div>


<div class="languageDiv" style="position:fixed; bottom:0.5rem; left: 0">
    <form method="post" action="../web/language.php">
        <div class="languageDiv">
            <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK"
                                                                                 src="https://www.countryflagicons.com/FLAT/24/SK.png">
            </button>
            <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN"
                                                                                 src="https://www.countryflagicons.com/FLAT/24/GB.png">
            </button>
        </div>
    </form
</div>

<?php } ?>


<?php

if ($language === "EN") {
    ?>


    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">
                <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">School portal  </a></h1></span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            <div class="nav right">
                <a href="../informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">User guide</span></span></a>
                <a href="../latexHandling/php/studentQuestions.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Assignments</span></span></a>
                <a href="../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Log out</span></span></a>
            </div>
        </nav>
    </header>

    <input id="toggle" type="checkbox">

    <label for="toggle" class="hamburger">
        <div class="top-bun"></div>
        <div class="meat"></div>
        <div class="bottom-bun"></div>
    </label>

    <div class="navSmall">
        <div class="navSmall-wrapperSmall">
            <nav id="navSmallHref">
                <a href="../informations/informations.php">User guide</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../latexHandling/php/studentQuestions.php">Assignments</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../controllers/logout-controller.php">Log out</a><br>
            </nav>
        </div>
    </div>


    <div class="welcomeDiv">
        <p class="Welcome">Welcome !</p>
        <p class="welcomeMessage">You are signed as student, <?php echo $_SESSION["name"] ?></p>
    </div>


    <div class="languageDiv" style="position:fixed; bottom:0.5rem; left: 0">
        <form method="post" action="../web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK"
                                                                                     src="https://www.countryflagicons.com/FLAT/24/SK.png">
                </button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN"
                                                                                     src="https://www.countryflagicons.com/FLAT/24/GB.png">
                </button>
            </div>
        </form
    </div>

<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>

</body>
</html>
