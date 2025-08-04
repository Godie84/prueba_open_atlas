<?php
require_once __DIR__ . '/../config/Database.php';

class Project 
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, description FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, description FROM projects WHERE id = ?");
        $stmt->execute(['$id']);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['description']]);
    }
}