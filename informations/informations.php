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



    <style>


        @media (max-width: 600px) {
            .wholePage{
                margin-top: 2rem;
            }
        }
    </style>
</head>


<body>

<?php

if ($language === "EN") {
    ?>

    <?php if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        if ($_SESSION["role"] == "teacher") {
            ?>
            <header id="nav-wrapper">
                <nav id="nav">
                    <div class="nav left">
                        <span class="gradient skew"><h1 class="logo un-skew"><a
                                        id="logoID">School portal  </a></h1></span>
                        <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                    </div>
                    <div class="nav right">
                        <a href="../informations/informations.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">User guide</span></span></a>
                        <a href="../details/studentDetail.php" class="nav-link"><span class="nav-link-span active"><span
                                        class="u-nav">Students</span></span></a>

                        <a href="../latexHandling/latexIndex.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Assignments</span></span></a>
                        <a href="../controllers/logout-controller.php" class="nav-link"><span
                                    class="nav-link-span active"><span
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
                        <a href="../details/studentDetail.php">Students</a><br>
                    </nav>
                    <nav id="navSmallHref">
                        <a href="../latexHandling/latexIndex.php">Assignments</a><br>
                    </nav>
                    <nav id="navSmallHref">
                        <a href="../controllers/logout-controller.php">Log out</a><br>
                    </nav>
                </div>
            </div>

        <?php } else if (isset($_SESSION["login"]) && $_SESSION["login"]) {
            if ($_SESSION["role"] == "student") {
            }
            ?>
            <header id="nav-wrapper">
                <nav id="nav">
                    <div class="nav left">
                        <span class="gradient skew"><h1 class="logo un-skew"><a
                                        id="logoID">School portal  </a></h1></span>
                        <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                    </div>
                    <div class="nav right">
                        <a href="../informations/informations.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">User guide</span></span></a>
                        <a href="../latexHandling/php/studentQuestions.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Assignments</span></span></a>
                        <a href="../controllers/logout-controller.php" class="nav-link"><span
                                    class="nav-link-span active"><span
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
                        <a href="../latexHandling/php/studentQuestions.php">Assignmetns</a><br>
                    </nav>
                    <nav id="navSmallHref">
                        <a href="../controllers/logout-controller.php">Log out</a><br>
                    </nav>
                </div>
            </div>


        <?php }
    } else { ?>

        <header id="nav-wrapper">
            <nav id="nav">
                <div class="nav left">
                    <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">School portal  </a></h1></span>
                    <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                </div>
                <div class="nav right">
                    <a href="../index.php" class="nav-link"><span class="nav-link-span active"><span
                                    class="u-nav">Sign in</span></span></a>
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
                    <a href="../index.php">Sign in</a><br>
                </nav>
                <nav id="navSmallHref">
                    <a href="../registration/registration.php">Registration</a><br>
                </nav>
            </div>
        </div>

    <?php } ?>

    <div class="languageDiv">
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

    <div class="wholePage">

        <div class="card" style="width: 90vw; margin: 1rem">
            <div class="card-body">
                <div style="border-bottom: 1px solid black">
                    <div style="display: flex; flex-direction: row; justify-content: space-between">
                        <h3 class="card-title"><b>User guid </b></h3>
                        <div>
                            <button id="print" class="btn btn-primary" onclick="printDiv()"> <i class="fa-solid fa-cloud-arrow-down" style="color: #ffffff;"></i>  Save</button>
                        </div>
                    </div>
                </div>

                <br>
                <div id="instructions">
                    <h6><b>-> Registration </b></h6>
                    <p>If the user is not registered, it is necessary to register upon first use of the system.
                        This option is located in the upper right corner of the screen, and upon selection, a form will open. After filling out and validating the mandatory fields, it is necessary to choose whether the new user is a teacher. If the option remains unselected, the user is automatically considered a student. A notification on the screen will inform about successful registration, and the user can proceed to login.</p>
                    <h6><b>-> Login</b></h6>
                    <p>A registered user enters their unique email and the password provided during registration. After successful login, they are redirected to their respective section of the application based on the role chosen during registration.</p>
                    <h6><b>-> Bilingualism</b></h6>
                    <p>On each page, it is possible to select the language of the page by clicking on the flags. The page is available in Slovak and English languages.</p>
                    <div style="border-bottom: 1px solid grey">
                        <h5><b>Teacher's Guide</b></h5>
                    </div>
                    <br>
                    <p>Upon logging into the system, the screen displays information about the name under which the teacher is logged in. On the navigation bar, they can choose whether to view the overview of students, upload a new assignment, or log out.</p>
                    <h6><b>-> Students </b></h6>
                    <p>If the teacher selects the "Students" option, a table with all registered students will be displayed, along with the number of assignments generated so far, the number of submitted assignments, and the total points obtained by each student. By clicking on a student's name, the teacher will be able to view a detailed overview of the generated assignment. Each assignment will display the assignment title, correct answer, and the maximum number of points that a student can receive. If a student has already completed the assignment, their answer, information about the correctness of their response, and the number of points obtained will also be displayed.</p>
                    <h6><b>-> Assignments</b></h6>
                    <p>By clicking on the "Assignments" option, the teacher will be presented with a form to upload a LaTex file with assignments. The teacher selects the file, enters the number of points that a student can earn, and specifies the date range during which the assignment can be generated. If no date range is selected, the assignment can be generated at any time. If an image needs to be uploaded along with the file, it can be uploaded using the form below.</p>
                    <div style="border-bottom: 1px solid grey">
                        <h5><b>Student's Guide</b></h5>
                    </div>
                    <br>
                    <p>Upon logging into the system, the screen displays information about the name under which the student is logged in. On the navigation bar, they can choose whether to go to the "Assignments" section or log out.</p>
                    <h6><b>-> Assignments</b></h6>
                    <p>If the student selects the "Assignments" option, they will be directed to a page where they can generate a new assignment based on the chosen name. After generating the assignment, it will be added to the list of assignment in the adjacent tab. By clicking on an assignment in the tab, they can work on it if it hasn't been completed yet or view the grading if the assignment has already been completed. By selecting the "Complete" option, the user will be redirected to the assignment detail screen, where they can complete and submit the assignment or go back to the assignment overview.</p>
                </div>
            </div>
        </div>

    </div>

    <?php
}

