<?php

require_once './basedatos/base_datos.php';

$elementManager = new ElementManager();

$id = $_GET['id'] ?? null;

if ($id) {
    $response = $elementManager->getElementById($id);
} else {
    $response = $elementManager->getAllElements();
}

header('Content-Type: application/json');
echo json_encode($response);

?>
