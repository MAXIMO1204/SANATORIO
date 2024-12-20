<?php
// Conexión a la base de datos centro_medico
$conexion = new mysqli('localhost', 'root', 'maximo2213', 'centro_medico');
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$historias = [];
$mensaje = '';
$nombrePaciente = '';
$nombreMedico = '';
$script = ''; // Variable para almacenar el script de SweetAlert

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];

    if (empty($dni)) {
        $mensaje = "DNI no proporcionado.";
    } else {
        // Obtener el nombre del paciente y del médico a partir del DNI en la tabla "turnos"
        $stmt = $conexion->prepare("SELECT nombre, medico FROM turnos WHERE dni = ?");
        if (!$stmt) {
            die("Error al preparar la consulta SQL para el nombre: " . $conexion->error);
        }
        $stmt->bind_param('s', $dni);
        $stmt->execute();
        $stmt->bind_result($nombrePaciente, $nombreMedico);
        $stmt->fetch();
        $stmt->close();

        // Verificar si se encontró un paciente
        if (empty($nombrePaciente)) {
            $mensaje = "No se encontró un paciente con el DNI proporcionado.";
        } else {
            // Obtener las historias clínicas del paciente desde la base de datos, incluyendo la fecha de consulta
            $stmt = $conexion->prepare("SELECT id, motivo_consulta, diagnostico, tratamiento, fecha FROM historia_clinica 
            WHERE dni = ? ORDER BY fecha DESC");
            if (!$stmt) {
                die("Error al preparar la consulta SQL: " . $conexion->error);
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Paciente</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
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
            resize: vertical;
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

        .historia-header {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .historia-header h3, .historia-header p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="img/nosotros.png" alt="Logo de la Clínica" class="logo">
            <h1>Centro Médico</h1>
            <h2>Historia Clínica del Paciente</h2>
        </header>
        
        <h2>Buscar Paciente por DNI</h2>
        <form action="buscar-historia.php" method="post">
            <label for="dni">DNI del Paciente:</label>
            <input type="text" id="dni" name="dni" required>
            <button type="submit">Buscar Paciente</button>
        </form>

        <?php if ($mensaje): ?>
            <p class="error"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php elseif (!empty($historias)): ?>
            <div class="historia-header">
                <h3>Paciente: <?php echo strtoupper(htmlspecialchars($nombrePaciente)); ?> (DNI: <?php echo htmlspecialchars($dni); ?>)</h3>
                <p>Médico: <?php echo htmlspecialchars($nombreMedico); ?></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Fecha de Consulta</th>
                        <th>Motivo de Consulta</th>
                        <th>Diagnóstico</th>
                        <th>Tratamiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historias as $historia): ?>
                        <tr>
                            <td><?php $date = new DateTime($historia['fecha']); echo htmlspecialchars($date->format('d/m/Y')); ?></td>
                            <td><?php echo htmlspecialchars($historia['motivo_consulta']); ?></td>
                            <td><?php echo htmlspecialchars($historia['diagnostico']); ?></td>
                            <td><?php echo htmlspecialchars($historia['tratamiento']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button onclick="generarPDF()">Imprimir Historia Clínica</button>
        <?php endif; ?>

        <button class="back-button" onclick="window.location.href='medico.php'">Volver al Panel</button>
    </div>

    <script>
    function generarPDF() {
        // Crear una nueva ventana
        var ventana = window.open('', '_blank');
        var contenido = `
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { max-width: 800px; margin: 0 auto; padding: 20px; }
                    header { text-align: center; margin-bottom: 20px; }
                    .logo { width: 100px; height: auto; }
                    h1 { font-size: 24px; margin: 0; }
                    h2 { font-size: 20px; margin: 0 0 10px; color: #007bff; }
                    .historia-header { display: flex; justify-content: space-between; margin: 20px 0; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    table, th, td { border: 1px solid #ddd; }
                    th, td { padding: 12px; text-align: left; }
                    th { background-color: #007bff; color: white; }
                    td { background-color: #f9f9f9; }
                </style>
            </head>
            <body>
                <div class="container">
                    <header>
                        <img src="img/nosotros.png" alt="Logo de la Clínica" class="logo">
                        <h1>Centro Médico</h1>
                        <h2>Historia Clínica del Paciente</h2>
                    </header>
                    
                    <div class="historia-header">
                        <h3>Paciente: <?php echo strtoupper(htmlspecialchars($nombrePaciente)); ?> (DNI: <?php echo htmlspecialchars($dni); ?>)</h3>
                        <p>Médico: <?php echo htmlspecialchars($nombreMedico); ?></p>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Fecha de Consulta</th>
                                <th>Motivo de Consulta</th>
                                <th>Diagnóstico</th>
                                <th>Tratamiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historias as $historia): ?>
                            <tr>
                                <td><?php $date = new DateTime($historia['fecha']); echo htmlspecialchars($date->format('d/m/Y')); ?></td>
                                <td><?php echo htmlspecialchars($historia['motivo_consulta']); ?></td>
                                <td><?php echo htmlspecialchars($historia['diagnostico']); ?></td>
                                <td><?php echo htmlspecialchars($historia['tratamiento']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </body>
            </html>
        `;
        
        // Escribir el contenido en la ventana nueva
        ventana.document.write(contenido);
        ventana.document.close();
        
        // Iniciar la impresión
        ventana.print();
        
        // Cerrar la ventana automáticamente después de imprimir
        ventana.onafterprint = function() {
            ventana.close();
        };
    }
    </script>
    
    <?php echo $script; // Mostrar el script de SweetAlert ?>
</body>
</html>
