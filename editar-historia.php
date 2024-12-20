<!-- <?php
// Conexión a la base de datos centro_medico
$conexion = new mysqli('localhost', 'root', 'maximo2213', 'centro_medico');
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verificar si el DNI se ha proporcionado
if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];

    // Obtener el nombre del paciente a partir del DNI
    $stmt = $conexion->prepare("SELECT nombre FROM pacientes WHERE dni = ?");
    if (!$stmt) {
        die("Error al preparar la consulta SQL para el nombre: " . $conexion->error);
    }
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($nombrePaciente);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se encontró un paciente con el DNI proporcionado
    if (!$nombrePaciente) {
        die("No se encontró ningún paciente con el DNI proporcionado.");
    }

    // Obtener la historia clínica del paciente desde la base de datos
    $stmt = $conexion->prepare("SELECT motivo_consulta, diagnostico, tratamiento FROM historia_clinica WHERE dni = ?");
    if (!$stmt) {
        die("Error al preparar la consulta SQL para selección: " . $conexion->error);
    }
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($motivoConsulta, $diagnostico, $tratamiento);
    $stmt->fetch();
    $stmt->close();
} else {
    die("DNI no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Clínica del Paciente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img src="img/nosotros.png" alt="Logo de la Clínica" class="logo">
        <h2>Historia Clínica del Paciente (DNI: <?php echo htmlspecialchars($dni); ?>, Nombre: <?php echo htmlspecialchars($nombrePaciente); ?>)</h2>

        <div>
            <h3>Motivo de Consulta:</h3>
            <p><?php echo htmlspecialchars($motivoConsulta); ?></p>

            <h3>Diagnóstico:</h3>
            <p><?php echo htmlspecialchars($diagnostico); ?></p>

            <h3>Tratamiento:</h3>
            <p><?php echo htmlspecialchars($tratamiento); ?></p>
        </div>

        <a href="medico.php">Volver al Panel</a>
    </div>
</body>
</html>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .logo {
        display: block;
        margin: 0 auto;
        max-width: 150px;
    }

    h2 {
        text-align: center;
    }

    h3 {
        margin-top: 20px;
        color: #333;
    }

    p {
        padding: 10px;
        background-color: #e9ecef;
        border-radius: 4px;
    }

    a {
        margin-top: 20px;
        display: inline-block;
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style> -->
