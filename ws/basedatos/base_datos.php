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

class Configuration
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
            $query = $this->connection->prepare("SELECT * FROM elementos WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result ? ['success' => true, 'message' => 'Elemento encontrado', 'data' => $result] : ['success' => false, 'message' => 'Elemento no encontrado'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function getAllElements()
    {
        try {
            $query = $this->connection->query("SELECT * FROM elementos");
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return ['success' => true, 'message' => 'Elementos recuperados', 'data' => $results];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al obtener elementos: ' . $e->getMessage()];
        }
    }

    public function deleteElementById($id)
    {
        try {
            $query = $this->connection->prepare("SELECT * FROM elementos WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if (!$query) {
                return ['success' => false, 'message' => 'Elemento no encontrado'];
            }

            $query = $this->connection->prepare("DELETE FROM elementos WHERE id = :id");
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true, 'message' => 'Elemento eliminado', 'data' => $query];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function createElement($nombre, $descripcion, $nserie, $estado, $prioridad) {
        try {
            $query = $this->connection->prepare(
                "INSERT INTO elementos (nombre, descripcion, nserie, estado, prioridad)
                 VALUES (:nombre, :descripcion, :nserie, :estado, :prioridad)"
            );
            $query->bindParam(':nombre', $nombre);
            $query->bindParam(':descripcion', $descripcion);
            $query->bindParam(':nserie', $nserie);
            $query->bindParam(':estado', $estado);
            $query->bindParam(':prioridad', $prioridad);

            $query->execute();

            $id = $this->connection->lastInsertId();

            return ['success' => true, 'message' => 'Elemento creado con éxito'];
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
                return ['success' => false, 'message' => 'No se proporcionaron datos para actualizar'];
            }

            $sql = "UPDATE elementos SET " . implode(", ", $array) . " WHERE id = :id";
            $query = $this->connection->prepare($sql);

            if ($nombre) $query->bindParam(':nombre', $nombre);
            if ($descripcion) $query->bindParam(':descripcion', $descripcion);
            if ($nserie) $query->bindParam(':nserie', $nserie);
            if ($estado) $query->bindParam(':estado', $estado);
            if ($prioridad) $query->bindParam(':prioridad', $prioridad);
            $query->bindParam(':id', $id, PDO::PARAM_INT);

            $query->execute();

            return ['success' => true, 'message' => 'Elemento actualizado con éxito'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al actualizar el elemento: ' . $e->getMessage()];
        }
    }
}

$configuration = new Configuration();

$id = $_GET['id'] ?? null;

if ($id) {
    $response = $configuration->getElementById($id);
} else {
    $response = $configuration->getAllElements();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
