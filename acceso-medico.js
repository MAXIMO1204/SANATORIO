document.addEventListener('DOMContentLoaded', (event) => {
    document.addEventListener('keydown', (e) => {
        if (e.shiftKey && e.key === 'P') {
            e.preventDefault(); // Prevenir redirección inmediata
            Swal.fire({
                title: 'Usted está por ingresar como Medico',
                text: "¿Desea continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login-medico.php';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = 'principal.php';
                }
            });
        }
    });
});
