<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['tipo'] ?? null;
if ($rol !== 'Administrador') {
    header('Location: Dashboard.php'); // Solo admins pueden entrar
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>⚙ Panel de Administración</title>
    <link rel="stylesheet" href="../../Public/css/admin.css">
</head>
<body>
    <h1>⚙ Panel de Administración</h1>

    <nav class="menu-admin">
        <a href="registrar_usuario.php">👤 Registrar Usuario</a>
        <a href="registrar_equipo.php">💻 Registrar Equipo</a>
        <a href="registrar_aula.php">🏫 Registrar Aula</a>
        <a href="Dashboard.php" class="volver">🔙 Volver</a>
    </nav>
</body>
</html>
