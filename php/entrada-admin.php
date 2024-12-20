<?php

include 'conexion-admin.php';

$administrador = $_POST['administrador'];
$pass = $_POST['pass'];

// Obtener la contraseña encriptada de la base de datos
$query = mysqli_query($conexion, "SELECT pass FROM administrador WHERE administrador='$administrador'");

if (mysqli_num_rows($query) > 0) {
    // Obtener la fila de resultados
    $row = mysqli_fetch_assoc($query);
    $hashedPassword = $row['pass'];

    // Verificar la contraseña
    if (password_verify($pass, $hashedPassword)) {
        $_SESSION['administrador'] = $administrador;

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Bienvenido/a",
                    text: "' . $administrador . '",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../principal.php"; // Redirige al principal.php
                    }
                });
            }
        </script>';
        exit();
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Error",
                    text: "La contraseña es incorrecta. Por favor, verifica los datos introducidos.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../login-admin.php"; // Redirige al login.php
                    }
                });
            }
        </script>';
        exit();
    }
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "El administrador no existe, por favor verifica los datos introducidos o regístrate para iniciar sesión.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../login-admin.php"; // Redirige al login.php
                }
            });
        }
    </script>';
    exit();
}

?>