?>


<?php

if ($language === "SK") {
    ?>

    <?php if (isset($_SESSION["login"]) && $_SESSION["login"]) {
        if ($_SESSION["role"] == "teacher") {
            ?>
            <header id="nav-wrapper">
                <nav id="nav">
                    <div class="nav left">
                        <span class="gradient skew"><h1 class="logo un-skew"><a
                                        id="logoID">Školský portál  </a></h1></span>
                        <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                    </div>
                    <div class="nav right">
                        <a href="../informations/informations.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Návod</span></span></a>
                        <a href="../details/studentDetail.php" class="nav-link"><span class="nav-link-span active"><span
                                        class="u-nav">Prehľad študentov</span></span></a>

                        <a href="../latexHandling/latexIndex.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Príklady</span></span></a>
                        <a href="../controllers/logout-controller.php" class="nav-link"><span
                                    class="nav-link-span active"><span
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
                        <a href="../details/studentDetail.php">Prehľad študentov</a><br>
                    </nav>
                    <nav id="navSmallHref">
                        <a href="../latexHandling/latexIndex.php">Príklady</a><br>
                    </nav>
                    <nav id="navSmallHref">
                        <a href="../controllers/logout-controller.php">Odhlásenie</a><br>
                    </nav>
                </div>
            </div>

        <?php } else if (isset($_SESSION["login"]) && $_SESSION["login"]) {
            if ($_SESSION["role"] == "student") {
            }
            ?>
            <header id="nav-wrapper">
                <nav id="nav">
                    <div class="nav left">
                        <span class="gradient skew"><h1 class="logo un-skew"><a
                                        id="logoID">Školský portál  </a></h1></span>
                        <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                    </div>
                    <div class="nav right">
                        <a href="../informations/informations.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Návod</span></span></a>
                        <a href="../latexHandling/php/studentQuestions.php" class="nav-link"><span
                                    class="nav-link-span active"><span
                                        class="u-nav">Príklady</span></span></a>
                        <a href="../controllers/logout-controller.php" class="nav-link"><span
                                    class="nav-link-span active"><span
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


        <?php }
    } else { ?>

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

    <?php } ?>

    <div class="languageDiv">
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

    <div class="wholePage">

        <div class="card" style="width: 90vw; margin: 1rem">
            <div class="card-body">
                <div style="border-bottom: 1px solid black">
                    <div style="display: flex; flex-direction: row; justify-content: space-between">
                        <h3 class="card-title"><b>Návod </b></h3>
                        <div>
                            <button id="print" class="btn btn-primary" onclick="printDiv()"> <i class="fa-solid fa-cloud-arrow-down" style="color: #ffffff;"></i>  Uložiť návod</button>
                        </div>
                    </div>
                </div>

                <br>
                <div id="instructions">
                <h6><b>->Registrácia </b></h6>
                <p>V prípade, že užívateľ nie je registrovaný, je potrebné sa pri prvom požití systému
                    zaregistrovať.
                    Táto možnosť je v pravej hornej časti obrazovky a po jej
                    zvolení sa otvorí formulár. Po vyplnení a validácii povinných polí je ešte nutné zvoliť, či je
                    nový
                    užívateľ učiteľ. V prípade, že možnosť zostane nezvolená, užívateľ je automaticky študent.
                    O úspešnej registrácii informuje upozornenie na obrazovke a používateľ sa môže prihlásiť.</p>
                <h6><b>-> Prihlásenie</b></h6>
                <p>Registrovaný používateľ zadá jedinečný email a heslo uvedené pri registrácii. Po úšešnom
                    prihlásení
                    je presmerovaný do svojej časti aplikácie na základe role vybranej pri registrácii.</p>
                <h6><b>-> Dvojjazyčosť</b></h6>
                <p>Na každej stránke je možné zvoliť jazyk stránky kliknutím na vlajky. Stránka je dostupná v
                    slovenskom
                    a anglickom jazyku</p>
                <div style="border-bottom: 1px solid grey">
                    <h5><b>Návod - učiteľ </b></h5>
                </div>
                <br>
                <p>Po prihlásení do systému sa na obrazovke zobrazí informácia, pod akým menom sa učiteľ prihlási.
                    Na
                    navigačnej lište môže zvoliť, či chce zobraziť prehľad študentov, nahrať nový príklad alebo sa
                    odhlásiť</p>
                <h6><b>-> Prehľad študentov </b></h6>
                <p>Pokiaľ si učiteľ zvolí možnosť "Prehľad študentov", zobrazí sa mu tabuľka so všetkými
                    zaregistrovanými študentmi, spolu s počtom doteraz vygenerovaných úloh, počtom už odovzdaných
                    úloh a
                    súčtom získaných bodov daného študenta.
                    Po kliknutí na meno študenta sa učiteľovi zobrazí podrobný prehľad vygenerovaných úloh. Pri
                    každej
                    úlohe je názov úlohy, správna odpoveď a maximálny počet bodov, ktorý môže študent získať.
                    Pokiaľ už študent úlohu vypracoval, zobrazí sa aj jeho odpoveď, informácia o správnosti jeho
                    odpovede a získaný počet bodov.</p>
                <h6><b>-> Príklady</b></h6>
                <p>Po kliknutí na možnosť "Príklady" sa učiteľovi zobrazí formulár na nahranie LaTex súboru s
                    príkladmi.
                    Učiteľ zvolí súbor, zadá počet bodov, ktoré má študent možnosť získať
                    a rozsah dátumov, kedy je možné vygenerovať si príklad. Pokiaľ nevyberie rozsah dátumov, príklad
                    je
                    možné vygenerovať si kedykoľvek. Pokiaľ k súboru je nutné nahrať aj obrázok, je možné nahrať ho
                    vo
                    formulári nižšie</p>
                <div style="border-bottom: 1px solid grey">
                    <h5><b>Návod - študent</b></h5>
                </div>
                <br>
                <p>Po prihlásení do systému sa na obrazovke zobrazí informácia, pod akým menom sa študent prihlási.
                    Na
                    navigačnej lište môže zvoliť, či chce prejsť do časti "príklady" alebo sa odhlásiť </p>
                <h6><b>-> Príklady</b></h6>
                <p>Pokiaľ si študent zvolí možnosť "Príklady", zobrazí sa mu stránka, kde je možné vygenerovať nový
                    príklad podľa zvoleného mena. Po vygenerovaní príkladu sa príklad pridá do zoznamu
                    príkladov v susednej záložke. V tejto záložke je po kliknutí na príklad možné jeho vypracovanie,
                    pokiaľ ešte vypracovaný nie je, prípadne zobrazenie hodnotenia v prípade, že je
                    príklad už vypracovaný. Po zvolení možnosti "Vypracovať" je užívateľ presunutý na obrazovku s
                    detailom príkladu, kde môže príklad vypracovať a odovzdať, alebo sa vrátiť späť na prehľad
                    príkladov</p>

            </div>
            </div>
        </div>

    </div>

    <?php
}

?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="printInstuctions.js" />

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>
</html>