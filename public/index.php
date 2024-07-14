<?php
require_once '../clases/Reserva.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $reserva = new Reserva(
            $_POST['hotel'],
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['telefono'],
            $_POST['fechaReserva'],
            $_POST['observaciones']
        );
        $reserva->guardarEnArchivo();
        header('Location: index.php?exito=1');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$reservas = Reserva::obtenerTodasLasReservas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas de Hotel</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Hotel Reservas</h1>
    </header>
    
    <main>
        <h2>Hacer una Reserva</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['exito'])): ?>
            <p style="color: green;">¡Reserva guardada exitosamente!</p>
        <?php endif; ?>
        <form method="post">
            <label for="hotel">Hotel:</label>
            <select name="hotel" id="hotel" required>
                <option value="Hotel A">Hotel A</option>
                <option value="Hotel B">Hotel B</option>
                <option value="Hotel C">Hotel C</option>
                <option value="Hotel D">Hotel D</option>
                <option value="Hotel E">Hotel E</option>
            </select>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="fechaReserva">Fecha de Reserva:</label>
            <input type="date" id="fechaReserva" name="fechaReserva" required>

            <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" name="observaciones" required></textarea>

            <button type="submit">Procesar</button>
        </form>

        <h2>Todas las Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Fecha de Reserva</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <?php foreach ($reserva->aArray() as $campo): ?>
                            <td><?php echo htmlspecialchars($campo); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2023 UCA Programacion III</p>
    </footer>
</body>
</html>
