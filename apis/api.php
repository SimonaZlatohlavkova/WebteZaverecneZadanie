<?php
require_once "../classes/Database.php";

use classes\Database;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function admin(): void
{
    $db = new Database();
    $db->createAdminUser();
}

function auth(): void
{
    $db = new Database();
    $email = $_POST["email"];

    $user = $db->findUserByEmail($email);
    if (isset($user) && $user) {
        if (password_verify($_POST["password"], $user["password"])) {

            $_SESSION["login"] = true;
            $_SESSION["name"] = $user["first_name"] . " " . $user["last_name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"];

            login($_SESSION);
        }
        else {
            reject(400, "Login Failed");
        }
    }
    else {
        reject(400, "Login Failed");
    }
}

function login($data): void
{
    $message = new stdClass();
    $message->type = "login";
    $message->code = 200;
    $message->message = "Login Successful";
    $message->userdata = $data;
    echo json_encode($message);
}

