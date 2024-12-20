<?php
// Conexión a la base de datos 'centro_medico'
$host = 'localhost';
$db = 'centro_medico';
$usuario = 'root'; 
$contraseña = 'maximo2213';
$conexion_medicos = new mysqli($host, $usuario, $contraseña, $db);

// Conexión a la base de datos 'profesionales'
$conexion_profesionales = new mysqli($host, $usuario, $contraseña, 'medicos');

session_start(); // Iniciar sesión


// Obtener el DNI del paciente
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';


// Consultar los datos del paciente por DNI
$pacienteNombre = '';
$pacienteDomicilio = '';
$turno_id = null;
if ($dni) {
    $stmt = $conexion_medicos->prepare("SELECT id, nombre, domicilio FROM turnos WHERE dni = ?");
    if ($stmt === false) {
        die("Error al preparar la consulta SQL: " . $conexion_medicos->error);
    }
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($id, $pacienteNombre, $pacienteDomicilio);
    $stmt->fetch();
    $stmt->close();
}

// Manejar la inserción de la historia clínica
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['motivo_consulta'], $_POST['diagnostico'], $_POST['tratamiento'])) {
    $motivoConsulta = $_POST['motivo_consulta'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];

    if ($id) {
               
        // Ajustar el bind_param a la cantidad correcta de variables y sus tipos
        $stmt = $conexion_medicos->prepare("INSERT INTO historia_clinica (dni, nombre, domicilio, motivo_consulta, diagnostico, tratamiento) VALUES ( ?, ?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            die("Error al preparar la consulta SQL: " . $conexion_medicos->error);
        }
        
        // Nota: 's' es para strings y 'i' es para enteros, ajusta según corresponda
        $stmt->bind_param('ssssss', $dni, $pacienteNombre, $pacienteDomicilio, $motivoConsulta, $diagnostico, $tratamiento);
    
        if ($stmt->execute()) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    window.onload = function() {
                        Swal.fire({
                            title: "Éxito",
                            text: "Historia clínica agregada correctamente.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "medico.php"; // Redirigir al panel del médico
                            }
                        });
                    }
                  </script>';
        } else {
            echo "Error al agregar la historia clínica: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: No se encontró un turno válido para este paciente.";
    }
}    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Historia Clínica</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header img {
            width: 100px;
            height: auto;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        h3 {
            margin-top: 30px;
            color: #007bff;
        }
        .subtitulo-medico {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
            text-align: right;
            font-style: italic;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            margin-top: 5px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #0056b3;
        }
        .info-paciente p {
            font-size: 1.1em;
            margin: 5px 0;
        }
        .info-paciente strong {
            font-weight: bold;
            text-transform: uppercase;
        }
        a {
            margin-top: 20px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            font-size: 1em;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <img src="/clinica/img/nosotros.png" alt="Logo Clínica">
        
    </header>
    <h2>Agregar Historia Clínica</h2>

    <!-- Formulario para buscar paciente -->
    <form action="agregar-historia.php" method="post">
        <label for="dni">DNI del Paciente:</label>
        <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($dni); ?>" required>
        <button type="submit">Buscar Paciente</button>
    </form>

    <?php if ($pacienteNombre && $pacienteDomicilio): ?>
        <h3>Datos del Paciente</h3>
        <div class="info-paciente">
            <p><strong>Nombre:</strong> <?php echo strtoupper(htmlspecialchars($pacienteNombre)); ?></p>
            <p><strong>Domicilio:</strong> <?php echo strtoupper(htmlspecialchars($pacienteDomicilio)); ?></p>
        </div>

        <!-- Formulario para agregar historia clínica -->
        <form action="agregar-historia.php" method="post">
            <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">
            <label for="motivo_consulta">Motivo de Consulta:</label>
            <textarea id="motivo_consulta" name="motivo_consulta" required></textarea>

            <label for="diagnostico">Diagnóstico:</label>
            <textarea id="diagnostico" name="diagnostico" required></textarea>

            <label for="tratamiento">Tratamiento:</label>
            <textarea id="tratamiento" name="tratamiento" required></textarea>

            <button type="submit">Agregar Historia Clínica</button>
            
        </form>
    <?php elseif ($dni): ?>
        <p class="error-message">No se encontraron turnos para el DNI ingresado.</p>
    <?php endif; ?>
   
    <button onclick="window.location.href='medico.php';">Volver al Panel</button>

    
</div>
</body>
</html>
