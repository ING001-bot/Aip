<?php
require "../config/conexion.php";

class PrestamoModel {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Guardar múltiples préstamos con fecha manual
    public function guardarPrestamosMultiple($id_usuario, $equipos, $fecha_prestamo, $hora_inicio, $hora_fin = null) {
        if (!$id_usuario || empty($equipos)) {
            return ['mensaje'=>'⚠ No se proporcionó usuario o equipos.','tipo'=>'error'];
        }

        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("
                INSERT INTO prestamos (id_usuario, id_equipo, id_aula, fecha_prestamo, estado, hora_inicio, hora_fin)
                VALUES (?, ?, ?, ?, 'Prestado', ?, ?)
            ");

            foreach ($equipos as $id_equipo => $id_aula) {
                if ($id_equipo) {
                    $stmt->execute([$id_usuario, $id_equipo, $id_aula, $fecha_prestamo, $hora_inicio, $hora_fin]);
                }
            }

            $this->db->commit();
            return ['mensaje'=>'✅ Préstamos registrados correctamente.','tipo'=>'success'];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['mensaje'=>'❌ Error al registrar préstamos: '.$e->getMessage(),'tipo'=>'error'];
        }
    }

    // Listar equipos disponibles por tipo
    public function listarEquiposPorTipo($tipo) {
        $stmt = $this->db->prepare("
            SELECT id_equipo, nombre_equipo
            FROM equipos
            WHERE tipo_equipo = ?
            AND id_equipo NOT IN (
                SELECT id_equipo FROM prestamos WHERE estado = 'Prestado' AND fecha_prestamo = CURDATE()
            )
        ");
        $stmt->execute([$tipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar todos los préstamos con tipo aula y fecha devolución
    public function obtenerTodosPrestamos() {
        $stmt = $this->db->prepare("
            SELECT p.id_prestamo, e.nombre_equipo, u.nombre, 
                   a.nombre_aula, a.tipo,
                   p.fecha_prestamo, p.hora_inicio, p.hora_fin, 
                   p.fecha_devolucion, p.estado
            FROM prestamos p
            JOIN equipos e ON p.id_equipo = e.id_equipo
            JOIN usuarios u ON p.id_usuario = u.id_usuario
            JOIN aulas a ON p.id_aula = a.id_aula
            ORDER BY p.fecha_prestamo DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Devolver equipo con fecha de devolución
    public function devolverEquipo($id_prestamo) {
        $stmt = $this->db->prepare("
            UPDATE prestamos 
            SET estado='Devuelto', fecha_devolucion=CURDATE() 
            WHERE id_prestamo=?
        ");
        return $stmt->execute([$id_prestamo]);
    }
}
?>
