<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$method = $_SERVER["REQUEST_METHOD"];

if (isset($method) && $method == "POST") {
    if (isset($_POST["email"])
        && isset($_POST["password"])
        && $_POST["email"] != ""
        && $_POST["password"] != "") {
        require_once "../apis/api.php";
        auth();
    }
    else {
        reject(400, "Bad Request");
    }
}


function reject($code, $message): void
{
    $data = new stdClass();
    $data->type = "error";
    $data->code = $code;
    $data->message = $message;
    echo json_encode($data);
}