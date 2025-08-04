<?php
//Endpoin users
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController();

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
