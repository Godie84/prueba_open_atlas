<?php
require_once __DIR__ . '/../controllers/ProjectController.php';

$controller = new ProjectController();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
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
