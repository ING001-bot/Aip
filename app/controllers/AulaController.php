<?php
require_once '../models/AulaModel.php';

class AulaController {
    private $model;

    public function __construct($conexion) {
        $this->model = new AulaModel($conexion);
    }

    public function crearAula($nombre, $capacidad) {
        return $this->model->crearAula($nombre, $capacidad);
    }

    public function listarAulas() {
        return $this->model->obtenerAulas();
    }

    public function actualizarAula($id, $nombre, $capacidad) {
        return $this->model->actualizarAula($id, $nombre, $capacidad);
    }

    public function eliminarAula($id) {
        return $this->model->eliminarAula($id);
    }
}
?>
