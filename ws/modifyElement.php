<?php

require_once './basedatos/Configuration.php';


// Obtener los datos enviados en la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

// Comprobar que los datos necesarios están presentes
if (isset($data['id'], $data['nombre'], $data['descripcion'], $data['numeroSerie'], $data['estado'], $data['prioridad'])) {
    $id = $data['id'];
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $numeroSerie = $data['numeroSerie'];
    $estado = $data['estado'];
    $prioridad = $data['prioridad'];

    try {
        // Crear la conexión a la base de datos usando la clase Configuracion
        $configuracion = new Configuration();

        // Llamar al método updateElement() para actualizar el elemento
        $result = $configuracion->updateElement($id, $nombre, $descripcion, $numeroSerie, $estado, $prioridad);

        // Devolver la respuesta JSON
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el elemento: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos necesarios para la actualización.']);
}
?>
