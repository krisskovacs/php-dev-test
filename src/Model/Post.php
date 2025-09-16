<?php

namespace silverorange\DevTest\Model;

class Post
{
    public string $id;
    public string $title;
    public string $body;
    public string $created_at;
    public string $modified_at;
    public string $author;
    public string $author_fullname;

    private $pdo;
    private $table = "posts";

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Check if a record with the same id exists
    public function exists($id) {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Insert record into Posts table
    public function insert($data) {
        // skip duplicate
        if ($this->exists($data['id'])) {
            return false;
        }

        $query = "INSERT INTO {$this->table} (id, title, body, created_at, modified_at, author)
                  VALUES (:id, :title, :body, :created_at, :modified_at, :author)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':body', $data['body']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':modified_at', $data['modified_at']);
        $stmt->bindParam(':author', $data['author']);
        return $stmt->execute();
    }
}
