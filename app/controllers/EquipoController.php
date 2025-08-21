<?php
require_once '../models/EquipoModel.php';

class EquipoController {
    private $equipoModel;

    public function __construct() {
        $this->equipoModel = new EquipoModel();
    }

    /** 🔹 Registrar equipo */
    public function registrarEquipo($nombre_equipo, $tipo_equipo) {
        // Validación básica
        if (!$nombre_equipo || !$tipo_equipo) {
            return ['error' => true, 'mensaje' => '⚠ Todos los campos son obligatorios.'];
        }

        // Registrar el equipo (permitimos duplicados)
        $ok = $this->equipoModel->registrarEquipo($nombre_equipo, $tipo_equipo);

        return [
            'error' => !$ok,
            'mensaje' => $ok ? "✅ Equipo '$nombre_equipo' registrado correctamente." : "❌ Error al registrar el equipo."
        ];
    }

    /** 🔹 Listar equipos */
    public function listarEquipos() {
        return $this->equipoModel->obtenerEquipos();
    }

    /** 🔹 Eliminar equipo */
    public function eliminarEquipo($id_equipo) {
        return $this->equipoModel->eliminarEquipo($id_equipo);
    }
}

/** ----------- HANDLER ----------- */
$mensaje = '';
$mensaje_tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_equipo'])) {
    $controller = new EquipoController();
    $res = $controller->registrarEquipo($_POST['nombre_equipo'], $_POST['tipo_equipo']);
    $mensaje = $res['mensaje'];
    $mensaje_tipo = $res['error'] ? 'error' : 'success';
}

// En tu Admin.php, puedes mostrar $mensaje y $mensaje_tipo sin redirigir
?>
