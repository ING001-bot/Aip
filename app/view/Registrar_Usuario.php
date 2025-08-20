<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['tipo'] ?? null;
$esAdmin = ($rol === 'Administrador');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>👤 Registro</title>
    <link rel="stylesheet" href="../../Public/css/admin.css">
</head>
<body>
    <h1>👤 <?php echo $esAdmin ? "Registrar Usuario" : "Crear Cuenta"; ?></h1>

    <div class="tarjeta">
        <form method="post" action="../controllers/UsuarioController.php">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
            <label>Correo:</label>
            <input type="email" name="correo" required>
            <label>Contraseña:</label>
            <input type="password" name="contraseña" required minlength="6">

            <?php if ($esAdmin): ?>
                <!-- Solo el admin puede elegir rol -->
                <label>Tipo de Usuario:</label>
                <select name="tipo" required>
                    <option value="">-- Selecciona un tipo --</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Encargado">Encargado</option>
                    <option value="Administrador">Administrador</option>
                </select>
                <button type="submit" name="registrar_usuario_admin">Registrar Usuario</button>
            <?php else: ?>
                <!-- Público: por defecto será Profesor -->
                <button type="submit" name="registrar_profesor_publico">Crear Cuenta</button>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($esAdmin): ?>
        <a href="admin.php" class="volver">🔙 Volver al Panel</a>
    <?php else: ?>
        <a href="login.php" class="volver">🔙 Volver al Login</a>
    <?php endif; ?>
</body>
</html>
