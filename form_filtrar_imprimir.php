<?php
session_start();
if (!isset($_SESSION['administrador'])) {
    header('Location: login.php');
    exit;
}

// Mostrar errores de PHP (para depuración)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', 'maximo2213', 'centro_medico');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medico = $_POST['medico'];

    // Usar LIKE para una coincidencia más flexible
    $sql = "SELECT * FROM turnos WHERE medico LIKE ?";
    $medicoBusqueda = "%$medico%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $medicoBusqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el nombre completo del médico y la especialidad de la primera fila encontrada
        $row = $result->fetch_assoc();
        $nombreMedico = $row['medico'];  // Guardamos el nombre completo del médico
        $especialidad = $row['especialidad'];  // Guardamos la especialidad
        $result->data_seek(0);  // Devolver el puntero del resultado al inicio
    

        // Consulta para mostrar los turnos del médico
                // Consulta para mostrar los turnos del médico, incluyendo la especialidad
            $sql = "SELECT nombre, dni, dia, hora, domicilio, telefono, email, observaciones, especialidad 
            FROM turnos 
            WHERE medico = '$nombreMedico'
            ORDER BY hora ASC";

            $result = $conn->query($sql);

            if (!$result) {
            die("Error en la consulta SQL: " . $conn->error);  // Si la consulta falla, se mostrará un mensaje de error
            }


        if ($result->num_rows > 0) {
            // Mostrar el listado de turnos con estilo
            echo "<div class='container'>";
            echo "<div class='header'>";
            echo "<h1>Centro Médico Grierson</h1>";
            echo "<img src='img/nosotros.png' alt='Logo del Centro Médico' class='logo'>";
            echo "</div>";
            echo "<h2>Listado de Turnos para '$nombreMedico' - Especialidad: '$especialidad'</h2>";
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
                        <td>" . strtoupper($numeroOrden) . "</td>
                        <td>" . strtoupper($row['nombre']) . "</td>
                        <td>" . strtoupper($row['dni']) . "</td>
                        <td>" . strtoupper($row['dia']) . "</td>
                        <td>" . strtoupper($row['hora']) . "</td>
                        <td>" . strtoupper($row['domicilio']) . "</td>
                        <td>" . strtoupper($row['telefono']) . "</td>
                        <td>" . ($row['email']) . "</td>
                    </tr>";
                $numeroOrden++;
            }
            

            echo "</tbody>
                </table>";

            echo '<button class="print-button" onclick="printAndRedirect()">Imprimir Listado</button>';
            echo "</div>";
        } else {
            echo "<p>No se encontraron turnos para '$nombreMedico'.</p>";
        }

        // Script para manejar la impresión y redirección
        echo '<script>
                function printAndRedirect() {
                    window.print();
                    setTimeout(function() {
                        window.location.href = "principal.php";
                    }, 1000); // Redirige después de 1 segundo para asegurar que la impresión se haya iniciado
                }
              </script>';
    } else {
        // Mostrar mensaje de error con SweetAlert y redirigir después de un tiempo
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "¡Error!",
                        text: "EL MEDICO INGRESADO ES INCORRECTO O NO TIENE TURNOS ASIGNADOS. POR RAZONES DE SEGURIDAD SERAS REDIRECCIONADO A LA PAGINA PRINCIPAL.",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        // Redirigir después de cerrar el mensaje
                        setTimeout(function() {
                            window.location.href = "form_filtrar_imprimir.php";
                        }); // Redirige después de medio segundo
                    });
                });
              </script>';
    }

    $stmt->close();
} else {
    // Mostrar el formulario para seleccionar un médico
    echo "<div class='container'>";
    echo "<div class='header'>";
    echo "<h1>Centro Médico Grierson</h1>";
    echo "<img src='img/nosotros.png' alt='Logo del Centro Médico' class='logo'>";
    echo "</div>";
    echo '<form method="POST" class="filter-form">
            <label for="medico">Buscar Médico:</label>
            <input type="text" id="medico" name="medico" placeholder="Ingrese el nombre del médico..." required><br><br>

            <button type="submit">Buscar</button>
        </form>';
    echo "</div>";
}

$conn->close();
?>

<style>
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

    .filter-form {
        margin: 20px 0;
    }

    .filter-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }

    .filter-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .filter-form button {
        padding: 10px 20px;
        background-color: #07ac96;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .filter-form button:hover {
        background-color: #059c85;
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
    }

    .print-button:hover {
        background-color: #0056b3;
    }
</style>
