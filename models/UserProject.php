<?php
require_once __DIR__ . '/../config/Database.php';

class UserProject
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function exists($userId, $projectId)
    {
        $stmt = $this->db->prepare("SELECT id FROM user_project WHERE user_id = ? AND project_id = ?");
        $stmt->execute([$userId, $projectId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userId, $projectId, $rate)
    {
        $stmt = $this->db->prepare("INSERT INTO user_project (user_id, project_id, rate) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $projectId, $rate]);
    }

    public function getRate($userId, $projectId)
    {
        $stmt = $this->db->prepare("SELECT rate FROM user_project WHERE user_id = ? AND project_id = ?");
        $stmt->execute([$userId, $projectId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['rate'] : null;
    }
}
