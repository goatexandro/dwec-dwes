<?php

require_once './basedatos/base_datos.php';

$elementManager = new ElementManager();

$id = $_GET['id'] ?? null;

if (!$id) {
    $response = ['success' => false, 'message' => 'El ID es requerido para modificar un elemento', 'data' => null];
} else {
    $nombre = $_POST['nombre'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $nserie = $_POST['nserie'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $prioridad = $_POST['prioridad'] ?? null;

    $response = $elementManager->updateElement($id, $nombre, $descripcion, $nserie, $estado, $prioridad);
}

header('Content-Type: application/json');
echo json_encode($response);

?>
