<?php 

session_start();

if (!isset($_SESSION["questionName"])) {
    header("location: studentQuestions.php");
    exit;
}

if (!isset($_POST["answer"])) {
    header("location: submitMath.php");
    exit;
}  

require_once "config.php";

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$answer = $_POST["answer"];

$sqlSelectSolution = "SELECT solution FROM studentQuestions WHERE question_name = '$_SESSION[questionName]'";
$stmt = $db->query($sqlSelectSolution);
$solution = $stmt->fetch(PDO::FETCH_ASSOC);


echo $_POST["answer"];

?>