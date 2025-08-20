<?php
require_once '../models/EquipoModel.php';

class EquipoController {
    private $equipoModel;

    public function __construct() {
        $this->equipoModel = new EquipoModel();
    }

    /** 🔹 Registrar equipo */
    public function registrarEquipo($nombre_equipo, $tipo_equipo) {
        $ok = $this->equipoModel->registrarEquipo($nombre_equipo, $tipo_equipo);
        return ['error' => !$ok, 'mensaje' => $ok ? 'Equipo registrado correctamente' : 'Error al registrar equipo'];
    }

    /** 🔹 Listar equipos */
    public function listarEquipos() {
        return $this->equipoModel->obtenerEquipos();
    }
}

/** ----------- HANDLER ----------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EquipoController();

    if (isset($_POST['registrar_equipo'])) {
        $res = $controller->registrarEquipo($_POST['nombre_equipo'], $_POST['tipo_equipo']);
        header("Location: ../views/admin.php?msg=" . urlencode($res['mensaje']));
        exit;
    }
}
