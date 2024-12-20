<?php
require_once 'conexion-medicos.php';

$id = $_POST['id'];
$pass = $_POST['pass'];

// Validar las credenciales del médico
$validar = mysqli_query($conexion_medicos, "SELECT * FROM medicos WHERE id='$id'");

if (mysqli_num_rows($validar) > 0) {
    $medico = mysqli_fetch_assoc($validar);

    // Verificar si la contraseña ingresada coincide con el hash almacenado
    if (password_verify($pass, $medico['pass'])) {
        // Si la contraseña es correcta, iniciar sesión
        $_SESSION['medico'] = $medico['nombre']; // Guarda el nombre del médico en la sesión

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Bienvenido/a",
                    text: "' . $medico['nombre'] . '",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/clinica/medico.php"; // Redirige a la página de bienvenida del médico
                    }
                });
            }
        </script>';
        exit();
    } else {
        // Si la contraseña es incorrecta
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
        echo '<script>
            window.onload = function() {
                Swal.fire({
                    title: "Error",
                    text: "ID o contraseña incorrectos. Por favor, verifique sus datos.",
                    icon: "error",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href ="../login-medico.php"; // Redirige al login de médicos
                    }
                });
            }
        </script>';
        exit();
    }
} else {
    // Si no se encuentra el médico
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; 
    echo '<script>
        window.onload = function() {
            Swal.fire({
                title: "Error",
                text: "ID o contraseña incorrectos. Por favor, verifique sus datos.",
                icon: "error",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href ="../login-medico.php"; // Redirige al login de médicos
                }
            });
        }
    </script>';
    exit();
}
?>
