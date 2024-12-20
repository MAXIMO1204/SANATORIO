<?php
session_start();

// Verificar si el médico está autenticado en la sesión
if (!isset($_SESSION['medico'])) {
    die("No se ha iniciado sesión como médico. Variable de sesión 'medico' no está definida.");
}

// Mostrar errores de PHP (para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', 'maximo2213', 'centro_medico');

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el nombre del médico desde la sesión
$nombreMedico = $_SESSION['medico'];

// // Verificar el valor de la variable de sesión
// echo "Nombre del médico en sesión: " . htmlspecialchars($nombreMedico) . "<br>";

// Escapar caracteres especiales
$nombreMedicoEscapado = $conn->real_escape_string($nombreMedico);

// Dividir el nombre del médico en partes (ejemplo: "Llanos Flavia" => ["Llanos", "Flavia"])
$nombrePartes = explode(' ', $nombreMedicoEscapado);

// Construir la consulta SQL utilizando una búsqueda más flexible
$sql = "SELECT nombre, dni, dia, hora, domicilio, telefono, email
        FROM turnos 
        WHERE ";

// Agregar condiciones para cada parte del nombre
$condiciones = [];
foreach ($nombrePartes as $parte) {
    $condiciones[] = "LOWER(medico) LIKE LOWER('%$parte%')";
}
$sql .= implode(' AND ', $condiciones) . " ORDER BY hora ASC";

// // Imprimir la consulta SQL para depuración
// echo "Consulta SQL: " . htmlspecialchars($sql) . "<br>";

// Preparar la consulta
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta SQL: " . $conn->error);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Verificar si la consulta se ejecutó correctamente
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Mostrar resultados
if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<div class='header'>";
    echo "<h1>Centro Médico Grierson</h1>";
    echo "<img src='img/nosotros.png' alt='Logo del Centro Médico' class='logo'>";
    echo "</div>";
    echo "<h2>Listado de Turnos para '$nombreMedico'</h2>";
    echo "<table class='appointments-table'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Domicilio</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>";

    $numeroOrden = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $numeroOrden . "</td>
           <td class='uppercase'>" . htmlspecialchars($row['nombre']) . "</td>
            <td class>" . htmlspecialchars($row['dni']) . "</td>
            <td class='uppercase'>" . htmlspecialchars($row['dia']) . "</td>
            <td class>" . htmlspecialchars($row['hora']) . "</td>
            <td class='uppercase'>" . htmlspecialchars($row['domicilio']) . "</td>
                <td>" . htmlspecialchars($row['telefono']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
            </tr>";
        $numeroOrden++;
    }

    echo "</tbody>
        </table>";

    echo '<button class="print-button" onclick="printAndRedirect()">Imprimir Listado</button>';
    echo '<button class="back-button" onclick="window.location.href=\'medico.php\'">Volver al Panel</button>';

        echo "</div>";

    // Script para manejar la impresión y redirección
    echo '<script>
            function printAndRedirect() {
                window.print();
                setTimeout(function() {
                    window.location.href = "medico.php";
                }, 1000); // Redirige después de 1 segundo para asegurar que la impresión se haya iniciado
            }
          </script>';
} else {
    // Mensaje de error en caso de que no haya resultados
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "¡Error!",
                    text: "El médico en sesión no tiene turnos asignados.",
                    confirmButtonText: "Aceptar"
                }).then(function() {
                    setTimeout(function() {
                        window.location.href = "medico.php";
                    }, 1000);
                });
            });
          </script>';
}

$stmt->close();
$conn->close();
?>

<style>
    .uppercase {
    text-transform: uppercase;
}

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
        color: #07ac96;
    }

    .header .logo {
        width: 100px;
        margin-top: 10px;
    }

    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .appointments-table th, .appointments-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .appointments-table th {
        background-color: #07ac96;
        color: white;
    }

    .appointments-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .appointments-table tr:hover {
        background-color: #e1f5f3;
    }

    .print-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 20px 0;
        margin-right: 20px;
    }

    .print-button:hover {
        background-color: #0056b3;
    }
    button {
            margin-top: 20px;
            padding: 10px 20px;
            margin-left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
   
</style>
