<?php
class AulaModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function crearAula($nombre, $capacidad, $tipo) {
        $sql = "INSERT INTO aulas (nombre_aula, capacidad, tipo) VALUES (:nombre, :capacidad, :tipo)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':capacidad' => $capacidad,
            ':tipo' => $tipo
        ]);
    }

    public function obtenerAulas() {
        $sql = "SELECT * FROM aulas";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarAula($id, $nombre, $capacidad, $tipo) {
        $sql = "UPDATE aulas SET nombre_aula = :nombre, capacidad = :capacidad, tipo = :tipo WHERE id_aula = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':capacidad' => $capacidad,
            ':tipo' => $tipo,
            ':id' => $id
        ]);
    }

    public function eliminarAula($id) {
        $sql = "DELETE FROM aulas WHERE id_aula = :id";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
