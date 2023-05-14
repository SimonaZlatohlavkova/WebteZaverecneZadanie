<?php

namespace classes;
require_once "User.php";

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;
    private ?PDO $connection;

    public function __construct()
    {
        $this->host = "localhost";

        // localhost
        $this->username = "root";
        $this->password = "";

        // Server
//        $this->username = "xzlatohlavkova";
//        $this->password = "8vRHsM0WDjrbR4T";
        $this->database = "zz";
        $this->initDatabase();
    }

    private function initDatabase(): void
    {
        $dns = "mysql:host=$this->host;dbname=$this->database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ];

        try {
            $this->connection = new PDO($dns, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }

    // TODO
    //  Methods
    function findUserByEmail(string $email)
    {
        $db = new Database();
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->getConnection()->prepare($query);
        $stmt->bindParam(":email", $email);

        $stmt->execute();
        return $stmt->fetch();
    }

    function findUserByUsername(string $username)
    {
        $db = new Database();
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->getConnection()->prepare($query);
        $stmt->bindParam(":username", $username);

        $stmt->execute();
        return $stmt->fetch();
    }

    function createAdminUser(): void
    {
        $user = new User("Jan", "Mrkva", "admin", "admin@admin.com", "admin", "admin");

        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $query = "INSERT INTO users (first_name, last_name, email, password, role) VALUES (:first_name, :last_name, :email, :password, :role);";

        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(":first_name", $firstName);
        $stmt->bindParam(":last_name", $lastName);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);

        $stmt->execute();
    }



}