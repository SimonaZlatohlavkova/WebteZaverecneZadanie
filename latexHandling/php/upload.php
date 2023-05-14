<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$file = $_FILES["latexFile"]["tmp_name"];
$fileData = file_get_contents($file);

$sql = "INSERT INTO latexFiles (name, latexFile) VALUES (?, ?)";
$stmt = $db->prepare($sql);
$success = $stmt->execute([$_FILES["latexFile"]["name"], $fileData]);

if ($success) {
    echo "File uploaded successfully!";
} else {
    echo "Error uploading file!";
}

?>