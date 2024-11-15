<?php

require_once './basedatos/Base_datos.php';

$configuration = new Configuration();

$id = $_GET['id'] ?? null;

if (!$id) {
    $response = ['success' => false, 'message' => 'El ID es requerido para modificar un elemento'];
} else {
    $nombre = $_POST['nombre'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $nserie = $_POST['nserie'] ?? null;
    $estado = $_POST['estado'] ?? null;
    $prioridad = $_POST['prioridad'] ?? null;

    $response = $configuration->updateElement($id, $nombre, $descripcion, $nserie, $estado, $prioridad);
}

?>
