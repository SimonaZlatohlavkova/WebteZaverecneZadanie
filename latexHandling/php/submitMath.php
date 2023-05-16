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
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">
</head>

<body>
    <p>Question name:
        <?php echo $questionName; ?>
    </p>

    <p>
        <?php echo $question['question']; ?>
    </p>
    <p>
        <?php
        if ($imageDB) {
            $imageData = base64_encode($imageDB['image']);
            $image = "data:image/png;base64," . $imageData;
            echo '<div class="image"><img width="auto" src="' . $image . '" alt="' . $image . '"></div>';
        }
        ?>
    </p>

    <form>
        <p>Type answer here: <span id="math-field" style="width: 500px;"></span></p>
        <button id="submit-answer-button" type="button"> Submit</button>
    </form>
    <!-- <p>LaTeX of what you typed: <span id="latex"></span></p> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.8.0/math.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>
    <script src="../js/editor.js"></script>
</body>

</html>