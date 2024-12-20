<?php
// Iniciar la sesión
session_start();

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "maximo2213", "profesionales");

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $pass = $_POST['pass'];
    $id = $_POST['id'];

    // Validar entradas para evitar inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $id = mysqli_real_escape_string($conexion, $id);

    // Encriptar la contraseña usando password_hash()
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar datos en la tabla 'medicos'
    $sql = "INSERT INTO medicos (id, nombre, pass) VALUES ('$id', '$nombre', '$hashed_pass')";

    if (mysqli_query($conexion, $sql)) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "¡Registro Exitoso!",
                    text: "El médico ha sido registrado correctamente.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../login-medico.php"; // Redirigir a la misma página
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
                    text: "No se pudo registrar al médico. Inténtelo de nuevo.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../login-medico.php"; // Redirigir a la misma página
                    }
                });
            }
        </script>';
    }
}
?>


