<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION["role"] == "student") {
    header("Location: studentMenu.php");
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LaTeX file upload</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/menu.css" rel="stylesheet"/>
        <link href="../css/styles.css" rel="stylesheet"/>

        <link href="../latexHandling/php/test.css" rel="stylesheet"/>
        <link href="php/latexIndex.css" rel="stylesheet"/>
    </head>
    <body>

    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">
                <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">Školský portál  </a></h1></span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            </div>
            <div class="nav right">
                <a href="../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Odhlásenie</span></span></a>
                <a href="../latexHandling/latexIndex.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Príklady</span></span></a>
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
                <a href="../controllers/logout-controller.php">Odhlásenie</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../latexHandling/latexIndex.php">Príklady</a><br>
            </nav>
        </div>
    </div>

    <div class="wholePage">
            <div class="card card-upload">
                <div class="card-body">
                        <h1>Nahrajte LaTex súbor</h1>
                        <div class="rectangle">
                            <div class="rectangle-content">
                                <form>
                                    <label for="file-input">
                                        <input  class="form-control" id="file-input" type="file" name="latexFile" accept=".tex" multiple="false">
                                    </label>
                                    <button id="upload-button"  class="btn btn-primary" type="button"> Nahrať</button>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card card-upload" >
                <div class="card-body">

                    <h1>Nahrajte obrázok pre LaTexový súbor </h1>
                            <form>
                                <label for="image-input">
                                    <input class="form-control" id="image-input" type="file" name="latexImage" multiple="false">
                                </label>
                                <button id="upload-image-button" class="btn btn-primary" type="button"> Nahrať</button>
                            </form>

                </div>
            </div>
        </div>



    <!---    <div class="container">
            <h1>Upload LaTeX file here</h1>
            <div class="rectangle">
                <div class="rectangle-content">
                    <form>
                        <label for="file-input">
                            <input id="file-input" type="file" name="latexFile" accept=".tex" multiple="false">
                        </label>
                        <button id="upload-button" type="button"> Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <h1>Upload images for the LaTeX file here</h1>
            <div class="rectangle">
                <div class="rectangle-content">
                    <form>
                        <label for="image-input">
                            <input id="image-input" type="file" name="latexImage" multiple="false">
                        </label>
                        <button id="upload-image-button" type="button"> Upload</button>
                    </form>
                </div>
            </div>
        </div>-->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
            integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
            integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="js/upload.js"></script>
    </body>
</html>