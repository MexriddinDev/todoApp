<?php
namespace App;

class Todo{
    public $pdo;

    public function __construct(){
        $db = new DB();
        $this->pdo = $db->conn;
    }

    public function store($title, $dueDate, $userID){
        $query = "INSERT INTO todos(title, status, due_date, created_at, update_at , user_Id) 
                VALUES (:title, 'pending', :dueDate, NOW(), NOW(), :userId)";
        $this->pdo->prepare($query)->execute([
            ":title" => $title,
            ":dueDate" => $dueDate,
            ":userId" => $userID,
        ]);
    }

    public function getAllTodos($userId): array{
        $query = "SELECT * FROM todos WHERE user_Id = $userId";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function destroy(int $id): bool{
        $query = "DELETE FROM todos WHERE id=:id";
        return $this->pdo->prepare($query)->execute([
            ":id" => $id,
        ]);
    }

    public function getTodo(int $id){
        $query = "SELECT * FROM todos WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ":id" => $id,
        ]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $title, string $status,string $dueDate){
        $query = "UPDATE todos SET title=:title ,status=:status, due_date=:dueDate,update_at=NOW() where id=:id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ":id" => $id,
            ":title" => $title,
            ":status" => $status,
            ":dueDate" => $dueDate,
        ]);
    }
    public function getTodoByTelegramId (int $chatId)
    {
        $query = "SELECT * FROM todos INNER JOIN users on todos.user_id = users.id WHERE users.telegram_id = :chatId";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ":chatId" => $chatId
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


}
