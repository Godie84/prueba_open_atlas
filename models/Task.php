<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/UserProject.php';

class Task
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT tasks.id, tasks.title, tasks.description, tasks.date, users.name 
        AS user_name, projects.name 
        AS project_name 
            FROM tasks
            INNER JOIN users ON tasks.user_id = users.id
            INNER JOIN projects ON tasks.project_id = projects.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT tasks.id, tasks.title, tasks.description, tasks.date, users.name 
        AS user_name, projects.name 
        AS project_name
            FROM tasks
            INNER JOIN users ON tasks.user_id = users.id
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE tasks.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO tasks (user_id, project_id, title, description) VALUES (?, ?, ?, ?)");

        $userProject = new UserProject();
        if (!$userProject->exists($data['user_id'], $data['project_id'])) {
            $rate = isset($data['rate']) ? $data['rate'] : 0;
            $userProject->create($data['user_id'], $data['project_id'], $rate);
        }

        return $stmt->execute([
            $data['user_id'],
            $data['project_id'],
            $data['title'],
            $data['description']
        ]);
    }

    public function getByUserId($userId)
    {
        $stmt = $this->db->prepare("
        SELECT 
            t.id AS task_id,
            t.title,
            t.description,
            t.date,
            u.name AS user_name,
            p.name AS project_name,
            up.rate
        FROM tasks t
        INNER JOIN users u ON t.user_id = u.id
        INNER JOIN projects p ON t.project_id = p.id
        LEFT JOIN user_project up ON up.user_id = t.user_id AND up.project_id = t.project_id
        WHERE t.user_id = ?
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
