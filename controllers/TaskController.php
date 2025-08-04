<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController
{
    private $model;

    public function __construct()
    {
        $this->model = new Task();
    }

    public function index()
    {
        $tasks = $this->model->getAll();
        echo json_encode($tasks);
    }

    public function show($id)
    {
        $task = $this->model->getById($id);
        if ($task) {
            echo json_encode($task);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Tarea no encontrada']);
        }
    }

    public function store()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!$input || !isset($input['user_id'], $input['project_id'], $input['title'], $input['description'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        if ($this->model->create($input)) {
            http_response_code(201);
            echo json_encode(['message' => 'Tarea creada']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear tarea']);
        }
    }

    public function tasksByUser($userId)
    {
        $tasks = $this->model->getByUserId($userId);
        if ($tasks) {
            echo json_encode($tasks);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No se encontraron tareas para el usuario']);
        }
    }
}
