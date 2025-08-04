<?php
require_once __DIR__ . '/../controllers/TaskController.php';

$controller = new TaskController();

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['user_id'])) {
            $controller->tasksByUser($_GET['user_id']);
        } elseif (isset($_GET['id'])) {
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

