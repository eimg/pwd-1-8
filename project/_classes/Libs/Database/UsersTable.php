<?php

namespace Libs\Database;

use PDO;
use PDOException;

class UsersTable
{
    private PDO $db;

    public function __construct(MySQL $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function find(String $email, String $password)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
            $statement->execute(["email" => $email, "password" => $password]);

            return $statement->fetch();

        } catch (PDOException $e) {
            $e->getMessage();
            exit();
        }
    }

    public function insert(Array $data)
    {
        try {
            $statement = $this->db->prepare(
                "INSERT INTO users (name, email, phone, address,
                password, created_at) VALUES (:name, :email,
                :phone, :address, :password, NOW())"
            );

            $statement->execute($data);

            return $this->db->lastInsertId();

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function updatePhoto(String $id, String $photo)
    {
        $statement = $this->db->prepare("UPDATE users SET photo=:photo WHERE id=:id");
        $statement->execute(["id" => $id, "photo" => $photo]);

        return $statement->rowCount();
    }
}
