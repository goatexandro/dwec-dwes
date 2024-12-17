<?php
require_once './basedatos/Configuration.php';

$configuration = new Configuration();

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if ($id) {
    $response = $configuration->deleteElementById($id);
} else {
    $response = ['success' => false, 'message' => 'Faltan datos para eliminar el elemento'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
