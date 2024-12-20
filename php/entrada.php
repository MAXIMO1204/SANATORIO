<?php
include 'conexion.php';

$usuario = $_POST['usuario'];
$pass = $_POST['pass'];

// Consultar el usuario en la base de datos
$validar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

if (mysqli_num_rows($validar) > 0) {
    $fila = mysqli_fetch_assoc($validar);
    $hashedPasswordAlmacenada = $fila['pass']; // Obtener la contraseña encriptada de la base de datos

    // Verificar la contraseña ingresada con la contraseña encriptada almacenada
    if (password_verify($pass, $hashedPasswordAlmacenada)) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['usuario'] = $usuario;

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Bienvenido/a",
                    text: "' . $usuario . '",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../principal.php";
                    }
                });
            }
        </script>';
        exit();
    } else {
        // Contraseña incorrecta
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Error",
                    text: "Contraseña incorrecta. Verifique los datos ingresados.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../login.php";
                    }
                });
            }
        </script>';
        exit();
    }
} else {
    // Usuario no encontrado
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "El usuario no existe. Por favor, verifique los datos o regístrese.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login.php";
                }
            });
        }
    </script>';
    exit();
}
?>