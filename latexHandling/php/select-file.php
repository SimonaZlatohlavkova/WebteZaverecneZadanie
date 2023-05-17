<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_POST['file-name'])) {
    $filename = $_POST['file-name'];

    require_once "config.php";

    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT latexFile, points FROM latexFiles WHERE name = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$filename]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $points = $row['points'];
    var_dump($points);
    $_SESSION['points'] = $points;
    $tmpFile = tmpfile();
    fwrite($tmpFile, $row['latexFile']);
    fseek($tmpFile, 0);

    $latexFile = stream_get_contents($tmpFile);
    $_SESSION['latexFile'] = $latexFile;

    $_SESSION['selectedFile']=1;
    fclose($tmpFile);
}

header('Location: studentQuestions.php');
exit;
?>