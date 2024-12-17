<?php
require_once './basedatos/Configuration.php';

$response = (new Configuration())->createElement(
    $_POST['nombre'], 
    $_POST['descripcion'], 
    $_POST['nserie'], 
    $_POST['estado'], 
    $_POST['prioridad']
);
?>
