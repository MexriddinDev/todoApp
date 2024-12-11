<?php

namespace App;
class User
{
    public $pdo;
    public function __construct()
    {
        $db = new DB();
        $this->pdo = $db->conn;
    }

    public function register(
        string $fullName,
        string $email,
        string $password
    ): bool
    {
        $query = "INSERT INTO users (full_name, password, email) 
                    VALUES (:full_name, :password, :email)";
        $stmt = $this->pdo->prepare($query);
         return $stmt->execute([
            ':full_name' => $fullName,
            ':password' => $password,
            ':email' => $email
        ]);
    }

    public function login(string $email, string $password): array | bool
    {
        $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}