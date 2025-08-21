<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../controllers/AulaController.php';
require '../config/conexion.php';

$rol = $_SESSION['tipo'] ?? null;
if ($rol !== 'Administrador') {
    header('Location: Dashboard.php');
    exit;
}

$mensaje = '';
$mensaje_tipo = '';

$controller = new AulaController($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_aula'])) {
    $nombre = trim($_POST['nombre_aula']);
    $capacidad = intval($_POST['capacidad']);

    if (!$nombre || $capacidad < 1) {
        $mensaje = "⚠ Por favor completa todos los campos correctamente.";
        $mensaje_tipo = "error";
    } else {
        $ok = $controller->crearAula($nombre, $capacidad);
        if ($ok) {
            $mensaje = "✅ Aula registrada correctamente.";
            $mensaje_tipo = "success";
        } else {
            $mensaje = "❌ Error al registrar el aula.";
            $mensaje_tipo = "error";
        }
    }
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

    <?php if ($mensaje): ?>
        <div class="mensaje <?= htmlspecialchars($mensaje_tipo) ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <div class="tarjeta">
        <form method="post">
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
