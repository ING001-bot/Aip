<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../controllers/PrestamoController.php';
require '../models/AulaModel.php';

$controller = new PrestamoController($conexion);
$aulaModel = new AulaModel($conexion);

$mensaje = '';
$mensaje_tipo = '';

$tipos = ['Laptop', 'Proyector', 'Mouse'];
$equiposPorTipo = [];

foreach ($tipos as $tipo) {
    $equiposPorTipo[$tipo] = $controller->listarEquiposPorTipo($tipo);
}

// Todas las aulas
$aulas = $aulaModel->obtenerAulas();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['equipos'])) {
    $id_usuario = $_SESSION['id_usuario'] ?? null;
    $fecha_prestamo = $_POST['fecha_prestamo'] ?? date("Y-m-d");
    $hora_inicio = $_POST['hora_inicio'] ?? null;
    $hora_fin = $_POST['hora_fin'] ?? null;
    $equipos = $_POST['equipos'] ?? [];

    if ($hora_inicio) {
        $resultado = $controller->guardarPrestamosMultiple($id_usuario, $equipos, $fecha_prestamo, $hora_inicio, $hora_fin);
        $mensaje = $resultado['mensaje'];
        $mensaje_tipo = $resultado['tipo'];
    } else {
        $mensaje = "⚠ Debes ingresar la hora de inicio.";
        $mensaje_tipo = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Préstamo de Equipos</title>
    <link rel="stylesheet" href="../../Public/css/estilo.css">
</head>
<body>
    <div class="formulario">
        <h2> Préstamo de Equipo</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje <?= htmlspecialchars($mensaje_tipo) ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="fecha_prestamo">Fecha de Préstamo:</label>
            <input type="date" name="fecha_prestamo" id="fecha_prestamo" required>

            <?php foreach ($tipos as $tipo): ?>
                <label for="<?= $tipo ?>"><?= $tipo ?> (opcional):</label>
                <select name="equipos[<?= $tipo ?>]" id="<?= $tipo ?>">
                    <option value="">-- No necesito <?= $tipo ?> --</option>
                    <?php foreach ($equiposPorTipo[$tipo] as $eq): ?>
                        <?php foreach ($aulas as $a): ?>
                            <option value="<?= $eq['id_equipo'] ?>|<?= $a['id_aula'] ?>">
                                <?= htmlspecialchars($eq['nombre_equipo']) ?> - Aula <?= $a['nombre_aula'] ?> (<?= $a['tipo'] ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </select>
                <br>
            <?php endforeach; ?>

            <label for="hora_inicio">Hora de inicio:</label>
            <input type="time" name="hora_inicio" id="hora_inicio" required>

            <label for="hora_fin">Hora de fin (opcional):</label>
            <input type="time" name="hora_fin" id="hora_fin">

            <button type="submit">Enviar</button>
        </form>

        <a href="../view/Dashboard.php" class="btn">🔙 Volver</a>
    </div>
</body>
</html>
