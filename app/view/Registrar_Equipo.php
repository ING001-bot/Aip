<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['tipo'] ?? null;
if ($rol !== 'Administrador') {
    header('Location: Dashboard.php');
    exit;
}

// Incluimos el controlador de equipos
require '../controllers/EquipoController.php';

$mensaje = '';
$mensaje_tipo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_equipo'])) {
    $controller = new EquipoController();
    $res = $controller->registrarEquipo($_POST['nombre_equipo'], $_POST['tipo_equipo']);
    $mensaje = $res['mensaje'];
    $mensaje_tipo = $res['error'] ? 'error' : 'success';
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

    <?php if (!empty($mensaje)): ?>
        <div class="mensaje <?= htmlspecialchars($mensaje_tipo) ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <div class="tarjeta">
        <form method="post">
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
