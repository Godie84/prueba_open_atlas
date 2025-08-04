<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController
{
    private $model;

    public function __construct()
    {
        $this->model = new Project();
    }

    public function index()
    {
        $projects = $this->model->getAll();
        echo json_encode($projects);
    }

    public function show($id)
    {
        $project = $this->model->getById($id);
        if ($project) {
            echo json_encode($project);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Proyecto no encontrado']);
        }
    }

    public function store()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos']);
            return;
        }
        if ($this->model->create($input)) {
            http_response_code(201);
            echo json_encode(['message' => 'Proyecto creado']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear proyecto']);
        }
    }
}
