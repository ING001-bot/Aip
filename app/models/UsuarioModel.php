<?php
require '../config/conexion.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        global $conexion;
        $this->db = $conexion;
    }

    // Verifica si un correo ya está registrado
    public function existeCorreo($correo) {
        $stmt = $this->db->prepare("SELECT 1 FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->rowCount() > 0;
    }

    // Registra un usuario
    public function registrar($nombre, $correo, $contraseña, $tipo_usuario) {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, correo, contraseña, tipo_usuario) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $correo, $contraseña, $tipo_usuario]);
    }

    // Obtiene todos los usuarios
    public function obtenerUsuarios() {
        $stmt = $this->db->prepare("SELECT id_usuario, nombre, correo, tipo_usuario FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Elimina un usuario por id
    public function eliminarUsuario($id_usuario) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id_usuario]);
    }

    // 🔹 Función CORRECTA que faltaba: obtener usuario por correo
    public function obtenerPorCorreo($correo) {
        $stmt = $this->db->prepare("SELECT id_usuario, nombre, correo, contraseña, tipo_usuario FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve un array asociativo o false si no existe
    }
}
?>
