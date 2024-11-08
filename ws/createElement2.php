<?php
 require_once './basedatos/base_datos.php';

if (isset($_POST['nombre'], $_POST['descripcion'], $_POST['nserie'], $_POST['estado'], $_POST['prioridad'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $nserie = $_POST['nserie'];
    $estado = $_POST['estado'];
    $prioridad = $_POST['prioridad'];

    $elementManager = new ElementManager();

    $response = $elementManager->createElement($nombre, $descripcion, $nserie, $estado, $prioridad);
} else {
    $response = ['success' => false, 'message' => 'Faltan datos en el formulario.'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
