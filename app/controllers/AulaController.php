<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../models/AulaModel.php';

class AulaController {
    private $model;

    public function __construct($conexion) {
        $this->model = new AulaModel($conexion);
    }

    // Crear un aula
    public function crearAula($nombre, $capacidad) {
        return $this->model->crearAula($nombre, $capacidad);
    }

    // Listar aulas
    public function listarAulas() {
        return $this->model->obtenerAulas();
    }

    // Obtener un aula por ID
    public function obtenerAula($id) {
        return $this->model->obtenerAulaPorId($id);
    }

    // Actualizar un aula
    public function actualizarAula($id, $nombre, $capacidad) {
        return $this->model->actualizarAula($id, $nombre, $capacidad);
    }

    // Eliminar un aula
    public function eliminarAula($id) {
        return $this->model->eliminarAula($id);
    }
}
