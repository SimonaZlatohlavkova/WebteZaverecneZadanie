<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["login"]) && $_SESSION["login"]) {
    if ($_SESSION["role"] == "teacher") {
        header("Location: menu/teacherMenu.php");
        exit();
    }
    else if ($_SESSION["role"] == "student") {
        header("Location: menu/studentMenu.php");
        exit();
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Portal</title>
    <link href="css/styles.css" rel="stylesheet"/>
    <link href="css/menu.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
</head>


<body>

<?php

if ($language === "EN") {
    ?>


    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">

                <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">School portal </a></h1></span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            <div class="nav right">
                <a href="informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">User Guide</span></span></a>
                <!--            <a href="index.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Prihlásenie</span></span></a>-->
                <a href="registration/registration.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Registration</span></span></a>
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
                <a href="informations/informations.php">User Guide</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="registration/registration.php">Registration</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK" src="https://www.countryflagicons.com/FLAT/24/SK.png"></button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN" src="https://www.countryflagicons.com/FLAT/24/GB.png"></button>
            </div>
        </form
    </div>

    <div class="toast show"  id="toastLogIN" style="position: absolute; top:1rem; z-index: 100; right:1rem; display: none">
        <div class="toast-header" style="background: #980019; color: white">
            <strong class="mr-auto text">ATTENTION!</strong>
        </div>

        <div class="toast-body">
            <p>Password or Login is not correct!</p>
        </div>
    </div>

    <div class="container centered-container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sign in</h5>
                <form>
                    <label for="username">
                        <input class="form-control" id="email-input" type="email" placeholder="Email">
                    </label>
                    <label class="form-label" for="password">
                        <input class="form-control" id="password-input" type="password" placeholder="Password">
                    </label>
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn">
                        <i class="fas fa-eye" aria-hidden="true"></i></button>
                    <button id="sign-in-button" type="button" class="btn btn-primary"> Sign in</button>
                </form>
            </div>
        </div>


        <script>

        </script>
        <!----  <div class="container">
              <h1>Welcome To School Portal</h1>
              <div class="rectangle">
                  <p class="rect-heading">Authentication</p>
                  <div class="rectangle-content">
                      <form>
                          <label for="username">
                              <input id="email-input" type="email" placeholder="Email">
                          </label>
                          <label class="form-label" for="password">
                              <input id="password-input" type="password" placeholder="Password">
                          </label>
                          <button id="sign-in-button" type="button"> Sign In</button>
                      </form>

                  </div>
              </div>
          </div>--->
    </div>


    <?php

}

?>


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
                <a href="informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Návod</span></span></a>
                <!--            <a href="index.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Prihlásenie</span></span></a>-->
                <a href="registration/registration.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Registrácia</span></span></a>
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
                <a href="informations/informations.php">Návod</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="registration/registration.php">Prihlásenie</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK" src="https://www.countryflagicons.com/FLAT/24/SK.png"></button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN" src="https://www.countryflagicons.com/FLAT/24/GB.png"></button>
            </div>
        </form
    </div>

    <div class="toast show" id="toastLogIN" style="position: absolute; top:1rem; z-index: 100; right:1rem; display: none">
        <div class="toast-header" style="background: #980019; color: white">
            <strong class="mr-auto text">POZOR!</strong>
        </div>
        <div class="toast-body">
            <p>Nesprávne meno alebo heslo!</p>
        </div>
    </div>

    <div class="container centered-container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Prihlásenie</h5>
                <form>
                    <label for="username">
                        <input class="form-control" id="email-input" type="email" placeholder="Email">
                    </label>
                    <label class="form-label" for="password">
                        <input class="form-control" id="password-input" type="password" placeholder="Heslo">
                    </label>
                    <button class="btn btn-outline-secondary" type="button" id="showPasswordBtn">
                        <i class="fas fa-eye" aria-hidden="true"></i></button>
                    <button id="sign-in-button" type="button" class="btn btn-primary"> Prihlásiť sa</button>
                </form>
            </div>
        </div>


        <script>

        </script>
        <!----  <div class="container">
              <h1>Welcome To School Portal</h1>
              <div class="rectangle">
                  <p class="rect-heading">Authentication</p>
                  <div class="rectangle-content">
                      <form>
                          <label for="username">
                              <input id="email-input" type="email" placeholder="Email">
                          </label>
                          <label class="form-label" for="password">
                              <input id="password-input" type="password" placeholder="Password">
                          </label>
                          <button id="sign-in-button" type="button"> Sign In</button>
                      </form>

                  </div>
              </div>
          </div>--->
    </div>

    <?php
}

?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="scripts/login.js"></script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>
</html>