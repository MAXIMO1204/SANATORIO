<?php
require_once 'conexion.php';
// Obtener los datos del formulario
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$pass = $_POST['pass'];

// Verificar que todos los campos estén completos
if (empty($dni) || empty($nombre) || empty($domicilio) || empty($telefono) || empty($correo) || empty($usuario) || empty($pass)) {
    $missingFields = [];

    if (empty($dni)) $missingFields[] = 'DNI';
    if (empty($nombre)) $missingFields[] = 'Nombre';
    if (empty($domicilio)) $missingFields[] = 'Domicilio';
    if (empty($telefono)) $missingFields[] = 'Teléfono';
    if (empty($correo)) $missingFields[] = 'Correo';
    if (empty($usuario)) $missingFields[] = 'Usuario';
    if (empty($pass)) $missingFields[] = 'Contraseña';

    $fieldsMessage = implode(", ", $missingFields);
    $alertMessage = "Los siguientes campos son obligatorios: " . $fieldsMessage;

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: "Campos Obligatorios",
                text: "' . $alertMessage . '",
                icon: "warning",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login.php";  
                }
            });
        });
    </script>';
    exit();
}

// Verificar que el correo no esté registrado
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

if (mysqli_num_rows($verificar_correo) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
    window.onload = function() {
        Swal.fire({
            title: "Correo ya registrado",
            text: "Inténtalo nuevamente con otro correo.",
            icon: "error",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });
    };
    </script>';
    exit();
}

// Verificar que el usuario no esté registrado
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
    window.onload = function() {
        Swal.fire({
            title: "Usuario ya registrado",
            text: "Inténtalo nuevamente con otro usuario.",
            icon: "error",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });
    };
    </script>';
    exit();
}

// Verificar que el DNI no esté registrado
$verificar_dni = mysqli_query($conexion, "SELECT * FROM usuarios WHERE dni='$dni'");

if (mysqli_num_rows($verificar_dni) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
    window.onload = function() {
        Swal.fire({
            title: "DNI YA REGISTRADO",
            text: "",
            icon: "error",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });
    };
    </script>';
 
    exit();
}

// Sanitizar los datos
$dni = mysqli_real_escape_string($conexion, $dni);
$nombre = mysqli_real_escape_string($conexion, $nombre);
$domicilio = mysqli_real_escape_string($conexion, $domicilio);
$telefono = mysqli_real_escape_string($conexion, $telefono);
$correo = mysqli_real_escape_string($conexion, $correo);
$usuario = mysqli_real_escape_string($conexion, $usuario);
$pass = mysqli_real_escape_string($conexion, $pass);

// Encriptar la contraseña con password_hash
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

// Intentar ejecutar la consulta de inserción
$query = "INSERT INTO usuarios(dni, nombre, domicilio, telefono, correo, usuario, pass) VALUES
          ('$dni', '$nombre', '$domicilio', '$telefono', '$correo', '$usuario', '$hashedPassword')";

if (mysqli_query($conexion, $query)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "¡Registro Exitoso!",
                text: "El usuario ha sido registrado correctamente.",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login.php";
                }
            });
        }
    </script>';
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
    window. onload = function() {
        Swal.fire({
            title: "Error",
            text: "Error: ' . mysqli_error($conexion) . '",
            icon: "error",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../login.php";
            }
        });
        };
    </script>';
}

mysqli_close($conexion);
?>
