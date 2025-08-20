<?php
class ReservaModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Crear nueva reserva
    public function crearReserva($id_aula, $id_usuario, $fecha, $hora_inicio, $hora_fin) {
        $stmt = $this->db->prepare("
            INSERT INTO reservas (id_usuario, id_aula, fecha, hora_inicio, hora_fin)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$id_usuario, $id_aula, $fecha, $hora_inicio, $hora_fin]);
    }

    // Obtener todas las aulas disponibles (ingresadas por el admin)
    public function obtenerAulas() {
        $stmt = $this->db->query("SELECT * FROM aulas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar reservas con nombre de aula y capacidad
    public function obtenerReservas() {
        $stmt = $this->db->query("
            SELECT r.id_reserva, u.nombre AS profesor, a.nombre_aula, a.capacidad,
                   r.fecha, r.hora_inicio, r.hora_fin
            FROM reservas r
            INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
            INNER JOIN aulas a ON r.id_aula = a.id_aula
            ORDER BY r.fecha DESC, r.hora_inicio ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
