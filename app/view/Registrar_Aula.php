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
    <title>🏫 Registrar Aula</title>
    <link rel="stylesheet" href="../../Public/css/admin.css">
</head>
<body>
    <h1>🏫 Registrar Aula</h1>

    <div class="tarjeta">
        <form method="post" action="../controllers/AdminController.php">
            <label>Nombre del Aula:</label>
            <input type="text" name="nombre_aula" placeholder="Ej: AIP1" required>
            <label>Capacidad de Estudiantes:</label>
            <input type="number" name="capacidad" min="1" required>
            <button type="submit" name="registrar_aula">Registrar Aula</button>
        </form>
    </div>

    <a href="admin.php" class="volver">🔙 Volver al Panel</a>
</body>
</html>
