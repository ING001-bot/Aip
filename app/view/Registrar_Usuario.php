<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['tipo'] ?? null;
$esAdmin = ($rol === 'Administrador');
$mensaje = $mensaje ?? ''; // viene desde el controlador
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>👤 <?= $esAdmin ? "Registrar Usuario" : "Crear Cuenta" ?></title>
    <link rel="stylesheet" href="../../Public/css/admin.css">
</head>
<body>
    <h1>👤 <?= $esAdmin ? "Registrar Usuario" : "Crear Cuenta" ?></h1>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <div class="tarjeta">
        <form method="post" action="../controllers/UsuarioController.php">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Correo:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="contraseña" required minlength="6">

            <?php if ($esAdmin): ?>
                <label>Tipo de Usuario:</label>
                <select name="tipo" required>
                    <option value="">-- Selecciona un tipo --</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Encargado">Encargado</option>
                    <option value="Administrador">Administrador</option>
                </select>
                <button type="submit" name="registrar_usuario_admin">Registrar Usuario</button>
            <?php else: ?>
                <button type="submit" name="registrar_profesor_publico">Crear Cuenta</button>
            <?php endif; ?>
        </form>
    </div>

    <a href="<?= $esAdmin ? 'Admin.php' : '../../Public/index.php' ?>" class="volver">🔙 Volver</a>
</body>
</html>
