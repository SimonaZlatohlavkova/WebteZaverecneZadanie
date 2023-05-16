<?php
session_start();

if (!isset($_GET["sectionName"])) {
    header("location: studentQuestions.php");
    exit;
}

$questionName = $_GET["sectionName"];
$_SESSION["questionName"] = $questionName;
$language = $_SESSION['lang'] ?? 'SK';
require_once "config.php";

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlSelectQuestion = "SELECT * FROM studentQuestions WHERE question_name = '$questionName'";
$stmt = $db->query($sqlSelectQuestion);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlSelectImage = "SELECT image FROM latexImages WHERE name = ?";
$stmt = $db->prepare($sqlSelectImage);
$stmt->execute([$question['image']]);
$imageDB = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit page</title>
    <link href="submit.css" rel="stylesheet"/>
    <link href="/css/styles.css">
    <link href="/css/menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">

</head>

<body>


<?php

if ($language === "EN") {
    ?>
    <div class="wholePage">
        <div class="languageDiv">
            <form method="post" action="../../web/language.php">
                <div class="languageDiv">
                    <button type="submit" class="ButtonLanguageDiv" style="background: white; border: none" name="buttonSK"><img alt="SK"
                                                                                         src="https://www.countryflagicons.com/FLAT/24/SK.png">
                    </button>
                    <button type="submit" class="ButtonLanguageDiv" style="background: white; border: none" name="buttonEN"><img alt="EN"
                                                                                         src="https://www.countryflagicons.com/FLAT/24/GB.png">
                    </button>
                </div>
            </form
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Assignment:
                    <?php echo $questionName; ?></h5>
                <div>
                    <p>
                        <?php echo $question['question']; ?>
                    </p>
                    <p>
                        <?php
                        if ($imageDB) {
                            $imageData = base64_encode($imageDB['image']);
                            $image = "data:image/png;base64," . $imageData;
                            echo '<div class="image"><img  src="' . $image . '" alt="' . $image . '"></div>';
                        }
                        ?>
                    </p>

                    <form>
                        <p><b>Answer: </b> <span id="math-field" class="answerSpan"></span></p>
                        <div class="buttonFlexbox">
                            <button id="backButton" type="button" onclick="changeLocation()" class="btn btn-primary"> ❮
                                Back
                            </button>
                            <button id="submit-answer-button" type="button" class="btn btn-success"> Submit</button>
                        </div>


                    </form>

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
    <div class="wholePage">
        <div class="languageDiv">
            <form method="post" action="../../web/language.php">
                <div class="languageDiv">
                    <button type="submit" class="ButtonLanguageDiv" style="background: white; border: none" name="buttonSK"><img alt="SK"
                                                                                         src="https://www.countryflagicons.com/FLAT/24/SK.png">
                    </button>
                    <button type="submit" class="ButtonLanguageDiv"  style="background: white; border: none" name="buttonEN"><img alt="EN"
                                                                                         src="https://www.countryflagicons.com/FLAT/24/GB.png">
                    </button>
                </div>
            </form
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Príklad:
                    <?php echo $questionName; ?></h5>
                <div>
                    <p>
                        <?php echo $question['question']; ?>
                    </p>
                    <p>
                        <?php
                        if ($imageDB) {
                            $imageData = base64_encode($imageDB['image']);
                            $image = "data:image/png;base64," . $imageData;
                            echo '<div class="image"><img  src="' . $image . '" alt="' . $image . '"></div>';
                        }
                        ?>
                    </p>

                    <form>
                        <p><b>Odpoveď: </b> <span id="math-field" class="answerSpan"></span></p>
                        <div class="buttonFlexbox">
                            <button id="backButton" type="button" onclick="changeLocation()" class="btn btn-primary"> ❮
                                Späť
                            </button>
                            <button id="submit-answer-button" type="button" class="btn btn-success"> Odovzdať</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php
}
?>

<script>
    function changeLocation() {
        console.log("change")
        window.location.href = "studentQuestions.php"; // Replace with the desired URL
    }
</script>
<!-- <p>LaTeX of what you typed: <span id="latex"></span></p> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.8.0/math.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>
<script src="../js/editor.js"></script>
</body>

</html>