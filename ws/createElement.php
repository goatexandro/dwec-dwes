<?php

require_once 'interfaces/IToJson.php'; 
require_once 'models/Element.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $numero_de_serie = $_POST['numero_de_serie'] ?? '';
    $estado = $_POST['estado'] ?? ''; 
    $prioridad = $_POST['prioridad'] ?? '';

    $elemento = new Element($nombre, $descripcion, $numero_de_serie, $estado, $prioridad);

    file_put_contents('Datos del formulario.txt', $elemento->toJson() . PHP_EOL, FILE_APPEND);

    echo $elemento->toJson();
}
?>
