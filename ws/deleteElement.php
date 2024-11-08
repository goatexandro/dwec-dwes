<?php

 require_once './basedatos/base_datos.php';


$elementManager = new ElementManager();

$id = $_GET['id'] ?? null;

if ($id) {
    $response = $elementManager->deleteElementById($id);
} else {
    $response = ['success' => false, 'message' => 'Parámetro id no proporcionado', 'data' => null];
}

header('Content-Type: application/json');
echo json_encode($response);

?>
