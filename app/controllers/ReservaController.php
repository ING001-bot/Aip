<?php
session_start();
require '../models/ReservaModel.php';

class ReservaController {
    private $model;
    public $mensaje = "";

    public function __construct($conexion) {
        $this->model = new ReservaModel($conexion);
    }

    public function reservarAula($id_aula, $fecha, $hora_inicio, $hora_fin, $id_usuario) {
        if ($this->model->crearReserva($id_aula, $id_usuario, $fecha, $hora_inicio, $hora_fin)) {
            $this->mensaje = "✅ Reserva realizada correctamente.";
            return true;
        } else {
            $this->mensaje = "❌ Error al realizar la reserva.";
            return false;
        }
    }

    public function obtenerAulas() {
        return $this->model->obtenerAulas();
    }

    public function obtenerReservas() {
        return $this->model->obtenerReservas();
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
$reservas = $controller->obtenerReservas();
