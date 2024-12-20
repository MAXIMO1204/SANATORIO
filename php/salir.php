<?php
session_start(); // Iniciar la sesión
session_destroy(); // Destruir la sesión

// Mostrar el mensaje de agradecimiento y redirigir
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>'; // Incluye SweetAlert2
echo '<script>
    window.onload = function() {
        Swal.fire({
            title: "¡Gracias por su visita!",
            text: "Esperamos verlo pronto.",
            icon: "info",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../principal.php"; // Redirige después de la confirmación
            }
        });
    }
</script>';
?>
