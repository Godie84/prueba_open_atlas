<?php
//Endpoin Projects
require_once __DIR__ . '/../controllers/ProjectController.php';

//Crear instancia del controlador
$controller = new ProjectController();

//Contenido de la respuewsta JSON
header('Content-Type: application/json');

//Metodo para validar el tipo de solicitud HTTP
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        //Si hay ID trae un usuario especifico
        if (isset($_GET['id'])) {
            // si no se especifica id trae todos los usuarios
            $controller->show($_GET['id']);
        } else {
            
            $controller->index();
        }
        break;

    case 'POST':
        $controller->store();
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
