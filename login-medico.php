<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro de Médicos</title>
    
    <!-- Fuentes y Estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <style>
        /* Estilo para el botón de la "X" roja */
        .btn-close {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: red;
            color: white;
            border: none;
            font-size: 24px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1000; /* Asegura que el botón esté por encima de otros elementos */
        }

        .btn-close:hover {
            background-color: darkred;
        }
    </style>

</head>
<body>

<main style="background: linear-gradient(
               rgba(33, 66, 39, 0.5),
               rgba(33, 66, 39, 0.5)
           ), url('img/fondo.jpg') top center/cover no-repeat;
           height: 100vh;
           width: 100vw;
           background-size: cover;
           background-position: top center;
           margin: 0;
           padding: 0;
           animation: backgroundZoom 20s ease-in-out infinite alternate;">
    
    <!-- Botón de cerrar con "X" roja -->
    <button class="btn-close" onclick="window.location.href='principal.php'">X</button>

    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3>¿Ya eres médico registrado?</h3>
                <p>Inicia sesión para gestionar tus citas y horarios</p>
                <button id="btn__iniciar-sesion">Iniciar Sesión</button>
            </div>
            <div class="caja__trasera-register">
                <h3>Regístrate como médico</h3>
                <p>Accede al sistema para gestionar tus citas</p>
                <button id="btn__registrarse">Regístrarse</button>
            </div>
        </div>

        <!--Formulario de Login y registro-->
        <div class="contenedor__login-register">
            <!--Login-->
            <form action="php/entrada-medico.php" method="POST" class="formulario__login">
                <h3>CENTRO MEDICO GRIERSON</h3>
                <h2>Iniciar Sesión Médico</h2>
                <input type="text" placeholder="Id" name="id" required>
                <div style="position: relative;">
                    <input type="password" placeholder="Contraseña" name="pass" id="password" required>
                    <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" 
                    onclick="togglePasswordVisibility()">
                        <svg xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                            <path d="M22 12s-4-8-10-8S2 12 2 12s4 8 10 8 10-8 10-8zM12 16a4 4 0 0 1-4-4m0 0a4 4 0 0 1 4-4m0 8a4 4 0 0 1-4-4 4 4 0 0 1 4-4 4 4 0 0 1 4 4 4 4 0 0 1-4 4z"></path>
                        </svg>
                    </span>
                </div>
                <button type="submit">Entrar</button>
            </form>

            <!--Register-->
            <form action="php/registro-medico.php" method="POST" class="formulario__register">
                <h3>CENTRO MEDICO GRIERSON</h3>
                <h2>Registro de Médico</h2>
                <input type="text" placeholder="ID" name="id" required>
                <input type="text" placeholder="Nombre" name="nombre" required>                      
                <input type="password" placeholder="Contraseña" name="pass" required>
                <button type="submit">Regístrarse</button>
            </form>
        </div>
    </div>
</main>

<!-- Script para alternar visibilidad de contraseña -->
<script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var icon = event.target.closest("span").querySelector("svg");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("feather-eye");
        icon.classList.add("feather-eye-off");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("feather-eye-off");
        icon.classList.add("feather-eye");
    }
}
</script>

<script src="login-medico.js"></script> <!-- Asegúrate de tener el archivo JavaScript correspondiente -->
</body>
</html>
