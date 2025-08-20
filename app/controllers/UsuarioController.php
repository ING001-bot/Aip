<?php
require_once '../models/UsuarioModel.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    /** 🔹 Registro desde el admin (elige tipo de usuario) */
    public function registrarUsuario($nombre, $correo, $contraseña, $tipo_usuario) {
        if ($this->usuarioModel->existeCorreo($correo)) {
            return ['error' => true, 'mensaje' => 'El correo ya está registrado'];
        }
        $hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $ok = $this->usuarioModel->registrar($nombre, $correo, $hash, $tipo_usuario);
        return ['error' => !$ok, 'mensaje' => $ok ? 'Usuario registrado correctamente' : 'Error al registrar'];
    }

    /** 🔹 Registro público (auto tipo Profesor) */
    public function registrarProfesorPublico($nombre, $correo, $contraseña) {
        if ($this->usuarioModel->existeCorreo($correo)) {
            return ['error' => true, 'mensaje' => 'El correo ya está en uso'];
        }
        $hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $ok = $this->usuarioModel->registrar($nombre, $correo, $hash, 'Profesor');
        return ['error' => !$ok, 'mensaje' => $ok ? 'Cuenta creada con éxito' : 'Error al crear cuenta'];
    }

    /** 🔹 Listar usuarios (solo admin) */
    public function listarUsuarios() {
        return $this->usuarioModel->obtenerUsuarios();
    }

    /** 🔹 Eliminar usuario */
    public function eliminarUsuario($id_usuario) {
        return $this->usuarioModel->eliminarUsuario($id_usuario);
    }
}

/** ----------- HANDLER ----------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();

    if (isset($_POST['registrar_usuario_admin'])) {
        $res = $controller->registrarUsuario($_POST['nombre'], $_POST['correo'], $_POST['contraseña'], $_POST['tipo']);
        header("Location: ../views/admin.php?msg=" . urlencode($res['mensaje']));
        exit;
    }

    if (isset($_POST['registrar_profesor_publico'])) {
        $res = $controller->registrarProfesorPublico($_POST['nombre'], $_POST['correo'], $_POST['contraseña']);
        header("Location: ../views/login.php?msg=" . urlencode($res['mensaje']));
        exit;
    }
}
