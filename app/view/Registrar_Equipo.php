<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['tipo'] ?? null;
if ($rol !== 'Administrador') {
    header('Location: Dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>💻 Registrar Equipo</title>
    <link rel="stylesheet" href="../../Public/css/admin.css">
</head>
<body>
    <h1>💻 Registrar Equipo</h1>

    <div class="tarjeta">
        <form method="post" action="../controllers/AdminController.php">
            <label>Nombre del Equipo:</label>
            <input type="text" name="nombre_equipo" required>
            <label>Tipo de Equipo:</label>
            <input type="text" name="tipo_equipo" required>
            <button type="submit" name="registrar_equipo">Registrar Equipo</button>
        </form>
    </div>

    <a href="admin.php" class="volver">🔙 Volver al Panel</a>
</body>
</html>
