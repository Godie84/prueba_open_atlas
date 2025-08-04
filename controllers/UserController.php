<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $users = $this->model->getAll();
        echo json_encode($users);
    }

    public function show($id)
    {
        $user = $this->model->getById($id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
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
            echo json_encode(['message' => 'Usuario creado']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al crear usuario']);
        }
    }
}
