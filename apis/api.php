<?php
require_once "../classes/Database.php";

use classes\Database;

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
            echo "OK";

        }
        else {
            reject(400, "Bad Request");
        }
    }
    else {
        reject(400, "Bad Request");
    }
}