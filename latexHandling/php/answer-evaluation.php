<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["questionName"])) {
    header("location: studentQuestions.php");
    exit;
}

if (!isset($_POST["answer"])) {
    header("location: submitMath.php");
    exit;
}

$studentMail = $_SESSION["email"];

require_once "config.php";

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$answer = $_POST["answer"];

$sqlSelectSolution = "SELECT * FROM studentQuestions WHERE question_name = '$_SESSION[questionName]' AND student_mail = '$studentMail'";
$stmt = $db->query($sqlSelectSolution);
$solution = $stmt->fetch(PDO::FETCH_ASSOC);
$maxPoints = $solution['maxPoints'];

function convertLatexToMaxima($latexCode)
{

    // var_dump($latexCode);
    // Remove unnecessary spaces
    $latexCode = preg_replace('/\s+/', '', $latexCode);

    // Define conversion rules
    $conversionRules = [
        // Basic arithmetic operations
        '/\\+/' => '+',
        '/\\-/' => '-',
        '/\\*/' => '*',
        '/\\//' => '/',
        '/\\^/' => '^',

        // Fractions
        '/\\\frac{([^}]+)}{([^}]+)}/' => '(\1)/(\2)',
        '/\\\dfrac{([^}]+)}{([^}]+)}/' => '(\1)/(\2)',

        // Trigonometric functions
        '/\\\sin\(([^)]+)\)/' => 'sin(\1)',
        '/\\\cos\(([^)]+)\)/' => 'cos(\1)',
        '/\\\tan\(([^)]+)\)/' => 'tan(\1)',

        // Logarithmic functions
        '/\\\ln\(([^)]+)\)/' => 'log(\1)',

        // Square root
        '/\\\sqrt{([^}]+)}/' => 'sqrt(\1)',

        // Greek letters
        '/\\\alpha/' => 'alpha',
        '/\\\beta/' => 'beta',
        '/\\\gamma/' => 'gamma',
        // ... Add more Greek letters as needed

        // Constants
        '/\\\pi/' => 'pi',
        '/e(?![a-z])/i' => 'exp(1)',

        // Custom functions
        '/\\\eta\(([^)]+)\)/' => 'eta(\1)',
        // ... Add more custom functions as needed

        // Replace '\left[ ... \right]' with '[' ... ']'
        '/\\\left\[(.*?)\\\right\]/s' => '[\1]',

        // Insert '*' between numbers and characters
        '/(\d)([a-z])/' => '\1*\2',
        '/\\\cdot/' => '*',

        // Insert '*' between neccessary brackets
        '/(?<=[\)\]\}])[\(\[\{]/' => '*\0',
        '/\)(\s*exp\(1\))/' => ')*\1',
        '/\](\s*eta)/' => ']*\1',
    ];

    // Apply conversion rules
    foreach ($conversionRules as $pattern => $replacement) {
        $latexCode = preg_replace($pattern, $replacement, $latexCode);
    }

    return $latexCode;
}

function compareExpressions($expression1, $expression2)
{
    // Prepare the Maxima command
    $maximaCommand = "maxima -r 'expr1: $expression1; expr2: $expression2; is(expr1 = expr2);'";

    // Execute the Maxima command and capture the output
    $output = shell_exec($maximaCommand);

    // Process the Maxima output
    if (strpos($output, 'true') !== false) {
        echo "Expressions are equal.";
        return true; // Expressions are equal
    } elseif (strpos($output, 'false') !== false) {
        echo "Expressions are not equal.";
        return false; // Expressions are not equal
    }

    echo "Error: Maxima output does not contain a comparison result.";
    return false; // Default: Expressions are not equal
}

$studentAnswer = convertLatexToMaxima($answer);
$correctSolution = convertLatexToMaxima($solution['solution']);


$result = compareExpressions($studentAnswer, $correctSolution);
echo $result;

$correct = 0;
if ($result){
    $correct = 1;
    $points = $maxPoints;
} else {
    $correct = 0;
    $points = 0;
}

$sqlUpdateDb = "UPDATE studentQuestions SET answer = '$answer', correct = '$correct', points = '$points' WHERE question_name = '$_SESSION[questionName]' AND student_mail = '$studentMail'";
$stmt = $db->prepare($sqlUpdateDb);
$success = $stmt->execute();
?>