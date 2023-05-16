<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

session_start();

$language = $_SESSION['lang'] ?? 'SK';

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlSelect = "SELECT name FROM latexFiles";
$stmt = $db->query($sqlSelect);
$names = $stmt->fetchAll(PDO::FETCH_ASSOC);

$studentName = $_SESSION['name'];
$studentMail = $_SESSION['email'];
$questionExists = false;

$sqlSelectStudentQuestions = "SELECT * FROM studentQuestions WHERE student_mail = '$studentMail'";
$stmt = $db->query($sqlSelectStudentQuestions);
$studentQuestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['latexFile'])) {
    $latexFile = $_SESSION['latexFile'];

    $sectionDelimiter = '\section*{';
    $taskDelimiter = '\begin{task}';
    $solutionDelimiter = '\begin{solution}';

    $sectionsArray = explode($sectionDelimiter, $latexFile);
    array_shift($sectionsArray);

    $questions = array();

    foreach ($sectionsArray as $section) {
        $sectionParts = explode($taskDelimiter, $section);
        $sectionName = substr($sectionParts[0], 0, strpos($sectionParts[0], '}'));

        $tasksArray = array_slice($sectionParts, 1);
        foreach ($tasksArray as $task) {
            $taskParts = explode($solutionDelimiter, $task);
            $taskContent = substr($taskParts[0], 0, strpos($taskParts[0], '\end{task}'));
            $solutionContent = substr($taskParts[1], 0, strpos($taskParts[1], '\end{solution}'));

            preg_match_all('/\$.*?\$/', $taskContent, $matches);
            foreach ($matches[0] as $match) {
                $wrappedFormula = '\(' . $match . '\)';
                $wrappedFormula = str_replace('$', '', $wrappedFormula);
                $taskContent = str_replace($match, $wrappedFormula, $taskContent);
            }

            $imagePath = '';
            if (preg_match('/includegraphics{([^}]+)}/i', $taskContent, $matches)) {
                $imagePath = $matches[1];
            }
            $imageName = basename($imagePath);

            $taskContent = preg_replace('/\\\\*includegraphics{([^}]+)}\s*\\\\*/i', '', $taskContent);
            $taskContent = preg_replace('/:\s*\\\\+/i', ':', $taskContent);

            $solutionContent = preg_replace('/\\\\begin{equation\*}/i', '', $solutionContent);
            $solutionContent = preg_replace('/\\\\end{equation\*}/i', '', $solutionContent);

            $questions[] = array(
                'sectionName' => $sectionName,
                'question' => $taskContent,
                'solution' => $solutionContent,
                'image' => $imageName
            );
        }
    }

    $randomIndex = array_rand($questions);
    $randomQuestion = $questions[$randomIndex];


    // if ($randomQuestion) {
    //     $sqlRandQuestion = "INSERT INTO studentQuestions (question_name, student_name, question, solution, image) VALUES (?, ?, ?, ?, ?)";
    //     $stmt = $db->prepare($sqlRandQuestion);
    //     $success = $stmt->execute([$randomQuestion['sectionName'], $studentName, $randomQuestion['question'], $randomQuestion['solution'], $randomQuestion['image']]);
    // }
    if ($randomQuestion) {
        $questionExists = false;

        // Check if the question already exists in the database
        foreach ($studentQuestions as $question) {
            if ($question['question'] === $randomQuestion['question'] && $question['solution'] === $randomQuestion['solution']) {
                $questionExists = true;
                break;
            }
        }

        if (!$questionExists) {
            // Insert the question into the database
            $sqlInsertQuestion = "INSERT INTO studentQuestions (question_name, student_mail, student_name, question, solution, image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sqlInsertQuestion);
            $stmt->execute([$randomQuestion['sectionName'], $studentMail, $studentName, $randomQuestion['question'], $randomQuestion['solution'], $randomQuestion['image']]);
        }
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
    <!--<link href="test.css" rel="stylesheet"/>-->
    <link href="tabsStyle.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


</head>

<body>
<?php

if ($language === "EN") {
    ?>

    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">
                <span class="gradient skew">
                    <h1 class="logo un-skew"><a id="logoID">School portal </a></h1>
                </span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            <div class="nav right">
                <a href="../../controllers/logout-controller.php" class="nav-link"><span
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
                <a href="../../controllers/logout-controller.php">Log out</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="../../web/language.php">
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
        <div class="card">
            <div class="card-body">
                <div>
                    <form method="POST" action="select-file.php">
                        <label for="file-name">Choose file:</label>
                        <select name="file-name" id="file-name" class="form-select">
                            <option value="" disabled selected>Choose assignment</option>
                            <?php
                            foreach ($names as $name) {
                                echo '<option value="' . $name['name'] . '">' . $name['name'] . '</option>';
                            }
                            ?>

                        </select>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>
                </div>

                <div>
                    <?php
                    if ($questionExists) {
                        echo "Tento príklad už bol vygenerovaný";
                    }
                    ?>
                </div>
                <div>
                    <h5 class="card-title">Assignment
                        <?php
                        if (empty($questions)) {
                            echo "";
                        } else {
                            echo $randomQuestion['sectionName'];
                        }
                        ?>
                    </h5>
                </div>

                <div>
                    <?php

                    if (empty($questions)) {
                        echo "<div id='noQuestions'>No assignments chosen</div>";
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
        <div class="card" id="questionsCard">
            <div class="card-body">
                <h5 class="card-title">Assignments</h5>

                <ul class="nav nav-tabs nav-questions" id="myTab" role="tablist">
                    <?php $first = true;
                    $i = 0; ?>
                    <?php foreach ($studentQuestions as $studentQuestion) { ?>
                        <li class="nav-item" style="width: auto">
                            <a class="nav-link"
                               style="color: inherit; transform: skew(0deg); background: inherit; font-size: x-small"
                               id="<?php echo $i; ?>-tab" data-toggle="tab" href="#<?php echo $i; ?>"
                               role="tab"

                               style="font-size: x-small">
                                <?php echo $studentQuestion['question_name']; ?></a>
                        </li>
                        <?php $first = false;
                        $i++; ?>
                    <?php } ?>
                </ul>


                <div class="tab-content" id="myTabContent" style="margin-top: 6rem;">
                    <?php
                    $first = true;
                    $i = 0;
                    foreach ($studentQuestions

                    as $studentQuestion) {
                    ?>
                    <div class="tab-pane" <?php if ($i === 0) {
                        echo "active";
                    } else {
                        echo "";
                    } ?>" id="<?php echo $i; ?>" role="tabpanel" >
                    <div class='questionName'><?php $studentQuestion['question_name']; ?></div> <?php
                    echo "<div id='question' class='question'>" . $studentQuestion['question'] . "</div>";

                    $sqlSelectImage = "SELECT image FROM latexImages WHERE name = ?";
                    $stmt = $db->prepare($sqlSelectImage);
                    $stmt->execute([$studentQuestion['image']]);
                    $imageDB = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($imageDB) {
                        $imageData = base64_encode($imageDB['image']);
                        $image = "data:image/png;base64," . $imageData;
                        echo '<div class="image"><img width="auto" height="auto" src="' . $image . '" alt="' . $image . '"></div>';
                    }


                    echo '<a href="submitMath.php?sectionName=' . urlencode($studentQuestion['question_name']) . '"> <b>  Elaborate </b></a> ';

                    ?>
                </div><?php
                $i++;
                $first = false;
                }
                ?>
            </div>

        </div>
    </div>


    <!--<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="..." alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Third slide">
            </div>
        </div>
    </div>-->

<?php } ?>


<?php

if ($language === "SK") {
    ?>

    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">
                <span class="gradient skew">
                    <h1 class="logo un-skew"><a id="logoID">Školský portál </a></h1>
                </span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            <div class="nav right">
                <a href="../../controllers/logout-controller.php" class="nav-link"><span
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
                <a href="../../controllers/logout-controller.php">Odhlásenie</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="../../web/language.php">
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
                        <button type="submit" class="btn btn-primary">Generovať príklad</button>
                    </form>
                </div>

                <div>
                    <?php
                    if ($questionExists) {
                        echo "Tento príklad už bol vygenerovaný";
                    }
                    ?>
                </div>
                <div>
                    <h5 class="card-title">Príklad
                        <?php
                        if (empty($questions)) {
                            echo "";
                        } else {
                            echo $randomQuestion['sectionName'];
                        }
                        ?>
                    </h5>
                </div>

                <div>
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
        <div class="card" id="questionsCard">
            <div class="card-body">
                <h5 class="card-title">Príklady</h5>

                <ul class="nav nav-tabs nav-questions" id="myTab" role="tablist">
                    <?php $first = true;
                    $i = 0; ?>
                    <?php foreach ($studentQuestions as $studentQuestion) { ?>
                        <li class="nav-item" style="width: auto">
                            <a class="nav-link"
                               style="color: inherit; transform: skew(0deg); background: inherit; font-size: x-small"
                               id="<?php echo $i; ?>-tab" data-toggle="tab" href="#<?php echo $i; ?>"
                               role="tab"

                               style="font-size: x-small">
                                <?php echo $studentQuestion['question_name']; ?></a>
                        </li>
                        <?php $first = false;
                        $i++; ?>
                    <?php } ?>
                </ul>


                <div class="tab-content" id="myTabContent" style="margin-top: 6rem;">
                    <?php
                    $first = true;
                    $i = 0;
                    foreach ($studentQuestions

                    as $studentQuestion) {
                    ?>
                    <div class="tab-pane" <?php if ($i === 0) {
                        echo "active";
                    } else {
                        echo "";
                    } ?>" id="<?php echo $i; ?>" role="tabpanel" >
                    <div class='questionName'><?php $studentQuestion['question_name']; ?></div> <?php
                    echo "<div id='question' class='question'>" . $studentQuestion['question'] . "</div>";

                    $sqlSelectImage = "SELECT image FROM latexImages WHERE name = ?";
                    $stmt = $db->prepare($sqlSelectImage);
                    $stmt->execute([$studentQuestion['image']]);
                    $imageDB = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($imageDB) {
                        $imageData = base64_encode($imageDB['image']);
                        $image = "data:image/png;base64," . $imageData;
                        echo '<div class="image"><img width="auto" height="auto" src="' . $image . '" alt="' . $image . '"></div>';
                    }


                    if ($studentQuestion['answer'] == null){
                        echo '<a href="submitMath.php?sectionName=' . urlencode($studentQuestion['question_name']) . '"> <b>  Vypracovať </b></a> ';
                    }

                    if ($studentQuestion['correct'] == 1){
                        echo '<p>Správne</p>';
                    } else if ($studentQuestion['correct'] == 0){
                        echo '<p>Nesprávne</p>';
                    }

                    ?>
                </div><?php
                $i++;
                $first = false;
                }
                ?>
            </div>

        </div>
    </div>


    <!--<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="..." alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="..." alt="Third slide">
            </div>
        </div>
    </div>-->

<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>

</html>