<?php
require_once '../models/UsuarioModel.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function registrarUsuario($nombre, $correo, $contraseña, $tipo_usuario) {
        if ($this->usuarioModel->existeCorreo($correo)) {
            return ['error' => true, 'mensaje' => '⚠️ El correo ya está registrado'];
        }
        if (strlen($contraseña) < 6) {
            return ['error' => true, 'mensaje' => '⚠️ La contraseña debe tener al menos 6 caracteres'];
        }
        $hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $ok = $this->usuarioModel->registrar($nombre, $correo, $hash, $tipo_usuario);
        return ['error' => !$ok, 'mensaje' => $ok ? '✅ Usuario registrado correctamente' : '❌ Error al registrar'];
    }

    public function registrarProfesorPublico($nombre, $correo, $contraseña) {
        if ($this->usuarioModel->existeCorreo($correo)) {
            return ['error' => true, 'mensaje' => '⚠️ El correo ya está en uso'];
        }
        if (strlen($contraseña) < 6) {
            return ['error' => true, 'mensaje' => '⚠️ La contraseña debe tener al menos 6 caracteres'];
        }
        $hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $ok = $this->usuarioModel->registrar($nombre, $correo, $hash, 'Profesor');
        return ['error' => !$ok, 'mensaje' => $ok ? '✅ Cuenta creada con éxito' : '❌ Error al crear cuenta'];
    }
}

/** ----------- HANDLER ----------- */
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UsuarioController();

    if (isset($_POST['registrar_usuario_admin'])) {
        $res = $controller->registrarUsuario(
            $_POST['nombre'],
            $_POST['correo'],
            $_POST['contraseña'],
            $_POST['tipo']
        );
        $mensaje = $res['mensaje'];
    }

    if (isset($_POST['registrar_profesor_publico'])) {
        $res = $controller->registrarProfesorPublico(
            $_POST['nombre'],
            $_POST['correo'],
            $_POST['contraseña']
        );
        $mensaje = $res['mensaje'];
    }
}

// 🔹 Cargar la vista al final, con la variable $mensaje
require '../view/Registrar_Usuario.php';
?>
