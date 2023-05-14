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
</head>

<body>
    <div>
        <form method="POST" action="select-file.php">
            <label for="file-name">Select file:</label>
            <select name="file-name" id="file-name">
                <?php
                foreach ($names as $name) {
                    echo '<option value="' . $name['name'] . '">' . $name['name'] . '</option>';
                }
                ?>
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>
    <?php
    if (empty($questions)) {
        echo "<div>No questions found.</div>";
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
                echo '<div class="image"><img src="' . $image . '" alt="' . $image . '"></div>';
            } else {
                echo "Image not found";
            }
        }

    }
    ?>
</body>

</html>