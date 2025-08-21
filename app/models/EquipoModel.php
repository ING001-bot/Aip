<?php
require '../config/conexion.php';

class EquipoModel {
    private $db;

    public function __construct() {
        global $conexion;
        $this->db = $conexion;
    }

    // Registrar un equipo (no bloquea duplicados)
    public function registrarEquipo($nombre_equipo, $tipo_equipo) {
        $stmt = $this->db->prepare(
            "INSERT INTO equipos (nombre_equipo, tipo_equipo) VALUES (?, ?)"
        );
        return $stmt->execute([$nombre_equipo, $tipo_equipo]);
    }

    // Obtener todos los equipos
    public function obtenerEquipos() {
        $stmt = $this->db->prepare("SELECT * FROM equipos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eliminar equipo
    public function eliminarEquipo($id_equipo) {
        $stmt = $this->db->prepare("DELETE FROM equipos WHERE id_equipo = ?");
        return $stmt->execute([$id_equipo]);
    }
}
?>
