<?php 
include 'conexion-admin.php';

// Obtener los datos del formulario
$id = $_POST['id'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$administrador = $_POST['administrador'] ?? '';
$pass = $_POST['pass'] ?? '';

// Verificar que todos los campos estén completos
if (empty($id) || empty($nombre) || empty($administrador) || empty($pass)) {
    $missingFields = [];

    if (empty($id)) $missingFields[] = 'ID';
    if (empty($nombre)) $missingFields[] = 'Nombre';
    if (empty($administrador)) $missingFields[] = 'Administrador';
    if (empty($pass)) $missingFields[] = 'Contraseña';

    $fieldsMessage = implode(", ", $missingFields);
    $alertMessage = "Los siguientes campos son obligatorios: " . $fieldsMessage;

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Campos Obligatorios",
                text: "' . $alertMessage . '",
                icon: "warning",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php"; 
                }
            });
        };
    </script>';
    exit();
}

// Verificar que el nombre no esté registrado
$verificar_nombre = mysqli_query($conexion, "SELECT * FROM administrador WHERE nombre='$nombre'");
if (mysqli_num_rows($verificar_nombre) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Nombre ya registrado",
                text: "Inténtalo nuevamente con otro nombre.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php";
                }
            });
        };
    </script>';
    exit();
}

// Verificar que el administrador no esté registrado
$verificar_administrador = mysqli_query($conexion, "SELECT * FROM administrador WHERE administrador='$administrador'");
if (mysqli_num_rows($verificar_administrador) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "ADMINISTRADOR YA REGISTRADO",
                text: "Inténtalo nuevamente con otro administrador.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php";
                }
            });
        };
    </script>';
    exit();
}

// Verificar que el id no esté registrado
$verificar_id = mysqli_query($conexion, "SELECT * FROM administrador WHERE id='$id'");
if (mysqli_num_rows($verificar_id) > 0) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "ID YA REGISTRADO",
                text: "",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php";
                }
            });
        };
    </script>';
    exit();
}

// Sanitizar 
$id = mysqli_real_escape_string($conexion, $id);
$nombre = mysqli_real_escape_string($conexion, $nombre);
$administrador = mysqli_real_escape_string($conexion, $administrador);
$pass = mysqli_real_escape_string($conexion, $pass);

// Encriptar la contraseña
$pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

// Intentar ejecutar la consulta de inserción
$query = "INSERT INTO administrador(id, nombre, administrador, pass) VALUES
          ('$id', '$nombre', '$administrador', '$pass_hashed')";

if (mysqli_query($conexion, $query)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Éxito",
                text: "ADMINISTRADOR REGISTRADO EXITOSAMENTE",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php"; 
                }
            });
        };
    </script>';
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "Error: ' . mysqli_error($conexion) . '",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php";
                }
            });
        };
    </script>';
}

mysqli_close($conexion);
?>

