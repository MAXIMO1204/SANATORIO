<?php
// Conexión a la base de datos centro_medico
$conexion = new mysqli('localhost', 'root', 'maximo2213', 'centro_medico');
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$historias = [];
$mensaje = '';
$nombrePaciente = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];

    if (empty($dni)) {
        $mensaje = "DNI no proporcionado.";
    } else {
        // Obtener el nombre del paciente
        $stmt = $conexion->prepare("SELECT nombre FROM turnos WHERE dni = ?");
        if (!$stmt) {
            die("Error al preparar la consulta SQL para nombre: " . $conexion->error);
        }
        $stmt->bind_param('s', $dni);
        $stmt->execute();
        $stmt->bind_result($nombrePaciente);
        $stmt->fetch();
        $stmt->close();


        if (empty($nombrePaciente)) {
            $mensaje = "No se encontró un paciente con el DNI proporcionado.";
        } else {
        // Obtener las historias clínicas del paciente desde la base de datos
        $stmt = $conexion->prepare("SELECT id, motivo_consulta, diagnostico, tratamiento, fecha FROM historia_clinica WHERE dni = ?");
        if (!$stmt) {
            die("Error al preparar la consulta SQL para historias clínicas: " . $conexion->error);
        }
        $stmt->bind_param('s', $dni);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $motivo_consulta, $diagnostico, $tratamiento, $fecha);

        while ($stmt->fetch()) {
            $historias[] = [
                'id' => $id,
                'motivo_consulta' => $motivo_consulta,
                'diagnostico' => $diagnostico,
                'tratamiento' => $tratamiento,
                'fecha' => $fecha
            ];
        }
        $stmt->close();
    }

        // Mostrar alerta si no se encuentran historias clínicas
        if (empty($historias) && !empty($nombrePaciente)) {
            $script = '
                <script>
                    window.onload = function() {
                        Swal.fire({
                            title: "No Encontrado",
                            text: "No se encontraron historias clínicas para el DNI proporcionado.",
                            icon: "info",
                            confirmButtonText: "Aceptar"
                        });
                    };
                </script>';
        }
    }
}

if (isset($_GET['delete_id'])) {
    $idToDelete = $_GET['delete_id'];

    // Eliminar la historia clínica
    $stmt = $conexion->prepare("DELETE FROM historia_clinica WHERE id = ?");
    if (!$stmt) {
        die("Error al preparar la consulta SQL para eliminar: " . $conexion->error);
    }
    $stmt->bind_param('i', $idToDelete);

    if ($stmt->execute()) {
        $script = '
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: "Eliminado!",
                        text: "Historia clínica eliminada correctamente.",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        window.location.href = "eliminar-historia.php";
                    });
                };
            </script>';
    } else {
        $script = '
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error al eliminar la historia clínica: ' . addslashes($stmt->error) . '",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                };
            </script>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Historia Clínica</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <header>
            <img src="img/nosotros.png" alt="Logo de la Clínica" class="logo">
            <h1>Centro Médico</h1>
            <h2>Panel del Médico</h2>
        </header>

        <h2>Eliminar Historia Clínica por DNI</h2>
        <form action="eliminar-historia.php" method="post">
            <label for="dni">DNI del Paciente:</label>
            <input type="text" id="dni" name="dni" required>
            <button type="submit">Buscar Paciente</button>
        </form>

        <?php if ($mensaje): ?>
            <p class="error"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php elseif ($historias): ?>
            <h3>Historias Clínicas de <?php echo strtoupper(htmlspecialchars($nombrePaciente)); ?> (DNI: <?php echo htmlspecialchars($dni); ?>)</h3>
            <ul>
                <?php foreach ($historias as $historia): ?>
                    <li>
                        <strong>Fecha de Consulta:</strong> <?php echo date('d/m/Y', strtotime($historia['fecha'])); ?><br>
                        <strong>Motivo de Consulta:</strong> <?php echo htmlspecialchars($historia['motivo_consulta']); ?><br>
                        <strong>Diagnóstico:</strong> <?php echo htmlspecialchars($historia['diagnostico']); ?><br>
                        <strong>Tratamiento:</strong> <?php echo htmlspecialchars($historia['tratamiento']); ?><br>
                        <a href="eliminar-historia.php?delete_id=<?php echo htmlspecialchars($historia['id']); ?>" class="delete-button">Eliminar</a>
                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <button class="back-button" onclick="window.location.href='medico.php'">Volver al Panel</button>
    </div>

    <?php if (isset($script)) echo $script; ?>
</body>
</html>


<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 150px;
        height: auto;
    }

    h1 {
        margin: 0;
        font-size: 24px;
    }

    h2 {
        margin: 5px 0;
        font-size: 20px;
        color: #007bff;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-top: 10px;
    }

    input[type="text"] {
        margin-top: 5px;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-button:hover {
        text-decoration: underline;
    }

    a {
        margin-top: 10px;
        display: inline-block;
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .error {
        color: red;
        font-weight: bold;
    }

    hr {
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>

