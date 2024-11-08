<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'monfab';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $e->getMessage()]);
            exit;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

class ElementManager
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function getElementById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM elementos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? ['success' => true, 'message' => 'Elemento encontrado', 'data' => $result] : ['success' => false, 'message' => 'Elemento no encontrado', 'data' => null];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage(), 'data' => null];
        }
    }

    public function getAllElements()
    {
        try {
            $stmt = $this->connection->query("SELECT * FROM elementos");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['success' => true, 'message' => 'Elementos recuperados', 'data' => $results];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener elementos: ' . $e->getMessage(), 'data' => null];
        }
    }

    public function deleteElementById($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM elementos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return ['success' => false, 'message' => 'Elemento no encontrado', 'data' => null];
            }

            $stmt = $this->connection->prepare("DELETE FROM elementos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return ['success' => true, 'message' => 'Elemento eliminado', 'data' => $result];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage(), 'data' => null];
        }
    }

    public function createElement($nombre, $descripcion, $nserie, $estado, $prioridad) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO elementos (nombre, descripcion, nserie, estado, prioridad)
                 VALUES (:nombre, :descripcion, :nserie, :estado, :prioridad)"
            );
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':nserie', $nserie);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':prioridad', $prioridad);
    
            $stmt->execute();
    
            $id = $this->connection->lastInsertId();
    
            return $this->getElementById($id);
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al crear elemento: ' . $e->getMessage()];
        }
    }

    public function updateElement($id, $nombre = null, $descripcion = null, $nserie = null, $estado = null, $prioridad = null)
    {
        try {
            $array = [];
            if ($nombre) $array[] = "nombre = :nombre";
            if ($descripcion) $array[] = "descripcion = :descripcion";
            if ($nserie) $array[] = "nserie = :nserie";
            if ($estado) $array[] = "estado = :estado";
            if ($prioridad) $array[] = "prioridad = :prioridad";

            if (empty($array)) {
                return ['success' => false, 'message' => 'No se proporcionaron datos para actualizar', 'data' => null];
            }

            $sql = "UPDATE elementos SET " . implode(", ", $array) . " WHERE id = :id";
            $stmt = $this->connection->prepare($sql);

            if ($nombre) $stmt->bindParam(':nombre', $nombre);
            if ($descripcion) $stmt->bindParam(':descripcion', $descripcion);
            if ($nserie) $stmt->bindParam(':nserie', $nserie);
            if ($estado) $stmt->bindParam(':estado', $estado);
            if ($prioridad) $stmt->bindParam(':prioridad', $prioridad);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            return ['success' => true, 'message' => 'Elemento actualizado con éxito'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar el elemento: ' . $e->getMessage()];
        }
    }
}

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
