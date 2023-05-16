<?php
session_start();

if (!isset($_GET["sectionName"])) {
    header("location: studentQuestions.php");
    exit;
}

$questionName = $_GET["sectionName"];
$_SESSION["questionName"] = $questionName;

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">

</head>

<body>
<div class="wholePage">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Píklad:
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
                    <p><b>Odpoveď: </b> <span id="math-field" class="answerSpan" ></span></p>
                    <div class="buttonFlexbox">
                        <button id="backButton" type="button"  onclick="changeLocation()" class="btn btn-primary"> ❮ Späť</button>
                        <button id="submit-answer-button" type="button" class="btn btn-success"> Odovzdať</button>
                    </div>


                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

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