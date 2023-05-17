<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
    <link href="../css/styles.css" rel="stylesheet"/>
    <link href="../css/menu.css" rel="stylesheet"/>
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
                <a href="../index.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Sign up</span></span></a>
                <!--            <a href="index.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Prihlásenie</span></span></a>-->
                <a href="../registration/registration.php" class="nav-link"><span class="nav-link-span active"><span
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
                <a href="../index.php">Sing up</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../registration/registration.php">Registration</a><br>
            </nav>

        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="../web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK" src="https://www.countryflagicons.com/FLAT/24/SK.png"></button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN" src="https://www.countryflagicons.com/FLAT/24/GB.png"></button>
            </div>
        </form
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
                <a href="../index.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Prihlásenie</span></span></a>
                <!--            <a href="index.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Prihlásenie</span></span></a>-->
                <a href="../registration/registration.php" class="nav-link"><span class="nav-link-span active"><span
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
                <a href="../index.php">Prihlásenie</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../registration/registration.php">Registrácia</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="../web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK" src="https://www.countryflagicons.com/FLAT/24/SK.png"></button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN" src="https://www.countryflagicons.com/FLAT/24/GB.png"></button>
            </div>
        </form
    </div>

    <div class="container centered-container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Návod</h5>
                <h6>Registrácia</h6>
                <p>V prípade, že užívateľ nie je registrovaný, je potrebné sa pri prvom požití systému zaregistrovať. Táto možnosť je v pravej hornej časti obrazovky a po jej
                    zvolení sa otvorí formulár. Po vyplnení a validácii povinných polí je ešte nutné zvoliť, či je nový užívateľ učiteľ. V prípade, že možnosť zostane nezvolená, užívateľ je automaticky študent.
                    O úspešnej registrácii informuje upozornenie na obrazovke a používateľ sa môže prihlásiť.</p>
                <h6>Prihlásenie</h6>
                <p>Registrovaný používateľ zadá jedinečný email a heslo uvedené pri registrácii. Po úšešnom prihlásení je presmerovaný do svojej časti aplikácie na základe role vybranej pri registrácii.</p>
                <h6>Dvojjazyčosť</h6>
                <p>Na každej stránke je možné zvoliť jazyk stránky kliknutím na vlajky. Stránka je dostupná v slovenskom a anglickom jazyku</p>
                <h5>Návod - učiteľ</h5>
                <p>Po prihlásení do systému sa na obrazovke zobrazí informácia, pod akým menom sa učiteľ prihlási. Na navigačnej lište môže zvoliť, či chce zobraziť prehľad študentov, nahrať nový príklad alebo sa odhlásiť</p>
                <h6>Prehľad študentov</h6>
                <p>Pokiaľ si učiteľ zvolí možnosť "Prehľad študentov", zobrazí sa mu tabuľka so všetkými zaregistrovanými študentmi, spolu s počtom doteraz vygenerovaných úloh, počtom už odovzdaných úloh a súčtom získaných bodov daného študenta.
                    Po kliknutí na meno študenta sa učiteľovi zobrazí podrobný prehľad vygenerovaných úloh. Pri každej úlohe je názov úlohy, správna odpoveď a maximálny počet bodov, ktorý môže študent získať.
                    Pokiaľ už študent úlohu vypracoval, zobrazí sa aj jeho odpoveď, informácia o správnosti jeho odpovede a získaný počet bodov.</p>
                <h6>Príklady</h6>
                <p>Po kliknutí na možnosť "Príklady" sa učiteľovi zobrazí formulár na nahranie LaTex súboru s príkladmi. Učiteľ zvolí súbor, zadá počet bodov, ktoré má študent možnosť získať
                    a rozsah dátumov, kedy je možné vygenerovať si príklad. Pokiaľ nevyberie rozsah dátumov, príklad je možné vygenerovať si kedykoľvek. Pokiaľ k súboru je nutné nahrať aj obrázok, je možné nahrať ho vo formulári nižšie</p>
                <h5>Návod - študent</h5>
                <p>Po prihlásení do systému sa na obrazovke zobrazí informácia, pod akým menom sa študent prihlási. Na navigačnej lište môže zvoliť, či chce prejsť do časti "príklady" alebo sa odhlásiť </p>
                <h6>Príklady</h6>
                <p>Pokiaľ si študent zvolí možnosť "Príklady", zobrazí sa mu stránka, kde je možné vygenerovať nový príklad podľa zvoleného mena. Po vygenerovaní príkladu sa príklad pridá do zoznamu
                príkladov v susednej záložke. V tejto záložke je po kliknutí na príklad možné jeho vypracovanie, pokiaľ ešte vypracovaný nie je, prípadne zobrazenie hodnotenia v prípade, že je
                príklad už vypracovaný. Po zvolení možnosti "Vypracovať" je užívateľ presunutý na obrazovku s detailom príkladu, kde môže príklad vypracovať a odovzdať, alebo sa vrátiť späť na prehľad príkladov</p>

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



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>
</html>