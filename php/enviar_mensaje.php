<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "contacto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];

// Verificar que todos los campos estén completos
if (empty($nombre) || empty($correo) || empty($mensaje)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "Todos los campos son obligatorios.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../contacto.php";
                }
            });
        }
    </script>';
    exit();
}

// Sanitizar los datos
$nombre = mysqli_real_escape_string($conn, $nombre);
$correo = mysqli_real_escape_string($conn, $correo);
$mensaje = mysqli_real_escape_string($conn, $mensaje);

// Insertar en la base de datos
$query = "INSERT INTO mensajes_contacto (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

if (mysqli_query($conn, $query)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Éxito",
                text: "Tu mensaje ha sido enviado correctamente.",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../principal.php";
                }
            });
        }
    </script>';
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "Error al guardar el mensaje en la base de datos.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../principal.php";
                }
            });
        }
    </script>';
}

mysqli_close($conn);
?>
