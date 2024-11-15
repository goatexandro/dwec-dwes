<?php

require_once './basedatos/Base_datos.php';

$configuration = new Configuration();

$id = $_GET['id'] ?? null;

if ($id) {
    $response = $configuration->deleteElementById($id);
}
?>
