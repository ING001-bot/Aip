<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../models/ReservaModel.php';

class ReservaController {
    private $model;
    public $mensaje = "";

    public function __construct($conexion) {
        $this->model = new ReservaModel($conexion);
    }

    public function reservarAula($id_aula, $fecha, $hora_inicio, $hora_fin, $id_usuario) {
    // 🔹 Validar límite de horario (hasta 18:35)
    if ($hora_fin > "18:35") {
        $this->mensaje = "⚠️ El horario excede la hora límite permitida (18:35).";
        return false;
    }

    // 🔹 Validar que hora_inicio sea menor que hora_fin
    if ($hora_inicio >= $hora_fin) {
        $this->mensaje = "⚠️ La hora de inicio debe ser menor a la hora de fin.";
        return false;
    }

    // 🔹 Verificar disponibilidad del aula
    if ($this->model->verificarDisponibilidad($id_aula, $fecha, $hora_inicio, $hora_fin)) {
        if ($this->model->crearReserva($id_aula, $id_usuario, $fecha, $hora_inicio, $hora_fin)) {
            $this->mensaje = "✅ Reserva realizada correctamente.";
            return true;
        } else {
            $this->mensaje = "❌ Error al realizar la reserva.";
            return false;
        }
    } else {
        $this->mensaje = "⚠️ Aula ocupada en el horario seleccionado. Por favor elige otro horario.";
        return false;
    }
}

    public function obtenerAulas() {
        return $this->model->obtenerAulas();
    }

    public function obtenerReservas($id_usuario) {
        return $this->model->obtenerReservasPorProfesor($id_usuario);
    }
}

// Inicializar controlador
$controller = new ReservaController($conexion);

// Verificar sesión
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] !== 'Profesor') {
    echo "Acceso denegado";
    exit();
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'guardar') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_aula = $_POST['id_aula'];
    $fecha = $_POST['fecha'] ?? null;
    $hora_inicio = $_POST['hora_inicio'] ?? null;
    $hora_fin = $_POST['hora_fin'] ?? null;

    $controller->reservarAula($id_aula, $fecha, $hora_inicio, $hora_fin, $id_usuario);
}

$mensaje = $controller->mensaje;
$aulas = $controller->obtenerAulas();
$reservas = $controller->obtenerReservas($_SESSION['id_usuario']);
