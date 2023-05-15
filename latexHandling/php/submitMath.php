<?php
session_start();

if (!isset($_GET["sectionName"])){
    header("location: studentQuestions.php");
    exit;
}

$questionName = $_GET["sectionName"];

require_once "config.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">
</head>

<body>
    <p>Question name: <?php echo $questionName;?></p>

    <p>Type math here: <span id="math-field" style="width: 500px;"></span></p>
    <p>LaTeX of what you typed: <span id="latex"></span></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>
    <script src="../js/editor.js"></script>
</body>

</html>