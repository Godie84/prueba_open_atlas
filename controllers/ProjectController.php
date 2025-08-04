<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController
{
    //Propiedad para almacenar la instancia del modelo Project
    private $model;

    //Constructor para inicializar e instanciar el modelo Project
    public function __construct()
    {
        $this->model = new Project();
    }

    //Metodo para obtener todos los proyectos
    public function index()
    {
        $projects = $this->model->getAll();
        echo json_encode($projects);//Devuelve la data en formato JSON
    }

    //Metodo para obtener un proyecto por ID
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

    //Metodo para creat proyectos en la base de datos
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
