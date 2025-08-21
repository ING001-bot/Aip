<?php
class AulaModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crearAula($nombre, $capacidad) {
        $sql = "INSERT INTO aulas (nombre_aula, capacidad) VALUES (:nombre, :capacidad)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':capacidad' => $capacidad
        ]);
    }

    public function obtenerAulas() {
        $sql = "SELECT * FROM aulas";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarAula($id, $nombre, $capacidad) {
        $sql = "UPDATE aulas SET nombre_aula = :nombre, capacidad = :capacidad WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':capacidad' => $capacidad,
            ':id' => $id
        ]);
    }

    public function eliminarAula($id) {
        $sql = "DELETE FROM aulas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
