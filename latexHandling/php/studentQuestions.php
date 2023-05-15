<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

session_start();

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlSelect = "SELECT name FROM latexFiles";
$stmt = $db->query($sqlSelect);
$names = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['latexFile'])) {
    $latexFile = $_SESSION['latexFile'];

    $delimiter = '\begin{task}';
    $questionsArray = explode($delimiter, $latexFile);
    array_shift($questionsArray);

    $questions = array();
    foreach ($questionsArray as $question) {
        $endLine = strpos($question, '\end{task}');
        $question = substr($question, 0, $endLine);

        preg_match_all('/\$.*?\$/', $question, $matches);
        foreach ($matches[0] as $match) {
            $wrappedFormula = '\(' . $match . '\)';
            $wrappedFormula = str_replace('$', '', $wrappedFormula);
            $question = str_replace($match, $wrappedFormula, $question);
        }

        $imagePath = '';

        if (preg_match('/includegraphics{([^}]+)}/i', $question, $matches)) {
            $imagePath = $matches[1];
        }

        $imageName = basename($imagePath);

        $question = preg_replace('/\\\\*includegraphics{([^}]+)}\s*\\\\*/i', '', $question);
        $question = preg_replace('/:\s*\\\\+/i', ':', $question);

        $questions[] = array(
            'question' => $question,
            'image' => $imageName
        );

        $randomIndex = array_rand($questions);
        $randomQuestion = $questions[$randomIndex];
    }

    unset($_SESSION['latexFile']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../css/menu.css" rel="stylesheet"/>
    <link href="../../css/styles.css" rel="stylesheet"/>
    <link href="test.css" rel="stylesheet"/>
</head>

<body>

<header id="nav-wrapper">
    <nav id="nav">
        <div class="nav left">
            <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">Školský portál  </a></h1></span>
            <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
        </div>
               <div class="nav right">
            <a href="../../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Odhlásenie</span></span></a>
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
            <a href="../../index.php">Prihlásenie</a><br>
        </nav>
    </div>
</div>


<div class="container-fluid centered-container " >
<div id="questionsFlex">
    <div class="card">
        <div class="card-body">

            <div>
                <form method="POST" action="select-file.php">
                    <label for="file-name">Vyberte súbor:</label>
                    <select name="file-name" id="file-name" class="form-select">
                        <option value="" disabled selected>Vyberte príklad</option>
                        <?php
                        foreach ($names as $name) {
                            echo '<option value="' . $name['name'] . '">' . $name['name'] . '</option>';
                        }
                        ?>

                    </select>
                    <button type="submit" class="btn btn-success">Vybrať</button>
                </form>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Príklad</h5>
                <?php

                if (empty($questions)) {
                    echo "<div id='noQuestions'>Neboli Vybraté žiadne otázky</div>";
                } else {
                    echo "<div id='question' class='question'>" . $randomQuestion['question'] . "</div>";
                    if ($randomQuestion['image']) {
                        $sqlSelectImage = "SELECT image FROM latexImages WHERE name = ?";
                        $stmt = $db->prepare($sqlSelectImage);
                        $stmt->execute([$randomQuestion['image']]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            $imageData = base64_encode($row['image']);
                            $image = "data:image/png;base64," . $imageData;
                            echo '<div class="image"><img width="auto" src="' . $image . '" alt="' . $image . '"></div>';
                        } else {
                            echo "Image not found";
                        }
                    }

                }

                ?>

        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>

</html>