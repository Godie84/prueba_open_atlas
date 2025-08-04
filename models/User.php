<?php
require_once __DIR__ . '/../config/Database.php';

class User 
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, email, position FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, email, position FROM users WHERE id = ?");
        $stmt->execute(['$id']);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, position) VALUES (?, ?, ?)");
        return $stmt->execute([$data['name'], $data['email'], $data['position']]);
    }
}